$(document).ready(function () {
  var Toast = Swal.mixin({
    toast: true,
    position: "bottom-end",
    showConfirmButton: false,
    timer: 4000,
  });
  $(document).on("click", "#keeploogedin", function (event) {
    var mode = "any";
    var formData = {
      mode: mode,
    };
    var method = "diet/setSessionToCookie";
    var data = ajaxcallcontrollerforcutom(method, formData);
    if (data.msg_status == 1) {
      $("#keeploogedin").removeClass("badge-danger");
      $("#keeploogedin").addClass("badge-success");
      $("#keeploogedin").html("Active login for today");
    }
  });
  $("#bottom-remaining-info").draggable();
  $(".predMeal").removeClass("dnclk");
  basepath = $("#basepath").val();
  $("#maincontainer").removeClass("container");
  $("#maincontainer").addClass("container-fluid");

  mode = $("#mode").val();
  if (mode == "EDIT") {
    $(".predMeal").removeClass("dnclk");
    var mobile = $("#mobile").val();
    var member_acc_code = $("#hidden_mmno").val();
    var selected_diseaseId = $("#dtl_diseaseValues").val();
    var selected_attr = selected_diseaseId.split(",");
    // console.log(selected_attr);
    $("#disease_adviceid").val(selected_attr).change();

    var selected_videoId = $("#dtl_youtubeValues").val();
    var selected_attr2 = selected_videoId.split(",");
    $("#youtube_videoid").val(selected_attr2).change();

    $("#ritht_top_row").css("background-image", "none");
    $("#ritht_top_row").css("opacity", 1);
    $("#calresult").css("display", "table-cell");
    $("#member_reg_info").show();
    $("#member_blood_div").show();

    memberMedicalInfo(mobile);
    memberBloodTest(member_acc_code);

    var meal_approach = $("#meal_approach").val();
    if (meal_approach == 3) {
      $(
        "#meal_approach_sub_opt_div,#meal_approach_sub_opt_dtl_div,#carbs_zig_zag_row"
      ).css("display", "table-row");
      $("#add_reduce_calorie_row").css("display", "none");
      $("#need_factor_row").css("display", "table-row");
      $("#calrecalOpt").val(0);
      $("#geivencal").val(0);
    }

    enableDisableFieldValue(meal_approach);
  } /* end of edit mode */

  $(document).on("click", "#bloodSave_btn", function (event) {
    var collectiont_dt = $("#collectiont_dt").val();
    var sel_blood_test = $("#sel_blood_test").val();
    var txtQty = $("#txtQty").val();
    var membership_no = $("#membership_no").val();
    var member_acc_code = $("#hidden_mmno").val();
    var mobile = $("#mobile").val();
    var test_notes = $("#test_notes").val();
    $("#collectiont_dt,#sel_blood_testerr,#txtQty").removeClass("form_error");
    if (collectiont_dt == "") {
      $("#collectiont_dt").addClass("form_error");
      $("#collectiont_dt").focus();
      return false;
    }
    if (sel_blood_test == "") {
      $("#sel_blood_testerr").addClass("form_error");
      $("#sel_blood_test").focus();
      return false;
    }
    if (txtQty == "") {
      $("#txtQty").addClass("form_error");
      $("#txtQty").focus();
      return false;
    }
    $("#bloodSave_btn").attr("disabled", true);
    $("#msg_blood").html("");
    var formData = {
      collectiont_dt: collectiont_dt,
      sel_blood_test: sel_blood_test,
      txtQty: txtQty,
      membership_no: membership_no,
      member_acc_code: member_acc_code,
      mobile: mobile,
      test_notes: test_notes,
    };
    var method = "diet/bloodtest_action";
    var data = ajaxcallcontrollerforcutom(method, formData);
    if (data.msg_status == 1) {
      memberBloodTest(member_acc_code);
      // $("#showAddTest").click();
      $(".showAddTest").trigger("click");
      $("#msg_blood").html(data.msg_data);
    } else {
    }
  });

  $(document).on("click", ".showAddTest", function (event) {
    $("#add_test_div").show();
    $(".showTestList").show();
    $("#test_list_div").hide();
    $(".showAddTest").hide();
    $(".select2").select2();
  });

  $(document).on("click", ".showTestList", function (event) {
    $("#add_test_div").hide();
    $(".showTestList").hide();
    $("#test_list_div").show();
    $(".showAddTest").show();
  });

  $(document).on("click", ".predMeal", function (event) {
    event.stopImmediatePropagation();
    var Dtlid = $(this).attr("id");
    var divno = Dtlid.split("meal");
    var collapse_id = divno[1];
    for (var i = 1; i <= 11; i++) {
      $("#collapse_" + i).removeClass("show");
    }
    $("#collapse_" + collapse_id).addClass("show");
  });

  $(document).on("change", "#sel_blood_test", function (event) {
    event.stopImmediatePropagation();
    // var unitdesc = $("#sel_blood_test").data("unitdesc");
    // $("#sel_blood_test_unit").val(unitdesc);
    $("#sel_blood_test_unit").val(
      $("#sel_blood_test option:selected").attr("data-unitdesc")
    );
    // alert($("#sel_blood_test option:selected").attr("data-unitdesc"));
  });

  $(document).on("click", ".advAccor", function (event) {
    event.stopImmediatePropagation();
    var collapse_id = $(this).attr("id");
    var collapse_ids = $("#advide_count").val();
    for (var i = 0; i < collapse_ids; i++) {
      $("#collapseAdv_" + i).removeClass("show");
    }
    $("#collapseAdv_" + collapse_id).addClass("show");
  });

  $(document).on("keyup", "#mobile", function (event) {
    event.preventDefault();
    event.stopImmediatePropagation();
    $("#gender").val("");

    resetCalculation();
    $("#member_reg_info").hide();
    $("#member_dietinfo_div").hide();
    $("#member_info_div").hide();
    $("#member_blood_div").hide();
    var mobile = $(this).val();
    var len = mobile.length;

    if (len == 10) {
      $("#meminfo").css("display", "none");
      $("#weight,#waist").val("");
      $("mem_vegnonveg").html("");
      var formData = {
        mobile: mobile,
      };
      var method = "diet/getMemberInformation";
      var data = ajaxcallcontrollerforcutom(method, formData);
      if (data.msg_status == 1) {
        $(".saveMeal").show();
        $("#ritht_top_row").css("background-image", "none");
        $("#ritht_top_row").css("opacity", 1);
        $("#member_reg_info").show();
        $("#member_blood_div").show();
        $("#member_dietinfo_div").show();
        if (data.diet == "Veg") {
          $("#mem_vegnonveg").html(
            '<span class="badge badge-success">Vegetarian</span>'
          );
        } else if (data.diet == "Non-Veg") {
          $("#mem_vegnonveg").html(
            '<span class="badge badge-danger">Non Vegetarian</span>'
          );
        }

        $("#member_info_div").show();
        $("#calculate_btn").show();
        $("#mem_info_name").html(data.cusname);
        $("#mem_info_code").html(data.membership);
        $("#mem_info_card").html(data.card);
        $("#mem_info_validity").html(data.validity);
        $("#mem_info_act").html(data.status);

        $("#membership_no").val(data.membership);
        $("#gender").val(data.gender);
        $("#dob").val(data.dob);
        $("#hidden_mmno").val(data.member_acc_code);
        memberMedicalInfo(mobile);
        memberBloodTest(data.member_acc_code);
      } else {
        $("#member_blood_div").hide();
        $("#member_reg_info").hide();
        $("#member_blood_div").hide();
        $("#member_dietinfo_div").hide();
        $("#member_info_div").hide();
        $("#calculate_btn").hide();
        $(".saveMeal").hide();
      }
    } else {
      $("#mem_dtl").html("");
      $("#meminfo").css("display", "none");
      $(".saveMeal").hide();
    }
  });

  $(document).on("change", "#activity_lvl", function () {
    // resetCalculation();
    var activityID = $(this).val();
    //alert($(this).data("acdesc"));

    $("#activity_desc").val($(this).find(":selected").data("acdesc"));
  });

  $(document).on("keyup", "#geivencal", function () {
    finalCalorieCal();
  });

  // Reset all values
  $(document).on("keyup", "#weight,#waist", function () {
    resetCalculation();
  });

  $(document).on("click", "#calculate_btn", function () {
    calCalorieReq();
  });

  $(document).on("change", "#calculate_by", function () {
    var calculate_by = $("#calculate_by").val();
    $("#member_hav_div_data").html("");
    resetCalculation();
    var mobile = $("#mobile").val();
    $("#weight,#waist").val("");
    $("#errormsg1").text("");
    if (calculate_by == "R") {
      $("#weight").prop("readonly", false);
      $("#waist").prop("readonly", false);
      $("#member_hav_div").hide();
    } else {
      memberHavData(mobile);
      $("#weight").prop("readonly", true);
      $("#waist").prop("readonly", true);
      var formData = {
        mobile: mobile,
      };
      var method = "diet/getHavWeight";
      var data = ajaxcallcontrollerforcutom(method, formData);
      if (data.msg_status == 1) {
        $("#weight").val(data.weight);
        $("#waist").val(data.waist);
      } else {
        $("#errormsg1").text(data.msg_data);
      }
    }
  });

  $(document).on("change", "#disease_adviceid", function (event) {
    event.stopImmediatePropagation();

    var diseaseIDs = [];

    $.each($("#disease_adviceid option:selected"), function () {
      diseaseIDs.push($(this).val());
    });
    if (diseaseIDs.length != 0) {
      $("#diet_disease").html("<center>Disease advice loading.... </center>");
      $("#dtl_diseaseValues").val(diseaseIDs.toString());
      var formData = {
        diseaseIDs: diseaseIDs,
      };
      var method = "diet/getDietDiseaseAdvice";
      var data = htmlshowajaxcomtroller(method, formData);
      $("#diet_disease").html(data);
    } else {
      $("#diet_disease").html("<br>");
    }
  });

  $(document).on("change", "#youtube_videoid", function (event) {
    event.stopImmediatePropagation();

    var videoIDs = [];

    $.each($("#youtube_videoid option:selected"), function () {
      videoIDs.push($(this).val());
    });
    if (videoIDs.length != 0) {
      $("#youtube_video_thumb").html(
        "<center>Youtube Video loading.... </center>"
      );
      $("#dtl_youtubeValues").val(videoIDs.toString());
      var formData = {
        videoIDs: videoIDs,
      };
      var method = "diet/getYoutubeVideo";
      var data = htmlshowajaxcomtroller(method, formData);
      $("#youtube_video_thumb").html(data);
    } else {
      $("#youtube_video_thumb").html("<br>");
    }
  });

  $("#flip").click(function () {
    $("#panel").slideToggle("slow");
  });
  /*------------------------------------------------------------------------------- */
  /*------------Model minimize Added on 20.06.2018 by shankha-----------*/

  var $content, $modal, $apnData, $modalCon;

  $content = $(".min");

  //To fire modal
  $(".mdlFire").click(function (e) {
    e.preventDefault();

    var $id = $(this).attr("data-target");

    $($id).modal({ backdrop: false, keyboard: false });
  });

  $(".modalMinimize").on("click", function () {
    $modalCon = $(this).closest(".mymodal").attr("id");

    $apnData = $(this).closest(".mymodal");

    $modal = "#" + $modalCon;

    $(".modal-backdrop").addClass("display-none");

    $($modal).toggleClass("min");

    if ($($modal).hasClass("min")) {
      $(".minmaxCon").append($apnData);

      $(this)
        .find("i")
        .toggleClass("fa-arrow-circle-down")
        .toggleClass("fa-clone");
    } else {
      $(".container").append($apnData);

      $(this)
        .find("i")
        .toggleClass("fa-clone")
        .toggleClass("fa-arrow-circle-down");
    }
  });

  $("button[data-dismiss='modal']").click(function () {
    $(this).closest(".mymodal").removeClass("min");

    $(".container").removeClass($apnData);

    $(this)
      .next(".modalMinimize")
      .find("i")
      .removeClass("fa fa-clone")
      .addClass("fa fa-minus");
  });

  /*--------------End of Model minimize---------------------*/
  var row = 1;
  var otherAssistanceRow = 1;
  //toggle the component with class accordion_body
  var icons = {
    header: "ui-icon-plus",
    activeHeader: " ui-icon-minus",
  };
  // $("#accordion").accordion({
  //   icons: icons,
  //   collapsible: true,
  //   active: false,
  // });

  $("#toggle")
    .button()
    .on("click", function () {
      if ($("#accordion").accordion("option", "icons")) {
        $("#accordion").accordion("option", "icons", null);
      } else {
        $("#accordion").accordion("option", "icons", icons);
      }
    });

  $(".mealTime").timepicker();
  //$(".food_select").selectpicker();
  //$("#test").customselect();

  $(document).on("click", ".saveMeal", function () {
    var dietitian_id = $("#dietitian_id").val();
    var mobile = $("#mobile").val();
    var mode = $("#mode").val();
    $("#errormsg1").text("");
    if (mobile == "") {
      //alert("Please Enter Mobile No");
      $("#errormsg1").text("Please Enter Mobile No");
      $("#mobile").addClass("form_error");
      $("#mobile").focus();
      return false;
    }

    if (dietitian_id == "0") {
      alert("Select Dietitian");
      return false;
    }
    var totalDetails = 0;
    $(".calorieGiven").each(function () {
      totalDetails += 1;
    });

    if (totalDetails == 0) {
      // $("#response_msg").text("Add Meal details");
      alert("Add Meal details");
      return false;
    }

    var totalCalorieReq = $("#final_cal_req").val();
    var totalCalorieGiven = $("#totalCalorie").val();
    var saveData = false;

    if (parseFloat(totalCalorieGiven) > parseFloat(totalCalorieReq)) {
      saveData = false;
      var r = confirm(
        "Calorie given by you is gretare than calorie requirement.Do You want to save."
      );

      if (r == true) {
        saveData = true;
      } else {
        saveData = false;
      }
    } else {
      saveData = true;
    }

    if (saveData == true) {
      var formData = $("#prepareDietForm").serialize();
      formData = decodeURI(formData);
      $(".saveMeal").attr("disabled", true);
      $.ajax({
        type: "POST",
        url: basepath + "diet/diet_action",
        dataType: "json",
        data: { formData: formData },
        success: function (res) {
          console.log(res);
          if (res.msg_status == 1) {
            $(".saveMeal").attr("disabled", false);

            if (mode == "ADD") {
              // alert("Meal Saved successfully");
              Toast.fire({
                type: "success",
                title: "Meal Saved successfully",
              });

              // location.reload();
              window.location.href =
                basepath + "diet/preparediet/" + res.mealID;
            } else {
              playaudio();
              Toast.fire({
                type: "success",
                title: "Meal Updated successfully",
              });

              // location.reload();
            }

            //location.reload();
          } else {
            alert("Please Calculate Calorie Requirement");
            $(".saveMeal").attr("disabled", false);
            return false;
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

  /**Dietry Management Popup	**/
  $(document).on("click", ".dietry-managment-popup", function () {
    var membership = $("#membership_no").val();

    $.ajax({
      type: "POST",
      url: "get_dietry_managment_list_view.php",
      dataType: "html",
      data: { membership: membership },
      success: function (res) {
        $("#listView").html(res);
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

  /**BMR List Popup	**/
  $(document).on("click", ".bmr-list-popup", function () {
    var membership = $("#membership_no").val();
    var mobile = $("#mobile").val();
    $("#dietryDetlView").html("");

    $.ajax({
      type: "POST",
      url: "get_bmr_list_view.php",
      dataType: "html",
      data: { membership: membership },
      success: function (res) {
        $("#memno").text(mobile);
        $("#bmrListView").html(res);
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

  /**
   * add on 09.06.2018 by shankha
   */
  /**Dietery View Chart	**/
  $(document).on("click", ".dietry_view_chart", function () {
    var membership = $(this).data("membershipno");
    var mealmasterid = $(this).data("mealmasterid");

    $("#dietary-loader").css("display", "block");
    $("#dietryDetlView").html("");
    $.ajax({
      type: "POST",
      url: "new_diet_meal_detail_view.php",
      dataType: "html",
      data: { membership: membership, mealmasterid: mealmasterid },
      success: function (res) {
        $("#dietary-loader").css("display", "none");
        $("#dietryDetlView").html(res);
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
  //------------------------------------------------------------------------

  $(document).on("change", "#meal-approach-sub-opt", function () {
    var meal_sub_approch_id = $("#meal-approach-sub-opt").val();

    $(
      "#final_cal_req_zig_zag,#carbo_per_zigzag,#carbo_cal_zigzag,#carbo_gram_zigzag"
    ).val(0);

    if (meal_sub_approch_id == "0") {
      finalCalorieCal();
      $("#carbo_per,#fat_per").attr("readonly", false);
      $(
        "#final_cal_req_zig_zag,#carbo_per_zigzag,#carbo_cal_zigzag,#carbo_gram_zigzag"
      ).val(0);
      $("#carbs_zig_zag_row").css("display", "none");
      $("#meal-approach-sub-detail-opt").val(0).select2();
    } else {
      MealApproachSubDetailOptions(meal_sub_approch_id);
    }
  });

  $(document).on("change", "#meal-approach-sub-detail-opt", function () {
    var meal_sub_approch_dtl_id = $("#meal-approach-sub-detail-opt").val();
    if (meal_sub_approch_dtl_id == "0") {
      finalCalorieCal();
      $("#carbo_gram,#fat_gram").attr("readonly", false);
      $(
        "#final_cal_req_zig_zag,#carbo_per_zigzag,#carbo_cal_zigzag,#carbo_gram_zigzag"
      ).val(0);

      $("#carbs_zig_zag_row").css("display", "none");

      var cgram = $("#carbo_gram").val();
      // $("#carbs-req-bottom").text(carbo - gram + " gm");
    } else {
      calculateZigZagCalorieVal(meal_sub_approch_dtl_id); // For Zig-Zag Calorie Req
    }
  });

  // Need Factor Protein Calculator For Zig Zag Approach

  $(document).on("change", "#need_factor", function () {
    var nedd_fact_id = $(this).val(); // Need Factor ID
    var weight = $("#weight").val(); // Weight in Kgs
    var bfpercen = $("#bFatPercentage").val(); // Body Fat Percentage
    ProteinCalculator(nedd_fact_id, weight, bfpercen);
  });

  //On change Add Or Reduce Calori
  $(document).on("change", "#calrecalOpt", function () {
    var add_or_reduce = $(this).val();
    if (add_or_reduce != "0") {
      var sign = "";
      if (add_or_reduce == "ADD") {
        sign = "+";
      }
      if (add_or_reduce == "SUB") {
        sign = "-";
      }

      var prv_cal = $("#calorieReqOrg").val();
      $("#prv_cal_txt").text(prv_cal);
      $("#cal_opr").text(sign);
    } else {
      var prv_cal = $("#calorieReqOrg").val();
      $("#prv_cal_txt").text("Calorie Requirement");
      $("#cal_opr").text("?");
      $("#geivencal").val(0);
      $("#recalCalVal").text(prv_cal);
      $("#finalcalReq").text(prv_cal);
      $("#calorie-req-bottom").text(prv_cal);
      $("#final_cal_req").val(prv_cal);
    }
    finalCalorieCal();
    globalCalorieDistribution();
  });

  // Approach Selection

  $(document).on("change", "#meal_approach", function () {
    var meal_approach = $(this).val();
    //var app = getMealApproachCode(approachID);
    //	var meal_approach = $("#approach_code").val();

    $(
      "#protein_per,#carbo_per,#fat_per,#protein_cal,#carbo_cal,#fat_cal,#protein_gram,#carbo_gram,#fat_gram"
    ).val(0);
    $("#zig_zag_margin_info").text("");

    clearFixedTopInfo();

    // MNRA = Micro Nutrition Ratio Approach
    if (meal_approach == 1) {
      $("#protein_per,#carbo_per,#fat_per").attr("readonly", false);
      $("#protein_gram,#carbo_gram,#fat_gram").attr("readonly", true);
      $("#calorie-given-bottom").text(0.0);
      $("#accordion input[type='text']").val("");
      $(".clearTable tbody tr").remove();

      $("#need_factor_row").css("display", "none");
      $("#add_reduce_calorie_row").css("display", "table-row");

      $("#calrecalOpt").val(0).select2();
      $("#geivencal").val(0);
      $("#meal-approach-sub-opt").val(0).select2();
      $("#meal-approach-sub-detail-opt").val(0).select2();
      $("#carbo_per,#fat_per").attr("readonly", false);
      $(
        "#final_cal_req_zig_zag,#carbo_per_zigzag,#carbo_cal_zigzag,#carbo_gram_zigzag"
      ).val(0);
      $("#carbs_zig_zag_row").css("display", "none");

      $("#meal_approach_sub_opt_div").css("display", "none");
      $("#meal_approach_sub_opt_dtl_div").css("display", "none");

      finalCalorieCal();
      totalCalorieSum();
      totalProteinSum();
      totalCarbsSum();
      totalFatSum();
    }

    if (meal_approach == 2) {
      $("#protein_per,#carbo_per,#fat_per").attr("readonly", true);
      $("#protein_gram,#carbo_gram,#fat_gram").attr("readonly", false);
      $("#calorie-given-bottom").text(0.0);
      $("#accordion input[type='text']").val("");
      $(".clearTable tbody tr").remove();

      $("#need_factor_row").css("display", "none");
      $("#add_reduce_calorie_row").css("display", "table-row");

      $("#calrecalOpt").val(0).select2();
      $("#geivencal").val(0);
      $("#meal-approach-sub-opt").val(0).select2();
      $("#meal-approach-sub-detail-opt").val(0).select2();

      $("#carbo_per,#fat_per").attr("readonly", false);
      $(
        "#final_cal_req_zig_zag,#carbo_per_zigzag,#carbo_cal_zigzag,#carbo_gram_zigzag"
      ).val(0);
      $("#carbs_zig_zag_row").css("display", "none");

      $("#meal_approach_sub_opt_div").css("display", "none");
      $("#meal_approach_sub_opt_dtl_div").css("display", "none");

      finalCalorieCal();
      totalCalorieSum();
      totalProteinSum();
      totalCarbsSum();
      totalFatSum();
    }

    if (meal_approach == 3) {
      $(
        "#protein_gram,#protein_cal,#protein_per,#carbo_cal,#carbo_gram,#fat_cal,#fat_gram"
      ).attr("readonly", true);
      $("#carbo_per,#fat_per").attr("readonly", false);
      $("#calorie-given-bottom").text(0.0);
      $("#accordion input[type='text']").val("");
      $(".clearTable tbody tr").remove();

      $("#add_reduce_calorie_row").css("display", "none");
      $("#need_factor_row").css("display", "table-row");
      $("#calrecalOpt").val(0).select2();
      $("#geivencal").val(0);

      // $("#meal_approach_sub_opt_div").css("display", "table-row");
      $("#meal_approach_sub_opt_div").show();
      //  $("#meal_approach_sub_opt_dtl_div").css("display", "table-row");
      $("#meal_approach_sub_opt_dtl_div").show();

      finalCalorieCal();
      totalProteinSum();
      totalCalorieSum();
      totalCarbsSum();
      totalFatSum();
      MealApproachSubOptions(meal_approach);
    }
  });

  $(document).on("keyup", "#protein_per,#carbo_per,#fat_per", function () {
    var meal_approach = $("#meal_approach").val();
    if (meal_approach == 1 || meal_approach == 3) {
      globalCalorieDistribution();
    }
  });

  $(document).on("keyup", "#protein_gram,#carbo_gram,#fat_gram", function () {
    var meal_approach = $("#meal_approach").val();
    if (meal_approach == 2) {
      var protein_gm = $("#protein_gram").val();
      var carbs_gm = $("#carbo_gram").val();
      var fat_gram = $("#fat_gram").val();

      globalPercentageDistribution();

      $("#protein-req-bottom").text(protein_gm + " gm");
      $("#carbs-req-bottom").text(carbs_gm + " gm");
      $("#fat-req-bottom").text(fat_gram + " gm");
    }
  });

  $(document).on("click", ".accordianHead", function () {
    var meal_approach = $("#meal_approach").val();
    var isConsume = $("#isconsumed").val();
    if (meal_approach == 1 || meal_approach == "0") {
      if (isConsume == "Y") {
      } else {
        $("#accordion").accordion({
          icons: icons,
          collapsible: true,
          active: false,
        });
        //	alert("Summation of Protein,Carbohydrate & Fat Percentage must be equal to 100");
        return false;
      }
    }
    // else
    // {
    // 	$("#accordion" ).accordion({
    // 			icons: icons,
    // 			collapsible: auto,
    // 			active: true
    // 		});

    // }
  });

  /*-----------Start Getting Food Name-----------*/
  $(document).on("change", ".food_type", function () {
    var Dtlid = $(this).attr("id");
    var divno = Dtlid.split("_");
    var meal_no = divno[1];
    var fdtype = $("#foodtype_" + meal_no).val();
    var fdcat = $("#foodcategory_" + meal_no).val();
    var gifrom = $("#giIndexfrom_" + meal_no).val();
    var gito = $("#giIndexto_" + meal_no).val();

    if (fdtype != "0" && fdcat != "0") {
      populateFoodByCategory(fdtype, fdcat, meal_no, gifrom, gito);
    } else {
      $("#food_select_" + meal_no).empty();
      var appendVal = "";
      appendVal += '<option value="0">Select</option>';
      $("#food_select_" + meal_no).append(appendVal);
    }
  });
  $(document).on("change", ".food_category", function () {
    var Dtlid = $(this).attr("id");
    var divno = Dtlid.split("_");
    var meal_no = divno[1];
    var fdtype = $("#foodtype_" + meal_no).val();
    var fdcat = $("#foodcategory_" + meal_no).val();
    var gifrom = $("#giIndexfrom_" + meal_no).val();
    var gito = $("#giIndexto_" + meal_no).val();

    if (fdtype != "0" && fdcat != "0") {
      populateFoodByCategory(fdtype, fdcat, meal_no, gifrom, gito);
    } else {
      $("#food_select_" + meal_no).empty();
      var appendVal = "";
      appendVal += '<option value="0">Select</option>';
      $("#food_select_" + meal_no).append(appendVal);
    }
  });

  $(document).on("keyup", ".giIndexfrom", function () {
    var Dtlid = $(this).attr("id");
    var divno = Dtlid.split("_");
    var meal_no = divno[1];
    var fdtype = $("#foodtype_" + meal_no).val();
    var fdcat = $("#foodcategory_" + meal_no).val();
    var gifrom = $("#giIndexfrom_" + meal_no).val();
    var gito = $("#giIndexto_" + meal_no).val();

    if (fdtype != "0" && fdcat != "0") {
      populateFoodByCategory(fdtype, fdcat, meal_no, gifrom, gito);
    } else {
      $("#food_select_" + meal_no).empty();
      var appendVal = "";
      appendVal += '<option value="0">Select</option>';
      $("#food_select_" + meal_no).append(appendVal);
    }
  });

  $(document).on("keyup", ".giIndexto", function () {
    var Dtlid = $(this).attr("id");
    var divno = Dtlid.split("_");
    var meal_no = divno[1];
    var fdtype = $("#foodtype_" + meal_no).val();
    var fdcat = $("#foodcategory_" + meal_no).val();
    var gifrom = $("#giIndexfrom_" + meal_no).val();
    var gito = $("#giIndexto_" + meal_no).val();

    if (fdtype != "0" && fdcat != "0") {
      populateFoodByCategory(fdtype, fdcat, meal_no, gifrom, gito);
    } else {
      $("#food_select_" + meal_no).empty();
      var appendVal = "";
      appendVal += '<option value="0">Select</option>';
      $("#food_select_" + meal_no).append(appendVal);
    }
  });
  /*-----------End Food Name-----------*/

  $(document).on("click", ".addFood", function () {
    var Dtlid = $(this).attr("id");
    var divno = Dtlid.split("_");
    var meal_no = divno[1];

    var food_type = $("#foodtype_" + meal_no).val();
    var food_category = $("#foodcategory_" + meal_no).val();
    var food_id = $("#food_select_" + meal_no).val();
    var qty = $("#qty_" + meal_no).val() || 0;
    var instruction = $("#instruction_" + meal_no).val() || "";

    //	alert("Instruction : "+instruction);

    if (validateDetail(food_type, food_category, food_id, qty)) {
      var isexist = checkDuplicate(meal_no, food_id);
      //alert(isexist);
      if (isexist == false) {
        $.ajax({
          type: "POST",
          url: basepath + "diet/addFoodDetailRow",
          dataType: "html",
          data: {
            meal_no: meal_no,
            food_id: food_id,
            qty: qty,
            instruction: instruction,
            row: row,
          },
          success: function (res) {
            $("#foodTable_" + meal_no + " tbody").append(res);
            row++;
            globalFoodValSum(meal_no);
            $("#qty_" + meal_no).val("");
            $("#instruction_" + meal_no).val("");
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
      } else {
        alert("This food is already selected.");
      }
    } else {
    }
  });

  /**---------------Other Assistance--------------**/

  /*---------------Getting Other Assistance Supplement Name----------*/
  $(document).on("change", "#other_assistnc_catg", function () {
    var id = $(this).val();
    $.ajax({
      url: basepath + "diet/getOtherAssistncSupplement",
      type: "POST",
      dataType: "json",
      data: { catgId: id },
      success: function (res) {
        if (res.otherSupllementID.length > 0) {
          var appendVal = "";
          var tdata = res.otherSupllementID.length;
          appendVal += '<option value="0">Select</option>';
          for (var i = 0; i < tdata; i++) {
            appendVal +=
              '<option value="' +
              res.otherSupllementID[i] +
              '">' +
              res.otherSupllementName[i] +
              "</option>";
          }
          $("#supplement_name").empty();
          $("#supplement_name").append(appendVal);
        } else {
          $("#supplement_name").empty();
          var appendVal = "";
          appendVal += '<option value="0">Select</option>';
          $("#supplement_name").append(appendVal);
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
  });

  /*----------------GET UNIT NAME----------------------*/
  $(document).on("change", "#supplement_name", function () {
    var id = $(this).val();
    $("#supplement_omponents_details").html("");
    $.ajax({
      url: basepath + "diet/getOtherAssistanceUnit",
      type: "POST",
      dataType: "json",
      data: { splmntId: id },
      success: function (res) {
        if (res) {
          $("#other_assistnc_unit").val(res.unitname);
          $("#other_assistnc_unitID").val(res.unitID);

          if (res.unitname != "") {
            var formData = {
              splmntId: id,
            };
            var method = "diet/supplementComponents";
            var data = htmlshowajaxcomtroller(method, formData);
            $("#supplement_omponents_details").html(data);
          }
        } else {
          $("#other_assistnc_unit").val("");
          $("#other_assistnc_unitID").val("");
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
  });

  /*----------ADD Other Assistance-------------------------*/

  $(document).on("click", "#otherAssistanceBtn", function () {
    var category = $("#other_assistnc_catg").val();
    var suppllmntname = $("#supplement_name").val();
    var servingSize = $("#serving_size").val();
    var unitId = $("#other_assistnc_unitID").val();
    var advice = $("#other_assistnce_advice").val();

    if (validateOtherAssistance(category, suppllmntname, servingSize, unitId)) {
      var existCheck = checkDuplicateOtherAssistance(
        otherAssistanceRow,
        suppllmntname
      );
      //var isexist = false;

      if (existCheck == false) {
        $.ajax({
          type: "POST",
          url: basepath + "diet/addOtherAssistanceItem",
          dataType: "html",
          data: {
            category: category,
            supplmntID: suppllmntname,
            servingSize: servingSize,
            unitId: unitId,
            advice: advice,
            row: otherAssistanceRow,
          },
          success: function (res) {
            $("#otherAssistanceDtl tbody").append(res);
            otherAssistanceRow++;
            $("#serving_size").val("");
            $("#other_assistnce_advice").val("");

            //$("#supplement_name").empty();
            //var appendVal = '';
            //appendVal+= '<option value="0">Select</option>';
            //$("#supplement_name").append(appendVal);
            //$("#other_assistnc_unitID").val("");
            //$("#other_assistnc_unit").val("");
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
      } else {
        alert("This combination is already exist");
      }
    }
  });

  /*-------delete Other Assistance--------*/
  $(document).on("click", ".otherAssistanceDlt", function () {
    alert();
    var ids = $(this).attr("id");
    var rowIDNo = ids.split("_");
    var rowID = rowIDNo[1];

    $("#otherAssistanceRow_" + rowID).remove();
  });

  /*----------Add other assistance row ----------------*/

  $(document).on("click", ".delicon", function () {
    var Dtlid = $(this).attr("id");
    var divno = Dtlid.split("_");
    var divid = divno[1];
    var rowid = divno[2];

    $("#fdetailrow_" + divid + "_" + rowid).remove();
    globalFoodValSum(divid);
  });

  /*------------------------------------------------------------------------------- */
}); /* end of document ready */

/***********************************************USER DEFINED FUNCTION**************************/

/*----------------Summation------------------*/
function globalCalorieDistribution() {
  MicroNutritionRatioApproach();
  ProteinCalDistribution();
  CarbohydrateCalDistribution();
  FatCalDistribution();
  //	MicroNutritionRatioApproach();
}

function globalPercentageDistribution() {
  // alert("red");
  ProteinPercentCalculation();
  CarbsPercentCalculation();
  FatPercentCalculation();
}

function globalFoodValSum(meal_no) {
  sumCalorieMealWise(meal_no);
  sumProteinMealWise(meal_no);
  sumCarbsMealWise(meal_no);
  sumFatMealWise(meal_no);

  totalCalorieSum();
  totalProteinSum();
  totalCarbsSum();
  totalFatSum();

  //RemainingCalorie();
}

function numericFilter(txb) {
  txb.value = txb.value.replace(/[^\0-9]/gi, "");
}

function resetCalculation() {
  $("#bdyfatval").text("");
  $("#BMRval").text("");
  $("#calReq").text("");
  $("#bFatPercentage").val("");
  $("#bmrValue").val("");
  $("#calresult").css("display", "none");

  $("#prv_cal_txt").text("0");
  $("#calorieReqOrg").val(0);
  finalCalorieCal();
}

// Final Calorie Requirement After Adding or reducing previous calorie result
function finalCalorieCal() {
  var given_cal = $("#geivencal").val() || 0;
  var org_cal = $("#calorieReqOrg").val();
  var add_or_reduce = $("#calrecalOpt").val();
  var final_cal_req = 0;
  $("#prv_cal_txt").text(org_cal);

  if (add_or_reduce != "0") {
    if (add_or_reduce == "ADD") {
      final_cal_req = parseFloat(org_cal) + parseFloat(given_cal);
    }
    if (add_or_reduce == "SUB") {
      final_cal_req = parseFloat(org_cal) - parseFloat(given_cal);
    }

    $("#finalcalReq").text(final_cal_req.toFixed(3));
    $("#recalCalVal").text(final_cal_req.toFixed(3));
    $("#final_cal_req").val(final_cal_req.toFixed(3));
    $("#calorie-req-bottom").text(final_cal_req.toFixed(3));

    //$(".remCaloriTxt").text(final_cal_req.toFixed(3));
    //	$("#calorie-given-bottom").text(final_cal_req.toFixed(3));
    $("#totalRemCalorie").val(final_cal_req.toFixed(3));
  } else {
    final_cal_req = org_cal;

    $("#finalcalReq").text(final_cal_req);
    $("#recalCalVal").text(final_cal_req);
    $("#final_cal_req").val(final_cal_req);
    $("#calorie-req-bottom").text(final_cal_req);
    $("#totalRemCalorie").val(final_cal_req);
  }
}

// Caclulate Calorie Required For Members
function calCalorieReq() {
  var mobile = $("#mobile").val();
  var membership_no = $("#membership_no").val();
  var gender = $("#gender").val();
  var dob = $("#dob").val();
  var weight = $("#weight").val();
  var waist = $("#waist").val();
  var activity = $("#activity_lvl").val();
  var calculate_by = $("#calculate_by").val();
  //var phone_valid = /^([0-9]{10})$/;

  $("#errormsg1").text("");
  if (mobile == "") {
    //alert("Please Enter Mobile No");
    $("#errormsg1").text("Please Enter Mobile No");
    $("#mobile").addClass("form_error");
    $("#mobile").focus();
    return false;
  }

  if (weight == "") {
    $("#errormsg1").text("Please Enter Weight");
    $("#weight").addClass("form_error");
    $("#weight").focus();
    return false;
  }
  if (weight <= 0) {
    $("#errormsg1").text("Weight Can't be negative or zero");
    $("#weight").addClass("form_error");
    return false;
  }
  if (waist == "") {
    $("#errormsg1").text("Please Enter Waist Size");
    $("#waist").addClass("form_error");
    $("#waist").focus();
    return false;
  }
  if (waist <= 0) {
    alert("");
    $("#errormsg1").text("Waist Size Can'nt be negative or zero");
    $("#waist").addClass("form_error");
    $("#waist").focus();
    return false;
  }

  if (activity == "") {
    $("#errormsg1").text("Please select Activity Level");
    $("#activity_lvl").addClass("form_error");
    $("#activity_lvl").focus();
    return false;
  }

  var formData = {
    membership_no: membership_no,
    gender: gender,
    dob: dob,
    weight: weight,
    waist: waist,
    activity: activity,
    calculate_by: calculate_by,
    mobile: mobile,
  };
  var method = "diet/calculateMemberBmr";
  var data = ajaxcallcontrollerforcutom(method, formData);
  if (data.msg_status == 1) {
    console.log(data);
    $("#ritht_top_row").css("background-image", "none");
    $("#ritht_top_row").css("opacity", 1);
    $("#calresult").css("display", "table-cell");
    $("#bdyfatval").text(data.bodyfatpercentage + "%");
    $("#bFatPercentage").val(data.bodyfatpercentage);
    $("#bodyFatRemarks").val(data.bodyFatRemarks);
    $("#bmrValue").val(data.BMR);
    $("#BMRval").text(data.BMR + " Cal/Day");
    $("#calReq").text(data.calReq);
    $("#calorieReqOrg").val(data.calReq);
    $("#finalcalReq").text(data.calReq);
    $("#calorie-req-bottom").text(data.calReq);
    $("#final_cal_req").val(data.calReq);
    $("#recalCalVal").text(data.calReq);
    $("#totalRemCalorie").val(data.calReq);
    finalCalorieCal();
    globalCalorieDistribution();
  } else {
    $("#calresult").css("display", "none");
  }
}

// Approach Selection

function MicroNutritionRatioApproach() {
  var total_consum = 0;
  var protein_per = $("#protein_per").val() || 0;
  var carbo_per = $("#carbo_per").val() || 0;
  var fat_per = $("#fat_per").val() || 0;
  total_consum =
    parseFloat(protein_per) + parseFloat(carbo_per) + parseFloat(fat_per);

  if (total_consum <= 100) {
    if (total_consum == 100) {
      $("#isconsumed").val("Y");
      $(".predMeal").removeClass("dnclk");
    } else {
      $("#isconsumed").val("N");
      //$(".predMeal").addClass("dnclk");
    }
    //	globalCalorieDistribution();
  } else {
    alert(
      "Summation of Protein , Carbohydrate , Fat should not greater than 100"
    );
    return false;
  }
}

// Get Meal Approach Code
function getMealApproachCode(approachID) {
  $.ajax({
    type: "POST",
    url: "get_meal_approach_dtl.php",
    dataType: "json",
    data: { approachID: approachID },
    success: function (res) {
      if (res) {
        $("#approach_code").val(res.approach_code);
      } else {
        $("#approach_code").val("");
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

  var approach = $("#approach_code").val();
  return approach;
}

function MealApproachSubOptions(meal_approach_id) {
  var formData = {
    meal_approach_id: meal_approach_id,
  };
  var method = "diet/mealapproachSubOptions";
  var data = htmlshowajaxcomtroller(method, formData);
  console.log(data);
  $("#sub_meal_approach_div").html(data);
  $(".select2").select2();

  /*$.ajax({
    type: "POST",
    url: "mealapproach_sub_options.php",
    dataType: "html",
    data: { meal_approach_id: meal_approach_id },
    success: function (res) {
      $("#sub_meal_approach_div").html(res);
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
  });*/
}

function MealApproachSubDetailOptions(meal_approach_sub_id) {
  $("#zig_zag_margin_info").text("");
  var formData = {
    meal_approach_sub_id: meal_approach_sub_id,
  };
  var method = "diet/mealapproachSubDetailOptions";
  var data = htmlshowajaxcomtroller(method, formData);
  console.log(data);
  $("#sub_meal_approach_detail_div").html(data);
  $(".select2").select2();

  /*
  $.ajax({
    type: "POST",
    url: "mealapproach_sub_detail_options.php",
    dataType: "html",
    data: { meal_approach_sub_id: meal_approach_sub_id },
    success: function (res) {
      $("#sub_meal_approach_detail_div").html(res);
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
  */
}

// ProteinCalculator : Used For Zig Zag Approach
function ProteinCalculator(nfid, weight, bfpercentg) {
  /* alert("nfid"+nfid);
     alert("weight"+weight);
     alert("bfpercentg"+bfpercentg);*/
  var protein_req1;
  $.ajax({
    type: "POST",
    //url: "protein_calculator.php",
    url: basepath + "diet/proteinCalculator",
    dataType: "json",
    data: { nfid: nfid, weight: weight, bfpercentg: bfpercentg },
    success: function (res) {
      $("#protein_gram").val(res.protein_req);

      globalPercentageDistribution();
      var protein_grm = $("#protein_gram").val();
      $("#protein-req-bottom").text(protein_grm + " gm");
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

function calculateZigZagCalorieVal(aproach_dtl_id) {
  var weight = $("#weight").val();
  var final_calorie = $("#final_cal_req").val();
  $.ajax({
    type: "POST",
    // url: "zig-zag-approach-calculation.php",
    url: basepath + "diet/zigzagapproachcalculation",
    dataType: "json",
    data: {
      aproach_dtl_id: aproach_dtl_id,
      weight: weight,
      final_calorie_req: final_calorie,
    },
    success: function (res) {
      //  $("#carbs_zig_zag_row").css("display", "table-row");
      $("#carbs_zig_zag_row").show();
      var carbo_cal = parseFloat($("#carbo_cal").val());
      var carbo_gram_prv = parseFloat($("#carbo_gram").val());
      var calorie_margin = parseFloat(res.calorie_margin);
      var operation = res.operation;

      if (operation == "ADD") {
        var carbs_cal_wth_margin = carbo_cal + calorie_margin;
        var carbs_gm_wth_margin = carbo_gram_prv + calorie_margin;
      } else {
        var carbs_cal_wth_margin = carbo_cal - calorie_margin;
        var carbs_gm_wth_margin = carbo_gram_prv - calorie_margin;
      }

      $("#zig_zag_margin_info").text(res.result_info);
      $("#finalcalReq").text(
        parseFloat(res.calorie_req_finlly_zig_zag).toFixed(3)
      );
      $("#final_cal_req_zig_zag").val(res.calorie_req_finlly_zig_zag);
      $("#carbo_cal_zigzag").val(carbs_cal_wth_margin.toFixed(3));
      $("#carbo_per,#fat_per").attr("readonly", true);

      calculateZigzagCalorietoGram();
      calculateZigzagCalorietoPercentage();

      var fincal_with_zigzag = $("#final_cal_req_zig_zag").val();
      //alert(a);

      $("#calorie-req-bottom").text(fincal_with_zigzag);
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

function calculateZigzagCalorietoGram() {
  var zig_zag_calorie = $("#carbo_cal_zigzag").val();
  var zig_zag_carbs_gm = parseFloat(zig_zag_calorie) / 4;
  $("#carbo_gram_zigzag").val(zig_zag_carbs_gm.toFixed(3));
  $("#carbs-req-bottom").text(zig_zag_carbs_gm.toFixed(3) + " gm");
}

function calculateZigzagCalorietoPercentage() {
  var zig_zag_calorie = $("#carbo_cal_zigzag").val();
  var totalcaloriezigzag = $("#final_cal_req_zig_zag").val();
  var zig_zag_carbs_per =
    (parseFloat(zig_zag_calorie) * 100) / parseFloat(totalcaloriezigzag);
  $("#carbo_per_zigzag").val(zig_zag_carbs_per.toFixed(2));
}

// Get Food Name
function populateFoodByCategory(fdtype, fdcat, meal_no, gifrm, gito) {
  $.ajax({
    type: "POST",
    url: basepath + "diet/getFoodList",
    dataType: "json",
    data: { fdtype: fdtype, fdcat: fdcat, gifrm: gifrm, gito: gito },
    success: function (res) {
      if (res) {
        var appendVal = "";
        var tdata = res.foodid.length;

        for (var i = 0; i < tdata; i++) {
          appendVal +=
            '<option value="' +
            res.foodid[i] +
            '">' +
            res.foodname[i] +
            "</option>";
        }
        $("#food_select_" + meal_no).empty();
        $("#food_select_" + meal_no).append(appendVal);
      } else {
        $("#food_select_" + meal_no).empty();
        var valAppend = "";
        valAppend += '<option value="0">Select</option>';
        $("#food_select_" + meal_no).append(valAppend);
      }
      //$(".food_select").selectpicker();
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

// get Detail Food

function addFoodDetail(mealno) {
  var meal = mealno;
  var arr = meal.split("_");
  var meal_no = arr[1];

  var food_id = $("#food_select_" + meal_no).val();
  var qty = $("#qty_" + meal_no).val() || 0;

  $.ajax({
    type: "POST",
    url: "add_food_detail.php",
    dataType: "html",
    data: { meal: meal, meal_no: meal_no, food_id: food_id, qty: qty },
    success: function (res) {
      $("#foodTable_" + meal_no).append(res);
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

function validateDetail(ftype, fcategory, foodid, qty) {
  if (ftype == "0") {
    alert("Please select Food Type");
    return false;
  }
  if (fcategory == "0") {
    alert("Please select food category");
    return false;
  }

  if (foodid == "" || foodid == "0" || foodid == null) {
    alert("Please select food");
    return false;
  }
  if (qty == "") {
    alert("Enter quantity");
    return false;
  }
  if (qty <= 0) {
    alert("Quantity value must be gretater than zero");
    return false;
  }
  return true;
}

function sumCalorieMealWise(mealno) {
  var sum = 0;
  $(".calorieGiven").each(function () {
    var idis = $(this).attr("id");
    var divno = idis.split("_");
    var mealNumber = divno[1];
    if (mealNumber == mealno) {
      sum += parseFloat($(this).val() || 0);
    }
  });

  $("#calorieSum_" + mealno).val(sum.toFixed(3));
}

function sumProteinMealWise(mealno) {
  var sum = 0;
  $(".proteinGiven").each(function () {
    var idis = $(this).attr("id");
    var divno = idis.split("_");
    var mealNumber = divno[1];
    if (mealNumber == mealno) {
      sum += parseFloat($(this).val() || 0);
    }
  });

  $("#proteinSum_" + mealno).val(sum.toFixed(3));
}

function sumCarbsMealWise(mealno) {
  var sum = 0;
  $(".carboGiven").each(function () {
    var idis = $(this).attr("id");
    var divno = idis.split("_");
    var mealNumber = divno[1];
    if (mealNumber == mealno) {
      sum += parseFloat($(this).val() || 0);
    }
  });

  $("#carbsSum_" + mealno).val(sum.toFixed(3));
}

function sumFatMealWise(mealno) {
  var sum = 0;
  $(".fatGiven").each(function () {
    var idis = $(this).attr("id");
    var divno = idis.split("_");
    var mealNumber = divno[1];
    if (mealno == mealNumber) {
      sum += parseFloat($(this).val() || 0);
    }
  });

  $("#fatSum_" + mealno).val(sum.toFixed(3));
}

function totalCalorieSum() {
  var totalReqCal = $("#final_cal_req").val() || 0;
  var remainingCalorie = 0;
  var totalCalorie = 0;
  $(".calorieGiven").each(function () {
    totalCalorie += parseFloat($(this).val() || 0);
  });

  $("#totalCalorie").val(totalCalorie.toFixed(3));

  remainingCalorie = parseFloat(totalReqCal) - parseFloat(totalCalorie);
  $("#totalRemCalorie").val(remainingCalorie.toFixed(3));

  /*
    if(remainingCalorie<0)
    {
    	$("#calorie-given-bottom").addClass("blink_me");
    }
    else
    {
    	$("#calorie-given-bottom").removeClass("blink_me");
    }
    */

  if (totalCalorie > totalReqCal) {
    $("#calorie-given-bottom").addClass("blink_me");
  } else {
    $("#calorie-given-bottom").removeClass("blink_me");
  }

  //$(".remCaloriTxt").text(remainingCalorie.toFixed(3));
  $("#calorie-given-bottom").text(totalCalorie.toFixed(3));
  //return totalCalorie.toFixed(3);
}

function totalProteinSum() {
  var totalProteinReq = $("#protein_gram").val() || 0;
  var remainingProtein = 0;
  var totalProtein = 0;
  $(".proteinGiven").each(function () {
    totalProtein += parseFloat($(this).val() || 0);
  });

  $("#totalProtein").val(totalProtein.toFixed(3));
  $("#protein-given-bottom").text(totalProtein.toFixed(3) + " gm");

  remainingProtein = parseFloat(totalProteinReq) - parseFloat(totalProtein);
  $("#totalRemProtein").val(remainingProtein.toFixed(3));

  if (remainingProtein < 0) {
    $(".remProteinTxt").css("color", "red");
  } else {
    $(".remProteinTxt").css("color", "");
  }

  $(".remProteinTxt").text(remainingProtein.toFixed(3));

  //return totalProtein.toFixed(3);
}

function totalCarbsSum() {
  var meal_approach = $("#meal_approach").val(); // For Weight Loss Approach
  var carbs_req = $("#carbo_gram").val(); // For Weight Loss Approach

  var totalCarbsReq = $("#carbo_gram").val() || 0;
  var remainingCarbs = 0;

  var totalCarbos = 0;
  $(".carboGiven").each(function () {
    totalCarbos += parseFloat($(this).val() || 0);
  });

  $("#totalCarbs").val(totalCarbos.toFixed(3));
  $("#carbs-given-bottom").text(totalCarbos.toFixed(3) + " gm");

  // For Weight Loss Approach
  if (meal_approach == 2) {
    $(".carbs-given-block").css("display", "block");
    $("#carbs-req-bottom").text(parseFloat(carbs_req) + " gm");
    $("#carbs-given-bottom").text(parseFloat(totalCarbos) + " gm");
    if (parseFloat(totalCarbos) > parseFloat(carbs_req)) {
      $("#carbs-given-bottom").addClass("blink_me");
    } else {
      $("#carbs-given-bottom").removeClass("blink_me");
    }
  } else {
    $("#carbs-given-block").css("display", "none");
  }

  /*
    remainingCarbs = parseFloat(totalCarbsReq)-parseFloat(totalCarbos);
    $("#totalRemCarbs").val(remainingCarbs.toFixed(3));
    if(remainingCarbs<0)
    {
    	$(".remCarbsTxt").css("color","red");
    }
    else
    {
    	$(".remCarbsTxt").css("color","");
    }
    $(".remCarbsTxt").text(remainingCarbs.toFixed(3));
    */

  //return totalCarbos.toFixed(3);
}

function totalFatSum() {
  var totalFatReq = $("#fat_gram").val() || 0;
  var remainingFat = 0;

  var totalFat = 0;
  $(".fatGiven").each(function () {
    totalFat += parseFloat($(this).val() || 0);
  });

  $("#totalFat").val(totalFat.toFixed(3));
  $("#fat-given-bottom").text(totalFat.toFixed(3) + " gm");

  remainingFat = parseFloat(totalFatReq) - parseFloat(totalFat);
  $("#totalRemFat").val(remainingFat.toFixed(3));

  if (remainingFat < 0) {
    $(".remFatTxt").css("color", "red");
  } else {
    $(".remFatTxt").css("color", "");
  }

  $(".remFatTxt").text(remainingFat.toFixed(3));
  //return totalFatSum.toFixed(3);
}

function checkDuplicate(mealno, foodid) {
  var foodname = "foodID_" + mealno;
  var isexist = false;
  var arr = $('input[name="' + foodname + '[]"]')
    .map(function () {
      var foodExist = $(this).val();
      var idis = $(this).attr("id");

      var divno = idis.split("_");
      var meal_no = divno[1];

      if (foodExist == foodid && meal_no == mealno) {
        isexist = true;
      } else {
        isexist = false;
      }
    })
    .get();

  return isexist;
}

function checkDuplicateOtherAssistance(rowno, supplementId) {
  var otherassistance = "otherAssistanceSupplyName";
  var isexist = false;
  var arr = $('input[name="' + otherassistance + '[]"]')
    .map(function () {
      var otherAsisitncExist = $(this).val();
      if (otherAsisitncExist == supplementId) {
        isexist = true;
      } else {
        isexist = false;
      }
    })
    .get();

  return isexist;
}

/*************** CONVERT VALUE FROM % to Calorie AND Gram ***************/
function ProteinCalDistribution() {
  var final_cal_req = $("#final_cal_req").val() || 0;
  var protein_cal = 0; // Calculate protein calorie Val
  var protein_gm = 0;
  var protein_p = $("#protein_per").val();
  protein_cal = parseFloat((final_cal_req * protein_p) / 100);
  protein_gm = parseFloat(protein_cal / 4);
  $("#protein_cal").val(protein_cal.toFixed(3));
  $("#protein_gram").val(protein_gm.toFixed(3));

  $("#protein-req-bottom").text(protein_gm.toFixed(3) + " gm");

  //	$(".remProteinTxt").text(protein_gm.toFixed(3)+'g');
  $("#totalRemProtein").val(protein_gm.toFixed(3));
}

function CarbohydrateCalDistribution() {
  var final_cal_req = $("#final_cal_req").val() || 0;
  var carbo_calorie = 0; // Calculate protein calorie Val
  var carbo_gm = 0;
  var carbo_per = $("#carbo_per").val();
  carbo_calorie = parseFloat((final_cal_req * carbo_per) / 100);
  carbo_gm = parseFloat(carbo_calorie / 4);
  $("#carbo_cal").val(carbo_calorie.toFixed(3));
  $("#carbo_gram").val(carbo_gm.toFixed(3));

  $("#carbs-req-bottom").text(carbo_gm.toFixed(3) + " gm");
  //	$(".remCarbsTxt").text(carbo_gm.toFixed(3)+'g');
  $("#totalRemCarbs").val(carbo_gm.toFixed(3));
}

function FatCalDistribution() {
  var final_cal_req = $("#final_cal_req").val() || 0;
  var fat_cal = 0; // Calculate protein calorie Val
  var fat_gm = 0;
  var fat_p = $("#fat_per").val();
  fat_cal = parseFloat((final_cal_req * fat_p) / 100);
  fat_gm = parseFloat(fat_cal / 9);
  $("#fat_cal").val(fat_cal.toFixed(3));
  $("#fat_gram").val(fat_gm.toFixed(3));

  $("#fat-req-bottom").text(fat_gm.toFixed(3) + " gm");
  //	$(".remFatTxt").text(fat_gm.toFixed(3)+'g');
  $("#totalRemFat").val(fat_gm.toFixed(3));
}

/*************** CONVERT VALUE FROM Gram to  Calorie AND Percentage ***************/

function ProteinPercentCalculation() {
  var final_cal_req = $("#final_cal_req").val() || 0;
  var protein_per = 0;
  var protein_cal = 0;

  var protein_gm = $("#protein_gram").val();
  protein_cal = parseFloat(protein_gm * 4);
  protein_per = parseFloat((protein_cal * 100) / final_cal_req); // Carbs Percentage

  $("#protein_cal").val(protein_cal.toFixed(3));
  $("#protein_per").val(protein_per.toFixed(2));

  //	$(".remFatTxt").text(fat_gm.toFixed(3)+'g');
  //	$("#totalRemFat").val(fat_gm.toFixed(3));
}

function CarbsPercentCalculation() {
  var final_cal_req = $("#final_cal_req").val() || 0;
  var carbs_per = 0;
  var carbs_cal = 0;

  var carbs_gm = $("#carbo_gram").val();
  carbs_cal = parseFloat(carbs_gm * 4);
  carbs_per = parseFloat((carbs_cal * 100) / final_cal_req); // Carbs Percentage

  $("#carbo_cal").val(carbs_cal.toFixed(3));
  $("#carbo_per").val(carbs_per.toFixed(2));

  //	$(".remFatTxt").text(fat_gm.toFixed(3)+'g');
  //	$("#totalRemFat").val(fat_gm.toFixed(3));
}

function FatPercentCalculation() {
  var final_cal_req = $("#final_cal_req").val() || 0;
  var fat_per = 0;
  var fat_cal = 0;

  var fat_gram = $("#fat_gram").val();
  fat_cal = parseFloat(fat_gram * 9);
  fat_per = parseFloat((fat_cal * 100) / final_cal_req); // Carbs Percentage

  $("#fat_cal").val(fat_cal.toFixed(3));
  $("#fat_per").val(fat_per.toFixed(2));

  //	$(".remFatTxt").text(fat_gm.toFixed(3)+'g');
  //	$("#totalRemFat").val(fat_gm.toFixed(3));
}

function validateOtherAssistance(catg, splmnt, servingsize, unitid) {
  if (catg == "0") {
    alert("Select Category");
    return false;
  }

  if (splmnt == "0") {
    alert("Select Supplement Name");
    return false;
  }
  if (servingsize == "") {
    alert("Enter Serving Size Value");
    return false;
  }
  if (servingsize < 0) {
    alert("Serving size value cann't be negative");
    return false;
  }
  return true;
}

function clearFixedTopInfo() {
  $("#protein-req-bottom").text("0.000 gm");
  $("#carbs-req-bottom").text("0.000 gm");
  $("#fat-req-bottom").text("0.000 gm");
}

function memberMedicalInfo(mobile) {
  $("#member_reg_info").html("");
  var formData = {
    mobile: mobile,
  };
  var method = "diet/memberMedicalInfo";
  var data = htmlshowajaxcomtroller(method, formData);
  $("#member_reg_info").html(data);
}

function memberBloodTest(member_ac_code) {
  var formData = {
    member_ac_code: member_ac_code,
  };
  var method = "diet/memberBloodTestList";
  var data = htmlshowajaxcomtroller(method, formData);
  $("#member_blood_test_data").html(data);
  $(".dataTable").DataTable();
  $(".datemask").inputmask("dd/mm/yyyy", { placeholder: "dd/mm/yyyy" });
}

function memberHavData(mobile) {
  $("#member_hav_div").show();
  var formData = {
    mobile: mobile,
  };
  var method = "diet/memberHavInformation";
  var data = htmlshowajaxcomtroller(method, formData);
  $("#member_hav_div_data").html(data);
}

function enableDisableFieldValue(meal_approach) {
  if (meal_approach == 1) {
    $("#protein_per,#carbo_per,#fat_per").attr("readonly", false);
    $("#protein_gram,#carbo_gram,#fat_gram").attr("readonly", true);
  }

  if (meal_approach == 2) {
    $("#protein_per,#carbo_per,#fat_per").attr("readonly", true);
    $("#protein_gram,#carbo_gram,#fat_gram").attr("readonly", false);
  }

  if (meal_approach == 3) {
    $(
      "#protein_per,#protein_cal,#protein_gram,#carbo_per,#carbo_cal,#carbo_gram,#fat_per,#fat_cal,#fat_gram"
    ).attr("readonly", true);
    //$("#carbo_per,#fat_per").attr("readonly",false);
    //MealApproachSubOptions(meal_approach);
  }
}

function playaudio() {
  var audio = new Audio(
    "https://res.cloudinary.com/dxfq3iotg/video/upload/v1557233524/success.mp3"
  );
  audio.play();
}
