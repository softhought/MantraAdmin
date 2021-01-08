$(document).ready(function () {
    basepath = $("#basepath").val();

    $(document).on("click", "#cashdepositshowbtn", function (event) {
        event.preventDefault();
    
       var from_dt = $("#from_dt").val();
       var to_date = $("#to_date").val();
       var branch = $("#branch").val(); 
        $("#cashdeposit_list").html("");    
        $("#loader").css('display','block');
      
        var method = "cashdeposit/getAllCashDepostit";
        formData = {from_dt:from_dt,to_date:to_date,branch:branch}
        var result = htmlshowajaxcomtroller(method, formData);
        $("#loader").css('display','none');      
       
        $("#cashdeposit_list").html(result); 
        $('.dataTable').DataTable();   
       
      });

$("#cashdepositshowbtn").trigger('click');
//form submit
$(document).on('submit', '#CashdepositForm', function(event) {
    event.preventDefault();
    var formData = new FormData($(this)[0]);
    //console.log(formData);
  // alert();
    if (validateform()) {
       var formData = new FormData($(this)[0]);
        $("#cashdepositsavebtn").css('display', 'none');
        $("#loaderbtn").css('display', 'inline-block');

       var method = 'cashdeposit/addedit_action';
       var data =  ajaxcallcontroller(method,formData);
       if(data.msg_status == 1 && data.mode == 'ADD'){
        $("#loaderbtn").css('display', 'none');
        $("#cashdepositsavebtn").css('display', 'inline-block');
        Swal.fire({
        title: "Voucher No : " + data.voucherno,
        text: "",
        icon: "info",
        width: 350,
        padding: "1em",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Ok",
        customClass: {
          title: "alerttitale",
          content: "alerttext",
          confirmButton: "btn tbl-action-btn padbtn",
        },
      }).then((result) => {
        if (result.value) {
          window.location.href = basepath + "cashdeposit";
        }else{
            alert();
        }
      });

   
 }
   else if(data.msg_status == 1 && data.mode == 'EDIT'){
    window.location.href = basepath + "cashdeposit";
   }   
       
    }
}); 


// delete cashdeposit

$(".cashdepositdelete").click(function(){
  var id = $(this).attr('id');
  var tran_id = $(this).attr('data-cashdepositid');
  var voucher_id = $(this).attr('data-voucherid');
 
  Swal.fire({    
      // title: 'Receipt No : ' + data.receipt_no,    
      text: "Are you sure you wish to delete this entry?",    
      icon: 'info',    
      width: 350,    
      padding: '1em',    
      showCancelButton: true,    
      confirmButtonColor: '#3085d6',    
      cancelButtonColor: 'btn btn-danger',    
      confirmButtonText: 'Yes',    
      cancelButtonText: 'No',    
      customClass: {    
          title: 'alerttitale',    
          content: 'alerttext',    
          confirmButton: 'btn tbl-action-btn padbtn',    
          cancelButton: 'btn tbl-action-btn padbtn',    
      },    
  }).then((result) => {    
      if (result.value) {   
                      var formData = {tran_id:tran_id,voucher_id:voucher_id};
                      var method = 'cashdeposit/deletecashdeposit';
                      var data =  ajaxcallcontrollerforcutom(method,formData); 
           if(data.msg_status == 1){
            
                $("#cash_deposit_"+id).css('display','none');
           }
              

      }   
  });
  });

});

function validateform(){

    var date_of_deposit = $("#date_of_deposit").val();
    var branch = $("#branch").val();
    var debit_acc_id = $("#debit_acc_id").val();
    var credit_acc_id = $("#credit_acc_id").val();
    var deposit_amt = $("#deposit_amt").val();

    if(date_of_deposit == ""){
        $("#errormsg").text("Error : Select deposit date");
        $("#date_of_deposit").focus();
        return false;
    }else if(branch == ""){
        $("#errormsg").text("Error : Select branch");
        $("#branch").focus();
        return false;
    }else if(debit_acc_id == ""){
        $("#errormsg").text("Error : Select debit account");
        $("#debit_acc_id").focus();
        return false;
    }else if(credit_acc_id == ""){
        $("#errormsg").text("Error : Select credit account");
        $("#credit_acc_id").focus();
        return false;
    }else if(deposit_amt == ""){
        $("#errormsg").text("Error : Enter  deposit amount");
        $("#deposit_amt").focus();
        return false;
    }
   return true;

}