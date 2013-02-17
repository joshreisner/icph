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
		<h1><?php echo $era['start_year']?>&ndash;<?php echo $era['end_year']?></h1>
		<h2><?php echo $era['title']?></h2>
		<a href="#" class="close">Back to Timeline</a>
		<h3>Articles</h3>
	</div>
	
	<div class="body">
		<div class="content">
			<img src="<?php bloginfo('template_directory');?>/img/placeholder/gordon-family-m2.jpg" alt="gordon-family-m2" width="640" height="282" />
			<div class="inner"><?php the_content()?></div>
		</div>
		<div class="navigation">
			<ul>
				<?php
				$posts = get_posts('category=' . $era['category_id']);
				foreach ($posts as $post) {?>
				<li>
					<a href="<?php echo $post->post_name?>"><?php echo $post->post_title?></a>
					<p><?php echo $post->post_excerpt?></p>
				</li>
				<?php }?>
			</ul>
		</div>
	</div>
</div>
<div id="overlay_backdrop"></div>