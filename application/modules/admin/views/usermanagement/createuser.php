<script src="<?php echo base_url();?>assets/js/customJs/user.js"></script>

<section class="layout-box-content-format1">

        <div class="card card-primary">

            <div class="card-header box-shdw">

              <h3 class="card-title">Create User</h3>

               <div class="btn-group btn-group-sm float-right" role="group" aria-label="MoreActionButtons" >

              <a href="<?php echo admin_with_base_url(); ?>user" class="btn btn-info btnpos link_tab">

              <i class="fas fa-clipboard-list"></i> List </a>

                </div>

             <!--  <a href="<?php echo base_url();?>user" class="link_tab"><span class="glyphicon glyphicon-plus"></span> List</a> -->

            </div><!-- /.card-header -->



            <div class="card-body">

                <div class="formblock-box">

                

                <form onsubmit="return CreateUserFrmValidate();" action="store" id="CreateUserFrm" method="post">

                    <div class="row">

                        <div class="col-md-4">

                            <label for="name">Name *</label>

                            <div class="form-group">

                            <div class="input-group input-group-sm">

                            <input type="text" class="form-control forminputs typeahead" id="name" name="name" placeholder="Enter Name" autocomplete="off" >

                        </div>

                            </div>

                        </div>

                         <div class="col-md-4">

                            <label for="user_name">Username *</label>

                            <div class="form-group">

                            

                            <div class="input-group input-group-sm">

                            <input type="text" class="form-control forminputs typeahead" id="user_name" name="user_name" placeholder="Enter Username" autocomplete="off" >

                        </div>

                    </div>

                        </div>

                        <div class="col-md-4">

                            <label for="mobile_no">Mobile No.</label>

                          <div class="form-group">

                               <div class="input-group input-group-sm">

                            <input type="text" class="form-control forminputs typeahead" id="mobile_no" name="mobile_no" placeholder="Enter Mobile No." autocomplete="off" >

                        </div>

                    </div>

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-4">

                            <label for="user_role_id">User Role*</label>

                        <div id="user_role_idDiv" class="form-group">      

                         <div class="input-group input-group-sm">                    

                            

                            <select class="form-control select2" data-show-subtext="true" name="user_role_id" id="user_role_id" data-live-search="true"  >

                                <option  value="0">Select</option>

                                <?php foreach ($userRoleList as $value) { ?>

                                    <option  value="<?php echo $value->id; ?>" ><?php echo $value->role; ?></option>   

                                <?php  }  ?>                                        

                            </select>

                        </div>

                    </div>

                        </div>

                        <div class="col-md-4">

                             <label for="password">Password *</label>

                        <div class="form-group">

                            <div class="input-group input-group-sm">

                            <input type="password" class="form-control forminputs typeahead" id="password" name="password" placeholder="Enter Mobile No." autocomplete="off" >

                        </div>

                      </div>

                        

                    </div>

                    <div class="col-md-4">

                        <div class="form-group">

                             <label for="cpassword">Confirm Password *</label>

                            <div class="input-group input-group-sm">

                           

                            <input type="password" class="form-control forminputs typeahead" id="cpassword" name="cpassword" placeholder="Enter Mobile No." autocomplete="off" >

                        </div>

                    </div>

                        </div>

                    </div>



                       </div>

                        </div>

                      <div class="formblock-box">

                        <div class="row">

                            <div class="col-md-10"></div>

                            <div class="col-md-2">

                                <button type="submit" class="btn btn-sm action-button padbtn">Create</button>

                            </div>

                        </div>



                        

                    </div>

                </form>

                



         

            </div><!-- /.card-body -->

        </div>

    </section>