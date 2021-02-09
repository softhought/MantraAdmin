<script src="<?php echo base_url();?>assets/js/customJs/registration/product_sale.js"></script>

<section class="layout-box-content-format1">
    <div class="card card-primary">
        <div class="card-header box-shdw">
            <h3 class="card-title">Product Sale (GST)</h3>

            <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons">
                <!-- <a href="<?php echo admin_with_base_url(); ?>statutorymaster" class="btn btn-info btnpos link_tab">

                  <i class="fas fa-clipboard-list"></i> List </a> -->
            </div>
        </div>
        <!-- /.card-header -->

        <div class="card-body">
            <form name="ProductSaleForm" id="ProductSaleForm" enctype="multipart/form-data">
                <input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>" />
                <input type="hidden" name="product_id" id="product_id" value="<?php echo $product_id; ?>" />
                <!-- <input type="hidden" name="payment_id" id="payment_id" value="<?php echo $payment_id; ?>"> -->

                <div class="formblock-box">
                    <div class="row">
                        <label for="date_of_sale" class="col-md-2 labletext">Date of Sale*</label>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                    </div>
                                    <input
                                        type="text" class="form-control datepicker" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" name="date_of_sale" id="date_of_sale"
                                        im-insert="false" value="" readonly />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="branch" class="col-md-2 labletext">Branch*</label>
                        <div class="col-md-4 ">
                            <div class="form-group">
                                <div class="input-group input-group-sm">
                                    <select name="branch" id="branch" class="form-control select2">
                                        <option value="">Select </option>
                                        <?php 
                                               $branchlist1 = $branchlist;
                                        foreach($branchlist1 as $branchlist1){?>
                                        <option value="<?php echo $branchlist1->BRANCH_ID;?>" data-code="<?php echo $branchlist1->BRANCH_CODE;?>"><?php echo $branchlist1->BRANCH_NAME; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="sel_card" class="col-md-2 labletext">Existing Package*</label>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="input-group input-group-sm">
                                    <select name="sel_card" id="sel_card" class="form-control select2">
                                        <option value="">Select Package</option>
                                        <?php foreach($cardlist as $cardlist){?>
                                        <option value="<?php echo $cardlist->CARD_ID;?>" data-card="<?php echo $cardlist->CARD_CODE;?>"><?php echo $cardlist->CARD_DESC.' ('.$cardlist->CARD_CODE.')'; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="sel_name" class="col-md-2 labletext">Name*</label>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="input-group input-group-sm">
                                    <select name="sel_name" id="sel_name" class="form-control select2">
                                        <option value="">Select Member </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <label for="sel_product" class="col-md-2 labletext">Product Chosen*</label>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="input-group input-group-sm">
                                    <select name="sel_product" id="sel_product" class="form-control select2">
                                        <option value="">Select Product</option>
                                        <?php foreach($productlist as $productlist){?>
                                        <option value="<?php echo $productlist->PROD_ID;?>"><?php echo $productlist->PROD_DESC; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <label for="wallet_cashback" class="col-md-2 labletext dispnone walleterr">Wallet</label>
                        <div class="col-md-3 dispnone walleterr">
                            <div class="form-group">
                                <div class="input-group input-group-sm">
                                    <select class="form-control select2" id="wallet_cashback" name="wallet_cashback" style="width: 100%;">
                                        <option value="">Select</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <label for="renewal_amt" class="col-md-2 labletext">Basic Fees*</label>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control forminputs" id="premium_amt" name="premium_amt" placeholder="" autocomplete="off" value="" readonly />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="payment_now" class="col-md-2 labletext">Payment Now*</label>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control forminputs" id="payment_now" name="payment_now" placeholder="" autocomplete="off" value="" readonly/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <label for="cgstrate" class="col-md-2 labletext">CGST</label>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="input-group input-group-sm">
                                    <select name="cgstrate" id="cgstrate" class="form-control select2">
                                        <option value="0">Select </option>
                                        <?php foreach($cgstlist as $row_cgst){?>
                                        <option value="<?php echo $row_cgst->id;?>"><?php echo $row_cgst->rate; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <label for="cgstAmount" class="col-md-2 labletext">CGST Amount</label>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="input-group input-group-sm">
                                    <input name="cgstAmount" id="cgstAmount" type="text" class="form_input_text form-control forminputs" autocomplete="off" readonly />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="sgstrate" class="col-md-2 labletext">SGST</label>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="input-group input-group-sm">
                                    <select name="sgstrate" id="sgstrate" class="form-control select2">
                                        <option value="0">Select </option>
                                        <?php foreach($sgstlist as $row_cgst){?>
                                        <option value="<?php echo $row_cgst->id;?>"><?php echo $row_cgst->rate; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <label for="sgstAmount" class="col-md-2 labletext">SGST Amount</label>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="input-group input-group-sm">
                                    <input name="sgstAmount" id="sgstAmount" type="text" class="form_input_text form-control forminputs" autocomplete="off" readonly />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <label for="payable_amt" class="col-md-2 labletext">Payable</label>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="input-group input-group-sm">
                                    <input name="payable_amt" id="payable_amt" type="text" class="form_input_text form-control forminputs" autocomplete="off" readonly />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="sel_self_guest" class="col-md-2 labletext">Self/Guest</label>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="input-group input-group-sm">
                                    <select name="sel_self_guest" id="sel_self_guest" class="form-control select2">
                                        <!-- <option value="0">Select </option> -->
                                        <?php foreach($memtype as $key=>$value){?>
                                        <option value="<?php echo $key;?>"><?php echo $value; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="guest_name" class="col-md-2 labletext">
                            Guest Name<br />

                            <label for="guest_mobile" class="" style="padding-top: 30px;">Guest Mobile</label>
                        </label>

                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control guestdtl" name="guest_name" id="guest_name" im-insert="false" value="" readonly />
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control guestdtl onlynumber" name="guest_mobile" id="guest_mobile" im-insert="false" value="" readonly />
                                </div>
                            </div>
                        </div>

                        <label for="guest_address" class="col-md-2 labletext">Guest Address</label>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="input-group input-group-sm">
                                    <textarea cols="30" rows="2" name="guest_address " id="guest_address" readonly class="guestdtl"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="collection_branch" class="col-md-2 labletext">Collection Branch*</label>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="input-group input-group-sm">
                                    <select name="collection_branch" id="collection_branch" class="form-control select2">
                                        <option value="">Select </option>
                                        <?php 
                                                    $collectionbrn  = $branchlist;
                                                    foreach($collectionbrn as $collectionbrn){?>
                                        <option value="<?php echo $collectionbrn->BRANCH_ID;?>"><?php echo $collectionbrn->BRANCH_NAME; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="payment_mode" class="col-md-2 labletext">Payment Mode*</label>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="input-group input-group-sm">
                                    <select name="payment_mode" id="payment_mode" class="form-control select2">
                                        <!-- <option value="0">Select </option> -->
                                        <?php foreach(json_decode(PAYMENT_MODE) as $key=>$value){?>
                                        <option value="<?php echo $key;?>"><?php echo $value; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <label for="cheque_no" class="col-md-2 labletext">Cheque No</label>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="input-group input-group-sm">
                                    <input name="cheque_no" id="cheque_no" type="text" class="form_input_text form-control forminputs" autocomplete="off" />
                                </div>
                            </div>
                        </div>
                        <label for="cheque_date" class="col-md-2 labletext">Cheque Date</label>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                    </div>
                                    <input
                                        type="text" class="form-control datepicker2" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" name="cheque_date"
                                        id="cheque_date" im-insert="false" value="" readonly />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="cheque_bank" class="col-md-2 labletext">Bank</label>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="input-group input-group-sm">
                                    <input name="cheque_bank" id="cheque_bank" type="text" class="form_input_text form-control forminputs" autocomplete="off" />
                                </div>
                            </div>
                        </div>
                        <label for="cheque_branch" class="col-md-2 labletext">Branch</label>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="input-group input-group-sm">
                                    <input name="cheque_branch" id="cheque_branch" type="text" class="form_input_text form-control forminputs" autocomplete="off" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="sale_account" class="col-md-2 labletext">Sale A/C*</label>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="input-group input-group-sm">
                                    <select name="sale_account" id="sale_account" class="form-control select2">
                                        <option value="0">Select </option>
                                        <?php foreach($saleaccountlist as $saleaccountlist){?>
                                        <option value="<?php echo $saleaccountlist->account_id;?>"><?php echo $saleaccountlist->account_description; ?></option>
                                        <?php } ?>
                                    </select>
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
                            <button type="submit" class="btn btn-sm action-button" id="productsavebtn" style="width: 57%;"><?php echo $btnText; ?></button>

                            <span class="btn btn-sm action-button loaderbtn" id="loaderbtn" style="display: none; width: 57%;"><?php echo $btnTextLoader; ?></span>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- /.card-body -->
</section>

<div id="productvalidationModal" class="modal fade validation">
    <div class="modal-dialog" style="width: 500px;">
        <div class="modal-content">
            <!-- dialog body -->
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <p id="valid_err" style="font-weight: bold; color: #ca3636;"></p>
            </div>
            <!-- dialog buttons -->
            <!-- <div class="modal-footer"><button type="button" class="btn btn-primary" id="btnhide" >OK</button></div> -->
        </div>
    </div>
</div>
