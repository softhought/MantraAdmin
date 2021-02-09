$(document).ready(function () {
  /** added by sandipan on 11.09.2019 **/
  // $('#promo').multiselect({
  // 	includeSelectAllOption: true
  // });
  basepath = $("#basepath").val();
  $(document).on("keyup click", "#txt_phone,#ext_mem_info", function (e) {
    e.preventDefault();
    $("#promoDefaultOp").prop("selected", true);
    $("#reducecase").val("");
    $("#casebackTr").addClass("casebackdispn");
    $("#walletchenge").val("N");
    getpromocashback(e);
  });

  /* start  added by anil 14-11-2019 */

  $(document).on("change", "#promo", function () {
    var selected = $(this).find("option:selected");
    var value = selected.attr("data-text");
    var promo = selected.attr("data-promo");

    if (promo == "N") {
      $("#reducecase").val(value);

      $("#casebackTr").removeClass("casebackdispn");
    } else {
      $("#reducecase").val("");
      $("#casebackTr").addClass("casebackdispn");

      $("#acc_info").prop("disabled", false);
    }
    if (value != 0) {
      $("#walletchenge").val("Y");
    } else {
      $("#walletchenge").val("N");
    }
  });

  $(document).on("keyup", "#reducecase", function () {
    var reduceval = parseInt($(this).val());

    var selected = $("#promo").find("option:selected");
    var value = selected.attr("data-text");

    if (reduceval > value) {
      alert("Cash should not greater than wallet cash..");
      $("#acc_info").prop("disabled", true);
    } else {
      getPayment();
      $("#acc_info").prop("disabled", false);
    }
  });

  /* End  added by anil 14-11-2019 */

  // $(document).on("keyup","#txt_mem_mob",function(){

  // 	alert();

  // });

  /* End  added by anil 14-11-2019 */

  //branch wise promo
  // $(document).on('change','#sel_branch',function(e) {
  // 	e.preventDefault();
  // 	$('#promoTr').html('');
  // 	var Mobile_no=$('#txt_phone').val();
  // 	var branch_Code=$('#sel_branch option:selected').val();
  // 	//alert(branch_Code);
  // 	getRate();

  // 	if(Mobile_no.length==10)
  // 	{
  // 		//alert('hii');
  // 		//var mobileno=$(this).val();
  // 		$.ajax({
  // 					url: "reg.dml.new.gst.php",
  // 					type: "post",
  // 					data: {
  // 						mobile:Mobile_no,
  // 						branch:branch_Code,
  // 						GetPromoWithMobile:"GetPromoWithMobile"
  // 					},
  // 					success: function(data) {
  // 						var obj = jQuery.parseJSON(data);
  // 						var html="";
  // 						if(obj.length>0)
  // 						{
  // 							html +='<td width="135">Wallet</td>';
  // 							html +='<td><select  name="promo" id="promo" class="form_input_text pay_info_chng" style="width: 306px;"><option data-text="0" value="0" id="promoDefaultOp">--Select--</option>';

  // 							obj.forEach(promo => {
  // 								html +='<option data-text="'+promo['amount']+'" value='+promo['id']+'>'+promo['title']+'-'+promo['amount']+'</option>';
  // 							});

  // 							html +='</select></td>';
  // 						}

  // 						$('#promoTr').html(html);
  // 						// $('#promo').multiselect({
  // 						// 		includeSelectAllOption: true
  // 						// 	});

  // 					}
  // 				});
  // 	}

  // });

  /* calculate to deduct the walet blnc  */
  $(document).on("change", "#promo", function () {
    if ($("#sel_card option:selected").val() != 0) {
      getPayment();
    } else {
      alert("Select a Package first");
      $("#promoDefaultOp").prop("selected", true);
      $("#reducecase").val("");
      $("#casebackTr").addClass("casebackdispn");
      $("#walletchenge").val("N");
      return false;
    }
  });

  /**- added by sandipan on 11.09.2019 -**/
});

/* Start added by anil on 20-11-2019 */

function getpromocashback(e) {
  getPayment();

  if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
    $("#txt_phone").val(
      $("#txt_phone")
        .val()
        .replace(/[^\d.]/g, "")
    );
  }
  $("#promoTr").html("");
  var Mobile_no = $("#txt_phone").val();

  // var branch_Code=$('#sel_branch option:selected').val();
  if (Mobile_no.length == 10) {
    getMemberAccCode(Mobile_no);
    $.ajax({
      url: basepath + "registration/getPromoWithMobile",
      type: "post",
      data: {
        mobile: Mobile_no,
        // branch:branch_Code,
        GetPromoWithMobile: "GetPromoWithMobile",
      },
      success: function (data) {
        var obj = jQuery.parseJSON(data);
        //console.log(obj);
        var html = "";
        if (obj.length > 0) {
          html += '<td width="135">Wallet</td>';
          html +=
            '<td><select  name="promo" id="promo" class="form_input_text pay_info_chng form-control select2" "><option data-text="0" data-promo="0" value="0" id="promoDefaultOp">--Select--</option>';

          obj.forEach((promo) => {
            if (promo["is_promo"] == "Y") {
              html +=
                '<option data-text="' +
                promo["amount"] +
                '" data-promo="' +
                promo["is_promo"] +
                '" value=' +
                promo["is_promo"] +
                "_" +
                promo["id"] +
                ">" +
                promo["title"] +
                "-" +
                promo["amount"] +
                "</option>";
            } else {
              html +=
                '<option data-text="' +
                promo["amount"] +
                '" data-promo="' +
                promo["is_promo"] +
                '" value=' +
                promo["is_promo"] +
                "_" +
                promo["id"] +
                ">" +
                "Cashback" +
                "-" +
                promo["amount"] +
                "</option>";
            }
          });

          html += "</select></td>";
        }

        $("#promoTr").html(html);
        $("#promo").select2();
      },
    });
  }
}

function getMemberAccCode(mobile_no) {
  $.ajax({
    //  url: "reg.dml.new.gst.php",
    url: basepath + "registration/getMemberaccCodeWithMobile",
    type: "post",
    data: {
      mobile: mobile_no,
      // branch:branch_Code,
      GetMemberaccCodeWithMobile: "GetMemberaccCodeWithMobile",
    },
    success: function (response) {
      $("#memberAccCode").val(response);
    },
  });
}

/* End added by anil on 20-11-2019 */

