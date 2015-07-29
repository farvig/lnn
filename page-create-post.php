<?php /* Template Name: Create post */

if ( is_user_logged_in() ) {

if(isset($_POST['submitted']) && isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {

	if(trim($_POST['post_title']) === '' ){
		$has_post_title_error = true;
	} else {
		$post_title = trim($_POST['post_title']);
	}
	
	$location_id = intval($_POST['location_id']);
 	$location = ( !empty( $location_id ) ? array( $location_id) : array() );

 	$course_cat_id = intval($_POST['course_category_id']);
 	$course_cat = ( !empty( $course_cat_id ) ? array( $course_cat_id ) : array() );

 	$course_tags = $_POST['course_tags'];
 	$course_tags =  explode( ',', $course_tags );

 	$course_contact_link = $_POST['contact_link'];

 	$course_status = $_POST['course_status'];

	$post_information = array(
		'post_title' => esc_attr(strip_tags($_POST['post_title'])),
		'post_content' => $_POST['post_content'],
		'post-type' => 'post',
		'post_status' => $course_status,
		'post_category' => $course_cat,
		'tags_input' =>  $course_tags,
		'tax_input' => array( 'sted' => $location )
	);

	$post_id = wp_insert_post( $post_information );
	if($post_id){
		// Update Custom Meta
		wp_set_object_terms( $post_id, $location, 'sted' );
		update_post_meta( $post_id, 'course_price', esc_attr(strip_tags( $_POST['course_price'] ) ) );
		update_post_meta( $post_id, 'course_zipcode', esc_attr(strip_tags( $_POST['course_zipcode'] ) ) );
		update_post_meta( $post_id, 'contact_link', $_POST['contact_link'] );
		// Redirect
		wp_redirect( get_permalink( 7 ) . '?status=created' );
		exit;
	}
	// Check for empty values
	if( $_POST['course_category_id'] === 'none'  ){
		$has_course_category_error = true;
	}
	if( $_POST['location_id'] === 'none' ){
		$has_location_error = true;
	}
	if( $_POST['post_content'] === '' ){
		$has_course_content_error = true;
	}

} // end if isset 

} // end if is_user_logged_in ?>

<?php get_header(); ?>
	<section class="center">
		<?php simple_breadcrumb(); ?>
		<div class="grid-group">
		<section class="page-content grid size-8 size-12--palm">
			<h1 class="page-title"><?php the_title(); ?></h1>
			<?php if ( is_user_logged_in() ) { ?>
			<form action="" method="post">
				<fieldset>
					<label for="post_title">Kursusnavn<span class="is-required">*</span></label>
					<input type="text" name="post_title" id="post_title" value="<?php if(isset($_POST['post_title'])) echo $_POST['post_title'];?>" class="<?php if( $has_post_title_error ){ echo 'error';} ?>" />
				</fieldset>

				<fieldset>
					<label for="course_category_id">Kategori<span class="is-required">*</span></label>
					<select name="course_category_id" id="course_category_id" class="<?php if( $has_course_category_error ){ echo 'error';} ?>">
						<option value="none">Vælg kategori</option>
						<?php 
						$cat_terms = get_terms("category", array( 'hide_empty' => 0 ) );
						foreach ( $cat_terms as $cat_term ) {
							echo "<option value='" . $cat_term->term_id ."'>" . $cat_term->name . "</option>";  
						}
					 ?>
					</select>
				</fieldset>
				<fieldset>
					<label for="post_content">Beskrivelse<span class="is-required">*</span></label>
					<?php
						if(isset($_POST['post_content'])) {
								$content =  $_POST['post_content']; 
						}else{
							$content =  '';
						}
					$settings = array(
					    'wpautop' => true,				// use wpautop?
					    'media_buttons' => false, 		// show insert/upload button(s)
					    'textarea_name' => 'post_content', // set the textarea name to something different, square brackets [] can be used here
					    'textarea_rows' => get_option('default_post_edit_rows', 20), // rows="..."
					    'tabindex' => '',
					    'editor_css' => '',				// intended for extra styles for both visual and HTML editors buttons, needs to include the <style> tags, can use "scoped".
					    'editor_class' => 'required',	// add extra class(es) to the editor textarea
					    'teeny' => false,				// output the minimal editor config used in Press This
					    'dfw' => false,					// replace the default fullscreen with DFW (supported on the front-end in WordPress 3.4)
					    'tinymce' => true,				// load TinyMCE, can be used to pass settings directly to TinyMCE using an array()
					    'quicktags' => false			// load Quicktags, can be used to pass settings directly to Quicktags using an array()
					);
					wp_editor( $content, 'post_content', $settings );
					?>
				</fieldset>
				<fieldset> 
					<div class="grid-group">
						<div class="grid size-6 size-12--palm">
							<label for="location_id">Område<span class="is-required">*</span></label>
							<select name="location_id" id="location_id" class="<?php if( $has_location_error ){ echo 'error';} ?>">
								<option value="none">Vælg område</option>
								<?php 
								 $terms = get_terms( "sted", array( 'hide_empty' => 0 ) );
								 $count = count($terms);
								 $cities = array( 'storkoebenhavn','aarhus', 'odense');
								 $regions = array();
								 if ( $count > 0 ){
								 	echo '<optgroup label="Storbyer">';
								    foreach ( $terms as $term ) {
								    	if( in_array( $term->slug, $cities ) ){
								       		echo "<option value='" . $term->term_id ."'>" . $term->name . "</option>";
								        }
								    }
								    echo '</optgroup>';
								    echo '<optgroup label="Landsdele">';
								    foreach ( $terms as $term ) {
								    	if( !in_array( $term->slug, $cities ) ){
								       		echo "<option value='" . $term->term_id ."'>" . $term->name . "</option>";
								        }
								    }
								    echo '</optgroup>';
								 }
							 ?>
							</select>
						</div>
						<div class="grid size-6 size-12--palm">
							<label for="course_zipcode">Post nr.</label>
							<input type="text" name="course_zipcode" id="course_zipcode" value="" />
						</div>
					</div>
				</fieldset>
				<fieldset>
					<label for="course_tags">Tags</label>
					<input type="text" id="course_tags" name="course_tags" />
					<p class="description">Seperér med komma, fx: beygnder, oliemaling</p>
				</fieldset>
				<fieldset>
					<label for="course_price">Timepris</label>
					<input type="text" name="course_price" id="course_price" value="" />
					<span>kr / timen</span>
					<p class="description">Hvis din pris ikke er timebaseret, kan du lade feltet være tomt og skrive prisen i kursusbeskrivelsen.</p>
				</fieldset>
				<fieldset>
					<label for="contact_link">Kontaktlink</label>
					<span class="description">http://</span><input type="text" name="contact_link" id="contact_link" value="" placeholder="www.din-hjemmeside.dk"/>
					<p class="description">Link til din egen side. Vil fremgå i stedet for kontaktformularen.</p>
				</fieldset>

				<fieldset>
					<label for="course_status">Status</label>
				<select name="course_status" id="course_status">
					<option value="publish">Aktivt</option>
					<option value="draft">Inaktivt</option>
				</select>
				</fieldset>

				<fieldset>
					<?php wp_nonce_field('post_nonce', 'post_nonce_field'); ?>
					<input type="hidden" name="submitted" id="submitted" value="true" />
					<button type="submit" class="btn cta">Opret</button>
				</fieldset>
			</form>
		<?php }else{ ?>
		<div class="inpage-login-form">
    		<p class="message message--error">Du skal være logget ind for at se denne side.</p>
            <?php  wp_login_form( array('label_username' => 'Email') ); ?>
            <p>Har du ikke en profil? <a href="/bliv-underviser" title="Opret profil">Opret en gratis her</a>.</p>
        </div>
	
		<?php } ?>

		</section>
			<aside class="grid size-4 size-12--palm">
	        	<?php get_template_part( 'partials/sidebar-logged-in' ); ?>
	    	</aside>
    	</div>
	</section>
<?php get_footer(); ?>