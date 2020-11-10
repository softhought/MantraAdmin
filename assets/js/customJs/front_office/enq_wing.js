$(document).ready(function(){
   
    basepath = $("#basepath").val();
    $(document).on('submit', '#WingsForm', function(event) {
        event.preventDefault();
        var formData = new FormData($(this)[0]);
        console.log(formData);
      // alert();
        if (validateform()) {
           var formData = new FormData($(this)[0]);
            $("#wingsavebtn").css('display', 'none');
            $("#loaderbtn").css('display', 'inline-block');

           var method = 'enquirywing/addedit_action';
           var data =  ajaxcallcontroller(method,formData);
           //window.location.href = basepath + 'createbranch';
           if(data.msg_status == 1 && data.mode == 'ADD'){
               $("#loaderbtn").css('display', 'none');
               $("#wingsavebtn").css('display', 'inline-block');               
               $("#wing_name").val('');
               $("#short_desc").val('');
               $("#errormsg").text(data.msg_data).css('color','#775dbf');
           }else if(data.msg_status == 1 && data.mode == 'EDIT'){
               window.location.href = basepath + 'enquirywing';
           }          
           
        }
    });

    $("#wing_name").keyup(function(){
        checkexistingwing()
        
    })
})

function validateform(){
    var wing_name = $("#wing_name").val();
    $("#errormsg").text('');
    if(wing_name == ""){
        $("#errormsg").text('Error : Enter Wing Name');
        $("#wing_name").focus();
        return false;

    }else if(checkexistingwing()){
        $("#wing_name").focus();
        return false;
    }
    return true;
}

function checkexistingwing(){
    $("#errormsg").text('');
    var wing_name = $("#wing_name").val();      
    var wingId = $("#wingId").val();      
    var formData = {wingId:wingId,wing_name:wing_name};
    var method = 'enquirywing/existingwing';
    var data =  ajaxcallcontrollerforcutom(method,formData);
    if(data.msg_status == 1){ 
        $("#errormsg").text('Error : Wing Aleardy Exists');
        return 1;
    }else{
        return 0;
    }

}