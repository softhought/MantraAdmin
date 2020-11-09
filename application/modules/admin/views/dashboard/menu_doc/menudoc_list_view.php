<script src="<?php echo base_url(); ?>assets/js/customJs/menudoc.js"></script>

<style type="text/css">
  table.dataTable td.focus {
        outline: 1px solid #ac1212;
        outline-offset: -3px;
        background-color: #f8e6e6 !important;
    }

table th {
    border: 2px solid red;
}
</style>

<section class="layout-box-content-format1">



        <div class="card card-primary">

            <div class="card-header box-shdw">

              <h3 class="card-title">Menu Doc</h3>



            <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >

                  <a href="<?php echo admin_with_base_url(); ?>menudoc/addMenudoc" class="btn btn-default btnpos">

                   <i class="fas fa-plus"></i> Add </a>

            </div>

             

              

            </div><!-- /.card-header -->



           <div class="card-body">

             <div class="formblock-box">

              <table class="table customTbl table-bordered table-hover dataTable tablepad">
                <thead>
                    <tr>
                    <th>Sl.No</th>
                    <th>Menu</th>
                    <th>Link</th>
                    <th>Link Type</th>
                    <th>Voucher Pass</th>
                    <th>Tables</th>
                    <th>Action</th>
                    </tr>

                </thead>
                <tbody>

                <?php $i=1;
                foreach ($menudocList as $menudoclist) { 
	?>

                   <tr>
                   <td><?php echo $i++; ?></td>
                   <td><?php echo $menuName[$menudoclist->menu_id]; ?></td>
                   <td><?php echo $menudoclist->link; ?></td>
                   <td><?php if($menudoclist->link_type=='E'){echo "Data Entry";}else{echo "Data View";} ; ?></td>
                   <td><?php if($menudoclist->voucher_pass=='Y'){echo "Yes";}else{echo "No";} ?></td>
                   <td><?php ;
                      $tableNames=explode(',', $menudoclist->tables);

                      if ($menudoclist->tables!='') {
                       
                    ?>
                     
                  <table width="100%" style="font-size: 10px;">
                 <tr style="color: #db4849;">
                         <th width="5%">Sl </th>
                         <th width="60%">Table </th>
                         <th>Structure</th>
                         <th>Data</th>
                     </tr>
                     <?php $slt=1;
                         foreach($tableNames as $value){
                         ?>
                      <tr>
                         <td><?php echo $slt++;?></td>
                         <td><?php echo $value;?></td>
                         <td><span  class="btn tbl-action-btn btn-xs tabledtl_btn" data-toggle="modal" data-target="#tableDetails" 
                    data-tablename="<?php echo $value; ?>" style="padding-right:7px;cursor: pointer;"  >View  </span></td>
                         <td><span  class="btn tbl-action-btn btn-xs tableData_btn" data-toggle="modal" data-target="#tableDataDetails" 
                    data-tablename="<?php echo $value; ?>" style="padding-right:7px;cursor: pointer;"  >Show  </span></td>
                     </tr>
                     <?php }?>
                 </table>

               <?php } ?>



                   </td>
                   <td>
                   <a href="<?php echo admin_with_base_url(); ?>menudoc/addMenudoc/<?php echo $menudoclist->menu_doc_id; ?>" class="btn tbl-action-btn padbtn">
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

 <div id="tableDetails" class="modal fade customModal format1 right"  data-keyboard="false" data-backdrop="false">
  <div class="modal-dialog modal-lg" style="margin-top: 90px;">
    <div class="modal-content">
      <div class="modal-header" style="background: linear-gradient(90deg, #A60711 0%,#4E3FFB 100%);background-color: rgba(0, 0, 0, 0);
padding: 5px;color: #fff;">
       <h4 class="frm_header">Table Structure: <span id="table_name"></span></h4>
        <button type="button" class="close" data-dismiss="modal"  >&times;<span class="sr-only">Close</span></button>
       
      </div>
      <div class="modal-body" style="height: 520px;
    overflow-y: auto;">
   <center>  <div style="text-align: center;display:none;" id="loader_tablestructure">
                   <img src="<?php echo base_url(); ?>assets/img/loader.gif" width="90" height="90" id="gear-loader" style="margin-left: auto;margin-right: auto;"/>
                   <span style="color: #bb6265;">Loading...</span>
               </div></center>
        <div id="table_details_data"></div>
      </div>
    </div>
  </div>
</div>



 <div id="tableDataDetails" class="modal fade customModal format1 right"  data-keyboard="false" data-backdrop="false">
  <div class="modal-dialog modal-xl" style="margin-top: 90px;width: 100%;">
    <div class="modal-content">
      <div class="modal-header" style="background: linear-gradient(90deg, #A60711 0%,#4E3FFB 100%);background-color: rgba(0, 0, 0, 0);
padding: 5px;color: #fff;">
       <h4 class="frm_header">Table Structure: <span id="table_name_span"></span></h4>
      &nbsp;&nbsp;&nbsp;&nbsp;<center></center> <button type="button" class="btn btn-sm" id="searchOption" style="width:170px;float:right;color:#fff;margin-left: 450px;">Add Search Option</button>
        <button type="button" class="close" data-dismiss="modal"  >&times;<span class="sr-only">Close</span></button>
       </center>
      </div>
      <div class="modal-body" style="height: 520px;
    overflow-y: auto;">
     <center><div style="text-align: center;display:none;" id="loader_tabledata">
                   <img src="<?php echo base_url(); ?>assets/img/loader.gif" width="90" height="90" id="gear-loader" style="margin-left: auto;margin-right: auto;"/>
                   <span style="color: #bb6265;">Loading...</span>
               </div></center> 
        <div id="table_data"></div>
      </div>
    </div>
  </div>
</div>

