$(document).ready(function(){
    basepath = $("#basepath").val();

    getAllFreeGuestpass();

    $("#listshowbtn").on('click',function(){
        getAllFreeGuestpass();
    })


});

function getAllFreeGuestpass(){
    var from_dt = $("#from_dt").val();
    var to_date = $("#to_date").val();
    var branch = $("#branch").val();  
   
    // if(Validitywithform()){
    $("#freeguestpass_list").html('');
    $("#loader").css('display','block');
    var formData = {from_dt:from_dt,to_date:to_date,branch:branch};
    var method = 'enquiry/getAllFreeGuestpass';
    var data =  htmlshowajaxcomtroller(method,formData); 
    $("#loader").css('display','none');  
    $("#freeguestpass_list").html(data);
    $('.dataTable2').DataTable();
    // }
}

function Validitywithform(){
    var from_dt = $("#from_dt").val();
    var to_date = $("#to_date").val();
    var branch = $("#branch").val();
    
    $("#errormsg").text('');
    if(from_dt == ""){
        $("#errormsg").text('Error : Select from date');
        return false;
    }else if(to_date == ""){
        $("#errormsg").text('Error : Select to date');
        return false;
    }
    return true;
}