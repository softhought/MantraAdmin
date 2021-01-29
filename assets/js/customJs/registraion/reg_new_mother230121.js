// JS for Registration

$(document).ready(function () {
  //Initialize Select2 Elements

  // $(".collapse").on("show.bs.collapse", function (e) {

  //    $(".collapse").collapse("hide");
  // });

  // $(".collapse").on("show.bs.collapse", function (e) {
  //   $(".collapse").collapse("hide");
  // });

  // $("#accordion").collapse((toggle: true));
  // var $myGroup = $("#accordion");
  // $myGroup.on("show.bs.collapse", ".collapse", function () {
  //   $myGroup.find(".collapse.show").collapse("hide");
  // });

  // $("input[type='checkbox'][name='is_term_con']").change(function () {
  //   if ($("input[type='checkbox'][name='is_term_con']:checked").length) {
  //     //alert("checked");
  //     $("#send_term_verfy_code").show();
  //   } else {
  //     $("#send_term_verfy_code,.trmVerify").hide();
  //   }
  // });

  $(document).on(
    "change",
    "#sel_mode,#sel_branch,#chkIscompl",
    function (event) {
      event.preventDefault();
      var sel_mode = $("#sel_mode").val();
      var sel_branch = $("#sel_branch").val();

      var ischecked = $("#chkIscompl").is(":checked");
      var is_compl;
      if (ischecked) {
        is_compl = "Yes";
      } else {
        is_compl = "No";
      }
      if (is_compl == "Yes") {
        $("#is_payment_mode_map").val("Y");
        return false;
      } else {
        $("#is_payment_mode_map").val("N");
      }

      $("#payment_mode_err").html("");
      if (sel_mode == "Select") {
        return false;
      }
      if (sel_branch == "") {
        return false;
      }

      var formData = {
        sel_mode: sel_mode,
        sel_branch: sel_branch,
      };
      var method = "registration/checkPaymentModeWithBranch";
      var data = ajaxcallcontrollerforcutom(method, formData);
      if (data.is_mapped == "Y") {
        $("#is_payment_mode_map").val("Y");
        $("#payment_mode_err").html("");
      } else {
        $("#is_payment_mode_map").val("N");
        $("#payment_mode_err").html(
          " * Payment mode not mapped with Account ID"
        );
      }
    }
  );

  $(document).on("input keyup", ".memName", function (event) {
    event.preventDefault();
    var first_name = $("#txt_first_name").val();
    var last_name = $("#txt_last_name").val();

    $("#txt_name").val(first_name + " " + last_name);
  });

  $(document).on("input keyup", ".miniaddr", function (event) {
    event.preventDefault();
    var txt_houseno = $("#txt_houseno").val();
    var txt_buildingno = $("#txt_buildingno").val();
    var txt_apartno = $("#txt_apartno").val();

    $("#txt_add").val(txt_houseno + " " + txt_buildingno + " " + txt_apartno);
  });

  $(document).on(
    "keyup input",
    "#term_condition_verify_code",
    function (event) {
      event.stopImmediatePropagation();
      var code = $("#term_condition_verify_code").val();
      $("#resend_term_verfy_code").show();
      if (code.length == 6) {
        $("#verify_code").show();
        $("#verify_no").hide();
      } else {
        $("#verify_code").hide();
        $("#verify_no").show();
      }
    }
  );

  $(document).on("click", "#verify_code", function (event) {
    event.stopImmediatePropagation();
    var code = $("#term_condition_verify_code").val();
    var sign_id = $("#agreement_sign_id").val();
    if (code.length == 6) {
      var formData = {
        code: code,
        sign_id: sign_id,
      };
      var method = "registration/checkVerificationCode";
      $("#term_condition_verify_code_err").removeClass("errorClass");
      var data = ajaxcallcontrollerforcutom(method, formData);
      $("#is_agreement_sign").val(data.is_verified);

      if (data.is_verified == "Y") {
        $("#send_term_verfy_code,.trmVerify").hide();
        $("#after_signed").show();
      } else {
        $("#term_condition_verify_code_err").addClass("errorClass");
      }
    }
  });

  $(document).on("change", ".agreecheck", function (event) {
    event.preventDefault();

    var agreement_sign_needed = $("#agreement_sign_needed").val();

    if (agreement_sign_needed == "N") {
      $("#is_agreement_sign").val("Y");
    } else {
      var agreeFlag = 0;
      if ($("input[type='checkbox'][name='is_participating']:checked").length) {
        agreeFlag++;
      }
      // if ($("input[type='checkbox'][name='is_receive_info']:checked").length) {
      //   agreeFlag++;
      // }
      if ($("input[type='checkbox'][name='is_term_con']:checked").length) {
        agreeFlag++;
      }
      if (
        $("input[type='checkbox'][name='is_health_club_eti']:checked").length
      ) {
        agreeFlag++;
      }

      if (agreeFlag == 3) {
        //alert("checked");
        $("#send_term_verfy_code").show();
      } else {
        $("#send_term_verfy_code,.trmVerify").hide();
        $("#is_agreement_sign").val("N");
      }
    }
  });

  $(document).on(
    "click",
    "#send_term_verfy_code,#resend_term_verfy_code",
    function (event) {
      event.preventDefault();

      var mobile = $("#txt_phone").val();

      if (mobile == "" || mobile.length != 10) {
        $("#myModal").modal({ backdrop: "static", keyboard: true, show: true });
        personal_info_err = "Enter Valid Mobile Number ";
        $("#txt_name").addClass("errorClass");
        $("#valid_err").text(personal_info_err);
        return false;
      } else {
        $("#send_term_verfy_code").hide();
        $("#otp_text_mobile").html(
          "(Verification code has been sent to " + mobile + ")"
        );
        $("#verify_code").hide();
        $("#verify_no").show();
      }
      $("#term_condition_verify_code").val("");
      $("#term_condition_verify_code_err").removeClass("errorClass");

      var Id = $(this).attr("id");

      if (Id == "resend_term_verfy_code") {
        $("#resend_term_verfy_code").hide();
      }
      var formData = {
        mobile: mobile,
      };
      var method = "registration/getTermconSendVerificationCode";

      var data = ajaxcallcontrollerforcutom(method, formData);

      //console.log("sign_id" + data);
      $("#agreement_sign_id").val(data.sign_id);
      /*------------------------------------------*/
      $("#term_condition_verify_code").val(data.verifed_code);
      $("#verify_no").hide();
      $("#verify_code").show();

      /*------------------------------------------*/
      var whatsapp="https://api.whatsapp.com/send?text=https://www.mantrahealthclub.com/mantra/termofuse/agreement/" + data.sign_id;
      $("#wplink").prop("href",whatsapp);
      $(".trmVerify").show();
    }
  );

  $(".select2").select2();
  $(".select2x").select2();
  $("#enquiry_panel").css("display", "none");
  $("#exst_membrshp_panel").css("display", "none");

  /* single single update */

  $(document).on("click", "#gen_ass_upd", function (event) {
    event.preventDefault();

    if (!validateSelectMedicalAssestment()) {
      $("#myModal").modal({ backdrop: "static", keyboard: true, show: true });
    } else {
      var formData = new FormData($("#reg_frm")[0]);
      var method = "registration/updateGeneralMedicalAssestment";
      var data = ajaxcallcontroller(method, formData);

      // $("#gen_ass_upd").css("display", "none");
      //$("#gen_ass_upd_loader").css("display", "inline-block");
      $("#gen_ass_upd").addClass("upDatedBtn");
      $("#gen_ass_upd").html("Updated");

      $("#collapseTen").attr("aria-expended", "false");
      $("#collapseTen").attr("class", "panel-collapse collapse");
      $("#collapseTen").css("height", "0px");

      $("#collapseEight").attr("aria-expended", "true");
      $("#collapseEight").attr("class", "panel-collapse collapse show");
      $("#collapseEight").css("height", "auto");
    }
  });

  $(document).on("submit", "#reg_frm", function (event) {
    event.preventDefault();
    var formData = new FormData($(this)[0]);

    console.log(formData);
    // alert();
    if (genmedvalid()) {
      makeEnable();
      var formData = new FormData($(this)[0]);
      $("#submit_form").css("display", "none");
      $("#loaderbtn").css("display", "inline-block");

      var method = "registration/registration_action";
      var data = ajaxcallcontroller(method, formData);
      // window.location.href = basepath + "createbranch";

      if (data.msg_status == 1 && data.mode == "Add") {
        var customer_id = data.cust_ins_id;
        var payment_id = data.pmt_ins_id;
        window.location.href =
          basepath +
          "registration/conformation/" +
          customer_id +
          "/" +
          payment_id;
      } else if (data.msg_status == 0 && data.mode == "Add") {
        $("#errormsg").text(data.msg_data);
      }
    }
  });

  $("#btnhide").on("click", function (e) {
    console.log("button pressed"); // just as an example...
    $("#myModal").modal("hide"); // dismiss the dialog
  });

  $(document).on("click", "#acc_info", function () {
    if (!validatePaymentInfo()) {
      $("#myModal").modal({ backdrop: "static", keyboard: true, show: true });
    }
  });

  $(document).on("click", "#personal_info", function () {
    if (!validatePersonalInfo()) {
      $("#myModal").modal({ backdrop: "static", keyboard: true, show: true });
    }
  });
  $(document).on("click", "#medical_info", function () {
    if (!validateMedicalInfo()) {
      $("#myModal").modal({ backdrop: "static", keyboard: true, show: true });
    }
  });

  $(document).on("click", "#style_modify", function () {
    if (!validateSelectInterest()) {
      $("#myModal").modal({ backdrop: "static", keyboard: true, show: true });
    }
  });
  $(document).on("click", "#style_fithistory", function () {
    if (!validateSelectFitnessHistory()) {
      $("#myModal").modal({ backdrop: "static", keyboard: true, show: true });
    }
  });

  $(document).on("click", "#style_medicalassement", function () {
    if (!validateSelectMedicalAssestment()) {
      $("#myModal").modal({ backdrop: "static", keyboard: true, show: true });
    }
  });

  $(document).on("click", "#other_info", function () {
    if (!validateOtherInfo()) {
      $("#myModal").modal({ backdrop: "static", keyboard: true, show: true });
    }
  });

  $(document).on("click", "#enq_info", function () {
    if (!validateEnqInfo()) {
      $("#myModal").modal({ backdrop: "static", keyboard: true, show: true });
    }
  });
  $(document).on("click", "#ext_mem_info", function () {
    if (!validateExstMember()) {
      $("#myModal").modal({ backdrop: "static", keyboard: true, show: true });
    }
  });

  // Open Submit Button
  $(document).on("click", ".validate_div", function () {
    var selectedmode = $("input[name=options]:checked").val();

    //	alert("MODE "+selectedmode);

    var acc_info_status = $("#acc_info_status").val();
    var personal_valid_status = $("#personal_valid_status").val();
    var medical_info_status = $("#medical_info_status").val();
    var select_int_status = $("#select_int_status").val();
    var other_info_status = $("#other_info_status").val();
    var enq_valid_status = $("#enq_valid_status").val(); // For Enquiry
    var ext_mem_status = $("#ext_mem_status").val(); // For Ext Membership
    var fitness_history_status = $("#fitness_history_status").val(); // fitness_history_status

    /*	alert("Acc Info "+acc_info_status);
			alert("Personal Info "+personal_valid_status);
			alert("Interestd Serv "+select_int_status);
			alert("Other Info "+other_info_status);
			alert("Enq Valid "+enq_valid_status);
			alert("Ext Mem Status "+ext_mem_status); */

    if (selectedmode == "NEW REG") {
      if (
        acc_info_status == "Y" &&
        personal_valid_status == "Y" &&
        medical_info_status == "Y" &&
        select_int_status == "Y" &&
        other_info_status == "Y"
      ) {
        $("#submit_form").css("visibility", "visible");
      }
    }
    if (selectedmode == "ENQ REG") {
      if (
        enq_valid_status == "Y" &&
        acc_info_status == "Y" &&
        personal_valid_status == "Y" &&
        medical_info_status == "Y" &&
        select_int_status == "Y" &&
        other_info_status == "Y"
      ) {
        $("#submit_form").css("visibility", "visible");
      }
    }
    if (selectedmode == "CON REG") {
      if (
        ext_mem_status == "Y" &&
        acc_info_status == "Y" &&
        personal_valid_status == "Y" &&
        medical_info_status == "Y" &&
        select_int_status == "Y" &&
        other_info_status == "Y"
      ) {
        $("#submit_form").css("visibility", "visible");
      }
    } else {
      //$("#submit_form").css("visibility","hidden");
    }
  });

  $(document).on("keyup", ".enq_chng_vld", function () {
    $("#enq_valid_status").val("N");
    validateButtonClr("enq_info");
    $("#submit_form").css("visibility", "hidden");
  });

  $(document).on("keyup", ".mem_ext_cls", function () {
    $("#ext_mem_status").val("N");
    validateButtonClr("ext_mem_info");
    $("#submit_form").css("visibility", "hidden");
  });

  $(document).on("keyup", ".pay_info_chng", function () {
    //	$("#collapseFour").attr("aria-expended","true");
    //	$("#collapseFour").attr("class","panel-collapse collapse show");

    //	alert("Test");
    $("#acc_info_status").val("N");
    validateButtonClr("acc_info");
    $("#submit_form").css("visibility", "hidden");
  });
  $(document).on("change", ".pay_info_chng", function () {
    $("#acc_info_status").val("N");
    validateButtonClr("acc_info");
    $("#submit_form").css("visibility", "hidden");
  });

  $(document).on("keyup", ".persnl_info_chng", function () {
    $("#personal_valid_status").val("N");
    validateButtonClr("personal_info");
    $("#submit_form").css("visibility", "hidden");
  });

  $(document).on("change", ".persnl_info_chng", function () {
    $("#personal_valid_status").val("N");
    validateButtonClr("personal_info");
    $("#submit_form").css("visibility", "hidden");
  });
  $(document).on("change", ".serv_int_chng", function () {
    $("#select_int_status").val("N");
    validateButtonClr("style_modify");
    $("#submit_form").css("visibility", "hidden");
  });
  $(document).on("change", ".med_valid_chng", function () {
    $("#medical_info_status").val("N");
    validateButtonClr("medical_info");
    $("#submit_form").css("visibility", "hidden");
  });
});

