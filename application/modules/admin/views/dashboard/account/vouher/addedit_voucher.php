<script src="<?php echo base_url();?>assets/js/customJs/account/voucher.js"></script>

<section class="layout-box-content-format1">
        <div class="card card-primary">
            <div class="card-header box-shdw">
              <h3 class="card-title"><?php echo $mode; ?> Voucher</h3>
               <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >
                   <!-- <a href="<?php echo admin_with_base_url(); ?>enquirywing" class="btn btn-info btnpos link_tab">
                  <i class="fas fa-clipboard-list"></i> List </a> -->
                </div>
           
            </div><!-- /.card-header -->
            <div class="card-body">
               <form name="VoucherForm"  id="VoucherForm" enctype="multipart/form-data"> 

               <input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>">
                <input type="hidden" name="vouchermstId" id="vouchermstId" value="<?php echo $vouchermstId; ?>">
              
                <div class="formblock-box">   
                 <div class="voucherdiv">
                  <!-- <div class="row">
                  <div class="col-md-12" style="background-color: #ba411d;color: #fff;padding-left: 10%;">
                      <h5 >Voucher No : <?php if($mode == 'EDIT'){ echo $voucherEditdata->voucher_no; } ?></h5>
                      </div> 
                  </div> -->
                   <div class="row">
                   <label for="daily_collection" class="col-md-2">Voucher No</label>
                             <div class="col-md-2">                                   
                                    <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                            <input type="text" class="form-control forminputs" name="voucher_no" name="voucher_no"  value = "<?php if($mode == 'EDIT'){ echo $voucherEditdata->voucher_no; } ?> " readonly>

                                            </div>
                                        </div>
                                    </div>
                            <label for="daily_collection" class="col-md-2">Daily Collection</label>
                             <div class="col-md-2">                                   
                                    <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                            <input type="checkbox" class="call-checkbox" name="daily_collection" name="daily_collection"  <?php if($mode == 'EDIT' && $voucherEditdata->is_daily_collection == 'Y'){ echo 'checked';  } if($mode == 'ADD'){ echo 'checked'; } ?>>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-2"></div> -->
                            <label for="is_original" class="col-md-2">Adjustment</label>
                             <div class="col-md-2">                                   
                                    <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                            <input type="checkbox" class="call-checkbox" name="is_original" name="is_original" <?php if($mode == 'EDIT' && $voucherEditdata->is_original == 'Y'){ echo 'checked';  }  ?>>

                                            </div>
                                        </div>
                                    </div>
                                    
                                
                      </div>
                      <div class="row">
                      <label class="col-md-2" for="voucher_dt">Date </label>                         
                                <div class="col-md-2">                                       
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">                                           
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control datepicker" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" name="voucher_dt" id="voucher_dt" im-insert="false" value="<?php if($mode == 'EDIT' && $voucherEditdata->voucher_date != ""){ echo date('d-m-Y',strtotime($voucherEditdata->voucher_date)); } ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                           
                                <label for="branch" class="col-md-2 labletext">Branch  </label>
                                <div class="col-md-2">
                                    
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                        <select class="form-control select2" id="branch" name="branch" style="width: 100%;">
                                            <option value=''>Select</option>
                                            <?php 
                                             foreach($Allbranchlist as $branchlist){ ?>
                                                <option value='<?php echo $branchlist->BRANCH_ID; ?>' <?php if($mode == 'EDIT' && $voucherEditdata->branch_id == $branchlist->BRANCH_ID){ echo "selected"; } ?>><?php echo $branchlist->BRANCH_NAME; ?></option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                        </div>
                                    </div>
                            <label for="tranction_type" class="col-md-2 labletext">Transaction Type  </label>
                                <div class="col-md-2">
                                    
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                        <select class="form-control select2" id="tranction_type" name="tranction_type" style="width: 100%;">
                                            <option value=''>Select</option>
                                            <?php foreach(json_decode(TRASANCTION_TYPE) as $key => $value){ ?>
                                                <option value='<?php echo $key; ?>' <?php if($mode == 'EDIT' && $voucherEditdata->tran_type == $key){ echo "selected"; } ?>><?php echo $value; ?></option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                        </div>
                                    </div>
                                   
                                     
                                   
                      </div>
                      </div>
            
                      <div class="voucherdiv">
                      <div class="row">
                      <label for="sub_tranction_type" class="col-md-2 labletext">Sub Tran. Type  </label>
                                <div class="col-md-2">
                                    
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                        <select class="form-control select2" id="sub_tranction_type" name="sub_tranction_type" style="width: 100%;" <?php if($mode == 'ADD'){ echo 'disabled'; } ?>>
                                            <option value='' <?php if($mode == 'EDIT'){ echo 'disabled'; } ?>>Select</option>
                                             <?php if($mode == 'EDIT'){                                                  
                                                 foreach($subtranlist as $key => $value){                                                 
                                                 ?>
                                                    <option value='<?php echo $key; ?>' <?php if($voucherEditdata->tran_sub_type == $key){ echo "selected";}else{ echo "disabled"; } ?>><?php echo $value; ?></option>

                                             <?php } }  ?>
                                           
                                            </select>
                                        </div>
                                        </div>
                                    </div>
                      <label for="category" class="col-sm-2">Package Category</label>
                            <div class="col-sm-2">
                                
                                <div class="form-group">
                                <div class="input-group input-group-sm">
                                        
                                    <select class="form-control select2" name="category" id="category">
                                        <option value="">Select</option>
                                        <?php foreach($packagecatlist as $packagecatlist){ ?>
                                                <option value='<?php echo $packagecatlist->id; ?>'<?php if($mode == 'EDIT' && $voucherEditdata->pkg_cat == $packagecatlist->id){ echo "selected"; } ?>><?php echo $packagecatlist->category_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    </div>
                            
                            </div>
                            <label for="card" class="col-sm-2">Package</label>
                            <div class="col-sm-2">
                           
                            <div class="form-group">
                            <div class="input-group input-group-sm">
                                    
                                <select class="form-control select2" name="card" id="card">
                                    <option value="">Select</option>
                                    <?php
                                     if($mode == 'EDIT'){
                                     foreach($cardlist as $cardlist){  ?>

                                        <option value="<?php echo $cardlist->CARD_ID; ?>" <?php if($voucherEditdata->pkg_id == $cardlist->CARD_ID){ echo "selected"; } ?>><?php echo $cardlist->CARD_DESC; ?></option>';

                                  <?php   }
                                      }
                                    ?>
                                    
                                    </select>
                                </div>
                                </div>
                            
                            </div>
                      
                      </div>
                </div>  
                </div>  
                 
               <div class="formblock-box"> 
                    <div class="row">                         
                                <div class="col-md-2">
                                    <label for="account_tag" class="labletext">Dr / Cr  </label>                                   
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                        <input type="hidden" name="hd_srl" Id="hd_srl">
                                        <select class="form-control select2" id="account_tag" name="account_tag" style="width: 100%;">
                                            <option value=''>Select</option>
                                            <?php foreach(json_decode(ACCOUNT_TAG) as $key => $value){ ?>
                                                <option value='<?php echo $key; ?>' ><?php echo $value; ?></option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                    <label for="account_id" class="labletext">Account</label>                                   
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                        <select class="form-control select2" id="account_id" name="account_id" style="width: 100%;">
                                            <option value=''>Select</option>
                                           
                                            </select>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                    <label for="pay_to" class="labletext">Pay To</label>                                   
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                        <select class="form-control select2" id="pay_to" name="pay_to" style="width: 100%;">
                                            <option value=''>Select</option>
                                            <?php foreach($employeelist as $employeelist){ ?>
                                                <option value='<?php echo $employeelist->empl_id; ?>'><?php echo $employeelist->empl_name; ?></option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                    <label for="pay_month" class="labletext">Month</label>                                   
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                        <select class="form-control select2" id="pay_month" name="pay_month" style="width: 100%;">
                                            <option value=''>Select</option>
                                            <?php foreach(json_decode(MONTH_MASTER) as $key => $value){ ?>
                                                <option value='<?php echo $key; ?>' ><?php echo $value; ?></option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                    <label for="pay_month" class="labletext">Amount</label>                                   
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                         <input type="text" class="form-control forminputs typeahead numberwithdecimal" id="amount" name="amount" placeholder="" autocomplete="off" value="">

                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                    <label for="pay_month" class="labletext">&nbsp;</label>                                   
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                            <button type="button" class="btn btn-sm action-button" id="addentrybtn" >Add</button>
                                        </div>
                                        </div>
                                    </div>
                    
                    </div>
                     <div class="row">
                        <div class="col-md-10">
                               <p class="errormsgcolor" id="adderrormsg"></p>
                            </div>
                     </div>


                      
              
                    <!-- voucher details list -->
                    <div class="voucherdiv" style="height: 200px;">
                    <div class="row ">
                        <!-- <div class="col-sm-1"></div> -->
                            <div class="col-sm-12 ">
                                <div  id="detail_voucher" style="#border: 1px solid #e49e9e;">
                                    <div class="table-responsive">
                                        <?php
                                                $rowno=0;
                                                $detailCount = 0;
                                                if($mode=="EDIT")
                                                {
                                                  $detailCount = count($voucherdtldata);
                                                //$detailCount = 0;
                                                }
                                                // For Table style Purpose
                                                if($mode=="EDIT" && $detailCount>0)
                                                {
                                                    $style_var = "display:block;width:100%;";
                                                }
                                                else
                                                {
                                                    $style_var = "display:none;width:100%;";
                                                }
                                                ?>
                                                <table class="table table-bordered" style="font-size: 13px;color: #354668;line-height:0.8;">
                                                    <thead>   
                                                        <tr>  
                                                            <th>#</th>
                                                            <th>Dr / Cr</th>
                                                            <th>Account</th>
                                                            <th>Pay To</th>
                                                            <th>Pay Month</th>                                         
                                                            <th>Amount</th>                                         
                                                            <th>Action</th> 
                                                        
                                                        </tr>
                                                    </thead>
                                                        <tbody>
                                <?php 
                                     if($mode == 'EDIT'){
                                     foreach($voucherdtldata as $voucherdtldata){ 
                                        $rowno++;
                                         ?>

                                    <tr id="rowcarddetails_<?php echo $rowno; ?>">
                                    <td>
                                        
                                        <?php echo $rowno; ?>
                                        </td>
                                    <td>
                                        <input type="hidden" name="dr_cr_tag_dtl[]" id="dr_cr_tag_dtl_<?php echo $rowno; ?>" value="<?php echo $voucherdtldata->tran_tag; ?>">

                                                
                                        <?php echo $voucherdtldata->tran_tag; ?>
                                    </td>
                                    <td>
                                            <input type="hidden" name="account_id_dtl[]" id="account_id_dtl_<?php echo $rowno; ?>" value="<?php echo $voucherdtldata->acc_id; ?>">
                                        
                                        <?php echo $voucherdtldata->account_description; ?>
                                    </td>
                                    <td>
                                        <input type="hidden" name="pay_to_id_dtl[]" id="pay_to_id_dtl_<?php echo $rowno; ?>" value="<?php echo $voucherdtldata->pay_to_id; ?>">
                                        <?php echo $voucherdtldata->empl_name; ?>
                                    </td>
                                    <td>
                                    <input type="hidden" name="pay_month_dtl[]" id="pay_month_dtl_<?php echo $rowno; ?>" value="<?php echo $voucherdtldata->pay_month; ?>">
                                        <?php echo $voucherdtldata->pay_month; ?>
                                    </td>
                                    <td>
                                    <input type="hidden" class="listamounted" name="amountdtl[]" id="amountdtl_<?php echo $rowno; ?>" value="<?php echo $voucherdtldata->amount; ?>">
                                        <?php echo $voucherdtldata->amount; ?>
                                    </td>
                                    <td>
                                        <a href="javascript:;" class="editvoucherDetails" id="delDocRow_<?php echo $rowno; ?>" title="Edit">
                                        <i class="far fa-edit" style="color: #2a92d4;font-weight:700;padding-right: 6px;"></i></a>

                                        <a href="javascript:;" class="delvoucherDetails" id="delDocRow_<?php echo $rowno; ?>" title="Delete">
                                        <i class="far fa-trash-alt" style="color: #d04949;; font-weight:700;"></i></a>
                                    </td>
                                    </tr>



                                                        <?php  } } ?>
                                                        
                                                        </tbody>
                                                        <input type="hidden" name="rowno" id="rowno" value="<?php echo $rowno;?>">
                                                        <input type="hidden" name="is_voucher_dtl" id="is_voucher_dtl" value="N">  
                                                </table>
                                        </div><!-- end of table responsive -->
                                    </div>                                                   

                        </div>           

                    </div>


          </div>

          <div class="row">
                <div class="col-md-1"></div>
                    <div class="col-md-3">
                        <label for="groupname">Total Dr</label>
                        <div class="form-group">
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" name="total_dr" id="total_dr" placeholder="" value="<?php if($mode == 'EDIT'){ echo $voucherEditdata->total_dr_amt; } ?>" readonly >
                        </div>
                    </div>               

                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-3">
                        <label for="groupname">Total Cr</label>
                        <div class="form-group">
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" name="total_cr" id="total_cr" placeholder="" value="<?php if($mode == 'EDIT'){ echo $voucherEditdata->total_cr_amt; } ?>" readonly >
                        </div>
                    </div>                

                    </div>  



                </div>


          </div>  
          <div class="formblock-box"> 
                <div class="row">

                   <div class="col-md-6">
                         <label for="narration" class="labletext">Narration</label>
                        <div class="form-group"> 
                                <div class="input-group input-group-sm">
                                    <textarea cols="60" rows="5" name="narration" id="narration"><?php if($mode == 'EDIT'){ echo $voucherEditdata->narration;  }  ?></textarea>
                                </div> 
                   </div>
                   </div>
                   <div class="col-md-6">
                       <div class="row">
                           <label for="cheque_no" class="col-md-4 labletext">Cheque No.</label>
                            <div class="col-md-8">                                                                       
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                             <input type="text" class="form-control forminputs typeahead" id="cheque_no" name="cheque_no" placeholder="" autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $voucherEditdata->cheque_no;  }  ?>">
                                        </div>
                                        </div>
                                    </div>
                       </div>
                       <div class="row">
                           <label for="cheque_date" class="col-md-4 labletext">Cheque Date</label>
                            <div class="col-md-8">                                                                       
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                              <input type="text" class="form-control datepicker" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" name="cheque_date" id="cheque_date" im-insert="false" value="<?php if($mode == 'EDIT' && $voucherEditdata->cheque_date != "" && $voucherEditdata->cheque_date != '0000-00-00 00:00:00'){ echo date('d-m-Y',strtotime($voucherEditdata->cheque_date)); } ?>" readonly>
                                            
                                        </div>
                                        </div>
                                    </div>
                       </div>
                       <div class="row">
                           <label for="bank_name" class="col-md-4 labletext">Bank</label>
                            <div class="col-md-8">                                                                       
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                             <input type="text" class="form-control forminputs typeahead" id="bank_name" name="bank_name" placeholder="" autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $voucherEditdata->bank_name;  }  ?>">
                                        </div>
                                        </div>
                                    </div>
                       </div>
                       <div class="row">
                           <label for="branch_name" class="col-md-4 labletext">Branch</label>
                            <div class="col-md-8">                                                                       
                                        <div class="form-group"> 
                                        <div class="input-group input-group-sm">
                                             <input type="text" class="form-control forminputs typeahead" id="branch_name" name="branch_name" placeholder="" autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $voucherEditdata->bank_branch;  }  ?>">
                                        </div>
                                        </div>
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
                                <button type="submit" class="btn btn-sm action-button" id="vouchersavebtn" style="width: 57%;"><?php echo $btnText; ?></button>

                                    <span class="btn btn-sm action-button loaderbtn" id="loaderbtn" style="display:none;width: 57%;"><?php echo $btnTextLoader; ?></span>

                                </div>
                            </div>
                    </div>
                    </form>
                               
         </div>
</div><!-- /.card-body -->

</section>