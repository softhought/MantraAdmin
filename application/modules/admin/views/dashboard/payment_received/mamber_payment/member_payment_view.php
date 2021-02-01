<script src="<?php echo base_url(); ?>assets/js/customJs/payment_received/member_payment_info.js"></script>



  <section class="layout-box-content-format1">

        <div class="card card-primary" style="border-bottom: 3px solid #d96692;">


            <div class="card-header box-shdw">

              <h3 class="card-title"> Member's Payment Info</h3>

               <!-- <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >

                  <a href="<?php echo base_url(); ?>order/addOrder" class="btn btn-info btnpos">

                  <i class="fas fa-plus"></i> Add </a>

                </div> -->

     

              <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >

              

              </div>

            </div><!-- /.card-header -->



            <div class="card-body">

            <div class="list-search-block">

               <div class="row box">
                   
                    <div class="col-sm-4">
                  
                    </div>
                     
                        <div class="col-md-3 mob_sect">
                                         <label for="from_dt"> Member Mobile</label>
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">                                           
     <input type="text" class="form-control forminputs typeahead inputupper" maxlength="10" id="mobile_no" name="mobile_no" placeholder="Enter mobile" autocomplete="off" value="" onKeyUp="numericFilter(this);">
                                        </div>
                                    </div>
                                </div> 

                 

   



                <div class="col-md-2">
                                 <label for="to_date" >&nbsp;</label>
                 <button type="button" class="btn btn-block action-button btn-sm" id="paymentDtlBtn"  style="width: 60%;">Show</button>



                   <!-- Total <span class="badge" id="total_amount_value">7</span> -->

               </div>

              </div>



              </div> <!-- End of search block -->





        

             

            </div><!-- /.card-body -->

        </div><!-- /.card -->

  </section>
        <div class="formblock-box">

                <div style="text-align: center;display:none;" id="loader">

                   <img src="<?php echo base_url(); ?>assets/img/loader.gif" width="90" height="90" id="gear-loader" style="margin-left: auto;margin-right: auto;"/>

                   <span style="color: #bb6265;">Loading...</span>

               </div>

              <div id="member_payment_list">

            

            

              </div>



              </div>



