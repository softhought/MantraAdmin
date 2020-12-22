$(document).ready(function(){

   

    basepath = $("#basepath").val();

    $(document).on('submit', '#AmcForm', function(event) {

        event.preventDefault();

        var formData = new FormData($(this)[0]);

        console.log(formData);

      // alert();

        if (validateform()) {

           var formData = new FormData($(this)[0]);

            $("#savebtn").css('display', 'none');
            $("#loaderbtn").css('display', 'inline-block');

           var method = 'annualmaintanancechrg/addedit_action';

           var data =  ajaxcallcontroller(method,formData);

           window.location.href = basepath + 'annualmaintanancechrg';

        //    if(data.msg_status == 1 && data.mode == 'ADD'){
        //        $("#loaderbtn").css('display', 'none');
        //        $("#savebtn").css('display', 'inline-block'); 
        //        $("#statutory_name").val('');
             
        //        $("#errormsg").text(data.msg_data).css('color','#775dbf');

        //    }else if(data.msg_status == 1 && data.mode == 'EDIT'){

        //        window.location.href = basepath + 'statutorymaster';

        //    }          

           

        }

    });




})



function validateform(){

    var item_name = $("#item_name").val();
    var expiry_date = $("#expiry_date").val();
    var renewal_amt = $("#renewal_amt").val();    
   

    $("#errormsg").text('').css('color','red');
    if(item_name == ""){
        $("#errormsg").text('Error : Select item name');
        $("#item_name").focus();
        return false;

    }
    else if(expiry_date == ""){
        $("#errormsg").text('Error : Select expiry date');
        $("#expiry_date").focus();
        return false;

    }else if(renewal_amt == ""){
        $("#errormsg").text('Error : Enter Renewal Amount');
        $("#renewal_amt").focus();
        return false;

    }

    return true;

}

