$(document).ready(function () {
  basepath = $("#basepath").val();

  $("#corporatecompanylist").DataTable();

  $(document).on("click", ".mappingstatus", function () {
    var uid = $(this).data("mappingid");
    var status = $(this).data("setstatus");
    var url = basepath + "accountmapping/setStatus";
    setActiveStatus(uid, status, url);
  });

  $(document).on("click", "#acmappingsavebtn", function (event) {
    event.preventDefault();

    if (valiadateform()) {
      var sel_branch = $("#sel_branch").val();
      var sel_payment_mode = $("#sel_payment_mode").val();
      var sel_account = $("#sel_account").val();

      var mode = $("#mode").val();
      var accountmappingId = $("#accountmappingId").val();
      $("#loaderbtn").show();
      $("#acmappingsavebtn").hide();
      var formData = {
        sel_branch: sel_branch,
        sel_payment_mode: sel_payment_mode,
        sel_account: sel_account,
        mode: mode,
        accountmappingId: accountmappingId,
      };
      // console.log(formData);
      var method = "accountmapping/mapping_action";
      var result = ajaxcallcontrollerforcutom(method, formData);

      if (result.msg_status == "1") {
        $("#loaderbtn").hide();
        $("#acmappingsavebtn").show();
        window.location.href = basepath + "accountmapping";
      } else {
      }
    }
  });

  $(document).on("change", "#sel_branch,#sel_payment_mode", function (e) {
    e.preventDefault();
    var sel_branch = $("#sel_branch").val();
    var sel_payment_mode = $("#sel_payment_mode").val();
    var mode = $("#mode").val();
    var accountmappingId = $("#accountmappingId").val();

    if (sel_branch == "0") {
      return false;
    }

    if (sel_payment_mode == "0") {
      return false;
    }
    var formData = {
      sel_branch: sel_branch,
      sel_payment_mode: sel_payment_mode,
      mode: mode,
      accountmappingId: accountmappingId,
    };
    var method = "accountmapping/checkAccountMapping";
    var result = ajaxcallcontrollerforcutom(method, formData);
    if (result.msg_status == "0") {
      $("#mapping_err").text(result.msg_data);
      $("#acmappingsavebtn").hide();
    } else {
      $("#mapping_err").text("");
      $("#acmappingsavebtn").show();
    }
  });
}); /* end of document ready */

function valiadateform() {
  var sel_branch = $("#sel_branch").val();
  var sel_payment_mode = $("#sel_payment_mode").val();
  var sel_account = $("#sel_account").val();

  $("#errormsg").text("");
  $("#sel_branch_err,#sel_payment_mode_err,#sel_account_err").removeClass(
    "form_error"
  );

  if (sel_branch == "0") {
    $("#sel_branch_err").addClass("form_error");
    return false;
  }

  if (sel_payment_mode == "0") {
    $("#sel_payment_mode_err").addClass("form_error");
    return false;
  }

  if (sel_account == "0") {
    $("#sel_account_err").addClass("form_error");
    return false;
  }

  return true;
}
