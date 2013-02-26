<?php
//search results page
get_header();

echo '<div class="container">';

if (have_posts()) {
	echo '<h1>Search results for &lsquo;' . get_search_query() . '&rsquo;</h1>';
	
	while (have_posts()) {
		the_post();
		?>
		<p>
			<h3><a href="#<?php echo $post->post_name?>"><?php echo $post->post_title?></a></h3>
			<?php echo $post->post_excerpt?>
		</p>
		<?php
	}
} else {
	echo 'no results homie';	
}

echo '</div>';

get_footer();