<?php 
if( is_user_logged_in() ){
	if ( is_active_sidebar( 'logged-in-users-widget-area' ) ) { ?>
		<?php dynamic_sidebar( 'logged-in-users-widget-area' ); ?>
	<?php }
} ?>