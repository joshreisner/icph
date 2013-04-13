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
	</head>
	<body <?php body_class($body_class) ?>>
		<header>
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
					<a><i class="icon-export"></i> Share</a>
					<ul class="dropdown">
						<li><a href="#"><i class="icon-facebook-circled"></i> Facebook</a></li>
						<li><a href="#"><i class="icon-twitter-circled"></i> Twitter</a></li>
						<li><a href="#"><i class="icon-gplus-circled"></i> Google Plus</a></li>
						<li><a href="#"><i class="icon-pinterest-circled"></i> Pinterest</a></li>
						<li><a href="#"><i class="icon-mail"></i> Email</a></li>
					</ul>
				</li>
				<li class="search">
					<a><i class="icon-search"></i> Search</a>
					<ul class="dropdown">
						<li class="form">							
							<form method="get" action="/">
						        <input type="text" name="s" value="<?php the_search_query()?>" placeholder="What are you looking for?">
						        <i class="icon-cancel-circled"></i>
							</form>
						</li>
						<li class="result">
							<a href="#">The Tenement House Exhibiti&hellip;</a>
						</li>
						<li class="result">
							<a href="#">Charity Organization Societ&hellip;</a>
						</li>
						<li class="result">
							<a href="#">Congestion Exhibit&hellip;</a>
						</li>
						<li class="result">
							<a href="#">Title&hellip;</a>
						</li>
						<li class="all">
							<a href="#"><i class="icon-right-circle"></i> All Results</a>
						</li>
					</ul>
				</li>
			</ul>
		</header>