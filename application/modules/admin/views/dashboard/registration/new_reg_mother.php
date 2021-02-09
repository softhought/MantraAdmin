<script src="<?php echo base_url();?>assets/js/customJs/registration/jquery_bootstrap_model.js"></script>
<script src="<?php echo base_url();?>assets/js/customJs/registration/alert.min.js"></script>
<script src="<?php echo base_url();?>assets/js/customJs/registration/bootstrap_confirmation.js"></script>
<script src="<?php echo base_url();?>assets/js/customJs/registration/reg_new_mother.js"></script>
<script src="<?php echo base_url();?>assets/js/customJs/registration/reg_new_mother_innerpage.js"></script>



<link rel="stylesheet" href="<?php echo(base_url());?>assets/css/reg_new_mother.css">

<section class="layout-box-content-format1">
        <div class="card card-primary">
            <div class="card-header box-shdw">
              <h3 class="card-title">Mother Package</h3>
               <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >
                   <!-- <a href="<?php echo admin_with_base_url(); ?>createbranch" class="btn btn-info btnpos link_tab">
                  <i class="fas fa-clipboard-list"></i> List </a> -->
                </div>
           
            </div><!-- /.card-header -->
            <div class="card-body">
			
			   <form name="reg_frm"  id="reg_frm" enctype="multipart/form-data" onsubmit="return genmedvalid();"> 
			   
			   	<input type="hidden" id="entry_mode" name="entry_mode" value="NEW REG" />
				<input type="hidden" name="cmpid" id="cmpid" value="<?php echo $companyID ;?>" />

               <input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>">
                <input type="hidden" name="regId" id="regId" value="<?php echo $regId; ?>">
                <!---- ACCOUNTING YEAR ---->
                <input type="hidden" name="accountingStartDt" id="accountingStartDt" value="<?php echo $accYear->starting_date;?>" />
                <input type="hidden" name="accountingEndDt" id="accountingEndDt" value="<?php echo $accYear->ending_date ;?>" />
                <input type="hidden" name="company_id" id="company_id" value="<?php echo $companyID ;?>" />

                <!----- END-------------->

                <div class="formblock-box">   
					

                <div class="row">

				

                    <div class="block">
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-primary radio_btn_cls active" onclick="displayPanelBody('NEW REG');" >
                                <input type="radio" name="options" id="new_reg" autocomplete="off" value="NEW REG" checked> New Registrant
                            </label>
                            <label class="btn btn-primary radio_btn_cls" onclick="displayPanelBody('ENQ REG');">
                                <input type="radio" name="options" id="enq_reg" autocomplete="off" value="ENQ REG"> Registration From Enquiry
                            </label>
                            <label class="btn btn-primary radio_btn_cls" onclick="displayPanelBody('CON REG');">
                                <input type="radio" name="options" id="conv_reg" autocomplete="off" value="CON REG"> Want to Convert
                            </label>
                            </div>
                    </div>
                </div>

                <div class='row'>

                	<!-- Accordian Start -->
	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
		<!--- Panel One Enquiry-->
		<div class="panel panel-default" id="enquiry_panel" >
			<div class="panel-heading" role="tab" id="headingOne" >
				<h4 class="panel-title">
					<a id="test" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
						<i class="more-less glyphicon glyphicon-plus"></i>
						Enquiry
					</a>
				</h4>
			</div>
			<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
				<div class="panel-body">
					 <table width="100%" border="0" cellpadding="4" cellspacing="0" class="form_text2">
					<tr><td width="135">Enquiry No</td><td><input name="txt_enq_no" id="txt_enq_no" type="text" class="form_input_text enq_chng_vld form-control forminputs txtInp" style="width: 300px;" onkeyup="return getEnquiry();" value="<?PHP echo($enq_no);?>"></td></tr>

					<tr>
					<td width="135">Name</td><td id="enq"><select name="sel_name_enq" id="sel_name_enq" class="form_input_text form-control forminputs select2 " style="width: 306px;">
					<?PHP 
				    if ($mode=="Edit")
					{
  					    echo("<option value=\"".$enq_id."\">");
					    echo($enqd_name);
					    echo("</option>");
					}
					else
					{
 					    echo("<option value=\"\">Select Name</option>");
					}
                           
                     ?>
                     </select>
					</td>
					</tr>
					<tr>
					<td>&nbsp;</td>
						<td  align="center"><button type="button" class="btn btn-danger validate_div" id="enq_info" style="width: 306px;float:left;" >Validate</button></td>
						<input type="hidden" name="enq_valid_status" id="enq_valid_status"/>
					</tr>

				</table>
				</div>
			</div>
		</div> <!-- End Of Panel One Enquiry -->
		
		<!-- Existing Membership Panel Two -->
		<div class="panel panel-default" id="exst_membrshp_panel">
			<div class="panel-heading" role="tab" id="headingTwo">
				<h4 class="panel-title">
					<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
						<i class="more-less glyphicon glyphicon-plus"></i>
						Existing Membership [For conversion only]
					</a>
				</h4>
			</div>
			<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
				<div class="panel-body">
					<table width="100%" border="0" cellpadding="4" cellspacing="0" class="form_text2">
					<tr>
						<td width="135">Memb'sp No</td><td><input name="txt_ext_mno" id="txt_ext_mno" type="text" class="form_input_text mem_ext_cls form-control forminputs txtInp" style="width: 300px;" onkeyup="return getMember();" value="<?PHP echo(@$ext_mem_no);?>">
						<input name="hd_mno" id="hd_mno" type="hidden" value="<?PHP echo(@$ext_mem_id);?>">
						<input name="hd_isconverted" id="hd_isconverted" type="hidden" value="N">
						</td>
					</tr>
					<tr>
					<td>&nbsp;</td>
						<td  align="center"><button type="button" class="btn btn-danger validate_div" id="ext_mem_info" style="width: 306px;float:left;" >Validate</button></td>
						<input type="hidden" name="ext_mem_status" id="ext_mem_status"/>
					</tr>
					</table>
				</div>
			</div>
		</div> <!-- Existing Membership Panel Two End-->

		<!-- Panel Three Admission & Payment Information(s) -->
		<div class="panel panel-default" id="admsn_paymmnt_info" >
			<div class="panel-heading" role="tab" id="headingThree">
				<h4 class="panel-title">
					<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
						<i class="more-less glyphicon glyphicon-plus"></i>
						Admission & Payment Information(s)
					</a>
				</h4>
			</div>
			<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
				<div class="panel-body">
					<table width="100%" border="0" cellpadding="4" cellspacing="0" class="form_text2">
                     <input type="hidden" name="memberAccCode" id="memberAccCode" value="">
					<!-- place changed by sandipan on 10.09.2019 -->
					<tr><td width="135">Phone / Mobile*</td><td><input name="txt_phone" id="txt_phone" type="text" class="form-control forminputs form_input_text persnl_info_chng txtInp" style="width: 100px;" autocomplete="off"  value="<?PHP echo(@$phone);?>"> 						
					</td></tr>

                    <?PHP
						if ($mode=="Add")
						{
					?>

					<tr><td width="135">Registration Dt*</td><td><input name="txt_reg_dt" id="txt_reg_dt" type="text" class="form_input_text pay_info_chng form-control forminputs txtInp" style="width: 100px;" readonly>	
					<?PHP
						}
					    else
						{
					?>
					<tr><td width="135">Registration Dt*</td><td><input name="txt_reg_dt" id="txt_reg_dt" type="text" class="form_input_text pay_info_chng form-control forminputs txtInp" style="width: 100px;" value="<?PHP echo(date("m/d/Y",strtotime($reg_dt)));?>">	
					<?PHP
						}
					?>
					<!--
					<script language="JavaScript">
                    new tcal ({
 	               // form name
	               'customer_details': 'reg_frm',
	               // input name
	               'controlname': 'txt_reg_dt'
	               });
                   </script> -->
                   </td></tr>

                    <?PHP
						if ($mode=="Add")
						{
					?>

					<tr><td width="135">Payment Dt*</td><td><input name="txt_payment_dt" id="txt_payment_dt" type="text" class="form_input_text pay_info_chng form-control forminputs txtInp" style="width: 100px;" readonly>	
					<?PHP
						}
					    else
						{
					?>
					<tr><td width="135">Payment Dt*</td><td><input name="txt_payment_dt" id="txt_payment_dt" type="text" class="form_input_text pay_info_chng form-control forminputs txtInp" style="width: 100px;" value="<?PHP echo(date("m/d/Y",strtotime($payment_dt)));?>"readonly >	
					<?PHP
						}
					?>

					<!--
					<script language="JavaScript">
                    new tcal ({
 	               // form name
	               'customer_details': 'reg_frm',
	               // input name
	               'controlname': 'txt_payment_dt'
	               });
                   </script>
				   -->
                   </td></tr>

					<tr><td width="135">Business Branch*</td><td>
					<select name="sel_branch" id="sel_branch" class="form-control select2 form_input_text pay_info_chng form-control forminputs" onchange="getRate();" onclick="return getRate();" style="width:50%;">
					<!-- <select name="sel_branch" id="sel_branch" class="form_input_text pay_info_chng"  style="width: 306px;"> -->
					<option value=''>Select</option>
					<?php
				   		foreach ($rowBranch as $row_brn) { ?>
							  <option value="<?php echo $row_brn->BRANCH_CODE;?>"><?php echo $row_brn->BRANCH_NAME;?></option>
					<?php	   }
										
					?>
			

					</select>
				</td></tr>
					
					<!-- added on 20.08.2016 -->
					<tr>
						<td  width="135">Category*</td>
						<td>
						<select name="sel_category" id="sel_category" class="form_input_text pay_info_chng form-control select2"  style="width: 306px;" onchange="getPackageList(this.value);">
									<option value=''>Select</option>
									<?php
										foreach ($rowCategory as $row_cat) { ?>
											<option value="<?php echo $row_cat->id;?>"><?php echo $row_cat->category_name;?></option>
									<?php	   }
														
									?>
							

								</select>
						</td>
					</tr>
					<!-- package by category -->
					<tr>
						<td  width="135">Package*</td>
						<td>
							<div id="pack">
							<select name="sel_card" id="sel_card" class="form_input_text pay_info_chng form-control select2"  style="width: 306px;" >

								<option value="0">Select</option>
							</select>
							</div>
						</td>
					</tr>
					
					
					
			

					<tr><td width="135">Collection Branch*</td><td><select name="sel_col_branch" id="sel_col_branch" class="form_input_text pay_info_chng form-control select2" style="width: 306px;">
									<option value=''>Select</option>
									<?php
										foreach ($rowBranchCol as $row_brncol) { ?>
											<option value="<?php echo $row_brncol->BRANCH_CODE;?>"><?php echo $row_brncol->BRANCH_NAME;?></option>
									<?php	   }
														
									?>
				


					</select></td></tr>

					<tr><td width="135">Complimentary</td><td><input type="checkbox" name="chkIscompl" id="chkIscompl" onclick="makedisable();" class="checkbox pay_info_chng " /></td></tr>


					<!--<tr><td width="135">Admission Chgs</td><td><input name="txt_admission" id="txt_admission" type="text" class="form_input_text" style="width: 100px;" value="<?PHP echo($admission);?>" onkeypress="return isNumberKey(event)" onkeyup="return getPayment();" autocomplete="off"></td></tr>-->

					<tr><td width="135">Package Rate*</td><td><input name="txt_subscription" id="txt_subscription" type="text" class="form_input_text pay_info_chng form-control forminputs txtInp" style="width: 100px;" value="<?PHP echo(@$subscription);?>" onkeypress="return isNumberKey(event)" onkeyup="return getPayment();" autocomplete="off" readonly>
					<!-- cash back on sale field-->
					</td></tr>

					<tr id="promoTr">
						<!-- <td width="135">Promo</td>
                        <td>
        	                <select  multiple="multiple" name="promo" id="promo" class="form_input_text " style="width: 306px;">
                                 <option></option>                                      
                            </select>
							</td> -->
					</tr>
                    
					<tr id="casebackTr" class="casebackdispn">
                      
						<td width="135">Total Cash Back</td>
                        <td>
        	              <input type="text" name="reducecase" id="reducecase" class="form_input_text pay_info_chng form-control forminputs txtInp"  readonly>
                          <input type="hidden" name="walletchenge" id="walletchenge" value="N">      
							</td>
							
					</tr>
					

					<!-- cash back on sale-->
					<tr id="onsalecback-row" style="display:none;"><td width="135">Cash Back on<br>Sale</td><td id="cashback-txt-val"></td></tr>

					<tr><td width="135">Discount on<br>Conversion</td><td><input name="txt_disc_conv" id="txt_disc_conv" type="text" class="form_input_text pay_info_chng form-control forminputs txtInp" style="width: 100px;" value="<?PHP echo(@$disc_on_conv);?>" autocomplete="off" onkeypress="return isNumberKey(event)" onkeyup="return getPayment();"></td></tr>

					<tr><td >Discount on<br>Offer</td><td><input name="txt_disc_offer" id="txt_disc_offer" type="text" class="form_input_text pay_info_chng form-control forminputs txtInp" style="width: 100px;" value="<?PHP echo(@$disc_on_offer);?>" autocomplete="off" onkeypress="return isNumberKey(event)" onkeyup="return getPayment();">
						
    	           <span id="discount"  style="font-size: 12px;color:green;"></span>
    	       
					</td>
					
						

					</tr>

					<tr><td width="135">Discount on<br>Negotiation</td><td><input name="txt_disc_nego" id="txt_disc_nego" type="text" class="form_input_text pay_info_chng form-control forminputs txtInp" style="width: 100px;" value="<?PHP echo(@$disc_on_nego);?>" autocomplete="off" onkeypress="return isNumberKey(event)" onkeyup="return getPayment();"></td></tr>

					<tr><td width="135">Remarks for<br>Negotiation</td><td><textarea name="txt_rem_nego" id="txt_rem_nego" class="form_input_text pay_info_chng form-control forminputs txtInp" rows="4" style="width: 300px;"><?PHP echo(@$remarks_nego);?></textarea></td></tr>
					
					<tr id="cashbackamtrow" style="display:none;"><td width="135">Cash Back</td><td>
						<input name="old_mem" id="old_mem" type="hidden">
						<input name="txt_cashbck" id="txt_cashbck" type="text" class="form_input_text" style="width: 100px;" value="<?PHP //echo($premium);?>" onkeypress="return isNumberKey(event)" readonly>
					</td></tr>

					<tr><td width="135">Premium</td><td><input name="txt_premium" id="txt_premium" type="text" class="form_input_text pay_info_chng form-control forminputs txtInp" style="width: 100px;" value="<?PHP  echo(@$premium);?>" onkeypress="return isNumberKey(event)" readonly></td></tr>

					<tr><td width="135">Payment Now*</td><td><input name="txt_payment_now" id="txt_payment_now" type="text" class="form_input_text pay_info_chng form-control forminputs txtInp" style="width: 100px;" value="<?PHP echo(@$payment_now);?>" onkeypress="return isNumberKey(event)" onkeyup="return getDue();" autocomplete="off"></td></tr>

					<tr>
					<td width="135">Due*</td><td><input name="txt_due" id="txt_due" type="text" class="form_input_text pay_info_chng form-control forminputs txtInp" style="width: 100px;" value="<?PHP echo(@$due);?>" readonly></td>
					</tr>
					<!-- added by anil on 14-04-2020 -->
					<tr><td width="155">Installment</td><td>
					<select name="installment_phase" id="installment_phase" class="form_input_text pay_info_chng form-control select2" style="width: 306px;">

						<option value=''>Select</option>
									<?php
										foreach ($rowinstallment as $rowinstallment) { ?>
											<option value="<?php echo $rowinstallment->rate;?>" data-month="<?php echo $rowinstallment->installment_period;?>">
											<?php echo($rowinstallment->installment_period." (".$rowinstallment->rate."%)");?></option>
									<?php	   }
														
									?>
				

					</select>					
					<b><span style="font-size:14px;" id="extra_charges"></span></b>
					</td></tr>
					<!-- ended by anil on 14-04-2020 -->

					<tr>
					<td width="135">1st Inst. Dt</td><td><input name="txt_inst1_dt" id="txt_inst1_dt" type="text" class="form_input_text pay_info_chng form-control forminputs txtInp" disabled style="width: 100px;" readonly>	
					<!--
					<script language="JavaScript">
                    new tcal ({
 	               // form name
	               'customer_details': 'reg_frm',
	               // input name
	               'controlname': 'txt_inst1_dt'
	               });
                   </script>
				   -->
				   
                   </td>
					</tr>

					<tr>
                        <td width="135">1st Installment</td>
                        <td>
                            <input name="txt_inst1_amt" id="txt_inst1_amt" type="text" class="form_input_text pay_info_chng form-control forminputs txtInp" disabled style="width: 100px;" onkeypress="return isNumberKey(event)" onkeyup="return getAdjustment_1();" autocomplete="off" readonly>
							<input name="due_installment1_charges" id="due_installment1_charges" type="hidden">
						</td>
                     </tr>
                        <tr>
                            <td width="135">1st Cheque No</td>
                            <td>
							<div class="row">
							<div class="col-sm-3"> <input name="txt_inst1_cheque" id="txt_inst1_cheque" type="text" class="form_input_text pay_info_chng form-control forminputs " disabled  onkeypress="return isNumberKey(event)" autocomplete="off"></div>
							<div class="col-sm-1">1st Bank</div>
							<div class="col-sm-3"><input name="txt_inst1_bank" id="txt_inst1_bank" type="text" disabled class="form_input_text pay_info_chng form-control forminputs "  autocomplete="off"></div>
							<div class="col-sm-2">1st Branch</div>
							<div class="col-sm-3"><input name="txt_inst1_branch" id="txt_inst1_branch" type="text" disabled class="form_input_text pay_info_chng form-control forminputs "  autocomplete="off"></div>
							</div>
                               
                               
                              
                            </td>
                        </tr>
                        
                        
					<tr>
					<td width="135">2nd Inst. Dt</td><td><input name="txt_inst2_dt" id="txt_inst2_dt" type="text" disabled class="form_input_text pay_info_chng form-control forminputs txtInp" style="width: 100px;" readonly>	
					
					<!--
					<script language="JavaScript">
                                        new tcal ({
                                           // form name
                                           'customer_details': 'reg_frm',
                                           // input name
                                           'controlname': 'txt_inst2_dt'
                                           });
                                       </script> -->
                                       </td>
					</tr>

					<tr><td width="135">2nd Installment</td>
                         <td>
                             <input name="txt_inst2_amt" id="txt_inst2_amt" type="text" disabled class="form_input_text pay_info_chng form-control forminputs txtInp" style="width: 100px;" onkeypress="return isNumberKey(event)" onkeyup="return getAdjustment_2();" autocomplete="off" readonly>
							 <input name="due_installment2_charges" id="due_installment2_charges" type="hidden">
						 </td>
                    </tr>
					
                     <tr>
                         <td width="135">2nd Cheque No</td>
                         <td >
						 <div class="row">
							<div class="col-sm-3">  <input name="txt_inst2_cheque" id="txt_inst2_cheque" type="text" disabled class="form_input_text pay_info_chng form-control forminputs"  onkeypress="return isNumberKey(event)" autocomplete="off"></span></div>
							<div class="col-sm-1">2nd Bank</div>
							<div class="col-sm-3"> <input name="txt_inst2_bank" id="txt_inst2_bank" disabled type="text" class="form_input_text pay_info_chng form-control forminputs"  autocomplete="off"></div>
							<div class="col-sm-2">2nd Branch</div>
							<div class="col-sm-3"><input name="txt_inst2_branch" id="txt_inst2_branch" disabled type="text" class="form_input_text pay_info_chng form-control forminputs"  autocomplete="off"></div>
						</div>
                           
                            
                             
                         </td>    
						 <td></td>
                     </tr>
					 <!-- added more installment feature by anil on 09-04-2020 -->
					 <tr>
					<td width="135">3rd Inst. Dt</td><td><input name="txt_inst3_dt" id="txt_inst3_dt" disabled type="text" class="form_input_text pay_info_chng form-control forminputs txtInp" style="width: 100px;" readonly>	
								   
                     </td>
					</tr>
					 <tr>
                        <td width="135">3rd Installment</td>
                        <td>
                            <input name="txt_inst3_amt" id="txt_inst3_amt" type="text" disabled class="form_input_text pay_info_chng form-control forminputs txtInp" style="width: 100px;" onkeypress="return isNumberKey(event)" onkeyup="return getAdjustment_3();" autocomplete="off" readonly>
							<input name="due_installment3_charges" id="due_installment3_charges" type="hidden">
					    </td>
                     </tr>
                        <tr>
                            <td width="135">3rd Cheque No</td>
                            <td>
						<div class="row">
							<div class="col-sm-3"> <input name="txt_inst3_cheque" id="txt_inst3_cheque" type="text" disabled class="form_input_text pay_info_chng form-control forminputs "  onkeypress="return isNumberKey(event)" autocomplete="off"></div>
							<div class="col-sm-1">3rd Bank</div>
							<div class="col-sm-3"><input name="txt_inst3_bank" id="txt_inst3_bank" disabled type="text" class="form_input_text pay_info_chng form-control forminputs "  autocomplete="off"></div>
							<div class="col-sm-2">3rd Branch</div>
							<div class="col-sm-3"><input name="txt_inst3_branch" id="txt_inst3_branch" disabled type="text" class="form_input_text pay_info_chng form-control forminputs " autocomplete="off"></div>
						</div>
                               
                                
                                
                            </td>
                        </tr>
                        
						<tr>
					<td width="135">4th Inst. Dt</td><td><input name="txt_inst4_dt" id="txt_inst4_dt" type="text" disabled class="form_input_text pay_info_chng form-control forminputs txtInp" style="width: 100px;" readonly>	
								   
                     </td>
					</tr>
					<tr>
                        <td width="135">4th Installment</td>
                        <td>
                            <input name="txt_inst4_amt" id="txt_inst4_amt" type="text" disabled class="form_input_text pay_info_chng form-control forminputs txtInp" style="width: 100px;" onkeypress="return isNumberKey(event)" onkeyup="return getAdjustment_4();" autocomplete="off" readonly>
							<input name="due_installment4_charges" id="due_installment4_charges" type="hidden">
						</td>
                     </tr>
                        <tr>
                            <td width="135">4th Cheque No</td>
                            <td>
						<div class="row">
							<div class="col-sm-3"><input name="txt_inst4_cheque" id="txt_inst4_cheque" disabled type="text" class="form_input_text pay_info_chng form-control forminputs "  onkeypress="return isNumberKey(event)" autocomplete="off"></div>
							<div class="col-sm-1">4th Bank</div>
							<div class="col-sm-3"><input name="txt_inst4_bank" id="txt_inst4_bank" disabled type="text" class="form_input_text pay_info_chng form-control forminputs "  autocomplete="off"></div>
							<div class="col-sm-2">4th Branch</div>
							<div class="col-sm-3"><input name="txt_inst4_branch" disabled id="txt_inst4_branch" type="text" class="form_input_text pay_info_chng form-control forminputs " autocomplete="off"></div>
						</div>
                                
                                
                               
                            </td>
                        </tr>
                        <tr>
					<td width="135">5th Inst. Dt</td><td><input name="txt_inst5_dt" id="txt_inst5_dt" disabled type="text" class="form_input_text pay_info_chng form-control forminputs txtInp" style="width: 100px;" readonly>	
								   
                     </td>
					</tr>
                        
					<tr>
                        <td width="135">5th Installment</td>
                        <td>
                            <input name="txt_inst5_amt" id="txt_inst5_amt" type="text" disabled class="form_input_text pay_info_chng form-control forminputs txtInp"  onkeypress="return isNumberKey(event)" onkeyup="return getAdjustment_5();" autocomplete="off" readonly>
							<input name="due_installment5_charges" id="due_installment5_charges" type="hidden">
						</td>
                     </tr>
                        <tr>
                            <td width="135">5th Cheque No</td>
                            <td>
					   <div class="row">
							<div class="col-sm-3"><input name="txt_inst5_cheque" id="txt_inst5_cheque" type="text" disabled class="form_input_text pay_info_chng form-control forminputs "  onkeypress="return isNumberKey(event)" autocomplete="off"></div>
							<div class="col-sm-1">5th Bank</div>
							<div class="col-sm-3"><input name="txt_inst5_bank" disabled id="txt_inst5_bank" type="text" class="form_input_text pay_info_chng form-control forminputs "  autocomplete="off"></div>
							<div class="col-sm-2">5th Branch</div>
							<div class="col-sm-3"><input name="txt_inst5_branch" disabled id="txt_inst5_branch" type="text" class="form_input_text pay_info_chng form-control forminputs "  autocomplete="off"></div>
						</div>
                                
                                

                            </td>
                        </tr>

                        <tr>
					<td width="135">6th Inst. Dt</td><td><input name="txt_inst6_dt" id="txt_inst6_dt" disabled type="text" class="form_input_text pay_info_chng form-control forminputs txtInp" style="width: 100px;" readonly>	
								   
                     </td>
					</tr>
                        
					<tr>
                        <td width="135">6th Installment</td>
                        <td>
                            <input name="txt_inst6_amt" id="txt_inst6_amt" type="text" disabled class="form_input_text pay_info_chng form-control forminputs txtInp"  onkeypress="return isNumberKey(event)" onkeyup="return getAdjustment_6();" autocomplete="off" readonly>
							<input name="due_installment6_charges" id="due_installment6_charges" type="hidden">
					    </td>
                     </tr>
                        <tr>
                            <td width="135">6th Cheque No</td>
                            <td>
								 <div class="row">
							<div class="col-sm-3"> <input name="txt_inst6_cheque" id="txt_inst6_cheque" type="text" disabled class="form_input_text pay_info_chng form-control forminputs "  onkeypress="return isNumberKey(event)" autocomplete="off"></div>
							<div class="col-sm-1">6th Bank</div>
							<div class="col-sm-3"><input name="txt_inst6_bank" disabled id="txt_inst6_bank" type="text" class="form_input_text pay_info_chng form-control forminputs " autocomplete="off"></div>
							<div class="col-sm-2">6th Branch</div>
							<div class="col-sm-3"><input name="txt_inst6_branch" disabled id="txt_inst6_branch" type="text" class="form_input_text pay_info_chng form-control forminputs "  autocomplete="off"></div>
						</div>
                               
                                
                                
                            </td>
                        </tr>
                        
                        
					
					 <!-- End more installment feature by anil on 09-04-2020 -->


					<tr>
						<!-- Closed on 30.06.2017 --
						<td width="135">Tax</td><td><input name="txt_tax" id="txt_tax" type="text" class="form_input_text pay_info_chng" style="width: 100px;" value="<?PHP echo(@$tax);?>" onkeypress="return isNumberKey(event)" onkeyup="return getTotal();" autocomplete="off"></td>-->
						
						<td width="135">CGST </td>
						<td>
						<div class="row">

							<div class="col-sm-8">
							<div class="select_wrap_sml" >	
							<select name="cgstrate" id="cgstrate" class="form_input_text forminputs form-control select2 "   onchange="return getTotal();">
								
								<option value="0">Select %</option>
								<?php foreach($rowGetCGSTRate as $row_cgst){?>
								<option value="<?php echo $row_cgst->id;?>"><?php echo $row_cgst->rate; ?></option>
								<?php } ?>
								
								
							</select>
						   </div>
						</div>
							
							<div class="col-sm-2">CGST Amount</div>
							<div class="col-sm-2"><input name="cgstAmount" id="cgstAmount" type="text" class="form_input_text form-control forminputs "  onkeypress="return isNumberKey(event)" autocomplete="off" readonly  ></span></div>
							</div>
						
							
						</td>
					</tr>
					
					<tr>
						
						<td width="135">SGST </td>
						<td>
						<div class="row">
							<div class="col-sm-8">	<select name="sgstrate" id="sgstrate" class="form_input_text form-control select2"   onchange="return getTotal();">
								<option value="0">Select %</option>
								<?php foreach($rowGetSGSTRate  as $row_sgst){?>
								<option value="<?php echo $row_sgst->id;?>"><?php echo $row_sgst->rate; ?></option>
								<?php } ?>
							</select></div>
							<div class="col-sm-2">SGST Amount</div>
							<div class="col-sm-2"><input name="sgstAmount" id="sgstAmount" type="text" class="form_input_text form-control forminputs "  onkeypress="return isNumberKey(event)" autocomplete="off" readonly ></span></div>
						</div>
					</td>
					</tr>

					<tr><td width="135">Payable</td><td><input name="txt_payable" id="txt_payable" type="text" class="form_input_text pay_info_chng form-control forminputs txtInp" style="width: 100px;" value="<?PHP echo(@$tax);?>" readonly></td></tr>

					<tr><td>Payment Mode</td>
					<td><select name="sel_mode" id="sel_mode" class="form_input_text pay_info_chng form-control select2 txtInp" >
					<?PHP
					if ($mode=="Edit")
					{
					?>
					<option value="<?PHP echo($mode_data);?>"><?PHP echo($mode_data);?></option>
					<?PHP
					}
					?>

					<?PHP
					 for($m=0;$m<=sizeof($pmt_mode);$m++)
				     {
					?>
                    <?PHP
				     if ($mode_data!=$pmt_mode[$m])
			         {
					?>
					<option value="<?PHP echo($pmt_mode[$m]);?>"><?PHP echo($pmt_mode[$m]);?></option>
                    <?PHP
					 } 
					 }
					?>

					</select>
					 <input type="hidden" name="is_payment_mode_map" id="is_payment_mode_map" value='N'>
					<span id="payment_mode_err" style="font-weight:bold;color:red;"></span>
					
					</td></tr>

					<tr><td>Cheque No</td><td><input name="txt_chq_no" id="txt_chq_no" type="text" class="form_input_text pay_info_chng form-control forminputs txtInp"></td></tr>

					<tr><td>Cheque Date</td><td><input name="txt_chq_dt" id="txt_chq_dt" type="text" class="form_input_text pay_info_chng form-control forminputs txtInp"  readonly>	
					<!--
					<script language="JavaScript">
                    new tcal ({
 	               // form name
	               'customer_details': 'new_frm',
	               // input name
	               'controlname': 'txt_chq_dt'
	               });
                   </script>-->
                   </td></tr>

					<tr><td>Bank</td><td><input name="txt_bank" id="txt_bank" type="text" class="form_input_text pay_info_chng form-control forminputs txtInp"  ></td></tr>
					
					<tr><td>Branch</td><td><input name="txt_branch" id="txt_branch" type="text" class="form_input_text pay_info_chng form-control forminputs txtInp"  ></td></tr>

					<tr><td  width="200">Done by*</td><td><select name="sel_user" id="sel_user" class="form_input_text pay_info_chng form-control select2" >
					<?PHP
					if ($mode=="Edit")
					{
  					   echo("<option value=\"".$id."\">");
					   echo($name);
					   echo("</option>");

					}
					else
					{
					echo("<option value=\"\">Select</option>");
					}
					foreach ($rowUser as $row_user)
					{
                       if ($user_id!=$row_user->id)
					   {
					      echo("<option value=\"".$row_user->id."\">");
					      echo($row_user->name);
					      echo("</option>");
					   }
					}
					?>

					</select></td></tr>
					
					<tr>
						<td colspan="2" align="center"><button type="button" class="btn btn-danger validate_div" id="acc_info" style="width: 30%;" >Validate</button></td>
						<input type="hidden" name="acc_info_status" id="acc_info_status"/>
					</tr>

				</table>
				</div>
			</div>
		</div>  <!-- Panel Three Admission & Payment Information(s) End-->
		
		
		<!-- Panel Four Personal Information -->
		<div class="panel panel-default" id="personal_info_panel" disabled="true">
			<div class="panel-heading" role="tab" id="headingFour">
				<h4 class="panel-title">
					<a id="personal_anchor" class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
						<i class="more-less glyphicon glyphicon-plus"></i>
						Personal Information(s)
					</a>
				</h4>
			</div>
			<div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
				<div class="panel-body">

				<div class="row">
				<div class="col-md-8">

					<table width="100%" border="0" cellpadding="4" cellspacing="0" class="form_text2">
					<tr>
					<td width="135">First Name*</td><td><input name="txt_first_name" id="txt_first_name" type="text" class="form_input_text persnl_info_chng form-control forminputs txtInp2 memName"  value="">
					
					</tr>
					<tr>
					<td width="135">Last Name*</td><td><input name="txt_last_name" id="txt_last_name" type="text" class="form_input_text persnl_info_chng form-control forminputs txtInp2 memName"  value="">
					</tr>
					<tr><td width="135">Full Name *</td><td><input name="txt_name" id="txt_name" type="text" class="form_input_text persnl_info_chng form-control forminputs txtInp2" readonly  value="<?PHP echo(@$name);?>"></td>
					
					</tr>
