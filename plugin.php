<?php

/**
 * Phile Admin Plugin
 */
class PhileAdmin extends \Phile\Plugin\AbstractPlugin implements \Phile\EventObserverInterface {

  private $config;
  private $path;
  private $choices;
  private $hidden;
  private $base_url;
  private $parser;

  public function __construct() {
    \Phile\Event::registerEvent('plugins_loaded', $this);
    $this->config = \Phile\Registry::get('Phile_Settings');
    $this->config['path'] = \Phile\Utility::resolveFilePath("MOD:phileAdmin/");
    $this->base_url = \Phile\Utility::getBaseUrl();
    $this->config['asset_path'] = $this->base_url . '/plugins/phileAdmin/views/';
    $this->choices = array(
      'login',
      'logout',
      'login_form',
      'save',
      'new_file',
      'pages',
      'media',
      'media_list',
      'upload',
      'settings',
      'save_settings',
      'get_page_info',
      'editor',
      'parse_markdown'
      );
    \Phile\Session::set('is_admin', true);
    $this->hidden = array('path', 'asset_path', 'title');
  }

  private function hideValues() {
    foreach ($this->hidden as $item) {
      unset($this->config['config'][$item]);
    }
  }

  /*!
   * check for the events
   * @param  string $eventKey the event to listen for
   * @param  array $data     the data passed for that event
   * @return function           assigns url requests to functions
   */
  public function on($eventKey, $data = null) {
    // check $eventKey for which you have registered
    if ($eventKey == 'plugins_loaded') {
      $uri = str_replace('/' . \Phile\Utility::getInstallPath(), '', $_SERVER['REQUEST_URI']).$this->settings['admin_url'];
      if (strpos($uri, 'editor') === false) {
        $parts = explode($this->settings['admin_url'], $uri);
        $target = str_replace('/', '', $parts[1]);
        if (!empty($target) || in_array($target, $this->choices)) {
          $this->{$target}();
        }
      } else {
        $this->editor($_GET['page']);
      }
    }
  }

  /*!
   * render the login form
   * @return page login page or redirect
   */
  private function login() {
    if (!\Phile\Session::get('is_admin')) {
      $this->render('login.php');
    } else {
      \Phile\Utility::redirect($this->base_url . $this->settings['admin_url'] . '/pages');
    }
  }

  /*!
   * the main page
   * @return page either pages or redirect
   */
  private function pages() {
    if (\Phile\Session::get('is_admin')) {
      $pageRespository = new \Phile\Repository\Page();
      $pages = $pageRespository->findAll();
      $this->config['pages'] = array();
      // convert the pages into key => values and not an object
      for ($i=0; $i < count($pages); $i++) {
        $this->config['pages'][] = array(
          'title' => $pages[$i]->getTitle(),
          // 'url' => $this->base_url.'/content/'.$pages[$i]->getUrl(),
          'real_url' => $pages[$i]->getUrl(),
          // 'path' => $pages[$i]->getFilePath(),
          // 'content' => $pages[$i]->getContent(),
          // 'meta' => $pages[$i]->getMeta()->getAll()
          );
      }
      $this->config['files'] = \Phile\Utility::getFiles(CONTENT_DIR, '/^.*\\'.CONTENT_EXT.'/');
      foreach ($this->config['files'] as &$file) {
        $file = str_replace(CONTENT_DIR, '', $file);
      }
      if (!empty($this->settings['info_file'])) {
        $this->config['info_file'] = $this->base_url . '/plugins/phileAdmin/' . $this->settings['info_file'];
        $this->config['info_file_title'] = $this->settings['info_file_title'];
      }
      $this->config['title'] = 'Pages';
      $this->render('pages.php');
    } else {
      \Phile\Utility::redirect($this->base_url . $this->settings['admin_url'] . '/login');
    }
    exit;
  }

  private function get_page_info() {
    if (\Phile\Session::get('is_admin') && $_SERVER['REQUEST_METHOD'] === 'POST') {
      $pageRespository = new \Phile\Repository\Page();
      $page = $pageRespository->findByPath($_POST['path']);
      $data = array(
        'title' => $page->getTitle(),
        'url' => $this->base_url.'/content/'.$page->getUrl(),
        'real_url' => $page->getUrl(),
        'path' => $page->getFilePath(),
        'content' => $page->getContent(),
        'meta' => $page->getMeta()->getAll()
        );
      $this->render('template-pageinfo.php', $data);
    }
    exit;
  }

  /*!
   * the media page
   * @return page either media or redirect
   */
  private function media() {
    if (\Phile\Session::get('is_admin')) {
      $this->config['title'] = 'Media';
      $this->config['images'] = $this->media_list();
      $this->render('media.php');
    } else {
      \Phile\Utility::redirect($this->base_url . $this->settings['admin_url'] . '/login');
    }
    exit;
  }

