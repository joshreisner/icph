<?php
//era landing pages & about page
get_header();
?>

<div id="home">
	<?php
	foreach ($eras as $era) {
		?>
	<div class="column <?php echo $era->post_name?>">
		<div class="upper">
		</div>
		<div class="lower">
			<h1><?php echo $era->start_year . '&ndash;' . $era->end_year?></h1>
			<h2><?php echo $era->post_title?></h2>
			<ul>
				<li><a href="#"><i class="icon-right-circle"></i>Read about the Progressive Era</a></li>
				<li><a href="#"><i class="icon-right-circle"></i>Access the Timeline</a></li>
				<li><a href="#"><i class="icon-right-circle"></i>Mapping the Settlement Houses</a></li>
				<li><a href="#"><i class="icon-right-circle"></i>Life in New York Slums: the Gordon Story</a></li>
			</ul>
		</div>
	</div>
	<?php }?>
</div>

<?php 
get_footer();