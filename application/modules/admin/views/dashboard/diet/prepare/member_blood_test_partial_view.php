  <div class="row">
 <div class="col-md-2">
 	&nbsp;&nbsp;<button class="btn btn-block btn-outline-info btn-sm" style="width:180px;">Prediocial Blood Test</button></div>
 <div class="col-md-1"></div>
   <div class="col-md-1">
 	&nbsp;&nbsp;<button class="btn btn-block btn-outline-danger btn-sm showAddTest" style="width:180px;"><i class="fas fa-plus"></i> Add Test</button><button class="btn btn-block btn-outline-warning btn-sm showTestList" style="width:180px;display:none;margin-top: 0px;"><i class="fas fa-clipboard-list"></i> Test List</button>
 	
 </div>
</div>


  <br><br>
  <div id="test_list_div">
  <table class="table table-bordered table-condensed dataTable" style="font-size: 11px;color:#cc6b58;margin-top: 10px;">
    <thead>
      <tr style="background: #f3f3f3;color: #742796;">
        
        <td style="width: 2%;">Sl</td>
		<td style="width: 8%;">Date</td>
		<td style="width: 25%;">Test Type</td>
		<td style="width: 15%;">Reading</td>
		<td>Note</td>
        
      </tr>
    </thead>
    <tbody>
   	<?php 
		$m = 1;$i =1;
	foreach($rowBloodReport as $blood_report){ 
		
	?>
		<tr style="color: #6D6E71; background-color: #fff; " id="activeeditrow_<?php echo $i; ?>">
			<td><?php echo $m++; ?></td>
			<td><?php echo date('d-m-Y',strtotime($blood_report->date_of_collection)); ?></td>
			<td><?php echo $blood_report->test_desc; ?></td>
			<td><?php echo $blood_report->reading; ?></td>
			<td><?php echo $blood_report->note; ?></td>
			
		</tr>
		
		
		
	<?php $i++;}  ?>
    
    
    </tbody>
  </table>
  </div>

  <div id="add_test_div" style="display:none;">
   <div class="row" >
                          <div class="col-md-2">
                          <div class="form-group">
                            <label for="eqpname">Collection Date</label>
                          <div class="input-group input-group-sm" id="bill_dterr">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                            </div>
                              <input type="text" class="form-control datemask" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask name="collectiont_dt" id="collectiont_dt" value="<?php echo date('d/m/Y');?>">
                          </div>

                        </div>

                 </div>
                           
                              <div class="col-md-3">
                                      <div class="form-group">
                                        <label for="code">Test</label>
                                          <div class="input-group input-group-sm" id="sel_blood_testerr">
                                          <select class="form-control  clrselct select2" name="sel_blood_test" id="sel_blood_test"  style="width: 100%;">
                                         	<option value="" data-unitdesc="">Select</option>
                                            <?php
                                            foreach ($rowBloodTest as $row_test) {  
                                          ?>
                                          <option value="<?php echo $row_test->blood_id?>" data-unitdesc="<?php echo $row_test->unit_desc;?>"  ><?php echo $row_test->test_desc;?></option>
                                          <?php }?>
                                        </select>
                                        </div>
                                      </div>
                            </div>
                                
                             
                        
                           <div class="col-md-1">
                                      <div class="form-group">
                                        <label for="code">Unit</label>
                                        <div class="input-group input-group-sm" >
                                          <input type="text" class="form-control  clrField " name="sel_blood_test_unit" id="sel_blood_test_unit"  value="" readonly>
                                       
                                        </div>
                                      </div>
                           </div>

                               <div class="col-md-1">
                                      <div class="form-group">
                                        <label for="code">Reading</label>
                                        <div class="input-group input-group-sm" >
                                          <input type="text" class="form-control  clrField " name="txtQty" id="txtQty"  value=""  onkeyup="return numericFilter(this);">
                                       
                                        </div>
                                      </div>
                           </div>
                                 <div class="col-md-4">
                                <div class="form-group">
                                  <label for="code">Note</label>
                                  <div class="input-group input-group-sm" >
                                   <textarea class="form-control clrField" id="test_notes" name="test_notes" style="width: 200px;height: 30px;resize:none;"></textarea>
                                  </div>
                                </div>
                            </div>  
                         <div class="col-md-1">
                          <div class="form-group">
                            <label for="firstname">&nbsp;</label>
                              <div class="input-group input-group-sm">
                           <button type="button" class="btn btn-md action-button actinct actibtn" id="bloodSave_btn">
                          <i class="fas fa-paper-plane"></i> Save</button>
                            </div>

                          </div>
                     </div> 
                      </div>
  </div>
  <center>
  	<p id="msg_blood" style="font-weight: bold;
font-size: 18px;
color: #5bc65b;"></p>
  </center>
