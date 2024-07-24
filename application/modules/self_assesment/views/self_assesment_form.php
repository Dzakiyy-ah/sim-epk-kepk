<h4 class="header smaller lighter blue">
	Nomor Protokol
	<span class="pull-right label label-lg label-yellow arrowed-in arrowed-in-right" data-bind="visible: klasifikasi > 1 && keputusan == '', text: lbl_klasifikasi"></span>
	<span class="pull-right label label-lg label-warning arrowed-in arrowed-in-right" data-bind="visible: keputusan != '', text: lbl_keputusan"></span>
</h4>
<div class="row">
	<div class="form-group">
		<div class="col-sm-12">
			<select class="select2 form-control" id="id_pengajuan" data-bind="value: id_pengajuan, enable: id() == 0" data-placeholder="Nomor Protokol">
				<option value=""></option>
				<?php
				if (isset($data_pengajuan))
				{
					for ($i=0; $i<count($data_pengajuan); $i++)
					{
						echo '<option value="'.$data_pengajuan[$i]['id_pengajuan'].'">'.$data_pengajuan[$i]['no_protokol'].' - '.$data_pengajuan[$i]['judul'].'</option>';
					}

					if (isset($data['id_sac']) && $data['id_sac'] > 0)
					{
						echo '<option value="'.$data['id_pengajuan'].'">'.$data['no_protokol'].' - '.$data['judul'].'</option>';
					}
				}
				?>
			</select>
		</div>
	</div>
</div>

<div class="space-4"></div>

<h4 class="smaller lighter">
  <i class="ace-icon fa fa-hand-o-right icon-animated-hand-pointer blue"></i>
  <a href="#" data-toggle="modal" class="pink" data-bind="click: print_protokol"> Klik untuk lihat protokol (pdf)</a>
  <i class="ace-icon fa fa-book icon-animated-hand-pointer blue"></i>
</h4>

<div class="hr hr-18 dotted hr-double"></div>

<div class="alert alert-info" data-bind="visible: id() == 0">
  <button type="button" class="close" data-dismiss="alert">
    <i class="ace-icon fa fa-times"></i>
  </button>
  Pilihan beberapa item/poin <strong>7-Standar Kelainan Etik Penelitian</strong> secara default terisi "Ya"
</div>

