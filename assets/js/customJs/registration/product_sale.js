$(document).ready(function () {
    var basepath = $("#basepath").val();

    $("#branch").change(function(){
        getmemberdtl(basepath);
    });
    $("#sel_card").change(function(){
        getmemberdtl(basepath);
    });
    $("#sel_name").change(function(){
        getmemberwalletdtl(basepath);
    });
    $("#sel_product").change(function(){
        var sel_product = $("#sel_product").val();
        urlpath = basepath+'productsale/productprice';
        $.ajax({
            type: "POST",
            url: urlpath,
            data: {sel_product:sel_product},
            dataType: 'json',
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            success: function(result) {
                $('#premium_amt').val(result.basic_price);				
                $('#payment_now').val(result.basic_price); 
                getPayment();      
            },
            error: function (jqXHR, exception) {
              var msg = "";
              if (jqXHR.status === 0) {
                msg = "Not connect.\n Verify Network.";
              } else if (jqXHR.status == 404) {
                msg = "Requested page not found. [404]";
              } else if (jqXHR.status == 500) {
                msg = "Internal Server Error [500].";
              } else if (exception === "parsererror") {
                msg = "Requested JSON parse failed.";
              } else if (exception === "timeout") {
                msg = "Time out error.";
              } else if (exception === "abort") {
                msg = "Ajax request aborted.";
              } else {
                msg = "Uncaught Error.\n" + jqXHR.responseText;
              }
        
              // alert(msg);
            },
          }); /*end ajax call*/
    });

    $(document).on("change", "#cgstrate", function () {   
        getTotal();
       
        
     });
     $(document).on("change", "#sgstrate", function () {   
        getTotal();
       
        
     });
     $(document).on("change", "#wallet_cashback", function () {  
        var premium_amt = parseInt($("#premium_amt").val()); 
        var cashbckamt = parseInt($('#wallet_cashback option:selected').attr('data-amount'));
        $('#productvalidationModal').modal('hide');	
     
         if(cashbckamt != "" && premium_amt < cashbckamt){
            $("#valid_err").text('Error : Select Another Product To Use Wallet Amount');
            $('#productvalidationModal').modal('show');
            $("#wallet_cashback").val('').change();
           
         }else{
            getPayment();
         } 
     });

     $(document).on("change", "#sel_self_guest", function () { 

        var sel_self_guest = $(this).val();
        if(sel_self_guest == 'Guest'){
            $(".guestdtl").removeAttr('readonly');

        }else{
            $(".guestdtl").attr('readonly',true);
        }

     });

      //  form submitt


$(document).on('submit', '#ProductSaleForm', function(event) {
    event.preventDefault();
   
      
    if (validateform()) {
       var formData = new FormData($(this)[0]);
        console.log(formData);
        $("#productsavebtn").css('display', 'none');
        $("#loaderbtn").css('display', 'inline-block');
      
       urlpath = basepath+'productsale/addedit_action';
       $.ajax({
           type: "POST",
           url: urlpath,
           data: formData,
           dataType: 'json',
           processData: false,
           contentType: false,           
           success: function(data) {

            if (data.msg_status == 1 && data.mode == "ADD") {
              var customer_id = data.cust_ins_id;
              var payment_id = data.pmt_ins_id;
              window.location.href =
                basepath +
                "productsale/conformation/" +
                customer_id +
                "/" +
                payment_id;
            } else if (data.msg_status == 0 && data.mode == "ADD") {
              $("#errormsg").text(data.msg_data);
            }
                   
           },
           error: function (jqXHR, exception) {
             var msg = "";
             if (jqXHR.status === 0) {
               msg = "Not connect.\n Verify Network.";
             } else if (jqXHR.status == 404) {
               msg = "Requested page not found. [404]";
             } else if (jqXHR.status == 500) {
               msg = "Internal Server Error [500].";
             } else if (exception === "parsererror") {
               msg = "Requested JSON parse failed.";
             } else if (exception === "timeout") {
               msg = "Time out error.";
             } else if (exception === "abort") {
               msg = "Ajax request aborted.";
             } else {
               msg = "Uncaught Error.\n" + jqXHR.responseText;
             }
       
             // alert(msg);
           },
         }); /*end ajax call*/
            
               
       
    }
});

});

