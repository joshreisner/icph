<ol>
<?php

$posts = $wpdb->get_results('SELECT id, post_title FROM wp_posts WHERE post_content LIKE \'%/archives%\' and post_status = \'publish\' ORDER BY post_title');

foreach ($posts as $post) { ?>

	<li><a href="/wp-admin/post.php?post=<?php echo $post->id?>&action=edit"><?php echo $post->post_title?></a></li>

<?php } ?>
</ol>