<?php

//global variables
$policies			= get_categories('parent=21&hide_empty=0');
$eras				= get_posts(array('post_status'=>'publish', 'post_type'=>'era', 'meta_key'=>'start_year', 'orderby'=>'meta_value_num', 'order'=>'ASC'));

//era options for select and other places
$era_options = array();
$era_count = count($eras);
for ($i = 0; $i < $era_count; $i++) {
	//todo test if i can get all this meta in one shot
	$eras[$i]->start_year		= get_post_meta($eras[$i]->ID, 'start_year', true);
	$eras[$i]->description 		= get_post_meta($eras[$i]->ID, 'description', true);
	$eras[$i]->map_link			= get_post_meta($eras[$i]->ID, 'map_link', true);
	$eras[$i]->url 				= '/era/' . $eras[$i]->post_name;
	$era_options[$eras[$i]->ID] = $eras[$i]->post_title;
}

//special code to loop through again and determine the era's end_year
for ($i = 0; $i < $era_count; $i++) {
	$eras[$i]->end_year = (isset($eras[$i + 1])) ? $eras[$i + 1]->start_year - 1 : 'Today';
}

$custom_fields = array(
	'infographic'=>array(
		'era'=>array(
			'type'		=>'select',
			'title'		=>'Era',
			'options'	=>$era_options,
		),
	),
	'year'=>array(
		'era'=>array(
			'type'		=>'select',
			'title'		=>'Era',
			'options'	=>$era_options,
		),
	),
	'post'=>array(
		'era'=>array(
			'type'		=>'select',
			'title'		=>'Era',
			'options'	=>$era_options,
			'nullable'	=>true,
		),
	),
	'map_point'=>array(
		'era'=>array(
			'type'		=>'select',
			'title'		=>'Era',
			'options'	=>$era_options,
		),
	),
	'era'=>array(
		'start_year'=>array(
			'type'		=>'input',
			'title'		=>'Start Year',
		),
		'description'=>array(
			'type'		=>'input',
			'title'		=>'Description',
		),
		'map_title'=>array(
			'type'		=>'input',
			'title'		=>'Map Title',
		),
		'map_title_short'=>array(
			'type'		=>'input',
			'title'		=>'Short Title',
		),
		'map_description'=>array(
			'type'		=>'textarea',
			'title'		=>'Map Text',
		),
		'map_link'=>array(
			'type'		=>'input',
			'title'		=>'Map Link',
		),
	)
);


//set up images and custom sizes
add_theme_support('post-thumbnails'); 

update_option('thumbnail_size_w', 226);
update_option('thumbnail_size_h', 0);
update_option('thumbnail_crop', 0);

//wp medium size not used
update_option('medium_size_w', 226);
update_option('medium_size_h', 0);
update_option('medium_crop', 0);

//wp large size used for article overlay
update_option('large_size_w', 640);
update_option('large_size_h', 0);
update_option('large_crop', 0);

//additional sizes
add_image_size('circle', 125, 125, 1); //the little circles
add_image_size('inline', 160); //for the era landing page or map point insert
add_image_size('featured', 226, 120, 1); //for the featured story in the main timeline
add_image_size('xl', 920); //for the view image overlay page

add_filter('pre_option_link_manager_enabled', '__return_true');

add_filter('image_size_names_choose', function ($sizes) {
	//they should only be inserting thumbnails
	foreach ($sizes as $key=>$value) return array($key=>$value);
});