<div class="widget-main">
	<div id="fuelux-wizard-container">
		<div>
			<ul class="steps">
				<li data-step="1" class="active">
					<span class="step">1</span>
					<span class="title">Nilai Sosial/Klinis</span>
				</li>

				<li data-step="2">
					<span class="step">2</span>
					<span class="title">Nilai Ilmiah</span>
				</li>

				<li data-step="3">
					<span class="step">3</span>
					<span class="title">Pemerataan Beban dan Manfaat</span>
				</li>

				<li data-step="4">
					<span class="step">4</span>
					<span class="title">Potensi Manfaat dan Resiko</span>
				</li>

				<li data-step="5">
					<span class="step">5</span>
					<span class="title">Bujukan/ Eksploitasi/ Iducement</span>
				</li>

				<li data-step="6">
					<span class="step">6</span>
					<span class="title">Rahasia dan Privacy</span>
				</li>

				<li data-step="7">
					<span class="step">7</span>
					<span class="title">Informed Consent</span>
				</li>
			</ul>
		</div>

		<hr />

		<div class="step-content pos-rel">
			<div class="step-pane active" data-step="1">
				<div class="form-group pull-right">
					<button class="btn btn-sm" id="reset1" data-bind="click: reset1">
						<i class="ace-icon fa fa-circle bigger-110"></i>
						Kosongkan
					</button>
				</div>

				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<tr><th width="5%">No</th><th width="80%">7-STANDAR KELAIKAN ETIK PENELITIAN</th><th width="15%">PILIHAN</th>
						</tr>
					</thead>
					<tbody data-bind="foreach: self_assesment1">
						<tr data-bind="attr: {'class': level == 0 ? 'active' : ''}">
							<td data-bind="text: no_tampilan, attr: {'align': level == 0 ? 'left': 'right'} "></td>
							<td>
								<div data-bind="if: level == 0">
									<strong><span data-bind="html: uraian_master"></span></strong>
									<br/><span data-bind="html: uraian == uraian_master ? '' : uraian"></span>
								</div>
								<div data-bind="if: level > 0">
									<span data-bind="html: uraian"></span>
								</div>
							</td>
							<td>
								<div class="control-group">
									<div class="radio" data-bind="visible: just_header == 0">
										<label>
											<input type="radio" class="ace" value="Ya" data-bind="checked: pil, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih1Ya($index(), parent) }}, enable: child == 0 || pil() == 'Ya'" />
											<span class="lbl"> Ya</span>
										</label>
										<label>
											<input type="radio" class="ace" value="Tidak" data-bind="checked: pil, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih1Tidak() }}, enable: child == 0 || pil() == 'Tidak'" />
											<span class="lbl"> Tidak</span>
										</label>
									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>

				<h3 class="header smaller lighter blue">Justifikasi Nilai Sosial/Klinis:</h3>
				<div class="form-group">
					<textarea id="justifikasi1" class="autosize-transition form-control" data-bind="value: justifikasi1"></textarea>
				</div>

			</div>

			<div class="step-pane" data-step="2">
				<div class="form-group pull-right">
					<button class="btn btn-sm" id="reset2" data-bind="click: reset2">
						<i class="ace-icon fa fa-circle bigger-110"></i>
						Kosongkan
					</button>
				</div>

				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<tr><th width="5%">No</th><th width="80%">7-STANDAR KELAIKAN ETIK PENELITIAN</th><th width="15%">PILIHAN</th>
						</tr>
					</thead>
					<tbody data-bind="foreach: self_assesment2">
						<tr data-bind="attr: {'class': level == 0 ? 'active' : ''}">
							<td data-bind="text: no_tampilan, attr: {'align': level == 0 ? 'left': 'right'} "></td>
							<td>
								<div data-bind="if: level == 0">
									<strong><span data-bind="html: uraian_master"></span></strong>
									<br/><span data-bind="html: uraian == uraian_master ? '' : uraian"></span>
								</div>
								<div data-bind="if: level > 0">
									<span data-bind="html: uraian"></span>
								</div>
							</td>
							<td>
								<div class="control-group">
									<div class="radio" data-bind="visible: just_header == 0">
										<label>
											<input type="radio" class="ace" value="Ya" data-bind="checked: pil, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih2Ya($index(), parent) }}, enable: child == 0 || pil() == 'Ya'" />
											<span class="lbl"> Ya</span>
										</label>
										<label>
											<input type="radio" class="ace" value="Tidak" data-bind="checked: pil, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih2Tidak() }}, enable: child == 0 || pil() == 'Tidak'" />
											<span class="lbl"> Tidak</span>
										</label>
									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>

				<h3 class="header smaller lighter blue">Justifikasi Nilai Ilmiah:</h3>
				<div class="form-group">
					<textarea id="justifikasi2" class="autosize-transition form-control" data-bind="value: justifikasi2"></textarea>
				</div>

			</div>

			<div class="step-pane" data-step="3">
				<div class="form-group pull-right">
					<button class="btn btn-sm" id="reset3" data-bind="click: reset3">
						<i class="ace-icon fa fa-circle bigger-110"></i>
						Kosongkan
					</button>
				</div>

				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<tr><th width="5%">No</th><th width="80%">7-STANDAR KELAIKAN ETIK PENELITIAN</th><th width="15%">PILIHAN</th>
						</tr>
					</thead>
					<tbody data-bind="foreach: self_assesment3">
						<tr data-bind="attr: {'class': level == 0 ? 'active' : ''}">
							<td data-bind="text: no_tampilan, attr: {'align': level == 0 ? 'left': 'right'} "></td>
							<td>
								<div data-bind="if: level == 0">
									<strong><span data-bind="html: uraian_master"></span></strong>
									<br/><span data-bind="html: uraian == uraian_master ? '' : uraian"></span>
								</div>
								<div data-bind="if: level > 0">
									<span data-bind="html: uraian"></span>
								</div>
							</td>
							<td>
								<div class="control-group">
									<div class="radio" data-bind="visible: just_header == 0">
										<label>
											<input type="radio" class="ace" value="Ya" data-bind="checked: pil, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih3Ya($index(), parent) }}, enable: child == 0 || pil() == 'Ya'" />
											<span class="lbl"> Ya</span>
										</label>
										<label>
											<input type="radio" class="ace" value="Tidak" data-bind="checked: pil, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih3Tidak() }}, enable: child == 0 || pil() == 'Tidak'" />
											<span class="lbl"> Tidak</span>
										</label>
									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>

				<h3 class="header smaller lighter blue">Justifikasi Pemerataan Beban dan Manfaat:</h3>
				<div class="form-group">
					<textarea id="justifikasi3" class="autosize-transition form-control" data-bind="value: justifikasi3"></textarea>
				</div>

			</div>

			<div class="step-pane" data-step="4">
				<div class="form-group pull-right">
					<button class="btn btn-sm" id="reset4" data-bind="click: reset4">
						<i class="ace-icon fa fa-circle bigger-110"></i>
						Kosongkan
					</button>
				</div>

				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<tr><th width="5%">No</th><th width="80%">7-STANDAR KELAIKAN ETIK PENELITIAN</th><th width="15%">PILIHAN</th>
						</tr>
					</thead>
					<tbody data-bind="foreach: self_assesment4">
						<tr data-bind="attr: {'class': level == 0 ? 'active' : ''}">
							<td data-bind="text: no_tampilan, attr: {'align': level == 0 ? 'left': 'right'} "></td>
							<td>
								<div data-bind="if: level == 0">
									<strong><span data-bind="html: uraian_master"></span></strong>
									<br/><span data-bind="html: uraian == uraian_master ? '' : uraian"></span>
								</div>
								<div data-bind="if: level > 0">
									<span data-bind="html: uraian"></span>
								</div>
							</td>
							<td>
								<div class="control-group">
									<div class="radio" data-bind="visible: just_header == 0">
										<label>
											<input type="radio" class="ace" value="Ya" data-bind="checked: pil, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih4Ya($index(), parent) }}, enable: child == 0 || pil() == 'Ya'" />
											<span class="lbl"> Ya</span>
										</label>
										<label>
											<input type="radio" class="ace" value="Tidak" data-bind="checked: pil, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih4Tidak() }}, enable: child == 0 || pil() == 'Tidak'" />
											<span class="lbl"> Tidak</span>
										</label>
									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>

				<h3 class="header smaller lighter blue">Justifikasi Potensi Manfaat dan Resiko:</h3>
				<div class="form-group">
					<textarea id="justifikasi4" class="autosize-transition form-control" data-bind="value: justifikasi4"></textarea>
				</div>

			</div>

			<div class="step-pane" data-step="5">
				<div class="form-group pull-right">
					<button class="btn btn-sm" id="reset5" data-bind="click: reset5">
						<i class="ace-icon fa fa-circle bigger-110"></i>
						Kosongkan
					</button>
				</div>

				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<tr><th width="5%">No</th><th width="80%">7-STANDAR KELAIKAN ETIK PENELITIAN</th><th width="15%">PILIHAN</th>
						</tr>
					</thead>
					<tbody data-bind="foreach: self_assesment5">
						<tr data-bind="attr: {'class': level == 0 ? 'active' : ''}">
							<td data-bind="text: no_tampilan, attr: {'align': level == 0 ? 'left': 'right'} "></td>
							<td>
								<div data-bind="if: level == 0">
									<strong><span data-bind="html: uraian_master"></span></strong>
									<br/><span data-bind="html: uraian == uraian_master ? '' : uraian"></span>
								</div>
								<div data-bind="if: level > 0">
									<span data-bind="html: uraian"></span>
								</div>
							</td>
							<td>
								<div class="control-group">
									<div class="radio" data-bind="visible: just_header == 0">
										<label>
											<input type="radio" class="ace" value="Ya" data-bind="checked: pil, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih5Ya($index(), parent) }}, enable: child == 0 || pil() == 'Ya'" />
											<span class="lbl"> Ya</span>
										</label>
										<label>
											<input type="radio" class="ace" value="Tidak" data-bind="checked: pil, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih5Tidak() }}, enable: child == 0 || pil() == 'Tidak'" />
											<span class="lbl"> Tidak</span>
										</label>
									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>

				<h3 class="header smaller lighter blue">Justifikasi Bujukan/ Eksploitasi/ Iducement:</h3>
				<div class="form-group">
					<textarea id="justifikasi5" class="autosize-transition form-control" data-bind="value: justifikasi5"></textarea>
				</div>

			</div>

			<div class="step-pane" data-step="6">
				<div class="form-group pull-right">
					<button class="btn btn-sm" id="reset6" data-bind="click: reset6">
						<i class="ace-icon fa fa-circle bigger-110"></i>
						Kosongkan
					</button>
				</div>

				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<tr><th width="5%">No</th><th width="80%">7-STANDAR KELAIKAN ETIK PENELITIAN</th><th width="15%">PILIHAN</th>
						</tr>
					</thead>
					<tbody data-bind="foreach: self_assesment6">
						<tr data-bind="attr: {'class': level == 0 ? 'active' : ''}">
							<td data-bind="text: no_tampilan, attr: {'align': level == 0 ? 'left': 'right'} "></td>
							<td>
								<div data-bind="if: level == 0">
									<strong><span data-bind="html: uraian_master"></span></strong>
									<br/><span data-bind="html: uraian == uraian_master ? '' : uraian"></span>
								</div>
								<div data-bind="if: level > 0">
									<span data-bind="html: uraian"></span>
								</div>
							</td>
							<td>
								<div class="control-group">
									<div class="radio" data-bind="visible: just_header == 0">
										<label>
											<input type="radio" class="ace" value="Ya" data-bind="checked: pil, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih6Ya($index(), parent) }}, enable: child == 0 || pil() == 'Ya'" />
											<span class="lbl"> Ya</span>
										</label>
										<label>
											<input type="radio" class="ace" value="Tidak" data-bind="checked: pil, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih6Tidak() }}, enable: child == 0 || pil() == 'Tidak'" />
											<span class="lbl"> Tidak</span>
										</label>
									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>

				<h3 class="header smaller lighter blue">Justifikasi Rahasia dan Privacy:</h3>
				<div class="form-group">
					<textarea id="justifikasi6" class="autosize-transition form-control" data-bind="value: justifikasi6"></textarea>
				</div>

			</div>

			<div class="step-pane" data-step="7">
				<div class="form-group pull-right">
					<button class="btn btn-sm" id="reset7" data-bind="click: reset7">
						<i class="ace-icon fa fa-circle bigger-110"></i>
						Kosongkan
					</button>
				</div>

				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<tr><th width="5%">No</th><th width="80%">7-STANDAR KELAIKAN ETIK PENELITIAN</th><th width="15%">PILIHAN</th>
						</tr>
					</thead>
					<tbody data-bind="foreach: self_assesment7">
						<tr data-bind="attr: {'class': level == 0 ? 'active' : ''}">
							<td data-bind="text: no_tampilan, attr: {'align': level == 0 ? 'left': 'right'} "></td>
							<td>
								<div data-bind="if: level == 0">
									<strong><span data-bind="html: uraian_master"></span></strong>
									<br/><span data-bind="html: uraian == uraian_master ? '' : uraian"></span>
								</div>
								<div data-bind="if: level > 0">
									<span data-bind="html: uraian"></span>
								</div>
							</td>
							<td>
								<div class="control-group">
									<div class="radio" data-bind="visible: just_header == 0">
										<label>
											<input type="radio" class="ace" value="Ya" data-bind="checked: pil, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih7Ya($index(), parent) }}, enable: child == 0 || pil() == 'Ya'" />
											<span class="lbl"> Ya</span>
										</label>
										<label>
											<input type="radio" class="ace" value="Tidak" data-bind="checked: pil, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih7Tidak() }}, enable: child == 0 || pil() == 'Tidak'" />
											<span class="lbl"> Tidak</span>
										</label>
									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>

				<h3 class="header smaller lighter blue">Justifikasi Informed Consent:</h3>
				<div class="form-group">
					<textarea id="justifikasi7" class="autosize-transition form-control" data-bind="value: justifikasi7"></textarea>
				</div>

			</div>

		</div>
	</div>

	<hr />
	<div class="wizard-actions">
		<button class="btn btn-sm btn-prev">
			<i class="ace-icon fa fa-arrow-left"></i>
			Sebelumnya
		</button>

		<button class="btn btn-sm btn-success btn-next" data-last="Selesai">
			Selanjutnya
			<i class="ace-icon fa fa-arrow-right icon-on-right"></i>
		</button>
	</div>
</div><!-- /.widget-main -->

<div class="clearfix form-actions">
	<div class="col-md-offset-3 col-md-9">
		<button class="btn btn-info" id="submit" type="button" data-loading-text="Proses..." data-bind="click: function(data, event){save(false, data, event) }, enable: is_resume == 0">
			<i class="ace-icon fa fa-floppy-o bigger-110"></i>
			Simpan
		</button>

		&nbsp; &nbsp; &nbsp;
		<button class="btn btn-warning" type="button" data-bind="click: back, enable: !processing()">
			<i class="ace-icon fa fa-list bigger-110"></i>
			Lihat Daftar
		</button>

		&nbsp; &nbsp; &nbsp;
		<button class="btn btn-success" id="kirim" type="button" data-loading-text="Mengirim..." data-bind="click: kirim, enable: id() > 0 && is_resume == 0 && is_kirim() == 0">
			<i class="ace-icon fa fa-envelope bigger-110"></i>
			<span data-bind="text: lbl_btn_kirim"></span> ke KEPK
		</button>

		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<button class="btn btn-default" id="print" type="button" data-bind="click: print, enable: id() > 0">
			<i class="ace-icon fa fa-print bigger-110"></i>
			Cetak Self Assesment
		</button>
	</div>
</div>