<?php
//blog page
get_header();
?>
<div class="timeline_mask">
	<ul id="timeline">
	<?php foreach ($eras as $e) {?>
		
		<li id="<?php echo $e['slug']?>" class="<?php echo $e['slug']?> overview">
			<div class="upper">
				<h1><?php echo $e['start_year']?>&dash;<?php echo $e['end_year']?></h1>
				<h2><?php echo $e['name']?></h2>
			</div>
			<div class="lower">
				<p>Urbanization, immigration, and industrialization transformed New York City's economy between 1890 and 1920, making poverty more prevalent among the working class while at the same time creating enormous wealth for some.</p>
				<p>Efforts to alleviate the effects of poverty among working-class and poor families through direct action and government reform become known as "progressivism."</p>
				<p>The sights, sounds, and smells of the poorer districts in New York City in the 1890s made evident the effects of mass urbanization, immigration, and industrialization.</p>
			</div>
		</li>
		<li class="<?php echo $e['slug']?> featured">
			<div class="upper"></div>
			<div class="lower">
				<a href="#gordon-family"><img src="<?php bloginfo('template_directory');?>/img/placeholder/gordon-family-s.jpg" alt="gordon-family-s" width="283" height="169" /></a>
				<p><a href="">March 12, 1907</a> — West 28th St.<br>Storm water poured from the ceiling of the basement apartment and down its plaster walls, soaking the family’s meager bed, dresser, and table before coming to rest in deep, dirty puddles on the floor.  Maria Gordon’s family—her nine-year-old niece, Edith, and six month-old foster child, Perry—had nowhere to sleep, and the workspace where Maria laundered clothes for her clients was unusable.</p>
			</div>
		</li>
		<?php 
		$years = get_categories(array('parent'=>$e['category_id'], 'hide_empty'=>false));
		foreach ($years as $y) {?>
		<li class="<?php echo $e['slug']?>">
			<div class="upper">
				<img src="<?php bloginfo('template_directory');?>/img/placeholder/great-migration-circle.png" alt="great-migration-circle" width="125" height="125" />
				<h3><?php echo $y->name?></h3>
			</div>
			<div class="lower">
				<?php
				$posts = get_posts('category=' . $y->term_id);
				foreach ($posts as $p) {
					$excerpt = (empty($p->post_excerpt)) ? $p->post_title : $p->post_excerpt;
					$excerpt = str_replace($p->post_title, '<a href="#' . $p->post_name . '">' . $p->post_title . '</a>', $excerpt);
					echo '<p>' . $excerpt . '</p>';
				}
				?>
			</div>
		</li>
		<?php }
	}?>
	</ul>
	
	<?php 
	//eras slider	
	foreach ($eras as &$e) $e = array('class'=>$e['slug'], 'content'=>$e['start_year'] . '<span>' . $e['name'] . '</span>');
	echo icph_ul($eras, array('id'=>'slider'));
		
	//policies slider
	$policies = get_categories(array('parent'=>21, 'hide_empty'=>false));
	foreach ($policies as &$p) $p = array('link'=>'/policies/' . $p->slug . '/', 'content'=>$p->name);
	array_unshift($policies, array('content'=>'View by Policy'));
	echo icph_ul($policies, array('id'=>'slider_policy'));
	?>
</div>

<?php

get_footer();