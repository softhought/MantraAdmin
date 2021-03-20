$(document).ready(function () {
  basepath = $("#basepath").val();

  $("#corporatecompanylist").DataTable();

  $(document).on("click", ".videostatus", function () {
    var uid = $(this).data("videoid");
    var status = $(this).data("setstatus");
    var url = basepath + "youtubevideo/setStatus";
    setActiveStatus(uid, status, url);
  });

  $(document).on("click", "#videosavebtn", function (event) {
    event.preventDefault();

    if (valiadateform()) {
      var video_title = $("#video_title").val();
      var video_url = $("#video_url").val();
      var show_tag = $("#show_tag").val();
      var mode = $("#mode").val();
      var videoId = $("#videoId").val();
      $("#loaderbtn").show();
      $("#videosavebtn").hide();
      var formData = {
        video_title: video_title,
        video_url: video_url,
        show_tag: show_tag,
        mode: mode,
        videoId: videoId,
      };
      // console.log(formData);
      var method = "youtubevideo/video_action";
      var result = ajaxcallcontrollerforcutom(method, formData);

      if (result.msg_status == "1") {
        $("#loaderbtn").hide();
        $("#videosavebtn").show();
        window.location.href = basepath + "youtubevideo";
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
  var video_title = $("#video_title").val();
  var video_url = $("#video_url").val();

  $("#errormsg").text("");
  $("#video_title,#video_url").removeClass("form_error");

  if (video_title == "") {
    $("#video_title").addClass("form_error");
    return false;
  }

  if (video_url == "") {
    $("#video_url").addClass("form_error");
    return false;
  }

  return true;
}
