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



    $("#wing_name").focusout(function(){

        checkexistingwing()

        

    })



    //wings category

    $(document).on('submit', '#WingscategoryForm', function(event) {

        event.preventDefault();

        var formData = new FormData($(this)[0]);

        console.log(formData);

      // alert();

        if (validatecatform()) {

           var formData = new FormData($(this)[0]);

            $("#catsavebtn").css('display', 'none');

            $("#loaderbtn").css('display', 'inline-block');



           var method = 'wingscategory/addedit_action';

           var data =  ajaxcallcontroller(method,formData);

           //window.location.href = basepath + 'createbranch';

           if(data.msg_status == 1 && data.mode == 'ADD'){

               $("#loaderbtn").css('display', 'none');

               $("#catsavebtn").css('display', 'inline-block');               

               $("#category_name").val('').change();

              

               $("#errormsg").text(data.msg_data).css('color','#775dbf');

           }else if(data.msg_status == 1 && data.mode == 'EDIT'){

               window.location.href = basepath + 'wingscategory';

           }          

           

        }

    });



    $("#category_name").focusout(function(){

        existingwingcat()

        

    })



})



function validateform(){

    var wing_name = $("#wing_name").val();
    var category = $("#category").val();

    $("#errormsg").text('');
    if(category == ""){

        $("#errormsg").text('Error : Select wing category');

        $("#category").focus();

        return false;



    }

    else if(wing_name == ""){

        $("#errormsg").text('Error : Enter wing name');

        $("#wing_name").focus();

        return false;



    }
    else if(checkexistingwing()){

        $("#wing_name").focus();

        return false;

    }

    return true;

}



function checkexistingwing(){

    $("#errormsg").text('');

    var wing_name = $("#wing_name").val();      
    var category = $("#category").val();      

    var wingId = $("#wingId").val();      

    var formData = {wingId:wingId,wing_name:wing_name,category:category};

    var method = 'enquirywing/existingwing';

    var data =  ajaxcallcontrollerforcutom(method,formData);

    if(data.msg_status == 1){ 

        $("#errormsg").text('Error : Wing aleardy exists');

        return 1;

    }else{

        return 0;

    }



}



function validatecatform(){

    var category_name = $("#category_name").val();

    $("#errormsg").text('');

    if(category_name == ""){

        $("#errormsg").text('Error : Enter wing  category name');

        $("#category_name").focus();

        return false;



    }else if(existingwingcat()){

        $("#category_name").focus();

        return false;

    }

    return true;

}



function existingwingcat(){

    $("#errormsg").text('');

    var category_name = $("#category_name").val();      

    var catId = $("#catId").val();      

    var formData = {catId:catId,category_name:category_name};

    var method = 'wingscategory/existingwingcat';

    var data =  ajaxcallcontrollerforcutom(method,formData);

    if(data.msg_status == 1){ 

        $("#errormsg").text('Error : Wing category aleardy exists');

        return 1;

    }else{

        return 0;

    }



}