// Panel Body Control For New Reg , Enq Reg, Con Reg
function displayPanelBody(val) {
  //var checkRegType = $('input[name=options]:checked').val();
  if (val == "NEW REG") {
    $("#submit_form").css("visibility", "hidden");
    closeAccordion();
    var clear = "";
    $("#txt_enq_no").val(clear);
    $("#sel_name_enq").val(clear);
    $("#txt_ext_mno").val(clear);
    $("#hd_mno").val(clear);
    $("#hd_isconverted").val("N");
    $("#txt_name").val(clear);
    $("#txt_birth").val(clear);
    $("#sel_blood_grp").val("0");
    $("#txt_add").val(clear);
    $("#txt_pin").val(clear);
    $("#txt_phone").val(clear);
    $("#txt_phone").prop("readonly", false);
    validateButtonClr("enq_info");
    validateButtonClr("ext_mem_info");

    // Other Information control
    var check_dropdown_val =
      $("#sel_heard option[value='Doctor Referral']").length > 0;
    //alert(check_dropdown_val);
    if (!check_dropdown_val) {
      $('<option value="Doctor Referral">Doctor Referral</option>').appendTo(
        "#sel_heard"
      );
    }

    $("#sel_heard").val("Hoarding");
    $("#ref_doct").val("0");
    $(".hide_ref_doctr").css("display", "none");
    $("#other_info_status").val("N");
    $("#submit_form").css("visibility", "hidden");
    $("#other_info").css({
      background: "#C9302C",
      border: "#AC2925",
    });
    $("#other_info").text("Validate");
    $("#personal_info_panel").removeClass("personal_info_disable");
    $("#enquiry_panel").css("display", "none");
    $("#exst_membrshp_panel").css("display", "none");

    $("#entry_mode").val(val);
  }
  if (val == "ENQ REG") {
    $("#submit_form").css("visibility", "hidden");
    closeAccordion();

    var clear = "";

    $("#txt_ext_mno").val(clear);
    $("#hd_mno").val(clear);
    $("#hd_isconverted").val("N");
    $("#txt_name").val(clear);
    $("#txt_birth").val(clear);
    $("#sel_blood_grp").val("0");
    $("#txt_add").val(clear);
    $("#txt_pin").val(clear);
    $("#txt_phone").val(clear);
    $("#txt_phone").prop("readonly", false);
    validateButtonClr("ext_mem_info");
    validateButtonClr("personal_info");
    $("#personal_valid_status").val("N");

    var check_dropdown_val =
      $("#sel_heard option[value='Doctor Referral']").length > 0;
    if (!check_dropdown_val) {
      $('<option value="Doctor Referral">Doctor Referral</option>').appendTo(
        "#sel_heard"
      );
    }
    $("#sel_heard").val("Hoarding");
    $("#ref_doct").val("0");
    $(".hide_ref_doctr").css("display", "none");
    $("#other_info_status").val("N");
    $("#submit_form").css("visibility", "hidden");
    $("#other_info").css({
      background: "#C9302C",
      border: "#AC2925",
    });
    $("#other_info").text("Validate");

    $("#personal_info_panel").removeClass("personal_info_disable");
    $("#exst_membrshp_panel").css("display", "none");
    $("#enquiry_panel").css("display", "block");
    $("#entry_mode").val(val);
  }
  if (val == "CON REG") {
    $("#submit_form").css("visibility", "hidden");
    closeAccordion();

    var clear = "";
    $("#txt_enq_no").val(clear);
    $("#sel_name_enq").val(clear);
    $("#txt_name").val(clear);
    $("#txt_birth").val(clear);
    $("#sel_blood_grp").val("0");
    $("#txt_add").val(clear);
    $("#txt_pin").val(clear);
    $("#txt_phone").val(clear);
    $("#txt_phone").prop("readonly", true);
    validateButtonClr("enq_info");
    validateButtonClr("personal_info");
    $("#personal_valid_status").val("N");
    // Other Information control
    $("#sel_heard option[value='Doctor Referral']").remove(); // hide doctor referral for convert mode
    $(".hide_ref_doctr").css("display", "none");
    $("#ref_doct").val("0");
    $("#other_info_status").val("N");
    $("#submit_form").css("visibility", "hidden");
    $("#other_info").css({
      background: "#C9302C",
      border: "#AC2925",
    });
    $("#other_info").text("Validate");

    $("#personal_info_panel").addClass("personal_info_disable");
    $("#enquiry_panel").css("display", "none");
    $("#exst_membrshp_panel").css("display", "block");
    $("#entry_mode").val(val);
  }
}

function validateButtonClr(id) {
  //alert(id);
  $("#" + id).addClass("active");
  $("#" + id).css({
    background: "#C9302C",
    border: "#AC2925",
  });
  $("#" + id).text("Validate");
}

function removeClassfun(params) {
  var i;
  for (i = 0; i < params.length; i++) {
    $("#" + params[i]).removeClass("errorClass");
  }
}

