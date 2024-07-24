<div data-bind="foreach: belum_kirim">
  <div class="alert alert-block alert-warning">
    <button type="button" class="close" data-dismiss="alert">
      <i class="ace-icon fa fa-times"></i>
    </button>
    Protokol <strong><span data-bind="text: no+' '+judul"></span></strong> belum dikirim ke Sekretaris
    &nbsp;
    <button type="button" class="btn btn-minier btn-success" data-bind="click: function(data, event){ $root.kirim(id_pep, klasifikasi, keputusan, no, data, event) }">&nbsp;&nbsp;Kirim&nbsp;&nbsp;</button>
  </div>
  <br/>
</div>

<div class="row" style="height: 300px">
  <div class="col-xs-12 col-sm-12">
    <div class="widget-box transparent">
      <div class="widget-header widget-header-small">
        <h4 class="widget-title blue smaller">
          <i class="ace-icon fa fa-gavel green"></i>
          Anda menjadi pelapor pada protokol berikut:
        </h4>

        <div class="widget-toolbar">
          <a href="#" data-action="collapse">
            <i class="ace-icon fa fa-chevron-up"></i>
          </a>
        </div>

        <div class="widget-toolbar action-buttons">
          <a href="#" data-action="reload" title="Perbarui" data-bind="click: init_telaah_pelapor()">
            <i class="ace-icon fa fa-refresh blue"></i>
          </a>
        </div>

      </div>

      <div class="widget-body">
        <div class="widget-main no-padding">
          <table class="table table-bordered table-striped">
            <thead class="thin-border-bottom">
              <tr>
                <th>
                  <i class="ace-icon fa fa-caret-right blue"></i>No. Protokol
                </th>

                <th>
                  <i class="ace-icon fa fa-caret-right blue"></i>Judul
                </th>

                <th class="hidden-480">
                  <i class="ace-icon fa fa-caret-right blue"></i>Klasifikasi
                </th>
                <th>
                  <i class="ace-icon fa fa-caret-right blue"></i>Anggota Penelaah
                </th>
              </tr>
            </thead>

            <tbody data-bind="foreach: telaah_pelapor">
              <tr>
                <td data-bind="text: no"></td>
                <td data-bind="text: judul"></td>
                <td class="hidden-480">
                  <span data-bind="text: klasifikasi, attr:{'class': klasifikasi == 'Expedited' ? 'label label-warning arrowed arrowed-right' : 'label label-red arrowed arrowed-right'}"></span>
                </td>
                <td data-bind="text: anggota"></td>
              </tr>
            </tbody>
          </table>
        </div><!-- /.widget-main -->
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
					<i class="ace-icon fa fa-filter green"></i>
					Telaah Awal
				</h4>

				<div class="widget-toolbar action-buttons">
					<a href="#" data-action="reload" title="Perbarui" data-bind="click: init_telaah_awal()">
						<i class="ace-icon fa fa-refresh blue"></i>
					</a>
				</div>

				<div class="widget-toolbar">
					<small>Jumlah : <span data-bind="text: telaah_awal().length"></span></small>
				</div>

			</div>

			<div class="widget-body">
        <div class="widget-main padding-8 scrollable" data-size="220">
					<div id="telaah_awal" class="profile-feed" data-bind="foreach: telaah_awal">
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
					<i class="ace-icon fa fa-flag red"></i>
					Telaah Expedited
				</h4>

				<div class="widget-toolbar action-buttons">
					<a href="#" data-action="reload" title="Perbarui" data-bind="click: init_telaah_expedited()">
						<i class="ace-icon fa fa-refresh blue"></i>
					</a>
				</div>

				<div class="widget-toolbar">
					<small><strong>Jumlah : <span data-bind="text: telaah_expedited().length"></span></strong></small>
				</div>

				<div class="widget-toolbar">
					<small>Perbaikan : <span data-bind="text: texp_rev"></span></small>
				</div>

				<div class="widget-toolbar">
					<small>Baru : <span data-bind="text: texp_new"></span></small>
				</div>

			</div>

			<div class="widget-body">
        <div class="widget-main padding-8 scrollable" data-size="220">
					<div id="telaah_expedited" class="profile-feed" data-bind="foreach: telaah_expedited">
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
					<i class="ace-icon fa fa-flag orange"></i>
					Telaah Fullboard
				</h4>

				<div class="widget-toolbar action-buttons">
					<a href="#" data-action="reload" title="Perbarui" data-bind="click: init_telaah_fullboard()">
						<i class="ace-icon fa fa-refresh blue"></i>
					</a>
				</div>

				<div class="widget-toolbar">
					<small><strong>Jumlah : <span data-bind="text: telaah_fullboard().length"></span></strong></small>
				</div>

				<div class="widget-toolbar">
					<small>Perbaikan : <span data-bind="text: tfbd_rev"></span></small>
				</div>

				<div class="widget-toolbar">
					<small>Baru : <span data-bind="text: tfbd_new"></span></small>
				</div>

			</div>

			<div class="widget-body">
        <div class="widget-main padding-8 scrollable" data-size="220">
					<div id="telaah_fullboard" class="profile-feed" data-bind="foreach: telaah_fullboard">
						<div class="profile-activity clearfix">
							<div>
								<div>
									No Protokol: <a class="user" href="#"> <span data-bind="text: no"></span> </a> <div class="pull-right"> <span data-bind="text: revisi_ke == 0 ? 'Baru' : 'Perbaikan #'+revisi_ke, attr: {'class': revisi_ke == 0 ? 'label label-success arrowed-in-right arrowed' : 'label label-warning arrowed-in-right arrowed'}"></span> </div>

								</div>
								<div>
									Judul:
									<a href="#"><span data-bind="text: judul"></span></a>
								</div>
                <div>
                  Tanggal, Jam:
                  <a href="#"><span data-bind="text: tgl_fb"></span> <span data-bind="text: jam_fb"></span></a>
                </div>
                <div>
                  Tempat:
                  <a href="#"><span data-bind="text: tempat_fb"></span></a>
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
