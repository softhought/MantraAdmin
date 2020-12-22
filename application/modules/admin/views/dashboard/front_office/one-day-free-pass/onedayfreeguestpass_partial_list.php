<table  class="table customTbl table-bordered table-hover dataTable2 tablepad">
          <thead>
          <tr>
          <th width="6%">Sl.No</th> 
              <th width="15%">Name </th>
              <th  width="10%">Mobile No.</th>    
              <th  width="10%">Enquiry Date</th>
              <th  width="12%">Gym Location</th> 
              <th width="7%">Email</th>                         
              <th width="22%">Comments</th> 
              <th width="12%">Action</th>
              </tr>
          </thead>
          <tbody>

          <?php
		$j=1;
		foreach($freeguestpasslist as $freeguestpasslist){			
		?>
		<tr>
			<td><?php echo $j++;?></td>
			<td><?php echo $freeguestpasslist->first_name.' '.$freeguestpasslist->last_name;?></td>
			<td><?php echo $freeguestpasslist->contactno;?></td>
			<td><?php if($freeguestpasslist->date_of_entry != ""){ echo  date('d-m-Y',strtotime($freeguestpasslist->date_of_entry)); } ?></td>
			<td><?php echo $freeguestpasslist->BRANCH_NAME;?></td>
			<td><?php echo $freeguestpasslist->emailid;?></td>
			<td><?php echo $freeguestpasslist->comment;?></td>			
			<td>
      <?php if($freeguestpasslist->is_called == 'N'){ ?>
       <a href="<?php echo admin_with_base_url(); ?>enquiry/addeditenquiry/<?php echo encode('ONE DAY FREE GUEST PASS') ?>/<?php echo $freeguestpasslist->id; ?>/<?php echo $freeguestpasslist->gym_location; ?>"  class="btn btn-block action-button btn-sm" style="width: 59%;margin-right: 8px;float: left;font-size: .675rem;">Calling</a>
      <?php } ?>
       </td>
		
		
	

		</tr>
		
        <?php } ?>
          
          </tbody>
        </table>