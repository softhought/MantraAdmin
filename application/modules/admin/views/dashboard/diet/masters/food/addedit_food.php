<link rel="stylesheet" href="<?php echo base_url(); ?>assets//plugins/summernote/summernote-bs4.css">
<script src="<?php echo base_url(); ?>assets/plugins/summernote/summernote-bs4.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
  $('.textarea').summernote();
  basepath = $("#basepath").val();
 var row = 1;
  $("#corporatecompanylist").DataTable();

  // $(document).on("click", ".videostatus", function () {
  //   var uid = $(this).data("videoid");
  //   var status = $(this).data("setstatus");
  //   var url = basepath + "youtubevideo/setStatus";
  //   setActiveStatus(uid, status, url);
  // });

  $(document).on("click", "#othersavebtn", function (event) {
    event.preventDefault();

    if (valiadateform()) {

        var formData = $("#otherFrom").serialize();
      formData = decodeURI(formData);
      $(".othersavebtn").attr("disabled", true);
      $.ajax({
        type: "POST",
        url: basepath + "otherassistance/other_action",
        dataType: "json",
        data: { formData: formData },
        success: function (res) {
          console.log(res);
          if (res.msg_status == 1) {
            $(".othersavebtn").attr("disabled", false);
            window.location.href = basepath + 'otherassistance';

            //location.reload();
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
$(document).on('click','.del_icon',function(){
	
	var attrVal = $(this).attr('id');
	var Dtl = attrVal.split('_');
	var rowID = Dtl[1]
	$("#componentDtl_"+rowID).remove();
	
});
	
  $(document).on("click","#addComponent",function(){


	$.ajax({
		url:basepath + "otherassistance/addComponentDetail",
		type:"POST",
		dataType:"html",
		data:{row:row},
		success:function(res){
			$("#componentDtlTable").append(res);
			row++;
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
  var other_assistnc_catg = $("#other_assistnc_catg").val();
  var supplement_name = $("#supplement_name").val();
  var quantity = $("#quantity").val();
  var other_assistnc_unit = $("#other_assistnc_unit").val();

  $("#errormsg").text("");
  $("#other_assistnc_catgerr,#supplement_name,#quantity,#other_assistnc_uniterr").removeClass("form_error");

  if (other_assistnc_catg == "0") {
    $("#other_assistnc_catgerr").addClass("form_error");
    return false;
  }

  if (supplement_name == "") {
    $("#supplement_name").addClass("form_error");
    return false;
  }

  if (quantity == "") {
    $("#quantity").addClass("form_error");
    return false;
  }
  if (other_assistnc_unit == "") {
    $("#other_assistnc_uniterr").addClass("form_error");
    return false;
  }
  

  return true;
}
function numericFilter(txb) {
  txb.value = txb.value.replace(/[^\0-9]/gi, "");
}
</script>

<style>
#componentDtlTable
{
	background:#ece5e2;
	padding: 1%;
	border-radius: 10px;
	font-size: 13px;
	margin-top: 1%;
	color: #FFF;
font-weight: 700;
}
.inp_txt_dtl
{
	height:22px;
	border:none;
	border-radius: 2px;
	border-color: #ad8c75;
}
.note-popover .popover-content, .card-header.note-toolbar {
    padding: 0 0 5px 5px;
    margin: 0;
    background: #f5f5f5!important;
}

.card-header.note-toolbar {
    padding: 0 0 5px 5px;
    margin: 0;
    background: #b63c94 !important;
        background-color: rgb(245, 245, 245);
}
</style>
<section class="layout-box-content-format1">

        <div class="card card-primary">
        

                      <div class="card-header box-shdw">
                        <h3 class="card-title">Food Master  </h3>
                        <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >
                        <a href="<?php echo admin_with_base_url(); ?>food" class="btn btn-info btnpos">
                        <i class="fas fa-clipboard-list"></i> List </a>
                          </div>           
                      </div><!-- /.card-header -->



                    <form name="otherFrom" id="otherFrom" enctype="multipart/form-data">
                    <input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>">
                    <input type="hidden" name="foodId" id="foodId" value="<?php echo $foodId; ?>">
                  <div class="card-body">


                    <div class="formblock-box">
                        <h3 class="form-block-subtitle"><i class="fas fa-angle-double-right"></i>  Info</h3>   
                        <div class="row">
                              
                                    <div class="col-md-5">
                                      <label for="groupname">Food Name
                                      <span id="company_name_err" style="color:red;font-weight:bold;"></span></label>
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">
                                          <input type="text" class="form-control" name="food_name" id="food_name"  autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $otherAssisEditdata->supplement_name; } ?>">
                                      </div>
                                    </div>                        
                                    </div> 
                                           <div class="col-md-2">
                                      <label for="groupname">Food Type
                                      <span id="subgroup_name_err" style="color:red;font-weight:bold;"></span></label>
                                        <div class="form-group">
                                        <div class="input-group input-group-sm" id="other_assistnc_catgerr">
                                      <select class="form-control select2" id="other_assistnc_catg" name="other_assistnc_catg" style="width: 100%;">
                                           <option value="0">Select</option>
                                            <?php
                                                foreach ($rowFoodType as $food_type) { 
                                            ?>
                                            <option value='<?php echo $food_type->id;?>' <?php if($mode == 'EDIT' && $value->id==$otherAssisEditdata->othr_assis_catgID){ echo "selected"; } ?>><?php echo $value->othr_assistnc_name;?></option>
                                          
                                        <?php } ?>
                                            </select>
                                      </div>
                                    </div>                        
                                    </div> 
                                         
                                </div>

                                              
                              

                          

                              
                       
                              

                      </div>



                    </div>  <!-- /.card-body -->



               <div class="formblock-box">
                   <div class="row">
                          <div class="col-md-10">                    
                          <p id="errormsg" class="errormsgcolor"></p>
                          </div>
                         <div class="col-md-2 text-right">
                            <button type="submit" class="btn btn-sm action-button" id="othersavebtn" style="width: 60%;"><?php echo $btnText; ?></button>
                              <span class="btn btn-sm action-button loaderbtn" id="loaderbtn" style="display:none;width: 60%;"><?php echo $btnTextLoader; ?></span>

                           </div>               
                   </div>                 
                 </div>





             </form>

       

         

        </div><!-- /.card -->


  </section>

  



