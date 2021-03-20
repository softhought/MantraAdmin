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
                        <h3 class="card-title">Other Assistance  </h3>
                        <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >
                        <a href="<?php echo admin_with_base_url(); ?>otherassistance" class="btn btn-info btnpos">
                        <i class="fas fa-clipboard-list"></i> List </a>
                          </div>           
                      </div><!-- /.card-header -->



                    <form name="otherFrom" id="otherFrom" enctype="multipart/form-data">
                    <input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>">
                    <input type="hidden" name="otherassId" id="otherassId" value="<?php echo $otherassId; ?>">
                  <div class="card-body">


                    <div class="formblock-box">
                        <h3 class="form-block-subtitle"><i class="fas fa-angle-double-right"></i>  Info</h3>    
                          <div class="row">
                              <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                      <label for="groupname">Category
                                      <span id="subgroup_name_err" style="color:red;font-weight:bold;"></span></label>
                                        <div class="form-group">
                                        <div class="input-group input-group-sm" id="other_assistnc_catgerr">
                                      <select class="form-control select2" id="other_assistnc_catg" name="other_assistnc_catg" style="width: 100%;">
                                           <option value="0">Select</option>
                                            <?php
                                                foreach ($otherAssisCatg as $key => $value) {
                                                
                                            ?>
                                            <option value='<?php echo $value->id;?>' <?php if($mode == 'EDIT' && $value->id==$otherAssisEditdata->othr_assis_catgID){ echo "selected"; } ?>><?php echo $value->othr_assistnc_name;?></option>
                                          
                                        <?php } ?>
                                            </select>
                                      </div>
                                    </div>                        
                                    </div> 
                
                                </div>                      
                              <div class="row">
                              <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                      <label for="groupname">Supplement Name
                                      <span id="company_name_err" style="color:red;font-weight:bold;"></span></label>
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">
                                          <input type="text" class="form-control" name="supplement_name" id="supplement_name"  autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $otherAssisEditdata->supplement_name; } ?>">
                                      </div>
                                    </div>                        
                                    </div> 
                                         
                                </div>

                              <div class="row">
                              <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                      <label for="groupname">Quantity
                                      <span id="subgroup_name_err" style="color:red;font-weight:bold;"></span></label>
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">
                                          <input type="text" class="form-control" name="quantity" id="quantity" placeholder="" autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $otherAssisEditdata->quantity; } ?>" onkeyup="return numericFilter(this);">
                                      </div>
                                    </div>                        
                                    </div> 
                
                                </div>
                           
                                <div class="row">
                              <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                      <label for="groupname">Unit
                                      <span id="subgroup_name_err" style="color:red;font-weight:bold;"></span></label>
                                        <div class="form-group">
                                        <div class="input-group input-group-sm" id="other_assistnc_uniterr">
                                      <select class="form-control select2" id="other_assistnc_unit" name="other_assistnc_unit" style="width: 100%;">
                                           <option value="0">Select</option>
                                            <?php
                                                foreach ($rowFoodUnit as $key => $value) {
                                                
                                            ?>
                                            <option value='<?php echo $value->id;?>' <?php if($mode == 'EDIT' && $value->id==$otherAssisEditdata->unit_id){ echo "selected"; } ?>><?php echo $value->unit_name;?></option>
                                          
                                        <?php } ?>
                                            </select>
                                      </div>
                                    </div>                        
                                    </div> 
                
                                </div> 

                                  <div class="row">
                              <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                      <label for="groupname">Brand
                                      <span id="subgroup_name_err" style="color:red;font-weight:bold;"></span></label>
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">
                                          <input type="text" class="form-control" name="brand" id="brand" placeholder="" autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $otherAssisEditdata->brand; } ?>" >
                                      </div>
                                    </div>                        
                                    </div> 
                
                                </div>
             <?php
             
   $this->load->model('dietmodel','_dietmodel',TRUE);
             ?>  
<div class="row">
<div class="col-md-2"></div>
<div class="col-md-8">
<span class="btn btn-danger btn-sm name="addComponent" id="addComponent" >Add Component if any</span>
             <!-- -------------------------------------------------------------------------------- --> 
             		<table id="componentDtlTable" class="table table-bordered" style="font-size: 13px;color: #354668;line-height:0.8;">
                 
						<?php 
							if($mode=="EDIT" AND $otherassId!=0){
								$rowOtherAssistanceDetail = $this->_dietmodel->GetOtherAssistanceDetail($otherassId);
								/*
								echo "<pre>";
								print_r($rowOtherAssistanceDetail);
								echo "</pre>";
								*/
						
							foreach($rowOtherAssistanceDetail as $otherAssistanceDtl)
							{
								$dtl_unit = $otherAssistanceDtl->unit_id;
						?>
							
							<tr id="componentDtl_<?php echo $otherAssistanceDtl->id."E"; ?>" style="">
								<td>Component </td>
								<td><input type="text" id="componentName_<?php echo $otherAssistanceDtl->id."E"; ?>" class="inp_txt_dtl componentName" name="componentName[]" value="<?php echo $otherAssistanceDtl->component; ?>" style="width:260px;"/></td>
								
							
								<td><a href="javascript:;" id="deleteID_<?php echo $otherAssistanceDtl->id."E";?>" class="del_icon" style="color:#FFF;">
                <i class="far fa-trash-alt" style="color: #d04949;; font-weight:700;"></i></a></td>
								
							</tr>

						<?php	
								
								}
							}
						?>
						
						
						
					</table>  
             </div>
                        </div>          

             <!-- -------------------------------------------------------------------------------- --> 
                       
                             <div class="row">
                                <label for="prot" class="col-md-2 labletext">Special Note</label>
                                <div class="col-md-8">
                                    
                                      <textarea  placeholder="Place some text here" class="textarea" id="supplement_remarks" name="supplement_remarks"  style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php if($mode=='EDIT'){echo $otherAssisEditdata->supplement_remarks;} ?></textarea>
                                                         
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

  