<!-- 
					<tr>
					<td width="135">Name (2nd Mem)</td>
					<td>
					
					</td></tr> -->
					<input name="txt_name_2" id="txt_name_2" type="hidden" class="form_input_text persnl_info_chng form-control forminputs txtInp2"  value="<?PHP echo(@$name2);?>">

                    <?PHP
						if ($mode=="Add")
						{
					?>
					
					<tr><td width="135">Date of Birth*</td><td><input name="txt_birth" id="txt_birth" type="text" class="form_input_text persnl_info_chng form-control forminputs txtInp2"  autocomplete="off">
					<?PHP
						}
					    else
						{
					?>
					<tr><td width="135">Date of Birth*</td><td><input name="txt_birth" id="txt_birth" type="text" class="form_input_text persnl_info_chng form-control forminputs txtInp2"  value="<?PHP echo(date("m/d/Y",strtotime($dob)));?>" autocomplete="off">
					<?PHP
						}
					?>

						<tr><td width="135">Anniversary Date</td><td><input name="txt_anniversary" id="txt_anniversary" type="text" class="form_input_text persnl_info_chng form-control forminputs txtInp2"  value="<?PHP //echo(date("m/d/Y",strtotime($dob)));?>" autocomplete="off">

                   </td></tr>

					<tr><td width="135">Gender*</td><td>
						<div class="row">
							<div class="col-sm-12">
					<select name="sel_gender" id="sel_gender" class="form_input_text persnl_info_chng form-control select2">
				 
					
				   <?php
							foreach ($gender as $key => $gender) {  ?>
								<option value="<?php echo $key;?>"><?php echo $gender;?></option>
					<?php		}
				   
				   ?>
					
					
						
					</select></div></div></td></tr>
					
					<tr><td width="135">Marital Status*</td>
					<td><select name="sel_marital" id="sel_marital" class="form_input_text persnl_info_chng form-control select2 txtInp2" >
				
					<?PHP
					if ($mode=="Edit") 
					{
					?>
					<option value="<?PHP echo($stat_val);?>"><?PHP echo($stat);?></option>
					<?PHP
					}
					?>
						
					
					
					<?PHP
					
					 for($m=0;$m<=sizeof($status);$m++)
				     {
					?>
                    <?PHP
				     if ($stat!=$status[$m])
			         {
					?>
					<option value="<?PHP echo($status_val[$m]);?>"><?PHP echo($status[$m]);?></option>
                    <?PHP
					 } 
					 }
					?>
					</select></td></tr>
					
					<tr><td width="135">Blood Group*</td><td>
					<select name="sel_blood_grp" id="sel_blood_grp" class="form_input_text persnl_info_chng where_enqmst form-control select2" >
						<option value="0">Select</option>
						<?php foreach($rowBloodGroup as $blood_grp){ ?>
							<option value="<?php echo $blood_grp->bld_group_code;?>" <?php if($blood_grp==$blood_grp->bld_group_code){
							echo "selected";}else{echo "";}?>><?php echo $blood_grp->bld_group_code;?></option>
						<?php }
						?>
					</select></td></tr>
					

					<tr><td width="135">Father / Guardian</td><td><input name="txt_father" id="txt_father" type="text" class="form_input_text form-control forminputs txtInp2"  value="<?PHP echo(@$father);?>"></td></tr>


