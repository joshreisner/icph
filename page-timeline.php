<?php
//blog page
$body_class = 'timeline';
get_header();
?>
<div id="timeline">
	<ul>
	<?php foreach ($eras as $era) {?>
		
		<li id="<?php echo $era['slug']?>" class="<?php echo $era['slug']?> overview">
			<div class="upper">
				<h1><?php echo $era['start_year']?>&ndash;<?php echo $era['end_year']?></h1>
				<h2><?php echo $era['name']?></h2>
			</div>
			<div class="lower">
				<?php
				$posts = get_posts('numberposts=1&tag_id=' . $overview_tag_id . '&category=' . $era['category_id']);
				foreach ($posts as $post) {
					echo nl2br($post->post_excerpt);
					echo '<a href="#' . $post->post_name . '" class="more">Era Introduction</a>';
				}
				?>
			</div>
		</li>
		<?php
		$posts = get_posts('numberposts=1&tag=featured-story&category=' . $era['category_id']);
		foreach ($posts as $post) {?>
		<li class="<?php echo $era['slug']?> featured">
			<div class="upper"></div>
			<div class="lower">
				<?php if (has_post_thumbnail()) {?>
				<a href="#<?php echo $post->post_name?>"><?php echo get_the_post_thumbnail($post->ID, 'medium')?></a>
				<?php }
				echo $post->post_excerpt?>
				<a href="#<?php echo $post->post_name?>" class="more"><?php echo $post->post_title?></a>
			</div>
		</li>
		<?php 
		}
		$years = get_posts('post_type=years&numberposts=-1&order_by=post_title&order=ASC&category=' . $era['category_id']);
		foreach ($years as $year) {
			?>
		<li class="<?php echo $era['slug']?>">
			<div class="upper">
				<?php if ($related_links = get_related_links('post', $year->ID)) {
					echo icph_thumbnail($related_links[0]['id'], $related_links[0]['title']);
				}?>
				<h3><?php echo $year->post_title?></h3>
			</div>
			<div class="lower">
				<?php echo str_replace(site_url('/'), '', nl2br($year->post_content))?>
			</div>
		</li>
		<?php }
	}?>
	</ul>
	
	<a class="arrow left"><div class="cap"><i class="icon-angle-left"></i></div></a>
	<a class="arrow right"><div class="cap"><i class="icon-angle-right"></i></div></a>
</div>

<?php

echo icph_slider();

get_footer();