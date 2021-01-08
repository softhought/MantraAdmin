<script src="<?php echo base_url();?>assets/js/customJs/account/cash_deposit.js"></script>

<section class="layout-box-content-format1">
        <div class="card card-primary">
            <div class="card-header box-shdw">
              <h3 class="card-title"><?php echo $mode; ?> Cash Deposit</h3>
               <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >
                   <a href="<?php echo admin_with_base_url(); ?>cashdeposit" class="btn btn-info btnpos link_tab">
                  <i class="fas fa-clipboard-list"></i> List </a>
                </div>          

            </div><!-- /.card-header -->
            <div class="card-body">
               <form name="CashdepositForm"  id="CashdepositForm" enctype="multipart/form-data"> 
               <input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>">
                <input type="hidden" name="tranId" id="tranId" value="<?php echo $tranId; ?>">
                <input type="hidden" name="voucherId" id="voucherId" value="<?php echo $voucherId; ?>">

                <div class="formblock-box">                           

                           <div class="row"> 
                            <label for="date_of_deposit" class="col-md-2">Date*</label>
                                <div class="col-md-3">
                                       
                                        <div class="form-group">
                                        <div class="input-group input-group-sm"> 
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control datepicker" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" name="date_of_deposit" id="date_of_deposit" im-insert="false" value="<?php if($mode == 'EDIT' && $cashdepositEditdata->date_of_deposit != ""){ echo date('d-m-Y',strtotime($cashdepositEditdata->date_of_deposit)); } ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                            <label for="branch" class="col-sm-2">Branch*</label>
                            <div class="col-sm-3">
                                    
                                    <div class="form-group">
                                    <div class="input-group input-group-sm">
                                            
                                        <select class="form-control select2" name="branch" id="branch" >
                                            <option value="">Select</option>
                                            <?php foreach($branchlist as $branchlist){ ?>
                                                    <option value='<?php echo $branchlist->BRANCH_ID; ?>' <?php if($mode == 'EDIT' && $cashdepositEditdata->branch_id == $branchlist->BRANCH_ID){  echo 'Selected'; } ?>><?php echo $branchlist->BRANCH_NAME; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        </div>
                                        
                                    </div> 
                            </div>
                            <div class="row">
                            <label for="debit_acc_id" class="col-sm-2">Debit Account*</label>
                            <div class="col-sm-3">
                                    
                                    <div class="form-group">
                                    <div class="input-group input-group-sm">
                                            
                                        <select class="form-control select2" name="debit_acc_id" id="debit_acc_id" >
                                            <option value="">Select</option>
                                            <?php 
                                                  $debitaccountlist  = $CreditDebitAccountList;
                                            foreach($debitaccountlist as $debitaccountlist){ ?>
                                                    <option value='<?php echo $debitaccountlist->account_id; ?>' <?php if($mode == 'EDIT' && $debitaccdtl->acc_id == $debitaccountlist->account_id){  echo 'Selected'; } ?>><?php echo $debitaccountlist->account_description; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        </div>
                                        
                                    </div> 
                            </div>
                            <div class="row">
                            <label for="credit_acc_id" class="col-sm-2">Credit Account*</label>
                            <div class="col-sm-3">
                                    
                                    <div class="form-group">
                                    <div class="input-group input-group-sm">
                                            
                                        <select class="form-control select2" name="credit_acc_id" id="credit_acc_id" >
                                            <option value="">Select</option>
                                            <?php $creditaccountlist  = $CreditDebitAccountList;
                                                 foreach($creditaccountlist as $creditaccountlist){ ?>
                                                    <option value='<?php echo $creditaccountlist->account_id; ?>' <?php if($mode == 'EDIT' && $Creditaccountdtl->acc_id == $creditaccountlist->account_id){  echo 'Selected'; } ?>><?php echo $creditaccountlist->account_description; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        </div>
                                        
                                    </div> 
                            </div>
                            <div class="row"> 
                            <label for="deposit_amt" class="col-md-2">Deposit Amt.*</label>
                                <div class="col-md-3">
                                       
                                        <div class="form-group">
                                        <div class="input-group input-group-sm"> 
                                       
                                            <input type="text" class="form-control numberwithdecimal"  name="deposit_amt" id="deposit_amt"  value="<?php if($mode == 'EDIT'){ echo $cashdepositEditdata->deposit_amt; } ?>" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                                                   

                </div>



                    <div class="formblock-box">

                        <div class="row">

                            <div class="col-md-10">

                               <p class="errormsgcolor" id="errormsg"></p>

                            </div>

                                <div class="col-md-2 text-right">

                                <button type="submit" class="btn btn-sm action-button" id="cashdepositsavebtn" style="width: 57%;"><?php echo $btnText; ?></button>



                                    <span class="btn btn-sm action-button loaderbtn" id="loaderbtn" style="display:none;width: 57%;"><?php echo $btnTextLoader; ?></span>



                                </div>

                            </div>

                    </div>

                    </form>

                               

         </div>

</div><!-- /.card-body -->



</section>