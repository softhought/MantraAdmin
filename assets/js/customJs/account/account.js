$(document).ready(function () {
  basepath = $("#basepath").val();

  $("#accountlist").DataTable({
    orderCellsTop: true,
    language: {
      search: "_INPUT_",
      searchPlaceholder: "Search...",
    },
    aoColumnDefs: [
      {
        bSortable: false,
        aTargets: [-1, -2] /* 1st one, start by the right */,
      },
    ],

    initComplete: function () {
      this.api()
        .columns([2])
        .every(function () {
          var column = this;
          var select = $(
            '<select class="form_input_text form-control select2"><option value="">Show all</option></select>'
          )
            .appendTo($(column.footer()).empty())
            .on("change", function () {
              var val = $.fn.dataTable.util.escapeRegex($(this).val());
              column.search(val ? "^" + val + "$" : "", true, false).draw();
            });

          column
            .data()
            .unique()
            .sort()
            .each(function (d, j) {
              select.append('<option value="' + d + '">' + d + "</option>");
            });
        });
    },
  });

  $("#accountlist tfoot tr").insertAfter($("#accountlist thead tr"));

  $(document).on("click", ".accountstatus", function () {
    var uid = $(this).data("accountid");
    var status = $(this).data("setstatus");
    var url = basepath + "account/setStatus";
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

  $(document).on("click", "#accountsavebtn", function (event) {
    event.preventDefault();

    if (valiadateform()) {
      var account_name = $("#account_name").val();
      var opening_balance = $("#opening_balance").val();
      var select_sub_group = $("#select_sub_group").val();
      var account_addr = $("#account_addr").val();
      var select_state = $("#select_state").val();
      var gst_in = $("#gst_in").val();
      var pan_no = $("#pan_no").val();
      var mode = $("#mode").val();
      var accountId = $("#accountId").val();
      $("#loaderbtn").show();
      $("#accountsavebtn").hide();
      var formData = {
        account_name: account_name,
        select_sub_group: select_sub_group,
        opening_balance: opening_balance,
        account_addr: account_addr,
        select_state: select_state,
        gst_in: gst_in,
        pan_no: pan_no,
        mode: mode,
        accountId: accountId,
      };
      // console.log(formData);
      var method = "account/account_action";
      var result = ajaxcallcontrollerforcutom(method, formData);

      if (result.msg_status == "1") {
        $("#loaderbtn").hide();
        $("#accountsavebtn").show();
        window.location.href = basepath + "account";
      } else {
      }
    }
  });

  $(document).on("keyup", "#account_name", function (e) {
    e.preventDefault();
    var account_name = $("#account_name").val();
    var mode = $("#mode").val();
    var accountId = $("#accountId").val();
    var formData = {
      account_name: account_name,
      mode: mode,
      accountId: accountId,
    };
    var method = "account/checkAccountName";
    var result = ajaxcallcontrollerforcutom(method, formData);
    if (result.msg_status == "0") {
      $("#account_name_err").text(result.msg_data);
      $("#accountsavebtn").hide();
    } else {
      $("#account_name_err").text("");
      $("#accountsavebtn").show();
    }
  });
}); /* end of document ready */

function valiadateform() {
  var account_name = $("#account_name").val();
  var select_sub_group = $("#select_sub_group").val();

  $("#errormsg").text("");
  $("#account_name,#sub_group_err").removeClass("form_error");

  if (account_name == "") {
    $("#account_name").addClass("form_error");
    return false;
  }

  if (select_sub_group == "0") {
    $("#sub_group_err").addClass("form_error");
    return false;
  }

  return true;
}
