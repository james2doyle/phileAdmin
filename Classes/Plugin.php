<?php
/**
 * Plugin class
 */
namespace Phile\Plugin\Phile\AdminPanel;

/**
 * Class Plugin
 * Phile admin interface and tools
 *
 * @author  James Doyle
 * @link    https://philecms.com
 * @license http://opensource.org/licenses/MIT
 * @package Phile\Plugin\Phile\AdminPanel
 */
class Plugin extends \Phile\Plugin\AbstractPlugin implements \Phile\Gateway\EventObserverInterface {
	private $config;
	/**
	 * the constructor
	 */
	public function __construct() {
		// check to see if we have these folders present, if not, create them
		$folders = array(CONTENT_DIR . 'uploads', CONTENT_DIR . 'uploads/files', CONTENT_DIR . 'uploads/images');
		foreach ($folders as $folder) {
			// dont tell us if the error is there, fail silently and create the folder
			if (@stat($folder) === false) {
				if (!mkdir($folder, 0755, true)) {
					throw new \Exception("Error creating ".$folder, 1);
				}
			}
		}
		\Phile\Event::registerEvent('request_uri', $this);
		$this->config = \Phile\Registry::get('Phile_Settings');
	}

	public function on($eventKey, $data = null) {
		if ($eventKey == 'request_uri') {
			$uri = explode('/', $data['uri']);

			// check for users (first time run)
			if(Users::count_users() === 0) {
				$default_user = Utilities::array_to_object($this->settings['default_user']);
				if(empty($default_user->password)) {
					$default_user->password = $this->config['encryptionKey'];
				}
				$default_user->email = $default_user->username . '@example.com';

				// create default user
				Users::save_user($default_user);
				$user = Users::get_user_by_username($default_user->username);

				\Phile\Session::set('PhileAdmin_logged', $user);

				// force edit new user (redirect doesn't work properly due to browser cache)
				$uri = array(0 => 'admin', 1 => 'edit_user');
				$_SERVER['REQUEST_METHOD'] = 'GET';
				$_GET['id'] = $user->user_id;
			}

			if ($uri[0] == 'admin') {
				// deny access when not logged in
				if(\Phile\Session::get('PhileAdmin_logged') == null) {
					if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
						$page = new Pages($this->settings);
						$page->login();
						exit;
					} elseif ($_SERVER['REQUEST_METHOD'] !== 'GET') {
						$request = new Ajax($this->settings);
						
						$white_list_methods = array('validate_login');
						
						if (method_exists($request, $uri[1]) && in_array($uri[1], $white_list_methods)) {
							$request->{$uri[1]}();
						} else {
							$request->send_json(array(
								'status' => false,
								'message' => 'Request not valid.',
								));
						}
					}
				}
				// we are using GET requests, therefore assume we are looking for a page
				if ($_SERVER['REQUEST_METHOD'] === 'GET') {
					$page = new Pages($this->settings);
					// redirect missing pages to the home page
					if (!isset($uri[1]) || $uri[1] === '') {
						$uri[1] = $this->settings['nav'][0]['url'];
					}
					if (method_exists($page, $uri[1])) {
						$page->{$uri[1]}();
					} else {
						// serve the 'not found' page
						$page->fourofour();
					}
				} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
					// we have used a POST request, must be ajax time
					$request = new Ajax($this->settings);
					if (method_exists($request, $uri[1])) {
						$request->{$uri[1]}();
					} else {
						$request->send_json(array(
							'status' => false,
							'message' => 'Request not valid.',
							));
					}
				}
			}
		}
	}
}
