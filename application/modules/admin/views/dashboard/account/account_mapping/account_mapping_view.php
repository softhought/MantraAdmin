<script src="<?php echo base_url();?>assets/js/customJs/account/account_mapping.js"></script>

<section class="layout-box-content-format1">



        <div class="card card-primary">

            <div class="card-header box-shdw">

              <h3 class="card-title">Account Mapping wiith Branch Register </h3>

               <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >

              <a href="<?php echo admin_with_base_url(); ?>accountmapping/addCompany" class="btn btn-default btnpos">

               <i class="fas fa-plus"></i> Add </a>

            </div>

             

              

            </div><!-- /.card-header -->

           

            <div class="card-body">

              <div class="formblock-box">

              <table id="corporatecompanylist" class="table customTbl table-bordered table-hover  tablepad">

                <thead>

                    <tr>

                    <th>Sl.No</th>
                    <th >Branch</th>
                    <th>Payment Mode</th>
                    <th>A/C </th>
                    <th>Status</th>
                    <th>Action</th>

                                        

                    </tr>

                </thead>

                <tbody>



                <?php $i=1;

                foreach ($accountmappingList as $accountmappingList) { 


               
                  
                  ?>

                   <tr>

                   <td><?php echo $i++; ?></td>

                   <td><?php echo $accountmappingList->BRANCH_NAME; ?></td>

                   <td><?php echo $accountmappingList->payment_mode; ?></td>
                   <td><?php echo $accountmappingList->account_description; ?></td>
						      
                  
                   <td>
                    	<?php  if ($accountmappingList->is_active=='Y') { ?>
                               
                                   <button class="btn btn-sm action-button actinct actibtn mappingstatus" data-setstatus="N"  data-mappingid="<?php echo $accountmappingList->id; ?>" >Active</button>
                                                                
                            <?php }else{ ?>
                              
                                    <button class="btn btn-sm action-button actinct inactbtn mappingstatus" data-setstatus="Y" data-mappingid="<?php echo $accountmappingList->id; ?>">Inactive</button>
                               
                            <?php } ?>
                    </td>
                        <td>

                     <!-- <a href="<?php echo admin_with_base_url(); ?>corporatecompany/addCompany/<?php echo $corporateCompanyList->id; ?>" class="btn tbl-action-btn padbtn">

                  <i class="fas fa-edit"></i> 

                </a> -->

                    

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