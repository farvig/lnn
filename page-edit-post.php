<?php /* Template Name: Edit Post */ 

$query = new WP_Query( array(
	'post_type' => 'post',
	'posts_per_page' =>'-1',
	'post_status' => array(
							'publish',
							'draft'
						)
					) 
		);
if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
	
	if( isset($_GET['post']) ) {
		
		if($_GET['post'] == $post->ID)
		{
			$current_post = $post->ID;

			$title = get_the_title();
			$content = wpautop( get_the_content() );

			$course_price = get_post_meta( $current_post, 'course_price', true);
			
			$course_zipcode = get_post_meta( $current_post, 'course_zipcode', true);

			$course_contact_link = get_post_meta( $current_post, 'contact_link', true);

			$course_cat_id = intval($_POST['course_category_id']);
 			$course_cat = ( !empty( $course_cat_id ) ? array( $course_cat_id ) : array());

			$course_location_array = get_the_terms( $current_post, 'sted');
			foreach ( $course_location_array as $course_location ) {
				$course_location =  $course_location->term_id;
			}

			$course_status = get_post_status();

			$course_category_array = get_the_terms( $current_post, 'category');
			foreach ( $course_category_array as $course_category ) {
				$course_category =  $course_category->term_id;
			}

			$course_tags = get_the_tags();
		}
	}


endwhile; endif;

wp_reset_query();

global $current_post;


if( isset( $_POST['submitted'] ) && isset( $_POST['post_nonce_field'] ) && wp_verify_nonce( $_POST['post_nonce_field'], 'post_nonce')) {
	if(trim($_POST['post_title']) === '') {
		$has_post_title_error = true;
	} else {
		$post_title = trim($_POST['post_title']);
	}

	// Get post tags
	$course_tags = $_POST['course_tags'];
 	$course_tags =  explode( ',', $course_tags );

 	// get the location
	$location_id = intval( $_POST['location_id'] );
 	$location = ( !empty($location_id) ? array($location_id) : array());

 	// Get the post status ( active/inactive )
 	$course_status = $_POST['course_status'];

 	// Get the contact link
 	$course_contact_link = $_POST['contact_link'];

	$post_information = array(
		'ID' => $current_post,
		'post_title' => esc_attr(strip_tags($_POST['post_title'])),
		'post_content' => $_POST['postContent'],
		'post-type' => 'post',
		'post_status' => $course_status,
		'post_category' => $course_cat,
		'tags_input' =>  $course_tags,
		'tax_input' => array( 'sted' => $location )
	);

	$post_id = wp_update_post( $post_information );

	if( $post_id ){
		// Update Custom Meta
		update_post_meta( $post_id, 'course_price', esc_attr(strip_tags($_POST['course_price'])));
		update_post_meta( $post_id, 'course_zipcode', esc_attr(strip_tags($_POST['course_zipcode'])));
		update_post_meta( $post_id, 'contact_link', $_POST['contact_link'] );
		wp_set_object_terms( $post_id, $location, 'sted' );
		wp_redirect( home_url().'/mine-opslag?status=updated' ); exit;
	}
	
	// Check for empty values
	if( $_POST['post_title'] === ''  ){
		$has_post_title_error = true;
	}
	if( $_POST['course_category_id'] === 'none'  ){
		$has_course_category_error = true;
	}
	if( $_POST['location_id'] === 'none' ){
		$has_location_error = true;
	}
	if( $_POST['postContent'] === '' ){
		$has_course_content_error = true;
	}
}

?>

