$(window).on("load", function () {
  memberViewOpt("DATE");
});

$(document).ready(function () {
  $("#example").dataTable();

  basepath = $("#basepath").val();

  $("#fromDt,#toDate").datepicker({
    autoclose: true,
    todayHighlight: true,
    format: "dd-mm-yyyy",
    forceParse: false,
  });

  $("#m-dob").datepicker({
    autoclose: true,
    todayHighlight: true,
    format: "dd-mm-yyyy",
    forceParse: false,
  });

  /*
		$("#searchByOpt").change(function(){
			var opt = $(this).val();
			memberViewOpt(opt);
		});
		*/
  $(document).on("input keyup", ".memName", function (event) {
    event.preventDefault();
    var first_name = $("#first_name").val();
    var last_name = $("#last_name").val();

    $("#m-name").val(first_name + " " + last_name);
  });

  $(document).on("click", ".litab", function () {
    idname = $(this).attr("id");
    $(".litab").removeClass("actTab");

    $("#" + idname).addClass("actTab");
  });

  $(document).on("change", "#searchByOpt", function () {
    var opt = $(this).val();
    memberViewOpt(opt);
  });

  // getting details of member
  $(document).on("click", ".editMemberModal", function () {
    var cid = $(this).data("memdtl").cid;
    var pid = $(this).data("memdtl").pid;
    var mem = $(this).data("memdtl").mno;
    /*
			alert("CID "+cid);
			alert("pid "+pid);
			alert("mem "+mem);
			*/

    $.ajax({
      type: "POST",
      //url:'edit_member_detail_modal.php',
      url: basepath + "memberinfo/getMemberDetailsModel",
      dataType: "html",
      data: { cid: cid, pid: pid, mem: mem },
      success: function (response) {
        $("#loadMemDtl").html(response);
        $("#m-dob,.datepicker").datepicker({
          autoclose: true,
          todayHighlight: true,
          format: "dd-mm-yyyy",
          forceParse: false,
        });
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
        //  alert(msg);
      },
    });
  });

  $(document).on("click", "#updatePersonalInfo", function () {
    $("#personal-upd").css("display", "none");
    var mode = "PERSONAL";
    var first_name = $("#first_name").val();
    var last_name = $("#last_name").val();
    var name = $("#m-name").val();
    var name = $("#m-name").val();
    var dob = $("#m-dob").val();
    var gender = $("#m-gender").val();
    var marital = $("#m-marital").val();
    var father = $("#m-father").val();
    var email = $("#m-email").val();
    var occp = $("#m-occupation").val();
    var bldgrp = $("#m-bldgrp").val();
    var trainer = $("#m-trainer").val();
    var pin = $("#m-pin").val();
    var address = $("#m-address").val();
    var whatsupNum = $("#whatsupNum").val();
    var cid = $("#cid").val();
    var validate = validatePersonalInfo(
      name,
      dob,
      email,
      bldgrp,
      trainer,
      pin,
      address,
      whatsupNum
    );
    if (validate) {
      $.ajax({
        type: "POST",
        //url:'update_member_info_mdl.php',
        url: basepath + "memberinfo/updateMemberData",
        dataType: "html",
        data: {
          mode: mode,
          first_name: first_name,
          last_name: last_name,
          name: name,
          dob: dob,
          gender: gender,
          marital: marital,
          father: father,
          email: email,
          occp: occp,
          bldgrp: bldgrp,
          trainer: trainer,
          pin: pin,
          address: address,
          cid: cid,
          whatsupNum: whatsupNum,
        },
        success: function (response) {
          if (response == 1) {
            $("#personal-upd").css("display", "table-cell");
          }
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
          //  alert(msg);
        },
      });
    }
  });

  //Payment
  $(document).on("click", "#updatePaymentInfo", function () {
    if (validatePaymentInfo()) {
      var pid = $("#pid").val();
      var cid = $("#cid").val();
      var vmid = $("#vmid").val();
      var pmtDt = $("#payment-dt").val();
      var colBrnch = $("#col-branch").val();
      var remarksnego = $("#remarks-nego").val();
      var paynw = $("#txt_payment_now").val();
      var txt_due = $("#txt_due").val();
      var txt_tax = $("#txt_tax").val();
      var txt_payable = $("#txt_payable").val();
      var finsdt = $("#frst-inst-dt").val();
      var finsamt = $("#txt_inst1_amt").val();
      var finschqn = $("#frst-chq-no").val();
      var finsbnk = $("#frst-bank").val();
      var finbrn = $("#frst-brn").val();
      var secinsdt = $("#second-instl-dt").val();
      var secinsamt = $("#txt_inst2_amt").val();
      var secinschq = $("#second-chq-no").val();
      var secinsbnk = $("#second-bnk").val();
      var secinsbrn = $("#second-brn").val();
      var pmode = $("#payment-mode").val();
      var chqno = $("#chq-num").val();
      var chqdt = $("#chq-date").val();
      var bnkname = $("#bank-name").val();
      var bnkbrn = $("#bank-branch").val();
      var doneby = $("#done-by").val();
      var isedt = $("#isedt").val();

      var mode = "PAYMENT";
      $.ajax({
        type: "POST",
        url: "update_member_info_mdl.php",
        url: basepath + "memberinfo/updateMemberData",
        dataType: "html",
        data: {
          mode: mode,
          cid: cid,
          pid: pid,
          vmid: vmid,
          isedt: isedt,
          pmtDt: pmtDt,
          clbrn: colBrnch,
          rmksnego: remarksnego,
          paynw: paynw,
          due: txt_due,
          tax: txt_tax,
          payble: txt_payable,
          finsdt: finsdt,
          finsamt: finsamt,
          finschqn: finschqn,
          finsbnk: finsbnk,
          finbrn: finbrn,
          secinsdt: secinsdt,
          secinsamt: secinsamt,
          secinschq: secinschq,
          secinsbnk: secinsbnk,
          secinsbrn: secinsbrn,
          pmode: pmode,
          chqno: chqno,
          chqdt: chqdt,
          bnkname: bnkname,
          bnkbrn: bnkbrn,
          doneby: doneby,
        },
        success: function (response) {
          if (response == 1) {
            $("#payment-upd").css("display", "table-cell");
          }
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
          //  alert(msg);
        },
      });
    }
  });

  /* medical info update */
  $(document).on("click", "#updateMedicalInfo", function () {
    if (1) {
      var pid = $("#pid_GST").val();
      var cid = $("#cid_GST").val();
      var txt_comp = $("#txt_comp").val();
      var txt_his = $("#txt_his").val();
      var sel_app = $("#sel_app").val();
      var sel_dig = $("#sel_dig").val();
      var sel_hrt = $("#sel_hrt").val();
      var sel_urn = $("#sel_urn").val();
      var sel_nrv = $("#sel_nrv").val();

      var sel_ent = $("#sel_ent").val();
      var sel_ort = $("#sel_ort").val();
      var sel_psy = $("#sel_psy").val();
      var sel_fem = $("#sel_fem").val();
      var sel_dit = $("#sel_dit").val();

      var mode = "MEDIINFO";

      $.ajax({
        type: "POST",
        // url: "update_member_info_mdl.php",
        url: basepath + "memberinfo/updateMemberData",
        dataType: "html",
        data: {
          mode: mode,
          cid: cid,
          pid: pid,
          txt_comp: txt_comp,
          txt_his: txt_his,
          sel_app: sel_app,
          sel_dig: sel_dig,
          sel_hrt: sel_hrt,
          sel_urn: sel_urn,
          sel_nrv: sel_nrv,
          sel_ent: sel_ent,
          sel_ort: sel_ort,
          sel_psy: sel_psy,
          sel_fem: sel_fem,
          sel_dit: sel_dit,
        },
        success: function (response) {
          if (response == 1) {
            $("#medicalinfo-upd").css("display", "table-cell");
          }
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
          //  alert(msg);
        },
      });
    }
  });

  /* update general medical assestemnt */

  $(document).on("click", "#updateGenMedicalInfo", function () {
    if (1) {
      var pid = $("#pid_GST").val();
      var cid = $("#cid_GST").val();
      var vmid = $("#vmid_GST").val();
      var is_high_bp = $("#is_high_bp").val();
      var high_bp_medicines = $("#high_bp_medicines").val();
      var diabetes_radio = $("#diabetes_radio").val();
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

      var mode = "GENMEDASS";

      $.ajax({
        type: "POST",
        // url: "update_member_info_mdl.php",
        url: basepath + "memberinfo/updateMemberData",
        dataType: "html",
        data: {
          mode: mode,
          cid: cid,
          pid: pid,
          vmid: vmid,
          is_high_bp: is_high_bp,
          high_bp_medicines: high_bp_medicines,
          diabetes_radio: diabetes_radio,
          diabetics_medicines: diabetics_medicines,
          is_heart_disease: is_heart_disease,
          heart_disease_medicines: heart_disease_medicines,
          is_pcod: is_pcod,
          pcod_medicines: pcod_medicines,
          is_pcod: is_pcod,
          is_chronic_kidney_disease: is_chronic_kidney_disease,
          chronic_kidney_disease_medicines: chronic_kidney_disease_medicines,
          sel_psyche: sel_psyche,
          regular_med_history: regular_med_history,
        },
        success: function (response) {
          if (response == 1) {
            $("#genmed-upd").css("display", "table-cell");
          }
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
          //  alert(msg);
        },
      });
    }
  });

  /*Payment Update Gst*/

  //Payment
  $(document).on("click", "#updatePaymentInfoGST", function () {
    if (validatePaymentInfoGST()) {
      var pid = $("#pid_GST").val();
      var cid = $("#cid_GST").val();
      var vmid = $("#vmid_GST").val();
      var pmtDt = $("#payment-dt-GST").val();
      var colBrnch = $("#col-branch-GST").val();
      var remarksnego = $("#remarks-nego-GST").val();
      var paynw = $("#txt_payment_now_GST").val();
      var txt_due = $("#txt_due_GST").val();
      var cgstRate = $("#cgstrate").val();
      var cgstAmt = $("#cgstAmount").val();
      var sgstRate = $("#sgstrate").val();
      var sgstAmt = $("#sgstAmount").val();
      var txt_payable = $("#txt_payable_GST").val();
      var finsdt = $("#frst-inst-dt-gst").val();
      var finsamt = $("#txt_inst1_amt_gst").val();
      var finschqn = $("#frst-chq-no-gst").val();
      var finsbnk = $("#frst-bank-gst").val();
      var finbrn = $("#frst-brn-gst").val();

      var secinsdt = $("#second-instl-dt-gst").val();
      var secinsamt = $("#txt_inst2_amt_gst").val();
      var secinschq = $("#second-chq-no-gst").val();
      var secinsbnk = $("#second-bnk-gst").val();
      var secinsbrn = $("#second-brn-gst").val();

      var thirdinsdt = $("#third-instl-dt-gst").val();
      var thirdinsamt = $("#txt_inst3_amt_gst").val();
      var thirdinschq = $("#third-chq-no-gst").val();
      var thirdinsbnk = $("#3rd-bnk-gst").val();
      var thirdinsbrn = $("#3rd-brn-gst").val();

      var fourinsdt = $("#four-instl-dt-gst").val();
      var fourinsamt = $("#txt_inst4_amt_gst").val();
      var fourinschq = $("#fourth-chq-no-gst").val();
      var fourinsbnk = $("#fourth-bnk-gst").val();
      var fourinsbrn = $("#fourth-brn-gst").val();

      var fifthinsdt = $("#five-instl-dt-gst").val();
      var fifthinsamt = $("#txt_inst5_amt_gst").val();
      var fifthinschq = $("#fifth-chq-no-gst").val();
      var fifthinsbnk = $("#fifth-bnk-gst").val();
      var fifthinsbrn = $("#fifth-brn-gst").val();

      var sixthinsdt = $("#six-instl-dt-gst").val();
      var sixthinsamt = $("#txt_inst6_amt_gst").val();
      var sixthinschq = $("#sixth-chq-no-gst").val();
      var sixthinsbnk = $("#sixth-bnk-gst").val();
      var sixthinsbrn = $("#second-brn-gst").val();

      var pmode = $("#payment-mode-gst").val();
      var chqno = $("#chq-num-gst").val();
      var chqdt = $("#chq-date-gst").val();
      var bnkname = $("#bank-name-gst").val();
      var bnkbrn = $("#bank-branch-gst").val();
      var doneby = $("#done-by-gst").val();
      var isedt = $("#isedtGST").val();
      var mode = "PAYMENTGST";

      $.ajax({
        type: "POST",
        // url: "update_member_info_mdl.php",
        url: basepath + "memberinfo/updateMemberData",
        dataType: "html",
        data: {
          mode: mode,
          cid: cid,
          pid: pid,
          vmid: vmid,
          isedt: isedt,
          pmtDt: pmtDt,
          clbrn: colBrnch,
          rmksnego: remarksnego,
          paynw: paynw,
          due: txt_due,
          cgstRate: cgstRate,
          cgstAmt: cgstAmt,
          sgstRate: sgstRate,
          sgstAmt: sgstAmt,
          payble: txt_payable,
          finsdt: finsdt,
          finsamt: finsamt,
          finschqn: finschqn,
          finsbnk: finsbnk,
          finbrn: finbrn,
          secinsdt: secinsdt,
          secinsamt: secinsamt,
          secinschq: secinschq,
          secinsbnk: secinsbnk,
          secinsbrn: secinsbrn,
          thirdinsdt: thirdinsdt,
          thirdinsamt: thirdinsamt,
          thirdinschq: thirdinschq,
          thirdinsbnk: thirdinsbnk,
          thirdinsbrn: thirdinsbrn,
          fourinsdt: fourinsdt,
          fourinsamt: fourinsamt,
          fourinschq: fourinschq,
          fourinsbnk: fourinsbnk,
          fourinsbrn: fourinsbrn,
          fifthinsdt: fifthinsdt,
          fifthinsamt: fifthinsamt,
          fifthinschq: fifthinschq,
          fifthinsbnk: fifthinsbnk,
          fifthinsbrn: fifthinsbrn,
          sixthinsdt: sixthinsdt,
          sixthinsamt: sixthinsamt,
          sixthinschq: sixthinschq,
          sixthinsbnk: sixthinsbnk,
          sixthinsbrn: sixthinsbrn,
          pmode: pmode,
          chqno: chqno,
          chqdt: chqdt,
          bnkname: bnkname,
          bnkbrn: bnkbrn,
          doneby: doneby,
        },
        success: function (response) {
          if (response == 1) {
            $("#payment-upd-gst").css("display", "table-cell");
          }
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
          //  alert(msg);
        },
      });
    }
  });

  $(document).on("change", "#payment-mode", function () {
    var pmode = $(this).val();
    if (pmode == "Cheque") {
      var chqno = $("#hd-chq-num").val();
      var chqdt = $("#hd-chq-date").val();
      var chqbnk = $("#hd-bank-name").val();
      var chqbrn = $("#hd-bank-branch").val();

      $("#chq-num").val(chqno);
      $("#chq-date").val(chqdt);
      $("#bank-name").val(chqbnk);
      $("#bank-branch").val(chqbrn);
    } else {
      $("#chq-num").val("");
      $("#chq-date").val("");
      $("#bank-name").val("");
      $("#bank-branch").val("");
    }
  });

  $(document).on("change", "#payment-mode-gst", function () {
    var pmode = $(this).val();
    if (pmode == "Cheque") {
      var chqno = $("#hd-chq-num-gst").val();
      var chqdt = $("#hd-chq-date-gst").val();
      var chqbnk = $("#hd-bank-name-gst").val();
      var chqbrn = $("#hd-bank-branch-gst").val();

      $("#chq-num-gst").val(chqno);
      $("#chq-date-gst").val(chqdt);
      $("#bank-name-gst").val(chqbnk);
      $("#bank-branch-gst").val(chqbrn);
    } else {
      $("#chq-num-gst").val("");
      $("#chq-date-gst").val("");
      $("#bank-name-gst").val("");
      $("#bank-branch-gst").val("");
    }
  });
});

