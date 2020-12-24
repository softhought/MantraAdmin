<script src="<?php echo base_url();?>assets/js/customJs/account/corporate_company.js"></script>



<section class="layout-box-content-format1">

        <div class="card card-primary">

                      <div class="card-header box-shdw">
                        <h3 class="card-title">Corporate Company </h3>
                        <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >
                        <a href="<?php echo admin_with_base_url(); ?>corporatecompany" class="btn btn-info btnpos">
                        <i class="fas fa-clipboard-list"></i> List </a>
                          </div>           
                      </div><!-- /.card-header -->



                    <form name="groupnameFrom" id="groupnameFrom" enctype="multipart/form-data">
                    <input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>">
                    <input type="hidden" name="corporateCompanyId" id="corporateCompanyId" value="<?php echo $corporateCompanyId; ?>">
                  <div class="card-body">



                    <div class="formblock-box">
                        <h3 class="form-block-subtitle"><i class="fas fa-angle-double-right"></i>Corporate Company  Info</h3>                          
                              <div class="row">
                              <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                      <label for="groupname">Company Name*
                                      <span id="company_name_err" style="color:red;font-weight:bold;"></span></label>
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">
                                          <input type="text" class="form-control" name="company_name" id="company_name" placeholder="Enter Company Name" value="<?php if($mode == 'EDIT'){ echo $corporateCompanyEditdata->company_name; } ?>">
                                      </div>
                                    </div>                        
                                    </div> 
                                         
                                </div>

                              <div class="row">
                              <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                      <label for="groupname">GISTN*
                                      <span id="subgroup_name_err" style="color:red;font-weight:bold;"></span></label>
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">
                                          <input type="text" class="form-control" name="gistn_no" id="gistn_no" placeholder="Enter GSTIN" value="<?php if($mode == 'EDIT'){ echo $corporateCompanyEditdata->gistn_no; } ?>">
                                      </div>
                                    </div>                        
                                    </div> 
                
                                </div>

                            
                              <div class="row">
                              <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                      <label for="groupname">Address*
                                      <span id="subgroup_name_err" style="color:red;font-weight:bold;"></span></label>
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">
                                     <textarea class="form-control" name="address" id="address"><?php if($mode == 'EDIT'){ echo $corporateCompanyEditdata->address; } ?></textarea>
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
                            <button type="submit" class="btn btn-sm action-button" id="companysavebtn" style="width: 60%;"><?php echo $btnText; ?></button>
                              <span class="btn btn-sm action-button loaderbtn" id="loaderbtn" style="display:none;width: 60%;"><?php echo $btnTextLoader; ?></span>

                           </div>               
                   </div>                 
                 </div>





             </form>

       

         

        </div><!-- /.card -->


  </section>

  



