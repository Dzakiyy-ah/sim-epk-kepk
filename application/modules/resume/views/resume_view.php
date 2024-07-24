<div class="row">
	<div class="col-xs-12 col-sm-12">
		<div class="widget-box transparent">
			<div class="widget-header widget-header-small">
				<h4 class="widget-title blue smaller">
					<i class="ace-icon fa fa-rss orange"></i>
					Protokol terbaru
				</h4>

				<div class="widget-toolbar action-buttons">
					<a href="#" data-action="reload" title="Perbarui" data-bind="click: init_protokol()">
						<i class="ace-icon fa fa-refresh blue"></i>
					</a>
				</div>
			</div>

			<div class="widget-body">
				<div class="widget-main padding-8 scrollable" data-size="300">
					<div id="profile-feed-1" class="profile-feed" data-bind="foreach: data_protokol">
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

<div class="space-12"></div>

<p>
  <div class="clearfix">
    <span class="inline pull-right">
      <button class="btn btn-purple" id="add" type="button">
        <i class="ace-icon fa fa-plus-circle bigger-110"></i>
        Tambah Data
	    </button>
    </span>
  </div>
</p>

<table id="grid-table"></table>

<div id="grid-pager"></div>

<div id="my-modal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="smaller lighter blue no-margin">Pilih Protokol</h3>
			</div>

			<div class="modal-body">
				<div class="row">
					<div class="form-group">
						<div class="col-sm-12">
							<select class="select2 form-control" id="protokol" data-placeholder="Pilih protokol...">
								<option value=""></option>
								<?php
								if ($protokol)
								{
									for($i=0; $i<count($protokol); $i++)
									{
										echo '<option value="'.$protokol[$i]['id_pep'].'">'.$protokol[$i]['no_protokol'].' - '.$protokol[$i]['judul'].'</option>';
									}
								}
								?>
							</select>
						</div>
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<button class="btn btn-sm btn-primary" id="pilih" data-dismiss="modal">
					<i class="ace-icon fa fa-check"></i>
					Pilih
				</button>
				<button class="btn btn-sm btn-warning pull-right" data-dismiss="modal">
					<i class="ace-icon fa fa-times"></i>
					Tutup
				</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