function validatePaymentInfo() {
  var payment_err = "";
  var reg_date = $("#txt_reg_dt").val();
  var payment_dt = $("#txt_payment_dt").val();
  var sel_branch = $("#sel_branch").val();
  var sel_category = $("#sel_category").val();
  var sel_card = $("#sel_card").val();
  var sel_col_brn = $("#sel_col_branch").val();
  //if chkIscompl is chekde
  var ischecked = $("#chkIscompl").is(":checked");
  var txt_subscription = $("#txt_subscription").val();
  //var txt_tax = $("#txt_tax").val();

  var cgstTax = $("#cgstrate").val();
  var sgstTax = $("#sgstrate").val();

  var payment_mode = $("#sel_mode").val();
  // var str_pm = pm.options[pm.selectedIndex].text;
  var inst1 = $("#txt_inst1_amt").val();
  var inst2 = $("#txt_inst2_amt").val();
  //added by anil on 09-04-2020
  var inst3 = $("#txt_inst3_amt").val();
  var inst4 = $("#txt_inst4_amt").val();
  var inst5 = $("#txt_inst5_amt").val();
  var inst6 = $("#txt_inst6_amt").val();
  //end by anil on 09-04-20
  var disc3 = $("#txt_disc_nego").val();
  var txt_rem_nego = $("#txt_rem_nego").val();
  var txt_inst1_dt = $("#txt_inst1_dt").val();
  var txt_inst1_amt = $("#txt_inst1_amt").val();
  var txt_inst1_cheque = $("#txt_inst1_cheque").val();
  var txt_inst2_dt = $("#txt_inst2_dt").val();
  var txt_inst2_amt = $("#txt_inst2_amt").val();
  var txt_inst2_cheque = $("#txt_inst2_cheque").val();
  //added by anil on 09-04-2020
  var txt_inst3_dt = $("#txt_inst3_dt").val();
  var txt_inst3_amt = $("#txt_inst3_amt").val();
  var txt_inst3_cheque = $("#txt_inst3_cheque").val();
  var txt_inst4_dt = $("#txt_inst4_dt").val();
  var txt_inst4_amt = $("#txt_inst4_amt").val();
  var txt_inst4_cheque = $("#txt_inst4_cheque").val();
  var txt_inst5_dt = $("#txt_inst5_dt").val();
  var txt_inst5_amt = $("#txt_inst5_amt").val();
  var txt_inst5_cheque = $("#txt_inst5_cheque").val();
  var txt_inst6_dt = $("#txt_inst6_dt").val();
  var txt_inst6_amt = $("#txt_inst6_amt").val();
  var txt_inst6_cheque = $("#txt_inst6_cheque").val();
  //end by anil on 09-04-20
  var sel_user = $("#sel_user").val();

  if (reg_date == "") {
    $("#acc_info_status").val("N");
    var remove_id = new Array(
      "txt_payment_dt",
      "sel_branch",
      "sel_category",
      "sel_card",
      "sel_col_branch",
      "txt_subscription",
      "cgstrate",
      "sgstrate",
      "sel_mode",
      "txt_rem_nego",
      "txt_inst1_dt",
      "txt_inst1_amt",
      "txt_inst1_cheque",
      "txt_inst2_dt",
      "txt_inst2_amt",
      "txt_inst2_cheque",
      "txt_inst3_dt",
      "txt_inst3_amt",
      "txt_inst3_cheque",
      "txt_inst4_dt",
      "txt_inst4_amt",
      "txt_inst4_cheque",
      "txt_inst5_dt",
      "txt_inst5_amt",
      "txt_inst5_cheque",
      "txt_inst6_dt",
      "txt_inst6_amt",
      "txt_inst6_cheque",
      "sel_user"
    );
    removeClassfun(remove_id); // after success validation remove class

    payment_err = "Enter Registartion date";
    $("#txt_reg_dt").addClass("errorClass");
    $("#txt_reg_dt").focus();
    $("#valid_err").text(payment_err);
    return false;
  }
  if (payment_dt == "") {
    $("#acc_info_status").val("N");
    var remove_id = new Array(
      "txt_reg_dt",
      "sel_branch",
      "sel_category",
      "sel_card",
      "sel_col_branch",
      "txt_subscription",
      "cgstrate",
      "sgstrate",
      "sel_mode",
      "txt_rem_nego",
      "txt_inst1_dt",
      "txt_inst1_amt",
      "txt_inst1_cheque",
      "txt_inst2_dt",
      "txt_inst2_amt",
      "txt_inst2_cheque",
      "txt_inst3_dt",
      "txt_inst3_amt",
      "txt_inst3_cheque",
      "txt_inst4_dt",
      "txt_inst4_amt",
      "txt_inst4_cheque",
      "txt_inst5_dt",
      "txt_inst5_amt",
      "txt_inst5_cheque",
      "txt_inst6_dt",
      "txt_inst6_amt",
      "txt_inst6_cheque",
      "sel_user"
    );
    removeClassfun(remove_id); // after success validation remove class

    payment_err = "Enter Payment date";
    $("#txt_payment_dt").addClass("errorClass");
    $("#txt_payment_dt").focus();
    $("#valid_err").text(payment_err);
    return false;
  }
  if (sel_branch == "") {
    $("#acc_info_status").val("N");
    var remove_id = new Array(
      "txt_reg_dt",
      "txt_payment_dt",
      "sel_category",
      "sel_card",
      "sel_col_branch",
      "txt_subscription",
      "cgstrate",
      "sgstrate",
      "sel_mode",
      "txt_rem_nego",
      "txt_inst1_dt",
      "txt_inst1_amt",
      "txt_inst1_cheque",
      "txt_inst2_dt",
      "txt_inst2_amt",
      "txt_inst2_cheque",
      "txt_inst3_dt",
      "txt_inst3_amt",
      "txt_inst3_cheque",
      "txt_inst4_dt",
      "txt_inst4_amt",
      "txt_inst4_cheque",
      "txt_inst5_dt",
      "txt_inst5_amt",
      "txt_inst5_cheque",
      "txt_inst6_dt",
      "txt_inst6_amt",
      "txt_inst6_cheque",
      "sel_user"
    );
    removeClassfun(remove_id); // after success validation remove class

    payment_err = "Select Business Branch";
    $("#sel_branch").addClass("errorClass");
    $("#sel_branch").focus();
    $("#valid_err").text(payment_err);
    return false;
  }
  if (sel_category == "") {
    $("#acc_info_status").val("N");
    var remove_id = new Array(
      "txt_reg_dt",
      "txt_payment_dt",
      "sel_branch",
      "sel_card",
      "sel_col_branch",
      "txt_subscription",
      "cgstrate",
      "sgstrate",
      "sel_mode",
      "txt_rem_nego",
      "txt_inst1_dt",
      "txt_inst1_amt",
      "txt_inst1_cheque",
      "txt_inst2_dt",
      "txt_inst2_amt",
      "txt_inst2_cheque",
      "txt_inst3_dt",
      "txt_inst3_amt",
      "txt_inst3_cheque",
      "txt_inst4_dt",
      "txt_inst4_amt",
      "txt_inst4_cheque",
      "txt_inst5_dt",
      "txt_inst5_amt",
      "txt_inst5_cheque",
      "txt_inst6_dt",
      "txt_inst6_amt",
      "txt_inst6_cheque",
      "sel_user"
    );
    removeClassfun(remove_id);

    payment_err = "Select Category";
    $("#sel_category").addClass("errorClass");
    $("#valid_err").text(payment_err);
    return false;
  }
  if (sel_card == "0") {
    $("#acc_info_status").val("N");
    var remove_id = new Array(
      "txt_reg_dt",
      "txt_payment_dt",
      "sel_branch",
      "sel_category",
      "sel_col_branch",
      "txt_subscription",
      "cgstrate",
      "sgstrate",
      "sel_mode",
      "txt_rem_nego",
      "txt_inst1_dt",
      "txt_inst1_amt",
      "txt_inst1_cheque",
      "txt_inst2_dt",
      "txt_inst2_amt",
      "txt_inst2_cheque",
      "txt_inst3_dt",
      "txt_inst3_amt",
      "txt_inst3_cheque",
      "txt_inst4_dt",
      "txt_inst4_amt",
      "txt_inst4_cheque",
      "txt_inst5_dt",
      "txt_inst5_amt",
      "txt_inst5_cheque",
      "txt_inst6_dt",
      "txt_inst6_amt",
      "txt_inst6_cheque",
      "sel_user"
    );
    removeClassfun(remove_id);

    payment_err = "Select Package";
    $("#sel_card").addClass("errorClass");
    $("#valid_err").text(payment_err);
    return false;
  }
  if (sel_col_brn == "") {
    $("#acc_info_status").val("N");
    var remove_id = new Array(
      "txt_reg_dt",
      "txt_payment_dt",
      "sel_branch",
      "sel_category",
      "sel_card",
      "txt_subscription",
      "cgstrate",
      "sgstrate",
      "sel_mode",
      "txt_rem_nego",
      "txt_inst1_dt",
      "txt_inst1_amt",
      "txt_inst1_cheque",
      "txt_inst2_dt",
      "txt_inst2_amt",
      "txt_inst2_cheque",
      "txt_inst3_dt",
      "txt_inst3_amt",
      "txt_inst3_cheque",
      "txt_inst4_dt",
      "txt_inst4_amt",
      "txt_inst4_cheque",
      "txt_inst5_dt",
      "txt_inst5_amt",
      "txt_inst5_cheque",
      "txt_inst6_dt",
      "txt_inst6_amt",
      "txt_inst6_cheque",
      "sel_user"
    );
    removeClassfun(remove_id);

    payment_err = "Select Collection Branch";
    $("#sel_col_branch").addClass("errorClass");
    $("#valid_err").text(payment_err);
    return false;
  }

  if (disc3 > 0) {
    if (txt_rem_nego == "") {
      $("#acc_info_status").val("N");
      var remove_id = new Array(
        "txt_reg_dt",
        "txt_payment_dt",
        "sel_branch",
        "sel_category",
        "sel_card",
        "sel_col_branch",
        "txt_subscription",
        "cgstrate",
        "sgstrate",
        "sel_mode",
        "txt_inst1_dt",
        "txt_inst1_amt",
        "txt_inst1_cheque",
        "txt_inst2_dt",
        "txt_inst2_amt",
        "txt_inst2_cheque",
        "txt_inst3_dt",
        "txt_inst3_amt",
        "txt_inst3_cheque",
        "txt_inst4_dt",
        "txt_inst4_amt",
        "txt_inst4_cheque",
        "txt_inst5_dt",
        "txt_inst5_amt",
        "txt_inst5_cheque",
        "txt_inst6_dt",
        "txt_inst6_amt",
        "txt_inst6_cheque",
        "sel_user"
      );
      removeClassfun(remove_id);

      payment_err = "Please Enter Remarks !!! Why are you giving Discount";
      $("#txt_rem_nego").addClass("errorClass");
      $("#valid_err").text(payment_err);
      return false;
    }
  }

  if (ischecked == false) {
    if (txt_subscription == "") {
      $("#acc_info_status").val("N");
      var remove_id = new Array(
        "txt_reg_dt",
        "txt_payment_dt",
        "sel_branch",
        "sel_category",
        "sel_card",
        "sel_col_branch",
        "cgstrate",
        "sgstrate",
        "sel_mode",
        "txt_rem_nego",
        "txt_inst1_dt",
        "txt_inst1_amt",
        "txt_inst1_cheque",
        "txt_inst2_dt",
        "txt_inst2_amt",
        "txt_inst2_cheque",
        "txt_inst3_dt",
        "txt_inst3_amt",
        "txt_inst3_cheque",
        "txt_inst4_dt",
        "txt_inst4_amt",
        "txt_inst4_cheque",
        "txt_inst5_dt",
        "txt_inst5_amt",
        "txt_inst5_cheque",
        "txt_inst6_dt",
        "txt_inst6_amt",
        "txt_inst6_cheque",
        "sel_user"
      );
      removeClassfun(remove_id);

      payment_err = "Enter Subscription Amount";
      $("#txt_subscription").addClass("errorClass");
      $("#valid_err").text(payment_err);
      return false;
    }

    /*
		 if(txt_tax=="")
         {
			$("#acc_info_status").val("N");
			var remove_id = new Array('txt_reg_dt','txt_payment_dt','sel_branch','sel_category','sel_card','sel_col_branch',			'txt_subscription','sel_mode','txt_rem_nego','txt_inst1_dt','txt_inst1_amt','txt_inst1_cheque','txt_inst2_dt','txt_inst2_amt','txt_inst2_cheque','sel_user');
			removeClassfun(remove_id);
			
	        payment_err = "Please Enter Service Tax Amount";
			$("#txt_tax").addClass('errorClass');
	        $("#valid_err").text(payment_err);
	        return false;	
         } 
		 
		*/

    if (cgstTax == "0") {
      $("#acc_info_status").val("N");
      var remove_id = new Array(
        "txt_reg_dt",
        "txt_payment_dt",
        "sel_branch",
        "sel_category",
        "sel_card",
        "sel_col_branch",
        "txt_subscription",
        "sel_mode",
        "txt_rem_nego",
        "txt_inst1_dt",
        "txt_inst1_amt",
        "txt_inst1_cheque",
        "txt_inst2_dt",
        "txt_inst2_amt",
        "sgstrate",
        "txt_inst2_cheque",
        "txt_inst3_dt",
        "txt_inst3_amt",
        "txt_inst3_cheque",
        "txt_inst4_dt",
        "txt_inst4_amt",
        "txt_inst4_cheque",
        "txt_inst5_dt",
        "txt_inst5_amt",
        "txt_inst5_cheque",
        "txt_inst6_dt",
        "txt_inst6_amt",
        "txt_inst6_cheque",
        "sel_user"
      );
      removeClassfun(remove_id);

      payment_err = "Please select CGST Rate";
      $("#cgstrate").addClass("errorClass");
      $("#valid_err").text(payment_err);
      return false;
    }

    if (sgstTax == "0") {
      $("#acc_info_status").val("N");
      var remove_id = new Array(
        "txt_reg_dt",
        "txt_payment_dt",
        "sel_branch",
        "sel_category",
        "sel_card",
        "sel_col_branch",
        "txt_subscription",
        "sel_mode",
        "txt_rem_nego",
        "txt_inst1_dt",
        "txt_inst1_amt",
        "txt_inst1_cheque",
        "txt_inst2_dt",
        "txt_inst2_amt",
        "cgstrate",
        "txt_inst2_cheque",
        "txt_inst3_dt",
        "txt_inst3_amt",
        "txt_inst3_cheque",
        "txt_inst4_dt",
        "txt_inst4_amt",
        "txt_inst4_cheque",
        "txt_inst5_dt",
        "txt_inst5_amt",
        "txt_inst5_cheque",
        "txt_inst6_dt",
        "txt_inst6_amt",
        "txt_inst6_cheque",
        "sel_user"
      );
      removeClassfun(remove_id);

      payment_err = "Please select SGST Rate";
      $("#sgstrate").addClass("errorClass");
      $("#valid_err").text(payment_err);
      return false;
    }

    if (payment_mode == "Select") {
      $("#acc_info_status").val("N");
      var remove_id = new Array(
        "txt_reg_dt",
        "txt_payment_dt",
        "sel_branch",
        "sel_category",
        "sel_card",
        "sel_col_branch",
        "txt_subscription",
        "cgstrate",
        "sgstrate",
        "txt_rem_nego",
        "txt_inst1_dt",
        "txt_inst1_amt",
        "txt_inst1_cheque",
        "txt_inst2_dt",
        "txt_inst2_amt",
        "txt_inst2_cheque",
        "txt_inst3_dt",
        "txt_inst3_amt",
        "txt_inst3_cheque",
        "txt_inst4_dt",
        "txt_inst4_amt",
        "txt_inst4_cheque",
        "txt_inst5_dt",
        "txt_inst5_amt",
        "txt_inst5_cheque",
        "txt_inst6_dt",
        "txt_inst6_amt",
        "txt_inst6_cheque",
        "sel_user"
      );
      removeClassfun(remove_id);

      payment_err = "Please select mode of payment  !!!";
      $("#sel_mode").addClass("errorClass");
      $("#valid_err").text(payment_err);
      return false;
    }
  }

  if (inst1 > 0) {
    if (txt_inst1_dt == "") {
      $("#acc_info_status").val("N");
      var remove_id = new Array(
        "txt_reg_dt",
        "txt_payment_dt",
        "sel_branch",
        "sel_category",
        "sel_card",
        "sel_col_branch",
        "txt_subscription",
        "cgstrate",
        "sgstrate",
        "sel_mode",
        "txt_rem_nego",
        "txt_inst1_amt",
        "txt_inst1_cheque",
        "txt_inst2_dt",
        "txt_inst2_amt",
        "txt_inst2_cheque",
        "txt_inst3_dt",
        "txt_inst3_amt",
        "txt_inst3_cheque",
        "txt_inst4_dt",
        "txt_inst4_amt",
        "txt_inst4_cheque",
        "txt_inst5_dt",
        "txt_inst5_amt",
        "txt_inst5_cheque",
        "txt_inst6_dt",
        "txt_inst6_amt",
        "txt_inst6_cheque",
        "sel_user"
      );
      removeClassfun(remove_id);

      payment_err = "Enter First Date of Installment";
      $("#txt_inst1_dt").addClass("errorClass");
      $("#valid_err").text(payment_err);
      return false;
    }

    /*
       else
       {
	       if (isValidDate(txt_inst1_dt)==false)
	       {
			  $("#acc_info_status").val("N");
			  var remove_id = new Array('txt_reg_dt','txt_payment_dt','sel_branch','sel_category','sel_card','sel_col_branch',			'txt_subscription','txt_tax','sel_mode','txt_rem_nego','txt_inst1_amt','txt_inst1_cheque','txt_inst2_dt','txt_inst2_amt','txt_inst2_cheque','sel_user');
			  removeClassfun(remove_id);
			  
	           payment_err = "Invalid Installment Date Format - Valid format : mm/dd/yyyy ";
			   $("#txt_inst1_dt").addClass('errorClass');
	           $("#valid_err").text(payment_err);
	           return false;	
	       }
       }
	   */

    if (txt_inst1_amt == "") {
      $("#acc_info_status").val("N");
      var remove_id = new Array(
        "txt_reg_dt",
        "txt_payment_dt",
        "sel_branch",
        "sel_category",
        "sel_card",
        "sel_col_branch",
        "txt_subscription",
        "cgstrate",
        "sgstrate",
        "sel_mode",
        "txt_rem_nego",
        "txt_inst1_dt",
        "txt_inst1_cheque",
        "txt_inst2_dt",
        "txt_inst2_amt",
        "txt_inst2_cheque",
        "txt_inst3_dt",
        "txt_inst3_amt",
        "txt_inst3_cheque",
        "txt_inst4_dt",
        "txt_inst4_amt",
        "txt_inst4_cheque",
        "txt_inst5_dt",
        "txt_inst5_amt",
        "txt_inst5_cheque",
        "txt_inst6_dt",
        "txt_inst6_amt",
        "txt_inst6_cheque",
        "sel_user"
      );
      removeClassfun(remove_id);

      payment_err = "Enter 1st Installment";
      $("#txt_inst1_amt").addClass("errorClass");
      $("#valid_err").text(payment_err);
      return false;
    }

    if (txt_inst1_cheque == "") {
      $("#acc_info_status").val("N");
      var remove_id = new Array(
        "txt_reg_dt",
        "txt_payment_dt",
        "sel_branch",
        "sel_category",
        "sel_card",
        "sel_col_branch",
        "txt_subscription",
        "cgstrate",
        "sgstrate",
        "sel_mode",
        "txt_rem_nego",
        "txt_inst1_dt",
        "txt_inst1_amt",
        "txt_inst2_dt",
        "txt_inst2_amt",
        "txt_inst2_cheque",
        "txt_inst3_dt",
        "txt_inst3_amt",
        "txt_inst3_cheque",
        "txt_inst4_dt",
        "txt_inst4_amt",
        "txt_inst4_cheque",
        "txt_inst5_dt",
        "txt_inst5_amt",
        "txt_inst5_cheque",
        "txt_inst6_dt",
        "txt_inst6_amt",
        "txt_inst6_cheque",
        "sel_user"
      );
      removeClassfun(remove_id);

      payment_err = "Enter Cheque No for 1st Installment";
      $("#txt_inst1_cheque").addClass("errorClass");
      $("#valid_err").text(payment_err);
      return false;
    }
  }

  if (inst2 > 0) {
    if (txt_inst2_dt == "") {
      $("#acc_info_status").val("N");
      var remove_id = new Array(
        "txt_reg_dt",
        "txt_payment_dt",
        "sel_branch",
        "sel_category",
        "sel_card",
        "sel_col_branch",
        "txt_subscription",
        "cgstrate",
        "sgstrate",
        "sel_mode",
        "txt_rem_nego",
        "txt_inst1_dt",
        "txt_inst1_amt",
        "txt_inst1_cheque",
        "txt_inst2_amt",
        "txt_inst2_cheque",
        "txt_inst3_dt",
        "txt_inst3_amt",
        "txt_inst3_cheque",
        "txt_inst4_dt",
        "txt_inst4_amt",
        "txt_inst4_cheque",
        "txt_inst5_dt",
        "txt_inst5_amt",
        "txt_inst5_cheque",
        "txt_inst6_dt",
        "txt_inst6_amt",
        "txt_inst6_cheque",
        "sel_user"
      );
      removeClassfun(remove_id);

      payment_err = "Enter Second Date of Installment";
      $("#txt_inst2_dt").addClass("errorClass");
      $("#valid_err").text(payment_err);
      return false;
    }
    /*
	   else
	   {
			if (isValidDate(txt_inst2_dt)==false)
			{
				$("#acc_info_status").val("N");
				var remove_id = new Array('txt_reg_dt','txt_payment_dt','sel_branch','sel_category','sel_card','sel_col_branch','txt_subscription','txt_tax','sel_mode','txt_rem_nego','txt_inst1_dt','txt_inst1_amt','txt_inst1_cheque','txt_inst2_amt','txt_inst2_cheque','sel_user');
				removeClassfun(remove_id);
				
				payment_err = "Invalid Installment Date Format - Valid format : mm/dd/yyyy ";
				 $("#txt_inst2_dt").addClass('errorClass');
				 $("#valid_err").text(payment_err);
				return false;	
			}
	   }
	   */

    if (txt_inst2_amt == "") {
      $("#acc_info_status").val("N");
      var remove_id = new Array(
        "txt_reg_dt",
        "txt_payment_dt",
        "sel_branch",
        "sel_category",
        "sel_card",
        "sel_col_branch",
        "txt_subscription",
        "cgstrate",
        "sgstrate",
        "sel_mode",
        "txt_rem_nego",
        "txt_inst1_dt",
        "txt_inst1_amt",
        "txt_inst1_cheque",
        "txt_inst2_dt",
        "txt_inst2_cheque",
        "txt_inst3_dt",
        "txt_inst3_amt",
        "txt_inst3_cheque",
        "txt_inst4_dt",
        "txt_inst4_amt",
        "txt_inst4_cheque",
        "txt_inst5_dt",
        "txt_inst5_amt",
        "txt_inst5_cheque",
        "txt_inst6_dt",
        "txt_inst6_amt",
        "txt_inst6_cheque",
        "sel_user"
      );
      removeClassfun(remove_id);

      payment_err = "Enter 2nd Installment";
      $("#txt_inst2_amt").addClass("errorClass");
      $("#valid_err").text(payment_err);
      return false;
    }

    if (txt_inst2_cheque == "") {
      $("#acc_info_status").val("N");
      var remove_id = new Array(
        "txt_reg_dt",
        "txt_payment_dt",
        "sel_branch",
        "sel_category",
        "sel_card",
        "sel_col_branch",
        "txt_subscription",
        "cgstrate",
        "sgstrate",
        "sel_mode",
        "txt_rem_nego",
        "txt_inst1_dt",
        "txt_inst1_amt",
        "txt_inst1_cheque",
        "txt_inst2_dt",
        "txt_inst2_amt",
        "txt_inst3_dt",
        "txt_inst3_amt",
        "txt_inst3_cheque",
        "txt_inst4_dt",
        "txt_inst4_amt",
        "txt_inst4_cheque",
        "txt_inst5_dt",
        "txt_inst5_amt",
        "txt_inst5_cheque",
        "txt_inst6_dt",
        "txt_inst6_amt",
        "txt_inst6_cheque",
        "sel_user"
      );
      removeClassfun(remove_id);

      payment_err = "Enter Cheque No for 2nd Installment";
      $("#txt_inst2_cheque").addClass("errorClass");
      $("#valid_err").text(payment_err);
      return false;
    }
  }

  //added by anil on 09-04-2020

  if (inst3 > 0) {
    if (txt_inst3_dt == "") {
      $("#acc_info_status").val("N");
      var remove_id = new Array(
        "txt_reg_dt",
        "txt_payment_dt",
        "sel_branch",
        "sel_category",
        "sel_card",
        "sel_col_branch",
        "txt_subscription",
        "cgstrate",
        "sgstrate",
        "sel_mode",
        "txt_rem_nego",
        "txt_inst1_dt",
        "txt_inst1_amt",
        "txt_inst1_cheque",
        "txt_inst2_amt",
        "txt_inst2_cheque",
        "txt_inst3_dt",
        "txt_inst3_amt",
        "txt_inst3_cheque",
        "txt_inst4_dt",
        "txt_inst4_amt",
        "txt_inst4_cheque",
        "txt_inst5_dt",
        "txt_inst5_amt",
        "txt_inst5_cheque",
        "txt_inst6_dt",
        "txt_inst6_amt",
        "txt_inst6_cheque",
        "sel_user"
      );
      removeClassfun(remove_id);

      payment_err = "Enter Third Date of Installment";
      $("#txt_inst3_dt").addClass("errorClass");
      $("#valid_err").text(payment_err);
      return false;
    }

    if (txt_inst3_amt == "") {
      $("#acc_info_status").val("N");
      var remove_id = new Array(
        "txt_reg_dt",
        "txt_payment_dt",
        "sel_branch",
        "sel_category",
        "sel_card",
        "sel_col_branch",
        "txt_subscription",
        "cgstrate",
        "sgstrate",
        "sel_mode",
        "txt_rem_nego",
        "txt_inst1_dt",
        "txt_inst1_amt",
        "txt_inst1_cheque",
        "txt_inst2_dt",
        "txt_inst2_cheque",
        "txt_inst3_dt",
        "txt_inst3_amt",
        "txt_inst3_cheque",
        "txt_inst4_dt",
        "txt_inst4_amt",
        "txt_inst4_cheque",
        "txt_inst5_dt",
        "txt_inst5_amt",
        "txt_inst5_cheque",
        "txt_inst6_dt",
        "txt_inst6_amt",
        "txt_inst6_cheque",
        "sel_user"
      );
      removeClassfun(remove_id);

      payment_err = "Enter 3rd Installment";
      $("#txt_inst3_amt").addClass("errorClass");
      $("#valid_err").text(payment_err);
      return false;
    }

    if (txt_inst3_cheque == "") {
      $("#acc_info_status").val("N");
      var remove_id = new Array(
        "txt_reg_dt",
        "txt_payment_dt",
        "sel_branch",
        "sel_category",
        "sel_card",
        "sel_col_branch",
        "txt_subscription",
        "cgstrate",
        "sgstrate",
        "sel_mode",
        "txt_rem_nego",
        "txt_inst1_dt",
        "txt_inst1_amt",
        "txt_inst1_cheque",
        "txt_inst2_dt",
        "txt_inst2_amt",
        "txt_inst3_dt",
        "txt_inst3_amt",
        "txt_inst3_cheque",
        "txt_inst4_dt",
        "txt_inst4_amt",
        "txt_inst4_cheque",
        "txt_inst5_dt",
        "txt_inst5_amt",
        "txt_inst5_cheque",
        "txt_inst6_dt",
        "txt_inst6_amt",
        "txt_inst6_cheque",
        "sel_user"
      );
      removeClassfun(remove_id);

      payment_err = "Enter Cheque No for 3rd Installment";
      $("#txt_inst3_cheque").addClass("errorClass");
      $("#valid_err").text(payment_err);
      return false;
    }
  }

  if (inst4 > 0) {
    if (txt_inst4_dt == "") {
      $("#acc_info_status").val("N");
      var remove_id = new Array(
        "txt_reg_dt",
        "txt_payment_dt",
        "sel_branch",
        "sel_category",
        "sel_card",
        "sel_col_branch",
        "txt_subscription",
        "cgstrate",
        "sgstrate",
        "sel_mode",
        "txt_rem_nego",
        "txt_inst1_dt",
        "txt_inst1_amt",
        "txt_inst1_cheque",
        "txt_inst2_amt",
        "txt_inst2_cheque",
        "txt_inst3_dt",
        "txt_inst3_amt",
        "txt_inst3_cheque",
        "txt_inst4_dt",
        "txt_inst4_amt",
        "txt_inst4_cheque",
        "txt_inst5_dt",
        "txt_inst5_amt",
        "txt_inst5_cheque",
        "txt_inst6_dt",
        "txt_inst6_amt",
        "txt_inst6_cheque",
        "sel_user"
      );
      removeClassfun(remove_id);

      payment_err = "Enter Fourth Date of Installment";
      $("#txt_inst4_dt").addClass("errorClass");
      $("#valid_err").text(payment_err);
      return false;
    }

    if (txt_inst4_amt == "") {
      $("#acc_info_status").val("N");
      var remove_id = new Array(
        "txt_reg_dt",
        "txt_payment_dt",
        "sel_branch",
        "sel_category",
        "sel_card",
        "sel_col_branch",
        "txt_subscription",
        "cgstrate",
        "sgstrate",
        "sel_mode",
        "txt_rem_nego",
        "txt_inst1_dt",
        "txt_inst1_amt",
        "txt_inst1_cheque",
        "txt_inst2_dt",
        "txt_inst2_cheque",
        "txt_inst3_dt",
        "txt_inst3_amt",
        "txt_inst3_cheque",
        "txt_inst4_dt",
        "txt_inst4_amt",
        "txt_inst4_cheque",
        "txt_inst5_dt",
        "txt_inst5_amt",
        "txt_inst5_cheque",
        "txt_inst6_dt",
        "txt_inst6_amt",
        "txt_inst6_cheque",
        "sel_user"
      );
      removeClassfun(remove_id);

      payment_err = "Enter 4th Installment";
      $("#txt_inst4_amt").addClass("errorClass");
      $("#valid_err").text(payment_err);
      return false;
    }

    if (txt_inst4_cheque == "") {
      $("#acc_info_status").val("N");
      var remove_id = new Array(
        "txt_reg_dt",
        "txt_payment_dt",
        "sel_branch",
        "sel_category",
        "sel_card",
        "sel_col_branch",
        "txt_subscription",
        "cgstrate",
        "sgstrate",
        "sel_mode",
        "txt_rem_nego",
        "txt_inst1_dt",
        "txt_inst1_amt",
        "txt_inst1_cheque",
        "txt_inst2_dt",
        "txt_inst2_amt",
        "txt_inst3_dt",
        "txt_inst3_amt",
        "txt_inst3_cheque",
        "txt_inst4_dt",
        "txt_inst4_amt",
        "txt_inst4_cheque",
        "txt_inst5_dt",
        "txt_inst5_amt",
        "txt_inst5_cheque",
        "txt_inst6_dt",
        "txt_inst6_amt",
        "txt_inst6_cheque",
        "sel_user"
      );
      removeClassfun(remove_id);

      payment_err = "Enter Cheque No for 4th Installment";
      $("#txt_inst4_cheque").addClass("errorClass");
      $("#valid_err").text(payment_err);
      return false;
    }
  }

  if (inst5 > 0) {
    if (txt_inst5_dt == "") {
      $("#acc_info_status").val("N");
      var remove_id = new Array(
        "txt_reg_dt",
        "txt_payment_dt",
        "sel_branch",
        "sel_category",
        "sel_card",
        "sel_col_branch",
        "txt_subscription",
        "cgstrate",
        "sgstrate",
        "sel_mode",
        "txt_rem_nego",
        "txt_inst1_dt",
        "txt_inst1_amt",
        "txt_inst1_cheque",
        "txt_inst2_amt",
        "txt_inst2_cheque",
        "txt_inst3_dt",
        "txt_inst3_amt",
        "txt_inst3_cheque",
        "txt_inst4_dt",
        "txt_inst4_amt",
        "txt_inst4_cheque",
        "txt_inst5_dt",
        "txt_inst5_amt",
        "txt_inst5_cheque",
        "txt_inst6_dt",
        "txt_inst6_amt",
        "txt_inst6_cheque",
        "sel_user"
      );
      removeClassfun(remove_id);

      payment_err = "Enter Fifth Date of Installment";
      $("#txt_inst5_dt").addClass("errorClass");
      $("#valid_err").text(payment_err);
      return false;
    }

    if (txt_inst5_amt == "") {
      $("#acc_info_status").val("N");
      var remove_id = new Array(
        "txt_reg_dt",
        "txt_payment_dt",
        "sel_branch",
        "sel_category",
        "sel_card",
        "sel_col_branch",
        "txt_subscription",
        "cgstrate",
        "sgstrate",
        "sel_mode",
        "txt_rem_nego",
        "txt_inst1_dt",
        "txt_inst1_amt",
        "txt_inst1_cheque",
        "txt_inst2_dt",
        "txt_inst2_cheque",
        "txt_inst3_dt",
        "txt_inst3_amt",
        "txt_inst3_cheque",
        "txt_inst4_dt",
        "txt_inst4_amt",
        "txt_inst4_cheque",
        "txt_inst5_dt",
        "txt_inst5_amt",
        "txt_inst5_cheque",
        "txt_inst6_dt",
        "txt_inst6_amt",
        "txt_inst6_cheque",
        "sel_user"
      );
      removeClassfun(remove_id);

      payment_err = "Enter 5th Installment";
      $("#txt_inst5_amt").addClass("errorClass");
      $("#valid_err").text(payment_err);
      return false;
    }

    if (txt_inst5_cheque == "") {
      $("#acc_info_status").val("N");
      var remove_id = new Array(
        "txt_reg_dt",
        "txt_payment_dt",
        "sel_branch",
        "sel_category",
        "sel_card",
        "sel_col_branch",
        "txt_subscription",
        "cgstrate",
        "sgstrate",
        "sel_mode",
        "txt_rem_nego",
        "txt_inst1_dt",
        "txt_inst1_amt",
        "txt_inst1_cheque",
        "txt_inst2_dt",
        "txt_inst2_amt",
        "txt_inst3_dt",
        "txt_inst3_amt",
        "txt_inst3_cheque",
        "txt_inst4_dt",
        "txt_inst4_amt",
        "txt_inst4_cheque",
        "txt_inst5_dt",
        "txt_inst5_amt",
        "txt_inst5_cheque",
        "txt_inst6_dt",
        "txt_inst6_amt",
        "txt_inst6_cheque",
        "sel_user"
      );
      removeClassfun(remove_id);

      payment_err = "Enter Cheque No for 5th Installment";
      $("#txt_inst5_cheque").addClass("errorClass");
      $("#valid_err").text(payment_err);
      return false;
    }
  }

  if (inst6 > 0) {
    if (txt_inst6_dt == "") {
      $("#acc_info_status").val("N");
      var remove_id = new Array(
        "txt_reg_dt",
        "txt_payment_dt",
        "sel_branch",
        "sel_category",
        "sel_card",
        "sel_col_branch",
        "txt_subscription",
        "cgstrate",
        "sgstrate",
        "sel_mode",
        "txt_rem_nego",
        "txt_inst1_dt",
        "txt_inst1_amt",
        "txt_inst1_cheque",
        "txt_inst2_amt",
        "txt_inst2_cheque",
        "txt_inst3_dt",
        "txt_inst3_amt",
        "txt_inst3_cheque",
        "txt_inst4_dt",
        "txt_inst4_amt",
        "txt_inst4_cheque",
        "txt_inst5_dt",
        "txt_inst5_amt",
        "txt_inst5_cheque",
        "txt_inst6_dt",
        "txt_inst6_amt",
        "txt_inst6_cheque",
        "sel_user"
      );
      removeClassfun(remove_id);

      payment_err = "Enter Sixth Date of Installment";
      $("#txt_inst6_dt").addClass("errorClass");
      $("#valid_err").text(payment_err);
      return false;
    }

    if (txt_inst6_amt == "") {
      $("#acc_info_status").val("N");
      var remove_id = new Array(
        "txt_reg_dt",
        "txt_payment_dt",
        "sel_branch",
        "sel_category",
        "sel_card",
        "sel_col_branch",
        "txt_subscription",
        "cgstrate",
        "sgstrate",
        "sel_mode",
        "txt_rem_nego",
        "txt_inst1_dt",
        "txt_inst1_amt",
        "txt_inst1_cheque",
        "txt_inst2_dt",
        "txt_inst2_cheque",
        "txt_inst3_dt",
        "txt_inst3_amt",
        "txt_inst3_cheque",
        "txt_inst4_dt",
        "txt_inst4_amt",
        "txt_inst4_cheque",
        "txt_inst5_dt",
        "txt_inst5_amt",
        "txt_inst5_cheque",
        "txt_inst6_dt",
        "txt_inst6_amt",
        "txt_inst6_cheque",
        "sel_user"
      );
      removeClassfun(remove_id);

      payment_err = "Enter 6th Installment";
      $("#txt_inst6_amt").addClass("errorClass");
      $("#valid_err").text(payment_err);
      return false;
    }

    if (txt_inst6_cheque == "") {
      $("#acc_info_status").val("N");
      var remove_id = new Array(
        "txt_reg_dt",
        "txt_payment_dt",
        "sel_branch",
        "sel_category",
        "sel_card",
        "sel_col_branch",
        "txt_subscription",
        "cgstrate",
        "sgstrate",
        "sel_mode",
        "txt_rem_nego",
        "txt_inst1_dt",
        "txt_inst1_amt",
        "txt_inst1_cheque",
        "txt_inst2_dt",
        "txt_inst2_amt",
        "txt_inst3_dt",
        "txt_inst3_amt",
        "txt_inst3_cheque",
        "txt_inst4_dt",
        "txt_inst4_amt",
        "txt_inst4_cheque",
        "txt_inst5_dt",
        "txt_inst5_amt",
        "txt_inst5_cheque",
        "txt_inst6_dt",
        "txt_inst6_amt",
        "txt_inst6_cheque",
        "sel_user"
      );
      removeClassfun(remove_id);

      payment_err = "Enter Cheque No for 6th Installment";
      $("#txt_inst6_cheque").addClass("errorClass");
      $("#valid_err").text(payment_err);
      return false;
    }
  }

  //end by anil on 09-04-2020

  if (sel_user == "") {
    $("#acc_info_status").val("N");
    var remove_id = new Array(
      "txt_reg_dt",
      "txt_payment_dt",
      "sel_branch",
      "sel_category",
      "sel_card",
      "sel_col_branch",
      "txt_subscription",
      "cgstrate",
      "sgstrate",
      "sel_mode",
      "txt_rem_nego",
      "txt_inst1_dt",
      "txt_inst1_amt",
      "txt_inst1_cheque",
      "txt_inst2_dt",
      "txt_inst2_amt",
      "txt_inst2_cheque",
      "txt_inst3_dt",
      "txt_inst3_amt",
      "txt_inst3_cheque",
      "txt_inst4_dt",
      "txt_inst4_amt",
      "txt_inst4_cheque",
      "txt_inst5_dt",
      "txt_inst5_amt",
      "txt_inst5_cheque",
      "txt_inst6_dt",
      "txt_inst6_amt",
      "txt_inst6_cheque"
    );
    removeClassfun(remove_id);

    payment_err = "Select Done by";
    $("#sel_user").addClass("errorClass");
    $("#valid_err").text(payment_err);
    return false;
  }

  $("#acc_info_status").val("Y");
  $("#acc_info").removeClass("active");
  $("#acc_info").css({
    background: "#1AB37D",
    border: "#1AB37D",
  });
  $("#acc_info").text("Proceed");
  $("#valid_err").text("");

  var remove = new Array(
    "txt_reg_dt",
    "txt_payment_dt",
    "sel_branch",
    "sel_category",
    "sel_card",
    "sel_col_branch",
    "txt_subscription",
    "cgstrate",
    "sgstrate",
    "sel_mode",
    "txt_rem_nego",
    "txt_inst1_dt",
    "txt_inst1_amt",
    "txt_inst1_cheque",
    "txt_inst2_dt",
    "txt_inst2_amt",
    "txt_inst2_cheque",
    "txt_inst3_dt",
    "txt_inst3_amt",
    "txt_inst3_cheque",
    "txt_inst4_dt",
    "txt_inst4_amt",
    "txt_inst4_cheque",
    "txt_inst5_dt",
    "txt_inst5_amt",
    "txt_inst5_cheque",
    "txt_inst6_dt",
    "txt_inst6_amt",
    "txt_inst6_cheque",
    "sel_user"
  );
  removeClassfun(remove); // after success validation remove class

  $("#collapseThree").attr("aria-expended", "false");
  $("#collapseThree").attr("class", "panel-collapse collapse");
  $("#collapseThree").css("height", "0px");

  $("#collapseFour").attr("aria-expended", "true");
  $("#collapseFour").attr("class", "panel-collapse collapse show");
  $("#collapseFour").css("height", "auto");

  return true;
}
function validatePersonalInfo() {
  var personal_info_err = "";
  var txt_first_name = $("#txt_first_name").val();
  var txt_last_name = $("#txt_last_name").val();
  var txt_name = $("#txt_name").val();
  var txt_birth = $("#txt_birth").val();
  var sel_blood_grp = $("#sel_blood_grp").val();
  var txt_add = $("#txt_add").val();
  var sel_diet = $("#sel_diet").val();
  var txt_pin = $("#txt_pin").val();
  var txt_phone = $("#txt_phone").val();
  //var is_exist = $("#mnexst").val();
  var entrymode = $("#entry_mode").val();
  var phone_valid = /^([0-9]{10})$/;
  var whatsup_number = $("#whatsup_number").val();
  //added by anil on 24-04-2020
  var sel_trainer = $("#sel_trainer").val();
  $("#txt_first_name,#txt_last_name").removeClass("errorClass");
  if (txt_first_name == "" || txt_last_name == "") {
    $("#personal_valid_status").val("N");
    var remove_id = new Array(
      "txt_birth",
      "sel_blood_grp",
      "txt_add",
      "txt_pin",
      "txt_phone",
      "sel_trainer"
    );
    removeClassfun(remove_id);

    personal_info_err = "Enter First Name & Last Name ";
    $("#txt_first_name,#txt_last_name").addClass("errorClass");
    $("#valid_err").text(personal_info_err);
    return false;
  }
  if (txt_birth == "") {
    $("#personal_valid_status").val("N");
    var remove_id = new Array(
      "txt_name",
      "sel_blood_grp",
      "txt_add",
      "txt_pin",
      "txt_phone",
      "sel_trainer"
    );
    removeClassfun(remove_id);

    personal_info_err = "Enter Date of Birth";
    $("#txt_birth").addClass("errorClass");
    $("#valid_err").text(personal_info_err);
    return false;
  }
  if (sel_blood_grp == "0") {
    $("#personal_valid_status").val("N");
    var remove_id = new Array(
      "txt_name",
      "txt_birth",
      "txt_add",
      "txt_pin",
      "txt_phone",
      "sel_trainer"
    );
    removeClassfun(remove_id);

    personal_info_err = "Select Blood Group";
    $("#sel_blood_grp").addClass("errorClass");
    $("#valid_err").text(personal_info_err);
    return false;
  }
  if (txt_add == "") {
    $("#personal_valid_status").val("N");
    var remove_id = new Array(
      "txt_name",
      "txt_birth",
      "sel_blood_grp",
      "txt_pin",
      "txt_phone",
      "sel_trainer"
    );
    removeClassfun(remove_id);

    personal_info_err = "Enter Address";
    $("#txt_add").addClass("errorClass");
    $("#valid_err").text(personal_info_err);
    return false;
  }

  if (sel_diet == "") {
    $("#personal_valid_status").val("N");
    var remove_id = new Array(
      "txt_name",
      "txt_birth",
      "sel_blood_grp",
      "txt_pin",
      "txt_phone",
      "sel_trainer"
    );
    removeClassfun(remove_id);

    personal_info_err = "Select Diet";
    $("#sel_diet").addClass("errorClass");
    $("#valid_err").text(personal_info_err);
    return false;
  }
  if (txt_pin == "") {
    $("#personal_valid_status").val("N");
    var remove_id = new Array(
      "txt_name",
      "txt_birth",
      "sel_blood_grp",
      "txt_add",
      "txt_pin",
      "txt_phone",
      "sel_trainer"
    );
    removeClassfun(remove_id);

    personal_info_err = "Select Pin No";
    $("#txt_pin").addClass("errorClass");
    $("#valid_err").text(personal_info_err);
    return false;
  }
  //added by anil on 24-04-2020
  if (sel_trainer == "0") {
    $("#personal_valid_status").val("N");
    var remove_id = new Array(
      "txt_name",
      "txt_birth",
      "sel_blood_grp",
      "txt_add",
      "txt_pin",
      "txt_phone",
      "sel_trainer"
    );
    removeClassfun(remove_id);

    personal_info_err = "Select Trainer";
    $("#sel_trainer").addClass("errorClass");
    $("#valid_err").text(personal_info_err);
    return false;
  }

  if (whatsup_number != "" && whatsup_number.length < 10) {
    $("#personal_valid_status").val("N");
    var remove_id = new Array(
      "txt_name",
      "txt_birth",
      "sel_blood_grp",
      "txt_add",
      "txt_pin",
      "sel_trainer"
    );
    removeClassfun(remove_id);

    personal_info_err = "Enter What's Up Mobile No. Minimum 10 Digit";
    $("#whatsup_number").addClass("errorClass");
    $("#valid_err").text(personal_info_err);
    return false;
  }
  if (txt_phone == "") {
    $("#personal_valid_status").val("N");
    var remove_id = new Array(
      "txt_name",
      "txt_birth",
      "sel_blood_grp",
      "txt_add",
      "txt_pin",
      "sel_trainer"
    );
    removeClassfun(remove_id);

    personal_info_err = "Enter Mobile No";
    $("#txt_phone").addClass("errorClass");
    $("#valid_err").text(personal_info_err);
    return false;
  }
  if (phone_valid.test(txt_phone) == false) {
    $("#personal_valid_status").val("N");
    var remove_id = new Array(
      "txt_name",
      "txt_birth",
      "sel_blood_grp",
      "txt_add",
      "txt_pin",
      "sel_trainer"
    );
    removeClassfun(remove_id);

    personal_info_err = "Mobile No should be 10 digit numeric value";
    $("#txt_phone").addClass("errorClass");
    $("#valid_err").text(personal_info_err);
    return false;
  }
  /*
		if(is_exist==1 && entrymode!='CON REG'){
			$("#personal_valid_status").val("N");
			var remove_id = new Array('txt_name','txt_birth','sel_blood_grp','txt_add','txt_pin');
			removeClassfun(remove_id);
			
			personal_info_err = "Mobile no you entered is already exist";
			$("#txt_phone").addClass('errorClass');
			$("#valid_err").text(personal_info_err);
			return false;
		}*/
  $("#personal_valid_status").val("Y");
  $("#personal_info").removeClass("active");
  $("#personal_info").css({
    background: "#1AB37D",
    border: "#1AB37D",
  });
  $("#personal_info").text("Proceed");
  $("#valid_err").text("");

  var remove = new Array(
    "txt_name",
    "txt_birth",
    "sel_blood_grp",
    "txt_add",
    "txt_pin",
    "txt_phone",
    "sel_trainer"
  );
  removeClassfun(remove);

  $("#collapseFour").attr("aria-expended", "false");
  $("#collapseFour").attr("class", "panel-collapse collapse");
  $("#collapseFour").css("height", "0px");

  $("#collapseFive").attr("aria-expended", "true");
  $("#collapseFive").attr("class", "panel-collapse collapse show");
  $("#collapseFive").css("height", "auto");

  return true;
}

