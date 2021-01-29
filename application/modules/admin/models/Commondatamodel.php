<?php if (!defined('BASEPATH')) exit('No direct script access allowed');



class Commondatamodel extends CI_Model{

	

	public function insertSingleTableData($table,$data){

            $lastinsert_id = 0;

        try {

            $this->db->trans_begin();



            $this->db->insert($table, $data);

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

    

    public function updateSingleTableData($table,$data,$where){



        

        try {

            $this->db->trans_begin();

            //$this->db->where($where);

			$this->db->update($table, $data,$where);

			$this->db->last_query(); 

			

            //$affectedRow = $this->db->affected_rows();

            if ($this->db->trans_status() === FALSE) {

                $this->db->trans_rollback();

                

                return FALSE;

            } else {

                $this->db->trans_commit();

                

                return TRUE;

            }

        } catch (Exception $exc) {

             return FALSE;

        }

    }

    

    public function deleteTableData($table,$where)

    {

        $this->db->delete($table, $where); 

    }



	/* 

		@insertMultiTableData('name of table array','insert value as array')

		@date 14.11.2017

		@By Mithilesh

	*/

	

	public function insertMultiTableData($tblnameArry,$insertArray){

		try{

            $this->db->trans_begin();

			

			for($i=0;$i<sizeof($insertArray);$i++)

			{

				 $this->db->insert($tblnameArry[$i], $insertArray[$i]);

				 

			}

			if($this->db->trans_status() === FALSE) {

                $this->db->trans_rollback();

                return false;

            } else {

                $this->db->trans_commit();

                return true;

            }

        }

		catch (Exception $err) {

            echo $err->getTraceAsString();

        }

	}

	

	

	public function checkExistanceData($table,$where)

	{

		

		$this->db->select('*')

				->from($table)

				->where($where);

		$query = $this->db->get();

	   #echo $this->db->last_query();

		if($query->num_rows()>0){

			return 1;

		}

		else

		{

			return 0;

		}

		

	}

	

	public function getAllDropdownData($table)

	{

		$data = array();

		$this->db->select("*")

				->from($table);

		$query = $this->db->get();

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

public function getAllDropdownActiveDataByComId($table)

	{

		$session = $this->session->userdata('mantra_user_detail');

		$data = array();

		$this->db->select("*")

				->from($table)

				->where('company_id',$session['companyid'])

				->where('is_active','Y');

		$query = $this->db->get();

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

	

	public function getSingleRowByWhereCls($table,$where)

	{

		$data = array();

		$this->db->select("*")

				->from($table)

				->where($where)

				->limit(1);

		$query = $this->db->get();

		

		#echo "<br>".$this->db->last_query();

		

		if($query->num_rows()> 0)

		{

           $row = $query->row();

           return $data = $row;

             

        }

		else

		{

            return $data;

        }

	}

	

	

	public function getAllRecordWhere($table,$where)

	{

		$data = array();

		$this->db->select("*")

				->from($table)

				->where($where);

		$query = $this->db->get();

		#echo $this->db->last_query();



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





		

	public function getAllRecordWhereNotIn($table,$ignorarray=[])

	{  

		$data = array();

		$this->db->select("*")

				->from($table)

				->where_not_in('id',$ignorarray);

		$query = $this->db->get();

		echo $this->db->last_query();



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



	public function getAllRecordWhereOrderBy($table,$where,$orderby)

	{

		$data = array();

		$this->db->select("*")

				->from($table)

				->where($where)

				->order_by($orderby);

		$query = $this->db->get();

		#echo $this->db->last_query();



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



	public function getAllRecordOrderByLike($table,$likecolumn,$likeStr,$orderby,$ordertag)

	{

		$data = array();

		$this->db->select("*")

				->from($table)

				->like($likecolumn,$likeStr,'after')

				->order_by($orderby,$ordertag);

		$query = $this->db->get();

		//echo $this->db->last_query();



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





	public function getAllRecordOrderByLikeWhere($table,$where,$likecolumn,$likeStr,$orderby,$ordertag)

	{

		$data = array();

		$this->db->select("*")

				->from($table)

				->where($where)

				->like($likecolumn,$likeStr,'after')

				->order_by($orderby,$ordertag);

		$query = $this->db->get();

		//echo $this->db->last_query();



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



	public function getAllRecordOrderBy($table,$orderby,$orderTag)

	{

		$data = array();

		$this->db->select("*")

				->from($table)

				->order_by($orderby,$orderTag);

		$query = $this->db->get();

		//echo $this->db->last_query();



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



	/*

	@updateData_WithUserActivity('update table name','update table data','update table where condition','user activity table name','user activity table data');

	*/

	public function updateData_WithUserActivity($upd_tbl_name,$upd_data,$upd_where,$user_actvty_tbl,$user_actvy_data)

	{

		 try {

            $this->db->trans_begin();

			$this->db->where($upd_where);

            $this->db->update($upd_tbl_name,$upd_data);

         //   echo $this->db->last_query();

			$this->db->insert($user_actvty_tbl, $user_actvy_data);

			

			

				

            if($this->db->trans_status() === FALSE) {

                $this->db->trans_rollback();

                return false;

            } else {

                $this->db->trans_commit();

                return true;

            }

        }

		catch (Exception $err) {

            echo $err->getTraceAsString();

        }

	}





	/* fetching Data For All type of document from any module

	*  @getDocumentDetailData('where upload_from_module_id,upload_from_module');

	*  On 23.01.2018

	*  By Mithilesh

	*/



	public function getDocumentDetailData($where)

	{



		$data = array();

		$this->db->select("*")

				->from('document_upload_all')

				->join('document_type','document_type.id = document_upload_all.document_type_id','INNER')

				->where($where);

		$query = $this->db->get();

		//echo $this->db->last_query();



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





	public function rowcount($table)

	{

		

		$this->db->select('*')

				->from($table);



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

        /**

         * @author Abhik

         * @param type $table

         * @param type $column

         * @param type $dataType

         * @return boolean

         */

        

        public function duplicateValueCheck($table="",$where="")

        {

            

			$query = $this->db->select("*")->from($table)->where($where)->get();

			

            if($query->num_rows()>0){

			return TRUE;

		}

		else

		{

			return FALSE;

		}

            

            

        }





        public function insertSingleTableDataRerurnInsertId($table,$data){

		

			$this->db->insert($table, $data);

		    $insert_ID = $this->db->insert_id();

            return $insert_ID;

		}

		

			



	public function getNameById($where,$select,$table) {

		$query = $this->db->select($select)

						  ->from($table)

						  ->where($where)

						  ->get();

			//q();

			if ($query->num_rows() > 0) {

				$row = $query->row();

				return $row->$select;

			}else{

				return '';

			}

		}



		public function ActiveInactive($table,$data,$where)

		{

			

			try {

				$this->db->trans_begin();

				//$this->db->where($where);

				$this->db->update($table, $data,$where);

				$this->db->last_query();

				

				//$affectedRow = $this->db->affected_rows();

				if ($this->db->trans_status() === FALSE) {

					$this->db->trans_rollback();

					

					return FALSE;

				} else {

					$this->db->trans_commit();

					

					return TRUE;

				}

			} catch (Exception $exc) {

				 return FALSE;

			}

		}

public function insertSingleActivityTableData($act_module,$module,$action,$method,$userId,$table,$old_details="",$new_details=""){

	$session = $this->session->userdata('mantra_user_detail');

			$lastinsert_id = 0;

			$user_activity = array(

                "activity_module_admin" => $act_module,

                "activity_module" => $module,

                "action" => $action,

                "from_method" => $method,

                "module_master_id" => $userId,

                "user_id" =>$session['userid'],

                "table_name" => $table,

                "user_browser" => getUserBrowserName(),

                "user_platform" =>  getUserPlatform(),

				'ip_address'=>getUserIPAddress(),

				"old_description"=>$old_details,

				"description"=>$new_details,

				'company_id'=>$session['companyid'],

				'branch_id'=>$session['branchid']

            );

        try {

            $this->db->trans_begin();



            $this->db->insert('admin_activity_log', $user_activity);

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

public function GetUploadImage($data,$filename,$dir,$short_name="")

	{ 

		

     //$dir = $_SERVER['DOCUMENT_ROOT'].'/assets/img/member-images'; //local

	//	$dir1 = APPPATH.'assets/img/room'; 

	//	exit;

	

	$imagename = $short_name.uniqid().time();

	$config = array(

	 'upload_path' => $dir,

	 'allowed_types' => 'jpg|png|jpeg|gif',

	 'max_size' => '5120', // Can be set to particular file size , here it is 2 MB(2048 Kb)

	 'max_filename' => '255',

	 // 'encrypt_name' => TRUE,

	 'file_name'=>$imagename

	 );    

	 $this->load->library('upload', $config);

	 $images = array();

	 $detail_array = array();	

	  

	 $_FILES['images']['name']= $_FILES[$filename]['name'];

	 $_FILES['images']['type']= $_FILES[$filename]['type'];

	 $_FILES['images']['tmp_name']= $_FILES[$filename]['tmp_name'];

	 $_FILES['images']['error']= $_FILES[$filename]['error'];

	 $_FILES['images']['size']= $_FILES[$filename]['size'];

	 $this->upload->initialize($config);

	 

	 if ($this->upload->do_upload('images'))

	 {                   

		$file_detail = $this->upload->data();

		$file_name = $file_detail['file_name']; 

		return $file_name;

	 }        

       

  }	



  public function checkExistanceDataWhereNotIn($table,$where,$where_notequal)

	{

		

		$this->db->select('*')

				->from($table)

				->where($where)

				->where($where_notequal);

		$query = $this->db->get();

	  # echo $this->db->last_query();exit;

		if($query->num_rows()>0){

			return 1;

		}

		else

		{

			return 0;

		}

		

	}

public function getAllDropdownDataByComId($table)

	{

		$session = $this->session->userdata('mantra_user_detail');

		$data = array();

		$this->db->select("*")

				->from($table)

				->where('company_id',$session['companyid']);				

		$query = $this->db->get();

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
	public function getSingleRowByWhereClsByComId($table,$where)
	{
		$session = $this->session->userdata('mantra_user_detail');
		$data = array();
		$this->db->select("*")
				->from($table)
				->where('company_id',$session['companyid'])
				->where($where)
				->limit(1);
		$query = $this->db->get();
		
		#echo "<br>".$this->db->last_query();
		
		if($query->num_rows()> 0)
		{
           $row = $query->row();
           return $data = $row;
             
        }
		else
		{
            return $data;
        }
	}
public function getAllRecordWhereByComId($table,$where)
	{
		$session = $this->session->userdata('mantra_user_detail');
		$data = array();
		$this->db->select("*")
				->from($table)
				->where('company_id',$session['companyid'])
				->where($where);
		$query = $this->db->get();
		#echo $this->db->last_query();

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

	public function getAllRecordWhereByComIdOrderBy($table,$where,$order=[])
	{
		$session = $this->session->userdata('mantra_user_detail');
		$data = array();
		$this->db->select("*")
				->from($table)
				->where('company_id',$session['companyid'])
				->where($where)
				->order_by($order);
		$query = $this->db->get();
		#echo $this->db->last_query();

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
	public function GetCurrentPackage($mobile_no,$company_id)
	{
        // $session = $this->session->userdata('mantra_user_detail');
        // $company_id = $session['companyid'];
        $data = array();
        $date = date("Y-m-d");
        $where = array('customer_master.IS_ACTIVE'=>'Y','customer_master.pack_type'=>'M','DATE_ADD(payment_master.VALID_UPTO , INTERVAL COALESCE(application_extension.grant_days,0) DAY) >='=>$date,'payment_master.FROM_DT <='=>$date);
        $where_in = array('F','R','RA');
       
        $query = $this->db->select("customer_master.CUS_ID,
                                    customer_master.MEMBERSHIP_NO,
                                    customer_master.CUS_BRANCH,
                                    customer_master.CUS_CARD,
                                    customer_master.CUS_NAME,
                                    customer_master.CUS_PHONE,
                                    customer_master.CUS_EMAIL,
                                    customer_master.CUS_ADRESS,
                                    customer_master.CUS_DOB,
                                    customer_master.CUS_SEX,
                                    customer_master.EXT_MEMBERSHIP_NO,
                                    customer_master.EXT_MEMBERSHIP_ID,
                                    customer_master.member_acc_code,
                                    payment_master.VALIDITY_STRING,
                                    payment_master.PAYMENT_ID")
                          ->from('payment_master')
                          ->join('customer_master','payment_master.MEMBERSHIP_NO = customer_master.MEMBERSHIP_NO','INNER')   
                          ->join('application_extension','payment_master.MEMBERSHIP_NO = application_extension.membership_no AND payment_master.VALIDITY_STRING = application_extension.validity_period','LEFT') 
                          ->where('payment_master.MEMBERSHIP_NO IN (SELECT customer_master.`MEMBERSHIP_NO` FROM customer_master WHERE customer_master.`CUS_PHONE`='.$mobile_no.' AND customer_master.`company_id` = '.$company_id.')',NULL)   
                          ->where($where)
                          ->where_in('payment_master.FRESH_RENEWAL',$where_in); 
                                                
      
        $query = $this->db->get();
        //  echo $this->db->last_query();exit;
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

}