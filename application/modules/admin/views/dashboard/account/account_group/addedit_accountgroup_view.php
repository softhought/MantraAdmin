<script src="<?php echo base_url();?>assets/js/customJs/account/account_group.js"></script>



<section class="layout-box-content-format1">

        <div class="card card-primary">

                      <div class="card-header box-shdw">
                        <h3 class="card-title">Account Group</h3>
                        <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >
                        <a href="<?php echo admin_with_base_url(); ?>accountgroup" class="btn btn-info btnpos">
                        <i class="fas fa-clipboard-list"></i> List </a>
                          </div>           
                      </div><!-- /.card-header -->



                    <form name="groupnameFrom" id="groupnameFrom" enctype="multipart/form-data">
                    <input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>">
                    <input type="hidden" name="groupId" id="groupId" value="<?php echo $groupId; ?>">
                  <div class="card-body">



                    <div class="formblock-box">
                        <h3 class="form-block-subtitle"><i class="fas fa-angle-double-right"></i>Account Group Info</h3>                          
                              <div class="row">
                              <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                      <label for="groupname">Group Name *
                                      <span id="group_name_err" style="color:red;font-weight:bold;"></span></label>
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">
                                          <input type="text" class="form-control" name="groupname" id="groupname" placeholder="Enter Group Name" value="<?php if($mode == 'EDIT'){ echo $accountgroupEditdata->group_description; } ?>">
                                      </div>
                                    </div>                        
                                    </div> 
                                         
                                </div>
                                <div class="row">
                                <?php $cat1=array("Balance Sheet","Profit & Loss","Trading");
                                $cat1 = array('B' => "Balance Sheet",'P' => "Profit & Loss",'T' => "Trading"); ?>
                                <div class="col-md-4"></div>
                                   <div class="col-md-4">
                                        <label for="companyname">First Category *</label>
                                        <div class="form-group">
                                        <div class="input-group input-group-sm" id="first_cat_drp">
                                            <select class="form-control select2" id="sel_grp_cat1" name="sel_grp_cat1" style="width: 100%;">
                                            <option value='0'>Select</option>
                                            <?php foreach ($cat1 as $key => $value) {
                                            ?>
                                                <option value='<?php echo $key; ?>'
                                                 <?php if($mode == 'EDIT' && $accountgroupEditdata->b_p_t == $key){ echo "selected"; } ?>>
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
                                        <label for="companyname">Second Category *</label>
                                        <div class="form-group">
                                        <div class="input-group input-group-sm" id="second_cat_drp">
                                            <select class="form-control select2" id="sel_grp_cat2" name="sel_grp_cat2" style="width: 100%;">
                                           <?php 

                                             $cat2 = array('A' => 'Asset','L' => 'Liability','I' => 'Income','E' => 'Expenditure' );
                                             $cat2Value=$accountgroupEditdata->a_l_i_e;
                                            if (array_key_exists($cat2Value,$cat2))
                                              {                                           
                                            ?>
                                           <option value='<?php echo $cat2Value;?>'><?php echo $cat2[$cat2Value];?></option>
                                           <?php }?>
                                           <?php if($mode=='ADD'){?>
                                            <option value='0'>Select</option>
                                           <?php }?>
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
                            <button type="submit" class="btn btn-sm action-button" id="accgroupsavebtn" style="width: 60%;"><?php echo $btnText; ?></button>
                              <span class="btn btn-sm action-button loaderbtn" id="loaderbtn" style="display:none;width: 60%;"><?php echo $btnTextLoader; ?></span>

                           </div>               
                   </div>                 
                 </div>





             </form>

       

         

        </div><!-- /.card -->


  </section>

  



