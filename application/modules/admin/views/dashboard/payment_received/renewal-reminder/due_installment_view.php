
<?php for($i=1;$i<=$period;$i++){
    
    if($i==1){ $lable="st"; }
    else if($i==2){ $lable="nd"; }
    else if($i==3){ $lable="rd"; }
    else{ $lable="th"; }
    ?>

<div class="row">  
    <label for="start_dt" class="col-md-2 labletext"><?php echo $i.$lable; ?> Inst. Dt  </label> 
        <div class="col-md-3">                                       
            <div class="form-group">
                    <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                            </div>
                            <input type="text" class="form-control datepicker" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" name="installment_dt[]" id="installmentdt_<?php echo $i; ?>" im-insert="false" value="" readonly>
                    </div>
            </div>
        </div> 
</div> 
<div class="row">                                 
    <label for="first_name" class="col-md-2 labletext"><?php echo $i.$lable; ?> Installment</label>
    <div class="col-md-3">                                        
        <div class="form-group"> 
            <div class="input-group input-group-sm">
                <input type="text" class="form-control forminputs typeahead" id="installmentamt_<?php echo $i; ?>" name="installmentamt[]" placeholder="" autocomplete="off" value="" readonly>
                <input name="dueinstallmentchrg[]" id="dueinstallmentchrg_<?php echo $i; ?>" type="hidden">
            </div>
        </div>
    </div>
</div>

<div class="row">                                 
    <label for="first_name" class="col-md-2 labletext"><?php echo $i.$lable; ?> Cheque No</label>
    <div class="col-md-3">                                        
        <div class="form-group"> 
            <div class="input-group input-group-sm">
                <input type="text" class="form-control forminputs typeahead" id="installmentcheque_<?php echo $i; ?>" name="installmentcheque[]" placeholder="" autocomplete="off" value="" >

            </div>
        </div>
    </div>
    <label for="first_name" class="col-md-1 labletext"><?php echo $i.$lable; ?> Bank</label>
    <div class="col-md-2">                                        
        <div class="form-group"> 
             <div class="input-group input-group-sm">
                <input type="text" class="form-control forminputs typeahead" id="installmentbank_<?php echo $i; ?>" name="installmentbank[]" placeholder="" autocomplete="off" value="" >

            </div>
        </div>
    </div>
    <label for="first_name" class="col-md-1 labletext"><?php echo $i.$lable; ?> Branch</label>
    <div class="col-md-2">                                        
        <div class="form-group"> 
            <div class="input-group input-group-sm">
                <input type="text" class="form-control forminputs typeahead" id="installmentbranch_<?php echo $i; ?>" name="installmentbranch[]" placeholder="" autocomplete="off" value="" >

            </div>
        </div>
    </div>
</div>

<?php } ?>