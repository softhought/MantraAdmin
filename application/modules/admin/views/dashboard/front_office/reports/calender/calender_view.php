
<script src="<?php echo base_url(); ?>assets/js/customJs/front_office/amc.js"></script>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/calender/fullcalendar.min.css">


<script src="<?php echo base_url(); ?>assets/calender/fullcalendar.min.js"></script>
<style>
.tablepad th,td {
    padding: 0 !important;
}

</style>

<section class="layout-box-content-format1">



        <div class="card card-primary">

            <div class="card-header box-shdw">

              <h3 class="card-title">Calender</h3>

               <!-- <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >

              <a href="<?php echo base_url(); ?>partybooking/addeditpartybooking" class="btn btn-default btnpos">

               <i class="fas fa-plus"></i> Add </a>

            </div> -->

             

              

            </div><!-- /.card-header -->

           

            <div class="card-body">

            <div class="formblock-box">

             <div class="row"> 

                               

                 <div class="col-sm-3">   

                         <label for="location">Statutory Name</label>               

                      

                         <div class="form-group">

                           <div class="input-group input-group-sm">

                            

                              <select class="form-control select2" name="statutory_name" id="statutory_name"  style="width: 100%;">

                                    <option value="">Select</option>

                                    <?php

                                    foreach ($statutorylist as $statutorylist) {

                                    ?>

                                    <option value="<?php echo $statutorylist->id;?>"><?php echo $statutorylist->statutory_name; ?></option>

                                    <?php } ?>

                                 </select>

                                 

                              </div>

                              </div>

                              <button type="button" class="btn btn-block action-button btn-sm" id="expirydate">Show</button>  

                      

                 </div>

                      <div class="col-sm-7 calcol">

                         <div id="loader" style="text-align:center; display:none;height: 500px;top: 150px;position: relative;">

                           <img src="<?php echo base_url(); ?>assets/img/loader.gif" style="width:115px;">

                         </div>

                         <div id="calender"></div>

                      </div>

                   </div>   



           

</div>

        



             



            </div><!-- /.card-body -->

        </div><!-- /.card -->

   </section>

<div id="calendarModal" class="modal fade">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
            <h4 id="modalTitle" class="modal-title"></h4>
        </div>
        <div id="modalBody" class="modal-body"> </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
</div>