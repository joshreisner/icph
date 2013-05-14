<?php
global $body_class;
?><!DOCTYPE html>
<html <?php language_attributes() ?>>
	<head>
		<meta charset="<?php bloginfo('charset') ?>">
		<title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name') ?></title>
		<meta name="description" content="<?php bloginfo('description') ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<?php wp_head(); ?>
		<link rel="stylesheet" type="text/css" href="//cloud.webtype.com/css/e677f601-51a3-41b8-9df8-446cd03d543f.css">
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory');?>/css/global.css">
		<script src="<?php bloginfo('template_directory');?>/js/respond.min.js"></script>
	</head>
	<body <?php body_class($body_class) ?>>
		<div id="header">
			<a class="logo" href="/">Poverty & Homelessness History <span>NYC</span></a>
			
			<ul id="nav">
				<li<?php if ($_SERVER['REQUEST_URI'] == '/') echo ' class="current_page_item"'?>>
					<a class="main" href="/">Timeline</a>
					<div class="separator"></div>
				</li>
				<li>
					<a class="main" href="#">Eras</a>
					<ul>
						<?php 
						global $eras;
						foreach ($eras as $era) {?>
						<li class="<?php echo $era->post_name?>">
							<a href="/eras/<?php echo $era->post_name?>">
								<div><?php echo $era->start_year?> to <?php echo $era->end_year?></div>
								<?php echo $era->description?>
							</a>
						</li>
						<?php }?>
					</ul>
					<div class="separator"></div>
				</li>
				<li<?php if ($_SERVER['REQUEST_URI'] == '/maps/') echo ' class="current_page_item"'?>>
					<a class="main" href="/maps/">Maps</a>
					<div class="separator"></div>
				</li>
				<li<?php if ($_SERVER['REQUEST_URI'] == '/browse/') echo ' class="current_page_item"'?>>
					<a class="main" href="/browse/">Browse</a>
					<div class="separator"></div>
				</li>
				<li<?php if ($_SERVER['REQUEST_URI'] == '/about/') echo ' class="current_page_item"'?>>
					<a class="main" href="/about/">About</a>
				</li>
			</ul>
			
			<ul id="tools">
				<li class="share">
					<a class="main"><i class="icon-export"></i> <span>Share</span></a>
					<ul class="dropdown">
						<li><a href="#"><i class="icon-facebook-circled"></i> Facebook</a></li>
						<li><a href="#"><i class="icon-twitter-circled"></i> Twitter</a></li>
						<li><a href="#"><i class="icon-gplus-circled"></i> Google Plus</a></li>
						<li><a href="#"><i class="icon-pinterest-circled"></i> Pinterest</a></li>
						<li><a href="#"><i class="icon-mail"></i> Email</a></li>
					</ul>
				</li>
				<li class="search">
					<a class="main"><i class="icon-search"></i> <span>Search</span></a>
					<ul class="dropdown">
						<li class="form">							
							<form method="get" action="/">
								<?php
								$posts = get_posts('numberposts=-1');
								foreach ($posts as &$p) $p = '"' . str_replace('"', '', str_replace("'", '&quot;', $p->post_title)) . '"';
								$posts = implode(',', $posts);
								?>
						        <input type="text" name="s" id="search" data-provide="typeahead" data-source='[<?php echo $posts?>]' value="<?php the_search_query()?>" placeholder="What are you looking for?">
						        <i class="icon-cancel-circled"></i>
							</form>
						</li>
						<li class="all">
							<a href="#"><i class="icon-play-circled"></i> All Results</a>
						</li>
					</ul>
				</li>
			</ul>
		</div>