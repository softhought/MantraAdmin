<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Birthdaywish extends MY_Controller{
	
function __construct()
	{
		 parent::__construct();
		 $this->load->model('commondatamodel','commondatamodel',TRUE);		
		 $this->load->model('birthdatwishmodel','birthdatwishmodel',TRUE);		
         $this->load->module('template');
   

		
    }
    public function index(){

        $session = $this->session->userdata('mantra_user_detail');
        if($this->session->userdata('mantra_user_detail'))
        { 
           
         
            $data['branchlist'] = $this->commondatamodel->getAllDropdownActiveDataByComId('branch_master'); 
            $data['view_file'] = 'dashboard/front_office/birthday/birthday_wish_list.php';      
            $this->template->admin_template($data);  
            
        }else{
            redirect('admin','refresh');
      
      }
    
    }

    public function getBirthdayList(){

      $session = $this->session->userdata('mantra_user_detail');
      if($this->session->userdata('mantra_user_detail'))
      {  
       
        $currentDate=date('m-d');
        // if(trim(htmlspecialchars($this->input->post('from_dt'))) != ''){          
        //   $from_dt = date('Y-m-d',strtotime($this->input->post('from_dt')));
        //  }else{
        //   $from_dt=NULL;
        //  }
        //  if(trim(htmlspecialchars($this->input->post('to_date'))) != ''){          
        //   $to_date = date('Y-m-d',strtotime($this->input->post('to_date')));
        //  }else{
        //   $to_date=NULL;
        //  }
        $branch_id = $this->input->post('branch');
             
    
        $data['todaybirthdaylist'] = $this->birthdatwishmodel->getBirthdayList($currentDate,$branch_id);
        //pre($data['renewalsmslist']);exit;
        $page = 'dashboard/front_office/birthday/birthday_wish_partial_list.php'; 
        $this->load->view($page,$data);    
        
      
      
      }else{
          redirect('admin','refresh');
    
    }
    
    }


}