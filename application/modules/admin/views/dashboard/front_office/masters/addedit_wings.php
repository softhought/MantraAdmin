<script src="<?php echo base_url();?>assets/js/customJs/front_office/enq_wing.js"></script>

<section class="layout-box-content-format1">
        <div class="card card-primary">
            <div class="card-header box-shdw">
              <h3 class="card-title"><?php echo $mode; ?> Wings</h3>
               <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >
                   <a href="<?php echo admin_with_base_url(); ?>enquirywing" class="btn btn-info btnpos link_tab">
                  <i class="fas fa-clipboard-list"></i> List </a>
                </div>
           
            </div><!-- /.card-header -->
            <div class="card-body">
               <form name="WingsForm"  id="WingsForm" enctype="multipart/form-data"> 

               <input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>">
                <input type="hidden" name="wingId" id="wingId" value="<?php echo $wingId; ?>">

                <div class="formblock-box">   
                         
                           <div class="row">   
                           <div class="col-md-3">
                                    <label for="category">Wing Category*</label>
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                        <select class="form-control select2" id="category" name="category" style="width: 100%;">
                                                <option value=''>Select</option>
                                                <?php foreach($wingcatlist as $wingcatlist){ ?>
                                                <option value='<?php echo $wingcatlist->cat_id; ?>' <?php if($mode == 'EDIT' && $wingEditdata->wing_category_id == $wingcatlist->cat_id){ echo "selected"; } ?>>
                                                <?php echo $wingcatlist->category_name; ?>
                                                </option>
                                                <?php } ?>
                                            
                                                </select>
                                        </div>
                                        </div>
                                    </div>                           
                                <div class="col-md-3">
                                        <label for="wing_name">Wings Name*</label>
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">                                           
                                          <input type="text" class="form-control forminputs typeahead inputupper" id="wing_name" name="wing_name" placeholder="Enter Wing Name" autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $wingEditdata->wing_name;  }  ?>">
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-md-3">
                                    <label for="short_desc">Short Description</label>
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control forminputs typeahead" id="short_desc" name="short_desc" placeholder="Enter Short Description" autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $wingEditdata->short_description;  }  ?>">

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
                                <button type="submit" class="btn btn-sm action-button" id="wingsavebtn" style="width: 57%;"><?php echo $btnText; ?></button>

                                    <span class="btn btn-sm action-button loaderbtn" id="loaderbtn" style="display:none;width: 57%;"><?php echo $btnTextLoader; ?></span>

                                </div>
                            </div>
                    </div>
                    </form>
                               
         </div>
</div><!-- /.card-body -->

</section>