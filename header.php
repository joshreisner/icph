<!DOCTYPE html>
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
	<body <?php body_class() ?>>
		<header>
			<a class="logo" href="/">Poverty & Homelessness <span>NYC</span></a>
			
			<!-- <div id="nav"><?php wp_nav_menu(array('theme_location'=>'nav')) ?></div> -->
			
			<div id="nav">
				<div class="menu">
					<ul>
						<li<?php if ($_SERVER['REQUEST_URI'] == '/') echo ' class="current_page_item"'?>>
							<a href="/">Timeline</a>
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
						</li>
						<li<?php if ($_SERVER['REQUEST_URI'] == '/maps/') echo ' class="current_page_item"'?>>
							<a href="/maps/">Maps</a>
						</li>
						<li<?php if ($_SERVER['REQUEST_URI'] == '/browse/') echo ' class="current_page_item"'?>>
							<a href="/browse/">Browse</a>
						</li>
						<li<?php if ($_SERVER['REQUEST_URI'] == '/about/') echo ' class="current_page_item"'?>>
							<a href="/about/">About</a>
						</li>
					</ul>
				</div>
			</div>
		</header>