<table  class="table customTbl table-bordered table-hover dataTable tablepad display compact" cellspacing="0" width="100%" cellspacing="0" width="100%" style="border-collapse:collapse;">
	<thead >
		<tr>
			<th width="">Sl</th>
			<th align="left">Membership</th>
			<th align="left">Branch</th>
			<th align="left">Name</th>
			<th align="left">Mobile</th>
			<th align="left">Meal Date</th>
			<th>Copy</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php $sl=1;
			foreach($rowMemberDietResult as $member_meal){
				
				if($member_meal->is_copied=="Y" AND $member_meal->is_modified=="N")
				{
					$copyied = "Y";
					$tr_bg_color = "background:#ffd996";
				}
				else
				{
					$tr_bg_color = "";
					$copyied = "";
				}
				
				?>
		<tr style="<?php echo $tr_bg_color; ?>">
			<td style="<?php echo $tr_bg_color; ?>"><?php echo $sl++; ?></td>
			<td><?php echo $member_meal->membership_no; ?></td>
			<td><?php echo $member_meal->BRANCH_NAME; ?></td>
			<td><?php echo $member_meal->CUS_NAME; ?></td>
			<td><?php echo $member_meal->CUS_PHONE; ?></td>
			<td><?php echo date('d-m-Y',strtotime($member_meal->meal_date)); ?></td>
			<td><?php echo $copyied; ?></td>
			<td align="center">
				 <a href="<?php echo admin_with_base_url(); ?>diet/preparediet/<?php echo $member_meal->memberMealMasterID; ?>" title="Edit Diet"><img src="<?php echo base_url(); ?>assets/img/edit_icon_custom.png" class="meal_list_icon"/></a>
				
				<a href="javascript:void(0);" title="Copy Diet" data-toggle="modal" data-target="#copyDietModal"  data-id="<?php echo $member_meal->memberMealMasterID;?>" class="copyDietModal"><img src="<?php echo base_url(); ?>assets/img/copy_icon.png" class="meal_list_icon"/></a>
				
				<!-- <a href="javascript:void(0);" title="Email Diet" onclick="sendDietEmail(<?php echo $member_meal->memberMealMasterID; ?>);"><img src="<?php echo base_url(); ?>assets/img/email_icon.png" class="meal_list_icon"/></a>
				 -->
				                            <a id="wplink" href="https://api.whatsapp.com/send?text=https://www.mantrahealthclub.com/adminportal/admin/diet/printdiet/<?php echo $member_meal->memberMealMasterID; ?>" target="_blank" > &nbsp; <img src="<?php echo base_url(); ?>assets/img/wp.png" class="meal_list_icon" /></a>
				<a href="<?php echo admin_with_base_url(); ?>diet/printdiet/<?php echo $member_meal->memberMealMasterID; ?>" target="_blank" title="Print Diet"><img src="<?php echo base_url(); ?>assets/img/print_icon_custom.png" class="meal_list_icon"/></a>
				
				<a href="javascript:;"  onclick="return confirmDelete(<?php echo $member_meal->memberMealMasterID; ?>);" title="Delete Diet"><img src="<?php echo base_url(); ?>assets/img/delete_icon.png" class="meal_list_icon"/></a>
			
			<!--  -->
            </td>
		</tr>
		<?php } ?>
	</tbody>
</table>

<!-- Modal -->
  <div class="modal fade" id="copyDietModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content" style="background:url('<?php echo base_url(); ?>assets/img/copy_diet_bg.png');">
		
        <div class="modal-header">
          <h4 class="modal-title" style="color:#FFF;">Make a duplicate</h4>
          <button type="button" class="close" data-dismiss="modal" style="color: #FFFF;opacity:.9;" onclick="closeCopyDietDialog();">&times;</button>
         
        </div>
        <div class="modal-body">
       
			<div class="dietCopyForm" id="dietCopyForm">
				<table style="width:90%;margin:0 auto;font-size:12px;color:#FFF;font-weight:700;">
					<tr>
						<td >Date of Diet</td>
						<td>
							<input type="hidden" name="mealMastIdFc" id="mealMastIdFc" />
							<input type="text" name="copyMealdate" id="copyMealdate" class="datepicker" style="border: 1px solid #FFF;width:198px;color:#fe5c36;font-weight:600;" readonly onchange="enableCopyButton();"/>
						</td>
					</tr>
					<tr>
						
						<td colspan="2" align="right">
							<button class="data-copy-btn" id="copy-button" onclick="copyDiet();" style="display:none;">Copy Diet</button>
						</td>
					</tr>
				</table>
			</div>
			
			<div class="custom-loader" id="custom-loader" style="display:none;">
				<h3 style="padding-top: 24px;">Please Wait</h3>
				<h3 style="margin-top: -14px;">We are processing...</h3>
				<img src="<?php echo base_url(); ?>assets/img/copy_data_loader.gif" />
			</div>
			<div class="copy-data-tagline" id="copy-data-tagline" >
				<img src="<?php echo base_url(); ?>assets/img/copy_data_transfer.png" />
				<p>Click button "Copy Diet" to make a duplicate of existing diet plan for your convenience.</p>
			</div>
			<div class="success-done" id="success-done" style="display:none;"> 
				<img src="<?php echo base_url(); ?>assets/img/success-right-icon.png" />
				<p>Diet has been successfully copied.you can check in diet list.Click on "Refresh Button" after closing this to get copied data.</p>
				<!--<button class="data-copy-btn" style="margin-left:132px;width:80px;" onclick="closeCopyDietDialog();">OK</button>-->
			</div>
			
			<div class="failure-done" id="failure-done" style="display:none;"> 
				<img src="<?php echo base_url(); ?>assets/img/error_icon.png" />
				<p>There is some problem while processing.Please try again later.</p>
			</div>
			
        </div>
		<!--
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">X</button>
        </div>-->
      </div>
      
    </div>
  </div>

  
  <script>
	$('#copyMealdate').datepicker({
            autoclose: true,
			todayHighlight: true,
            format: 'dd-mm-yyyy',
			forceParse: false
		});
  </script>
