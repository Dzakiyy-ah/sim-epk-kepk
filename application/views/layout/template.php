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

		<!-- basic scripts -->

		<!--[if !IE]> -->
		<script src="<?php echo base_url()?>assets/js/jquery-2.1.4.min.js"></script>

		<!-- <![endif]-->

		<!--[if IE]>
<script src="<?php echo base_url()?>assets/js/jquery-1.11.3.min.js"></script>
<![endif]-->

		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo base_url()?>assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="<?php echo base_url()?>assets/js/bootstrap.min.js"></script>

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
							SIM-EPK <?php echo $this->session->userdata('nama_kepk') != '0' ? ' :: '.$this->session->userdata('nama_kepk') : ''?>
						</small>
					</a>
				</div>

				<div class="navbar-buttons navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">

						<li class="light-blue dropdown-modal">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle" style="background-color: #389B23 !important;">
								<span class="user-info">
									<small>Selamat datang,</small>
									<?php echo $this->session->userdata('nama_user_'.APPAUTH)?>
								</span>

								<i class="ace-icon fa fa-caret-down"></i>
							</a>

							<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<li>
									<a href="#">
										<i class="ace-icon fa fa-cog"></i>
										<?php echo $this->session->userdata('nama_group_'.APPAUTH)?>
									</a>
								</li>

								<li>
									<a href="<?php echo base_url()?>user_profil">
										<i class="ace-icon fa fa-user"></i>
										User Profile
									</a>
								</li>

								<li class="divider"></li>

								<li>
									<?php if ($this->session->userdata('id_group_'.APPAUTH) == 9) { ?>
									<a href="<?php echo base_url()?>auth/logout_keppkn">
									<?php } else { ?>
									<a href="<?php echo base_url()?>auth/logout">
									<?php } ?>
										<i class="ace-icon fa fa-power-off"></i>
										Logout
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div><!-- /.navbar-container -->
		</div>

		<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>

			<div id="sidebar" class="sidebar                  responsive                    ace-save-state">
				<script type="text/javascript">
					try{ace.settings.loadState('sidebar')}catch(e){}
				</script>

				<div class="sidebar-shortcuts" id="sidebar-shortcuts">
					<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
						<button class="btn btn-success">
							<i class="ace-icon fa fa-signal"></i>
						</button>

						<button class="btn btn-info">
							<i class="ace-icon fa fa-pencil"></i>
						</button>

						<button class="btn btn-warning">
							<i class="ace-icon fa fa-users"></i>
						</button>

						<button class="btn btn-danger">
							<i class="ace-icon fa fa-cogs"></i>
						</button>
					</div>

					<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
						<span class="btn btn-success"></span>

						<span class="btn btn-info"></span>

						<span class="btn btn-warning"></span>

						<span class="btn btn-danger"></span>
					</div>
				</div><!-- /.sidebar-shortcuts -->

				<?php 
				$id_group = $this->session->userdata('id_group_'.APPAUTH);
				switch ($id_group) {
					case 1:  $this->load->view('layout/navigation_admin'); 
						break;
					case 2:  $this->load->view('layout/navigation_kepk'); 
						break;
					case 3:  $this->load->view('layout/navigation_pengusul'); 
						break;
					case 4:	 $this->load->view('layout/navigation_sekretaris');
						break;
					case 5:	 $this->load->view('layout/navigation_kesekretariatan');
						break;
					case 6:	 $this->load->view('layout/navigation_penelaah');
						break;
					case 7:	 $this->load->view('layout/navigation_ketua');
						break;
					case 8:	 $this->load->view('layout/navigation_wakil_ketua');
						break;
				}
				?>

				<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
					<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
				</div>
			</div>

			<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="#">Home</a>
							</li>
							<li class="active"><?php echo isset($breadcrumb) ? $breadcrumb : 'Dashboard'?></li>
						</ul><!-- /.breadcrumb -->

					</div>

					<div class="page-content">
						<div class="page-header">
							<h1>
								<?php echo isset($page_header) ? $page_header : 'Dashboard' ?>
								<?php if (isset($subheader)) { ?>
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									<?php echo $subheader ?>
								</small>
								<?php } ?>
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->

			          <?php if(isset($main_content)) { $this->load->view($main_content); } ?>

								<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
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


		<!--[if lte IE 8]>
		  <script src="<?php echo base_url()?>assets/js/excanvas.min.js"></script>
		<![endif]-->

		<!-- ace scripts -->
		<script src="<?php echo base_url()?>assets/js/ace-elements.min.js"></script>
		<script src="<?php echo base_url()?>assets/js/ace.min.js"></script>

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($) {
		    // addClass active di menu
		    var activeurl = '<?php echo base_url().$this->uri->slash_segment(1);?>';
		    $('a[href="'+activeurl+'"]').parent().addClass('active');
		    $('a[href="'+activeurl+'"]').parent().parent().parent().addClass('active open');
		
  		})
		</script>

    <?php if(isset($js_content)) { $this->load->view($js_content); } ?>

	</body>
</html>
