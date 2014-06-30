<?php
/**
 * The Admin Utilities Class
 */
namespace Phile\Plugin\Phile\AdminPanel;

/**
 * Class Utilities
 *
 * @author  James Doyle
 * @link    https://philecms.com
 * @license http://opensource.org/licenses/MIT
 * @package Phile\Plugin\Phile\AdminPanel\Utilities
 */
class Utilities {
	private static $config;
	private static $parser;
	private static $initialized = false;

	private static function init()
	{
		if (self::$initialized){
			return;
		}
		self::$config = \Phile\Registry::get('Phile_Settings');
		self::$config['path'] = \Phile\Utility::resolveFilePath("MOD:phile/adminPanel/");
		self::$parser = \Phile\ServiceLocator::getService('Phile_Parser');
		self::$initialized = true;
	}

	/*!
	 * filter a GET or POST request
	 * @param  array $data either $_GET or $_POST
	 * @return array       the clean result
	 */
	public static function filter($data) {
		if (is_array($data)) {
			foreach ($data as $key => $value) {
				$data[$key] = self::filter($value);
			}
		} else {
			$data = trim(htmlentities(strip_tags($data)));
			if(get_magic_quotes_gpc()) {
				$data = stripslashes($data);
			}
			$data = filter_var($data, FILTER_SANITIZE_STRING);
		}
		return $data;
	}

	/*!
	 * this is a simple function to render a PHP file based on an input array
	 * @param  string $filename the file to render
	 * @param  array $vars     the data to send to the template
	 * @return function           cleans the memory
	 */
	public static function render_file($filename, $vars = null) {
		self::init();
		if (is_array($vars) && !empty($vars)) {
			extract($vars);
		}
		ob_start();
		include self::$config['path'] . 'views/' . $filename;
		return ob_get_clean();
	}

	/*!
	 * render a php file with data
	 * @param  string $file the file to render
	 * @return page       the page to render
	 */
	public static function render($file, $data = null, $merge = true, $status = '200')
	{
		self::init();
		// set the appropriate headers
		$codes = array(
			'200' => 'OK',
			'500' => 'Internal Server Error',
			'404' => 'Not Found'
			);
		header($_SERVER['SERVER_PROTOCOL'].' '.$status.' '.$codes[$status]);
		header("Content-Type: text/html; charset=UTF-8");
		// echo out the template file
		if ($merge) {
			$data = array_merge($data, self::$config);
		}
		echo self::render_file($file, (is_null($data)) ? self::$config: $data);
		// exit the app and stop all activity
		exit;
	}

	public static function parse_markdown($content) {
		self::init();
		return self::$parser->parse($content);
	}

