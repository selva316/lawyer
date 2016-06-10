<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Bootstrap Admin Theme</title>
	
	<!-- Bootstrap Core CSS -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/bootstrap/dist/css/bootstrap.min.css" />
	<!-- Bootstrap Responsive CSS -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/bootstrap/bootstrap-responsive.min.css" />
	
    <link href="<?php echo base_url();?>assets/font-awesome/css/font-awesome.min.css"  rel="stylesheet" />

    <style type='text/css' media='screen'>

      body.login.example2 {
        background-image: url("/images/bg_2.png");
        background-color: rgba(255, 255, 255, 0);
      }
      body.login {
        color: #7F7F7F;
      }
      body, .main-container, .footer, .main-navigation, ul.main-navigation-menu > li > ul.sub-menu, .navigation-small ul.main-navigation-menu > li > ul.sub-menu {
        background-color: #F6F6F6 !important;
      }
      body {
        color: #000;
        direction: ltr;
        font-family: "Open+Sans",sans-serif;
        font-size: 13px;
        padding: 0px !important;
        margin: 0px !important;
        background: #FFF none repeat scroll 0% 0%;
      }          

      body.login .main-login {
        margin-top: 60px;
      }
      .login_message {
        padding: 6px 25px 20px 25px;
        color: #c33;
      }
      body.login .logo {
        padding: 20px;
        text-align: center;
      }

      body.login .box-forgot, body.login .box-register, body.login .box-login {
        display: none;
      }
      body.login .box-login, body.login .box-forgot, body.login .box-register {
        background: #FFF none repeat scroll 0% 0%;
        border-radius: 5px;
        box-shadow: -30px 30px 50px rgba(0, 0, 0, 0.32);
        overflow: hidden;
        padding: 15px;
      }
      .no-display {
        display: none;
      }
      span.input-icon, span.input-help {
        display: block;
        position: relative;
      }
      .input-icon > input {
        padding-left: 25px;
        padding-right: 6px;
      }
      body.login .form-actions {
        margin-top: 15px;
        padding-top: 10px;
        display: block;
      }
      .input-icon > [class*="fa-"], .input-icon > [class*="clip-"] {
        bottom: 0px;
        color: #909090;
        display: inline-block;
        font-size: 14px;
        left: 5px;
        line-height: 35px;
        padding: 0px 3px;
        position: absolute;
        top: 0px;
        z-index: 2;
      }
      body.login .copyright {
        font-size: 11px;
        margin: 0px auto;
        padding: 10px 10px 0px;
        text-align: center;
      }
    </style>

    <script>


    var is_ie_lt9 = false;

    </script>
</head>

<body>

  <div id='login' class="main-login col-sm-4 col-sm-offset-4">
    <div class="logo">
    <img src="<?php echo base_url();?>img/advocateq.png" style="width:300px;height: 90px;" alt="Law Logo" />
    </div>
    <div style="display: block;" class="box-login">
      <h3>Sign in to your account</h3>
      <p>
        Please enter your Username and Password to log in.
      </p>
      <!--[if lt IE 9 ]>
    <div class='login_message'>This tool is supported only on IE 9+, Chrome, Firefox and Safari browsers! <BR> Please try launching this on a supported browser!</div>
    <![endif]-->
      <form action="login/validate_credentials" method='POST' id='loginForm' class='form-login' autocomplete='off'>
        
        <div class="errorHandler alert alert-danger no-display">
          <i class="fa fa-remove-sign"></i> You have some form errors. Please check below.
        </div>
        <fieldset>
          <div class="form-group">
            <span class="input-icon">
              <input class="form-control" name="j_username" id ="username" placeholder="Enter your Username" type="text">
              <i class="fa fa-user"></i> </span>
          </div>
          <div class="form-group form-actions">
            <span class="input-icon">
              <input class="form-control password" name="j_password" id="password" placeholder="Enter your Password" type="password">
              <i class="fa fa-lock"></i>
            </span>
          </div>

          <div class="form-actions">
            <label for="remember" class="checkbox-inline">

            </label>
            <button type="submit" id="submit" class="btn btn-bricky pull-right"> Login <i class="fa fa-arrow-circle-right"></i>
            </button>
          </div>
        </fieldset>
      </form>
    </div>                        
    <!--<div class="copyright">
      2016 © Game.
    </div>  -->

  </div>
  

    <!-- jQuery -->
	<script src="<?php echo base_url();?>assets/jquery/jquery.js"></script>
	
	<!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url();?>assets/bootstrap/dist/js/bootstrap.min.js"></script>
    <script type='text/javascript'>
        <!--
        (function() {
        document.forms['loginForm'].elements['j_username'].focus();
        $('body').addClass('login example2');
        $('#syn_logo').hide();
        $('nav').addClass('hide');
        })();
        // -->
    </script>

</body>

</html>
