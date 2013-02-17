<?php

//global variables
//era variable currently has too much information to come from wordpress
//$eras = get_categories('parent=20&hide_empty=0'));

$eras = array(
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

$policies = get_categories('parent=21&hide_empty=0');


//setup
//add_theme_support('menus');
add_action('wp_ajax_browse', 'icph_browse');
add_action('wp_ajax_nopriv_browse', 'icph_browse');

function icph_browse($type='Subject') {
	global $eras;
	
	$parent_id = (isset($_POST['type']) && ($_POST['type'] == 'policy')) ? 21 : 22;
	$categories = get_categories('parent=' . $parent_id);

	foreach ($categories as $category) {?>
		
	<div class="row">
		<h3<?php if ($category->name == $categories[0]->name) {?> class="first"<?php }?>><?php echo $category->name?></h3>
		<ul>
			<?php 
			$posts = get_posts('category=' . $category->term_id);
			foreach ($posts as $post) {
				if ($era = icph_get_era($post->ID)) $era = '<h4 class="' . $era['slug'] . '">' . $era['name'] . '</h4>';
			?>
			<li>
				<img src="<?php bloginfo('template_directory');?>/img/placeholder/great-migration-circle.png" alt="great-migration-circle" width="150" height="150" />
				<div>
					<?php echo $era?>
					<a href="#<?php echo $post->post_name?>"><?php echo $post->post_title?></a>
					<p><?php echo $post->post_excerpt?> &hellip;</p>
				</div>
			</li>
			<?php }?>
		</ul>
	</div>
	
	<?php }

	if (isset($_POST['type'])) die(); //end output here on ajax requests
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
	array_unshift($policies, array('content'=>'View by Policy'));
	
	return icph_ul($eras, array('id'=>'slider')) . icph_ul($policies, array('id'=>'slider_policy'));
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

/*
object(stdClass)#216 (15) { 
	["term_id"]=> &string(1) "3" 
	["name"]=> &string(64) "1890s - 1920s: Poverty & Homelessness in The Progressive Era" 
	["slug"]=> &string(9) "1890-1920" 
	["term_group"]=> string(1) "0" 
	["term_taxonomy_id"]=> string(1) "3" 
	["taxonomy"]=> string(8) "category" 
	["description"]=> &string(566) "Urbanization, immigration, and industrialization transformed New York City’s economy between 1890 and 1920, making poverty more prevalent among the working class while at the same time creating enormous wealth for some. Efforts to alleviate the effects of poverty among working-class and poor families through direct action and government reform become known as “progressivism.” The sights, sounds, and smells of the poorer districts in New York City in the 1890s made evident the effects of mass urbanization, immigration, and industrialization. " 
	["parent"]=> &string(2) "20" 
	["count"]=> &string(1) "7" 
	["cat_ID"]=> &string(1) "3" 
	["category_count"]=> &string(1) "7" 
	["category_description"]=> &string(566) "Urbanization, immigration, and industrialization transformed New York City’s economy between 1890 and 1920, making poverty more prevalent among the working class while at the same time creating enormous wealth for some. Efforts to alleviate the effects of poverty among working-class and poor families through direct action and government reform become known as “progressivism.” The sights, sounds, and smells of the poorer districts in New York City in the 1890s made evident the effects of mass urbanization, immigration, and industrialization. " 
	["cat_name"]=> &string(64) "1890s - 1920s: Poverty & Homelessness in The Progressive Era" 
	["category_nicename"]=> &string(9) "1890-1920" 
	["category_parent"]=> &string(2) "20" 
}
*/