<?php

/* Template Name: Edit profile */ 

/* Get user info. */
global $current_user, $wp_roles;


$errors = array();
/* If profile was saved, update profile. */
if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_REQUEST['action'] ) && $_REQUEST['action'] == 'update-user' ) {
    /* Update user password. */
    if ( !empty( $_POST['pass1'] ) && !empty( $_POST['pass2'] ) ) {
        if ( $_POST['pass1'] == $_POST['pass2'] ){
            wp_update_user(
            	array(
            		'ID' => $current_user->ID,
            		'user_pass' => esc_attr( $_POST['pass1'] )
            		) 
            );
        }else{
            $errors[] = 'De indtastede passwords stemte ikke overens. Password er ikke opdateret';
        }
    }
    /* Update user information. */
    if ( !empty( $_POST['email'] ) ){
        if( !is_email( esc_attr( $_POST['email'] ))){
            $errors[] = 'Du skal indtaste en email.';
        }
        elseif( email_exists(esc_attr( $_POST['email'] )) != $current_user->id )
            $errors[] = 'Denne email adresse er allerede i brug, prøv en anden.';
        else{
            wp_update_user(
            	array(
            		'ID' => $current_user->ID,
            		'user_email' => esc_attr( $_POST['email'] ),
            		)
            );
        }
    }
    if ($_FILES) {
    	// These files need to be included as dependencies when on the front end.
    	require_once( ABSPATH . 'wp-admin/includes/image.php' );
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
		require_once( ABSPATH . 'wp-admin/includes/media.php' );

		foreach ($_FILES as $file => $array) {
			//Check if the $_FILES is set and if the size is > 0 (if =0 it's empty)

			if(isset($_FILES[$file]) && ($_FILES[$file]['size'] > 0)) {

				$tmpName = $_FILES[$file]['tmp_name'];
				list($width, $height, $type, $attr) = getimagesize($tmpName);

			if( $width < 100 || $height < 100 )
			{
				$errors[] = "Billedet er for lille<br />";
				unlink($_FILES[$file]['tmp_name']);
			}

			// Get the type of the uploaded file. This is returned as "type/extension"
            $arr_file_type = wp_check_filetype(basename($_FILES[$file]['name']));
            $uploaded_file_type = $arr_file_type['type'];

             // Set an array containing a list of acceptable formats
            $allowed_file_types = array('image/jpg','image/jpeg','image/gif','image/png');

             // If the uploaded file is the right format
            if( in_array( $uploaded_file_type, $allowed_file_types) ) {
            	if( $array['size'] > 0 ){
				// Let WordPress handle the upload.
				// Remember, 'my_image_upload' is the name of our file input in our form above.
				$file_id = media_handle_upload( $file, 0 );
				update_user_meta( $current_user->ID, $file, $file_id);
			}
			} else {
			// wrong file type
	 			$errors[] = "Tilladte billedtyper er: JPG, GIF og PNG filer<br />";
               	 }

			}
		} // end for each

	} // END THE IF STATEMENT FOR FILES

    if ( !empty( $_POST['first-name'] ) )
        update_user_meta( $current_user->ID, 'first_name', esc_attr( $_POST['first-name'] ) );
    if ( !empty( $_POST['last-name'] ) )
        update_user_meta($current_user->ID, 'last_name', esc_attr( $_POST['last-name'] ) );
    if ( !empty( $_POST['description'] ) )
        update_user_meta( $current_user->ID, 'description', esc_attr( $_POST['description'] ) );
    if ( !empty( $_POST['user_profile'] ) )
        update_user_meta( $current_user->ID, 'user_profile', $_POST['user_profile'] );
}
// Delete cover and/or profile image
if ( !empty( $_REQUEST['trashed'] ) && !empty( $_REQUEST['ids'] ) ) {
	$deleted_image_id = $_REQUEST['ids'];
	if( get_the_author_meta( 'user_profile_image', $current_user->ID ) == $deleted_image_id ){
		update_user_meta( $current_user->ID, 'user_profile_image', "" );
	}elseif
	( get_the_author_meta( 'user_cover_image', $current_user->ID ) == $deleted_image_id ){
		update_user_meta( $current_user->ID, 'user_cover_image', "" );
	}
}

