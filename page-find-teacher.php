<?php /* Template Name: Find teacher */
get_header(); ?>
<div class="center">
	<?php simple_breadcrumb(); ?>
</div>
<?php while ( have_posts() ) : the_post(); ?>
<section id="page-content" class="background-light page-content-container">
  <div class="center">
    <div class="grid-group">
      	<div class="page-content grid size-12 size-12--palm">
		<?php
			$users = get_users('blog_id=1&orderby=display_name');
			$groups = array();

			if( $users && is_array( $users ) ) {
				foreach( $users as $user ) {
					$first_letter = strtoupper( $user->display_name[0] );
					$groups[ $first_letter ][] = $user;
				}
				if( !empty( $groups ) ) {
					// print the navigation a-z list ?>
					<nav class="teacher-groups-nav clearfix">
					<?php foreach( $groups as $letter => $users ) { ?>
						<a href="#" title="Undervisere der starter med <?php echo apply_filters( 'the_title', $letter );  ?>" rel="<?php echo apply_filters( 'the_title', $letter );  ?>">
							<?php echo apply_filters( 'the_title', $letter ); ?>
						</a>
					<?php } ?>
					</nav>
					<div class="teacher-groups-wrapper">
				<?php }

				if( !empty( $groups ) ) {
					foreach( $groups as $letter => $users ) { ?>
						<div id="<?php echo apply_filters( 'the_title', $letter ); ?>" class="teacher-group-item">
							<div class="teacher-list-items grid-group">
							<?php
							foreach( $users as $user ) { ?>
								<article class="teacher-list-item grid size-6 size-12--palm">
									<div class="teacher-list-item__content">
									<a href="<?php echo get_author_posts_url( $user->ID ); ?>" title="Se <?php echo $user->display_name; ?>s profil" class="teacher-list-item__image-wrapper">
										<?php
											$author_badge = $author_badge = get_user_meta( $user->ID, 'user_profile_image', TRUE );
											if( $author_badge != ''){
										?>
											<img src="<?php $author_badge_thumbnail = wp_get_attachment_image_src( $author_badge ); echo $author_badge_thumbnail[0]; ?>" alt="" class="teacher-list-item__image" />
										<?php }else{ ?>
											<img src="<?php echo get_template_directory_uri(); ?>/img/default-profile.jpg" alt="<?php echo $user->display_name; ?>" class="teacher-list-item__image" />
										<?php } ?>
										</a>
										<h1 class="teacher-list-item__name">
											<a href="<?php echo get_author_posts_url( $user->ID ); ?>" title="Se <?php echo $user->display_name; ?>s profil">
												<?php echo $user->display_name; ?>
											</a>
										</h1>
										<div class="teacher-list-item__bio">
										<?php 
							                $author_desc = get_user_meta( $user->ID, 'user_profile', TRUE );
							                if( $author_desc != ''){ printTruncated( 260, $author_desc ); } 
							             ?>
							         	</div>
							            <div class="teacher-list-item__courses">
							             	<h3>Kurser:</h3>
							             	<ul>
							             		<?php
						             			//The Query
												query_posts('author='.$user->ID);
												//The Loop
												if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
												<li>
													<a href="<?php the_permalink();?>" title="<?php the_title_attribute(); ?>">
														<?php the_title(); ?>
													</a>
												</li>
												<?php endwhile; endif;

												//Reset Query
												wp_reset_query();?>
							             	</ul>
							            </div>
								    </div>
								</article>
							<?php } ?>
						</div>
					</div>
					<?php
					}
				}	
			}
			?>
			</div>
      	</div>
	</div>		
</section>
<?php endwhile;

get_footer(); ?>