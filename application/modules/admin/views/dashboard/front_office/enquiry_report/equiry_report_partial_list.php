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
              <th  style="width:70px;">dob</th> 
              <th  style="width:70px;">Age</th> 
              <th  style="width:80px;">Email</th>  
              
              <th  style="width:60px;">Pin</th>  
              <th  style="width:80px;">Location</th>  
              <th style="width:100px;">Address</th>  
              <th style="width:80px;">Follow-Up Date</th>               
              <th style="width:200px;">Remarks</th>  
              <th style="width:60px;">Status</th>  
              <th style="width:80px;">Caller</th>              
              
                                  
              </tr>
          </thead>
          <tbody>

          <?php $i=1; 
          $open_stat=0;
          $clos_stat=0;
          $not_interested=0;
                
          foreach($enquirylist as $enquirylist){
            $closing="N";
            $total_followup = 0;
                 if ($enquirylist['enqdtl']->IS_OPEN=="Y")
						 {	 $status="Open"; }
						 else { $status="Not Interested";	$closing="Y";	$not_interested=$not_interested+1;			 
                         }
                         
                         if ($enquirylist['rowcount']>0)
						 {
							 $status="Close - Converted";
							 $closing="Y";  $clos_stat=$clos_stat+1;
						 }
                         foreach ($enquirylist['followup_count'] as $followup_count){
                            $total_followup+=1;
                         }

                         if($enquirylist['enqdtl']->age > 0){
                              $mem_age = $enquirylist['enqdtl']->age;
                         }else{
                              $bday = $enquirylist['enqdtl']->dob;
                              $today = date('Y-m-d');
                              $diff = abs(strtotime($today) - strtotime($bday));
                              $years = floor($diff / (365*60*60*24));
                              $mem_age = $years;
                             
                             // $mem_age = $enquirylist->dob;
                         }
                         
                         ?>
                    <tr>
                            <td><?php echo $i++ ?></td>
                            <td><?php echo date('d-m-Y',strtotime($enquirylist['enqdtl']->enq_date)); ?></td>
                            <td> 
                            <?php echo $enquirylist['enqdtl']->ENQ_NO; ?>                            
                            </td>
                            <td><?php echo $enquirylist['enqdtl']->for_the_wing; ?></td>
                            <td><?php echo $enquirylist['enqdtl']->BRANCH_NAME; ?></td>
                            
                         
                            <td><?php echo $enquirylist['enqdtl']->FIRST_NAME.' '.$enquirylist['enqdtl']->LAST_NAME; ?></td>
                            <td><?php echo $enquirylist['enqdtl']->MOBILE1; ?></td>
                            <td><?php if($enquirylist['enqdtl']->dob != ""){ echo date('d-m-Y',strtotime($enquirylist['enqdtl']->dob)); } ?></td>
                            <td><?php echo $mem_age; ?></td>
                            <td><?php echo $enquirylist['enqdtl']->EMAIL; ?></td>
                            <td><?php echo $enquirylist['enqdtl']->pin_code; ?></td>
                            <td><?php echo $enquirylist['enqdtl']->pin_location; ?></td>
                            <td><?php echo $enquirylist['enqdtl']->ADDRESS; ?></td>
                            <td><?php echo date('d-m-Y',strtotime($enquirylist['enqdtl']->followup_date)); ?></td>
                          
                            <td><?php echo $enquirylist['enqdtl']->enq_remarks; ?></td>
                            <td><?php echo $status; ?></td>
                            <td><?php echo $enquirylist['enqdtl']->caller_name; ?></td>
                            
                           
                           
                      </tr>
     <?php  }  ?>
          
          </tbody>
        </table>

