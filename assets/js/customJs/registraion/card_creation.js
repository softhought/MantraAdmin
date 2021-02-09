$(document).ready(function(){

    basepath = $("#basepath").val();

    $("#addcardrate").click(function(){
      
        var branch = $("#branch").val();
        var package_rate = $("#package_rate").val();
        var renewal_rate = $("#renewal_rate").val();
        var disount_rate = $("#disount_rate").val();
        var rowno = parseInt($("#rowno").val())+parseInt(1);

        if(validatecard()){
            var formData = {rowno:rowno,branch:branch,package_rate:package_rate,renewal_rate:renewal_rate,disount_rate:disount_rate};
            var method = 'packagecardcreation/getcardrate';
            var data =  htmlshowajaxcomtroller(method,formData); 
            $("#rowno").val(rowno);
            $("#detail_cardrate table").show();
            $("#detail_cardrate table tbody").append(data);
            $("#branch").val('').change();
            $("#package_rate").val('');
            $("#renewal_rate").val('');
            $("#disount_rate").val('');
            $("#is_card_rate_change").val('Y');
           

        }

    })

    var delIdarr = [];

    $(document).on('click', '.delcardDetails', function() {
        var currRowID = $(this).attr('id');
        var rowDtlNo = currRowID.split('_');
        //delIdarr.push($("#childdtlId_" + rowDtlNo[1]).val());
        //console.log(delIdarr);
        $("#delIds").val(delIdarr);
        //$("tr#rowDocument_"+rowDtlNo[1]+"_"+rowDtlNo[2]).remove();
        $("tr#rowcarddetails_" + rowDtlNo[1]).remove();
        $("#is_card_rate_change").val('Y');
    });

    $("#addpackagedtl").click(function(){
      
        var packdtl_branch = $("#packdtl_branch").val();
        var facility_id = $("#facility").val();
        var facility_name = $("#facility option:selected").text();
        var qty = $("#qty").val();
        var type = $("#type").val();
        var work_out = $("#work_out").val();
        var sub_group = $("#sub_group").val();
        var rowno = parseInt($("#dtl_rowno").val())+parseInt(1);
        if(validatedata()){
        addeditpackagelist(packdtl_branch,facility_id,facility_name,qty,type,work_out,sub_group,rowno);
        }
        $("#packdtl_branch").val('').change();
        $("#facility").val('').change();
        $("#qty").val('');
        $("#type").val('').change();
        $("#work_out").val('').change();
        $("#work_out").val('').change();
        $("#sub_group").val('').change();
        $("#is_card_detail_change").val('Y');
    });

    
    $(document).on('click', '.delfacilityDetails', function() {
        var currRowID = $(this).attr('id');
        var rowDtlNo = currRowID.split('_');
        //delIdarr.push($("#childdtlId_" + rowDtlNo[1]).val());
        //console.log(delIdarr);
        $("#delIds").val(delIdarr);
        //$("tr#rowDocument_"+rowDtlNo[1]+"_"+rowDtlNo[2]).remove();
        $("tr#rowfacilitydetails_" + rowDtlNo[1]).remove();
        $("#is_card_detail_change").val('Y');
    });

    $(document).on('change', '#package_cat', function() {
       // alert($('#package_cat option:selected').attr('data-prefix'));
       $("#card_prefix").val($('#package_cat option:selected').attr('data-prefix'));
    })

    $(document).on('keyup', '#card_code', function() {
        $("#errormsg").text('');
        $(this).css('border','1px solid #ced4da');
        var mode = $("#mode").val();  
        if(mode == 'ADD' && checkcarcode() == 1){
            $(this).css('border','1px solid red');
            $("#errormsg").text('Error : Code Already Exists');
            $(this).focus();
        }

      
     });

    //  form submit
    $(document).on('submit', '#CardCreationForm', function(event) {
        event.preventDefault();
        var formData = new FormData($(this)[0]);
        console.log(formData);
      // alert();
        if (validateform()) {
           var formData = new FormData($(this)[0]);
            $("#cardsavebtn").css('display', 'none');
            $("#loaderbtn").css('display', 'inline-block');

           var method = 'packagecardcreation/addedit_action';
           var data =  ajaxcallcontroller(method,formData);
           window.location.href = basepath + 'packagecardcreation';
        //    if(data.msg_status == 1 && data.mode == 'ADD'){
        //        $("#errormsg").text(data.msg_data);
        //    }else if(data.msg_status == 1 && data.mode == 'EDIT'){
        //        window.location.href = basepath + 'createbranch';
        //    }          
           
        }
    });

     /* check appearance_serial */
     $(document).on('keyup','#appearance_serial',function(e){
        e.preventDefault();       
       
       var appearance_serial = $('#appearance_serial').val();
       var card_prefix=$('#card_prefix').val();       
       
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) 
        {  
            // checking for only numeric value              
            $('#appearance_serial').val($('#appearance_serial').val().replace(/[^\d.]/g,''));
        }
        $('#status_appearance_serial').html("");	            
        if (appearance_serial!=""){

            var formData = {appearance_serial:appearance_serial,card_prefix:card_prefix};
            var method = 'packagecardcreation/CheckPrefixWithAppearance';
            var data =  ajaxcallcontrollerforcutom(method,formData);

            if (data.msg_status == 0) {			
                $('#status_appearance_serial').html("");
                
                $('<img src="'+data.base_url+'assets/img/active-icon.png" alt="'+data.msg_data+'" height="20" width="20">').appendTo( "#status_appearance_serial" );
            }else {
               $('#status_appearance_serial').html("");
               
              $('<img src="'+data.base_url+'assets/img/inactive2.png" alt="'+data.msg_data+'" height="20" width="20">').appendTo( "#status_appearance_serial" );
            }
             
              
        }
    });


});

