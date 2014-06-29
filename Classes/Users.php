<?php
/**
 * The Admin User Functions
 */
namespace Phile\Plugin\Phile\AdminPanel;
/**
 * Class Users
 *
 * @author  Bruno Horphoz
 * @link    https://philecms.com
 * @license http://opensource.org/licenses/MIT
 * @package Phile\Plugin\Phile\AdminPanel\Users
 */
class Users {
	
	public static function get_users_path() {
		return dirname(__DIR__) . DIRECTORY_SEPARATOR . 'users' . DIRECTORY_SEPARATOR;
	}
	
	/*!
	 * count users
	 * @return int
	 */
	public static function count_users() {
		return \Phile\Utility::getFiles(Users::get_users_path(), '/^.*\.(json)$/');
	}

	/*!
	 * get all users
	 * @param  string $order field name to order data
	 * @return array  array with all users (objects)
	 */
	public static function get_all_users($order = 'username') {
		$aUsers = array();
		$users_folder = \Phile\Utility::getFiles(Users::get_users_path(), '/^.*\.(json)$/');
		foreach ($users_folder as $key => $user_file) {
			$id = str_ireplace('.json', '', basename($user_file));
			$user = Users::get_user_by_hash($id);
			$aUsers[$user->{$order}] = $user;
		}
		ksort($aUsers);
		return $aUsers;
	}

	/*!
	 * get an user by its username
	 * @param  string $username
	 * @return mixed  user object OR false if user wasn't found
	 */
	public static function get_user_by_username($username) {
		return Users::get_user_by_hash(Utilities::generateHash($username));
	}
	
	/*!
	 * get an user by its id/hash
	 * @param  string $hash user_id
	 * @return mixed  user object OR false if user wasn't found
	 */
	public static function get_user_by_hash($hash) {
		$userFile = Users::get_users_path() . $hash . '.json';
		if(file_exists($userFile)){
			$user_decoded = Utilities::decodeData(file_get_contents($userFile));
			return(json_decode($user_decoded));
		} else {
			return false;
		}
	}
	
	/*!
	 * validate login info
	 * @param  string $username username
	 * @param  string $password user password
	 * @return boolean true if login data are right OR false if not
	 */
	public static function validate_login($username, $password) {
		$user_id = Utilities::generateHash($username);
		$user_data = Users::get_user_by_hash($user_id);
		if($user_data === false) {
			return false;
		} else {
			if($user_data->password == Utilities::generateHash($password)) {
				return true;
			}
		}
		return false;
	}
	
	/*!
	 * update user with its last login time
	 * @param  string $user_id user_id
	 * @return mixed true if user was updated OR string that contains an error
	 */
	public static function update_last_login($user_id) {
		$user_data = Users::get_user_by_hash($user_id);
		$user_data->logged = time();
		return Users::save_user($user_data);
	}
	
	/*!
	 * create/update an user
	 * @param  object $user object that contains user data
	 * @return mixed true if user was saved/updated properly OR string that contains an error
	 */
	public static function save_user($user) {
	
		/* User data:
			$user->user_id
			$user->username
			$user->display_name
			$user->email
			$user->password
			$user->created
			$user->logged
		*/
		
		if(empty($user->display_name)) {
			return 'Display Name must be filled out';
		}
		
		if(empty($user->email)) {
			return 'Email must be filled out';
		} elseif(!filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
			return 'Invalid email';
		}
		
		// new user
		if(!isset($user->user_id) || $user->user_id == '') {
		
			// password is required for new users
			if(empty($user->password)) {
				return 'Password must be filled out';
			}
			// username is also required for new users
			if(empty($user->username)) {
				return 'Username must be filled out';
			}
			
			$user->username = strtolower($user->username);
			$user->user_id  = Utilities::generateHash($user->username);
			$user->password = Utilities::generateHash($user->password);
			$user->created = time();
			$user->logged  = time();
			
			// check if user already exists
			if(Users::get_user_by_hash($user->user_id) !== false) {
				return 'User already exists';
			}
			
		} else {
			// update user data
			$old_user_data = Users::get_user_by_hash($user->user_id);
			
			if($old_user_data === false) {
				return "User wasn't found";
			}
			
			## keep data and check for data changes ##
			
			// update password
			if(!empty($user->password) && $old_user_data->password != $user->password) {
				$old_user_data->password = Utilities::generateHash($user->password);
			}
			// update display name
			if(!empty($user->display_name) && $user->display_name != $old_user_data->display_name) {
				$old_user_data->display_name = $user->display_name;
			}
			// update email
			if(!empty($user->email) && $user->email != $old_user_data->email) {
				$old_user_data->email = $user->email;
			}
			// update last login
			if(!empty($user->logged)) {
				$old_user_data->logged = $user->logged;
			}			
			
			$user = $old_user_data;
			
		}
		
		$encoded_user = Utilities::encodeData(json_encode($user));
		
		if ( Utilities::file_force_contents(Users::get_users_path() . $user->user_id . '.json', $encoded_user) ){
			return true;
		} else {
			return 'Error while saving user file';
		}
	}

}
