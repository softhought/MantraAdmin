$(document).ready(function(){

    basepath = $("#basepath").val();

    $("#mobile_no").keyup(function(){
        var mobile_no = $(this).val();
        removedata();
        if(mobile_no.length == 10){
           
        var formData = {mobile_no:mobile_no};
        var method = 'exchangepackage/getCurrentPackage';
        var data =  ajaxcallcontrollerforcutom(method,formData);
           $("#sel_package").html(data.currentpack);
          
           if(data.wallet_cash == 1){
               $("#wallet").removeClass('dispnone');
            $("#wallet_cashback").html(data.walletdtlview);
           }
        }
    });

    $("#sel_package").change(function(){
        if($(this).val() != ""){
           getpackageandmemberdtl();
          
        }else{
            removedata();
        }
    });

    //transfer branch
    $('input:radio[name="transfer_branch"]').change(function(){

        if ($(this).is(':checked') && $(this).val() == 'TOB') {

            $(".withinbrn").removeClass('displaybl');
            $(".withinbrn").addClass('dispnone');            
            $(".accbrnnopay").removeClass('displaybl');
            $(".accbrnnopay").addClass('dispnone');           
            $(".accrossbrn").removeClass('dispnone');
            $(".accrossbrn").addClass('displaybl');

            if($("#sale_cashback").val() > 0){
                $("#cashback_on_sale_txt").removeClass('dispnone ');
                $("#cashback_on_sale").removeClass('dispnone ');
                $("#cashback_on_sale_txt").addClass('displaybl');
                $("#cashback_on_sale").addClass('displaybl');

            }else{
                $("#cashback_on_sale_txt").removeClass('displaybl ');
                $("#cashback_on_sale").removeClass('displaybl ');
                $("#cashback_on_sale_txt").addClass('dispnone');
                $("#cashback_on_sale").addClass('dispnone');
            }

        }else  if ($(this).is(':checked') && $(this).val() == 'TSB') {
            
            $(".accrossbrn").removeClass('displaybl');
            $(".accrossbrn").addClass('dispnone');            
            $(".accbrnnopay").removeClass('displaybl');
            $(".accbrnnopay").addClass('dispnone');   
            $(".withinbrn").removeClass('dispnone');
            $(".withinbrn").addClass('displaybl');
            if($("#sale_cashback").val() > 0){
                $("#cashback_on_sale_txt").removeClass('dispnone ');
                $("#cashback_on_sale").removeClass('dispnone ');
                $("#cashback_on_sale_txt").addClass('displaybl');
                $("#cashback_on_sale").addClass('displaybl');

            }else{
                $("#cashback_on_sale_txt").removeClass('displaybl ');
                $("#cashback_on_sale").removeClass('displaybl ');
                $("#cashback_on_sale_txt").addClass('dispnone');
                $("#cashback_on_sale").addClass('dispnone');
            }
            
        }else  if ($(this).is(':checked') && $(this).val() == 'TRN') {
            
            $(".accrossbrn").addClass('dispnone');
            $(".accrossbrn").removeClass('displaybl');
            $(".withinbrn").removeClass('displaybl');
            $(".withinbrn").addClass('dispnone');   
            $(".accbrnnopay").removeClass('dispnone');
            $(".accbrnnopay").addClass('displaybl');
        }

    });

    //package check 
    $(document).on("change","#sel_card",function(){

        if($(this).val() != ""){
            getpackagedtl();
            getPayment();
        } 
    });
    $(document).on("keyup", "#disc_nego", function () {   
        getPayment();
        
     });
     $(document).on("keyup", "#disc_conv", function () {   
        getPayment();
        
     });
     $(document).on("keyup", "#disc_offer", function () {   
        getPayment();
        
     });
     $(document).on("keyup", "#payment_now", function () {   
        getDue();
        
     });
    
    $(document).on("change", "#installment_phase", function () {   
        getinstallmentview();
       
        
     });
     $(document).on("change", "#cgstrate", function () {   
        getTotal();
       
        
     });
     $(document).on("change", "#sgstrate", function () {   
        getTotal();
       
        
     });
     $(document).on("change", "#wallet_cashback", function () {   
        getPayment();
       
        
     });

    //  complimentry
    $(document).on("click", "#complimentry", function () {   
   
        if($("input[type='checkbox'][name='complimentry']:checked").length == true){
            $("#disc_nego").val("");
            $("#disc_nego").prop( "disabled", true );

            $("#disc_conv").val("");
            $("#disc_conv").prop( "disabled", true );

            $("#disc_offer").val("");
            $("#disc_offer").prop( "disabled", true );
    
            $("#wallet_cashback").val('').change();
            $("#wallet_cashback").prop( "disabled", true );
    
            
            $("#premium_amt").val("0");
            $("#premium_amt").prop( "disabled", true );

            $("#package_rate").val("0");
            $("#package_rate").prop( "disabled", true );

            $("#paid_amt").val("0");
            $("#paid_amt").prop( "disabled", true );
            
            $("#payment_now").val("0");
            $("#payment_now").prop( "disabled", true );
    
            $("#due_amt").val("");        
    
            $("#installment_phase").val('').change();
            $("#installment_phase").prop( "disabled", true );
            $("#extra_charges").val(0);
    
            $("#cgstrate").val('0').change();
            $("#cgstrate").prop( "disabled", true );
    
            $("#sgstrate").val('0').change();
            $("#sgstrate").prop( "disabled", true );
    
            $("#payment_mode").prop( "disabled", true );
    
            $("#cheque_no").val('');
            $("#cheque_no").prop( "disabled", true );
    
            $("#cheque_date").val('');
            $("#cheque_date").prop( "disabled", true );
    
            $("#cheque_bank").val('');
            $("#cheque_bank").prop( "disabled", true );
    
            $("#cheque_branch").val('');
            $("#cheque_branch").prop( "disabled", true );
    
    
    
    
        }else{
            var package_rate_txt = $("#package_rate_txt").val();
            var paid_amt_txt = $("#paid_amt_txt").val();
           
            $("#disc_nego").prop( "disabled", false );
            $("#disc_conv").prop( "disabled", false );
            $("#disc_offer").prop( "disabled", false );
            $("#wallet_cashback").prop( "disabled", false );
            $("#subscription_amt").prop( "disabled", false );
           
            $("#premium_amt").prop( "disabled", false );

            $("#package_rate").val(package_rate_txt);
            $("#package_rate").prop( "disabled", false );

            $("#paid_amt").val(paid_amt_txt);
            $("#paid_amt").prop( "disabled", false );
           
            $("#payment_now").prop( "disabled", false );
            $("#premium_amt").val(paid_amt_txt);
           
            // $("#installment_phase").prop( "disabled", false );
            $("#payment_now").val(paid_amt_txt);
    
            $("#payable_amt").val(paid_amt_txt);
    
            $("#cgstrate").prop( "disabled", false );
            $("#sgstrate").prop( "disabled", false );
            $("#payment_mode").prop( "disabled", false );
            ("#cheque_no").prop( "disabled", false );
            $("#cheque_date").prop( "disabled", false );
            $("#cheque_bank").prop( "disabled", false );
            $("#cheque_branch").prop( "disabled", false );
        }
        
     });
    //  form submitt


$(document).on('submit', '#ExchangepackForm', function(event) {
    event.preventDefault();
    var formData = new FormData($(this)[0]);
    //console.log(formData);
    var transfer_branch = $('input:radio[name="transfer_branch"]:checked').val();   
    if (validateform()) {
       var formData = new FormData($(this)[0]);
        $("#exchangesavebtn").css('display', 'none');
        $("#loaderbtn").css('display', 'inline-block');

       var method = 'exchangepackage/addedit_action';
       var data =  ajaxcallcontroller(method,formData);  
       
       if ((transfer_branch == 'TOB' || transfer_branch == 'TSB') && data.msg_status == 1 && data.mode == "ADD") {
        var customer_id = data.cust_ins_id;
        var payment_id = data.pmt_ins_id;
        var sent_msg = data.sent_msg;
        window.location.href =
          basepath +
          "registration/conformation/" +
          customer_id +
          "/" +
          payment_id +
          "/" +
          sent_msg;
      } else if (data.msg_status == 0 && data.mode == "ADD") {
        $("#errormsg").text(data.msg_data);
      }else{
        Swal.fire({
            title: "Save Successfully",
            text: "",
            icon: "info",
            width: 350,
            padding: "1em",
            allowOutsideClick: false,
            confirmButtonColor: "#3085d6",
            confirmButtonText: "Ok",
            customClass: {
              title: "alerttitale",
              content: "alerttext",
              confirmButton: "btn tbl-action-btn padbtn",
            },
          }).then((result) => {
            if (result.value) {
              window.location.href = basepath + "exchangepackage/addeditexchangepack";
            }else{
                window.location.href = basepath + "exchangepackage/addeditexchangepack";
            }
          });
      }
               
       
    }
});

});
function validateform(){

     var mobile_no = $('#mobile_no').val();
     var sel_package = $('#sel_package').val();
     var transfer_branch = $('input:radio[name="transfer_branch"]:checked').val();
     var pre_branch_id = $("#pre_branch_id").val();
     var branch = $("#branch").val();
     var sel_card = $("#sel_card").val();
       
     var from_branch = $("#from_branch").val();
    var payment_dt = $("#payment_dt").val();
    var premium_amt = $("#premium_amt").val();
    var payment_now = $("#payment_now").val();
    var due_amt = $("#due_amt").val();
    var installment = $("#installment_phase").val();
   
    var collection_branch = $("#collection_branch").val();
    var payable_amt = $("#payable_amt").val();
   
   var valid = true;
   if(mobile_no == ""){
    $("#valid_err").text('Error : Enter Mobile No. ');
    $('#mobile_no').focus();
    $('#renewalvalidationModal').modal('show');
    return valid = false;
 }else if(mobile_no.length < 10 ){
    $("#valid_err").text('Error : Enter 10 digit Mobile No.');
    $('#mobile_no').focus();
    $('#renewalvalidationModal').modal('show');
    return valid = false;
 }else if(sel_package == ""){
    $("#valid_err").text('Error : Select Package');
    $('#sel_package').focus();
    $('#renewalvalidationModal').modal('show');
    return valid = false;
 }
   else if((transfer_branch == 'TOB' || transfer_branch == 'TSB') && payment_dt == ""){
       $("#valid_err").text('Error : Select Payment Date ');
       $('#payment_dt').focus();
       $('#renewalvalidationModal').modal('show');
       return valid = false;
    }else if(transfer_branch == 'TOB' && from_branch == ""){
        $("#valid_err").text('Error : Select From Branch ');
        $('#from_branch').focus();
        $('#renewalvalidationModal').modal('show');
        return valid = false;
        }
       else if(transfer_branch == 'TSB' && branch == ""){
            $("#valid_err").text('Error : Select Branch ');
            $('#branch').focus();
            $('#renewalvalidationModal').modal('show');
            return valid = false;
        }else if((transfer_branch == 'TOB' || transfer_branch == 'TRN') && branch == ""){
            $("#valid_err").text('Error : Select To Branch ');
            $('#branch').focus();
            $('#renewalvalidationModal').modal('show');
            return valid = false;
        }else if(transfer_branch == 'TRN' && branch == pre_branch_id){
            $("#valid_err").text('Error : Same Branch Transfer Not Possible ');
            $('#branch').focus();
            $('#renewalvalidationModal').modal('show');
            return valid = false;
        }
        else if(sel_card == ""){
            $("#valid_err").text('Error : Select Type of Package Card ');
            $('#sel_card').focus();
            $('#renewalvalidationModal').modal('show');
            return valid = false;
         }

    if((transfer_branch == 'TOB' || transfer_branch == 'TSB') && $("input[type='checkbox'][name='complimentry']:checked").length == false){

       if(premium_amt == ""){
           $("#valid_err").text('Error : Enter Package Rate ');
           $('#renewalvalidationModal').modal('show');
           $('#premium_amt').focus();
           return valid = false;
       }else if(payment_now == ""){
          $("#valid_err").text('Error : Enter Payment Now');
          $('#renewalvalidationModal').modal('show');
          $('#payment_dt').focus();
          return valid = false;
      }else if(due_amt > 0 && installment == ''){
           $("#valid_err").text('Error : Select Installment');
           $('#renewalvalidationModal').modal('show');
           $('#installment_phase').focus();
           return valid = false;
      }else if(due_amt > 0 && installment > 0){       

       for (i = 1; i <= installment; i++) {

           if(i==1){ var lable="st"; }
           else if(i==2){ var lable="nd"; }
           else if(i==3){ var lable="rd"; }
           else{ var lable="th"; }

           if($("#installmentdt_"+i).val() == ""){
               $("#valid_err").text('Error : Select '+i+lable+' Inst. Dt ');
               $('#renewalvalidationModal').modal('show');
               $("#installmentdt_"+i).focus();
               return valid = false;


           }else if($("#installmentamt_"+i).val() == ""){
               $("#valid_err").text('Error : Enter '+i+lable+' Installment ');
               $('#renewalvalidationModal').modal('show');
               $("#installmentamt_"+i).focus();
               return valid = false;
           }else if($("#installmentcheque_"+i).val() == ""){
               $("#valid_err").text('Error : Enter '+i+lable+' Cheque No ');
               $('#renewalvalidationModal').modal('show');
               $("#installmentcheque_"+i).focus();
               return valid = false;
           }else if($("#installmentbank_"+i).val() == ""){
               $("#valid_err").text('Error : Enter '+i+lable+' Bank ');
               $('#renewalvalidationModal').modal('show');
               $("#installmentbank_"+i).focus();
               return valid = false;
           }else if($("#installmentbranch_"+i).val() == ""){
               $("#valid_err").text('Error : Enter '+i+lable+' Branch ');
               $('#renewalvalidationModal').modal('show');
               $("#installmentbranch_"+i).focus();
               return valid = false;
           }
                 
        }

        valid = othervalidate();
       
       }
       valid= othervalidate();
          
      
    }else{
       if((transfer_branch == 'TOB' || transfer_branch == 'TSB') && collection_branch == ""){
           $("#valid_err").text('Error : Select Collection Branch');
           $('#renewalvalidationModal').modal('show');
           $('#collection_branch').focus();
           return valid = false;
       }

    }
    return valid;

}

