<table  class="table customTbl table-bordered table-hover dataTable2 tablepad">
          <thead>
              <tr>
              <th style="width:55px;">Sl.No</th>              
              <th style="width:90px;">Reg. Date</th>
              <th style="width:90px;">Pament Date</th>
              <th style="width:90px;">Mem. No</th>            
              <th style="width:120px;">Name </th> 
              <!-- <th style="width:60px;">Branch</th>             -->
              <th style="width:150px;">Validity</th>  
              <th  style="width:80px;">Email</th>            
              <th  style="width:80px;">Gender</th>            
              <th  style="width:150px;">Phone/WhatsApp No.</th>
              <th  style="width:60px;">RCPT</th>  
              <th  style="width:120px;">Trainer</th>  
              <th  style="width:80px;">Closed By</th>  
              <th style="width:100px;">Done By</th>  
              <th style="width:60px;">GST</th>  
              <th style="width:200px;">Action</th>  
                         
             
                                  
              </tr>
          </thead>
          <tbody>
                <?php $i=1;
                foreach ($motherackagelist as $motherackagelist) {
                    
                 ?>

                 <tr>
                 <td><?php echo $i++; ?></td>
                 <td><?php if($motherackagelist->REGISTRATION_DT != "") { echo date('d-m-Y',strtotime($motherackagelist->REGISTRATION_DT)); } ?></td>
                 <td><?php if($motherackagelist->PAYMENT_DT != "") { echo date('d-m-Y',strtotime($motherackagelist->PAYMENT_DT)); } ?></td>
                 <td><?php echo $motherackagelist->MEMBERSHIP_NO; ?></td>
                 <td><?php echo $motherackagelist->CUS_NAME; ?></td>
                 <td><?php echo date('d-m-Y',strtotime($motherackagelist->FROM_DT)).' To '.date('d-m-Y',strtotime($motherackagelist->EXPIRY_DT)); ?></td>
                 <td><?php echo $motherackagelist->CUS_EMAIL; ?></td>
                 <td><?php echo $motherackagelist->CUS_SEX; ?></td>
                 <td><?php echo $motherackagelist->CUS_PHONE;if($motherackagelist->whatsup_number != ""){ echo ' / '.$motherackagelist->whatsup_number; } ?></td>
                 <td><?php echo $motherackagelist->RCPT_NO; ?></td>
                 <td><?php echo $motherackagelist->Trainer; ?></td>
                 <td><?php echo $motherackagelist->closedByName; ?></td>
                 <td><?php echo $motherackagelist->doneByName; ?></td>
                 <td><?php echo $motherackagelist->IS_GST; ?></td>
                 <td>
                 <a class="btn btn-block action-button btn-sm" href="<?php echo admin_with_base_url(); ?>motherpackage/receiptpdf/<?php echo $motherackagelist->PAYMENT_ID; ?>/<?php echo $motherackagelist->CUS_ID; ?>" target="_blank" style="width: 32%;font-size:12px;float:left;" >Recipt</a>
                 <a class="btn action-button btn-sm" href="<?php echo admin_with_base_url(); ?>motherpackage/printwelletter/<?php echo $motherackagelist->CUS_ID; ?>"  target="_blank" style="width: 65%;font-size:12px;float:right;">Welcome Letter</a>
                 </td>
                 </tr>

            <?php } ?>


          
          </tbody>
        </table>