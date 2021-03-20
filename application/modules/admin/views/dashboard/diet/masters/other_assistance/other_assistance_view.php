<script src="<?php echo base_url();?>assets/js/customJs/front_office/youtube_video.js"></script>

<section class="layout-box-content-format1">



        <div class="card card-primary">

            <div class="card-header box-shdw">

              <h3 class="card-title">Other Assistance List </h3>

               <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >

              <a href="<?php echo admin_with_base_url(); ?>otherassistance/addOtherassistance" class="btn btn-default btnpos">

               <i class="fas fa-plus"></i> Add </a>

            </div>

             

              

            </div><!-- /.card-header -->

           

            <div class="card-body">

              <div class="formblock-box">

              <table id="corporatecompanylist" class="table customTbl table-bordered table-hover  tablepad">

                <thead >
						<tr>
							<th width="35">Sl</th>
							<th>Category</th>
							<th>Supplement Name</th>
							<th>Quantity</th>
							<th>Unit</th>
							<th width="40" align="right">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php $sl=1;
							foreach($otherAssistanceList as $assistance_food){?>
						<tr>
							<td><?php echo $sl++; ?></td>
							<td><?php echo $assistance_food->othr_assistnc_name; ?></td>
							<td><?php echo $assistance_food->supplement_name; ?></td>
							<td><?php echo $assistance_food->quantity; ?></td>
							<td><?php echo $assistance_food->unit_name; ?></td>
							<td align="center">
							
                  <a href="<?php echo admin_with_base_url(); ?>otherassistance/addOtherassistance/<?php echo $assistance_food->othrAssistncMastID; ?>" class="btn tbl-action-btn padbtn">

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