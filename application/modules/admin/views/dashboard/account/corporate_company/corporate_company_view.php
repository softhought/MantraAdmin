<script src="<?php echo base_url();?>assets/js/customJs/account/corporate_company.js"></script>

<section class="layout-box-content-format1">



        <div class="card card-primary">

            <div class="card-header box-shdw">

              <h3 class="card-title">Corporate Company </h3>

               <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >

              <a href="<?php echo admin_with_base_url(); ?>corporatecompany/addCompany" class="btn btn-default btnpos">

               <i class="fas fa-plus"></i> Add </a>

            </div>

             

              

            </div><!-- /.card-header -->

           

            <div class="card-body">

              <div class="formblock-box">

              <table id="corporatecompanylist" class="table customTbl table-bordered table-hover  tablepad">

                <thead>

                    <tr>

                    <th>Sl.No</th>
                    <th >Company Name</th>
                    <th>GISTNNO</th>
                    <th >Address</th>
                    <th>Status</th>
                    <th>Action</th>

                                        

                    </tr>

                </thead>

                <tbody>



                <?php $i=1;

                foreach ($corporateCompanyList as $corporateCompanyList) { 


               
                  
                  ?>

                   <tr>

                   <td><?php echo $i++; ?></td>

                   <td><?php echo $corporateCompanyList->company_name; ?></td>

                   <td><?php echo $corporateCompanyList->gistn_no; ?></td>
                   <td><?php echo $corporateCompanyList->address; ?></td>
						      
                  
                   <td>
                    	<?php  if ($corporateCompanyList->is_active=='Y') { ?>
                               
                                   <button class="btn btn-sm action-button actinct actibtn corpcomptatus" data-setstatus="N"  data-corcompid="<?php echo $corporateCompanyList->id; ?>" >Active</button>
                                                                
                            <?php }else{ ?>
                              
                                    <button class="btn btn-sm action-button actinct inactbtn corpcomptatus" data-setstatus="Y" data-corcompid="<?php echo $corporateCompanyList->id; ?>">Inactive</button>
                               
                            <?php } ?>
                    </td>
                        <td>

                     <a href="<?php echo admin_with_base_url(); ?>corporatecompany/addCompany/<?php echo $corporateCompanyList->id; ?>" class="btn tbl-action-btn padbtn">

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