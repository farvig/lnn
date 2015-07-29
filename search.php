<?php get_header(); ?>

<header class="page-header">
  <div class="center">
    <h1 class="page-title">Søgeresultat for<strong> <?php echo get_search_query(); ?></strong></h1>
  </div>
</header>
<section class="search-results center">
      <div class="posts-list clearfix">
      <?php while ( have_posts() ) : the_post(); ?>
      <article class="posts-list-item-container grid size-6 size-12--palm">
        <div class="posts-list-item">
          <div class="grid-group">
            <div class="posts-list-item__content grid size-10 size-8--palm grid-last">
              <h1 class="posts-list-item__content-title">
                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
              </h1>
              <?php if( get_field('course_price') ){ ?>
		    	       <span class="posts-list-item__content-price"><?php the_field('course_price'); ?> kr/timen</span>
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
                	<span><?php echo get_the_term_list( $post->ID, 'sted', '', ', ', '' ); ?> <?php  if( get_field('course_zipcode') ){ ?>, <?php the_field('course_zipcode'); } ?></span>
                </div>
              </div>
            </div>
            <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" title="Se profilen" class="posts-list-item__person grid size-2 size-4--palm">
            	<?php
        		$author_badge = get_user_meta( get_the_author_meta( 'ID' ), 'user_profile_image', TRUE );
        		if( $author_badge != ''){
				?>
					<img src="<?php $author_badge_thumbnail = wp_get_attachment_image_src($author_badge); echo $author_badge_thumbnail[0]; ?>" alt="" class="posts-list-item__person-portrait" />
				<?php }else{ ?>
					<img src="<?php echo get_template_directory_uri(); ?>/img/default-profile.jpg" alt="<?php echo $user->display_name; ?>" class="posts-list-item__person-portrait"/>
                <?php } ?>
            	<h3 class="posts-list-item__person-name"><?php the_author(); ?></h3>
          	</a>
          </div>
        </div>
      </article>
      <?php endwhile; // End the loop. Whew. ?>
      </div>    
</section>
<section class="posts-search">
  <p class="posts-search-manchet">Fandt du ikke det du ledte efter. Prøv at søg igen.</p>
  <form role="search" method="get" class="center" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label class="visuallyhidden" for="s">Hvad vil du lære?</label>
    <input placeholder="Hvad vil du lære?" type="search" class="inline-element" id="s" name="s">
    <label for="sted">
        <select name="sted" id="location_name" class="inline-element area-picker">
          <option value="">Hele landet</option>
          <?php  $locations = get_terms_by_post_type('sted','','post','all');
            foreach ( $locations as $location ){ ?>
              <option value="<?php echo $location->slug; ?>"><?php echo $location->name;  ?></option>
            <?php }
          ?>
        </select>
      </label>
    <input type="submit" value="Søg" id="s" class="cta btn inline-element">
  </form>
</section>
<?php get_footer(); ?>