function validatePaymentInfo() {
  var paymentdt = $("#payment-dt").val();
  var paymntnow = $("#txt_payment_now").val();
  var due = $("#txt_due").val();
  var frst_ins_dt = $("#frst-inst-dt").val();
  var txt_inst1_amt = $("#txt_inst1_amt").val();
  var frst_chq_no = $("#frst-chq-no").val();
  var frst_bank = $("#frst-bank").val();
  var frst_brn = $("#frst-brn").val();
  var second_instl_dt = $("#second-instl-dt").val();
  var txt_inst2_amt = $("#txt_inst2_amt").val();
  var second_chq_no = $("#second-chq-no").val();
  var second_bnk = $("#second-bnk").val();
  var second_brn = $("#second-brn").val();
  var payment_mode = $("#payment-mode").val();
  var chq_num = $("#chq-num").val();
  var chq_date = $("#chq-date").val();
  var bank_name = $("#bank-name").val();
  var bank_branch = $("#bank-branch").val();

  $(
    "#payment-dt,#txt_payment_now,#txt_due,#frst-inst-dt,#txt_inst1_amt,#frst-chq-no,#frst-bank,#frst-brn,#second-instl-dt,#txt_inst2_amt,#second-chq-no,#second-bnk,#second-brn,#payment-mode,#chq-num,#chq-date,#bank-name,#bank-branch"
  ).removeClass("error-field");

  if (paymentdt == "") {
    alert("Enter Payment Date !!!");
    $("#payment-dt").addClass("error-field");
    return false;
  }
  if (paymntnow == "") {
    alert("Enter Payment Now Amount !!!");
    $("#txt_payment_now").addClass("error-field");
    return false;
  }
  if (paymntnow < 0) {
    alert("Payment Now Amount cann't be negative");
    $("#payment-dt").addClass("error-field");
    return false;
  }
  if (due < 0) {
    alert("Due amount cann't be negative");
    $("#txt_payment_now").addClass("error-field");
    return false;
  }
  if (due > 0) {
    if (txt_inst1_amt > 0) {
      if (frst_ins_dt == "") {
        alert("Select First Installment Date ");
        $("#frst-inst-dt").addClass("error-field");
        return false;
      }
      if (frst_chq_no == "") {
        alert("Enter first installment cheque number");
        $("#frst-chq-no").addClass("error-field");
        return false;
      }
      if (frst_bank == "") {
        alert("Enter first installment bank name");
        $("#frst-bank").addClass("error-field");
        return false;
      }
      if (frst_brn == "") {
        alert("Enter first installment branch name");
        $("#frst-brn").addClass("error-field");
        return false;
      }
    }

    if (txt_inst2_amt > 0) {
      if (second_instl_dt == "") {
        alert("Select second Installment Date ");
        $("#second-instl-dt").addClass("error-field");
        return false;
      }
      if (second_chq_no == "") {
        alert("Enter second installment cheque number");
        $("#second-chq-no").addClass("error-field");
        return false;
      }
      if (second_bnk == "") {
        alert("Enter second installment bank name");
        $("#second-bnk").addClass("error-field");
        return false;
      }
      if (second_brn == "") {
        alert("Enter second installment branch name");
        $("#second-brn").addClass("error-field");
        return false;
      }
    }
  }

  if (payment_mode == "Cheque") {
    if (chq_num == "") {
      alert("Enter cheque number");
      $("#chq-num").addClass("error-field");
      return false;
    }
    if (chq_date == "") {
      alert("Enter cheque date");
      $("#chq-date").addClass("error-field");
      return false;
    }
    if (bank_name == "") {
      alert("Enter Bank Name");
      $("#bank-name").addClass("error-field");
      return false;
    }
    if (bank_branch == "") {
      alert("Enter Branch Name");
      $("#bank-branch").addClass("error-field");
      return false;
    }
  }

  return true;
}