function validateMedicalInfo() {
  medical_info_err = "";
  var sel_app = $("#sel_app option:selected").text();
  var sel_dig = $("#sel_dig option:selected").text();
  var sel_hrt = $("#sel_hrt option:selected").text();
  var sel_urn = $("#sel_urn option:selected").text();
  var sel_nrv = $("#sel_nrv option:selected").text();
  var sel_ent = $("#sel_ent option:selected").text();
  var sel_ort = $("#sel_ort option:selected").text();
  var sel_psy = $("#sel_psy option:selected").text();
  var sel_fem = $("#sel_fem option:selected").text();
  var sel_dit = $("#sel_dit option:selected").text();

  if (sel_app == "Select") {
    $("#medical_info_status").val("N");
    var remove_id = new Array(
      "sel_dig",
      "sel_hrt",
      "sel_urn",
      "sel_nrv",
      "sel_ent",
      "sel_ort",
      "sel_psy",
      "sel_fem",
      "sel_dit"
    );
    removeClassfun(remove_id);

    medical_info_err = "Select Appetite Option";
    $("#sel_app").addClass("errorClass");
    $("#valid_err").text(medical_info_err);
    return false;
  }
  if (sel_dig == "Select") {
    $("#medical_info_status").val("N");
    var remove_id = new Array(
      "sel_app",
      "sel_hrt",
      "sel_urn",
      "sel_nrv",
      "sel_ent",
      "sel_ort",
      "sel_psy",
      "sel_fem",
      "sel_dit"
    );
    removeClassfun(remove_id);

    medical_info_err = "Select Digestion Option";
    $("#sel_dig").addClass("errorClass");
    $("#valid_err").text(medical_info_err);
    return false;
  }
  if (sel_hrt == "Select") {
    $("#medical_info_status").val("N");
    var remove_id = new Array(
      "sel_app",
      "sel_dig",
      "sel_urn",
      "sel_nrv",
      "sel_ent",
      "sel_ort",
      "sel_psy",
      "sel_fem",
      "sel_dit"
    );
    removeClassfun(remove_id);

    medical_info_err = "Select Heart Option";
    $("#sel_hrt").addClass("errorClass");
    $("#valid_err").text(medical_info_err);
    return false;
  }
  if (sel_urn == "Select") {
    $("#medical_info_status").val("N");
    var remove_id = new Array(
      "sel_app",
      "sel_dig",
      "sel_hrt",
      "sel_nrv",
      "sel_ent",
      "sel_ort",
      "sel_psy",
      "sel_fem",
      "sel_dit"
    );
    removeClassfun(remove_id);

    medical_info_err = "Select Urine Option";
    $("#sel_urn").addClass("errorClass");
    $("#valid_err").text(medical_info_err);
    return false;
  }
  if (sel_nrv == "Select") {
    $("#medical_info_status").val("N");
    var remove_id = new Array(
      "sel_app",
      "sel_dig",
      "sel_hrt",
      "sel_urn",
      "sel_ent",
      "sel_ort",
      "sel_psy",
      "sel_fem",
      "sel_dit"
    );
    removeClassfun(remove_id);

    medical_info_err = "Select Nerves Option";
    $("#sel_nrv").addClass("errorClass");
    $("#valid_err").text(medical_info_err);
    return false;
  }
  if (sel_ent == "Select") {
    $("#medical_info_status").val("N");
    var remove_id = new Array(
      "sel_app",
      "sel_dig",
      "sel_hrt",
      "sel_urn",
      "sel_nrv",
      "sel_ort",
      "sel_psy",
      "sel_fem",
      "sel_dit"
    );
    removeClassfun(remove_id);

    medical_info_err = "Select ENT Option";
    $("#sel_ent").addClass("errorClass");
    $("#valid_err").text(medical_info_err);
    return false;
  }
  if (sel_ort == "Select") {
    $("#medical_info_status").val("N");
    var remove_id = new Array(
      "sel_app",
      "sel_dig",
      "sel_hrt",
      "sel_urn",
      "sel_nrv",
      "sel_ent",
      "sel_psy",
      "sel_fem",
      "sel_dit"
    );
    removeClassfun(remove_id);

    medical_info_err = "Select Orthopedic Option";
    $("#sel_ort").addClass("errorClass");
    $("#valid_err").text(medical_info_err);
    return false;
  }

  if (sel_psy == "Select") {
    $("#medical_info_status").val("N");
    var remove_id = new Array(
      "sel_app",
      "sel_dig",
      "sel_hrt",
      "sel_urn",
      "sel_nrv",
      "sel_ent",
      "sel_ort",
      "sel_fem",
      "sel_dit"
    );
    removeClassfun(remove_id);

    medical_info_err = "Select Psyche Option";
    $("#sel_psy").addClass("errorClass");
    $("#valid_err").text(medical_info_err);
    return false;
  }

  if (sel_fem == "Select") {
    $("#medical_info_status").val("N");
    var remove_id = new Array(
      "sel_app",
      "sel_dig",
      "sel_hrt",
      "sel_urn",
      "sel_nrv",
      "sel_ent",
      "sel_ort",
      "sel_psy",
      "sel_dit"
    );
    removeClassfun(remove_id);

    medical_info_err = "Select Female Disorder Option";
    $("#sel_fem").addClass("errorClass");
    $("#valid_err").text(medical_info_err);
    return false;
  }
  if (sel_dit == "Select") {
    $("#medical_info_status").val("N");
    var remove_id = new Array(
      "sel_app",
      "sel_dig",
      "sel_hrt",
      "sel_urn",
      "sel_nrv",
      "sel_ent",
      "sel_ort",
      "sel_psy",
      "sel_fem"
    );
    removeClassfun(remove_id);

    medical_info_err = "Select Diet Option";
    $("#sel_dit").addClass("errorClass");
    $("#valid_err").text(medical_info_err);
    return false;
  }

  $("#medical_info_status").val("Y");

  $("#medical_info").removeClass("active");
  $("#medical_info").css({
    background: "#1AB37D",
    border: "#1AB37D",
  });
  $("#medical_info").text("Proceed");
  $("#valid_err").text("");

  var remove = new Array(
    "sel_app",
    "sel_dig",
    "sel_hrt",
    "sel_urn",
    "sel_nrv",
    "sel_ent",
    "sel_ort",
    "sel_psy",
    "sel_fem",
    "sel_dit"
  );
  removeClassfun(remove);

  $("#collapseFive").attr("aria-expended", "false");
  $("#collapseFive").attr("class", "panel-collapse collapse");
  $("#collapseFive").css("height", "0px");

  $("#collapseSix").attr("aria-expended", "true");
  $("#collapseSix").attr("class", "panel-collapse collapse show");
  $("#collapseSix").css("height", "auto");

  return true;
}

