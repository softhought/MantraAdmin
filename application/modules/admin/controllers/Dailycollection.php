<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Dailycollection extends MY_Controller{

function __construct()

	{

		 parent::__construct();
		 $this->load->model('commondatamodel','commondatamodel',TRUE);	
		  $this->load->model('dailycollectionmodel','dailycollectionmodel',TRUE);		  
          $this->load->module('template');		

	}

public function collectionbranchwise(){

    
    if($this->session->userdata('mantra_user_detail'))
    {   
        
        $session = $this->session->userdata('mantra_user_detail');
        $comp = $session['companyid'];
        $data['user_role'] = $session['user_role'];
        $data['branchlist'] = $this->commondatamodel->getAllDropdownActiveDataByComId('branch_master'); 
        $data['cashaccountlist'] = $this->dailycollectionmodel->getAllCashAccountByComId($comp); 
        // pre($data['branchlist']);exit;
        $data['view_file'] = 'dashboard/account/reports/daily_collection/daily_collection_register_list';
        $this->template->admin_template($data);  		

    }else{
        redirect('admin','refresh');  

  }
}

/* add by shankha  */
public function collectionbranchwiserevised(){

    
    if($this->session->userdata('mantra_user_detail'))
    {   
        
        $session = $this->session->userdata('mantra_user_detail');
        $comp = $session['companyid'];
        $data['user_role'] = $session['user_role'];
        $data['branchlist'] = $this->commondatamodel->getAllDropdownActiveDataByComId('branch_master'); 
        $data['cashaccountlist'] = $this->dailycollectionmodel->getAllCashAccountByComId($comp); 
        // pre($data['branchlist']);exit;
        $data['view_file'] = 'dashboard/account/reports/daily_collection/daily_collection_register_list_reveised';
        $this->template->admin_template($data);  		

    }else{
        redirect('admin','refresh');  

  }
}

public function getAlldailycollection(){

    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {   
        // pre($session);exit;
        $session = $this->session->userdata('mantra_user_detail');
        $comp = $session['companyid'];
        $user_role = $session['user_role'];
                
        
           $brn_id =  $this->input->post('branch');
           $cash_account_id =  $this->input->post('cash_account_id');
           if ($user_role=="1" || $user_role=="2")
            {
                if(trim(htmlspecialchars($this->input->post('from_dt'))) != ''){          
                    $fdt = date('Y-m-d',strtotime($this->input->post('from_dt')));
                   }else{
                    $fdt=NULL;
                   }
                   if(trim(htmlspecialchars($this->input->post('to_date'))) != ''){          
                    $tdt = date('Y-m-d',strtotime($this->input->post('to_date')));
                   }else{
                    $tdt=NULL;
                   }
              
            }
            else
            {
                $duration=7;
                $tdt=date("Y-m-d");
                $fdt=strtotime ('-7 day',strtotime($tdt));

                $last_date = explode("-",$tdt);
                $fdt = date('Y-m-d',strtotime('-'.$duration.' day',mktime(0,0,0,$last_date[1],$last_date[2],$last_date[0])));
            }
         
            $aryDate=array();

            $iDateFrom=mktime(1,0,0,substr($fdt,5,2),     substr($fdt,8,2),substr($fdt,0,4));
            $iDateTo=mktime(1,0,0,substr($tdt,5,2),     substr($tdt,8,2),substr($tdt,0,4));
            
            if ($iDateTo>=$iDateFrom)
            {
                array_push($aryDate,date('Y-m-d',$iDateFrom)); // first entry
                while ($iDateFrom<$iDateTo)
                {
                    $iDateFrom+=86400; // add 24 hours
                    array_push($aryDate,date('Y-m-d',$iDateFrom));
                }
            }
            $this_yr_date=date("Y-m-d",strtotime("2014-12-01"));
            $data['daliytcollectionlist'] = array();
            for($j=0;$j<sizeof($aryDate);$j++)
           {
                $cash_coll_np=0;
                $cash_coll_p=0;
                $cash_coll_prod=0;
                $cash_coll_pack=0;
                $cash_rcvd=0;
                $cash_coll=0;
                $chq_coll=0;
                $card_coll=0;
                $ref_pbl=0;
                $total_coll=0;
                $cash_deposit=0;
                $cash_exp=0;
                $ref_paid=0;
                $tot_cash=0;
                $bal_cash=0;
                $str_col="";
                $str_col_card="";
                $str_col_chq="";
                $str_col_chq="";
                $card_coll_pack=0;
                $card_coll_prod=0;
                $online_payment_col = 0;
                $todaysColl = 0;

         // For this year
       $this_yr_date=date("Y-m-d",strtotime("2014-12-01"));
  
   //
       if ($j==0)
       {
   
           if($aryDate[$j]<$this_yr_date)
           {
               $cash_open=0;
           }
           else
           {
               if($aryDate[$j]==$this_yr_date)
               {
                   $cash_open=$this->dailycollectionmodel->getOpening($aryDate[$j],$brn_id,$comp);
                   
               }
               else
               {
                   $cash_open=$this->getOpeningBetween($this_yr_date,$aryDate[$j],$brn_id,$comp,$cash_account_id);
               }
           }
       }
    
        $payment_mode = 'Cash';
        $cash_coll_np=$this->dailycollectionmodel->getCollTotalAmtFromPayment($aryDate[$j],$aryDate[$j],$brn_id,$comp,$payment_mode);	
        // $str_col=$this->dailycollectionmodel->getCollTotalAmtFromPaymentStr($aryDate[$j],$aryDate[$j],$brn_id,$comp,$payment_mode);

        $cash_coll_prod=$this->dailycollectionmodel->getCollAllProduct($aryDate[$j],$aryDate[$j],$brn_id,$comp,$payment_mode);
        $str_col=$this->dailycollectionmodel->getCollAllProductWOSTStr($aryDate[$j],$aryDate[$j],$brn_id,$comp,$payment_mode);

        $cash_coll=$cash_coll_np+$cash_coll_p+$cash_coll_prod;

        $payment_mode = 'Cheque';
        $chq_coll=$this->dailycollectionmodel->getCollTotalAmtFromPayment($aryDate[$j],$aryDate[$j],$brn_id,$comp,$payment_mode);
        // $str_col_chq=$this->dailycollectionmodel->getCollTotalAmtFromPaymentStr($aryDate[$j],$aryDate[$j],$brn_id,$comp,$payment_mode);
    
        $payment_mode = 'Card';
        $card_coll_pack=$this->dailycollectionmodel->getCollTotalAmtFromPayment($aryDate[$j],$aryDate[$j],$brn_id,$comp,$payment_mode);
        // $str_col_card=$this->dailycollectionmodel->getCollTotalAmtFromPaymentStr($aryDate[$j],$aryDate[$j],$brn_id,$comp,$payment_mode);

        $card_coll_prod=$this->dailycollectionmodel->getCollAllProduct($aryDate[$j],$aryDate[$j],$brn_id,$comp,$payment_mode);
        $str_col_card=$this->dailycollectionmodel->getCollAllProductWOSTStr($aryDate[$j],$aryDate[$j],$brn_id,$comp,$payment_mode);
	
        $card_coll=$card_coll_pack+$card_coll_prod;

        /*-------------ONLINE PAYMENT COLLECTION----------*/
        $online_payment_col = 0;
        $payment_mode = 'ONP';
        $online_payment_col=$this->dailycollectionmodel->getCollTotalAmtFromPayment($aryDate[$j],$aryDate[$j],$brn_id,$comp,$payment_mode);
        
        /*-------------FUND TRANSFER COLLECTION----------*/
        $fund_transfer_col = 0;
        $payment_mode = 'Fund Transfer';
        $fund_transfer_col = $this->dailycollectionmodel->getCollTotalAmtFromPayment($aryDate[$j],$aryDate[$j],$brn_id,$comp,$payment_mode);
        
        $todaysColl = $cash_coll+$chq_coll+$card_coll+$online_payment_col+$fund_transfer_col;
	
        $total_coll=$cash_open+$cash_coll_np+$cash_coll_p+$cash_coll_prod+$chq_coll+$card_coll+$online_payment_col+$ref_pbl+$fund_transfer_col;
        
        $cash_deposit=$this->dailycollectionmodel->getCashDepositDaily($aryDate[$j],$aryDate[$j],$brn_id,$comp);
        $cash_exp=$this->dailycollectionmodel->getCashExpDaily($aryDate[$j],$aryDate[$j],$brn_id,$comp,$cash_account_id);
        $cash_rcvd=$this->dailycollectionmodel->getCashRcvdDaily($aryDate[$j],$aryDate[$j],$brn_id,$comp,$cash_account_id);

        $tot_cash=$cash_open+$cash_coll+$cash_rcvd;
	    $bal_cash=($cash_open+$cash_coll+$cash_rcvd)-($cash_deposit+$cash_exp+$ref_paid);	
        $srlno = $j+1;
        
       $data['daliytcollectionlist'][] = array(
                                              'coll_date'=>date("d-m-Y",strtotime($aryDate[$j])),
                                              'cash_open'=>number_format($cash_open,2),
                                              'cash_coll'=>number_format($cash_coll,2),
                                              'cash_rcvd'=>number_format($cash_rcvd,2),
                                              'chq_coll'=>number_format($chq_coll,2),
                                              'card_coll'=>number_format($card_coll,2),
                                              'online_payment_col'=>number_format($online_payment_col,2),
                                              'fund_transfer_col'=>number_format($fund_transfer_col,2),
                                              'ref_pbl'=>number_format($ref_pbl,2),
                                              'tot_cash'=>number_format($tot_cash,2),
                                              'todaysColl'=>number_format($todaysColl,2),
                                              'cash_deposit'=>number_format($cash_deposit,2),
                                              'cash_exp'=>number_format($cash_exp,2),
                                              'ref_paid'=>number_format($ref_paid,2),
                                              'bal_cash'=>number_format($bal_cash,2)
                                            );


        $cash_open=$bal_cash;

           }
        
         //pre($data['daliytcollectionlist']);exit;
        $page = 'dashboard/account/reports/daily_collection/daily_collection_register_partial_list';
        $this->load->view($page,$data);
        		

    }else{
        redirect('admin','refresh');  

  }
}

private function getOpeningBetween($dt1,$tdt,$brn_id,$comp,$cash_account_id)
{

	$dt2=date('Y-m-d', strtotime('-1 day', strtotime($tdt)));	
	$ref_paid=0;

    $cash_open=$this->dailycollectionmodel->getOpening($brn_id,$comp);
    

    $payment_mode = 'Cash';
    $cash_coll_np=$this->dailycollectionmodel->getCollTotalAmtFromPayment($dt1,$dt2,$brn_id,$comp,$payment_mode);
   
	$cash_coll_prod=$this->dailycollectionmodel->getCollAllProduct($dt1,$dt2,$brn_id,$comp,$payment_mode);
    
//	$cash_coll=$cash_coll_np+$cash_coll_p+$cash_coll_prod;
	$cash_coll=$cash_coll_np+$cash_coll_prod;
   
	$cash_rcvd=$this->dailycollectionmodel->getCashRcvdDaily($dt1,$dt2,$brn_id,$comp,$cash_account_id);	
   
	$cash_deposit=$this->dailycollectionmodel->getCashDepositDaily($dt1,$dt2,$brn_id,$comp);
	
	$cash_exp=$this->dailycollectionmodel->getCashExpDaily($dt1,$dt2,$brn_id,$comp,$cash_account_id);
    
   // pre($cash_open);
    //  pre($cash_coll_np);
    //  pre($cash_coll_prod);
    //  pre($cash_rcvd);
    //  pre($cash_deposit);
    //  pre($cash_exp);
    // pre($cash_exp);
    //exit;
  
	$bal_cash=($cash_open+$cash_coll+$cash_rcvd)-($cash_deposit+$cash_exp+$ref_paid);
    return $bal_cash;
}

public function getdailycollectiondtl(){

    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {   
  
        $session = $this->session->userdata('mantra_user_detail');
        $comp = $session['companyid'];
        $user_role = $session['user_role'];
                
        
           $brn_id =  $this->input->post('branch');
           $payment_mode =  $this->input->post('payment_mode');
           $where = array('BRANCH_ID'=>$brn_id);
           $branch_name  = $this->commondatamodel->getSingleRowByWhereCls('branch_master',$where)->BRANCH_NAME;
           $cash_account_id =  $this->input->post('cash_account_id');
           if(trim(htmlspecialchars($this->input->post('from_dt'))) != ''){          
                        $fdt = date('Y-m-d',strtotime($this->input->post('from_dt')));
                }else{
                        $fdt=NULL;
            }
            if(trim(htmlspecialchars($this->input->post('to_date'))) != ''){          
                $tdt = date('Y-m-d',strtotime($this->input->post('to_date')));
            }else{
                 $tdt=NULL;
            }
       
            
            $dailycollectionalldtl= array();
             $data['dailycollectionlist']=array();
             $data['heading'] = "";

             $dtl['Cash'] = 'Cash Collection Detail';
             $dtl['Cheque'] = 'Cheque Collection Detail';
             $dtl['Card'] = 'Card Collection Detail';
             $dtl['ONP'] = 'Payment Gateway Collection Detail';
             $dtl['Fund Transfer'] = 'Fund Transfer Collection Detail';
             $dtl['Cash Rcvd'] = 'Cash Received Detail';
             $dtl['Cash Exp'] = 'Cash Expension Detail';
             
             $data['heading'] = $dtl[$payment_mode];
             $data['payment_mode'] = $payment_mode;
             if($payment_mode == "Cash Rcvd"){
                
                $data['dailycollectionlist'] = $this->dailycollectionmodel->getCashRcvdDailydtl($fdt,$tdt,$brn_id,$comp,$cash_account_id);
               

             }else if($payment_mode == "Cash Exp"){
                
                $data['dailycollectionlist'] = $this->dailycollectionmodel->getCashExpDailydtl($fdt,$tdt,$brn_id,$comp,$cash_account_id);

             }else{

                $data['dailycollectionlist'] = $this->getdailycollbypaymentmode($fdt,$tdt,$brn_id,$comp,$payment_mode,$dailycollectionalldtl);

                    if($payment_mode == 'Cash' || $payment_mode == 'Card'){

                        $data['dailycollectionlist'] = $this->getproductcashcollection($fdt,$tdt,$brn_id,$comp,$payment_mode,$data['dailycollectionlist']);

                    }
            }
            

        //  pre($data['dailycollectionlist']);exit;
           $page = 'dashboard/account/reports/daily_collection/daily_collection_partial_modal';
           $this->load->view($page,$data); 
    
    }else{
        redirect('admin','refresh');
  
  }
  
  }

  private function getdailycollbypaymentmode($fdt,$tdt,$brn_id,$comp,$payment_mode,$dailycollectionalldtl){

    $dailyAmtcollectiondtl = array();
    $basicAmt = 0;
    $taxAmt = 0;
    $totalAmt =0;    
    $totalwithTax=0;    
    $where = array('BRANCH_ID'=>$brn_id);
    $branch_name  = $this->commondatamodel->getSingleRowByWhereCls('branch_master',$where)->BRANCH_NAME;
    // $dailycollectionalldtl = array();
    
    $dailyAmtcollectiondtl = $this->dailycollectionmodel->getCollTotalAmtFromPaymentStr($fdt,$tdt,$brn_id,$comp,$payment_mode);
               //pre($dailyAmtcollectiondtl);exit;
               foreach($dailyAmtcollectiondtl as $dailyAmtcollectiondtl)
               {
                $basicAmt = $dailyAmtcollectiondtl->AMOUNT;
                $taxAmt = $dailyAmtcollectiondtl->TOTAL_AMOUNT-$dailyAmtcollectiondtl->AMOUNT;
                $totalAmt = $dailyAmtcollectiondtl->TOTAL_AMOUNT;
                
                $totalwithTax = $totalwithTax+$dailyAmtcollectiondtl->TOTAL_AMOUNT;
                
                if($payment_mode == 'ONP'){                   
                $where = array('payment_id'=>$dailyAmtcollectiondtl->PAYMENT_ID);
                $compldtl  = $this->commondatamodel->getSingleRowByWhereCls('compliment_consumption',$where);
                if(!empty($compldtl)){
                    if($compldtl->cus_type == 'GUEST'){
                        $membName = $compldtl->guest_name;
			            $mobile = $compldtl->guest_mobile;
                    }else{
                        $membName = $dailyAmtcollectiondtl->CUS_NAME;
                        $mobile = $dailyAmtcollectiondtl->CUS_PHONE;
                    }
                }else{
                    $membName = $dailyAmtcollectiondtl->CUS_NAME;
                    $mobile = $dailyAmtcollectiondtl->CUS_PHONE;
                }
                
            }else{
                        $membName = $dailyAmtcollectiondtl->CUS_NAME;
                        $mobile = $dailyAmtcollectiondtl->CUS_PHONE;
                }
                
    

                $dailycollectionalldtl[] = array(
                                                          'membership_no'=>$dailyAmtcollectiondtl->MEMBERSHIP_NO,
                                                          'membName'=>$membName,
                                                          'mobile'=>$mobile,
                                                          'branch'=>$branch_name,
                                                          'basicAmt'=> number_format($basicAmt,2),
                                                          'taxAmt'=> number_format($taxAmt,2),
                                                          'totalAmt'=> $totalAmt
                                                          
                                                          ); 

               }
            //    $dailycollectionalldtl2= $this->getproductcashcollection($fdt,$tdt,$brn_id,$comp,$payment_mode,$dailycollectionalldtl);
               return $dailycollectionalldtl;

  }

  private function getproductcashcollection($fdt,$tdt,$brn_id,$comp,$payment_mode,$dailycollectionalldtl){

    $basicFee = 0;
    $taxFee = 0;
    $totalFee = 0;
    $totalWithoutTax=0;
    $where = array('BRANCH_ID'=>$brn_id);
    $branch_name  = $this->commondatamodel->getSingleRowByWhereCls('branch_master',$where)->BRANCH_NAME;
    $dailyprocollectionalldtl = array();
    $dailyprodustAmtcollectiondtl=$this->dailycollectionmodel->getCollAllProductWOSTStr($fdt,$tdt,$brn_id,$comp,$payment_mode);
               foreach($dailyprodustAmtcollectiondtl as $dailyprodustAmtcollectiondtl)
	           {
                $basicFee = $dailyprodustAmtcollectiondtl->BASIC_FEE;
                $taxFee = $dailyprodustAmtcollectiondtl->TAX_FEE;
                $totalFee = $dailyprodustAmtcollectiondtl->TOTAL_AMT;
                
                $totalWithoutTax = $totalWithoutTax+$dailyprodustAmtcollectiondtl->TOTAL_AMT;
                $cusID = $dailyprodustAmtcollectiondtl->CUS_ID;
                $mem_or_guest = $dailyprodustAmtcollectiondtl->MEM_GUEST_GMEM;
                if($mem_or_guest=="Member"){
                    $where = array('MEMBERSHIP_NO'=>$dailyprodustAmtcollectiondtl->MEMBERSHIP_NO);
                    $memberDtl  = $this->commondatamodel->getSingleRowByWhereCls('customer_master',$where);                   
                    $membership = $memberDtl->MEMBERSHIP_NO;
                    $mem_name = $memberDtl->CUS_NAME;
                    $mobile_no = $memberDtl->CUS_PHONE;                   
                   
                }
                else{
                    $membership = $dailyprodustAmtcollectiondtl->MEM_GUEST_GMEM;
                    $mem_name = $dailyprodustAmtcollectiondtl->GUEST_NAME;
                    $mobile_no = $dailyprodustAmtcollectiondtl->GUEST_CONTACT;
                }

                $dailycollectionalldtl[] = array(
                                        'membership_no'=>$membership,
                                        'membName'=>$mem_name,
                                        'mobile'=>$mobile_no,
                                        'branch'=>$branch_name,
                                        'basicAmt'=> number_format($basicFee,2),
                                        'taxAmt'=> number_format($taxFee,2),
                                        'totalAmt'=> $totalFee
                    ); 

                  }

                  return $dailycollectionalldtl;

  }



  /*------------------------------------------------------------------------------------------------------- */

  public function getAlldailycollectionreveised(){

    $session = $this->session->userdata('mantra_user_detail');
    if($this->session->userdata('mantra_user_detail'))
    {   
        // pre($session);exit;
        $session = $this->session->userdata('mantra_user_detail');
        $comp = $session['companyid'];
        $user_role = $session['user_role'];
        $where = array('year_id'=>$session['yearid']);
		$financialyear = $this->commondatamodel->getSingleRowByWhereCls('year_master',$where);
        $start_date=$financialyear->starting_date;

        
                
        
           $brn_id =  $this->input->post('branch');
           $cash_account_id =  $this->input->post('cash_account_id');
           if ($user_role=="1" || $user_role=="2")
            {
                if(trim(htmlspecialchars($this->input->post('from_dt'))) != ''){          
                    $fdt = date('Y-m-d',strtotime($this->input->post('from_dt')));
                   }else{
                   // $fdt=NULL;
                    $fdt=$start_date;
                   }
                   if(trim(htmlspecialchars($this->input->post('to_date'))) != ''){          
                    $tdt = date('Y-m-d',strtotime($this->input->post('to_date')));
                   }else{
                   // $tdt=NULL;
                    $tdt=date('Y-m-d');
                   }
              
            }
            else
            {
                $duration=7;
                $tdt=date("Y-m-d");
                $fdt=strtotime ('-7 day',strtotime($tdt));

                $last_date = explode("-",$tdt);
                $fdt = date('Y-m-d',strtotime('-'.$duration.' day',mktime(0,0,0,$last_date[1],$last_date[2],$last_date[0])));

               
            }
           
            $aryDate=array();

            $iDateFrom=mktime(1,0,0,substr($fdt,5,2),     substr($fdt,8,2),substr($fdt,0,4));
            $iDateTo=mktime(1,0,0,substr($tdt,5,2),     substr($tdt,8,2),substr($tdt,0,4));
            
            if ($iDateTo>=$iDateFrom)
            {
                array_push($aryDate,date('Y-m-d',$iDateFrom)); // first entry
                while ($iDateFrom<$iDateTo)
                {
                    $iDateFrom+=86400; // add 24 hours
                    array_push($aryDate,date('Y-m-d',$iDateFrom));
                }
            }
            $this_yr_date=date("Y-m-d",strtotime("2014-12-01"));
            $data['daliytcollectionlist'] = array();


           // pre($aryDate);exit;
            for($j=0;$j<sizeof($aryDate);$j++)
           {
                $cash_coll_np=0;
                $cash_coll_p=0;
                $cash_coll_prod=0;
                $cash_coll_pack=0;
                $cash_rcvd=0;
                $cash_coll=0;
                $chq_coll=0;
                $card_coll=0;
                $ref_pbl=0;
                $total_coll=0;
                $cash_deposit=0;
                $cash_exp=0;
                $ref_paid=0;
                $tot_cash=0;
                $bal_cash=0;
                $str_col="";
                $str_col_card="";
                $str_col_chq="";
                $str_col_chq="";
                $card_coll_pack=0;
                $card_coll_prod=0;
                $online_payment_col = 0;
                $todaysColl = 0;

         // For this year
       $this_yr_date=date("Y-m-d",strtotime("2014-12-01"));
  
   //
       if ($j==0)
       {
  

        if($aryDate[$j]==$start_date){
        $cash_open=0;  
        $where_op = array(
                            'year_id'=>$session['yearid'],
                            'branch_id'=>$brn_id ,
                            'company_id'=>$session['companyid']
                        );
           $OpeningData = $this->commondatamodel->getSingleRowByWhereCls('cash_opening_balance',$where_op);
          if($OpeningData){ $cash_open=$OpeningData->open_balance;}
        }else{
            
            $cash_open=$this->getOpeningBetweenrevised($start_date,$aryDate[$j],$brn_id,$session['yearid'],$comp,$cash_account_id);

        }

  
       }
    
        $payment_mode = 'Cash';
        $cash_coll_np=$this->dailycollectionmodel->getCollTotalAmtFromPayment($aryDate[$j],$aryDate[$j],$brn_id,$comp,$payment_mode);	
        // $str_col=$this->dailycollectionmodel->getCollTotalAmtFromPaymentStr($aryDate[$j],$aryDate[$j],$brn_id,$comp,$payment_mode);

        $cash_coll_prod=$this->dailycollectionmodel->getCollAllProduct($aryDate[$j],$aryDate[$j],$brn_id,$comp,$payment_mode);
        $str_col=$this->dailycollectionmodel->getCollAllProductWOSTStr($aryDate[$j],$aryDate[$j],$brn_id,$comp,$payment_mode);

        $cash_coll=$cash_coll_np+$cash_coll_p+$cash_coll_prod;

        $payment_mode = 'Cheque';
        $chq_coll=$this->dailycollectionmodel->getCollTotalAmtFromPayment($aryDate[$j],$aryDate[$j],$brn_id,$comp,$payment_mode);
        // $str_col_chq=$this->dailycollectionmodel->getCollTotalAmtFromPaymentStr($aryDate[$j],$aryDate[$j],$brn_id,$comp,$payment_mode);
    
        $payment_mode = 'Card';
        $card_coll_pack=$this->dailycollectionmodel->getCollTotalAmtFromPayment($aryDate[$j],$aryDate[$j],$brn_id,$comp,$payment_mode);
        // $str_col_card=$this->dailycollectionmodel->getCollTotalAmtFromPaymentStr($aryDate[$j],$aryDate[$j],$brn_id,$comp,$payment_mode);

        $card_coll_prod=$this->dailycollectionmodel->getCollAllProduct($aryDate[$j],$aryDate[$j],$brn_id,$comp,$payment_mode);
        $str_col_card=$this->dailycollectionmodel->getCollAllProductWOSTStr($aryDate[$j],$aryDate[$j],$brn_id,$comp,$payment_mode);
	
        $card_coll=$card_coll_pack+$card_coll_prod;

        /*-------------ONLINE PAYMENT COLLECTION----------*/
        $online_payment_col = 0;
        $payment_mode = 'ONP';
        $online_payment_col=$this->dailycollectionmodel->getCollTotalAmtFromPayment($aryDate[$j],$aryDate[$j],$brn_id,$comp,$payment_mode);
        
        /*-------------FUND TRANSFER COLLECTION----------*/
        $fund_transfer_col = 0;
        $payment_mode = 'Fund Transfer';
        $fund_transfer_col = $this->dailycollectionmodel->getCollTotalAmtFromPayment($aryDate[$j],$aryDate[$j],$brn_id,$comp,$payment_mode);
        
        $todaysColl = $cash_coll+$chq_coll+$card_coll+$online_payment_col+$fund_transfer_col;
	
        $total_coll=$cash_open+$cash_coll_np+$cash_coll_p+$cash_coll_prod+$chq_coll+$card_coll+$online_payment_col+$ref_pbl+$fund_transfer_col;
        
        $cash_deposit=$this->dailycollectionmodel->getCashDepositDaily($aryDate[$j],$aryDate[$j],$brn_id,$comp);
        $cash_exp=$this->dailycollectionmodel->getCashExpDaily($aryDate[$j],$aryDate[$j],$brn_id,$comp,$cash_account_id);
        $cash_rcvd=$this->dailycollectionmodel->getCashRcvdDaily($aryDate[$j],$aryDate[$j],$brn_id,$comp,$cash_account_id);

        $tot_cash=$cash_open+$cash_coll+$cash_rcvd;
	    $bal_cash=($cash_open+$cash_coll+$cash_rcvd)-($cash_deposit+$cash_exp+$ref_paid);	
        $srlno = $j+1;
        
       $data['daliytcollectionlist'][] = array(
                                              'coll_date'=>date("d-m-Y",strtotime($aryDate[$j])),
                                              'cash_open'=>number_format($cash_open,2),
                                              'cash_coll'=>number_format($cash_coll,2),
                                              'cash_rcvd'=>number_format($cash_rcvd,2),
                                              'chq_coll'=>number_format($chq_coll,2),
                                              'card_coll'=>number_format($card_coll,2),
                                              'online_payment_col'=>number_format($online_payment_col,2),
                                              'fund_transfer_col'=>number_format($fund_transfer_col,2),
                                              'ref_pbl'=>number_format($ref_pbl,2),
                                              'tot_cash'=>number_format($tot_cash,2),
                                              'todaysColl'=>number_format($todaysColl,2),
                                              'cash_deposit'=>number_format($cash_deposit,2),
                                              'cash_exp'=>number_format($cash_exp,2),
                                              'ref_paid'=>number_format($ref_paid,2),
                                              'bal_cash'=>number_format($bal_cash,2)
                                            );


        $cash_open=$bal_cash;

           }
        
         //pre($data['daliytcollectionlist']);exit;
        $page = 'dashboard/account/reports/daily_collection/daily_collection_register_partial_list';
        $this->load->view($page,$data);
        		

    }else{
        redirect('admin','refresh');  

  }
}


private function getOpeningBetweenrevised($dt1,$tdt,$brn_id,$year_id,$comp,$cash_account_id)
{

	$dt2=date('Y-m-d', strtotime('-1 day', strtotime($tdt)));	
	$ref_paid=0;

   // $cash_open=$this->dailycollectionmodel->getOpening($brn_id,$comp);
     $cash_open=0;
     $where_op = array(
                            'year_id'=>$year_id,
                            'branch_id'=>$brn_id ,
                            'company_id'=>$comp
                        );
           $OpeningData = $this->commondatamodel->getSingleRowByWhereCls('cash_opening_balance',$where_op);
          if($OpeningData){ $cash_open=$OpeningData->open_balance;}
    

    $payment_mode = 'Cash';
    $cash_coll_np=$this->dailycollectionmodel->getCollTotalAmtFromPayment($dt1,$dt2,$brn_id,$comp,$payment_mode);
   
	$cash_coll_prod=$this->dailycollectionmodel->getCollAllProduct($dt1,$dt2,$brn_id,$comp,$payment_mode);
    
//	$cash_coll=$cash_coll_np+$cash_coll_p+$cash_coll_prod;
	$cash_coll=$cash_coll_np+$cash_coll_prod;
   
	$cash_rcvd=$this->dailycollectionmodel->getCashRcvdDaily($dt1,$dt2,$brn_id,$comp,$cash_account_id);	
   
	$cash_deposit=$this->dailycollectionmodel->getCashDepositDaily($dt1,$dt2,$brn_id,$comp);
	
	$cash_exp=$this->dailycollectionmodel->getCashExpDaily($dt1,$dt2,$brn_id,$comp,$cash_account_id);
    
   // pre($cash_open);
    //  pre($cash_coll_np);
    //  pre($cash_coll_prod);
    //  pre($cash_rcvd);
    //  pre($cash_deposit);
    //  pre($cash_exp);
    // pre($cash_exp);
    //exit;
  
	$bal_cash=($cash_open+$cash_coll+$cash_rcvd)-($cash_deposit+$cash_exp+$ref_paid);
    return $bal_cash;
}

}