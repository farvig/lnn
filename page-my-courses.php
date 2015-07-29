<?php /* Template Name: My posts */
get_header(); ?>
<div class="center">
	<?php simple_breadcrumb(); ?>
</div>
<?php while ( have_posts() ) : the_post(); ?>
<section>
  <div class="center">
    <div class="grid-group">
      <div class="page-content grid size-12 size-12--palm">
      	<h1 class="page-title"><?php the_title(); ?></h1>
       	<?php if ( is_user_logged_in() ) { ?>
			<table class="list-my-courses">
				<thead>
					<tr>
						<th>#</th>
						<th>Kursusnavn</th>
						<th>Kategori</th>
						<th>Tags</th>
						<th>Timepris</th>
						<th>Status</th>
						<th>Actions</th>
					</tr>
				</thead>
			<?php
			    $current_user = wp_get_current_user();
			     if ( !($current_user instanceof WP_User) ) {
			         return;
			     }
				$query = new WP_Query(
					array(
						'post_type' => 'post',
						'posts_per_page' =>'-1',
						'author' => $current_user->ID,
						'post_status' => array('publish','draft')
					) 
				);
				$i = 0;
				if ($query->have_posts()) { while ($query->have_posts()) : $query->the_post(); $i++;
					$post_id = get_the_ID();
					?>
					<tr>
						<td><?php echo $i; ?></td>
						<td><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></td>
						
						<td><?php $category = get_the_category(); 
							if($category[0]){
								echo '<a href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a>';
							} ?>
						</td>
						
						<td><?php the_tags('', ', ', '<br />'); ?> </td>
						
						<td><?php echo get_post_meta( $post_id, 'course_price', true ); ?> kr</td>
						
						<td><?php
							$course_stauts = get_post_status( $post_id );
							if( $course_stauts == 'publish'){
								echo 'Aktivt';
							}else{
								echo 'Inaktivt';
							}

						?></td>

						<?php $edit_post = add_query_arg('post', $post_id, get_permalink( 11 + $_POST['_wp_http_referer'])); ?>

						<td>
							<a href="<?php echo $edit_post; ?>">Rediger</a>
							|
							<?php if( !(get_post_status() == 'trash') ) : ?>
								<a onclick="return confirm('Er du sikker på at du vil slette: <?php echo get_the_title() ?>?')" href="<?php echo get_delete_post_link( $post_id );?>" title="Slet opslag" class="delete-post">Slet</a>
							<?php endif; ?>
						</td>
					</tr>

			<?php endwhile; }else{ ?>
				<tr><td colspan="7">Du har ikke oprette nogen kurser endnu. Opret dit første opslag <a href ="/opret-opslag/" >her</a></td></tr>
			<?php } ?>

		</table>
       	<?php }else{ ?>
			<div class="inpage-login-form">
        		<p class="message message--error">Du skal være logget ind for at se denne side.</p>
                <?php  wp_login_form( array('label_username' => 'Email') ); ?>
                <p>Har du ikke en profil? <a href="/bliv-underviser" title="Opret profil">Opret en gratis her</a>.</p>
            </div>
       	<?php } ?>
      </div>
    </div>
  </div>
</section>

<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>