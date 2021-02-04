<script src="<?php echo base_url();?>assets/js/customJs/front_office/special_enquiry.js"></script>
<section class="layout-box-content-format1">

<div class="card card-primary">
    <div class="card-header box-shdw">
      <h3 class="card-title">Special Enquiry </h3>
       <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >
      <!-- <a href="<?php echo admin_with_base_url(); ?>enquiry/addeditenquiry" class="btn btn-default btnpos">
       <i class="fas fa-plus"></i> Add Enquiry</a> -->
    </div>
     
      
    </div><!-- /.card-header -->
   
    <div class="card-body">   

    <div class="list-search-block">
               <div class="row box">  

                    <div class="col-sm-2">
                    <label for="wing">Type</label>
                      <div class="form-group">
                       <div class="input-group input-group-sm">
                            
                        <select class="form-control select2" name="search_type" id="search_type" >
                              <!-- <option value="">Select</option> -->
                              <?php foreach (json_decode(SPECIAL_ENQUIRY) as $key => $value) {
                                # code...
                               ?>
                                      <option value='<?php echo $key; ?>'><?php echo $value; ?></option>
                                <?php } ?>
                            </select>
                          </div>
                        </div>
                        
                    </div> 

                    
                         
                  <div class="col-sm-2 ">
                    <label for="from_dt">From Date</label>
                       <div class="form-group">
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                            </div>
                            <input type="text" class="form-control datepicker2" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask="" name="from_dt" id="from_dt" im-insert="false" value="" readonly>
                          </div>
                        </div>
                       
                    </div>
                   
                    <div class="col-sm-2 ">
                    <label for="to_date">To Date</label>
                       <div class="form-group">
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                            </div>
                            <input type="text" class="form-control datepicker2" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask="" name="to_date" id="to_date" im-insert="false" value="" readonly>
                          </div>
                        </div>
                        
                    </div> 

                      <!-- <div class="col-sm-2 old_mem_div">
                    <label for="wing">Search From</label>
                      <div class="form-group">
                       <div class="input-group input-group-sm" >
                            
                        <select class="form-control select2" name="sel_month" id="sel_month" >
                              <option value="">Select</option>
                              <?php for ($i=1; $i < 25; $i++) { 
                             
                               ?>
                                      <option value='<?php echo $i; ?>'><?php echo $i." month ago"; ?></option>
                                <?php } ?>
                            </select>
                          </div>
                        </div>
                        
                    </div> -->

                   
                        <div class="col-sm-2 old_mem_div" >
                    <label for="wing">Category</label>
                      <div class="form-group">
                       <div class="input-group input-group-sm">
                            
                        <select class="form-control select2" name="sel_category" id="sel_category" >
                              <option value="">Select</option>
                                <?php foreach ($categorylist as $key => $value) {
                                
                               ?>
                                      <option value='<?php echo $value->id; ?>'><?php echo $value->category_name; ?></option>
                                <?php } ?>
                            </select>
                          </div>
                        </div>
                        
                    </div> 

                       <div class="col-sm-2 old_mem_div">
                    <label for="wing">Package</label>
                      <div class="form-group">
                       <div class="input-group input-group-sm" id="package_drp">
                            
                        <select class="form-control select2" name="sel_card" id="sel_card" >
                              <option value="">Select</option>
                           
                            </select>
                          </div>
                        </div>
                        
                    </div> 
                    
                    
                   

                 


                    <div class="col-sm-2">
                    <label for="branch">Branch</label>
                      <div class="form-group">
                       <div class="input-group input-group-sm">
                            
                        <select class="form-control select2" name="branch" id="branch" >
                              <option value="">Select</option>
                              <?php foreach($branchlist as $branchlist){ ?>
                                      <option value='<?php echo $branchlist->BRANCH_ID; ?>'><?php echo $branchlist->BRANCH_NAME; ?></option>
                                <?php } ?>
                            </select>
                          </div>
                        </div>
                       
                    </div> 
                                
                  

                <div class="col-md-1">
                <label for="payment">&nbsp;</label>
                 <button type="button" class="btn btn-block action-button btn-sm" id="specialenquiryshowbtn">Show</button>


                   <!-- Total <span class="badge" id="total_amount_value">7</span> -->
               </div>
               <div class="col-md-12">
               <p class="errormsgcolor" id="errormsg"></p>
                 <div class="alert alert-light alert-dismissible fade show notemsg" role="alert">
 <span id="note_text"><strong>Note: </strong>List of person those who enquired but not converted as member.</span>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
               </div>
              
              </div>

               <div class="row ">  
 <div class="col-md-12">
             
               </div>

               

               </div>

              

              </div> <!-- End of search block -->

              

      <div class="formblock-box">
      <div style="text-align: center;display:none;" id="loader">
           <img src="<?php echo base_url(); ?>assets/img/loader.gif" width="90" height="90" id="gear-loader" style="margin-left: auto;margin-right: auto;"/>
           <span style="color: #bb6265;">Loading...</span>
       </div>
       <center> <div id="response_message" style="font-weight: bold;font-size: 25px;color: #821e70;"></div> </center>
      <div id="specialenquiry_list">
       
     </div>
    </div>

    </div><!-- /.card-body -->
</div><!-- /.card -->
</section>