function validatePaymentInfoGST() {
  var paymentdt = $("#payment-dt-GST").val();
  var paymntnow = $("#txt_payment_now_GST").val();
  var due = $("#txt_due_GST").val();
  var frst_ins_dt = $("#frst-inst-dt-gst").val();
  var txt_inst1_amt = $("#txt_inst1_amt_gst").val();
  var frst_chq_no = $("#frst-chq-no-gst").val();
  var frst_bank = $("#frst-bank-gst").val();
  var frst_brn = $("#frst-brn-gst").val();
  var second_instl_dt = $("#second-instl-dt-gst").val();
  var txt_inst2_amt = $("#txt_inst2_amt_gst").val();
  var second_chq_no = $("#second-chq-no-gst").val();
  var second_bnk = $("#second-bnk-gst").val();
  var second_brn = $("#second-brn-gst").val();
  var payment_mode = $("#payment-mode-gst").val();
  var chq_num = $("#chq-num-gst").val();
  var chq_date = $("#chq-date-gst").val();
  var bank_name = $("#bank-name-gst").val();
  var bank_branch = $("#bank-branch-gst").val();

  $(
    "#payment-dt-GST,#txt_payment_now_GST,#txt_due_GST,#frst-inst-dt-gst,#txt_inst1_amt_gst,#frst-chq-no-gst,#frst-bank-gst,#frst-brn-gst,#second-instl-dt-gst,#txt_inst2_amt_gst,#second-chq-no-gst,#second-bnk-gst,#second-brn-gst,#payment-mode-gst,#chq-num-gst,#chq-date-gst,#bank-name-gst,#bank-branch-gst"
  ).removeClass("error-field");

  if (paymentdt == "") {
    alert("Enter Payment Date !!!");
    $("#payment-dt-GST").addClass("error-field");
    return false;
  }
  if (paymntnow == "") {
    alert("Enter Payment Now Amount !!!");
    $("#txt_payment_now_GST").addClass("error-field");
    return false;
  }
  if (paymntnow < 0) {
    alert("Payment Now Amount cann't be negative");
    $("#txt_payment_now_GST").addClass("error-field");
    return false;
  }
  if (due < 0) {
    alert("Due amount cann't be negative");
    $("#txt_payment_now_GST").addClass("error-field");
    return false;
  }
  if (due > 0) {
    if (txt_inst1_amt > 0) {
      if (frst_ins_dt == "") {
        alert("Select First Installment Date ");
        $("#frst-inst-dt-gst").addClass("error-field");
        return false;
      }
      if (frst_chq_no == "") {
        alert("Enter first installment cheque number");
        $("#frst-chq-no-gst").addClass("error-field");
        return false;
      }
      if (frst_bank == "") {
        alert("Enter first installment bank name");
        $("#frst-bank-gst").addClass("error-field");
        return false;
      }
      if (frst_brn == "") {
        alert("Enter first installment branch name");
        $("#frst-brn-gst").addClass("error-field");
        return false;
      }
    }

    if (txt_inst2_amt > 0) {
      if (second_instl_dt == "") {
        alert("Select second Installment Date ");
        $("#second-instl-dt-gst").addClass("error-field");
        return false;
      }
      if (second_chq_no == "") {
        alert("Enter second installment cheque number");
        $("#second-chq-no-gst").addClass("error-field");
        return false;
      }
      if (second_bnk == "") {
        alert("Enter second installment bank name");
        $("#second-bnk-gst").addClass("error-field");
        return false;
      }
      if (second_brn == "") {
        alert("Enter second installment branch name");
        $("#second-brn-gst").addClass("error-field");
        return false;
      }
    }
  }

  if (payment_mode == "Cheque") {
    if (chq_num == "") {
      alert("Enter cheque number");
      $("#chq-num-gst").addClass("error-field");
      return false;
    }
    if (chq_date == "") {
      alert("Enter cheque date");
      $("#chq-date-gst").addClass("error-field");
      return false;
    }
    if (bank_name == "") {
      alert("Enter Bank Name");
      $("#bank-name-gst").addClass("error-field");
      return false;
    }
    if (bank_branch == "") {
      alert("Enter Branch Name");
      $("#bank-branch-gst").addClass("error-field");
      return false;
    }
  }

  return true;
}

