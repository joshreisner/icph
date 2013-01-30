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
		<div class="header_wrapper">
			<div class="wrapper2">
				<header>
					<a class="logo" href="/">Poverty & Homelessness <span>NYC</span></a>
					
					<nav class="nav">
						<a href="/">Timeline</a>
						<a href="/eras/" class="eras">Eras</a>
						<a href="/maps/" class="maps">Maps</a>
						<a href="/browse/" class="browse">Browse</a>
						<a href="/about/" class="about">About</a>
					</nav>
					
					<nav class="tools">
						<a href="#">Share</a>
						<a href="#">Search</a>
					</nav>
				</header>
			</div>
		</div>