get_header(); ?>
<div class="center">
	<?php simple_breadcrumb(); ?>
		<div class="grid-group">
		    <section class="page-content grid size-8 size-12--palm">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	                <h1 class="page-title">Rediger profil</h1>
	                <?php the_content(); ?>
	                <?php if ( !is_user_logged_in() ) : ?>
	                <div class="inpage-login-form">
                		<p class="message message--error">Du skal være logget ind for at se denne side.</p>
	                    <?php  wp_login_form( array('label_username' => 'Email') ); ?>
	                    <p>Har du ikke en profil? <a href="/bliv-underviser" title="Opret profil">Opret en gratis her</a>.</p>
                    </div>
	                <?php else : ?>
	                    <form method="post" id="form-edit-user" class="form-edit-user clearfix grid-group" action="<?php the_permalink(); ?>" enctype="multipart/form-data">
	                    	<?php
	                    		if( count( $errors ) > 0 ){
	                    		echo '<p class="message message--error">' . implode("<br />", $errors) . '</p>';
	                    		}
	                    	?>
	                    	<div class="form-username grid size-12 size-12--palm" style="padding:0 1em;">
	                            <p>Dit brugerid: <b><?php the_author_meta( 'login', $current_user->ID ); ?></b>. <a href="/profil/<?php the_author_meta( 'login', $current_user->ID ); ?>" title="Se din profil">Se din profil</a></p>
	                        </div>
	                        <div class="form-username grid size-6 size-12--palm">
	                            <label for="first-name">Fornavn:</label>
	                            <input class="text-input" name="first-name" type="text" id="first-name" value="<?php the_author_meta( 'first_name', $current_user->ID ); ?>" />
	                        </div>
	                        <div class="form-username grid size-6 size-12--palm">
	                            <label for="last-name">Efternavn:</label>
	                            <input class="text-input" name="last-name" type="text" id="last-name" value="<?php the_author_meta( 'last_name', $current_user->ID ); ?>" />
	                        </div>
	                        <div id="form-user_profile_image" class="form-user_profile_image grid size-6 size-12--palm">
                        		<p>Profilbillede</p>
                        		<?php echo wp_get_attachment_image( get_the_author_meta( 'user_profile_image', $current_user->ID ), 'thumbnail', false, array('class' => 'user_profile_image-thumbnail') ); ?>
                        		<?php if( get_the_author_meta( 'user_profile_image', $current_user->ID ) != ""){ ?>
                        		<a href="<?php echo get_delete_post_link( get_the_author_meta( 'user_profile_image', $current_user->ID  ),true ); ?>" class="icon-cancel-circle delete-image" onclick="return confirm('Er du sikker på at du vil slette billedet. Du kan ikke fortryde dette.')" title="Slet dit profilbillede">Slet</a>
                        		<?php } ?>
                        		<div>
                        			<label for="user_profile_image">Upload et nyt billede: <span class="description">Max 1000x1000px, max 1Mb</span></label>
                        			<input class="file-input" name="user_profile_image" type="file" id="user_profile_image" value="" />
                        		</div>
	                        </div>
	                        <div id="form-user_cover_image" class="form-user_cover_image grid size-6 size-12--palm">
                        		<p>Coverbillede</p>
                        		<?php echo wp_get_attachment_image( get_the_author_meta( 'user_cover_image', $current_user->ID ), 'medium', false, array('class' => 'user_cover_image-thumbnail') ); ?>
                        		<?php if( get_the_author_meta( 'user_cover_image', $current_user->ID ) != ""){ ?>
                        		<a href="<?php echo get_delete_post_link( get_the_author_meta( 'user_cover_image', $current_user->ID  ),true ); ?>" class="icon-cancel-circle delete-image" onclick="return confirm('Er du sikker på at du vil slette billedet. Du kan ikke fortryde dette.')" title="Slet dit profilbillede">Slet</a>
                        		<?php } ?>
                        		<div>
                        			<label for="user_cover_image">Upload et nyt billede: <span class="description">Max 600x1600px, max 1Mb</span></label>
                        			<input class="file-input" name="user_cover_image" type="file" id="user_cover_image" value="" />
                        		</div>
	                        </div>
	                        <div class="form-textarea grid size-12 size-12--palm">
	                             <?php
	                             $settings = array(
								    'wpautop' => true, // use wpautop?
								    'media_buttons' => false, // show insert/upload button(s)
								    'textarea_name' => 'user_profile', // set the textarea name to something different, square brackets [] can be used here
								    'textarea_rows' => get_option('default_post_edit_rows', 20), // rows="..."
								    'tabindex' => '',
								    'editor_css' => '', // intended for extra styles for both visual and HTML editors buttons, needs to include the <style> tags, can use "scoped".
								    'editor_class' => 'required', // add extra class(es) to the editor textarea
								    'teeny' => false, // output the minimal editor config used in Press This
								    'dfw' => false, // replace the default fullscreen with DFW (supported on the front-end in WordPress 3.4)
								    'tinymce' => true, // load TinyMCE, can be used to pass settings directly to TinyMCE using an array()
								    'quicktags' => false // load Quicktags, can be used to pass settings directly to Quicktags using an array()
								);
								wp_editor( wpautop( get_user_meta( $current_user->ID,'user_profile', true ) ), 'user_profile', $settings );
	                            ?>
	                        
	                        </div><!-- .form-textarea -->
	                        <div class="form-email  grid size-12 size-12--palm">
	                            <label for="email">Email:</label>
	                            <input class="text-input" name="email" type="text" id="email" value="<?php the_author_meta( 'user_email', $current_user->ID ); ?>" />
	                        </div><!-- .form-email <--></-->
	                        <div class="form-password  grid size-6 size-12--palm">
	                            <label for="pass1">Nyt password:</label>
	                            <input class="text-input password-input" name="pass1" type="password" id="pass1" />
	                        </div><!-- .form-password -->
	                        <div class="form-password  grid size-6 size-12--palm">
	                            <label for="pass2">Gentag password:</label>
	                            <input class="text-input password-input" name="pass2" type="password" id="pass2" />
	                        </div><!-- .form-password -->
	                        <hr />
	                        <fieldset class="form-submit">
		                        <input name="update_user" type="submit" id="update_user" class="btn cta" value="Opdater" />
		                        <?php wp_nonce_field( 'update-user' ) ?>
		                        <input name="action" type="hidden" id="action" value="update-user" />
	                        </fieldset><!-- .form-submit -->
	                    </form><!-- #adduser -->
	                    <hr />
	                <p>Hvis du vil opsige dit medlemsskab, skriv venligst til os på <a href="mailto:info@laernogetnyt.dk?subject=Opsigelse" title="Skriv til os">info@laernogetnyt.dk</a>. Oplys venligst din email og fulde navn.</p>
	                <p>Når vi sletter en profil slettes alle opslag også og kan ikke genskabes. Husk du kan altid beholde en gratis profil.</p>
	                <?php endif; ?>
			<?php endwhile; ?>
			<?php else: ?>
			    <p class="no-data">
			        <p>Vi ved desværre ikke hvad vi skal vise dig.</p>
			    </p><!-- .no-data -->
			<?php endif; ?>
			</section><!-- .main-content -->
		    <aside class="grid size-4 size-12--palm">
		    	<?php get_template_part( 'partials/sidebar-logged-in' ); ?>
		    </aside>
	</div>
</div>
<?php get_footer(); ?>