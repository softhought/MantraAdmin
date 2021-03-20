
<br>
 <?php if($dataAdvise){ ?>

   
  <h3 class="form-block-subtitle formsubtitle"><i class="fas fa-angle-double-right"></i>Disease Nutrition Guidelines </h3>                          
   <?php } ?>
        <div class="card" style="margin-bottom: .5rem!important;">
              
              <!-- /.card-header -->
              <div class="card-body">
                <div id="accordion" class="accordionCard2">
         	<?php $sl=1;
         	 for($i=0;$i<count($dataAdvise);$i++){  ?>
                  <div class="card card-danger advAccor" id="<?php echo $i; ?>">
                  	<a data-toggle="collapse" data-parent="#accordion" href="#collapseAdv_<?php echo $i; ?>" class="" aria-expanded="true">
                    <div class="card-header" style="cursor: pointer;">
                      <h4 class="card-title">
                        
                         <?php echo $sl++.". ";
                         echo $dataAdvise[$i]->disease; ?>
                       
                      </h4>
                    </div> </a>

                    <div id="collapseAdv_<?php echo $i; ?>" class="panel-collapse collapse" >
                      <div class="card-body ">
                      	<div class="callout callout-warning" style="margin-top:5px;">
                        <?php echo $dataAdvise[$i]->disease_guidelines; ?>
                        </div>
                      </div>
                    </div>
                  </div>
                   <?php } ?>
             
                </div>
              </div>
              <!-- /.card-body -->
            </div>
             <input type="hidden" name="advide_count" id="advide_count" value="<?php echo $i;?>"> 


