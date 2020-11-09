
<section class="layout-box-content-format1">

        <div class="card card-primary">
            <div class="card-header box-shdw">
              <h3 class="card-title">Company List</h3>
               <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >
              <a href="<?php echo admin_with_base_url(); ?>createcompany/addeditcompany" class="btn btn-default btnpos">
               <i class="fas fa-plus"></i> Add </a>
            </div>
             
              
            </div><!-- /.card-header -->
           
            <div class="card-body">   

              <div class="formblock-box">
              <div style="text-align: center;display:none;" id="loader">
                   <img src="<?php echo base_url(); ?>assets/img/loader.gif" width="90" height="90" id="gear-loader" style="margin-left: auto;margin-right: auto;"/>
                   <span style="color: #bb6265;">Loading...</span>
               </div>

               <div id="bookinglistid">
                <table class="table customTbl table-bordered table-hover dataTable tablepad">
                  <thead>
                      <tr>
                      <th>Sl.No</th>
                      <th>Registration No.</th>
                      <th>Company Name</th>
                      <th>Short Name</th>  
                      <th>Mobile No.</th>  
                      <th>Email</th>  
                      <th>Status</th>  
                      <th>Action</th>
                                          
                      </tr>
                  </thead>
                  <tbody>

                  <?php $i=1;
                  foreach ($companylist as $companylist) { ?>
                    <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo $companylist->registration_no; ?></td>                    
                    <td><?php echo $companylist->company_name; ?></td>
                    <td><?php echo $companylist->short_name; ?></td>
                    <td><?php echo $companylist->company_phone; ?></td>
                    <td><?php echo $companylist->company_email; ?></td>
                   
                    <td align="center">
                    <?php if($companylist->is_active == 'Y'){ ?>
                    <a href="<?php echo admin_with_base_url(); ?>createcompany/inactivecompany/<?php echo $companylist->comany_id; ?>" class="btn tbl-action-btn padbtn" style="font-size: 15px;padding: 2px 6px 2px 2px;">
                    <i class="fa fa-check"></i> 
                  </a>
                    <?php }else{ ?>
                      <a href="<?php echo admin_with_base_url(); ?>createcompany/activecompany/<?php echo $companylist->comany_id; ?>" class="btn tbl-action-btn padbtn" style="font-size: 16px;padding: 2px 8px 2px 4px;">
                    <i class="fa fa-times"></i> 
                    <?php } ?>
                    </td>
                    <td align="center">
                      <a href="<?php echo admin_with_base_url(); ?>createcompany/addeditcompany/<?php echo $companylist->comany_id; ?>" class="btn tbl-action-btn padbtn">
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