<div class="row">
	<div class="col-xs-12 col-sm-12">
		<div class="widget-box transparent">
			<div class="widget-header widget-header-small">
				<h4 class="widget-title blue smaller">
					<i class="ace-icon fa fa-file-o blue"></i>
					Statistik 
					<i class="ace-icon fa fa-spinner fa-spin orange bigger-125" data-bind="visible: load_data()"></i>
				</h4>

				<div class="widget-toolbar action-buttons">
					<div class="input-group">
						<input class="form-control date-picker" id="periode" type="text" data-date-format="mm yyyy" />
						<span class="input-group-addon">
							<i class="fa fa-calendar bigger-110"></i>
						</span>
					</div>
				</div>

			</div>

			<div class="widget-body">
				<div class="widget-main padding-12">
					<div class="row">
						<div class="col-sm-2">
							<div class="dropdown dropdown-preview">
								<ul class="dropdown-menu">
									<li><a href="#" tabindex="-1"><h5>Jenis Penelitian</h5></a></li>
									<li class="divider"></li>
									<li><a href="#" tabindex="-1">Observasional <span class="badge badge-info" data-bind="text: jenis_penelitian1"></span></a></li>
									<li><a href="#" tabindex="-1">Intervensi <span class="badge badge-info" data-bind="text: jenis_penelitian2"></span></a></li>
									<li><a href="#" tabindex="-1">Uji Klinik <span class="badge badge-info" data-bind="text: jenis_penelitian3"></span></a></li>
								</ul>
							</div>
						</div>

						<div class="col-sm-2">
							<div class="dropdown dropdown-preview">
								<ul class="dropdown-menu">
									<li><a href="#" tabindex="-1"><h5>Asal Pengusul</h5></a></li>
									<li class="divider"></li>
									<li><a href="#" tabindex="-1">Internal <span class="badge badge-info" data-bind="text: asal_pengusul1"></span></a></li>
									<li><a href="#" tabindex="-1">Eksternal <span class="badge badge-info" data-bind="text: asal_pengusul2"></span></a></li>
								</ul>
							</div>
						</div>

 						<div class="col-sm-2">
							<div class="dropdown dropdown-preview">
								<ul class="dropdown-menu">
									<li><a href="#" tabindex="-1"><h5>Jenis Lembaga <br/> Asal Pengusul</h5></a></li>
									<li class="divider"></li>
									<li><a href="#" tabindex="-1">Pendidikan <span class="badge badge-info" data-bind="text: jenis_lembaga1"></span></a></li>
									<li><a href="#" tabindex="-1">Rumah Sakit <span class="badge badge-info" data-bind="text: jenis_lembaga2"></span></a></li>
									<li><a href="#" tabindex="-1">Litbang <span class="badge badge-info" data-bind="text: jenis_lembaga3"></span></a></li>
								</ul>
							</div>
						</div>

 						<div class="col-sm-2">
							<div class="dropdown dropdown-preview">
								<ul class="dropdown-menu">
									<li><a href="#" tabindex="-1"><h5>Status Pengusul</h5></a></li>
									<li class="divider"></li>
									<li><a href="#" tabindex="-1">Mahasiswa <span class="badge badge-info" data-bind="text: status_pengusul1"></span></a></li>
									<li><a href="#" tabindex="-1">Dosen <span class="badge badge-info" data-bind="text: status_pengusul2"></span></a></li>
									<li><a href="#" tabindex="-1">Pelaksana<br/> Pelayanan <span class="badge badge-info" data-bind="text: status_pengusul3"></span></a></li>
									<li><a href="#" tabindex="-1">Peneliti <span class="badge badge-info" data-bind="text: status_pengusul4"></span></a></li>
									<li><a href="#" tabindex="-1">Lainnya <span class="badge badge-info" data-bind="text: status_pengusul5"></span></a></li>
								</ul>
							</div>
						</div>

 						<div class="col-sm-2">
							<div class="dropdown dropdown-preview">
								<ul class="dropdown-menu">
									<li><a href="#" tabindex="-1"><h5>Strata Pendidikan <br/> Pengusul</h5></a></li>
									<li class="divider"></li>
									<li><a href="#" tabindex="-1">Diploma III <span class="badge badge-info" data-bind="text: strata_pendidikan1"></span></a></li>
									<li><a href="#" tabindex="-1">Diploma IV <span class="badge badge-info" data-bind="text: strata_pendidikan2"></span></a></li>
									<li><a href="#" tabindex="-1">S-1 <span class="badge badge-info" data-bind="text: strata_pendidikan3"></span></a></li>
									<li><a href="#" tabindex="-1">S-2 <span class="badge badge-info" data-bind="text: strata_pendidikan4"></span></a></li>
									<li><a href="#" tabindex="-1">S-3 <span class="badge badge-info" data-bind="text: strata_pendidikan5"></span></a></li>
									<li><a href="#" tabindex="-1">Sp-1 <span class="badge badge-info" data-bind="text: strata_pendidikan6"></span></a></li>
									<li><a href="#" tabindex="-1">Sp-2 <span class="badge badge-info" data-bind="text: strata_pendidikan7"></span></a></li>
									<li><a href="#" tabindex="-1">Lainnya <span class="badge badge-info" data-bind="text: strata_pendidikan8"></span></a></li>
								</ul>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>

	</div>
</div>