function memberViewOpt(opt) {
  if (opt == "MOBILE") {
    $(".mob_sect").css("display", "table-row");
    $(".date_sect").css("display", "none");
    $("#fromDt").val("");
    $("#toDate").val("");
    $("#sel_branch").val("0");
  }
  if (opt == "DATE") {
    $(".date_sect").css("display", "table-row");
    $(".mob_sect").css("display", "none");
    $("#txt_mobile_no").val("");
  }
}

function validatePersonalInfo(
  name,
  dob,
  email,
  bldgrp,
  trainer,
  pin,
  address,
  whatsupNum
) {
  var email_validate = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

  if (name == "") {
    alert("Name is required");
    $("#m-name").focus();
    return false;
  }
  if (dob == "") {
    alert("DOB is required");
    $("#m-dob").focus();
    return false;
  }
  if (email.length > 0) {
    if (email_validate.test(email) == false) {
      alert("Email is not valid");
      $("#m-email").focus();
      return false;
    }
  }
  if (whatsupNum != "" && whatsupNum.length < 10) {
    alert("Please Enter minimum 10 digit whatsApp no.");
    $("#whatsupNum").focus();
    return false;
  }
  if (bldgrp == "0") {
    alert("Select blood group");
    $("#m-bldgrp").focus();
    return false;
  }
  if (trainer == "0") {
    alert("Select trainer");
    $("#m-trainer").focus();
    return false;
  }
  if (pin == "") {
    alert("Pin is required");
    $("#m-pin").focus();
    return false;
  }
  if (address == "") {
    alert("Address is required");
    $("#m-address").focus();
    return false;
  }

  return true;
}

