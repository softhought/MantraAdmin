<?php
	session_start();
	if(empty($_SESSION['YID']))
	{
	   echo '<script>window.location.href="logout.php";</script>';
	   exit();
	}

	include ('system/database.php');
	include ('system/Zebra_Pagination.php');
	include ('disp.reg.cls.php');
	include ('disp.mem_edit.cls.php');

	$obj_reg_inc = new reg_inc;
	$disp_mem_cls = new mem_edit;


	$rowBranch=$obj_reg_inc->GetBranchList($_SESSION['COMPANY']);
	$rowCard=$obj_reg_inc->GetCardList();
	$rowServices=$obj_reg_inc->GetServiceList();
	$rowUser=$obj_reg_inc->getUsers();
	$rowTrainer=$obj_reg_inc->GetTrainerListAll();
	$rowCategory=$obj_reg_inc->getCategoryList();
	$rowBloodGroup = $obj_reg_inc->getBloodGroupList();

	$rowGetCGSTRate = $obj_reg_inc->GetGSTRate('CGST',$_SESSION['COMPANY']);
	$rowGetSGSTRate = $obj_reg_inc->GetGSTRate('SGST',$_SESSION['COMPANY']);

	$cid = $_POST['cid'];
	$pid = $_POST['pid'];
	$mno = $_POST['mem'];


	$rowMemberInfo = $obj_reg_inc->getMemberDetailsByCode($mno);
	$rowMemberPayment = $obj_reg_inc->GetPaymentData($pid);
	$rowDueData =  $disp_mem_cls->GetDueDetailData($pid);





	$name = "";
	$cus_card = "";
	$dob = "";
	$gender = "";
	$marital_status = "";
	$phone = "";
	$bloodGrp = "";
	$father = "";
	$pin = "";
	$email = "";
	$occupation = "";
	$trainer = "";
	$address = "";
	$done_by = "0";

	foreach($rowMemberInfo as $mem_info)
	{
		$reg_date = $mem_info['REGISTRATION_DT'];
		$name = $mem_info['CUS_NAME'];
		$cus_card = $mem_info['CUS_CARD'];
		$dob = $mem_info['CUS_DOB'];
		$gender = $mem_info['CUS_SEX'];
		$marital_status = $mem_info['CUS_MS'];
		$phone = $mem_info['CUS_PHONE'];
		$bloodGrp = $mem_info['CUS_BLOOD_GRP'];
		$father = $mem_info['CUS_FATHER'];
		$pin = $mem_info['CUS_PIN'];
		$email = $mem_info['CUS_EMAIL'];
		$occupation = $mem_info['CUS_OCCUPATION'];
		$trainer = $mem_info['trainer_id'];
		$address = $mem_info['CUS_ADRESS'];
		$is_compl = $mem_info['IS_COMPLI'];
		$done_by = $mem_info['done_by'];
		$whatsup_num = $mem_info['whatsup_number'];


	}



	$rowCardCategory = $disp_mem_cls->getCategoryByCode($cus_card);
	foreach($rowCardCategory as $row_card_cat)
	{
		$cardcategoryID = $row_card_cat['id'];
	}


	$validity = "";
	$subscription = 0;
	$discount_conv = 0;
	$discount_offer = 0;
	$discount_nego = 0;
	$nego_remark = "";
	$cashback_amt = 0;
	$prm_amount = 0;
	$amount = 0;
	$due_amount = 0;
	$service_tax = 0;
	$cgstRateID = 0;
	$cgstAmt = "";
	$sgstRateId = 0;
	$sgstAmt = "";

	$total_amount = 0;

	$branch_code = "";
	$fresh_renewal ="";
	$payment_from = "";
	$bill_no = "";
	$bill_dt = "";
	$payment_mode = "0";
	$chq_no = "";
	$chq_dt = "" ;
	$bank_name = "";
	$branch_name = "";
	$collection_at = "";
	$voucher_master_id = 0;
	$isGST = "";

	foreach($rowMemberPayment as $row_payment)
	{
		$payment_id = $row_payment['PAYMENT_ID'];
		$from_dt = $row_payment['FROM_DT'];
		$valid_upto = $row_payment['VALID_UPTO'];
		$validity = $row_payment['VALIDITY_STRING'];
		$subscription = $row_payment['SUBSCRIPTION'];
		$discount_conv = $row_payment['DISCOUNT_CONV'];
		$discount_offer = $row_payment['DISCOUNT_OFFER'];
		$discount_nego = $row_payment['DISCOUNT_NEGO'];
		$nego_remark = $row_payment['NEGO_REMARK'];
		$cashback_amt = $row_payment['CASHBACK_AMT'];
		$prm_amount = $row_payment['PRM_AMOUNT'];
		$amount = $row_payment['AMOUNT'];
		$due_amount = $row_payment['DUE_AMOUNT'];
		$service_tax = $row_payment['SERVICE_TAX'];
		$cgstRateID = $row_payment['CGST_RATE_ID'];
		$cgstAmt = $row_payment['CGST_AMT'];
		$sgstRateId = $row_payment['SGST_RATE_ID'];
		$sgstAmt = $row_payment['SGST_AMT'];
		$total_amount = $row_payment['TOTAL_AMOUNT'];
		$payment_dt = $row_payment['PAYMENT_DT'];
		$branch_code = $row_payment['BRANCH_CODE'];
		$fresh_renewal = $row_payment['FRESH_RENEWAL'];
		$payment_from = $row_payment['payment_from'];
		$bill_no = $row_payment['BILL_NO'];
		$bill_dt = $row_payment['BILL_DT'];
		$payment_mode = $row_payment['PAYMENT_MODE'];
		$chq_no = $row_payment['CHQ_NO'];
		$chq_dt = $row_payment['CHQ_DT'];
		$bank_name = $row_payment['BANK_NAME'];
		$branch_name = $row_payment['BRANCH_NAME'];
		$cust_id = $row_payment['CUST_ID'];
		$collection_at = $row_payment['collection_at'];
		$voucher_master_id = $row_payment['voucher_master_id'];
		$isGST = $row_payment['IS_GST'];
	}



	$chqDt = "";
	if($chq_dt=="")
	{
		$chqDt = "";
	}
	else
	{
		$chqDt = date("d-m-Y",strtotime($chq_dt));
	}

	$editType = getTypeOfEdit($payment_from);

	 $sizeOF = sizeof($rowDueData);


		if(sizeof($rowDueData)>0)
		{


			if($sizeOF==2)
			{
				$frst_instl_dt =  date('d-m-Y',strtotime($rowDueData[0]['due_pybl_date']));
				$frst_instl_amt = $rowDueData[0]['due_pybl_amt'];
				$frst_instl_chqno = $rowDueData[0]['pybl_cheque_no'];
				$frst_instl_bank = $rowDueData[0]['pybl_bank'];
				$frst_instl_branch = $rowDueData[0]['pybl_branch'];

				$secnd_instl_dt = date('d-m-Y',strtotime($rowDueData[1]['due_pybl_date']));
				$secnd_instl_amt = $rowDueData[1]['due_pybl_amt'];
				$secnd_instl_chqno = $rowDueData[1]['pybl_cheque_no'];
				$secnd_instl_bank = $rowDueData[1]['pybl_bank'];
				$secnd_instl_branch = $rowDueData[1]['pybl_branch'];
			}
			if($sizeOF==1)
			{
				$frst_instl_dt =  date('d-m-Y',strtotime($rowDueData[0]['due_pybl_date']));
				$frst_instl_amt = $rowDueData[0]['due_pybl_amt'];
				$frst_instl_chqno = $rowDueData[0]['pybl_cheque_no'];
				$frst_instl_bank = $rowDueData[0]['pybl_bank'];
				$frst_instl_branch = $rowDueData[0]['pybl_branch'];

				$secnd_instl_dt = "";
				$secnd_instl_amt = 0;
				$secnd_instl_chqno = "";
				$secnd_instl_bank = "";
				$secnd_instl_branch = "";
			}
		}
		else
		{
			$frst_instl_dt =  "";
			$frst_instl_amt = 0;
			$frst_instl_chqno = "";
			$frst_instl_bank = "";
			$frst_instl_branch = "";

			$secnd_instl_dt = "";
			$secnd_instl_amt = 0;
			$secnd_instl_chqno = "";
			$secnd_instl_bank = "";
			$secnd_instl_branch = "";
		}

		$isEditable="";
		$readonly = "";
		$class = "";

		$checkduePayable = $disp_mem_cls->isDuePaid($mno,$validity,$pid);
		if($checkduePayable>0)
		{
			$isEditable="N";
		}
		else
		{
			$isEditable="Y";
		}
		if($isEditable=="Y")
		{
			$class="";
			$readonly = "";
		}
		else
		{
			$class="disbale-field";
			$readonly="readonly";
		}

		if($isGST=="Y")
		{
			$servTaxPaymntTab = "display:none";
			$GSTpaymtTab = "display:block";
		}
		else
		{
			$servTaxPaymntTab = "display:block";
			$GSTpaymtTab = "display:none";
		}






