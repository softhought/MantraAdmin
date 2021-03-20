<?php 

if(!defined('BASEPATH')) exit('No direct script access allowed');



class Template_model extends CI_Model  {

    

    public function __construct()

	{

	    parent::__construct();

	}

	  public function getSearchParentMenuList($user_id)
   {
    $data = [];
       $where_Ary = array(
           "admin_menu_master.is_parent" => "P",
           "admin_menu_master.is_active" => "Y",
		   "admin_menu_permission.user_id" => $user_id
       );
        $this->db->select("admin_menu_master.*")
               ->from('admin_menu_master')
			   ->join('admin_menu_permission','admin_menu_master.id=admin_menu_permission.menu_id')
               ->where($where_Ary)
               ->order_by('admin_menu_master.menu_srl','ASC');
      $query = $this->db->get();
      #q();
       if ($query->num_rows()> 0)
        {
            foreach($query->result() as $rows)
            {
                $data[] = $rows;
            }

          }

          return $data;

   }


    public function getSearchMenuListParentId($menu_id,$user_id)
   {
    $data = [];
       $where_Ary = array(
           "admin_menu_master.is_parent" => "C",
           "admin_menu_master.is_active" => "Y",
           "admin_menu_master.parent_id" => $menu_id,
		   "admin_menu_permission.user_id" => $user_id
       );
        $this->db->select("admin_menu_master.*")
               ->from('admin_menu_master')
			   ->join('admin_menu_permission','admin_menu_master.id=admin_menu_permission.menu_id')
               ->where($where_Ary)
               ->order_by('admin_menu_master.menu_srl','ASC');
      $query = $this->db->get();
     # q();echo "<br>";
       if ($query->num_rows()> 0)
        {
            foreach($query->result() as $rows)
            {
                $data[] = $rows;
            }

          }

          return $data;

   }



    public function getadminmenulist($table,$user_id)

	{

		$data = array();

		$where_Ary = array(

			"admin_menu_master.is_parent" => "P",

			"admin_menu_master.is_active" => "Y",

			"admin_menu_permission.user_id" => $user_id

			

		);

		

		$this->db->select("*")

				->from($table)

				->join('admin_menu_permission','admin_menu_master.id=admin_menu_permission.menu_id')

				->where($where_Ary)

				->order_by('admin_menu_master.menu_srl','ASC');

		$query = $this->db->get();

		//echo q();exit;

		if ($query->num_rows() > 0) 

		   {

			  foreach($query->result() as $rows)

			  {

					$data[] = array(

							"first_menu_id" => $rows->menu_id,

							"menu_name" => $rows->menu_name,

							"menu_link" => $rows->menu_link,

							"is_parent" => $rows->is_parent,

							"parent_id" => $rows->parent_id,

							"secondLevelMenu" => $this->getSecondLevelMenu($rows->menu_id,$user_id) 

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

			"admin_menu_permission.user_id" => $user_id

		);

		

		$this->db->select("*")

				->from('admin_menu_master')

				->join('admin_menu_permission','admin_menu_master.id=admin_menu_permission.menu_id')

				->where($where_Ary)

				->order_by('admin_menu_master.menu_srl','ASC');

		$query = $this->db->get();

		

		if($query->num_rows() > 0) 

		   {

				foreach($query->result() as $rows)

				{

					$data[] = array(

							"second_menu_id" => $rows->menu_id,

							"second_menu_name" => $rows->menu_name,

							"second_menu_link" => $rows->menu_link,

							"second_is_parent" => $rows->is_parent,

							"second_parent_id" => $rows->parent_id,

							"secondLevelMenu" => $this->getSecondLevelMenu($rows->menu_id,$user_id) 

						 );

				}

		   }

		   return $data;

	}

	





	





}