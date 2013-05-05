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
		<a href="#" class="close"><span>Close</span> <i class="icon-cancel-circled"></i></a>
	</div>
	
	<div class="body">
		<div class="content">
			<?php 
			if (has_post_thumbnail()) {
				echo '<a class="featured_image" href="' . icph_img(get_post_thumbnail_id($post->ID)) . '" title="' . the_title_attribute('echo=0') . '" >';
				echo get_the_post_thumbnail($post->ID, 'large');
				echo '<i class="icon-plus-circled"></i></a>';
			}
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
			<h3>
				<a class="articles active">Articles</a>
				<a class="imagery">Imagery</a>
				<a class="documents">Documents</a>
			</h3>
			<div class="scroll-pane">
				<ul>
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
				<li>
					<a href="#<?php echo $p->post_name?>"<?php if ($p->post_name == $post->post_name) {?> class="active"<?php }?>>
						<?php echo $p->post_title?>
					</a>
				</li>
				<?php }?>
				</ul>
				
				<h4>Era Imagery<a href="/browse/?type=imagery">View All</a></h4>
				
				<h4>Era Documents<a href="/browse/?type=documents">View All</a></h4>
				
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