?>

<div role="tabpanel">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">

        <li role="presentation" class="active">
			<a href="#personalInfo" aria-controls="personalInfo" role="tab" data-toggle="tab"><img src="images/edit.png" width="20" height="20"/> Personal Info</a>
		</li>
        <li role="presentation" style="<?php echo $servTaxPaymntTab;?>">
			<a href="#paymentInfo" aria-controls="browseTab" role="tab" data-toggle="tab"><img src="images/edit.png" width="20" height="20"/> Payment Info Serv. Tax</a>
		</li>
		<li role="presentation" style="<?php echo $GSTpaymtTab;?>">
			<a href="#paymentInfoGST" aria-controls="browseTab" role="tab" data-toggle="tab"><img src="images/edit.png" width="20" height="20"/> Payment Info GST</a>
		</li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">

        <div role="tabpanel" class="tab-pane active" id="personalInfo">
		<h3 class="edit-title"><?php echo "Personal Info";?> - Edit</h3>
			<div class="tab-detail">
				<table class="mem-info-table" cellspacing="6">
					<tr>
						<td>Membership No</td>
						<td style="font-weight:700;"><?php echo $mno; ?></td>
						<td>Validity</td>
						<td style="font-weight:700;"><?php echo $validity; ?></td>
					</tr>
					<tr>
						<td>Name</td>
						<td><input type="text" name="m-name" id="m-name" class="mem-info-inpt" value="<?php echo $name; ?>" /></td>
						<td>DOB</td>
						<td><input type="text" name="m-dob" id="m-dob" class="mem-info-inpt" value="<?php echo date("d-m-Y",strtotime($dob)); ?>" /></td>
					</tr>
					<tr>
						<td>Gender</td>
						<td>

							<select name="m-gender" id="m-gender" class="mem-info-inpt" style="width:92%;height:26px;">
								<option value="M" <?php if($gender=="M"){echo "selected";}else{echo "";}?>>Male</option>
								<option value="F" <?php if($gender=="F"){echo "selected";}else{echo "";}?>>Female</option>
							</select>
							</td>
						<td>Marital Status</td>
						<td>

							<select name="m-marital" id="m-marital" class="mem-info-inpt" style="width:92%;height:26px;">
								<option value="M" <?php if($marital_status=="M"){echo "selected";}else{echo "";}?>>Married</option>
								<option value="S" <?php if($marital_status=="S"){echo "selected";}else{echo "";}?>>Single</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>Father</td>
						<td><input type="text" name="m-father" id="m-father" class="mem-info-inpt" value="<?php echo $father; ?>" /></td>
						<td>Phone</td>
						<td><input type="text" name="m-phone" id="m-phone" class="mem-info-inpt" value="<?php echo $phone; ?>" readonly /></td>
					</tr>
					<tr>
						<td>Email</td>
						<td><input type="text" name="m-email" id="m-email" class="mem-info-inpt" value="<?php echo $email; ?>" /></td>
						<td>WhatsApp No.</td>
						<td><input type="text" name="whatsupNum" id="whatsupNum" maxlength="10" class="mem-info-inpt" value="<?php echo $whatsup_num; ?>" /></td>
					</tr>
					<tr>
						<td>Occupation</td>
						<td><input type="text" name="m-occupation" id="m-occupation" class="mem-info-inpt" value="<?php echo $occupation; ?>" /></td>

						<td>Blood Group</td>
						<td>

							<select name="m-bldgrp" id="m-bldgrp" class="mem-info-inpt" style="width:92%;height:26px;">
							<option value="0">Select</option>
							<?php
								foreach($rowBloodGroup as $blood_grp)
								{ ?>
								<option value="<?php echo $blood_grp['bld_group_code'];?>" <?php if($bloodGrp==$blood_grp['bld_group_code']){
							echo "selected";}else{echo "";}?>><?php echo $blood_grp['bld_group_code'];?></option>
							<?php
								}
							?>
							</select>
							</td>
					  </tr>
					<tr>
						<td>Trainer</td>
						<td>

							<select name="m-trainer" id="m-trainer" class="mem-info-inpt" style="width:92%;height:26px;">
							<option value="0">Select</option>
							<?php
								foreach($rowTrainer as $row_trainer)
								{ ?>
								<option value="<?php echo $row_trainer['empl_id']; ?>" <?php if($trainer==$row_trainer['empl_id']){echo "selected";}else{echo "";}?>>
									<?php echo $row_trainer['empl_name']." [".$row_trainer['branch_cd']."]"; ?>
								</option>
							<?php
								}
							?>
							</select>
						</td>


						<td>Pin</td>
						<td><input type="text" name="m-pin" id="m-pin" class="mem-info-inpt" value="<?php echo $pin; ?>" /></td>
					</tr>

					<tr>
						<td>Address</td>
						<td>
							<textarea name="m-address" id="m-address" class="mem-info-inpt" style="height:50px;resize:none;"><?php echo $address; ?></textarea>

							<input type="hidden" id="cid" name="cid" value="<?php echo $cid; ?>"/>
						</td>
					</tr>

					<tr>
						<td colspan="4" align="center">
							<button type="button" class="btn btn-danger" style="width: 26%;" id="updatePersonalInfo">Update</button>
						</td>
					</tr>
					<tr>

						<td colspan="4" align="center">
							<p id="personal-upd" style="font-size:18px;color:#18B64C;display:none;">
								<img src="images/successfully_icon.png" style="vertical-align:middle;width:8%;"/> Personal Info updated successfully.
							</p>
						</td>
					</tr>

				</table>
			</div>


		</div><!-- Personal Info End-->





		<!-- Service Tax payment Info-->
        <div role="tabpanel" class="tab-pane" id="paymentInfo">
			<h3 class="edit-title"><?php echo $editType;?> - Edit</h3>
			<div class="tab-detail">
				<table class="mem-info-table" cellspacing="6" style="width:75%;">
					<tr>
						<td>Membership No<input type="hidden" name="isedt" id="isedt" value="<?php echo $isEditable ; ?>" /></td>
						<td style="font-weight:700;"><?php echo $mno; ?></td>
					</tr>
					<tr>
						<td>Validity</td>
						<td style="font-weight:700;"><?php echo $validity; ?></td>
					</tr>
					<tr>
						<td class="txt_header">Reg. Date</td>
						<td>
						<input type="text" name="reg-date" id="reg-date" class="mem-info-inpt" value="<?php echo date('d-m-Y',strtotime($reg_date)); ?>" readonly />
						</td>
					</tr>
					<tr>
						<td class="txt_header">Payment Date</td>
						<td><input type="text" name="payment-dt" id="payment-dt" class="mem-info-inpt datepicker" value="<?php echo date('d-m-Y',strtotime($payment_dt)); ?>" style="width:89%;height:17px;"/></td>
					</tr>
					<tr>
						<td class="txt_header">Business Branch</td>
						<td>

							<select name="bs-branch" id="bs-branch" class="mem-info-inpt" style="width:92%;height:26px;" disabled>
								<?php foreach($rowBranch as $row_brn){?>
								<option value="<?php echo $row_brn['BRANCH_CODE'];?>" <?php if($branch_code==$row_brn['BRANCH_CODE']){echo "selected";}else{echo "";}?>>
									<?php echo $row_brn['BRANCH_NAME']; ?>
								</option>
								<?php }?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="txt_header">Category</td>
						<td>

							<select name="pck-category" id="pck-category" class="mem-info-inpt" style="width:92%;height:26px;" disabled>
								<?php
									foreach($rowCategory as $row_cat){ ?>

								<option value="<?php echo $row_cat['id'];?>" <?php if($cardcategoryID==$row_cat['id']){echo "selected";}else{echo "";}?>>
									<?php echo $row_cat['category_name'];?>
								</option>

								<?php
									}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="txt_header">Package</td>
						<td>
							<select name="pckage" id="pckage" class="mem-info-inpt" style="width:92%;height:26px;" disabled>
								<?php
								foreach($rowCard as $row_card){ ?>
									<option value="<?php echo $row_card['CARD_CODE'];?>" <?php if($cus_card==$row_card['CARD_CODE']){echo "selected";}else{echo "";}?>>
										<?php echo $row_card['CARD_DESC'];?>
									</option>
								<?php
									}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="txt_header">Collection Branch</td>
						<td>
							<select name="col-branch" id="col-branch" class="mem-info-inpt" style="width:92%;height:26px;">
								<?php foreach($rowBranch as $col_brn){?>
								<option value="<?php echo $col_brn['BRANCH_CODE'];?>" <?php if($collection_at==$col_brn['BRANCH_CODE']){echo "selected";}else{echo "";}?>>
									<?php echo $col_brn['BRANCH_NAME']; ?>
								</option>
								<?php }?>
							</select>
						</td>
					</tr>
					<!--
					<tr>
						<td class="txt_header">Complimentary</td>
						<td>
							<?php if($is_compl=="Y"){?>
								<input type="checkbox" name="iscompli" id="iscompli" checked />
							<?php }else{ ?>
								<input type="checkbox" name="iscompli" id="iscompli" />
							<?php } ?>
						</td>
					</tr> -->
					<tr>
						<td class="txt_header">Package rate</td>
						<td>
							<input type="text" name="txt_subscription" id="txt_subscription" class="mem-info-inpt disbale-field" value="<?php echo $subscription; ?>" readonly />
						</td>
					</tr>
					<tr>
						<td class="txt_header">Cash Back </td>
						<td style="font-weight:700;">
							<?php echo $cashback_amt; ?>
							<input type="hidden" name="txt_cashbck" id="txt_cashbck" class="mem-info-inpt" value="<?php echo $cashback_amt; ?>" readonly />
						</td>
					</tr>
					<tr>
						<td class="txt_header">Discount On Conversion</td>
						<td>
							<input type="text" name="txt_disc_conv" id="txt_disc_conv" class="mem-info-inpt disbale-field" value="<?php echo $discount_conv; ?>" readonly />
						</td>
					</tr>
					<tr>
						<td class="txt_header">Discount On Offer</td>
						<td>
							<input type="text" name="txt_disc_offer" id="txt_disc_offer" class="mem-info-inpt disbale-field" value="<?php echo $discount_offer; ?>"  readonly />
						</td>

					</tr>
					<tr>
						<td class="txt_header">Discount On Negotiation</td>
						<td>
							<input type="text" name="txt_disc_nego" id="txt_disc_nego" class="mem-info-inpt disbale-field" value="<?php echo $discount_nego; ?>" readonly />
							<input type="hidden" id="pid" name="pid" value="<?php echo $pid; ?>"/>
							<input type="hidden" id="cid" name="pid" value="<?php echo $cid; ?>"/>
							<input type="hidden" id="vmid" name="vmid" value="<?php echo $voucher_master_id; ?>"/>
						</td>
					</tr>
					<tr>
						<td class="txt_header">Remarks for Negotiation</td>
						<td>
							<textarea name="remarks-nego" id="remarks-nego" style="border: 1px solid #f8723f;resize: none;width: 90%;border-radius: 5px;"><?php echo trim($nego_remark) ; ?></textarea>
						</td>

					</tr>

					<tr>
						<td class="txt_header">Premium</td>
						<td>
							<input type="text" name="txt_premium" id="txt_premium" class="mem-info-inpt disbale-field" value="<?php echo $prm_amount ; ?>" readonly />
						</td>
					</tr>
					<tr>
						<td class="txt_header">Payment Now</td>
						<td>
							<input type="text" name="txt_payment_now" id="txt_payment_now" class="mem-info-inpt <?php echo $class;?>" value="<?php echo $amount ; ?>"  <?php echo $readonly ; ?> onkeyup="return getDue();" />
						</td>
					</tr>

					<tr>
						<td class="txt_header">Due</td>
						<td>
							<input type="text" name="txt_due" id="txt_due" class="mem-info-inpt disbale-field" value="<?php echo $due_amount ; ?>" readonly />
						</td>
					</tr>

					<tr>
						<td class="txt_header">Tax</td>
						<td>
							<input type="text" name="txt_tax" id="txt_tax" class="mem-info-inpt disbale-field" value="<?php echo $service_tax; ?>" />
						</td>
					</tr>
					<tr>
						<td class="txt_header">Payable</td>
						<td>
							<input type="text" name="txt_payable" id="txt_payable" class="mem-info-inpt disbale-field" value="<?php echo $total_amount; ?>" readonly />
						</td>
					</tr>

					<tr>
						<td class="txt_header">1st Inst. Dt</td>
						<td>
							<input type="text" name="frst-inst-dt" id="frst-inst-dt" class="mem-info-inpt datepicker <?php echo $class;?>" value="<?php echo $frst_instl_dt ; ?>" style="width:88.5%;height:17px;"/>
						</td>
					</tr>

					<tr>
						<td class="txt_header">1st Installment</td>
						<td>
							<input type="text" name="txt_inst1_amt" id="txt_inst1_amt" class="mem-info-inpt  <?php echo $class;?>" value="<?php echo $frst_instl_amt  ; ?>" readonly />
						</td>
					</tr>
					<tr>
						<td class="txt_header">1st Cheque No</td>
						<td>
							<input type="text" name="frst-chq-no" id="frst-chq-no" class="mem-info-inpt <?php echo $class;?>" value="<?php echo $frst_instl_chqno  ; ?>" />
						</td>
					</tr>

					<tr>
						<td class="txt_header">1st Bank</td>
						<td>
							<input type="text" name="frst-bank" id="frst-bank" class="mem-info-inpt <?php echo $class;?>" value="<?php echo $frst_instl_bank  ; ?>" />
						</td>
					</tr>
					<tr>
						<td class="txt_header">1st Branch</td>
						<td>
							<input type="text" name="frst-brn" id="frst-brn" class="mem-info-inpt <?php echo $class;?>" value="<?php echo $frst_instl_branch ; ?>" />
						</td>
					</tr>

					<tr>
						<td class="txt_header">2nd Inst. Dt</td>
						<td>
							<input type="text" name="second-instl-dt" id="second-instl-dt" class="mem-info-inpt datepicker <?php echo $class;?>" value="<?php echo $secnd_instl_dt ; ?>" style="width:88.5%;height:17px;" />
						</td>
					</tr>

					<tr>
						<td class="txt_header">2nd Installment</td>
						<td>
							<input type="text" name="txt_inst2_amt" id="txt_inst2_amt" class="mem-info-inpt <?php echo $class;?>" value="<?php echo $secnd_instl_amt ; ?>" readonly />
						</td>
					</tr>
					<tr>
						<td class="txt_header">2nd Cheque No</td>
						<td>
							<input type="text" name="second-chq-no" id="second-chq-no" class="mem-info-inpt <?php echo $class;?>" value="<?php echo $secnd_instl_chqno ; ?>" />
						</td>
					</tr>

					<tr>
						<td class="txt_header">2nd Bank</td>
						<td>
							<input type="text" name="second-bnk" id="second-bnk" class="mem-info-inpt <?php echo $class;?>" value="<?php echo $secnd_instl_bank ; ?>" />
						</td>
					</tr>
					<tr>
						<td class="txt_header">2nd Branch</td>
						<td>
							<input type="text" name="second-brn" id="second-brn" class="mem-info-inpt <?php echo $class;?>" value="<?php echo $secnd_instl_branch ; ?>" />
						</td>
					</tr>


					<tr>
						<td class="txt_header">Payment Mode</td>
						<td>
							<select name="payment-mode" id="payment-mode" class="mem-info-inpt" style="width:92%;height:26px;">
								<option value="Cash" <?php if($payment_mode=="Cash"){echo "selected";}else{echo "";}?>>Cash</option>
								<option value="Cheque" <?php if($payment_mode=="Cheque"){echo "selected";}else{echo "";}?>>Cheque</option>
								<option value="Card" <?php if($payment_mode=="Card"){echo "selected";}else{echo "";}?>>Card</option>
								<option value="Fund Transfer" <?php if($payment_mode=="Fund Transfer"){echo "selected";}else{echo "";}?>>Fund Transfer</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="txt_header">Cheque No</td>
						<td>
							<input type="hidden" name="hd-chq-num" id="hd-chq-num" class="mem-info-inpt" value="<?php echo $chq_no; ?>" />
							<input type="text" name="chq-num" id="chq-num" class="mem-info-inpt" value="<?php echo $chq_no; ?>" />
						</td>
					</tr>
					<tr>
						<td class="txt_header">Cheque Date</td>
						<td>

							<input type="hidden" name="hd-chq-date" id="hd-chq-date" class="mem-info-inpt" value="<?php echo $chqDt; ?>" />
							<input type="text" name="chq-date" id="chq-date" class="mem-info-inpt datepicker" value="<?php echo $chqDt; ?>" style="width:88.5%;height:17px;" />
						</td>
					</tr>
					<tr>
						<td class="txt_header">Bank</td>
						<td>
							<input type="hidden" name="hd-bank-name" id="hd-bank-name" class="mem-info-inpt" value="<?php echo $bank_name ;?>" />
							<input type="text" name="bank-name" id="bank-name" class="mem-info-inpt" value="<?php echo $bank_name ;?>" />
						</td>
					</tr>
					<tr>
						<td class="txt_header">Branch</td>
						<td>
							<input type="hidden" name="hd-bank-branch" id="hd-bank-branch" class="mem-info-inpt" value="<?php echo $branch_name ;?>" />
							<input type="text" name="bank-branch" id="bank-branch" class="mem-info-inpt" value="<?php echo $branch_name ;?>" />
						</td>
					</tr>
					<tr>
						<td class="txt_header">Done By</td>
						<td>
							<select name="done-by" id="done-by" class="mem-info-inpt" style="width:92%;height:26px;">
								<?php foreach($rowUser as $row_user){?>
									<option value="<?php echo $row_user['user_id'];?>" <?php if($done_by==$row_user['user_id']){echo "selected";}else{echo "";}?>>
										<?php echo $row_user['name_in_full'];?>
									</option>
								<?php } ?>
							</select>
						</td>
					</tr>



					<tr>
						<td colspan="4" align="center">
							<button type="button" class="btn btn-danger" style="width: 26%;" id="updatePaymentInfo">Update</button>
						</td>
					</tr>
					<tr>

						<td colspan="4" align="center">
							<p id="payment-upd" style="font-size:18px;color:#18B64C;display:none;">
								<img src="images/successfully_icon.png" style="vertical-align:middle;width:8%;"/> Payment Info updated successfully.
							</p>
						</td>
					</tr>

				</table>
			</div>
		</div><!-- Payment Info End of Service Tax--->

