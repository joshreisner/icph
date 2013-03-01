<?php
//no header or footer

if (empty($_GET['overlay'])) {
	//not an overlay, forward to overlay page
	header('Location: /#' . str_replace('/', '', $_SERVER['REQUEST_URI']));
	exit;
}

the_post();

$era = icph_get_era($post->ID);

?>

<div id="overlay" class="<?php echo $era['slug']?>">
	<div class="header">
		<h1><?php echo $post->post_title?></h1>
		<a href="#" class="close">Close <i class="icon-remove-circle icon-large"></i></a>
		<h3>Articles</h3>
	</div>
	
	<div class="body">
		<div class="content">
			<!-- <img src="<?php bloginfo('template_directory');?>/img/placeholder/gordon-family-m2.jpg" alt="gordon-family-m2" width="640" height="282" /> -->
			<?php 
			if (has_post_thumbnail()) echo '<div class="featured_image">'. get_the_post_thumbnail($post->ID, 'large') . '</div>';
			?>

			<div class="inner">
				<?php the_content()?>
				
				<?php if ($related_links = get_related_links()) {?>
				<div class="related">
					<h3>Related Articles</h3>
					<?php
					foreach ($related_links as &$link) {
						$link['content'] = icph_thumbnail($link['id'], $link['title']) . $link['title'];
					}
					echo icph_ul($related_links);
					?>
				</div>
				<?php } ?>
			</div>
			
		</div>
		<div class="navigation">
			<ul>
				<?php
				$posts = get_posts('numberposts=-1&category=' . $era['category_id']);
				foreach ($posts as $p) {?>
				<li<?php if ($p->post_name == $post->post_name) {?> class="active"<?php }?>>
					<a href="#<?php echo $p->post_name?>">
						<strong><?php echo $p->post_title?></strong>
						<?php echo $p->post_excerpt?>
					</a>
				</li>
				<?php }?>
			</ul>
		</div>
	</div>
</div>
<div id="overlay_backdrop"></div>