<tr><td width="135">House NO</td><td><input name="txt_houseno" id="txt_houseno" type="text" class="form_input_text form-control forminputs txtInp2 miniaddr"  value=""></td></tr>
<tr><td width="135">Building NO</td><td><input name="txt_buildingno" id="txt_buildingno" type="text" class="form_input_text form-control forminputs txtInp2 miniaddr"  value=""></td></tr>
<tr><td width="135">Appartment NO</td><td><input name="txt_apartno" id="txt_apartno" type="text" class="form_input_text form-control forminputs txtInp2 miniaddr"  value=""></td></tr>



					<tr><td width="135">Address*</td><td><textarea name="txt_add" id="txt_add" class="form_input_text persnl_info_chng form-control forminputs txtInp2" rows="4" ><?PHP echo(@$address);?></textarea></td></tr>
						<tr><td width="135">Diet*</td><td>
					<select name="sel_diet" id="sel_diet" class="form_input_text persnl_info_chng where_enqmst form-control select2" >
						
						<option value="">Select</option>
						<option value="Vegetarian">Vegetarian</option>
						<option value="Non-vegetarian">Non-vegetarian</option>
					</select></td></tr>			

			        <tr><td width="135">Pin*</td><td>
			        	<!-- <input name="txt_pin" id="txt_pin" type="text" class="form_input_text persnl_info_chng" style="width: 100px;" value="<?PHP echo(@$pin);?>"> -->
			        <select name="txt_pin" id="txt_pin" type="text" class="form_input_text persnl_info_chng form-control forminputs select2" >
			        	<option value="">Select </option>
			        	<?php
			        		foreach ($rowPin as $value) { ?>
			        		<option value="<?php echo $value->pin_code;?>"><?php echo $value->pin_code."-".$value->location;?></option>
			        			
			        	<?php	}
			        	?>

			        </select>

			        </td></tr>

					<!-- <tr><td width="135">Phone / Mobile*</td><td><input name="txt_phone" id="txt_phone" type="text" class="form_input_text persnl_info_chng" style="width: 100px;" onKeyUp="numericFilter(this);" value="<?PHP //echo(@$phone);?>"> 
						<input name="mnexst" id="mnexst" type="hidden">
					</td></tr> -->

					<tr><td width="135">Phone (Other)</td><td><input name="txt_phone2" id="txt_phone2" type="text" class="form_input_text form-control forminputs txtInp2"  value="<?PHP echo(@$phone2);?>"></td></tr>
				
					<tr><td width="135">WhatsApp No.</td><td><input name="whatsup_number" id="whatsup_number" type="text" class="form_input_text form-control forminputs txtInp2" style="width: 100px;" maxlength="10" value="<?PHP echo(@$whatsup_number);?>" onkeypress="return isNumberKey(event)"></td></tr>

					<tr><td width="135">Email ID</td><td><input name="txt_mail" id="txt_mail" type="text" class="form_input_text persnl_info_chng form-control forminputs txtInp2"  value="<?PHP echo(@$email);?>"></td></tr>

					<tr><td width="135">Website</td><td><input name="txt_website" id="txt_website" type="text" class="form_input_text persnl_info_chng form-control forminputs txtInp2"  value="<?PHP echo(@$email);?>"></td></tr>

					<tr><td width="135">Occupation</td>
					<td>
					<!-- <input name="txt_occu" id="txt_occu" type="text" class="form_input_text form-control forminputs txtInp2"  value="<?PHP echo(@$occupation);?>"> -->
								<select name="txt_occu" id="txt_occu" class="form_input_text form-control forminputs select2" >
								<option value="">Select</option>
								<?php 

								
									foreach ($occupationList as $key => $value) {							
								?>
								<option value="<?php echo $value->name;?>"><?php echo $value->name;?></option>
									<?php } ?>

								</select>


					</td>
					</tr>

					<tr><td width="165">Trainer</td><td>
					<div id="sel_trainerdrp">
					<select name="sel_trainer" id="sel_trainer" class="form_input_text form-control forminputs select2" >
					<?PHP
					if ($mode=="Edit")
					{
  					   echo("<option value=\"".$trainer_id."\">");
					   echo($trainer_name);
					   echo("</option>");

					}
					else
					{
					echo("<option value=\"\">Select Trainer</option>");
					}
					foreach ($rowTrainer as $row_trainer)
					{
                       if ($trainer_id!=$row_trainer->empl_id)
					   {
						  $empl_name=$row_trainer->empl_name.' ['.$row_trainer->branch_cd.']';
					      echo("<option value=\"".$row_trainer->empl_id."\">");
					      echo($empl_name);
					      echo("</option>");
					   }
					}
					?>

					</select>
					</div>
					
					</td></tr>
					
					<tr>
						<td>Corporate Company</td>
						<td>
							<select name="sel_corp_comny" id="sel_corp_comny" class="form_input_text form-control forminputs select2" >
								<option value="0">Select</option>
								<?php foreach($rowCorporateCompny as $corp_compny){?>
								<option value="<?php echo $corp_compny->id; ?>"><?php echo $corp_compny->company_name; ?></option>
								<?php } ?>
							</select>
						</td>
					</tr>
					
					
					<tr>
						<td colspan="2" align="center"><button type="button" class="btn btn-danger validate_div" id="personal_info" style="width: 30%;" >Validate</button></td>
						<input type="hidden" name="personal_valid_status" id="personal_valid_status"/>
					</tr>

				</table>
				
				
				
				</div>
				<div class="col-md-4">

				<table width="100%" height="390" border="0" cellpadding="3" cellspacing="0" class="form_text2" style="#border: 1px solid #8f0c06;">
								<tr>
									<td align="left">
										<div style="text-align: center; margin-bottom: 5px;">Upload Photo</div>
										&nbsp;<img id="blah" src="#" width="100" height="110" style="padding: 4px; border: 1px solid #8f0c06; margin-bottom: 5px; background-color: #fdefe4;" alt="">

										
										 
										<input type="hidden" name="MAX_FILE_SIZE" value="7000000" />
										<input name="imgInp" id="imgInp" type="file" class="file1 fileInput" accept="image/jpeg, image/gif, image/tiff, image/x-ms-bmp, image/x-png" onchange="readCommanURL(this);" data-showId="blah" data-isimage="isImage">
										<input type='hidden' name='isImage' id="isImage" value="N">

									</td>
								</tr>

								<tr>
									<td align="left">
										<!-- <div style="text-align: center; margin-bottom: 5px;">Upload Form (Page-1)</div> -->
										&nbsp;Upload Form (Page-1) &nbsp;<input type="hidden" name="MAX_FILE_SIZE" value="5000000" /><input name="doc1" id="doc1" type="file" class="file1" accept=".pdf">
									</td>
								</tr>
								<tr>
									<td align="left">
									<!-- 	<div style="text-align: center; margin-bottom: 5px;">Upload Form (Page-2)</div> -->
										&nbsp;Upload Form (Page-2) &nbsp;<input type="hidden" name="MAX_FILE_SIZE" value="5000000" /><input name="doc2" id="doc2" type="file" class="file1" accept=".pdf">
									</td>
								</tr>

								<tr>
									<td align="left">
										<!-- <div style="text-align: center; margin-bottom: 5px;">Upload Form (Page-3)</div> -->
										&nbsp;Upload Form (Page-3)&nbsp;<input type="hidden" name="MAX_FILE_SIZE" value="5000000" /><input name="doc3" id="doc3" type="file" class="file1" accept=".pdf">
									</td>
								</tr>

								<tr>
									<td align="left">
										<!-- <div style="text-align: center; margin-bottom: 5px;">Upload Form (Page-4)</div> -->
										&nbsp;Upload Form (Page-4)&nbsp;<input type="hidden" name="MAX_FILE_SIZE" value="5000000" /><input name="doc4" id="doc4" type="file" class="file1" accept=".pdf">
									</td>
								</tr>

								<tr>
									<td align="left">
										<!-- <div style="text-align: center; margin-bottom: 5px;">Upload Form (Page-5)</div> -->
										&nbsp;Upload Form (Page-5)&nbsp;<input type="hidden" name="MAX_FILE_SIZE" value="5000000" /><input name="doc5" id="doc5" type="file" class="file1" accept=".pdf">
									</td>
								</tr>

							</table>
				
				
				</div>
				</div>
								



				</div>
			</div>
		</div> <!-- Panel Four Personal Information End-->
		
		
		<!-- Panel Five Medical Information -->
		<!-- <div class="panel panel-default" id="medical_info_panel" >
			<div class="panel-heading" role="tab" id="headingFive">
				<h4 class="panel-title">
					<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
						<i class="more-less glyphicon glyphicon-plus"></i>
						Medical Information(s)
					</a>
				</h4>
			</div>
			<div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
				<div class="panel-body">
				
				<table width="100%" border="0" cellpadding="4" cellspacing="0" class="form_text2">
					<tr><td width="135">Present Complaint</td><td><textarea name="txt_comp" id="txt_comp" class="form_input_text form-control forminputs txtInp2" rows="2" style="width: 300px;" placeholder="(Optional)"><?PHP echo(@$compl);?></textarea></td></tr>
					<tr><td width="135">Past History</td><td><textarea name="txt_his" id="txt_his" class="form_input_text form-control forminputs txtInp2" rows="2" style="width: 300px;"  placeholder="(Optional)"><?PHP echo(@$past);?></textarea></td></tr>


					<tr><td>Appetite</td><td><select name="sel_app" id="sel_app" class="form_input_text med_valid_chng form-control forminputs select2" style="width: 150px;">
					<?PHP
					if ($mode=="Edit")
					{
					?>
					<option value="<?PHP echo($app_data);?>"><?PHP echo($app_data);?></option>
					<?PHP
					}
					?>

					<?PHP
					 for($m=0;$m<=sizeof($appetite);$m++)
				     {
					?>
                    <?PHP
				     if ($app_data!=$appetite[$m])
			         {
					?>
					<option value="<?PHP echo($appetite[$m]);?>"><?PHP echo($appetite[$m]);?></option>
                    <?PHP
					 } 
					 }
					?>

					</select></td></tr>

					<tr><td>Digestion</td><td><select name="sel_dig" id="sel_dig" class="form_input_text med_valid_chng form-control forminputs select2" style="width: 150px;">
					<?PHP
					if ($mode=="Edit")
					{
					?>
					<option value="<?PHP echo($digestion_data);?>"><?PHP echo($digestion_data);?></option>
					<?PHP
					}
					?>

					<?PHP
					 for($m=0;$m<=sizeof($digestion);$m++)
				     {
					?>
                    <?PHP
				     if ($digestion_data!=$digestion[$m])
			         {
					?>
					<option value="<?PHP echo($digestion[$m]);?>"><?PHP echo($digestion[$m]);?></option>
                    <?PHP
					 } 
					 }
					?>

					</select></td></tr>

					<tr><td>Heart</td><td><select name="sel_hrt" id="sel_hrt" class="form_input_text med_valid_chng form-control forminputs select2" style="width: 150px;">
										<?PHP
					if ($mode=="Edit")
					{
					?>
					<option value="<?PHP echo($heart_data);?>"><?PHP echo($heart_data);?></option>
					<?PHP
					}
					?>

					<?PHP
					 for($m=0;$m<=sizeof($heart);$m++)
				     {
					?>
                    <?PHP
				     if ($heart_data!=$heart[$m])
			         {
					?>
					<option value="<?PHP echo($heart[$m]);?>"><?PHP echo($heart[$m]);?></option>
                    <?PHP
					 } 
					 }
					?>

					</select></td></tr>

					<tr><td>Urine</td><td><select name="sel_urn" id="sel_urn" class="form_input_text med_valid_chng form-control forminputs select2" style="width: 150px;">
										<?PHP
					if ($mode=="Edit")
					{
					?>
					<option value="<?PHP echo($urine_data);?>"><?PHP echo($urine_data);?></option>
					<?PHP
					}
					?>

					<?PHP
					 for($m=0;$m<=sizeof($urine);$m++)
				     {
					?>
                    <?PHP
				     if ($urine_data!=$urine[$m])
			         {
					?>
					<option value="<?PHP echo($urine[$m]);?>"><?PHP echo($urine[$m]);?></option>
                    <?PHP
					 } 
					 }
					?>

					</select></td></tr>

					<tr><td>Nerves</td><td><select name="sel_nrv" id="sel_nrv" class="form_input_text med_valid_chng form-control forminputs select2" style="width: 150px;">
					<?PHP
					if ($mode=="Edit")
					{
					?>
					<option value="<?PHP echo($nerves_data);?>"><?PHP echo($nerves_data);?></option>
					<?PHP
					}
					?>

					<?PHP
					 for($m=0;$m<=sizeof($nerves);$m++)
				     {
					?>
                    <?PHP
				     if ($nerves_data!=$nerves[$m])
			         {
					?>
					<option value="<?PHP echo($nerves[$m]);?>"><?PHP echo($nerves[$m]);?></option>
                    <?PHP
					 } 
					 }
					?>

					</select></td></tr>

					<tr><td>ENT</td><td><select name="sel_ent" id="sel_ent" class="form_input_text med_valid_chng form-control forminputs select2" style="width: 150px;">
					<?PHP
					if ($mode=="Edit")
					{
					?>
					<option value="<?PHP echo($ent_data);?>"><?PHP echo($ent_data);?></option>
					<?PHP
					}
					?>

					<?PHP
					 for($m=0;$m<=sizeof($ent);$m++)
				     {
					?>
                    <?PHP
				     if ($ent_data!=$ent[$m])
			         {
					?>
					<option value="<?PHP echo($ent[$m]);?>"><?PHP echo($ent[$m]);?></option>
                    <?PHP
					 } 
					 }
					?>
					</select></td></tr>

					<tr><td>Orthopedic Problem</td><td><select name="sel_ort" id="sel_ort" class="form_input_text med_valid_chng form-control forminputs select2" style="width: 150px;">
					<?PHP
					if ($mode=="Edit")
					{
					?>
					<option value="<?PHP echo($ortho_data);?>"><?PHP echo($ortho_data);?></option>
					<?PHP
					}
					?>

					<?PHP
					 for($m=0;$m<=sizeof($ortho);$m++)
				     {
					?>
                    <?PHP
				     if ($ortho_data!=$ortho[$m])
			         {
					?>
					<option value="<?PHP echo($ortho[$m]);?>"><?PHP echo($ortho[$m]);?></option>
                    <?PHP
					 } 
					 }
					?>

					</select></td></tr>

					<tr><td>Psyche</td><td><select name="sel_psy" id="sel_psy" class="form_input_text med_valid_chng form-control forminputs select2" style="width: 150px;">
					<?PHP
					if ($mode=="Edit")
					{
					?>
					<option value="<?PHP echo($psyche_data);?>"><?PHP echo($psyche_data);?></option>
					<?PHP
					}
					?>

					<?PHP
					 for($m=0;$m<=sizeof($psyche);$m++)
				     {
					?>
                    <?PHP
				     if ($psyche_data!=$psyche[$m])
			         {
					?>
					<option value="<?PHP echo($psyche[$m]);?>"><?PHP echo($psyche[$m]);?></option>
                    <?PHP
					 } 
					 }
					?>

					</select></td></tr>

					<tr><td>Female Disorder</td><td><select name="sel_fem" id="sel_fem" class="form_input_text med_valid_chng form-control forminputs select2" style="width: 150px;">
					<?PHP
					if ($mode=="Edit")
					{
					?>
					<option value="<?PHP echo($disorder_data);?>"><?PHP echo($disorder_data);?></option>
					<?PHP
					}
					?>

					<?PHP
					 for($m=0;$m<=sizeof($disorder);$m++)
				     {
					?>
                    <?PHP
				     if ($disorder_data!=$disorder[$m])
			         {
					?>
					<option value="<?PHP echo($disorder[$m]);?>"><?PHP echo($disorder[$m]);?></option>
                    <?PHP
					 } 
					 }
					?>

					</select></td></tr>

					<tr><td>Diet</td><td><select name="sel_dit" id="sel_dit" class="form_input_text med_valid_chng form-control forminputs select2"  style="width: 150px;">
					<?PHP
					if ($mode=="Edit")
					{
					?>
					<option value="<?PHP echo($diet_data);?>"><?PHP echo($diet_data);?></option>
					<?PHP
					}
					?>

					<?PHP
					 for($m=0;$m<=sizeof($diet);$m++)
				     {
					?>
                    <?PHP
				     if ($diet_data!=$diet[$m])
			         {
					?>
					<option value="<?PHP echo($diet[$m]);?>"><?PHP echo($diet[$m]);?></option>
                    <?PHP
					 } 
					 }
					?>

					</select></td></tr>

					<tr><td width="135">Hold Membership</td><td><input type="checkbox" name="chkIsact" id="chkIsact" class="checkbox" /></td></tr>
					
					<tr>
						<td colspan="2" align="center"><button type="button" class="btn btn-danger validate_div" id="medical_info" style="width: 30%;background:#C9302C;border:#C9302C;" >Validate</button></td>
						
					</tr>


				</table>
				</div>
			</div>
		</div>  -->
		<input type="hidden" name="medical_info_status" id="medical_info_status" value="Y"/>
		<!-- Panel Five Medical Information End -->


		
		<!-- Panel Six Style Modification Programme-->
		<div class="panel panel-default" id="style_modify_panel">
			<div class="panel-heading" role="tab" id="headingSix">
				<h4 class="panel-title">
					<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
						<i class="more-less glyphicon glyphicon-plus"></i>
						Services interested in Life Style Modification Programme
					</a>
				</h4>
			</div>
			<div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix">
				<div class="panel-body">
					<table width="100%" border="0" cellpadding="4" cellspacing="0" class="form_text2">

					<tr><td width="135">Interested Serv. *</td><td><select name="sel_service_int" id="sel_service_int" class="form_input_text serv_int_chng form-control forminputs select2" style="width: 400px;">
					<?PHP
					if ($mode=="Edit")
					{
  					   echo("<option value=\"".$serv_id."\">");
					   echo($serv_desc);
					   echo("</option>");

					}
					else
					{
					echo("<option value=\"\">Select Services</option>");
					}
					foreach ($rowServices as $row_serv)
					{
                       if ($serv_id!=$row_serv->service_id)
					   {
					      echo("<option value=\"".$row_serv->service_id."\">");
					      echo($row_serv->service_description);
					      echo("</option>");
					   }
					}
					?>

					</select></td></tr>
					<tr>
						<td colspan="2" align="center"><button type="button" class="btn btn-danger validate_div" id="style_modify" style="width: 30%;" >Validate</button></td>
						<input type="hidden" name="select_int_status" id="select_int_status" />
					</tr>
					
				</table>
				</div>
			</div>
		</div> <!-- Panel Six Style Modification Programme End-->









		
		
		<!-- Panel Seven  Other Information(s) -->
		<div class="panel panel-default" id="other_info_panel">
			<div class="panel-heading" role="tab" id="headingSeven">
				<h4 class="panel-title">
					<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
						<i class="more-less glyphicon glyphicon-plus"></i>
						Other Information(s)
					</a>
				</h4>
			</div>
			<div id="collapseSeven" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSeven">
				<div class="panel-body">
						<div class="row"> 
						<label class="col-md-2 labletext" for="enquiry_dt">•	From where you first heard </label>   			
						<div class="col-md-10">	<select name="sel_heard" id="sel_heard" class="form_input_text form-control forminputs select2" style="width: 150px;" " >
					<!-- <option value="">Select</option> -->
					<?PHP
					if ($mode=="Edit")
					{
					?>
					<option value="<?PHP echo($heard_data);?>"><?PHP echo($heard_data);?></option>
					<?PHP
					}
					?>

					<?PHP
					 for($m=0;$m<=sizeof($heard_about);$m++)
				     {
					?>
                    <?PHP
				     if ($heard_data!=$heard_about[$m])
			         {
					?>
					<option value="<?PHP echo($heard_about[$m]);?>"><?PHP echo($heard_about[$m]);?></option>
                    <?PHP
					 } 
					 }
					?>

					</select></div>
						</div>

						<div class="row"> 	
						<label class="col-md-2 labletext" for="enquiry_dt">Mobile of Referral Person </label>  		
						<div class="col-md-2">
						<input name="txt_mem_mob" id="txt_mem_mob" type="text" class="form_input_text form-control forminputs" style="width: 225px;"   autocomplete ="off" maxlength="10" ><input name="txtmid" id="txtmid" type="hidden"></div>
						</div>

							<div class="row"> 
						<label class="col-md-2 labletext" for="enquiry_dt">Name of Referral Person  </label> 				
						<div class="col-md-2">
						<input name="txt_ref_person_name" id="txt_ref_person_name"  type="text" class="form_input_text form-control forminputs " style="width: 225px;"  autocomplete ="off" readonly ></div>
						</div>

							<div class="row"> 	
							<label class="col-md-2 labletext" for="enquiry_dt">Doctor Referral&nbsp;
							<i class="fa fa-plus-circle" style="color: green;font-size: 15px;" aria-hidden="true" data-toggle="modal" data-target="#addDoctorReferral" style="cursor:pointer;"></i>	</label>  	
						<div class="col-md-10" id="refresh_ref_doct">
						<select class="form_input_text form-control forminputs select2" id="ref_doct" name="ref_doct" style="width:254px;">
								<option value="0">Select</option>
								<?php 
									foreach($rowRefDoctor as $ref_doct){
								?>
									<option value="<?php echo $ref_doct->id; ?>"><?php echo $ref_doct->doctor_name;?></option>
								<?php } ?>
							</select>
							
							</div>
						</div>

						<div class="row"> 	
							<label class="col-md-2 labletext" for="enquiry_dt">Free Service to society	</label>  	
						<div class="col-md-10">
							<select name="sel_service" id="sel_service" class="form_input_text form-control forminputs select2" style="width: 150px;">
							<?PHP
							if ($mode=="Edit")
							{
							?>
							<option value="<?PHP echo($service_data);?>"><?PHP echo($service_data);?></option>
							<?PHP
							}
							?>

							<?PHP
							for($m=0;$m<=sizeof($service);$m++)
							{
							?>
							<?PHP
							if ($service_data!=$service[$m])
							{
							?>
							<option value="<?PHP echo($service[$m]);?>"><?PHP echo($service[$m]);?></option>
							<?PHP
							} 
							}
							?>
							</select>
							

							

						</div>
						
						</div>

							<div class="row"> 
							<div class="col-md-5"></div>	
							<div class="col-md-5">
						<button type="button" class="btn btn-danger validate_div" id="other_info" style="width: 30%;" >Proceed</button></td>
						<input type="hidden" name="other_info_status" id="other_info_status" />
							</div>	
							
							</div><br>



						



			
				</div>
			</div>
		</div>	<!-- Panel Seven  Other Information(s) End-->


			<!-- Panel Nine Style Modification Programme-->
		<div class="panel panel-default" id="style_modify_panel">
			<div class="panel-heading" role="tab" id="headingNine">
				<h4 class="panel-title">
					<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseNine" aria-expanded="false" aria-controls="collapseSix">
						<i class="more-less glyphicon glyphicon-plus"></i>
						Fitness History 
					</a>
				</h4>
			</div>
			<div id="collapseNine" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingNine">
				<div class="panel-body">
					 <br>
					 	<?php
											$rl=1;		
								foreach ($fitnessHistory as $key => $value) {?>																										
													
								<div class="row"> 			
									<div class="col-md-10">
									<div class="form-group" style="margin-left: 65px;">
									<div class="custom-control custom-radio">
									<input class="custom-control-input" type="radio" id="customRadio<?php echo $rl;?>" name="sel_fitness_history" value="<?php echo $key;?>">
									<label for="customRadio<?php echo $rl;?>" class="custom-control-label"><?php echo $value;?></label>
									</div>
									</div>
									</div>
									</div>
										<?php		$rl++;}?>


		
				<table width="100%" border="0" cellpadding="4" cellspacing="0" class="form_text2">
					<tr>
						<td colspan="2" align="center"><button type="button" class="btn btn-danger validate_div" id="style_fithistory" style="width: 30%;" >Validate</button></td>
						<input type="hidden" name="fitness_history_status" id="fitness_history_status" />
					</tr>
				</table>
				
				</div>
			</div>
		</div> <!-- Panel Nine Style Modification Programme End-->








		
		<!-- Panel Eight General Medical Assessment -->
			<div class="panel panel-default" id="gen_med_assesment_panel">
			<div class="panel-heading" role="tab" id="headingEight">
				<h4 class="panel-title">
					<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
						<i class="more-less glyphicon glyphicon-plus"></i>
						<!-- General Medical Assessment  -->
						Medical Information(s)
					</a>
				</h4>
			</div>
			<div id="collapseEight" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingEight">
				<div class="panel-body"><br>
				
				 <div class="row"> 
						<div class="col-md-1">
								<div class="form-group" style="margin-left: 65px;">												
									<div class="input-group input-group-sm">                                           
									<input type="checkbox" class="rowCheck inputcheck" name="is_high_bp" id="is_high_bp"  value="Yes" >
									</div>
								</div>       
						</div>    
						<label class="col-md-2 labletext" for="enquiry_dt">High BP </label>                         
									<div class="col-md-6">
											<div class="form-group"> 
													<div class="input-group input-group-sm">
														<input type="text" class="form-control forminputs typeahead" id="high_bp_medicines" name="high_bp_medicines" placeholder="High BP medicine" autocomplete="off" value="">
													</div>
													</div>
										</div>  
				</div>

				<div class="row"> 
			

						 <div class="col-md-3">
						 <div class="form-group" style="margin-left: 65px;">
                          <div class="custom-control custom-radio">
                          <input class="custom-control-input" type="radio" id="diabetes_radio1" name="diabetes_radio" value="Type 1">
                          <label for="diabetes_radio1" class="custom-control-label">Diabetes Type 1</label>
                          </div>
						  </div>
						   </div>
						  <div class="col-md-2">
						  <div class="custom-control custom-radio">
                          <input class="custom-control-input" type="radio" id="diabetes_radio2" name="diabetes_radio" value="Type 2">
                          <label for="diabetes_radio2" class="custom-control-label">Diabetes Type 2</label>
                          </div>
                                       
                             </div>

									<div class="col-md-4">
											<div class="form-group"> 
													<div class="input-group input-group-sm">
														<input type="text" class="form-control forminputs typeahead" id="diabetics_medicines" name="diabetics_medicines" placeholder="Diabetics  medicine" autocomplete="off" value="">
													</div>
													</div>
										</div>  
				</div>

					 <div class="row"> 
						<div class="col-md-1">
								<div class="form-group" style="margin-left: 65px;">												
									<div class="input-group input-group-sm">                                           
									<input type="checkbox" class="rowCheck inputcheck" name="is_heart_disease" id="is_heart_disease"  value="Yes" >
									</div>
								</div>       
						</div>    
						<label class="col-md-2 labletext" for="enquiry_dt">Heart disease  </label>                         
									<div class="col-md-6">
											<div class="form-group"> 
													<div class="input-group input-group-sm">
														<input type="text" class="form-control forminputs typeahead" id="heart_disease_medicines" name="heart_disease_medicines" placeholder="Heart disease medicine" autocomplete="off" value="">
													</div>
													</div>
										</div>  
				</div>

				 <div class="row"> 
						<div class="col-md-1">
								<div class="form-group" style="margin-left: 65px;">												
									<div class="input-group input-group-sm">                                           
									<input type="checkbox" class="rowCheck inputcheck" name="is_pcod" id="is_pcod"  value="Yes" >
									</div>
								</div>       
						</div>    
						<label class="col-md-2 labletext" for="enquiry_dt">PCOD</label>                         
									<div class="col-md-6">
											<div class="form-group"> 
													<div class="input-group input-group-sm">
														<input type="text" class="form-control forminputs typeahead" id="pcod_medicines" name="pcod_medicines" placeholder="PCOD medicine" autocomplete="off" value="">
													</div>
													</div>
										</div>  
				</div>

					 <div class="row"> 
						<div class="col-md-1">
								<div class="form-group" style="margin-left: 65px;">												
									<div class="input-group input-group-sm">                                           
									<input type="checkbox" class="rowCheck inputcheck" name="is_chronic_kidney_disease" id="is_chronic_kidney_disease"  value="Yes" >
									</div>
								</div>       
						</div>    
						<label class="col-md-2 labletext" for="enquiry_dt">Chronic Kidney Disease </label>                         
									<div class="col-md-6">
											<div class="form-group"> 
													<div class="input-group input-group-sm">
														<input type="text" class="form-control forminputs typeahead" id="chronic_kidney_disease_medicines" name="chronic_kidney_disease_medicines" placeholder="PCOD medicine " autocomplete="off" value="">
													</div>
													</div>
										</div>  
				</div>

					 <!-- <div class="row"> 
					    <label class="col-md-1 labletext" for="enquiry_dt"> </label>  
						<label class="col-md-2 labletext" for="enquiry_dt">Psyche </label>                         
									<div class="col-md-6">
											<div class="form-group"> 
													<div class="input-group input-group-sm">
														<select class="form_input_text form-control forminputs select2" id="sel_psyche" name="sel_psyche" style="width:254px;">
														<option value="">Select</option>
														<option value="Healthy">Healthy</option>
														<option value="Anxiety">Anxiety</option>
														<option value="Depression">Depression</option>
														<option value="Childhood Experience">Childhood Experience</option>
														<option value="Others">Others</option>
														</select>
													</div>
													</div>
										</div>  
				</div> -->

				 <div class="row"> 
					    <label class="col-md-1 labletext" for="enquiry_dt"> </label>  
						<label class="col-md-2 labletext" for="enquiry_dt">History of Regular Medication:  </label>  
							<div class="col-md-6">
						<div class="form-group"> 
						<div class="input-group input-group-sm">
					
						<textarea  class="form-control forminputs typeahead" id="regular_med_history" name="regular_med_history"></textarea>
						
						</div>
						</div>
						</div>

				</div>

						<div class="row"> 
					    <label class="col-md-1 labletext" for="enquiry_dt"> </label>  
						<label class="col-md-2 labletext" for="enquiry_dt">Recent Doctor Prescription Upload   </label>  
							<div class="col-md-6">
					 &nbsp;<input type="hidden" name="MAX_FILE_SIZE" value="5000000" /><input name="doc6" id="doc6" type="file" class="file1" accept=".pdf">
						</div>

				</div>

				
