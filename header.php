<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php bloginfo('name'); ?><?php wp_title(); ?></title>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />	
	<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats please -->

	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/reset.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge;chrome=1"><![endif]-->
    <!--[if IE 6]>
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/ie6.css" type="text/css" media="screen" />
    <![endif]-->
    <!--[if IE 7]>
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/ie7.css" type="text/css" media="screen" />
    <![endif]-->
    <!--[if IE 8]>
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/ie8.css" type="text/css" media="screen" />
    <![endif]-->
    <link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/favicon.ico" type="image/x-icon" />
    <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
	<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/menu.css" type="text/css" media="screen" />
 	<?php wp_enqueue_script('jquery'); ?>
 	<?php wp_head(); ?>
    <script src="<?php bloginfo('template_url'); ?>/js/columnizer.js" type="text/javascript"></script>
    <script src="<?php bloginfo('template_url'); ?>/js/columnize.js" type="text/javascript"></script>
	<script type='text/javascript' src='<?php bloginfo('template_url'); ?>/js/menu.js'></script>
	<script type='text/javascript' src='<?php bloginfo('template_url'); ?>/js/general.js'></script>
	<!--<script type='text/javascript' src='<?php bloginfo('template_url'); ?>/js/image_appear.js'></script>-->
	<script type='text/javascript' src='<?php bloginfo('template_url'); ?>/js/jquery.backstretch.min.js'></script>
	<link type="text/css" href="/cometchat/cometchatcss.php" rel="stylesheet" charset="utf-8">
	<script type="text/javascript" src="/cometchat/cometchatjs.php" charset="utf-8"></script>

</head>
<body <?php body_class(); ?>>
	<div id="outer">
		<div class="logo_bottom"></div>
    	<div id="header">
        	<div id="logo">
        		<a href="<?php bloginfo("url"); ?>/">
				<img src="<?php bloginfo('template_url'); ?>/images/logo.png" alt="<?php bloginfo('name'); ?>" /></a>
        	</div>
        	<div id="flag"></div>
        	<?php get_sidebar(); ?>
        	<div id="twitter_abstract">
        		<?php 
        		$tw_post_id=41;
        		$tw_post= get_post($tw_post_id);
        		echo $tw_post->post_content;
        		?>
        	</div>
            <div id="serv">
<!--            	<div id="search"><?php get_search_form(); ?></div>-->
                <div id="navicons">
                	<?php echo do_shortcode('[social_share/]');?>
                	
                </div>
                <div id="menu">
				<?php custom_menu(); ?>
                </div>
            </div>
            <?php
            if(is_front_page()){ 
           	 get_sidebar("events");
            }
            ?>
        </div>
