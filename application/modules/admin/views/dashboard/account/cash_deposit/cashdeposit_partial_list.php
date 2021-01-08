<table class="table customTbl table-bordered table-hover dataTable tablepad">
          <thead>
              <tr>
              <th>Sl.No</th>
              <th>Branch</th> 
              <th>Date</th>  
              <th>Deposit Amount</th>  
              <th>Action</th>
                                  
              </tr>
          </thead>
          <tbody>

          <?php $i=1;
          foreach ($cashdepositlist as $cashdepositlist) { ?>
            <tr id="cash_deposit_<?php echo $i; ?>">
            <td><?php echo $i; ?></td>
            <td><?php echo $cashdepositlist->BRANCH_NAME; ?></td>                    
            <td><?php if($cashdepositlist->date_of_deposit != ""){ echo date('d-m-Y',strtotime($cashdepositlist->date_of_deposit)); } ?></td>                <td><?php echo $cashdepositlist->deposit_amt; ?></td>  
                  
          
                    
            <td align="center">
              <a href="<?php echo admin_with_base_url(); ?>cashdeposit/addeditcashdeposit/<?php echo $cashdepositlist->tran_id; ?>" class="btn tbl-action-btn padbtn">
            <i class="fas fa-edit"></i> 
          </a>

          <a href="javascript:;" class="btn tbl-action-btn padbtnn cashdepositdelete" id="<?php echo $i; ?>" data-cashdepositid="<?php echo $cashdepositlist->tran_id; ?>" data-voucherid="<?php echo $cashdepositlist->voucher_id; ?>" title="Delete">
                    <i class="far fa-trash-alt" ></i></a>
        
              
            </td>


          </tr>
          <?php $i++; } ?>                       
                  
          </tbody>
        </table>