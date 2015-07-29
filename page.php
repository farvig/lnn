<?php get_header(); ?>
<div class="center">
  <?php simple_breadcrumb(); ?>
</div>
<?php while ( have_posts() ) : the_post(); ?>

<section id="page-content" class="background-light page-content-container">
  <div class="center">
    <div class="grid-group">
      <div class="page-content grid size-8 size-12--palm">
      	<h1 class="page-title"><?php the_title(); ?></h1>
       	<?php the_content(); ?>
      </div>
       <aside class="grid size-4 size-12--palm">
       		<?php sub_nav($post); ?>
       </aside>
    </div>
  </div>
</section>
<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>