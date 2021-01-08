<script src="<?php echo base_url();?>assets/js/customJs/account/reports/daily_collection.js"></script>
<section class="layout-box-content-format1">

<div class="card card-primary">
    <div class="card-header box-shdw">
      <h3 class="card-title">Collection Register</h3>
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
                    <label for="cash_account_id">Cash Account</label>
                      <div class="form-group">
                       <div class="input-group input-group-sm">
                            
                        <select class="form-control select2" name="cash_account_id" id="cash_account_id">
                              <!-- <option value="">Select</option> -->
                              <?php foreach($cashaccountlist as $cashaccountlist){ ?>
                                      <option value='<?php echo $cashaccountlist->account_id; ?>'><?php echo $cashaccountlist->account_description; ?></option>
                                <?php } ?>
                            </select>
                          </div>
                        </div>
                      
                    </div>
                    
                    

                <div class="col-md-2">
                <label for="payment">&nbsp;</label>
                 <button type="button" class="btn btn-block action-button btn-sm" id="dailycollectionviewbtn" style="width: 60%;">Show</button>

                   <!-- Total <span class="badge" id="total_amount_value">7</span> -->
               </div>
              </div>

              </div> <!-- End of search block -->

      <div class="formblock-box">
      <div style="text-align: center;display:none;" id="loader">
           <img src="<?php echo base_url(); ?>assets/img/loader.gif" width="90" height="90" id="gear-loader" style="margin-left: auto;margin-right: auto;"/>
           <span style="color: #bb6265;">Loading...</span>
       </div>

      <div id="daily_collection_list">
        <table  class="table customTbl table-bordered table-hover dataTable tablepad">
          <thead>
              <tr>
              <th >Sl.No</th>              
              <th >Date</th>
              <th >Cash Opening</th>
              <th >Cash Coll.</th>
              <th >Cash Rcvd</th>
              <th ">Chq. Coll. </th>             
              <th  >Card Coll.</th>  
              <th  >Payment Gateway</th>  
              <th  >Fund Transfer</th>  
              <th  >Ref Pbl.</th>  
              <th ">Tot. Cash</th>  
              <th >Today's Coll.</th>  
              <th ">Cash Dep.</th>  
              <th >Cash Exp.</th>  
              <th >Ref. Paid</th>              
              <th ">Bal. Cash</th>
                                  
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

<!-- Modal -->
<section class="layout-box-content-format1">
<div class="modal fade" id="dailycollectionlistmodel"  role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header card-header box-shdw" style="color: white;">
              <h5 class="modal-title"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                <span aria-hidden="true">×</span>
              </button>
            </div>          
            <div style="text-align: center;display:none;" id="modalloader">
           <img src="<?php echo base_url(); ?>assets/img/loader.gif" width="90" height="90" id="gear-loader" style="margin-left: auto;margin-right: auto;"/>
           <span style="color: #bb6265;">Loading...</span>
           </div>
            <div id="dailycollModalBody"  class="modal-body">
                

            </div>      
               
               <div class="modal-footer ">
                
                 <button type="button" class="btn btn-sm action-button" data-dismiss="modal">Close</button>
               </div>
             </div>
             <!-- /.modal-content -->
           </div>
           <!-- /.modal-dialog -->
         </div>
     </section>