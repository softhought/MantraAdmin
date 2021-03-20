<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Youtubevideo extends MY_Controller{
	
function __construct()
	{
		 parent::__construct();
		 $this->load->model('commondatamodel','commondatamodel',TRUE);
		 $this->load->model('accountmodel','accountmodel',TRUE);
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
        $data['videoList'] = $this->commondatamodel->getAllRecordWhereOrderBy('videogallery',$where,$orderby);
       // pre($data['videoList']);exit;
        $data['view_file'] = 'dashboard/front_office/masters/video/youtube_video_view';       
        $this->template->admin_template($data);  
		
    }else{
        redirect('admin','refresh');
  
  }

  }

  
  public function addVideo(){

    $session = $this->session->userdata('mantra_user_detail');

    if($this->session->userdata('mantra_user_detail'))
    {  
        $company_id=$session['companyid'];
        $year_id=$session['yearid'];
       if($this->uri->segment(4) == NULL){

        $data['mode'] = "ADD";
        $data['btnText'] = "Save";
        $data['btnTextLoader'] = "Saving...";
        $data['videoId'] = 0;
        $data['videoEditdata'] = [];
       

       }else{

          $data['mode'] = "EDIT";
          $data['btnText'] = "Update";
          $data['btnTextLoader'] = "Updating...";
          $data['videoId'] = $this->uri->segment(4);
          $where = array('id'=>$data['videoId']);
          $data['videoEditdata'] = $this->commondatamodel->getSingleRowByWhereCls('videogallery',$where);


       }


       
      // exit;

        $data['view_file'] = 'dashboard/front_office/masters/video/addedit_youtube_video.php';  
        $header="";

        $this->template->admin_template($data);  

    }else{

        redirect('admin','refresh');

    }

}

  public function video_action() {

     $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))

    {
         
        $mode = $this->input->post('mode');
        $videoId = $this->input->post('videoId');
        $video_title = trim($this->input->post('video_title'));
        $video_url = trim($this->input->post('video_url'));
        $show_tag = $this->input->post('show_tag');
     


        $company_id=$session['companyid'];
        $year_id=$session['yearid'];

        if ($mode == "ADD" && $videoId == "0") {

            $insert_arr = array(                             
                                'videotitle' => $video_title,
                                'videolink' => $video_url,                     
                                'showtag' => $show_tag,                     
                                'is_active' => 'Y',
                                'company_id' => $company_id,
                                'entry_date' => date('Y-m-d h:i'),
                           );

             $insertData = $this->commondatamodel->insertSingleTableData('videogallery',$insert_arr);



                /** audit trail */ 
                  $module = 'Youtube Video ';           
                  $action = "Insert";
                  $method = "youtubevideo/video_action";

                  $table="videogallery";
                  $old_details="";
                  $new_details = json_encode($insert_arr);
                  $this->commondatamodel->insertSingleActivityTableData('Add Youtube Video',$module,$action,$method,$insertData,$table,$old_details,$new_details);


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
                                'videotitle' => $video_title,
                                'videolink' => $video_url,                     
                                'showtag' => $show_tag,  
                                'is_active' => 'Y',                                              
                           );
                $where = array('id'=>$videoId);
                $olddtl = $this->commondatamodel->getSingleRowByWhereCls('videogallery',$where);
                $upd_insert = $this->commondatamodel->updateSingleTableData('videogallery',$update_arr,$where);



                  /** audit trail */ 
                  $module = 'Youtube Video ';           
                  $action = "Insert";
                  $method = "youtubevideo/video_action";

                  $table="videogallery";
                 $old_details = json_encode($olddtl);
                 $new_details = json_encode($update_arr);
                 $this->commondatamodel->insertSingleActivityTableData('Update Youtube Video ',$module,$action,$method,$videoId,$table,$old_details,$new_details);


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





}/* end of class  */