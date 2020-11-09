<script src="<?php echo base_url(); ?>assets/js/customJs/menudoc.js"></script>

<style type="text/css">
  .select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #821e72;
  }
  .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    color: #fefefe;
 
}
</style>

<section class="layout-box-content-format1">

        <div class="card card-primary">

            <div class="card-header box-shdw">

              <h3 class="card-title">Menu Doc</h3>

               <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >

              <a href="<?php echo admin_with_base_url(); ?>menudoc" class="btn btn-default btnpos"> <i class="fas fa-clipboard-list"></i> List </a>

             

            </div>

                           

            </div><!-- /.card-header -->

           <form name="menudocFrom" id="menudocFrom" enctype="multipart/form-data">
           <input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>">
           <input type="hidden" name="menudocId" id="menudocId" value="<?php echo $menudocId; ?>">
          <div class="card-body">


             <div class="formblock-box">
               <h3 class="form-block-subtitle"><i class="fas fa-angle-double-right"></i>Menu Doc Info</h3>  
                   <div class="row">                 
                    <div class="col-md-1"></div>
                      <div class="col-md-5">
                         <label>Menu</label>
                           <div class="form-group">
                              <div class="input-group input-group-sm">
                                <select class="form-control select2" id="menu_id" name="menu_id" style="width: 100%;" autocomplete="off">
                                  <option value='' data-linkval="">Select Menu</option>
                                  <?php foreach ($menuListDropdown as $menulistdropdown) { ?>
                                    <option value="<?php echo $menulistdropdown['menuid']; ?>" 
                                      data-linkval="<?php echo $menulistdropdown['menulink']; ?>"
                                    <?php  if($mode == 'EDIT' && $menuDocEditdata->menu_id == $menulistdropdown['menuid']){
                                      echo 'selected';
                                    } ?>
                                     ><?php echo $menulistdropdown['name']; ?></option>
                                <?php   } ?>
                                </select>      
                                </div>
                              </div>                       
                            </div>

                   <div class="col-md-5">
                       <label for="groupname">Link</label>
                       <div class="form-group">
                         <div class="input-group input-group-sm">
                          <input type="text" class="form-control" name="url_link" id="url_link" placeholder="Enter Url Link" value="<?php if($mode == 'EDIT'){ echo $menuDocEditdata->link; } ?>" autocomplete="off">
                        </div>
                      </div>                    
                    </div>  

               </div>

               <div class="row">
                       <div class="col-md-1"></div>
                   <div class="col-md-2">
                         <label>Link Type</label>
                           <div class="form-group">
                              <div class="input-group input-group-sm" id="linktypeerr">
                                <select class="form-control select2" id="link_type" name="link_type" style="width: 100%;" autocomplete="off">
                                  <option value='' >Select</option>
                                  <option value='E'
                                   <?php  if($mode == 'EDIT' && $menuDocEditdata->link_type == 'E'){
                                      echo 'selected';
                                    } ?>
                                   >Data Entry</option>
                                  <option value='V'
                                  <?php  if($mode == 'EDIT' && $menuDocEditdata->link_type == 'V'){
                                      echo 'selected';
                                    } ?>
                                    >Data View</option>
                                  
                                
                                </select>      
                                </div>
                              </div>                       
                            </div>


                          <div class="col-md-2">
                         <label>Voucher Pass</label>
                           <div class="form-group">
                              <div class="input-group input-group-sm" id="voucherpasserr">
                                <select class="form-control select2" id="voucher_pass" name="voucher_pass" style="width: 100%;" autocomplete="off">
                                  <option value='' >Select</option>
                                  <option value='Y'
                                    <?php  if($mode == 'EDIT' && $menuDocEditdata->voucher_pass == 'Y'){
                                      echo 'selected';
                                    } ?> >Yes</option>
                                  <option value='N' 
                                    <?php  if($mode == 'EDIT' && $menuDocEditdata->voucher_pass == 'N'){
                                      echo 'selected';
                                    } ?>>No</option>
                                  
                                
                                </select>      
                                </div>
                              </div>                       
                            </div>


                             <div class="col-md-6">
                         <label>Related Tables</label>
                           <div class="form-group">
                              <div class="input-group input-group-sm" id="selecttableerr">
                                <select class="form-control select2" id="select_tables" name="select_tables[]" style="width: 100%;" multiple autocomplete="off">
                                  <!-- <option value='' data-linkval="">Select</option> -->
                                  <?php foreach ($tableList as $tableList) { ?>
                                    <option value="<?php echo $tableList->table_name; ?>" 
                                      <?php  if($mode == 'EDIT'){

                                    if ($menuDocEditdata->tables!='') {
                                      $selectedTables = explode (",", $menuDocEditdata->tables); 
                                    }else{
                                      $selectedTables = array('0');
                                    }
                                      if(in_array($tableList->table_name ,$selectedTables)){ echo "selected";}
                                    } ?>
                                     ><?php echo $tableList->table_name; ?></option>
                                <?php   } ?>
                                </select>      
                                </div>
                              </div>                       
                            </div>
                </div>

                <div class="row">
                  <div class="col-md-1"></div>
                   <div class="col-md-10">
                       <label for="groupname">Module Description</label>
                       <div class="form-group">
                         <div class="input-group input-group-sm">
                          <textarea class="form-control" name="notes" id="notes" placeholder="Enter A Description" autocomplete="off"><?php if($mode == 'EDIT'){ echo $menuDocEditdata->note; } ?></textarea>
                         
                        </div>
                      </div>                    
                    </div>  

                </div>


                  <h3 class="form-block-subtitle"><i class="fas fa-angle-double-right"></i>Development Details Info</h3>  

