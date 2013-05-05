<?php
if (empty($_GET['overlay'])) {
	//not an overlay, forward to overlay page
	header('Location: /#' . str_replace('/', '', $_SERVER['REQUEST_URI']));
	exit;
}

the_post();

$era_id = get_post_meta($post->post_parent, 'era', true); //does get_post_meta cache?  if so i could make this a one-liner
foreach ($eras as $era) if ($era->ID == $era_id) break;

list($url, $width, $height) = wp_get_attachment_image_src($post->ID, 'extra-large');

$orientation = ($width > $height) ? 'landscape' : 'portrait';

?>
<div id="overlay" class="image <?php echo $era->post_name?>">
	<div class="header">
		<h1><?php echo $post->post_title?></h1>
		<a href="<?php echo icph_post($post->post_parent)?>" class="close"><span>Back to Article</span> <i class="icon-cancel-circled"></i></a>
	</div>
	
	<div class="body">
		<img src="<?php echo $url?>" width="<?php echo $width?>" height="<?php echo $height?>" class="<?php echo $orientation?>">
		
		<?php if (!empty($post->post_content)) {?>
			<div class="transcript">
				<h2>Transcript</h2>
				<?php the_content()?>
			</div>
		<?php }?>
	</div>
</div>

<?php
//prev and next
$nav_array = array();

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