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
    
    private function danish_day_name(){
        for($i = 1; $i < 8; $i++){
        $weekdaynum = date('N',$this->date_obj);
        switch($weekdaynum){
            case 1 : return 'Mandag';
                     break;
            case 2 : return 'Tirsdag';
                     break;
            case 3 : return 'Onsdag';
                     break;
            case 4 : return 'Torsdag';
                    break;
            case 5 : return 'Fredag';
                    break;
            case 6 : return 'Lørdag';
                    break;
            case 7 : return 'Søndag';
            
            }
        }
    
    }
}


?>