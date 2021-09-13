<?php
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
if(isset($_GET['user_area_id'])){
    //echo $_GET['user_area_id'];
    $user_area_id = base64_decode($_GET['user_area_id']);
   // echo  $user_area_id; 
    if(is_numeric($user_area_id)){
      require_once("./Controller/DayController.php");
      require_once("./Model/AddressModel.php");
      $address_model1 = new address_model();
      $controller = new day_controller($address_model1, $con);
      //print_r($controller->get_address_where_program_id());
      $arr = $controller->get_address_where_program_id();
      $area_name  = ($languages == "en") ?  $arr['area_name_eng']: $arr['area_name_ar'];
      $place_name = ($languages == "en") ?  $arr['place_type_eng']: $arr['place_type_ar'];
      //echo $arr['program_duration'];
      
      //echo $arr['program_start_date'];
      $startTime = strtotime($arr['program_start_date']);
      $endTime = strtotime($arr['program_start_end']);
      $day_array =  array();
      $z = 0;
      // Loop between timestamps, 24 hours at a time
      for ($i = $startTime;$i<=$endTime; $i = $i + 86400 ) {
        
        $timestamp = strtotime(date( 'Y-m-d', $i ));
        $day = date('D', $timestamp);
        $arr = array('Fri','Sat'); // get out from week stauday and friday 
        if(!in_array($day,$arr)) {
           $day_array[$z++] = $day."-".date( 'Y-m-d', $i ); // add all days inside array 

        }
    
      }
      // leave two day from array 
      for($counter = 0 ;$counter <count($day_array);$counter++){
        if($counter == 0 ){
          echo $day_array[$counter];
        }else if(($counter+2) < count($day_array)){
          echo $day_array[$counter+2]."<br/>";
        }
        
      }
   //else if($counter+2 < count($day_array)){
        //   echo $day_array[$counter+2];

        // }
      
 
     
         echo '</div>
        </div>
      </div>
    </div>';

 


    }


}

}


?>
