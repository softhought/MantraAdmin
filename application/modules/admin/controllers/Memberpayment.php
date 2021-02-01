<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Memberpayment extends MY_Controller {
    public $CI = NULL;
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('commondatamodel','commondatamodel',TRUE);
        $this->load->model('memberpaymentmodel','memberpaymentmodel',TRUE);
        //$this->load->model('menumodel','menumodel',TRUE);
        $this->load->module('template');
        $this->CI = & get_instance();
    }



public function index()
{
    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {  
        $data['companyID']=$session['companyid'];
      
      
       
        $data['view_file'] = 'dashboard/payment_received/mamber_payment/member_payment_view.php';         
        $this->template->admin_template($data);
     
    }else{
        redirect('admin','refresh');
    }


 }



public function getMemberPaymentList(){

  $session = $this->session->userdata('mantra_user_detail');
  if($this->session->userdata('mantra_user_detail'))
  {  

      $mobile_no =  $this->input->post('mobile_no');
      $company_id=$session['companyid'];
      $page = 'dashboard/payment_received/mamber_payment/member_payment_partial_view.php';  
      $data['paymentList']  = $this->memberpaymentmodel->getDetailMobilePayModuleRev($company_id,$mobile_no);  
    
        
      $this->load->view($page,$data);  
  
  }else{
      redirect('admin','refresh');

}

}



public function getPaymentDetailsList(){

  $session = $this->session->userdata('mantra_user_detail');
  if($this->session->userdata('mantra_user_detail'))
  {  

      $membership_no =  $this->input->post('membershipno');
      $data['membership_no']=$membership_no;
      $validity =  $this->input->post('validity');
      $data['validity']=$validity;
      $paymentfrom =  $this->input->post('paymentfrom');
      $actualvalidity =  $this->input->post('actualvalidity');
      $paymentid =  $this->input->post('paymentid');


        if($paymentfrom == 'HYG'){

	        $data['rowPayment']=$this->memberpaymentmodel->GetPaymentBypaymentid($paymentid);
		 }else{
	    	$data['rowPayment']=$this->memberpaymentmodel->GetPaymentByValidity($membership_no,$validity);
         }

           // pre($rowPaymentNow);

        // exit;
      $company_id=$session['companyid'];

      $page = 'dashboard/payment_received/mamber_payment/member_payment_model_details_data.php';  
     
    
        
      $this->load->view($page,$data);  
  
  }else{
      redirect('admin','refresh');

}

}

}/* end of class  */