function validateSelectInterest() {
  var sele_int_err = "";
  var sel_service_int = $("#sel_service_int").val();
  if (sel_service_int == "") {
    $("#select_int_status").val("N");
    sele_int_err = "Select Interested Service";
    $("#sel_service_int").addClass("errorClass");
    $("#valid_err").text(sele_int_err);
    return false;
  }
  $("#select_int_status").val("Y");
  $("#style_modify").removeClass("active");
  $("#style_modify").css({
    background: "#1AB37D",
    border: "#1AB37D",
  });
  $("#style_modify").text("Proceed");
  $("#valid_err").text("");

  $("#collapseSix").attr("aria-expended", "false");
  $("#collapseSix").attr("class", "panel-collapse collapse");
  $("#collapseSix").css("height", "0px");

  $("#collapseSeven").attr("aria-expended", "true");
  $("#collapseSeven").attr("class", "panel-collapse collapse show");
  $("#collapseSeven").css("height", "auto");

  return true;
}

function validateSelectFitnessHistory() {
  var sele_int_err = "";

  if ($('input[name="sel_fitness_history"]:checked').length == 0) {
    $("#fitness_history_status").val("N");
    sele_int_err = "Select Fitness History Type";
    $("#sel_fitness_history").addClass("errorClass");
    $("#valid_err").text(sele_int_err);
    return false;
  }
  $("#fitness_history_status").val("Y");
  $("#style_fithistory").removeClass("active");
  $("#style_fithistory").css({
    background: "#1AB37D",
    border: "#1AB37D",
  });
  $("#style_fithistory").text("Proceed");
  $("#valid_err").text("");

  $("#collapseNine").attr("aria-expended", "false");
  $("#collapseNine").attr("class", "panel-collapse collapse");
  $("#collapseNine").css("height", "0px");

  $("#collapseEight").attr("aria-expended", "true");
  $("#collapseEight").attr("class", "panel-collapse collapse show");
  $("#collapseEight").css("height", "auto");

  return true;
}

