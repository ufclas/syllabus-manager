<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://it.clas.ufl.edu/
 * @since      0.0.0
 *
 * @package    Syllabus_Manager
 * @subpackage Syllabus_Manager/public/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div id="syllabus-main-wrap">

<div id="main" class="container main-content syllabus-main-content">
<div class="row">
  <div class="col-sm-12">
	
	<header class="entry-header sm-header" style="background-image:url('/wp-content/uploads/cultivated6-Copy-930x325.jpg');">
		<div class="sm-header-content">
			<ul class="breadcrumb-wrap">
				<li><a href="/departments">Departments</a></li>
			</ul>
			<?php the_archive_title( '<h1 class="page-title">', '</h1>' );	?>
			
			<ul class="sm-header-nav nav nav-pills">
			  <li role="presentation" class="active"><a href="#">Fall 2017</a></li>
			  <li role="presentation"><a href="#">Summer 2017</a></li>
			  <li role="presentation"><a href="#">Spring 2017</a></li>
			  <li role="presentation" class="link"><a href="#">Website</a></li>
			</ul>
			<form action="https://search.ufl.edu/search" method="get" class="search-form" role="search" style="width: 100%;">
				<label for="query-kb" class="visuallyhidden sr-only">Search Courses</label>
				<input type="text" id="query-kb" name="query" placeholder="Search">
				<button type="submit" class="btn-search">
					<span class="sr-only">Search</span>
					<span class="icon-svg">
						<svg>
						<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="http://syllabus.local/wp-content/themes/ufclas-ufl-2015/img/spritemap.svg#search"></use>
						</svg>
					</span>
				</button>
				<input type="hidden" name="source" id="source" value="web">
				<input type="hidden" name="site" id="site" value="syllabus.local">      
			</form>
		</div>
    </header><!-- .entry-header --> 
  </div>
</div>
<div class="row">
<div class="col-md-12">