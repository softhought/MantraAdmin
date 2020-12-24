<script src="<?php echo base_url();?>assets/js/customJs/account/account_group.js"></script>

<section class="layout-box-content-format1">



        <div class="card card-primary">

            <div class="card-header box-shdw">

              <h3 class="card-title">Account Group</h3>

               <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >

              <a href="<?php echo admin_with_base_url(); ?>accountgroup/addAccountgroup" class="btn btn-default btnpos">

               <i class="fas fa-plus"></i> Add </a>

            </div>

             

              

            </div><!-- /.card-header -->

           

            <div class="card-body">

              <div class="formblock-box">

              <table id="accountgrouplist" class="table customTbl table-bordered table-hover  tablepad">

                <thead>

                    <tr>

                    <th>Sl.No</th>

                    <th>Group Description</th>

                    <th>Balance Sheet/
                        Profit & Loss/
                        Trading</th>

                    <th>Asset/Liability
                    Income/Expenditure</th>

                    <th>Status</th>
                    <th>Action</th>

                                        

                    </tr>

                </thead>

                <tbody>



                <?php $i=1;

                foreach ($accountgrouplist as $accountgrouplist) { 


                  	 if($accountgrouplist->b_p_t=="B")
                        {
                        $cat_desc1="Balance Sheet";
                      }
                      else
                        {
                        $cat_desc1="Profit & Loss";
                      }

                      if($accountgrouplist->a_l_i_e=="A")
                        {
                        $cat_desc2="Asset";
                      }

                      if($accountgrouplist->a_l_i_e=="L")
                        {
                        $cat_desc2="Liability";
                      }

                      if($accountgrouplist->a_l_i_e=="I")
                        {
                        $cat_desc2="Income";
                      }
                      if($accountgrouplist->a_l_i_e=="E")
                        {
                        $cat_desc2="Expenditure";
                      }
                  
                  ?>

                   <tr>

                   <td><?php echo $i++; ?></td>

                   <td><?php echo $accountgrouplist->group_description; ?></td>

                   <td><?PHP echo($cat_desc1);?></td>
						       <td><?PHP echo($cat_desc2);?></td>
                  
                   <td>
                    	<?php  if ($accountgrouplist->is_active=='Y') { ?>
                               
                                   <button class="btn btn-sm action-button actinct actibtn groupstatus" data-setstatus="N"  data-groupid="<?php echo $accountgrouplist->group_id; ?>" >Active</button>
                                                                
                            <?php }else{ ?>
                              
                                    <button class="btn btn-sm action-button actinct inactbtn groupstatus" data-setstatus="Y" data-groupid="<?php echo $accountgrouplist->group_id; ?>">Inactive</button>
                               
                            <?php } ?>
                    </td>
                        <td>

                     <a href="<?php echo admin_with_base_url(); ?>accountgroup/addAccountgroup/<?php echo $accountgrouplist->group_id; ?>" class="btn tbl-action-btn padbtn">

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

                           <th></th>

                          

                         

                           </tr>

              </table>

            </div>



            </div><!-- /.card-body -->

        </div><!-- /.card -->

   </section>