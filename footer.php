<?php
$site_title = get_bloginfo('name');
$site_title = str_replace('NYC', '<span>NYC</span>', $site_title);
?>
		<div id="header">
			<a class="logo" href="/"><?php echo $site_title?></a>
			
			<ul id="nav">
				<li<?php if ($_SERVER['REQUEST_URI'] == '/') echo ' class="current_page_item"'?>>
					<a class="main" href="/">Timeline</a>
					<div class="separator"></div>
				</li>
				<li>
					<a class="main" href="#">Eras</a>
					<ul class="dropdown">
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
		
		<footer>
			<div class="copyright">
				<a target="_blank" href="http://www.icphusa.org/"><img src="<?php bloginfo('template_directory');?>/img/logo.png" alt="logo" width="229" height="27"></a>
				<div>&copy; <?php echo date("Y")?> Institute for Children, Poverty &amp; Homelessness- All Rights Reserved</div>
			</div>
			<ul>
				<li class="icon"><a target="_blank" href="https://www.facebook.com/InstituteforChildrenandPoverty"><i class="icon-facebook-circled"></i></a></li>
				<li class="icon"><a target="_blank" href="https://twitter.com/icph_homeless"><i class="icon-twitter-circled"></i></a></li>
				<li><a href="/about/">About</a></li>
				<li><a href="/about/#contact">Contact</a></li>
			</ul>				
		</footer>

		<?php wp_footer(); ?>
		<script src="<?php bloginfo('template_directory');?>/js/global.min.js"></script>
	</body>
</html>