function showMember() {
  var mobileno = $("#txt_mobile_no").val();
  var frmDt = $("#fromDt").val();
  var toDt = $("#toDate").val();
  var branch = $("#sel_branch").val();
  /*
		alert("Mobile No "+mobileno);
		alert("frmDt "+frmDt);
		alert("toDt "+toDt);
		alert("branch"+branch);
		*/

  $("#ajaxLoadData").html("<center>Please wait loading...</center>");

  $.ajax({
    type: "POST",
    //url:'get_member_list_edit.php',
    url: basepath + "memberinfo/getMemberListEdit",
    dataType: "html",
    data: { mobileno: mobileno, frmDt: frmDt, toDt: toDt, branch: branch },
    success: function (response) {
      $("#ajaxLoadData").html(response);
      $("#example").dataTable();
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
      //  alert(msg);
    },
  });
}

/*-------Payment Cal--------*/
function getPayment() {
  var prm;
  var adm;
  var subs;
  var disc1;
  var disc2;
  var disc3;
  var cashbckamt;
  var payment = 0;

  subs = $("#txt_subscription").val();
  cashbckamt = $("#txt_cashbck").val();
  disc1 = $("#txt_disc_conv").val();
  disc2 = $("#txt_disc_offer").val();
  disc3 = $("#txt_disc_nego").val();

  $("#txt_premium").val(prm);

  if ($("#txt_disc_conv").val() == "") {
    disc1 = 0;
  }

  if ($("#txt_disc_offer").val() == "") {
    disc2 = 0;
  }

  if ($("#txt_disc_nego").val() == "") {
    disc3 = 0;
  }

  adm = 0;

  if ($("#txt_subscription").val() == "") {
    subs = 0;
  }
  prm =
    parseFloat(adm) +
    parseFloat(subs) -
    (parseFloat(disc1) +
      parseFloat(disc2) +
      parseFloat(disc3) +
      parseFloat(cashbckamt));

  $("#txt_premium").val(prm);
  $("#txt_payment_now").val(prm);
  var payment = $("#txt_payment_now").val() || 0;
  var txtdue = parseFloat(prm) - parseFloat(payment);
  $("#txt_due").val(txtdue);
  var txt_ins_amt1 = (parseFloat(prm) - parseFloat(payment)) / 2;
  var txt_ins_amt2 = (parseFloat(prm) - parseFloat(payment)) / 2;
  $("#txt_inst1_amt").val(txt_ins_amt1);
  $("#txt_inst2_amt").val(txt_ins_amt2);
  getTotal();
  return true;
}

