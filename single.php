<?php
//no header or footer

if (empty($_GET['overlay'])) {
	//not an overlay, forward to overlay page
	$link = $_SERVER['REQUEST_URI'];
	if (substr($link, 0, 1) == '/') $link = substr($link, 1);
	header('Location: /#' . $link);
	exit;
}

the_post();

$era_id = get_post_meta($post->ID, 'era', true); //does get_post_meta cache?  if so i could make this a one-liner
foreach ($eras as $era) if ($era->ID == $era_id) break;

?>

<div id="overlay" class="<?php echo $era->post_name?>">
	<div class="header">
		<h1><?php echo $post->post_title?></h1>
		<a href="#" class="close"><span>Close</span> <i class="icon-cancel-circled"></i></a>
	</div>
	
	<div class="body">
		<div class="content">
			<?php if (has_post_thumbnail()) {
				$featured = get_post(get_post_thumbnail_id($post->ID));
				$images = get_posts('post_type=attachment&post_status=any&post_mime_type=image&orderby=menu_order&order=ASC&post_parent=' . $post->ID . '&exclude=' . $featured->ID);
				?>
				<a class="featured_image" href="<?php echo icph_img($images[0]->ID)?>">
					<?php echo get_the_post_thumbnail($post->ID, 'large')?>
					<?php if (!empty($featured->post_excerpt)) {?><div class="caption"><?php echo $featured->post_excerpt?></div><?php }?>
					<i class="icon-zoom-in"></i>
				</a>
			<?php }?>

			<div class="inner">
				<?php echo icph_links(apply_filters('the_content', get_the_content()))?>
				
				<?php if ($related_links = get_related_links()) {?>
				<div class="related">
					<h3>Related Articles</h3>
					<?php
					foreach ($related_links as &$link) {
						$link['content'] = icph_thumbnail($link['id'], $link['title']) . $link['title'];
					}
					echo icph_ul($related_links);
					?>
				</div>
				<?php } ?>
			</div>
			
		</div>
		<div class="navigation">
			<?php
			//trim leading "the " off of article name to prevent "the progressive era articles"
			$article_era = $era->post_title . ' Articles';
			if (substr($article_era, 0, 4) == 'The ') $article_era = substr($article_era, 4);
			?>
			<h3><?php echo $article_era?></h3>
			<div class="scroll-pane">
				<ul id="articles">
				<?php
				$nav_array = $era_posts = array(); //for getting previous and next
				$exclude = array();
				$featured = get_related_links('post', $era->ID);
				foreach ($featured as &$feature) {
					$exclude[] = $feature['id'];
					$feature = get_post($feature['id']);
				}
				$posts = array_merge($featured, get_posts('orderby=title&order=asc&numberposts=-1&exclude=' . implode(',', $exclude) . '&meta_key=era&meta_value=' . $era->ID));
				foreach ($posts as $p) {
					$era_posts[] = $p->ID;
					$nav_array[$p->post_name] = $p->post_title; //for prev and next
					?>
				<li>
					<a href="#<?php echo $p->post_name?>"<?php if ($p->post_name == $post->post_name) {?> class="active"<?php }?>>
						<?php echo $p->post_title?>
					</a>
				</li>
				<?php }?>
				</ul>
			</div>
		</div>
	</div>
</div>

<?php
//prev and next
$prev = $next = $last = false;
foreach ($nav_array as $key=>$value) {
	if ($key == $post->post_name) {
		$prev = $last;
	} elseif ($prev) {
		$next = array('slug'=>$key, 'title'=>$value); 
		break;
	} else {
		$last = array('slug'=>$key, 'title'=>$value); 
	}
}

//special catch for first element
if (!$prev && !$next && count($nav_array > 1)) {
	$nav_keys = array_keys($nav_array);
	$next = array('slug'=>$nav_keys[1], 'title'=>$nav_array[$nav_keys[1]]);
}
?>

<div id="overlay_backdrop">
	<?php if ($prev) {?>
	<a class="arrow left" href="#<?php echo $prev['slug']?>">
		<div class="stem"><?php echo $prev['title']?></div>
		<div class="cap"><i class="icon-left-open-big"></i></div>
	</a>
	<?php }
	if ($next) {?>
	<a class="arrow right" href="#<?php echo $next['slug']?>">
		<div class="cap"><i class="icon-right-open-big"></i></div>
		<div class="stem"><?php echo $next['title']?></div>
	</a>
	<?php }?>
</div>