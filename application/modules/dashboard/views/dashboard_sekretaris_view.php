<div class="row" style="height: 300px">
	<div class="col-xs-6 col-sm-6">
		<div class="widget-box transparent">
			<div class="widget-header widget-header-small">
				<h4 class="widget-title blue smaller">
					<i class="ace-icon fa fa-file-o blue"></i>
					Resume
				</h4>

				<div class="widget-toolbar action-buttons">
					<a href="#" data-action="reload" title="Perbarui" data-bind="click: init_resume()">
						<i class="ace-icon fa fa-refresh blue"></i>
					</a>
				</div>

				<div class="widget-toolbar">
					<small>Jumlah : <span data-bind="text: resume().length"></span></small>
				</div>

			</div>

			<div class="widget-body">
				<div class="widget-main padding-8 scrollable" data-size="220">
					<div id="resume" class="profile-feed" data-bind="foreach: resume">
						<div class="profile-activity clearfix">
							<div>
								<div>
									No Protokol: <a class="user" href="#"> <span data-bind="text: no"></span> </a>
									<div class="pull-right"> <span data-bind="text: revisi_ke == 0 ? 'Baru' : 'Perbaikan #'+revisi_ke, attr: {'class': revisi_ke == 0 ? 'label label-success arrowed-in-right arrowed' : 'label label-warning arrowed-in-right arrowed'}"></span> </div>
								</div>
								<div>
									Judul:
									<a href="#"><span data-bind="text: judul"></span></a>
								</div>

								<div class="time">
									<i class="ace-icon fa fa-clock-o bigger-110"></i>
									<span data-bind="text: waktu"></span>
									&nbsp;&nbsp;&nbsp;

									<span class="label label-info arrowed-in-right arrowed">
										<strong>
											<i class="ace-icon fa fa-info-circle bigger-110"></i> Hari ke <span data-bind="text: hari_ke"></span>
										</strong>
									</span>
								</div>
							</div>

							<div class="tools action-buttons">
								<a class="blue" data-bind="attr:{href: url_edit}">
									<i class="ace-icon fa fa-pencil bigger-125"></i>
								</a>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>

		<div class="hr hr2 hr-double"></div>

	</div>
</div>

<div class="row" style="height: 300px">
	<div class="col-xs-6 col-sm-6">
		<div class="widget-box transparent">
			<div class="widget-header widget-header-small">
				<h4 class="widget-title blue smaller">
					<i class="ace-icon fa fa-th-large red"></i>
					Putusan Telaah Expedited
				</h4>

				<div class="widget-toolbar action-buttons">
					<a href="#" data-action="reload" title="Perbarui" data-bind="click: init_putusan_expedited()">
						<i class="ace-icon fa fa-refresh blue"></i>
					</a>
				</div>

				<div class="widget-toolbar">
					<small><strong>Jumlah : <span data-bind="text: putusan_expedited().length"></span></strong></small>
				</div>

				<div class="widget-toolbar">
					<small>Perbaikan : <span data-bind="text: kexp_rev"></span></small>
				</div>

				<div class="widget-toolbar">
					<small>Baru : <span data-bind="text: kexp_new"></span></small>
				</div>

			</div>

			<div class="widget-body">
        <div class="widget-main padding-8 scrollable" data-size="220">
					<div id="putusan_expedited" class="profile-feed" data-bind="foreach: putusan_expedited">
						<div class="profile-activity clearfix">
							<div>
								<div>
									No Protokol: <a class="user" href="#"> <span data-bind="text: no"></span> </a> <div class="pull-right"> <span data-bind="text: revisi_ke == 0 ? 'Baru' : 'Perbaikan #'+revisi_ke, attr: {'class': revisi_ke == 0 ? 'label label-success arrowed-in-right arrowed' : 'label label-warning arrowed-in-right arrowed'}"></span> </div>

								</div>
								<div>
									Judul:
									<a href="#"><span data-bind="text: judul"></span></a>
								</div>

								<div class="time">
									<i class="ace-icon fa fa-clock-o bigger-110"></i>
									<span data-bind="text: waktu"></span>
									&nbsp;&nbsp;&nbsp;
									
									<span class="label label-info arrowed-in-right arrowed">
										<strong>
											<i class="ace-icon fa fa-info-circle bigger-110"></i> Hari ke <span data-bind="text: hari_ke"></span>
										</strong>
									</span>
								</div>
							</div>

							<div class="tools action-buttons">
								<a class="blue" data-bind="attr:{href: url_edit}">
									<i class="ace-icon fa fa-pencil bigger-125"></i>
								</a>
							</div>
						</div>

					</div>
				</div>
			</div>

		</div>

		<div class="hr hr2 hr-double"></div>

	</div>

	<div class="col-xs-6 col-sm-6">
		<div class="widget-box transparent">
			<div class="widget-header widget-header-small">
				<h4 class="widget-title blue smaller">
					<i class="ace-icon fa fa-th orange"></i>
					Putusan Telaah Fullboard
				</h4>

				<div class="widget-toolbar action-buttons">
					<a href="#" data-action="reload" title="Perbarui" data-bind="click: init_putusan_fullboard()">
						<i class="ace-icon fa fa-refresh blue"></i>
					</a>
				</div>

				<div class="widget-toolbar">
					<small><strong>Jumlah : <span data-bind="text: putusan_fullboard().length"></span></strong></small>
				</div>

				<div class="widget-toolbar">
					<small>Perbaikan : <span data-bind="text: kfbd_rev"></span></small>
				</div>

				<div class="widget-toolbar">
					<small>Baru : <span data-bind="text: kfbd_new"></span></small>
				</div>

			</div>

			<div class="widget-body">
        <div class="widget-main padding-8 scrollable" data-size="220">
					<div id="putusan_fullboard" class="profile-feed" data-bind="foreach: putusan_fullboard">
						<div class="profile-activity clearfix">
							<div>
								<div>
									No Protokol: <a class="user" href="#"> <span data-bind="text: no"></span> </a> <div class="pull-right"> <span data-bind="text: revisi_ke == 0 ? 'Baru' : 'Perbaikan #'+revisi_ke, attr: {'class': revisi_ke == 0 ? 'label label-success arrowed-in-right arrowed' : 'label label-warning arrowed-in-right arrowed'}"></span> </div>

								</div>
								<div>
									Judul:
									<a href="#"><span data-bind="text: judul"></span></a>
								</div>

								<div class="time">
									<i class="ace-icon fa fa-clock-o bigger-110"></i>
									<span data-bind="text: waktu"></span>
									&nbsp;&nbsp;&nbsp;
									
									<span class="label label-info arrowed-in-right arrowed">
										<strong>
											<i class="ace-icon fa fa-info-circle bigger-110"></i> Hari ke <span data-bind="text: hari_ke"></span>
										</strong>
									</span>
								</div>
							</div>

							<div class="tools action-buttons">
								<a class="blue" data-bind="attr:{href: url_edit}">
									<i class="ace-icon fa fa-pencil bigger-125"></i>
								</a>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>

		<div class="hr hr2 hr-double"></div>

	</div>
</div>
