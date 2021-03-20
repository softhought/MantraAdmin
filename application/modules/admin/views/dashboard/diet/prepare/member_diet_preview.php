<script type="text/javascript">
 basepath = $("#basepath").val();
  $(document).on("click", "#dietDtlBtn", function (event) {
    var mobile_no = $("#mobile_no").val();

    $("#response_message").html("");

    if (ValiditeNumber()) {
      $("#member_diet_list").html("");
      $("#loader").css("display", "block");
      var formData = {
        mobile_no: mobile_no,
      };
      var method = "diet/getMemberDietPreviewList";
      var data = htmlshowajaxcomtroller(method, formData);
     
      $("#loader").css("display", "none");
      $("#member_diet_list").html(data);
    }
  });


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
</script>

<style>
#viewMemberMeal
{
	border:none;
	background: #f6713c;
	padding: 3px 24px;
	border-radius: 5px;
	color: #FFF;
	font-size: 14px;
	cursor:pointer;
	font-weight:700;
}

.memberMealContainer
{
	width: 94%;
	background: rgb(254, 254, 254);
	margin: 40px auto;
	height: 100%;
	border-radius: 1px;
	padding: 20px;
	box-shadow: 0 8px 6px -6px black;
	border-top-right-radius: 24px;
	border-top-left-radius: 24px;
  border-left:2px solid #97608b;
  border-right:2px solid #97608b;
	border-top: 8px solid #97608b;
}
.custom_table
{
	font-size:12px;
	margin: 6px 0;
  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
  transition: 0.3s;
}
#memb_cal_tab tbody tr:nth-child(even) {background: #d97878;color:#fff;}
#memb_cal_tab tbody tr:nth-child(odd) {background: #DEDC8F;color:#fff;}

#memb_calResult_tab tbody tr:nth-child(even) {background: #d97878;color:#fff;}
#memb_calResult_tab tbody tr:nth-child(odd) {background: #DEDC8F;color:#fff;}

#memPersonalInfo 
{
	width: 70%;
margin: 0 auto;
border: 2px solid #97608b;
    border-bottom-color: rgb(151, 96, 139);
    border-bottom-style: solid;
    border-bottom-width: 2px;
border-bottom: 5px solid #a26595;
padding: 10px;
border-radius: 13px;
font-size:14px;
}

#memberFoodDtl
{
	width: 100%;
	margin: 2% 0;
	border: 1px solid #d4d4d4;
	text-indent: 12px;width:100%;
	margin:2% 0;
}
#memberFoodDtl tr 
{
	height:25px;
}
#memTotalMealGivenTab 
{
	width:50%;
	margin:0 auto;
	border:0px solid #FFF;
	padding:10px;
	background: rgb(186, 181, 105);
	//box-shadow: 0 8px 6px -6px black;
	color:#FFF;
	//font-weight:700;
}
#memTotalMealGivenTab tr 
{
	height:22px;
}
.linkBtn
{
	width:20%;
	margin:0 auto;
	margin-top:30px;
	margin-bottom:15px;
}
.linkBtn a 
{
	text-decoration: none;
	background: #ce398c;
	padding: 6px 14px;
	border-radius: 5px;
	color: #FFF;
	font-size: 14px;
}
</style>

  <section class="layout-box-content-format1">

        <div class="card card-primary" style="border-bottom: 3px solid #d96692;">


            <div class="card-header box-shdw">
              <h3 class="card-title">Member's Meal List</h3>
              
               <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >

              <a href="<?php echo admin_with_base_url(); ?>diet/preparediet" class="btn btn-default btnpos">

               <i class="fas fa-plus"></i> Add </a>

            </div>
            </div><!-- /.card-header -->



            <div class="card-body">
            <div class="list-search-block">
               <div class="row box">
                
                    <div class="col-sm-4">
                  
                    </div>
                     
                        <div class="col-md-3 mob_sect">
                                         <label for="from_dt"> Member Mobile</label>
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">                                           
     <input type="text" class="form-control forminputs typeahead inputupper" maxlength="10" id="mobile_no" name="mobile_no" placeholder="Enter mobile" autocomplete="off" value="" onKeyUp="numericFilter(this);">
                                        </div>
                                    </div>
                                </div> 

                 

   



                <div class="col-md-2">
                                 <label for="to_date" >&nbsp;</label>
                 <button type="button" class="btn btn-block action-button btn-sm" id="dietDtlBtn"  style="width: 60%;">Show</button>



                   <!-- Total <span class="badge" id="total_amount_value">7</span> -->

               </div>

              </div>



              </div> <!-- End of search block -->





        

             

            </div><!-- /.card-body -->

        </div><!-- /.card -->

  </section>
        <div class="formblock-box">

                <div style="text-align: center;display:none;" id="loader">

                   <img src="<?php echo base_url(); ?>assets/img/loader.gif" width="90" height="90" id="gear-loader" style="margin-left: auto;margin-right: auto;"/>

                   <span style="color: #bb6265;">Loading...</span>

               </div>

              <div id="member_diet_list">

            

            

              </div>



              </div>



