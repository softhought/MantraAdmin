<script src="<?php echo base_url(); ?>assets/js/customJs/registration/member_info.js"></script>

<style>
	.date_sect
	{
		display:none;
	}

	.datepicker table{
		font-size:13px;
	}
		.datepicker table tr td, .datepicker table tr th {
		text-align: center;
		width: 29px;
		height: 26px;
		border-radius: 4px;
		border: 0px none;
	}
	.datepicker table tr td.today, .datepicker table tr td.today:hover, .datepicker table tr td.today.disabled, .datepicker table tr td.today.disabled:hover {
		background:#F2652C;
		color:#FFF;
		font-weight:bold;
	}
		.datepicker.dropdown-menu th, .datepicker.dropdown-menu td {
		padding: 0px 1px;
	}

	#editMemberModal .modal-body
	{

		height:580px;
		max-height:540px;
	}

	#editMemberModal .nav > li > a
	{
		font-size:12px;
		text-decoration:none;
		color:#F34C27;
		font-weight:700;
	}


	.mem-info-table
	{
		width: 90%;
		margin: 10px auto;
		font-size: 12px;
		color: #F25F1C;

	}
	.mem-info-inpt
	{
		width: 90%;
		height: 22px;
		border-radius: 0px;
		border: 1px solid #f8723f;
		border-radius: 5px;
		color: #E8601F;
	}
	.txt_header
	{
		width:25%;

	}
	.edit-title
	{
		/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#ff4111+0,f2a4a4+100 */
		background: #ff4111; /* Old browsers */
		background: -moz-linear-gradient(left, #ff4111 0%, #f2a4a4 100%); /* FF3.6-15 */
		background: -webkit-linear-gradient(left, #ff4111 0%,#f2a4a4 100%); /* Chrome10-25,Safari5.1-6 */
		background: linear-gradient(to right, #ff4111 0%,#f2a4a4 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ff4111', endColorstr='#f2a4a4',GradientType=1 ); /* IE6-9 */3

		width: 75%;
		margin: 20px auto;
		padding: 8px 0;
		border-radius: 50px;
		font-size: 15px;
		text-indent: 16px;
		color: #FFF;

	}
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
</style>

  <section class="layout-box-content-format1">

        <div class="card card-primary">

            
<!-- 
            <div class="list-summary">

              <div class="row summary-box-container">



                <div class="col-md-9  bg-3">

                

                </div>

                <div class="col-md-3 summary-box bg-4">

                  <div class="row">

                    <div class="col-md-3 align-vh-center">

                      <i class="fab fa-algolia"></i>

                    </div>

                    <div class="col-md-9">

                      <h3>Total Amount</h3>

                      <h4><span  id="total_amount_value"></span></h4>

                    </div>

                  </div>

                </div>

                

              </div>

            </div> -->





            <div class="card-header box-shdw">

              <h3 class="card-title">Edit Member Info</h3>

               <!-- <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >

                  <a href="<?php echo base_url(); ?>order/addOrder" class="btn btn-info btnpos">

                  <i class="fas fa-plus"></i> Add </a>

                </div> -->

     

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
                    <label for="from_dt" >From Payment Date</label>
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
                     <label for="to_date" >To Payment Date</label>
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
