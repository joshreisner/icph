<?php
//maps page
get_header();

?>

<div id="browse">
	<div class="header">
		Browse by
		<a href="#" class="active">Subject</a>
		<a href="#">Policy</a>
		<!--
		<a href="#">Documents</a>
		<a href="#">Images</a>
		-->
	</div>
	<div class="content"><?php icph_browse()?></div>
</div>

<?php
get_footer();