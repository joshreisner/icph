<?php
//no header or footer

if (empty($_GET['overlay'])) {
	//not an overlay, forward to overlay page
	header('Location: /#' . str_replace('/', '', $_SERVER['REQUEST_URI']));
	exit;
}

the_post();

?>

<div id="overlay" class="progressive">
	<div class="header">
		<h1>1890&ndash;1928</h1>
		<h2>Poverty and Homelessness in the Progressive Era</h2>
		<a href="#" class="close">Back to Timeline</a>
		<h3>Articles</h3>
	</div>
	
	<div class="body">
		<div class="content">
			<img src="<?php bloginfo('template_directory');?>/img/placeholder/gordon-family-m2.jpg" alt="gordon-family-m2" width="640" height="282" />
			<div class="inner"><?php the_content()?></div>
		</div>
		<div class="navigation">
			<ul>
				<li>
					<a href="#">The Gordon Family</a>
					<p>Neutra PBR tousled before they sold out, 90's aesthetic readymade quinoa helvetica aliqua veniam authentic. Anim vegan nostrud vero.</p>
				</li>
				<li>
					<a href="#">The Gordon Family</a>
					<p>Neutra PBR tousled before they sold out, 90's aesthetic readymade quinoa helvetica aliqua veniam authentic. Anim vegan nostrud vero.</p>
				</li>
				<li>
					<a href="#">The Gordon Family</a>
					<p>Neutra PBR tousled before they sold out, 90's aesthetic readymade quinoa helvetica aliqua veniam authentic. Anim vegan nostrud vero.</p>
				</li>
				<li>
					<a href="#">The Gordon Family</a>
					<p>Neutra PBR tousled before they sold out, 90's aesthetic readymade quinoa helvetica aliqua veniam authentic. Anim vegan nostrud vero.</p>
				</li>
				<li>
					<a href="#">The Gordon Family</a>
					<p>Neutra PBR tousled before they sold out, 90's aesthetic readymade quinoa helvetica aliqua veniam authentic. Anim vegan nostrud vero.</p>
				</li>
				<li>
					<a href="#">The Gordon Family</a>
					<p>Neutra PBR tousled before they sold out, 90's aesthetic readymade quinoa helvetica aliqua veniam authentic. Anim vegan nostrud vero.</p>
				</li>
				<li>
					<a href="#">The Gordon Family</a>
					<p>Neutra PBR tousled before they sold out, 90's aesthetic readymade quinoa helvetica aliqua veniam authentic. Anim vegan nostrud vero.</p>
				</li>
				<li>
					<a href="#">The Gordon Family</a>
					<p>Neutra PBR tousled before they sold out, 90's aesthetic readymade quinoa helvetica aliqua veniam authentic. Anim vegan nostrud vero.</p>
				</li>
				<li>
					<a href="#">The Gordon Family</a>
					<p>Neutra PBR tousled before they sold out, 90's aesthetic readymade quinoa helvetica aliqua veniam authentic. Anim vegan nostrud vero.</p>
				</li>
			</ul>
		</div>
	</div>
</div>
<div id="overlay_backdrop"></div>