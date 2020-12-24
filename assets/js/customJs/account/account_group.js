$(document).ready(function () {
  basepath = $("#basepath").val();

  $("#accountgrouplist").DataTable({
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
        .columns([2, 3])
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

  $("#accountgrouplist tfoot tr").insertAfter($("#accountgrouplist thead tr"));

  $(document).on("click", ".groupstatus", function () {
    var uid = $(this).data("groupid");
    var status = $(this).data("setstatus");
    var url = basepath + "accountgroup/setStatus";
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

  $(document).on("click", "#accgroupsavebtn", function (event) {
    event.preventDefault();

    if (valiadateform()) {
      var groupname = $("#groupname").val();
      var sel_grp_cat1 = $("#sel_grp_cat1").val();
      var sel_grp_cat2 = $("#sel_grp_cat2").val();
      var mode = $("#mode").val();
      var groupId = $("#groupId").val();
      $("#loaderbtn").show();
      $("#accgroupsavebtn").hide();
      var formData = {
        sel_grp_cat1: sel_grp_cat1,
        sel_grp_cat2: sel_grp_cat2,
        groupname: groupname,
        mode: mode,
        groupId: groupId,
      };
      var method = "accountgroup/accountgroup_action";
      var result = ajaxcallcontrollerforcutom(method, formData);

      if (result.msg_status == "1") {
        $("#loaderbtn").hide();
        $("#accgroupsavebtn").show();
        window.location.href = basepath + "accountgroup";
      } else {
      }
    }
  });

  $(document).on("keyup", "#groupname", function (e) {
    e.preventDefault();
    var groupname = $("#groupname").val();
    var mode = $("#mode").val();
    var groupId = $("#groupId").val();
    var formData = {
      groupname: groupname,
      mode: mode,
      groupId: groupId,
    };
    var method = "accountgroup/checkGroupName";
    var result = ajaxcallcontrollerforcutom(method, formData);
    if (result.msg_status == "0") {
      $("#group_name_err").text(result.msg_data);
      $("#accgroupsavebtn").hide();
    } else {
      $("#group_name_err").text("");
      $("#accgroupsavebtn").show();
    }
  });
}); /* end of document ready */

function valiadateform() {
  var groupname = $("#groupname").val();
  var sel_grp_cat1 = $("#sel_grp_cat1").val();
  var sel_grp_cat2 = $("#sel_grp_cat2").val();

  $("#errormsg").text("");
  $("#groupname,#first_cat_drp,#second_cat_drp").removeClass("form_error");

  if (groupname == "") {
    $("#groupname").addClass("form_error");
    return false;
  }

  if (sel_grp_cat1 == "0") {
    $("#first_cat_drp").addClass("form_error");
    return false;
  }

  if (sel_grp_cat2 == "0") {
    $("#second_cat_drp").addClass("form_error");
    return false;
  }

  return true;
}
