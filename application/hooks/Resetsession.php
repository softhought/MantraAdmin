<?php
/**
 * @author:shankha
 */
class Resetsession {
      public function __construct()
    {
            $this->CI =& get_instance(); 
    }
   
  
    function restore(){
        
   
        $user_session = $this->CI->session->userdata('mantra_user_detail');
        if ($user_session) {
           /* session alreay active */
          // echo "set";
       // print_r($user_session);
        }else{
            $cookie_name = "umetainfo";
            if(!isset($_COOKIE[$cookie_name])) {
               // echo "Cookie named is not set!";
            } else {
            //echo "Cookie is set!<br>";
            //echo "Value is: " . $_COOKIE[$cookie_name];
                $user_session = json_decode($_COOKIE['umetainfo'], true);
                $this->setSessionData($user_session);
            }
           

        }
 
      
       

        

      //  $this->setSessionData($user_session);

       // print_r($user_session);exit;
        
        
    }

    private function setSessionData($result = NULL) {



        if ($result) {

            $this->CI->session->set_userdata("mantra_user_detail", $result);

        }

    }
}
?>