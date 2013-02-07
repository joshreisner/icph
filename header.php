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
		<div class="header_wrapper">
			<div class="wrapper2">
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
									<a href="/eras/">Eras</a>
									<ul class="children">
										<li>
											<a href="/eras/early-new-york-city/">
												1650s to 1830s: Family Poverty in Early New York City
											</a>
										</li>
										<li>
											<a href="/eras/19th-century/">
												1830s to 1890s: Poverty &#038; Homelessness in the 19th Century
											</a>
										</li>
										<li>
											<a href="/eras/the-progressive-era/">
												1890s to 1920s: Poverty &#038; Homelessness in the Progressive Era
											</a>
										</li>
										<li>
											<a href="/eras/the-great-depression/">
												1929 to 1945: Family Crises in the Great Depression
											</a>
										</li>
										<li>
											<a href="/eras/new-urban-poverty/">
												1945 to Today: The Origin of New Urban Poverty
											</a>
										</li>
									</ul>
								</li>
								<li<?php if ($_SERVER['REQUEST_URI'] == '/maps/') echo ' class="current_page_item"'?>>
									<a href="/maps/">Maps</a>
								</li>
								<li<?php if ($_SERVER['REQUEST_URI'] == '/topics/') echo ' class="current_page_item"'?>>
									<a href="/topics/">Topics</a>
								</li>
								<li<?php if ($_SERVER['REQUEST_URI'] == '/about/') echo ' class="current_page_item"'?>>
									<a href="/about/">About</a>
								</li>
							</ul>
						</div>
					</div>
				</header>
			</div>
		</div>