<!-- ------------------------------------------------------------------------------------------------------- -->

<div class="row">
    <div class="col-md-2">
                          <div class="form-group">
                            <label for="eqpname">Development Date</label>
                            <!-- <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" im-insert="false"> -->
                          <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                            </div>
                            <input type="text" class="form-control datemask" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask name="development_dt" id="development_dt" value="">
                          </div>
                        </div>
                 </div>
                  <div class="col-md-2"><?php

                  $devType = array(
                                  'Creation' => 'Creation',
                                  'Modification' => 'Modification',
                                  'Bug Fix' => 'Bug Fix'
                                   );

                  ?>
                         <label>Development Type</label>
                           <div class="form-group">
                              <div class="input-group input-group-sm" id="development_type_err">
                                <select class="form-control select2" id="development_type" name="development_type" style="width: 100%;" autocomplete="off">
                                  <option value='' >Select</option>
                                 <?php 

                                    foreach ($devType as $key => $value) {
                                 ?>
                                    <option value='<?php echo $value;?>' ><?php echo $value;?></option>
                                <?php } ?>
                                </select>      
                                </div>
                              </div>                       
                            </div>  
                             <div class="col-md-2">
                       <label for="groupname">Developer</label>
                       <div class="form-group">
                         <div class="input-group input-group-sm">
                          <input type="text" class="form-control" name="developer_name" id="developer_name" placeholder="Developer" value="" autocomplete="off">
                        </div>
                      </div>                    
                    </div> 

                   <div class="col-md-5">
                       <label for="groupname">Note</label>
                       <div class="form-group">
                         <div class="input-group input-group-sm">
                          <input type="text" class="form-control" name="developer_note" id="developer_note" placeholder="Developer Notes" value="" autocomplete="off">
                        </div>
                      </div>                    
                    </div> 
                      <div class="col-sm-1">
                        <label for="groupname">&nbsp;</label>
                     <div class="form-group">
                        <div class="input-group input-group-sm">
                           <button type="button" class="btn btn-sm action-button addDevelopDetails" id="maingroupsavebtn" style="width: 60%;">Add</button>
                        </div>
                     </div>
                  </div>
</div>


    <!-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-start slot table - xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->
               <div class="row">
                  <div class="col-sm-12">
                     <div  id="detail_slottime" style="border: 1px solid #a84e7f;max-height: 650px;#overflow: scroll;">
                        <div class="table-responsive">
                           <?php
                              $rowno=0;
                              $detailCount = 0;
                              if($mode=="EDIT")
                              {
                              // $detailCount = sizeof($bodycontent['doctorScheduleEdit']);
                              }
                              
                              // For Table style Purpose
                              if($mode=="EDIT" && $detailCount>0)
                              {
                                $style_var = "display:block;width:100%;";
                              }
                              else
                              {
                                $style_var = "display:none;width:100%;";
                              }
                              
                              ?>
                           <table class="table table-bordered" style="font-size: 14px;color: #354668;<?php echo $style_var; ?>">
                              <thead>
                                 <tr>
                                    <th style="width:5%">Sl No</th>
                                    <th style="width:6%">Date</th>
                                    <th style="width:5%">Development Type</th>
                                    <th style="width:5%">Developer</th>
                                    <th style="width:5%">Note</th>
                                    <th style="width:5%">Del</th>
                                 </tr>
                              </thead>
                              <tbody>
                                
                              </tbody>
                           </table>
                        </div>
                        <!-- end of table responsive -->
                     </div>
                     <input type="hidden" name="rowno" id="rowno" value="<?php echo $rowno;?>">  
                  </div>
               </div>


        <!-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-end slot table - xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->

<br>

<?php if($devDetailsData){
?>
  <table class="table customTbl table-bordered table-hover dataTable tablepad">
                <thead>
                    <tr>
                    <th width="5%">Sl.No</th>
                    <th width="10%">Date</th>
                    <th width="15%">Development Type</th>
                    <th width="10%">Developer</th>
                    <th>Note</th>
                    <th width="5%">Action</th>
                   
                    </tr>

                </thead>
                <tbody>

  
                  <?php 
                      $sl=1;
                      foreach ($devDetailsData as $key => $value) {
                    
                  ?>
                   <tr>
                   <td><?php echo $sl++;?></td>
                   <td><?php echo date("d-m-Y",strtotime($value->development_dt));?></td>
                   <td><?php echo $value->development_type;?></td>
                   <td><?php echo $value->developer_name;?></td>
                   <td><?php echo $value->developer_note;?></td>
                   <td>
                     
                        <a href="javascript:;"  class="btn tbl-action-btn padbtn delDocDtl"  style="padding-right:7px;" data-docdtlid="<?php echo $value->dtl_id; ?>">
                      <i class="fas fa-trash"> </i> 
                    </a>
                   </td>
                  
                   </tr>

                 <?php } ?>

            

                         

                </tbody>

               </table>

                <?php } ?>



<!-- ------------------------------------------------------------------------------------------------------- -->



















                   </div>



                   <div class="formblock-box">
                     <div class="row">
                      <div class="col-md-10"> </div>               
                       <div class="col-md-2 text-right">
                        <button type="submit" class="btn btn-sm action-button" id="menudocsavebtn" style="width: 60%;"><?php echo $btnText; ?></button>
                           <span class="btn btn-sm action-button loaderbtn" id="loaderbtn" style="display:none;width: 60%;"><?php echo $btnTextLoader; ?></span>
                       </div>
                     
                     </div>
                   </div>

             </form>
           </div>
          <!-- /.card-body -->
        </div><!-- /.card -->
   </section>



