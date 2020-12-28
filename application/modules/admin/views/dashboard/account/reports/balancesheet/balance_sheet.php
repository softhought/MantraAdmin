
<style type="text/css">



</style>

<section class="layout-box-content-format1">

        <div class="card card-primary">

            <div class="card-header box-shdw">

              <h3 class="card-title">Balance Sheet</h3>             

                           

            </div><!-- /.card-header -->



           

        

            <div class="card-body">

                <div class="formblock-box">

        

            <div id="copy_div">

                <form target="_blank" action="balancesheet/balancesheetpdf" method="post" name="balancesheet" id="balancesheet">

                <div class="row">

                    <div class="col-md-4">

                        <label for="firstname">From Date</label>

                        <div class="form-group">                              

                            <div class="input-group input-group-sm">

                                <div class="input-group-prepend">

                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>

                                </div>

                                <input type="text" class="form-control datepicker" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" name="fromdate" id="fromdate" im-insert="false" value="<?php echo date('d-m-Y',strtotime($start_date)); ?>" >

                            </div>

                        </div>

                   </div>

                    <div class="col-md-4">

                        <label for="firstname">To Date</label>

                        <div class="form-group">                              

                            <div class="input-group input-group-sm">

                                <div class="input-group-prepend">

                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>

                                </div>

                                <input type="text" class="form-control datepicker" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask="" name="todate" id="todate" im-insert="false" value="<?php if($ending_date >= date('Y-m-d')){ echo date('d-m-Y'); }else{ echo date('d-m-Y',strtotime($ending_date)); } ?>" >

                            </div>

                        </div>

                   </div>

               



              <div class="col-md-2">

                 <div class="form-group">

                            <label for="specialcoching">&nbsp;</label>

                            <div class="input-group input-group-sm">

                           <button type="submit" class="btn btn-sm action-button" id="showprofitloss">Generate PDF</button>

                            </div>



                          </div>

               

              </div>



     

              

            

             </div>

         

            

             <div class="row">

               <div class="col-md-3">

               <p id="response_msg" style="font-weight: bold;color:#7d6060;"></p>

               </div>

                 <div class="col-md-5 colmargin">

                    <p id="errormsg" class="errormsgcolor"></p>

                 </div>

               

             </div>



             </form>

             </div>

           </div>

                     

          </div> <!-- /.card-body -->





     





         







        </div><!-- /.card -->

   </section>







