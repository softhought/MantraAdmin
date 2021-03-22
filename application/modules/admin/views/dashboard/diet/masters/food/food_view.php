<script src="<?php echo base_url();?>assets/js/customJs/front_office/youtube_video.js"></script>

<section class="layout-box-content-format1">



        <div class="card card-primary">

            <div class="card-header box-shdw">

              <h3 class="card-title">Food List </h3>

               <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >

              <a href="<?php echo admin_with_base_url(); ?>food/addFood" class="btn btn-default btnpos">

               <i class="fas fa-plus"></i> Add </a>

            </div>

             

              

            </div><!-- /.card-header -->

           

            <div class="card-body">

              <div class="formblock-box">

              <table id="corporatecompanylist" class="table customTbl table-bordered table-hover  tablepad">

                <thead >
						<tr>
							<th >Sl</th>
					    	<th>Food Type</th>
							<th>Category</th>
							<th>Food Name</th>
							<th>Quantity</th>
							<th>Unit</th>
							<th>Calorie</th>
							<th>Protein (gm.)</th>
							<th>Carbo. (gm.)</th>
							<th>Fat (gm.)</th>
							<th>GI</th>
							<th width="40" align="right">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php $sl=1;
							foreach($rowFoodMaster as $food_master){?>
						<tr>
							<td><?php echo $sl++; ?></td>
							<td><?php echo $food_master->food_type_name; ?></td>
							<td><?php echo $food_master->category; ?></td>
							<td><?php echo $food_master->food_name; ?></td>
							<td><?php echo $food_master->food_qty; ?></td>
							<td><?php echo $food_master->unit_name; ?></td>
							<td align="center"><?php echo $food_master->calorie; ?></td>
							<td align="center"><?php echo $food_master->protein; ?></td>
							<td align="center"><?php echo $food_master->carbohydrate; ?></td>
							<td align="center"><?php echo $food_master->fat; ?></td>
							<td align="center"><?php echo $food_master->glucose_index; ?></td>
							<td align="center">
							
                  <a href="<?php echo admin_with_base_url(); ?>food/addFood/<?php echo $food_master->foodMasterID; ?>" class="btn tbl-action-btn padbtn">

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