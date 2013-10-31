<?php
header('Content-type: application/json');

$posts = get_posts('numberposts=-1');
foreach ($posts as &$post) $post = $post->post_title;

echo json_encode(array('options'=>$posts));