<table width="100%" border="0" cellpadding="4" cellspacing="0" class="form_text2">
					<tr>
						<td colspan="2" align="center"><button type="button" class="btn btn-danger validate_div" id="style_medicalassement" style="width: 30%;" >Validate</button></td>
						<input type="hidden" name="medical_assestment_status" id="medical_assestment_status" />
					</tr>
				</table>

			<!--	<div class="row">
                            <div class="col-md-9">
                               <p class="errormsgcolor" id="errormsg"></p>
                            </div>
                                <div class="col-md-2 text-right">
                                <button type="button" class="btn btn-sm action-button" id="gen_ass_upd" style="width: 57%;">Update</button>

                                    <span class="btn btn-sm action-button loaderbtn" id="gen_ass_upd_loader" style="display:none;width: 57%;">Updating...</span>

                                </div>
                     </div><br> -->

									
									
									
									
									
									<table width="100%" border="0" cellpadding="4" cellspacing="0" class="form_text2">
					
					<!-- <tr>
					<td width="135">Waist</td>
					<td><input name="txt_waist" id="txt_waist" type="text" class="form_input_text form-control forminputs txtInp2" style="width: 100px;" onkeypress="return isNumberKey(event)" value="<?PHP echo(@$waist);?>"></td>

					<td width="135">Weight</td>
					<td><input name="txt_weight" id="txt_weight" type="text" class="form_input_text form-control forminputs txtInp2" style="width: 100px;" onkeypress="return isNumberKey(event)" value="<?PHP echo(@$weight);?>"></td>

					<td width="135">Height</td>
					<td><input name="txt_height" id="txt_height" type="text" class="form_input_text form-control forminputs txtInp2" style="width: 100px;" onkeypress="return isNumberKey(event)" value="<?PHP echo(@$height);?>"></td>
					
					</tr> -->
					<!-- <tr>
					<td width="135">Hip</td>
					<td><input name="txt_hip" id="txt_hip" type="text" class="form_input_text form-control forminputs txtInp2" style="width: 100px;" onkeypress="return isNumberKey(event)" value="<?PHP echo(@$hip);?>"></td>

					<td width="135">Chest</td>
					<td><input name="txt_chest" id="txt_chest" type="text" class="form_input_text form-control forminputs txtInp2" style="width: 100px;" onkeypress="return isNumberKey(event)" value="<?PHP echo(@$chest);?>"></td>

					<td width="135">Hand</td>
					<td><input name="txt_hand" id="txt_hand" type="text" class="form_input_text form-control forminputs txtInp2" style="width: 100px;" onkeypress="return isNumberKey(event)" value="<?PHP echo(@$hand);?>"></td>
					
					</tr> -->

					<!-- <tr>
					<td width="135">Blood Pressure (S)</td>
					<td><input name="txt_bp" id="txt_bp" type="text" class="form_input_text form-control forminputs txtInp2" style="width: 100px;" onkeypress="return isNumberKey(event)" autocomplete ="off" value="<?PHP echo(@$bp);?>"></td>

					<td width="135">Blood Pressure (D)</td>
					<td><input name="txt_bp_d" id="txt_bp_d" type="text" class="form_input_text form-control forminputs txtInp2" style="width: 100px;" onkeypress="return isNumberKey(event)" autocomplete ="off" value="<?PHP echo(@$bp_d);?>"></td>

					<td width="135">FAT Percentage</td>
					<td><input name="txt_fat" id="txt_fat" type="text" class="form_input_text form-control forminputs txtInp2" style="width: 100px;" onkeypress="return isNumberKey(event)" autocomplete ="off" value="<?PHP echo(@$fat);?>"></td>
                    
					</tr> -->

					<!-- <tr>
					<td width="135">Heart Rate</td>
					<td><input name="txt_heart_rate" id="txt_heart_rate" type="text" class="form_input_text form-control forminputs txtInp2" style="width: 100px;" onkeypress="return isNumberKey(event)" autocomplete ="off" value="<?PHP echo(@$heart_rate);?>"></td>

					<td width="135">Oxygen Saturation Level</td>
					<td><input name="txt_oxy_level" id="txt_oxy_level" type="text" class="form_input_text form-control forminputs txtInp2" style="width: 100px;" onkeypress="return isNumberKey(event)" autocomplete ="off" value="<?PHP echo(@$oxy_level);?>"></td>

					<td width="135">ECG</td>
					<td><textarea name="txt_ecg" id="txt_ecg" class="form_input_text form-control forminputs txtInp2" rows="2" style="width: 100px;"><?PHP echo(@$ecg);?></textarea></td>
					</tr> -->

					<!-- <tr>
					<td width="135">Chest Xray</td>
					<td><textarea name="txt_chest_xray" id="txt_chest_xray" class="form_input_text form-control forminputs txtInp2" rows="2" style="width: 100px;"><?PHP echo(@$chest_xray);?></textarea></td>

					<td width="135">Vo2 max</td>
					<td><input name="txt_vo2" id="txt_vo2" type="text" class="form_input_text form-control forminputs txtInp2" style="width: 100px;" onkeypress="return isNumberKey(event)" autocomplete ="off" value="<?PHP echo(@$vo2_max);?>"></td>

					</tr> -->

					
					
				</table>
				
				</div>
				
			</div>
		</div> <!-- Panel Eight General Medical Assessment End-->
		<!-- Panel 8 close -->


		
			<!-- Panel Nine Style Modification Programme-->
		<div class="panel panel-default" id="style_modify_panel">
			<div class="panel-heading" role="tab" id="headingTen">
				<h4 class="panel-title">
					<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTen" aria-expanded="false" aria-controls="collapseSix">
						<i class="more-less glyphicon glyphicon-plus"></i>
						Agreements
					</a>
				</h4>
			</div>
			<div id="collapseTen" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTen">
				<div class="panel-body">
				   <div class="row"> 
				     <label for="branch_id" class="col-md-2 labletext">&nbsp;Fitness Waivers:   </label>
				     <div class="col-md-9"><p>I am participating in this selected Mantra programme of my own interest and take full responsibility
					  for my participation. I release Mantra, all its organization, teachers and assistants in this program from all damages whatsoevers and waive all rights
					   to compensation in case of injury. I declare that I am physically and mentally fit to participate in this program. I will not teach any techniques of 
					   the programme unless I have training certificates from Mantra . I will keep the content of the programme and the techniques revealed to me during the
					    program confidential. </p> 
						</div>
						</div>
						<div class="row" style="margin-top: -15px;">
						<div class="col-md-2"></div>
						<label for="branch_id" class="col-md-1 labletext">&nbsp;I agree  </label>
						<div class="col-md-1">
										<div class="form-group" style="">												
											<div class="input-group input-group-sm">                                           
											<input type="checkbox" class="rowCheck inputcheck agreecheck" name="is_participating" id="is_participating"  value="" >
											</div>
										</div>       
								</div>
						</div>


						 <div class="row"> 
				    <label for="branch_id" class="col-md-2 labletext">&nbsp; Terms and conditions:  </label>
				     <div class="col-md-9"><p>I agree to receive information from the Mantra Health Club and its sister concerns through various media, 
					 including print, digital, with a facilities to opt out.  </p> 
						</div>
						</div>
						<div class="row" style="margin-top: -15px;">
						<div class="col-md-2"></div>
						<label for="branch_id" class="col-md-1 labletext">&nbsp;I agree  </label>
						<div class="col-md-1">
										<div class="form-group" style="">												
											<div class="input-group input-group-sm">                                           
											<!-- <input type="checkbox" class="rowCheck inputcheck agreecheck" name="is_receive_info" id="is_receive_info"  value="" > -->
												<input type="checkbox" class="rowCheck inputcheck agreecheck" name="is_term_con" id="is_term_con"  value="" >
											</div>
										</div>       
								</div>
								<hr>
						</div>

						<!-- <div class="row"> 
				 
				     <label for="branch_id" class="col-md-1 labletext">&nbsp;I agree  </label>
						
						<div class="col-md-1">
										<div class="form-group" style="">												
											<div class="input-group input-group-sm">                                           
											<input type="checkbox" class="rowCheck inputcheck agreecheck" name="is_term_con" id="is_term_con"  value="" >
											</div>
										</div>       
								</div>
								
						</div> -->

						<div class="row"> 
						<label for="branch_id" class="col-md-2 labletext">&nbsp;Health club Etiquette :  </label>
						<label for="branch_id" class="col-md-1 labletext">&nbsp;I agree  </label>
						<div class="col-md-1">
										<div class="form-group" style="">												
											<div class="input-group input-group-sm">                                           
											<input type="checkbox" class="rowCheck inputcheck agreecheck" name="is_health_club_eti" id="is_health_club_eti"  value="" >
											</div>
										</div>       
								</div>
						
						</div>

						<div class="row">
						<div class="col-md-2"></div>
						<div class="col-md-2" id="send_term_verfy_code" style="display:none;"><span class="badge badge-danger" style="cursor: pointer;margin-top:5px;">Send Verification Code</span></div>
									<div class="col-md-2 trmVerify"  style="display:none;">
											<div class="form-group"> 
													<div class="input-group input-group-sm" id="term_condition_verify_code_err">
		      	<input type="text" maxlength="6" class="form-control forminputs typeahead" id="term_condition_verify_code" name="term_condition_verify_code" placeholder="Verification code " autocomplete="off" value="">
													</div>
													</div>
												
										</div> 

