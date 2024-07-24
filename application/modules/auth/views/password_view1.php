<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title><?php echo isset($title) ? $title : ''?></title>

    <meta name="description" content="User login page" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    <!-- bootstrap & fontawesome -->
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>assets/font-awesome/4.5.0/css/font-awesome.min.css" />

    <!-- text fonts -->
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/fonts.googleapis.com.css" />

    <!-- ace styles -->
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/ace.min.css" />

    <!--[if lte IE 9]>
      <link rel="stylesheet" href="<?php echo base_url()?>assets/css/ace-part2.min.css" />
    <![endif]-->
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/ace-rtl.min.css" />

    <!--[if lte IE 9]>
      <link rel="stylesheet" href="<?php echo base_url()?>assets/css/ace-ie.min.css" />
    <![endif]-->

    <!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

    <!--[if lte IE 8]>
    <script src="<?php echo base_url()?>assets/js/html5shiv.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/respond.min.js"></script>
    <![endif]-->
  </head>

  <body class="login-layout light-login">
    <div class="main-container">
      <div class="main-content">
        <div class="row">
          <div class="col-sm-10 col-sm-offset-1">
            <div class="login-container">
              <div class="center">
                <h1>
                  <a href="<?php echo base_url()?>home/"><i class="ace-icon fa fa-book green"></i>
                  <span class="red">SIM-EPK</span>
                  <span class="grey" id="id-text2"></span></a>
                </h1>
                <h4 class="blue" id="id-company-text">&copy; KEPPKN</h4>
              </div>

              <div class="space-6"></div>

              <div class="position-relative">
                <div id="forgot-box" class="forgot-box visible widget-box no-border">
                  <div class="widget-body">
                    <div class="widget-main">
                      <h4 class="header red lighter bigger">
                        <i class="ace-icon fa fa-key"></i>
                        Perbarui Password
                      </h4>

                      <div class="space-6"></div>

                      <?php
                        $err_msg = $this->session->flashdata('error_password');
                        if (isset($err_msg)) {
                          echo '<div class="text-danger" role="alert">'.$err_msg.'</div>';
                        }
                        else if ($this->session->userdata('ganti_password') && $this->session->userdata('ganti_password') > 0) {
                      ?>
                      <p>
                        Masukkan Password Baru
                      </p>
                      <form method="post" action="<?php echo base_url()?>auth/proses_password2/">
                        <fieldset>
                          <label class="block clearfix">
                            <span class="block input-icon input-icon-right">
                              <input type="password" class="form-control" name="passw_baru1" placeholder="Password Baru" />
                              <i class="ace-icon fa fa-key"></i>
                            </span>
                          </label>

                          <label class="block clearfix">
                            <span class="block input-icon input-icon-right">
                              <input type="password" class="form-control" name="passw_baru2" placeholder="Ulangi Password Baru" />
                              <i class="ace-icon fa fa-key"></i>
                            </span>
                          </label>

                          <div class="clearfix">
                            <button type="submit" class="width-35 pull-right btn btn-sm btn-danger">
                              <i class="ace-icon fa fa-lightbulb-o"></i>
                              <span class="bigger-110">Kirim</span>
                            </button>
                          </div>
                        </fieldset>
                      </form>
                      
                      <?php    
                        }
                      ?>

                    </div><!-- /.widget-main -->

                    <div class="toolbar center">
                      <a href="<?php echo base_url()?>auth/login/" class="back-to-login-link">
                        Kembali ke halaman login
                        <i class="ace-icon fa fa-arrow-right"></i>
                      </a>
                    </div>
                  </div><!-- /.widget-body -->
                </div><!-- /.forgot-box -->

              </div><!-- /.position-relative -->

              <div class="navbar-fixed-top align-right">
                <br />
                &nbsp;
                <a id="btn-login-dark" href="#">Dark</a>
                &nbsp;
                <span class="blue">/</span>
                &nbsp;
                <a id="btn-login-blur" href="#">Blur</a>
                &nbsp;
                <span class="blue">/</span>
                &nbsp;
                <a id="btn-login-light" href="#">Light</a>
                &nbsp; &nbsp; &nbsp;
              </div>
            </div>

          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.main-content -->
    </div><!-- /.main-container -->

    <!-- basic scripts -->

    <!--[if !IE]> -->
    <script src="<?php echo base_url()?>assets/js/jquery-2.1.4.min.js"></script>

    <!-- <![endif]-->

    <!--[if IE]>
<script src="assets/js/jquery-1.11.3.min.js"></script>
<![endif]-->
    <script type="text/javascript">
      if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo base_url()?>assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
    </script>

    <!-- inline scripts related to this page -->
    <script type="text/javascript">
      jQuery(function($) {
        $(document).on('click', '.toolbar a[data-target]', function(e) {
          e.preventDefault();
          var target = $(this).data('target');
          $('.widget-box.visible').removeClass('visible');//hide others
          $(target).addClass('visible');//show target
        });
      });
      
      
      
      //you don't need this, just used for changing background
      jQuery(function($) {
        $('#btn-login-dark').on('click', function(e) {
          $('body').attr('class', 'login-layout');
          $('#id-text2').attr('class', 'white');
          $('#id-company-text').attr('class', 'blue');
        
          e.preventDefault();
        });
        $('#btn-login-light').on('click', function(e) {
          $('body').attr('class', 'login-layout light-login');
          $('#id-text2').attr('class', 'grey');
          $('#id-company-text').attr('class', 'blue');
        
          e.preventDefault();
        });
        $('#btn-login-blur').on('click', function(e) {
          $('body').attr('class', 'login-layout blur-login');
          $('#id-text2').attr('class', 'white');
          $('#id-company-text').attr('class', 'light-blue');
        
          e.preventDefault();
        });
       
      });

    </script>
  </body>
</html>
