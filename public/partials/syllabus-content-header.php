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
	
<?php if ( is_post_type_archive('syllabus_course') ): ?>
<div id="sm-hero" class="landing-page-hero-full">
	<div class="hero-img hero-img-half">
		<div class="hero-heading"><h1>Course Syllabi</h1></div>
	</div>
	
	<div class="hero-text container">
	<form>
	<div class="row">
		<div class="col-sm-6">
			<label for="sm-search-filter" class="sr-only">Search</label>
			<input type="text" id="sm-search-filter" class="sm-filter" placeholder="Search" autocomplete="off" aria-autocomplete="list"> 
		</div>
		<div class="col-sm-3">
			<label for="sm-dept-filter" class="sr-only">Department</label>
			<select id="sm-dept-filter" class="sm-filter"><option>Select Department</option></select>      
		</div>
		
		<div class="col-sm-3">
			<label for="sm-semester-filter" class="sr-only">Semester</label>
			<select id="sm-semester-filter" class="sm-filter"><option>Select Semester</option></select>      
		</div>
	</div>
	</form>
	</div><!-- .hero-text -->
</div><!-- .landing-page-hero-full -->
<?php endif; ?>

<div id="main" class="container main-content syllabus-main-content">
<div class="row">
  <div class="col-sm-12">
    <?php //ufclas_ufl_2015_breadcrumbs(); ?>
    <header class="entry-header">
	<?php 
	  	if ( is_archive() ){
			the_archive_title( '<h1 class="page-title">', '</h1>' );
	  	}
		else {
			the_title( '<h1 class="page-title">', '</h1>' );
		}
	?>
    </header>
    <!-- .entry-header --> 
  </div>
</div>
<div class="row">
<div class="col-md-12">