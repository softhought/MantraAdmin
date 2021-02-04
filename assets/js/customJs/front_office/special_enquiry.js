$(document).ready(function () {
  basepath = $("#basepath").val();

  $(".old_mem_div").hide();

  $(document).on("change", "#search_type", function () {
    search_type = $("#search_type").val();

    $("#specialenquiry_list").html("");
    $("#note_text").html("-------------------------------------------------");

    if (search_type == "ENQUIRED PERSON" || search_type == "") {
      $(".old_mem_div").hide();
      $(".enquired_div").show();
      $("#note_text").html(
        "<strong>Note: </strong>List of person those who enquired but not converted as member."
      );
    }
    if (search_type == "OLD MEMBER") {
      $(".old_mem_div").show();
      $(".enquired_div").hide();
      $("#note_text").html(
        "<strong>Note: </strong>List of members whose expiry lies in between from date & To date and no package is active as on date."
      );
    }
    if (search_type == "EXISTING MEMBER") {
      $(".old_mem_div").show();
      $(".enquired_div").hide();
      $("#note_text").html(
        "<strong>Note: </strong>List of members whose validity is currently active but will expire within the date range specified."
      );
    }
  });

  $(document).on("change", "#sel_category", function () {
    var sel_category = $("#sel_category").val();
    var formData = {
      sel_category: sel_category,
    };
    var method = "enquiry/getCardList";
    var data = htmlshowajaxcomtroller(method, formData);
    $("#package_drp").html(data);
    $("#sel_card").select2();
  });

  $("#specialenquiryshowbtn").click(function () {
    var from_dt = $("#from_dt").val();
    var to_date = $("#to_date").val();
    var branch = $("#branch").val();
    var wing = $("#wing").val();
    var search_type = $("#search_type").val();

    var sel_month = $("#sel_month").val();
    var sel_category = $("#sel_category").val();
    var sel_card = $("#sel_card").val();

    $("#response_message").html("");

    if (Validitywithform()) {
      $("#specialenquiry_list").html("");
      $("#loader").css("display", "block");
      var formData = {
        from_dt: from_dt,
        to_date: to_date,
        branch: branch,
        search_type: search_type,
        sel_month: sel_month,
        sel_category: sel_category,
        sel_card: sel_card,
      };
      var method = "enquiry/getspecialenquiry";
      var data = htmlshowajaxcomtroller(method, formData);
      $("#loader").css("display", "none");
      $("#specialenquiry_list").html(data);
      $("#specialEnqTable").DataTable({ scrollX: true });
      /* $(".dataTable").DataTable({
        paging: false,
        scrollX: true,
        ordering: false,

        info: false,
        drawCallback: function (settings) {
          var flag = 0;

          var checkbox = $("input:checkbox.rowCheck:checked").length;
          $("#heads").val(checkbox);
          $(".rowCheck").each(function () {
            if ($(this).is(":checked")) {
              console.log("checkedsingle");
              flag = 1;
            }
          });
          if (flag) {
            $("#specialenquiryapplybtn").show();
          } else {
            $("#specialenquiryapplybtn").hide();
          }
        },
      });*/
      $(".select2").select2();
    }
  });

  /*-------------------------------------------------------- */
  // Handle click on "Select all" control

  $(document).on("click", "#example-select-all", function () {
    // Check/uncheck all checkboxes in the table
    var table = $("#specialEnqTable").DataTable();
    var rows = table.rows({ search: "applied" }).nodes();
    $('input[type="checkbox"]', rows).prop("checked", this.checked);
  });

  // Handle click on checkbox to set state of "Select all" control
  $(document).on("change", 'input[type="checkbox"]', function () {
    // If checkbox is not checked
    if (!this.checked) {
      var el = $("#example-select-all").get(0);
      // If "Select all" control is checked and has 'indeterminate' property
      if (el && el.checked && "indeterminate" in el) {
        // Set visual state of "Select all" control
        // as 'indeterminate'
        el.indeterminate = true;
      }
    }
  });

  $(document).on("click", "#specialenquiryapplybtn", function () {
    var data = [];
    var oTable = $("#specialEnqTable").dataTable();
    var rowcollection = oTable.$(".call-checkbox:checked", { page: "all" });

    rowcollection.each(function (index, elem) {
      data.push($(elem).val());
    });

    console.log(data);
    var send_type = $("#send_type").val();
    var sel_sms = $("#sel_sms").val();
    var sel_email = $("#sel_email").val();
    var sel_sms = $("#sel_sms").val();
    var matter_data = $("#matter_data").val();
    var applytype = $("#applytype").val();
    var formData = {
      enqids: data,
      send_type: send_type,
      sel_sms: sel_sms,
      sel_email: sel_email,
      matter_data: matter_data,
      applytype: applytype,
    };
    if (ValidateApplyNotification()) {
      var method = "enquiry/applyEnquiryNotification";
      var jsondata = ajaxcallcontrollerforcutom(method, formData);

      if (jsondata.msg_status == 1) {
        $("#response_message").html(jsondata.msg_data);
        $("#specialenquiry_list").html("");
      }
    }
  });

  $(document).on("change", ".rowCheckAll,.rowCheck", function () {
    var flag = 0;

    var table = $("#specialEnqTable").dataTable();

    table.$(".rowCheck").each(function () {
      // If checkbox doesn't exist in DOM
      console.log(this);

      // If checkbox is checked

      if (this.checked) {
        flag += 1;
      }
    });
    $("#heads").val(flag);
    if (flag) {
      $("#specialenquiryapplybtn").show();
    } else {
      $("#specialenquiryapplybtn").hide();
    }
  });

  /*-------------------------------------------------------- */

  $(document).on("click", ".addFeedback", function () {
    var startDate = new Date($("#acstartDate").val());
    var endDate = new Date($("#acendDate").val());
    var enq_id = $(this).attr("data-id");
    var formData = { enq_id: enq_id };
    var method = "enquiry/getenqmasterforfeedback";
    var data = ajaxcallcontrollerforcutom(method, formData);
    $("#enquiry_id").val(enq_id);
    $("#fname").val(data.enquirymstdata["FIRST_NAME"]);
    $("#lname").val(data.enquirymstdata["LAST_NAME"]);
    $("#pincode").val(data.enquirymstdata["PIN"]);
    $("#location").val(data.enquirymstdata["LOCATION"]);
    $("#address").val(data.enquirymstdata["ADDRESS"]);
    $("#email").val(data.enquirymstdata["EMAIL"]);
    $("#mobile1").val(data.enquirymstdata["MOBILE1"]);
    $("#mobile2").val(data.enquirymstdata["MOBILE2"]);
    $("#txtwing").val(data.enquirymstdata["for_the_wing"]);
    $("#feedbck_branch").val(data.enquirymstdata["BRANCH_CODE"]);
    $("#sel_remarks").html(data.remarkslist);
    $("#done_by").html(data.userlistview);
    $("#feedbackmodel").modal("show");
    $(".datepicker").datepicker({
      format: "dd-mm-yyyy",
      startDate: startDate,
      endDate: endDate,
      autoclose: true,
      todayHighlight: true,
    });
    $(".select2").select2();
  });

  $(document).on("click", ".feedbackList", function () {
    var enq_id = $(this).attr("data-id");
    var formData = { enq_id: enq_id };
    var method = "enquiry/getfeedbacklist";
    var data = htmlshowajaxcomtroller(method, formData);
    $("#feedbackModalBody").html(data);
    $("#feedbacklistmodel").modal("show");
  });

  $(document).on("click", ".smsList", function () {
    var enq_id = $(this).attr("data-id");
    var formData = { enq_id: enq_id };
    var method = "enquiry/getSmslist";
    var data = htmlshowajaxcomtroller(method, formData);
    $("#smsModalBody").html(data);
    $("#smslistmodel").modal("show");
  });

  $(document).on("click", ".emailList", function () {
    var enq_id = $(this).attr("data-id");
    var formData = { enq_id: enq_id };
    var method = "enquiry/getEmailList";
    var data = htmlshowajaxcomtroller(method, formData);
    $("#emailModalBody").html(data);
    $("#emaillistmodel").modal("show");
  });

  $(document).on("click", ".smsListOldmem", function () {
    var cus_id = $(this).attr("data-id");
    var formData = { cus_id: cus_id };
    var method = "enquiry/getSmslistOldMem";
    var data = htmlshowajaxcomtroller(method, formData);
    $("#smsModalBody").html(data);
    $("#smslistmodel").modal("show");
  });

  $(document).on("click", ".emailListExistingmem", function () {
    var cus_id = $(this).attr("data-id");
    var formData = { cus_id: cus_id };
    var method = "enquiry/getEmailListExistingMem";
    var data = htmlshowajaxcomtroller(method, formData);
    $("#emailModalBody").html(data);
    $("#emaillistmodel").modal("show");
  });

  $(document).on("click", ".smsListExtmem", function () {
    var cus_id = $(this).attr("data-id");
    var formData = { cus_id: cus_id };
    var method = "enquiry/getSmslistExtMem";
    var data = htmlshowajaxcomtroller(method, formData);
    $("#smsModalBody").html(data);
    $("#smslistmodel").modal("show");
  });

  $(document).on("click", ".emailListExtmem", function () {
    var cus_id = $(this).attr("data-id");
    var formData = { cus_id: cus_id };
    var method = "enquiry/getEmailListOldMem";
    var data = htmlshowajaxcomtroller(method, formData);
    $("#emailModalBody").html(data);
    $("#emaillistmodel").modal("show");
  });

  $(document).on("change", "#send_type", function () {
    send_type = $("#send_type").val();
    $("#matter_data").val("");
    $("#matter_box").hide();
    if (send_type == "sms") {
      $("#sms_drp_div").show();
      $("#email_drp_div").hide();
    } else {
      $("#sms_drp_div").hide();
      $("#email_drp_div").show();
    }
  });

  $(document).on("change", "#sel_sms", function () {
    $("#matter_box").show();
    var selectedCode = $("#sel_sms").find("option:selected");
    var matter = selectedCode.data("smsmatter");
    $("#matter_title").html("SMS Text:");
    $("#matter_text").html(matter);
    $("#matter_data").val(matter);
  });

  $(document).on("change", "#sel_email", function () {
    $("#matter_box").show();
    var selectedCode = $("#sel_email").find("option:selected");
    var matter = selectedCode.data("emailmatter");
    $("#matter_title").html("Email Text:");
    $("#matter_text").html(matter);
    $("#matter_data").val(matter);
  });
}); /* end of document ready  */

