$(document).ready(function(){

    basepath = $("#basepath").val();

    $("#category").change(function(){
        var category = $(this).val();  
           
        var formData = {category:category};
        var method = 'duereminder/getPackageList';
        var data =  ajaxcallcontrollerforcutom(method,formData);
        $("#card").html(data.cardlistview);
      
    });

    $("#dueviewbtn").click(function(){
        getAllduereminder();
    });
    $("#payment_now").keyup(function(){
        getPayment();
    });
    $("#cgstrate").change(function(){
        getTotal();
    });
    $("#sgstrate").change(function(){
        getTotal();
    });

    //  form submitt


$(document).on('submit', '#DueRenewalForm', function(event) {
    event.preventDefault();
    var formData = new FormData($(this)[0]);
    //console.log(formData);

    if (validateform()) {
       var formData = new FormData($(this)[0]);
        $("#duesavebtn").css('display', 'none');
        $("#loaderbtn").css('display', 'inline-block');

       var method = 'duereminder/addedit_action';
       var data =  ajaxcallcontroller(method,formData);  
       
       if (data.msg_status == 1 && data.mode == "ADD") {
        var customer_id = data.cust_ins_id;
        var tran_id = data.tran_id;
        var is_sms = data.is_sms;
        window.location.href =
          basepath +
          "duereminder/conformation/" +
          customer_id +
          "/" +
          tran_id+
          "/" +
          is_sms;
      } else if (data.msg_status == 0 && data.mode == "ADD") {
        $("#errormsg").text(data.msg_data);
      }
               
       
    }
});


})

function validateform(){

    var payment_dt = $("#payment_dt").val();  
    var payment_now = $("#payment_now").val();        
    
    var payable_amt = $("#payable_amt").val();
    if(payment_dt == ""){
        $("#valid_err").text('Error : Select Payment Date ');
        $('#payment_dt').focus();
        $('#renewalvalidationModal').modal('show');
        return valid = false;
    }else if(payment_now == ""){
        $("#valid_err").text('Error : Enter Payment Now');
        $('#renewalvalidationModal').modal('show');
        $('#payment_dt').focus();
        return valid = false;
    }
    return othervalidate();

    return true;
}
function othervalidate(){

    var cgstrate = $("#cgstrate").val();
     var sgstrate = $("#sgstrate").val();
     var payment_mode = $("#payment_mode").val();
     var cheque_no = $("#cheque_no").val();
     var cheque_date = $("#cheque_date").val();
     var cheque_bank = $("#cheque_bank").val();     
     var again_due_amt = $("#again_due_amt").val();     
     var next_due_date = $("#next_due_date").val();     
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
        }else if(again_due_amt > 0 && next_due_date == ""){
            $("#valid_err").text('Error : Select Next Due Date');
            $('#renewalvalidationModal').modal('show');
            $('#next_due_date').focus();
            return valid = false;
        }else if(collection_branch == ""){
            $("#valid_err").text('Error : Select Collection Branch');
            $('#renewalvalidationModal').modal('show');
            $('#collection_branch').focus();
            return valid = false;
        }
        return valid
}
function getPayment()
{
    agin_due = 0;
    var  due_payable_amt = $("#due_amt").val();
    var payment_now = $("#payment_now").val();  

   var agin_due = parseFloat(due_payable_amt)-parseFloat(payment_now);
    $("#again_due_amt").val(agin_due.toFixed(2));
    getTotal();
    return true;
}

function getTotal()
{    
    var paid=  $("#payment_now").val();   
    var total;
    var tax_amt1;
    var tax_amt2;

    var cgstrate=$("#cgstrate option:selected").text();  
    var sgstrate = $("#sgstrate option:selected").text(); 
    
    if(cgstrate>0)
    {
        tax_amt1 = ((cgstrate/100) * paid);
        $("#cgstAmount").val( parseFloat(tax_amt1.toFixed(2)));
    }
    else
    {
        tax_amt1 = 0;
        $("#cgstAmount").val( parseFloat(tax_amt1.toFixed(2)));
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
    $("#payable_amt").val(total.toFixed(2));    
    return true;
    
}

function getAllduereminder(){
  
    var from_dt = $("#from_dt").val();
    var to_date = $("#to_date").val();
    var branch = $("#branch").val();
    var card = $("#card").val();
      
   
    $("#due_reminder_list").html(''); 
    $("#loader").css('display','block');
    var formData = {from_dt:from_dt,to_date:to_date,branch:branch,card:card};
    var method = 'duereminder/getAllduereminder';
    var data =  htmlshowajaxcomtroller(method,formData);
     $("#loader").css('display','none');
     $("#due_reminder_list").html(data);
     $('.dataTable').DataTable();
     $("#total_amount_due").text($("#total_due").val());


  }