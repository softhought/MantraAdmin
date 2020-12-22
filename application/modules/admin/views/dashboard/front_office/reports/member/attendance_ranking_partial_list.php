<table  class="table customTbl table-bordered table-hover dataTable tablepad">
          <thead>
          <tr>
              <th width="6%">Sl.No</th> 
              <th  width="10%">Membership No</th>
              <th width="15%">Name </th>             
              <th  width="10%">Mobile No.</th>  
              <th  width="12%">Validity String</th> 
              <th width="7%">Present Days</th>                         
              <!-- <th width="10%">Action</th> -->
                                  
              </tr>
          </thead>
          <tbody>

          <?php
		$j=1;
		foreach($attendancerankinglist as $attendancerankinglist){			
		?>
		<tr>
			<td><?php echo $j++;?></td>
			<td><?php echo $attendancerankinglist['MEMBERSHIP_NO'];?></td>
			<td><?php echo $attendancerankinglist['CUS_NAME'];?></td>
			<td><?php echo $attendancerankinglist['CUS_PHONE'];?></td>
			<td><?php echo $attendancerankinglist['validty'];?></td>
			<td><?php echo $attendancerankinglist['daysAttn'];?></td>
		
	

		</tr>
		
        <?php } ?>
          
          </tbody>
        </table>