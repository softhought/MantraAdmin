<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class User extends MY_Controller {

    public function __construct() {

        parent::__construct(); 
        $this->load->model('commondatamodel','commondatamodel',TRUE);
        $this->load->model('Usermodel','user',TRUE);       
        $this->load->module('template');
    }





    public function index()

	{   
		if($this->session->userdata('mantra_user_detail'))

		{  
           
            $session = $this->session->userdata('mantra_user_detail');         

            $data['view_file'] = "usermanagement/user";
            $data['userslist']=$this->user->getUserList($session['user_role']); 
            $this->template->admin_template($data);  

        }else{

			redirect('login','refresh');

		}

    }



    public function create()

    {

        $session = $this->session->userdata('mantra_user_detail');

		if($this->session->userdata('mantra_user_detail'))

		{  
            $data['view_file'] = "usermanagement/createuser";           
            $data['userRoleList']=$this->user->getUserRoleList($session['user_role']);

            $this->template->admin_template($data); 

        }else{

			redirect('admin','refresh');

		}

    }



    public function store()

    {

        $session = $this->session->userdata('mantra_user_detail');

		if($this->session->userdata('mantra_user_detail'))

		{  

            $name=$this->input->post('name');

            $user_name=$this->input->post('user_name');

            $mobile_no=$this->input->post('mobile_no');

            $user_role_id=$this->input->post('user_role_id');

            $password=$this->input->post('password');

            $date=date('Y-m-d H:i:s');

             $insert_Arr=[

                 'name'=>$name,

                 'user_name'=>$user_name,

                 'mobile_no'=>$mobile_no,

                 'user_role_id'=>$user_role_id,

                 'password'=>md5($password),

                 'created_at'=>$date,

                 'updated_at'=>$date,
                 'created_by'=>$session['userid']
             ];



            

            $id= $this->commondatamodel->insertSingleTableData('users',$insert_Arr);

            if ($id>0) {


            /** audit trail */ 
             $module = 'user';           
             $action = "Insert";
             $method = 'user/store';
             $table="users";
             $this->commondatamodel->insertSingleActivityTableData('Active User Account',$module,$action,$method,$userId,$table);





                $this->session->set_flashdata('success', 'User created successfully');

            }else{

                $this->session->set_flashdata('error', 'oops! an error occur');

            }

            redirect(admin_except_base_url().'user');



        }else{

			redirect('login','refresh');

		}

    }



    public function ActiveUser()

    {

        $session = $this->session->userdata('mantra_user_detail');

		if($this->session->userdata('mantra_user_detail'))

		{   
            $userId=$this->uri->segment(4);          

            $this->user->ActiveInactiveUserAccount($userId,'Y');
         
             /** audit trail */ 
             $module = 'user';           
             $action = "Insert";
             $method = 'user/ActiveUser';
             $table="users";
             $this->commondatamodel->insertSingleActivityTableData('Active User Account',$module,$action,$method,$userId,$table);

            redirect(admin_except_base_url().'user','refresh');



        }else{

			redirect('admin','refresh');

		}

    }

    public function InactiveUser()

    {

        $session = $this->session->userdata('mantra_user_detail');

		if($this->session->userdata('mantra_user_detail'))

		{   
            $userId=$this->uri->segment(4);
            $this->user->ActiveInactiveUserAccount($userId,'N');
            /** audit trail */ 
            $module = 'user';           
            $action = "Insert";
            $method = 'user/InactiveUser';
            $table="users";
            $this->commondatamodel->insertSingleActivityTableData('Inactive User Account',$module,$action,$method,$userId,$table);

            redirect(admin_except_base_url().'user','refresh');


        }else{

			redirect('admin','refresh');

		}

    }

    

    public function getloginLogoutDetailByUserId()

    {

        $userid=$this->input->post('userid');

        

        $table="";

        $userActivity=$this->user->getUserAccountActivity($userid);

        $table="<table id='loginLogoutTable' class='table customTbl table-bordered table-striped dataTables' style='border-collapse: collapse !important;'>

                    <thead>

                        <tr>

                            <th>Login Date & Time</th>

                            <th>Logout Date & Time</th>

                            <th>Browser</th>

                            <th>Device OS</th>

                        </tr>

                    </thead>

                    <tbody>";

                        foreach ($userActivity as $Activity) {

                            $table .="<tr>

                                        <td>".$Activity->login_time."</td>

                                        <td>".$Activity->logout_time."</td>

                                        <td>".$Activity->user_browser."</td>

                                        <td>".$Activity->user_platform."</td>                        

                                    </tr>";

                        }

                    $table .="</tbody>

                </table>";

        echo $table;

    }

 



}// end of class