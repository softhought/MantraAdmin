<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Menupermission extends MY_Controller {

    public function __construct() {

        parent::__construct();

        $this->load->library('session');
        $this->load->model('commondatamodel','commondatamodel',TRUE);
        $this->load->model('Menupermissionmodel','Menupermissionmodel',TRUE);  
        $this->load->module('template');     

    }





    public function index()

    {

        $session = $this->session->userdata('mantra_user_detail');
		if($this->session->userdata('mantra_user_detail'))
		{  
            $data['view_file'] = "usermanagement/usermenu";

            $data['userslist']=$this->Menupermissionmodel->getUserList($session['user_role']);
            $data['Menulist'] =$this->Menupermissionmodel->getMenuList($session['user_role'],$session['userid']);                          
           
            $this->template->admin_template($data); 

        }else{

			redirect('admin','refresh');

		}

    }

    

    public function getUsersPermittedMenu()

    {

        $session = $this->session->userdata('mantra_user_detail');

		if($this->session->userdata('mantra_user_detail'))

		{  

            $userId=$this->input->post('userId');

            $menuId= $this->Menupermissionmodel->getUsersPermittedMenu($userId);
//pre($menuId);exit;
            $json_response = array(

                "data" =>$menuId

            );



            header('Content-Type: application/json');

            echo json_encode( $json_response );

            exit;

           

        }else{

			redirect('admin','refresh');

		}

    }



    public function AssignMenu()

    {   $session = $this->session->userdata('mantra_user_detail');

		if($this->session->userdata('mantra_user_detail'))

		{   



            $userId=$this->input->post('userId');
            $menuIds=explode(",",$this->input->post('MenuString'));

            $count=$this->Menupermissionmodel->getMenuCount($userId);
            if($count>0)
            {
                $this->Menupermissionmodel->DeletePermittedMenu($userId);
            }         

                foreach ($menuIds as $key => $menuid) {
                    $insert_Arr=array(
                        "user_id"=>$userId,
                        "menu_id"=>$menuid,
                        'created_at'        =>date('Y-m-d H:i:s'),
                        'updated_at'        =>date('Y-m-d H:i:s'),
                    );

                    $masterId=$this->Menupermissionmodel->InsertPermittedMenu($insert_Arr);        

                     /** audit trail */ 
             $module = 'Menupermission';           
             $action = "Delete & Insert";
             $method = 'Menupermission/AssignMenu';
             $table="admin_menu_permission";
             $this->commondatamodel->insertSingleActivityTableData('Menu Permission',$module,$action,$method,$userId,$table);

                } 


            $json_response = array(
                "status"=>1,
                "msg" =>'Menu permitted successfully'
            );

            header('Content-Type: application/json');
            echo json_encode( $json_response );
            exit;
        }else{
            redirect('admin','refresh');
        }        

    }























}//end of class