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
		<a class="upper" href="<?php echo $era->url?>"></a>
		<div class="lower">
			<a href="<?php echo $era->url?>"><h1><?php echo $era->start_year . '&ndash;' . $era->end_year?></h1></a>
			<a href="<?php echo $era->url?>"><h2><?php echo $era->post_title?></h2></a>
			<ul>
				<li><a href="<?php echo $era->url?>"><i class="icon-right-circle"></i><?php echo get_post_meta($era->ID, 'home_read_more', true)?></a></li>
				<li><a href="/timeline"><i class="icon-right-circle"></i>Access the Timeline</a></li>
				<li><a href="/maps"><i class="icon-right-circle"></i><?php echo $era->map_link?></a></li>
				<li><a href="/#<?php echo $overview->post_name?>"><i class="icon-right-circle"></i><?php echo $overview->post_title?></a></li>
			</ul>
		</div>
	</div>
	<?php }?>
</div>

<div id="home_insights">
	<div class="title">Policy &amp; Research <em>Insights</em></div>
	<div>
		<div class="arrow left"><a href="#"><i class="icon-left-open-big"></i></a></div>
		<div class="insight">
			<?php
			$links = get_bookmarks('orderby=link_id&order=desc');
			foreach ($links as $link) {
				echo '<a href="' . $link->url . '">' . $link->link_name . '</a>';
			}
			?>
		</div>
		<div class="arrow right"><a href="#"><i class="icon-right-open-big"></i></a></div>
	</div>
</div>

<?php 
get_footer();