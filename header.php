<!DOCTYPE html>
<html <?php language_attributes() ?>>
	<head>
		<meta charset="<?php bloginfo('charset') ?>">
		<title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name') ?></title>
		<meta name="description" content="<?php bloginfo('description') ?>">
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
								<li class="early_ny">
									<a href="/eras/early-new-york-city/">
										<div>1650s to 1830s</div>
										Family Poverty in Early New York City
									</a>
								</li>
								<li class="nineteenth">
									<a href="/eras/19th-century/">
										<div>1830s to 1890s</div>
										Poverty &#038; Homelessness in the 19th Century
									</a>
								</li>
								<li class="progressive">
									<a href="/eras/the-progressive-era/">
										<div>1890s to 1920s</div>
										Poverty &#038; Homelessness in the Progressive Era
									</a>
								</li>
								<li class="great_depression">
									<a href="/eras/the-great-depression/">
										<div>1929 to 1945</div>
										Family Crises in the Great Depression
									</a>
								</li>
								<li class="today">
									<a href="/eras/new-urban-poverty/">
										<div>1945 to Today</div>
										The Origin of New Urban Poverty
									</a>
								</li>
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