<?php if($newtrtb == 'Table'){ ?>
   <h3 class="form-block-subtitle"><i class="fas fa-angle-double-right"></i><?php echo $branch_name; ?></h3>
   <input type="hidden" name="srl_no_<?php echo $branch; ?>" id="srl_no_<?php echo $branch; ?>" value="<?php echo $srlNo; ?>">
<table class="table table-bordered" style="font-size: 13px;color: #354668;" id="table_<?php echo $branch; ?>">
  
    <thead>
          <tr>
             <th>#</th>
             <th>Branch</th>
             <th>Facility</th>
             <th>Qty</th>
             <th>Type</th>
             <th>Work Out</th>
             <th>Sub Group</th>
             <th>Action</th>
          </tr>
    </thead>

    <tbody>
<?php } ?>
       <tr id="rowfacilitydetails_<?php echo $rowno; ?>">
          <td><?php echo $srlNo; ?></td>

          <td>
          <input type="hidden" name="card_branch_code[]" id="card_branch_code_<?php echo $rowno; ?>" value="<?php echo $branch_code; ?>">

          <input type="hidden" name="card_branch_id[]" id="card_branch_code_<?php echo $rowno; ?>" value="<?php echo $branch; ?>">

          <input type="hidden" name="card_coupon_id[]" id="card_coupon_id_<?php echo $rowno; ?>" value="<?php echo $facility_id; ?>">
          
             <?php echo $branch_code.'-'.$facility_id; ?>
            
            </td>
          <td><?php echo $facility_name; ?></td>
          <td>
               <input type="hidden" name="carddtl_qty[]" id="carddtl_qty_<?php echo $rowno; ?>" value="<?php echo $qty; ?>">
             <?php echo $qty; ?>
            </td>
          <td>
              <input type="hidden" name="detail_description[]" id="detail_description_<?php echo $rowno; ?>" value="<?php echo $type; ?>">
             <?php echo $type; ?>
            </td>
          <td>
              <input type="hidden" name="sub_description[]" id="sub_description_<?php echo $rowno; ?>" value="<?php echo $work_out; ?>">
             <?php echo $work_out; ?>
            </td>
          <td>
              <input type="hidden" name="grp_for_hf[]" id="grp_for_hf_<?php echo $rowno; ?>" value="<?php echo $sub_group; ?>">
             <?php echo $sub_group; ?>
            </td>
          <td> <a href="javascript:;" class="delfacilityDetails" id="delDocRow_<?php echo $rowno; ?>" title="Delete">
              <i class="far fa-trash-alt" style="color: #d04949;; font-weight:700;"></i></a></td>
       </tr>
       <?php if($newtrtb == 'Table'){ ?>
        
    </tbody>
</table>
<?php } ?>