<?php
//no header or footer

if (empty($_GET['overlay'])) {
	//not an overlay, forward to overlay page
	header('Location: /#' . str_replace('/', '', $_SERVER['REQUEST_URI']));
	exit;
}

the_post();

$era_id = get_post_meta($post->ID, 'era', true); //does get_post_meta cache?  if so i could make this a one-liner
foreach ($eras as $era) if ($era->ID == $era_id) break;

?>

<div id="overlay" class="<?php echo $era->post_name?>">
	<div class="header">
		<h1><?php echo $post->post_title?></h1>
		<a href="#" class="close">Close <i class="icon-remove-circle icon-large"></i></a>
		<h3>Articles</h3>
	</div>
	
	<div class="body">
		<div class="content">
			<!-- <img src="<?php bloginfo('template_directory');?>/img/placeholder/gordon-family-m2.jpg" alt="gordon-family-m2" width="640" height="282" /> -->
			<?php 
			if (has_post_thumbnail()) echo '<div class="featured_image">'. get_the_post_thumbnail($post->ID, 'large') . '</div>';
			?>

			<div class="inner">
				<?php the_content()?>
				
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
			<ul class="scroll-pane">
				<?php
				$nav_array = array(); //for getting previous and next
				$exclude = array();
				$featured = get_related_links('post', $era->ID);
				foreach ($featured as &$feature) {
					$exclude[] = $feature['id'];
					$feature = get_post($feature['id']);
				}
				$posts = array_merge($featured, get_posts('numberposts=-1&exclude=' . implode(',', $exclude) . '&meta_key=era&meta_value=' . $era->ID));
				foreach ($posts as $p) {
					$nav_array[$p->post_name] = $p->post_title; //for prev and next
					?>
				<li<?php if ($p->post_name == $post->post_name) {?> class="active"<?php }?>>
					<a href="#<?php echo $p->post_name?>">
						<strong><?php echo $p->post_title?></strong>
						<!-- <?php echo $p->post_excerpt?> -->
					</a>
				</li>
				<?php }?>
			</ul>
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
		<div class="cap"><i class="icon-angle-left"></i></div>
	</a>
	<?php }
	if ($next) {?>
	<a class="arrow right" href="#<?php echo $next['slug']?>">
		<div class="cap"><i class="icon-angle-right"></i></div>
		<div class="stem"><?php echo $next['title']?></div>
	</a>
	<?php }?>
</div>