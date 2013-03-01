<?php
$body_class = 'timeline';
get_header();

//get category info
$policy = false;
foreach ($policies as $p) if ($p->slug == $_SERVER['QUERY_STRING']) $policy = $p;

if (!$policy) {
	header('Location: /');
	exit;
}
?>

<div id="timeline">
	<ul>
		<li class="overview">
			<div class="upper">
				<h2><?php echo $policy->name?></h2>
			</div>
			<div class="lower">
				Stumptown chambray readymade, ullamco eu +1 mustache bushwick shoreditch. Street art williamsburg dolor cliche mollit. Church-key laboris est craft beer. 
				<br><br>
				Culpa shoreditch twee, pork belly cillum brooklyn consectetur wes anderson delectus vegan leggings. Veniam sunt keffiyeh, trust fund bicycle rights ethical in scenester gluten-free. Aliquip semiotics est, ethical beard 8-bit consectetur odio deep v tumblr. 
				<br><br>
				Odio tattooed polaroid cray viral. Hoodie literally pug try-hard farm-to-table vice, adipisicing blue bottle proident. 
			</div>
		</li>
		<li class="early_ny">
			<div class="upper">
				<a class="thumbnail"><img src="<?php bloginfo('template_directory');?>/img/placeholder/great-migration-circle.png" alt="great-migration-circle" width="125" height="125"></a>
				<h3>1730</h3>
			</div>
			<div class="lower">
				<p>
					<a href="#">National Committee on Care of Transient and Homeless</a><br>
					Hoodie literally pug try-hard farm-to-table vice, adipisicing blue bottle proident.
				</p>	
			</div>
		</li>
		<li class="nineteenth">
			<div class="upper">
				<a class="thumbnail"><img src="<?php bloginfo('template_directory');?>/img/placeholder/great-migration-circle.png" alt="great-migration-circle" width="125" height="125"></a>
				<h3>1890</h3>
			</div>
			<div class="lower">
				<p>
					<a href="#">National Committee on Care of Transient and Homeless</a><br>
					Hoodie literally pug try-hard farm-to-table vice, adipisicing blue bottle proident.
				</p>	
			</div>
		</li>
		<li class="progressive">
			<div class="upper">
				<a class="thumbnail"><img src="<?php bloginfo('template_directory');?>/img/placeholder/great-migration-circle.png" alt="great-migration-circle" width="125" height="125"></a>
				<h3>1900</h3>
			</div>
			<div class="lower">
				<p>
					<a href="#">National Committee on Care of Transient and Homeless</a><br>
					Hoodie literally pug try-hard farm-to-table vice, adipisicing blue bottle proident.
				</p>	
			</div>
		</li>
		<li class="progressive">
			<div class="upper">
				<a class="thumbnail"><img src="<?php bloginfo('template_directory');?>/img/placeholder/great-migration-circle.png" alt="great-migration-circle" width="125" height="125"></a>
				<h3>1910</h3>
			</div>
			<div class="lower">
				<p>
					<a href="#">National Committee on Care of Transient and Homeless</a><br>
					Hoodie literally pug try-hard farm-to-table vice, adipisicing blue bottle proident.
				</p>	
			</div>
		</li>
		<li class="progressive">
			<div class="upper">
				<a class="thumbnail"><img src="<?php bloginfo('template_directory');?>/img/placeholder/great-migration-circle.png" alt="great-migration-circle" width="125" height="125"></a>
				<h3>1910</h3>
			</div>
			<div class="lower">
				<p>
					<a href="#">National Committee on Care of Transient and Homeless</a><br>
					Hoodie literally pug try-hard farm-to-table vice, adipisicing blue bottle proident.
				</p>	
			</div>
		</li>
	</ul>
	
	<div class="arrow left"></div>
	<div class="arrow right"></div>
</div>
<?php
echo icph_slider();

get_footer();
?>