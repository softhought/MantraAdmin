<script type="text/javascript">
$(window).on("load", function () {
  memberViewOpt("DATE");
});

$(document).ready(function () {
  $("#example").dataTable();

  basepath = $("#basepath").val();

  $(document).on("change", "#searchByOpt", function () {
    var opt = $(this).val();
    memberViewOpt(opt);
  });

  	$(document).on("click",".copyDietModal",function(){
			var mealId = $(this).attr('data-id');
			$("#mealMastIdFc").val(mealId);
		});
		

});

  function showMember() {
  basepath = $("#basepath").val();
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

  $("#ajaxLoadData").html("");
  $("#loader").show();

  $.ajax({
    type: "POST",
    //url:'get_member_list_edit.php',
    url: basepath + "diet/getMembersDietList",
    dataType: "html",
    data: { mobileno: mobileno, frmDt: frmDt, toDt: toDt, branch: branch },
    success: function (response) {
      $("#loader").hide();
      $("#ajaxLoadData").html(response);
      $(".dataTable").dataTable();
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




  function numericFilter(txb) {
  txb.value = txb.value.replace(/[^\0-9]/gi, "");
}

function ValiditeNumber() {
  var mobile_no = $("#mobile_no").val();

  if (mobile_no == "") {
    $("#mobile_no").addClass("form_error");
    return false;
  }

  if (mobile_no.length != 10) {
    $("#mobile_no").addClass("form_error");
    return false;
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

	function enableCopyButton()
	{
		var mealdT = $("#copyMealdate").val();
		if(mealdT!=""){
			$("#copy-button").css("display","table-row");
		}
		else
		{
			$("#copy-button").css("display","none");
		}
	}

	
	function copyDiet()
	{
    basepath = $("#basepath").val();
		var mealmastId = $("#mealMastIdFc").val();
		var mealDt = $("#copyMealdate").val();
		
		$("#custom-loader").css("display","block");
		$("#copy-data-tagline").css("display","none");
		$.ajax({
		//	url:'make_duplicate_diet.php',
			url:basepath+'diet/makeDuplicateDiet',
			type:'post',
			dataType:'html',
			data:{mealmastID:mealmastId,mealDt:mealDt},
			success:function(res){
				$("#custom-loader").css("display","none");
				$("#copy-data-tagline").css("display","none");
				if(res=="1")
				{
					$("#mealMastIdFc").val("");
					$("#copyMealdate").val("");
					$("#dietCopyForm").css("display","none");
					$("#success-done").css("display","block");
				}
				else
				{
					$("#dietCopyForm").css("display","block");
					$("#failure-done").css("display","block");
					$("#success-done").css("display","none");
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
		
		
	}
	
	function closeCopyDietDialog()
	{
		$("#success-done").css("display","none");
		$("#mealMastIdFc").val("");
		$("#copyMealdate").val("");
		$("#dietCopyForm").css("display","block");
		$("#copy-data-tagline").css("display","block");
		$("#refresh").css("display","table-row");
		enableCopyButton();
		//showMembsDiet();

		}
	
	
	
	function confirmDelete(mealMasterID)
	{
		var isConfirmed = false;
		var confirmdel = confirm("Do you want to delete this meal completely");
		if(confirmdel)
		{
			isConfirmed = true;
       
          var formData = {
            mealMasterID: mealMasterID,
          };
          var method = "diet/deleteDiet";
          var data = ajaxcallcontrollerforcutom(method, formData);
          if (data.msg_status == 1) {
           showMember();
          }
		}
		else
		{
			isConfirmed = false;
		}
	
	} 
	
	
	// Sebd email
	function sendDietEmail(mealID)
	{
		$.ajax({
			url:'send_diet_email.php',
			type:'post',
			dataType:'html',
			data:{mealmastID:mealID},
			success:function(res){
				
				alert("Email sent successfully");
				
			
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
	}
	
</script>

<style>

	.disbale-field
	{
		background:#e5e5e5;
		cursor: not-allowed;
		pointer-events: none;
	}
	.error-field
	{
		border: 1px solid red;
		box-shadow: 1px 0px 2px #F00;
		}

    .actTab{
     # border:2px solid #e7d1d1;
      padding-left: 5px;
      padding-right: 5px;
      background-color:#e7d1d1;
    }
    img{
      width:15px;
    }

  .meal_list_icon
{
	width:22px;
	height:22px;
}
#copyDietModal .modal-dialog
{
	width:400px;
}

#copyDietModal .modal-content
{
	height:400px;
	border-radius: 0;
	
}
#copyDietModal .modal-header {
    border-bottom: 0px solid #e5e5e5;
	text-align: center;
	font-size: 30px;
}

.dietCopyForm
{
	width:90%;
	margin:0 auto;
}
.data-copy-btn
{
	border: none;
	background: #FFF;
	height: 30px;
	width: 140px;
	color: #ff3900;
	font-weight: 600;
	border-radius: 4px;
	margin-top: 6px;
	cursor: pointer;
}
.data-copy-btn:hover
{
	opacity:.9;
}
.custom-loader img,.copy-data-tagline img,.success-done img,.failure-done img
{
	width: 110px;
	margin-left: auto;
	margin-right: auto;
	display: block;
	margin-top:0px;
}
.custom-loader h3
{
	text-align:center;
	color:#FFF;
}
.copy-data-tagline p,.success-done p,.failure-done p
{
	font-size:18px;
	color:#FFF;
	opacity:.9;
	text-align:center;
	
}
</style>

  <section class="layout-box-content-format1">

        <div class="card card-primary">



            <div class="card-header box-shdw">

              <h3 class="card-title">Search Member's Diet</h3>


              <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >

              

              </div>

            </div><!-- /.card-header -->



            <div class="card-body">

            <div class="list-search-block">

               <div class="row box">
                   
                    <div class="col-sm-2">
                    <label for="from_dt" >Search By</label>
                        <div class="form-group">

                              <div class="input-group input-group-sm">

                                    <select class="form-control select2" id="searchByOpt" name="searchByOpt" style="width: 100%;">

                                      
                                   
                                     	<option value="DATE">Date Wise</option>
									                  	<option value="MOBILE">Mobile No</option>

                                    </select>

                              </div>

                            </div>
                    </div>
                     
                        <div class="col-md-2 mob_sect">
                                         <label for="from_dt"  >Mobile</label>
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">                                           
     <input type="text" class="form-control forminputs typeahead inputupper" maxlength="10" id="txt_mobile_no" name="txt_mobile_no" placeholder="Enter mobile" autocomplete="off" value="" onKeyUp="numericFilter(this);">
                                        </div>
                                    </div>
                                </div> 

                 

                    <div class="col-sm-2 date_sect">
                    <label for="from_dt" >From Date</label>
                       <div class="form-group">

                        <div class="input-group input-group-sm">

                            <div class="input-group-prepend">

                              <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>

                            </div>

                            <input type="text" class="form-control datepicker" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask="" name="fromDt" id="fromDt" im-insert="false" value="<?php echo date("d-m-Y"); ?>" readonly>

                          </div>

                        </div>

                        <p id="fromdaterr" style="font-size: 12px;"></p>

                    </div>

                   

                    <div class="col-sm-2 date_sect">
                     <label for="to_date" >To Date</label>
                       <div class="form-group">

                        <div class="input-group input-group-sm">

                            <div class="input-group-prepend">

                              <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>

                            </div>

                            <input type="text" class="form-control datepicker" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask="" name="toDate" id="toDate" im-insert="false" value="<?php echo date("d-m-Y"); ?>" readonly>

                          </div>

                        </div>

                         <p id="todateerr" style="font-size: 12px;"></p>

                    </div>

                     

                  


                    

                    <!-- <label for="student" class="col-sm-1">Member </label> -->

                    <div class="col-sm-2 date_sect">
                   <label for="to_date" >Branch</label>
                      <div class="form-group">

                       <div class="input-group input-group-sm">

                            

                        <select class="form-control select2" name="sel_branch" id="sel_branch"  style="width: 100%;">

                              <option value="All">Select Branch</option>

                              <?php

                              foreach ($rowBranch as $row_brn) {

                              ?>

                              <option value="<?php echo $row_brn->BRANCH_CODE;?>"><?php echo $row_brn->BRANCH_NAME?></option>

                              <?php } ?>

                            </select>

                          </div>

                        </div>

                        <p id="studenterr" ></p>

                    </div> 



                <div class="col-md-2">
                                 <label for="to_date" >&nbsp;</label>
                 <button type="button" class="btn btn-block action-button btn-sm" onclick="showMember();" style="width: 60%;">Show</button>



                   <!-- Total <span class="badge" id="total_amount_value">7</span> -->

               </div>

              </div>



              </div> <!-- End of search block -->





              <div class="formblock-box">

                <div style="text-align: center;display:none;" id="loader">

                   <img src="<?php echo base_url(); ?>assets/img/loader.gif" width="90" height="90" id="gear-loader" style="margin-left: auto;margin-right: auto;"/>

                   <span style="color: #bb6265;">Loading...</span>

               </div>

              <div id="ajaxLoadData">

            

            

              </div>



              </div>

             

            </div><!-- /.card-body -->

        </div><!-- /.card -->

  </section>


  <div class="modal fade" id="editMemberModal" tabindex="-1" role="dialog" aria-labelledby="editMemberModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 80%;background:#f2f2f2;">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>

                </button> -->
                 <h4 class="modal-title" id="myModalLabel" style="color:#ff614c;">Edit Member Personal & Payment Info</h4>

            </div>
            <div class="modal-body" style="overflow-y:scroll;">
               <div id="loadMemDtl"></div>
            </div>
            <div class="modal-footer">
                <!--<button type="button" class="btn btn-default" data-dismiss="modal"></button>-->
                <button type="button" class="btn btn-success" data-dismiss="modal" onclick="backtoList();" >Back to List</button>
            </div>
        </div>
    </div>
</div>
