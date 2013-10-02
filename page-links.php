<?php

//define vars for later
$links = $slugs = $ids = $skips = $replaces = array();
$base = site_url('/');


//get all live posts
$posts = $wpdb->get_results('SELECT id, post_title, post_name, post_content FROM wp_posts WHERE post_status = \'publish\'');


//make an array of links and an array of slug/IDs
foreach ($posts as $post) {
	if (preg_match_all('/<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>/siU', $post->post_content, $matches)) {
		$links = array_merge($links, $matches[2]);
	}
	$slugs[$post->post_name] = $post->id;
	$ids[$post->id] = $post->post_name;
}
$links = array_unique($links);
sort($links);


//loop through and fix links
foreach ($links as $link) {
	if (starts($link, 'http:') || starts($link, 'https:')) {
		//absolute url
		if (starts($link, $base . 'archives/')) {
			$id = substr($link, strlen($base . 'archives/'));
			if (array_key_exists($id, $ids)) {
				$replaces[$link] = $base . $ids[$id];
			} else {
				$skips[] = $link;
			}
		} else {
			$skips[] = $link;
		}
	} elseif (starts($link, '#') || starts($link, '/')) {
		$slug = strtolower(substr($link, 1));
		if (array_key_exists($slug, $slugs)) {
			$replaces[$link] = $base . $slug;
		} else {
			$skips[] = $link;
		}
	} else {
		//relative path
		if (array_key_exists($link, $slugs)) {
			$replaces[$link] = $base . $link;
		} else {
			$skips[] = $link;
		}
	}
}

echo '<h3>Replaces</h3>' . ol_assoc($replaces);
echo '<h3>Skips</h3>' . ol($skips);

function ol($items) {
	foreach ($items as &$item) $item = '<li>' . $item . '</li>';
	return '<ol>' . implode($items) . '</ol>';
}

function ol_assoc($items) {
	$return = array();
	foreach ($items as $key=>$value) $return[] = '<li>' . $key . ' -> ' . $value . '</li>';
	return '<ol>' . implode($return) . '</ol>';
}

function starts($haystack, $needle) {
	return (substr($haystack, 0, strlen($needle)) == $needle);
}