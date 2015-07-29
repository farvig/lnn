<?php /* Template Name: Teacher questions*/
get_header(); ?>

 <?php
$current_user = wp_get_current_user();
$args = array(
  'author' =>  $current_user->ID,
  'post_status' => array('publish','draft'),
  'posts_per_page' => '-1'
);
if(!$current_user instanceof WP_User ){
    return;
}
?>

<div class="center">
  <?php simple_breadcrumb(); ?>
</div>
<?php while ( have_posts() ) : the_post(); ?>

<section id="page-content" class="background-light page-content-container">
  <div class="center">
    <div class="grid-group">
      <div class="page-content grid size-8 size-12--palm">
        <h1 class="page-title"><?php the_title(); ?></h1>
        <?php if ( is_user_logged_in() ) { ?>
        <?php
        the_content();?>
        <div class="feedback-items">
        <?php 
        $current_user_posts = get_posts( $args );
        foreach ($current_user_posts as $current_user_post) {
          $current_user_post_ids[] = $current_user_post->ID;
        }
        $query = new WP_Query( 
          array(
              'posts_per_page' =>'-1',
              'post_type'       => 'feedback', 
              'post_parent__in' => $current_user_post_ids, 
              'post_status' => array('publish','draft')
            )
        );
        if($query->have_posts()) {
          while ($query->have_posts()) : $query->the_post(); ?>
          <div class="feedback-item">
            <div class="feedback-item__meta">
              <span>
                Besked fra: <?php echo get_post_meta( get_the_ID(), '_feedback_author', TRUE ); ?>,
                <a href="mailto:<?php echo get_post_meta(  get_the_ID(), '_feedback_author_email', TRUE ); ?>" title="Send email"><?php echo get_post_meta(  get_the_ID(), '_feedback_author_email', TRUE ); ?></a> 
              </span>
            </div>
            <?php echo get_the_date(); ?>
            <p class="feedback-item__message">
              <?php echo get_the_content(''); ?>
            </p>
            <p>
              <?php
                $post_title = get_the_title( wp_get_post_parent_id( get_the_ID() ) );
                if( $post_title != ''){ ?>
                Link til dit opslag: <a href="<?php echo get_the_permalink( wp_get_post_parent_id( get_the_ID() ) );
 ?>" title="Se opslaget"><?php echo $post_title; ?></a>
             <?php }else{
              echo "Intet opslag fundet.";
             }  ?>
            </p>
          </div>
        <?php endwhile; } ?>
        </div>
      </div>
      <aside class="grid size-4 size-12--palm">
       		<?php get_template_part( 'partials/sidebar-logged-in' ); ?>
      </aside>
      <?php }else{ // end if logged in ?>
        <div class="inpage-login-form">
          <p class="message message--error">Du skal være logget ind for at se denne side.</p>
            <?php  wp_login_form( array('label_username' => 'Email') ); ?>
            <p>Har du ikke en profil? <a href="/bliv-underviser" title="Opret profil">Opret en gratis her</a>.</p>
          </div>
      <?php } ?>
    </div>
  </div>
</section>
<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>