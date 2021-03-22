<link rel="stylesheet" href="<?php echo base_url(); ?>assets//plugins/summernote/summernote-bs4.css">
<script src="<?php echo base_url(); ?>assets/plugins/summernote/summernote-bs4.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
  $('.textarea').summernote();
  basepath = $("#basepath").val();
 var row = 1;
  $("#corporatecompanylist").DataTable();



  $(document).on("click", "#unitsavebtn", function (event) {
    event.preventDefault();

    if (valiadateform()) {

        var formData = $("#unitFrom").serialize();
      formData = decodeURI(formData);
      $(".unitsavebtn").attr("disabled", true);
      $.ajax({
        type: "POST",
        url: basepath + "diet/unit_action",
        dataType: "json",
        data: { formData: formData },
        success: function (res) {
          console.log(res);
          if (res.msg_status == 1) {
            $(".unitsavebtn").attr("disabled", false);
            window.location.href = basepath + 'diet/unitlist';

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
  var unit_name = $("#unit_name").val();

  $("#errormsg").text("");
  $("#unit_name").removeClass("form_error");


  if (unit_name == "") {
    $("#unit_name").addClass("form_error");
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
                        <h3 class="card-title">Unit </h3>
                        <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >
                        <a href="<?php echo admin_with_base_url(); ?>diet/unitlist" class="btn btn-info btnpos">
                        <i class="fas fa-clipboard-list"></i> List </a>
                          </div>           
                      </div><!-- /.card-header -->



                    <form name="unitFrom" id="unitFrom" enctype="multipart/form-data">
                    <input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>">
                    <input type="hidden" name="unitId" id="unitId" value="<?php echo $unitId; ?>">
                  <div class="card-body">


                    <div class="formblock-box">
                        <h3 class="form-block-subtitle"><i class="fas fa-angle-double-right"></i>  Info</h3>    
                                              
                              <div class="row">
                              <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                      <label for="groupname">Unit Name
                                      <span id="company_name_err" style="color:red;font-weight:bold;"></span></label>
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">
                                          <input type="text" class="form-control" name="unit_name" id="unit_name"  autocomplete="off" value="<?php if($mode == 'EDIT'){ echo $unitEditdata->unit_name; } ?>">
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
                            <button type="submit" class="btn btn-sm action-button" id="unitsavebtn" style="width: 60%;"><?php echo $btnText; ?></button>
                              <span class="btn btn-sm action-button loaderbtn" id="loaderbtn" style="display:none;width: 60%;"><?php echo $btnTextLoader; ?></span>

                           </div>               
                   </div>                 
                 </div>





             </form>

       

         

        </div><!-- /.card -->


  </section>

  