<?php /* "**************************************************************************************************************";*/ ?>

		<!-- Payment Info GST ----->

		 <div role="tabpanel" class="tab-pane" id="paymentInfoGST">
			<h3 class="edit-title"><?php echo $editType;?> - Edit</h3>
			<div class="tab-detail">
				<table class="mem-info-table" cellspacing="6" style="width:75%;">
					<tr>
						<td>Membership No<input type="hidden" name="isedtGST" id="isedtGST" value="<?php echo $isEditable ; ?>" /></td>
						<td style="font-weight:700;"><?php echo $mno; ?></td>
					</tr>
					<tr>
						<td>Validity</td>
						<td style="font-weight:700;"><?php echo $validity; ?></td>
					</tr>
					<tr>
						<td class="txt_header">Reg. Date</td>
						<td>
						<input type="text" name="reg-date-GST" id="reg-date-GST" class="mem-info-inpt" value="<?php echo date('d-m-Y',strtotime($reg_date)); ?>" readonly />
						</td>
					</tr>
					<tr>
						<td class="txt_header">Payment Date</td>
						<td><input type="text" name="payment-dt-GST" id="payment-dt-GST" class="mem-info-inpt datepicker" value="<?php echo date('d-m-Y',strtotime($payment_dt)); ?>" style="width:89%;height:17px;"/></td>
					</tr>
					<tr>
						<td class="txt_header">Business Branch</td>
						<td>

							<select name="bs-branch-GST" id="bs-branch-GST" class="mem-info-inpt" style="width:92%;height:26px;" disabled>
								<?php foreach($rowBranch as $row_brn){?>
								<option value="<?php echo $row_brn['BRANCH_CODE'];?>" <?php if($branch_code==$row_brn['BRANCH_CODE']){echo "selected";}else{echo "";}?>>
									<?php echo $row_brn['BRANCH_NAME']; ?>
								</option>
								<?php }?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="txt_header">Category</td>
						<td>

							<select name="pck-category-GST" id="pck-category-GST" class="mem-info-inpt" style="width:92%;height:26px;" disabled>
								<?php
									foreach($rowCategory as $row_cat){ ?>

								<option value="<?php echo $row_cat['id'];?>" <?php if($cardcategoryID==$row_cat['id']){echo "selected";}else{echo "";}?>>
									<?php echo $row_cat['category_name'];?>
								</option>

								<?php
									}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="txt_header">Package</td>
						<td>
							<select name="pckage-GST" id="pckage-GST" class="mem-info-inpt" style="width:92%;height:26px;" disabled>
								<?php
								foreach($rowCard as $row_card){ ?>
									<option value="<?php echo $row_card['CARD_CODE'];?>" <?php if($cus_card==$row_card['CARD_CODE']){echo "selected";}else{echo "";}?>>
										<?php echo $row_card['CARD_DESC'];?>
									</option>
								<?php
									}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="txt_header">Collection Branch</td>
						<td>
							<select name="col-branch-GST" id="col-branch-GST" class="mem-info-inpt" style="width:92%;height:26px;">
								<?php foreach($rowBranch as $col_brn){?>
								<option value="<?php echo $col_brn['BRANCH_CODE'];?>" <?php if($collection_at==$col_brn['BRANCH_CODE']){echo "selected";}else{echo "";}?>>
									<?php echo $col_brn['BRANCH_NAME']; ?>
								</option>
								<?php }?>
							</select>
						</td>
					</tr>
					<!--
					<tr>
						<td class="txt_header">Complimentary</td>
						<td>
							<?php if($is_compl=="Y"){?>
								<input type="checkbox" name="iscompli" id="iscompli" checked />
							<?php }else{ ?>
								<input type="checkbox" name="iscompli" id="iscompli" />
							<?php } ?>
						</td>
					</tr> -->
					<tr>
						<td class="txt_header">Package rate</td>
						<td>
							<input type="text" name="txt_subscription_GST" id="txt_subscription_GST" class="mem-info-inpt disbale-field" value="<?php echo $subscription; ?>" readonly />
						</td>
					</tr>
					<tr>
						<td class="txt_header">Cash Back </td>
						<td style="font-weight:700;">
							<?php echo $cashback_amt; ?>
							<input type="hidden" name="txt_cashbck_GST" id="txt_cashbck_GST" class="mem-info-inpt" value="<?php echo $cashback_amt; ?>" readonly />
						</td>
					</tr>
					<tr>
						<td class="txt_header">Discount On Conversion</td>
						<td>
							<input type="text" name="txt_disc_conv_GST" id="txt_disc_conv_GST" class="mem-info-inpt disbale-field" value="<?php echo $discount_conv; ?>" readonly />
						</td>
					</tr>
					<tr>
						<td class="txt_header">Discount On Offer</td>
						<td>
							<input type="text" name="txt_disc_offer_GST" id="txt_disc_offer_GST" class="mem-info-inpt disbale-field" value="<?php echo $discount_offer; ?>"  readonly />
						</td>

					</tr>
					<tr>
						<td class="txt_header">Discount On Negotiation</td>
						<td>
							<input type="text" name="txt_disc_nego_GST" id="txt_disc_nego_GST" class="mem-info-inpt disbale-field" value="<?php echo $discount_nego; ?>" readonly />
							<input type="hidden" id="pid_GST" name="pid_GST" value="<?php echo $pid; ?>"/>
							<input type="hidden" id="cid_GST" name="cid_GST" value="<?php echo $cid; ?>"/>
							<input type="hidden" id="vmid_GST" name="vmid_GST" value="<?php echo $voucher_master_id; ?>"/>
						</td>
					</tr>
					<tr>
						<td class="txt_header">Remarks for Negotiation</td>
						<td>
							<textarea name="remarks-nego-GST" id="remarks-nego-GST" style="border: 1px solid #f8723f;resize: none;width: 90%;border-radius: 5px;"><?php echo trim($nego_remark) ; ?></textarea>
						</td>

					</tr>

					<tr>
						<td class="txt_header">Premium</td>
						<td>
							<input type="text" name="txt_premium_GST" id="txt_premium_GST" class="mem-info-inpt disbale-field" value="<?php echo $prm_amount ; ?>" readonly />
						</td>
					</tr>
					<tr>
						<td class="txt_header">Payment Now</td>
						<td>
							<input type="text" name="txt_payment_now_GST" id="txt_payment_now_GST" class="mem-info-inpt <?php echo $class;?>" value="<?php echo $amount ; ?>"  <?php echo $readonly ; ?> onkeyup="return getDueGST();" />
						</td>
					</tr>

					<tr>
						<td class="txt_header">Due</td>
						<td>
							<input type="text" name="txt_due_GST" id="txt_due_GST" class="mem-info-inpt disbale-field" value="<?php echo $due_amount ; ?>" readonly />
						</td>
					</tr>
					<!--
					<tr>
						<td class="txt_header">Tax</td>
						<td>
							<input type="text" name="txt_tax" id="txt_tax" class="mem-info-inpt disbale-field" value="<?php echo $service_tax; ?>" />
						</td>
					</tr>-->


					<tr>
						<td width="135">CGST </td>
						<td>
							<select name="cgstrate" id="cgstrate" class="mem-info-inpt" style="width:108px;" onchange="return getTotalGST();">


								<?php foreach($rowGetCGSTRate as $row_cgst){?>
								<option value="<?php echo $row_cgst['id'];?>" <?php if($cgstRateID==$row_cgst['id']){echo "selected";}else{echo "";}?>><?php echo $row_cgst['rate']; ?></option>
								<?php } ?>


							</select>%
							 &nbsp; &nbsp; &nbsp;
							<span>CGST Amount &nbsp;</span>
							<input name="cgstAmount" id="cgstAmount" type="text" class="mem-info-inpt" style="width: 123px;" onkeypress="return isNumberKey(event)" autocomplete="off" value="<?php echo $cgstAmt; ?>" readonly ></span>
						</td>
					</tr>

					<tr>
						<td width="135">SGST </td>
						<td>
							<select name="sgstrate" id="sgstrate" class="mem-info-inpt" style="width:108px;" onchange="return getTotalGST();">

								<?php foreach($rowGetSGSTRate  as $row_sgst){?>
								<option value="<?php echo $row_sgst['id'];?>" <?php if($sgstRateId==$row_sgst['id']){echo "selected";}else{echo "";} ?>><?php echo $row_sgst['rate']; ?></option>
								<?php } ?>
							</select>%
							 &nbsp; &nbsp; &nbsp;
							<span>SGST Amount &nbsp;</span>
							<input name="sgstAmount" id="sgstAmount" type="text" class="mem-info-inpt" style="width: 123px;" onkeypress="return isNumberKey(event)" autocomplete="off" value="<?php echo $sgstAmt; ?>" readonly ></span>
						</td>
					</tr>


					<tr>
						<td class="txt_header">Payable</td>
						<td>
							<input type="text" name="txt_payable_GST" id="txt_payable_GST" class="mem-info-inpt disbale-field" value="<?php echo $total_amount; ?>" readonly />
						</td>
					</tr>

					<tr>
						<td class="txt_header">1st Inst. Dt</td>
						<td>
							<input type="text" name="frst-inst-dt-gst" id="frst-inst-dt-gst" class="mem-info-inpt datepicker <?php echo $class;?>" value="<?php echo $frst_instl_dt ; ?>" style="width:88.5%;height:17px;"/>
						</td>
					</tr>

					<tr>
						<td class="txt_header">1st Installment</td>
						<td>
							<input type="text" name="txt_inst1_amt_gst" id="txt_inst1_amt_gst" class="mem-info-inpt  <?php echo $class;?>" value="<?php echo $frst_instl_amt  ; ?>" readonly />
						</td>
					</tr>
					<tr>
						<td class="txt_header">1st Cheque No</td>
						<td>
							<input type="text" name="frst-chq-no-gst" id="frst-chq-no-gst" class="mem-info-inpt <?php echo $class;?>" value="<?php echo $frst_instl_chqno  ; ?>" />
						</td>
					</tr>

					<tr>
						<td class="txt_header">1st Bank</td>
						<td>
							<input type="text" name="frst-bank-gst" id="frst-bank-gst" class="mem-info-inpt <?php echo $class;?>" value="<?php echo $frst_instl_bank  ; ?>" />
						</td>
					</tr>
					<tr>
						<td class="txt_header">1st Branch</td>
						<td>
							<input type="text" name="frst-brn-gst" id="frst-brn-gst" class="mem-info-inpt <?php echo $class;?>" value="<?php echo $frst_instl_branch ; ?>" />
						</td>
					</tr>

					<tr>
						<td class="txt_header">2nd Inst. Dt</td>
						<td>
							<input type="text" name="second-instl-dt-gst" id="second-instl-dt-gst" class="mem-info-inpt datepicker <?php echo $class;?>" value="<?php echo $secnd_instl_dt ; ?>" style="width:88.5%;height:17px;" />
						</td>
					</tr>

					<tr>
						<td class="txt_header">2nd Installment</td>
						<td>
							<input type="text" name="txt_inst2_amt_gst" id="txt_inst2_amt_gst" class="mem-info-inpt <?php echo $class;?>" value="<?php echo $secnd_instl_amt ; ?>" readonly />
						</td>
					</tr>
					<tr>
						<td class="txt_header">2nd Cheque No</td>
						<td>
							<input type="text" name="second-chq-no-gst" id="second-chq-no-gst" class="mem-info-inpt <?php echo $class;?>" value="<?php echo $secnd_instl_chqno ; ?>" />
						</td>
					</tr>

					<tr>
						<td class="txt_header">2nd Bank</td>
						<td>
							<input type="text" name="second-bnk-gst" id="second-bnk-gst" class="mem-info-inpt <?php echo $class;?>" value="<?php echo $secnd_instl_bank ; ?>" />
						</td>
					</tr>
					<tr>
						<td class="txt_header">2nd Branch</td>
						<td>
							<input type="text" name="second-brn-gst" id="second-brn-gst" class="mem-info-inpt <?php echo $class;?>" value="<?php echo $secnd_instl_branch ; ?>" />
						</td>
					</tr>


					<tr>
						<td class="txt_header">Payment Mode</td>
						<td>
							<select name="payment-mode-gst" id="payment-mode-gst" class="mem-info-inpt" style="width:92%;height:26px;">
								<option value="Cash" <?php if($payment_mode=="Cash"){echo "selected";}else{echo "";}?>>Cash</option>
								<option value="Cheque" <?php if($payment_mode=="Cheque"){echo "selected";}else{echo "";}?>>Cheque</option>
								<option value="Card" <?php if($payment_mode=="Card"){echo "selected";}else{echo "";}?>>Card</option>
								<option value="Fund Transfer" <?php if($payment_mode=="Fund Transfer"){echo "selected";}else{echo "";}?>>Fund Transfer</option>
								<option value="ONP" <?php if($payment_mode=="ONP"){echo "selected";}else{echo "";}?>>ONP</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="txt_header">Cheque No</td>
						<td>
							<input type="hidden" name="hd-chq-num-gst" id="hd-chq-num-gst" class="mem-info-inpt" value="<?php echo $chq_no; ?>" />
							<input type="text" name="chq-num-gst" id="chq-num-gst" class="mem-info-inpt" value="<?php echo $chq_no; ?>" />
						</td>
					</tr>
					<tr>
						<td class="txt_header">Cheque Date</td>
						<td>

							<input type="hidden" name="hd-chq-date-gst" id="hd-chq-date-gst" class="mem-info-inpt" value="<?php echo $chqDt; ?>" />
							<input type="text" name="chq-date-gst" id="chq-date-gst" class="mem-info-inpt datepicker" value="<?php echo $chqDt; ?>" style="width:88.5%;height:17px;" />
						</td>
					</tr>
					<tr>
						<td class="txt_header">Bank</td>
						<td>
							<input type="hidden" name="hd-bank-name-gst" id="hd-bank-name-gst" class="mem-info-inpt" value="<?php echo $bank_name ;?>" />
							<input type="text" name="bank-name-gst" id="bank-name-gst" class="mem-info-inpt" value="<?php echo $bank_name ;?>" />
						</td>
					</tr>
					<tr>
						<td class="txt_header">Branch</td>
						<td>
							<input type="hidden" name="hd-bank-branch-gst" id="hd-bank-branch-gst" class="mem-info-inpt" value="<?php echo $branch_name ;?>" />
							<input type="text" name="bank-branch-gst" id="bank-branch-gst" class="mem-info-inpt" value="<?php echo $branch_name ;?>" />
						</td>
					</tr>
					<tr>
						<td class="txt_header">Done By</td>
						<td>
							<select name="done-by-gst" id="done-by-gst" class="mem-info-inpt" style="width:92%;height:26px;">
								<?php foreach($rowUser as $row_user){?>
									<option value="<?php echo $row_user['user_id'];?>" <?php if($done_by==$row_user['user_id']){echo "selected";}else{echo "";}?>>
										<?php echo $row_user['name_in_full'];?>
									</option>
								<?php } ?>
							</select>
						</td>
					</tr>



					<tr>
						<td colspan="4" align="center">
							<button type="button" class="btn btn-danger" style="width: 26%;" id="updatePaymentInfoGST">Update</button>
						</td>
					</tr>
					<tr>

						<td colspan="4" align="center">
							<p id="payment-upd-gst" style="font-size:18px;color:#18B64C;display:none;">
								<img src="images/successfully_icon.png" style="vertical-align:middle;width:8%;"/> Payment Info updated successfully.
							</p>
						</td>
					</tr>

				</table>
			</div>


		</div>





    </div>
</div>
<?php
	function getTypeOfEdit($paymentfrom)
	{
		$type= "";
		if($paymentfrom=="REG")
		{
			$type = "Registration";
		}
		elseif($paymentfrom=="REN")
		{
			$type="Renewal";
		}
		elseif($paymentfrom=="DUE")
		{
			$type="Due Payable";
		}
		elseif($paymentfrom=="compl")
		{
			$type="Complimentary";
		}
		elseif($paymentfrom=="CHL")
		{
			$type="Child Package";
		}
		elseif($paymentfrom=="EXC")
		{
			$type="Exchange Package";
		}
		elseif($paymentfrom=="CON")
		{
			$type="Conversion Package";
		}
		elseif($paymentfrom=="PRODSALE")
		{
			$type="Product Sale";
		}
		else
		{
			$type="";
		}
		return $type;
	}
?>
