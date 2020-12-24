$(document).ready(function () {
  basepath = $("#basepath").val();

  $("#corporatecompanylist").DataTable();

  $(document).on("click", ".corpcomptatus", function () {
    var uid = $(this).data("corcompid");
    var status = $(this).data("setstatus");
    var url = basepath + "corporatecompany/setStatus";
    setActiveStatus(uid, status, url);
  });

  $(document).on("change", "#sel_grp_cat1", function (event) {
    event.preventDefault();

    var sel_grp_cat1 = $("#sel_grp_cat1").val();
    var formData = {
      cat1: sel_grp_cat1,
    };
    var method = "accountgroup/getSecondCategory";
    var result = ajaxcallcontrollerHtml(method, formData);
    console.log(result);
    $("#second_cat_drp").html(result);

    $(".select2").select2();
  });

  $(document).on("click", "#companysavebtn", function (event) {
    event.preventDefault();

    if (valiadateform()) {
      var company_name = $("#company_name").val();
      var gistn_no = $("#gistn_no").val();
      var address = $("#address").val();

      var mode = $("#mode").val();
      var corporateCompanyId = $("#corporateCompanyId").val();
      $("#loaderbtn").show();
      $("#companysavebtn").hide();
      var formData = {
        company_name: company_name,
        gistn_no: gistn_no,
        address: address,

        mode: mode,
        corporateCompanyId: corporateCompanyId,
      };
      // console.log(formData);
      var method = "corporatecompany/company_action";
      var result = ajaxcallcontrollerforcutom(method, formData);

      if (result.msg_status == "1") {
        $("#loaderbtn").hide();
        $("#companysavebtn").show();
        window.location.href = basepath + "corporatecompany";
      } else {
      }
    }
  });

  $(document).on("keyup", "#company_name", function (e) {
    e.preventDefault();
    var company_name = $("#company_name").val();
    var mode = $("#mode").val();
    var corporateCompanyId = $("#corporateCompanyId").val();
    var formData = {
      company_name: company_name,
      mode: mode,
      corporateCompanyId: corporateCompanyId,
    };
    var method = "corporatecompany/checkAccountName";
    var result = ajaxcallcontrollerforcutom(method, formData);
    if (result.msg_status == "0") {
      $("#company_name_err").text(result.msg_data);
      $("#companysavebtn").hide();
    } else {
      $("#company_name_err").text("");
      $("#companysavebtn").show();
    }
  });
}); /* end of document ready */

function valiadateform() {
  var company_name = $("#company_name").val();
  var gistn_no = $("#gistn_no").val();
  var address = $("#address").val();

  $("#errormsg").text("");
  $("#company_name,#gistn_no,#address").removeClass("form_error");

  if (company_name == "") {
    $("#company_name").addClass("form_error");
    return false;
  }

  if (gistn_no == "") {
    $("#gistn_no").addClass("form_error");
    return false;
  }

  if (address == "") {
    $("#address").addClass("form_error");
    return false;
  }

  return true;
}
