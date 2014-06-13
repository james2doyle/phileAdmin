<!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js lt-ie7"><![endif]-->
<!--[if IE 7]><html class="no-js ie7 lt-ie8"><![endif]-->
<!--[if IE 8]><html class="no-js ie8 lt-ie9"><![endif]-->
<!--[if IE 9]><html class="no-js ie9 lt-ie10"><![endif]-->
<html class="no-js not-ie">
<head>
	<base href="<?php echo $base_url ?>/admin/">
	<meta charset="utf-8" />
	<title><?php echo $portal_name ?> | <?php echo $title ?></title>
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,300,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="<?php echo $origin ?>/css/style.css" media="screen" />
	<!--[if IE]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<body class="<?php echo $body_class ?>">
	<div class="container">
		<header class="user-banner">
			<a href="<?php echo $homepage ?>" target="_blank"><strong><?php echo $portal_name ?></strong></a>
			<a href="#"><strong>James Doyle</strong></a>
		</header>
		<nav class="main-nav">
			<?php foreach ($nav as $item): ?>
				<a href="<?php echo $item->url ?>" <?php if($body_class === $item->name) { echo 'class="active"'; } ?>>
					<span class="oi" data-glyph="<?php echo $item->icon ?>"></span>
					<span class="title"><?php echo $item->title ?></span>
					<span class="indicator oi" data-glyph="caret-top"></span>
				</a>
			<?php endforeach ?>
		</nav>
