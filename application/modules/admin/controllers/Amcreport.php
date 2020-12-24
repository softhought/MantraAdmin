<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Amcreport extends MY_Controller{

function __construct()

	{

		 parent::__construct();
		 $this->load->model('commondatamodel','commondatamodel',TRUE);	
		  $this->load->model('amcmodel','amcmodel',TRUE);
          $this->load->module('template');		

	}

public function index(){

    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {   
        //pre($session);exit;       
        $data['Amclist'] = $this->amcmodel->getAmcList();  
        // pre($data['branchlist']);exit;
        $data['view_file'] = 'dashboard/front_office/reports/calender/calender_view';
        $this->template->admin_template($data);  		

    }else{
        redirect('admin','refresh');  

  }
}

public  function getAmcExpirydata()

    {
        $session = $this->session->userdata('user_detail');

        if($this->session->userdata('user_detail'))

        {         

            $amc_id = $this->input->post('amc_id'); 
            $json_response = $this->amcmodel->getallamcforcalender($amc_id); 

            header('Content-Type: application/json');

            echo json_encode( $json_response );

            exit;

        }

        else{

            redirect('login','refresh');

        }

    }

}