function validateForm() {
  var b = document.getElementById("sel_branch");
  var str_branch = b.options[b.selectedIndex].text;

  var u = document.getElementById("sel_user");
  var user = u.options[u.selectedIndex].text;

  var colb = document.getElementById("sel_col_branch");
  var str_col_branch = colb.options[colb.selectedIndex].text;

  var category = document.getElementById("sel_category").value;
  var card = document.getElementById("sel_card").value;

  // var c=document.getElementById("sel_card");
  // var str_card = c.options[c.selectedIndex].text;

  var pm = document.getElementById("sel_mode");
  var str_pm = pm.options[pm.selectedIndex].text;

  var s = document.getElementById("sel_service_int");
  var str_service = s.options[s.selectedIndex].text;

  var inst1 = document.getElementById("txt_inst1_amt").value;
  var inst2 = document.getElementById("txt_inst2_amt").value;
  var inst3 = document.getElementById("txt_inst3_amt").value;
  var inst4 = document.getElementById("txt_inst4_amt").value;
  var inst5 = document.getElementById("txt_inst5_amt").value;
  var inst6 = document.getElementById("txt_inst6_amt").value;

  var hrd = document.getElementById("sel_heard");
  var str_hrd = hrd.options[hrd.selectedIndex].text;

  var disc3 = document.getElementById("txt_disc_nego").value;

  if (document.getElementById("txt_reg_dt").value == "") {
    alert("Enter Date of Registration!!!");
    document.getElementById("txt_reg_dt").focus();
    return false;
  }
  /*
	else
	{
		if (isValidDate(document.getElementById("txt_reg_dt").value)==false)
		{
		   alert ("Invalid Registration Date Format - Valid format : mm/dd/yyyy !!!");
		   document.getElementById("txt_reg_dt").focus();
		   return false;	
		}
	}
	*/

  if (document.getElementById("txt_payment_dt").value == "") {
    alert("Enter Date of Payment!!!");
    document.getElementById("txt_payment_dt").focus();
    return false;
  }
  /*
	else
	{
		if (isValidDate(document.getElementById("txt_payment_dt").value)==false)
		{
		   alert ("Invalid Payment Date Format - Valid format : mm/dd/yyyy !!!");
		   document.getElementById("txt_payment_dt").focus();
		   return false;	
		}
	}*/

  if (str_branch == "Select Branch") {
    alert("Select Branch !!!");
    document.getElementById("sel_branch").focus();
    return false;
  }

  if (category == "") {
    alert("Select Category !!!");
    document.getElementById("sel_category").focus();
    return false;
  }
  if (card == 0) {
    alert("Select Card !!!");
    document.getElementById("sel_card").focus();
    return false;
  }

  if (str_col_branch == "Select") {
    alert("Select Collection Branch !!!");
    document.getElementById("sel_col_branch").focus();
    return false;
  }

  /* if(str_card=="Select Card")
	{
		alert ("Select Type of Card !!!");
		document.getElementById("sel_card").focus();
		return false;	
	} */

  if (document.getElementById("txt_birth").value == "") {
    alert("Enter Date of Birth!!!");
    document.getElementById("txt_birth").focus();
    return false;
  } else {
    if (isValidDate(document.getElementById("txt_birth").value) == false) {
      alert("Invalid Date of Birth Format - Valid format : mm/dd/yyyy !!!");
      document.getElementById("txt_birth").focus();
      return false;
    }
  }

  if (document.getElementById("chkIscompl").checked == false) {
    if (document.getElementById("txt_subscription").value == "") {
      alert("Enter Subscription Amount !!!");
      document.getElementById("txt_subscription").focus();
      return false;
    }

    if (document.getElementById("txt_tax").value == "") {
      alert("Please Enter Service Tax Amount");
      document.getElementById("txt_tax").focus();
      return false;
    }

    if (str_pm == "Select") {
      alert("Please select mode of payment  !!!");
      document.getElementById("sel_mode").focus();
      return false;
    }
  }

  if (disc3 > 0) {
    if (document.getElementById("txt_rem_nego").value == "") {
      alert("Please Enter Remarks !!! Why are you giving Discount");
      document.getElementById("txt_rem_nego").focus();
      return false;
    }
  }

  if (inst1 > 0) {
    if (document.getElementById("txt_inst1_dt").value == "") {
      alert("Enter First Date of Installment !!!");
      document.getElementById("txt_inst1_dt").focus();
      return false;
    }
    /*	   
       else
       {
	       if (isValidDate(document.getElementById("txt_inst1_dt").value)==false)
	       {
	           alert ("Invalid Installment Date Format - Valid format : mm/dd/yyyy !!!");
	           document.getElementById("txt_inst1_dt").focus();
	           return false;	
	       }
       }
	   */

    if (document.getElementById("txt_inst1_amt").value == "") {
      alert("Enter 1st Installment!!!");
      document.getElementById("txt_inst1_amt").focus();
      return false;
    }

    if (document.getElementById("txt_inst1_cheque").value == "") {
      alert("Enter Cheque No for 1st Installment!!!");
      document.getElementById("txt_inst1_cheque").focus();
      return false;
    }
  }

  if (inst2 > 0) {
    if (document.getElementById("txt_inst2_dt").value == "") {
      alert("Enter Second Date of Installment !!!");
      document.getElementById("txt_inst2_dt").focus();
      return false;
    }
    /*
	   else
	   {
			if (isValidDate(document.getElementById("txt_inst2_dt").value)==false)
			{
				alert ("Invalid Installment Date Format - Valid format : mm/dd/yyyy !!!");
				document.getElementById("txt_inst2_dt").focus();
				return false;	
			}
	   }
	   */

    if (document.getElementById("txt_inst2_amt").value == "") {
      alert("Enter 2nd Installment!!!");
      document.getElementById("txt_inst2_amt").focus();
      return false;
    }

    if (document.getElementById("txt_inst2_cheque").value == "") {
      alert("Enter Cheque No for 2nd Installment!!!");
      document.getElementById("txt_inst2_cheque").focus();
      return false;
    }
  }
  //added by anil on 09-04-2020
  if (inst3 > 0) {
    if (document.getElementById("txt_inst3_dt").value == "") {
      alert("Enter Third Date of Installment !!!");
      document.getElementById("txt_inst3_dt").focus();
      return false;
    }
    if (document.getElementById("txt_inst3_amt").value == "") {
      alert("Enter 3rd Installment!!!");
      document.getElementById("txt_inst3_amt").focus();
      return false;
    }

    if (document.getElementById("txt_inst3_cheque").value == "") {
      alert("Enter Cheque No for 3rd Installment!!!");
      document.getElementById("txt_inst3_cheque").focus();
      return false;
    }
  }

  if (inst4 > 0) {
    if (document.getElementById("txt_inst4_dt").value == "") {
      alert("Enter Fourth Date of Installment !!!");
      document.getElementById("txt_inst4_dt").focus();
      return false;
    }
    if (document.getElementById("txt_inst4_amt").value == "") {
      alert("Enter 4th Installment!!!");
      document.getElementById("txt_inst4_amt").focus();
      return false;
    }

    if (document.getElementById("txt_inst4_cheque").value == "") {
      alert("Enter Cheque No for 4th Installment!!!");
      document.getElementById("txt_inst4_cheque").focus();
      return false;
    }
  }

  if (inst5 > 0) {
    if (document.getElementById("txt_inst5_dt").value == "") {
      alert("Enter Fifth Date of Installment !!!");
      document.getElementById("txt_inst5_dt").focus();
      return false;
    }
    if (document.getElementById("txt_inst5_amt").value == "") {
      alert("Enter 5th Installment!!!");
      document.getElementById("txt_inst5_amt").focus();
      return false;
    }

    if (document.getElementById("txt_inst5_cheque").value == "") {
      alert("Enter Cheque No for 5th Installment!!!");
      document.getElementById("txt_inst5_cheque").focus();
      return false;
    }
  }

  if (inst6 > 0) {
    if (document.getElementById("txt_inst6_dt").value == "") {
      alert("Enter Sixth Date of Installment !!!");
      document.getElementById("txt_inst6_dt").focus();
      return false;
    }
    if (document.getElementById("txt_inst6_amt").value == "") {
      alert("Enter 6th Installment!!!");
      document.getElementById("txt_inst6_amt").focus();
      return false;
    }

    if (document.getElementById("txt_inst6_cheque").value == "") {
      alert("Enter Cheque No for 6th Installment!!!");
      document.getElementById("txt_inst6_cheque").focus();
      return false;
    }
  }

  //end by anil on 09-04-2020

  if (document.getElementById("txt_name").value == "") {
    alert("Enter Name!!!");
    document.getElementById("txt_name").focus();
    return false;
  }

  if (document.getElementById("sel_blood_grp").value == "0") {
    alert("Select Blood Group !!!");
    document.getElementById("sel_blood_grp").focus();
    return false;
  }

  if (document.getElementById("txt_phone").value == "") {
    alert("Enter Phone No. !!!");
    document.getElementById("txt_phone").focus();
    return false;
  }

  if (document.getElementById("txt_pin").value == "") {
    alert("Enter Pin!!!");
    document.getElementById("txt_pin").focus();
    return false;
  }

  if (document.getElementById("txt_add").value == "") {
    alert("Enter Address!!!");
    document.getElementById("txt_add").focus();
    return false;
  }

  //   if(document.getElementById("txt_subscription").value=="")
  //	{
  //		alert ("Enter Subscription Amount !!!");
  //		document.getElementById("txt_subscription").focus();
  //		return false;
  //	}

  if (document.getElementById("txt_mail").value != "") {
    if (echeck(document.getElementById("txt_mail").value) == false) {
      document.getElementById("txt_mail").focus();
      return false;
    }
  }
  if (document.getElementById("txt_ext_mno").value != "") {
    if ((document.getElementById("hd_mno").value = "")) {
      alert("Invalid Membership No !!!");
      document.getElementById("txt_ext_mno").focus();
      return false;
    }
  }

  if (str_service == "Select Services") {
    alert("Select Interested Service !!!");
    document.getElementById("sel_service_int").focus();
    return false;
  }

  if (str_hrd == "From Member") {
    if ((document.getElementById("txt_mem_mob").value = "")) {
      alert("Please enter Member's(Reference) Mobile No");
      document.getElementById("txt_mem_mob").focus();
      return false;
    }
  }

  if (user == "Select") {
    alert("Please Enter name of operator !!!");
    document.getElementById("sel_user").focus();
    return false;
  }

  //document.getElementById("continue").setAttribute("data-toggle", "modal");
  //document.getElementById("continue").setAttribute("data-target", "#myModal");
  var elem = document.getElementById("reg_frm");

  setAttributes(elem, { "data-toggle": "modal", "data-target": "#myModal" });
  return true;
}

