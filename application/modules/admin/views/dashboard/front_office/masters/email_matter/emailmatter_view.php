<script src="<?php echo base_url();?>assets/js/customJs/front_office/emailmatter.js"></script>

<section class="layout-box-content-format1">



        <div class="card card-primary">

            <div class="card-header box-shdw">

              <h3 class="card-title">Email Matter</h3>

               <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >

              <a href="<?php echo admin_with_base_url(); ?>emailmatter/addEmailmatter" class="btn btn-default btnpos">

               <i class="fas fa-plus"></i> Add </a>

            </div>

             

              

            </div><!-- /.card-header -->

           

            <div class="card-body">

              <div class="formblock-box">

              <table id="emailmatterlist" class="table customTbl table-bordered table-hover  tablepad">

                <thead>

                    <tr>

                    <th>Sl.No</th>

                    
                      <th align="left">Email Title</th>
                      <th align="right">Email Matter</th>
                      <th align="left">Active</th>
                      <th align="left">&nbsp;</th>
                                        

                    </tr>

                </thead>

                <tbody>



                <?php $i=1;

                foreach ($emailmatterlist as $emailmatterlist) { 


                  	 
                  
                  ?>

                   <tr>

                   <td><?php echo $i++; ?></td>

                   <td><?php echo $emailmatterlist->email_title; ?></td>

                   <td><?php echo $emailmatterlist->email_matter; ?></td>
						     
                  
                   <td>
                    	<?php  if ($emailmatterlist->is_active=='Y') { ?>
                               
                                   <button class="btn btn-sm action-button actinct actibtn emailstatus" data-setstatus="N"  data-emailid="<?php echo $emailmatterlist->tran_id; ?>" >Active</button>
                                                                
                            <?php }else{ ?>
                              
                                    <button class="btn btn-sm action-button actinct inactbtn emailstatus" data-setstatus="Y" data-emailid="<?php echo $emailmatterlist->tran_id; ?>">Inactive</button>
                               
                            <?php } ?>
                    </td>
                        <td>

                     <a href="<?php echo admin_with_base_url(); ?>emailmatter/addEmailmatter/<?php echo $emailmatterlist->tran_id; ?>" class="btn tbl-action-btn padbtn">

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