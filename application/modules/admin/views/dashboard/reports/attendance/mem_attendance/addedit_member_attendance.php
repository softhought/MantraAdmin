<script src="<?php echo base_url();?>assets/js/customJs/reports/attendance.js"></script>

<section class="layout-box-content-format1">
        <div class="card card-primary">
            <div class="card-header box-shdw">
              <h3 class="card-title">Member's Attendance</h3>
               <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >
                   <!-- <a href="<?php echo admin_with_base_url(); ?>enquirywing" class="btn btn-info btnpos link_tab">
                  <i class="fas fa-clipboard-list"></i> List </a> -->
                </div>
           
            </div><!-- /.card-header -->
            <div class="card-body">
               <form name="MemberattendaneForm"  id="MemberattendaneForm" enctype="multipart/form-data"> 

               <input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>">
                <input type="hidden" name="tranId" id="tranId" value="<?php echo $tranId; ?>">
              

                <div class="formblock-box">  
                  <div class="row"> 
                      <div class="col-md-8">
                    <div class="row">
                         <label class="col-md-3" for="enquiry_dt">Time Now </label> 
                         <label class="col-md-9 font14"><span id="clock">&nbsp;</span> </label>  
                      </div>
                   
                         
                        <div class="row">     
                           <label class="col-md-3 labletext" >Mobile No</label>
                                <div class="col-md-9">                                       
                                        <div class="form-group">
                                        <div class="input-group input-group-sm">                                           
                                        
                                            <input type="text" class="form-control onlynumber" name="mobile_no" id="mobile_no" im-insert="false" value="<?php if($mode == 'EDIT'){ echo $attendenceEditdata->mobile_no; } ?>" >
                                        </div>
                                    </div>
                                </div>  
                               

                            </div>
                            <div class="row">     
                            <label class="col-md-3 labletext" >Package</label>
                                    <div class="col-md-9">                                       
                                            <div class="form-group">
                                            <div class="input-group input-group-sm">                                           
                                            <select class="form-control select2" id="package" name="package" style="width: 100%;">
                                            <option value=''>Select</option>
                                            
                                            </select>
                                                
                                            </div>
                                        </div>
                                    </div>  
                               

                            </div>

                            <div class="row">     
                            <label class="col-md-3 labletext" >Member Name</label>
                                    <div class="col-md-9">                                       
                                            <div class="form-group">
                                            <div class="input-group input-group-sm">                      
                                            <input type="text" class="form-control " name="mem_name" id="mem_name" im-insert="false" value="" readonly>             
                                           
                                                
                                            </div>
                                        </div>
                                    </div>

                                    
                               

                            </div>
                            </div>
                            <div class="col-sm-1"></div> 
                               <div class="col-sm-3">    

                                <img src='<?php  if($mode == 'EDIT' && $comapnyEditdata->logo_name != ''){ ?> <?php echo base_url(); ?>assets/img/company-logo/<?php echo $comapnyEditdata->logo_name; } ?>' id="showimage" style="width: 125px;height:150px;border: 1px solid #6d78cb;margin-bottom:13px; ">
                           
                            
                             </div>                          
                        
                        </div> 
                            <div class="row">     
                            <label class="col-md-2 labletext" >Membership No.</label>
                                    <div class="col-md-3">                                       
                                            <div class="form-group">
                                            <div class="input-group input-group-sm">                      
                                            <input type="text" class="form-control " name="membership_no" id="membership_no" im-insert="false" value="" readonly>             
                                           
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <label class="col-md-2 labletext" >Trainer</label>
                                    <div class="col-md-4">                                       
                                            <div class="form-group">
                                            <div class="input-group input-group-sm">                     
                                             <input type="text" class="form-control " name="trainer" id="trainer" im-insert="false" value="" readonly>             
                                           
                                                
                                            </div>
                                        </div>
                                    </div>    
                               

                            </div>
                            <div class="row">     
                            <label class="col-md-2 labletext" >HAV Point<br></label>
                                    <div class="col-md-3">                                       
                                            <div class="form-group">
                                            <div class="input-group input-group-sm">                      <input type="text" class="form-control " name="mem_name" id="mem_name" im-insert="false" value="<?php if($mode == 'EDIT'){ echo $attendenceEditdata->mobile_no; } ?>" >             
                                           
                                                
                                            </div>
                                        </div>
                                    </div>  
                                    <label class="col-md-2 labletext" >Validity Pd</label>
                                    <div class="col-md-4">                                       
                                            <div class="form-group">
                                            <div class="input-group input-group-sm">                      <input type="text" class="form-control " name="mem_name" id="mem_name" im-insert="false" value="<?php if($mode == 'EDIT'){ echo $attendenceEditdata->mobile_no; } ?>" >             
                                           
                                                
                                            </div>
                                        </div>
                                    </div>  
                               

                            

                        </div> 
                       
                    <div class="row">                                       
                         <label class="col-md-2" for="enquiry_dt">Due Amount </label> 
                                <div class="col-md-3">                                       
                                            <div class="form-group">
                                            <div class="input-group input-group-sm">                      <input type="text" class="form-control " name="mem_name" id="mem_name" im-insert="false" value="<?php if($mode == 'EDIT'){ echo $attendenceEditdata->mobile_no; } ?>" >             
                                           
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <label class="col-md-2 labletext" >Extension Days</label>
                                    <div class="col-md-4">                                       
                                            <div class="form-group">
                                            <div class="input-group input-group-sm">                      <input type="text" class="form-control " name="mem_name" id="mem_name" im-insert="false" value="<?php if($mode == 'EDIT'){ echo $attendenceEditdata->mobile_no; } ?>" >             
                                           
                                                
                                            </div>
                                        </div>
                                    </div>
                      
                      </div>  

                       <div class="row">                                       
                         <label class="col-md-2" for="enquiry_dt">Actual Expiry Date </label> 
                                <div class="col-md-3">                                       
                                            <div class="form-group">
                                            <div class="input-group input-group-sm">                      <input type="text" class="form-control " name="mem_name" id="mem_name" im-insert="false" value="<?php if($mode == 'EDIT'){ echo $attendenceEditdata->mobile_no; } ?>" >             
                                           
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <label class="col-md-2 labletext" >Remaining Days</label>
                                    <div class="col-md-4">                                       
                                            <div class="form-group">
                                            <div class="input-group input-group-sm">                      <input type="text" class="form-control " name="mem_name" id="mem_name" im-insert="false" value="<?php if($mode == 'EDIT'){ echo $attendenceEditdata->mobile_no; } ?>" >             
                                           
                                                
                                            </div>
                                        </div>
                                    </div>
                      
                      </div>

                      <div class="row">                                       
                         <label class="col-md-2" for="enquiry_dt">Any Comments </label> 
                                <div class="col-md-3">                                       
                                            <div class="form-group">
                                            <div class="input-group input-group-sm">                      <textarea  class="form-control " name="mem_name" id="mem_name" ></textarea>            
                                           
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <label class="col-md-2 labletext" >Today's Weight(in Kgs.)</label>
                                    <div class="col-md-4">                                       
                                            <div class="form-group">
                                            <div class="input-group input-group-sm">                      <input type="text" class="form-control " name="mem_name" id="mem_name" im-insert="false" value="<?php if($mode == 'EDIT'){ echo $attendenceEditdata->mobile_no; } ?>" >             
                                           
                                                
                                            </div>
                                        </div>
                                    </div>
                      
                      </div>  
                                                   
                </div>

                    <div class="formblock-box">
                        <div class="row">
                            <div class="col-md-10">
                               <p class="errormsgcolor" id="errormsg"></p>
                            </div>
                                <div class="col-md-2 text-right">
                                <button type="submit" class="btn btn-sm action-button" id="insavebtn" >IN</button>
                                <button type="submit" class="btn btn-sm action-button" id="outsavebtn" >OUT</button>

                                    <span class="btn btn-sm action-button loaderbtn" id="loaderbtn" style="display:none;width: 57%;"><?php echo $btnTextLoader; ?></span>

                                </div>
                            </div>
                    </div>
                    </form>
                               
         </div>
</div><!-- /.card-body -->

</section>