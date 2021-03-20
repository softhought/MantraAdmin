<script src="<?php echo base_url();?>assets/js/customJs/front_office/youtube_video.js"></script>



<section class="layout-box-content-format1">

        <div class="card card-primary">

                      <div class="card-header box-shdw">
                        <h3 class="card-title">Youtube Link </h3>
                        <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >
                        <a href="<?php echo admin_with_base_url(); ?>youtubevideo" class="btn btn-info btnpos">
                        <i class="fas fa-clipboard-list"></i> List </a>
                          </div>           
                      </div><!-- /.card-header -->



                    <form name="groupnameFrom" id="groupnameFrom" enctype="multipart/form-data">
                    <input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>">
                    <input type="hidden" name="videoId" id="videoId" value="<?php echo $videoId; ?>">
                  <div class="card-body">



                    <div class="formblock-box">
                        <h3 class="form-block-subtitle"><i class="fas fa-angle-double-right"></i>Video  Info</h3>                          
                              <div class="row">
                              <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                      <label for="groupname">Video Title*
                                      <span id="company_name_err" style="color:red;font-weight:bold;"></span></label>
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">
                                          <input type="text" class="form-control" name="video_title" id="video_title" placeholder="Enter Title" autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $videoEditdata->videotitle; } ?>">
                                      </div>
                                    </div>                        
                                    </div> 
                                         
                                </div>

                              <div class="row">
                              <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                      <label for="groupname">Video URL*
                                      <span id="subgroup_name_err" style="color:red;font-weight:bold;"></span></label>
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">
                                          <input type="text" class="form-control" name="video_url" id="video_url" placeholder="Enter URL" autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $videoEditdata->videolink; } ?>">
                                      </div>
                                    </div>                        
                                    </div> 
                
                                </div>
                            <?php

                              $show_video = array(
                                                  'A' => 'All', 
                                                  'N' => 'Nutritation', 
                                                  'T' => 'Testimonial', 
                                                  'G' => 'Video Gallary', 
                                                );
                            
                            
                            ?>
                            
                              <div class="row">
                              <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                      <label for="groupname">Show
                                      <span id="subgroup_name_err" style="color:red;font-weight:bold;"></span></label>
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">
                                      <select class="form-control select2" id="show_tag" name="show_tag" style="width: 100%;">
                                            <?php
                                                foreach ($show_video as $key => $value) {
                                                
                                            ?>
                                            <option value='<?php echo $key;?>' <?php if($mode == 'EDIT' && $key==$videoEditdata->showtag){ echo "selected"; } ?>><?php echo $value;?></option>
                                          
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
                            <button type="submit" class="btn btn-sm action-button" id="videosavebtn" style="width: 60%;"><?php echo $btnText; ?></button>
                              <span class="btn btn-sm action-button loaderbtn" id="loaderbtn" style="display:none;width: 60%;"><?php echo $btnTextLoader; ?></span>

                           </div>               
                   </div>                 
                 </div>





             </form>

       

         

        </div><!-- /.card -->


  </section>

  



