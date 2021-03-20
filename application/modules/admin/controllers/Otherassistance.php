<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Otherassistance extends MY_Controller{
	
function __construct()
	{
		 parent::__construct();
		 $this->load->model('commondatamodel','commondatamodel',TRUE);
		 $this->load->model('dietmodel','_dietmodel',TRUE);	
         $this->load->module('template');
		
	}

public function index(){ 
    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {   
        $company_id=$session['companyid'];
        $year_id=$session['yearid'];
        $where = array('company_id' => $company_id);
        $orderby='videotitle'; 
        $data['otherAssistanceList'] = $this->_dietmodel->GetAllOtherAssistanceData();
        // pre($data['otherAssistanceList']);exit;
        $data['view_file'] = 'dashboard/diet/masters/other_assistance/other_assistance_view';       
        $this->template->admin_template($data);  
		
    }else{
        redirect('admin','refresh');
  
    }

  }

  
  public function addOtherassistance(){
    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {  
        $company_id=$session['companyid'];
        $year_id=$session['yearid'];
       if($this->uri->segment(4) == NULL){

        $data['mode'] = "ADD";
        $data['btnText'] = "Save";
        $data['btnTextLoader'] = "Saving...";
        $data['otherassId'] = 0;
        $data['otherAssisEditdata'] = [];
 
       }else{

          $data['mode'] = "EDIT";
          $data['btnText'] = "Update";
          $data['btnTextLoader'] = "Updating...";
          $data['otherassId'] = $this->uri->segment(4);
          $where = array('id'=>$data['otherassId']);
          $data['otherAssisEditdata'] = $this->commondatamodel->getSingleRowByWhereCls('other_assistance_master',$where);

       }
      // exit;
        $orderby='othr_assistnc_name'; 
        $data['otherAssisCatg'] = $this->commondatamodel->getAllRecordWhereOrderBy('other_assistance_category',[],$orderby);
        $orderby2='unit_name'; 
        $data['rowFoodUnit'] = $this->commondatamodel->getAllRecordWhereOrderBy('diet_unit_master',[],$orderby2);
        $data['view_file'] = 'dashboard/diet/masters/other_assistance/addedit_other_assistance';  
        $header="";
        $this->template->admin_template($data);  

    }else{

        redirect('admin','refresh');

    }

}


  public function other_action() {
    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {
         $mealData = $_POST['formData'];
            parse_str($mealData, $data);
            //pre($data);exit;
            $mode = $data['mode'];
            $otherassId = $data['otherassId'];
   
     


        $company_id=$session['companyid'];
        $year_id=$session['yearid'];

        if ($mode == "ADD" && $otherassId == "0") {

            $insert_arr = array(                             
                                'othr_assis_catgID' => $data['other_assistnc_catg'],
                                'supplement_name' => $data['supplement_name'],                    
                                'quantity' => $data['quantity'],                     
                                'unit_id' => $data['other_assistnc_unit'],                     
                                'brand' => $data['brand'],                   
                                'supplement_remarks' => $data['supplement_remarks'],                     
                                'company_id' => $company_id,                     
                              
                           );

             $insertData = $this->commondatamodel->insertSingleTableData('other_assistance_master',$insert_arr);


             if (isset($data['componentName'])) {
                
                $detailLength = sizeof($data['componentName']);

                if($detailLength>0)
                {
                    for($i=0;$i<$detailLength;$i++)
                    {
                        $detailArray = array(
                            "other_assis_mastrID" => $insertData,
                            "component" => $data['componentName'][$i],
                           
                        );
                        $insertData2 = $this->commondatamodel->insertSingleTableData('other_assistance_detail',$detailArray);
                    }
                }
             }



                /** audit trail */ 
                  $module = 'other assistance master ';           
                  $action = "Insert";
                  $method = "otherassistance/other_action";

                  $table="other_assistance_master";
                  $old_details="";
                  $new_details = json_encode($insert_arr);
                  $this->commondatamodel->insertSingleActivityTableData('Add other_assistance_master',$module,$action,$method,$insertData,$table,$old_details,$new_details);


               if($insertData)
                    {
                        $json_response = array(
                            "msg_status" => 1,
                            "msg_data" => "Saved successfully",
                            "mode" => "ADD",
                        );

                    }
                    else
                    {
                        $json_response = array(
                            "msg_status" => 1,
                            "msg_data" => "There is some problem.Try again"
                        );

                    }



        }else{

              $update_arr = array(
                                'othr_assis_catgID' => $data['other_assistnc_catg'],
                                'supplement_name' => $data['supplement_name'],                    
                                'quantity' => $data['quantity'],                     
                                'unit_id' => $data['other_assistnc_unit'],                     
                                'brand' => $data['brand'],                     
                                'supplement_remarks' => $data['supplement_remarks'],                                             
                           );
                $where = array('id'=>$otherassId);
                $olddtl = $this->commondatamodel->getSingleRowByWhereCls('other_assistance_master',$where);
                $upd_insert = $this->commondatamodel->updateSingleTableData('other_assistance_master',$update_arr,$where);


               
             if (isset($data['componentName'])) {
                
                $detailLength = sizeof($data['componentName']);

                if($detailLength>0)
                { 
                     $this->deleteOtherAssistncDtl($otherassId);
                    for($i=0;$i<$detailLength;$i++)
                    {
                        $detailArray = array(
                            "other_assis_mastrID" => $otherassId,
                            "component" => $data['componentName'][$i],
                           
                        );
                       
                        $insertData2 = $this->commondatamodel->insertSingleTableData('other_assistance_detail',$detailArray);
                    }
                }
             }



                  /** audit trail */ 
                   $module = 'other assistance master ';           
                  $action = "Insert";
                  $method = "otherassistance/other_action";

                  $table="other_assistance_master";
                 $old_details = json_encode($olddtl);
                 $new_details = json_encode($update_arr);
                 $this->commondatamodel->insertSingleActivityTableData('Update other_assistance_master ',$module,$action,$method,$otherassId,$table,$old_details,$new_details);


               if($upd_insert)
                    {
                        $json_response = array(
                            "msg_status" => 1,
                            "msg_data" => "Saved successfully",
                            "mode" => "ADD",
                        );

                    }
                    else
                    {
                        $json_response = array(
                            "msg_status" => 1,
                            "msg_data" => "There is some problem.Try again"
                        );

                    }



            

        }


            header('Content-Type: application/json');
            echo json_encode( $json_response );
            exit;

   }else
		{
			redirect('login','refresh');
        }
        
  }


  
	public function setStatus(){
		$session = $this->session->userdata('mantra_user_detail');
		if($this->session->userdata('mantra_user_detail'))
		{
			$updID = trim($this->input->post('uid'));
			$setstatus = trim($this->input->post('setstatus'));
			
			$update_array  = array(
				"is_active" => $setstatus
				);
				
			$where = array(
				"id" => $updID
				);

			$update = $this->commondatamodel->updateSingleTableData('videogallery',$update_array,$where);
			if($update)
			{
				$json_response = array(
					"msg_status" => 1,
					"msg_data" => "Status updated"
				);
			}
			else
			{
				$json_response = array(
					"msg_status" => 0,
					"msg_data" => "Failed to update"
				);
			}


		header('Content-Type: application/json');
		echo json_encode( $json_response );
		exit;

		}
		else
		{
			redirect('admin','refresh');
		}
    }



  	public function checkAccountName(){
		$session = $this->session->userdata('mantra_user_detail');
		if($this->session->userdata('mantra_user_detail'))
		{
			$company_name = trim($this->input->post('company_name'));
            $mode = trim($this->input->post('mode'));
            $corporateCompanyId = trim($this->input->post('corporateCompanyId'));
            $company_id=$session['companyid'];
            $flag=0;
            
            if($mode=='ADD'){
                $where = array('company_name' => $company_name,'company_id' => $company_id);
                $checkData=$this->commondatamodel->duplicateValueCheck('corporate_company',$where);
                if($checkData){$flag=1;}
            }else{
                $where_notequal = "id !=".$corporateCompanyId;
                $where = array('company_name' => $company_name,'company_id' => $company_id);
                $checkData=$this->commondatamodel->checkExistanceDataWhereNotIn('corporate_company',$where,$where_notequal);
                if($checkData){$flag=1;}
            }

     
			if(!$flag)
			{
				$json_response = array(
					"msg_status" => 1,
					"msg_data" => "You can proceed"
				);
			}
			else
			{
				$json_response = array(
					"msg_status" => 0,
					"msg_data" => "Company name all ready exist!"
				);
			}


		header('Content-Type: application/json');
		echo json_encode( $json_response );
		exit;

		}
		else
		{
			redirect('admin','refresh');
		}
    }


	public function addComponentDetail(){
		$session = $this->session->userdata('mantra_user_detail');
		if($this->session->userdata('mantra_user_detail'))
		{
            $data['rowNo'] = $_POST['row'];
			
				  
      $page = 'dashboard/diet/masters/other_assistance/add_component_detail';   
      $this->load->view($page,$data);
		
		}
		else
		{
			redirect('admin','refresh');
		}

	}
function deleteOtherAssistncDtl($delId){
 
      $where = array('other_assistance_detail.other_assis_mastrID' => $delId);
      $this->commondatamodel->deleteTableData('other_assistance_detail',$where);
}

}/* end of class  */