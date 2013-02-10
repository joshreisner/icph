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
		<a class="close">Back to Timeline</a>
	</div>
	
	<div class="body">
		<div class="content">
			<?php the_content()?>
		</div>
		<div class="navigation">
			<ul>
				<h3>Articles</h3>
				<li>
					<a href="#">The Gordon Family</a>
					<p>Neutra PBR tousled before they sold out, 90's aesthetic readymade quinoa helvetica aliqua veniam authentic. Anim vegan nostrud vero. Flexitarian beard plaid irure four loko, banh mi pitchfork 3 wolf moon quis before they sold out. Freegan fanny pack vero ut, skateboard terry richardson assumenda sunt irure farm-to-table organic.</p>
				</li>
				<li>
					<a href="#">The Gordon Family</a>
					<p>Neutra PBR tousled before they sold out, 90's aesthetic readymade quinoa helvetica aliqua veniam authentic. Anim vegan nostrud vero. Flexitarian beard plaid irure four loko, banh mi pitchfork 3 wolf moon quis before they sold out. Freegan fanny pack vero ut, skateboard terry richardson assumenda sunt irure farm-to-table organic.</p>
				</li>
				<li>
					<a href="#">The Gordon Family</a>
					<p>Neutra PBR tousled before they sold out, 90's aesthetic readymade quinoa helvetica aliqua veniam authentic. Anim vegan nostrud vero. Flexitarian beard plaid irure four loko, banh mi pitchfork 3 wolf moon quis before they sold out. Freegan fanny pack vero ut, skateboard terry richardson assumenda sunt irure farm-to-table organic.</p>
				</li>
				<li>
					<a href="#">The Gordon Family</a>
					<p>Neutra PBR tousled before they sold out, 90's aesthetic readymade quinoa helvetica aliqua veniam authentic. Anim vegan nostrud vero. Flexitarian beard plaid irure four loko, banh mi pitchfork 3 wolf moon quis before they sold out. Freegan fanny pack vero ut, skateboard terry richardson assumenda sunt irure farm-to-table organic.</p>
				</li>
				<li>
					<a href="#">The Gordon Family</a>
					<p>Neutra PBR tousled before they sold out, 90's aesthetic readymade quinoa helvetica aliqua veniam authentic. Anim vegan nostrud vero. Flexitarian beard plaid irure four loko, banh mi pitchfork 3 wolf moon quis before they sold out. Freegan fanny pack vero ut, skateboard terry richardson assumenda sunt irure farm-to-table organic.</p>
				</li>
				<li>
					<a href="#">The Gordon Family</a>
					<p>Neutra PBR tousled before they sold out, 90's aesthetic readymade quinoa helvetica aliqua veniam authentic. Anim vegan nostrud vero. Flexitarian beard plaid irure four loko, banh mi pitchfork 3 wolf moon quis before they sold out. Freegan fanny pack vero ut, skateboard terry richardson assumenda sunt irure farm-to-table organic.</p>
				</li>
				<li>
					<a href="#">The Gordon Family</a>
					<p>Neutra PBR tousled before they sold out, 90's aesthetic readymade quinoa helvetica aliqua veniam authentic. Anim vegan nostrud vero. Flexitarian beard plaid irure four loko, banh mi pitchfork 3 wolf moon quis before they sold out. Freegan fanny pack vero ut, skateboard terry richardson assumenda sunt irure farm-to-table organic.</p>
				</li>
				<li>
					<a href="#">The Gordon Family</a>
					<p>Neutra PBR tousled before they sold out, 90's aesthetic readymade quinoa helvetica aliqua veniam authentic. Anim vegan nostrud vero. Flexitarian beard plaid irure four loko, banh mi pitchfork 3 wolf moon quis before they sold out. Freegan fanny pack vero ut, skateboard terry richardson assumenda sunt irure farm-to-table organic.</p>
				</li>
				<li>
					<a href="#">The Gordon Family</a>
					<p>Neutra PBR tousled before they sold out, 90's aesthetic readymade quinoa helvetica aliqua veniam authentic. Anim vegan nostrud vero. Flexitarian beard plaid irure four loko, banh mi pitchfork 3 wolf moon quis before they sold out. Freegan fanny pack vero ut, skateboard terry richardson assumenda sunt irure farm-to-table organic.</p>
				</li>
				<li>
					<a href="#">The Gordon Family</a>
					<p>Neutra PBR tousled before they sold out, 90's aesthetic readymade quinoa helvetica aliqua veniam authentic. Anim vegan nostrud vero. Flexitarian beard plaid irure four loko, banh mi pitchfork 3 wolf moon quis before they sold out. Freegan fanny pack vero ut, skateboard terry richardson assumenda sunt irure farm-to-table organic.</p>
				</li>
				<li>
					<a href="#">The Gordon Family</a>
					<p>Neutra PBR tousled before they sold out, 90's aesthetic readymade quinoa helvetica aliqua veniam authentic. Anim vegan nostrud vero. Flexitarian beard plaid irure four loko, banh mi pitchfork 3 wolf moon quis before they sold out. Freegan fanny pack vero ut, skateboard terry richardson assumenda sunt irure farm-to-table organic.</p>
				</li>
				<li>
					<a href="#">The Gordon Family</a>
					<p>Neutra PBR tousled before they sold out, 90's aesthetic readymade quinoa helvetica aliqua veniam authentic. Anim vegan nostrud vero. Flexitarian beard plaid irure four loko, banh mi pitchfork 3 wolf moon quis before they sold out. Freegan fanny pack vero ut, skateboard terry richardson assumenda sunt irure farm-to-table organic.</p>
				</li>
			</ul>
		</div>
	</div>
</div>
<div id="overlay_backdrop"></div>