  /*!
   * the media page
   * @return page either media or redirect
   */
  private function media_template() {
    if (\Phile\Session::get('is_admin')) {
      $this->config['images'] = $this->media_list();
      $this->render('template-media.php');
    } else {
      \Phile\Utility::redirect($this->base_url . $this->settings['admin_url'] . '/login');
    }
    exit;
  }

  private function media_list() {
    $images = array();
    if ($handle = opendir($this->settings['upload_path'])) {
      while (false !== ($entry = readdir($handle))) {
        $check = preg_match("/\.(jpg|jpeg|svg|png|gif|webp)/i", $entry);
        if ($entry != "." && $entry != ".." && $check) {
          $alt = preg_replace('/\.(jpg|jpeg|svg|png|gif|webp)/', '', $entry);
          $image_info = getimagesize($this->settings['upload_path'].$entry);
          $images[] = array(
            'src' => $this->settings['upload_dir'].$entry,
            'filename' => $entry,
            'width' => $image_info[0],
            'height' => $image_info[1],
            'title' => $alt,
            'alt' => $alt
            );
        }
      }
      closedir($handle);
    }
    return $images;
  }

  private function upload() {
    if (\Phile\Session::get('is_admin')) {
      if (!empty($_FILES) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        // cleanup the filename
        $info = pathinfo($_FILES['file']['name']);
        $filename = $this->slugify($info['filename']);
        // add a timestamp for lazy fix of name conflicts
        $date = new DateTime();
        $cleanName = $filename . '-' . $date->getTimestamp() . '.' . $info['extension'];
        $targetFile = $this->settings['upload_path'] . $cleanName;
        move_uploaded_file($_FILES['file']['tmp_name'], $targetFile);
      }
    }
    exit;
  }

  /*!
   * the settings page
   * @return page either media or redirect
   */
  private function settings() {
    if (\Phile\Session::get('is_admin')) {
      $this->config['title'] = 'Settings';
      $this->config['config'] = $this->config;
      array_merge($this->config['config'], $this->settings);
      $this->hideValues();
      $this->render('settings.php');
    } else {
      \Phile\Utility::redirect($this->base_url . $this->settings['admin_url'] . '/login');
    }
    exit;
  }

  /*!
   * the save settings action
   * @return boolean the write success
   */
  private function save_settings() {
    if (\Phile\Session::get('is_admin')) {
      $data = json_encode($_POST['settings']);
      $filepath = $this->config['path'] . $this->settings['settings_save_file'];
      if ($this->file_force_contents($filepath, $data)) {
        $this->send_json(array(
          'status' => true,
          'message' => $this->settings['message_save_post'],
          ));
      }
    }
  }

  /*!
   * the editor page
   * @return page either editor or redirect
   */
  private function editor($target) {
    if (\Phile\Session::get('is_admin')) {
      $pageRespository = new \Phile\Repository\Page();
      $page = $pageRespository->findByPath($target);
      $this->config['data'] = array(
        'title' => $page->getTitle(),
        'url' => $this->base_url.'/content/'.$page->getUrl(),
        'real_url' => $page->getUrl(),
        'path' => $page->getFilePath(),
        'content' => $page->getContent(),
        'raw_content' => file_get_contents($page->getFilePath()),
        'meta' => $page->getMeta()->getAll()
        );
      $this->config['title'] = 'Editor';
      $this->render('editor.php');
    }
    exit;
  }

  public function parse_markdown() {
    if (\Phile\Session::get('is_admin') && $_SERVER['REQUEST_METHOD'] === 'POST') {
      $this->parser = \Phile\ServiceLocator::getService('Phile_Parser');
      header_remove();
      echo $this->parser->parse($_POST['content']);
      exit;
    }
  }

  /*!
   * the login function for the homepage
   * @return redirect redirect to the pages page
   */
  private function login_form()
  {
    header_remove();
    $post = $this->filter($_POST);
    if($post['username'] === $this->settings['username'] && $post['password'] === $this->settings['password']) {
      \Phile\Session::set('is_admin', true);
      \Phile\Utility::redirect($this->base_url . $this->settings['admin_url'] . '/pages');
    } else {
      \Phile\Utility::redirect($this->base_url . $this->settings['admin_url'] . '/login');
    }
    exit;
  }

  /*!
   * logout of the current session
   * @return redirect redirect to login
   */
  private function logout() {
    header_remove();
    \Phile\Session::set('is_admin', false);
    \Phile\Utility::redirect($this->base_url . $this->settings['admin_url'] . '/login');
  }

