<?php
class Companymodel extends CI_Model {
    /**

     * returns a list of articles

     * @return array 

     */

    public function companylist() {
		$where = [
			"company_master.is_active" => "Y"
		];
        $this->db->select('*');
        $this->db->from('company_master');
        $this->db->where($where);
        
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = $rows;
            }
            return $data;
        } else {
            return false;
        }
    }
    public function getCompanyNameById($id) 
    {
        $this->db->select("company_name")
                ->from('company_master')
                ->where('comany_id', $id);
        $query = $this->db->get();      

    #  echo  $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->company_name;
        }else{
            return '';
        }
    }    

      public function getCompanyAddressBybranchId($id = '') {
        $this->db->select("branch_address")
                ->from('branch_master')
                ->where('BRANCH_ID', $id);
        $query = $this->db->get();   
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->branch_address;
        }else{
            return '';
        }
    }
  

    /**

     * result foe fetch data

     */    

    

      public function getCompanyById($id = '') {
        $sql = "SELECT * FROM company_master WHERE company_id='" . $id . "'";
		$query = $this->db->query($sql);
		//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row;
        }else{
            return '';
        }
    }
	

}


?>