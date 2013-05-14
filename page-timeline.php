<?php
//blog page
$body_class = 'timeline';
get_header();
?>
<div id="timeline">
	<ul>
	<?php foreach ($eras as $era) {
		//overview & featured
		$featured = get_related_links('post', $era->ID);
		$overview = array_shift($featured);
		$overview = get_post($overview['id']);
	?>
		<li id="<?php echo $era->post_name?>" class="<?php echo $era->post_name?> overview">
			<div class="upper">
				<h1><?php echo $era->start_year?>&ndash;<?php echo $era->end_year?></h1>
				<h2><?php echo $era->post_title?></h2>
			</div>
			<div class="lower">
				<?php echo nl2br($overview->post_excerpt)?>
				<a href="#<?php echo $overview->post_name?>" class="more"><i class="icon-play-circled"></i> <span>Continue</span></a>
			</div>
		</li>
		<?php
		foreach ($featured as $feature) {
			$post = get_post($feature['id']);
		?>
		<li class="<?php echo $era->post_name?> featured">
			<div class="upper"></div>
			<div class="lower">
				<?php if (has_post_thumbnail($post->ID)) {?>
				<a href="#<?php echo $post->post_name?>"><?php echo get_the_post_thumbnail($post->ID, 'featured')?></a>
				<?php }
				echo $post->post_excerpt?>
				<a href="#<?php echo $post->post_name?>" class="more"><i class="icon-play-circled"></i> <span>Meet the <?php echo $post->post_title?></span></a>
			</div>
		</li>
		<?php }
		$years = get_posts('post_type=timeline_year&numberposts=-1&orderby=title&order=ASC&meta_key=era&meta_value=' . $era->ID);
		foreach ($years as $year) {
			?>
		<li class="<?php echo $era->post_name?>">
			<div class="upper">
				<?php if ($related_links = get_related_links('post', $year->ID)) {
					echo icph_thumbnail($related_links[0]['id'], $related_links[0]['title']);
				}?>
				<h3><?php echo $year->post_title?></h3>
			</div>
			<div class="lower">
				<?php echo str_replace(site_url('/'), '#', apply_filters('the_content', $year->post_content))?>
			</div>
		</li>
		<?php }
	}?>
	</ul>
	
	<a class="arrow left"><div class="cap"><i class="icon-left-open-big"></i></div></a>
	<a class="arrow right"><div class="cap"><i class="icon-right-open-big"></i></div></a>
</div>

<?php

echo icph_slider();

get_footer();