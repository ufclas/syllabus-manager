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

<div id="sm-hero-wrap" class="landing-page-hero-full">
	<div class="hero-img hero-img-half">
		<div class="hero-heading">
			<h1>Courses</h1>
		</div>
	</div><!-- .hero-img -->

	<div class="hero-text">
	<div class="">
	<div class="col-sm-12">
		
		<form action="https://search.ufl.edu/search" method="get" class="search-form" role="search" style="width: 100%;">
			<label for="query-kb" class="visuallyhidden sr-only">Search</label>
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
	</div>
	</div><!-- .hero-text -->
</div><!-- .landing-page-hero-full -->