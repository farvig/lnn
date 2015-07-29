<?php
/*
 * Global options
 */

/*
 * Setting up localization
 */

add_action('after_setup_theme', 'ivp_theme_setup');
function ivp_theme_setup(){
    load_theme_textdomain('ivp', get_template_directory() . '/lang');
}

/*
 * Include our scripts 
 */

function ivp_register_scripts() {
	//wp_enqueue_style( 'style-name', get_stylesheet_uri() );
	wp_enqueue_script( 
		'ivp-plugins',
		get_template_directory_uri() . '/inc/assets/js/plugins.js',
		array('jquery'),
		'1.0.0',
		true
	);
	wp_enqueue_script( 
		'moderniizr',
		get_template_directory_uri() . '/inc/assets/js/modernizr-2.6.2.min.js',
		array(),
		'2.6.2',
		true
	);
}
add_action( 'wp_enqueue_scripts', 'ivp_register_scripts' );


/*
 * Including files
 */
global $ivp_theme_options;

include('inc/admin/theme-settings.php');
$ivp_theme_options = ivp_theme_get_settings();
include('inc/admin/admin-pages.php');
include('inc/admin/theme-customization.php');
include('inc/admin/theme-update-checker.php');

include('inc/breadcrumb.php');
include('inc/cookiebox.php');
include('inc/share-buttons.php');
include('inc/shortcodes.php');
include('inc/sidebars.php');

// Our widgets
include('inc/widgets/ivp_social.php');
include('inc/widgets/lnn_user_progress.php');
include('inc/widgets/lnn-list-locations.php');

// Our metaboxes
include('inc/metaboxes/ivp-hide-subnavigation.php');
include('inc/metaboxes/rich-tax-description-editor/main.php');

include('inc/menus.php');
include('inc/user.php');

if ( ! function_exists( 'boilerplate_comment' ) ) :
	/**
	 * Template for comments and pingbacks.
	 *
	 * To override this walker in a child theme without modifying the comments template
	 * simply create your own boilerplate_comment(), and that function will be used instead.
	 *
	 * Used as a callback by wp_list_comments() for displaying the comments.
	 *
	 * @since Twenty Ten 1.0
	 */
	function boilerplate_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case '' :
		?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<article id="comment-<?php comment_ID(); ?>" class="clearfix">
				<div class="comment-author-image module-1-4">
						<?php  echo get_avatar( $comment, 40 ); ?>
				</div>
				
				<div class="comment-content clearfix module-3-4">

					<?php if ( $comment->comment_approved == '0' ) : ?>
						<em><?php _e( 'Your comment is awaiting moderation.', 'ivp' ); ?></em>
						<br />
					<?php endif; ?>

					<h4 class="comment-author-name">
						<?php printf( __( '%s', 'ivp' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
					</h4>

					<div class="comment-date">
						<?php
							/* translators: 1: date, 2: time */
							$date = get_comment_date('d,M,Y');
							$date = explode(",", $date);
							$date = '<span class="comment-day">'.$date[0].'.</span><span class="comment-month">'.$date[1].'</span><span class="comment-year">'.$date[2].'</span>';
							$time = '<time class="comment-time">'.get_comment_time().'</time>';
							printf( __( '%1$s %2$s', 'ivp' ), $time, $date ); ?>
					</div>
					<div class="comment-text"><?php comment_text(); ?></div>
				</div>
				<div class="post-comment-reply">
					<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
				</div><!-- .reply -->
			</article><!-- #comment-##  -->
		<?php
			break;
			case 'pingback'  :
			case 'trackback' :
		?>
		<li class="post pingback">
			<p><?php _e( 'Pingback:', 'ivp' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'ivp'), ' ' ); ?></p>
		<?php
				break;
		endswitch;
	}
endif;

// This theme styles the visual editor to resemble the theme style.
//add_editor_style( array( 'css/editor-style.css', twentyfourteen_font_url() ) );



if ( ! function_exists( 'boilerplate_remove_recent_comments_style' ) ) :
	/**
	 * Removes the default styles that are packaged with the Recent Comments widget.
	 *
	 * To override this in a child theme, remove the filter and optionally add your own
	 * function tied to the widgets_init action hook.
	 *
	 * @since Twenty Ten 1.0
	 */
	function boilerplate_remove_recent_comments_style() {
		global $wp_widget_factory;
		remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
	}
endif;
add_action( 'widgets_init', 'boilerplate_remove_recent_comments_style' );

