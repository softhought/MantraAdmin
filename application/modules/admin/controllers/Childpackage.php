<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Childpackage extends MY_Controller{

function __construct()

	{

		 parent::__construct();
		 $this->load->model('commondatamodel','commondatamodel',TRUE);	
		  $this->load->model('renewalremidermodel','renewalremidermodel',TRUE);		  
		  $this->load->model('renewalemindersmsmodel','renewalemindersmsmodel',TRUE);		  
		  $this->load->model('walletmodel','walletmodel',TRUE);		  
		  $this->load->model('registrationmodel','registrationmodel',TRUE);		  
		  $this->load->model('vouchermodel','vouchermodel',TRUE);		  
		  $this->load->model('corporatecompanymodel','corporatecompanymodel',TRUE);		  
		  $this->load->model('exchangepackagemodel','exchangepackagemodel',TRUE);		  
          $this->load->module('template');		

    }
    public function addeditchildpack(){
   
        if($this->session->userdata('mantra_user_detail'))
        {   
            $session = $this->session->userdata('mantra_user_detail');
            $company_id = $session['companyid'];
            if($this->uri->segment(4) == NULL){
      
                $data['mode'] = "ADD";    
                $data['btnText'] = "Save";  
                $data['btnTextLoader'] = "Saving..."; 
                $data['cus_id'] =$this->uri->segment(4);
                
               
                
      
               }
      
               $data['branchlist'] = $this->commondatamodel->getAllDropdownActiveDataByComId('branch_master'); 
               $data['cardlist'] = $this->registrationmodel->getCardList($company_id); 
               $data['dueinstallmentlist'] = $this->renewalremidermodel->getinstallmentperiod($company_id); 
               $data['cgstlist'] = $this->registrationmodel->GetGSTRate('CGST',$company_id);
               $data['sgstlist'] = $this->registrationmodel->GetGSTRate('SGST',$company_id);
               $data['trainerlist'] = $this->renewalemindersmsmodel->GetTrainerListAll($company_id);
               $data['userlist'] = $this->exchangepackagemodel->getUsers($company_id);
               //pre($data['walletdtl']);exit;
      
           $data['view_file'] = 'dashboard/registration/child-package/addedit_childpackage';        
      
            $this->template->admin_template($data); 
      
        
        }else{
      
            redirect('admin','refresh');
      }
      
      }

    }     