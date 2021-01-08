<tr id="rowcarddetails_<?php echo $rowno; ?>">
   <td>
       
      <?php echo $rowno; ?>
      </td>
   <td>
       <input type="hidden" name="dr_cr_tag_dtl[]" id="dr_cr_tag_dtl_<?php echo $rowno; ?>" value="<?php echo $dr_cr_tag; ?>">

              
       <?php echo $dr_cr_tag; ?>
   </td>
   <td>
        <input type="hidden" name="account_id_dtl[]" id="account_id_dtl_<?php echo $rowno; ?>" value="<?php echo $account_id; ?>">
     
       <?php echo $account_name; ?>
   </td>
   <td>
       <input type="hidden" name="pay_to_id_dtl[]" id="pay_to_id_dtl_<?php echo $rowno; ?>" value="<?php echo $pay_to_id; ?>">
       <?php if($pay_to_id != "") { echo $pay_to_name; }else{ echo ""; } ?>
   </td>
   <td>
   <input type="hidden" name="pay_month_dtl[]" id="pay_month_dtl_<?php echo $rowno; ?>" value="<?php echo $pay_month; ?>">
       <?php if($pay_month != ""){  echo $pay_month; }else{ echo ""; } ?>
   </td>
   <td>
   <input type="hidden" class="listamounted" name="amountdtl[]" id="amountdtl_<?php echo $rowno; ?>" value="<?php echo $amount; ?>">
       <?php echo $amount; ?>
   </td>
   <td>
       <a href="javascript:;" class="editvoucherDetails" id="delDocRow_<?php echo $rowno; ?>" title="Edit">
      <i class="far fa-edit" style="color: #2a92d4;font-weight:700;padding-right: 6px;"></i></a>

      <a href="javascript:;" class="delvoucherDetails" id="delDocRow_<?php echo $rowno; ?>" title="Delete">
      <i class="far fa-trash-alt" style="color: #d04949;; font-weight:700;"></i></a>
   </td>
</tr>