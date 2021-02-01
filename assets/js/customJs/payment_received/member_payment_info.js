$(document).ready(function () {
  basepath = $("#basepath").val();

  $("#paymentDtlBtn").click(function () {
    var mobile_no = $("#mobile_no").val();

    $("#response_message").html("");

    if (ValiditeNumber()) {
      $("#member_payment_list").html("");
      $("#loader").css("display", "block");
      var formData = {
        mobile_no: mobile_no,
      };
      var method = "memberpayment/getMemberPaymentList";
      var data = htmlshowajaxcomtroller(method, formData);
      $("#loader").css("display", "none");
      $("#member_payment_list").html(data);
    }
  });

  $('[data-toggle="tooltip"]').tooltip();

  $(document).on("click", ".payment_DetailsBtn", function (e) {
    e.preventDefault();
    var membershipno = $(this).data("membershipno");
    var validity = $(this).data("validity");
    var paymentfrom = $(this).data("paymentfrom");
    var actualvalidity = $(this).data("actualvalidity");
    var paymentid = $(this).data("paymentid");
    $("#payment_details_data").html("");

    $.ajax({
      type: "POST",
      url: basepath + "memberpayment/getPaymentDetailsList",
      dataType: "html",
      data: {
        membershipno: membershipno,
        validity: validity,
        paymentfrom: paymentfrom,
        actualvalidity: actualvalidity,
        paymentid: paymentid,
      },
      success: function (result) {
        $("#paymentDetails").modal({ backdrop: false });
        $("#payment_details_data").html(result);

        $(".select2").select2();

        // $(".dataTable").DataTable();
      },

      error: function (jqXHR, exception) {
        var msg = "";
        if (jqXHR.status === 0) {
          msg = "Not connect.\n Verify Network.";
        } else if (jqXHR.status == 404) {
          msg = "Requested page not found. [404]";
        } else if (jqXHR.status == 500) {
          msg = "Internal Server Error [500].";
        } else if (exception === "parsererror") {
          msg = "Requested JSON parse failed.";
        } else if (exception === "timeout") {
          msg = "Time out error.";
        } else if (exception === "abort") {
          msg = "Ajax request aborted.";
        } else {
          msg = "Uncaught Error.\n" + jqXHR.responseText;
        }

        // alert(msg);
      },
    }); /*end ajax call*/
  });
}); /* end of document ready */

function ValiditeNumber() {
  var mobile_no = $("#mobile_no").val();

  if (mobile_no == "") {
    $("#mobile_no").addClass("form_error");
    return false;
  }

  if (mobile_no.length != 10) {
    $("#mobile_no").addClass("form_error");
    return false;
  }

  return true;
}

function numericFilter(txb) {
  txb.value = txb.value.replace(/[^\0-9]/gi, "");
}