function validateSelectMedicalAssestment() {
  var sele_int_err = "";

  // if ($('input[name="sel_fitness_history"]:checked').length == 0) {
  //   $("#fitness_history_status").val("N");
  //   sele_int_err = "Select Fitness History Type";
  //   $("#sel_fitness_history").addClass("errorClass");
  //   $("#valid_err").text(sele_int_err);
  //   return false;
  // }
  $("#medical_assestment_status").val("Y");
  $("#style_medicalassement").removeClass("active");
  $("#style_medicalassement").css({
    background: "#1AB37D",
    border: "#1AB37D",
  });
  $("#style_medicalassement").text("Proceed");
  $("#valid_err").text("");

  $("#collapseEight").attr("aria-expended", "false");
  $("#collapseEight").attr("class", "panel-collapse collapse");
  $("#collapseEight").css("height", "0px");

  $("#collapseTen").attr("aria-expended", "true");
  $("#collapseTen").attr("class", "panel-collapse collapse show");
  $("#collapseTen").css("height", "auto");

  return true;
}

function validateOtherInfo() {
  var other_ifo_err = "";
  var heard_from = $("#sel_heard").val();
  var txt_mem_mob = $("#txt_mem_mob").val();
  var ref_doct = $("#ref_doct").val();

  //	alert(heard_from);
  //	alert(txt_mem_mob);

  if (heard_from == "") {
    if (ref_doct == "0") {
      $("#other_info_status").val("N");
      $("#submit_form").css("visibility", "hidden");
      $("#other_info").css({
        background: "#C9302C",
        border: "#AC2925",
      });
      $("#other_info").text("Validate");
      other_ifo_err = "From where you first heard ";
      $("#valid_err").text(other_ifo_err);
      return false;
    }
  }
  /*  // commented on 09.012.2020 by shankha
  if (heard_from == "From Member") {
    $("#ref_doct").val("0");
    if (txt_mem_mob == "" || txt_mem_mob.length < 10) {
      $("#other_info_status").val("N");
      $("#submit_form").css("visibility", "hidden");
      $("#other_info").css({
        background: "#C9302C",
        border: "#AC2925",
      });
      $("#other_info").text("Validate");
      if (txt_mem_mob.length < 10 && txt_mem_mob.length > 0) {
        other_ifo_err = "Enter 10 Digit Member's Mobile No";
      } else {
        other_ifo_err = "Enter Member's Mobile No";
      }
      $("#valid_err").text(other_ifo_err);
      return false;
    }
  }

  if (heard_from == "Doctor Referral") {
    if (ref_doct == "0") {
      $("#other_info_status").val("N");
      $("#submit_form").css("visibility", "hidden");
      $("#other_info").css({
        background: "#C9302C",
        border: "#AC2925",
      });
      $("#other_info").text("Validate");
      other_ifo_err = "Select doctor referral";
      $("#valid_err").text(other_ifo_err);
      return false;
    }
  }

  */

  $("#other_info_status").val("Y");
  $("#other_info").removeClass("active");
  $("#other_info").css({
    background: "#1AB37D",
    border: "#1AB37D",
  });
  $("#other_info").text("Proceed");
  $("#valid_err").text("");

  $("#collapseSeven").attr("aria-expended", "false");
  $("#collapseSeven").attr("class", "panel-collapse collapse");
  $("#collapseSeven").css("height", "0px");

  $("#collapseEight").attr("aria-expended", "true");
  $("#collapseEight").attr("class", "panel-collapse collapse show");
  $("#collapseEight").css("height", "auto");

  /*
		if(heard_from!="From Member"){
			$("#txt_mem_mob").val("");
			$("#detail").text("");
		}
		
		
		
		$("#other_info_status").val("Y");
		$("#other_info").removeClass("active");
		$("#other_info").css({
						"background":"#1AB37D",
						"border":"#1AB37D"
						});
		$("#other_info").text("Proceed");
		$("#valid_err").text("");
		
		$("#collapseSeven").attr("aria-expended","false");
		$("#collapseSeven").attr("class","panel-collapse collapse");
		$("#collapseSeven").css("height","0px");
		
		$("#collapseEight").attr("aria-expended","true");
		$("#collapseEight").attr("class","panel-collapse collapse show");
		$("#collapseEight").css("height","auto");
		
		
		return true;
		*/
  return true;
}

