<script src="<?php echo base_url();?>assets/js/customJs/account/account.js"></script>



<section class="layout-box-content-format1">

        <div class="card card-primary">

                      <div class="card-header box-shdw">
                        <h3 class="card-title">Account Group</h3>
                        <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >
                        <a href="<?php echo admin_with_base_url(); ?>account" class="btn btn-info btnpos">
                        <i class="fas fa-clipboard-list"></i> List </a>
                          </div>           
                      </div><!-- /.card-header -->



                    <form name="groupnameFrom" id="groupnameFrom" enctype="multipart/form-data">
                    <input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>">
                    <input type="hidden" name="accountId" id="accountId" value="<?php echo $accountId; ?>">
                  <div class="card-body">



                    <div class="formblock-box">
                        <h3 class="form-block-subtitle"><i class="fas fa-angle-double-right"></i>Account Info</h3>                          
                              <div class="row">
                              <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                      <label for="groupname">Account Name *
                                      <span id="account_name_err" style="color:red;font-weight:bold;"></span></label>
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">
                                          <input type="text" class="form-control" name="account_name" id="account_name" placeholder="Enter Account Name" value="<?php if($mode == 'EDIT'){ echo $accountEditdata->account_description; } ?>" autocomplete="off">
                                      </div>
                                    </div>                        
                                    </div> 
                                         
                                </div>
                                <div class="row">
                                <div class="col-md-4"></div>
                                   <div class="col-md-4">
                                        <label for="companyname">Sub Group *</label>
                                        <div class="form-group">
                                        <div class="input-group input-group-sm" id="sub_group_err">
                                            <select class="form-control select2" id="select_sub_group" name="select_sub_group" style="width: 100%;">
                                            <option value='0'>Select</option>
                                            <?php foreach ($subGroupList as  $value) {
                                            ?>
                                                <option value='<?php echo $value->sub_group_id; ?>'
                                                 <?php if($mode == 'EDIT' && $accountEditdata->sub_group_id == $value->sub_group_id){ echo "selected"; } ?>>
                                                <?php echo $value->sub_group_desc; ?></option>
                                            <?php } ?>
                                            </select>
                                      
                                        </div>
                                    </div>
                                </div> 
                                </div>

                                <div class="row">
                              <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                      <label for="groupname">Opening Balance</label>
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">
                                          <input type="text" class="form-control" name="opening_balance" id="opening_balance" placeholder="Enter Opening balance" value="<?php if($mode == 'EDIT'){ echo $openingBalance; } ?>" autocomplete="off">
                                      </div>
                                    </div>                        
                                    </div> 
                                         
                                </div>

                                <div class="row">
                              <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                      <label for="groupname">Address</label>
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">
                                        <textarea  class="form-control" style="width: 300px;" autocomplete="off" name="account_addr" id="account_addr"><?php if($mode == 'EDIT'){ echo $accountEditdata->account_description; } ?></textarea>
                                         
                                      </div>
                                    </div>                        
                                    </div> 
                                         
                                </div>
                                    <div class="row">
                                <div class="col-md-4"></div>
                                   <div class="col-md-4">
                                        <label for="companyname">State</label>
                                        <div class="form-group">
                                        <div class="input-group input-group-sm" >
                                            <select class="form-control select2" id="select_state" name="select_state" style="width: 100%;">
                                            <option value='0'>Select</option>
                                            <?php foreach ($stateList as  $value) {
                                            ?>
                                                <option value='<?php echo $value->id; ?>'
                                                 <?php if($mode == 'EDIT' && $accountEditdata->state_id == $value->id){ echo "selected"; } ?>>
                                                <?php echo $value->state; ?></option>
                                            <?php } ?>
                                            </select>
                                      
                                        </div>
                                    </div>
                                </div> 
                                </div>
                                   <div class="row">
                              <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                      <label for="groupname">GSTIN</label>
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">
                                         <input type="text" class="form-control" name="gst_in" id="gst_in" placeholder="Enter GSTIN" value="<?php if($mode == 'EDIT'){ echo $accountEditdata->gstin; } ?>" autocomplete="off">
                                      </div>
                                    </div>                        
                                    </div> 
                                         
                                </div>

                                    <div class="row">
                              <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                      <label for="groupname">Pan</label>
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">
                                         <input type="text" class="form-control" name="pan_no" id="pan_no" placeholder="Enter PAN No" value="<?php if($mode == 'EDIT'){ echo $accountEditdata->panno; } ?>" autocomplete="off">
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
                            <button type="submit" class="btn btn-sm action-button" id="accountsavebtn" style="width: 60%;"><?php echo $btnText; ?></button>
                              <span class="btn btn-sm action-button loaderbtn" id="loaderbtn" style="display:none;width: 60%;"><?php echo $btnTextLoader; ?></span>

                           </div>               
                   </div>                 
                 </div>





             </form>

       

         

        </div><!-- /.card -->


  </section>

  



