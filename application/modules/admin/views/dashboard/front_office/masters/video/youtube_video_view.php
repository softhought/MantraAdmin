<script src="<?php echo base_url();?>assets/js/customJs/front_office/youtube_video.js"></script>

<section class="layout-box-content-format1">



        <div class="card card-primary">

            <div class="card-header box-shdw">

              <h3 class="card-title">Youtube Video List </h3>

               <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >

              <a href="<?php echo admin_with_base_url(); ?>youtubevideo/addVideo" class="btn btn-default btnpos">

               <i class="fas fa-plus"></i> Add </a>

            </div>

             

              

            </div><!-- /.card-header -->

           

            <div class="card-body">

              <div class="formblock-box">

              <table id="corporatecompanylist" class="table customTbl table-bordered table-hover  tablepad">

                <thead>

                    <tr>

                    <th>Sl.No</th>
                    <th>Video Title</th>
                    <th>Video URL</th>
                    <th>Video For</th>
                    <th>Status</th>
                    <th>Action</th>

                                        

                    </tr>

                </thead>

                <tbody>



                <?php $i=1;

                foreach ($videoList as $videolist) { 


               
                  
                  ?>

                   <tr>

                   <td><?php echo $i++; ?></td>

                   <td><?php echo $videolist->videotitle; ?></td>

                   <td> <a href="<?php echo $videolist->videolink; ?>" target="_blank"><?php echo $videolist->videolink; ?></a> </td>
                 
						      <td><?php if($videolist->showtag=='A'){
                    echo "ALL";
                  }else if($videolist->showtag=='G'){
                    echo "Video Gallary";
                  }else if($videolist->showtag=='T'){
                    echo "Testimonial";
                  }else if($videolist->showtag=='N'){
                    echo "Nutritation";
                  }  ?></td>
                  
                   <td>
                    	<?php  if ($videolist->is_active=='Y') { ?>
                               
                                   <button class="btn btn-sm action-button actinct actibtn videostatus" data-setstatus="N"  data-videoid="<?php echo $videolist->id; ?>" >Active</button>
                                                                
                            <?php }else{ ?>
                              
                                    <button class="btn btn-sm action-button actinct inactbtn videostatus" data-setstatus="Y" data-videoid="<?php echo $videolist->id; ?>">Inactive</button>
                               
                            <?php } ?>
                    </td>
                        <td>

                     <a href="<?php echo admin_with_base_url(); ?>youtubevideo/addVideo/<?php echo $videolist->id; ?>" class="btn tbl-action-btn padbtn">

                  <i class="fas fa-edit"></i> 

                </a>

                    

                  </td>





                 </tr>

                <?php } ?>                       

                         

                </tbody>
                  <tfoot>

                           <tr>

                     

                           <th></th>

                           <th></th>

                           <th></th>

                           <th></th>

                           <th></th>
                         

                           </tr>

              </table>

            </div>



            </div><!-- /.card-body -->

        </div><!-- /.card -->

   </section>