function setAttributes(el, attrs) {
  for (var key in attrs) {
    el.setAttribute(key, attrs[key]);
  }
}

function isValidDate(date) {
  var valid = true;

  date = date.replace("/-/g", "");

  var month = parseInt(date.substring(0, 2), 10);
  var day = parseInt(date.substring(2, 4), 10);
  var year = parseInt(date.substring(4, 8), 10);

  if (month < 1 || month > 12) valid = false;
  else if (day < 1 || day > 31) valid = false;
  else if ((month == 4 || month == 6 || month == 9 || month == 11) && day > 30)
    valid = false;
  else if (
    month == 2 &&
    (year % 400 == 0 || year % 4 == 0) &&
    year % 100 != 0 &&
    day > 29
  )
    valid = false;
  else if (month == 2 && year % 100 == 0 && day > 29) valid = false;

  return valid;
}

function echeck(str) {
  var at = "@";
  var dot = ".";
  var lat = str.indexOf(at);
  var lstr = str.length;
  var ldot = str.indexOf(dot);
  if (str.indexOf(at) == -1) {
    alert("Invalid E-mail ID");
    return false;
  }

  if (
    str.indexOf(at) == -1 ||
    str.indexOf(at) == 0 ||
    str.indexOf(at) == lstr
  ) {
    alert("Invalid E-mail ID");
    return false;
  }

  if (
    str.indexOf(dot) == -1 ||
    str.indexOf(dot) == 0 ||
    str.indexOf(dot) == lstr
  ) {
    alert("Invalid E-mail ID");
    return false;
  }

  if (str.indexOf(at, lat + 1) != -1) {
    alert("Invalid E-mail ID");
    return false;
  }

  if (
    str.substring(lat - 1, lat) == dot ||
    str.substring(lat + 1, lat + 2) == dot
  ) {
    alert("Invalid E-mail ID");
    return false;
  }

  if (str.indexOf(dot, lat + 2) == -1) {
    alert("Invalid E-mail ID");
    return false;
  }

  if (str.indexOf(" ") != -1) {
    alert("Invalid E-mail ID");
    return false;
  }

  return true;
}

function getHTTPObject() {
  if (window.ActiveXObject) return new ActiveXObject("Microsoft.XMLHTTP");
  else if (window.XMLHttpRequest) return new XMLHttpRequest();
  else {
    alert("Your browser does not support AJAX.");
    return null;
  }
}

function setOutput_enq(responseText) {
  document.getElementById("enq").innerHTML = responseText;
  $(".select2").select2();
}

function setOutput_enq_no(responseText) {
  var strSend;
  var name;

  strSend = responseText.split("*");
  name = strSend[1] + " " + strSend[2];
  document.getElementById("txt_enq_no").value = strSend[0];
  document.getElementById("txt_name").value = name;
  document.getElementById("txt_add").value = strSend[3];
  document.getElementById("txt_phone").value = strSend[4];
  document.getElementById("txt_phone2").value = strSend[5];
  document.getElementById("txt_pin").value = strSend[6];
}

function setOutput(responseText) {
  var strSend;
  var gender;
  var married;

  //if (httpObject.readyState == 4) {
  if (1) {
    strSend = responseText.split("*");

    //alert(strSend);
    var str = document.getElementById("hd_mno").value;

    document.getElementById("hd_mno").value = strSend[0];
    document.getElementById("txt_name").value = strSend[1];

    var el = document.getElementById("personal_info_panel");
    //alert(strSend[0]);
    if (strSend[0].trim() != "") {
      document.getElementById("hd_isconverted").value = "Y";
      el.classList.remove("personal_info_disable");
    } else {
      document.getElementById("hd_isconverted").value = "N";
      el.classList.add("personal_info_disable");
    }

    //	document.getElementById('txt_cashbck').value = strSend[24];

    var cashbckamt = strSend[24];
    if (cashbckamt == "") {
      document.getElementById("txt_cashbck").value = 0;
    } else {
      document.getElementById("txt_cashbck").value = cashbckamt;
    }
    document.getElementById("txt_cashbck").value = cashbckamt;

    // //alert(cashbckamt);
    // 	if(cashbckamt==0 || cashbckamt==""){
    // 		document.getElementById("cashbackamtrow").style.display = "none";
    // 	}
    // 	else{
    // 		document.getElementById("cashbackamtrow").style.display = "table-row";
    // 	}

    var dArr = strSend[2].split("-"); // ex input "2010-01-18"
    var dt = dArr[1] + "/" + dArr[2] + "/" + dArr[0];

    var g = document.getElementById("sel_gender");
    var m = document.getElementById("sel_marital");
    // var a = document.getElementById("sel_app");
    // var a = document.getElementById("sel_app");
    var d = document.getElementById("sel_dig");
    // var h = document.getElementById("sel_hrt");
    // var u = document.getElementById("sel_urn");
    // var n = document.getElementById("sel_nrv");
    // var e = document.getElementById("sel_ent");
    // var o = document.getElementById("sel_ort");
    // var p = document.getElementById("sel_psy");
    // var f = document.getElementById("sel_fem");
    // var t = document.getElementById("sel_dit");

    var b = document.getElementById("sel_blood_grp");

    if (strSend[3] == "M") {
      gender = "Male";
    } else {
      gender = "Female";
    }

    if (strSend[4] == "M") {
      married = "Married";
    } else {
      married = "Single";
    }

    if (strSend[3].trim() != "") {
      selectedValue("sel_gender", strSend[3]);
    }

    if (strSend[4].trim() != "") {
      selectedValue("sel_marital", strSend[4]);
    }

    //	g.options[g.selectedIndex].value=strSend[3];
    //    g.options[g.selectedIndex].text=gender;

    //	m.options[m.selectedIndex].value=strSend[4];
    //   m.options[m.selectedIndex].text=married;

    // Blood Group
    if (strSend[25].trim() != "") {
      selectedValue("sel_blood_grp", strSend[25]);
    }

    document.getElementById("txt_birth").value = dt;
    document.getElementById("txt_father").value = strSend[5];
    document.getElementById("txt_add").value = strSend[6];
    document.getElementById("txt_pin").value = strSend[7];
    document.getElementById("txt_phone").value = strSend[8];
    document.getElementById("txt_phone2").value = strSend[9];
    document.getElementById("txt_mail").value = strSend[10];
    document.getElementById("txt_occu").value = strSend[11];
    // document.getElementById("txt_comp").value = strSend[12];
    // document.getElementById("txt_his").value = strSend[13];

    // BY Mithilesh on 28.10.2016
    // if (strSend[14].trim() != "") {
    //   selectedValue("sel_app", strSend[14]);
    // }
    if (strSend[15].trim() != "") {
      selectedValue("sel_dig", strSend[15]);
    }
    // if (strSend[16].trim() != "") {
    //   selectedValue("sel_hrt", strSend[16]);
    // }
    // if (strSend[17].trim() != "") {
    //   selectedValue("sel_urn", strSend[17]);
    // }
    // if (strSend[18].trim() != "") {
    //   selectedValue("sel_nrv", strSend[18]);
    // }
    // if (strSend[19].trim() != "") {
    //   selectedValue("sel_ent", strSend[19]);
    // }
    // if (strSend[20].trim() != "") {
    //   selectedValue("sel_ort", strSend[20]);
    // }
    // if (strSend[21].trim() != "") {
    //   selectedValue("sel_psy", strSend[21]);
    // }
    // if (strSend[22].trim() != "") {
    //   selectedValue("sel_fem", strSend[22]);
    // }
    // if (strSend[23].trim() != "") {
    //   selectedValue("sel_dit", strSend[23]);
    // }

    /*a.options[a.selectedIndex].value=strSend[14]; 
    a.options[a.selectedIndex].text=strSend[14]; 

	d.options[d.selectedIndex].value=strSend[15]; 
    d.options[d.selectedIndex].text=strSend[15]; 

	h.options[h.selectedIndex].value=strSend[16]; 
    h.options[h.selectedIndex].text=strSend[16]; 

	u.options[u.selectedIndex].value=strSend[17]; 
    u.options[u.selectedIndex].text=strSend[17]; 

	n.options[n.selectedIndex].value=strSend[18]; 
    n.options[n.selectedIndex].text=strSend[18]; 

	e.options[e.selectedIndex].value=strSend[19]; 
    e.options[e.selectedIndex].text=strSend[19]; 

	o.options[o.selectedIndex].value=strSend[20]; 
    o.options[o.selectedIndex].text=strSend[20]; 

	p.options[p.selectedIndex].value=strSend[21]; 
    p.options[p.selectedIndex].text=strSend[21]; 

	f.options[f.selectedIndex].value=strSend[22]; 
    f.options[f.selectedIndex].text=strSend[22]; 

	t.options[t.selectedIndex].value=strSend[23]; 
    t.options[t.selectedIndex].text=strSend[23]; 
	*/

    var memberid = document.getElementById("hd_mno").value;
    document.getElementById("old_mem").value = memberid;

    getPayment();
  }

  // function for selected value
  function selectedValue(id, value) {
    var optbld_ln = document.getElementById(id).options.length;
    var bGrp = document.getElementById(id);
    for (i = 0; i < optbld_ln; i++) {
      var optbld = document.getElementById(id).options.item(i).value;
      if (optbld == value) {
        $("#" + id).val(value);
      }
    }
  }
}

