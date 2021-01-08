$(document).ready(function () {
    basepath = $("#basepath").val();

    $(document).on("click", "#dailycollectionviewbtn", function (event) {
        event.preventDefault();
    
       var from_dt = $("#from_dt").val();
       var to_date = $("#to_date").val();
       var branch = $("#branch").val(); 
       var cash_account_id = $("#cash_account_id").val(); 
        $("#daily_collection_list").html("");    
        $("#loader").css('display','block');
        // var host = window.location.href;
        // var where_from = host.substring(host.lastIndexOf('/') + 1);  
      
        var method = "dailycollection/getAlldailycollection";
        formData = {from_dt:from_dt,to_date:to_date,branch:branch,cash_account_id:cash_account_id};
        var result = htmlshowajaxcomtroller(method, formData);
        $("#loader").css('display','none');      
       
        $("#daily_collection_list").html(result); 
        $('.dataTable').DataTable();   
       
      });

      $(document).on("click", ".dispdailycoll", function (event) {
        event.preventDefault();
        event.stopPropagation();
        var from_dt = $(this).attr('data-collectiondt'); 
        var to_date = $(this).attr('data-collectiondt'); 
        var branch = $("#branch").val(); 
        var payment_mode = $(this).attr('data-paymentmode'); 
        var cash_account_id = $("#cash_account_id").val();
        $("#dailycollModalBody").html(""); 
        $("#modalloader").css('display','block');   
        formData = {from_dt:from_dt,to_date:to_date,branch:branch,cash_account_id:cash_account_id,payment_mode:payment_mode};
        var method = 'dailycollection/getdailycollectiondtl';
         var data =  htmlshowajaxcomtroller(method,formData);        
        $('#dailycollectionlistmodel').modal('show');
        $("#modalloader").css('display','none');
        $("#dailycollModalBody").html(data); 
       
        
    });

    });