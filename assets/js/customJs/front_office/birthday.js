$(document).ready(function(){

    basepath = $("#basepath").val();
    getBirthdayList();
   
    $(document).on('click', '#viewbtn', function() {
        // var from_dt = $("#from_dt").val();
        // var to_date = $("#to_date").val();
        getBirthdayList();
        
    })
 });


 function getBirthdayList(){

    var branch = $("#branch").val();
       
       
    if(1){
    $("#birthday_wish_list").html('');
    $("#loader").css('display','block');
    var formData = {branch:branch};
    var method = 'birthdaywish/getBirthdayList';
    var data =  htmlshowajaxcomtroller(method,formData); 
    $("#loader").css('display','none');  
    $("#birthday_wish_list").html(data);
    $('.dataTable').DataTable();
    }

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