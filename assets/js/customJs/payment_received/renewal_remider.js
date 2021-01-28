$(document).ready(function(){

    basepath = $("#basepath").val();
    
    $("#mobile_no").keyup(function(){
        var mobile_no = $(this).val();
       
        if(mobile_no.length == 10){
           
        var formData = {mobile_no:mobile_no};
        var method = 'renewalremindersms/getMobileDetail';
        var data =  ajaxcallcontrollerforcutom(method,formData);
        $("#mem_no").val(data.mem_no);
        }
    })


    $("#category").change(function(){
        var category = $(this).val();  
           
        var formData = {category:category};
        var method = 'duereminder/getPackageList';
        var data =  ajaxcallcontrollerforcutom(method,formData);
        $("#card").html(data.cardlistview);
      
    });

    $("#renewaltviewbtn").click(function(){
        getAllRenewalreminder();
    });

    //feedback list
   $(document).on("click", ".addFeedback", function () {
   
    var cusid = $(this).attr('data-cusid');
    var pid = $(this).attr('data-pid');
    var enqmode = $(this).attr('data-mode');
    var wing = "RENEWAL";
    var formData = {cusid:cusid,pid:pid,wing:wing};
    var method = 'renewalreminder/getenqmasterforfeedback';
    var data =  ajaxcallcontrollerforcutom(method,formData);
     $("#enquiry_id").val(data.enquirymstdata['prv_enq_id']);
     $("#customer_id").val(cusid);
     $("#feedbackEnqMode").val(enqmode);
    $("#fname").val(data.enquirymstdata['FIRST_NAME'])
    $("#lname").val(data.enquirymstdata['LAST_NAME'])
    $("#pincode").val(data.enquirymstdata['PIN'])
    $("#location").val(data.enquirymstdata['LOCATION'])
    $("#address").val(data.enquirymstdata['ADDRESS'])
    $("#email").val(data.enquirymstdata['EMAIL'])
    $("#mobile1").val(data.enquirymstdata['MOBILE1'])
    $("#mobile2").val(data.enquirymstdata['MOBILE2'])        
    $("#txtwing").val(data.enquirymstdata['for_the_wing'])
    $("#feedbck_branch").val(data.enquirymstdata['BRANCH_CODE'])
    $("#sel_remarks").html(data.remarkslist);
    $("#done_by").html(data.userlistview);      
    $('#feedbackmodel').modal('show');
    $('.datepicker').datepicker({
        format: 'dd-mm-yyyy',
        startDate: startDate,
        endDate: endDate,
        autoclose:true,
        todayHighlight:true  
    
     });
     $('.select2').select2();
});

$(document).on("click", ".feedbackList", function () {
    var cusid = $(this).attr('data-cusid');
    var pid = $(this).attr('data-pid');
    var formData = {cusid:cusid,pid:pid};
    var method = 'renewalreminder/getfeedbacklist';
    var data =  htmlshowajaxcomtroller(method,formData);
    $("#feedbackModalBody").html(data);
    $('#feedbacklistmodel').modal('show');
    
});
$("#installment_phase").prop( "disabled", true );
$(document).on("keyup", "#disc_nego", function () {   
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
 $(document).on("click", "#complimentry", function () {   
   
    if($("input[type='checkbox'][name='complimentry']:checked").length == true){
        $("#disc_nego").val("");
        $("#disc_nego").prop( "disabled", true );

        $("#wallet_cashback").val('').change();
        $("#wallet_cashback").prop( "disabled", true );

        
        $("#premium_amt").val("0");
        $("#premium_amt").prop( "disabled", true );
        
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
        var subscription_amt = $("#subscription_amt").val();
       
        $("#disc_nego").prop( "disabled", false );
        $("#wallet_cashback").prop( "disabled", false );
        $("#subscription_amt").prop( "disabled", false );
       
        $("#premium_amt").prop( "disabled", false );
       
        $("#payment_now").prop( "disabled", false );
        $("#premium_amt").val(subscription_amt);
       
        $("#installment_phase").prop( "disabled", false );
        $("#payment_now").val(subscription_amt);

        $("#payable_amt").val(subscription_amt);

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


$(document).on('submit', '#RenewalForm', function(event) {
    event.preventDefault();
    var formData = new FormData($(this)[0]);
    //console.log(formData);

    if (validateform()) {
       var formData = new FormData($(this)[0]);
        $("#renewalsavebtn").css('display', 'none');
        $("#loaderbtn").css('display', 'inline-block');

       var method = 'renewalreminder/addedit_action';
       var data =  ajaxcallcontroller(method,formData);  
       
       if (data.msg_status == 1 && data.mode == "ADD") {
        var customer_id = data.cust_ins_id;
        var payment_id = data.pmt_ins_id;
        window.location.href =
          basepath +
          "registration/conformation/" +
          customer_id +
          "/" +
          payment_id;
      } else if (data.msg_status == 0 && data.mode == "ADD") {
        $("#errormsg").text(data.msg_data);
      }
               
       
    }
});


});

function validateform(){

     var start_dt = $("#start_dt").val();
     var payment_dt = $("#payment_dt").val();
     var premium_amt = $("#premium_amt").val();
     var payment_now = $("#payment_now").val();
     var due_amt = $("#due_amt").val();
     var installment = $("#installment_phase").val();
    
     var collection_branch = $("#collection_branch").val();
     var payable_amt = $("#payable_amt").val();
    
    var valid = true;
     if(start_dt == ""){
         $("#valid_err").text('Error : Select Starting Date ');
         $('#renewalvalidationModal').modal('show');
         $('#start_dt').focus();
         return valid = false;
     }else if(payment_dt == ""){
        $("#valid_err").text('Error : Select Payment Date ');
        $('#payment_dt').focus();
        $('#renewalvalidationModal').modal('show');
        return valid = false;
    }

     if($("input[type='checkbox'][name='complimentry']:checked").length == false){

        if(premium_amt == ""){
            $("#valid_err").text('Error : Enter Renewal Amount ');
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
        if(collection_branch == ""){
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
		
		var subs = $("#subscription_amt").val();
        var disc = $("#disc_nego").val();
        
        if( $('#wallet_cashback').val() != ""){	 
          var cashbckamt = $('#wallet_cashback option:selected').attr('data-amount');		
        }else{
            cashbckamt= 0;
        }
        if(subs == ""){ subs= 0; }if(disc == ""){ disc= 0; }if(cashbckamt == ""){ cashbckamt= 0; }
			
		
	    prm=parseFloat(subs)-parseFloat(disc)-parseFloat(cashbckamt);
		
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




function getAllRenewalreminder(){
  
    var from_dt = $("#from_dt").val();
    var to_date = $("#to_date").val();
    var branch = $("#branch").val();
    var category = $("#category").val();
    var card = $("#card").val();
    var trainer = $("#trainer").val();
    var mobile_no = $("#mobile_no").val();
    var mem_no = $("#mem_no").val();
  
   
    $("#renewal_reminder_list").html(''); 
    $("#loader").css('display','block');
    var formData = {from_dt:from_dt,to_date:to_date,branch:branch,category:category,card:card,trainer:trainer,mobile_no:mobile_no,mem_no:mem_no};
    var method = 'renewalreminder/getAllRenewalreminder';
    var data =  htmlshowajaxcomtroller(method,formData);
     $("#loader").css('display','none');
     $("#renewal_reminder_list").html(data);
     $('.dataTable2').DataTable({
      "scrollX": true,
      "ordering": false,
      "footer": true, 
       "scrollY": 1500,
      "pageLength": 100,
    //   "fixedColumns":   {
    //     "leftColumns": 3,
       
    // },
    
      
    //   "lengthMenu": [ 100, 200,300,500]
   })
  


  }

  function addFeedBack(){
	var enq_id = $("#enquiry_id").val();
	var customer_id = $("#customer_id").val();
	var feedbackEnqMode = $("#feedbackEnqMode").val();
	var sel_remarks = $("#sel_remarks").val();
	var remarks = $("#txtremark").val();
	var followup_date = $("#followup_date").val();
	var done_by = $("#done_by").val();
	var m_branch_feed_code = $("#feedbck_branch").val();	
    var wing = "RENEWAL";
    if(validatefeedback()){
        formData =  {enq_id:enq_id,customer_id:customer_id,wing:wing,feedbackEnqMode:feedbackEnqMode,sel_remarks:sel_remarks,remarks:remarks,followup_date:followup_date,done_by:done_by,m_branch_feed_code:m_branch_feed_code};
        var method = 'renewalreminder/feedback_action';
        var data =  ajaxcallcontrollerforcutom(method,formData);
        if(data.msg_status == 1){
            $("#sel_remarks").val('').change();
            $("#txtremark").val('');
            $("#followup_date").val('');
            $("#done_by").val('').change();
             $("#errormodal").css('display','inline-block');
             location.reload();
             
        }
    }
	
	function validatefeedback(){
        // var enq_id = $("#enquiry_id").val();
        var remarks = $("#txtremark").val();
        var followup_date = $("#followup_date").val();
        var done_by = $("#done_by").val();
        $("#enquiry_id,#txtremark,#followup_date,#donebyerr").removeClass('modalerror');
        
         if(remarks == ""){
            // $("#errormodal").text('Error : Enter addtional remarks') 
            $("#txtremark").addClass('modalerror');
            $("#txtremark").focus();
            return false;
         }else if(followup_date == ""){
            // $("#errormodal").text('Error : Select follow up date')
            $("#followup_date").addClass('modalerror');
            $("#followup_date").focus();
            return false;
         }else if(done_by == ""){
            // $("#errormodal").text('Error : Select done by')
            $("#donebyerr").addClass('modalerror');
            $("#done_by").focus();
            return false;
         }
         return true;
    }	
	
}