function setOutput_other() {
  var strSend;
  var name;
  var x = new Date();

  if (httpObject.readyState == 4) {
    strSend = httpObject.responseText.split("*");
    if (strSend[0] != "") {
      document.getElementById("detail").innerHTML =
        strSend[1] + "/" + strSend[2] + "/" + strSend[4] + "/" + strSend[5];
      document.getElementById("txtmid").value = strSend[0];
    } else {
      //else will be added by anil 20-11-2019

      $(".numererr").text("");

      $("#detail").text(
        "This Mobile No. Not Exists Please Should Be Registered First"
      );
      $("#detail").css("color", "red");
      $("#other_info").prop("disabled", true);
    }
  }
}

function setOutput_rate() {
  if (httpObject.readyState == 4) {
    document.getElementById("txt_subscription").value = httpObject.responseText;
    getPayment();
  }
}

// setoutput for package on 20.08.2016
function setOutput_package() {
  if (httpObject.readyState == 4) {
    document.getElementById("pack").innerHTML = httpObject.responseText;
  }
}

function getMember() {
  var code = $("#txt_ext_mno").val();

  $.ajax({
    //  url: "reg.dml.new.gst.php",
    url: basepath + "registration/getRegistrationInfo",
    type: "post",
    data: {
      code: code,
    },
    success: function (response) {
      // console.log("getCardBrnRate" + response);
      setOutput(response);
    },
  });

  /*
  var strURL =
    "get_reg_detail.php?code=" + document.getElementById("txt_ext_mno").value;

  httpObject = getHTTPObject();
  if (httpObject != null) {
    httpObject.open("GET", strURL, true);
    httpObject.send(null);
    httpObject.onreadystatechange = setOutput;
    $("#txt_phone").trigger("keyup");
  }

  */
}

function getEnquiry() {
  var enq_no = $("#txt_enq_no").val();
  $.ajax({
    //  url: "reg.dml.new.gst.php",
    url: basepath + "registration/getEnquiryDetails",
    type: "post",
    data: {
      enq_no: enq_no,
    },
    success: function (response) {
      // console.log("getCardBrnRate" + response);
      setOutput_enq(response);
    },
  });
  /*
  var strURL =
    "get_enq_detail.php?enq=" + document.getElementById("txt_enq_no").value;
  httpObject = getHTTPObject();
  if (httpObject != null) {
    httpObject.open("GET", strURL, true);
    httpObject.send(null);
    httpObject.onreadystatechange = setOutput_enq;
  } */
}

$(document).on("input keyup", "#txt_mem_mob", function (event) {
  event.preventDefault();
  var txt_mem_mob = $("#txt_mem_mob").val();
  $("#txt_ref_person_name").val("");
  if (txt_mem_mob.length == 10) {
    $.ajax({
      //  url: "reg.dml.new.gst.php",
      url: basepath + "registration/getMemberNameByMobile",
      type: "post",
      data: {
        txt_mem_mob: txt_mem_mob,
      },
      success: function (response) {
        $("#txt_ref_person_name").val(response);
      },
    });
  }
});

function getEnqNo(enqid) {
  $.ajax({
    //  url: "reg.dml.new.gst.php",
    url: basepath + "registration/getEnquiryNoData",
    type: "post",
    data: {
      enqid: enqid,
    },
    success: function (response) {
      // console.log("getCardBrnRate" + response);
      setOutput_enq_no(response);
    },
  });

  /*
  var strURL = "get_enq_no.php?enq=" + enqid;
  httpObject = getHTTPObject();
  if (httpObject != null) {
    httpObject.open("GET", strURL, true);
    httpObject.send(null);
    httpObject.onreadystatechange = setOutput_enq_no;
  }*/
}

//modify by anil on 20-11-2019

function getOtherData() {
  var txt_phone = $("#txt_phone").val();
  var txt_mem_mob = $("#txt_mem_mob").val();
  $("#other_info").prop("disabled", false);
  $(".numererr").text("Member's Detail");
  $("#detail").text("");
  $("#detail").css("color", "unset");

  if (txt_mem_mob.length == 10) {
    if (txt_phone != txt_mem_mob) {
      var hrd = document.getElementById("sel_heard");
      var str_hrd = hrd.options[hrd.selectedIndex].text;

      if (str_hrd != "From Member") {
        alert("Member Mobile No not required");
        document.getElementById("txt_mem_mob").value = "";
        return false;
      }
      var strURL =
        "get_detail_mobile_mother.php?mob=" +
        document.getElementById("txt_mem_mob").value;
      httpObject = getHTTPObject();
      if (httpObject != null) {
        httpObject.open("GET", strURL, true);
        httpObject.send(null);
        httpObject.onreadystatechange = setOutput_other;
      }
    } else {
      $(".numererr").text("");

      $("#detail").text(
        "Registration Mobile No. Or Refferral Mobile No. Could Not Be Same .."
      );
      $("#detail").css("color", "red");
      $("#other_info").prop("disabled", true);
    }
  }
}

