<?php

//global variables
$thumbnail_diameter = 125;
$policies			= get_categories('parent=21&hide_empty=0');
$eras				= get_posts(array('post_status'=>'publish', 'post_type'=>'era', 'meta_key'=>'start_year', 'orderby'=>'meta_value_num', 'order'=>'ASC'));

//era options for select and other places
$era_options = array();
$progressive_id = false;
$era_count = count($eras);
for ($i = 0; $i < $era_count; $i++) {
	$eras[$i]->start_year = get_post_meta($eras[$i]->ID, 'start_year', true);
	$eras[$i]->description = get_post_meta($eras[$i]->ID, 'description', true);
	$era_options[$eras[$i]->ID] = $eras[$i]->post_title;
	if ($eras[$i]->post_name == 'progressive') $progressive_id = $eras[$i]->ID;
}

//special code to loop through again and determine the era's end_year
for ($i = 0; $i < $era_count; $i++) {
	$eras[$i]->end_year = (isset($eras[$i + 1])) ? $eras[$i + 1]->start_year - 1 : 'Today';
}

//die(var_dump($era_options));

$custom_fields = array(
	'timeline_year'=>array(
		'era'=>array(
			'type'		=>'select',
			'title'		=>'Era',
			'options'	=>$era_options,
		),
	),
	'policy_year'=>array(
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
	)
);

//set up images and custom sizes
add_theme_support('post-thumbnails'); 
set_post_thumbnail_size($thumbnail_diameter, $thumbnail_diameter); //wonder if there's a way to set medium to 226/0 and large to 640/0
add_image_size('era-landing', 160, 229); //for the era landing page
add_image_size('extra-large', 880, 880); //for the view image overlay page

//register custom post types
add_action('init', function() {
	register_post_type('timeline_year', array(
		'labels'        => array(
			'name'               => _x( 'Timeline Years', 'post type general name' ),
			'singular_name'      => _x( 'Timeline Year', 'post type singular name' ),
			'add_new'            => _x( 'Add New', 'book' ),
			'add_new_item'       => __( 'Add Year to the Timeline' ),
			'edit_item'          => __( 'Edit Year' ),
			'new_item'           => __( 'New Year' ),
			'all_items'          => __( 'All Years' ),
			'view_item'          => __( 'View Year' ),
			'search_items'       => __( 'Search Years' ),
			'not_found'          => __( 'No timeline years found' ),
			'not_found_in_trash' => __( 'No timeline years found in the Trash' ), 
			'parent_item_colon'  => '',
			'menu_name'          => 'Timeline Years'
		),
		'description'   => 'Years for the main timeline',
		'public'        => true,
		'menu_position' => 5,
		'supports'      => array('title', 'editor'),
		'has_archive'   => false,
	));
	
	register_post_type('policy_year', array(
		'labels'        => array(
			'name'               => _x( 'Policy Years', 'post type general name' ),
			'singular_name'      => _x( 'Policy Year', 'post type singular name' ),
			'add_new'            => _x( 'Add New', 'book' ),
			'add_new_item'       => __( 'Add a Year to a Policy Timeline' ),
			'edit_item'          => __( 'Edit Year' ),
			'new_item'           => __( 'New Year' ),
			'all_items'          => __( 'All Years' ),
			'view_item'          => __( 'View Year' ),
			'search_items'       => __( 'Search Years' ),
			'not_found'          => __( 'No policy years found' ),
			'not_found_in_trash' => __( 'No policy years found in the Trash' ), 
			'parent_item_colon'  => '',
			'menu_name'          => 'Policy Years'
		),
		'description'   => 'Years for the policy timelines',
		'public'        => true,
		'menu_position' => 6,
		'supports'      => array('title', 'editor'),
		'taxonomies'	=> array('category'),
		'has_archive'   => false,
	));
	
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
		'menu_position' => 5,
		'supports'      => array('title', 'editor', 'excerpt'),
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
});

