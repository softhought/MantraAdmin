<script src="<?php echo base_url();?>assets/js/customJs/front_office/attendance_reg.js"></script>
<section class="layout-box-content-format1">

<div class="card card-primary">
    <div class="card-header box-shdw">
      <h3 class="card-title">Attendance Ranking</h3>
       <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >
      <!-- <a href="<?php echo admin_with_base_url(); ?>enquiry/addeditenquiry" class="btn btn-default btnpos">
       <i class="fas fa-plus"></i> Add Enquiry</a> -->
    </div>
     
      
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
                        <p id="fromdaterr" style="font-size: 12px;"></p>
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
                         <p id="todateerr" style="font-size: 12px;"></p>
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
                        <p id="studenterr" ></p>
                    </div>                  
                  
                    <div class="col-sm-2">
                    <label for="mobile_no">Mobile No.</label>
                      <div class="form-group">
                       <div class="input-group input-group-sm">                            
                           <input type="text" class="form-control onlynumber" name="mobile_no" id="mobile_no" value="" maxlength="10">
                          </div>
                        </div>
                        <p id="studenterr" ></p>
                    </div>  

                    <div class="col-sm-3">
                    <label for="branch">Package</label>
                      <div class="form-group">
                       <div class="input-group input-group-sm">
                            
                        <select class="form-control select2" name="package" id="package">
                              <option value="">Select</option>
                             
                            </select>
                          </div>
                        </div>
                        <p id="studenterr" ></p>
                    </div> 
                  

                <div class="col-md-1">
                <label for="payment">&nbsp;</label>
                 <button type="button" class="btn btn-block action-button btn-sm" id="registerrankingshowbtn">Show</button>


                   <!-- Total <span class="badge" id="total_amount_value">7</span> -->
               </div>
               <div class="col-md-12">
               <p class="errormsgcolor" id="errormsg"></p>
               </div>
              </div>

              </div> <!-- End of search block -->

      <div class="formblock-box">
      <div style="text-align: center;display:none;" id="loader">
           <img src="<?php echo base_url(); ?>assets/img/loader.gif" width="90" height="90" id="gear-loader" style="margin-left: auto;margin-right: auto;"/>
           <span style="color: #bb6265;">Loading...</span>
       </div>

      <div id="attendance_ranking_list">
        <table  class="table customTbl table-bordered table-hover dataTable tablepad">
          <thead>
          <tr>
              <th width="6%">Sl.No</th> 
              <th  width="10%">Membership No</th>
              <th width="15%">Name </th>             
              <th  width="10%">Mobile No.</th>  
              <th  width="12%">Validity String</th> 
              <th width="7%">Present Days</th>                         
              <!-- <th width="10%">Action</th> -->
                                  
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