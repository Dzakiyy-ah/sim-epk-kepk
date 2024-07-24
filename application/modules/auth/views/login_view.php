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

  <body class="login-layout blur-login" style="background-color: #AEF9AC !important;">
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
                <div id="login-box" class="login-box visible widget-box no-border">
                  <div class="widget-body">
                    <div class="widget-main">
                      <h4 class="header blue lighter bigger">
                        <i class="ace-icon fa fa-coffee green"></i>
                        Masukkan Username dan Password <span class="red"></span>
                      </h4>

                      <div class="space-6"></div>

                      <form method="post" action="<?php echo base_url()?>auth/proses_login/">
                        <fieldset>
                          <label class="block clearfix">
                            <span class="block input-icon input-icon-right">
                              <input type="text" class="form-control" name="username" placeholder="Username" />
                              <i class="ace-icon fa fa-user"></i>
                            </span>
                          </label>

                          <label class="block clearfix">
                            <span class="block input-icon input-icon-right">
                              <input type="password" class="form-control" name="password" placeholder="Password" />
                              <i class="ace-icon fa fa-lock"></i>
                            </span>
                          </label>

                          <label class="block clearfix">
                            <span class="block input-icon input-icon-right">
                              <select class="chosen-select form-control" name="group" id="group">
                                <option value="3">Peneliti</option>
                                <option value="2">Admin KEPK</option>
                                <option value="4">Sekretaris KEPK</option>
                                <option value="5">Kesekretariatan KEPK</option>
                                <option value="6">Penelaah KEPK</option>
                                <option value="7">Ketua KEPK</option>
                                <option value="8">Wakil Ketua KEPK</option>
                              </select>
                              <!-- <i class="ace-icon fa fa-lock"></i> -->
                            </span>
                          </label>

                          <label class="block clearfix">
                            <input type="text" class="col-xs-10 col-sm-6" name="captcha" placeholder="Captcha" />
                            &nbsp;&nbsp;
                            <?php echo $captcha_img; ?>
                            <button type="button" id="refresh_captcha" class="btn btn-white btn-default">
                              <i class="fa fa-refresh"></i>
                            </button>
                          </label>

                          <div class="space"></div>

                          <?php

                            $err_msg = $this->session->flashdata('error_login');
                            if (isset($err_msg)) {
                              echo '<div class="text-danger" role="alert">'.$err_msg.'</div>';
                            }
                          ?>

                          <div class="clearfix">
                            <button type="submit" class="width-35 pull-right btn btn-sm btn-primary">
                              <i class="ace-icon fa fa-key"></i>
                              <span class="bigger-110">Login</span>
                            </button>
                          </div>

                          <div class="space-4"></div>

                        </fieldset>
                      </form>

                    </div><!-- /.widget-main -->

                    <div class="toolbar clearfix">
                      <div>
                        <a href="#" data-target="#forgot-box" class="forgot-password-link">
                          <i class="ace-icon fa fa-arrow-left"></i>
                          Lupa password?
                        </a>
                      </div>
                    </div>
                  </div>

                </div><!-- /.login-box -->

                <div id="forgot-box" class="forgot-box widget-box no-border">
                  <div class="widget-body">
                    <div class="widget-main">
                      <h4 class="header red lighter bigger">
                        <i class="ace-icon fa fa-key"></i>
                        Perbarui Password
                      </h4>

                      <div class="space-6"></div>
                      <p>
                        Masukkan Username dan Email
                      </p>

                      <form method="post" action="<?php echo base_url()?>auth/proses_password1/">
                        <fieldset>
                          <label class="block clearfix">
                            <span class="block input-icon input-icon-right">
                              <input type="text" class="form-control" name="username2" placeholder="Username" />
                              <i class="ace-icon fa fa-user"></i>
                            </span>
                          </label>

                          <label class="block clearfix">
                            <span class="block input-icon input-icon-right">
                              <input type="email" class="form-control" name="email2" placeholder="Email" />
                              <i class="ace-icon fa fa-envelope"></i>
                            </span>
                          </label>

                          <label class="block clearfix">
                            <span class="block input-icon input-icon-right">
                              <select class="chosen-select form-control" name="group2" id="group2">
                                <option value="3">Peneliti</option>
                                <option value="2">Admin KEPK</option>
                                <option value="4">Sekretaris KEPK</option>
                                <option value="5">Kesekretariatan KEPK</option>
                                <option value="6">Penelaah KEPK</option>
                                <option value="9">Ketua KEPK</option>
                                <option value="10">Wakil Ketua KEPK</option>
                              </select>
                              <!-- <i class="ace-icon fa fa-lock"></i> -->
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
                    </div><!-- /.widget-main -->

                    <div class="toolbar center">
                      <a href="#" data-target="#login-box" class="back-to-login-link">
                        Login kembali
                        <i class="ace-icon fa fa-arrow-right"></i>
                      </a>
                    </div>
                  </div><!-- /.widget-body -->
                </div><!-- /.forgot-box -->

              </div><!-- /.position-relative -->

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

        $('#refresh_captcha').click( function(){
         $.ajax({
            type: 'POST',
            url: '<?php echo base_url()?>auth/refresh_captcha',
            dataType: "text",  
            cache:false,  
            success: function(data){
              $('#Imageid').replaceWith(data);
            }
          });
        });
      });      
    </script>
  </body>
</html>
