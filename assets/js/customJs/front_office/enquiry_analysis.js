$(document).ready(function(){
    var basepath = $("#basepath").val();

    $(document).on("click","#analysisviewbtn",function(){
       
        getenquiryanalysis();
    });

    
})


function getenquiryanalysis(){
    var search_by = $("#search_by").val(); 
    var from_dt = $("#from_dt").val();
    var to_date = $("#to_date").val();
    var branch = $("#branch").val();
    var wing = $("#wing").val();
    var caller = $("#caller").val();
   
    $("#enquiry_analysis_list").html(''); 
    $("#loader").css('display','block');
    var formData = {search_by:search_by,from_dt:from_dt,to_date:to_date,branch:branch,wing:wing,caller:caller};
    var method = 'enquiry/getenquiryanalysis';
    var data =  htmlshowajaxcomtroller(method,formData);
     $("#loader").css('display','none');
     $("#enquiry_analysis_list").html(data);
     $('.dataTable2').DataTable({
      "scrollX": true
   })
  }