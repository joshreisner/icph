<?php
global $body_class;
?><!DOCTYPE html>
<html <?php language_attributes() ?>>
	<head>
		<meta charset="<?php bloginfo('charset') ?>">
		<title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name') ?></title>
		<meta name="description" content="<?php bloginfo('description') ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<?php
			wp_enqueue_script('jquery');
			wp_head();
		?>
		<link rel="stylesheet" type="text/css" href="//cloud.webtype.com/css/e677f601-51a3-41b8-9df8-446cd03d543f.css">
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory');?>/css/global.css">
	</head>
	<body <?php body_class($body_class) ?>>
		<header>
			<a class="logo" href="/">Poverty & Homelessness <span>NYC</span></a>
			
			<!-- <div id="nav"><?php wp_nav_menu(array('theme_location'=>'nav')) ?></div> -->
			
			<ul id="nav">
				<li<?php if ($_SERVER['REQUEST_URI'] == '/') echo ' class="current_page_item"'?>>
					<a href="/">Timeline</a>
					<div class="separator"></div>
				</li>
				<li>
					<a href="#">Eras</a>
					<ul>
						<?php 
						global $eras;
						foreach ($eras as $e) {?>
						<li class="<?php echo $e['slug']?>">
							<a href="<?php echo $e['url']?>">
								<div><?php echo $e['start_year']?> to <?php echo $e['end_year']?></div>
								<?php echo $e['title']?>
							</a>
						</li>
						<?php }?>
					</ul>
					<div class="separator"></div>
				</li>
				<li<?php if ($_SERVER['REQUEST_URI'] == '/maps/') echo ' class="current_page_item"'?>>
					<a href="/maps/">Maps</a>
					<div class="separator"></div>
				</li>
				<li<?php if ($_SERVER['REQUEST_URI'] == '/browse/') echo ' class="current_page_item"'?>>
					<a href="/browse/">Browse</a>
					<div class="separator"></div>
				</li>
				<li<?php if ($_SERVER['REQUEST_URI'] == '/about/') echo ' class="current_page_item"'?>>
					<a href="/about/">About</a>
				</li>
			</ul>
			
			<ul id="tools">
				<li class="share"><i class="icon-share icon-large"></i> Share</li>
				<li class="search">
					<i class="icon-search icon-large"></i> Search

					<form method="get" action="/">
				        <input type="search" name="s" value="<?php the_search_query()?>">
					</form>
				</li>
			</ul>
		</header>