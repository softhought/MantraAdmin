$(document).ready(function () {
  basepath = $("#basepath").val();

  $("#emailmatterlist").DataTable({
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

  $("#emailmatterlist tfoot tr").insertAfter($("#emailmatterlist thead tr"));

  $(document).on("click", ".emailstatus", function () {
    var uid = $(this).data("emailid");
    var status = $(this).data("setstatus");
    var url = basepath + "emailmatter/setStatus";
    setActiveStatus(uid, status, url);
  });

  $(document).on("click", "#emailmattersavebtn", function (event) {
    event.preventDefault();

    if (valiadateform()) {
      var email_title = $("#email_title").val();
      var email_matter = $("#email_matter").val();
      var emailmatterId = $("#emailmatterId").val();
      var mode = $("#mode").val();

      $("#loaderbtn").show();
      $("#emailmattersavebtn").hide();
      var formData = {
        email_title: email_title,
        email_matter: email_matter,
        mode: mode,
        emailmatterId: emailmatterId,
      };
      // console.log(formData);
      var method = "emailmatter/emailmatter_action";
      var result = ajaxcallcontrollerforcutom(method, formData);

      if (result.msg_status == "1") {
        $("#loaderbtn").hide();
        $("#emailmattersavebtn").show();
        window.location.href = basepath + "emailmatter";
      } else {
      }
    }
  });
}); /* end of document ready */

function valiadateform() {
  var email_title = $("#email_title").val();
  var email_matter = $("#email_matter").val();

  $("#errormsg").text("");
  $("#email_title,#email_matter").removeClass("form_error");

  if (email_title == "") {
    $("#email_title").addClass("form_error");
    return false;
  }

  if (email_matter == "") {
    $("#email_matter").addClass("form_error");
    return false;
  }

  return true;
}
