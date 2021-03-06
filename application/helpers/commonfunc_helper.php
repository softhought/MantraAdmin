<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('partial_uri'))
{
    function partial_uri($start = 0) {
        return join('/',array_slice(get_instance()->uri->segment_array(), $start));
    }
}
if (!function_exists('admin_with_base_url'))
{
    function admin_with_base_url() {
        return base_url()."admin/";
    }
}
if (!function_exists('admin_except_base_url'))
{
    function admin_except_base_url() {
        return "admin/";
    }
}


if (!function_exists('pre'))
{
    function pre($arr=[]) {
       echo "<pre>";
       print_r($arr);
       echo "</pre>";
    }
}


   
    if(!function_exists('arrayToStringWithDlm'))
    {
        function arrayToStringWithDlm($arr,$delimiter=",") { 
            $str = "";
            for($i=0;$i<count($arr);$i++) {
                $str.=$arr[$i].$delimiter;
            }
            rtrim($str,$delimiter);
            return $str;
        }
    }
    if(!function_exists('arrayObjectToStringWithDlm'))
    {
        function arrayObjectToStringWithDlm($arr,$column,$delimiter=",") { 
            $str = "";
            if(count($arr)>0) {
                foreach($arr as $data_arr) {
                $str.= $data_arr->$column.$delimiter;
                }
            }
            $str = rtrim($str,$delimiter);
            return $str;
        }
    }

   
    if(!function_exists('safe_b64encode'))
	{
        function safe_b64encode($string) {
        
            $data = base64_encode($string);
            $data = str_replace(array('+','/','='),array('-','_',''),$data);
            return $data;
        }
    }

    if(!function_exists('safe_b64decode'))
	{
        function safe_b64decode($string) {
            $data = str_replace(array('-','_'),array('+','/'),$string);
            $mod4 = strlen($data) % 4;
            if ($mod4) {
                $data .= substr('====', $mod4);
            }
            return base64_decode($data);
        }
    }
    
    if(!function_exists('encode')){
        function encode($value){ 
            $CI =& get_instance();
            $skey = $CI->config->item('encryption_key_urlencode');
            if(!$value){return false;}
            $text = $value;
            $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
            $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
            $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $skey, $text, MCRYPT_MODE_ECB, $iv);
            return trim(safe_b64encode($crypttext)); 
        }
    }
    
    if(!function_exists('decode')){
        function decode($value){
            $CI =& get_instance();
            $skey = $CI->config->item('encryption_key_urlencode');
            if(!$value){return false;}
            $crypttext = safe_b64decode($value); 
            $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
            $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
            $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $skey, $crypttext, MCRYPT_MODE_ECB, $iv);
            return trim($decrypttext);
        }
    }
    if(!function_exists('mantraSend')){
        function mantraSend($phone, $msg)
            {    
                $CI =& get_instance();
                $CI->load->database();
                $CI->load->library('session');
                $mantra_user = "mantraapi1";               
                $mantra_password = "j7@L86k1*dG";            
                $mantra_url = "http://myvaluefirst.com/smpp/sendsms?";
                $mantra_url = "https://103.229.250.200/smpp/sendsms?";
                //$mantra_from = "manl";
                $mantra_from = "MANTRA";
                $mantra_udh = 0;
                $url = 'username='.$mantra_user;
                $url.= '&password='.$mantra_password;
                $url.= '&to='.urlencode($phone);
                $url.= '&from='.$mantra_from;
                $url.= '&udh='.$mantra_udh;
                $url.= '&text='.urlencode($msg);
                $url.= '&dlr-mask=19&dlr-url*';

                $urltouse =  $mantra_url.$url;
            //	  if ($debug)
            //	  { echo "Request: <br>$urltouse<br><br>";
            //      }

                $file = file_get_contents($urltouse);
               
                $session = $CI->session->userdata('mantra_user_detail');
                $company_id = $session['companyid'];
                if ($file=="Sent.")
                {
                    $response="Y";
                    
		          $sms_log_inst = array(
                    'mobile' => $phone,
                    'message' => $msg,   
                    'status_code' => $response,                 
                    'response_code' => $file,                   
                    'created_on' => date('Y-m-d h:i s'),
                    'company_id'=>$company_id

                   );
                   $CI->commondatamodel->insertSingleTableData('sms_log',$sms_log_inst);
                }
                else
                {
                    $response="N";
                    $sms_log_inst = array(
                        'mobile' => $phone,
                        'message' => $msg,   
                        'status_code' => $response,                 
                        'response_code' => $file,                   
                        'created_on' => date('Y-m-d h:i s'),
                        'company_id'=>$company_id
    
                       );
                       $CI->commondatamodel->insertSingleTableData('sms_log',$sms_log_inst);
                }

                return($response);
            
            }
    }  
    
    if(!function_exists('siteURL'))
	{
		
		function siteURL(){
			$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
			$domainName = $_SERVER['HTTP_HOST'];
			return $protocol . $domainName;
		}
	}


