<script src="<?php echo base_url();?>assets/js/customJs/account/onp_voucher.js"></script>
<section class="layout-box-content-format1">

<div class="card card-primary">
    <div class="card-header box-shdw">
      <h3 class="card-title">Online Payment List</h3>
       <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >
      <!-- <a href="<?php echo admin_with_base_url(); ?>cashdeposit/addeditcashdeposit" class="btn btn-default btnpos">
       <i class="fas fa-plus"></i> Add </a> -->
    </div>
     
      
    </div><!-- /.card-header -->
   
    <div class="card-body">   
    <div class="list-search-block">
               <div class="row box">  
                             
                  
                   
                   
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
                 <button type="button" class="btn btn-block action-button btn-sm" id="onptovoucherhowbtn">Show</button>


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

       <div id="onpvoucher_list">
        <table class="table customTbl table-bordered table-hover dataTable tablepad">
          <thead>
              <tr>
              <th>Sl.No</th>
              <th>Membership No</th> 
              <th>Name</th>  
              <th>Mobile</th>  
              <th>Branch</th>  
              <th>Card Code</th>  
              <th>Payment Date</th>  
              <th>Voucher A</th>  
              <th>Voucher B</th>  
              <th>Amount</th>  
              <th>Action</th>
                                  
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