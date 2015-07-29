<?php  /* Template Name: Registrer profil */

get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>
<section class="banner-container banner-container--signup">
	<div class="banner__content">
		<h1 class="banner__title">Tilbyd undervisning i dag</h1>
	</div>
</section>
<section id="create-profile-container" class="create-profile-container">	
	<div class="create-profile__content">
		<?php the_content(); ?>
	</div>
	<?php echo do_shortcode('[register_form]'); ?>
</section>
<section class="create-profile-selling-points">
	<div class="create-profile-selling-points__content">
		<div class="grid-group">
			<div class="grid size-6 size-12--palm">
				<h2>Du tjener alle pengene</h2>
				<p>Laernogetnyt.dk formidler blot kontakten mellem dig og potentielle elever - betalingen tror vi I bedst klarer selv. </p>
			</div>
			<div class="grid size-6 size-12--palm">
				<h2>Bliv kontaktet direkte</h2>
				<p>Undervisningssøgende skal ikke oprette profil for at kontakte dig. Gennem vores formular får du besked direkte i din indbakke.</p>
			</div>
			<div class="grid size-6 size-12--palm">
				<h2></h2>
				<p></p>
			</div>
		</div>
	</div>
</section>
<?php endwhile; // end of the loop. ?>

<?php get_template_part( 'partials/how-it-works' ); ?>

<?php get_footer(); ?>