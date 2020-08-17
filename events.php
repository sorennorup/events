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
    include('classes/Event.php');
   
    add_action( 'wp_enqueue_scripts', 'load_event_scripts' );
  
function load_event_scripts() {
    wp_enqueue_script( 'events_script', plugins_url('events/js/myscript.js'), array('script'));
    wp_register_style('events', plugins_url( 'events/css/events.css'), array(), '1.0', 'all' );
    wp_enqueue_style( 'events');
    wp_enqueue_style( 'prefix-font-awesome', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.1/css/font-awesome.min.css', array(), '4.6.1' );
}

function renderEvents() {

    $from = new DateHandler();
    $to = new DateHandler();

    $args = array(
        'numberposts' => -1,
        'posts_per_page' => -1,
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
   
    if($posts) :
        $html .= '<h2>Det sker lige nu</h2>';
        $html .= '<div class = "events-container">';
        
        foreach($posts as $post) {  
            $start_date  =   Event::getStartDate($post);
            $end_date    =   Event::getEndDate($post);
            $type        =   Event::getEventType($post);
            $event_date  =   $from->set_date_str($start_date);
            $publish_date=   $from->set_publish_date('-1 week');
            $insert_to   =  "";

            if (Event::isMultiDayEvent(strtotime($to->set_date_str($end_date)))) :
                 $insert_to = ' til '.$to->format_to_danish();
                 $event_date = $to->set_date_str($end_date);
            endif;

           $html .= renderEvent($post,$publish_date, $event_date, $type,$from,$insert_to);
        }
        $html .= '</div>';
    endif;
    
    return $html;
}

function renderEvent($post,$publish_date, $event_date, $type,$from,$insert_to ) {
    $html;
    if(Event::isUpcommingEvent($publish_date,$event_date)) :
        $html.= '<div class = "event card-hover"> <a class = "linked-item "href = "'.$post->guid.'">  <h5>'.$type.'</h5>';
        $html.= '<h3>'.$post->post_title.'</h3>';
        $html .= $from->format_to_danish().''.$insert_to.
        'Læs mere </a></div>';
    endif;
    return $html;
}



add_shortcode('upcomming_events','renderEvents');

?>