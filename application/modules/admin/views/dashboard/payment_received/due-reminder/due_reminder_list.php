<script src="<?php echo base_url();?>assets/js/customJs/payment_received/due_remider.js"></script>
<section class="layout-box-content-format1">

<div class="card card-primary">

       <div class="list-summary">

              <div class="row summary-box-container">
                  <div class="col-md-3 "> 
                    </div>
                    <div class="col-md-3 ">
                    </div>
                    <div class="col-md-3 ">
                    </div> 

                <div class="col-md-3 summary-box bg-4">
                     <div class="row">
                      <div class="col-md-3 align-vh-center">
                         <i class="fab fa-algolia"></i>
                      </div>
                       <div class="col-md-9">
                          <h3>Total Due</h3>
                         <h4><span  id="total_amount_due">0.00</span></h4>
                    </div>
                  </div>
                </div>                

              </div>
            </div>



    <div class="card-header box-shdw">
      <h3 class="card-title">Due Reminder List</h3>
       <!-- <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >
      <a href="<?php echo admin_with_base_url(); ?>enquiry/addeditenquiry" class="btn btn-default btnpos">
       <i class="fas fa-plus"></i> Add Enquiry</a>
    </div> -->
     
      
    </div><!-- /.card-header -->
   


   
    <div class="card-body">  
     

    <div class="list-search-block">
               <div class="row box">  
                             
                  <div class="col-sm-2">
                    <label for="from_dt">From Date</label>
                       <div class="form-group">
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                            </div>
                            <input type="text" class="form-control datepicker" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask="" name="from_dt" id="from_dt" im-insert="false" value="" readonly>
                          </div>
                        </div>
                       
                    </div>
                   
                    <div class="col-sm-2">
                    <label for="to_date">To Date</label>
                       <div class="form-group">
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                            </div>
                            <input type="text" class="form-control datepicker" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask="" name="to_date" id="to_date" im-insert="false" value="" readonly>
                          </div>
                        </div>
                         
                    </div> 
                    <div class="col-sm-2">
                    <label for="branch">Branch</label>
                      <div class="form-group">
                       <div class="input-group input-group-sm">
                            
                        <select class="form-control select2" name="branch" id="branch">
                              <option value="">Select</option>
                              <?php foreach($branchlist as $branchlist){ ?>
                                      <option value='<?php echo $branchlist->BRANCH_CODE; ?>'><?php echo $branchlist->BRANCH_NAME; ?></option>
                                <?php } ?>
                            </select>
                          </div>
                        </div>
                       
                    </div>
                    <div class="col-sm-2">
                    <label for="category">Category</label>
                      <div class="form-group">
                       <div class="input-group input-group-sm">
                            
                        <select class="form-control select2" name="category" id="category">
                              <option value="">Select</option>
                              <?php foreach($packagecatlist as $packagecatlist){ ?>
                                      <option value='<?php echo $packagecatlist->id; ?>'><?php echo $packagecatlist->category_name; ?></option>
                                <?php } ?>
                            </select>
                          </div>
                        </div>
                       
                    </div>
                    <div class="col-sm-3">
                    <label for="card">Package</label>
                      <div class="form-group">
                       <div class="input-group input-group-sm">
                            
                        <select class="form-control select2" name="card" id="card">
                              <option value="">Select</option>
                            
                              
                            </select>
                          </div>
                        </div>
                       
                    </div>
                   
                   
                    
                    
                <div class="col-md-1">
                <label for="payment">&nbsp;</label>
                 <button type="button" class="btn btn-block action-button btn-sm" id="dueviewbtn" >Show</button>

                   <!-- Total <span class="badge" id="total_amount_value">7</span> -->
               </div>
             
              </div>

              </div> <!-- End of search block -->

      <div class="formblock-box">
      <div style="text-align: center;display:none;" id="loader">
           <img src="<?php echo base_url(); ?>assets/img/loader.gif" width="90" height="90" id="gear-loader" style="margin-left: auto;margin-right: auto;"/>
           <span style="color: #bb6265;">Loading...</span>
       </div>

      <div id="due_reminder_list">
        <table id="" class="table customTbl table-bordered table-hover dataTable tablepad">
          <thead>
              <tr>
              <th style="width:55px;">Sl.No</th>              
              <th style="width:110px;">Membership No.<br>Validity Pd<br>Mobile No.</th> 
              <th style="width:90px;">Name </th>
              <th style="width:60px;">Package</th>
              <th style="width:100px;">Reg Dt</th>
              <th  style="width:80px;">Payment Dt</th> 
              <th  style="width:150px;">Prm</th>  
               <th style="width:150px;">Paid</th>               
              <th style="width:80px;">Payable Dt <br>Cheque No. <br>Bank<br>Branch</th>  
              <th style="width:80px;">Due</th>  
              <th style="width:80px;">Branch</th>  
              <!-- <th style="width:80px;">Attd</th>   -->
              <th style="width:80px;">Action</th>  
                       
              
                       
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