function addeditpackagelist(packdtl_branch,facility_id,facility_name,qty,type,work_out,sub_group,rowno){
     
    if($("#package_dtl").find('#table_'+packdtl_branch).length) {
      
        var newtrtb = 'Row';
        var srlNo = parseInt($('#srl_no_'+packdtl_branch).val())+parseInt(1);
    }else{           
        var newtrtb = 'Table';
        var srlNo = 1;
        
    }
    if(1){
        var formData = {newtrtb:newtrtb,srlNo:srlNo,rowno:rowno,packdtl_branch:packdtl_branch,facility_id:facility_id,facility_name:facility_name,qty:qty,type:type,work_out:work_out,sub_group:sub_group};
        var method = 'packagecardcreation/getpackagedtl';
        var data =  htmlshowajaxcomtroller(method,formData); 
        $("#dtl_rowno").val(rowno);
        $('#srl_no_'+packdtl_branch).val(srlNo);
        if(newtrtb == 'Table'){
        $("#package_dtl").show();
        $("#package_dtl").append(data);
       
        }else{                
            $('#table_'+packdtl_branch).show();
            $('#table_'+packdtl_branch+' tbody').append(data);
        }
    }

}
 var Allbranchid = [];

function addeditpackagelist2(packdtl_branch,facility_id,facility_name,qty,type,work_out,sub_group,rowno,method){
    
   
    if(Allbranchid.indexOf(packdtl_branch) == -1) {       
        Allbranchid.push(packdtl_branch);
        var newtrtb = 'Table';
        var srlNo = 0;
    }else{           
        var newtrtb = 'Row';
        var srlNo = parseInt($('#srl_no_'+packdtl_branch).val())+parseInt(1);
        // var srl = parseInt($('#edit_srl').val());
        // //alert('get-'+srl);
        // var srlNo = parseInt(srl) + 1;
       
      
    }
    //alert(newtrtb);
   // alert($('#edit_srl').val());
    if(1){
       
        var formData = {newtrtb:newtrtb,srlNo:srlNo,rowno:rowno,packdtl_branch:packdtl_branch,facility_id:facility_id,facility_name:facility_name,qty:qty,type:type,work_out:work_out,sub_group:sub_group};
       // var method = method;
      
        $.ajax({
            type: "POST",
            url: method,
            dataType: "html",
            data: formData,
            success: function(data) {
                $("#dtl_rowno").val(rowno);
               
                $('#edit_srl').val(srlNo);
                if(newtrtb == 'Table'){
                $("#package_dtl").show();
                $("#package_dtl").append(data);
               
                 $('#srl_no_'+packdtl_branch).val(srlNo);
            
                }else{                
                    $('#table_'+packdtl_branch).show();
                    $('#table_'+packdtl_branch+' tbody').append(data);                   
                     $('#srl_no_'+packdtl_branch).val(srlNo);
                }
                
            },

        });
        //var data =  htmlshowajaxcomtroller(method,formData); 
        
    }

}

