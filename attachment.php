<?php
if (empty($_GET['overlay'])) {
	//not an overlay, forward to overlay page
	header('Location: /#' . str_replace('/', '', $_SERVER['REQUEST_URI']));
	exit;
}

the_post();

//get era information
$era_id = get_post_meta($post->post_parent, 'era', true); //does get_post_meta cache?  if so i could make this a one-liner
foreach ($eras as $era) if ($era->ID == $era_id) break;

//get image properties
list($url, $width, $height) = wp_get_attachment_image_src($post->ID, 'large');
list($full_url, $full_width, $full_height) = wp_get_attachment_image_src($post->ID, 'full');
$orientation = ($width > $height) ? 'landscape' : 'portrait';

//download link?
$download = $wpdb->get_var($wpdb->prepare("SELECT guid FROM $wpdb->posts WHERE post_parent = %d AND post_title = %s AND post_mime_type = 'application/pdf' AND post_type='attachment'", $post->post_parent, $post->post_title));

?>
<div id="overlay" class="image <?php echo $era->post_name?>">
	<div class="header">
		<h1><?php echo $post->post_title?></h1>
		<a href="<?php echo icph_post($post->post_parent)?>" class="close"><span>Back to Article</span> <i class="icon-cancel-circled"></i></a>
		<div class="attachment">
			<?php if ($download) {?>
			<a href="<?php echo $download?>">Download as .PDF</a>
			<?php }
			if (!empty($post->post_content)) {?>
			<a class="transcript">Transcript</a>
			<?php }?>
			<a class="mag"><i class="icon-zoom-in"></i> Magnifying Glass On</a>
		</div>
	</div>
	
	<div class="body">
		<img src="<?php echo $url?>" width="<?php echo $width?>" height="<?php echo $height?>" class="<?php echo $orientation?>" id="zoomable" data-full="<?php echo $full_url?>">
		
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
$parent = get_post($post->post_parent);
$siblings = get_posts('post_type=attachment&post_status=any&post_mime_type=image&post_parent=' . $post->post_parent);
foreach ($siblings as $sibling) {
	$nav_array[$parent->post_name . '/' . $sibling->post_name] = $sibling->post_title; //for prev and next
}

$prev = $next = $last = false;
foreach ($nav_array as $key=>$value) {
	if ($key == $parent->post_name . '/' . $post->post_name) {
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