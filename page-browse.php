<?php
//maps page
get_header();

?>

<div id="browse">
	<div class="header">
		Browse by
		<a href="#" class="active">Subject</a>
		<a href="#">Policy</a>
		<a href="#">Documents</a>
		<a href="#">Images</a>
	</div>
	
	<?php
	$rows = array('Almshouses', 'African American', 'Children', 'The Economy', 'Homelessness', 'Labor', 'Low-Income Housing', 'People', 'Philanthropy', 'Settlement Houses', 'Urban Decline');
	foreach ($rows as $row) {?>
		
	<div class="row">
		<h3<?php if ($row == $rows[0]) {?> class="first"<?php }?>><?php echo $row?></h3>
		<ul>
			<?php for ($i = 0; $i < 5; $i++) {?>
			<li>
				<img src="<?php bloginfo('template_directory');?>/img/placeholder/great-migration-circle.png" alt="great-migration-circle" width="150" height="150" />
				<div>
					<h4 class="progressive">1890&dash;1920 The Progressive Era</h4>
					<a href="#">Depression of 1893</a>
					<p>The Depression of 1893 caused widespread unemployment and poverty in New York &hellip;</p>
				</div>
			</li>
			<?php }?>
		</ul>
	</div>
	
	<?php }?>
</div>

<?php
get_footer();
?>