function getTotal() {
  var tax = $("#txt_tax").val();
  var tax_amt;
  var paid = $("#txt_payment_now").val() || 0;
  var total;
  if (tax > 0) {
    tax_amt = (tax / 100) * paid;
    total = parseFloat(paid) + parseFloat(tax_amt);
  } else {
    total = paid;
  }
  $("#txt_payable").val(total);
  return true;
}

function getDue() {
  var prm = $("#txt_premium").val();
  var payment = $("#txt_payment_now").val() || 0;

  var due = parseFloat(prm) - parseFloat(payment);
  $("#txt_due").val(due);
  $("#txt_inst1_amt").val(due / 2);
  $("#txt_inst2_amt").val(due / 2);

  getTotal();
  return true;
}

function getAdjustment_1() {
  var due = $("#txt_due").val();
  var due_1 = $("#txt_inst1_amt").val();
  var txt_ins2_Amt = parseFloat(due) - parseFloat(due_1);
  $("#txt_inst2_amt").val(txt_ins2_Amt);
}

function getAdjustment_2() {
  var due = $("#txt_due").val();
  var due_2 = $("#txt_inst2_amt").val();
  var txt_inst2_Amt = parseFloat(due) - parseFloat(due_2);
  $("#txt_inst1_amt").val(txt_inst2_Amt);
}

