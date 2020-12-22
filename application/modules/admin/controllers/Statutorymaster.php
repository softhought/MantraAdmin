<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Statutorymaster extends MY_Controller{

function __construct()

	{

		 parent::__construct();
		 $this->load->model('commondatamodel','commondatamodel',TRUE);	
		//  $this->load->model('enquirymodel','enquirymodel',TRUE);
          $this->load->module('template');		

	}

public function index(){

    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {   
        //pre($session);exit;
       
        $data['statutorylist'] = $this->commondatamodel->getAllDropdownDataByComId('statutory_master');  
        // pre($data['branchlist']);exit;
        $data['view_file'] = 'dashboard/front_office/masters/statutory_master/statutory_list';
        $this->template->admin_template($data);  		

    }else{
        redirect('admin','refresh');  

  }
}
  public function addeditstatutory(){
    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {   
        if($this->uri->segment(4) == NULL){

            $data['mode'] = "ADD";    
            $data['btnText'] = "Save";  
            $data['btnTextLoader'] = "Saving...";   
            $data['statutoryId'] = 0;
            $data['statutoryEditdata'] = [];  

           }else{      
              $data['mode'] = "EDIT";   
              $data['btnText'] = "Update";
              $data['btnTextLoader'] = "Updating..."; 
              $data['statutoryId'] = $this->uri->segment(4);    
               $where = array('id'=>$data['statutoryId']);  
               $data['statutoryEditdata'] = $this->commondatamodel->getSingleRowByWhereCls('statutory_master',$where);   
           }

           
        //pre($data['wingcatlist']);exit;

       $data['view_file'] = 'dashboard/front_office/masters/statutory_master/addedit_statutory'; ;       

        $this->template->admin_template($data);  

		

    }else{

        redirect('admin','refresh');

  

  }

  }
  public function addedit_action(){
    if($this->session->userdata('mantra_user_detail'))

    {

      $session = $this->session->userdata('mantra_user_detail');
       

        $statutoryId = trim(htmlspecialchars($this->input->post('statutoryId')));
        $mode = trim(htmlspecialchars($this->input->post('mode')));
      
        $statutory_name = trim(htmlspecialchars($this->input->post('statutory_name')));
         

                        

           if ($mode == "ADD" && $statutoryId == "0") {          

            

              $insert_arr = array(
                  'statutory_name'=>strtoupper($statutory_name),                   
                  'is_active'=>'Y',
                  'company_id'=> $session['companyid']
                    );



                $upd_inser = $this->commondatamodel->insertSingleTableData('statutory_master',$insert_arr);



                 /** audit trail */ 
                  $module = 'Statutory Master'; 
                  $action = "Insert";
                  $method = 'statutorymaster/addedit_action';
                  $table="statutory_master";
                  $old_details="";
                  $new_details = json_encode($insert_arr);
                  $this->commondatamodel->insertSingleActivityTableData('Add Statutory',$module,$action,$method,$upd_inser,$table,$old_details,$new_details);





            } else{



                      $update_arr =  array(
                        'statutory_name'=>strtoupper($statutory_name),                   
                        'is_active'=>'Y',                      

                          );



                $where = array('id'=>$statutoryId);

                $olddtl = $this->commondatamodel->getSingleRowByWhereCls('statutory_master',$where);

                $upd_inser = $this->commondatamodel->updateSingleTableData('statutory_master',$update_arr,$where);

                 /** audit trail */ 

                 $module = 'Statutory Master';           

                 $action = "Update";

                 $method = 'statutorymaster/addedit_action';

                 $table="statutory_master";

                 $old_details = json_encode($olddtl);

                 $new_details = json_encode($update_arr);

                 $this->commondatamodel->insertSingleActivityTableData('Update Statutory',$module,$action,$method,$statutoryId,$table,$old_details,$new_details);



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

public function checkexisting(){

    if($this->session->userdata('mantra_user_detail'))

    {     

      $session = $this->session->userdata('mantra_user_detail');

      $statutory_name = $this->input->post('statutory_name'); 
    

      $statutoryId = $this->input->post('statutoryId');   

      $where = array('statutory_name'=>$statutory_name,'company_id'=>$session['companyid']);  

      $where_notequal = "id !=".$statutoryId;

      if($statutoryId == 0){

        $existing = $this->commondatamodel->checkExistanceData('statutory_master',$where);    

     }else{

        $existing = $this->commondatamodel->checkExistanceDataWhereNotIn('statutory_master',$where,$where_notequal);

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

public function active()

  {

      $session = $this->session->userdata('mantra_user_detail');

      if($this->session->userdata('mantra_user_detail'))

      {   

         $statutoryId=$this->uri->segment(4); 



          $where = array('id'=>$statutoryId);

          $data = array('is_active'=>'Y');

          $this->commondatamodel->ActiveInactive('statutory_master',$data,$where);

           /** audit trail */ 

           $module = 'Statutory Master';           

           $action = "Active";

           $method = 'statutorymaster/active';

           $table="statutory_master";

           $this->commondatamodel->insertSingleActivityTableData('Active Statutory',$module,$action,$method,$statutoryId,$table);



          redirect(admin_except_base_url().'statutorymaster','refresh');







      }else{



          redirect('admin','refresh');



      }



  }



  public function inactive()
  {
      $session = $this->session->userdata('mantra_user_detail');
      if($this->session->userdata('mantra_user_detail'))

      {  
        $statutoryId=$this->uri->segment(4); 
        $where = array('id'=>$statutoryId);
          $data = array('is_active'=>'N');
          $this->commondatamodel->ActiveInactive('statutory_master',$data,$where);
           /** audit trail */ 

           $module = 'Statutory Master'; 
           $action = "Inctive";
           $method = 'statutorymaster/inactive';
           $table="statutory_master";
           $this->commondatamodel->insertSingleActivityTableData('Inctive Statutory',$module,$action,$method,$statutoryId,$table);


        redirect(admin_except_base_url().'statutorymaster','refresh');





      }else{



          redirect('admin','refresh');



      }



  }





}  