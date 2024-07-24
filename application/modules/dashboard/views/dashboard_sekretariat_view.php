<div class="row" style="height: 300px">
	<div class="col-xs-6 col-sm-6">
		<div class="widget-box transparent">
			<div class="widget-header widget-header-small">
				<h4 class="widget-title blue smaller">
					<i class="ace-icon fa fa-th blue"></i>
					Putusan Fullboard
				</h4>

				<div class="widget-toolbar action-buttons">
					<a href="#" data-action="reload" title="Perbarui" data-bind="click: init_putusan_awal_fullboard()">
						<i class="ace-icon fa fa-refresh blue"></i>
					</a>
				</div>

				<div class="widget-toolbar">
					<small>Jumlah : <span data-bind="text: putusan_awal_fullboard().length"></span></small>
				</div>

			</div>

			<div class="widget-body">
				<div class="widget-main padding-8" data-bind="foreach: putusan_awal_fullboard">
					<div id="putusan_awal_fullboard" class="profile-feed">
						<div class="profile-activity clearfix">
							<div>
								<div>
									No Protokol: <a class="user" href="#"> <span data-bind="text: no"></span> </a>
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
					<i class="ace-icon fa fa-print blue"></i>
					Pembebasan Etik
				</h4>

				<div class="widget-toolbar action-buttons">
					<a href="#" data-action="reload" title="Perbarui" data-bind="click: init_pembebasan()">
						<i class="ace-icon fa fa-refresh blue"></i>
					</a>
				</div>

				<div class="widget-toolbar">
					<small>Jumlah : <span data-bind="text: pembebasan().length"></span></small>
				</div>

			</div>

			<div class="widget-body">
				<div class="widget-main padding-8" data-bind="foreach: pembebasan">
					<div id="pembebasan" class="profile-feed">
						<div class="profile-activity clearfix">
							<div>
								<div>
									No Protokol: <a class="user" href="#"> <span data-bind="text: no"></span> </a>
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
					<i class="ace-icon fa fa-print green"></i>
					Persetujuan Etik
				</h4>

				<div class="widget-toolbar action-buttons">
					<a href="#" data-action="reload" title="Perbarui" data-bind="click: init_persetujuan()">
						<i class="ace-icon fa fa-refresh blue"></i>
					</a>
				</div>

				<div class="widget-toolbar">
					<small>Jumlah : <span data-bind="text: persetujuan().length"></span></small>
				</div>
			</div>

			<div class="widget-body">
				<div class="widget-main padding-8" data-bind="foreach: persetujuan">
					<div id="persetujuan" class="profile-feed">
						<div class="profile-activity clearfix">
							<div>
								<div>
									No Protokol: <a class="user" href="#"> <span data-bind="text: no"></span> </a>
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
					<i class="ace-icon fa fa-print orange"></i>
					Perbaikan Etik
				</h4>

				<div class="widget-toolbar action-buttons">
					<a href="#" data-action="reload" title="Perbarui" data-bind="click: init_perbaikan()">
						<i class="ace-icon fa fa-refresh green"></i>
					</a>
				</div>

				<div class="widget-toolbar">
					<small>Jumlah : <span data-bind="text: perbaikan().length"></span></small>
				</div>
			</div>

			<div class="widget-body">
				<div class="widget-main padding-8" data-bind="foreach: perbaikan">
					<div id="perbaikan" class="profile-feed">
						<div class="profile-activity clearfix">
							<div>
								<div>
									No Protokol: <a class="user" href="#"> <span data-bind="text: no"></span> </a>
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
