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
			// placeholder for session logins
			$logged_in = true;
			if ($uri[0] == 'admin' && $logged_in) {
				if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
					$page = new Pages($this->settings);
					// redirect missing pages to the home page
					if (method_exists($page, $uri[1])) {
						$page->{$uri[1]}();
					} else {
						// serve the 'not found' page
						$page->fourofour();
					}
				} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
					$request = new Ajax($this->settings);
					if (method_exists($request, $uri[1])) {
						$request->{$uri[1]}();
					} else {
						$request->send_json(array(
							'status' => false,
							'content' => 'Request not valid.',
							));
					}
				}
			}
		}
	}
}
