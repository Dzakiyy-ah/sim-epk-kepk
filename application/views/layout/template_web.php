<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title><?php echo isset($title) ? $title : ''?></title>

		<meta name="description" content="overview &amp; stats" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<link rel="shortcut icon" href="#">

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="<?php echo base_url()?>assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="<?php echo base_url()?>assets/font-awesome/4.5.0/css/font-awesome.min.css" />
		
	    <?php if(isset($css_content)) { $this->load->view($css_content); } ?>

		<!-- text fonts -->
		<link rel="stylesheet" href="<?php echo base_url()?>assets/css/fonts.googleapis.com.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="<?php echo base_url()?>assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="assets/css/ace-part2.min.css" class="ace-main-stylesheet" />
		<![endif]-->
		<link rel="stylesheet" href="<?php echo base_url()?>assets/css/ace-skins.min.css" />
		<link rel="stylesheet" href="<?php echo base_url()?>assets/css/ace-rtl.min.css" />

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- ace settings handler -->
		<script src="<?php echo base_url()?>assets/js/ace-extra.min.js"></script>

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="<?php echo base_url()?>assets/js/html5shiv.min.js"></script>
		<script src="<?php echo base_url()?>assets/js/respond.min.js"></script>
		<![endif]-->
	
	</head>

	<body class="no-skin">
    <div id="navbar" class="navbar navbar-default          ace-save-state" style="background-color: #47B943 !important;">
      <div class="navbar-container ace-save-state" id="navbar-container">
        <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
          <span class="sr-only">Toggle sidebar</span>

          <span class="icon-bar"></span>

          <span class="icon-bar"></span>

          <span class="icon-bar"></span>
        </button>

        <div class="navbar-header pull-left">
          <a href="<?php echo base_url()?>" class="navbar-brand">
            <small>
              <i class="fa fa-book"></i>
              SIM-EPK
            </small>
          </a>
        </div>

        <div class="navbar-buttons navbar-header pull-right" role="navigation">
          <ul class="nav ace-nav">
            <li class="active"> <a href="<?php echo base_url()?>home/" style="background-color: #389B23 !important;"><i class="ace-icon fa fa-home home-icon"></i> Home</a> </li>
            <li> <a href="https://sim-epk-keppkn.kemkes.go.id/" style="background-color: #389B23 !important;"><i class="ace-icon fa fa-institution institution-icon"></i> KEPPKN</a> </li>
            <li> <a href="<?php echo base_url()?>data_kepk/" style="background-color: #389B23 !important;"><i class="ace-icon fa fa-institution institution-icon"></i> KEPK</a> </li>
            <li> <a href="<?php echo base_url()?>akun_bank/" style="background-color: #389B23 !important;"><i class="ace-icon fa fa-credit-card credit-card-icon"></i> Akun Bank & Tarif/Biaya Telaah</a> </li>
            <li> <a href="<?php echo base_url()?>daftar_pengajuan/" style="background-color: #389B23 !important;"><i class="ace-icon fa fa-book book-icon"></i> Protokol</a> </li>
            <li> <a href="<?php echo base_url()?>reg_pengusul/" style="background-color: #389B23 !important;"><i class="ace-icon fa fa-user user-icon"></i> Pendaftaran Peneliti</a> </li>
            <li> <a href="<?php echo base_url()?>auth/login/" style="background-color: #389B23 !important;"><i class="ace-icon fa fa-key key-icon"></i> Log in</a> </li>
          </ul>
        </div>
      </div><!-- /.navbar-container -->
    </div>

		<div class="main-container ace-save-state" id="main-container">
			<div class="main-content">
				<div class="main-content-inner">
<!-- 					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
						</ul>
					</div>
					<div class="page-header">
						<h1>
							<?php echo isset($page_header) ? $page_header : 'Home' ?>
						</h1>
					</div> --><!-- /.page-header -->
					<div class="page-content">
						<!-- PAGE CONTENT BEGINS -->

	          <?php if(isset($main_content)) { $this->load->view($main_content); } ?>

						<!-- PAGE CONTENT ENDS -->
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

			<div class="footer">
				<div class="footer-inner">
					<div class="footer-content">
						<span class="bigger-120">
							<span class="blue bolder">SIM-EPK</span>
							&copy; 2023
						</span>
					</div>
          <div style="bottom: 0px;clear: both;display: block;">
            <?php
            if (file_exists('version') && file_get_contents('version'))
              echo '<span class="text-primary"><small>v'.file_get_contents('version').'</small></span>';
            ?>
          </div>
				</div>
			</div>

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->

    <script src="<?php echo base_url()?>assets/js/jquery-2.1.4.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/bootstrap.min.js"></script>

    <!-- ace scripts -->
    <script src="<?php echo base_url()?>assets/js/ace-elements.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/ace.min.js"></script>

    <?php if(isset($js_content)) { $this->load->view($js_content); } ?>

	</body>
</html>
