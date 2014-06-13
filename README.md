PhileCMS Admin 1.0.0
====================

This is the new version of the [PhileCMS](https://github.com/PhileCMS/Phile) admin.

## For Phile 0.9.*

You can download the old release [here](https://github.com/james2doyle/phileAdmin/releases/tag/0.9).

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

### Users

* list users (fake data)

### Settings

* list settings
* list required fields for new pages
