<script src="<?php echo base_url();?>assets/js/customJs/account/account_mapping.js"></script>



<section class="layout-box-content-format1">

        <div class="card card-primary">

                      <div class="card-header box-shdw">
                        <h3 class="card-title">Account Mapping wiith Branch </h3>
                        <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >
                        <a href="<?php echo admin_with_base_url(); ?>accountmapping" class="btn btn-info btnpos">
                        <i class="fas fa-clipboard-list"></i> List </a>
                          </div>           
                      </div><!-- /.card-header -->



                    <form name="groupnameFrom" id="groupnameFrom" enctype="multipart/form-data">
                    <input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>">
                    <input type="hidden" name="accountmappingId" id="accountmappingId" value="<?php echo $accountmappingId; ?>">
                  <div class="card-body">



                    <div class="formblock-box">
                        <h3 class="form-block-subtitle"><i class="fas fa-angle-double-right"></i>Account Mapping Info</h3>                          
                             <div class="row">
                           
                                <div class="col-md-4"></div>
                                   <div class="col-md-4">
                                        <label for="companyname">Branch
                                         <span id="mapping_err" style="color:red;font-weight:bold;"></span></label>
                                        <div class="form-group">
                                        <div class="input-group input-group-sm" id="sel_branch_err">
                                            <select class="form-control select2" id="sel_branch" name="sel_branch" style="width: 100%;">
                                            <option value='0'>Select</option>
                                            <?php foreach ($rowBranch as  $value) {
                                            ?>
                                                <option value='<?php echo $value->BRANCH_ID; ?>'
                                                 <?php if($mode == 'EDIT' && $branchmappingEditdata->branch_id == $value->BRANCH_ID){ echo "selected"; } ?>>
                                                <?php echo $value->BRANCH_NAME; ?></option>
                                            <?php } ?>
                                            </select>
                                      
                                        </div>
                                    </div>
                                </div> 
                                </div>

                                    <div class="row">
                           
                                <div class="col-md-4"></div>
                                   <div class="col-md-4">
                                        <label for="companyname">Payment Mode</label>
                                        <div class="form-group">
                                        <div class="input-group input-group-sm" id="sel_payment_mode_err">
                                            <select class="form-control select2" id="sel_payment_mode" name="sel_payment_mode" style="width: 100%;">
                                            <option value='0'>Select</option>
                                            <?php foreach ($pmt_mode as  $value) {
                                            ?>
                                                <option value='<?php echo $value; ?>'
                                                 <?php if($mode == 'EDIT' && $branchmappingEditdata->payment_mode == $value){ echo "selected"; } ?>>
                                                <?php echo $value; ?></option>
                                            <?php } ?>
                                            </select>
                                      
                                        </div>
                                    </div>
                                </div> 
                                </div>

                                  <div class="row">
                           
                                <div class="col-md-4"></div>
                                   <div class="col-md-4">
                                        <label for="companyname">Account</label>
                                        <div class="form-group">
                                        <div class="input-group input-group-sm" id="sel_account_err">
                                            <select class="form-control select2" id="sel_account" name="sel_account" style="width: 100%;">
                                            <option value='0'>Select</option>
                                            <?php foreach ($accountList as  $value) {
                                            ?>
                                                <option value='<?php echo $value->account_id; ?>'
                                                 <?php if($mode == 'EDIT' && $branchmappingEditdata->account_id == $value->account_id){ echo "selected"; } ?>>
                                                <?php echo $value->account_description; ?></option>
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
                            <button type="submit" class="btn btn-sm action-button" id="acmappingsavebtn" style="width: 60%;"><?php echo $btnText; ?></button>
                              <span class="btn btn-sm action-button loaderbtn" id="loaderbtn" style="display:none;width: 60%;"><?php echo $btnTextLoader; ?></span>

                           </div>               
                   </div>                 
                 </div>





             </form>

       

         

        </div><!-- /.card -->


  </section>

  



