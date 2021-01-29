<script src="<?php echo base_url();?>assets/js/customJs/front_office/emailmatter.js"></script>



<section class="layout-box-content-format1">

        <div class="card card-primary">

                      <div class="card-header box-shdw">
                        <h3 class="card-title">Email Matter</h3>
                        <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >
                        <a href="<?php echo admin_with_base_url(); ?>smsmatter" class="btn btn-info btnpos">
                        <i class="fas fa-clipboard-list"></i> List </a>
                          </div>           
                      </div><!-- /.card-header -->



                    <form name="emailnameFrom" id="emailnameFrom" enctype="multipart/form-data">
                    <input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>">
                    <input type="hidden" name="emailmatterId" id="emailmatterId" value="<?php echo $emailmatterId; ?>">
                  <div class="card-body">



                    <div class="formblock-box">
                        <h3 class="form-block-subtitle"><i class="fas fa-angle-double-right"></i>Emailmatter Info</h3>                          
                              <div class="row">
                              <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                      <label for="groupname">Email Title *
                                      <span id="account_name_err" style="color:red;font-weight:bold;"></span></label>
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">
                                          <input type="text" class="form-control" name="email_title" id="email_title" placeholder="Enter email title" value="<?php if($mode == 'EDIT'){ echo $emailmatterEditdata->email_title; } ?>" autocomplete="off">
                                      </div>
                                    </div>                        
                                    </div> 
                                         
                                </div>
                               

                              

                                <div class="row">
                              <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                      <label for="groupname">Email Matter</label>
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">
                                        <textarea  class="form-control" style="width: 300px;" autocomplete="off" name="email_matter" id="email_matter"><?php if($mode == 'EDIT'){ echo $emailmatterEditdata->email_matter; } ?></textarea>
                                         
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
                            <button type="submit" class="btn btn-sm action-button" id="emailmattersavebtn" style="width: 60%;"><?php echo $btnText; ?></button>
                              <span class="btn btn-sm action-button loaderbtn" id="loaderbtn" style="display:none;width: 60%;"><?php echo $btnTextLoader; ?></span>

                           </div>               
                   </div>                 
                 </div>





             </form>

       

         

        </div><!-- /.card -->


  </section>

  



