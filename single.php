<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>
<header class="page-header">
  <div class="center">
    <h1 class="page-title"><?php the_title(); ?></h1>
    <?php if( get_field('course_price') ){ ?>
    	<span class="post-price"><?php the_field('course_price'); ?> kr/timen</span>
    <?php } ?>
    <span class="post-location"><?php echo get_the_term_list( $post->ID, 'sted', '', ', ', '' ); ?> <?php  if( get_field('course_zipcode') ){ ?>, <?php the_field('course_zipcode'); } ?></span>
    <a href="#profile" class="teacher">
    	<?php
        $author_badge = get_user_meta( get_the_author_meta( 'ID' ), 'user_profile_image', TRUE ); 
        if( $author_badge != ''){ ?>
        	<img src="<?php $author_badge_thumbnail = wp_get_attachment_image_src($author_badge); echo $author_badge_thumbnail[0];  ?>" alt="<?php echo $author_badge['alt']; ?>" class="post-teacher__portrait" />
        <?php }else{ ?>
          <img src="<?php echo get_template_directory_uri(); ?>/img/default-profile.jpg" alt="<?php echo $user->display_name; ?>" class="post-teacher__portrait" />
        <?php } ?>
    	<h2 class="post-teacher__name"><?php echo get_the_author(); ?></h2>
  	</a>
  </div>
</header>
<section id="page-content" class="background-light page-content-container">
  <div class="center">
    <div class="grid-group">
      <div class="page-content grid size-8 size-12--palm">
       	<?php the_content(); ?>
        <div class="post-meta">
    		<?php
    			/* translators: used between list items, there is a space after the comma */
    			$tag_list = get_the_tag_list( '', __( ', ', 'laernogetnyt' ) );
    			if( !empty( $tag_list ) ) {
    				$meta_text = __( 'Tags: %1$s', 'laernogetnyt' );
            printf(
              $meta_text,
              $tag_list
            );
    			}
    		?>
        </div>
      </div>
      <aside class="grid size-4 size-12--palm">
        <?php ivp_display_share_buttons(); ?>
      </aside>
    </div>
  </div>
</section>
<section class="contact-teacher-container">
  <div class="center">
    <?php
      if( get_post_meta( $post->ID, 'contact_link', true) ){ ?>
        <a href="//<?php echo get_post_meta( $post->ID, 'contact_link', true); ?>" title="Læs mere" class="btn cta" target="_blank" onClick="_gaq.push(['_trackEvent', 'Contact link', 'Click', '<?php the_title_attribute(); ?>' ]);">Læs mere</a>
      <?php }else{ ?>
    <h2>Skriv til <?php the_author(); ?></h2>
    <div class="contact-form-wrapper">
      <?php
        echo do_shortcode('[contact-form subject="Forespørgsel på laernogetnyt.dk"][contact-field label="Navn" type="name" required="true" /][contact-field label="Email" type="email" required="true" /][contact-field label="Besked" type="textarea" required="true" /][/contact-form]');
      ?>
      </div>
      <?php } ?>
  </div>
</section>
<section id="profile" class="post-teacher-container center">
  <div class="grid-group">
    <div class="grid size-2 size-12--palm">
		<?php if( $author_badge != ''){ ?>
        	<img src="<?php $author_badge_thumbnail = wp_get_attachment_image_src($author_badge); echo $author_badge_thumbnail[0]; ?>" alt="" class="post-teacher__portrait" />
        <?php }else{ ?>
          <img src="<?php echo get_template_directory_uri(); ?>/img/default-profile.jpg" alt="<?php echo get_the_author(); ?>" class="post-teacher__portrait" />
        <?php } ?>
    </div>
    <div class="grid size-5 size-12--palm">
      <h2 class="post-teacher__name"><?php echo get_the_author(); ?></h2>
      <p class="post-teacher__description">
		<?php 
	        $author_desc = get_field('user_profile', 'user_' .  get_the_author_meta( 'ID' ) );
	        $author_desc = preg_replace('/<iframe.*?\/iframe>/i','', $author_desc);
	        printTruncated( 240, $author_desc );
	      ?>
      	<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" title="Se <?php echo get_the_author(); ?>s fuldeprofil">Læs mere om <?php echo get_the_author(); ?></a></p>
    </div>
  </div>
</section>
<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>