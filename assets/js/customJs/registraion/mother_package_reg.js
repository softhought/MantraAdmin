$(document).ready(function(){
    var basepath = $("#basepath").val();

    $(document).on("click","#showlistbtn",function(){
      
        getmotherpackagereglist();
    });

    
})


function getmotherpackagereglist(){
   
    var from_dt = $("#from_dt").val();
    var to_date = $("#to_date").val();   
    var branch = $("#branch").val();
    var status = $("#status").val(); 
    var search_by = $("#search_by").val();
    var package = $("#package").val();
    var trainer = $("#trainer").val();
    var doneby = $("#doneby").val();
    var close_by = $("#close_by").val();
   
    $("#motherpackage_reg_list").html(''); 
    $("#loader").css('display','block');
    var formData = {from_dt:from_dt,to_date:to_date,branch:branch,status:status,search_by:search_by,package:package,trainer:trainer,doneby:doneby,close_by:close_by};
    var method = 'motherpackage/getmotherpackagereglist';
    var data =  htmlshowajaxcomtroller(method,formData);
     $("#loader").css('display','none');
     $("#motherpackage_reg_list").html(data);
     $('.dataTable2').DataTable({
      "scrollX": true
   })
  }