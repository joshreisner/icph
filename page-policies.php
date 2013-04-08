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
	<ul class="policy">
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
			$years = get_posts('post_type=policy_year&numberposts=-1&orderby=title&order=ASC&meta_key=era&meta_value=' . $era->ID . '&category=' . $policy->term_id);
			foreach ($years as $year) {?>
		<li class="<?php echo $era->post_name?>">
			<div class="upper">
				<?php if ($related_links = get_related_links('post', $year->ID)) {
					echo icph_thumbnail($related_links[0]['id'], $related_links[0]['title']);
				}?>
				<h3><?php echo $year->post_title?></h3>
			</div>
			<div class="lower">
				<?php echo str_replace(site_url('/'), '#', apply_filters('the_content', $year->post_content))?>
			</div>
		</li>
		<?php 
			}
		}
		?>
		<li class="end">
			<div class="upper">
				<h2>Now</h2>
			</div>
			<div class="lower">
				<?php echo $end?>
			</div>
		</li>
	</ul>
	
	<a class="arrow left"><div class="cap"><i class="icon-angle-left"></i></div></a>
	<a class="arrow right"><div class="cap"><i class="icon-angle-right"></i></div></a>
</div>
<?php
echo icph_slider();

get_footer();