function Validitywithform() {
  var search_type = $("#search_type").val();

  $("#errormsg").text("");
  if (search_type == "") {
    $("#errormsg").text("Error : Select Type");
    return false;
  }

  var from_dt = $("#from_dt").val();
  var to_date = $("#to_date").val();
  if (from_dt == "") {
    $("#errormsg").text("Error : Select from date");
    return false;
  } else if (to_date == "") {
    $("#errormsg").text("Error : Select to date");
    return false;
  }

  if (search_type == "ENQUIRED PERSON") {
  }

  if (search_type == "OLD MEMBER") {
    // var sel_month = $("#sel_month").val();
    // var sel_category = $("#sel_category").val();
    // var sel_card = $("#sel_card").val();
    // if (sel_month == "") {
    //   $("#errormsg").text("Error : Select Search From");
    //   return false;
    // }
    // else if (sel_category == "") {
    //   $("#errormsg").text("Error : Select Category");
    //   return false;
    // }
    //  else if (sel_card == "") {
    //   $("#errormsg").text("Error : Select Package");
    //   return false;
    // }
  }

  return true;
}

function ValidateApplyNotification() {
  var send_type = $("#send_type").val();

  $("#send_typeerr,#sel_smserr,#sel_emailerr").removeClass("form_error");
  if (send_type == "sms") {
    var sel_sms = $("#sel_sms").val();
    if (sel_sms == "") {
      $("#sel_smserr").addClass("form_error");
      return false;
    }
  } else {
    var sel_email = $("#sel_email").val();
    if (sel_email == "") {
      $("#sel_emailerr").addClass("form_error");
      return false;
    }
  }

  return true;
}
function addFeedBack() {
  var enq_id = $("#enquiry_id").val();
  var sel_remarks = $("#sel_remarks").val();
  var remarks = $("#txtremark").val();
  var followup_date = $("#followup_date").val();
  var done_by = $("#done_by").val();
  var m_branch_feed_code = $("#feedbck_branch").val();

  if (validatefeedback()) {
    formData = {
      enq_id: enq_id,
      sel_remarks: sel_remarks,
      remarks: remarks,
      followup_date: followup_date,
      done_by: done_by,
      m_branch_feed_code: m_branch_feed_code,
    };
    var method = "enquiry/feedback_action";
    var data = ajaxcallcontrollerforcutom(method, formData);
    if (data.msg_status == 1) {
      $("#sel_remarks").val("").change();
      $("#txtremark").val("");
      $("#followup_date").val("");
      $("#done_by").val("").change();
      $("#errormodal").css("display", "inline-block");
    }
  }
}

function validatefeedback() {
  var enq_id = $("#enquiry_id").val();
  var remarks = $("#txtremark").val();
  var followup_date = $("#followup_date").val();
  var done_by = $("#done_by").val();
  $("#enquiry_id,#txtremark,#followup_date,#donebyerr").removeClass(
    "modalerror"
  );

  if (enq_id == "") {
    // $("#errormodal").text('Error : Enter enquiry id')
    $("#enquiry_id").addClass("modalerror");
    return false;
  } else if (remarks == "") {
    // $("#errormodal").text('Error : Enter addtional remarks')
    $("#txtremark").addClass("modalerror");
    $("#txtremark").focus();
    return false;
  } else if (followup_date == "") {
    // $("#errormodal").text('Error : Select follow up date')
    $("#followup_date").addClass("modalerror");
    $("#followup_date").focus();
    return false;
  } else if (done_by == "") {
    // $("#errormodal").text('Error : Select done by')
    $("#donebyerr").addClass("modalerror");
    $("#done_by").focus();
    return false;
  }
  return true;
}
