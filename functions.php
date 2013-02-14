<?php

//setup
//add_theme_support('menus');
add_filter('body_class', 'icph_body_class');


//custom functions
function icph_body_class($classes)  {
	global $post;
	foreach(explode('/', $_SERVER['REQUEST_URI']) as $category) {
		if (!empty($category)) $classes[] = trim($category);
	}
	if ($post && $post->ID) {
		foreach((get_the_category($post->ID)) as $category) $classes[] = trim($category->category_nicename);
	}
	return array_unique($classes);
}

function icph_ul($elements, $arguments) {
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
