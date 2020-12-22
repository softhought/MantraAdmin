$(document).ready(function(){

    basepath = $("#basepath").val();

    $(document).on('change', '#branch', function(){
     
        var branch = $("#branch").val();
        var formData = {branch:branch};
        var method = 'employeeattendance/getTrainerByBranch';
        var data =  ajaxcallcontrollerforcutom(method,formData); 
        $("#employee").html(data.trainerlistview);

    });

    $(document).on('click', '#registershowbtn', function() {
        var from_dt = $("#from_dt").val();
        var to_date = $("#to_date").val();
        var branch = $("#branch").val();
        var employee = $("#employee").val();
      
       
        if(Validityform()){
        $("#employee_attendance_list").html('');
        $("#loader").css('display','block');
        var formData = {from_dt:from_dt,to_date:to_date,branch:branch,employee:employee};
        var method = 'employeeattendance/getattendencelist';
        var data =  htmlshowajaxcomtroller(method,formData); 
        $("#loader").css('display','none');  
        $("#employee_attendance_list").html(data);
        $('.dataTable').DataTable();
        }
        
    })


});

function Validityform(){
    var from_dt = $("#from_dt").val();
    var to_date = $("#to_date").val();
    var branch = $("#branch").val();
  
    $("#errormsg").text('');
    if(from_dt == "" || to_date == ""){
        $("#errormsg").text('Error : Select from date and to date');
        return false;
    }
    return true;
}