if ( ! function_exists( 'boilerplate_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post—date/time and author.
	 *
	 * @since Twenty Ten 1.0
	 */
	function boilerplate_posted_on() {
		// BP: slight modification to Twenty Ten function, converting single permalink to multi-archival link
		// Y = 2012
		// F = September
		// m = 01–12
		// j = 1–31
		// d = 01–31
		printf( __( '<span class="%1$s">Posted on</span> <span class="entry-date">%2$s %3$s, %4$s</span> <span class="meta-sep">by</span> %5$s', 'boilerplate' ),
			// %1$s = container class
			'meta-prep meta-prep-author',
			// %2$s = month: /yyyy/mm/
			sprintf( '<a href="%1$s" title="%2$s" rel="bookmark">%3$s</a>',
				home_url() . '/' . get_the_date( 'Y' ) . '/' . get_the_date( 'm' ) . '/',
				esc_attr( 'View Archives for ' . get_the_date( 'F' ) . ' ' . get_the_date( 'Y' ) ),
				get_the_date( 'F' )
			),
			// %3$s = day: /yyyy/mm/dd/
			sprintf( '<a href="%1$s" title="%2$s" rel="bookmark">%3$s</a>',
				home_url() . '/' . get_the_date( 'Y' ) . '/' . get_the_date( 'm' ) . '/' . get_the_date( 'd' ) . '/',
				esc_attr( 'View Archives for ' . get_the_date( 'F' ) . ' ' . get_the_date( 'j' ) . ' ' . get_the_date( 'Y' ) ),
				get_the_date( 'j' )
			),
			// %4$s = year: /yyyy/
			sprintf( '<a href="%1$s" title="%2$s" rel="bookmark">%3$s</a>',
				home_url() . '/' . get_the_date( 'Y' ) . '/',
				esc_attr( 'View Archives for ' . get_the_date( 'Y' ) ),
				get_the_date( 'Y' )
			),
			// %5$s = author vcard
			sprintf( '<span class="entry-author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
				get_author_posts_url( get_the_author_meta( 'ID' ) ),
				sprintf( esc_attr__( 'View all posts by %s', 'ivp' ), get_the_author() ),
				get_the_author()
			)
		);
	}
endif;

if ( ! function_exists( 'boilerplate_posted_in' ) ) :
	/**
	 * Prints HTML with meta information for the current post (category, tags and permalink).
	 *
	 * @since Twenty Ten 1.0
	 */
	function boilerplate_posted_in() {
		// Retrieves tag list of current post, separated by commas.
		$tag_list = get_the_tag_list( '', ', ' );
		if ( $tag_list ) {
			$posted_in = __( 'This entry was posted in %1$s and tagged %2$s.', 'ivp' );
		} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
			$posted_in = __( 'This entry was posted in %1$s.', 'ivp' );
		}
		// Prints the string, replacing the placeholders.
		printf(
			$posted_in,
			get_the_category_list( ', ' ),
			$tag_list,
			get_permalink(),
			the_title_attribute( 'echo=0' )
		);
	}
endif;


// add thumbnail support
if ( function_exists( 'add_theme_support' ) ) :
	add_theme_support( 'post-thumbnails' );
endif;

if ( ! function_exists( 'ivp_boilerplate_page_menu_args' ) ) :
	/**
	 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
	 *
	 * To override this in a child theme, remove the filter and optionally add
	 * your own function tied to the wp_page_menu_args filter hook.
	 *
	 * @since Twenty Ten 1.0
	 */
	function ivp_boilerplate_page_menu_args( $args ) {
		$args['show_home'] = false;
		return $args;
	}
endif;
add_filter( 'wp_page_menu_args', 'ivp_boilerplate_page_menu_args' );

/*
 * Switch default core markup for search form, comment form, and comments
 * to output valid HTML5.
 */
add_theme_support( 'html5', array(
	'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
) );


// This theme uses its own gallery styles.
add_filter( 'use_default_gallery_style', '__return_false' );


/*
 * Add Google webmaster tools, if entered
 */

function ivp_add_google_webmaster_meta_tag(){
	global $ivp_theme_options;

	if( $ivp_theme_options['webmaster_tools'] != ''){
		echo $ivp_theme_options['webmaster_tools'];
	}
}
add_action('wp_head', 'ivp_add_google_webmaster_meta_tag');


/* ------------------------------------------------------------------*/
/* ADD PRETTYPHOTO REL ATTRIBUTE FOR LIGHTBOX */
/* ------------------------------------------------------------------*/
 
add_filter('wp_get_attachment_link', 'ivp_add_rel_attribute');
function ivp_add_rel_attribute($link) {
	global $post;
	return str_replace('<a href', '<a rel="gallery" href', $link);
}


function lnn_excerpt_more( $more ) {
	return ' <a class="read-more" href="' . get_permalink( get_the_ID() ) . '">Læs mere</a>';
}
add_filter('excerpt_more', 'lnn_excerpt_more');


/*
 * Search only posts
 */
function lnn_search_only_posts($query) {
	if ($query->is_search) {
		$query->set('post_type', 'post');
	}
	return $query;
}
add_filter('pre_get_posts','lnn_search_only_posts');


/* get terms limited to post type 
 @ $taxonomies - (string|array) (required) The taxonomies to retrieve terms from. 
 @ $args  -  (string|array) all Possible Arguments of get_terms http://codex.wordpress.org/Function_Reference/get_terms
 @ $post_type - (string|array) of post types to limit the terms to
 @ $fields - (string) What to return (default all) accepts ID,name,all,get_terms. 
 if you want to use get_terms arguments then $fields must be set to 'get_terms'
*/
function get_terms_by_post_type($taxonomies,$args,$post_type,$fields = 'all'){
    $args = array(
        'post_type' => $post_type,
        'posts_per_page' => -1,
    );
    $the_query = new WP_Query( $args );
    $terms = array();
    while ( $the_query->have_posts() ){
        $the_query->the_post();

        $curent_terms = wp_get_object_terms( get_the_ID() , $taxonomies);

        foreach ($curent_terms as $t){
          //avoid duplicates
            if (!in_array( $t, $terms )){
                $terms[] = $t;
            }
        }
    }
    wp_reset_query();
    //return array of term objects
    if ($fields == "all")
        return $terms;
    //return array of term ID's
    if ($fields == "ID"){
        foreach ($terms as $t){
            $re[] = $t->term_id;
        }
        return $re;
    }
    //return array of term names
    if ($fields == "name"){
        foreach ($terms as $t){
            $re[] = $t->name;
        }
        return $re;
    }
    // get terms with get_terms arguments
    if ($fields == "get_terms"){
        $terms2 = get_terms( $taxonomies, $args );
        foreach ($terms as $t){
            if (in_array($t,$terms2)){
                $re[] = $t;
            }
        }
        return $re;
    }
}


/*
 * Location tax
 */

function course_location() {
    register_taxonomy(
        'sted',
        array( 'post' ),
        array(
            'labels' => array(
                'name' => 'Sted',
                'add_new_item' => 'Add New Sted',
                'new_item_name' => "New Sted"
            ),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => true,
            'show_in_nav_menus' => true,
            'rewrite' => array( 'slug' => 'sted' )
        )
    );
}
add_action( 'init', 'course_location', 0 );

/*
 * Truncate function
 */

function printTruncated($maxLength, $html, $isUtf8=true){
    $printedLength = 0;
    $position = 0;
    $tags = array();
    $print_html = '';

    // For UTF-8, we need to count multibyte sequences as one character.
    $re = $isUtf8
        ? '{</?([a-z]+)[^>]*>|&#?[a-zA-Z0-9]+;|[\x80-\xFF][\x80-\xBF]*}'
        : '{</?([a-z]+)[^>]*>|&#?[a-zA-Z0-9]+;}';

    while( $printedLength < $maxLength && preg_match($re, $html, $match, PREG_OFFSET_CAPTURE, $position)){
        list($tag, $tagPosition) = $match[0];

        // Print text leading up to the tag.
        $str = substr($html, $position, $tagPosition - $position);
        if ($printedLength + strlen($str) > $maxLength){
            print(substr($str, 0, $maxLength - $printedLength));
            $printedLength = $maxLength;
            break;
        }

        print($str);
        $printedLength += strlen($str);
        if ($printedLength >= $maxLength) break;

        if ($tag[0] == '&' || ord($tag) >= 0x80){
            // Pass the entity or UTF-8 multibyte sequence through unchanged.
            print($tag);
            $printedLength++;
        }else{
            // Handle the tag.
            $tagName = $match[1][0];
            if ($tag[1] == '/'){
                // This is a closing tag.
                $openingTag = array_pop($tags);
                assert($openingTag == $tagName); // check that tags are properly nested.

                print($tag);
            }
            else if ($tag[strlen($tag) - 2] == '/'){
                // Self-closing tag.
                print($tag);
            }else{
                // Opening tag.
                print($tag);
                $tags[] = $tagName;
            }
        }
        // Continue after the tag.
        $position = $tagPosition + strlen($tag);
    }

    // Print any remaining text.
    if ($printedLength < $maxLength && $position < strlen($html) )
        $print_html = substr( $html, $position, $maxLength - $printedLength );
    	// Add the trailing ... 
		print( $print_html . '...');
    // Close any open tags.
    while (!empty($tags))
        printf('</%s>', array_pop($tags));
}

function search_content_highlight() {
    $content = get_the_excerpt();
    $keys = implode('|', explode(' ', get_search_query()));
    $content = preg_replace('/(' . $keys .')/iu', '<i class="search-highlight">\0</i>', $content);

    echo '<p>' . $content . '</p>';
}

function search_title_highlight() {
	$title = get_the_title();
	$keys = implode('|', explode(' ', get_search_query()));
	$title = preg_replace('/(' . $keys .')/iu', '<i class="search-highlight">\0</i>', $title);

	echo $title;
}