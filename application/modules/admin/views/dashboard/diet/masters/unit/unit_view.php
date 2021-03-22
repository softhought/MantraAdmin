<script src="<?php echo base_url();?>assets/js/customJs/front_office/youtube_video.js"></script>

<section class="layout-box-content-format1">



        <div class="card card-primary">

            <div class="card-header box-shdw">

              <h3 class="card-title">Unit List </h3>

               <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >

              <a href="<?php echo admin_with_base_url(); ?>diet/addUnit/" class="btn btn-default btnpos">

               <i class="fas fa-plus"></i> Add </a>

            </div>

             

              

            </div><!-- /.card-header -->

           

            <div class="card-body">

              <div class="formblock-box">

              <table id="corporatecompanylist" class="table customTbl table-bordered table-hover  tablepad">

                <thead >
						<tr>
							<th width="35">Sl</th>
						
							<th>Unit</th>
							<th width="40" align="right">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php $sl=1;
							foreach($rowFoodUnit as $rowFoodUnit){?>
						<tr>
							<td><?php echo $sl++; ?></td>
						
							<td><?php echo $rowFoodUnit->unit_name; ?></td>
							<td align="center">
							
                  <a href="<?php echo admin_with_base_url(); ?>diet/addUnit/<?php echo $rowFoodUnit->id; ?>" class="btn tbl-action-btn padbtn">

                  <i class="fas fa-edit"></i> 

                </a>
							</td>
						</tr>
						<?php } ?>
					</tbody>
              </table>

            </div>



            </div><!-- /.card-body -->

        </div><!-- /.card -->

   </section>