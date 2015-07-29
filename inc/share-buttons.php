<?php

/*
 * Share buttons
 * 
 * @since Boilerplate 1.0
 */

function ivp_display_share_buttons(){
	// Get out themes option
	global $ivp_theme_options;

	$ivp_theme_options['hide_sharing'] = false;

	if( !$ivp_theme_options['hide_sharing'] ){

		// Use the share links for social media
		?>
		<div class="share-bar">Del på: 
          <a href="https://www.facebook.com/sharer.php?u=<?php echo urlencode( get_permalink() ); ?>" title="Del på facebook" rel="nofollow external" target="_blank" onclick="window.open(this.href,'targetWindow','toolbar=no,location=1,status=1,statusbar=1,menubar=no,scrollbars=yes,resizable=yes,width=1024,height=580');return false;" class="share-btn facebook-btn"><span class="icon-facebook"></span></a>
          <a href="https://twitter.com/intent/tweet?text=<?php echo urlencode( get_permalink() ); ?>" title="Del på Twitter" rel="nofollow external" target="_blank" onclick="window.open(this.href,'targetWindow','toolbar=no,location=1,status=1,statusbar=1,menubar=no,scrollbars=yes,resizable=yes,width=1024,height=580');return false;" class="share-btn twitter-btn"><span class="icon-twitter"></span></a>
          <a href="https://plus.google.com/share?url=<?php echo urlencode( get_permalink() ); ?>" title="Del på google plus" rel="nofollow external" target="_blank" onclick="window.open(this.href,'targetWindow','toolbar=no,location=1,status=1,statusbar=1,menubar=no,scrollbars=yes,resizable=yes,width=1024,height=580');return false;" class="share-btn google-plus-btn"><span class="icon-google-plus"></span></a>
          <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo urlencode( get_permalink() ); ?>&amp;title=<?php echo urlencode( get_the_title() ); ?>" title="Del via LinkedIn" rel="nofollow external" target="_blank" onclick="window.open(this.href,'targetWindow','toolbar=no,location=1,status=1,statusbar=1,menubar=no,scrollbars=yes,resizable=yes,width=1024,height=580');return false;" class="share-btn linkedin-btn"><span class="icon-linkedin"></span></a>
        </div>
		<?php
	}
}