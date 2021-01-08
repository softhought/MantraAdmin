<?php (defined('BASEPATH')) OR exit('No direct script access allowed');



class Enquirywing extends MY_Controller{

	

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

        //pre($session);exit;

        $data['wingslist'] = $this->enquirymodel->gatallwingslist();  

        // pre($data['branchlist']);exit;

        $data['view_file'] = 'dashboard/front_office/masters/enquiry_wings_list';       

        $this->template->admin_template($data);  

		

    }else{

        redirect('admin','refresh');

  

  }



}



  public function addeditwings(){



    

    if($this->session->userdata('mantra_user_detail'))

    {   
      $session = $this->session->userdata('mantra_user_detail');


        if($this->uri->segment(4) == NULL){





            $data['mode'] = "ADD";    

            $data['btnText'] = "Save";    

            $data['btnTextLoader'] = "Saving...";    

            $data['wingId'] = 0;    

            $data['wingEditdata'] = [];  

    

    

           }else{      

    

              $data['mode'] = "EDIT";    

              $data['btnText'] = "Update";    

              $data['btnTextLoader'] = "Updating...";    

              $data['wingId'] = $this->uri->segment(4);     

               $where = array('wing_id'=>$data['wingId']);      

               $data['wingEditdata'] = $this->commondatamodel->getSingleRowByWhereCls('enquiry_wings',$where);   

                        

           }

            // $where_cat = array('is_active'=>'Y','company_id'=>$session['companyid']);
            $where_cat = array('is_active'=>'Y');

           $data['wingcatlist'] = $this->commondatamodel->getAllRecordWhere('wings_category_master',$where_cat);

        //pre($data['wingcatlist']);exit;

       $data['view_file'] = 'dashboard/front_office/masters/addedit_wings'; ;       

        $this->template->admin_template($data);  

		

    }else{

        redirect('admin','refresh');

  

  }



  }



  public function addedit_action(){



    if($this->session->userdata('mantra_user_detail'))



    {

      $session = $this->session->userdata('mantra_user_detail');

        $dataArry=[];

        $json_response = array();

        $formData = $this->input->post('formDatas');

        parse_str($formData, $dataArry);



        $wingId = trim(htmlspecialchars($this->input->post('wingId')));

        $mode = trim(htmlspecialchars($this->input->post('mode')));

        $category = trim(htmlspecialchars($this->input->post('category')));

        $wing_name = trim(htmlspecialchars($this->input->post('wing_name')));

        $short_desc = trim(htmlspecialchars($this->input->post('short_desc')));

       

              

          

           if ($mode == "ADD" && $wingId == "0") {



             

            

              $insert_arr = array(

                  'wing_name'=>strtoupper($wing_name),

                  'short_description'=>$short_desc, 

                  'wing_category_id'=> $category,               

                  'is_active'=>'Y',
                  'company_id'=> $session['companyid']

                 

                    );



                $upd_inser = $this->commondatamodel->insertSingleTableData('enquiry_wings',$insert_arr);



                 /** audit trail */ 

                  $module = 'Enquiry Wings';           

                  $action = "Insert";

                  $method = 'enquirywing/addedit_action';

                  $table="enquiry_wings";

                  $old_details="";

                  $new_details = json_encode($insert_arr);

                  $this->commondatamodel->insertSingleActivityTableData('Add Wing',$module,$action,$method,$upd_inser,$table,$old_details,$new_details);





            } else{



                      $update_arr =  array(

                        'wing_name'=>strtoupper($wing_name),

                        'short_description'=>$short_desc,

                        'wing_category_id'=> $category,                 

                        'is_active'=>'Y',

                       

                          );



                $where = array('wing_id'=>$wingId);

                $olddtl = $this->commondatamodel->getSingleRowByWhereCls('enquiry_wings',$where);

                $upd_inser = $this->commondatamodel->updateSingleTableData('enquiry_wings',$update_arr,$where);

                 /** audit trail */ 

                 $module = 'Enquiry Wings';           

                 $action = "Update";

                 $method = 'enquirywing/addedit_action';

                 $table="enquiry_wings";

                 $old_details = json_encode($olddtl);

                 $new_details = json_encode($update_arr);

                 $this->commondatamodel->insertSingleActivityTableData('Update Wing',$module,$action,$method,$wingId,$table,$old_details,$new_details);



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

public function existingwing(){

    if($this->session->userdata('mantra_user_detail'))

    {     

    
      $session = $this->session->userdata('mantra_user_detail');
      $wing_name = $this->input->post('wing_name'); 
      $category = $this->input->post('category'); 

      $wingId = $this->input->post('wingId');   

      // $where = array('wing_name'=>$wing_name,'wing_category_id'=>$category,'company_id'=>$session['companyid']);  
      $where = array('wing_name'=>$wing_name,'wing_category_id'=>$category);  

      $where_notequal = "wing_id !=".$wingId;

      if($wingId == 0){

        $existing = $this->commondatamodel->checkExistanceData('enquiry_wings',$where);    

     }else{

        $existing = $this->commondatamodel->checkExistanceDataWhereNotIn('enquiry_wings',$where,$where_notequal);

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

public function activewing()

  {

      $session = $this->session->userdata('mantra_user_detail');

      if($this->session->userdata('mantra_user_detail'))

      {   

         $wing_id=$this->uri->segment(4); 



          $where = array('wing_id'=>$wing_id);

          $data = array('is_active'=>'Y');

          $this->commondatamodel->ActiveInactive('enquiry_wings',$data,$where);

           /** audit trail */ 

           $module = 'Enquiry Wings';           

           $action = "Active";

           $method = 'enquirywing/activewing';

           $table="enquiry_wings";

           $this->commondatamodel->insertSingleActivityTableData('Active Wing',$module,$action,$method,$wing_id,$table);



          redirect(admin_except_base_url().'enquirywing','refresh');







      }else{



          redirect('admin','refresh');



      }



  }



  public function inactivewing()



  {



      $session = $this->session->userdata('mantra_user_detail');



      if($this->session->userdata('mantra_user_detail'))



      {   

        $wing_id=$this->uri->segment(4); 

        $where = array('wing_id'=>$wing_id);

        $data = array('is_active'=>'N');

        $this->commondatamodel->ActiveInactive('enquiry_wings',$data,$where);

         /** audit trail */ 

         $module = 'Enquiry Wings';           

         $action = "Inactive";

         $method = 'enquirywing/inactivewing';

         $table="enquiry_wings";

         $this->commondatamodel->insertSingleActivityTableData('Inactive Wing',$module,$action,$method,$wing_id,$table);



        redirect(admin_except_base_url().'enquirywing','refresh');





      }else{



          redirect('admin','refresh');



      }



  }





}  