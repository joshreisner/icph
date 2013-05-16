<?php
//browse page
get_header();

?>

<div id="browse">
	<div class="header">
		Browse by
		<?php
		$type = (isset($_GET['type'])) ? $_GET['type'] : 'subject';
		$types = array('Subject', 'Policy', 'Images', 'Documents');
		foreach ($types as $t) {
			echo '<a href="#"' . (($type == strtolower($t)) ? ' class="active"' : '') . '">' . $t . '</a>';
		}
		?>
	</div>
	<div class="content"><?php icph_browse($_GET['type'])?></div>
</div>

<?php
get_footer();