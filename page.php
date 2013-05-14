<?php
//era landing pages & about page
get_header();

if (!$era = icph_get_era(false, $post->post_name)) die('era not found'); //need some better failure mechanism

$related = get_related_links('post', $era->ID);
if (isset($related[0])) $overview = get_post($related[0]['id']);
if (isset($related[1])) $featured = get_post($related[1]['id']);
?>

<div id="era" class="<?php echo $era->post_name?>">

	<div class="row header">
		<div class="inner">
			<h1><?php echo $era->start_year?>&ndash;<?php echo $era->end_year?></h1>
			<h2><?php echo $era->post_title?></h2>
			<p><?php echo nl2br($overview->post_excerpt)?></p>
			<a class="left" href="#<?php echo $overview->post_name?>">Continue</a>
			<a class="right" href="/">Browse the Timeline</a>
		</div>
	</div>
	
	<div class="row feature_policies">
		<div class="inner">
			<div class="column left feature">
				<h3><a href="#<?php echo $featured->post_name?>"><?php echo $featured->post_title?></a></h3>
				<?php 
				if (has_post_thumbnail($featured->ID)) {
					echo '<a href="#' . $featured->post_name . '">' . get_the_post_thumbnail($featured->ID, 'thumbnail') . '</a>';
				}
				?>				
				<p><?php echo $featured->post_excerpt?></p>
				<a class="more" href="#<?php echo $featured->post_name?>"><i class="icon-play-circled"></i> Meet the <?php echo $featured->post_title?></a>
			</div>
			<div class="column right policies">
				<h3>Policy in this Time Period</h3>
				<ul class="scroll-pane">
					<?php 
					$policy_posts = array();
					foreach ($policies as $policy) {
						if ($posts = get_posts(array('category'=>$policy->term_id, 'numberposts'=>-1, 'meta_key'=>'era', 'meta_value'=>$era->ID))) {
							if (count($posts) >= 3) $policy_posts[] = array('name'=>$policy->name, 'description'=>$policy->description, 'posts'=>array_slice($posts, 0, 3));
							echo '<li class="heading">' . $policy->name . '</li>';
							foreach ($posts as $post) {
								echo '<li><a href="#' . $post->post_name . '">' . $post->post_title . '</a></li>';
							}
						}
					} ?>
				</ul>
			</div>
		</div>
	</div>
	
	<a class="row map" href="/maps/">
		<div class="inner">
			<h3>Where Were The Settlement Houses?</h3>
			<span class="more">Explore the Map</span>
		</div>
	</a>
	
	<?php
	if (count($policy_posts) >= 2) {
		if (count($policy_posts) > 2) $policy_posts = array_slice($policy_posts, 0, 2);
	?>
	<div class="row topics">
		<div class="inner">
			<?php 
			foreach ($policy_posts as $policy) {
				foreach ($policy['posts'] as &$post) {
					$post = array('content'=>icph_thumbnail($post->ID, $post->post_title, $post->post_name) . '
						<a href="#' . $post->post_name . '" class="text">' . $post->post_title . '</a>');
				}
			?>
			<div class="column">
				<h3><?php echo $policy['name']?></h3>
				<p><?php echo nl2br($policy['description'])?></p>
				<?php echo icph_ul($policy['posts'])?>
			</div>
			<?php }?>
		</div>
	</div>
	<?php }?>
	<div class="row infographics">
		<div class="inner">
			<h3>By the Numbers</h3>
			<div class="infographic_scroller">
				<ul>
					<li class="text">In 1900, two-thirds of New Yorkers lived in tenement houses.</li>
					<li><img src="<?php bloginfo('template_directory');?>/img/eras/progressive/infographics/tenements.png" alt="Tenement" width="237" height="171"></li>
					<li class="text">In 1900, 30.6% of New Yorkers were 14. Only 2.8% were over 65.<cite>(Jackson)</cite></li>
					<li><img src="<?php bloginfo('template_directory');?>/img/eras/progressive/infographics/age.png" alt="Age" width="174" height="172"></li>
					<li class="text">In 1918, low-income families of four spent an average of 45% of their income on food.<cite>(BLS)</cite></li>
					<li><img src="<?php bloginfo('template_directory');?>/img/eras/progressive/infographics/money.png" alt="Money" width="201" height="130"></li>
					<li class="text">In 1914, a dozen eggs cost 50 cents&ndash;$11.36 in today's dollars.<cite>(BLS)</cite></li>
					<li><img src="<?php bloginfo('template_directory');?>/img/eras/progressive/infographics/eggs.png" alt="Eggs" width="181" height="86"></li>
					<li class="text">In 1885, 27 out of 100 infants died before their first birthday.  By 1914, 9 out of 100 died&ndash;a 65% decrease.<cite>(Meyer)</cite></li>
					<li><img src="<?php bloginfo('template_directory');?>/img/eras/progressive/infographics/infants.png" alt="Infants" width="325" height="107"></li>
					<li class="text">In 1900, only 6 in 10 school-aged children in New York were enrolled in school.  By 1920, 9 out of every 10 school age children were registered for school.</li>
					<li><img src="<?php bloginfo('template_directory');?>/img/eras/progressive/infographics/education.png" alt="Education" width="271" height="126"></li>
					<li class="text">If you lived in a tenement you shared a toilet with about 7 people.  Often the bathroom was outside.</li>
					<li><img src="<?php bloginfo('template_directory');?>/img/eras/progressive/infographics/toilet.png" alt="Toilet" width="358" height="166"></li>
					<li class="text">Between 1890 and 1920 the population of NYC increased 124%.<cite>Encyclopedia of New York City</cite></li>
					<li><img src="<?php bloginfo('template_directory');?>/img/eras/progressive/infographics/population.png" alt="Population" width="228" height="162"></li>
					<li class="text">In 1910, 4 out of every 10 New Yorkers were born in another country.</li>
					<li><img src="<?php bloginfo('template_directory');?>/img/eras/progressive/infographics/migration.png" alt="Migration" width="315" height="127"></li>
				</ul>
			</div>
		</div>
		<a class="arrow left"><div class="cap"><i class="icon-left-open-big"></i></div></a>
		<a class="arrow right"><div class="cap"><i class="icon-right-open-big"></i></div></a>
	</div>
	
</div>

<?php 
get_footer();