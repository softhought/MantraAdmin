<link rel="stylesheet" href="<?php echo base_url(); ?>assets//plugins/summernote/summernote-bs4.css">
<script src="<?php echo base_url(); ?>assets/plugins/summernote/summernote-bs4.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
  $('.textarea').summernote();
  basepath = $("#basepath").val();
 var row = 1;
  $("#corporatecompanylist").DataTable();



  $(document).on("click", "#advicesavebtn", function (event) {
    event.preventDefault();

    if (valiadateform()) {

        var formData = $("#adviceFrom").serialize();
      formData = decodeURI(formData);
      $(".advicesavebtn").attr("disabled", true);
      $.ajax({
        type: "POST",
        url: basepath + "diet/advice_guideline_action",
        dataType: "json",
        data: { formData: formData },
        success: function (res) {
          console.log(res);
          if (res.msg_status == 1) {
            $(".advicesavebtn").attr("disabled", false);
            window.location.href = basepath + 'diet/guidelinelist';

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




}); /* end of document ready */

function valiadateform() {
  var disease = $("#disease").val();
  var disease_guidelines = $("#disease_guidelines").val();

  $("#errormsg").text("");
  $("#disease,#disease_guidelineserr").removeClass("form_error");


  if (disease == "") {
    $("#disease").addClass("form_error");
    return false;
  }

    if (disease_guidelines == "") {
    $("#disease_guidelineserr").addClass("form_error");
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
                        <h3 class="card-title">Disease Nutrition Guidelines </h3>
                        <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >
                        <a href="<?php echo admin_with_base_url(); ?>diet/guidelinelist" class="btn btn-info btnpos">
                        <i class="fas fa-clipboard-list"></i> List </a>
                          </div>           
                      </div><!-- /.card-header -->



                    <form name="adviceFrom" id="adviceFrom" enctype="multipart/form-data">
                    <input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>">
                    <input type="hidden" name="guidelineId" id="guidelineId" value="<?php echo $guidelineId; ?>">
                  <div class="card-body">


                    <div class="formblock-box">
                        <h3 class="form-block-subtitle"><i class="fas fa-angle-double-right"></i>  Info</h3>    
                                              
                              <div class="row">
                             <label for="prot" class="col-md-2 labletext">Disease</label>
                                    <div class="col-md-10">
                                      <label for="groupname">
                                      <span id="company_name_err" style="color:red;font-weight:bold;"></span></label>
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">
                                          <input type="text" class="form-control" name="disease" id="disease"  autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $guideEditdata->disease; } ?>">
                                      </div>
                                    </div>                        
                                    </div> 
                                         
                                </div>

                         <div class="row">
                                <label for="prot" class="col-md-2 labletext">Guidelines</label>
                                <div class="col-md-10" id="disease_guidelineserr">
                                    
                                      <textarea  placeholder="Place some text here" class="textarea" id="disease_guidelines" name="disease_guidelines"  style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php if($mode=='EDIT'){echo $guideEditdata->disease_guidelines;} ?></textarea>
                                                         
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
                            <button type="submit" class="btn btn-sm action-button" id="advicesavebtn" style="width: 60%;"><?php echo $btnText; ?></button>
                              <span class="btn btn-sm action-button loaderbtn" id="loaderbtn" style="display:none;width: 60%;"><?php echo $btnTextLoader; ?></span>

                           </div>               
                   </div>                 
                 </div>





             </form>

       

         

        </div><!-- /.card -->


  </section>

  