  /*!
   * create a new file
   * @return json/array the resulting json for the AJAX request
   */
  private function new_file() {
    $post = $this->filter($_POST);
    $title = $post['filename'];
    if (strpos($title, '/')) {
      $title = explode('/', $title);
    } else {
      $title = array('', $title);
    }
    $dest = $this->slugify($title[0]).'/'.$this->slugify($title[1]);
    $filepath = CONTENT_DIR.$dest.'.md';
    $url = $this->base_url.'/content/'.$dest.'.md';
    $template = "<!--\n";
    $newtitle = '';
    foreach ($this->settings['required_fields'] as $field) {
      if (strtolower($field['name']) == 'title') {
        // check to see if you want to overwrite the title
        // with the filename
        if ($this->settings['filename_is_title']) {
          $field['default'] = $title[1];
        } else {
          $newtitle = $field['default'];
        }
      }
      $template .= ucfirst($field['name']).": ".$field['default']."\n";
    }
    $template .= "-->\n\n";
    $template .= $this->settings['default_content'];
    // ceck to see if creating the new file was a success
    if($this->file_force_contents($filepath, $template)) {
      $list_item = '<li><a href="'.$url.'" data-path="'.$filepath.'">'.$title[1].'</a></li>';
      $this->send_json(array(
        'status' => true,
        'message' => $this->settings['message_new_post'],
        'content' => $template,
        'list_item' => $list_item
        ));
    } else {
      $this->send_json(array(
        'status' => false,
        'message' => $this->settings['message_new_error'],
        ));
    }
  }

  public function delete_file()
  {
    $post = $this->filter($_POST);
    $file = CONTENT_DIR . $post['filename'] . '.md';
    if(unlink($file)) {
      $this->send_json(array(
        'status' => true,
        'message' => $this->settings['message_delete_post']
        ));
    } else {
      $this->send_json(array(
        'status' => false,
        'message' => $this->settings['message_delete_error'],
        ));
    }
  }

  /*!
   * save the working file
   * @return json/array the results for the AJAX request
   */
  private function save() {
    $post = $this->filter($_POST);
    $path = pathinfo($post['path']);
    if ($path['basename'] == $this->settings['info_file']) {
      $this->send_json(array(
        'status' => false,
        'message' => 'Cannot Override '. $this->settings['info_file'] .'. Is info_file.'
        ));
    } else {
      // use raw textarea value
      $data = file_put_contents($post['path'], $_POST['value']);
      if ($data) {
        $this->send_json(array(
          'status' => true,
          'message' => $this->settings['message_save_post']
          ));
      } else {
        $this->send_json(array(
          'status' => false,
          'message' => $this->settings['message_save_error']
          ));
      }
    }
  }

  /*!
   * send json to the client
   * @param  array $data the data to encode as JSON
   * @return json/array       resulting json
   */
  private function send_json($data) {
    header_remove();
    header($_SERVER['SERVER_PROTOCOL'].' 200 OK');
    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode($data);
    exit;
  }

  /*!
   * filter a GET or POST request
   * @param  array $data either $_GET or $_POST
   * @return array       the clean result
   */
  private function filter($data) {
    if (is_array($data)) {
      foreach ($data as $key => $value) {
        $data[$key] = $this->filter($value);
      }
    } else {
      $data = trim(htmlentities(strip_tags($data)));
      if(get_magic_quotes_gpc()) {
        $data = stripslashes($data);
      }
      $data = mysql_real_escape_string($data);
    }
    return $data;
  }

  /*!
   * this is a simple function to render a PHP file based on an input array
   * @param  string $filename the file to render
   * @param  array $vars     the data to send to the template
   * @return function           cleans the memory
   */
  private function render_file($filename, $vars = null) {
    if (is_array($vars) && !empty($vars)) {
      extract($vars);
    }
    ob_start();
    include $this->config['path'] . 'views/' . $filename;
    return ob_get_clean();
  }

  /*!
   * render a php file with data
   * @param  string $file the file to render
   * @return page       the page to render
   */
  private function render($file, $data = null)
  {
    // set the appropriate headers
    header($_SERVER['SERVER_PROTOCOL'].' 200 OK');
    header("Content-Type: text/html; charset=UTF-8");
    // echo out the template file
    echo $this->render_file($file, (is_null($data)) ? $this->config: $data);
    // exit the app and stop all activity
    exit;
  }

  /*!
   * create a slug from a title [http://goo.gl/ZOpbtk]
   * @param  string $text the string to convert
   * @return string       the results of the conversion
   */
  private function slugify($text) {
    // replace non letter or digits by -
    $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
    // trim
    $text = trim($text, '-');
    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    // lowercase
    $text = strtolower($text);
    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);
    if (empty($text)) {
      return 'n-a';
    }
    return $text;
  }

  /*!
   * if path doesnt exist, create it
   * @param  string $dir      the path to create
   * @param  string $contents the contents to write
   * @return int           the number of bytes written
   */
  private function file_force_contents($dir, $contents){
    $parts = explode('/', $dir);
    $file = array_pop($parts);
    $dir = '';
    foreach($parts as $part) {
      if(!is_dir($dir .= "/$part")) {
        mkdir($dir);
      }
    }
    return file_put_contents("$dir/$file", $contents);
  }

}
