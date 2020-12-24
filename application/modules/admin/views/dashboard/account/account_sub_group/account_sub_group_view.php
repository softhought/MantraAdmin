<script src="<?php echo base_url();?>assets/js/customJs/account/account_sub_group.js"></script>

<section class="layout-box-content-format1">



        <div class="card card-primary">

            <div class="card-header box-shdw">

              <h3 class="card-title">Account Sub Group</h3>

               <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >

              <a href="<?php echo admin_with_base_url(); ?>accountsubgroup/addAccountsubgroup" class="btn btn-default btnpos">

               <i class="fas fa-plus"></i> Add </a>

            </div>

             

              

            </div><!-- /.card-header -->

           

            <div class="card-body">

              <div class="formblock-box">

              <table id="accountsubgrouplist" class="table customTbl table-bordered table-hover  tablepad">

                <thead>

                    <tr>

                    <th>Sl.No</th>
                    <th>Sub Group </th>
                    <th>Group </th>


                    <th>Status</th>
                    <th>Action</th>

                                        

                    </tr>

                </thead>

                <tbody>



                <?php $i=1;

                foreach ($accountSubGroupList as $accountSubGroupList) { 


               
                  
                  ?>

                   <tr>

                   <td><?php echo $i++; ?></td>

                   <td><?php echo $accountSubGroupList->sub_group_desc; ?></td>

                   <td><?php echo $accountSubGroupList->group_description; ?></td>
						      
                  
                   <td>
                    	<?php  if ($accountSubGroupList->is_active=='Y') { ?>
                               
                                   <button class="btn btn-sm action-button actinct actibtn subgroupstatus" data-setstatus="N"  data-subgroupid="<?php echo $accountSubGroupList->sub_group_id; ?>" >Active</button>
                                                                
                            <?php }else{ ?>
                              
                                    <button class="btn btn-sm action-button actinct inactbtn subgroupstatus" data-setstatus="Y" data-subgroupid="<?php echo $accountSubGroupList->sub_group_id; ?>">Inactive</button>
                               
                            <?php } ?>
                    </td>
                        <td>

                     <a href="<?php echo admin_with_base_url(); ?>accountsubgroup/addAccountsubgroup/<?php echo $accountSubGroupList->sub_group_id; ?>" class="btn tbl-action-btn padbtn">

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