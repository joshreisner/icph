<?php

//global variables
$thumbnail_diameter = 125;
$overview_tag_id	= 24;
$featured_tag_id	= 19;
$policies			= get_categories('parent=21&hide_empty=0');

//era variable currently has too much information to come from wordpress
//$eras = get_categories('parent=20&hide_empty=0'));
$eras				= array(
	array(
		'category_id'=>2,
		'slug'=>'early_ny',
		'start_year'=>1650,
		'end_year'=>1830,
		'name'=>'Early New York',
		'title'=>'Family Poverty in Early New York',
		'url'=>'/eras/early-new-york-city/'
	),
	array(
		'category_id'=>1,
		'slug'=>'nineteenth',
		'start_year'=>1830,
		'end_year'=>1890,
		'name'=>'19th Century',
		'title'=>'Homelessness in the Nineteenth Century',
		'url'=>'/eras/19th-century/'
	),
	array(
		'category_id'=>3,
		'slug'=>'progressive',
		'start_year'=>1890,
		'end_year'=>1920,
		'name'=>'The Progressive Era',
		'title'=>'Homelessness in the Progressive Era',
		'url'=>'/eras/the-progressive-era/'
	),
	array(
		'category_id'=>35,
		'slug'=>'great_depression',
		'start_year'=>1929,
		'end_year'=>1944,
		'name'=>'The Great Depression',
		'title'=>'Family Crises in the Great Depression',
		'url'=>'/eras/the-great-depression/'
	),
	array(
		'category_id'=>4,
		'slug'=>'today',
		'start_year'=>1945,
		'end_year'=>'Today',
		'name'=>'Today',
		'title'=>'Origins of the New Urban Poverty',
		'url'=>'/eras/new-urban-poverty'
	)
);


//setup images and custom sizes
add_theme_support('post-thumbnails'); 
set_post_thumbnail_size($thumbnail_diameter, $thumbnail_diameter); //wonder if there's a way to set medium to 226/0 and large to 640/0
add_image_size('era-landing', 160, 229); //for the era landing page
add_image_size('extra-large', 880, 880); //for the view image overlay page

//setup browse as an ajax function
add_action('wp_ajax_browse', 'icph_browse');
add_action('wp_ajax_nopriv_browse', 'icph_browse');
function icph_browse($type='Subject') {
	global $eras;
	
	$parent_id = (isset($_POST['type']) && ($_POST['type'] == 'policy')) ? 21 : 22;
	$categories = get_categories('parent=' . $parent_id);

	foreach ($categories as $category) {?>
		
	<div class="row">
		<h3<?php if ($category->name == $categories[0]->name) {?> class="first"<?php }?>><i class="icon-plus-sign"></i> <?php echo $category->name?></h3>
		<ul>
			<?php 
			$posts = get_posts('category=' . $category->term_id);
			foreach ($posts as $post) {
				if (!$era = icph_get_era($post->ID)) $era = array('name'=>'', 'slug'=>'');
			?>
			<li class="<?php echo $era['slug']?>">
				<?php echo icph_thumbnail($post->ID, $post->post_title, $post->post_name)?>
				<div>
					<h4><?php echo $era['name']?></h4>
					<a href="#<?php echo $post->post_name?>"><?php echo $post->post_title?></a>
					<?php echo icph_excerpt($post->post_excerpt)?>
				</div>
			</li>
			<?php }?>
		</ul>
	</div>
	
	<?php }

	if (isset($_POST['type'])) die(); //end output here on ajax requests
}

