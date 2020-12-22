$(document).ready(function(){

   

    basepath = $("#basepath").val();

    $(document).on('submit', '#StatutoryForm', function(event) {

        event.preventDefault();

        var formData = new FormData($(this)[0]);

        console.log(formData);

      // alert();

        if (validateform()) {

           var formData = new FormData($(this)[0]);

            $("#savebtn").css('display', 'none');
            $("#loaderbtn").css('display', 'inline-block');

           var method = 'statutorymaster/addedit_action';

           var data =  ajaxcallcontroller(method,formData);

           //window.location.href = basepath + 'createbranch';

           if(data.msg_status == 1 && data.mode == 'ADD'){
               $("#loaderbtn").css('display', 'none');
               $("#savebtn").css('display', 'inline-block'); 
               $("#statutory_name").val('');
             
               $("#errormsg").text(data.msg_data).css('color','#775dbf');

           }else if(data.msg_status == 1 && data.mode == 'EDIT'){

               window.location.href = basepath + 'statutorymaster';

           }          

           

        }

    });



    $("#statutory_name").keyup(function(){

        checkexisting()

        

    })


})



function validateform(){

    var statutory_name = $("#statutory_name").val();
   

    $("#errormsg").text('').css('color','red');
    if(statutory_name == ""){

        $("#errormsg").text('Error : Enter Statutory name');

        $("#statutory_name").focus();

        return false;



    }
    else if(checkexisting()){

        $("#statutory_name").focus();

        return false;

    }

    return true;

}



function checkexisting(){

    $("#errormsg").text('');

    var statutory_name = $("#statutory_name").val();
    var statutoryId = $("#statutoryId").val(); 
    var formData = {statutoryId:statutoryId,statutory_name:statutory_name};
    var method = 'statutorymaster/checkexisting';
    var data =  ajaxcallcontrollerforcutom(method,formData);
    $("#errormsg").text('').css('color','red');
    if(data.msg_status == 1){ 
        $("#errormsg").text('Error : Statutory aleardy exists');

        return 1;

    }else{

        return 0;

    }



}


