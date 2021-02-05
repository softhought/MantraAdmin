<!-- <script src="<?php echo base_url();?>assets/js/customJs/account/reports/daily_collection.js"></script> -->
<table  class="table customTbl table-bordered table-hover dataTable tablepad">
          <thead>
              <tr>
              <th width="3%">#</th>              
              <th width="8%">Date</th>
              <th width="8%">Cash Opening</th>
              <th width="8%">Cash Coll.</th>
              <th width="8%">Cash Rcvd</th>
              <th width="8%">Chq. Coll. </th>             
              <th width="8%">Card Coll.</th>  
              <th width="8%">Payment Gateway</th>  
              <th width="8%">Fund Transfer</th>  
              <th width="8%">Ref Pbl.</th>  
              <th width="8%">Tot. Cash</th>  
              <th >Today's Coll.</th>  
              <th width="8%">Cash Dep.</th>  
              <th width="8%">Cash Exp.</th>  
              <th width="8%">Ref. Paid</th>              
              <th width="11%">Bal. Cash</th>
                                  
              </tr>
          </thead>
          <tbody>
            <?php $i= 1;
            foreach($daliytcollectionlist as $daliytcollectionlist){ ?>

            <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo $daliytcollectionlist['coll_date']; ?></td>
            <td align="right"><?php echo $daliytcollectionlist['cash_open']; ?></td>
            <td align="right">
            <a href="javascript:void(0);" data-toggle="modal" data-paymentmode="Cash" data-collectiondt="<?php echo $daliytcollectionlist['coll_date']; ?>" data-target="#dailycollectionlistmodel" class="dispdailycoll"    style="color: black;text-decoration: underline red 2px;"><?php echo $daliytcollectionlist['cash_coll']; ?></a>
            
            </td>
            <td align="right">
            <a href="javascript:void(0);" data-toggle="modal" data-paymentmode="Cash Rcvd" data-collectiondt="<?php echo $daliytcollectionlist['coll_date']; ?>" data-target="#dailycollectionlistmodel" class="dispdailycoll"  style="color: black;text-decoration: underline red 2px;" ><?php echo $daliytcollectionlist['cash_rcvd']; ?></a>
           
            </td>
            <td align="right">
            <a href="javascript:void(0);" data-toggle="modal" data-paymentmode="Cheque" data-collectiondt="<?php echo $daliytcollectionlist['coll_date']; ?>" data-target="#dailycollectionlistmodel" class="dispdailycoll"   style="color: black;text-decoration: underline red 2px;" ><?php echo $daliytcollectionlist['chq_coll']; ?></a>
           
            </td>
            <td align="right">
            <a href="javascript:void(0);" data-toggle="modal" data-paymentmode="Card" data-collectiondt="<?php echo $daliytcollectionlist['coll_date']; ?>" data-target="#dailycollectionlistmodel" class="dispdailycoll"   style="color: black;text-decoration: underline red 2px;" ><?php echo $daliytcollectionlist['card_coll']; ?></a>
            
            </td>
            <td align="right">
            <a href="javascript:void(0);" data-toggle="modal" data-paymentmode="ONP" data-collectiondt="<?php echo $daliytcollectionlist['coll_date']; ?>" data-target="#dailycollectionlistmodel" class="dispdailycoll"   style="color: black;text-decoration: underline red 2px;" ><?php echo $daliytcollectionlist['online_payment_col']; ?></a>
            
            </td>
            <td align="right">
            <a href="javascript:void(0);" data-toggle="modal" data-paymentmode="Fund Transfer" data-collectiondt="<?php echo $daliytcollectionlist['coll_date']; ?>" data-target="#dailycollectionlistmodel" class="dispdailycoll"   style="color: black;text-decoration: underline red 2px;" ><?php echo $daliytcollectionlist['fund_transfer_col']; ?></a>
            
            </td>
            <td align="right"><?php echo $daliytcollectionlist['ref_pbl']; ?></td>
            <td align="right"><?php echo $daliytcollectionlist['tot_cash']; ?></td>
            <td align="right"><?php echo $daliytcollectionlist['todaysColl']; ?></td>
            <td align="right"><?php echo $daliytcollectionlist['cash_deposit']; ?></td>
            <td align="right">
            <a href="javascript:void(0);" data-toggle="modal" data-paymentmode="Cash Exp" data-collectiondt="<?php echo $daliytcollectionlist['coll_date']; ?>" data-target="#dailycollectionlistmodel" class="dispdailycoll"   style="color: black;text-decoration: underline red 2px;" ><?php echo $daliytcollectionlist['cash_exp']; ?></a>
           
            </td>
            <td align="right"><?php echo $daliytcollectionlist['ref_paid']; ?></td>
            <td align="right"><?php echo $daliytcollectionlist['bal_cash']; ?></td>
            
            </tr>

            <?php } ?>
          
          </tbody>
        </table>