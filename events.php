<?php
/*
    Plugin Name: Events
    Plugin URI: uudanmark.dk
    Description: Starter for wordpress plugin
    Author: Soren Norup
    Version: 1.0
    Author URI: EUK
*/ 
    include('events_admin.php');
    include('classes/Metabox.php');
    include('classes/DateHandler.php');
   
    add_action( 'wp_enqueue_scripts', 'load_event_scripts' );
  
function load_event_scripts() {
    wp_enqueue_script( 'events_script', plugins_url('events/js/myscript.js'), array('script'));
    wp_register_style('events', plugins_url( 'events/css/events.css'), array(), '1.0', 'all' );
    wp_enqueue_style( 'events');
    wp_enqueue_style( 'prefix-font-awesome', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.1/css/font-awesome.min.css', array(), '4.6.1' );
}

function getAllEvents() {
    $args = array(
        'numberposts' => -1,
        'posts_per_page' => 3,
        'orderby'          => 'meta_value',
        'meta_query'       => array(
                array('key'=>'_meta_date'   
                    )
                        ),
        'order'            => 'ASC',    
        'post_type'        => 'project',
        'post_status'      => 'publish',
        'suppress_filters' => false
    ); 
    $posts = get_posts( $args );
    $from = new DateHandler();
    $to = new DateHandler();
    if($posts) :
        $html .= '<h2>Det sker lige nu</h2>';
        $html .= '<div class = "events-container">';
        foreach($posts as $post) {  
            $start_date = get_post_meta($post->ID, '_meta_date', true);
            $end_date = get_post_meta($post->ID, '_meta_end_date', true);
            $type = get_post_meta($post->ID, '_event_type',true);
            $from->set_date_str($start_date);
            $to->set_date_str($end_date);
            $to_date = $to->format_to_danish();
            $html.= '
            <div class = "event"><h3>'.$post->post_title.'</h3>
            <h5>'.$type.' afvikles:</h5>'
            .$from->format_to_danish().' til '.$to->format_to_danish().
            '<a class = "event-more" href = "'.$post->guid.'">Læs mere </a></div>';
        }
        $html .= '</div>';
    endif;
    
    return $html;
}


add_shortcode('upcomming_events','getAllEvents');

?>