function getRate() {
  var sel_branch = $("#sel_branch").val();
  var sel_card = $("#sel_card").val();
  var comapny_id = $("#company_id").val();

  var formData = {
    comapny_id: comapny_id,
    sel_branch: sel_branch,
    sel_card: sel_card,
  };
  var method = "registration/getCardBrnRate";
  var data = ajaxcallcontrollerforcutom(method, formData);

  //console.log("getCardBrnRate" + data);
  $("#txt_subscription").val(data);
  getPayment();
}

// get package by category on 20.08.2016 by Mithilesh
function getPackageList(catid) {
  categoryonchange();
  var cmpid = $("#company_id").val();

  //alert(cmpid);
  $.ajax({
    type: "POST",
    url: basepath + "registration/getCardList",
    data: { cat: catid, comp: cmpid },

    success: function (data) {
      // console.log(data);
      $("#pack").html(data);
      $("#sel_card").select2();
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
      // alert(msg);
    },
  });
}

var httpObject = null;

function makedisable() {
  if (document.getElementById("chkIscompl").checked == true) {
    //document.getElementById('txt_admission').disabled = true;
    document.getElementById("txt_subscription").disabled = true;

    document.getElementById("txt_disc_conv").disabled = true;
    document.getElementById("txt_disc_offer").disabled = true;
    document.getElementById("txt_disc_nego").disabled = true;

    document.getElementById("txt_premium").disabled = true;
    document.getElementById("txt_payment_now").disabled = true;
    document.getElementById("cgstrate").disabled = true;
    document.getElementById("cgstAmount").disabled = true;
    document.getElementById("sgstrate").disabled = true;
    document.getElementById("sgstAmount").disabled = true;
    // document.getElementById('txt_tax').disabled = true;
    document.getElementById("txt_inst1_amt").disabled = true;
    document.getElementById("txt_inst2_amt").disabled = true;
    document.getElementById("txt_inst3_amt").disabled = true;
    document.getElementById("txt_inst4_amt").disabled = true;
    document.getElementById("txt_inst5_amt").disabled = true;
    document.getElementById("txt_inst6_amt").disabled = true;

    document.getElementById("txt_inst1_cheque").disabled = true;
    document.getElementById("txt_inst1_bank").disabled = true;
    document.getElementById("txt_inst1_branch").disabled = true;
    document.getElementById("txt_inst2_cheque").disabled = true;
    document.getElementById("txt_inst2_bank").disabled = true;
    document.getElementById("txt_inst2_branch").disabled = true;
    document.getElementById("txt_inst3_cheque").disabled = true;
    document.getElementById("txt_inst3_bank").disabled = true;
    document.getElementById("txt_inst3_branch").disabled = true;
    document.getElementById("txt_inst4_cheque").disabled = true;
    document.getElementById("txt_inst4_bank").disabled = true;
    document.getElementById("txt_inst4_branch").disabled = true;
    document.getElementById("txt_inst5_cheque").disabled = true;
    document.getElementById("txt_inst5_bank").disabled = true;
    document.getElementById("txt_inst5_branch").disabled = true;
    document.getElementById("txt_inst6_cheque").disabled = true;
    document.getElementById("txt_inst6_bank").disabled = true;
    document.getElementById("txt_inst6_branch").disabled = true;
    document.getElementById("sel_mode").disabled = true;
    document.getElementById("txt_chq_no").disabled = true;
    document.getElementById("txt_chq_dt").disabled = true;
    document.getElementById("txt_bank").disabled = true;
    document.getElementById("txt_branch").disabled = true;

    document.getElementById("txt_premium").value = "";

    document.getElementById("txt_disc_conv").value = "";
    document.getElementById("txt_disc_offer").value = "";
    document.getElementById("txt_disc_nego").value = "";

    document.getElementById("txt_payment_now").value = "";
    document.getElementById("txt_due").value = "";
    document.getElementById("cgstrate").value = "";
    document.getElementById("cgstAmount").value = "";
    document.getElementById("sgstrate").value = "";
    document.getElementById("sgstAmount").value = "";
    // document.getElementById('txt_tax').value = "";
    document.getElementById("txt_payable").value = "";
    document.getElementById("txt_inst1_amt").value = "";
    document.getElementById("txt_inst2_amt").value = "";
    document.getElementById("txt_inst3_amt").value = "";
    document.getElementById("txt_inst4_amt").value = "";
    document.getElementById("txt_inst5_amt").value = "";
    document.getElementById("txt_inst6_amt").value = "";
    document.getElementById("txt_inst1_dt").value = "";
    document.getElementById("txt_inst2_dt").value = "";
    document.getElementById("txt_inst3_dt").value = "";
    document.getElementById("txt_inst4_dt").value = "";
    document.getElementById("txt_inst5_dt").value = "";
    document.getElementById("txt_inst6_dt").value = "";

    document.getElementById("txt_subscription").value = "";

    document.getElementById("txt_inst1_cheque").value = "";
    document.getElementById("txt_inst1_bank").value = "";
    document.getElementById("txt_inst1_branch").value = "";
    document.getElementById("txt_inst2_cheque").value = "";
    document.getElementById("txt_inst2_bank").value = "";
    document.getElementById("txt_inst2_branch").value = "";
    document.getElementById("txt_inst3_cheque").value = "";
    document.getElementById("txt_inst3_bank").value = "";
    document.getElementById("txt_inst3_branch").value = "";
    document.getElementById("txt_inst4_cheque").value = "";
    document.getElementById("txt_inst4_bank").value = "";
    document.getElementById("txt_inst4_branch").value = "";
    document.getElementById("txt_inst5_cheque").value = "";
    document.getElementById("txt_inst5_bank").value = "";
    document.getElementById("txt_inst5_branch").value = "";
    document.getElementById("txt_inst6_cheque").value = "";
    document.getElementById("txt_inst6_bank").value = "";
    document.getElementById("txt_inst6_branch").value = "";
    document.getElementById("sel_mode").value = "Select";
    document.getElementById("txt_chq_no").value = "";
    document.getElementById("txt_chq_dt").value = "";
    document.getElementById("txt_bank").value = "";
    document.getElementById("txt_branch").value = "";
    //added by anil on 04-12-2019
    document.getElementById("promo").disabled = true;
    $("#reducecase").val("");
    $("#promoDefaultOp").prop("selected", true);
    $("#casebackTr").addClass("casebackdispn");
    $("#walletchenge").val("N");
  } else {
    //document.getElementById('txt_admission').disabled = false;
    document.getElementById("txt_subscription").disabled = false;

    document.getElementById("txt_disc_conv").disabled = false;
    document.getElementById("txt_disc_offer").disabled = false;
    document.getElementById("txt_disc_nego").disabled = false;

    document.getElementById("txt_premium").disabled = false;
    document.getElementById("txt_payment_now").disabled = false;
    document.getElementById("cgstrate").disabled = false;
    document.getElementById("cgstAmount").disabled = false;
    document.getElementById("sgstrate").disabled = false;
    document.getElementById("sgstAmount").disabled = false;
    //  document.getElementById('txt_tax').disabled = false;
    document.getElementById("txt_inst1_amt").disabled = false;
    document.getElementById("txt_inst2_amt").disabled = false;
    document.getElementById("txt_inst3_amt").disabled = false;
    document.getElementById("txt_inst4_amt").disabled = false;
    document.getElementById("txt_inst5_amt").disabled = false;
    document.getElementById("txt_inst6_amt").disabled = false;

    document.getElementById("txt_inst1_cheque").disabled = false;
    document.getElementById("txt_inst1_bank").disabled = false;
    document.getElementById("txt_inst1_branch").disabled = false;
    document.getElementById("txt_inst2_cheque").disabled = false;
    document.getElementById("txt_inst2_bank").disabled = false;
    document.getElementById("txt_inst2_branch").disabled = false;
    document.getElementById("txt_inst3_cheque").disabled = false;
    document.getElementById("txt_inst3_bank").disabled = false;
    document.getElementById("txt_inst3_branch").disabled = false;
    document.getElementById("txt_inst4_cheque").disabled = false;
    document.getElementById("txt_inst4_bank").disabled = false;
    document.getElementById("txt_inst4_branch").disabled = false;
    document.getElementById("txt_inst5_cheque").disabled = false;
    document.getElementById("txt_inst5_bank").disabled = false;
    document.getElementById("txt_inst5_branch").disabled = false;
    document.getElementById("txt_inst6_cheque").disabled = false;
    document.getElementById("txt_inst6_bank").disabled = false;
    document.getElementById("txt_inst6_branch").disabled = false;
    document.getElementById("sel_mode").disabled = false;
    document.getElementById("txt_chq_no").disabled = false;
    document.getElementById("txt_chq_dt").disabled = false;
    document.getElementById("txt_bank").disabled = false;
    document.getElementById("txt_branch").disabled = true;
    document.getElementById("promo").disabled = false;
  }
}

