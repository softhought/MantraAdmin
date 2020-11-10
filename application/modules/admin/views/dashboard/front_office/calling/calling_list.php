<script src="<?php echo base_url();?>assets/js/customJs/front_office/enquiry.js"></script>
<section class="layout-box-content-format1">

<div class="card card-primary">
    <div class="card-header box-shdw">
      <h3 class="card-title">Enquiry List</h3>
       <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >
      <a href="<?php echo admin_with_base_url(); ?>enquiry/addeditenquiry" class="btn btn-default btnpos">
       <i class="fas fa-plus"></i> Add </a>
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
                              <option value="">Select</option>
                              <?php
                                   foreach (json_decode(SEARCH_BY) as $key=>$value){  ?>
                                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                 <?php }
                              ?>
                              
                            </select>
                          </div>
                        </div>
                        <p id="studenterr" ></p>
                    </div>                
                  <div class="col-sm-2">
                    <label for="from_dt">From Date</label>
                       <div class="form-group">
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                            </div>
                            <input type="text" class="form-control datepicker" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" name="from_dt" id="from_dt" im-insert="false" value="<?php echo date("d/m/Y"); ?>" readonly>
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
                            <input type="text" class="form-control datepicker" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" name="to_date" id="to_date" im-insert="false" value="<?php echo date("d/m/Y"); ?>" readonly>
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
                        <p id="studenterr" ></p>
                    </div>
                    <div class="col-sm-3">
                    <label for="wing">Wing</label>
                      <div class="form-group">
                       <div class="input-group input-group-sm">
                            
                        <select class="form-control select2" name="wing" id="wing">
                              <option value="">Select</option>
                              <?php foreach($winglist as $winglist){ ?>
                                      <option value='<?php echo $winglist->wing_name; ?>' ><?php echo $winglist->wing_name; ?></option>
                              <?php } ?>
                              
                            </select>
                          </div>
                        </div>
                        <p id="studenterr" ></p>
                    </div>
                    <div class="col-sm-3">
                    <label for="caller">Caller</label>
                      <div class="form-group">
                       <div class="input-group input-group-sm">
                            
                        <select class="form-control select2" name="caller" id="caller">
                              <option value="">Select</option>
                              <?php foreach($userlist as $userlist){ ?>
                                      <option value='<?php echo $userlist->user_id; ?>' ><?php echo $userlist->name_in_full; ?></option>
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

       <div id="">
        <table class="table customTbl table-bordered table-hover dataTable tablepad">
          <thead>
              <tr>
              <th>Sl.No</th>              
              <th>Enquiry Date</th>
              <th>Branch</th>
              <th>Name </th>             
              <th>Mobile No.</th>  
              <th>Email</th>  
              <th>Pin</th>  
              <th>Location</th>  
              <th>Address</th>  
              <th>Follow-Up</th>  
              <th>Remarks</th>  
              <th>Status</th>  
              <th>Caller</th>              
              <th>Action</th>
                                  
              </tr>
          </thead>
          <tbody>
          <div id="calling_list">
          </div>

          <!-- <?php $i=1;
          foreach ($wingslist as $wingslist) { ?>
            <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo $wingslist->wing_name; ?></td>                    
            <td><?php echo $wingslist->short_description; ?></td>           
          
            <td align="center">
                    <?php if($wingslist->is_active == 'Y'){ ?>
                    <a href="<?php echo admin_with_base_url(); ?>enquirywing/inactivewing/<?php echo $wingslist->wing_id; ?>" class="btn tbl-action-btn padbtn" style="font-size: 15px;padding: 2px 6px 2px 2px;">
                    <i class="fa fa-check"></i> 
                  </a>
                    <?php }else{ ?>
                      <a href="<?php echo admin_with_base_url(); ?>enquirywing/activewing/<?php echo $wingslist->wing_id; ?>" class="btn tbl-action-btn padbtn" style="font-size: 16px;padding: 2px 8px 2px 4px;">
                    <i class="fa fa-times"></i> 
                    <?php } ?>
                    </td>
           
            <td align="center">
              <a href="<?php echo admin_with_base_url(); ?>enquirywing/addeditwings/<?php echo $wingslist->wing_id; ?>" class="btn tbl-action-btn padbtn">
            <i class="fas fa-edit"></i> 
          </a>
        
              
            </td>


          </tr>
          <?php } ?>                        -->
                  
          </tbody>
        </table>
      </div>  
    </div>

    </div><!-- /.card-body -->
</div><!-- /.card -->
</section>