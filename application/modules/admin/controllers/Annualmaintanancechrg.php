<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Annualmaintanancechrg extends MY_Controller{

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
        $data['view_file'] = 'dashboard/front_office/amc/amc_list';
        $this->template->admin_template($data);  		

    }else{
        redirect('admin','refresh');  

  }
}
  public function addeditamc(){
    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {   
        if($this->uri->segment(4) == NULL){

            $data['mode'] = "ADD";    
            $data['btnText'] = "Save";  
            $data['btnTextLoader'] = "Saving...";   
            $data['amcId'] = 0;
            $data['amcEditdata'] = [];  

           }else{      
              $data['mode'] = "EDIT";   
              $data['btnText'] = "Update";
              $data['btnTextLoader'] = "Updating..."; 
              $data['amcId'] = $this->uri->segment(4);    
               $where = array('amc_id'=>$data['amcId']);  
               $data['amcEditdata'] = $this->commondatamodel->getSingleRowByWhereCls('amc_master',$where);   
           }
         
         $data['statutorylist'] = $this->commondatamodel->getAllDropdownActiveDataByComId('statutory_master');  
       // pre($data['statutorylist']);exit;

       $data['view_file'] = 'dashboard/front_office/amc/addedit_amc'; ;       

        $this->template->admin_template($data);  

		

    }else{

        redirect('admin','refresh');

  

  }

  }
  public function addedit_action(){
    if($this->session->userdata('mantra_user_detail'))

    {

      $session = $this->session->userdata('mantra_user_detail');
       

        $amcId = trim(htmlspecialchars($this->input->post('amcId')));
        $mode = trim(htmlspecialchars($this->input->post('mode')));
      
        $item_name = trim(htmlspecialchars($this->input->post('item_name')));
        if(trim(htmlspecialchars($this->input->post('expiry_date'))) != ''){            
            $expiry_date = date('Y-m-d',strtotime($this->input->post('expiry_date')));
           }else{
            $expiry_date=NULL;
           }
      
        $renewal_amt = trim(htmlspecialchars($this->input->post('renewal_amt')));
         

                        

           if ($mode == "ADD" && $amcId == "0") {          

            

              $insert_arr = array(
                    'statutory_id'=>$item_name,                   
                    'expiry_date'=>$expiry_date,
                    'renewal_amt'=>$renewal_amt,
                    'year_id'=> $session['yearid']
                    );


                $upd_inser = $this->commondatamodel->insertSingleTableData('amc_master',$insert_arr);

                 /** audit trail */ 
                  $module = 'AMC'; 
                  $action = "Insert";
                  $method = 'annualmaintanancechrg/addedit_action';
                  $table="amc_master";
                  $old_details="";
                  $new_details = json_encode($insert_arr);
                  $this->commondatamodel->insertSingleActivityTableData('Add AMC',$module,$action,$method,$upd_inser,$table,$old_details,$new_details);





            } else{


                $update_arr = array(
                    'statutory_id'=>$item_name,                   
                    'expiry_date'=>$expiry_date,
                    'renewal_amt'=>$renewal_amt,
                   
                    );



                $where = array('amc_id'=>$amcId);

                $olddtl = $this->commondatamodel->getSingleRowByWhereCls('amc_master',$where);

                $upd_inser = $this->commondatamodel->updateSingleTableData('amc_master',$update_arr,$where);

                 /** audit trail */ 
                 $module = 'AMC';
                 $action = "Update";
                 $method = 'annualmaintanancechrg/addedit_action';
                 $table="amc_master";
                 $old_details = json_encode($olddtl);
                 $new_details = json_encode($update_arr);

                 $this->commondatamodel->insertSingleActivityTableData('Update AMC',$module,$action,$method,$statutoryId,$table,$old_details,$new_details);

            }              

         
          if($upd_inser){

              $json_response = array(
                  "msg_status" => 1,
                  "mode"=>$mode,
                  "msg_data"=>'Saved Successfully'               

              );

             } else{

              $json_response = array(
                  "msg_status" => 0,
                  "msg_data" => "There is some problem while updating ...Please try again."      

              );

          }                   

        header('Content-Type: application/json');

        echo json_encode( $json_response );

        exit; 

      

    }  else{

      redirect('admin','refresh');



}



}





}  