function backtoList() {
  var mobileno = $("#txt_mobile_no").val();
  var frmDt = $("#fromDt").val();
  var toDt = $("#toDate").val();
  var branch = $("#sel_branch").val();
  /*
		alert("Mobile"+mobileno);
		alert("frmDt"+frmDt);
		alert("toDt"+toDt);
		alert("branch"+branch); */

  $.ajax({
    type: "POST",
    //url:'get_member_list_edit.php',
    url: basepath + "memberinfo/getMemberListEdit",
    dataType: "html",
    data: { mobileno: mobileno, frmDt: frmDt, toDt: toDt, branch: branch },
    success: function (response) {
      $("#ajaxLoadData").html(response);
      $("#example").dataTable();
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
      //  alert(msg);
    },
  });
}

/*-------Payment Cal--------*/
function getPaymentGST() {
  var prm;
  var adm;
  var subs;
  var disc1;
  var disc2;
  var disc3;
  var cashbckamt;
  var payment = 0;

  subs = $("#txt_subscription_GST").val();
  cashbckamt = $("#txt_cashbck_GST").val();
  disc1 = $("#txt_disc_conv_GST").val();
  disc2 = $("#txt_disc_offer_GST").val();
  disc3 = $("#txt_disc_nego_GST").val();

  $("#txt_premium_GST").val(prm);

  if ($("#txt_disc_conv_GST").val() == "") {
    disc1 = 0;
  }

  if ($("#txt_disc_offer_GST").val() == "") {
    disc2 = 0;
  }

  if ($("#txt_disc_nego_GST").val() == "") {
    disc3 = 0;
  }

  adm = 0;

  if ($("#txt_subscription_GST").val() == "") {
    subs = 0;
  }
  prm =
    parseFloat(adm) +
    parseFloat(subs) -
    (parseFloat(disc1) +
      parseFloat(disc2) +
      parseFloat(disc3) +
      parseFloat(cashbckamt));

  $("#txt_premium_GST").val(prm);
  $("#txt_payment_now_GST").val(prm);
  var payment = $("#txt_payment_now_GST").val() || 0;
  var txtdue = parseFloat(prm) - parseFloat(payment);
  $("#txt_due_GST").val(txtdue);
  var txt_ins_amt1 = (parseFloat(prm) - parseFloat(payment)) / 2;
  var txt_ins_amt2 = (parseFloat(prm) - parseFloat(payment)) / 2;
  $("#txt_inst1_amt_gst").val(txt_ins_amt1);
  $("#txt_inst2_amt_gst").val(txt_ins_amt2);
  getTotalGST();
  return true;
}

