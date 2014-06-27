<?php
/**
 * The Admin AJAX Class
 */
namespace Phile\Plugin\Phile\AdminPanel;

/**
 * Class Ajax
 *
 * @author  James Doyle
 * @link    https://philecms.com
 * @license http://opensource.org/licenses/MIT
 * @package Phile\Plugin\Phile\AdminPanel\Ajax
 */
class Ajax {
	private $parser;
	private $settings;
	private $config;

	public function __construct($settings)
	{
		$this->settings = $settings;
		$this->data = Utilities::filter($_POST);
		$this->config = \Phile\Registry::get('Phile_Settings');
	}

	/*!
	 * send json to the client
	 * @param  array $data the data to encode as JSON
	 * @return string       resulting json
	 */
	private function send_json($response = null) {
		header_remove();
		$status = ($response['status']) ? ' 200 OK': ' 500 Internal Server Error';
		header('Cache-Control: no-cache, must-revalidate');
		header("Content-Type: application/json; charset=UTF-8");
		header($_SERVER['SERVER_PROTOCOL'].$status, true);
		echo json_encode($response);
		exit;
	}

	public function parse_markdown() {
		$this->parser = \Phile\ServiceLocator::getService('Phile_Parser');
		$content = $this->parser->parse($_POST['content']);
		$this->send_json(array(
			'status' => true,
			'content' => $content,
			));
	}

	public function get_contents() {
		$this->send_json(array(
			'status' => true,
			'content' => file_get_contents($this->data['path'])
			));
	}

	public function delete_file()
	{
		foreach ($this->data as $value) {
			if (preg_match('/^content/', $value)) {
				$value = str_replace('content/', '', $value);
				$file = CONTENT_DIR . $value;
			} elseif (preg_match('/^users/', $value)) {
				$value = str_replace('users/', '', $value . '.json');
				$file = Users::get_users_path() . $value;
			} else {
				$file = ROOT_DIR . $value;
			}
			if(!file_exists($file)){
				$value = str_replace('/', DIRECTORY_SEPARATOR, $value);
			}
			if(unlink($file)) {
				$this->send_json(array(
					'status' => true,
					'message' => $value . " deleted"
					));
			} else {
				$this->send_json(array(
					'status' => false,
					'message' => "Error deleting ". $value,
					));
			}
		}
	}

	public function rename_file()
	{
		$newfile = CONTENT_DIR . $this->data['newname'] . '.md';
		$oldfile = CONTENT_DIR . $this->data['oldname'] . '.md';
		if(rename($oldfile, $newfile)) {
			$this->send_json(array(
				'status' => true,
				'message' => $this->settings['message_rename_post'],
				'url' => $this->base_url.'/'.$this->data['newname']
				));
		} else {
			$this->send_json(array(
				'status' => false,
				'message' => $this->settings['message_rename_error'],
				));
		}
	}

	public function file_info()
	{
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$file_templates = array();
		foreach ($this->data as $filename) {
			$file = ROOT_DIR . $filename;
			if(file_exists($file)) {
				$info = getimagesize($file);
				$file_data = array(
					'name' => basename($filename),
					'slug' => Utilities::slugify(basename($filename)),
					'url' => str_replace(ROOT_DIR, '', $file),
					'mime' => finfo_file($finfo, $file),
					'size' => round(filesize($file) / 1000).'Kb',
					'width' => $info[0].'px',
					'height' => $info[1].'px',
					);
				$template = '<h3>Info for ' . $file_data['name'] . '</h3><ul>';
				foreach ($file_data as $key => $value) {
					$template .= '<li><strong>'.$key.'</strong>: <input type="text" value="'.$value.'" placeholder="'.$value.'" class="input-hidden" /></li>';
				}
				$template .= '</ul>';
				$file_templates[] = $template;
			} else {
				$this->send_json(array(
					'status' => false,
					'message' => "Error reading ".  $filename,
					));
			}
		}
		$this->send_json(array(
			'status' => true,
			'message' => $file_templates
			));
	}

	/*!
	 * template for items on the photo page
	 * @param  string $path the location of the photo
	 * @return string       the compliled template
	 */
	private function photo_template($path)
	{
		$photo = Utilities::photo_info($path, $this->config['base_url']);
		return "<div class=\"photo-item\" id=\"{$photo->slug}\"><img src=\"{$photo->url}\" width=\"{$photo->info[0]}\" height=\"{$photo->info[1]}\"><p><input type=\"checkbox\" name=\"\" value=\"{$photo->slug}\" data-url=\"{$photo->path}\"> {$photo->name}</p></div>";
	}

