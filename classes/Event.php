<?php
 class Event {

    public static function isUpcommingEvent( $pub_date,$event_date ) {
        if( strtotime(date( 'd-m-Y' ) )>= strtotime( $pub_date ) && strtotime(date('d-m-Y')) > strtotime($event_date.'-14 days') && strtotime(date( 'd-m-Y '))<= strtotime( $event_date)) {
            return true;
        }
        else {
            return false;
        }
    }

    public static function isMultidayEvent( $end_date ){
        if( $end_date!="" ) {
        return true;
        }
        else {
            return false;
        }
    }

    public static function getStartDate($post){
        return get_post_meta($post->ID, '_meta_date', true);
    }

    public static function getEndDate($post){
        return get_post_meta($post->ID, '_meta_end_date', true);
    }

    public static function getEventType($post) {
        return get_post_meta($post->ID,'_event_type', true);
    }
 }






?>