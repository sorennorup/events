<?php


class DateHandler{

    public $date_str;
    public $format_str;
    private $date_obj;
    
    public function set_date_str($date){
        return $this->date_str = $date;
    }
    
    
    private function set_date_obj(){
        $this->date_obj =  $this->parse_date_str();
        return $this->date_obj;
    }
    
    private function parse_date_str(){
       return strtotime($this->date_str); 
    }
    
    public function format_to_danish(){
        $this->date_obj = $this->parse_date_str($this->date_str);
        $this->date_is_past();
        return $this->danish_day_name().' '.date('d-m-Y',$this->date_obj);
    }
    
    public function date_is_past(){    
           $today_obj = strtotime(date('Y-m-d'));    
           if($today_obj > $this->date_obj){
            return true;
           }
           else{
            return false;
           }                
    }

    public function set_publish_date($interval) {
      $pub_date = date('d-m-Y',strtotime($interval, strtotime($this->date_str)));
        return $pub_date;
    }
 
    private function danish_day_name(){
        for($i = 1; $i < 8; $i++){
        $weekdaynum = date('N',$this->date_obj);
        switch($weekdaynum){
            case 1 : return 'mandag';
                     break;
            case 2 : return 'tirsdag';
                     break;
            case 3 : return 'onsdag';
                     break;
            case 4 : return 'torsdag';
                    break;
            case 5 : return 'fredag';
                    break;
            case 6 : return 'lørdag';
                    break;
            case 7 : return 'søndag';
            
            }
        }
    
    }
}
$date_handler = new DateHandler();

?>