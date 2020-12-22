<table id="calling_list" class="table customTbl table-bordered table-hover dataTable2 tablepad">
          <thead>
              <tr>
              <th style="width:55px;">Sl.No</th>              
              <th style="width:90px;">Enquiry Date</th>
              <th style="width:90px;">Enquiry No.</th>
              <th style="width:90px;">Wing</th>
              <th style="width:60px;">Branch</th>
              <th style="width:100px;">Name </th>             
              <th  style="width:70px;">Mobile No.</th>  
              <th  style="width:80px;">Email</th>  
              <th  style="width:60px;">Pin</th>  
              <th  style="width:80px;">Location</th>  
              <th style="width:100px;">Address</th>  
              <th style="width:60px;">Follow-Up</th>  
              <th style="width:200px;">Remarks</th>  
              <th style="width:60px;">Status</th>  
              <th style="width:80px;">Caller</th>              
              <th style="width:150px;">Action</th>
                                  
              </tr>
          </thead>
          <tbody>

          <?php $i=1;
                
          foreach($enquirylist as $enquirylist){
            $closing="N";
                 if ($enquirylist['enqdtl']->IS_OPEN=="Y")
						 {	 $status="Open"; }
						 else { $status="Not Interested";	$closing="Y";				 
                         }
                         
                         if ($enquirylist['rowcount']>0)
						 {
							 $status="Close - Converted";
							 $closing="Y";
						 }

                         
                         ?>
                    <tr>
                            <td><?php echo $i++ ?></td>
                            <td><?php echo date('d-m-Y',strtotime($enquirylist['enqdtl']->enq_date)); ?></td>
                            <td> 
                            <?php echo $enquirylist['enqdtl']->ENQ_NO; ?><br>
                            <?php if ($closing=="N") { ?>
                                  
                                <a href="javascript:void(0);" data-id="<?php echo $enquirylist['enqdtl']->enq_id; ?>" class="addFeedback hidebtn_<?php echo $enquirylist['enqdtl']->enq_id; ?>" style="margin-left: 30px;"> <img src="<?php echo base_url(); ?>assets/img/add_icon.png" width="30" height="30" /></a> 

                                  <a href="javascript:void(0);" data-toggle="modal" data-id="<?php echo $enquirylist['enqdtl']->enq_id; ?>" data-target="#feedbackList" class="feedbackList hidebtn_<?php echo $enquirylist['enqdtl']->enq_id; ?>"><img src="<?php echo base_url(); ?>assets/img/dtl_view.png" width="30" height="30" /></a> 
                                <?php  }?>
                            
                            </td>
                            <td><?php echo $enquirylist['enqdtl']->BRANCH_NAME; ?></td>
                            <td><?php echo $enquirylist['enqdtl']->for_the_wing; ?></td>
                         
                            <td><?php echo $enquirylist['enqdtl']->FIRST_NAME.' '.$enquirylist['enqdtl']->LAST_NAME; ?></td>
                            <td><?php echo $enquirylist['enqdtl']->MOBILE1; ?></td>
                            <td><?php echo $enquirylist['enqdtl']->EMAIL; ?></td>
                            <td><?php echo $enquirylist['enqdtl']->pin_code; ?></td>
                            <td><?php echo $enquirylist['enqdtl']->pin_location; ?></td>
                            <td><?php echo $enquirylist['enqdtl']->ADDRESS; ?></td>
                            <td><?php echo date('d-m-Y',strtotime($enquirylist['enqdtl']->followup_date)); ?></td>
                            <td><?php echo $enquirylist['enqdtl']->enq_remarks; ?></td>
                            <td><?php echo $status; ?></td>
                            <td><?php echo $enquirylist['enqdtl']->caller_name; ?></td>
                            <td class="">
                            <?php if ($closing=="N") { ?>
                            <a href="javascript:void(0);" data-toggle="modal" data-id="<?php echo $enquirylist['enqdtl']->enq_id; ?>" data-target="#addFeedback" class="btn btn-block action-button btn-sm addFeedback hidebtn_<?php echo $enquirylist['enqdtl']->enq_id; ?>" id="feedbackbtn" style="width: 59%;margin-right: 8px;float: left;font-size: .675rem;">Feedback</a>


                          <a href="<?php echo admin_with_base_url(); ?>enquiry/addeditenquiry/<?php echo $enquirylist['enqdtl']->enq_id; ?>" class="btn tbl-action-btn padbtn hidebtn_<?php echo $enquirylist['enqdtl']->enq_id; ?>"> <i class="fas fa-edit"></i>  </a>
                            <br>
                          <a href="javascript:void(0);" class="btn btn-block action-button btn-sm hidebtn_<?php echo $enquirylist['enqdtl']->enq_id; ?>" id="closeenquiry" style="width: 85%;margin-right: 8px;margin-top: 3px;font-size: .675rem;" data-id="<?php echo $enquirylist['enqdtl']->enq_id; ?>">Not Interested</a>
                            <?php } ?>
                           </td>
                      </tr>
     <?php  }  ?>
          
          </tbody>
        </table>

