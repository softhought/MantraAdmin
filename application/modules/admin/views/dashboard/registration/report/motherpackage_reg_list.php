<script src="<?php echo base_url();?>assets/js/customJs/registraion/mother_package_reg.js"></script>
<section class="layout-box-content-format1">

<div class="card card-primary">
    <div class="card-header box-shdw">
      <h3 class="card-title">Registration - Mother Package</h3>
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
                            <input type="text" class="form-control datepicker2" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask="" name="from_dt" id="from_dt" im-insert="false" value="" readonly>
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
                            <input type="text" class="form-control datepicker2" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask="" name="to_date" id="to_date" im-insert="false" value="" readonly>
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
                                      <option value='<?php echo $branchlist->BRANCH_ID; ?>'><?php echo $branchlist->BRANCH_NAME; ?></option>
                                <?php } ?>
                            </select>
                          </div>
                        </div>
                        
                    </div>

                    <div class="col-sm-2">
                    <label for="status">Status</label>
                      <div class="form-group">
                       <div class="input-group input-group-sm">
                            
                        <select class="form-control select2" name="status" id="status">
                              <!-- <option value="">Select</option> -->
                              <?php
                                   foreach (json_decode(MOTHER_PACKAGE_STATUS) as $key=>$value){  ?>
                                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                 <?php }
                              ?>
                              
                            </select>
                          </div>
                        </div>
                        
                    </div>
                    <div class="col-sm-2">
                    <label for="search_by">Search By</label>
                      <div class="form-group">
                       <div class="input-group input-group-sm">
                            
                        <select class="form-control select2" name="search_by" id="search_by">
                              <!-- <option value="">Select</option> -->
                              <?php
                                   foreach (json_decode(MOTHER_PACKAGE_SEARCH) as $key=>$value){  ?>
                                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                 <?php }
                              ?>
                              
                            </select>
                          </div>
                        </div>
                        
                    </div>
                    <div class="col-sm-4">
                    <label for="package">Package</label>
                      <div class="form-group">
                       <div class="input-group input-group-sm">
                            
                        <select class="form-control select2" name="package" id="package">
                              <option value="">Select</option>
                              <?php foreach($cardlist as $cardlist){ ?>
                                      <option value='<?php echo $cardlist->CARD_ID; ?>'><?php echo $cardlist->CARD_DESC; ?></option>
                                <?php } ?>
                            </select>
                          </div>
                        </div>
                        
                    </div>
                    <div class="col-sm-2">
                    <label for="trainer">Trainer</label>
                      <div class="form-group">
                       <div class="input-group input-group-sm">
                            
                        <select class="form-control select2" name="trainer" id="trainer">
                              <option value="">Select</option>
                              <?php foreach($trainerlist as $trainerlist){ ?>
                                      <option value='<?php echo $trainerlist->empl_id; ?>'><?php echo $trainerlist->empl_name; ?></option>
                                <?php } ?>
                            </select>
                          </div>
                        </div>
                        
                    </div>
                    <div class="col-sm-2">
                    <label for="doneby">Done By</label>
                      <div class="form-group">
                       <div class="input-group input-group-sm">
                            
                        <select class="form-control select2" name="doneby" id="doneby">
                              <option value="">Select</option>
                              <?php
                                    $userlist1 = $userlist;
                              
                              foreach($userlist1 as $userlist1){ ?>
                                      <option value='<?php echo $userlist1['id']; ?>'><?php echo $userlist1['name']; ?></option>
                                <?php } ?>
                            </select>
                          </div>
                        </div>
                        
                    </div>
                    <div class="col-sm-2">
                    <label for="close_by">Close By</label>
                      <div class="form-group">
                       <div class="input-group input-group-sm">
                            
                        <select class="form-control select2" name="close_by" id="close_by">
                              <option value="">Select</option>
                              <?php 
                               $userlist2 = $userlist;
                              foreach($userlist2 as $userlist2){ ?>
                                <option value='<?php echo $userlist2['id']; ?>'><?php echo $userlist2['name']; ?></option>
                                <?php } ?>
                            </select>
                          </div>
                        </div>
                        
                    </div>
                   
                   
                   
                   
                <div class="col-md-2">
                <label for="report">&nbsp;</label>
                 <button type="button" class="btn btn-block action-button btn-sm" id="showlistbtn" style="width: 60%;">Show</button>

                   <!-- Total <span class="badge" id="total_amount_value">7</span> -->
               </div>
               <div class="col-md-10">
                        <p class="errormsgcolor" id="errormsg"></p>
                </div>
              </div>
             

              </div> <!-- End of search block -->

      <div class="formblock-box">
      <div style="text-align: center;display:none;" id="loader">
           <img src="<?php echo base_url(); ?>assets/img/loader.gif" width="90" height="90" id="gear-loader" style="margin-left: auto;margin-right: auto;"/>
           <span style="color: #bb6265;">Loading...</span>
       </div>

      <div id="motherpackage_reg_list">
        <table  class="table customTbl table-bordered table-hover dataTable2 tablepad">
          <thead>
              <tr>
              <th style="width:55px;">Sl.No</th>              
              <th style="width:90px;">Reg. Date</th>
              <th style="width:90px;">Pament Date</th>
              <th style="width:90px;">Mem. No</th>            
              <th style="width:100px;">Name </th> 
              <!-- <th style="width:60px;">Branch</th>             -->
              <th style="width:60px;">Validity</th>  
              <th  style="width:80px;">Email</th>            
              <th  style="width:80px;">Gender</th>            
              <th  style="width:150px;">Phone/WhatsApp No.</th>
              <th  style="width:60px;">RCPT</th>  
              <th  style="width:60px;">Trainer</th>  
              <th  style="width:80px;">Closed By</th>  
              <th style="width:100px;">Done By</th>  
              <th style="width:60px;">GST</th>  
              <th style="width:200px;">Action</th>  
                         
             
                                  
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