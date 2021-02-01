



<section class="layout-box-content-format1">

        <div class="card card-primary">

            <div class="card-header box-shdw">

              <h3 class="card-title">sms Log</h3>

                 <!-- <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >

              <a href="<?php echo admin_with_base_url(); ?>user/create" class="btn btn-info btnpos link_tab">

              <i class="fas fa-plus"></i> Add </a>

                </div> -->

             <!--  <a href="<?php echo base_url();?>user/create" class="link_tab"><span class="glyphicon glyphicon-plus"></span> ADD</a> -->

            </div><!-- /.card-header -->



            <div class="card-body">

                <div class="formblock-box">

              <table id="example2" class="table customTbl table-bordered table-hover dataTable">

                <thead>

                    <tr>

                    <th>Sl</th>
                    <th>Mobile</th>
                    <th>Message</th>
                    <th>Status Code</th>
                    <th>Response Code</th>
                    <th>Module</th>
                    <th>created_on</th>
                   
                   

               

                    </tr>

                </thead>

                <tbody>                       

                    <?php 

                    // pre($bodycontent['userslist']);
                        $i=1;
                    foreach ($smslist as $smslist) { ?> 
                        <tr>
                        <td><?php echo $i++; ?> </td>
                        <td><?php echo $smslist->mobile; ?> </td>
                        <td><?php echo $smslist->message; ?> </td>
                        <td><?php echo $smslist->status_code; ?> </td>
                        <td><?php echo $smslist->response_code; ?> </td>
                        <td><?php echo $smslist->module; ?> </td>
                        <td><?php echo $smslist->created_on; ?> </td>
                      
                   
                        </tr>      

                                

                    <?php } ?>     

                </tbody>

              </table>

          </div>

            </div><!-- /.card-body -->

        </div><!-- /.card -->

    </section>



<!-- Modal -->

<section class="layout-box-content-format1">

<div class="modal fade" id="myModal" style="display: none;" aria-hidden="true">

        <div class="modal-dialog modal-lg">

          <div class="modal-content">

            <div class="modal-header card-header box-shdw" style="color: white;">

              <h5 class="modal-title">Login & Logout Details</h5>

              <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">

                <span aria-hidden="true">×</span>

              </button>

            </div>

           

            <div id="ModalBody"  class="modal-body">



            </div>

       

            <div class="modal-footer justify-content-between">

              <button type="button" class="btn btn-sm action-button" data-dismiss="modal">Close</button>

            </div>

          </div>

          <!-- /.modal-content -->

        </div>

        <!-- /.modal-dialog -->

      </div>

  </section>