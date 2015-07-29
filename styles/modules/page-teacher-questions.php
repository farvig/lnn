<?php  /* Template Name: Teacher questions */
get_header(); ?>
<div class="center">
	<?php simple_breadcrumb(); ?>
</div>
<?php while ( have_posts() ) : the_post(); ?>



<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>