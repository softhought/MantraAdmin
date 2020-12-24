	<table id="example" class="table customTbl table-bordered table-hover dataTable tablepad display compact" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>Sl</th>
			<th>Payment Dt</th>
			<th>Membership</th>
			<th>Validity<br>(Validity+GrantDays)</th>
			<th>Name</th>
			<th>Mobile</th>
			<th>Type</th>
			<th>GST</th>
			<th>Status</th>
			<th style="text-align:right;">Action</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$this->load->model('registrationmodel','reg_model',TRUE);


		//$result = $this->CI->test();
		$i = 1;
		$currdate = date('Y-m-d');
		$isActive = "";
		$final_exp_date = "";
		foreach($rowMemberInfo as $row_mem)
		{
		
		$from_dt = $row_mem->FROM_DT;
		$validupto = $row_mem->VALID_UPTO;
		$isActive = $row_mem->IS_ACTIVE;
		$validityUpto = substr($row_mem->VALIDITY_STRING,13);
		
		$rowApplication = $this->reg_model->getMemberExtension($row_mem->memberhip,$row_mem->VALIDITY_STRING);	
		$appl_ext_days = 0;
		if($rowApplication)
		{
		$appl_ext_days=$rowApplication->grant_days;
		}
		 $final_dt = explode("-",$validupto);
		 // after application
		// $final_exp_date = date('Y-m-d',strtotime('+'.$appl_ext_days.' Days',mktime(0,0,0,$final_dt[1],$final_dt[2],$final_dt[0])));
		 $final_exp_date =  date('Y-m-d', strtotime($validityUpto. ' + '.$appl_ext_days.' days'));
		 
		 $actualValidity = date("d-m-Y",strtotime($row_mem->FROM_DT))." To ".date("d-m-Y",strtotime($final_exp_date));
		 
		 
		// Status Check 
		$status="";
		if($isActive == "N" AND $final_exp_date>$currdate)
		{
			$status = "Inactive";
		}
		
		if($currdate>$final_exp_date)
		{
			$status = "Expired";
		}
		if($currdate<$final_exp_date AND $isActive=="Y")
		{
			$status = "Active";
		}
		if($from_dt>$currdate)
		{
			$status = "Advance";
		}
		
	
		
		
		if($final_exp_date >= $currdate)
		{
		?>
		<tr>
			<td><?php echo $i++; ?></td>
			<td align="left"><?php echo date('d-m-Y',strtotime($row_mem->PAYMENT_DT)); ?></td>
			<td align="left"><?php echo $row_mem->memberhip; ?></td>
			<td align="left"><?php echo $actualValidity; ?></td>
			<td align="left"><?php echo $row_mem->CUS_NAME; ?></td>
			<td align="left"><?php echo $row_mem->CUS_PHONE; ?></td>
			<td align="left"><?php echo $row_mem->payment_from; ?></td>
			<td align="left"><?php echo $row_mem->IS_GST; ?></td>
			<td align="left">
				<?php 
								if($status == "Active")
								{
								?>
									<span style="font-weight:700;background:green;padding: 5px 20px;border-radius: 8px;color: #FFF;"><?php echo $status;?></span>	
								<?php 
								}
								elseif($status == "Advance")
								{
								?>
									<span style="font-weight:700;background:#0d7fcd;padding: 5px 20px;border-radius: 8px;color: #FFF;"><?php echo $status;?></span>
								<?php
								}
								else
								{
								?>
									<span style="font-weight:700;background:red;padding: 5px 20px;border-radius: 8px;color: #FFF;"><?php echo $status;?></span>	
								<?php } ?>
								
			</td>
			<td align="right">
			<a href="javascript:void(0);" class="btn tbl-action-btn padbtn editMemberModal" data-toggle="modal" data-target="#editMemberModal"  data-memdtl='{"cid":<?php echo $row_mem->CUS_ID;?>,"pid":<?php echo $row_mem->PAYMENT_ID; ?>,"mno":"<?php echo $row_mem->memberhip; ?>"}' style="margin-left: 30px;">  <i class="fas fa-edit"></i> </a> 
			<!--<a href="javascript:void(0)" ><img src="images/delete_me.png" width="20" height="20"/></a>-->
			</td>
		</tr>
		<?php 
		}else{echo "";}
		
		}
		
		?>
	</tbody>
	
</table>