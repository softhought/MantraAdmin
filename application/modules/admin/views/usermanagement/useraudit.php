<script src="<?php echo base_url();?>assets/js/customJs/useraudit.js"></script>





<section class="layout-box-content-format1">

        <div class="card card-primary">

            <div class="card-header box-shdw">

              <h3 class="card-title">User(s) Activity</h3>

              

            </div><!-- /.card-header -->



            <div class="card-body">

                <div class="formblock-box">

              <table id="userAuditTable" class="table customTbl table-bordered table-hover dataTable">

                <thead>

                    <tr>

                    <th>User Name</th>

                    <th>Date & Time</th>

                    <th>Action</th>

                    <th>Module(Admin)</th>

                    <th>Module(Dev.)</th>

                    <th>Method(Dev.)</th>

                    <th>Browser</th>

                    <th>Device OS</th>

                    </tr>

                </thead>

                <tbody>                       

                    <?php 

                    // pre($bodycontent['usersAuditList']);

                    foreach ($usersAuditList as $value) { ?> 

                        <tr>

                        <td><?php echo $value->user_name; ?></td>

                        <td><?php echo $value->activity_date; ?></td>

                        <td><?php echo $value->action; ?></td>

                        <td><?php echo $value->activity_module_admin; ?></td>

                        <td><?php echo $value->activity_module; ?></td>

                        <td><?php echo $value->from_method; ?></td>

                        <td><?php echo $value->user_browser; ?></td>

                        <td><?php echo $value->user_platform; ?></td>

                       

                        </tr>      

                                

                    <?php } ?>     

                </tbody>

              </table>

          </div>

            </div><!-- /.card-body -->

        </div><!-- /.card -->

    </section>