</a>
								<div class="col-md-1 trmVerify"  style="display:none;">
								<span class="badge badge-danger " id="verify_code" style="cursor: pointer;margin-top:5px;">Verify</span>
								<span class="badge badge-secondary " id="verify_no" style="cursor: pointer;margin-top:5px;">Verify</span>
								<a id="wplink" href="https://api.whatsapp.com/send?text=https://www.mantrahealthclub.com/mantra/termofuse/agreement/16" target="_blank" > <img src="<?php echo base_url(); ?>assets/img/wp.png" width="20" height="20" /></a>


								</div>

								 <label for="branch_id" class="col-md-5 labletext trmVerify"  style="display:none;">
								 <span id="resend_term_verfy_code" style="cursor: pointer;">Resend </span> 
								 <span style="color:gray" id="otp_text_mobile"> </span> 
								 </label>
							<div class="col-md-4" id="after_signed" style="display:none">
							<span class="badge badge-success" style="cursor: pointer;margin-top:5px;">Successfully signed Agreement <i class="fa fa-check-circle" aria-hidden="true"></i>
</span></div>
						
						</div>

						<input type="hidden" id="agreement_sign_id" name="agreement_sign_id" value="0">
						<input type="hidden" id="is_agreement_sign" name="is_agreement_sign" value="N">
						<input type="hidden" id="agreement_sign_needed" name="agreement_sign_needed" value="<?php echo $agreement_sign_needed;?>">

									<br><br>
		
				
				
				</div>
			</div>
		</div> <!-- Panel Nine Style Modification Programme End-->








		

	</div><!-- panel-group --><!-- Close Accordian -->


	<div style="width: 450px; margin: 0 auto;">
			   <?PHP
			   if ($mode=="Add")
			   {
			   ?>
				<!--<input name="submit" type="submit" value="Submit" class="button_c" style="float: left; margin-right: 4px; width: 60px;">--> 
				<input name="submit" type="submit" value="Submit" class="btn btn-success" id="submit_form" style="float: left; margin-right: 4px; width: 100px;font-weight:bold;text-shadow:1px 1px #323232;visibility:hidden;padding:2px;" data-toggle="confirmation" data-btn-ok-label="Yes" data-btn-ok-class="btn-success" data-btn-cancel-label="No" data-btn-cancel-class="btn-danger" data-title="Are You Sure?" data-content="Please check preview before final submission. Do you want to submit. ">
				
				<?PHP
			   }
			   else
			   {
			   ?>
				<input name="submit" type="submit" value="Update" class="button_c" style="float: left; margin-right: 4px; width: 60px;">
				<input name="txt_pmt_id" id="txt_pmt_id" type="hidden" class="form_input_text" style="width: 300px;" value="<?PHP echo($pmt_id);?>">
               <?PHP
			   }
			   ?>

			    <button type="button" id="loaderbtn" class="btn btn-success" style="float: left; margin-right: 4px; width: 100px;font-weight:bold;text-shadow:1px 1px #323232;padding:3px;display:none;"><?php echo $btnTextLoader;?></button>

			   <button type="button" id="preview" class="btn btn-warning" style="float: left; width: 100px;font-weight:bold;text-shadow:1px 1px #323232;margin-right:4px;color: #fff!important;padding:3px;" onclick="showPreview();" data-toggle="modal" data-target="#previewModal">Preview</button>
			   
				<input name="reset" type="reset" class="btn btn-danger" value="Reset" style="float: left; width: 100px;font-weight:bold;text-shadow:1px 1px #323232;margin-right:4px;padding:2px;">
				
				
			
				
			</div>




                </div>
                         
                         
                         
                        
                </div>

                    <div class="formblock-box">
                        <div class="row">
                            <div class="col-md-10">
                               <p class="errormsgcolor" id="errormsg"></p>
                            </div>
                           <!--      <div class="col-md-2 text-right">
                                    <button type="submit" class="btn btn-sm action-button" id="branchsavebtn" style="width: 57%;"><?php echo $btnText; ?></button>

                                    <span class="btn btn-sm action-button loaderbtn" id="loaderbtn" style="display:none;width: 57%;"><?php echo $btnTextLoader; ?></span>

                                </div> -->
                            </div>
                    </div>
                    </form>
                               
         </div>
