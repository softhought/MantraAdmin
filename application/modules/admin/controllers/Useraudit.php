<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Useraudit extends MY_Controller {

    public function __construct() {

        parent::__construct();

        $this->load->library('session');
        $this->load->model('commondatamodel','commondatamodel',TRUE);
        $this->load->model('Userauditmodel','audit',TRUE);       
        $this->load->module('template');
    }



public function index()

{

    $session = $this->session->userdata('mantra_user_detail');

	if($this->session->userdata('mantra_user_detail'))

	{  

        $data['view_file'] = "usermanagement/useraudit";
        $data['usersAuditList']=$this->audit->getAuditList($session['userid']);
        $this->template->admin_template($data);  
     
    }else{

        redirect('admin','refresh');

    }

    

}





}//end of class