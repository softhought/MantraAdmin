<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Sms extends MY_Controller {

    public function __construct() {

        parent::__construct(); 
        $this->load->model('commondatamodel','commondatamodel',TRUE);
        $this->load->model('smsmodel','smsmodel',TRUE);       
        $this->load->module('template');
    }





    public function index()

	{   
		if($this->session->userdata('mantra_user_detail'))

		{  
           
            $session = $this->session->userdata('mantra_user_detail');         

            $data['view_file'] = "sms/sms_congratulations";
            $data['smsconlist']=$this->smsmodel->getSmsConfig($session['companyid']); 
            $this->template->admin_template($data);  

        }else{

			redirect('login','refresh');

		}

    }


    public function loglist()

	{   
		if($this->session->userdata('mantra_user_detail'))

		{  
           
            $session = $this->session->userdata('mantra_user_detail');         

            $data['view_file'] = "sms/sms_log";
            $data['smslist']=$this->smsmodel->getSmsLog($session['companyid']); 
            $this->template->admin_template($data);  

        }else{

			redirect('login','refresh');

		}

    }



 



 





  

    


 



}// end of class