function getTotalGST() {
  var paid = document.getElementById("txt_payment_now_GST").value || 0;
  var total;
  var tax_amt1;
  var tax_amt2;

  var cgst = document.getElementById("cgstrate");
  var cgstrate = cgst.options[cgst.selectedIndex].text;

  var sgst = document.getElementById("sgstrate");
  var sgstrate = sgst.options[sgst.selectedIndex].text;

  if (cgstrate > 0) {
    tax_amt1 = (cgstrate / 100) * paid;
    document.getElementById("cgstAmount").value = parseFloat(
      tax_amt1.toFixed(2)
    );
  } else {
    tax_amt1 = 0;
    document.getElementById("cgstAmount").value = parseFloat(
      tax_amt1.toFixed(2)
    );
  }

  if (sgstrate > 0) {
    tax_amt2 = (sgstrate / 100) * paid;
    document.getElementById("sgstAmount").value = parseFloat(
      tax_amt2.toFixed(2)
    );
  } else {
    tax_amt2 = 0;
    document.getElementById("sgstAmount").value = parseFloat(
      tax_amt2.toFixed(2)
    );
  }

  total =
    parseFloat(paid) +
    parseFloat(tax_amt1.toFixed(2)) +
    parseFloat(tax_amt2.toFixed(2));

  document.getElementById("txt_payable_GST").value = total.toFixed(2);

  return true;
}

function getDueGST() {
  var prm = $("#txt_premium_GST").val();
  var payment = $("#txt_payment_now_GST").val() || 0;

  var due = parseFloat(prm) - parseFloat(payment);
  $("#txt_due_GST").val(due);
  $("#txt_inst1_amt_gst").val(due / 2);
  $("#txt_inst2_amt_gst").val(due / 2);

  getTotalGST();
  return true;
}

function getAdjustmentGST_1() {
  var due = $("#txt_due_GST").val();
  var due_1 = $("#txt_inst1_amt_gst").val();
  var txt_ins2_Amt = parseFloat(due) - parseFloat(due_1);
  $("#txt_inst2_amt_gst").val(txt_ins2_Amt);
}

function getAdjustmentGST_2() {
  var due = $("#txt_due_GST").val();
  var due_2 = $("#txt_inst2_amt_gst").val();
  var txt_inst2_Amt = parseFloat(due) - parseFloat(due_2);
  $("#txt_inst1_amt_gst").val(txt_inst2_Amt);
}

function numericFilter(txb) {
  txb.value = txb.value.replace(/[^\0-9]/gi, "");
}
