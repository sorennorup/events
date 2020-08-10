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





$args = array(
    'numberposts' => 1000,
    'posts_per_page' => -1,
    'orderby'          => 'meta_value',
    'meta_query'       => array(
                 array('key'=>'_meta_date'   
                      )
                         ),
    'order'            => 'ASC',    
    'post_type'        => 'events',
    'post_status'      => 'publish',
    'suppress_filters' => false
    ); 

$posts = get_posts( $args );




?>