<?php get_header();

global $wp_query;
$curauth = $wp_query->get_queried_object();

// Get user image if any
$author_badge = get_user_meta( $curauth->ID, 'user_profile_image', TRUE ); 
$author_cover = get_user_meta( $curauth->ID, 'user_cover_image', TRUE );
$author_cover = wp_get_attachment_image_src( $author_cover, 'full');
?>

<header class="page-header page-header--profile <?php if( $author_cover != ''){ echo"has-cover-image";}; ?>">
  <div class="page-heder-cover" style="background-image:url(<?php if( $author_cover != ''){ echo $author_cover[0]; } ?>);">
    <?php if( $curauth->ID == get_current_user_id()  &&  $author_cover == ''){ ?>
        <a href="/min-profil#acf-user_cover_image" class="btn">Vælg et cover billede</a>
    <?php } ?>
  </div>
  <div class="center page-header--profile__content">
    <div class="grid-group">
    	<?php if( $author_badge != ''){ ?>
          <img src="<?php $author_badge_thumbnail = wp_get_attachment_image_src($author_badge); echo $author_badge_thumbnail[0]; ?>" alt="<?php echo $author_badge['alt']; ?>" height="300" width="300" class="post-teacher__portrait" />
        <?php }else{ ?>
          <img src="<?php echo get_template_directory_uri(); ?>/img/default-profile.jpg" alt="<?php echo $curauth->display_name; ?>" height="300" width="300" class="post-teacher__portrait" />
        <?php } ?>
      	<h1 class="page-title"><?php echo $curauth->display_name; ?></h1>
    </div>
  </div>
</header>
<section id="page-content" class="background-light page-content-container">
  <div class="center">
    <div class="grid-group">
      <div class="page-content grid size-8 size-12--palm">
        <div>
         <?php  the_field('user_profile', 'user_' . $curauth->ID ); ?>
    	    	<?php
    			/* Since we called the_post() above, we need to
    			 * rewind the loop back to the beginning that way
    			 * we can run the loop properly, in full.
    			 */
    			rewind_posts();
    			?>
          <hr>
        </div>
        <?php if ( have_posts() ) : ?>
        
        <h2><?php echo $curauth->display_name; ?> underviser i </h2>
        
        <?php /* Start the Loop */ ?>
		<?php while ( have_posts() ) : the_post(); ?>
        
        <div class="posts-list clearfix">
          <article class="posts-list-item">
            <div class="grid-group">
              <div class="posts-list-item__content grid size-12 size-12--palm">
                <h1 class="posts-list-item__content-title">
                  <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                    <?php the_title(); ?>
                  </a>
                </h1>
                <?php if( get_field('course_price') ){ ?>
					<span class="posts-list-item__content-price"> <?php the_field('course_price'); ?> kr / timen</span>
				<?php } ?>
                <div class="posts-list-item__content-text">
					         <?php the_excerpt(); ?>
                </div>
                <div class="posts-list-item__content-meta">
	                <div class="posts-list-item__content-tags">
	                	<?php
        						/* translators: used between list items, there is a space after the comma */
        						$tag_list = get_the_tag_list( '', __( ', ', 'laernogetnyt' ) );
        						if ( '' != $tag_list ) {
        							$meta_text = __( 'Tags: %1$s', 'laernogetnyt' );
        						}
        						printf(
        							$meta_text,
        							$tag_list
        						);
        						?>
	              	</div>
                  <div class="posts-list-item__content-location">
                  	<span><?php echo get_the_term_list( $post->ID, 'sted', '', ', ', '' ); ?>
                  	<?php  if( get_field('course_zipcode') ){ ?>
						, <?php the_field('course_zipcode'); ?>
					<?php } ?>
					</span>
                  </div>
                </div>
              </div>
            </div>
          </article>
        </div>
      <?php endwhile; ?>
      <?php else : ?>

			<p><?php echo $curauth->display_name; ?> har i øjeblikekt ingen aktive kuser</p>

	   <?php endif; ?>
	</div>
      <aside class="grid size-4 size-12--palm">
        <?php ivp_display_share_buttons(); ?>
      </aside>
    </div>
  </div>
</section>
<?php get_footer(); ?>