$(document).ready(function(){
  

    basepath = $("#basepath").val();

    //wings category

    $(document).on('submit', '#ZoneForm', function(event) {
        event.preventDefault();
        var formData = new FormData($(this)[0]);
        //console.log(formData);
      // alert();

        if (validateform()) {
           var formData = new FormData($(this)[0]);
            $("#zonesavebtn").css('display', 'none');
            $("#loaderbtn").css('display', 'inline-block');
           var method = 'zone/addedit_action';

           var data =  ajaxcallcontroller(method,formData);
           //window.location.href = basepath + 'createbranch';
           if(data.msg_status == 1 && data.mode == 'ADD'){
               $("#loaderbtn").css('display', 'none');
               $("#zonesavebtn").css('display', 'inline-block'); 
               $("#zone_name").val('');             

               $("#errormsg").text(data.msg_data).css('color','#775dbf');

           }else if(data.msg_status == 1 && data.mode == 'EDIT'){
               window.location.href = basepath + 'zone';
           }          
         

        }

    });

    $("#zone_name").focusout(function(){
        existingzone();       

    })

})


function validateform(){

    var zone_name = $("#zone_name").val();
    $("#errormsg").text('').css('color','red');
    if(zone_name == ""){

        $("#errormsg").text('Error : Enter zone name');
        $("#zone_name").focus();
        return false;

    }else if(existingzone()){

        $("#zone_name").focus();
        return false;
    }

    return true;

}



function existingzone(){

    $("#errormsg").text('');
    var zone_name = $("#zone_name").val();     

    var zoneId = $("#zoneId").val();
    var formData = {zoneId:zoneId,zone_name:zone_name};
    var method = 'zone/existingzone';
    var data =  ajaxcallcontrollerforcutom(method,formData);
    if(data.msg_status == 1){ 
        $("#errormsg").text('Error : Zone name aleardy exists');
        return 1;
    }else{
        return 0;
    }
}