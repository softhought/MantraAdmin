$(document).ready(function(){
    var basepath = $("#basepath").val();

    $(document).on("click","#reportviewbtn",function(){
       
        getenquiryreportlist();
    });

    
})


function getenquiryreportlist(){
   
    var from_dt = $("#from_dt").val();
    var to_date = $("#to_date").val();
    var gender = $("#gender").val(); 
    var branch = $("#branch").val();
    var from_dob = $("#from_dob").val();
    var to_dob = $("#to_dob").val();
     if(validatedata()){
    $("#enquiry_analysis_list").html(''); 
    $("#loader").css('display','block');

    var formData = {branch:branch,gender:gender,from_dt:from_dt,to_date:to_date,from_dob:from_dob,to_dob:to_dob};
    var method = 'enquiryreport/getenquiryreportlist';
    var data =  htmlshowajaxcomtroller(method,formData);
     $("#loader").css('display','none');
     $("#enquiry_list").html(data);
     $('.dataTable2').DataTable({
      "scrollX": true
   })
}
  }

  function validatedata(){
    var from_dt = $("#from_dt").val();
    var to_date = $("#to_date").val();

    if(from_dt == ''){
        $("#errormsg").text('Error : Select from date');
        $("#from_dt").focus();
        return false;
    }
   else if(to_date == ''){
        $("#errormsg").text('Error : Select to date');
        $("#to_date").focus();
        return false;
    }
return true;


  }