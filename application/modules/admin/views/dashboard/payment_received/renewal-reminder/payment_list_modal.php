<table id="userAuditTable" class="table customTbl table-bordered table-hover dataTable">
                <thead>
                    <tr>
                    <th>Sl No.</th>
                    <th>Membership No.</th>
                    <th>Payment Mode</th>
                    <th>Payment Date</th>
                    <th>Amount</th>                   
                    </tr>

                </thead>

                <tbody> 
                  <?php $i = 1;
                  
                   foreach($paymentdata as $paymentdata){
                         
                 
                  ?>
                  <tr>
                  <td><?php echo $i++; ?></td>
                  <td><?php echo $paymentdata->MEMBERSHIP_NO; ?></td>
                  <td><?php echo $paymentdata->PAYMENT_MODE; ?></td>
                  <td><?php echo $paymentdata->PAYMENT_DT; ?></td>
                  <td><?php echo $paymentdata->AMOUNT; ?></td>
                  </tr>

                   <?php } ?>

                </tbody>
                </table>