function viewFirstHeardFrom() {
  var heard_from = $("#sel_heard").val();
  var txt_mem_mob = $("#txt_mem_mob").val();
  if (heard_from == "From Member") {
    $(".hide_frm_mem").css("display", "table-cell");
    $("#ref_doct").val("0");
    $(".hide_ref_doctr").css("display", "none");

    $("#other_info_status").val("N");
    $("#submit_form").css("visibility", "hidden");
    $("#other_info").css({
      background: "#C9302C",
      border: "#AC2925",
    });
    $("#other_info").text("Validate");
  }

  if (heard_from == "Doctor Referral") {
    $(".hide_frm_mem").css("display", "none");
    $("#txt_mem_mob").val("");
    $("#detail").text("");
    $(".hide_ref_doctr").css("display", "table-cell");

    $("#other_info_status").val("N");
    $("#submit_form").css("visibility", "hidden");
    $("#other_info").css({
      background: "#C9302C",
      border: "#AC2925",
    });
    $("#other_info").text("Validate");
  }

  if (heard_from != "From Member" && heard_from != "Doctor Referral") {
    $("#txt_mem_mob").val("");
    $("#detail").text("");
    $("#ref_doct").val("0");
    $(".hide_frm_mem").css("display", "none");
    $(".hide_ref_doctr").css("display", "none");
  }
}

function validateEnqInfo() {
  var enq_info_err = "";
  var enq_no = $("#txt_enq_no").val();
  var sel_name_enq = $("#sel_name_enq").val();

  if (enq_no == "") {
    $("#enq_valid_status").val("N");
    enq_info_err = "Enter Enquiry No";
    $("#valid_err").text(enq_info_err);
    return false;
  }
  if (sel_name_enq == "0") {
    $("#enq_valid_status").val("N");
    enq_info_err = "Select Name From Enquiry";
    $("#valid_err").text(enq_info_err);
    return false;
  }

  $("#enq_valid_status").val("Y");
  $("#valid_err").text("");
  $("#enq_info").removeClass("active");
  $("#enq_info").css({
    background: "#1AB37D",
    border: "#1AB37D",
  });
  $("#enq_info").text("Proceed");

  $("#collapseOne").attr("aria-expended", "false");
  $("#collapseOne").attr("class", "panel-collapse collapse");
  $("#collapseOne").css("height", "0px");

  $("#collapseThree").attr("aria-expended", "true");
  $("#collapseThree").attr("class", "panel-collapse collapse show");
  $("#collapseThree").css("height", "auto");

  return true;
}

function validateExstMember() {
  var ext_mem_err = "";
  var ext_mem_no = $("#txt_ext_mno").val();
  if (ext_mem_no == "") {
    $("#ext_mem_status").val("N");
    ext_mem_err = "Enter Existing Membership No";
    $("#valid_err").text(ext_mem_err);
    return false;
  }

  $("#ext_mem_status").val("Y");
  $("#valid_err").text("");
  $("#ext_mem_info").removeClass("active");
  $("#ext_mem_info").css({
    background: "#1AB37D",
    border: "#1AB37D",
  });
  $("#ext_mem_info").text("Proceed");

  $("#collapseTwo").attr("aria-expended", "false");
  $("#collapseTwo").attr("class", "panel-collapse collapse");
  $("#collapseTwo").css("height", "0px");

  $("#collapseThree").attr("aria-expended", "true");
  $("#collapseThree").attr("class", "panel-collapse collapse show");
  $("#collapseThree").css("height", "auto");

  return true;
}

function closeAccordion() {
  $("#collapseOne").attr("aria-expended", "false");
  $("#collapseOne").attr("class", "panel-collapse collapse");
  $("#collapseOne").css("height", "0px");

  $("#collapseTwo").attr("aria-expended", "false");
  $("#collapseTwo").attr("class", "panel-collapse collapse");
  $("#collapseTwo").css("height", "0px");

  $("#collapseThree").attr("aria-expended", "false");
  $("#collapseThree").attr("class", "panel-collapse collapse");
  $("#collapseThree").css("height", "0px");

  $("#collapseFour").attr("aria-expended", "false");
  $("#collapseFour").attr("class", "panel-collapse collapse");
  $("#collapseFour").css("height", "0px");

  $("#collapseFive").attr("aria-expended", "false");
  $("#collapseFive").attr("class", "panel-collapse collapse");
  $("#collapseFive").css("height", "0px");

  $("#collapseSix").attr("aria-expended", "false");
  $("#collapseSix").attr("class", "panel-collapse collapse");
  $("#collapseSix").css("height", "0px");

  $("#collapseSeven").attr("aria-expended", "false");
  $("#collapseSeven").attr("class", "panel-collapse collapse");
  $("#collapseSeven").css("height", "0px");

  $("#collapseEight").attr("aria-expended", "false");
  $("#collapseEight").attr("class", "panel-collapse collapse");
  $("#collapseEight").css("height", "0px");
}