//register custom post types
add_action('init', function() {

	add_post_type_support('page', 'excerpt');

	register_post_type('era', array(
		'labels'        => array(
			'name'               => _x( 'Eras', 'post type general name' ),
			'singular_name'      => _x( 'Era', 'post type singular name' ),
			'add_new'            => _x( 'Add New', 'book' ),
			'add_new_item'       => __( 'Add Era' ),
			'edit_item'          => __( 'Edit Era' ),
			'new_item'           => __( 'New Era' ),
			'all_items'          => __( 'All Eras' ),
			'view_item'          => __( 'View Era' ),
			'search_items'       => __( 'Search Eras' ),
			'not_found'          => __( 'No eras found' ),
			'not_found_in_trash' => __( 'No eras found in the Trash' ), 
			'parent_item_colon'  => '',
			'menu_name'          => 'Eras'
		),
	    'description'   => 'Eras',
		'public'        => true,
		'menu_position' => 4,
      'capability_type' => 'page',
		'supports'      => array('title'),
		'has_archive'   => true,
	));
	
	flush_rewrite_rules();

	register_post_type('year', array(
		'labels'        => array(
			'name'               => _x( 'Years', 'post type general name' ),
			'singular_name'      => _x( 'Year', 'post type singular name' ),
			'add_new'            => _x( 'Add New', 'book' ),
			'add_new_item'       => __( 'Add Year to a Timeline' ),
			'edit_item'          => __( 'Edit Year' ),
			'new_item'           => __( 'New Year' ),
			'all_items'          => __( 'All Years' ),
			'view_item'          => __( 'View Year' ),
			'search_items'       => __( 'Search Years' ),
			'not_found'          => __( 'No years found' ),
			'not_found_in_trash' => __( 'No years found in the Trash' ), 
			'parent_item_colon'  => '',
			'menu_name'          => 'Years'
		),
		'description'   => 'Years for the main timeline',
		'public'        => true,
		'menu_position' => 5,
		'supports'      => array('title', 'editor'),
		'taxonomies'	=> array('category'),
		'has_archive'   => false,
	));
		
	register_post_type('map_point', array(
		'labels'        => array(
			'name'               => _x( 'Map Points', 'post type general name' ),
			'singular_name'      => _x( 'Map Point', 'post type singular name' ),
			'add_new'            => _x( 'Add New', 'book' ),
			'add_new_item'       => __( 'Add Map Point' ),
			'edit_item'          => __( 'Edit Map Point' ),
			'new_item'           => __( 'New Map Point' ),
			'all_items'          => __( 'All Map Points' ),
			'view_item'          => __( 'View Map Point' ),
			'search_items'       => __( 'Search Map Points' ),
			'not_found'          => __( 'No map points found' ),
			'not_found_in_trash' => __( 'No map points found in the Trash' ), 
			'parent_item_colon'  => '',
			'menu_name'          => 'Map Points'
		),
		'description'   => 'Map Points',
		'public'        => true,
		'menu_position' => 5,
		'supports'      => array('title', 'editor'),
		'has_archive'   => false,
	));
		
	register_post_type('infographic', array(
		'labels'        => array(
			'name'               => _x( 'Infographics', 'post type general name' ),
			'singular_name'      => _x( 'Infographic', 'post type singular name' ),
			'add_new'            => _x( 'Add New', 'book' ),
			'add_new_item'       => __( 'Add Infographic' ),
			'edit_item'          => __( 'Edit Infographic' ),
			'new_item'           => __( 'New Infographic' ),
			'all_items'          => __( 'All Infographics' ),
			'view_item'          => __( 'View Infographic' ),
			'search_items'       => __( 'Search Infographic' ),
			'not_found'          => __( 'No infographics found' ),
			'not_found_in_trash' => __( 'No infographics found in the Trash' ), 
			'parent_item_colon'  => '',
			'menu_name'          => 'Infographics'
		),
		'description'   => 'Infographics',
		'public'        => true,
		'menu_position' => 5,
		'supports'      => array('title', 'excerpt'),
		'has_archive'   => false,
	));
});

//home and contact page link carousel
add_shortcode('insights', function(){
	$links = get_bookmarks('orderby=link_id&order=desc');
	foreach ($links as &$link) {
		$link = '<a href="' . $link->link_url . '" target="_blank">' . $link->link_name . '</a>';
	}

	return '
	<div id="home_insights">
		<div class="title">What\'s New From ICPH</div>
		<div>
			<div class="arrow left"><a href="#"><i class="icon-left-open-big"></i></a></div>
			<div class="insight">' . implode($links) . '</div>
			<div class="arrow right"><a href="#"><i class="icon-right-open-big"></i></a></div>
		</div>
	</div>';
});

