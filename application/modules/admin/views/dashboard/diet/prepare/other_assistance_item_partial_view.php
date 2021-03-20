<tr id="otherAssistanceRow_<?php echo $row; ?>">
	<td>
		<input type="hidden" name="otherAssistanceCategory[]" class="otherAssistanceCategory" value="<?php echo $category; ?>" />
		<?php echo $suplmntCatg; ?>
	</td>
	<td>
		<input type="hidden" name="otherAssistanceSupplyName[]" class="otherAssistanceSupplyName" value="<?php echo $supplmntID; ?>" />
		<?php echo $suplmntName; ?>
	</td>
	<td>
		<input type="hidden" name="otherAssistanceServingSize[]" class="otherAssistanceServingSize" value="<?php echo $servingsize; ?>" />
		<?php echo $servingsize; ?>
	</td>
	<td>
		<input type="hidden" name="otherAssistanceUnit[]" class="otherAssistanceUnit" value="<?php echo $unitId; ?>" />
		<?php echo $suplmntUnit; ?>
	</td>
	<td>
		<input type="hidden" name="otherAssistanceAdvice[]" class="otherAssistanceAdvice" value="<?php echo trim($advice); ?>" />
		<?php echo $advice; ?>
	</td>
	<td>

		<a href="javascript:;"  class="otherAssistanceDlt" id="otherAssistanceDlt_<?php echo $row; ?>" title="Delete">
        <i class="far fa-trash-alt" style="color: #d04949;; font-weight:700;"></i>
        </a>
	</td>
</tr>