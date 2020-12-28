<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Generalledger extends MY_Controller {

	public function __construct()
	{

	    parent::__construct();
		$this->load->model('Generalledgermodel','generalledgermodel',TRUE);
		$this->load->model('Companymodel','companymodel',TRUE);
		$this->load->model('commondatamodel','commondatamodel',TRUE);
		$this->load->model('trialbalancemodel','trialbalancemodel',TRUE);
		$this->load->library('jasperphp');
		$this->load->module('template');

    }

	public function index(){

		$session = $this->session->userdata('mantra_user_detail');
		if($this->session->userdata('mantra_user_detail'))
		{  
		 
			$where = array('year_id'=>$session['yearid']);
	
			$financialyear = $this->commondatamodel->getSingleRowByWhereCls('year_master',$where);
			$data['start_date']=$financialyear->starting_date;
			$data['ending_date']=$financialyear->ending_date;
			$company=$session['companyid'];
            $yearid=$session['yearid'];
			$data['accountList'] = $this->generalledgermodel->getAllAccountList($company,$yearid);
			$data['branchlist'] = $this->commondatamodel->getAllDropdownActiveDataByComId('branch_master');  
			//pre($data['accountList']);exit;
			$data['view_file'] = 'dashboard/account/reports/general_ledger/generalLedger';      
			$this->template->admin_template($data);  
			
		}else{
			redirect('admin','refresh');
	  
	  }
	
	}

	public function GeneralLedger(){
        
		$session = $this->session->userdata('mantra_user_detail');
		if ($this->session->userdata('mantra_user_detail')) {
		 
		 ini_set('max_execution_time', 600);
		 
		 
		 
		 $companyId = $session['companyid'];
		 $yearid = $session['yearid'];
   
		 
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		ini_set('memory_limit', '256M'); 
		 
		 
		$fromdate = $this->input->post('fromdate');
		$todate = $this->input->post('todate');
		$accId = $this->input->post('acccountid');
		
		 $branch_id = $this->input->post('branch_id');
		 $frmDate = date("Y-m-d",strtotime($fromdate));
		 $toDate = date("Y-m-d",strtotime($todate)); 
	   
		 $fiscalStartDt = $this->trialbalancemodel->getFiscalStartDt($yearid);
	   
	
	
	   
	   $result['accountname']=  $this->generalledgermodel->getAccountnameById($accId);
	   $result['accounting_period']=$this->generalledgermodel->getAccountingPeriod($yearid);
	   $result['company']=  $this->companymodel->getCompanyNameById($companyId);
	   $result['companyaddress']=  $this->companymodel->getCompanyAddressBybranchId($branch_id); 
	   $result['fromDate'] = $fromdate;
	   $result['toDate'] = $todate;
	   
	  // pre($reportType);exit;
	   
	    $result['generalledger']= $this->generalledgermodel->getGeneralLedgerReportType3($frmDate,$toDate,$companyId,$yearid,$accId,$branch_id);
		   //freeDBResource($this->db->conn_id);
		   //pre($result['generalledger']);exit;
		   $page = 'dashboard/account/reports/general_ledger/general_ledger_html_type3.php';
	 
	   echo $html = $this->load->view($page, $result,TRUE);
	   
	//    $pdf->WriteHTML($html); 
	//    $output = 'testPdf' . date('Y_m_d_H_i_s') . '_.pdf'; 
	//    $pdf->Output("$output", 'I');
	//    exit();
	   
	 

	  
		 } else {
		   redirect('admin', 'refresh');
	   }
	
	   
   }




public function GeneralLedgerJasperReport(){
        
		$session = $this->session->userdata('mantra_user_detail');
		if ($this->session->userdata('mantra_user_detail')) {
		 
			$fromdate = $this->input->post('fromdate');
			$todate = $this->input->post('todate');
			$accId = $this->input->post('acccountid');
			
			 $branch_id = $this->input->post('branch_id');
			 $frmDate = date("Y-m-d",strtotime($fromdate));
			 $toDate = date("Y-m-d",strtotime($todate)); 
			
		//pre($branch_id);exit;

			$file= APPPATH."modules/admin/views/dashboard/account/reports/general_ledger/GeneralLedgerJasperReport.jrxml";

            $this->load->library('jasperphp');

            $jasperphp = $this->jasperphp->jasper();



            $dbdriver="mysql";
            $this->load->database();
            $server=$this->db->hostname;
            $user=$this->db->username;
            $pass=$this->db->password;
			$db=$this->db->database;
			
            $companyId = $session['companyid'];
			$yearid = $session['yearid']; 
			$accountname=  $this->generalledgermodel->getAccountnameById($accId);
			
			$accounting_period=$this->generalledgermodel->getAccountingPeriod($yearid);        
			
			$fiscalStartDt = $this->trialbalancemodel->getFiscalStartDt($yearid);
			
            $company=  $this->companymodel->getCompanyNameById($companyId);
            $companyaddress=  $this->companymodel->getCompanyAddressBybranchId($branch_id);            
			//$groupname=$this->generalledgermodel->getGroupnameById($group);
            $dateRange='('.date('d-m-Y',strtotime($frmDate)).' To '.date('d-m-Y',strtotime($toDate)).')';
            $printDate=date("d-m-Y");

			
            // $jasperphp->debugsql=true;

			$jasperphp->arrayParameter = array('CompanyName'=>$company,'CompanyAddress'=>$companyaddress,'CompanyId'=>$companyId,'YearId'=>$yearid,'printdate'=>$printDate,'fromDate'=>"'".$frmDate."'",'toDate'=>"'".$toDate."'",'fiscalstartdate'=>"'".$fiscalStartDt."'",'dateRange'=>$dateRange,'accId'=>$accId,'accountname'=>$accountname,'accounting_period'=>'('.date('d-m-Y',strtotime($accounting_period['start_date'])).' To '.date('d-m-Y',strtotime($accounting_period['end_date'])).')','branch_id'=>$branch_id);
			
			//pre($jasperphp->arrayParameter);exit;

            $jasperphp->load_xml_file($file); 
            $jasperphp->transferDBtoArray($server,$user,$pass,$db,$dbdriver);
            $jasperphp->outpage('I','General Ledger-'.date('d_m_Y-His'));  

           
		 } else {
		   redirect('admin', 'refresh');
	   }
	
	   
   }


} // end of class