function validatecard(){
    var branch = $("#branch").val();
    var package_rate = $("#package_rate").val();
    var renewal_rate = $("#renewal_rate").val();    
  
    $("#rateerrormsg").text("");
    if(branch == ""){
           $("#rateerrormsg").text("Error : Select branch");
           $("#branch").focus();
           return false();
    }
    else if(package_rate == ""){
         $("#rateerrormsg").text("Error : Enter package rate");
         $("#package_rate").focus();
         return false();
    } else if(renewal_rate == ""){
        $("#rateerrormsg").text("Error : Enter renewal rate");
        $("#renewal_rate").focus();
        return false();
   } 
   return true;
 }

 function checkcarcode(){
    var card_prefix = $("#card_prefix").val();  
    var card_code = $("#card_code").val();  
    
    var formData = {card_code:card_code,card_prefix:card_prefix};
    var method = 'packagecardcreation/checkcarcode';
    var data =  ajaxcallcontrollerforcutom(method,formData);
    if(data.msg_status == 1){ 
        return 1;
    }else{
        return 0;
    }


}

function validatedata(){
        var packdtl_branch = $("#packdtl_branch").val();
        var facility_id = $("#facility").val();      
        var qty = $("#qty").val();
        var type = $("#type").val();
       
  
    $("#packageerrormsg").text("");
    if(packdtl_branch == ""){
           $("#packageerrormsg").text("Error : Select branch");
           $("#packdtl_branch").focus();
           return false();
    }
    else if(facility_id == ""){
         $("#packageerrormsg").text("Error : Select Facility");
         $("#facility_id").focus();
         return false();
    } else if(qty == ""){
        $("#packageerrormsg").text("Error : Enter Qty");
        $("#qty").focus();
        return false();
   } else if(type == ""){
       $("#packageerrormsg").text("Error : Select Type");
       $("#type").focus();
       return false();
    } 
   return true;
 }


 function validateform(){
    var package_cat = $("#package_cat").val();
    var package_type = $("#package_type").val();      
    var card_code = $("#card_code").val();
    var package_desc = $("#package_desc").val();   
    var achivement_type = $("#achivement_type").val();
    var active_days = $("#active_days").val();
    var application_limit_days = $("#application_limit_days").val();

    $('#package_cat_err,#package_type_err,#package_desc,#card_code').css('border','unset');  
    $('#package_desc,#card_code').css('border','1px solid #ced4da');  
   $("#errormsg").text("");
if(package_cat == ""){
       $("#errormsg").text("Error : Select package category");
       $('#package_cat_err').css('border','1px solid red');
       $("#package_cat").focus();
       return false();
}
else if(package_type == ""){
     $("#errormsg").text("Error : Select package type");
     $('#package_type_err').css('border','1px solid red');
     $("#package_type").focus();
     return false();
} else if(card_code == ""){
    $("#errormsg").text("Error : Enter code");
    $('#card_code').css('border','1px solid red');
    $("#card_code").focus();
    return false();
} else if(package_desc == ""){
   $("#errormsg").text("Error : Enter package description");
   $('#package_desc').css('border','1px solid red');
   $("#package_desc").focus();
   return false();
}
else if(achivement_type == ""){
    $("#errormsg").text("Error : Enter achievemen type");
    $('#achivement_type_err').css('border','1px solid red');
    $("#achivement_type").focus();
    return false();
 } 
 else if(active_days == ""){
    $("#errormsg").text("Error : Enter active days");
    $('#active_days').css('border','1px solid red');
    $("#active_days").focus();
    return false();
 } 
 else if(application_limit_days == ""){
    $("#errormsg").text("Error : Enter days limit for application(Extension)");
    $('#application_limit_days').css('border','1px solid red');
    $("#application_limit_days").focus();
    return false();
 } 
return true;
}