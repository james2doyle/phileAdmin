<!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js lt-ie7"><![endif]-->
<!--[if IE 7]><html class="no-js ie7 lt-ie8"><![endif]-->
<!--[if IE 8]><html class="no-js ie8 lt-ie9"><![endif]-->
<!--[if IE 9]><html class="no-js ie9 lt-ie10"><![endif]-->
<html class="no-js not-ie">
<head>
  <meta charset="utf-8" />
  <title><?php echo $title; ?> | Phile Admin</title>
  <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
  <link rel="stylesheet" href="<?php echo $asset_path; ?>css/style.css" media="screen" />
  <!--[if IE]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
  <script>
  window.admin = {
    url: "<?php echo $base_url.'/admin/'; ?>",
    path: "<?php echo $path; ?>",
    asset_path: "<?php echo $asset_path; ?>"
  };
  </script>
  <?php if (strtolower($title) == 'editor'): ?>
    <link rel="stylesheet" href="<?php echo $asset_path; ?>css/tomorrow-night.css" media="screen" />
  <?php endif ?>
</head>
<body class="<?php echo strtolower($title) ?>-template">
<div class="messages"></div>
