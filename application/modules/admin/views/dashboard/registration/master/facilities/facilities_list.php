<script src="<?php echo base_url();?>assets/js/customJs/registraion/main_package.js"></script>
<section class="layout-box-content-format1">

<div class="card card-primary">
    <div class="card-header box-shdw">
      <h3 class="card-title">Package Facilities</h3>
       <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >
      <a href="<?php echo admin_with_base_url(); ?>package/addeditfacilities" class="btn btn-default btnpos">
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
              <th width="20%">Title </th>
              <th  width="10%">Free/Not Free</th>    
              <th  width="10%">Actual Rate</th>  
              <th width="10%">Rate Off/(in %)</th>                                  
              <th width="10%">GST Chargable</th>  
              <th width="10%">Action</th>
                                  
              </tr>
          </thead>
          <tbody>

           <?php $i=1;
           foreach($couponlist as $couponlist){ ?>
                <tr id="row_<?php echo $couponlist->coupon_id; ?>">
                <td><?php echo $i++; ?></td>
                <td><?php echo $couponlist->coupon_title; ?></td>
                <td><?php echo $couponlist->rate_type; ?></td>
                <td><?php echo $couponlist->actual_rate; ?></td>
                <td><?php echo $couponlist->price_off_rate; ?></td>
                <td><?php echo $couponlist->is_gstchargble; ?></td>
               
               
                <td>
                <a href="<?php echo admin_with_base_url(); ?>package/addeditfacilities/<?php echo $couponlist->coupon_id; ?>" class="btn tbl-action-btn padbtn"> <i class="fas fa-edit"></i>  </a>
                <button class="btn tbl-action-btn padbtn" style="padding:2px 7px 2px 7px;margin-left: 12px;" id="facilitiesdel" data-delid="<?php echo $couponlist->coupon_id; ?>"> <i class="fas fa-trash"></i>  </button>
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