<!DOCTYPE HTML>
<!--[if IEMobile 7 ]><html class="no-js iem7" manifest="default.appcache?v=1"><![endif]-->
<!--[if lt IE 7 ]><html class="no-js ie6" lang="en"><![endif]-->
<!--[if IE 7 ]><html class="no-js ie7" lang="en"><![endif]-->
<!--[if IE 8 ]><html class="no-js ie8" lang="en"><![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!--><html class="no-js" lang="en"><!--<![endif]-->
	<?php $version = 4; ?>
	<head>
		<title><?php bloginfo( 'name' ); ?></title>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
	  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, user-scalable=no" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico"/>
		<link rel="stylesheet" href="//code.cdn.mozilla.net/fonts/fira.css">
		<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri() .'/style.css?v=' . get_version(); ?>" />

		<meta property="og:title" content="<?php echo get_field('social_subject', 'option'); ?>" />
		<meta property="og:site_name" content="<?php bloginfo( 'name' ); ?>" />
		<meta property="og:url" content="<?php echo get_bloginfo('url'); ?>" />
		<meta property="og:description" content="<?php echo get_field('social_body', 'option'); ?>" />
		<?php $std_image = get_field('image','option'); ?>

		<meta property="og:image" content="<?php echo $std_image['url'] ?>" />
		<meta name="twitter:card" content="summary_large_image" />
		<meta name="twitter:site" content="@firefox">
		<meta name="twitter:creator" content="@firefox">
		<meta name="twitter:title" content="<?php echo get_field('social_subject', 'option'); ?>" />
		<meta name="twitter:description" content="<?php echo get_field('social_body', 'option'); ?>" />
		<meta name="twitter:image:src" content="<?php echo $std_image['url']; ?>" />

		<script src="<?php echo get_stylesheet_directory_uri(); ?>/head.min.js?v=<?php echo get_version(); ?>"></script>
	
		<!--[if IE]>
		<script src="<?php echo get_stylesheet_directory_uri(); ?>/ie.js"></script>
		<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
		<![endif]-->
		
		<?php wp_head(); ?>
		
		<!--[if IE 8 ]>
		<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/ie8.css">
		<![endif]-->
	</head>
	<body <?php body_class(); ?>>
