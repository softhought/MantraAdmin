<!DOCTYPE html> 

<html>

<head>

  <meta charset="utf-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>Mantra | Login</title>

  <!-- Tell the browser to be responsive to screen width -->

  <meta name="viewport" content="width=device-width, initial-scale=1">



  <!-- Font Awesome -->

  <link rel="stylesheet" href="<?php echo(base_url());?>assets/plugins/fontawesome-free/css/all.min.css">

  <!-- Ionicons -->

  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

  <!-- icheck bootstrap -->

  <link rel="stylesheet" href="<?php echo(base_url());?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">

  <!-- Theme style -->

  <link rel="stylesheet" href="<?php echo(base_url());?>assets/dist/css/adminlte.min.css">
  

  <!-- Google Font: Source Sans Pro -->

  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo(base_url());?>assets/css/login.css">

</head>

<body class="hold-transition login-page">

<div class="login-box" style="width:450px;">

  <div class="login-logo" >

    <!-- <a href="../../index2.html"><b>Admin</b>LTE</a> -->

    <!-- <img src="<?php echo(base_url());?>assets/img/logo-dks.png" width="355px" height="50px" alt=" Dakshin Kalikata Sansad Logo" class="brand-image " style="opacity: .8"> -->

  </div>

  <!-- /.login-logo -->

  <div class="card">

    <div class="card-body login-card-body">

      <p class="login-box-msg">Sign in to start your session</p>



      

      <form class="login-form"  name="loginfrm" method="post" action="<?php echo(base_url());?>admin/checklogin">
     
      <div class="form-group  mb-3">
            
            <div class="input-group">
            <label for="registration_no" class="">Registration no.</label>
            <input type="text" name="registration_no" id="registration_no" class="form-control" placeholder="Registration no.">
            <div class="input-group-append">
                <div class="input-group-text">
                    <!-- <span class="fas fa-user-alt"></span> -->
                </div>
            </div>
            
            </div> 
      </div>
      <div class="form-group  mb-3">           

            <div class="input-group">
            <label for="company" class="">Company</label> 
                
                    <select name="company" id="company" class="custom-select">
                                        <option value="">Select</option>
                                                                

                    </select>
                
            
            
            </div> 
      </div>

      <div class="form-group  mb-3">
          <div class="input-group">
             <label>Branch</label>
                <select name="branch" id="branch" class="custom-select">
                    <option value="">Select</option>
                                              

                </select>
                     </div>

                      

            <?php echo form_error('year'); ?>

        </div>

        <div class="form-group  mb-3">

           

            <div class="input-group">
            <label for="username" class="">Username</label> 
            <input type="text" name="username" id="username" class="form-control" placeholder="User name">

            <div class="input-group-append">

                <div class="input-group-text">

                    <span class="fas fa-user-alt"></span>

                </div>

            </div>

            </div> 

          <?php echo form_error('username'); ?>

        </div>

        <div class="form-group  mb-3">

      

            <div class="input-group">
            <label for="password" class="">Password</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Password">

            <div class="input-group-append">

                <div class="input-group-text">

                    <span class="fas fa-lock"></span>

                </div>

            </div>

            </div> 

            <?php echo form_error('password'); ?>

        </div>

        <div class="form-group  mb-3 marginbottom">
            <div class="input-group">
             <label>Year</label>

                <select name="yearid" id="yearid" class="custom-select">

                    <option value="">Select</option>

                     <?php 

                     foreach ($financilayear as $financilayear) { ?>
                       

                       <option value="<?php echo $financilayear->year_id; ?>"><?php echo $financilayear->acc_period; ?></option>


                     <?php } ?>                          

                </select>
                     </div>

                      

            <?php echo form_error('year'); ?>

        </div>

        <?php echo $this->session->flashdata('msg'); ?>

        <div class="row ">

          <div class="col-12">

            <button type="submit" class="btn btn-primary btn-block">Sign In</button>

          </div>

          <!-- /.col -->

        </div>

      </form>

     <input type="hidden" name="basepath" id="basepath" value="<?php echo base_url(); ?>" >

      <!-- /.social-auth-links -->



    </div>

    <!-- /.login-card-body -->

  </div>

</div>

<!-- /.login-box -->



<!-- jQuery -->

<script src="<?php echo(base_url());?>assets/plugins/jquery/jquery.min.js"></script>

<!-- Bootstrap 4 -->

<script src="<?php echo(base_url());?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- AdminLTE App -->

<script src="<?php echo(base_url());?>assets/dist/js/adminlte.min.js"></script>

<script src="<?php echo(base_url());?>assets/js/customJs/login.js"></script>

</body>

</html>