function othervalidate(){

   var cgstrate = $("#cgstrate").val();
    var sgstrate = $("#sgstrate").val();
    var payment_mode = $("#payment_mode").val();
    var cheque_no = $("#cheque_no").val();
    var cheque_date = $("#cheque_date").val();
    var cheque_bank = $("#cheque_bank").val();     
    var collection_branch = $("#collection_branch").val();
    valid = true;
    if(cgstrate == 0){
       $("#valid_err").text('Error : Select CGST');
       $('#renewalvalidationModal').modal('show');
       $('#cgstrate').focus();
       return  valid = false;
   }else if(sgstrate == 0){
       $("#valid_err").text('Error : Select SGST');
       $('#renewalvalidationModal').modal('show');
       $('#sgstrate').focus();
       return valid = false;
   }else if(payment_mode == "Cheque"){
       if(cheque_no == ""){
           $("#valid_err").text('Error : Enter Cheque No');
           $('#renewalvalidationModal').modal('show');
           $('#cheque_no').focus();
           return valid = false;
       }else if(cheque_date == ""){
               $("#valid_err").text('Error : Select Cheque Date');
               $('#renewalvalidationModal').modal('show');
               $('#cheque_date').focus();
               return valid = false;
           }else if(cheque_bank == ""){
               $("#valid_err").text('Error : Enter Cheque Bank');
               $('#renewalvalidationModal').modal('show');
               $('#cheque_bank').focus();
               return valid = false;
           }else if(collection_branch == ""){
               $("#valid_err").text('Error : Select Collection Branch');
               $('#renewalvalidationModal').modal('show');
               $('#collection_branch').focus();
               return valid = false;
           }
       }else if(collection_branch == ""){
           $("#valid_err").text('Error : Select Collection Branch');
           $('#renewalvalidationModal').modal('show');
           $('#collection_branch').focus();
           return valid = false;
       }
       return valid
}
function getinstallmentview(){

    var period = $("#installment_phase").val();
    var due = $("#due_amt").val();
    if(due > 0){
    $("#installment_list").html("");
    var formData = {period:period};
    var method = 'renewalreminder/getinstallmentview';
    var data =  htmlshowajaxcomtroller(method,formData);
     $("#installment_list").html(data);
     var startDate = new Date($("#acstartDate").val());
     var endDate = new Date($("#acendDate").val());
 
   $('.datepicker').datepicker({
     format: 'dd-mm-yyyy',
     startDate: startDate,
     endDate: endDate,
     autoclose:true,
     todayHighlight:true  
 
  });
   }
     getDue();
}

