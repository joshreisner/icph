<?php

//global variables
$thumbnail_diameter = 125;
$policies			= get_categories('parent=21&hide_empty=0');
$eras				= get_posts(array('post_status'=>'publish', 'post_type'=>'era', 'meta_key'=>'start_year', 'orderby'=>'meta_value_num', 'order'=>'ASC'));

//era options for select and other places
$era_options = array();
$progressive_id = false;
foreach ($eras as &$era) {
	$era->start_year = get_post_meta($era->ID, 'start_year', true);
	$era_options[$era->ID] = $era->post_title;
	if ($era->post_name == 'progressive') $progressive_id = $era->ID;
}

//special code to loop through again and determine the era's end_year
$era_count = count($eras);
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
	'post'=>array(
		'era'=>array(
			'type'		=>'select',
			'title'		=>'Era',
			'options'	=>$era_options,
			'nullable'	=>true,
		),
	),
	'era'=>array(
		'start_year'=>array(
			'type'		=>'input',
			'title'		=>'Start Year',
		)
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
			'add_new_item'       => __( 'Add Year to the Policies Timelines' ),
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
		<h3<?php if ($category->name == $categories[0]->name) {?> class="first"<?php }?>><i class="icon-plus-sign"></i> <?php echo $category->name?></h3>
		<ul>
			<?php 
			$posts = get_posts('category=' . $category->term_id);
			foreach ($posts as $post) {
			?>
			<li class="<?php echo get_post_meta($post->ID, 'era', true)?>">
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

function icph_slider() {
	global $eras, $policies;
	
	//eras slider	
	foreach ($eras as &$era) $era = array('class'=>$era->post_name, 'content'=>$era->start_year . '<span>' . $era->post_title . '</span>');
		
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
					$meta_box_value = get_post_meta($post->ID, $name, true);
					if (empty($meta_box_value)) $value = $features['default'];
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
		
		if (get_post_meta($post_id, $name) == "") {
			add_post_meta($post_id, $name, $_POST[$name], true);  
		} elseif ($_POST[$name] != get_post_meta($post_id, $name, true)) {
			update_post_meta($post_id, $name, $_POST[$name]);
		} elseif ($_POST[$name] ==  "") {
			delete_post_meta($post_id, $name, get_post_meta($post_id, $name, true));
		}
	}
});

//display era column on timeline year list
add_filter('manage_timeline_year_posts_columns', function($defaults) {
    return array(
    	'cb'=>'<input type="checkbox">',
    	'title'=>'Title',
    	'era'=>'Era',
    	'date'=>'Date',
    );
});  

add_action('manage_timeline_year_posts_custom_column', function($column_name, $post_ID) {
	global $era_options; 
    if ($column_name == 'era') echo @$era_options[get_post_meta($post_ID, 'era', true)];
}, 10, 2);

//display era column on posts  list
add_filter('manage_posts_columns', function($defaults) {
    return array(
    	'cb'=>'<input type="checkbox">',
    	'title'=>'Title',
    	'era'=>'Era',
    	'date'=>'Date',
    );
});  

add_action('manage_posts_custom_column', function($column_name, $post_ID) {
	global $era_options; 
    if ($column_name == 'era') echo @$era_options[get_post_meta($post_ID, 'era', true)];
}, 10, 2);
