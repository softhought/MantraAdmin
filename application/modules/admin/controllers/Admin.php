<?php (defined('BASEPATH')) OR exit('No direct script access allowed');



class Admin extends MY_Controller{

	

function __construct()

	{

		 parent::__construct();
         $this->load->library('session');
		 $this->load->model('commondatamodel','commondatamodel',TRUE);

           $this->load->model("Loginmodel", "login");

	

	}



public function index(){

       

        $this->load->library('form_validation'); 

        $where = array('is_active'=>'Y');

        $orderby="year_id desc";

        $result['financilayear'] = $this->commondatamodel->getAllRecordWhereOrderBy('year_master',$where,$orderby);        

        

        $page = 'login/login_view';        

        //pre($result['financilayear']);exit; 

        $this->load->view($page,$result);

     



   }



public function getcompanydtl(){

       

     $registration_no = $this->input->post('registration_no');



     $where = array('registration_no'=>$registration_no);

     $branchdtl = array();

     $companydtl = $this->commondatamodel->getAllRecordWhere('company_master',$where);   

     $companylist = '';

     $brnachlist = '';

     //$companylist.='<select name="company" id="company" class="custom-select">';

     if(!empty($companydtl)){

     foreach($companydtl as $companydtl){

         

          $companylist.='<option value="'.$companydtl->comany_id.'">'.$companydtl->company_name.'</option>';

          $where = array('company_id' => $companydtl->comany_id,'is_active'=>'Y');

          $branchdtl = $this->commondatamodel->getAllRecordWhere('branch_master',$where); 

     }

    

    // $companylist.='</select>';

     //pre($branchdtl);exit;

   }else{

     $companylist = '<option value="">Select</option>';

   }

   $brnachlist = '<option value="">Select</option>';

   if(!empty($branchdtl)){

     foreach($branchdtl as $branchdtl){ 



          $brnachlist.='<option value="'.$branchdtl->BRANCH_ID.'">'.$branchdtl->BRANCH_NAME.'</option>';

          

     }



    }

     $json_response = array('msg_status'=>1,'companylist'=>$companylist,'brnachlist'=>$brnachlist);



     header('Content-Type: application/json');

     echo json_encode( $json_response );

     exit; 

  



}





public function checklogin(){



        $this->load->helper('form');

        $this->load->library('form_validation');

        $this->form_validation->set_rules('registration_no', 'Username', 'required');

        $this->form_validation->set_rules('company', 'Username', 'required');

        $this->form_validation->set_rules('branch', 'Username', 'required');

        $this->form_validation->set_rules('username', 'Username', 'required');

        $this->form_validation->set_rules('password', 'Password', 'required');

        $this->form_validation->set_rules('yearid', 'Password', 'required');

       

        $this->form_validation->set_error_delimiters('<div class="error-login">', '</div>');

       

        

        if ($this->form_validation->run() == FALSE)

           {

               $this->session->set_flashdata('msg','<div class="error-login">Invalid username or password</div>');       

                redirect('admin');  

                                  

           }

           else

           {



                $registration_no = $this->input->post('registration_no');

                $company = $this->input->post('company');

                $branch = $this->input->post('branch');

                $username = $this->input->post('username');

                $password = $this->input->post('password');

                $yearid = $this->input->post('yearid');



                $level = "";

                $verification_req = "";

                $isverificationreq = "N";

               

               //  $where = array('user_name'=>$username,'user_pwd'=>$password);

               //  $userdtl = $this->commondatamodel->getSingleRowByWhereCls('user_master',$where); 

               //  if(!empty($userdtl)){

                   

               //      $level = $userdtl->user_level;

               //      $verification_req = $userdtl->qr_verification_required;

                  

                  

               //  }



                $user_id = $this->login->checkLogin($username,$password,$branch,$company);

                

                if($user_id!=""){

                    $arr=[

                        

                        "user_id"=>$user_id,

                        "ip_address"=>getUserIPAddress(),

                        "user_browser"=>getUserBrowserName(),

                        "user_platform"=>getUserPlatform(),

                        "login_time"=>date('Y-m-d H:i:s')

                       

                    ];

                   

                   $insertid= $this->commondatamodel->insertSingleTableDataRerurnInsertId('user_account_activity',$arr);

                    $where=['id'=>$user_id];

                    $this->commondatamodel->updateSingleTableData('users',array('is_online'=>'Y','updated_at'=>date('Y-m-d H:i:s')),$where);



                    $user = $this->login->get_user($user_id);

                    $branchdtl = $this->login->get_branch($branch);

                    $companytl = $this->login->get_company($company);

                    $financialyear = $this->login->get_financialyear($yearid);

                    



                    $user_session = [

                    "userid"=>$user->id,

                    "username"=>$user->user_name,

                    "user_role"=>$user->user_role_id,

                    "branchid"=>$branch,

                    "companyid"=>$company,

                    "yearid"=>$yearid,

                    "fullname"=>$user->name,

                    "branchcode"=>$branchdtl->BRANCH_CODE,

                    "acc_period"=>$financialyear->acc_period,

                    "companyname"=>$companytl->company_name,

                    "user_account_activity_id"=>$insertid

                ];

               // pre($user_session);exit;

                 $this->setSessionData($user_session);

                 redirect('admin/dashboard');

                    

                }else{

                     $this->session->set_flashdata('msg','<div style="color: red;" class="error-login">Invalid username or password</div>');

                     redirect('admin');

                }

           }



   }



  private function setSessionData($result = NULL) {



        if ($result) {

            $this->session->set_userdata("mantra_user_detail", $result);

        }

    }



function logout(){



     $session = $this->session->userdata('mantra_user_detail');

        $where=[

            "id"=>$session['user_account_activity_id']

        ];

        $this->commondatamodel->updateSingleTableData('user_account_activity',array("logout_time"=>date('Y-m-d H:i:s')),$where);



        $where1=[

            'id'=>$session['userid']

        ];

        $this->commondatamodel->updateSingleTableData('users',array('is_online'=>'N','updated_at'=>date('Y-m-d H:i:s')),$where1);

   

    
        $this->session->unset_userdata('mantra_user_detail');
    //  $this->session->sess_destroy();

     redirect('admin');

 }







}