function getPayment()
	{
		
        var subs = $("#paid_amt").val();
       
        var disc = $("#disc_nego").val();
        var disc_conv = $("#disc_conv").val();
        var disc_offer = $("#disc_offer").val();
        
        if( $('#wallet_cashback').val() != ""){	 
          var cashbckamt = $('#wallet_cashback option:selected').attr('data-amount');		
        }else{
            cashbckamt= 0;
        }
        if(subs == ""){ subs= 0; }if(disc == ""){ disc= 0; }if(cashbckamt == ""){ cashbckamt= 0; }
		if(disc_conv == ""){ disc_conv=0; }	if(disc_offer == ""){ disc_offer=0; }	
		
	    prm=parseFloat(subs)-parseFloat(disc)-parseFloat(disc_conv)-parseFloat(disc_offer)-parseFloat(cashbckamt);
		
		$("#premium_amt").val(prm);
		$("#payment_now").val(prm);
        var due = parseFloat(prm)-parseFloat(payment);    	
        var payment= $("#payment_now").val();
        $("#due_amt").val(parseFloat(prm)-parseFloat(payment));                 
            $("#installment_phase").val('').change();            
       
        $("#extra_charges").val(0);
	   
        getTotal();
        
	}

function getDue()
	{
	    var prm= $("#premium_amt").val();
	    var payment= $("#payment_now").val();
        var due = parseFloat(prm)-parseFloat(payment);
        $("#due_amt").val(due);
        if(due > 0){
          
            $("#installment_phase").prop( "disabled", false );
        }else{
            $("#installment_phase").prop( "disabled", true );
            $("#installment_list").html("");
        }
        if($("#installment_phase").val() != ""){
		var rate = $("#installment_phase option:selected").attr('data-rate');
		var installment =$("#installment_phase").val();
        installment_chrg = (due * rate) / 100;
         $("#extra_charges").val(installment_chrg);
	for (i = 1; i <= installment; i++) {
        
	     var installdueamt = (parseFloat(due/installment)).toFixed(2);
         var installduecharges = (parseFloat(installment_chrg/installment)).toFixed(2);         
         var installamt = parseFloat(installdueamt) + parseFloat(installduecharges);
         $("#installmentamt_"+i).val(installamt.toFixed(2));
         $("#dueinstallmentchrg_"+i).val(installduecharges);
		       
      }

    }
    getTotal();
}