/* for call before save  */
function makeEnable() {
  document.getElementById("txt_subscription").disabled = false;

  document.getElementById("txt_disc_conv").disabled = false;
  document.getElementById("txt_disc_offer").disabled = false;
  document.getElementById("txt_disc_nego").disabled = false;

  document.getElementById("txt_premium").disabled = false;
  document.getElementById("txt_payment_now").disabled = false;
  document.getElementById("cgstrate").disabled = false;
  document.getElementById("cgstAmount").disabled = false;
  document.getElementById("sgstrate").disabled = false;
  document.getElementById("sgstAmount").disabled = false;
  //  document.getElementById('txt_tax').disabled = false;
  document.getElementById("txt_inst1_amt").disabled = false;
  document.getElementById("txt_inst2_amt").disabled = false;
  document.getElementById("txt_inst3_amt").disabled = false;
  document.getElementById("txt_inst4_amt").disabled = false;
  document.getElementById("txt_inst5_amt").disabled = false;
  document.getElementById("txt_inst6_amt").disabled = false;

  document.getElementById("txt_inst1_cheque").disabled = false;
  document.getElementById("txt_inst1_bank").disabled = false;
  document.getElementById("txt_inst1_branch").disabled = false;
  document.getElementById("txt_inst2_cheque").disabled = false;
  document.getElementById("txt_inst2_bank").disabled = false;
  document.getElementById("txt_inst2_branch").disabled = false;
  document.getElementById("txt_inst3_cheque").disabled = false;
  document.getElementById("txt_inst3_bank").disabled = false;
  document.getElementById("txt_inst3_branch").disabled = false;
  document.getElementById("txt_inst4_cheque").disabled = false;
  document.getElementById("txt_inst4_bank").disabled = false;
  document.getElementById("txt_inst4_branch").disabled = false;
  document.getElementById("txt_inst5_cheque").disabled = false;
  document.getElementById("txt_inst5_bank").disabled = false;
  document.getElementById("txt_inst5_branch").disabled = false;
  document.getElementById("txt_inst6_cheque").disabled = false;
  document.getElementById("txt_inst6_bank").disabled = false;
  document.getElementById("txt_inst6_branch").disabled = false;
  document.getElementById("sel_mode").disabled = false;
  document.getElementById("txt_chq_no").disabled = false;
  document.getElementById("txt_chq_dt").disabled = false;
  document.getElementById("txt_bank").disabled = false;
  document.getElementById("txt_branch").disabled = true;
}

function getPayment() {
  var prm;
  var adm;
  var subs;
  var disc1;
  var disc2;
  var disc3;
  var cashbckamt;
  //var premiumamt ;

  //adm = document.getElementById("txt_admission").value;
  subs = document.getElementById("txt_subscription").value;
  //	cashbckamt = document.getElementById("txt_cashbck").value; // added by mithilesh
  if (document.getElementById("txt_cashbck").value == "") {
    cashbckamt = 0;
  } else {
    cashbckamt = document.getElementById("txt_cashbck").value;
  }

  disc1 = document.getElementById("txt_disc_conv").value;
  disc2 = document.getElementById("txt_disc_offer").value;
  disc3 = document.getElementById("txt_disc_nego").value;

  //	alert(prm);
  document.getElementById("txt_premium").value = prm;

  if (document.getElementById("txt_disc_conv").value == "") {
    disc1 = 0;
  }

  if (document.getElementById("txt_disc_offer").value == "") {
    disc2 = 0;
  }

  if (document.getElementById("txt_disc_nego").value == "") {
    disc3 = 0;
  }

  //if (document.getElementById("txt_admission").value=="")
  //{
  adm = 0;
  //}

  if (document.getElementById("txt_subscription").value == "") {
    subs = 0;
  }

  var amount = 0;

  //
  // comment by anil 14-11-2019
  $("#promo")
    .find("option:selected")
    .each(function () {
      var is_promo = $(this).attr("data-promo");

      if (is_promo == "Y") {
        amount += parseFloat($(this).attr("data-text"));
      } else {
        amount += $("#reducecase").val();
      }
    });

  prm =
    parseFloat(adm) +
    parseFloat(subs) -
    (parseFloat(disc1) +
      parseFloat(disc2) +
      parseFloat(disc3) +
      parseFloat(amount));

  document.getElementById("txt_premium").value = prm;
  document.getElementById("txt_payment_now").value = prm;
  var payment = document.getElementById("txt_payment_now").value;
  document.getElementById("txt_due").value =
    parseFloat(prm) - parseFloat(payment);
  //added by anil on 14-04-2020
  var due = parseFloat(prm) - parseFloat(payment);
  var rate = $("#installment_phase").val();
  var installment = $("#installment_phase option:selected").attr("data-month");
  installment_chrg = (due * rate) / 100;

  for (i = 1; i <= installment; i++) {
    var installdueamt = parseFloat(due / installment).toFixed(2);
    var installduecharges = parseFloat(installment_chrg / installment).toFixed(
      2
    );
    document.getElementById("txt_inst" + i + "_amt").value = (
      parseFloat(installdueamt) + parseFloat(installduecharges)
    ).toFixed(2);

    document.getElementById(
      "due_installment" + i + "_charges"
    ).value = parseFloat(installduecharges).toFixed(2);
    //alert(parseInt(installdueamt) );alert(parseInt(installduecharges));
  }
  // document.getElementById("txt_inst1_amt").value=(parseFloat(prm)-parseFloat(payment))/6;
  // document.getElementById("txt_inst2_amt").value=(parseFloat(prm)-parseFloat(payment))/6;
  // document.getElementById("txt_inst3_amt").value=(parseFloat(prm)-parseFloat(payment))/6;
  // document.getElementById("txt_inst4_amt").value=(parseFloat(prm)-parseFloat(payment))/6;
  // document.getElementById("txt_inst5_amt").value=(parseFloat(prm)-parseFloat(payment))/6;
  // document.getElementById("txt_inst6_amt").value=(parseFloat(prm)-parseFloat(payment))/6;
  getTotal();
  return true;
}

function getTotal() {
  var paid = document.getElementById("txt_payment_now").value;
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

  document.getElementById("txt_payable").value = total;

  return true;

  /*	var tax=document.getElementById("txt_tax").value;
		var tax_amt;
		var paid=document.getElementById("txt_payment_now").value;
		var total;
	    if (tax>0) 
	    {
		   tax_amt=((tax/100) * paid);
		   total=parseFloat(paid)+parseFloat(tax_amt);
	    }
	    else
	    {
		  total=paid;
	    }
        document.getElementById("txt_payable").value=total;
		return true;

		*/

  //alert("Total Calculated");
}