function validateform(){

    var date_of_sale = $("#date_of_sale").val();   
    var branch = $("#branch").val();   
    var sel_card = $("#sel_card").val();   
    var sel_name = $("#sel_name").val();   
    var sel_product = $("#sel_product").val();   
    var sel_self_guest = $("#sel_self_guest").val();   
    var premium_amt = $("#premium_amt").val();
    var payment_now = $("#payment_now").val(); 
    var payable_amt = $("#payable_amt").val();
    $('#productvalidationModal').modal('hide');	
   var valid = true;
    if(date_of_sale == ""){
        $("#valid_err").text('Error : Select Date Of Sale');
        $('#productvalidationModal').modal('show');
        $('#date_of_sale').focus();
        return valid = false;
    }  
    if(branch == ""){
           $("#valid_err").text('Error : Select Branch');
           $('#productvalidationModal').modal('show');
           $('#branch').focus();
           return valid = false;
       }else if(sel_card == ""){
        $("#valid_err").text('Error : Select Existing Package');
        $('#productvalidationModal').modal('show');
        $('#sel_card').focus();
        return valid = false;
    }else if(sel_name == ""){
        $("#valid_err").text('Error : Select Member');
        $('#productvalidationModal').modal('show');
        $('#sel_name').focus();
        return valid = false;
    }else if(sel_product == ""){
        $("#valid_err").text('Error : Select Product To Buy');
        $('#productvalidationModal').modal('show');
        $('#sel_product').focus();
        return valid = false;
    }else if(payment_now == ""){
          $("#valid_err").text('Error : Enter Payment Now');
          $('#productvalidationModal').modal('show');
          $('#payment_now').focus();
          return valid = false;
      }   
          
       valid = othervalidate();   
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
    var sale_account = $("#sale_account").val();
    valid = true;
    if(cgstrate == 0){
       $("#valid_err").text('Error : Select CGST');
       $('#productvalidationModal').modal('show');
       $('#cgstrate').focus();
       return  valid = false;
   }else if(sgstrate == 0){
       $("#valid_err").text('Error : Select SGST');
       $('#productvalidationModal').modal('show');
       $('#sgstrate').focus();
       return valid = false;
   }else if(payment_mode == "Cheque"){
       if(cheque_no == ""){
           $("#valid_err").text('Error : Enter Cheque No');
           $('#productvalidationModal').modal('show');
           $('#cheque_no').focus();
           return valid = false;
       }else if(cheque_date == ""){
               $("#valid_err").text('Error : Select Cheque Date');
               $('#productvalidationModal').modal('show');
               $('#cheque_date').focus();
               return valid = false;
           }else if(cheque_bank == ""){
               $("#valid_err").text('Error : Enter Cheque Bank');
               $('#productvalidationModal').modal('show');
               $('#cheque_bank').focus();
               return valid = false;
           }else if(collection_branch == ""){
               $("#valid_err").text('Error : Select Collection Branch');
               $('#productvalidationModal').modal('show');
               $('#collection_branch').focus();
               return valid = false;
           }
       }else if(collection_branch == ""){
           $("#valid_err").text('Error : Select Collection Branch');
           $('#productvalidationModal').modal('show');
           $('#collection_branch').focus();
           return valid = false;
       }else if(sale_account == 0){
        $("#valid_err").text('Error : Select Sale A/C ');
        $('#productvalidationModal').modal('show');
        $('#sale_account').focus();
        return valid = false;
    }
       return valid
}

function getPayment()
	{		
		var subs = $("#premium_amt").val();       
        
        if( $('#wallet_cashback').val() != ""){	 
          var cashbckamt = $('#wallet_cashback option:selected').attr('data-amount');		
        }else{
            cashbckamt= 0;
        }
        if(subs == ""){ subs= 0; }if(cashbckamt == ""){ cashbckamt= 0; }		
		
	    prm=parseFloat(subs)-parseFloat(cashbckamt);		
		
		$("#payment_now").val(prm);          	
        var payment= $("#payment_now").val();
       
	   
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


 function getmemberdtl(basepath){

    var branch = $("#branch").val();
    var sel_card = $("#sel_card").val();
    $("#sel_name").html('<option value="">Select Member</option>')
    urlpath = basepath+'productsale/getmemberdtl';
    $.ajax({
        type: "POST",
        url: urlpath,
        data: {branch:branch,sel_card:sel_card},
        dataType: 'json',
        contentType: "application/x-www-form-urlencoded; charset=UTF-8",
        success: function(result) {
            $("#sel_name").html(result.memberlistview)           
        },
        error: function (jqXHR, exception) {
          var msg = "";
          if (jqXHR.status === 0) {
            msg = "Not connect.\n Verify Network.";
          } else if (jqXHR.status == 404) {
            msg = "Requested page not found. [404]";
          } else if (jqXHR.status == 500) {
            msg = "Internal Server Error [500].";
          } else if (exception === "parsererror") {
            msg = "Requested JSON parse failed.";
          } else if (exception === "timeout") {
            msg = "Time out error.";
          } else if (exception === "abort") {
            msg = "Ajax request aborted.";
          } else {
            msg = "Uncaught Error.\n" + jqXHR.responseText;
          }
    
          // alert(msg);
        },
      }); /*end ajax call*/

}

function getmemberwalletdtl(basepath){

    var cus_id = $("#sel_name").val();   
      $("#wallet_cashback").html('<option value="">Select</option>')
      $(".walleterr").addClass('dispnone');
    urlpath = basepath+'productsale/getmemberwalletdtl';
    $.ajax({
        type: "POST",
        url: urlpath,
        data: {cus_id:cus_id},
        dataType: 'json',
        contentType: "application/x-www-form-urlencoded; charset=UTF-8",
        success: function(result) {
            if(result.walletdtlview != ""){
                $("#wallet_cashback").html(result.walletdtlview);
                $(".walleterr").removeClass('dispnone');
            }
                     
        },
        error: function (jqXHR, exception) {
          var msg = "";
          if (jqXHR.status === 0) {
            msg = "Not connect.\n Verify Network.";
          } else if (jqXHR.status == 404) {
            msg = "Requested page not found. [404]";
          } else if (jqXHR.status == 500) {
            msg = "Internal Server Error [500].";
          } else if (exception === "parsererror") {
            msg = "Requested JSON parse failed.";
          } else if (exception === "timeout") {
            msg = "Time out error.";
          } else if (exception === "abort") {
            msg = "Ajax request aborted.";
          } else {
            msg = "Uncaught Error.\n" + jqXHR.responseText;
          }
    
          // alert(msg);
        },
      }); /*end ajax call*/

}