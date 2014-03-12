<?php

return array(
  'username' => 'james',
  'password' => 'phile',
  'filename_is_title' => true,
  'upload_dir' => \Phile\Utility::getBaseUrl() . '/content/uploads/',
  'upload_path' => CONTENT_DIR . 'uploads/',
  'info_file' => 'actions/cheatsheet.md',
  'info_file_title' => 'Md Help File',
  'settings_save_file' => 'actions/settings.json',
  'message_new_post' => 'New Post Created',
  'message_new_error' => 'Error Creating New Post',
  'message_save_post' => 'Saved Successfully',
  'message_save_error' => 'Error Saving File',
  // the post title gets overwritten by the new file function
  'required_fields' => array(
    array(
      'name' => 'title',
      'default' => 'New Page Title'
      ),
    array(
      'name' => 'description',
      'default' => 'This is the post description'
      ),
    array(
      'name' => 'date',
      'default' => date('Y-m-d')
      ),
    array(
      'name' => 'thumbnail',
      'default' => '0.jpg'
      )
    ),
  'default_content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'
  );
