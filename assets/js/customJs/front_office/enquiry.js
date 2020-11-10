$(document).ready(function(){
    basepath = $("#basepath").val();
    $(document).on('submit', '#EnquiryForm', function(event) {
        event.preventDefault();
        var formData = new FormData($(this)[0]);
        //console.log(formData);
    
        if (validateform()) {
           var formData = new FormData($(this)[0]);
            $("#enquirysavebtn").css('display', 'none');
            $("#loaderbtn").css('display', 'inline-block');

           var method = 'enquiry/addedit_action';
           var data =  ajaxcallcontroller(method,formData);         
           if(data.msg_status == 1 && data.mode == 'ADD'){
              
            $("#loaderbtn").css('display', 'none');
            $("#enquirysavebtn").css('display', 'inline-block');
            $("#errormsg").text(data.msg_data).css('color','#775dbf');
            $("#enquiry_dt").val('');
            $("#first_name").val('');
            $("#wings").val('').change();
            $("#last_name").val('');
            $("#branch_id").val('').change();
            $("#pin").val('').change();
            $("#location").val('').change();
            $("#email").val('');
            $("#mobile_no").val('');
            $("#whatsapp_no").val('');
            $("#address").val('');
            $("#remarks").val('');
            $("#followup_date").val('');
            $("#done_by").val('').change();
              //$("#EnquiryForm").reset();           
            
           }
        //    else if(data.msg_status == 1 && data.mode == 'EDIT'){
        //        window.location.href = basepath + 'createbranch';
        //    }          
           
        }
    });

    $("#pin").change(function(){
        var pin = $("#pin option:selected").text();
        var formData = {pin:pin};
        var method = 'enquiry/getlocation';
        var data =  ajaxcallcontrollerforcutom(method,formData);
        $("#location").html(data.locationlist);
    })

})

function validateform(){
    var enquiry_dt = $("#enquiry_dt").val();
    var first_name = $("#first_name").val();
    var wings = $("#wings").val();
    var last_name = $("#last_name").val();
    var branch_id = $("#branch_id").val();
    var pin = $("#pin").val();
    var location = $("#location").val();   
    var mobile_no = $("#mobile_no").val();   
    var address = $("#address").val();   
    var followup_date  = $("#followup_date").val();
    var done_by = $("#done_by").val();
    $("#errormsg").text("").css('color','red');
    if(enquiry_dt == ""){
        $("#errormsg").text("Error : Select Enquiry Date");
        $("#enquiry_dt").focus();
        return false;
    }else if(first_name == ""){
        $("#errormsg").text("Error : Enter First Name");
        $("#first_name").focus();
        return false;
    }else if(wings == ""){
        $("#errormsg").text("Error : Select Wing");
        $("#wings").focus();
        return false;
    }
    else if(last_name == ""){
        $("#errormsg").text("Error : Enter Last Name");
        $("#last_name").focus();
        return false;
    }else if(branch_id == ""){
        $("#errormsg").text("Error : Select Branch");
        $("#branch_id").focus();
        return false;
    }else if(pin == ""){
        $("#errormsg").text("Error : Select Pin");
        $("#pin").focus();
        return false;
    }else if(location == ""){
        $("#errormsg").text("Error : Select Location");
        $("#location").focus();
        return false;
    }else if(mobile_no == ""){
        $("#errormsg").text("Error : Enter Mobile No.");
        $("#mobile_no").focus();
        return false;
    }else if(mobile_no.length < 10){
        $("#errormsg").text("Error : Enter 10 Digit Mobile No.");
        $("#mobile_no").focus();
        return false;
    }else if(address == ""){
        $("#errormsg").text("Error : Enter Address");
        $("#address").focus();
        return false;
    }else if(followup_date == ""){
        $("#errormsg").text("Error : Select Follow-Up Date");
        $("#followup_date").focus();
        return false;
    }else if(done_by == ""){
        $("#errormsg").text("Error : Select Done By");
        $("#done_by").focus();
        return false;
    }
return true;

}