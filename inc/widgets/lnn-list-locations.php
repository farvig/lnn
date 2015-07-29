<?php
/*
 * IVP social links widget
 * Takes the link entered in the IVP settings panel
 *
 */
class lnn_list_locations_widget extends WP_Widget {

	function __construct() {
		parent::__construct(
		// Base ID of your widget
		'lnn_list_locations', 

		// Widget name will appear in UI
		'Liste med steder',

		// Widget description
		array( 'description' => 'Lister alle steder med opslag' ) 
		);
	}

	// Creating widget front-end
	// This is where the action happens
	public function widget( $args, $instance ) {
	$title = apply_filters( 'widget_title', $instance['title'] );
	// before and after widget arguments are defined by themes
	echo $args['before_widget'];
	if ( ! empty( $title ) )
	echo $args['before_title'] . $title . $args['after_title'];

	// This is where we run the code and display the output
	// The get_terms_by_post_type function can be found in functions.php
	$locations = get_terms_by_post_type('sted','','post','all');
	echo "<ul>";
	foreach ( $locations as $location ){ ?>
	<li>
      <a href="/sted/<?php echo $location->slug; ?>" title="Se alle opslag i <?php echo $location->name;?>"><?php echo $location->name; ?></a>
    </li>
    <?php }
    echo "</ul>";
	echo $args['after_widget'];
	}
			
	// Widget Backend 
	public function form( $instance ) {
	if ( isset( $instance[ 'title' ] ) ) {
	$title = $instance[ 'title' ];
	}
	else {
	$title = __( 'New title', 'ivp' );
	}
	// Widget admin form
	?>
	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
	</p>
	<?php 
	}
		
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
	$instance = array();
	$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
	return $instance;
	}
} // Class lnn_load_list_locations_widget ends here

// Register and load the widget
function lnn_load_list_locations_widget() {
	register_widget( 'lnn_list_locations_widget' );
}
add_action( 'widgets_init', 'lnn_load_list_locations_widget' );