<script src="<?php echo base_url();?>assets/js/customJs/account/account_sub_group.js"></script>



<section class="layout-box-content-format1">

        <div class="card card-primary">

                      <div class="card-header box-shdw">
                        <h3 class="card-title">Account Sub Group</h3>
                        <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >
                        <a href="<?php echo admin_with_base_url(); ?>accountsubgroup" class="btn btn-info btnpos">
                        <i class="fas fa-clipboard-list"></i> List </a>
                          </div>           
                      </div><!-- /.card-header -->



                    <form name="groupnameFrom" id="groupnameFrom" enctype="multipart/form-data">
                    <input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>">
                    <input type="hidden" name="subgroupId" id="subgroupId" value="<?php echo $subgroupId; ?>">
                  <div class="card-body">



                    <div class="formblock-box">
                        <h3 class="form-block-subtitle"><i class="fas fa-angle-double-right"></i>Account Sub Group Info</h3>                          
                              <div class="row">
                              <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                      <label for="groupname">Sub Group*
                                      <span id="subgroup_name_err" style="color:red;font-weight:bold;"></span></label>
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">
                                          <input type="text" class="form-control" name="subgroupname" id="subgroupname" placeholder="Enter Sub Group Name" value="<?php if($mode == 'EDIT'){ echo $subgroupEditdata->sub_group_desc; } ?>">
                                      </div>
                                    </div>                        
                                    </div> 
                                         
                                </div>
                                <div class="row">
                           
                                <div class="col-md-4"></div>
                                   <div class="col-md-4">
                                        <label for="companyname">Group</label>
                                        <div class="form-group">
                                        <div class="input-group input-group-sm" id="sel_group_err">
                                            <select class="form-control select2" id="sel_group" name="sel_group" style="width: 100%;">
                                            <option value='0'>Select</option>
                                            <?php foreach ($groupList as  $value) {
                                            ?>
                                                <option value='<?php echo $value->group_id; ?>'
                                                 <?php if($mode == 'EDIT' && $subgroupEditdata->group_id == $value->group_id){ echo "selected"; } ?>>
                                                <?php echo $value->group_description; ?></option>
                                            <?php } ?>
                                            </select>
                                      
                                        </div>
                                    </div>
                                </div> 
                                </div>
                                 
                                

                      </div>



                    </div>  <!-- /.card-body -->



               <div class="formblock-box">
                   <div class="row">
                          <div class="col-md-10">                    
                          <p id="errormsg" class="errormsgcolor"></p>
                          </div>
                         <div class="col-md-2 text-right">
                            <button type="submit" class="btn btn-sm action-button" id="subgroupsavebtn" style="width: 60%;"><?php echo $btnText; ?></button>
                              <span class="btn btn-sm action-button loaderbtn" id="loaderbtn" style="display:none;width: 60%;"><?php echo $btnTextLoader; ?></span>

                           </div>               
                   </div>                 
                 </div>





             </form>

       

         

        </div><!-- /.card -->


  </section>

  



