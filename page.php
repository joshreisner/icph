<?php
//era landing pages & about page
get_header();

if (!$era = icph_get_era(false, $post->post_name)) die('era not found'); //need some better failure mechanism

if ($feature = get_related_links('post', $era->ID)) $feature = get_post($feature[0]['id']);
?>

<div id="era" class="<?php echo $era->post_name?>">

	<div class="row header">
		<div class="inner">
			<h1><?php echo $era->start_year?>&ndash;<?php echo $era->end_year?></h1>
			<h2><?php echo $era->post_title?></h2>
			<p><?php echo nl2br($era->post_excerpt)?></p>
			<a class="left" href="#<?php echo $overview->post_name?>">Continue Era Introduction</a>
			<a class="right" href="/">Browse the Timeline</a>
		</div>
	</div>
	
	<div class="row feature_policies">
		<div class="inner">
			<div class="column left feature">
				<h3><a href="#<?php echo $feature->post_name?>"><?php echo $feature->post_title?></a></h3>
				<?php 
				if (has_post_thumbnail($feature->ID)) {
					echo '<a href="#' . $feature->post_name . '">' . get_the_post_thumbnail($feature->ID, 'era-landing') . '</a>';
				}
				?>				
				<p><?php echo $feature->post_excerpt?></p>
				<a class="more" href="#<?php echo $feature->post_name?>"><i class="icon-circle"></i> <?php echo $feature->post_title?></a>
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
	<div class="row stats">
		<div class="inner">
			<h3>By the Numbers</h3>
			<ul>
				<li>
					<div class="stat">2/3 of New York City's population live in tenements</div>
					<div class="img"><img src="<?php bloginfo('template_directory');?>/img/placeholder/stat1.png" alt="stat1" width="160" height="120" /></div>
				</li>
				<li class="center">
					<div class="stat">Total number of child workers in the United States in 1900: 1.7 million</div>
					<div class="img"><img src="<?php bloginfo('template_directory');?>/img/placeholder/stat2.png" alt="stat1" width="188" height="120" /></div>
				</li>
				<li>
					<div class="stat">National economic output increased by 85%</div>
					<div class="img"><img src="<?php bloginfo('template_directory');?>/img/placeholder/stat3.png" alt="stat1" width="60" height="120" /></div>
				</li>
			</ul>
		</div>
	</div>
	
</div>

<?php 
get_footer();