$(document).ready(function(){

    basepath = $("#basepath").val();
    $(document).on('submit', '#CreateBranchForm', function(event) {
        event.preventDefault();
        var formData = new FormData($(this)[0]);
        console.log(formData);
      // alert();
        if (valiadateform()) {
           var formData = new FormData($(this)[0]);
            $("#branchsavebtn").css('display', 'none');
            $("#loaderbtn").css('display', 'inline-block');

           var method = 'createbranch/createbranch_action';
           var data =  ajaxcallcontroller(method,formData);
           window.location.href = basepath + 'createbranch';
        //    if(data.msg_status == 1 && data.mode == 'ADD'){
        //        $("#errormsg").text(data.msg_data);
        //    }else if(data.msg_status == 1 && data.mode == 'EDIT'){
        //        window.location.href = basepath + 'createbranch';
        //    }          
           
        }
    });
    
    $("#branch_name").keyup(function(){
        var comapny_id = $("#company_id").val();
        $("#errormsg").text("");
        
        if(comapny_id == ""){
            $("#errormsg").text("Error : Select Company Name");
            $("#comapny_id").focus();
        }else if(checkbranchname()){          
            $("#errormsg").text("Branch Name Already Used For This Company");
        }  
    })
    $("#branch_code").keyup(function(){
        var comapny_id = $("#company_id").val();
        $("#errormsg").text("");
        if(comapny_id == ""){
            $("#errormsg").text("Error : Select Company Name");
            $("#comapny_id").focus();
        }else if(checkbranchcode()){          
            $("#errormsg").text("Branch Code Already Used For This Company");
        } 
         
    })

})

function  valiadateform(){
    var comapny_id = $("#company_id").val();
    var branch_name = $("#branch_name").val();
    var branch_code = $("#branch_code").val();
    var gst_no = $("#gst_no").val();
    var personal_contact = $("#personal_contact").val();
    var branch_address = $("#branch_address").val();
    $("#errormsg").text("");
   if(comapny_id == ""){
          $("#errormsg").text("Error : Select Company Name");
          $("#comapny_id").focus();
          return false();
   }else if(branch_name == ""){
    $("#errormsg").text("Error : Enter Branch Name");
    $("#branch_name").focus();
    return false();
    }
    else if(branch_code == ""){
        $("#errormsg").text("Error : Enter Branch Code");
        $("#branch_code").focus();
        return false();
    }
    // else if(gst_no == ""){
    //     $("#errormsg").text("Error : Enter GST No.");
    //     $("#gst_no").focus();
    //     return false();
    // }
    // else if(personal_contact == ""){
    //     $("#errormsg").text("Error : Enter Personal Contact No.");
    //     $("#personal_contact").focus();
    //     return false();
    // }
    else if(branch_address == ""){
        $("#errormsg").text("Error : Enter Branch Address");
        $("#branch_address").focus();
        return false();
    }else if(checkbranchname()){          
        $("#errormsg").text("Branch Name Already Used For This Company");
        $("#branch_name").focus();
        return false();
    } else if(checkbranchcode()){          
        $("#errormsg").text("Branch Code Already Used For This Company");
        $("#branch_code").focus();
        return false();
    }
    return true;
}

function checkbranchname(){
    var comapny_id = $("#company_id").val();    
    var branch_name = $("#branch_name").val();     
    var branchId = $("#branchId").val();     
    var formData = {comapny_id:comapny_id,branch_name:branch_name,branchId:branchId};
    var method = 'createbranch/existingbarnchname';
    var data =  ajaxcallcontrollerforcutom(method,formData);
    if(data.msg_status == 1){ 
        return 1;
    }else{
        return 0;
    }

}

function checkbranchcode(){
    var comapny_id = $("#company_id").val();    
    var branch_code = $("#branch_code").val();     
    var branchId = $("#branchId").val();   
    var formData = {comapny_id:comapny_id,branch_code:branch_code,branchId:branchId};
    var method = 'createbranch/existingbarnchcode';
    var data =  ajaxcallcontrollerforcutom(method,formData);
    if(data.msg_status == 1){ 
        return 1;         
       
    }else{
        return 0;
    }

}