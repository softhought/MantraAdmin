<table  class="table customTbl table-bordered table-hover dataTable2 tablepad">
          <thead>
          <tr>
               <th style="width:55px;">Sl.No</th> 
              <th style="width:150px;">Name </th>
              <th  style="width:100px;">Mobile No.</th>    
              <th style="width:120px;">Enquiry Date</th>
              <th  style="width:120px;">Branch</th> 
              <th style="width:150px;">Email</th>                         
              <th style="width:200px;">Comments</th>                         
              <th style="width:120px;">Help Category</th>                         
              <th style="width:120px;">Enq. Page</th>                         
              <th style="width:120px;">Action</th>
              </tr>
          </thead>
          <tbody>

          <?php
		$j=1;
		foreach($quickenquirylist as $quickenquirylist){			
		?>
		<tr>
			<td><?php echo $j++;?></td>
			<td><?php echo $quickenquirylist->name;?></td>
			<td><?php echo $quickenquirylist->mobile_no;?></td>
			<td><?php if($quickenquirylist->date_of_entry != ""){ echo  date('d-m-Y',strtotime($quickenquirylist->date_of_entry)); } ?></td>
			<td><?php echo $quickenquirylist->BRANCH_NAME;?></td>
			<td><?php echo $quickenquirylist->emailid;?></td>
			<td><?php echo $quickenquirylist->comments;?></td>
			<td><?php echo $quickenquirylist->help_category;?></td>
			<td><?php echo $quickenquirylist->enq_from;?></td>
			<td>
      <?php if($quickenquirylist->is_called == 'N'){ ?>
       <a href="<?php echo admin_with_base_url(); ?>enquiry/addeditenquiry/<?php echo encode('WEB ENQUIRY') ?>/<?php echo $quickenquirylist->id; ?>/<?php echo $quickenquirylist->branch_id; ?>"  class="btn btn-block action-button btn-sm" style="width: 59%;margin-right: 8px;float: left;font-size: .675rem;">Calling</a>
      <?php } ?>
       </td>
		
		
	

		</tr>
		
        <?php } ?>
          
          </tbody>
        </table>