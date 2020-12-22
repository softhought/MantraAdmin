<tr id="rowcarddetails_<?php echo $rowno; ?>">
   <td>
       
      <?php echo $rowno; ?>
      </td>
   <td>
       <input type="hidden" name="rate_branch_code[]" id="rate_branch_code_<?php echo $rowno; ?>" value="<?php echo $branch_code; ?>">

       <input type="hidden" name="rate_branch_id[]" id="rate_branch_id_<?php echo $rowno; ?>" value="<?php echo $branch; ?>">
        
       <?php echo $branch_name; ?>
   </td>
   <td>
        <input type="hidden" name="package_rate_dtl[]" id="package_rate_dtl_<?php echo $rowno; ?>" value="<?php echo $package_rate; ?>">
     
       <?php echo $package_rate; ?>
   </td>
   <td>
       <input type="hidden" name="renewal_rate_dtl[]" id="renewal_rate_dtl_<?php echo $rowno; ?>" value="<?php echo $renewal_rate; ?>">
       <?php echo $renewal_rate; ?>
   </td>
   <td>
   <input type="hidden" name="discount_rate_dtl[]" id="discount_rate_dtl_<?php echo $rowno; ?>" value="<?php echo $discount_rate; ?>">
       <?php echo $discount_rate; ?>
   </td>
   <td>
       <a href="javascript:;" class="delcardDetails" id="delDocRow_<?php echo $rowno; ?>" title="Delete">
      <i class="far fa-trash-alt" style="color: #d04949;; font-weight:700;"></i></a>
   </td>
</tr>