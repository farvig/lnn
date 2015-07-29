<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="no-js ie ie6 lte7 lte8 lte9" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 7 ]><html class="no-js ie ie7 lte7 lte8 lte9" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8 ]><html class="no-js ie ie8 lte8 lte9" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 9 ]><html class="no-js ie ie9 lte9" <?php language_attributes(); ?>><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html class="no-js" dir="<?php bloginfo('text_direction'); ?>" <?php language_attributes(); ?>><!--<![endif]-->
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<title><?php
			/*
			 * Print the <title> tag based on what is being viewed.
			 * We filter the output of wp_title() a bit -- see
			 * boilerplate_filter_wp_title() in functions.php.
			 */
			wp_title( '|', true, 'right' );
		?></title>
	  	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<!--[if lt IE 9]>
			<script src="<?php echo get_stylesheet_directory_uri() ?>/inc/assets/js/html5shiv.js"></script>
		<![endif]-->
<?php
		/* We add some JavaScript to pages with the comment form
		 * to support sites with threaded comments (when in use).
		 */
		if ( is_singular() && get_option( 'thread_comments' ) )
			wp_enqueue_script( 'comment-reply' );

		/* Always have wp_head() just before the closing </head>
		 * tag of your theme, or you will break many plugins, which
		 * generally use this hook to add elements to <head> such
		 * as styles, scripts, and meta tags.
		 */
		wp_head();
?>
	</head>
	<body <?php body_class(); ?>>
		<header class="site-header">
			<div class="center">
				<a href="<?php echo home_url(); ?>" class="site-logo">
					<img src="<?php echo get_template_directory_uri(); ?>/img/logo.png" alt="">
				</a>
				<nav class="site-nav">
				<a href="#content" title="<?php esc_attr_e( 'Skip to content', 'ivp' ); ?>" class="visuallyhidden"><?php _e( 'Skip to content', 'ivp' ); ?></a>
				<a href="#" class="mobile-nav js-mobile-nav">Menu</a>
					<ul>
						<?php
							wp_nav_menu( array(
								'theme_location' => 'site_nav',
								'items_wrap' => '%3$s',
								'container' => '',
							) );
						?>
						<?php
							if ( is_user_logged_in()){ ?>
								<?php $user_ID = get_current_user_id();
								$user_info = get_userdata($user_ID); ?>
								<li class="user-menu menu-item-has-children">
									<a href="#" title="Brugermenu">
										<?php echo wp_get_attachment_image( get_the_author_meta( 'user_profile_image', $user_info->ID ), 'thumbnail', false, array('class'=>'site-nav-profile-image') ); ?>
										<?php echo $user_info->display_name; ?>
									</a>
									<ul class="sub-menu">
										<?php
											wp_nav_menu( array(
												'theme_location' => 'user_nav',
												'items_wrap' => '%3$s',
												'container' => '',
											) );
										?>
										<li class="icon-exit"><a href="<?php echo wp_logout_url('/'); ?>" title="Logout">Logout</a></li>
									</ul>
								</li>
							<?php
							}else{ ?>
								<li><a href="/log-ind" title="Log ind">Log ind</a></li>
							<?php } ?>
					</ul>
				</nav>
			</div>
		</header>