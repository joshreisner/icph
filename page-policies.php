<?php
$body_class = 'timeline';
get_header();

//get current policy
if (!$policy = icph_get_policy(false, $_SERVER['QUERY_STRING'])) {
	header('Location: /');
	exit;
}

//get overview and end piece
$front = $end = '';
//if ($posts = get_posts('category=' . $policy->term_id . '&tag_id=' . $overview_tag_id)) {
	//list($front, $end) = explode('<!--more-->', nl2br($posts[0]->post_content));
//}
?>

<div id="timeline">
	<ul>
		<li class="overview">
			<div class="upper">
				<h2><?php echo $policy->name?></h2>
			</div>
			<div class="lower">
				<?php echo $policy->description?>
			</div>
		</li>
		<?php
		foreach ($eras as $era) {
			$years = get_posts('type=policy_year&category=' . $policy->term_id);
			foreach ($years as $year) {
				if ($posts = get_posts(array('category__and'=>array($year->term_id, $policy->term_id), 'numberposts'=>-1))) {?>
					<li class="<?php echo $era['slug']?>">
						<div class="upper">
							<?php echo icph_thumbnail($posts[0]->ID, $posts[0]->post_title, $posts[0]->post_name)?>
							<h3><?php echo $year->name?></h3>
						</div>
						<div class="lower">
							<?php
							foreach ($posts as $post) {
								echo '<p><a href="#' . $post->post_name . '">' . $post->post_title . '</a><br>' . $post->post_excerpt . '</p>';
							}
							?>
						</div>
					</li>
					<?php 
				}
			}
		}
		?>
		<li class="end">
			<div class="upper">
				<h2>Today</h2>
			</div>
			<div class="lower">
				<?php echo $end?>
			</div>
		</li>
	</ul>
	
	<div class="arrow left"></div>
	<div class="arrow right"></div>
</div>
<?php
echo icph_slider();

get_footer();