function getTotal()
{
  
    var paid = $("#payment_now").val();    
    var total;
    var tax_amt1;
    var tax_amt2;

    
   // var cgst = $("#cgstrate option:selected").text();
    var cgstrate = $("#cgstrate option:selected").text(); 
   
   // var sgst=$("#sgstrate").val();
    var sgstrate = $("#sgstrate option:selected").text(); 
    
    if(cgstrate>0)
    {
        tax_amt1 = ((cgstrate/100) * paid);
        $("#cgstAmount").val(parseFloat(tax_amt1.toFixed(2)));
      
    }
    else
    {
        tax_amt1 = 0;
        $("#cgstAmount").val(parseFloat(tax_amt1.toFixed(2)));
       
    }
    
    if(sgstrate>0)
    {
        tax_amt2 = ((sgstrate/100) * paid);
        $("#sgstAmount").val(parseFloat(tax_amt2.toFixed(2)));
       
    }
    else
    {
        tax_amt2 = 0;
        $("#sgstAmount").val(parseFloat(tax_amt2.toFixed(2)));
    }
    
    total = parseFloat(paid)+parseFloat(tax_amt1.toFixed(2))+parseFloat(tax_amt2.toFixed(2));
    $("#payable_amt").val(Math.round(total));
   

}

function getpackagedtl(){

    var card_id = $("#sel_card").val();
    var card_code = $("#sel_card option:selected").attr('data-card');
    var branch_code = $("#branch option:selected").attr('data-code');
    var startDate = $("#packg_start_dt").val();
    var totalDys =0;var cduration = 0;
    var currdate = $("#currdate").val();
    var grantdys = $("#grantdays").val();
    $("#carderr").addClass('dispnone');
    var formData = {card_id:card_id,card_code:card_code,branch_code:branch_code};
    var method = 'exchangepackage/getpackagedtl';
    var data =  ajaxcallcontrollerforcutom(method,formData);
    var cduration = data.card_activedays;  
   
    totalDys = parseInt(cduration) + parseInt(grantdys);
    
    var finaldt = addDays(startDate,totalDys);
   
    var validupto = formatDate(finaldt);

    if(validupto>currdate)
    {
        $("#carderr").removeClass('dispnone');
        $("#packg_validity").removeClass('colored');
        $("#packg_validity").addClass('colorbl');
       $("#packg_validity").text("Would be Package validity is "+startDate+" To "+validupto);
       $("#exchangesavebtn").css("display","inline-block");
    }
    else
    {
        $("#carderr").removeClass('dispnone');
        $("#packg_validity").removeClass('colorbl');
        $("#packg_validity").addClass('colored');
        $("#exchangesavebtn").css("display","none");
        $("#packg_validity").text("Would be Package validity is "+startDate+" To "+validupto +" . Sorry, this action is not permissible.Contact Admin.");
    }

    //cashback on sale
    $("#sale_cashback").val(data.cashback_on_sale);
    if(data.cashback_on_sale > 0){
        $("#cashback_on_sale_txt").removeClass('dispnone');
        $("#cashback_on_sale").removeClass('dispnone');
        
        $("#cashback_on_sale").text(data.cashback_on_sale);
       
    }else{
        $("#cashback_on_sale_txt").removeClass('displaybl ');
        $("#cashback_on_sale").removeClass('displaybl ');
        $("#cashback_on_sale_txt").addClass('dispnone');
        $("#cashback_on_sale").addClass('dispnone');
    }
    //package rate
    if(data.package_rate > 0){
        var prvpaidAmt = $('#prv_pckg_paid_amt').val();
        var prv_due_amt = $("#prv_due_amt").val();
        var packageamount = data.package_rate;
        $('#package_rate').val(data.package_rate);
        $('#package_rate_txt').val(data.package_rate);
        var new_subscriptionAmt = parseFloat(packageamount) - parseFloat(prvpaidAmt);
        $('#paid_amt').val(new_subscriptionAmt);
        $('#paid_amt_txt').val(new_subscriptionAmt);
        if(new_subscriptionAmt< 0)
			{  
                $("#exchangesavebtn").css("display","none");
               // $("#amttobepaidinfo").removeClass('dispnone');
               $("#amttobepaidinfo").addClass('colored');
				$("#amttobepaidinfo").text("Please select the package of higher value.");
			}else if(prv_due_amt > 0){
                $("#exchangesavebtn").css("display","none");
            }else{
                $("#amttobepaidinfo").text("");
            }
    }

}