</div><!-- /.card-body -->

</section>



<!--     ------------------------start  Model Preview  -------------------------        -->

<!-- Modal For Preview-->
<div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="previewModal" >
  <div class="modal-dialog modal-lg" role="document" >
    <div class="modal-content" >
      <div class="modal-header">
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
        <h4 class="modal-title" id="previewModal">Preview</h4>
      </div>
      <div class="modal-body" style="height:400px;overflow-y:scroll;font-size:13px;">
	  
		<h3>Admission & Payment Information(s)</h3>
		<div class="table-responsive">
			  <table class="table">
			  <tr>
					<td>Phone / Mobile</td>
					<td id="prv_phone_mobile"></td>
				</tr>
				<tr>
					<td>Registration Dt</td>
					<td id="prv_reg_dt"></td>
				</tr>
				<tr>
					<td>Payment Dt</td>
					<td id="prv_payment_dt"></td>
				</tr>
				
				<tr>
					<td>Business Branch</td>
					<td id="prv_bus_brnch"></td>
				</tr>
				<tr>
					<td>Category</td>
					<td id="prv_category"></td>
				</tr>
				<tr>
					<td>Package</td>
					<td id="prv_pkg"></td>
				</tr>
				<tr>
					<td>Collection Branch</td>
					<td id="prv_col_brnch"></td>
				</tr>
				<tr>
					<td>Complimentary</td>
					<td id="prv_comply"></td>
				</tr>
				<tr>
					<td>Pakage Rate</td>
					<td id="prv_packg_rate"></td>
				</tr>
				<tr>
					<td>Discount on Conversion</td>
					<td id="prv_dis_conv"></td>
				</tr>
				<tr>
					<td>Discount on Offer</td>
					<td id="prv_dis_off"></td>
				</tr>  
				<tr>
					<td>Discount on Negotiation</td>
					<td id="prv_dis_nego"></td>
				</tr>
				<tr>
					<td>Remarks for Negotiation</td>
					<td id="prv_rmk_nego"></td>
				</tr> 
				<tr>
					<td>Premium</td>
					<td id="prv_prm"></td>
				</tr> 
				<tr>
					<td>Payment Now</td>
					<td id="prv_paymnt_nw"></td>
				</tr> 
				<tr>
					<td>Due</td>
					<td id="prv_due"></td>
				</tr> 
				<tr>
					<td>1st Inst. Dt</td>
					<td id="prv_1st_inst_dt"></td>
				</tr>  
				<tr>
					<td>1st Installment</td>
					<td id="prv_1st_inst"></td>
				</tr> 
				<tr>
					<td>1st Cheque No</td>
					<td id="prv_1st_chq_no"></td>
				</tr>  
				<tr>
					<td>1st Bank</td>
					<td id="prv_1st_bnk"></td>
				</tr>
				<tr>
					<td>1st Branch</td>
					<td id="prv_1st_brn"></td>
				</tr>
				<tr>
					<td>2nd Inst. Dt</td>
					<td id="prv_2nd_inst_dt"></td>
				</tr> 
				<tr>
					<td>2nd Installment</td>
					<td id="prv_2nd_inst"></td>
				</tr> 
				<tr>
					<td>2nd Cheque No</td>
					<td id="prv_2nd_chq_no"></td>
				</tr>
				<tr>
					<td>2nd Bank</td>
					<td id="prv_2nd_bnk"></td>
				</tr>
				<tr>
					<td>2nd Branch </td>
					<td id="prv_2nd_brn"></td>
				</tr>
				<!-- added by anil on 09-04-2020 -->
				<tr>
					<td>3rd Inst. Dt</td>
					<td id="prv_3rd_inst_dt"></td>
				</tr> 
				<tr>
					<td>3rd Installment</td>
					<td id="prv_3rd_inst"></td>
				</tr> 
				<tr>
					<td>3rd Cheque No</td>
					<td id="prv_3rd_chq_no"></td>
				</tr>
				<tr>
					<td>3rd Bank</td>
					<td id="prv_3rd_bnk"></td>
				</tr>
				<tr>
					<td>3rd Branch </td>
					<td id="prv_3rd_brn"></td>
				</tr>
				<tr>
					<td>4th Inst. Dt</td>
					<td id="prv_4th_inst_dt"></td>
				</tr> 
				<tr>
					<td>4th Installment</td>
					<td id="prv_4th_inst"></td>
				</tr> 
				<tr>
					<td>4th Cheque No</td>
					<td id="prv_4th_chq_no"></td>
				</tr>
				<tr>
					<td>4th Bank</td>
					<td id="prv_4th_bnk"></td>
				</tr>
				<tr>
					<td>4th Branch </td>
					<td id="prv_4th_brn"></td>
				</tr>
				<tr>
					<td>5th Inst. Dt</td>
					<td id="prv_5th_inst_dt"></td>
				</tr> 
				<tr>
					<td>5th Installment</td>
					<td id="prv_5th_inst"></td>
				</tr> 
				<tr>
					<td>5th Cheque No</td>
					<td id="prv_5th_chq_no"></td>
				</tr>
				<tr>
					<td>5th Bank</td>
					<td id="prv_5th_bnk"></td>
				</tr>
				<tr>
					<td>5th Branch </td>
					<td id="prv_5th_brn"></td>
				</tr>
				<tr>
					<td>6th Inst. Dt</td>
					<td id="prv_6th_inst_dt"></td>
				</tr> 
				<tr>
					<td>6th Installment</td>
					<td id="prv_6th_inst"></td>
				</tr> 
				<tr>
					<td>6th Cheque No</td>
					<td id="prv_6th_chq_no"></td>
				</tr>
				<tr>
					<td>6th Bank</td>
					<td id="prv_6th_bnk"></td>
				</tr>
				<tr>
					<td>6th Branch </td>
					<td id="prv_6th_brn"></td>
				</tr>
				<!-- end by anil on 09-04-2020 -->
				<tr>
					<td>Tax </td>
					<td id="prv_tax"></td>
				</tr>
				<tr>
					<td>Payable </td>
					<td id="prv_payble"></td>
				</tr>
				<tr>
					<td>Payment Mode </td>
					<td id="prv_payment_mode"></td>
				</tr>
				<tr>
					<td>Cheque No</td>
					<td id="prv_chq_no"></td>
				</tr>
				<tr>
					<td>Cheque Date</td>
					<td id="prv_chq_dt"></td>
				</tr>
				<tr>
					<td>Bank</td>
					<td id="prv_bnk"></td>
				</tr>
				<tr>
					<td>Branch</td>
					<td id="prv_brnch"></td>
				</tr> 
				<tr>
					<td>Done by</td>
					<td id="prv_done_by"></td>
				</tr>
				</table>
				
			<h3>Personal Information(s)</h3>
			<table class="table">
			   <tr>
					<td>First Name </td>
					<td id="prv_first_name"></td>
				</tr>
				<tr>
					<td>Last Name </td>
					<td id="prv_last_name"></td>
				</tr>
				<tr>
					<td>Full Name </td>
					<td id="prv_full_name"></td>
				</tr>
				<!-- <tr>
					<td>Name (2nd Mem)</td>
					<td id="prv_2nd_name"></td>
				</tr> -->
				<tr>
					<td>Date of Birth</td>
					<td id="prv_dob"></td>
				</tr> 
				<tr>
					<td>Date of Birth</td>
					<td id="prv_anv_dt"></td>
				</tr> 
				<tr>
					<td>Gender</td>
					<td id="prv_gender"></td>
				</tr>
				<tr>
					<td>Marital Status</td>
					<td id="prv_maritl_status"></td>
				</tr>
				<tr>
					<td>Blood Group</td>
					<td id="prv_bld_grp"></td>
				</tr>
				<tr>
					<td>Father / Guardian</td>
					<td id="prv_father"></td>
				</tr>
				<tr>
					<td>House No</td>
					<td id="prv_houseno"></td>
				</tr>
				<tr>
					<td>Building No</td>
					<td id="prv_buildingno"></td>
				</tr>
				<tr>
					<td>Appartmemt No</td>
					<td id="prv_apartno"></td>
				</tr>
				<tr>
					<td>Address</td>
					<td id="prv_add"></td>
				</tr>
				<tr>
					<td>Diet</td>
					<td id="prv_diet"></td>
				</tr>
				<tr>
					<td>Pin</td>
					<td id="prv_pin"></td>
				</tr>
				<tr>
					<td>Phone / Mobile</td>
					<td id="prv_mobile"></td>
				</tr>
				<tr>
					<td>Phone (Other)</td>
					<td id="prv_phn_othr"></td>
				</tr>
				<tr>
					<td>Email ID</td>
					<td id="prv_email"></td>
				</tr>
				<tr>
					<td>Occupation</td>
					<td id="prv_occup"></td>
				</tr>
				<tr>
					<td>Trainer</td>
					<td id="prv_trainer"></td>
				</tr>
			</table>
			
			<!-- <h3>Medical Information(s)</h3>
			<table class="table">
				<tr>
					<td>Present Complaint</td>
					<td id="prv_prs_comp"></td>
				</tr>
				<tr>
					<td>Past History</td>
					<td id="prv_past_his"></td>
				</tr>
				<tr>
					<td>Appetite</td>
					<td id="prv_appetit"></td>
				</tr> 
				<tr>
					<td>Digestion</td>
					<td id="prv_digestion"></td>
				</tr>
				<tr>
					<td>Heart</td>
					<td id="prv_heart"></td>
				</tr>
				<tr>
					<td>Urine</td>
					<td id="prv_urine"></td>
				</tr>
				<tr>
					<td>Nerves</td>
					<td id="prv_nerve"></td>
				</tr>
				<tr>
					<td>ENT</td>
					<td id="prv_ent"></td>
				</tr>
				<tr>
					<td>Orthopedic Problem</td>
					<td id="prv_ortho_prb"></td>
				</tr>
				<tr>
					<td>Psyche</td>
					<td id="prv_psyche"></td>
				</tr>
				<tr>
					<td>Female Disorder</td>
					<td id="prv_fml_disorder"></td>
				</tr>
				<tr>
					<td>Diet</td>
					<td id="prv_diet"></td>
				</tr>
				<tr>
					<td>Hold Membership</td>
					<td id="prv_hold_mem"></td>
				</tr>
				
			</table> -->
			
			<h3>Services interested in Life Style Modification Programme</h3>
			<table class="table">
				<tr>
					<td>Interested Serv. </td>
					<td id="prv_int_serv"></td>
				</tr>
			</table>
			
			<h3>Other Information(s)</h3>
				<table class="table">
				<tr>
					<td>First heard from</td>
					<td id="prv_first_herd"></td>
				</tr>
				<tr>
					<td> Member's Mobile No</td>
					<td id="prv_mem_mbl"></td>
				</tr>
				<tr>
					<td> Member's Detail</td>
					<td id="prv_mem_dtl"></td>
				</tr>
				<tr>
					<td>Doctor Referral</td>
					<td id="prv_doct_ref"></td>
				</tr>
				<tr>
					<td>Free Service to society</td>
					<td id="prv_free_serv"></td>
				</tr> 
				
			</table>
					<h3>Fitness History</h3>
				<table class="table">
				<tr>
					<td>Type</td>
					<td id="prv_fitmess_history"></td>
				</tr>
				
				</tr> 
				
			</table>
			
			<!-- <h3>General Medical Assessment</h3> -->
			<h3>Medical Information(s)</h3>
			<table class="table">
				<tr>
					<td>Hign BP</td>
					<td id="prv_high_bp"></td>
				    <td>&nbsp;&nbsp;</td>
				    <td>High BP Medicine</td>
					<td id="prv_high_bp_med"></td>
				</tr>
				<tr>
					<td>Diabetes</td>
					<td id="prv_diabetes"></td>
				    <td>&nbsp;&nbsp;</td>
				    <td>Diabetes Medicine</td>
					<td id="prv_diabetes_med"></td>
				</tr>

				<tr>
					<td>Heart disease</td>
					<td id="prv_heart_disease"></td>
				    <td>&nbsp;&nbsp;</td>
				    <td>Diabetes Medicine</td>
					<td id="prv_heart_disease_med"></td>
				</tr>

				
				<tr>
					<td>PCOD</td>
					<td id="prv_pcod"></td>
				    <td>&nbsp;&nbsp;</td>
				    <td>PCOD Medicine</td>
					<td id="prv_pcod_med"></td>
				</tr>

				<tr>
					<td>Chronic Kidney Disease</td>
					<td id="prv_chronic_kidney"></td>
				    <td>&nbsp;&nbsp;</td>
				    <td> Medicine</td>
					<td id="prv_chronic_kidney_med"></td>
				</tr>

				<tr>
					<td>Psyche </td>
					<td id="prv_psyche "></td>
				    <td>&nbsp;&nbsp;</td>
				    <td> Psyche Medicine</td>
					<td id="prv_psyche"></td>
				</tr>

				<tr>
					<td>History of Regular Medication:  </td>
					<td colspan="3" id="prv_regular_med_history "></td>
				  
				</tr>


				<!-- <tr>
					<td>Waist</td>
					<td id="prv_waist"></td>
				</tr>
				<tr>
					<td>Weight</td>
					<td id="prv_weight"></td>
				</tr>
				<tr>
					<td>Height</td>
					<td id="prv_height"></td>
				</tr> 
				<tr>
					<td>Hip</td>
					<td id="prv_hip"></td>
				</tr>
				<tr>
					<td>Chest</td>
					<td id="prv_chest"></td>
				</tr>
				<tr>
					<td>Hand</td>
					<td id="prv_hand"></td>
				</tr>
				<tr>
					<td>Blood Pressure (S)</td>
					<td id="prv_bp_s"></td>
				</tr>
				<tr>
					<td>Blood Pressure (D)</td>
					<td id="prv_bp_d"></td>
				</tr>
				<tr>
					<td>FAT Percentage</td>
					<td id="prv_fat_per"></td>
				</tr>
				<tr>
					<td>Heart Rate</td>
					<td id="prv_heart_rt"></td>
				</tr>
				<tr>
					<td>Oxygen Saturation Level</td>
					<td id="prv_oxy_lvl"></td>
				</tr>
				<tr>
					<td>ECG</td>
					<td id="prv_ecg"></td>
				</tr>
				<tr>
					<td>Chest Xray</td>
					<td id="prv_chst_xray"></td>
				</tr> 
				<tr>
					<td>Vo2 max</td>
					<td id="prv_vo2_max"></td>
				</tr>  -->
				
			</table>
			
		</div>
		</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" style="background:#F64019;border:#E7371A;color:#FFF;font-weight:bold;">Close</button>
      </div>
    </div>
  </div>
