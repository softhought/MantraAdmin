<!-- <script src="<?php echo base_url();?>assets/js/customJs/front_office/quick_enquiry.js"></script> -->
<section class="layout-box-content-format1">

<div class="card card-primary">
    <div class="card-header box-shdw">
      <h3 class="card-title">Main Package</h3>
       <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >
      <a href="<?php echo admin_with_base_url(); ?>package/addeditmainpackage" class="btn btn-default btnpos">
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
              <th width="10%">Start Letter </th>
              <th  width="10%">Package Name</th>    
              <th  width="10%">Banner Image</th>                                    
              <th width="10%">Status</th>
              <th width="10%">Action</th>
                                  
              </tr>
          </thead>
          <tbody>

           <?php $i=1;
           foreach($productlist as $productlist){ ?>
                <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo $productlist->start_letter; ?></td>
                <td><?php echo $productlist->category_name; ?></td>
               
                <td>
                <?php if($productlist->banner_img != ''){ ?>
                    <img src="<?php echo siteURL(); ?>/images/products/<?php echo($productlist->banner_img);?>" style="width:180px;">
                <?php  } ?>
                </td>
                <td align="center">
                    <?php if($productlist->is_active_web_menu == 'Y'){ ?>
                    <a href="<?php echo admin_with_base_url(); ?>package/inactivemainpackage/<?php echo $productlist->id; ?>" class="btn tbl-action-btn padbtn" style="font-size: 15px;padding: 2px 6px 2px 2px;">
                    <i class="fa fa-check"></i> 
                  </a>
                    <?php }else{ ?>
                      <a href="<?php echo admin_with_base_url(); ?>package/activemainpackage/<?php echo $productlist->id; ?>" class="btn tbl-action-btn padbtn" style="font-size: 16px;padding: 2px 8px 2px 4px;">
                    <i class="fa fa-times"></i> 
                    <?php } ?>
                    </td>
                <td><a href="<?php echo admin_with_base_url(); ?>package/addeditmainpackage/<?php echo $productlist->id; ?>" class="btn tbl-action-btn padbtn"> <i class="fas fa-edit"></i>  </a></td>
                </tr>       

           <?php } ?>

          
          </tbody>
        </table>
     </div>
    </div>

    </div><!-- /.card-body -->
</div><!-- /.card -->
</section>