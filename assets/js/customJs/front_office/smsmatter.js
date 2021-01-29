$(document).ready(function () {
  basepath = $("#basepath").val();

  $("#smsmatterlist").DataTable({
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
        .columns([1])
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

  $("#smsmatterlist tfoot tr").insertAfter($("#smsmatterlist thead tr"));

  $(document).on("click", ".smsstatus", function () {
    var uid = $(this).data("smsid");
    var status = $(this).data("setstatus");
    var url = basepath + "smsmatter/setStatus";
    setActiveStatus(uid, status, url);
  });

  $(document).on("click", "#smsmattersavebtn", function (event) {
    event.preventDefault();

    if (valiadateform()) {
      var sms_title = $("#sms_title").val();
      var sms_matter = $("#sms_matter").val();
      var smsmatterId = $("#smsmatterId").val();
      var mode = $("#mode").val();

      $("#loaderbtn").show();
      $("#smsmattersavebtn").hide();
      var formData = {
        sms_title: sms_title,
        sms_matter: sms_matter,
        mode: mode,
        smsmatterId: smsmatterId,
      };
      // console.log(formData);
      var method = "smsmatter/smsmatter_action";
      var result = ajaxcallcontrollerforcutom(method, formData);

      if (result.msg_status == "1") {
        $("#loaderbtn").hide();
        $("#smsmattersavebtn").show();
        window.location.href = basepath + "smsmatter";
      } else {
      }
    }
  });
}); /* end of document ready */

function valiadateform() {
  var sms_title = $("#sms_title").val();
  var sms_matter = $("#sms_matter").val();

  $("#errormsg").text("");
  $("#sms_title,#sms_matter").removeClass("form_error");

  if (sms_title == "") {
    $("#sms_title").addClass("form_error");
    return false;
  }

  if (sms_matter == "") {
    $("#sms_matter").addClass("form_error");
    return false;
  }

  return true;
}
