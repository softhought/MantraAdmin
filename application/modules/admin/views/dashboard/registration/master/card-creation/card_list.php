<script src="<?php echo base_url();?>assets/js/customJs/registraion/main_package.js"></script>
<section class="layout-box-content-format1">

<div class="card card-primary">
    <div class="card-header box-shdw">
      <h3 class="card-title">Package Card(s)</h3>
       <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >
      <a href="<?php echo admin_with_base_url(); ?>Packagecardcreation/addeditcard" class="btn btn-default btnpos">
       <i class="fas fa-plus"></i> Add</a>
    </div>
     
      
    </div><!-- /.card-header -->
   
    <div class="card-body">   


      <div class="formblock-box">
      <!-- <div style="text-align: center;display:none;" id="loader">
           <img src="<?php echo base_url(); ?>assets/img/loader.gif" width="90" height="90" id="gear-loader" style="margin-left: auto;margin-right: auto;"/>
           <span style="color: #bb6265;">Loading...</span>
       </div> -->

      <div id="quickenquiry_list">
        <table  class="table customTbl table-bordered table-hover dataTable tablepad">
          <thead>
          <tr>
              <th width="6%">Sl.No</th> 
              <th width="8%">Card Code </th>
              <th  width="20%">Card Desc</th>    
              <th  width="10%">Package Type</th>  
              <th width="10%">Active Days</th>                                  
              <th width="10%">Ext. Days</th>  
              <th width="9%">Basic Fees</th>  
              <th width="9%">Tax Fees</th>  
              <th width="10%">Active</th>  
              <th width="20%">Active For Website</th>  
              <th width="12%">Time Slot</th>  
              <th width="10%">Ref. Point</th>  
              <th width="10%">Action</th>
                                  
              </tr>
          </thead>
          <tbody>

           <?php $i=1;
           foreach($cardlist as $cardlist){

            $time_slot= $cardlist->FROM_TIME."-".$cardlist->TO_TIME;

            if($cardlist->package_card_type=="M")
						{
							$packtype =  "<b>Mother<b>";

						}else if($cardlist->package_card_type=="C")
						{
							$packtype = "<b>Child<b>";
						}else{ $packtype =  "";}
             
             ?>
                <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo $cardlist->CARD_CODE; ?></td>
                <td><?php echo $cardlist->CARD_DESC; ?></td>
                <td><?php echo $packtype; ?></td>
                <td><?php echo $cardlist->CARD_ACTIVE_DAYS; ?></td>
                <td><?php echo $cardlist->EXTENSION_DAYS; ?></td>
                <td><?php echo $cardlist->BASIC_FEE; ?></td>
                <td><?php echo $cardlist->TAX_FEE; ?></td>
                <td align="center">
                    <?php if($cardlist->IS_ACTIVE == 'Y'){ ?>
                    <a href="<?php echo admin_with_base_url(); ?>packagecardcreation/inactivecard/<?php echo $cardlist->CARD_ID; ?>/ACT" class="btn tbl-action-btn padbtn" style="font-size: 15px;padding: 2px 6px 2px 2px;">
                    <i class="fa fa-check"></i> 
                  </a>
                    <?php }else{ ?>
                      <a href="<?php echo admin_with_base_url(); ?>packagecardcreation/activecard/<?php echo $cardlist->CARD_ID; ?>/ACT" class="btn tbl-action-btn padbtn" style="font-size: 16px;padding: 2px 8px 2px 4px;">
                    <i class="fa fa-times"></i> 
                    <?php } ?>
                    </td>
                    <td align="center">
                    <?php if($cardlist->WEB_ACTIVE == 'Y'){ ?>
                    <a href="<?php echo admin_with_base_url(); ?>packagecardcreation/inactivecard/<?php echo $cardlist->CARD_ID; ?>/WEB" class="btn tbl-action-btn padbtn" style="font-size: 15px;padding: 2px 6px 2px 2px;">
                    <i class="fa fa-check"></i> 
                  </a>
                    <?php }else{ ?>
                      <a href="<?php echo admin_with_base_url(); ?>packagecardcreation/activecard/<?php echo $cardlist->CARD_ID; ?>/WEB" class="btn tbl-action-btn padbtn" style="font-size: 16px;padding: 2px 8px 2px 4px;">
                    <i class="fa fa-times"></i> 
                    <?php } ?>
                    </td>
                <td><?php echo $time_slot; ?></td>
                <td><?php echo $cardlist->point; ?></td>
               
               
                <td>
                <a href="<?php echo admin_with_base_url(); ?>Packagecardcreation/addeditcard/<?php echo $cardlist->CARD_ID; ?>" class="btn tbl-action-btn padbtn"> <i class="fas fa-edit"></i>  </a>
               
                </td>
                </tr>       

           <?php } ?>

          
          </tbody>
        </table>
     </div>
    </div>

    </div><!-- /.card-body -->
</div><!-- /.card -->
</section>