function showPreview() {
  // Addmission & Payment Information
  var txt_phone = $("#txt_phone").val();
  var reg_date = $("#txt_reg_dt").val();
  var payment_dt = $("#txt_payment_dt").val();
  var sel_branch = $("#sel_branch option:selected").text();
  var sel_category = $("#sel_category option:selected").text();
  var sel_card = $("#sel_card option:selected").text();
  var sel_col_brn = $("#sel_col_branch option:selected").text();
  //if chkIscompl is chekde
  var ischecked = $("#chkIscompl").is(":checked");
  var is_compl;
  if (ischecked) {
    is_compl = "Yes";
  } else {
    is_compl = "No";
  }
  var txt_subscription = $("#txt_subscription").val();
  var txt_disc_conv = $("#txt_disc_conv").val();
  var txt_disc_offer = $("#txt_disc_offer").val();
  var txt_disc_nego = $("#txt_disc_nego").val();
  var txt_rem_nego = $("#txt_rem_nego").val();
  var txt_premium = $("#txt_premium").val();
  var txt_payment_now = $("#txt_payment_now").val();
  var txt_due = $("#txt_due").val();
  var txt_inst1_dt = $("#txt_inst1_dt").val();
  var txt_inst1_amt = $("#txt_inst1_amt").val();
  var txt_inst1_cheque = $("#txt_inst1_cheque").val();
  var txt_inst1_bank = $("#txt_inst1_bank").val();
  var txt_inst1_branch = $("#txt_inst1_branch").val();
  var txt_inst2_dt = $("#txt_inst2_dt").val();
  var txt_inst2_amt = $("#txt_inst2_amt").val();
  var txt_inst2_cheque = $("#txt_inst2_cheque").val();
  var txt_inst2_bank = $("#txt_inst2_bank").val();
  var txt_inst2_branch = $("#txt_inst2_branch").val();
  //added by anil on 09-04-2020
  var txt_inst3_dt = $("#txt_inst3_dt").val();
  var txt_inst3_amt = $("#txt_inst3_amt").val();
  var txt_inst3_cheque = $("#txt_inst3_cheque").val();
  var txt_inst3_bank = $("#txt_inst3_bank").val();
  var txt_inst3_branch = $("#txt_inst3_branch").val();

  var txt_inst4_dt = $("#txt_inst4_dt").val();
  var txt_inst4_amt = $("#txt_inst4_amt").val();
  var txt_inst4_cheque = $("#txt_inst4_cheque").val();
  var txt_inst4_bank = $("#txt_inst4_bank").val();
  var txt_inst4_branch = $("#txt_inst4_branch").val();

  var txt_inst5_dt = $("#txt_inst5_dt").val();
  var txt_inst5_amt = $("#txt_inst5_amt").val();
  var txt_inst5_cheque = $("#txt_inst5_cheque").val();
  var txt_inst5_bank = $("#txt_inst5_bank").val();
  var txt_inst5_branch = $("#txt_inst5_branch").val();

  var txt_inst6_dt = $("#txt_inst6_dt").val();
  var txt_inst6_amt = $("#txt_inst6_amt").val();
  var txt_inst6_cheque = $("#txt_inst6_cheque").val();
  var txt_inst6_bank = $("#txt_inst6_bank").val();
  var txt_inst6_branch = $("#txt_inst6_branch").val();

  //end by anil on 09-04-2020

  var txt_tax = $("#txt_tax").val();
  var txt_payable = $("#txt_payable").val();
  var payment_mode = $("#sel_mode").val();
  // var str_pm = pm.options[pm.selectedIndex].text;
  var txt_chq_no = $("#txt_chq_no").val();
  var txt_chq_dt = $("#txt_chq_dt").val();
  var txt_bank = $("#txt_bank").val();
  var txt_branch = $("#txt_branch").val();
  var sel_user = $("#sel_user option:selected").text();

  $("#prv_phone_mobile").text(txt_phone);
  $("#prv_reg_dt").text(reg_date);
  $("#prv_payment_dt").text(payment_dt);
  $("#prv_bus_brnch").text(sel_branch);
  $("#prv_category").text(sel_category);
  $("#prv_pkg").text(sel_card);
  $("#prv_col_brnch").text(sel_col_brn);
  $("#prv_comply").text(is_compl);
  $("#prv_packg_rate").text(txt_subscription);
  $("#prv_dis_conv").text(txt_disc_conv);
  $("#prv_dis_off").text(txt_disc_offer);
  $("#prv_dis_nego").text(txt_disc_nego);
  $("#prv_rmk_nego").text(txt_rem_nego);
  $("#prv_prm").text(txt_premium);
  $("#prv_paymnt_nw").text(txt_payment_now);
  $("#prv_due").text(txt_due);
  $("#prv_1st_inst_dt").text(txt_inst1_dt);
  $("#prv_1st_inst").text(txt_inst1_amt);
  $("#prv_1st_chq_no").text(txt_inst1_cheque);
  $("#prv_1st_bnk").text(txt_inst1_bank);
  $("#prv_1st_brn").text(txt_inst1_branch);
  $("#prv_2nd_inst_dt").text(txt_inst2_dt);
  $("#prv_2nd_inst").text(txt_inst2_amt);
  $("#prv_2nd_chq_no").text(txt_inst2_cheque);
  $("#prv_2nd_bnk").text(txt_inst2_bank);
  $("#prv_2nd_brn").text(txt_inst2_branch);
  //added by anil on 09-04-2020
  $("#prv_3rd_inst_dt").text(txt_inst3_dt);
  $("#prv_3rd_inst").text(txt_inst3_amt);
  $("#prv_3rd_chq_no").text(txt_inst3_cheque);
  $("#prv_3rd_bnk").text(txt_inst3_bank);
  $("#prv_3rd_brn").text(txt_inst3_branch);
  $("#prv_4th_inst_dt").text(txt_inst4_dt);
  $("#prv_4th_inst").text(txt_inst4_amt);
  $("#prv_4th_chq_no").text(txt_inst4_cheque);
  $("#prv_4th_bnk").text(txt_inst4_bank);
  $("#prv_4th_brn").text(txt_inst4_branch);
  $("#prv_5th_inst_dt").text(txt_inst5_dt);
  $("#prv_5th_inst").text(txt_inst5_amt);
  $("#prv_5th_chq_no").text(txt_inst5_cheque);
  $("#prv_5th_bnk").text(txt_inst5_bank);
  $("#prv_5th_brn").text(txt_inst5_branch);
  $("#prv_6th_inst_dt").text(txt_inst6_dt);
  $("#prv_6th_inst").text(txt_inst6_amt);
  $("#prv_6th_chq_no").text(txt_inst6_cheque);
  $("#prv_6th_bnk").text(txt_inst6_bank);
  $("#prv_6th_brn").text(txt_inst6_branch);
  //ended by anil on 09-04-2020
  $("#prv_tax").text(txt_tax);
  $("#prv_payble").text(txt_payable);
  $("#prv_payment_mode").text(payment_mode);
  $("#prv_chq_no").text(txt_chq_no);
  $("#prv_chq_dt").text(txt_chq_dt);
  $("#prv_bnk").text(txt_bank);
  $("#prv_brnch").text(txt_branch);
  $("#prv_done_by").text(sel_user);
  // end admission and payment information

  // Start Personal Information
  var gender;
  var marital_status;
  var txt_first_name = $("#txt_first_name").val();
  var txt_last_name = $("#txt_last_name").val();
  var txt_name = $("#txt_name").val();
  var txt_name_2 = $("#txt_name_2").val();
  var txt_birth = $("#txt_birth").val();
  var txt_anniversary = $("#txt_anniversary").val();
  var sel_gender = $("#sel_gender").val();
  var sel_fitness_history = $(
    'input[name="sel_fitness_history"]:checked'
  ).val();
  if (sel_gender == "M") {
    gender = "Male";
  } else {
    gender = "Female";
  }
  var sel_marital = $("#sel_marital").val();
  if (sel_marital == "M") {
    marital_status = "Married";
  } else {
    marital_status = "Single";
  }
  var sel_blood_grp = $("#sel_blood_grp").val();
  var txt_father = $("#txt_father").val();
  var txt_houseno = $("#txt_houseno").val();
  var txt_buildingno = $("#txt_buildingno").val();
  var txt_apartno = $("#txt_apartno").val();
  var txt_add = $("#txt_add").val();
  var sel_diet = $("#sel_diet").val();
  var txt_pin = $("#txt_pin").val();
  var txt_phone = $("#txt_phone").val();
  var txt_phone2 = $("#txt_phone2").val();
  var txt_mail = $("#txt_mail").val();
  var txt_occu = $("#txt_occu").val();
  var sel_trainer = $("#sel_trainer option:selected").text();

  $("#prv_first_name").text(txt_first_name);
  $("#prv_last_name").text(txt_last_name);
  $("#prv_full_name").text(txt_name);
  // $("#prv_2nd_name").text(txt_name_2);
  $("#prv_dob").text(txt_birth);
  $("#prv_anv_dt").text(txt_anniversary);
  $("#prv_gender").text(gender);
  $("#prv_maritl_status").text(marital_status);
  $("#prv_bld_grp").text(sel_blood_grp);
  $("#prv_father").text(txt_father);

  $("#prv_houseno").text(txt_houseno);
  $("#prv_buildingno").text(txt_buildingno);
  $("#prv_apartno").text(txt_apartno);

  $("#prv_add").text(txt_add);
  $("#prv_pin").text(txt_pin);
  $("#prv_diet").text(sel_diet);
  $("#prv_mobile").text(txt_phone);
  $("#prv_phn_othr").text(txt_phone2);
  $("#prv_email").text(txt_mail);
  $("#prv_occup").text(txt_occu);
  $("#prv_trainer").text(sel_trainer);
  // End Personal Information

  // Medical Information(s)
  var is_mem_act;
  var txt_comp = $("#txt_comp").val();
  var txt_his = $("#txt_his").val();
  var sel_app = $("#sel_app option:selected").text();
  var sel_dig = $("#sel_dig option:selected").text();
  var sel_hrt = $("#sel_hrt option:selected").text();
  var sel_urn = $("#sel_urn option:selected").text();
  var sel_nrv = $("#sel_nrv option:selected").text();
  var sel_ent = $("#sel_ent option:selected").text();
  var sel_ort = $("#sel_ort option:selected").text();
  var sel_psy = $("#sel_psy option:selected").text();
  var sel_fem = $("#sel_fem option:selected").text();
  var sel_dit = $("#sel_dit option:selected").text();
  var chkIsact = $("#chkIsact").is(":checked");
  if (chkIsact) {
    is_mem_act = "Yes";
  } else {
    is_mem_act = "No";
  }

  $("#prv_prs_comp").text(txt_comp);
  $("#prv_past_his").text(txt_his);
  $("#prv_appetit").text(sel_app);
  $("#prv_digestion").text(sel_dig);
  $("#prv_heart").text(sel_hrt);
  $("#prv_urine").text(sel_urn);
  $("#prv_nerve").text(sel_nrv);
  $("#prv_ent").text(sel_ent);
  $("#prv_ortho_prb").text(sel_ort);
  $("#prv_psyche").text(sel_psy);
  $("#prv_fml_disorder").text(sel_fem);
  $("#prv_diet").text(sel_dit);
  $("#prv_hold_mem").text(is_mem_act);
  $("#prv_fitmess_history").text(sel_fitness_history);
  // End Medical Information

  // Service Interested in Life Style Modification
  var sel_service_int = $("#sel_service_int option:selected").text();
  $("#prv_int_serv").text(sel_service_int);

  // Other Information(s)
  var sel_heard = $("#sel_heard").val();
  var txt_mem_mob = $("#txt_mem_mob").val();
  var sel_service = $("#sel_service").val();
  var detail = $("#detail").text();
  var doct_ref = $("#ref_doct option:selected").text();

  $("#prv_first_herd").text(sel_heard);
  $("#prv_mem_mbl").text(txt_mem_mob);
  $("#prv_free_serv").text(sel_service);
  $("#prv_mem_dtl").text(detail);
  $("#prv_doct_ref").text(doct_ref);
  // End Other Information

  //General Medical Assesment
  /*
  var txt_waist = $("#txt_waist").val();
  var txt_weight = $("#txt_weight").val();
  var txt_height = $("#txt_height").val();
  var txt_hip = $("#txt_hip").val();
  var txt_chest = $("#txt_chest").val();
  var txt_hand = $("#txt_hand").val();
  var txt_bp = $("#txt_bp").val();
  var txt_bp_d = $("#txt_bp_d").val();
  var txt_fat = $("#txt_fat").val();
  var txt_heart_rate = $("#txt_heart_rate").val();
  var txt_oxy_level = $("#txt_oxy_level").val();
  var txt_ecg = $("#txt_ecg").val();
  var txt_chest_xray = $("#txt_chest_xray").val();
  var txt_vo2 = $("#txt_vo2").val();



  $("#prv_waist").text(txt_waist);
  $("#prv_weight").text(txt_weight);
  $("#prv_height").text(txt_height);
  $("#prv_hip").text(txt_hip);
  $("#prv_chest").text(txt_chest);
  $("#prv_hand").text(txt_hand);
  $("#prv_bp_s").text(txt_bp);
  $("#prv_bp_d").text(txt_bp_d);
  $("#prv_fat_per").text(txt_fat);
  $("#prv_heart_rt").text(txt_heart_rate);
  $("#prv_oxy_lvl").text(txt_oxy_level);
  $("#prv_ecg").text(txt_ecg);
  $("#prv_chst_xray").text(txt_chest_xray);
  $("#prv_vo2_max").text(txt_vo2); */

  var is_high_bp = $("#is_high_bp").val();
  var high_bp_medicines = $("#high_bp_medicines").val();
  var diabetes_radio = $('input[name="diabetes_radio"]:checked').val();
  var diabetics_medicines = $("#diabetics_medicines").val();
  var is_heart_disease = $("#is_heart_disease").val();
  var heart_disease_medicines = $("#heart_disease_medicines").val();
  var is_pcod = $("#is_pcod").val();
  var pcod_medicines = $("#pcod_medicines").val();
  var is_chronic_kidney_disease = $("#is_chronic_kidney_disease").val();
  var chronic_kidney_disease_medicines = $(
    "#chronic_kidney_disease_medicines"
  ).val();
  var sel_psyche = $("#sel_psyche").val();
  var regular_med_history = $("#regular_med_history").val();

  $("#prv_high_bp").text(is_high_bp);
  $("#prv_high_bp_med").text(high_bp_medicines);
  $("#prv_diabetes").text(diabetes_radio);
  $("#prv_diabetes_med").text(diabetics_medicines);
  $("#prv_heart_disease").text(is_heart_disease);
  $("#prv_heart_disease_med").text(heart_disease_medicines);
  $("#prv_pcod").text(is_pcod);
  $("#prv_pcod_med").text(pcod_medicines);
  $("#prv_chronic_kidney").text(is_chronic_kidney_disease);
  $("#prv_chronic_kidney_med").text(chronic_kidney_disease_medicines);
  $("#prv_psyche").text(sel_psyche);
  $("#prv_regular_med_history").text(txt_vo2);
  $("#regular_med_history").text(txt_vo2);
}

function numericFilter(txb) {
  txb.value = txb.value.replace(/[^\0-9]/gi, "");
}

function addReferralDoctor() {
  var doct_name = $("#doctor_name").val();
  var degree = $("#degree").val();
  if (doct_name == "") {
    $("#doc_ref_err").css("display", "block");
    $("#doctor_name").focus();
    return false;
  }
  $("#doc_ref_err").css("display", "none");

  $.ajax({
    url: basepath + "registration/addReferDoctor",
    type: "post",
    dataType: "html",
    data: { doct_name: doct_name, degree: degree },
    success: function (data) {
      var clear = "";
      $("#doctor_name").val(clear);
      $("#degree").val(clear);
      if (data) {
        // $("#successMesg").modal("show");
        // $("#addDoctorReferral").css("display", "none");
        $("#addDoctorReferral").modal("hide");
        $("#refresh_ref_doct").html(data);
        $("#ref_doct").select2();
      }
      if (data == "0") {
      }
    },
    complete: function (data) {},
    error: function (e) {
      console.log(e.message);
    },
  });
}

function closeAddDoctorRef() {
  var clear = "";
  $("#doctor_name").val(clear);
  $("#degree").val(clear);
  $("#myModal").modal("hide");
}

/* add blood presure validation*/
function genmedvalid() {
  /*
  var weight = $("#txt_weight").val();
  var txt_bp_s = $("#txt_bp").val();
  var txt_bp_d = $("#txt_bp_d").val();

  $("#txt_weight,#txt_bp,#txt_bp_d").removeClass("errorClass");

  if (weight == "") {
    weight_err = "Enter Body weight";
    $("#txt_weight").addClass("errorClass");
    $("#valid_err").text(weight_err);

    $("#myModal").modal({ backdrop: "static", keyboard: true, show: true });
    return false;
  }

  if (txt_bp_s == "") {
    bp_s_err = "Enter Blood Pressure Systolic";
    $("#txt_bp").addClass("errorClass");
    $("#valid_err").text(bp_s_err);

    $("#myModal").modal({ backdrop: "static", keyboard: true, show: true });
    return false;
  }

  if (txt_bp_d == "") {
    bp_d_err = "Enter Blood Pressure Diastolic";
    $("#txt_bp_d").addClass("errorClass");
    $("#valid_err").text(bp_d_err);

    $("#myModal").modal({ backdrop: "static", keyboard: true, show: true });
    return false;
  }

  */

  var is_payment_mode_map = $("#is_payment_mode_map").val();
  var is_agreement_sign = $("#is_agreement_sign").val();

  if (is_payment_mode_map == "N") {
    var agree = "Payment mode not mapped with Account ID";

    $("#valid_err").text(agree);

    $("#myModal").modal({ backdrop: "static", keyboard: true, show: true });

    return false;
  }

  if (is_agreement_sign == "N") {
    var agree = "Check the Agreements";

    $("#valid_err").text(agree);

    $("#myModal").modal({ backdrop: "static", keyboard: true, show: true });

    return false;
  }

  return true;
}