</div>

<!--   ---------------------------end  Model Preview   ----------------------------       -->



<!-- set up the modal to start hidden and fade in and out -->
<div id="myModal" class="modal fade validation" >
  <div class="modal-dialog" style="width:500px;">
    <div class="modal-content">
      <!-- dialog body -->
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
			<p id="valid_err"></p>
      </div>
      <!-- dialog buttons -->
      <!-- <div class="modal-footer"><button type="button" class="btn btn-primary" id="btnhide" >OK</button></div> -->
    </div>
  </div>
</div>




<!-- Sucess Message -->
<div id="successMesg" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content" class="">
				   <div class="modal-header">
					<!--<button type="button" class="close" data-dismiss="modal" onclick="closeAddDoctorRef();">&times;</button> -->
					<h4 class="modal-title" style="font-family: verdana;font-size: 17px;text-align: center;color: #747474;">Message</h4>
				  </div>
				  <div class="modal-body">
					<table class="modal_table_cls" style="width:55%;margin:0 auto;">
						<tr>
							<td>&nbsp;</td>
							<td style="color: #16994F;font-weight:bold;font-size:12px;">
							<i class="fa fa-check-circle" aria-hidden="true" style="color:green"></i>
 							Referral doctor added successfully.</td>
						</tr>
					</table>
					</div>
				  <div class="modal-footer" >
				<!--	<button type="button" class="btn btn-danger" style="font-family:verdana;font-size:12px;" onclick="clearHarvardField();"><i class="glyphicon glyphicon-refresh"></i> Refresh Me</button> -->
					<button type="button" class="btn btn-success" data-dismiss="modal" style="font-family:verdana;font-size:12px;" >Close</button>
				  </div>
				</div>

			  </div>
