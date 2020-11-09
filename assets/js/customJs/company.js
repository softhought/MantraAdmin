$(document).ready(function(){
    
    basepath = $("#basepath").val();
    $(document).on('submit', '#CreateCompanyForm', function(event) {
        event.preventDefault();
        var formData = new FormData($(this)[0]);
        console.log(formData);
      // alert();
        if (validateform()) {
           var formData = new FormData($(this)[0]);
            $("#companysavebtn").css('display', 'none');
            $("#loaderbtn").css('display', 'inline-block');

           var method = 'createcompany/createcompany_action';
           var data =  ajaxcallcontroller(method,formData);
          
           if(data.msg_status == 1 && data.mode == 'ADD'){
               
                $("#loaderbtn").css('display', 'none');
                $("#companysavebtn").css('display', 'inline-block'); 
                Swal.fire({ 
                        title: 'Registration No : ' + data.registration_no,    
                        text: "",    
                        icon: 'info',    
                        width: 350,    
                        padding: '1em', 
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok', 
                        customClass: {    
                            title: 'alerttitale',    
                            content: 'alerttext',    
                            confirmButton: 'btn tbl-action-btn padbtn',  
                        },    
                    }).then((result) => {    
                        if (result.value) {    
                            window.location.href = basepath + 'createcompany';    

                        }    
                    });    
                                
                
           }else{
                   window.location.href = basepath + 'createcompany';   
           }
           
        }
    });  
    
    $("#company_name").keyup(function(){
        $("#errormsg").text("");
        if(checkcompanyname()){
            $("#errormsg").text("Company Name Already Exists");
        }        
    });
    $("#short_name").keyup(function(){
        $("#errormsg").text("");
        if(checkcompanyshortname()){
            $("#errormsg").text("Company Short Name Already Used");
        }
    });   
})

function validateform(){
   var company_name = $("#company_name").val();
   var short_name = $("#short_name").val();
   var email = $("#email").val();
   var mobile_no = $("#mobile_no").val();
   $("#errormsg").text("");
   if(company_name == ""){
          $("#errormsg").text("Error : Enter Company Name");
          $("#company_name").focus();
          return false();
   }
   else if(short_name == ""){
        $("#errormsg").text("Error : Enter Company Short Name");
        $("#short_name").focus();
        return false();
   } else if(email == ""){
    $("#errormsg").text("Error : Enter Email");
    $("#short_name").focus();
    return false();
    } else if(mobile_no == ""){
        $("#errormsg").text("Error : Enter Mobile No.");
        $("#short_name").focus();
        return false();
    }else if(mobile_no.length < 10){
        $("#errormsg").text("Error : Enter 10 Digit Mobile No.");
        $("#short_name").focus();
        return false();
    }else if(checkcompanyname()){
         $("#errormsg").text("Company Name Already Exists");
         $("#company_name").focus();
         return false();
    }else if(checkcompanyshortname()){
        $("#errormsg").text("Company Short Name Already Used");
        $("#short_name").focus();
         return false();
    }
  return true;
}

function checkcompanyname(){
    var company_name = $("#company_name").val();
    var companyId = $("#companyId").val();
    var where = {company_name:company_name};
    var where_notequal = "comany_id != "+companyId;
    var formData = {where:where,where_notequal:where_notequal,id:companyId};
    var method = 'commancontroller/check_existingdata';
    var data =  ajaxcallcontrollerforcutom(method,formData);
    if(data.msg_status == 1){ 
        return 1;
    }else{
        return 0;
    }
}

function checkcompanyshortname(){
    var short_name = $("#short_name").val();
    var companyId = $("#companyId").val();
    var where = {short_name:short_name};
    var where_notequal = "comany_id != "+companyId;
    var formData = {where:where,where_notequal:where_notequal,id:companyId};
    var method = 'commancontroller/check_existingdata';
    var data =  ajaxcallcontrollerforcutom(method,formData);
    if(data.msg_status == 1){ 
        return 1;         
       
    }else{
        return 0;
    }

}