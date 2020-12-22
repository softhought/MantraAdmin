<table  class="table customTbl table-bordered table-hover dataTable2 tablepad">
          <thead>
          <tr>
          <th style="width:55px;">Sl.No</th>              
              <th style="width:90px;">Enquiry Date</th>
              <th style="width:90px;">Enquiry No.</th>
              <!-- <th style="width:90px;">Wing</th> -->
              <th style="width:60px;">Branch</th>
              <th style="width:100px;">Name </th>             
              <th  style="width:70px;">Mobile No.</th>  
              <th  style="width:80px;">Email</th>  
              <!-- <th  style="width:60px;">Pin</th>  
              <th  style="width:80px;">Location</th>   -->
              <th style="width:100px;">Address</th>  
              <th style="width:60px;">Follow-Up</th>  
              <th style="width:200px;">Remarks</th>  
              <!-- <th style="width:60px;">Status</th>   -->
              <!-- <th style="width:80px;">Caller</th>               -->
              
              </tr>
          </thead>
          <tbody>

          <?php
		$i=1;
		foreach($specialenquirylist as $specialenquirylist){			
		?>
	<tr>
                            <td><?php echo $i++ ?></td>
                            <td><?php echo date('d-m-Y',strtotime($specialenquirylist->enq_date)); ?></td>
                            <td> 
                            <?php echo $specialenquirylist->ENQ_NO; ?><br>
                           
                                  
                                <a href="javascript:void(0);" data-id="<?php echo $specialenquirylist->enq_id; ?>" class="addFeedback hidebtn_<?php echo $specialenquirylist->enq_id; ?>" style="margin-left: 30px;"> <img src="<?php echo base_url(); ?>assets/img/add_icon.png" width="30" height="30" /></a> 

                                  <a href="javascript:void(0);" data-toggle="modal" data-id="<?php echo $specialenquirylist->enq_id; ?>" data-target="#feedbackList" class="feedbackList hidebtn_<?php echo $specialenquirylist->enq_id; ?>"><img src="<?php echo base_url(); ?>assets/img/dtl_view.png" width="30" height="30" /></a> 
                                
                            
                            </td>
                            <!-- <td><?php echo $specialenquirylist->for_the_wing; ?></td> -->
                            <td><?php echo $specialenquirylist->BRANCH_NAME; ?></td>
                           
                         
                            <td><?php echo $specialenquirylist->FIRST_NAME.' '.$specialenquirylist->LAST_NAME; ?></td>
                            <td><?php echo $specialenquirylist->MOBILE1; ?></td>
                            <td><?php echo $specialenquirylist->EMAIL; ?></td>
                            <!-- <td><?php echo $specialenquirylist->pin_code; ?></td>
                            <td><?php echo $specialenquirylist->pin_location; ?></td> -->
                            <td><?php echo $specialenquirylist->ADDRESS; ?></td>
                            <td><?php echo date('d-m-Y',strtotime($specialenquirylist->followup_date)); ?></td>
                            <td><?php echo $specialenquirylist->enq_remarks; ?></td>
                            <!-- <td><?php echo $status; ?></td> -->
                            <!-- <td><?php echo $specialenquirylist->caller_name; ?></td> -->
                           
                      </tr>
        <?php } ?>
          
          </tbody>
        </table>