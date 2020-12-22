$(document).ready(function(){

    basepath = $("#basepath").val();

    $("#txtcode").keyup(function(){   
        $("#errormsg").text("");
        if(checkduplicate()){
            $("#errormsg").text("Error : Starting Letter Already Exists");
            $("#txtcode").focus();
           
       }     
        
    })

//Main Package form submit
$(document).on('submit', '#MainPackageForm', function(event) {
    event.preventDefault();
    var formData = new FormData($(this)[0]);
    //console.log(formData);
  // alert();
    if (validateform()) {
       var formData = new FormData($(this)[0]);
        $("#packagesavebtn").css('display', 'none');
        $("#loaderbtn").css('display', 'inline-block');

       var method = 'package/addedit_action';
       var data =  ajaxcallcontroller(method,formData);
       window.location.href = basepath + 'package'; 
    //    if(data.msg_status == 1 && data.mode == 'ADD'){           
    //         $("#loaderbtn").css('display', 'none');
    //         $("#packagesavebtn").css('display', 'inline-block');             
                            
            
    //    }else{
    //            window.location.href = basepath + 'createcompany';   
    //    }
       
    }
}); 

// Facilities Form Submit
$(document).on('submit', '#PackageFacilitiesForm', function(event) {
    event.preventDefault();
    var formData = new FormData($(this)[0]);
    
    if (facilitiesformvalidate()) {
       var formData = new FormData($(this)[0]);
        $("#facilitiesavebtn").css('display', 'none');
        $("#loaderbtn").css('display', 'inline-block');

       var method = 'package/facilities_addedit_action';
       var data =  ajaxcallcontroller(method,formData);
       window.location.href = basepath + 'package/facilities'; 
    //    if(data.msg_status == 1 && data.mode == 'ADD'){           
    //         $("#loaderbtn").css('display', 'none');
    //         $("#facilitiesavebtn").css('display', 'inline-block');             
                            
            
    //    }else{
    //            window.location.href = basepath + 'createcompany';   
    //    }
       
    }
}); 

$(document).on("click","#facilitiesdel",function(){
  var coupon_id = $(this).attr('data-delid');
  
    Swal.fire({    
        title: 'Do you want to delete',    
        text: "",    
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
            var formData = {coupon_id:coupon_id};
            var method = 'package/deletefacilities';
            var data =  ajaxcallcontrollerforcutom(method,formData);
            if(data.msg_status == 1){        
               // alert("row_"+coupon_id);        
                $("#row_"+coupon_id).css('display','none');
            }
                 
        }
        // } else {    
        //     window.location.replace(basepath + 'partyreceipt/addReceipt');    
        // }    
    });    
})


});

function validateform(){
    var txtcode = $("#txtcode").val();
    var package_name = $("#package_name").val();
  
    $("#errormsg").text("");
    if(txtcode == ""){
           $("#errormsg").text("Error : Enter Starting Letter");
           $("#txtcode").focus();
           return false();
    }
    else if(package_name == ""){
         $("#errormsg").text("Error : Enter Main Package Name");
         $("#package_name").focus();
         return false();
    } else if(checkduplicate()){
        $("#errormsg").text("Error : Starting Letter Already Exists");
        $("#txtcode").focus();
        return false();
   } 
   return true;
 }

function readCommanURL2(input) {
   
    var id = $(input).attr('data-showId');
    var isimage = $(input).attr('data-isimage');
  
    $("#"+isimage).val('Y');
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#'+id)
                .attr('src', e.target.result)
                .width(200)
                .height(70);
        };

        reader.readAsDataURL(input.files[0]);

    }

}
function checkduplicate(){
    var txtcode = $("#txtcode").val();
    var productId = $("#productId").val();
  
    var formData = {txtcode:txtcode,productId:productId};
    var method = 'package/checkduplicate';
    var data =  ajaxcallcontrollerforcutom(method,formData);
    if(data.msg_status == 1){ 
        return 1;
    }else{
        return 0;
    }

}

function facilitiesformvalidate(){
    var coupon_title = $("#coupon_title").val();
    var rate_type = $("#rate_type").val();
    var sms_title = $("#sms_title").val();
  
    $("#errormsg").text("");
    if(coupon_title == ""){
           $("#errormsg").text("Error : Enter coupon title code");
           $("#coupon_title").focus();
           return false();
    }
    else if(rate_type == ""){
         $("#errormsg").text("Error : Select rate type");
         $("#rate_type").focus();
         return false();
    } else if(sms_title.length > 10){
        $("#errormsg").text("Error : Enter sms title less then in 11 character");
        $("#sms_title").focus();
        return false();
   } 
   return true;
 }



