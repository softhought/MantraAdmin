<section class="layout-box-content-format1">


        <div class="card card-primary">

<div class="table-responsive">

   
           
           <span class="badge badge-danger" style="float:left;font:12px;">Membership No : <?php echo $membership_no;?></span>
           <span class="badge badge-warning" style="float:right;font:12px;">Validity: <?php echo $validity;?></span>
         
        
   

                   <div id="discount_list_data" class="formblock-box">
                      <table class="table customTbl table-bordered table-striped dataTable ">
                <thead>

                   <th >Sl</th>
                   <th >Payment Date</th>
					<th >Amount</th>
					<th >Mode</th>
					<th >GST</th>
					<th >Action</th>



                </thead>

                <tbody>

                <?php $i=1;$rowno=1; 

                if ($rowPayment) {
                  foreach($rowPayment as $row_pmt)
							{
                 
                ?>
                 <tr>          <td><?php echo $i++;?></td>
								<td align="left"><?php echo(date("d-m-Y",strtotime($row_pmt->PAYMENT_DT)));?></td>
								<td align="right"><?php echo(number_format($row_pmt->AMOUNT,2));?></td>
								<td align="left"><?php echo($row_pmt->PAYMENT_MODE);?></td>
								<td align="left"><?php echo($row_pmt->IS_GST);?></td>
								<td>

                                 <a  href="<?php echo admin_with_base_url(); ?>motherpackage/receiptpdf/<?php echo $row_pmt->PAYMENT_ID; ?>/<?php echo $row_pmt->CUST_ID; ?>" target="_blank"  >
                              <span class="badge badge-success">Recipt</span> 
                                  </a>

								</td>    
								
							</tr>
               <?php $rowno++;} }?>
                </tbody>



              </table>
                   </div>


</div>


</div>
</section>