//browse as an ajax function
add_action('wp_ajax_browse', 'icph_browse');
add_action('wp_ajax_nopriv_browse', 'icph_browse');
function icph_browse($type='Subject') {
	global $eras;
	
	$parent_id = (isset($_POST['type']) && ($_POST['type'] == 'policy')) ? 21 : 22;
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

function icph_slider() {
	global $eras, $policies;
	
	//eras slider	
	foreach ($eras as &$era) $era = array('class'=>$era->post_name, 'content'=>$era->start_year . '<span>' . $era->post_title . '</span>');
		
	//policies slider
	foreach ($policies as &$policy) $policy = array('link'=>'/policies/?' . $policy->slug, 'content'=>$policy->name);
	array_unshift($policies, array('content'=>'<i class="icon-plus-circled"></i> View by Policy'));
	
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
					<i class="icon-play-circled"></i><br>
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

function icph_img($image_id) {
	return str_replace(site_url('/'), '#', get_permalink($image_id));
}

function icph_post($post_id) {
	return str_replace(site_url('/'), '#', get_permalink($post_id));
}

//custom stylesheet for tinymce
add_filter('mce_css', 'icph_editor_style');  
function icph_editor_style($url) {  
	if (!empty($url)) $url .= ',';  
	return $url . get_bloginfo('template_directory') . '/css/editor.css';
}  

//remove existing styleselect
add_filter('mce_buttons_2', 'icph_editor_buttons');
function icph_editor_buttons($buttons) {  
	array_unshift($buttons, 'styleselect');  
	return $buttons;  
}  
  
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
add_filter('wp_terms_checklist_args', 'icph_checklist_args');
function icph_checklist_args($args) {
	$args['checked_ontop'] = false;
	return $args;
}

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

	if (empty($post->post_type)) $post->post_type = $_GET['post_type'];
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

add_filter('manage_map_point_posts_columns', function($defaults) {
    return array(
    	'cb'=>'<input type="checkbox">',
    	'title'=>'Title',
    	'era'=>'Era',
    	'date'=>'Date',
    );
});  

add_filter('manage_policy_year_posts_columns', function($defaults) {
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
	if ($wp_query->query['post_type'] == 'era') {
		$wp_query->set('meta_key', 'start_year');
		$wp_query->set('orderby', 'meta_value');
		$wp_query->set('order', 'ASC');
	} elseif ($wp_query->query['post_type'] == 'timeline_year') {
		$wp_query->set('orderby', 'title');
		$wp_query->set('order', 'ASC');
	} elseif ($wp_query->query['post_type'] == 'policy_year') {
		$wp_query->set('orderby', 'title');
		$wp_query->set('order', 'ASC');
	}
});


//adding custom document checkbox to the attachment
add_filter('attachment_fields_to_edit', function($form_fields, $post) {
    $document = (bool) get_post_meta($post->ID, 'document', true);
	$form_fields['document'] = array(
		'label' => 'Document',
		'input' => 'html',
	    'html' => '<label for="attachments-'.$post->ID.'-document"><input type="checkbox" id="attachments-' . $post->ID . '-document" name="attachments[' . $post->ID . '][document]"' . ($document ? ' checked="checked"' : '') . '></label>',
		'value' => $document,
		'helps' => '',
	);
	return $form_fields;
}, 10, 2);

add_filter('attachment_fields_to_save', function($post, $attachment) {
    update_post_meta($post['ID'], 'document', (($attachment['document'] == 'on') ? '1' : '0'));  
    return $post;  
}, null, 2 );


//fix attachment image margins
add_filter('img_caption_shortcode', function($current_html, $attr, $content) {
	extract(shortcode_atts(array('id'=>'', 'align'=>'alignnone', 'width'=>'', 'caption'=>''), $attr));
	if (1 > (int) $width || empty($caption)) return $content;
	if ($id) $id = 'id="' . esc_attr($id) . '" ';
	return '<div ' . $id . 'class="wp-caption ' . esc_attr($align) . '" style="width: ' . ((int) $width) . 'px">' . do_shortcode( $content ) . '<p class="wp-caption-text">' . $caption . '</p></div>';
}, 10, 3 );
