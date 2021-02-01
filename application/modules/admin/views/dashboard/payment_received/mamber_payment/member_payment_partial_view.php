<?php
$this->load->model('memberpaymentmodel','member_payment_model',TRUE);
$paymentSl=1;
foreach ($paymentList as $paymentlist) {
    
    

    
    $member_id=$paymentlist->CUS_ID;
    $company_id=$paymentlist->company_id;
    $membership_no=$paymentlist->MEMBERSHIP_NO;

    $attendanceData = $this->member_payment_model->GetLastAttendeceDt($member_id); 
    $last_att_date='';
    if($attendanceData){
    $last_att_date =  date('d-m-Y',strtotime($attendanceData->att_date));
    }
?>
 <div class="formblock-box">
<div class="card card-success card-outline" style="border-bottom: 3px solid #d96692;">
<div class="sl_div" id="sldiv_1"><?php echo $paymentSl++;?></div>
          <div class="card-header">
           <span class="badge badge-dark"><?php echo $paymentlist->CUS_NAME;?></span>
           <span class="badge badge-danger"><?php echo $paymentlist->CUS_CARD;?></span>
           <span class="badge badge-warning"><?php echo $paymentlist->MEMBERSHIP_NO?></span>

           <span class="badge badge-secondary" style="float:right;">Last Attend: <?php echo $last_att_date;?></span>
          </div> <!-- /.card-body -->
          <div class="card-body">
           <?php 


                $rowValidity = $this->member_payment_model->GetAllValidity($membership_no);

                foreach ($rowValidity as $key => $row_validity) {

                    $valid_string=date("d-m-Y",strtotime($row_validity->FROM_DT))." To ".date("d-m-Y",strtotime($row_validity->VALID_UPTO));
                       $appl_ext_days=0;
                       
                       $rowApplication = $this->member_payment_model->GetExtViaApplication($membership_no,$row_validity->VALIDITY_STRING);
                     foreach($rowApplication as $row_appl)
							 {
								 $appl_ext_days=$row_appl->grant_days;
							 }
							  $final_dt = explode("-",$row_validity->VALID_UPTO);
							
							 $final_exp_date = date('Y-m-d',strtotime('+'.$appl_ext_days.' Days',mktime(0,0,0,$final_dt[1],$final_dt[2],$final_dt[0])));
							 $actualValidity = date("d-m-Y",strtotime($row_validity->FROM_DT))." To ".date("d-m-Y",strtotime($final_exp_date));
							 
						
               
           
            if($row_validity->payment_from != 'HYG'){ 
           ?>
            
            <div class="row box">
                 <div class="col-sm-4">
                  <strong class="">&nbsp;Validity: <?php echo $valid_string;?></strong>
                    </div>
                     <div class="col-sm-4">
                   <strong class="text-primary">Grant Days: <?php echo $appl_ext_days;?></strong>
                    </div>
                     <div class="col-sm-4">
                   <strong class="text-success">Actual Validity: <?php echo $actualValidity;?></strong>
                    </div>
              
            </div> 
            <?php }else{?>
             <div class="row box">
                 <div class="col-sm-12">
                  <strong class="">&nbsp;Hygine Payment</strong>
                    </div>
              
            </div> 
            <?php }?>
    <section class="layout-box-content-format1">
        <table  class="table customTbl table-bordered table-hover  tablepad" style="margin-top:5px;" >
          <thead>
        <tr>
            <th>Sl</th>
			<th>Admission</th>
			<th>Subscription</th>
			<th>Discount</th>
			<th>Premium</th>
			<th>Payment</th>
			<th>Net (with Tax)</th>
			<th>Due</th>
			<th>Action</th>
		
       </tr>
          </thead>
          <tbody>
              <?php 
                $row_payment=$this->member_payment_model->GetPaymentByValidityDesc($membership_no,$row_validity->VALIDITY_STRING,$row_validity->payment_from);
            //      		   echo "<pre>";
					  //  print_r($rowPayment);
					  //  echo "</pre>";exit;
                
                $m=1;
					  if($row_payment)
					  {

                         $mem_prm=$row_payment->PRM_AMOUNT;
						  
						  
						   if($row_validity->payment_from == 'HYG'){

				
						   $rowPaymentNow=$this->member_payment_model->GetPaymentBypaymentid($row_validity->PAYMENT_ID);
						   }else{
							$rowPaymentNow=$this->member_payment_model->GetPaymentByValidity($membership_no,$row_validity->VALIDITY_STRING);
               }
               
               
						   $pmt=0;
						   $due=0;
						   $disc=0;
						   $net_with_tax=0;
						   $pmt_rem="";
						   $due_rem = "";
						   foreach($rowPaymentNow as $row_now)
						   {
							   if (strlen($row_now->CHQ_NO)!=0)
							   {
								   $chq_no=$row_now->CHQ_NO;
							   }
							   else
							   {
								   $chq_no="";
							   }

							   if (strlen($row_now->CHQ_DT)!=0)
							   {
								   $chq_dt=date("Y-m-d",strtotime($row_now->CHQ_DT));
							   }
							   else
							   {
								   $chq_dt="";
							   }
							   
							   $pmt_rem.=date("d-m-Y",strtotime($row_now->PAYMENT_DT))." => ".number_format($row_now->AMOUNT,2)." (".$row_now->PAYMENT_MODE." / ".$chq_no." & ".$chq_dt.")";
							   $pmt_rem.="<br>";

							   $pmt=$pmt+$row_now->AMOUNT;
							   $disc=$disc+$row_now->DISCOUNT_CONV+$row_now->DISCOUNT_OFFER+$row_now->DISCOUNT_NEGO+$row_now->CASHBACK_AMT;

							   $net_with_tax=$net_with_tax+$row_now->TOTAL_AMOUNT;
						   }
						   
						 
						   $due=$mem_prm-($pmt);
						   

						   if ($due>0)
						   {
							   $rowDue=$this->member_payment_model->GetDueByValidity($membership_no,$row_validity->VALIDITY_STRING,$row_validity->payment_from);
							   foreach($rowDue as $row_due)
							   {

								   $due_rem.=date("d-m-Y",strtotime($row_due->due_pybl_date))." => ".number_format($row_due->due_pybl_amt,2);
								   $due_rem.="<br>";
							   }
							    $due =  $due;
						   }
						   else
						   {
							   $due = 0;
						   }
						 
              ?>
              <tr>
                  <td width="4%"><?PHP echo($m);?></td>
                  <td width="12%"><?PHP echo(number_format($row_payment->ADMISSION,2));?></td>
                  <td width="12%"><?PHP echo(number_format($row_payment->SUBSCRIPTION,2));?></td>
                  <td width="12%"><?PHP echo(number_format($disc,2));?></td>
                  <td width="12%"><?PHP echo(number_format($row_payment->PRM_AMOUNT,2));?></td>
                  <td>
                 <u> <a href="#" data-toggle="tooltip" data-placement="bottom" title="<?PHP echo($pmt_rem);?>">
                  <?PHP echo(number_format($pmt,2));?></a></u></td>
                  <td><?PHP echo(number_format($net_with_tax,2));?></td>
                    <?PHP
	                        if ($due>0)
						   {
                            ?>
							<td><u> <a href="#" data-toggle="tooltip" data-placement="bottom" title="<?PHP echo($due_rem);?>">
                  <?PHP echo(number_format($due,2));?></a></u></td>
							<?PHP
						   }
							else
						   {
							?>
							<td ><?PHP echo(number_format($due,2));?></td>
						   <?PHP
						   }

							?>
                <td>
                 <button type="button" class="btn btn-sm action-button actinct actibtn payment_DetailsBtn" data-setstatus="N"

                            data-membershipno="<?php echo $membership_no; ?>" 
                            data-validity="<?php echo $row_validity->VALIDITY_STRING; ?>" 
                            data-paymentfrom="<?php echo $row_validity->payment_from; ?>" 
                            data-actualvalidity="<?php echo $actualValidity; ?>" 
                            data-paymentid="<?php echo $row_validity->PAYMENT_ID; ?>" 
                            data-toggle="modal" data-target="#paymentDetails" 

                          ><i class="fas fa-clipboard-list"></i> Details</button></td>
                  
            </tr>
              <?php  } ?>

          </tbody>
          </table>
</section>

<?php }?>

          </div><!-- /.card-body -->
        </div>
         </div>

         <?php } ?>





<div id="paymentDetails" class="modal fade customModal format1 right"  data-keyboard="false" data-backdrop="false">
  <div class="modal-dialog modal-lg" style="margin-top: 100px;">
    <div class="modal-content">
      <div class="modal-header" style="background: linear-gradient(90deg, #A60711 0%,#4E3FFB 100%);background-color: rgba(0, 0, 0, 0);
padding: 5px;color: #fff;">
       <h4 class="frm_header">Payment Details</h4>
        <button type="button" class="close" data-dismiss="modal"  >&times;<span class="sr-only">Close</span></button>    
      </div>
      <div class="modal-body" style="min-height: 250px;height: 50px
    overflow-y: auto;">
          <div id="payment_details_data"></div>
      </div>
    </div>
  </div>
</div>