<?php get_header(); ?>
<div class="center">
	<?php simple_breadcrumb(); ?>
	<section class="grid-group">
		<section class="page-content grid size-8 size-12--palm">
			<?php if ( is_user_logged_in() ) { ?>
			<h1 class="page-title"><?php the_title(); ?></h1>
			<form action="" method="POST" class="edit-post-form">
				<fieldset>
					<label for="post_title">Kursusnavn</label>
					<input type="text" name="post_title" id="post_title" value="<?php echo $title; ?>" class="<?php if( $has_post_title_error ){ echo 'error';} ?>" />
				</fieldset>
				<fieldset>
					<label for="course_category_id">Kategori</label>
					<select name="course_category_id" id="course_category_id" class="<?php if( $has_course_category_error ){ echo 'error';} ?>">
						<option value="none">Vælg kategori</option>
						<?php 
						$cat_terms = get_terms("category", array( 'hide_empty' => 0 ) );
						foreach ( $cat_terms as $cat_term ) {
							
							if( $cat_term->term_id == $course_category){ $selected = 'selected'; }else{ $selected = '';}
							
							echo "<option value='" . $cat_term->term_id ."' " . $selected . ">" . $cat_term->name . "</option>";  
						}
					 ?>
					</select>
				</fieldset>
				<fieldset>
							
					<label for="postContent">Beskrivelse</label>

					<?php
						if(isset($_POST['postContent'])) {
							if(function_exists('stripslashes')) {
								$content = stripslashes($_POST['postContent']);
							} else {
								$content =  $_POST['postContent']; 
							} 
						}
					
					$settings = array(
					    'wpautop' => true, // use wpautop?
					    'media_buttons' => false, // show insert/upload button(s)
					    'textarea_name' => 'postContent', // set the textarea name to something different, square brackets [] can be used here
					    'textarea_rows' => get_option('default_post_edit_rows', 20), // rows="..."
					    'tabindex' => '',
					    'editor_css' => '', // intended for extra styles for both visual and HTML editors buttons, needs to include the <style> tags, can use "scoped".
					    'editor_class' => 'required', // add extra class(es) to the editor textarea
					    'teeny' => false, // output the minimal editor config used in Press This
					    'dfw' => false, // replace the default fullscreen with DFW (supported on the front-end in WordPress 3.4)
					    'tinymce' => true, // load TinyMCE, can be used to pass settings directly to TinyMCE using an array()
					    'quicktags' => false // load Quicktags, can be used to pass settings directly to Quicktags using an array()
					);
					wp_editor( $content, 'postContent', $settings );
					?>

				</fieldset>

				<fieldset>
					<label for="course_tags">Tags</label>
					<input type="text" id="course_tags" name="course_tags" value="<?php foreach ( $course_tags as $course_tag ) { echo $course_tag->name . ','; } ?>" />
					<p class="description">Seperer med komma, fx: beygnder, oliemaling</p>
				</fieldset>

				<fieldset>
					<label for="course_price">Timepris</label>
					<input type="text" name="course_price" id="course_price" value="<?php echo $course_price; ?>" />
					<span>kr / timen</span>
					<p class="description">Hvis din pris ikke er timebaseret, kan du lade feltet være tomt og skrive prisen i kursusbeskrivelsen.</p>
				</fieldset>
				<fieldset>
					<div class="grid-group">
						<div class="grid size-6 size-12--palm">
							<label for="location_id">Område</label>
							<select name="location_id" id="location_id" class="<?php if( $has_location_error ){ echo 'error';} ?>">
								<option value="none">Vælg undervisningssted</option>
								<?php 
									 $terms = get_terms( "sted", array( 'hide_empty' => 0 ) );

									 print_r( $terms );

									 $count = count($terms);
									 $cities = array( 'storkoebenhavn','aarhus', 'odense');
									 $regions = array();
									 if ( $count > 0 ){
									 	echo '<optgroup label="Storbyer">';
									    foreach ( $terms as $term ) {
									    	if( $term->term_id == $course_location){ $selected = 'selected'; }else{ $selected = ''; }
									    	if( in_array( $term->slug, $cities ) ){
									       		echo "<option value='" . $term->term_id ."' ".$selected." >" . $term->name . "</option>";
									        }
									    }
									    echo '</optgroup>';
									    echo '<optgroup label="Landsdele">';
									    foreach ( $terms as $term ) {
									    	if( $term->term_id == $course_location){ $selected = 'selected'; }else{ $selected = ''; }
									    	if( !in_array( $term->slug, $cities ) ){
									       		echo "<option value='" . $term->term_id ."' ".$selected." >" . $term->name . "</option>";
									        }
									    }
									    echo '</optgroup>';
									 }
								 ?>
							</select>
						</div>
						<div class="grid size-4 size-12--palm">
							<label for="course_zipcode">Post nr.</label>
							<input type="text" name="course_zipcode" id="course_zipcode" value="<?php echo $course_zipcode; ?>" />
						</div>
					</div>
				</fieldset>
				<fieldset>
					<label for="contact_link">Kontaktlink</label>
					<span class="description">http://</span><input type="text" name="contact_link" id="contact_link" value="<?php if($course_contact_link != ''){ echo $course_contact_link;} ?>" placeholder="wwww.din-hjemmeside.dk"/>
					<p class="description">Link til din egen side. Vil fremgå i stedet for kontaktformularen.</p>
				</fieldset>
				<hr />
				<fieldset>
					<label for="course_status">Status</label>
					<select name="course_status" id="course_status">
							<option value="publish" <?php if( $course_status == 'publish' ){ echo 'selected'; } ?> >Aktivt</option>
							<option value="draft" <?php if( $course_status == 'draft' ){ echo 'selected'; } ?> >Inaktivt</option>
					</select>
				</fieldset>
				<fieldset>
					<?php wp_nonce_field('post_nonce', 'post_nonce_field'); ?>
					<input type="hidden" name="submitted" id="submitted" value="true" />
					<button type="submit" class="btn cta">Opdater</button>
				</fieldset>

			</form>

			<?php }else{ ?>
				<div class="login-container">
					<h2 style="max-width:100%;">Du skal være logget ind for at se denne side</h2>
					<?php wp_login_form( array('label_username' => __( 'Email' ) ) ); ?>
					<p>Har du ikke en profil? <a href="/bliv-underviser" title="Opret profil">Opret en gratis her</a>.</p>
				</div>
			<?php } ?>
		</section>
		<aside class="grid size-4 size-12--palm">
			<?php get_template_part( 'partials/sidebar-logged-in' ); ?>
		</aside>
	</section>
</div>
<?php get_footer(); ?>