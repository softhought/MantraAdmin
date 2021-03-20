
 <div class="formblock-box">
<div class="card card-success card-outline" style="border-bottom: 3px solid #d96692;">

          <div class="card-header">
           
          </div> <!-- /.card-body -->
          <div class="card-body">
               <div class="linkBtn">
		<a href="#" id="previous_link">Previous</a>
		<a href="#" id="next_link">Next</a>
	</div>
           
<?php 

$this->load->model('dietmodel','_dietmodel',TRUE);
$i = 1;
foreach($rowMembrshpList as $member_meal){

$rowMemberMealDtl = $this->_dietmodel->GetMemberMealDetail($member_meal->memberMealMasterID);
?>
<div class="memberMealContainer">
	<div>
	<h3 style="font-size:16px;text-align:center;font-weight:bold;color: #45b014;">Member's Meal Info</h3>
	<input type="hidden" name="mealid" value="<?php echo $member_meal->memberMealMasterID; ?>" />
	
	<table class="custom_table table-striped" id="memPersonalInfo" >
		
		<tr>
			<td>Meal Date</td>
			<td><strong><?php echo date("d-m-Y",strtotime($member_meal->meal_date)); ?></strong></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>Membership No</td>
			<td><?php echo $member_meal->membership_no ; ?></td>
			<td>Name</td>
			<td><?php echo $member_meal->CUS_NAME ; ?></td>
		</tr>
		<tr>
			<td>Validity</td>
			<td><?php echo $member_meal->validity_string; ?></td>
			<td>Mobile</td>
			<td><?php echo $member_meal->CUS_PHONE ; ?></td>
		</tr>

	</table>
	
	<table id="memb_cal_tab" class="custom_table" border="0" cellspacing="0" cellpadding="0" style="width:49%;float:left;margin-top:3%;border:1px solid #dd9284;">
		<tr >
			<td>Weight(Kgs.)</td>
			<td><?php echo $member_meal->weight; ?></td>
		</tr>
		<tr >
			<td>Waist(Inch.)</td>
			<td><?php echo $member_meal->waist; ?></td>
		</tr>
		<tr>
			<td>Activity Level</td>
			<td><?php echo $member_meal->activity_level; ?></td>
		</tr>
		<tr>
			<td>Body Fat %</td>
			<td><?php echo $member_meal->bodyfatpercent; ?></td>
		</tr>
		<tr>
			<td>BMR</td>
			<td><?php echo $member_meal->bmr_rate; ?></td>
		</tr>
	</table>
	
	<table id="memb_calResult_tab" class="custom_table" border="0" cellspacing="0" cellpadding="0" style="width:49%;float:right;margin-top:3%;border:1px solid #dd9284;">
		<tr>
			<td>Meal Approach</td>
			<td><?php echo $member_meal->meal_approach; ?></td>
		</tr>
		<tr>
			<td>Calorie Req.</td>
			<td><?php echo $member_meal->final_calorie_req; ?></td>
		</tr>
		<tr>
			<td>Protein Req(In gm)</td>
			<td><?php echo $member_meal->protein_gm; ?></td>
		</tr>
		<tr>
			<td>Carbs Req.(In gm)</td>
			<td><?php echo $member_meal->carbs_gm; ?></td>
		</tr>
		<tr>
			<td>Fat Req.(In gm)</td>
			<td><?php echo $member_meal->fat_gm; ?></td>
		</tr>
	</table>
	<div style="clear:both;padding:5px 0;"></div>
	<?php foreach($rowMemberMealDtl as $memmealDtl){
	$rowMemFoodDtl = $this->_dietmodel->GetMemberFoodDtl($memmealDtl->id);	
	?>
	<table id="memberFoodDtl" class="custom_table" border="0" cellspacing="0" cellpadding="0" >
		<tr style="background:rgb(156, 72, 172);color:#FFF;font-weight:700;height:25px;">
			<td><?php echo $memmealDtl->meal_name ; ?></td>
			<td colspan="6" align="left">Time : <?php echo date("h:i a",strtotime($memmealDtl->meal_time)); ?></td>
		</tr>
		<tr style="background:#e0e0e0;font-weight:700;">
			<td width="25%">Food</td>
			<td width="8%">Qty</td>
			<td width="8%">Unit</td>
			<td width="8%">Calorie</td>
			<td width="8%">Protein(g)</td>
			<td width="8%">Carbs(g)</td>
			<td width="8%">Fat(g)</td>
		</tr>
		<?php foreach($rowMemFoodDtl as $foodDtl){?>
			<tr>
				<td><?php echo $foodDtl->food_name; ?></td>
				<td><?php echo $foodDtl->food_qty; ?></td>
				<td><?php echo $foodDtl->unit_name; ?></td>
				<td><?php echo $foodDtl->calorie; ?></td>
				<td><?php echo $foodDtl->protein_grams; ?></td>
				<td><?php echo $foodDtl->carbs_grams; ?></td>
				<td><?php echo $foodDtl->fat_grams; ?></td>
			</tr>
		<?php } ?>
	</table>
	<?php } ?>
	
	<table class="custom_table table-striped"	id="memTotalMealGivenTab" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td>Total Calorie Gained</td>
			<td><?php echo $member_meal->total_calorie_given; ?></td>
			<td>Total Protein Given</td>
			<td><?php echo $member_meal->total_protein_given; ?> (g)</td>
		</tr>
		<tr>
			<td>Total Carbs Given</td>
			<td><?php echo $member_meal->total_carbs_given; ?> (g)</td>
			<td>Total Fat Given</td>
			<td><?php echo $member_meal->total_fat_given; ?> (g)</td>
		</tr>
	</table>
	
	
	
	<div style="clear:both;"></div>
	</div>
	<div style="clear:both;padding:10px 0;"></div>
	
	
</div>
<?php } ?>
          
          
      <!-- <div class="linkBtn">
		<a href="#" id="previous_link">Previous</a>
		<a href="#" id="next_link">Next</a>
	</div> -->

          </div><!-- /.card-body -->
        </div>
         </div>

  <script>
	$('div.memberMealContainer:not(:first)').hide();
    $('#previous_link').hide();
    $('#next_link, #previous_link').click(function(e) {		
		e.preventDefault();		
		var currentIdx = parseInt($('div.memberMealContainer:visible').index('div.memberMealContainer'), 10);
		var nextIdx = ($(e.target).is('#next_link')) ? currentIdx + 1 : currentIdx - 1;
        
        if ((nextIdx + 1) == $('div.memberMealContainer').length) {
          $('#next_link').hide();   
        } else {
          $('#next_link').show();   
        }
        
        if (nextIdx == 0) {
         $('#previous_link').hide();   
        } else {
         $('#previous_link').show();   
        }
		
		$('div.memberMealContainer:eq(' + currentIdx + ')').hide();
		$('div.memberMealContainer:eq(' + nextIdx + ')').show();
		
	});
</script>       

     




