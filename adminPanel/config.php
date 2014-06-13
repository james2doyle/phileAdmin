<?php
/**
 * config file
 */
return array(
  'info' => array(
    'author' => array(
      'name' => 'James Doyle',
      'homepage' => 'http://ohdoylerules.com'
      ),
    'namespace' => 'Phile',
    'url' => 'http://github.com/james2doyle/phileAdmin',
    'version' => '1.0.0'
    ),
  'users' => array(
    array(
      'username' => 'james2doyle',
      'display_name' => 'James Doyle',
      'role' => 'Admin',
      'created' => '2014-05-22',
      'logged_in' => date('Y-m-d'),
      ),
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
      )
    ),
  'default_content' => "## New Page Title\n\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",
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