//browse as an ajax function
add_action('wp_ajax_browse', 'icph_browse');
add_action('wp_ajax_nopriv_browse', 'icph_browse');
function icph_browse($type='subject') {
	global $eras;

	if (isset($_POST['type'])) $type = $_POST['type'];

	if (in_array($type, array('images', 'documents'))) {
	
		//get array to exclude all featured images
		$featured_images = array();
		$posts = get_posts();
		foreach ($posts as $post) {
			$image = get_post_thumbnail_id($post->ID);
			$featured_images[] = $image->ID;
		}
		
		//get images
		$images = get_posts('numberposts=-1&post_type=attachment&post_status=any&post_mime_type=image&orderby=title&order=ASC&exclude=' . implode(',', $featured_images));
		
		echo '<div class="row"><ul style="display:block;">';
		foreach ($images as $image) {
			$document = get_post_meta($image->ID, 'document', true);
			if ((($type == 'documents') && !$document) || (($type == 'images') && $document)) continue;

			$hide_from_browse = get_post_meta($image->ID, 'hide_from_browse', true);
			if ($hide_from_browse) continue;

			$era = icph_get_era(get_post_meta($image->post_parent, 'era', true));
			
			list($src, $width, $height) = wp_get_attachment_image_src($image->ID, 'circle');
			$post = get_post($image->post_parent);
			?>
				<li class="<?php echo $era->post_name?>">
					<a class="thumbnail" href="#<?php echo $post->post_name?>/<?php echo $image->post_name?>">
						<span>
							<i class="icon-play-circled"></i><br>
							<?php echo $post->post_title?>
						</span>
						<img src="<?php echo $src?>" width="<?php echo $width?>" height="<?php echo $height?>" border="0">
					</a>
					<div>
						<h4><?php echo $era->title?></h4>
						<a href="#<?php echo $image->post_name?>"><?php echo $image->post_title?></a>
						<?php echo icph_excerpt($image->post_excerpt)?>
					</div>
				</li>
			<?php
		}
		echo '</ul></div>';
		
	} else {
		$parent_id = ($type == 'policy') ? 21 : 22;
		$categories = get_categories('parent=' . $parent_id);
	
		foreach ($categories as $category) {?>
			
		<div class="row">
			<h3<?php if ($category->name == $categories[0]->name) {?> class="first"<?php }?>><i class="icon-plus-circled"></i> <?php echo $category->name?></h3>
			<ul>
				<?php 
				$posts = get_posts('category=' . $category->term_id);
				foreach ($posts as $post) {
					$era = icph_get_era(get_post_meta($post->ID, 'era', true));
				?>
				<li class="<?php echo $era->post_name?>">
					<?php echo icph_thumbnail($post->ID, $post->post_title, $post->post_name)?>
					<div>
						<h4><?php echo $era->title?></h4>
						<a href="#<?php echo $post->post_name?>"><?php echo $post->post_title?></a>
						<?php echo icph_excerpt($post->post_excerpt)?>
					</div>
				</li>
				<?php }?>
			</ul>
		</div>
		
		<?php }
	}
	
	if (isset($_POST['type'])) die(); //end output here on ajax requests
}

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

function icph_get_era($era_id=false, $era_slug=false) {
	global $eras;
	foreach ($eras as $era) {
		if ($era_id && ($era->ID == $era_id)) return $era;
		if ($era_slug && ($era->post_name == $era_slug)) return $era;
	}
	return false;
}

function icph_get_policy($policy_id=false, $policy_slug=false) {
	global $policies;
	foreach ($policies as $policy) {
		if ($policy_id && ($policy_id == $policy->term_id)) return $policy;
		if ($policy_slug && ($policy_slug == $policy->slug)) return $policy;
	}
	return false;
}

function icph_img($image_id) {
	return str_replace(site_url('/'), '#', get_permalink($image_id));
}

function icph_post($post_id) {
	return str_replace(site_url('/'), '#', get_permalink($post_id));
}

function icph_slider($policy_active=false) {
	global $eras, $policies;
	
	//eras slider	
	$slider_eras = $eras; //need to preserve the eras variable now that the header is in footer.php
	foreach ($slider_eras as &$era) $era = array('class'=>$era->post_name, 'content'=>$era->start_year . '<span>' . $era->post_title . '</span>');

	//policies slider
	foreach ($policies as &$policy) {
		$policy = array(
			'link'=>'#' . $policy->slug, 
			'content'=>$policy->name
		);
	}
	array_unshift($policies, array('content'=>'Filter by policy'));
	array_push($policies, array('content'=>'View complete timeline', 'link'=>'#'));
	
	return '<div id="slider_policy_wrapper">' . icph_ul($slider_eras, array('id'=>'slider')) . icph_ul($policies, array('id'=>'slider_policy', 'class'=>($policy_active ? 'active' : false))) . '</div>';
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
					<i class="icon-play-circled"></i><br>
					' . $title . 
				'</span>' . 
			(has_post_thumbnail($post_id) ? get_the_post_thumbnail($post_id, 'circle') : '') . 
		'</a>';
}

