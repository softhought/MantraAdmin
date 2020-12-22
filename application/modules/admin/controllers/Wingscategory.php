<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Wingscategory extends MY_Controller{
	
function __construct()
	{
		 parent::__construct();
		 $this->load->model('commondatamodel','commondatamodel',TRUE);		
		 $this->load->model('enquirymodel','enquirymodel',TRUE);		
          $this->load->module('template');
   

		
	}

public function index(){

    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {  
     
     
      $data['wingcategorylist'] = $this->commondatamodel->getAllDropdownData('wings_category_master');  
      
      // pre($data['branchlist']);exit;
      $data['view_file'] = 'dashboard/front_office/masters/wings-category/wings_category_list'; ;      
        $this->template->admin_template($data);  
		
    }else{
        redirect('admin','refresh');
  
  }

}
public function addeditcategory(){

    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {   

        if($this->uri->segment(4) == NULL){

            $data['mode'] = "ADD";    
            $data['btnText'] = "Save";    
            $data['btnTextLoader'] = "Saving...";    
            $data['catId'] = 0;    
            $data['categoryEditdata'] = [];      
    
           }else{      
    
              $data['mode'] = "EDIT";    
              $data['btnText'] = "Update";    
              $data['btnTextLoader'] = "Updating...";    
              $data['catId'] = $this->uri->segment(4);     
               $where = array('cat_id'=>$data['catId']);      
              $data['categoryEditdata'] = $this->commondatamodel->getSingleRowByWhereCls('wings_category_master',$where);                
                
                 //pre($where);exit;      
           }
                  
          
       // pre($data['winglist']);exit;
         $data['view_file'] = 'dashboard/front_office/masters/wings-category/addedit_wings_category';      
         $this->template->admin_template($data);  
		
    }else{
        redirect('admin','refresh');
  
  }

  }

  public function addedit_action(){
    if($this->session->userdata('mantra_user_detail'))

    {
      $session = $this->session->userdata('mantra_user_detail');       

        $catId = trim(htmlspecialchars($this->input->post('catId')));
        $mode = trim(htmlspecialchars($this->input->post('mode')));       
       $category_name = trim(htmlspecialchars($this->input->post('category_name')));
          
           if ($mode == "ADD" && $catId == "0") { 

                   $insert_arr = array(
                                        'category_name'=>strtoupper($category_name),
                                        'is_active'=>'Y',                                       
                                        'branch_id'=>$session['branchid'],
                                        'company_id'=>$session['companyid'],
                                        'created_dt'=>date('d-m-Y')
                                       );

                  $upd_inser = $this->commondatamodel->insertSingleTableData('wings_category_master',$insert_arr);                                       

                 /** audit trail */ 
                 $module = 'Wings Category';           
                 $action = "Insert";
                 $method = 'wingscategory/addedit_action';
                 $table="wings_category_master";
                 $old_details="";
                 $new_details = json_encode($insert_arr);
                 $this->commondatamodel->insertSingleActivityTableData('Add Wings Category',$module,$action,$method,$upd_inser,$table,$old_details,$new_details);


            } else{

                   $where = array('cat_id'=>$catId);
                   $old_dtl = $this->commondatamodel->getSingleRowByWhereCls('wings_category_master',$where);
                   $updtearr = array(
                                       'category_name'=>strtoupper($category_name),
                                       'is_active'=>'Y'
                                      );
                   $upd_inser = $this->commondatamodel->updateSingleTableData('wings_category_master',$updtearr,$where);                 
                  /** audit trail */ 
                  $module = 'Wings Category';           
                  $action = "Update";
                  $method = 'wingscategory/addedit_action';
                  $table="wings_category_master";
                  $old_details=json_encode($old_dtl);
                  $new_details = json_encode($updtearr);
                  $this->commondatamodel->insertSingleActivityTableData('Add Wings Category',$module,$action,$method,$catId,$table,$old_details,$new_details);

            }              
         
          if($upd_inser){
              $json_response = array(
                  "msg_status" => 1,
                  "mode"=>$mode,
                  "msg_data"=>'Save Successfully'                 
                         
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
public function existingwingcat(){
    if($this->session->userdata('mantra_user_detail'))
    {     
    
      $category_name = $this->input->post('category_name'); 
      $catId = $this->input->post('catId');   
      $where = array('category_name'=>$category_name);  
      $where_notequal = "cat_id !=".$catId;
      if($catId == 0){
        $existing = $this->commondatamodel->checkExistanceData('wings_category_master',$where);    
     }else{
        $existing = $this->commondatamodel->checkExistanceDataWhereNotIn('wings_category_master',$where,$where_notequal);
     }
    
    
     
     $json_response = array(
                      "msg_status" => $existing              
                    );

          header('Content-Type: application/json');
          echo json_encode( $json_response );
          exit; 
    
    }else{
        redirect('admin','refresh');
  
    }

}
public function activewingcat()
  {
      $session = $this->session->userdata('mantra_user_detail');
      if($this->session->userdata('mantra_user_detail'))
      {   
          $catid=$this->uri->segment(4); 

          $where = array('cat_id'=>$catid);
          $data = array('is_active'=>'Y');
          $this->commondatamodel->ActiveInactive('wings_category_master',$data,$where);
           /** audit trail */ 
           $module = 'Wings Category';           
           $action = "Active";
           $method = 'wingscategory/activewing';
           $table="wings_category_master";
           $this->commondatamodel->insertSingleActivityTableData('Active Wing Category',$module,$action,$method,$catid,$table);

          redirect(admin_except_base_url().'wingscategory','refresh');



      }else{

          redirect('admin','refresh');

      }

  }

  public function inactivewingcat()

  {

      $session = $this->session->userdata('mantra_user_detail');

      if($this->session->userdata('mantra_user_detail'))

      {   
        $catid=$this->uri->segment(4); 
        $where = array('cat_id'=>$catid);
        $data = array('is_active'=>'N');
        $this->commondatamodel->ActiveInactive('wings_category_master',$data,$where);
         /** audit trail */ 
         $module = 'Wings Category';           
         $action = "Inactive";
         $method = 'wingscategory/inactivewingcat';
         $table="wings_category_master";
         $this->commondatamodel->insertSingleActivityTableData('Inactive Wing Category',$module,$action,$method,$catid,$table);

        redirect(admin_except_base_url().'wingscategory','refresh');


      }else{

          redirect('admin','refresh');

      }

  }

}