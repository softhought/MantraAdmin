<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Userauditmodel extends CI_Model {



    public function getAuditList($user_id)

    {

        $data = array();

        if ($user_id==1) { // 1 is the id for developer role

            $this->db->select("users.name,users.user_name,admin_activity_log.*")

            ->from('admin_activity_log')

            ->join('users','users.id = admin_activity_log.user_id','INNER')

            ->order_by('activity_date','DESC')
            ->limit(2000);

        }else{

            $this->db->select("users.name,users.user_name,admin_activity_log.*")

            ->from('admin_activity_log')

            ->join('users','users.id = admin_activity_log.user_id','INNER')

            ->where_not_in('users.user_role_id',1)

            ->order_by('activity_date','DESC')
            ->limit(2000);

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

             

        }

		else

		{

             return $data;

         }

    }



    

}//end of class