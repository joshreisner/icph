<?php
//main timeline page

$body_class = 'timeline';

get_header();

echo '<div id="timeline_wrapper">';
icph_timeline();
echo '</div>';

echo icph_slider();

get_footer();