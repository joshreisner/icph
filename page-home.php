<?php
//era landing pages & about page
get_header();
?>

<div id="home">
	<?php
	foreach ($eras as $era) {
		$featured = get_related_links('post', $era->ID);
		$overview = array_shift($featured);
		$overview = array_shift($featured);
		$overview = get_post($overview['id']);
		?>
	<div class="column <?php echo $era->post_name?>">
		<div class="upper_wrapper">
			<a class="upper" href="<?php echo $era->url?>"></a>
		</div>
		<div class="lower">
			<a href="<?php echo $era->url?>">
				<h1><?php echo $era->start_year . '&ndash;' . $era->end_year?></h1>
				<h2><?php echo $era->post_title?></h2>
			</a>
			<ul>
				<li><a href="/timeline#<?php echo $era->post_name?>"><i class="icon-right-circle"></i>Timeline</a></li>
				<li><a href="/maps#<?php echo $era->post_name?>"><i class="icon-right-circle"></i>Map: <?php echo $era->map_link?></a></li>
				<li><a href="#<?php echo $overview->post_name?>"><i class="icon-right-circle"></i><?php echo $overview->post_title?></a></li>
			</ul>
		</div>
	</div>
	<?php }?>
</div>

<?php 

echo do_shortcode('[insights]');

get_footer();