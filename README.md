PhileCMS Admin 1.0.0
====================

This is the new version of the [PhileCMS](https://github.com/PhileCMS/Phile) admin.

## For Phile 0.9.*

You can download the old release [here](https://github.com/james2doyle/phileAdmin/releases/tag/0.9). Please note, *I never finished the 0.9 version. It will not be supported anymore.*.

## For Phile 1.*

At the root of your Phile installation:

`git clone https://github.com/james2doyle/phileAdmin plugins/phile/adminPanel`

Or if you are downloading, make sure the folder is named `adminPanel` and drop it into `plugins/phile/`. Then move `upload-htaccess` `to content/uploads/.htaccess`.

You also need add the plugin to your config:

```
'phile\\adminPanel' => array('active' => true)
```

## Usage

Just go to `/admin` on your phile install and you will see it load up! The session is not enabled while this plugin is in development.

The users data is fake.I am no security expert but maybe there is a good way to do users with Phile without using plaintext passwords and logins. Maybe something with single sign-on style?

### Udate your config.php

```php
// merge config with json if PhileAdmin is installed
if($config['plugins']['phile\\adminPanel']['active'] && file_exists('config.json')) {
  $config = array_merge(
    $config,
    json_decode(file_get_contents('config.json'), true)
  );
}
return $config;
```

### Handling Errors

Before you create any issues or write off this plugin as broken, please check the `error_log` file located in the adminPanel root.

## Features

Here is what is working so far:

### Pages

* new temporary page
* view pages
* open page in editor
* delete pages

### Photos

* view multiple photo info
* download photo
* upload photo
* delete multiple photos

### Files

* delete multiple files
* view files
* upload files

### Plugins

* list plugin status and info
* there is a plugin toggle, but I am not sure if that is feasible at the moment

### Templates

* list templates
* edit/save templates

### Config

* list config
* create and save key => values
* delete items

### Users

* list users
* create and save
* auto-create when no users are present
* delete users

### Settings

* list settings
* list required fields for new pages
* create, save and delete fields
