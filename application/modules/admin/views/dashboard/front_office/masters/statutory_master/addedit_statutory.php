<script src="<?php echo base_url();?>assets/js/customJs/front_office/statutory.js"></script>



<section class="layout-box-content-format1">

        <div class="card card-primary">

            <div class="card-header box-shdw">

              <h3 class="card-title"><?php echo $mode; ?> Statutory</h3>

               <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >

                   <a href="<?php echo admin_with_base_url(); ?>statutorymaster" class="btn btn-info btnpos link_tab">

                  <i class="fas fa-clipboard-list"></i> List </a>

                </div>

           

            </div><!-- /.card-header -->

            <div class="card-body">

               <form name="StatutoryForm"  id="StatutoryForm" enctype="multipart/form-data"> 



               <input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>">

                <input type="hidden" name="statutoryId" id="statutoryId" value="<?php echo $statutoryId; ?>">



                <div class="formblock-box">   

                         

                           <div class="row">   

                                                   

                                <div class="col-md-3">

                                        <label for="wing_name">Statutory Name*</label>

                                        <div class="form-group">

                                        <div class="input-group input-group-sm">                                           

                                          <input type="text" class="form-control forminputs typeahead inputupper" id="statutory_name" name="statutory_name" placeholder="Enter Statutory Name" autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $statutoryEditdata->statutory_name;  }  ?>">

                                        </div>

                                    </div>

                                </div> 

                              



                            </div>

                                                   

                </div>



                    <div class="formblock-box">

                        <div class="row">

                            <div class="col-md-10">

                               <p class="errormsgcolor" id="errormsg"></p>

                            </div>

                                <div class="col-md-2 text-right">

                                <button type="submit" class="btn btn-sm action-button" id="savebtn" style="width: 57%;"><?php echo $btnText; ?></button>



                                    <span class="btn btn-sm action-button loaderbtn" id="loaderbtn" style="display:none;width: 57%;"><?php echo $btnTextLoader; ?></span>



                                </div>

                            </div>

                    </div>

                    </form>

                               

         </div>

</div><!-- /.card-body -->



</section>