function addDays(date, days) {
    var result = new Date(date);  
    result.setDate(result.getDate() + days);
    return result;
}
function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
}
function removedata(){
    var mobile_no = $("#mobile_no").val();
    if(mobile_no.length < 10){
    $("#sel_package").html("<option value=''>Select</option>");
    }
    $("#cus_id").val('');
    $("#reg_dt").val("");
    $("#membership_no").val("");
    $("#mother_pack").val("");
    $("#validity_pd").val("");
    $("#mem_name").val("");
    $("#phone_no").val("");
    $("#grantdays").val("");
    $("#actual_exp_date").val("");
    $("#pack_starting_dt").text("");
    $("#paidamt").text("");
    $("#previousdue").text("");
    $("#packg_validity").text('');
    $("#carderr").addClass('dispnone');
    $("#wallet").addClass('dispnone');
    $("#cashback_on_sale_txt").addClass('dispnone');
    $("#cashback_on_sale").text('');
    $("#sel_card").val('').change();
    $("#amttobepaidinfo").text("");
    
}

function getpackageandmemberdtl(){

    var cus_id = $("#sel_package").val();       
   
    if(cus_id != ""){
       
    var formData = {cus_id:cus_id};
    var method = 'exchangepackage/getpackageandmemberdtl';
    var data =  ajaxcallcontrollerforcutom(method,formData);
     $("#cus_id").val(cus_id);
     $("#reg_dt").val(data.customerdtl['REGISTRATION_DT']);
     $("#membership_no").val(data.customerdtl['MEMBERSHIP_NO']);
     $("#mother_pack").val(data.customerdtl['CARD_DESC']);
     $("#package_name").val(data.customerdtl['CARD_DESC']);
     $("#validity_pd").val(data.customerdtl['VALIDITY_STRING']);
     $("#mem_name").val(data.customerdtl['CUS_NAME']);
     $("#phone_no").val(data.customerdtl['CUS_PHONE']);
     $("#grantdays").val(data.customerdtl['grant_days']);
     $("#actual_exp_date").val(data.customerdtl['actualExpiryDt']);
     $("#pack_starting_dt").text("Would be Package starting date is "+data.customerdtl['FROM_DT']);
     $("#packg_start_dt").val(data.customerdtl['start_dt']);
     $("#paidamt").text(data.customerdtl['totalPaid']);
     $("#prv_pckg_paid_amt").val(data.customerdtl['totalPaid']);
     $("#prv_due_amt").val(data.customerdtl['DUE']);
     $("#pre_branch_id").val(data.customerdtl['branch_id']);
     if(data.customerdtl['DUE'] > 0){
        $("#previousdue").removeClass('colorbl');
        $("#previousdue").addClass('colored');
     $("#exchangesavebtn").css("display","none");
     $("#previousdue").text("Please clear your previous due amount of Rs. "+data.customerdtl['DUE']+" to exchanage the new one.");
     
     }else{
        $("#previousdue").removeClass('colored');
        $("#previousdue").addClass('colorbl');
        $("#exchangesavebtn").css("display","inline-block");
        $("#previousdue").text(data.customerdtl['DUE']);
       
     }
    }
   

}