	/*!
	 * create a slug from a title [http://goo.gl/ZOpbtk]
	 * @param  string $text the string to convert
	 * @return string       the results of the conversion
	 */
	public static function slugify($text) {
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
			return '';
		}
		return $text;
	}

	/*!
	 * if path doesnt exist, create it
	 * @param  string $dir      the path to create
	 * @param  string $contents the contents to write
	 * @return int           the number of bytes written
	 */
	public static function file_force_contents($dir, $contents){

		$parts = explode(DIRECTORY_SEPARATOR, $dir);
		$file = array_pop($parts);
		$dir = implode(DIRECTORY_SEPARATOR, $parts);

		if (!is_dir($dir)) {
			// creates each directory recursively (using default chmod)
			mkdir($dir, 0777, TRUE);
		}

		return file_put_contents($dir . DIRECTORY_SEPARATOR . $file, $contents);
	}

	public static function array_to_object($array) {
		$obj = new \stdClass;
		foreach($array as $k => $v) {
			if(strlen($k)) {
				if(is_array($v)) {
					$obj->{$k} = self::array_to_object($v); // RECURSION
				} else {
					$obj->{$k} = $v;
				}
			}
		}
		return $obj;
	}

	public static function photo_info($value, $base_url)
	{
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$image_obj = new \stdClass();
		$pathinfo = pathinfo($value);
		$image_obj->name = basename($value);
		$image_obj->slug = self::slugify(str_replace('.'.$pathinfo['extension'], '', basename($value)));
		$image_obj->path = str_replace(ROOT_DIR, '', $value);
		$image_obj->url = $base_url . '/'.str_replace(ROOT_DIR, '', $value);
		$image_obj->info = getimagesize($value);
		$image_obj->mime = finfo_file($finfo, $value);
		return $image_obj;
	}

	public static function file_info($value, $base_url)
	{
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$file_obj = new \stdClass();
		$file_obj->name = basename($value);
		$file_obj->slug = self::slugify(basename($value));
		$file_obj->path = str_replace(ROOT_DIR, '', $value);
		$file_obj->url = $base_url . '/' . str_replace(ROOT_DIR, '', $value);
		$file_obj->mime = finfo_file($finfo, $value);
		$file_obj->size = round(filesize($value) / 1000) . 'Kb';
		return $file_obj;
	}

	public static function safe_extension($check)
	{
		// the bad file list http://goo.gl/eFotBy
		$bad_files = array('php', 'php2', 'php3', 'php4', 'php5', 'php6', 'php7', 'php8', 'pl', 'py', 'sh', 'cgi', 'bat', 'exe', 'cmd', '386', 'dll', 'com', 'torrent', 'js', 'app', 'jar', 'pif', 'vb', 'vbscript', 'wsf', 'asp', 'cer', 'csr', 'jsp', 'drv', 'sys', 'ade', 'adp', 'bas', 'chm', 'cpl', 'crt', 'csh', 'fxp', 'hlp', 'hta', 'inf', 'ins', 'isp', 'jse', 'htaccess', 'htpasswd', 'ksh', 'lnk', 'mdb', 'mde', 'mdt', 'mdw', 'msc', 'msi', 'msp', 'mst', 'ops', 'pcd', 'prg', 'reg', 'scr', 'sct', 'shb', 'shs', 'url', 'vbe', 'vbs', 'wsc', 'wsf', 'wsh');
		// are we passing a pathinfo array?
		$path_array = (is_array($check) && isset($check['extension'])) ? $check: pathinfo($check);
		if (in_array($path_array['extension'], $bad_files)) {
			return false;
		} else {
			return true;
		}
	}

	public static function generateHash($value)
	{
		$config = \Phile\Registry::get('Phile_Settings');
		$encryptionKey = $config['encryptionKey'];
		return sha1($value . $encryptionKey);
	}

	public static function encodeData($value, $key = NULL)
	{
		if($key == NULL) $key = Utilities::generateHash('');

		$j      = 0;
		$hash   = '';
		$value  = gzcompress(bin2hex($value));
		$strLen = strlen($value);
		$keyLen = strlen($key);
		for ($i = 0; $i < $strLen; $i++) {
			$ordStr = ord(substr($value,$i,1));
			if ($j == $keyLen) { $j = 0; }
			$ordKey = ord(substr($key,$j,1));
			$j++;
			$hash .= strrev(base_convert(dechex($ordStr + $ordKey),16,36));
		}

		return gzcompress($hash);
	}

	public static function decodeData($value, $key = NULL)
	{
		if($key == NULL) $key = Utilities::generateHash('');

		$j      = 0;
		$hash   = '';
		$value  = gzuncompress($value);
		$strLen = strlen($value);
		$keyLen = strlen($key);
		for ($i = 0; $i < $strLen; $i+=2) {
			$ordStr = hexdec(base_convert(strrev(substr($value,$i,2)),36,16));
			if ($j == $keyLen) { $j = 0; }
			$ordKey = ord(substr($key,$j,1));
			$j++;
			$hash .= chr($ordStr - $ordKey);
		}

		return hex2bin(gzuncompress($hash));
	}
	
	public static function delTree($dir) {
		$files = array_diff(scandir($dir), array('.','..'));
		foreach ($files as $file) {
			(is_dir("$dir/$file")) ? Utilities::delTree("$dir/$file") : unlink("$dir/$file");
		}
		return rmdir($dir);
  } 

	public static function error_log($message) {
		$error_file = realpath(dirname(dirname(__FILE__)))."/error_log";
		$file_handler = fopen($error_file, 'a');
		$message = date("Y-m-d H:i:s")." ". $message ." \n";
		$write = fwrite($file_handler, $message);
		fclose($file_handler);
	}
}
