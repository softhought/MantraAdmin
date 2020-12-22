$(document).ready(function(){

    basepath = $("#basepath").val();

   
    $(document).on('keyup change', '#mobile_no', function() {
        //$("#branch").val("").change();
        $("#branch option:selected" ).text('Select');
        $("#package").html('<option value="">Select</option>');
        $("#errormsg").text('');
        var mobile_no = $(this).val();      
        if(mobile_no.length == 10){
       var formData = {mobile_no:mobile_no};
       var method = 'memberattendance/getmembershipdtl';
       var data =  ajaxcallcontrollerforcutom(method,formData);
         if(data.msg_status == 1){
          $("#package").html(data.listview);
         }else{
           $("#errormsg").text('Error : Member has no active package')
         }
        }
 });

  $(document).on('change', '#branch', function(){
      
        $("#mobile_no").val("");
         //$("#package").val('').change();
        $("#package").html('<option value="">Select</option>');       

    });

 $(document).on('click', '#registershowbtn', function() {
    var from_dt = $("#from_dt").val();
    var to_date = $("#to_date").val();
    var branch = $("#branch").val();
    var mobile_no = $("#mobile_no").val();
    var package = $("#package").val(); 
   
    if(Validityform()){
    $("#attendance_list").html('');
    $("#loader").css('display','block');
    var formData = {from_dt:from_dt,to_date:to_date,branch:branch,mobile_no:mobile_no,package:package};
    var method = 'memberattendance/getattendencelist';
    var data =  htmlshowajaxcomtroller(method,formData); 
    $("#loader").css('display','none');  
    $("#attendance_list").html(data);
    $('.dataTable').DataTable();
    }
    
})

//Start Attendence Register With Time

$(document).on('click', '#registerwithshowbtn', function() {
    var from_dt = $("#from_dt").val();
    var to_date = $("#to_date").val();
    var branch = $("#branch").val();  
   
    if(Validitywithform()){
    $("#attendance_withtime_list").html('');
    $("#loader").css('display','block');
    var formData = {from_dt:from_dt,to_date:to_date,branch:branch};
    var method = 'memberattendance/getattendencetimelist';
    var data =  htmlshowajaxcomtroller(method,formData); 
    $("#loader").css('display','none');  
    $("#attendance_withtime_list").html(data);
    $('.dataTable').DataTable();
    }
    
})

//End Attendence Register With Time


//Start Attendence Ranking

$(document).on('click', '#registerrankingshowbtn', function() {
    var from_dt = $("#from_dt").val();
    var to_date = $("#to_date").val();
    var branch = $("#branch").val();
    var mobile_no = $("#mobile_no").val();
    var package = $("#package").val(); 
   
    if(Validityform()){
    $("#attendance_ranking_list").html('');
    $("#loader").css('display','block');
    var formData = {from_dt:from_dt,to_date:to_date,branch:branch,mobile_no:mobile_no,package:package};
    var method = 'memberattendance/getattendencerankinglist';
    var data =  htmlshowajaxcomtroller(method,formData); 
    $("#loader").css('display','none');  
    $("#attendance_ranking_list").html(data);
    $('.dataTable').DataTable();
    }
    
})

//End Attendence Ranking


});

function Validityform(){
    var from_dt = $("#from_dt").val();
    var to_date = $("#to_date").val();
    var branch = $("#branch").val();
    var mobile_no = $("#mobile_no").val();
    var package = $("#package").val(); 
    $("#errormsg").text('');
    if(mobile_no == "" && from_dt == "" && to_date == ""){
        $("#errormsg").text('Error : Select from date and to date');
        return false;
    }else if(mobile_no == "" && from_dt == "" && to_date == "" && branch != ""){
        $("#errormsg").text('Error : Select from date and to date');
        return false;
    }else if(mobile_no != "" && package == ""){
        $("#errormsg").text('Error : Select package');
        return false;
    }
    return true;
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
    }else if(branch == ""){
        $("#errormsg").text('Error : Select branch');
        return false;
    }
    return true;
}