//set up years a custom post type
add_action('init', function() {
	$labels = array(
		'name'               => _x( 'Timeline Years', 'post type general name' ),
		'singular_name'      => _x( 'Year', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'book' ),
		'add_new_item'       => __( 'Add New Year to the Timeline' ),
		'edit_item'          => __( 'Edit Year' ),
		'new_item'           => __( 'New Year' ),
		'all_items'          => __( 'All Years' ),
		'view_item'          => __( 'View Year' ),
		'search_items'       => __( 'Search Years' ),
		'not_found'          => __( 'No years found' ),
		'not_found_in_trash' => __( 'No years found in the Trash' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'Timeline Years'
	);
	$args = array(
		'labels'        => $labels,
		'description'   => 'Years for the timeline',
		'public'        => true,
		'menu_position' => 5,
		'supports'      => array('title', 'editor'),
		'taxonomies'	=> array('category'),
		'has_archive'   => false,
	);
	register_post_type('years', $args);
});

function icph_excerpt($str, $limit=100, $append='&hellip;') {
	$words = explode(' ', strip_tags($str));
	$str = '';
	$counter = 0;
	foreach ($words as $word) {
		if (empty($word)) continue;
		$counter += mb_strlen($word) + 1;
		if ($counter > $limit) return trim($str) . $append;
		$str .= $word . ' ';
	}
	return trim($str);
}

function icph_get_era($post_id) {
	global $eras;
	//get post's era -- probably will replace this with multiple eras?
	$categories = wp_get_post_categories($post_id);
	foreach ($categories as $category_id) {
		foreach ($eras as $era) {
			if ($category_id == $era['category_id']) return $era;
		}
	}
	return false;
}

function icph_slider() {
	global $eras, $policies;
	
	//eras slider	
	foreach ($eras as &$era) $era = array('class'=>$era['slug'], 'content'=>$era['start_year'] . '<span>' . $era['name'] . '</span>');
		
	//policies slider
	foreach ($policies as &$policy) $policy = array('link'=>'/policies/?' . $policy->slug, 'content'=>$policy->name);
	array_unshift($policies, array('content'=>'<i class="icon-plus-sign"></i> View by Policy'));
	
	return '<div id="slider_policy_wrapper">' . icph_ul($eras, array('id'=>'slider')) . icph_ul($policies, array('id'=>'slider_policy')) . '</div>';
}

function icph_thumbnail($post_id, $title=false, $slug=false) {
	if (!$title) $title = get_the_title($post_id);
	if (!$slug) {
		$post = get_post($post_id);
		$slug = $post->post_name;
	}
	return '
		<a class="thumbnail" href="#' . $slug . '">
				<span>
					<i class="icon-play-circle"></i><br>
					Read about<br>
					' . $title . 
				'</span>' . 
			(has_post_thumbnail($post_id) ? get_the_post_thumbnail($post_id, 'thumbnail') : '') . 
		'</a>';
}

function icph_ul($elements, $arguments=array()) {
	//universal lightweight method for outputting UL lists with first and last classes on LI elements
	$count = count($elements);
	$counter = 1;
	foreach ($elements as &$e) {
		$e['class'] = empty($e['class']) ? array() : explode(' ', $e['class']);
		if ($counter == 1) $e['class'][] = 'first';
		if ($counter == $count) $e['class'][] = 'last';
		$e['content'] = empty($e['link']) ? $e['content'] : '<a href="' . $e['link'] . '">' . $e['content'] . '</a>';
		$e = '<li class="' . implode(' ', array_unique($e['class'])) . '">' . $e['content'] . '</li>';
		$counter++;
	}
	
	$return = '<ul'; //assemble output
	foreach ($arguments as $key=>$value) $return .= ' ' . $key . '="' . $value . '"';
	return $return . '>' . implode('', $elements) . '</ul>';
}

//custom styles for tinymce
add_filter('mce_css', 'icph_editor_style');  
function icph_editor_style($url) {  
	if (!empty($url)) $url .= ',';  
	$url .= get_bloginfo('template_directory') . '/css/editor.css';  
	//die($url);
	return $url;  
}  

//remove existing styleselect
add_filter('mce_buttons_2', 'icph_editor_buttons');
function icph_editor_buttons($buttons) {  
	array_unshift($buttons, 'styleselect');  
	return $buttons;  
}  
  
//i think
add_filter('tiny_mce_before_init', 'icph_edtor_init');  
function icph_edtor_init($settings) {  
    $settings['style_formats'] = json_encode(
    	array(  
	        array(  
	            'title' => 'Statistic',  
	            'block' => 'div',  
	            'classes' => 'statistic',  
	            'wrapper' => true  
	        ),  
	        array(  
	            'title' => 'Big',  
	            'block' => 'div',  
	            'classes' => 'big',  
	            'wrapper' => true  
	        ),  
	    )
    );
	return $settings;  
}