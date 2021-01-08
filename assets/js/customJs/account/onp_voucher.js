$(document).ready(function () {
    basepath = $("#basepath").val();

    $(document).on("click", "#onptovoucherhowbtn", function (event) {
        event.preventDefault();
    
    //    var from_dt = $("#from_dt").val();
    //    var to_date = $("#to_date").val();
       var branch = $("#branch").val(); 
        $("#onpvoucher_list").html("");    
        $("#loader").css('display','block');
      
        var method = "onptovoucher/getOnlinePaymentListByBranch";
        formData = {branch:branch}
        var result = htmlshowajaxcomtroller(method, formData);
        $("#loader").css('display','none');      
       
        $("#onpvoucher_list").html(result); 
        $('.dataTable').DataTable();   
       
      });

// $("#onptovoucherhowbtn").trigger('click');

$(document).on('click','.postonlinepaymentvoucher',function(){

           var membership = $(this).data('membership');
			var paymentid = $(this).data('paymentid');
            var branchid = $(this).data('branchid');
            var payment_mode="ONP";
            var valsl=  $(this).data('valsl');
            $("#postinfo_"+valsl).css("display","none");
            $("#process-loader_"+valsl).css("display","block");

            var formData = {membership:membership,paymentid:paymentid,branchid:branchid,payment_mode:payment_mode};
            var method = 'onptovoucher/postonpvoucher';
            var data =  ajaxcallcontrollerforcutom(method,formData);

            if (data.msg_status == 1) {
                $("#postinfo_"+valsl).css("display","none");
                $("#process-loader_"+valsl).css("display","none");
                $("#afterpostvoucher_"+valsl).css("display","block");
                $("#voucher_no_a_"+valsl).text(data.voucher_no_a);
                $("#voucher_no_b_"+valsl).text(data.voucher_no_b);
            }
});

});