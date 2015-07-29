<?php
/*
 * This files contains functions regarding users
 */


function new_author_base() {
    global $wp_rewrite;
    $author_slug = 'profil';
    $wp_rewrite->author_base = $author_slug;
}
add_action('init', 'new_author_base');

// Email settings
/* enter the full email address you want displayed */
/* from http://miloguide.com/filter-hooks/wp_mail_from/ */
function lnn_filter_wp_mail_from($email){
	return "no-reply@elaernoget.dk";
}
add_filter("wp_mail_from", "lnn_filter_wp_mail_from");

/* enter the full name you want displayed alongside the email address */
/* from http://miloguide.com/filter-hooks/wp_mail_from_name/ */
function lnn_filter_wp_mail_from_name($from_name){
	return "Lær noget nyt";
}
add_filter("wp_mail_from_name", "lnn_filter_wp_mail_from_name");


function rcp_add_required_field() {
	ob_start(); ?> 
		<p id="rcp_required_field_wrapper">
			<input name="rcp_required_field" id="rcp_required_field" type="checkbox" />
			<label for="rcp_required_field">Accepter <a href="/betingelser/" title="Betingelser" target="_blank">betingelser</a></label>
		</p>
	<?php
	echo ob_get_clean();
}
add_action('rcp_after_register_form_fields', 'rcp_add_required_field');

function validate_required_form_field($posted) {
	if(!isset($posted['rcp_required_field'])) {
		rcp_errors()->add('sample_field_required', __('Betingelserne skal godkendes', 'rcp'));
	}
}
add_action('rcp_form_errors', 'validate_required_form_field');



add_action( 'wp_login_failed', 'lnn_login_failed' ); // hook failed login

function lnn_login_failed( $user ) {
  	// check what page the login attempt is coming from
  	$referrer = $_SERVER['HTTP_REFERER'];

  	// check that were not on the default login page
	if ( !empty($referrer) && !strstr($referrer,'wp-admin') && $user!=null ) {
		// make sure we don't already have a failed login attempt
		if ( !strstr($referrer, '?login=failed' )) {
			// Redirect to the login page and append a querystring of login failed
	    	wp_redirect( $referrer . '/log-ind?login=failed');
	    } else {
	      	wp_redirect( $referrer );
	    }

	    exit;
	}
}


function remove_admin_bar() {
	if (!current_user_can('administrator') && !is_admin()) {
	  show_admin_bar(false);
	}
}
add_action('after_setup_theme', 'remove_admin_bar');

function restrict_admin_with_redirect() {
	if ( ! current_user_can( 'manage_options' )
		&& $_SERVER['PHP_SELF'] != '/laernogetnyt/wp-admin/admin-ajax.php'
		&& $_SERVER['PHP_SELF'] != '/laernogetnyt/wp-admin/async-upload.php'
		&& $_SERVER['PHP_SELF'] != '/laernogetnyt/wp-admin/post.php'
	) {
		wp_redirect( site_url() ); exit;
	}
}
add_action( 'admin_init', 'restrict_admin_with_redirect' );

add_filter('authenticate', 'lnn_allow_email_login', 20, 3);

/**
 * lnn_allow_email_login filter to the authenticate filter hook, to fetch a username based on entered email
 * @param  obj $user
 * @param  string $username [description]
 * @param  string $password [description]
 * @return boolean
 */
function lnn_allow_email_login( $user, $username, $password ) {
    if ( is_email( $username ) ) {
        $user = get_user_by('email', $username );
        if( $user ) $username = $user->user_login;
    }
    return wp_authenticate_username_password(null, $username, $password );
}

function yoast_change_opengraph_image( $url ) {
  if ( is_author() || is_single() ){
	    global $wp_query;
		$curauth = $wp_query->get_queried_object();
		$image_url = get_user_meta( $curauth->ID, 'user_profile_image', TRUE ); 
		if ( $image_url ) {
			$image_url_src = wp_get_attachment_image_src($image_url, 'full');
			return $image_url_src[0];
		}
	}
}
add_filter( 'wpseo_opengraph_image', 'yoast_change_opengraph_image', 10, 1 );


