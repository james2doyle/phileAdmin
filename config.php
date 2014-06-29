<?php
/**
 * config file
 */

$config = array(
  'info' => array(
    'author' => array(
      'name' => 'James Doyle',
      'homepage' => 'http://ohdoylerules.com'
      ),
    'namespace' => 'Phile',
    'url' => 'http://github.com/james2doyle/phileAdmin',
    'version' => '1.0.0'
    ),
  'default_user' => array(
      'username' => 'admin',
      'display_name' => 'Phile Admin',
	  'password' => '' // empty means that encryptionKey will be used as a password
    ),
   'admin_url' => '/admin', // must have a leading slash
  'unsafe_settings' => array(
    'active',
    'admin_url',
    'default_content'
    ),
  'unsafe_config' => array(
    'encryptionKey',
    'timezone',
    'base_url'
    ),
  'origin' => '../plugins/phile/adminPanel/views',
  'homepage' => 'http://localhost:8888/PhileCMS',
  'portal_name' => 'PhileCMS Admin',
  'admin_url' => '/admin', // must have a leading slash
  'filename_is_title' => 'true',
  'image_types' => 'jpg|jpeg|svg|png|gif|webp|ico|bmp',
  // the post title gets overwritten by the new file function
  'required_fields' => array(
    array(
      'name' => 'title',
      'default' => 'New Page'
      ),
    array(
      'name' => 'description',
      'default' => 'This is the post description'
      ),
    array(
      'name' => 'keywords',
      'default' => 'an, array, of, keywords'
      ),
    array(
      'name' => 'date',
      'default' => date('Y-m-d')
      ),
    array(
      'name' => 'thumbnail',
      'default' => '0.jpg'
      ),
    array(
      'name' => 'status',
      'default' => 'draft'
      ),
	array(
	  'name' => 'default_content',
	  'default' => "## New Page Title\n\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
	)
  ),
  'nav' => array(
    array(
      'name' => 'pages',
      'url' => 'pages',
      'title' => 'Pages',
      'icon' => 'document'
      ),
    array(
      'name' => 'templates',
      'url' => 'templates',
      'title' => 'Templates',
      'icon' => 'browser'
      ),
    array(
      'name' => 'photos',
      'url' => 'photos',
      'title' => 'Photos',
      'icon' => 'image'
      ),
    array(
      'name' => 'files',
      'url' => 'files',
      'title' => 'Files',
      'icon' => 'file'
      ),
    array(
      'name' => 'plugins',
      'url' => 'plugins',
      'title' => 'Plugins',
      'icon' => 'puzzle-piece'
      ),
    array(
      'name' => 'users',
      'url' => 'users',
      'title' => 'Users',
      'icon' => 'people'
      ),
    array(
      'name' => 'config',
      'url' => 'config',
      'title' => 'Config',
      'icon' => 'wrench'
      ),
    array(
      'name' => 'settings',
      'url' => 'settings',
      'title' => 'Settings',
      'icon' => 'cog'
      ),
    )
  );

  if(file_exists(__DIR__ . DIRECTORY_SEPARATOR . 'config.json')) {
	$config = array_merge($config, json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'config.json'), true));
  }

  return $config;