add_action('wp_ajax_timeline', 'icph_timeline');
add_action('wp_ajax_nopriv_timeline', 'icph_timeline');
function icph_timeline($category_id=false) {
	global $eras, $policies;

	$description = '';

	//if showing main timeline (no cat), specifically exclude all cats
	if (empty($category_id)) {
		if (!empty($_POST['category'])) {
			foreach ($policies as $policy) {
				if ($policy->slug == $_POST['category']) {
					$category_id = $policy->term_id;
					$description = '
					<div class="policy_description">
						<h2>' . $policy->name . '</h2>
						<a class="close"><i class="icon-cancel-circled"></i></a>
						<div class="description"><div>' . nl2p($policy->description) . '</div></div>
					</div>';
				}
			}
		} else {
			$category_id = array();
			foreach ($policies as $policy) $category_id[] = '-' . $policy->term_id;
			$category_id = implode(',', $category_id);		
		}
	}

	$li_items = array();

	foreach ($eras as $era) {
		//era overview & featured
		if (empty($_POST['category'])) {
			$featured = get_related_links('post', $era->ID);
			$overview = array_shift($featured);
			$overview = get_post($overview['id']);

			//era overview
			$li_items[] = '
				<li id="' . $era->post_name . '" class="' . $era->post_name . ' overview">
					<div class="upper">
						<h1>' . $era->start_year . '&ndash;' . $era->end_year . '</h1>
						<h2>' . $era->post_title . '</h2>
					</div>
					<div class="lower">
						' . nl2br($overview->post_excerpt) . '
						<a href="#' . $overview->post_name . '" class="more"><i class="icon-play-circled"></i> <span>Continue</span></a>
					</div>
				</li>';

			//featured stories
			if (count($featured)) {
				$feature = array_shift($featured);
				$post = get_post($feature['id']);
				$li_items[] = '
					<li class="' . $era->post_name . ' featured">
						<div class="upper"></div>
						<div class="lower">' . 
							((has_post_thumbnail($post->ID)) ? 
								'<a href="#' . $post->post_name . '">' . get_the_post_thumbnail($post->ID, 'featured') . '</a>' :
								'') . 
							$post->post_excerpt . 
							'<a href="#' . $post->post_name . '" class="more"><i class="icon-play-circled"></i> <span>' . $post->post_title . '</span></a>
						</div>
					</li>';
			}
		}

		//loop through years
		$years = get_posts('post_type=year&numberposts=-1&category=' . $category_id . '&orderby=title&order=ASC&meta_key=era&meta_value=' . $era->ID);
		foreach ($years as $year) {
			$content = apply_filters('the_content', $year->post_content);

			//fix links
			$content = str_replace('href="#', 'href="', $content);
			$content = str_replace('href="' . site_url('/'), 'href="', $content);
			$content = str_replace('href="', 'href="#', $content);

			$li_items[] = '
				<li class="' . $era->post_name . '">
					<div class="upper">' . 
						(($related_links = get_related_links('post', $year->ID)) ?
							icph_thumbnail($related_links[0]['id'], $related_links[0]['title']) :
							'') . '
						<h3>' . $year->post_title . '</h3>
					</div>
					<div class="lower">' . $content . '</div>
				</li>';
		}
	}

	//send output
	echo '
	<div id="timeline">
		<ul>' . implode($li_items) . '</ul>
		<a class="arrow left"><div class="cap"><i class="icon-left-open-big"></i></div></a>
		<a class="arrow right"><div class="cap"><i class="icon-right-open-big"></i></div></a>
		' . $description . '
	</div>';

	//end output here on ajax requests
	if (isset($_POST['type'])) die(); 
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

//from http://stackoverflow.com/questions/7409512/new-line-to-paragraph-function
function nl2p($string, $line_breaks = false, $xml = false) {

	$string = str_replace(array('<p>', '</p>', '<br>', '<br />'), '', $string);

	// It is conceivable that people might still want single line-breaks
	// without breaking into a new paragraph.
	if ($line_breaks == true)
	    return '<p>'.preg_replace(array("/([\n]{2,})/i", "/([^>])\n([^<])/i"), array("</p>\n<p>", '$1<br'.($xml == true ? ' /' : '').'>$2'), trim($string)).'</p>';
	else 
	    return '<p>'.preg_replace(
	    array("/([\n]{2,})/i", "/([\r\n]{3,})/i","/([^>])\n([^<])/i"),
	    array("</p>\n<p>", "</p>\n<p>", '$1<br'.($xml == true ? ' /' : '').'>$2'),

	    trim($string)).'</p>'; 
}

//custom stylesheet for tinymce
add_filter('mce_css', function($url) {  
	if (!empty($url)) $url .= ',';  
	return $url . get_bloginfo('template_directory') . '/css/editor.css';
});

//remove existing styleselect
add_filter('mce_buttons_2', function($buttons) {  
	array_unshift($buttons, 'styleselect');  
	return $buttons;  
});
  
//add custom styles
add_filter('tiny_mce_before_init', function($settings) {  
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
});

//fixing wordpress "feature" of putting checked categories on top
add_filter('wp_terms_checklist_args', function($args) {
	$args['checked_ontop'] = false;
	return $args;
});

//attach custom field forms to post types
add_action('admin_menu', function(){
	global $custom_fields;
	foreach ($custom_fields as $post_type=>$fields) {
		add_meta_box('icph-custom-fields-' . $post_type, 'Custom Metadata', function($post, $metabox){
			global $custom_fields;
			foreach ($custom_fields[$metabox['args']['post_type']] as $name=>$features) {
				if (!isset($features['default'])) $features['default'] = '';
				
				echo '<div style="margin:10px 0;"><input type="hidden" name="' . $name . '_noncename" value="' . wp_create_nonce('icph') . '">';
				
				if ($features['type'] == 'input' )  { 
					$value = get_post_meta($post->ID, $name, true);
					if (empty($value)) $value = $features['default'];
					echo '<input type="text" name="'. $name .'" id="'. $name .'"  value="' . $value . '">';
				} elseif ($features['type'] ==  'select' ) {
					$selected = get_post_meta($post->ID, $name, true);
					if (empty($selected)) $selected = $features['default'];
					echo '<select name="' . $name . '" id="' . $name . '">';
					if (isset($features['nullable'])) echo '<option></option>';
					foreach ($features['options'] as $key=>$value) {
						echo '<option value="' . $key . '"';
						if ($key == $selected) echo ' selected="selected"';
						echo '>' . $value . '</option>';
					}
					echo '</select>';
				} elseif ($features['type'] ==  'grouped_select' ) {
					$selected = get_post_meta($post->ID, $name, true);
					$last_group = '';
					$optgroup = false;
					if (!empty($selected)) $selected = $features['default'];
					echo '<select name="' . $name . '" id="' . $name . '">';
					foreach ($features['options'] as $option) {
						if ($option['group'] != $last_group) {
							if ($optgroup) echo '</optgroup>';
							echo '<optgroup label="' . $option['group'] . '">';
							$optgroup = true;
							$last_group = $option['group'];
						}
						echo '<option value="' . $option['value'] . '"';
						if ($option['value'] == $selected) echo ' selected="selected"';
						echo '>' . $option['title'] . '</option>';
					}
					if ($optgroup) echo '</optgroup>';
					echo '</select>';
				} elseif ($features['type'] == 'checkbox') {
					echo '<input type="checkbox" name="' . $name . '" id="' . $name . '"';
					//checked
					echo '>';
				} elseif ($features['type'] == 'textarea') {
					$value = get_post_meta($post->ID, $name, true);
					echo '<textarea style="width:170px; height:100px;" name="' . $name . '" id="' . $name . '">' . $value . '</textarea>';
				}
				
				echo '<label for="' . $name . '" style="font-size: 12px; margin-left: 5px;">' . $features['title'] . '</label></div>';
			}
		}, $post_type, 'side', 'high', array('post_type'=>$post_type));
	}
});

//save custom custom fields to post
add_action('save_post', function($post_id) {
	global $post, $custom_fields;

	if (empty($post->post_type)) $post->post_type = @$_GET['post_type'];
	if (!isset($custom_fields[$post->post_type])) return;

	foreach($custom_fields[$post->post_type] as $name=>$features) {  
		if (!wp_verify_nonce($_POST[$name . '_noncename'], 'icph')) return $post_id;  
		
		$_POST[$name] = trim($_POST[$name]);
		if (get_post_meta($post_id, $name) == "") {
			add_post_meta($post_id, $name, $_POST[$name], true);  
		} elseif ($_POST[$name] != get_post_meta($post_id, $name, true)) {
			update_post_meta($post_id, $name, $_POST[$name]);
		} elseif ($_POST[$name] ==  "") {
			delete_post_meta($post_id, $name, get_post_meta($post_id, $name, true));
		}
	}
});

//customize admin screens for various post types
add_filter('manage_post_posts_columns', function($defaults) {
    return array(
    	'cb'=>'<input type="checkbox">',
    	'title'=>'Title',
    	'era'=>'Era',
    	'date'=>'Date',
    );
});  

add_filter('manage_infographic_posts_columns', function($defaults) {
    return array(
    	'cb'=>'<input type="checkbox">',
    	'title'=>'Title',
    	'era'=>'Era',
    	'date'=>'Date',
    );
});  

add_filter('manage_map_point_posts_columns', function($defaults) {
    return array(
    	'cb'=>'<input type="checkbox">',
    	'title'=>'Title',
    	'era'=>'Era',
    	'date'=>'Date',
    );
});  

add_filter('manage_year_posts_columns', function($defaults) {
    return array(
    	'cb'=>'<input type="checkbox">',
    	'title'=>'Title',
    	'era'=>'Era',
    	'categories'=>'Categories',
    	'date'=>'Date',
    );
});  

add_action('manage_posts_custom_column', function($column_name, $post_ID) {
	global $era_options; 
    if ($column_name == 'era') echo @$era_options[get_post_meta($post_ID, 'era', true)];
}, 10, 2);

add_filter('pre_get_posts', function($wp_query) {
	if (isset($wp_query->query['post_type'])) {
		if ($wp_query->query['post_type'] == 'era') {
			$wp_query->set('meta_key', 'start_year');
			$wp_query->set('orderby', 'meta_value');
			$wp_query->set('order', 'ASC');
		} elseif ($wp_query->query['post_type'] == 'infographic') {
			$wp_query->set('meta_key', 'era');
			$wp_query->set('orderby', 'meta_value');
			$wp_query->set('order', 'ASC');
		} elseif ($wp_query->query['post_type'] == 'year') {
			$wp_query->set('orderby', 'title');
			$wp_query->set('order', 'ASC');
		}
	}
});


//adding custom document and hide_from_browse checkboxes to the attachment
add_filter('attachment_fields_to_edit', function($form_fields, $post) {
    $document = (bool) get_post_meta($post->ID, 'document', true);
	$form_fields['document'] = array(
		'label' => 'Document',
		'input' => 'html',
	    'html' => '<label for="attachments-'.$post->ID.'-document"><input type="checkbox" style="margin-top:7px;" id="attachments-' . $post->ID . '-document" name="attachments[' . $post->ID . '][document]"' . ($document ? ' checked="checked"' : '') . '></label>',
		'value' => $document,
		'helps' => '',
	);
    $hide_from_browse = (bool) get_post_meta($post->ID, 'hide_from_browse', true);
	$form_fields['hide_from_browse'] = array(
		'label' => 'Hide Browse',
		'input' => 'html',
	    'html' => '<label for="attachments-'.$post->ID.'-hide_from_browse"><input type="checkbox" style="margin-top:7px;" id="attachments-' . $post->ID . '-hide_from_browse" name="attachments[' . $post->ID . '][hide_from_browse]"' . ($hide_from_browse ? ' checked="checked"' : '') . '></label>',
		'value' => $hide_from_browse,
		'helps' => '',
	);
	return $form_fields;
}, 10, 2);

add_filter('attachment_fields_to_save', function($post, $attachment) {
    update_post_meta($post['ID'], 'document', (($attachment['document'] == 'on') ? '1' : '0'));  
    update_post_meta($post['ID'], 'hide_from_browse', (($attachment['hide_from_browse'] == 'on') ? '1' : '0'));  
    return $post;  
}, null, 2 );


//fix attachment image margins
add_filter('img_caption_shortcode', function($current_html, $attr, $content) {
	extract(shortcode_atts(array('id'=>'', 'align'=>'alignnone', 'width'=>'', 'caption'=>''), $attr));
	if (1 > (int) $width || empty($caption)) return $content;
	if ($id) $id = 'id="' . esc_attr($id) . '" ';
	return '<div ' . $id . 'class="wp-caption ' . esc_attr($align) . '" style="width: ' . ((int) $width) . 'px">' . do_shortcode( $content ) . '<p class="wp-caption-text">' . $caption . '</p></div>';
}, 10, 3 );
