<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Menupermissionmodel extends CI_Model{





 public function getUserList($userRole)

 {

     // 1 is the role id for Developer      

     if ($userRole==1) {

        $this->db->select("*")->from('users')->where('is_active','Y');

        

     }else{

        $this->db->select("*")->from('users')->where('is_active','Y')->where_not_in('user_role_id',1);

     }



     $query = $this->db->get();

     // echo $this->db->last_query();



    if($query->num_rows()> 0)

    {

        foreach ($query->result() as $rows)

        {

            $data[] = $rows;

        }

         return $data;

          

    }else{

        return $data;

    }



 }



 public function getMenuList($userRole,$user_id=null)

 {

     // 1 is the role id for Developer 

    if ($userRole==1) {

     return  $this->getAllAdministrativeMenuDevOnly();

    }else{

     return  $this->getAllAdministrativeMenu($user_id);

    }

   

 }



   /** menu list for developer (developer will have all the menu access ) */



   public function getAllAdministrativeMenuDevOnly()

   {

       $data = array();

       $where_Ary = array(

           "admin_menu_master.is_parent" => "P",

           "admin_menu_master.is_active" => "Y"

       );

       

       $this->db->select("*")->from('admin_menu_master')

                    ->where($where_Ary)

                    ->order_by('admin_menu_master.menu_srl','ASC');

        $query = $this->db->get();



        if ($query->num_rows()> 0)

        {

            foreach($query->result() as $rows)

            {

                $data[] = array(

                        "FirstLevelMenuData" => $rows,

                        "secondLevelMenu" => $this->getSecondLevelMenuDevOnly($rows->id) 

                    );

            }

        }

          return $data;

   }



   public function getSecondLevelMenuDevOnly($parentID)

   {

       $data = array();

       $where_Ary = array(

           "admin_menu_master.parent_id" => $parentID,

           "admin_menu_master.is_active" => "Y"

       );

       

       $this->db->select("*")->from('admin_menu_master')

               ->where($where_Ary)

               ->order_by('admin_menu_master.menu_srl','ASC');

        $query = $this->db->get();

        // pre($this->db->last_query());

       if($query->num_rows()> 0)

          {

               foreach($query->result() as $rows)

               {

                   $data[] = array(

                           "secondLevelMenuData" => $rows,

                           "thirdLevelMenu" => $this->getThirdLevelMenuDevOnly($rows->id) 

                        );

               }

          }

          return $data;

   }

   

   public function getThirdLevelMenuDevOnly($parentID)

   {

       $data = array();

       $where_Ary = array(

           "admin_menu_master.parent_id" => $parentID,

           "admin_menu_master.is_active" => "Y"

       );

       

        $this->db->select("*")->from('admin_menu_master')

               ->where($where_Ary)

               ->order_by('admin_menu_master.menu_srl','ASC');

        $query = $this->db->get();

       if($query->num_rows()>  0) 

       {

           foreach($query->result() as $rows)

           {

               $data[] = array(

                       "thirdLevelMenuData" =>$rows,

                   );

           }

       }

          return $data;

   }

/** end  menu list for developer  */



   public function getAllAdministrativeMenu($user_id)

   {

       $data = array();

       $where_Ary = array(

           "admin_menu_master.is_parent" => "P",

           "admin_menu_master.is_active" => "Y",

           "admin_menu_permission.user_id" => $user_id,

       );

       

        $this->db->select("admin_menu_master.*")->from('admin_menu_master')

               ->join('admin_menu_permission','admin_menu_master.id=admin_menu_permission.menu_id')

               ->where($where_Ary)

               ->order_by('admin_menu_master.menu_srl','ASC');

        $query = $this->db->get();

        

       if ($query->num_rows()> 0)

          {

             foreach($query->result() as $rows)

             {

                   $data[] = array(

                           "FirstLevelMenuData" => $rows,

                           "secondLevelMenu" => $this->getSecondLevelMenu($rows->id,$user_id) 

                        );

            }

          }

          return $data;

   }



   public function getSecondLevelMenu($parentID,$user_id)

   {

       $data = array();

       $where_Ary = array(

           "admin_menu_master.parent_id" => $parentID,

           "admin_menu_master.is_active" => "Y",

           "admin_menu_permission.user_id" => $user_id,

       );

       

        $this->db->select("admin_menu_master.*")->from('admin_menu_master')

               ->join('admin_menu_permission','admin_menu_master.id=admin_menu_permission.menu_id')

               ->where($where_Ary)

               ->order_by('admin_menu_master.menu_srl','ASC');

              

               $query = $this->db->get();

            //    pre($this->db->last_query());exit;

       if($query->num_rows()> 0)

          {

               foreach($query->result() as $rows)

               {

                   $data[] = array(

                           "secondLevelMenuData" => $rows,

                           "thirdLevelMenu" => $this->getThirdLevelMenu($rows->id,$user_id) 

                        );

               }

          }

          return $data;

   }

   

   public function getThirdLevelMenu($parentID,$user_id)

   {

       $data = array();

       $where_Ary = array(

           "admin_menu_master.parent_id" => $parentID,

           "admin_menu_master.is_active" => "Y",

           "admin_menu_permission.user_id" => $user_id,

       );

       

      $this->db->select("admin_menu_master.*")->from('admin_menu_master')

               ->join('admin_menu_permission','admin_menu_master.id=admin_menu_permission.menu_id')

               ->where($where_Ary)

               ->order_by('admin_menu_master.menu_srl','ASC');

        $query = $this->db->get();

       if($query->num_rows()> 0) 

       {

           foreach($query->result() as $rows)

           {

               $data[] = array(

                       "thirdLevelMenuData" =>$rows,

                   );

           }

       }

          return $data;

   }

   



    public function getUsersPermittedMenu($userId)

    {

        $data = array();

        $this->db->select("admin_menu_master.id")->from('admin_menu_permission')

                ->join('admin_menu_master','admin_menu_master.id=admin_menu_permission.menu_id','INNER')

                ->where('admin_menu_permission.user_id',$userId)
                ->where('admin_menu_master.is_parent <>','P');
        $query = $this->db->get();
         #echo $this->db->last_query();exit;
        if($query->num_rows()> 0) 

        {

            

            foreach($query->result() as $rows)

            {

                $data[] = $rows;

            }

        }

        return $data;

    }



    public function getMenuCount($userId)

    {

        $this->db->select('*')

				->from('admin_menu_permission')->where('user_id',$userId);



		$query = $this->db->get();

		$rowcount = $query->num_rows();

	

		if($query->num_rows()>0){

			return $rowcount;

		}

		else

		{

			return 0;

		}

    }



    public function DeletePermittedMenu($userId)

    {

        $this->db->delete('admin_menu_permission', array('user_id'=>$userId)); 

        

    }



    public function InsertPermittedMenu($insert_Arr)

    {    

        $lastinsert_id = 0;

        try {

            $this->db->trans_begin();



            $this->db->insert('admin_menu_permission', $insert_Arr);

            $lastinsert_id = $this->db->insert_id();



            if ($this->db->trans_status() === FALSE) {

                $this->db->trans_rollback();

                $lastinsert_id=0;

                return $lastinsert_id;

            } else {

                $this->db->trans_commit();

                return $lastinsert_id;

            }

        } catch (Exception $err) {

            echo $err->getTraceAsString();

        }

        

    }















}//end of class