	/*!
	 * template for items on the file page
	 * @param  string $path the location of the file
	 * @return string       the compliled template
	 */
	private function file_template($path)
	{
		$file = Utilities::file_info($path, $this->config['base_url']);
		return "<tr id=\"{$file->slug}\"><td align=\"center\"><input type=\"checkbox\" class=\"row-select\" value=\"{$file->slug}\" data-url=\"{$file->path}\"></td><td>{$file->name}</td><td>{$file->mime}</td><td align=\"right\">{$file->size}</td><td><input type=\"text\" name=\"\" value=\"{$file->path}\" placeholder=\"{$file->path}\" class=\"input-100\"></td><td align=\"right\" class=\"actions\"><a href=\"{$file->url}\" target=\"_blank\" class=\"btn yellow small hint--left\" data-hint=\"View File\"><span class=\"oi\" data-glyph=\"eye\"></span></a></td></tr>";
	}

	public function upload() {
		if (!empty($_FILES) && $_SERVER['REQUEST_METHOD'] === 'POST') {
			// cleanup the filename
			$info = pathinfo($_FILES['file']['name']);
			if (!Utilities::safe_extension($info)) {
				$this->send_json(array(
					'status' => false,
					'message' => 'Unsafe file upload'
					));
			}
			$filename = Utilities::slugify($info['filename']);
			// add a timestamp for lazy fix of name conflicts
			$date = new \DateTime();
			$clean_name = $filename . '-' . $date->getTimestamp() . '.' . $info['extension'];
			// check the file type so we put it in the right folder
			$folder = (preg_match('/^.*\.('. $this->settings['image_types'] .')$/', $clean_name) === 1) ? 'images/': 'files/';
			$target_file = CONTENT_DIR . 'uploads/' . $folder . $clean_name;
			move_uploaded_file($_FILES['file']['tmp_name'], $target_file);
			if ($folder == 'images/') {
				$template = $this->photo_template($target_file);
			} else {
				$template = $this->file_template($target_file);
			}
			$this->send_json(array(
				'status' => true,
				'message' => $template
				));
		}
		exit;
	}

	public function save()
	{
		$path = pathinfo($this->data['path']);
		if (!Utilities::safe_extension($path)) {
			$this->send_json(array(
				'status' => false,
				'message' => 'Unsafe file extension'
				));
		}
		$safe_filename = str_replace($path['filename'], Utilities::slugify($path['filename']), $this->data['path']);
		// use raw textarea value
		$write = file_put_contents($safe_filename, $_POST['value']);
		
		if($this->data['pageType'] == 'template') {
			$received_filename = str_replace(ROOT_DIR, '', $this->data['path']);
		} else {
			if(isset($this->data['filename'])) {
				$received_filename = $this->data['filename'];
			} else {
				$received_filename = $path['filename'];
			}
		}
		
		if ($write) {
			$this->send_json(array(
				'status' => true,
				'message' => 'Saved ' . $path['filename'],
				'path' => str_replace($path['filename'], Utilities::slugify($path['filename']), $received_filename)
				));
		} else {
			$this->send_json(array(
				'status' => false,
				'message' => 'Error saving ' . $path['filename']
				));
		}
	}
	/*
	* simple delete functions
	 */
	public function delete()
	{
		$path = pathinfo($this->data['path']);
		if(unlink($this->data['path'])) {
			$this->send_json(array(
				'status' => true,
				'message' => $path['filename'] . " deleted"
				));
		} else {
			$this->send_json(array(
				'status' => false,
				'message' => "Error deleting ".  $path['filename'],
				));
		}
	}
	
	/* USER FUNCTIONS */
	
	public function save_user()
	{
		$user = new \stdClass();
		$user->user_id = $this->data['user_id'];
		$user->username = $this->data['username'];
		$user->display_name = $this->data['display_name'];
		$user->email = $this->data['email'];
		$user->password = $this->data['password'];
		
		$save_user = Users::save_user($user);
		
		if($save_user === true) {
			$this->send_json(array(
				'status' => true,
				'message' => "User was successfully been saved"
				));			
		} else {
			$this->send_json(array(
				'status' => false,
				'message' => $save_user
				));
		}
		
	}
	
	public function validate_login()
	{
		$user = new \stdClass();
		$user->username = $this->data['username'];
		$user->password = $this->data['password'];

		
		
		$validate_login = Users::validate_login($this->data['username'], $this->data['password']);
		
		if($validate_login) {
			$user = Users::get_user_by_username($this->data['username']);
			Users::update_last_login($user->user_id);
			
			\Phile\Session::set('PhileAdmin_logged', $user);
			
			$this->send_json(array(
				'status' => true,
				'message' => "Logged as " . $this->data['username']
			));
				
		} else {
			\Phile\Session::set('PhileAdmin_logged', null);
			
			$this->send_json(array(
				'status' => false,
				'message' => 'Invalid login'
			));
		}
	}
	
}
