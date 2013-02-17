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
				<h1><?php echo $era['start_year']?>&dash;<?php echo $era['end_year']?></h1>
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
		foreach ($years as $year) {?>
		<li class="<?php echo $era['slug']?>">
			<div class="upper">
				<img src="<?php bloginfo('template_directory');?>/img/placeholder/great-migration-circle.png" alt="great-migration-circle" width="125" height="125">
				<h3><?php echo $year->name?></h3>
			</div>
			<div class="lower">
				<?php
				$posts = get_posts('category=' . $year->term_id);
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
	
	<div class="arrow left"></div>
	<div class="arrow right"></div>
</div>

<?php

echo icph_slider();

get_footer();