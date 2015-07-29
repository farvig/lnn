<?php /* Template Name: Login page */
get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

<section>	
	<div class="login-container">
		<h1 class="page-title"><?php the_title(); ?></h1>
		<?php if( isset($_REQUEST['login']) && $_REQUEST['login'] == 'failed') { ?>
			<p class="message message--error">Log ind mislykkedes</p>
		<?php } ?>
		<?php wp_login_form( array('label_username' => 'Email','redirect' => get_home_url() ) ); ?>
		<p class="no-profile-wrapper">Har du ikke en profil? <a href="/opret-profil" title="Opret profil">Opret en gratis her</a>.</p>
	</div>
</section>

<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>