function getDue() {
  var prm = document.getElementById("txt_premium").value;
  var payment = document.getElementById("txt_payment_now").value;
  var due = parseFloat(prm) - parseFloat(payment);
  document.getElementById("txt_due").value = due;
  //added by anil on 14-04-2020
  var rate = $("#installment_phase").val();
  var installment = $("#installment_phase option:selected").attr("data-month");
  installment_chrg = (due * rate) / 100;
  $("#extra_charges").text("Extra Charges : " + installment_chrg);

  for (i = 1; i <= installment; i++) {
    var installdueamt = parseFloat(due / installment).toFixed(2);
    var installduecharges = parseFloat(installment_chrg / installment).toFixed(
      2
    );
    document.getElementById("txt_inst" + i + "_amt").value = (
      parseFloat(installdueamt) + parseFloat(installduecharges)
    ).toFixed(2);
    document.getElementById(
      "due_installment" + i + "_charges"
    ).value = parseFloat(installduecharges).toFixed(2);
    //alert(parseInt(installdueamt) );alert(parseInt(installduecharges));
  }

  getTotal();
  return true;
}
//comment by anil and new added on 09-04-2020
// function getAdjustment_1()
// {
// 	var due = document.getElementById("txt_due").value;
// 	var due_1 = document.getElementById("txt_inst1_amt").value;

// 	document.getElementById("txt_inst2_amt").value=parseFloat(due)-parseFloat(due_1);
// }

// function getAdjustment_2()
// {
// 	var due = document.getElementById("txt_due").value;
// 	var due_2 = document.getElementById("txt_inst2_amt").value;

// 	document.getElementById("txt_inst1_amt").value=parseFloat(due)-parseFloat(due_2);
// }

//comment by anil on 20-04-2020
// function getAdjustment_1()
// {
// 	var due = document.getElementById("txt_due").value;
// 	var due_1 = document.getElementById("txt_inst1_amt").value;
// 	var total_due = parseFloat(due)-parseFloat(due_1);
// 	var intallment = parseFloat(total_due)/5;

// 	document.getElementById("txt_inst2_amt").value=intallment.toFixed(2);
// 	document.getElementById("txt_inst3_amt").value=intallment.toFixed(2);
// 	document.getElementById("txt_inst4_amt").value=intallment.toFixed(2);
// 	document.getElementById("txt_inst5_amt").value=intallment.toFixed(2);
// 	document.getElementById("txt_inst6_amt").value=intallment.toFixed(2);
// }

// function getAdjustment_2()
// {
// 	var due = document.getElementById("txt_due").value;
// 	var due_1 = document.getElementById("txt_inst1_amt").value;
// 	var due_2 = document.getElementById("txt_inst2_amt").value;
// 	var total_due = parseFloat(due)-parseFloat(due_1)-parseFloat(due_2);

// 	document.getElementById("txt_inst3_amt").value=(parseFloat(total_due)/4).toFixed(2);
// 	document.getElementById("txt_inst4_amt").value=(parseFloat(total_due)/4).toFixed(2);
// 	document.getElementById("txt_inst5_amt").value=(parseFloat(total_due)/4).toFixed(2);
// 	document.getElementById("txt_inst6_amt").value=(parseFloat(total_due)/4).toFixed(2);
// }
// function getAdjustment_3()
// {
// 	var due = document.getElementById("txt_due").value;
// 	var due_1 = document.getElementById("txt_inst1_amt").value;
// 	var due_2 = document.getElementById("txt_inst2_amt").value;
// 	var due_3 = document.getElementById("txt_inst3_amt").value;
// 	var total_due = parseFloat(due)-parseFloat(due_1)-parseFloat(due_2)-parseFloat(due_3);

// 	document.getElementById("txt_inst4_amt").value=(parseFloat(total_due)/3).toFixed(2);
// 	document.getElementById("txt_inst5_amt").value=(parseFloat(total_due)/3).toFixed(2);
// 	document.getElementById("txt_inst6_amt").value=(parseFloat(total_due)/3).toFixed(2);
// }
// function getAdjustment_4()
// {
// 	var due = document.getElementById("txt_due").value;
// 	var due_1 = document.getElementById("txt_inst1_amt").value;
// 	var due_2 = document.getElementById("txt_inst2_amt").value;
// 	var due_3 = document.getElementById("txt_inst3_amt").value;
// 	var due_4 = document.getElementById("txt_inst4_amt").value;
// 	var total_due = parseFloat(due)-parseFloat(due_1)-parseFloat(due_3)-parseFloat(due_2)-parseFloat(due_4);

// 	document.getElementById("txt_inst5_amt").value=(parseFloat(total_due)/2).toFixed(2);
// 	document.getElementById("txt_inst6_amt").value=(parseFloat(total_due)/2).toFixed(2);
// }
// function getAdjustment_5()
// {
// 	var due = document.getElementById("txt_due").value;
// 	var due_1 = document.getElementById("txt_inst1_amt").value;
// 	var due_2 = document.getElementById("txt_inst2_amt").value;
// 	var due_3 = document.getElementById("txt_inst3_amt").value;
// 	var due_4 = document.getElementById("txt_inst4_amt").value;
// 	var due_5 = document.getElementById("txt_inst5_amt").value;
// 	var total_due = parseFloat(due)-parseFloat(due_1)-parseFloat(due_3)-parseFloat(due_2)-parseFloat(due_4)-parseFloat(due_5);

// 	document.getElementById("txt_inst6_amt").value=total_due.toFixed(2);
// }

function getPaymentDate() {
  document.getElementById("txt_payment_dt").value = document.getElementById(
    "txt_reg_dt"
  ).value;
  return true;
}

function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      $("#blah").attr("src", e.target.result);
    };

    reader.readAsDataURL(input.files[0]);
  }
}

$("#imgInp").change(function () {
  readURL(this);
});

