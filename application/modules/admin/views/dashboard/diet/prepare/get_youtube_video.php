
<br>
 <?php if($dataVideo){ ?>

   
  <h3 class="form-block-subtitle formsubtitle"><i class="fas fa-angle-double-right"></i>Nutrition Youtube Video </h3>                          
   <?php } ?>
        <div class="card" style="margin-bottom: .5rem!important;">
        <?php
          $sl=1;
              foreach ($dataVideo as $datavideo) {
              
        ?>
                 <div class="row" >
                          <div class="col-md-6" >
                      <?php echo $sl++;?>.<span class="badge badge-secondary"><?php echo $datavideo->videotitle;?></span>   <a id="wplink" href="https://api.whatsapp.com/send?text=<?php echo $datavideo->videolink;?>" target="_blank" > &nbsp; <img src="<?php echo base_url(); ?>assets/img/wp.png" width="20" height="20" /></a>

                          </div>    

                          </div>   
          <?php } ?>
              </div>
              <!-- /.card-body -->
            
             


