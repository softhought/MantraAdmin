$(document).ready(function(){

    var basepath = $("#basepath").val();

$(document).on("keyup","#registration_no",function(){
    var  registration_no = $("#registration_no").val();
    //$("#companydrp").html('');
    $.ajax({
        type: "POST",
        url: basepath+"admin/getcompanydtl",
        data: { registration_no: registration_no},
        dataType: 'json',
        contentType: "application/x-www-form-urlencoded; charset=UTF-8",
        success: function(result) {
            if (result.msg_status = 1) {
                $("#company").html(result.companylist);
                $("#branch").html(result.brnachlist);
                //$("#custom-select").select();
            }
        },
        error: function(jqXHR, exception) {
            var msg = '';
            if (jqXHR.status === 0) {
                msg = 'Not connect.\n Verify Network.';
            } else if (jqXHR.status == 404) {
                msg = 'Requested page not found. [404]';
            } else if (jqXHR.status == 500) {
                msg = 'Internal Server Error [500].';
            } else if (exception === 'parsererror') {
                msg = 'Requested JSON parse failed.';
            } else if (exception === 'timeout') {
                msg = 'Time out error.';
            } else if (exception === 'abort') {
                msg = 'Ajax request aborted.';
            } else {
                msg = 'Uncaught Error.\n' + jqXHR.responseText;
            }

            //alert(msg);

        }

    });
  })
})