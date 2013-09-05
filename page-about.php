<?php
//era landing pages & about page
get_header();

if (have_posts()) while (have_posts()) the_post();
?>

<div id="era" class="about">

	<div class="row story intro">
		<div class="inner">
			<h1>The Project</h1>
			<p><?php the_excerpt() ?></p>
		</div>
	</div>
	
	<div class="row">
		<div class="inner">

			<?php the_content() ?>

		</div>
	</div>
		
</div>

<?php 
get_footer();