<?php
$site_title = get_bloginfo('name');
$site_title = str_replace('NYC', '<span>NYC</span>', $site_title);
?>
		<div id="header">

			<div class="superheader">
				<div class="side left">
					1/5 of New Yorkers are poor or homeless today<br>How did we get here?
				</div>
				<div class="side right">
					<em>The Institute of Children, Poverty, and Homelessness presents</em> timelines,
					maps, stories, and articles exploring the historical experience of family poverty
					and homelessness, and society's response to it.
				</div>
			</div>

			<a class="logo" href="/"><?php echo $site_title?></a>
			
			<ul id="nav">
				<li<?php if ($_SERVER['REQUEST_URI'] == '/timeline') echo ' class="current_page_item"'?>>
					<a class="main" href="/timeline">Timeline</a>
					<div class="separator"></div>
				</li>
				<li>
					<a class="main">Eras</a>
					<ul class="dropdown">
						<?php 
						global $eras;
						foreach ($eras as $era) {?>
						<li class="<?php echo $era->post_name?>">
							<a href="<?php echo $era->url?>">
								<div><?php echo $era->start_year?> to <?php echo $era->end_year?></div>
								<?php echo $era->description?>
							</a>
						</li>
						<?php }?>
					</ul>
					<div class="separator"></div>
				</li>
				<li<?php if ($_SERVER['REQUEST_URI'] == '/maps') echo ' class="current_page_item"'?>>
					<a class="main">Maps</a>
					<ul class="dropdown">
						<?php 
						global $eras;
						foreach ($eras as $era) {?>
						<li class="<?php echo $era->post_name?>">
							<a href="/maps#<?php echo $era->post_name?>">
								<div><?php echo $era->start_year?> to <?php echo $era->end_year?></div>
								<?php echo $era->map_link?>
							</a>
						</li>
						<?php }?>
					</ul>
					<div class="separator"></div>
				</li>
				<li<?php if ($_SERVER['REQUEST_URI'] == '/browse') echo ' class="current_page_item"'?>>
					<a class="main" href="/browse">Browse</a>
					<div class="separator"></div>
				</li>
				<li<?php if ($_SERVER['REQUEST_URI'] == '/about') echo ' class="current_page_item"'?>>
					<a class="main" href="/about">About</a>
				</li>
			</ul>
			
			<ul id="tools">
				<li class="share">
					<a class="main"><i class="icon-export"></i> <span>Share</span></a>
					<ul class="dropdown">
						<li><a href="https://www.facebook.com/InstituteforChildrenandPoverty?v=wall"><i class="icon-facebook-circled"></i> Facebook</a></li>
						<li><a href="https://twitter.com/icph_homeless"><i class="icon-twitter-circled"></i> Twitter</a></li>
						<li><a href="http://www.pinterest.com/icphusa/"><i class="icon-pinterest-circled"></i> Pinterest</a></li>
						<li><a href="mailto:info@ICPHusa.org"><i class="icon-mail"></i> Email</a></li>
					</ul>
				</li>
				<li class="search">
					<a class="main"><i class="icon-search"></i> <span>Search</span></a>
					<ul class="dropdown">
						<li class="form">							
							<form method="get" action="/">
								<?php
								$posts = get_posts('numberposts=-1');
								foreach ($posts as &$p) $p = '"' . str_replace('"', '', str_replace("'", '&rsquo;', $p->post_title)) . '"';
								//$posts = array_slice($posts, 1);
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
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-44217931-1', 'povertyhistory.org');
		  ga('send', 'pageview');
		</script>
	</body>
</html>