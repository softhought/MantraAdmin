$(document).ready(function () {
  basepath = $("#basepath").val();

  $("#accountsubgrouplist").DataTable({
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

  $("#accountsubgrouplist tfoot tr").insertAfter(
    $("#accountsubgrouplist thead tr")
  );

  $(document).on("click", ".subgroupstatus", function () {
    var uid = $(this).data("subgroupid");
    var status = $(this).data("setstatus");
    var url = basepath + "accountsubgroup/setStatus";
    setActiveStatus(uid, status, url);
  });

  $(document).on("click", "#subgroupsavebtn", function (event) {
    event.preventDefault();

    if (valiadateform()) {
      var subgroupname = $("#subgroupname").val();
      var sel_group = $("#sel_group").val();
      var mode = $("#mode").val();
      var subgroupId = $("#subgroupId").val();
      $("#loaderbtn").show();
      $("#subgroupsavebtn").hide();
      var formData = {
        sel_group: sel_group,
        subgroupname: subgroupname,
        mode: mode,
        subgroupId: subgroupId,
      };
      var method = "accountsubgroup/accountsubgroup_action";
      var result = ajaxcallcontrollerforcutom(method, formData);

      if (result.msg_status == "1") {
        $("#loaderbtn").hide();
        $("#subgroupsavebtn").show();
        window.location.href = basepath + "accountsubgroup";
      } else {
      }
    }
  });

  $(document).on("keyup", "#subgroupname", function (e) {
    e.preventDefault();
    var subgroupname = $("#subgroupname").val();
    var mode = $("#mode").val();
    var subgroupId = $("#subgroupId").val();
    var formData = {
      subgroupname: subgroupname,
      mode: mode,
      subgroupId: subgroupId,
    };
    var method = "accountsubgroup/checkSubGroupName";
    var result = ajaxcallcontrollerforcutom(method, formData);
    if (result.msg_status == "0") {
      $("#subgroup_name_err").text(result.msg_data);
      $("#subgroupsavebtn").hide();
    } else {
      $("#subgroup_name_err").text("");
      $("#subgroupsavebtn").show();
    }
  });
}); /* end of document ready */

function valiadateform() {
  var subgroupname = $("#subgroupname").val();
  var sel_group = $("#sel_group").val();

  $("#errormsg").text("");
  $("#subgroupname,#sel_group_err").removeClass("form_error");

  if (subgroupname == "") {
    $("#subgroupname").addClass("form_error");
    return false;
  }

  if (sel_group == "0") {
    $("#sel_group_err").addClass("form_error");
    return false;
  }

  return true;
}
