<?php
//era landing pages & about page
get_header();

$era		= icph_get_era(false, $post->post_name);
$related	= get_related_links('post', $era->ID);
$overview	= array_shift($related);
$overview	= get_post($overview['id']);
$featured	= array_shift($related);
$featured	= get_post($featured['id']);
?>

<div id="era" class="<?php echo $era->post_name?>">

	<div class="row story intro">
		<div class="inner">
			<h1><?php echo $era->start_year?>&ndash;<?php echo $era->end_year?></h1>
			<h2><?php echo $era->post_title?></h2>
			<p><?php echo nl2br($overview->post_excerpt)?></p>
			<div class="more">
				<a href="#<?php echo $overview->post_name?>"><i class="icon-right-circle"></i> Continue Reading the Introduction</a>
				<a href="/timeline#<?php echo $era->post_name?>"><i class="icon-right-circle"></i> Explore Articles on the Timeline</a>
			</div>
		</div>
	</div>
	
	<div class="row infographics">
		<div class="inner">
			<div class="infographic_scroller">
				<ul>
				<?php
				$infographics = get_posts('post_type=infographic&numberposts=-1&orderby=rand&meta_key=era&meta_value=' . $era->ID);
				foreach ($infographics as $infographic) {
					$image = '/img/eras/' . $era->post_name . '/infographics/' . $infographic->post_name . '.png';
					if (file_exists(TEMPLATEPATH . $image)) {
						$sizes = getimagesize(TEMPLATEPATH . $image);
						echo '
						<li>
							<div class="text">' . $infographic->post_excerpt . '</div>
							<div><img src="' . get_bloginfo('template_directory') . $image . '" width="' . $sizes[0] . '" height="' . $sizes[1] . '" alt="' . $infographic->post_title . '"></div>
						</li>';
					}
				}
				?>
				</ul>
			</div>
		</div>
		<a class="arrow left"><div class="cap"><i class="icon-left-open-big"></i></div></a>
		<a class="arrow right"><div class="cap"><i class="icon-right-open-big"></i></div></a>
	</div>

	<div class="row story">
		<div class="inner">
			<h2><a href="#<?php echo $featured->post_name?>"><?php echo $featured->post_title?></a></h2>
			<p><?php echo $featured->post_excerpt?></p>
			<div class="more">
				<a href="#<?php echo $featured->post_name?>"><i class="icon-right-circle"></i> Continue Reading</a>
			</div>
		</div>
	</div>
	
	<div class="row map">
		<div class="inner">
			<h3><?php echo $era->map_link?></h3>
			<p><?php echo nl2br(get_post_meta($era->ID, 'map_description', true))?></p>
			<a class="more" href="/maps#<?php echo $era->post_name?>"><i class="icon-right-circle"></i> Explore the Map</a>
		</div>
	</div>

	<div class="row featured">
		<div class="inner">
			<h3>Featured Articles</h3>
			<?php 
			if (count($related) > 5) $related = array_slice($related, 0, 5);
			foreach ($related as &$story) {
				$story['content'] = icph_thumbnail($story['id'], $story['title']) . $story['title'];
			}
			echo icph_ul($related);
			?>
		</div>
	</div>
	
</div>

<?php 
get_footer();