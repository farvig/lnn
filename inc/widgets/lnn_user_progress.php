<?php
/*
 * IVP social links widget
 * Takes the link entered in the IVP settings panel
 *
 */
class lnn_user_progress_widget extends WP_Widget {

	function __construct() {
		parent::__construct(
		// Base ID of your widget
		'lnn_user_progress', 

		// Widget name will appear in UI
		'User Progress', 

		// Widget description
		array( 'description' => 'Not mush to say yet', ) 
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
		$progress = '';
		global $current_user;
		$user_post_count = count_user_posts( $current_user->ID);
		if( $user_post_count > 0){
			$progress = $progress + 30;
			if( $user_post_count > 1 && $user_post_count < 3){
				$progress = $progress + 10;
			}else{
				$suggestions[] = 'Overvej at <a href="/bruger/opret-opslag" title="Opret endnu et opslag">oprette endnu et opslag</a>';
			}
		}else{
			$suggestions[] = '<a href="/bruger/opret-opslag" title="Opret dit første opslag">Opret dit første opslag</a>';
		}

		if( get_the_author_meta( 'user_profile', $current_user->ID ) ){
			$progress = $progress + 30;
		}else{
			$suggestions[] = '<a href="/bruger/rediger-profil" title="Udfyld din profiltekst">Udfyld din profiltekst</a>. Her kan du skrive lidt om dig selv og dine kompetancer.';
		}

		if( get_the_author_meta( 'user_profile_image', $current_user->ID ) ){
			$progress = $progress + 20;
		}else{
			$suggestions[] = 'Overvej at <a href="/bruger/rediger-profil" title="Upload et coverbillede">uploade et profilbillede.</a>.';
		}

		if( get_the_author_meta( 'user_cover_image', $current_user->ID ) ){
			$progress = $progress + 10;
		}else{
			$suggestions[] = 'Overvej at <a href="/bruger/rediger-profil" title="Upload et coverbillede">uploade et coverbillede</a>.';
		}
		if( $progress == '100'){ $user_progree_status = 'user-progress-complete'; }else{ $user_progree_status = 'in-progress';}
		?>
		<h3>Din profil</h3>
		<div class="progress-bar">
		<div class="progress-bar__progress <?php echo $user_progree_status; ?>" style="height: <?php echo $progress; ?>%;">
			<span class="progress-bar__number"><?php echo $progress; ?></span><span class="progress-bar__unit">%</span>
		</div>
		</div>
		
		<?php
		if( $suggestions > 0 ){ ?>
			<ul class="suggestions">
			<?php foreach ($suggestions as $suggestion) {
				echo '<li>' . $suggestion . '</li>';
			} ?>
			</ul>
		<?php }

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
		<p>Shows the user progress bar</p>
	<?php 
	}
		
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
	$instance = array();
	$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
	return $instance;
	}
} // Class lnn_user_progress_widget ends here

// Register and load the widget
function lnn_load_user_progress_widget() {
	register_widget( 'lnn_user_progress_widget' );
}
add_action( 'widgets_init', 'lnn_load_user_progress_widget' );