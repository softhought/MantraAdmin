<script src="<?php echo base_url();?>assets/js/customJs/front_office/amc.js"></script>



<section class="layout-box-content-format1">

        <div class="card card-primary">

            <div class="card-header box-shdw">

              <h3 class="card-title"><?php echo $mode; ?> AMC</h3>

               <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >

                   <a href="<?php echo admin_with_base_url(); ?>annualmaintanancechrg" class="btn btn-info btnpos link_tab">

                  <i class="fas fa-clipboard-list"></i> List </a>

                </div>

           

            </div><!-- /.card-header -->

            <div class="card-body">

               <form name="AmcForm"  id="AmcForm" enctype="multipart/form-data"> 



               <input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>">

                <input type="hidden" name="amcId" id="amcId" value="<?php echo $amcId; ?>">



                <div class="formblock-box">   

                         

                           <div class="row">                                                     

                                <label for="item_name" class="col-md-2 labletext">Item Name*  </label>
                                    <div class="col-md-3">
                                        
                                            <div class="form-group"> 
                                            <div class="input-group input-group-sm">
                                            <select class="form-control select2" id="item_name" name="item_name" style="width: 100%;">
                                                <option value=''>Select</option>
                                                <?php foreach($statutorylist as $statutorylist){ ?>
                                                <option value='<?php echo $statutorylist->id; ?>' <?php if($mode == "EDIT" && $amcEditdata->statutory_id == $statutorylist->id){ echo "selected"; } ?>><?php echo $statutorylist->statutory_name; ?></option>
                                                <?php } ?>
                                            
                                                </select>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                            <div class="row">       
                              <label class="col-md-2 labletext" for="followup_date">Expiry Date* </label>                         
                                <div class="col-md-3">
                                       
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">                                           
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control datepicker2" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" name="expiry_date" id="expiry_date" im-insert="false" value="<?php if($mode == 'EDIT' && $amcEditdata->expiry_date != ""){ echo date('d-m-Y',strtotime($amcEditdata->expiry_date));  }  ?>" readonly>
                                        </div>
                                    </div>
                                </div> 
                             
                            </div>
                            
                            <div class="row">                                                     

                                    <label for="item_name" class="col-md-2 labletext">Renewal Amount*  </label>
                                        <div class="col-md-3">
                                            
                                                <div class="form-group"> 
                                                <div class="input-group input-group-sm">
                                                <input type="text" class="form-control forminputs typeahead numberwithdecimal" id="renewal_amt" name="renewal_amt" placeholder="Enter Renewal Amount" autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $amcEditdata->renewal_amt;  }  ?>">

                                                </div>
                                                </div>
                                            </div> 
                    </div> 
                    <div class="row">                                                     

                                <label for="item_name" class="col-md-2 labletext">Vendor Name*  </label>
                                    <div class="col-md-3">
                                        
                                            <div class="form-group"> 
                                            <div class="input-group input-group-sm">
                                            <select class="form-control select2" id="account_id" name="account_id" style="width: 100%;">
                                                <option value=''>Select</option>
                                                <?php foreach($vendorlist as $vendorlist){ ?>
                                                <option value='<?php echo $vendorlist->account_id; ?>' <?php if($mode == "EDIT" && $amcEditdata->account_id == $vendorlist->account_id){ echo "selected"; } ?>><?php echo $vendorlist->account_description; ?></option>
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

                                <button type="submit" class="btn btn-sm action-button" id="savebtn" style="width: 57%;"><?php echo $btnText; ?></button>



                                    <span class="btn btn-sm action-button loaderbtn" id="loaderbtn" style="display:none;width: 57%;"><?php echo $btnTextLoader; ?></span>



                                </div>

                            </div>

                    </div>

                    </form>

                               

         </div>

</div><!-- /.card-body -->



</section>