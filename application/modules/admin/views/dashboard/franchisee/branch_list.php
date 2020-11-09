
<section class="layout-box-content-format1">

<div class="card card-primary">
    <div class="card-header box-shdw">
      <h3 class="card-title">Branch List</h3>
       <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >
      <a href="<?php echo admin_with_base_url(); ?>createbranch/addeditbranch" class="btn btn-default btnpos">
       <i class="fas fa-plus"></i> Add </a>
    </div>
     
      
    </div><!-- /.card-header -->
   
    <div class="card-body">   

      <div class="formblock-box">
      <div style="text-align: center;display:none;" id="loader">
           <img src="<?php echo base_url(); ?>assets/img/loader.gif" width="90" height="90" id="gear-loader" style="margin-left: auto;margin-right: auto;"/>
           <span style="color: #bb6265;">Loading...</span>
       </div>

       <div id="">
        <table class="table customTbl table-bordered table-hover dataTable tablepad">
          <thead>
              <tr>
              <th width="5%">Sl.No</th>
              <th>Branch Name</th>
              <th width="10%">Branch Code</th>
              <th>Company Name</th>
              <th>Branch Address</th>
              <th width="8%">GST No.</th>
              <th width="8%">Phone No.</th>
              <th width="10%">Contact Person</th>
              <th width="8%">Status</th>  
              <th width="8%">Action</th>
                                  
              </tr>
          </thead>
          <tbody>

          <?php $i=1;
          foreach ($branchlist as $branchlist) { ?>
            <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo $branchlist->BRANCH_NAME; ?></td>                    
            <td><?php echo $branchlist->BRANCH_CODE; ?></td>
            <td><?php echo $branchlist->company_name; ?></td>
            <td><?php echo $branchlist->branch_address; ?></td>
            <td><?php echo $branchlist->gst_no; ?></td>
            <td><?php echo $branchlist->company_contact; ?></td>
            <td><?php echo $branchlist->contact_person; ?></td>
            <td align="center">
                    <?php if($branchlist->is_active == 'Y'){ ?>
                    <a href="<?php echo admin_with_base_url(); ?>createbranch/inactivebranch/<?php echo $branchlist->BRANCH_ID; ?>" class="btn tbl-action-btn padbtn" style="font-size: 15px;padding: 2px 6px 2px 2px;">
                    <i class="fa fa-check"></i> 
                  </a>
                    <?php }else{ ?>
                      <a href="<?php echo admin_with_base_url(); ?>createbranch/activebranch/<?php echo $branchlist->BRANCH_ID; ?>" class="btn tbl-action-btn padbtn" style="font-size: 16px;padding: 2px 8px 2px 4px;">
                    <i class="fa fa-times"></i> 
                    <?php } ?>
                    </td>
           
            <td align="center">
              <a href="<?php echo admin_with_base_url(); ?>createbranch/addeditbranch/<?php echo $branchlist->BRANCH_ID; ?>" class="btn tbl-action-btn padbtn">
            <i class="fas fa-edit"></i> 
          </a>
        
              
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