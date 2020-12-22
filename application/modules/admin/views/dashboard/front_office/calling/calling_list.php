<script src="<?php echo base_url();?>assets/js/customJs/front_office/enquiry.js"></script>
<section class="layout-box-content-format1">

<div class="card card-primary">
    <div class="card-header box-shdw">
      <h3 class="card-title">Enquiry List</h3>
       <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >
      <a href="<?php echo admin_with_base_url(); ?>enquiry/addeditenquiry" class="btn btn-default btnpos">
       <i class="fas fa-plus"></i> Add Enquiry</a>
    </div>
     
      
    </div><!-- /.card-header -->
   
    <div class="card-body">   

    <div class="list-search-block">
               <div class="row box">  
               <div class="col-sm-3">
                    <label for="search_by">Search By</label>
                      <div class="form-group">
                       <div class="input-group input-group-sm">
                            
                        <select class="form-control select2" name="search_by" id="search_by">
                              <!-- <option value="">Select</option> -->
                              <?php
                                   foreach (json_decode(SEARCH_BY) as $key=>$value){  ?>
                                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                 <?php }
                              ?>
                              
                            </select>
                          </div>
                        </div>
                      
                    </div>                
                  <div class="col-sm-2">
                    <label for="from_dt">From Date</label>
                       <div class="form-group">
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                            </div>
                            <input type="text" class="form-control datepicker" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask="" name="from_dt" id="from_dt" im-insert="false" value="<?php echo date("d-m-Y"); ?>" readonly>
                          </div>
                        </div>
                        <p id="fromdaterr" style="font-size: 12px;"></p>
                    </div>
                   
                    <div class="col-sm-2">
                    <label for="to_date">To Date</label>
                       <div class="form-group">
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                            </div>
                            <input type="text" class="form-control datepicker" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask="" name="to_date" id="to_date" im-insert="false" value="<?php echo date("d-m-Y"); ?>" readonly>
                          </div>
                        </div>
                         <p id="todateerr" style="font-size: 12px;"></p>
                    </div> 
                    <div class="col-sm-2">
                    <label for="branch">Branch</label>
                      <div class="form-group">
                       <div class="input-group input-group-sm">
                            
                        <select class="form-control select2" name="branch" id="branch">
                              <option value="">Select</option>
                              <?php foreach($branchlist as $branchlist){ ?>
                                      <option value='<?php echo $branchlist->BRANCH_ID; ?>'><?php echo $branchlist->BRANCH_NAME; ?></option>
                                <?php } ?>
                            </select>
                          </div>
                        </div>
                      
                    </div>
                    <div class="col-sm-3">
                    <label for="wing">Wing Category</label>
                         <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                        <select class="form-control select2" id="category" name="category" style="width: 100%;">
                                        <option value=''>Select</option>
                                                <?php foreach($wingcatlist as $wingcatlist){ ?>
                                                <option value='<?php echo $wingcatlist->cat_id; ?>'  >
                                                <?php echo $wingcatlist->category_name; ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        </div>
                       
                    </div>
                    <div class="col-sm-3">
                    <label for="wing">Wing</label>
                      <div class="form-group">
                       <div class="input-group input-group-sm">
                            
                        <select class="form-control select2" name="wing" id="wing">
                              <option value="">Select</option>
                              <!-- <?php foreach($winglist as $winglist){ ?>
                                      <option value='<?php echo $winglist->wing_name; ?>' ><?php echo $winglist->wing_name; ?></option>
                              <?php } ?> -->
                              
                            </select>
                          </div>
                        </div>
                      
                    </div>
                    <div class="col-sm-3">
                    <label for="caller">Caller</label>
                      <div class="form-group">
                       <div class="input-group input-group-sm">
                            
                        <select class="form-control select2" name="caller" id="caller">
                              <option value="">Select</option>
                              <?php foreach($userlist as $userlist){ ?>
                                      <option value='<?php echo $userlist['id']; ?>' ><?php echo $userlist['name']; ?></option>
                              <?php } ?>
                              
                            </select>
                          </div>
                        </div>
                      
                    </div>
                    <div class="col-sm-2">
                    <label for="mobile_no">Mobile No.</label>
                      <div class="form-group">
                       <div class="input-group input-group-sm">                            
                           <input type="text" class="form-control onlynumber" name="mobile_no" id="mobile_no" value="" maxlength="10">
                          </div>
                        </div>
                      
                    </div>           
                  

                <div class="col-md-2">
                <label for="payment">&nbsp;</label>
                 <button type="button" class="btn btn-block action-button btn-sm" id="viewbtn" style="width: 60%;">Show</button>

                   <!-- Total <span class="badge" id="total_amount_value">7</span> -->
               </div>
              </div>

              </div> <!-- End of search block -->

      <div class="formblock-box">
      <div style="text-align: center;display:none;" id="loader">
           <img src="<?php echo base_url(); ?>assets/img/loader.gif" width="90" height="90" id="gear-loader" style="margin-left: auto;margin-right: auto;"/>
           <span style="color: #bb6265;">Loading...</span>
       </div>

      <div id="calling_list">
        <table  class="table customTbl table-bordered table-hover dataTable2 tablepad">
          <thead>
              <tr>
              <th style="width:55px;">Sl.No</th>              
              <th style="width:90px;">Enquiry Date</th>
              <th style="width:90px;">Enquiry No.</th>
              <th style="width:90px;">Wing</th>
              <th style="width:60px;">Branch</th>
              <th style="width:100px;">Name </th>             
              <th  style="width:70px;">Mobile No.</th>  
              <th  style="width:80px;">Email</th>  
              <th  style="width:60px;">Pin</th>  
              <th  style="width:80px;">Location</th>  
              <th style="width:100px;">Address</th>  
              <th style="width:60px;">Follow-Up</th>  
              <th style="width:200px;">Remarks</th>  
              <th style="width:60px;">Status</th>  
              <th style="width:80px;">Caller</th>              
              <th style="width:150px;">Action</th>
                                  
              </tr>
          </thead>
          <tbody>
          
          </tbody>
        </table>
     </div>
    </div>

    </div><!-- /.card-body -->
</div><!-- /.card -->
</section>