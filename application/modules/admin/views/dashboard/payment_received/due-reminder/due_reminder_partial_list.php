

<table id="" class="table customTbl table-bordered table-hover dataTable tablepad">
          <thead>
              <tr>
              <th style="width:55px;">Sl.No</th>              
              <th style="width:150px;">Membership No.<br>Validity Pd<br>Mobile No.</th> 
              <th style="width:180px;">Name </th>
              <th style="width:100px;">Package</th>
              <th style="width:100px;">Reg Dt</th>
              <th  style="width:80px;">Payment Dt</th> 
              <th  style="width:150px;">Prm</th>  
               <th style="width:150px;">Paid</th>               
              <th style="width:80px;">Payable Dt <br>Cheque No. <br>Bank<br>Branch</th>  
              <th style="width:80px;">Due</th>  
              <th style="width:80px;">Branch</th>  
              <!-- <th style="width:80px;">Attd</th>   -->
              <th style="width:80px;">Action</th>  
                     
              </tr>
          </thead>
          <tbody>

          <?php $i=0;$total_due=0;
          foreach($duereminderlist as $duereminderlist){
            $total_due+=$duereminderlist->due_pybl_amt;
            
            ?>
          <tr>
          <td><?php echo $i++; ?></td>
          <td>
          <?php  echo $duereminderlist->membershipno; ?>
          <br>
          <?php  echo $duereminderlist->validity_string; ?>
          <br>
          <?php  echo $duereminderlist->CUS_PHONE; ?>
          </td>
          <td><?php  echo $duereminderlist->CUS_NAME; ?></td>
          <td><?php  echo $duereminderlist->CARD_DESC; ?></td>
          <td><?php if($duereminderlist->REGISTRATION_DT != ""){ echo date('d-m-Y',strtotime($duereminderlist->REGISTRATION_DT)); } ?></td>
          <td><?php if($duereminderlist->PAYMENT_DT != ""){ echo date('d-m-Y',strtotime($duereminderlist->PAYMENT_DT)); } ?></td>
          <td><?php  echo $duereminderlist->PRM_AMOUNT; ?></td>
          <td><?php  echo $duereminderlist->AMOUNT; ?></td>
          <td>
          <?php if($duereminderlist->due_pybl_date != ""){ echo date('d-m-Y',strtotime($duereminderlist->due_pybl_date)); } ?>
          <br>
          <?php  echo $duereminderlist->pybl_cheque_no; ?>
          <br>
          <?php  echo $duereminderlist->pybl_bank; ?>
          <br>
          <?php  echo $duereminderlist->pybl_branch; ?>
          </td>
          <td><?php  echo $duereminderlist->due_pybl_amt; ?></td>
          <td><?php  echo $duereminderlist->BRANCH_CODE; ?></td>
          <td><a href="<?php echo admin_with_base_url(); ?>duereminder/duerenewalpayment/<?php echo $duereminderlist->tran_id; ?>"    class="btn btn-block action-button btn-sm" style="font-size:12px;padding: 2px;">Payment</a> </td>
          </tr>
          <?php  } ?>
          
          </tbody>
        </table>

        <input type="hidden" id="total_due" name="total_due" value="<?php echo $total_due; ?>">