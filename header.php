<!DOCTYPE html>
<html <?php language_attributes();?>>
	<head>
		<meta charset="<?php bloginfo('charset');?>">
		<title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
		<meta name="description" content="<?php bloginfo('description');?>">
		<?php
			wp_enqueue_script('jquery');
			wp_head();
		?>
		<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_directory');?>/css/global.css">
	</head>
	<body <?php body_class();?>>
