<?php

class Metabox {
    public $field_names = array();
    public $meta_key_values = array();
    private $meta_box_name = 'Detaljer';
    public $post_type;
    
    function __construct($meta_box_name,$post_type){
        $this->meta_box_name = $meta_box_name ;
		$this->post_type = $post_type;
		
        add_action('add_meta_boxes', array($this,'events_add_meta_box'));
		add_action('save_post', array($this, 'save_meta_box_data'));
     }
     
     
	public function events_add_meta_box() {
	
		add_meta_box(
			'date_id',
			 $this->meta_box_name,
			'meta_box_callback',
             $this->post_type    	
		);

      	function meta_box_callback($post){
			wp_nonce_field( 'events_meta_box', 'myplugin_meta_box_nonce' );
     
	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
			$event_date = get_post_meta( $post->ID, '_meta_date', true );
			$event_end_date = get_post_meta( $post->ID, '_meta_end_date', true );
        	$event_time = get_post_meta( $post->ID, '_event_type', true );
			$event_url = get_post_meta($post->ID, '_ticket_url',true);
         
			echo '<label for="myplugin_new_field">';
			_e( '<h4>Dato:</h4>', 'myplugin_textdomain' );
			echo '</label> ';
			echo '<input type="date" name = "date" value="' .$event_date. '" size="25" />';
			echo '<input type="date" name = "end-date" value="' .$event_end_date. '" size="25" />';
	
			echo '';
			echo '<label for="afviklingstype">';
			_e( '<h4>Vælg en Afviklingstype</h4>', 'myplugin_textdomain' );
			echo '</label> ';
			echo '<select name = "event-type" id = "type" value="' . esc_attr( $event_time ) . '">
			<option value="Forældrearrangement">Forældrearrangement</option>
			<option value="Kollektiv vejledning">Kollektiv vejledning</option>
  			<option value="Brobygning">Brobygning</option>
			 <option value="Praktik">Praktik</option>
			 <option value="Opfølgning">Opfølgning</option>
			</select>';
			
			echo '<label for="buy-ticket-url">';
			_e( '<h4>Eventuelt link</h4>', 'myplugin_textdomain' );
			echo '</label> ';
			echo '<input type="text" id="ticketurl" name = "url" value="' . esc_attr( $event_url ) . '" size="50" />';
    	}	
	}

    public function save_meta_box_data($post_id){
        /*
	 * We need to verify this came from our screen and with proper authorization,
	 * because the save_post action can be triggered at other times.
	 */

	// Check if our nonce is set.
	if ( ! isset( $_POST['myplugin_meta_box_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['myplugin_meta_box_nonce'], 'events_meta_box' ) ) {
		return;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	/* OK, it's safe for us to save the data now. */
	
	// Make sure that it is set.
	if ( ! isset( $_POST['date'] ) && ! isset($_POST['time']) && ! isset($_POST['ticketurl']) && ! isset($_POST['end-date']) ) {
		return;
	}

	// Sanitize user input.
	
	$date = sanitize_text_field( $_POST['date'] );
	$end_date = sanitize_text_field( $_POST['end-date'] );
	$time = strtotime($date);
	$end_time = strtotime($end_time);
    $newformat = date('d-m-Y',$time);
        
	$event_type = sanitize_text_field( $_POST['event-type'] );
	$event_url = sanitize_text_field($_POST['url']);
        
      
	// Update the meta field in the database.
	
		update_post_meta( $post_id, '_meta_date', $date);
		update_post_meta( $post_id, '_meta_end_date', $end_date);
        update_post_meta( $post_id, '_event_type', $event_type );
		update_post_meta( $post_id, '_ticket_url', $event_url );    
    }
      
}
 $newMetabox = new Metabox('Detaljer', 'event');

?>
