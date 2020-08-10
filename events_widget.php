<?php

function newsy_child_widgets(){
   $args = array(
	'name'          => 'Project Display',
	'id'            => 'project_display',
	'description'   => '',
        'class'         => '',
	'before_widget' => '<div id="project" class="widget_project">',
	'after_widget'  => '</div>',
	'before_title'  => '<h2 class="widgettitle">',
	'after_title'   => '</h2>' );
   

        
        register_sidebar( $args );
        }
    
        add_action( 'widgets_init', 'newsy_child_widgets' );
   
   
        add_shortcode('place_widget','display_my_widget');

function display_my_widget(){
 
        dynamic_sidebar('Project Display');

}



?>