$(document).ready(function () {
  var accountingStartDt = $("#accountingStartDt").val();
  var accountingEndDt = $("#accountingEndDt").val();

  $("#txt_payment_dt").datepicker({
    autoclose: true,
    startDate: new Date(accountingStartDt),
    endDate: new Date(accountingEndDt),
    todayHighlight: true,
    format: "dd-mm-yyyy",
    forceParse: false,
    orientation: "bottom",
  });
  $(
    "#txt_inst1_dt,#txt_inst2_dt,#txt_inst3_dt,#txt_inst4_dt,#txt_inst5_dt,#txt_inst6_dt,#txt_chq_dt,#txt_birth,#txt_anniversary"
  ).datepicker({
    autoclose: true,
    //    startDate : new Date(accountingStartDt),
    // endDate : new Date(accountingEndDt),
    todayHighlight: true,
    format: "dd-mm-yyyy",
    forceParse: false,
    orientation: "bottom",
  });

  $("#txt_reg_dt").datepicker({
    autoclose: true,
    todayHighlight: true,
    format: "dd-mm-yyyy",
    forceParse: false,
    orientation: "bottom",
  });

  /*-----------Check Existing Phone No-------*/
  //txt_phone
  /*
	$(document).on('blur','#txt_phone',function(){
		var mobileno = $("#txt_phone").val();
		$.ajax({
			type:'POST',
			url:'check_mobile_existance.php',
			dataType: "html",
			data: {mobileno:mobileno},
			success:function(response){
				if(response=="1")
				{
					
					$("#mnexst").val(1)
				}
				else
				{
					$("#mnexst").val(0)
					//alert("Continue");
				}
			},
			error: function (jqXHR, exception) {
				var msg = '';
                if (jqXHR.status === 0) {
                    msg = 'Not connect.\n Verify Network.';
                } else if (jqXHR.status == 404) {
                    msg = 'Requested page not found. [404]';
                } else if (jqXHR.status == 500) {
                    msg = 'Internal Server Error [500].';
                } else if (exception === 'parsererror') {
                    msg = 'Requested JSON parse failed.';
                } else if (exception === 'timeout') {
                    msg = 'Time out error.';
                } else if (exception === 'abort') {
                    msg = 'Ajax request aborted.';
                } else {
                    msg = 'Uncaught Error.\n' + jqXHR.responseText;
                }
              //  alert(msg);  
            }
		});
	}); */

  /*-------------------GET ON SALE CASH BACK AMOUNT--------------------*/

  $(document).on("change", "#sel_card,sel_category", function () {
    var branch = $("#sel_branch").val();
    var pack = $("#sel_card").val();
    //alert(branch);
    $.ajax({
      type: "POST",
      // url: "get_on_sale_cash_back.php",
      url: basepath + "registration/getOnSaleCashBack",
      dataType: "html",
      data: { branch: branch, card_code: pack },
      success: function (response) {
        //console.log()
        if (response > 0) {
          $("#onsalecback-row").css("display", "table-row");
          $("#cashback-txt-val").text(response);
        } else {
          $("#onsalecback-row").css("display", "none");
          $("#cashback-txt-val").text(0);
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

  /*-------------------Get Discount rate --------------------*/
  /*------------Added on 30.03.2018 by shankha -------------*/

  $(document).on("change", "#sel_card,#sel_branch", function () {
    var branch = $("#sel_branch").val();
    var pack = $("#sel_card").val();
    getTrainerByBranch();

    $.ajax({
      type: "POST",
      url: basepath + "registration/getDiscountRateBranchPackage",
      dataType: "json",
      data: { branch: branch, card_code: pack },

      success: function (data) {
        if (data.status == 1) {
          //alert(data.discount);

          $("#txt_disc_offer").val(data.discount);
          $("#txt_premium").val(data.premium);
          $("#txt_payment_now").val(data.payment_now);
          $("#discount").text(data.discount_rate);

          $("#txt_disc_offer").prop("readonly", true);
        } else {
          //alert("else");
          $("#txt_disc_offer").val(data.discount);
          $("#txt_premium").val(data.premium);
          $("#txt_payment_now").val(data.payment_now);
          $("#discount").text(data.discount_rate);
          $("#txt_disc_offer").prop("readonly", false);
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
        // alert(msg);
      },
    });
  });

  //added by anil on 14-04-2020
  $("#installment_phase").change(function () {
    var rate = $(this).val();

    //var installment = $("#installment_phase option:selected").text();
    var installment = $("#installment_phase option:selected").attr(
      "data-month"
    );

    for (i = 1; i <= installment; i++) {
      $("#txt_inst" + i + "_dt").prop("disabled", false);
      $("#txt_inst" + i + "_amt").prop("disabled", false);
      $("#txt_inst" + i + "_cheque").prop("disabled", false);
      $("#txt_inst" + i + "_bank").prop("disabled", false);
      $("#txt_inst" + i + "_branch").prop("disabled", false);
    }
    for (j = 6; j > installment; j--) {
      $("#txt_inst" + j + "_dt").val("");
      $("#txt_inst" + j + "_amt").val("");
      $("#txt_inst" + j + "_cheque").val("");
      $("#txt_inst" + j + "_bank").val("");
      $("#txt_inst" + j + "_branch").val("");
      $("#txt_inst" + j + "_dt").prop("disabled", true);
      $("#txt_inst" + j + "_amt").prop("disabled", true);
      $("#txt_inst" + j + "_cheque").prop("disabled", true);
      $("#txt_inst" + j + "_bank").prop("disabled", true);
      $("#txt_inst" + j + "_branch").prop("disabled", true);
    }

    getDue();
  });
  //ended by anil on 14-04-2020
});

function categoryonchange() {
  $("#discount").text("");
  $("#txt_subscription").val("");
  $("#txt_disc_offer").val("");
  $("#txt_premium").val("");
  $("#txt_payment_now").val("");
  $("#txt_payable").val("");
  $("#cashback-txt-val").text("");
}

function getTrainerByBranch() {
  var brn = $("#sel_branch").val();
  $.ajax({
    type: "POST",
    url: basepath + "registration/getTrainerByBranch",
    data: { brn: brn },

    success: function (data) {
      // $("#sel_trainer").html(data);/* commented on 13.11.2020 shankha*/
      $("#sel_trainerdrp").html(data);
      $("#sel_trainer").select2();
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
      // alert(msg);
    },
  });
}

/*----------------------------------------------------------------------------------*/
$("[data-toggle=confirmation]").confirmation({
  rootSelector: "[data-toggle=confirmation]",
  // other options
});

$("#myModal").on("hide", function () {
  // remove the event listeners when the dialog is dismissed
  $("#myModal a.btn").off("click");
});

$("#myModal").on("hidden", function () {
  // remove the actual elements from the DOM when fully hidden
  $("#myModal").remove();
});
$("#myModal").modal({
  show: false,
});
/* $("#myModal").modal({                    // wire up the actual modal functionality and show the dialog
      "backdrop"  : "static",
      "keyboard"  : true,
      "show"      : true                     // ensure the modal is shown immediately
    }); */
/*
$('#myCollapsible').collapse({
  toggle: false
});
function toggleIcon(e) {
        $(e.target)
            .prev('.panel-heading')
            .find(".more-less")
            .toggleClass('glyphicon-plus glyphicon-minus');
    }
    $('.panel-group').on('hidden.bs.collapse', toggleIcon);
  */

/*----------------------------------------------------------------------------------*/
function isNumberKey(evt) {
  var charCode = evt.which ? evt.which : event.keyCode;
  if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
    return false;
  }
  return true;
}
/*-----------------------------start page.js-----------------------------------*/

$(function () {
  // Use CSS3 PIE PHP wrapper
  $.alert.setup({
    defaults: {
      pie: "php",
    },
  });

  // Events
  $("#page")
    // Code folding
    .on("click", ".button.code", function () {
      $(this).next("pre").stop(true, true).slideToggle(250);
    })

    // Examples
    .on("click", '.button[href^="#demo-"]', function () {
      switch ($(this).attr("href").split("-")[1]) {
        // Alert type
        case "info":
          $.alert.open("info", "Lorem ipsum dolor sit amet");
          break;
        case "confirm":
          $.alert.open("confirm", "Lorem ipsum dolor sit amet");
          break;
        case "warning":
          $.alert.open("warning", "Lorem ipsum dolor sit amet");
          break;
        case "error":
          $.alert.open("error", "Lorem ipsum dolor sit amet");
          break;
        case "prompt":
          $.alert.open("prompt", "Lorem ipsum dolor sit amet");
          break;

        // Title
        case "title":
          $.alert.open("My title", "Lorem ipsum dolor sit amet");
          break;

        // Custom buttons
        case "buttons":
          $.alert.open("Lorem ipsum dolor sit amet", {
            someId: "Abc",
            someOtherId: "Def",
          });
          break;

        // Callback
        case "callback_confirm":
          $.alert.open(
            "confirm",
            "Lorem ipsum dolor sit amet?",
            function (button) {
              if (button == "yes")
                $.alert.open('You pressed the "Yes" button.');
              else if (button == "no")
                $.alert.open('You pressed the "No" button.');
              else $.alert.open("Alert was canceled.");
            }
          );
          break;

        case "callback_custom":
          $.alert.open(
            "Lorem ipsum dolor sit amet",
            {
              A: "A",
              B: "B",
              C: "C",
            },
            function (button) {
              if (!button) $.alert.open("Alert was canceled.");
              else $.alert.open('You pressed the "' + button + '" button.');
            }
          );
          break;

        case "callback_prompt":
          $.alert.open(
            "prompt",
            "Lorem ipsum dolor sit amet",
            function (button, value) {
              if (button == "ok")
                $.alert.open(value || "No value has been entered");
            }
          );
      }
      return false;
    });
});
/*-----------------------------end page.js-----------------------------------*/
