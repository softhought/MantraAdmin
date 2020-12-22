
<table  class="table customTbl table-bordered table-hover dataTable tablepad">
          <thead>
          <tr>
              <th width="6%">Sl.No</th> 
              <th  width="10%">Membership No</th>
              <th width="15%">Name </th>             
              <th  width="10%">Mobile No.</th>  
              <th  width="12%">Validity String</th> 
              <th width="12%">Last Attendance Date</th>                         
              <th width="10%">Action</th>
                                  
              </tr>
          </thead>
          <tbody>
          <?php $i = 1;          
                foreach($zeroattendancelist as $zeroattendancelist){ 
                    
                    if($zeroattendancelist->totalcalling<10)
                        {
                            $total_cal = "0".$zeroattendancelist->totalcalling;
                        }
                        else
                        {
                            $total_cal = $zeroattendancelist->totalcalling;
                        }
          ?>
             <tr>
             <td><?php echo  $i++;   ?></td>
             <td><?php echo  $zeroattendancelist->membership_no;   ?></td>
             <td><?php echo  $zeroattendancelist->customer_name;   ?></td>
             <td><?php echo  $zeroattendancelist->customer_phone;   ?></td>
             <td><?php echo  $zeroattendancelist->validitystring;   ?></td>
             <td><?php echo  $zeroattendancelist->last_attd;   ?></td>
             <td>
                 <?php if( $zeroattendancelist->totalcalling > 0){ ?>
                   <div data-toggle="modal" data-id="<?php echo $zeroattendancelist->customer_id; ?>" data-mode="Feedback" data-target="#addFeedback" class="addFeedback" style="margin-left: 0px;cursor:pointer;float:left;"> 
							<i class="fa fa-comments enq-add-icon" aria-hidden="true"></i>
					</div> 
                 <?php }else{ ?>

                   <div data-toggle="modal" data-id="<?php echo $zeroattendancelist->customer_id; ?>" data-mode="Enquiry" data-target="#addFeedback" class="addFeedback" style="margin-left: 0px;cursor:pointer;float:left;"> 
							<i class="fa fa-plus enq-add-icon" aria-hidden="true"></i>
					</div> 
                 <?php } ?> 
             
                   <div  data-toggle="modal" data-id="<?php echo $zeroattendancelist->customer_id; ?>" data-target="#feedbackList" class="feedbackList enq-count-notify-dv">
								<span class="count-enq"><?php echo $total_cal;  ?></span>
								<i class="fa fa-bell bell-icon-enq" aria-hidden="true" style="float:left;"></i>
							</div> 
             
             </td>
            
            
             </tr>




                <?php } ?>
          
          </tbody>
        </table>