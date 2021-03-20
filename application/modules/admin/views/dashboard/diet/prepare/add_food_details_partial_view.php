<tr id="fdetailrow_<?php echo $mealno; ?>_<?php echo $row; ?>" style="font-weight:700;">
	<td>
	<input type="hidden" id="foodForMeal_<?php echo $mealno; ?>" name="foodID_<?php echo $mealno; ?>[]" value="<?php echo $food_id; ?>" />
	<?php echo $food_name; ?>
	</td>
	<td>
		<input type="hidden" id="qtyForMeal_<?php echo $mealno; ?>" name="qtyGiven_<?php echo $mealno; ?>[]" value="<?php echo $qty_req; ?>" />
		<?php echo $qty_req ; ?>
	</td>
	<td>
		<input type="hidden" id="UnitForMeal_<?php echo $mealno; ?>" name="UnitGiven_<?php echo $mealno; ?>[]" value="<?php echo $unitID; ?>" />
		<?php echo $unit ; ?>
	</td>
	<td>
		<input type="text" name="calorieGiven_<?php echo $mealno; ?>[]" id="calorieGiven_<?php echo $mealno;?>" class="calorieGiven form_input_text" value="<?php echo $calorie_given; ?>"  style="width:80px;text-align:right;" readonly />
		
	</td>
	<td>
		<input type="text" name="proteinGiven_<?php echo $mealno; ?>[]" id="proteinGiven_<?php echo $mealno;?>" class="proteinGiven form_input_text" value="<?php echo $protein_given; ?>" style="width:80px;text-align:right;" readonly />
		<?php //echo $protein_given; ?>
	</td>
	<td>
		<input type="text" name="carboGiven_<?php echo $mealno; ?>[]" id="carboGiven_<?php echo $mealno;?>" class="carboGiven form_input_text" value="<?php echo $carbo_given; ?>"  style="width:80px;text-align:right;" readonly />
		
	</td>
	<td>
		<input type="text" name="fatGiven_<?php echo $mealno; ?>[]" id="fatGiven_<?php echo $mealno;?>" class="fatGiven form_input_text" value="<?php echo $fat_given; ?>" style="width:80px;text-align:right;" readonly />
		<?php //echo $fat_given; ?>
	</td>
	
	<?php if(strlen($instruction)>0){?>
	<td>
		<input type="hidden" name="instructionGiven_<?php echo $mealno; ?>[]" id="instructionGiven_<?php echo $mealno;?>" class="instructionGiven form_input_text" value="<?php echo $instruction; ?>" style="width:80px;text-align:right;" readonly />
		<?php echo $instruction; ?>
	</td>
	<?php } else{
	?>
		<input type="hidden" name="instructionGiven_<?php echo $mealno; ?>[]" id="instructionGiven_<?php echo $mealno;?>" class="instructionGiven form_input_text" value="<?php echo ""; ?>" style="width:80px;text-align:right;" readonly />
		<?php echo $instruction; ?>
	<?php } ?>
	<td style="vertical-align: middle;text-align: center;">
		<a href="javascript:;" class="delicon" id="deldtlid_<?php echo $mealno; ?>_<?php echo $row; ?>" title="Delete">
        <i class="far fa-trash-alt" style="color: #d04949;; font-weight:700;"></i>
        </a>

		
	</td>
</tr>