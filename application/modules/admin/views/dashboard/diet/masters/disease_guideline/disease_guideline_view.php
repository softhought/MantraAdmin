
<script type="text/javascript">
$(document).ready(function () {
   $("#guidelist").DataTable();
  basepath = $("#basepath").val();
  $(document).on("click", ".guidestatus", function () {
    var uid = $(this).data("guideid");
    var status = $(this).data("setstatus");
    var url = basepath + "diet/diseaseGuidelineSetStatus";
    setActiveStatus(uid, status, url);
  });


   });
   </script>

<section class="layout-box-content-format1">



        <div class="card card-primary">

            <div class="card-header box-shdw">

              <h3 class="card-title">Disease guideline List </h3>

               <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >

              <a href="<?php echo admin_with_base_url(); ?>diet/addGuideline/" class="btn btn-default btnpos">

               <i class="fas fa-plus"></i> Add </a>

            </div>

             

              

            </div><!-- /.card-header -->

           

            <div class="card-body">

              <div class="formblock-box">

              <table id="guidelist" class="table customTbl table-bordered table-hover  tablepad">

                <thead >
						<tr>
							<th width="35">Sl</th>
						<th width="20%" align="left">Disease</th>
            <th align="left">Disease Guidelines</th>
            <th  align="left">Status</th>
						<th width="40" align="right">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php $sl=1;
							foreach($diseaseguidelineList as $diseaseguidelinelist){

                 $disease_guidelines = $diseaseguidelinelist->disease_guidelines;
                ?>
						<tr>
							<td><?php echo $sl++; ?></td>
							<td><?php echo $diseaseguidelinelist->disease; ?></td>
							<td><?php  $startPos=0; $maxLength=400;
                     $data = trim(substr($disease_guidelines, $startPos, $maxLength));
                     echo strip_tags(htmlspecialchars_decode($data));; ?></td>
              	<td> 	<?php  if ($diseaseguidelinelist->is_active=='Y') { ?>
                               
                                   <button class="btn btn-sm action-button actinct actibtn guidestatus" data-setstatus="N"  data-guideid="<?php echo $diseaseguidelinelist->id; ?>" >Active</button>
                                                                
                            <?php }else{ ?>
                              
                                    <button class="btn btn-sm action-button actinct inactbtn guidestatus" data-setstatus="Y" data-guideid="<?php echo $diseaseguidelinelist->id; ?>">Inactive</button>
                               
                            <?php } ?></td>
							<td align="center">
							
                  <a href="<?php echo admin_with_base_url(); ?>diet/addGuideline/<?php echo $diseaseguidelinelist->id; ?>" class="btn tbl-action-btn padbtn">

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