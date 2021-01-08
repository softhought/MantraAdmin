<?php if (!defined('BASEPATH')) exit('No direct script access allowed');



class Generalledgermodel extends CI_Model{



    public function getFiscalStartDt($yearid){

        // echo $yearid;exit;

        $sql="SELECT `start_date` FROM `financialyear` WHERE is_active='Y' and year_id=".$yearid;

        $query = $this->db->query($sql);

         if ($query->num_rows() > 0) {

                foreach ($query->result() as $rows) {

                    return $rows->start_date;

                }

         }

        

    }



    public function getAccountingPeriod($yearid){

        $data = array();
        $where = array('is_active'=>'Y','year_id'=>$yearid);
        $query = $this->db->select('*')
                          ->from('year_master')
                          ->where($where)                         
                          ->get();

        
        if ($query->num_rows() > 0) {

                foreach ($query->result() as $rows) {

                    $data=[

                        "start_date"=>$rows->starting_date,

                        "end_date"=>$rows->ending_date

                    ];

                }

                return $data;

        }else{

            return $data;

        }

        

    }





     /*

  *getGeneralLedgerReportType3

  *03-04-2018

  *Multiple debit and multiple credit

  */

   public function getGeneralLedgerReportType3($frmDate,$toDate,$companyId,$yearid,$accId,$branch_id)

   {

       $data = [];

       $call_procedure = "CALL usp_generalLedger_Style3('".$frmDate."','".$toDate."',"."$companyId,$yearid,$accId,'".$branch_id."')";

       $query =$this->db->query($call_procedure);

       if($query->num_rows()>0){

           foreach ($query->result() as $rows) {

           $data[] = [

              "vchId"=>$rows->vchId,

              "vchNumber"=>$rows->vchNumber,

              "debitamount"=>$rows->debitamount,

              "creditamount"=>$rows->creditamount,

              "isdebit"=>$rows->isdebit,

              "Naration"=>$rows->Naration,

              "VchType"=>$rows->VchType,

              "VchDate"=>$rows->VchDate,

              "VchAccountDetailscrdrtag"=>$rows->VchAccountDetailscrdrtag,

              "VchAccountDetailsAccountName"=>$rows->VchAccountDetailsAccountName,

              "VchAccountDetailsAmount"=>$rows->VchAccountDetailsAmount



           ];

       }

       }

       return $data;

   }


   public function generalLedgerStyle3_revised($frmDate,$toDate,$companyId,$yearid,$accId,$fiscalStartDt)

   {

       $data = [];

        $call_procedure = "CALL usp_generalLedgerStyle3_revised('".$frmDate."','".$toDate."',"."$companyId,$yearid,$accId,'".$fiscalStartDt."')";

       $query =$this->db->query($call_procedure);

       if($query->num_rows()>0){

           foreach ($query->result() as $rows) {

           $data[] = [

              "vchId"=>$rows->vchId,

              "vchNumber"=>$rows->vchNumber,

              "debitamount"=>$rows->debitamount,

              "creditamount"=>$rows->creditamount,

              "isdebit"=>$rows->isdebit,

              "Naration"=>$rows->Naration,

              "VchType"=>$rows->VchType,

              "VchDate"=>$rows->VchDate,

              "VchAccountDetailscrdrtag"=>$rows->VchAccountDetailscrdrtag,

              "VchAccountDetailsAccountName"=>$rows->VchAccountDetailsAccountName,

              "VchAccountDetailsAmount"=>$rows->VchAccountDetailsAmount



           ];

       }

       }

       return $data;

   }



   public function getCompanyNameById($id) {        

    $query = $this->db->select('company_name')

                  ->from('company_master')

                  ->where('company_id',$id)
                  ->where('is_active','Y')

                  ->get();

    $row = $query->row();

    return $row->company_name;

    if ($query->num_rows() > 0) {

        $row = $query->row();

        return $row->company_name;

    }else{

        return '';

    }

}

public function getAllAccountList($company_id,$year_id)
{

    $where = array('account_master.company_id' => $company_id,'account_master.is_active'=>'Y');

    $data = array();    
    $query = $this->db->select("account_master.*,sub_group_master.sub_group_desc")
                      ->from('account_master')
                      ->join('sub_group_master','sub_group_master.sub_group_id = account_master.sub_group_id','INNER')   
                      ->where($where)
                      ->order_by('account_master.account_description','ASC');
  
    $query = $this->db->get();
    // echo $this->db->last_query();
    if($query->num_rows()> 0)
    {
        foreach ($query->result() as $rows)
        {
        //	$data[] = $rows;
        
        $data[] = [
                "accountData" => $rows,
                "openingBalance" => $this->getAccountOpeningBalance($company_id,$year_id,$rows->account_id)                 
            ];
        }
        return $data;            

    }
    else
    {
         return $data;
     }

}

public function getAccountOpeningBalance($company_id,$year_id,$account_id)
	{
		$data = 0;
		$where = array(
                        'companyId' => $company_id,
                        'AccountId' => $account_id,
                        'AccountingYearId' => $year_id,
                      );
		$this->db->select("*")
				 ->from('account_opening_master')				
				 ->where($where)
				 ->limit(1);
		$query = $this->db->get();
		#echo "<br>".$this->db->last_query();
		if($query->num_rows()> 0)
		{
           $row = $query->row();
           return $data = $row->OpeningBalance;           
        }
		else
		{
            return $data;
        }
	}
    public function getAccountnameById($accId){

        $data = "";
        $where = array('account_master.account_id'=>$accId);

        $this->db->select("*")
        ->from('account_master')				
        ->where($where);

        $query = $this->db->get();
       
    
      if ($query->num_rows() > 0) {
    
              $row = $query->row();
              $data =  $row->account_description;
               
        }
    
        return $data;
    
    }









} //end of class