</div>

	<!--- ADD referral Doctor -->
	<div class="modal fade" id="addDoctorReferral" role="dialog">
		<div class="modal-dialog">
    
			<!-- Modal content-->
		  <div class="modal-content">
			<div class="modal-header" style="box-shadow:0px;">
			  <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
			  <h4 class="modal-title">Add Referral Doctor</h4>
			</div>
			<div class="modal-body">
			 <table border="0" cellpadding="4" cellspacing="0" style="width:390px;margin:0 auto;">
				<tr>
                <td class="form_text2">Doctor's Name *</td>
                <td>
					<input type="text" name="doctor_name" id="doctor_name" class="add_doctref_input" style="height:24px;"  />
                </td>
                </tr>
				<tr>
                    <td class="form_text2">Degree</td>
                    <td>
					<textarea name="degree" id="degree" style="height:50px;resize:none;" class="add_doctref_input"></textarea>
                    </td>
                </tr>
				<tr>
					<td>&nbsp;</td>
					<td id="doc_ref_err" style="font-size:12px;color:#F00;font-weight:bold;display:none;">* Fields are required.</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><button type="button" class="btn btn-success" style="width:100%;" onclick="addReferralDoctor();">Add</button></td>
				</tr>
			</table>
			</div>
			<div class="modal-footer">
			  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>
		  </div>
      </div>
	</div>
  
		
	<!-- End Add Referral Doctor -->