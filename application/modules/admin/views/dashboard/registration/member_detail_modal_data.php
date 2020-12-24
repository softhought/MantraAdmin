<?php
	$this->load->model('registrationmodel','reg_model',TRUE);


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

	if($rowMemberInfo)
	{
		$reg_date = $rowMemberInfo->REGISTRATION_DT;
		$name = $rowMemberInfo->CUS_NAME;
		$cus_card = $rowMemberInfo->CUS_CARD;
		$dob = $rowMemberInfo->CUS_DOB;
		$gender = $rowMemberInfo->CUS_SEX;
		$marital_status = $rowMemberInfo->CUS_MS;
		$phone = $rowMemberInfo->CUS_PHONE;
		$bloodGrp = $rowMemberInfo->CUS_BLOOD_GRP;
		$father = $rowMemberInfo->CUS_FATHER;
		$pin = $rowMemberInfo->CUS_PIN;
		$email = $rowMemberInfo->CUS_EMAIL;
		$occupation = $rowMemberInfo->CUS_OCCUPATION;
		$trainer = $rowMemberInfo->trainer_id;
		$address = $rowMemberInfo->CUS_ADRESS;
		$is_compl = $rowMemberInfo->IS_COMPLI;
		$done_by = $rowMemberInfo->done_by;
		$whatsup_num = $rowMemberInfo->whatsup_number;


	}



	$rowCardCategory = $this->reg_model->getCategoryByCode($cus_card,$company_id);
	if($rowCardCategory)
	{
		$cardcategoryID = $rowCardCategory->id;
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

	if($rowMemberPayment)
	{
		$payment_id = $rowMemberPayment->PAYMENT_ID;
		$from_dt = $rowMemberPayment->FROM_DT;
		$valid_upto = $rowMemberPayment->VALID_UPTO;
		$validity = $rowMemberPayment->VALIDITY_STRING;
		$subscription = $rowMemberPayment->SUBSCRIPTION;
		$discount_conv = $rowMemberPayment->DISCOUNT_CONV;
		$discount_offer = $rowMemberPayment->DISCOUNT_OFFER;
		$discount_nego = $rowMemberPayment->DISCOUNT_NEGO;
		$nego_remark = $rowMemberPayment->NEGO_REMARK;
		$cashback_amt = $rowMemberPayment->CASHBACK_AMT;
		$prm_amount = $rowMemberPayment->PRM_AMOUNT;
		$amount = $rowMemberPayment->AMOUNT;
		$due_amount = $rowMemberPayment->DUE_AMOUNT;
		$service_tax = $rowMemberPayment->SERVICE_TAX;
		$cgstRateID = $rowMemberPayment->CGST_RATE_ID;
		$cgstAmt = $rowMemberPayment->CGST_AMT;
		$sgstRateId = $rowMemberPayment->SGST_RATE_ID;
		$sgstAmt = $rowMemberPayment->SGST_AMT;
		$total_amount = $rowMemberPayment->TOTAL_AMOUNT;
		$payment_dt = $rowMemberPayment->PAYMENT_DT;
		$branch_code = $rowMemberPayment->BRANCH_CODE;
		$fresh_renewal = $rowMemberPayment->FRESH_RENEWAL;
		$payment_from = $rowMemberPayment->payment_from;
		$bill_no = $rowMemberPayment->BILL_NO;
		$bill_dt = $rowMemberPayment->BILL_DT;
		$payment_mode = $rowMemberPayment->PAYMENT_MODE;
		$chq_no = $rowMemberPayment->CHQ_NO;
		$chq_dt = $rowMemberPayment->CHQ_DT;
		$bank_name = $rowMemberPayment->BANK_NAME;
		$branch_name = $rowMemberPayment->BRANCH_NAME;
		$cust_id = $rowMemberPayment->CUST_ID;
		$collection_at = $rowMemberPayment->collection_at;
		$voucher_master_id = $rowMemberPayment->voucher_master_id;
		$isGST = $rowMemberPayment->IS_GST;
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

			if($sizeOF==5)
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

				$third_instl_dt = date('d-m-Y',strtotime($rowDueData[2]['due_pybl_date']));
				$third_instl_amt = $rowDueData[2]['due_pybl_amt'];
				$third_instl_chqno = $rowDueData[2]['pybl_cheque_no'];
				$third_instl_bank = $rowDueData[2]['pybl_bank'];
				$third_instl_branch = $rowDueData[2]['pybl_branch'];

				
				$fourth_instl_dt = date('d-m-Y',strtotime($rowDueData[3]['due_pybl_date']));
				$fourth_instl_amt = $rowDueData[3]['due_pybl_amt'];
				$fourth_instl_chqno = $rowDueData[3]['pybl_cheque_no'];
				$fourth_instl_bank = $rowDueData[3]['pybl_bank'];
				$fourth_instl_branch = $rowDueData[3]['pybl_branch'];

				$fifth_instl_dt = date('d-m-Y',strtotime($rowDueData[4]['due_pybl_date']));
				$fifth_instl_amt = $rowDueData[4]['due_pybl_amt'];
				$fifth_instl_chqno = $rowDueData[4]['pybl_cheque_no'];
				$fifth_instl_bank = $rowDueData[4]['pybl_bank'];
				$fifth_instl_branch = $rowDueData[4]['pybl_branch'];

				$fifth_instl_dt = date('d-m-Y',strtotime($rowDueData[5]['due_pybl_date']));
				$fifth_instl_amt = $rowDueData[5]['due_pybl_amt'];
				$fifth_instl_chqno = $rowDueData[5]['pybl_cheque_no'];
				$fifth_instl_bank = $rowDueData[5]['pybl_bank'];
				$fifth_instl_branch = $rowDueData[5]['pybl_branch'];
			}

			if($sizeOF==5)
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

				$third_instl_dt = date('d-m-Y',strtotime($rowDueData[2]['due_pybl_date']));
				$third_instl_amt = $rowDueData[2]['due_pybl_amt'];
				$third_instl_chqno = $rowDueData[2]['pybl_cheque_no'];
				$third_instl_bank = $rowDueData[2]['pybl_bank'];
				$third_instl_branch = $rowDueData[2]['pybl_branch'];

				
				$fourth_instl_dt = date('d-m-Y',strtotime($rowDueData[3]['due_pybl_date']));
				$fourth_instl_amt = $rowDueData[3]['due_pybl_amt'];
				$fourth_instl_chqno = $rowDueData[3]['pybl_cheque_no'];
				$fourth_instl_bank = $rowDueData[3]['pybl_bank'];
				$fourth_instl_branch = $rowDueData[3]['pybl_branch'];

				$fifth_instl_dt = date('d-m-Y',strtotime($rowDueData[4]['due_pybl_date']));
				$fifth_instl_amt = $rowDueData[4]['due_pybl_amt'];
				$fifth_instl_chqno = $rowDueData[4]['pybl_cheque_no'];
				$fifth_instl_bank = $rowDueData[4]['pybl_bank'];
				$fifth_instl_branch = $rowDueData[4]['pybl_branch'];
			}

			if($sizeOF==4)
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

				$third_instl_dt = date('d-m-Y',strtotime($rowDueData[2]['due_pybl_date']));
				$third_instl_amt = $rowDueData[2]['due_pybl_amt'];
				$third_instl_chqno = $rowDueData[2]['pybl_cheque_no'];
				$third_instl_bank = $rowDueData[2]['pybl_bank'];
				$third_instl_branch = $rowDueData[2]['pybl_branch'];

				
				$fourth_instl_dt = date('d-m-Y',strtotime($rowDueData[3]['due_pybl_date']));
				$fourth_instl_amt = $rowDueData[3]['due_pybl_amt'];
				$fourth_instl_chqno = $rowDueData[3]['pybl_cheque_no'];
				$fourth_instl_bank = $rowDueData[3]['pybl_bank'];
				$fourth_instl_branch = $rowDueData[3]['pybl_branch'];
			}

			if($sizeOF==3)
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

				$third_instl_dt = date('d-m-Y',strtotime($rowDueData[2]['due_pybl_date']));
				$third_instl_amt = $rowDueData[2]['due_pybl_amt'];
				$third_instl_chqno = $rowDueData[2]['pybl_cheque_no'];
				$third_instl_bank = $rowDueData[2]['pybl_bank'];
				$third_instl_branch = $rowDueData[2]['pybl_branch'];
			}


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

				$third_instl_dt = "";
				$third_instl_amt = 0;
				$third_instl_chqno = "";
				$third_instl_bank = "";
				$third_instl_branch = "";

				$fourth_instl_dt = "";
				$fourth_instl_amt = 0;
				$fourth_instl_chqno = "";
				$fourth_instl_bank = "";
				$fourth_instl_branch = "";

				$fifth_instl_dt = "";
				$fifth_instl_amt = 0;
				$fifth_instl_chqno = "";
				$fifth_instl_bank = "";
				$fifth_instl_branch = "";

				$sixth_instl_dt = "";
				$sixth_instl_amt = 0;
				$sixth_instl_chqno = "";
				$sixth_instl_bank = "";
				$sixth_instl_branch = "";
		}

		$isEditable="";
		$readonly = "";
		$class = "";

		$checkduePayable = $this->reg_model->isDuePaid($mno,$validity,$pid);
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

        <li role="presentation" id="personalInfoID" class="litab active actTab">
			<a href="#personalInfo" aria-controls="personalInfo" role="tab" data-toggle="tab"><i class="fas fa-edit"></i> Personal Info</a>
		</li>
        <li role="presentation" id="servTaxPaymntTabID" class="litab" style="<?php echo $servTaxPaymntTab;?>">
			<a href="#paymentInfo" aria-controls="browseTab" role="tab" data-toggle="tab">&nbsp;<i class="fas fa-edit"></i> Payment Info Serv. Tax</a>
		</li>
		<li role="presentation"  id="GSTpaymtTabID" class="litab" style="<?php echo $GSTpaymtTab;?>">
			<a href="#paymentInfoGST" aria-controls="browseTab" role="tab" data-toggle="tab">&nbsp;<i class="fas fa-edit"></i> Payment Info GST</a>
		</li>

		<li role="presentation"  id="medicalInfoTabID" class="litab" >
			<a href="#medicalInfo" aria-controls="browseTab" role="tab" data-toggle="tab">&nbsp;<i class="fas fa-edit"></i> Medical Information</a>
		</li>

		<li role="presentation"  id="generalmedicalInfoTabID" class="litab" >
			<a href="#generalmedicalInfo" aria-controls="browseTab" role="tab" data-toggle="tab">&nbsp;<i class="fas fa-edit"></i> General Medical Assestment</a>
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


					<?php

						$nameArr=explode(' ',$name, 2);
					
					?>
						<tr>
						<td>First Name</td>
						<td><input type="text" name="first_name" id="first_name" class="mem-info-inpt memName" value="<?php echo $nameArr[0]; ?>" /></td>
						<td>Last Name</td>
						<td><input type="text" name="last_name" id="last_name" class="mem-info-inpt memName" value="<?php echo $nameArr[1]; ?>" /></td>
					</tr>
					<tr>
						<td>Name</td>
						<td><input type="text" name="m-name" id="m-name" class="mem-info-inpt" value="<?php echo $name; ?>" readonly /></td>
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
								<option value="<?php echo $blood_grp->bld_group_code;?>" <?php if($bloodGrp==$blood_grp->bld_group_code){
							echo "selected";}else{echo "";}?>><?php echo $blood_grp->bld_group_code;?></option>
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
								<option value="<?php echo $row_trainer->empl_id; ?>" <?php if($trainer==$row_trainer->empl_id){echo "selected";}else{echo "";}?>>
									<?php echo $row_trainer->empl_name." [".$row_trainer->branch_cd."]"; ?>
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
								<i class="fa fa-check-circle" aria-hidden="true"></i> Personal Info updated successfully.
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
								<option value="<?php echo $row_brn->BRANCH_CODE;?>" <?php if($branch_code==$row_brn->BRANCH_CODE){echo "selected";}else{echo "";}?>>
									<?php echo $row_brn->BRANCH_NAME; ?>
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

								<option value="<?php echo $row_cat->id;?>" <?php if($cardcategoryID==$row_cat->id){echo "selected";}else{echo "";}?>>
									<?php echo $row_cat->category_name;?>
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
									<option value="<?php echo $row_card->CARD_CODE;?>" <?php if($cus_card==$row_card->CARD_CODE){echo "selected";}else{echo "";}?>>
										<?php echo $row_card->CARD_DESC;?>
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
								<option value="<?php echo $col_brn->BRANCH_CODE;?>" <?php if($collection_at==$col_brn->BRANCH_CODE){echo "selected";}else{echo "";}?>>
									<?php echo $col_brn->BRANCH_NAME; ?>
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
							<input type="text" id="vmid" name="vmid" value="<?php echo $voucher_master_id; ?>"/>
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

					<!-- ----------------------------------------------------- -->
						<tr>
						<td class="txt_header">3rd Installment</td>
						<td>
							<input type="text" name="txt_inst3_amt" id="txt_inst3_amt" class="mem-info-inpt  <?php echo $class;?>" value="<?php echo $frst_instl_amt  ; ?>" readonly />
						</td>
					</tr>
					<tr>
						<td class="txt_header">3rd Cheque No</td>
						<td>
							<input type="text" name="3rd-chq-no" id="3rd-chq-no" class="mem-info-inpt <?php echo $class;?>" value="<?php echo $frst_instl_chqno  ; ?>" />
						</td>
					</tr>

					<tr>
						<td class="txt_header">3rd Bank</td>
						<td>
							<input type="text" name="3rd-bank" id="3rd-bank" class="mem-info-inpt <?php echo $class;?>" value="<?php echo $frst_instl_bank  ; ?>" />
						</td>
					</tr>
					<tr>
						<td class="txt_header">3rd Branch</td>
						<td>
							<input type="text" name="3rd-brn" id="3rd-brn" class="mem-info-inpt <?php echo $class;?>" value="<?php echo $frst_instl_branch ; ?>" />
						</td>
					</tr>
					<!-- ----------------------------------------------------- -->

					<!-- ----------------------------------------------------- -->
						<tr>
						<td class="txt_header">4th Installment</td>
						<td>
							<input type="text" name="txt_inst4_amt" id="txt_inst4_amt" class="mem-info-inpt  <?php echo $class;?>" value="<?php echo $frst_instl_amt  ; ?>" readonly />
						</td>
					</tr>
					<tr>
						<td class="txt_header">4th Cheque No</td>
						<td>
							<input type="text" name="fourth-chq-no" id="fourth-chq-no" class="mem-info-inpt <?php echo $class;?>" value="<?php echo $frst_instl_chqno  ; ?>" />
						</td>
					</tr>

					<tr>
						<td class="txt_header">4th Bank</td>
						<td>
							<input type="text" name="fourth-bank" id="fourth-bank" class="mem-info-inpt <?php echo $class;?>" value="<?php echo $frst_instl_bank  ; ?>" />
						</td>
					</tr>
					<tr>
						<td class="txt_header">4th Branch</td>
						<td>
							<input type="text" name="fourth-brn" id="fourth-brn" class="mem-info-inpt <?php echo $class;?>" value="<?php echo $frst_instl_branch ; ?>" />
						</td>
					</tr>
					<!-- ----------------------------------------------------- -->


					
					<!-- ----------------------------------------------------- -->
						<tr>
						<td class="txt_header">5th Installment</td>
						<td>
							<input type="text" name="txt_inst5_amt" id="txt_inst5_amt" class="mem-info-inpt  <?php echo $class;?>" value="<?php echo $frst_instl_amt  ; ?>" readonly />
						</td>
					</tr>
					<tr>
						<td class="txt_header">5th Cheque No</td>
						<td>
							<input type="text" name="fifth-chq-no" id="fifth-chq-no" class="mem-info-inpt <?php echo $class;?>" value="<?php echo $frst_instl_chqno  ; ?>" />
						</td>
					</tr>

					<tr>
						<td class="txt_header">5th Bank</td>
						<td>
							<input type="text" name="fifth-bank" id="fifth-bank" class="mem-info-inpt <?php echo $class;?>" value="<?php echo $frst_instl_bank  ; ?>" />
						</td>
					</tr>
					<tr>
						<td class="txt_header">5th Branch</td>
						<td>
							<input type="text" name="fifth-brn" id="fifth-brn" class="mem-info-inpt <?php echo $class;?>" value="<?php echo $frst_instl_branch ; ?>" />
						</td>
					</tr>
					<!-- ----------------------------------------------------- -->

						
					<!-- ----------------------------------------------------- -->
						<tr>
						<td class="txt_header">6th Installment</td>
						<td>
							<input type="text" name="txt_inst6_amt" id="txt_inst6_amt" class="mem-info-inpt  <?php echo $class;?>" value="<?php echo $frst_instl_amt  ; ?>" readonly />
						</td>
					</tr>
					<tr>
						<td class="txt_header">6th Cheque No</td>
						<td>
							<input type="text" name="sixth-chq-no" id="sixth-chq-no" class="mem-info-inpt <?php echo $class;?>" value="<?php echo $frst_instl_chqno  ; ?>" />
						</td>
					</tr>

					<tr>
						<td class="txt_header">6th Bank</td>
						<td>
							<input type="text" name="sixth-bank" id="sixth-bank" class="mem-info-inpt <?php echo $class;?>" value="<?php echo $frst_instl_bank  ; ?>" />
						</td>
					</tr>
					<tr>
						<td class="txt_header">6th Branch</td>
						<td>
							<input type="text" name="sixth-brn" id="sixth-brn" class="mem-info-inpt <?php echo $class;?>" value="<?php echo $frst_instl_branch ; ?>" />
						</td>
					</tr>
					<!-- ----------------------------------------------------- -->


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
									<option value="<?php echo $row_user->user_id;?>" <?php if($done_by==$row_user->user_id){echo "selected";}else{echo "";}?>>
										<?php echo $row_user->name_in_full;?>
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
								<i class="fa fa-check-circle" aria-hidden="true"></i> Payment Info updated successfully.
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
								<option value="<?php echo $row_brn->BRANCH_CODE;?>" <?php if($branch_code==$row_brn->BRANCH_CODE){echo "selected";}else{echo "";}?>>
									<?php echo $row_brn->BRANCH_NAME; ?>
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

								<option value="<?php echo $row_cat->id;?>" <?php if($cardcategoryID==$row_cat->id){echo "selected";}else{echo "";}?>>
									<?php echo $row_cat->category_name;?>
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
									<option value="<?php echo $row_card->CARD_CODE;?>" <?php if($cus_card==$row_card->CARD_CODE){echo "selected";}else{echo "";}?>>
										<?php echo $row_card->CARD_DESC;?>
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
								<option value="<?php echo $col_brn->BRANCH_CODE;?>" <?php if($collection_at==$col_brn->BRANCH_CODE){echo "selected";}else{echo "";}?>>
									<?php echo $col_brn->BRANCH_NAME; ?>
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
								<option value="<?php echo $row_cgst->id;?>" <?php if($cgstRateID==$row_cgst->id){echo "selected";}else{echo "";}?>><?php echo $row_cgst->rate; ?></option>
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
								<option value="<?php echo $row_sgst->id;?>" <?php if($sgstRateId==$row_sgst->id){echo "selected";}else{echo "";} ?>><?php echo $row_sgst->rate; ?></option>
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

					<tr><td >Installment</td><td>
					<select name="installment_phase" id="installment_phase" class="mem-info-inpt" style="width: 306px;">

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

					
					<!-- ----------------------------------------------------- -->
					
					<tr>
						<td class="txt_header">3nd Inst. Dt</td>
						<td>
							<input type="text" name="third-instl-dt-gst" id="third-instl-dt-gst" class="mem-info-inpt datepicker <?php echo $class;?>" value="<?php echo $third_instl_dt ; ?>" style="width:88.5%;height:17px;" />
						</td>
					</tr>
						<tr>
						<td class="txt_header">3rd Installment</td>
						<td>
							<input type="text" name="txt_inst3_amt_gst" id="txt_inst3_amt_gst" class="mem-info-inpt  <?php echo $class;?>" value="<?php echo $third_instl_amt  ; ?>" readonly />
						</td>
					</tr>
					<tr>
						<td class="txt_header">3rd Cheque No</td>
						<td>
							<input type="text" name="third-chq-no-gst" id="third-chq-no-gst" class="mem-info-inpt <?php echo $class;?>" value="<?php echo $third_instl_chqno  ; ?>" />
						</td>
					</tr>

					<tr>
						<td class="txt_header">3rd Bank</td>
						<td>
							<input type="text" name="3rd-bnk-gst" id="3rd-bnk-gst" class="mem-info-inpt <?php echo $class;?>" value="<?php echo $third_instl_bank  ; ?>" />
						</td>
					</tr>
					<tr>
						<td class="txt_header">3rd Branch</td>
						<td>
							<input type="text" name="3rd-brn-gst" id="3rd-brn-gst" class="mem-info-inpt <?php echo $class;?>" value="<?php echo $third_instl_branch ; ?>" />
						</td>
					</tr>
					<!-- ----------------------------------------------------- -->

					<!-- ----------------------------------------------------- -->
						<tr>
						<td class="txt_header">4th Inst. Dt</td>
						<td>
							<input type="text" name="four-instl-dt-gst" id="four-instl-dt-gst" class="mem-info-inpt datepicker <?php echo $class;?>" value="<?php echo $fourth_instl_dt ; ?>" style="width:88.5%;height:17px;" />
						</td>
					</tr>
						<tr>
						<td class="txt_header">4th Installment</td>
						<td>
							<input type="text" name="txt_inst4_amt_gst" id="txt_inst4_amt_gst" class="mem-info-inpt  <?php echo $class;?>" value="<?php echo $fourth_instl_amt  ; ?>" readonly />
						</td>
					</tr>
					<tr>
						<td class="txt_header">4th Cheque No</td>
						<td>
							<input type="text" name="fourth-chq-no-gst" id="fourth-chq-no-gst" class="mem-info-inpt <?php echo $class;?>" value="<?php echo $fourth_instl_chqno  ; ?>" />
						</td>
					</tr>

					<tr>
						<td class="txt_header">4th Bank</td>
						<td>
							<input type="text" name="fourth-bnk-gst" id="fourth-bnk-gst" class="mem-info-inpt <?php echo $class;?>" value="<?php echo $fourth_instl_bank  ; ?>" />
						</td>
					</tr>
					<tr>
						<td class="txt_header">4th Branch</td>
						<td>
							<input type="text" name="fourth-brn-gst" id="fourth-brn-gst" class="mem-info-inpt <?php echo $class;?>" value="<?php echo $fourth_instl_branch ; ?>" />
						</td>
					</tr>
					<!-- ----------------------------------------------------- -->


					
					<!-- ----------------------------------------------------- -->
					<tr>
						<td class="txt_header">5th Inst. Dt</td>
						<td>
							<input type="text" name="five-instl-dt-gst" id="five-instl-dt-gst" class="mem-info-inpt datepicker <?php echo $class;?>" value="<?php echo $fifth_instl_dt ; ?>" style="width:88.5%;height:17px;" />
						</td>
					</tr>
						<tr>
						<td class="txt_header">5th Installment</td>
						<td>
							<input type="text" name="txt_inst5_amt_gst" id="txt_inst5_amt_gst" class="mem-info-inpt  <?php echo $class;?>" value="<?php echo $fifth_instl_amt  ; ?>" readonly />
						</td>
					</tr>
					<tr>
						<td class="txt_header">5th Cheque No</td>
						<td>
							<input type="text" name="fifth-chq-no-gst" id="fifth-chq-no-gst" class="mem-info-inpt <?php echo $class;?>" value="<?php echo $fifth_instl_chqno  ; ?>" />
						</td>
					</tr>

					<tr>
						<td class="txt_header">5th Bank</td>
						<td>
							<input type="text" name="fifth-bnk-gst" id="fifth-bnk-gst" class="mem-info-inpt <?php echo $class;?>" value="<?php echo $fifth_instl_bank  ; ?>" />
						</td>
					</tr>
					<tr>
						<td class="txt_header">5th Branch</td>
						<td>
							<input type="text" name="fifth-brn-gst" id="fifth-brn-gst" class="mem-info-inpt <?php echo $class;?>" value="<?php echo $fifth_instl_branch ; ?>" />
						</td>
					</tr>
					<!-- ----------------------------------------------------- -->

						
					<!-- ----------------------------------------------------- -->
					<tr>
						<td class="txt_header">6th Inst. Dt</td>
						<td>
							<input type="text" name="six-instl-dt-gst" id="six-instl-dt-gst" class="mem-info-inpt datepicker <?php echo $class;?>" value="<?php echo $sixth_instl_dt ; ?>" style="width:88.5%;height:17px;" />
						</td>
					</tr>
						<tr>
						<td class="txt_header">6th Installment</td>
						<td>
							<input type="text" name="txt_inst6_amt_gst" id="txt_inst6_amt_gst" class="mem-info-inpt  <?php echo $class;?>" value="<?php echo $sixth_instl_amt  ; ?>" readonly />
						</td>
					</tr>
					<tr>
						<td class="txt_header">6th Cheque No</td>
						<td>
							<input type="text" name="sixth-chq-no-gst" id="sixth-chq-no-gst" class="mem-info-inpt <?php echo $class;?>" value="<?php echo $sixth_instl_chqno  ; ?>" />
						</td>
					</tr>

					<tr>
						<td class="txt_header">6th Bank</td>
						<td>
							<input type="text" name="sixth-bnk-gst" id="sixth-bnk-gst" class="mem-info-inpt <?php echo $class;?>" value="<?php echo $sixth_instl_bank  ; ?>" />
						</td>
					</tr>
					<tr>
						<td class="txt_header">6th Branch</td>
						<td>
							<input type="text" name="sixth-brn-gst" id="sixth-brn-gst" class="mem-info-inpt <?php echo $class;?>" value="<?php echo $sixth_instl_branch ; ?>" />
						</td>
					</tr>
					<!-- ----------------------------------------------------- -->


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
									<option value="<?php echo $row_user->user_id;?>" <?php if($done_by==$row_user->user_id){echo "selected";}else{echo "";}?>>
										<?php echo $row_user->name_in_full;?>
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
							<i class="fa fa-check-circle" aria-hidden="true"></i> Payment Info updated successfully.
							</p>
						</td>
					</tr>

				</table>
			</div>


		</div>

			<!-- --------------------Medical Info ---------------------- -->
        <div role="tabpanel" class="tab-pane " id="medicalInfo">
		<h3 class="edit-title"><?php echo "Medical Info";?> - Edit</h3>
			<div class="tab-detail">

			<table class="mem-info-table"   cellspacing="6" >


					<tr><td ><b>Present Complaint</b></td>
					<td>
					<textarea name="txt_comp" id="txt_comp" class="mem-info-inpt" rows="4" " placeholder="(Optional)"><?php echo $rowMemberInfo->CUS_COMPLAINT;?></textarea></td></tr>
					<tr>
					<td ><b>Past History</b></td>
					<td><textarea name="txt_his" id="txt_his" class="mem-info-inpt" rows="4"   placeholder="(Optional)"><?php echo $rowMemberInfo->CUS_HISTORY;?></textarea></td></tr>
                    <tr><td><b>Appetite</b></td>
					<td><select name="sel_app" id="sel_app" class="mem-info-inpt" >
					<?PHP
				
					?>

					<?PHP
					 for($m=0;$m<=sizeof($appetite);$m++)
				     {
					?>
                    <?PHP
				     if ($app_data!=$appetite[$m])
			         {
					?>
					<option value="<?PHP echo($appetite[$m]);?>" <?php if($rowMemberInfo->CUS_APPETITE==$appetite[$m]){echo "selected";}?>  ><?PHP echo($appetite[$m]);?></option>
                    <?PHP
					 } 
					 }
					?>

					</select></td></tr>
					<tr><td><b>Digestion</b></td>
					<td><select name="sel_dig" id="sel_dig" class="mem-info-inpt" >
				
					<?PHP
					 for($m=0;$m<=sizeof($digestion);$m++)
				     {
					?>
                    <?PHP
				     if ($digestion_data!=$digestion[$m])
			         {
					?>
					<option value="<?PHP echo($digestion[$m]);?>" <?php if($rowMemberInfo->CUS_DIGESTION==$digestion[$m]){echo "selected";}?>   ><?PHP echo($digestion[$m]);?></option>
                    <?PHP
					 } 
					 }
					?>

					</select></td></tr>

					<tr><td><b>Heart</b></td><td>
					<select name="sel_hrt" id="sel_hrt" class="mem-info-inpt" >
					

					<?PHP
					 for($m=0;$m<=sizeof($heart);$m++)
				     {
					?>
                    <?PHP
				     if ($heart_data!=$heart[$m])
			         {
					?>
					<option value="<?PHP echo($heart[$m]);?>" <?php if($rowMemberInfo->CUS_HEART==$heart[$m]){echo "selected";}?> ><?PHP echo($heart[$m]);?></option>
                    <?PHP
					 } 
					 }
					?>

					</select></td></tr>

					<tr><td><b>Urine</b></td><td>
					<select name="sel_urn" id="sel_urn" class="mem-info-inpt" >
					

					<?PHP
					 for($m=0;$m<=sizeof($urine);$m++)
				     {
					?>
                    <?PHP
				     if ($urine_data!=$urine[$m])
			         {
					?>
					<option value="<?PHP echo($urine[$m]);?>"  <?php if($rowMemberInfo->CUS_URINE==$urine[$m]){echo "selected";}?> ><?PHP echo($urine[$m]);?></option>
                    <?PHP
					 } 
					 }
					?>

					</select></td></tr>

					<tr><td><b>Nerves</b></td>
					<td><select name="sel_nrv" id="sel_nrv" class="mem-info-inpt" >
				

					<?PHP
					 for($m=0;$m<=sizeof($nerves);$m++)
				     {
					?>
                    <?PHP
				     if ($nerves_data!=$nerves[$m])
			         {
					?>
					<option value="<?PHP echo($nerves[$m]);?>" <?php if($rowMemberInfo->CUS_NERVES==$nerves[$m]){echo "selected";}?> ><?PHP echo($nerves[$m]);?></option>
                    <?PHP
					 } 
					 }
					?>

					</select></td></tr>

					<tr><td><b>ENT</b></td>
					<td><select name="sel_ent" id="sel_ent" class="mem-info-inpt" >
				

					<?PHP
					 for($m=0;$m<=sizeof($ent);$m++)
				     {
					?>
                    <?PHP
				     if ($ent_data!=$ent[$m])
			         {
					?>
					<option value="<?PHP echo($ent[$m]);?>" <?php if($rowMemberInfo->CUS_ENT==$ent[$m]){echo "selected";}?> ><?PHP echo($ent[$m]);?></option>
                    <?PHP
					 } 
					 }
					?>
					</select></td></tr>

					<tr><td><b>Orthopedic Problem</b></td>
					<td><select name="sel_ort" id="sel_ort" class="mem-info-inpt" >
				

					<?PHP
					 for($m=0;$m<=sizeof($ortho);$m++)
				     {
					?>
                    <?PHP
				     if ($ortho_data!=$ortho[$m])
			         {
					?>
					<option value="<?PHP echo($ortho[$m]);?>" <?php if($rowMemberInfo->CUS_ORTHO==$ortho[$m]){echo "selected";}?> ><?PHP echo($ortho[$m]);?></option>
                    <?PHP
					 } 
					 }
					?>

					</select></td></tr>

					<tr><td><b>Psyche</b></td>
					<td><select name="sel_psy" id="sel_psy" class="mem-info-inpt" >
				

					<?PHP
					 for($m=0;$m<=sizeof($psyche);$m++)
				     {
					?>
                    <?PHP
				     if ($psyche_data!=$psyche[$m])
			         {
					?>
					<option value="<?PHP echo($psyche[$m]);?>" <?php if($rowMemberInfo->CUS_PSYCHE==$psyche[$m]){echo "selected";}?>><?PHP echo($psyche[$m]);?></option>
                    <?PHP
					 } 
					 }
					?>

					</select></td></tr>

					<tr><td><b>Female Disorder</b></td>
					<td><select name="sel_fem" id="sel_fem" class="mem-info-inpt" >
				

					<?PHP
					 for($m=0;$m<=sizeof($disorder);$m++)
				     {
					?>
                    <?PHP
				     if ($disorder_data!=$disorder[$m])
			         {
					?>
					<option value="<?PHP echo($disorder[$m]);?>" <?php if($rowMemberInfo->CUS_FD==$disorder[$m]){echo "selected";}?> ><?PHP echo($disorder[$m]);?></option>
                    <?PHP
					 } 
					 }
					?>

					</select></td></tr>

					<tr><td><b>Diet</b></td>
					<td><select name="sel_dit" id="sel_dit" class="mem-info-inpt"  >
				

					<?PHP
					 for($m=0;$m<=sizeof($diet);$m++)
				     {
					?>
                    <?PHP
				     if ($diet_data!=$diet[$m])
			         {
					?>
					<option value="<?PHP echo($diet[$m]);?>" <?php if($rowMemberInfo->CUS_DIET==$diet[$m]){echo "selected";}?> ><?PHP echo($diet[$m]);?></option>
                    <?PHP
					 } 
					 }
					?>

					</select></td></tr>




				<tr>
						<td colspan="4" align="center">
							<button type="button" class="btn btn-danger" style="width: 26%;" id="updateMedicalInfo">Update</button>
						</td>
					</tr>
					<tr>

						<td colspan="4" align="center">
							<p id="medicalinfo-upd" style="font-size:18px;color:#18B64C;display:none;">
								<i class="fa fa-check-circle" aria-hidden="true"></i> Medical Info updated successfully.
							</p>
						</td>
					</tr>


			</table>

			</div>
		</div>
		<!-- --------------------end Medical Info ---------------------- -->


			<!-- --------------------General Medical Assestment Info ---------------------- -->
        <div role="tabpanel" class="tab-pane " id="generalmedicalInfo">
		<h3 class="edit-title"><?php echo "General Medical Assestment";?> - Edit</h3>
			<div class="tab-detail">

				<table class="mem-info-table"   cellspacing="6" >
					<tr>
						<td><div style="margin-top: 20px;">												
									                                         
									<input type="checkbox" class="rowCheck inputcheck" name="is_high_bp" id="is_high_bp" <?php if($rowMemberInfo->is_high_bp=='Yes'){echo "checked";};?>  value="Yes" >
									&nbsp;&nbsp;<span><b>High BP</b></span>
								</div></td>
						
						<td colspan="2">
					<input type="text" class="mem-info-inpt" id="high_bp_medicines" name="high_bp_medicines" placeholder="High BP medicine" autocomplete="off" value="<?php echo $rowMemberInfo->high_bp_medicines;?>"></td>
						
					</tr>


					<tr>
						<td>
						<div class="form-group" style="margin-top: 16px;">
                          <div class="custom-control custom-radio">
                          <input class="custom-control-input" type="radio" id="diabetes_radio1" name="diabetes_radio" value="Type 1" <?php if($rowMemberInfo->diabetes_type=='Type 1'){echo "checked";};?>>
                          <label for="diabetes_radio1" class="custom-control-label">Diabetes Type 1</label>
                          </div>
						  </div>
						  <div class="form-group" style="margin-top: 16px;">
						  <div class="custom-control custom-radio">
                          <input class="custom-control-input" type="radio" id="diabetes_radio2" name="diabetes_radio" value="Type 2" <?php if($rowMemberInfo->diabetes_type=='Type 1'){echo "checked";};?>>
                          <label for="diabetes_radio2" class="custom-control-label">Diabetes Type 2</label>
                          </div>
						   </div>
						</td>
						
						
						<td colsan="3">	
					
						<input type="text" class="mem-info-inpt" id="diabetics_medicines" name="diabetics_medicines" placeholder="Diabetics  medicine" autocomplete="off" value="<?php echo $rowMemberInfo->diabetics_medicines;?>">
					</tr>

				<tr>
				<td><div  style="margin-top: 16px;">												
								                                          
									<input type="checkbox" class="rowCheck inputcheck" name="is_heart_disease" id="is_heart_disease"  value="Yes" <?php if($rowMemberInfo->is_heart_disease=='Yes'){echo "checked";};?> >
									&nbsp;&nbsp;<span><b>Heart disease </b></span>
								</div>
				</td>
				<td colspan="2">		
				<input type="text" class="mem-info-inpt" id="heart_disease_medicines" name="heart_disease_medicines" placeholder="Heart disease medicine" autocomplete="off" value="<?php echo $rowMemberInfo->heart_disease_medicines;?>">
				</td>
						
				</tr>

				<tr>
				<td><div  style="margin-top: 16px;">												
									                                         
								    <input type="checkbox" class="rowCheck inputcheck" name="is_pcod" id="is_pcod"  value="Yes" <?php if($rowMemberInfo->is_pcod=='Yes'){echo "checked";};?> >
									&nbsp;&nbsp;<span><b>PCOD </b></span>
								</div>
				</td>
				<td colspan="2">		
				<input type="text" class="mem-info-inpt" id="pcod_medicines" name="pcod_medicines" placeholder="PCOD medicine" autocomplete="off" value="<?php echo $rowMemberInfo->pcod_medicines;?>">
				</td>				
				</tr>

				<tr>
				<td><div  style="margin-top: 16px;">												
									                                     
								   <input type="checkbox" class="rowCheck inputcheck" name="is_chronic_kidney_disease" placeholder="Chronic medicine" id="is_chronic_kidney_disease"  value="Yes" <?php if($rowMemberInfo->is_chronic_kidney_disease=='Yes'){echo "checked";};?> >
									&nbsp;&nbsp;<span><b>Chronic Kidney Disease </b></span>
								</div>
				</td>
				<td colspan="2">		
				
					<input type="text" class="mem-info-inpt" id="chronic_kidney_disease_medicines" name="chronic_kidney_disease_medicines" placeholder=" " autocomplete="off" value="<?php echo $rowMemberInfo->chronic_kidney_disease_medicines;?>">
				</td>
								
				</tr>
				<tr>
				<td><b>Psyche</b></td>
				<td>
					<select class="mem-info-inpt" id="sel_psyche" name="sel_psyche" style="width:254px;">
														<option value="">Select</option>
														<option value="Healthy" <?php if($rowMemberInfo->psyche=='Healthy'){echo "selected";}?> >Healthy</option>
														<option value="Anxiety" <?php if($rowMemberInfo->psyche=='Anxiety'){echo "selected";}?>>Anxiety</option>
														<option value="Depression" <?php if($rowMemberInfo->psyche=='Depression'){echo "selected";}?>>Depression</option>
														<option value="Childhood Experience" <?php if($rowMemberInfo->psyche=='Childhood Experience'){echo "selected";}?>>Childhood Experience</option>
														<option value="Others" <?php if($rowMemberInfo->psyche=='Others'){echo "selected";}?>>Others</option>
														</select>
				</td>
				</tr>

				<tr>
				<td >
					<b>History of Regular Medication: </b>
				</td>
				<td colspan="2">
				<textarea  class="mem-info-inpt" id="regular_med_history" rows=4 name="regular_med_history"></textarea>
				</td>
				
				</tr>











					
						<tr>
						<td colspan="4" align="center">
							<button type="button" class="btn btn-danger" style="width: 26%;" id="updateGenMedicalInfo">Update</button>
						</td>
					</tr>
					<tr>

						<td colspan="4" align="center">
							<p id="genmed-upd" style="font-size:18px;color:#18B64C;display:none;">
								<i class="fa fa-check-circle" aria-hidden="true"></i> General Medical Assestment updated successfully.
							</p>
						</td>
					</tr>
	
	</table>
			

			</div>
		</div>
		<!-- --------------------end General Medical Assestment Info ---------------------- -->





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
