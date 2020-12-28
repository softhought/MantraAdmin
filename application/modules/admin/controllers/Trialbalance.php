<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Trialbalance extends MY_Controller{
	
function __construct()
	{
		 parent::__construct();
         $this->load->model('commondatamodel','commondatamodel',TRUE);	
        
        $this->load->model('trialbalancemodel', '', TRUE);	 	
        $this->load->model('companymodel', '', TRUE);	
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
        //pre($data['start_date']);exit;
        $data['view_file'] = 'dashboard/account/reports/trialbalance/trial_balance';      
        $this->template->admin_template($data);  
		
    }else{
        redirect('admin','refresh');
  
  }

}

public function trailJasper()

    {
        $session = $this->session->userdata('mantra_user_detail');
        if($this->session->userdata('mantra_user_detail'))
        {     

            $file= APPPATH."modules/admin/views/dashboard/account/reports/trialbalance/TrailBalanceJasper.jrxml";
            $this->load->library('jasperphp');
            $jasperphp = $this->jasperphp->jasper();
// pre($file);exit;
            $dbdriver="mysql";
            // $server="localhost";
            // $db="teasamrat";
            // $user="root";
            // $pass="";           

            $this->load->database();
            $server=$this->db->hostname;
            $user=$this->db->username;
            $pass=$this->db->password;
            $db=$this->db->database;

           

            $companyId = $session['companyid'];
            $yearid = $session['yearid'];
            $branchid = $session['branchid'];
                 

            $fromdate = $this->uri->segment(4);
            $todate = $this->uri->segment(5);
            $frmDate = date("Y-m-d",strtotime($fromdate));
            $toDate = date("Y-m-d",strtotime($todate)); 
             
            $fiscalStartDt= $this->trialbalancemodel->getFiscalStartDt($yearid);          
            $company=  $this->companymodel->getCompanyNameById($companyId);           
            $companyaddress=  $this->companymodel->getCompanyAddressBybranchId($branchid);
         
          
            $dateRange='('.$fromdate.' To '.$todate.')';
            $printDate=date("d-m-Y");

            // $jasperphp->debugsql=true;
            $jasperphp->arrayParameter = array('CompanyId'=>$companyId,'YearId'=>$yearid,'fromDate'=>"'".$frmDate."'",'toDate'=>"'".$toDate."'",'fiscalstartdate'=>"'".$fiscalStartDt."'",'CompanyName'=>$company,'CompanyAddress'=>$companyaddress,'printDate'=>$printDate,'dateRange'=>$dateRange);
            //pre($jasperphp->arrayParameter);  exit;   
            $jasperphp->load_xml_file($file); 
            $jasperphp->transferDBtoArray($server,$user,$pass,$db,$dbdriver);
            $jasperphp->outpage('I','Trial Balance-'.date('d_m_Y-His'));         
            // $page = 'trial_balance/trailWithJasper.php';
            // $this->load->view($page, $result, TRUE);

        } else {
            redirect('admin', 'refresh');
        }
    }


}
