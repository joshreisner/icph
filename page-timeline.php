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
				$posts = get_posts('numberposts=1&tag=era-overview&category=' . $era['category_id']);
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
		$years = get_categories('parent=' . $era['category_id']);
		foreach ($years as $year) {
			$posts = get_posts('numberposts=-1&category=' . $year->term_id);
			?>
		<li class="<?php echo $era['slug']?>">
			<div class="upper">
				<?php echo icph_thumbnail($posts[0]->ID, $posts[0]->post_title, $posts[0]->post_name)?>
				<h3><?php echo $year->name?></h3>
			</div>
			<div class="lower">
				<?php
				foreach ($posts as $post) {
					$excerpt = (empty($post->post_excerpt)) ? $post->post_title : $post->post_excerpt;
					$excerpt = str_ireplace($post->post_title, '<a href="#' . $post->post_name . '">' . $post->post_title . '</a>', $excerpt);
					echo '<p>' . $excerpt . '</p>';
				}
				?>
			</div>
		</li>
		<?php }
	}?>
	</ul>
	
	<a class="arrow left"><i class="icon-angle-left"></i></a>
	<a class="arrow right"><i class="icon-angle-right"></i></a>
</div>

<?php

echo icph_slider();

get_footer();