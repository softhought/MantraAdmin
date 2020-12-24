<script src="<?php echo base_url();?>assets/js/customJs/account/account.js"></script>

<section class="layout-box-content-format1">



        <div class="card card-primary">

            <div class="card-header box-shdw">

              <h3 class="card-title">Account Group</h3>

               <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >

              <a href="<?php echo admin_with_base_url(); ?>account/addAccount" class="btn btn-default btnpos">

               <i class="fas fa-plus"></i> Add </a>

            </div>

             

              

            </div><!-- /.card-header -->

           

            <div class="card-body">

              <div class="formblock-box">

              <table id="accountlist" class="table customTbl table-bordered table-hover  tablepad">

                <thead>

                    <tr>

                    <th>Sl.No</th>

                    	<th align="left">Account Head</th>
                      <th align="left">Sub Group</th>
                      <th align="right">Opening Balance</th>
                      <th align="left">Active</th>
                      <th align="left">&nbsp;</th>
                                        

                    </tr>

                </thead>

                <tbody>



                <?php $i=1;

                foreach ($accountList as $accountlist) { 


                  	 
                  
                  ?>

                   <tr>

                   <td><?php echo $i++; ?></td>

                   <td><?php echo $accountlist['accountData']->account_description; ?></td>

                   <td><?php echo $accountlist['accountData']->sub_group_desc; ?></td>
						       <td align="right"><?php echo number_format($accountlist['openingBalance'],2); ?></td>
                  
                   <td>
                    	<?php  if ($accountlist['accountData']->is_active=='Y') { ?>
                               
                                   <button class="btn btn-sm action-button actinct actibtn accountstatus" data-setstatus="N"  data-accountid="<?php echo $accountlist['accountData']->account_id; ?>" >Active</button>
                                                                
                            <?php }else{ ?>
                              
                                    <button class="btn btn-sm action-button actinct inactbtn accountstatus" data-setstatus="Y" data-accountid="<?php echo $accountlist['accountData']->account_id; ?>">Inactive</button>
                               
                            <?php } ?>
                    </td>
                        <td>

                     <a href="<?php echo admin_with_base_url(); ?>account/addAccount/<?php echo $accountlist['accountData']->account_id; ?>" class="btn tbl-action-btn padbtn">

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