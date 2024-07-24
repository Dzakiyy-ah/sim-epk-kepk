<div class="row">
	<div class="col-xs-12 col-sm-12">
		<div class="widget-box transparent">
			<div class="widget-header widget-header-small">
				<h4 class="widget-title smaller">
					<i class="ace-icon fa fa-file bigger-110"></i>
					Nomor Protokol
					<span class="pull-right label label-lg label-warning arrowed-in arrowed-in-right" data-bind="visible: keputusan != '', text: lbl_keputusan"></span>
				</h4>
			</div>

			<div class="widget-body">
				<div class="widget-main">
					<div class="form-group">
						<select class="select2 form-control" id="id_pep" data-bind="value: id_pep, enable: id() == 0" data-placeholder="Nomor Protokol">
							<option value=""></option>
							<?php
							if (isset($protokol))
							{
								for ($i=0; $i<count($protokol); $i++)
								{
									echo '<option value="'.$protokol[$i]['id_pep'].'">'.$protokol[$i]['no_protokol'].' - '.$protokol[$i]['judul'].'</option>';
								}

								if (isset($data['id_pep']) && $data['id_pep'] > 0)
								{
									echo '<option value="'.$data['id_pep'].'">'.$data['no_protokol'].' - '.$data['judul'].'</option>';
								}
							}
							?>
						</select>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>

<div data-bind="foreach: resume">
	<h4 class="header smaller blue">
		<i class="ace-icon fa fa-file-o bigger-110"></i> Resume Sekretaris <span data-bind="text: nama_sekretaris"></span>
	</h4>
	<div class="row">
		<div class="col-xs-12 col-sm-12 widget-container-col">
			<div class="widget-box">
				<div class="widget-header">
					<div class="widget-toolbar">
						<a href="#" data-action="fullscreen" class="orange2">
							<i class="ace-icon fa fa-expand"></i>
						</a>

						<a href="#" data-action="collapse">
							<i class="ace-icon fa fa-chevron-up"></i>
						</a>

					</div>
				</div>

				<div class="widget-body">
					<div class="widget-main">
						<p data-bind="html: resume_sekretaris !== '' ? resume_sekretaris : '<i>null</i>'"></p>
					</div>
				</div>
			</div>
		</div>

		<div class="hr hr-dotted"></div>
	</div>
</div>

<div data-bind="foreach: telaah_awal">
	<h4 class="header smaller blue">
		<i class="ace-icon fa fa-pencil-square-o bigger-110"></i> Telaah Awal <span data-bind="text: nama_penelaah"></span>
	</h4>
	<div class="row">
		<div class="col-xs-12 col-sm-12 widget-container-col">
			<div class="widget-box">
				<div class="widget-header">
					<div class="widget-toolbar">
            <a href="#" data-bind="click: function(data, event){$root.print_telaah_awal(id_ta, data, event) }">
              <i class="ace-icon fa fa-print"></i>
            </a>

						<a href="#" data-action="fullscreen" class="orange2">
							<i class="ace-icon fa fa-expand"></i>
						</a>

						<a href="#" data-action="collapse">
							<i class="ace-icon fa fa-chevron-up"></i>
						</a>

					</div>
				</div>

				<div class="widget-body">
					<div class="widget-main">
						<h5 class="header smaller lighter blue">Klasifikasi Usulan <span data-bind="text: nama_penelaah"></span></h5>
						<div class="radio">
							<label>
								<input type="radio" class="ace" value="1" data-bind="checked: klasifikasi_usulan, enable: klasifikasi_usulan === '1'" />
								<span class="lbl"> Exempted </span>
							</label>
							<label>
								<input type="radio" class="ace" value="2" data-bind="checked: klasifikasi_usulan, enable: klasifikasi_usulan === '2'" />
								<span class="lbl"> Expedited </span>
							</label>
							<label>
								<input type="radio" class="ace" value="3" data-bind="checked: klasifikasi_usulan, enable: klasifikasi_usulan === '3'" />
								<span class="lbl"> Full Board </span>
							</label>
						</div>
						<h5 class="header smaller lighter blue">Catatan Protokol</h5>
						<p data-bind="html: catatan_protokol !== '' ? catatan_protokol : '<i>null</i>'"></p>
						<h5 class="header smaller lighter blue">Catatan 7 Standar</h5>
						<p data-bind="html: catatan_7standar !== '' ? catatan_7standar : '<i>null</i>'"></p>
					</div>
				</div>
			</div>
		</div>

		<div class="hr hr-dotted"></div>
	</div>
</div>

<div class="space-12"></div>

<div class="row">
	<div class="col-xs-12 col-sm-5">
		<div class="widget-box transparent">
			<div class="widget-header widget-header-small">
				<h4 class="widget-title smaller">
					<i class="ace-icon fa fa-check-square-o bigger-110"></i>
					Klasifikasi Protokol
				</h4>
			</div>

			<div class="widget-body">
				<div class="widget-main">
					<div class="form-group">
						<div class="radio">
							<label>
								<input name="klasifikasi" type="radio" class="ace" value="1" data-bind="checked: klasifikasi" />
								<span class="lbl"> Exempted </span>
							</label>
							<label>
								<input name="klasifikasi" type="radio" class="ace" value="2" data-bind="checked: klasifikasi" />
								<span class="lbl"> Expedited </span>
							</label>
							<label>
								<input name="klasifikasi" type="radio" class="ace" value="3" data-bind="checked: klasifikasi" />
								<span class="lbl"> Full Board </span>
							</label>
						</div>
					</div>
					<div class="alert alert-block alert-info" data-bind="visible: klasifikasi() == 2">
						Dalam proses telaah etik dipercepat, usulan dikirim kepada dua anggota KEPK yang diperlukan untuk memberikan umpan balik mereka ke sekretariat dalam waktu 5—10 hari kerja. Persetujuan disampaikan kepada petugas sekretariat. Jika terjadi perbedaan pendapat atau keputusan di antara dua anggota KEPK, ketua akan mengirimkan kepada satu anggota lainnya atau ahli yang kompeten untuk pertimbangan keputusan akhir.
						</div>

					<div class="hr hr-dotted"></div>

					<div class="form-group" data-bind="visible: klasifikasi() == 2 || klasifikasi() == 3" style="width: 100%">
						<label>Penelaah <span data-bind="text: checkKlasifikasi"></span></label>
            <select class="select2 form-control" id="penelaah_etik" data-placeholder="Penelaah" multiple="true" data-bind="selectedOptions: penelaah_etik">
            	<option value=""> </option>
          	<?php 
          	if ($data_penelaah)
          	{
          		for ($i=0; $i<count($data_penelaah); $i++)
          		{
          			echo '<option value="'.$data_penelaah[$i]['id_atk'].'">'.$data_penelaah[$i]['nomor'].' - '.$data_penelaah[$i]['nama'].'</option>';
          		}
          	}
          	?>
            </select>
          </div>

					<div class="hr hr-dotted"></div>

					<div class="form-group" data-bind="visible: klasifikasi() == 2 || klasifikasi() == 3" style="width: 100%">
						<label>Pelapor</label>
            <select class="select2 form-control" id="pelapor" data-placeholder="Pelapor" data-bind="value: pelapor">
            	<option value=""> </option>
            </select>
          </div>

					<div class="hr hr-dotted"></div>

					<div class="form-group" data-bind="visible: klasifikasi() == 3" style="width: 100%">
						<label>Lay Person Full Board</label>
            <select class="select2 form-control" id="lay_person" data-placeholder="Lay Person" multiple="true" data-bind="selectedOptions: lay_person">
            	<option value=""> </option>
          	<?php 
          	if ($data_lay_person)
          	{
          		for ($i=0; $i<count($data_lay_person); $i++)
          		{
          			echo '<option value="'.$data_lay_person[$i]['id_atk'].'">'.$data_lay_person[$i]['nomor'].' - '.$data_lay_person[$i]['nama'].'</option>';
          		}
          	}
          	?>
            </select>
          </div>

					<div class="hr hr-dotted"></div>

					<div class="form-group" data-bind="visible: klasifikasi() == 2 || klasifikasi() == 3" style="width: 100%">
						<label>Konsultan Independen <span data-bind="text: checkKlasifikasi"></span></label>
            <select class="select2 form-control" id="konsultan" data-placeholder="Konsultan Independen" multiple="true" data-bind="selectedOptions: konsultan">
            	<option value=""> </option>
          	<?php 
          	if ($data_konsultan)
          	{
          		for ($i=0; $i<count($data_konsultan); $i++)
          		{
          			echo '<option value="'.$data_konsultan[$i]['id_atk'].'">'.$data_konsultan[$i]['nomor'].' - '.$data_konsultan[$i]['nama'].'</option>';
          		}
          	}
          	?>
            </select>
          </div>

				</div>
			</div>
		</div>
	</div>

	<div class="col-xs-12 col-sm-7">
		<div class="widget-box transparent">
			<div class="widget-header widget-header-small header-color-blue2">
				<h4 class="widget-title smaller">
					<i class="ace-icon fa fa-lightbulb-o bigger-120"></i>
					Klasifikasi Usulan Penelaah (%)
				</h4>
			</div>

			<div class="widget-body">
				<div class="widget-main padding-16">
					<h5>Total yang menelaah: <span data-bind="text: jml_penelaah"></span></h5>
					<div class="hr hr-dotted"></div>
					<div class="clearfix">
						<div class="grid4 center">
							<div class="easy-pie-chart percentage" id="persen1" data-percent="0" data-color="#59A84B"">
								<span class="percent" data-bind="text: persen1"></span>%
							</div>

							<div class="space-2"></div>
							Exempted

							<div class="hr hr-dotted"></div>
							<ol data-bind="foreach: pe_exempted">
								<li><small data-bind="text: nomor"></small> - <small data-bind="text: nama"></small></li>
							</ol>
						</div>

						<div class="grid4 center">
							<div class="center easy-pie-chart percentage" id="persen2" data-percent="0" data-color="#f0AD4E">
								<span class="percent" data-bind="text: persen2"></span>%
							</div>

							<div class="space-2"></div>
							Expedited

							<div class="hr hr-dotted"></div>
							<ol data-bind="foreach: pe_expedited">
								<li><small data-bind="text: nomor"></small> - <small data-bind="text: nama"></small></li>
							</ol>
						</div>

						<div class="grid4 center">
							<div class="center easy-pie-chart percentage" id="persen3" data-percent="0" data-color="#CA5952"">
								<span class="percent" data-bind="text: persen3"></span>%
							</div>

							<div class="space-2"></div>
							Full Board

							<div class="hr hr-dotted"></div>
							<ol data-bind="foreach: pe_fullboard">
								<li><small data-bind="text: nomor"></small> - <small data-bind="text: nama"></small></li>
							</ol>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>

</div>

<h4 class="header smaller blue" data-bind="visible: klasifikasi() == 1">
	<i class="ace-icon fa fa-certificate bigger-110"></i> 7 Standar
</h4>
<div class="alert alert-info" data-bind="visible: id() == 0 && klasifikasi() == 1">
  <button type="button" class="close" data-dismiss="alert">
    <i class="ace-icon fa fa-times"></i>
  </button>
  Pilihan Ketua/Wakil Ketua beberapa item/poin <strong>7-Standar Kelainan Etik Penelitian</strong> secara default terisi "Ya"
</div>

<div class="row" data-bind="visible: klasifikasi() == 1">
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
							<th width="5%">No</th>
							<th width="75%">7-STANDAR KELAIKAN ETIK PENELITIAN</th>
							<th width="10%">PENELITI</th>
							<th width="10%">
                <?php
                if ($this->session->userdata('id_group_'.APPAUTH) == 7)
                  echo 'KETUA';
                else if ($this->session->userdata('id_group_'.APPAUTH) == 8)
                  echo 'WAKIL KETUA';
                ?>
              </th>
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
								<div class="control-group" data-bind="visible: just_header == 0">
                  <div class="radio">
										<label>
											<input type="radio" class="ace" value="Ya" data-bind="checked: pil_pengaju, attr:{'name': $index().$data}, enable: pil_pengaju == 'Ya'" />
											<span class="lbl"> Ya</span>
										</label>
									</div>
                  <div class="radio">
										<label>
											<input type="radio" class="ace" value="Tidak" data-bind="checked: pil_pengaju, attr:{'name': $index().$data}, enable: pil_pengaju == 'Tidak'" />
											<span class="lbl"> Tidak</span>
										</label>
									</div>
								</div>
							</td>
							<td>
								<div class="control-group" data-bind="visible: just_header == 0">
                  <div class="radio">
										<label>
											<input type="radio" class="ace" value="Ya" data-bind="checked: pil_ketua, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih1Ya($index(), parent) }}, enable: child == 0 || pil_ketua() == 'Ya'" />
											<span class="lbl"> Ya</span>
										</label>
									</div>
                  <div class="radio">
										<label>
											<input type="radio" class="ace" value="Tidak" data-bind="checked: pil_ketua, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih1Tidak() }}, enable: child == 0 || pil_ketua() == 'Tidak'" />
											<span class="lbl"> Tidak</span>
										</label>
									</div>
                  <div class="radio">
										<label>
											<input type="radio" class="ace" value="NA" data-bind="checked: pil_ketua, attr:{'name': $index().$data}, enable: child == 0 || pil_ketua() == 'NA'" />
											<span class="lbl"> NA</span>
										</label>
									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>

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
							<th width="5%">No</th>
							<th width="75%">7-STANDAR KELAIKAN ETIK PENELITIAN</th>
							<th width="10%">PENELITI</th>
							<th width="10%">
                <?php
                if ($this->session->userdata('id_group_'.APPAUTH) == 7)
                  echo 'KETUA';
                else if ($this->session->userdata('id_group_'.APPAUTH) == 8)
                  echo 'WAKIL KETUA';
                ?>
              </th>
						</tr>
					</thead>
					<tbody data-bind="foreach: self_assesment2">
						<tr data-bind="attr: {'class': level == 0 ? 'active' : ''}">
							<td data-bind="html: no, attr: {'align': level == 0 ? 'left': 'right'} "></td>
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
								<div class="control-group" data-bind="visible: just_header == 0">
									<div class="radio">
										<label>
											<input type="radio" class="ace" value="Ya" data-bind="checked: pil_pengaju, attr:{'name': $index().$data}, enable: pil_pengaju == 'Ya'" />
											<span class="lbl"> Ya</span>
										</label>
									</div>
									<div class="radio">
										<label>
											<input type="radio" class="ace" value="Tidak" data-bind="checked: pil_pengaju, attr:{'name': $index().$data}, enable: pil_pengaju == 'Tidak'" />
											<span class="lbl"> Tidak</span>
										</label>
									</div>
								</div>
							</td>
							<td>
								<div class="control-group" data-bind="visible: just_header == 0">
                  <div class="radio">
										<label>
											<input type="radio" class="ace" value="Ya" data-bind="checked: pil_ketua, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih2Ya($index(), parent) }}, enable: child == 0 || pil_ketua() == 'Ya'" />
											<span class="lbl"> Ya</span>
										</label>
									</div>
                  <div class="radio">
										<label>
											<input type="radio" class="ace" value="Tidak" data-bind="checked: pil_ketua, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih2Tidak() }}, enable: child == 0 || pil_ketua() == 'Tidak'" />
											<span class="lbl"> Tidak</span>
										</label>
									</div>
                  <div class="radio">
										<label>
											<input type="radio" class="ace" value="NA" data-bind="checked: pil_ketua, attr:{'name': $index().$data}, enable: child == 0 || pil_ketua() == 'NA'" />
											<span class="lbl"> NA</span>
										</label>
									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>

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
							<th width="5%">No</th>
							<th width="75%">7-STANDAR KELAIKAN ETIK PENELITIAN</th>
							<th width="10%">PENELITI</th>
							<th width="10%">
                <?php
                if ($this->session->userdata('id_group_'.APPAUTH) == 7)
                  echo 'KETUA';
                else if ($this->session->userdata('id_group_'.APPAUTH) == 8)
                  echo 'WAKIL KETUA';
                ?>
              </th>
						</tr>
					</thead>
					<tbody data-bind="foreach: self_assesment3">
            <tr data-bind="attr: {'class': level == 0 ? 'active' : ''}">
              <td data-bind="html: no, attr: {'align': level == 0 ? 'left': 'right'} "></td>
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
								<div class="control-group" data-bind="visible: just_header == 0">
									<div class="radio">
										<label>
											<input type="radio" class="ace" value="Ya" data-bind="checked: pil_pengaju, attr:{'name': $index().$data}, enable: pil_pengaju == 'Ya'" />
											<span class="lbl"> Ya</span>
										</label>
									</div>
									<div class="radio">
										<label>
											<input type="radio" class="ace" value="Tidak" data-bind="checked: pil_pengaju, attr:{'name': $index().$data}, enable: pil_pengaju == 'Tidak'" />
											<span class="lbl"> Tidak</span>
										</label>
									</div>
								</div>
							</td>
							<td>
								<div class="control-group" data-bind="visible: just_header == 0">
									<div class="radio">
										<label>
											<input type="radio" class="ace" value="Ya" data-bind="checked: pil_ketua, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih3Ya($index(), parent) }}, enable: child == 0 || pil_ketua() == 'Ya'" />
											<span class="lbl"> Ya</span>
										</label>
									</div>
									<div class="radio">
										<label>
											<input type="radio" class="ace" value="Tidak" data-bind="checked: pil_ketua, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih3Tidak() }}, enable: child == 0 || pil_ketua() == 'Tidak'" />
											<span class="lbl"> Tidak</span>
										</label>
									</div>
									<div class="radio">
										<label>
											<input type="radio" class="ace" value="NA" data-bind="checked: pil_ketua, attr:{'name': $index().$data}, enable: child == 0 || pil_ketua() == 'NA'" />
											<span class="lbl"> NA</span>
										</label>
									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>

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
							<th width="5%">No</th>
							<th width="75%">7-STANDAR KELAIKAN ETIK PENELITIAN</th>
							<th width="10%">PENELITI</th>
							<th width="10%">
                <?php
                if ($this->session->userdata('id_group_'.APPAUTH) == 7)
                  echo 'KETUA';
                else if ($this->session->userdata('id_group_'.APPAUTH) == 8)
                  echo 'WAKIL KETUA';
                ?>
              </th>
						</tr>
					</thead>
					<tbody data-bind="foreach: self_assesment4">
            <tr data-bind="attr: {'class': level == 0 ? 'active' : ''}">
              <td data-bind="html: no, attr: {'align': level == 0 ? 'left': 'right'} "></td>
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
								<div class="control-group" data-bind="visible: just_header == 0">
									<div class="radio">
										<label>
											<input type="radio" class="ace" value="Ya" data-bind="checked: pil_pengaju, attr:{'name': $index().$data}, enable: pil_pengaju == 'Ya'" />
											<span class="lbl"> Ya</span>
										</label>
									</div>
									<div class="radio">
										<label>
											<input type="radio" class="ace" value="Tidak" data-bind="checked: pil_pengaju, attr:{'name': $index().$data}, enable: pil_pengaju == 'Tidak'" />
											<span class="lbl"> Tidak</span>
										</label>
									</div>
								</div>
							</td>
							<td>
								<div class="control-group" data-bind="visible: just_header == 0">
									<div class="radio">
										<label>
											<input type="radio" class="ace" value="Ya" data-bind="checked: pil_ketua, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih4Ya($index(), parent) }}, enable: child == 0 || pil_ketua() == 'Ya'" />
											<span class="lbl"> Ya</span>
										</label>
									</div>
									<div class="radio">
										<label>
											<input type="radio" class="ace" value="Tidak" data-bind="checked: pil_ketua, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih4Tidak() }}, enable: child == 0 || pil_ketua() == 'Tidak'" />
											<span class="lbl"> Tidak</span>
										</label>
									</div>
									<div class="radio">
										<label>
											<input type="radio" class="ace" value="NA" data-bind="checked: pil_ketua, attr:{'name': $index().$data}, enable: child == 0 || pil_ketua() == 'NA'" />
											<span class="lbl"> NA</span>
										</label>
									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>

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
							<th width="5%">No</th>
							<th width="75%">7-STANDAR KELAIKAN ETIK PENELITIAN</th>
							<th width="10%">PENELITI</th>
							<th width="10%">
                <?php
                if ($this->session->userdata('id_group_'.APPAUTH) == 7)
                  echo 'KETUA';
                else if ($this->session->userdata('id_group_'.APPAUTH) == 8)
                  echo 'WAKIL KETUA';
                ?>
              </th>
						</tr>
					</thead>
					<tbody data-bind="foreach: self_assesment5">
            <tr data-bind="attr: {'class': level == 0 ? 'active' : ''}">
              <td data-bind="html: no, attr: {'align': level == 0 ? 'left': 'right'} "></td>
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
								<div class="control-group" data-bind="visible: just_header == 0">
									<div class="radio">
										<label>
											<input type="radio" class="ace" value="Ya" data-bind="checked: pil_pengaju, attr:{'name': $index().$data}, enable: pil_pengaju == 'Ya'" />
											<span class="lbl"> Ya</span>
										</label>
									</div>
									<div class="radio">
										<label>
											<input type="radio" class="ace" value="Tidak" data-bind="checked: pil_pengaju, attr:{'name': $index().$data}, enable: pil_pengaju == 'Tidak'" />
											<span class="lbl"> Tidak</span>
										</label>
									</div>
								</div>
							</td>
							<td>
								<div class="control-group" data-bind="visible: just_header == 0">
									<div class="radio">
										<label>
											<input type="radio" class="ace" value="Ya" data-bind="checked: pil_ketua, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih5Ya($index(), parent) }}, enable: child == 0 || pil_ketua() == 'Ya'" />
											<span class="lbl"> Ya</span>
										</label>
									</div>
									<div class="radio">
										<label>
											<input type="radio" class="ace" value="Tidak" data-bind="checked: pil_ketua, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih5Tidak() }}, enable: child == 0 || pil_ketua() == 'Tidak'" />
											<span class="lbl"> Tidak</span>
										</label>
									</div>
									<div class="radio">
										<label>
											<input type="radio" class="ace" value="NA" data-bind="checked: pil_ketua, attr:{'name': $index().$data}, enable: child == 0 || pil_ketua() == 'NA'" />
											<span class="lbl"> NA</span>
										</label>
									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>

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
							<th width="5%">No</th>
							<th width="75%">7-STANDAR KELAIKAN ETIK PENELITIAN</th>
							<th width="10%">PENELITI</th>
							<th width="10%">
                <?php
                if ($this->session->userdata('id_group_'.APPAUTH) == 7)
                  echo 'KETUA';
                else if ($this->session->userdata('id_group_'.APPAUTH) == 8)
                  echo 'WAKIL KETUA';
                ?>
              </th>
						</tr>
					</thead>
					<tbody data-bind="foreach: self_assesment6">
            <tr data-bind="attr: {'class': level == 0 ? 'active' : ''}">
              <td data-bind="html: no, attr: {'align': level == 0 ? 'left': 'right'} "></td>
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
								<div class="control-group" data-bind="visible: just_header == 0">
									<div class="radio">
										<label>
											<input type="radio" class="ace" value="Ya" data-bind="checked: pil_pengaju, attr:{'name': $index().$data}, enable: pil_pengaju == 'Ya'" />
											<span class="lbl"> Ya</span>
										</label>
									</div>
									<div class="radio">
										<label>
											<input type="radio" class="ace" value="Tidak" data-bind="checked: pil_pengaju, attr:{'name': $index().$data}, enable: pil_pengaju == 'Tidak'" />
											<span class="lbl"> Tidak</span>
										</label>
									</div>
								</div>
							</td>
							<td>
								<div class="control-group" data-bind="visible: just_header == 0">
									<div class="radio">
										<label>
											<input type="radio" class="ace" value="Ya" data-bind="checked: pil_ketua, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih6Ya($index(), parent) }}, enable: child == 0 || pil_ketua() == 'Ya'" />
											<span class="lbl"> Ya</span>
										</label>
									</div>
									<div class="radio">
										<label>
											<input type="radio" class="ace" value="Tidak" data-bind="checked: pil_ketua, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih6Tidak() }}, enable: child == 0 || pil_ketua() == 'Tidak'" />
											<span class="lbl"> Tidak</span>
										</label>
									</div>
									<div class="radio">
										<label>
											<input type="radio" class="ace" value="NA" data-bind="checked: pil_ketua, attr:{'name': $index().$data}, enable: child == 0 || pil_ketua() == 'NA'" />
											<span class="lbl"> NA</span>
										</label>
									</div>
								</div>
							</td>										
						</tr>
					</tbody>
				</table>

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
							<th width="5%">No</th>
							<th width="75%">7-STANDAR KELAIKAN ETIK PENELITIAN</th>
							<th width="10%">PENELITI</th>
							<th width="10%">
                <?php
                if ($this->session->userdata('id_group_'.APPAUTH) == 7)
                  echo 'KETUA';
                else if ($this->session->userdata('id_group_'.APPAUTH) == 8)
                  echo 'WAKIL KETUA';
                ?>
              </th>
						</tr>
					</thead>
					<tbody data-bind="foreach: self_assesment7">
            <tr data-bind="attr: {'class': level == 0 ? 'active' : ''}">
              <td data-bind="html: no, attr: {'align': level == 0 ? 'left': 'right'} "></td>
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
								<div class="control-group" data-bind="visible: just_header == 0">
									<div class="radio">
										<label>
											<input type="radio" class="ace" value="Ya" data-bind="checked: pil_pengaju, attr:{'name': $index().$data}, enable: pil_pengaju == 'Ya'" />
											<span class="lbl"> Ya</span>
										</label>
									</div>
									<div class="radio">
										<label>
											<input type="radio" class="ace" value="Tidak" data-bind="checked: pil_pengaju, attr:{'name': $index().$data}, enable: pil_pengaju == 'Tidak'" />
											<span class="lbl"> Tidak</span>
										</label>
									</div>
								</div>
							</td>
							<td>
								<div class="control-group" data-bind="visible: just_header == 0">
									<div class="radio">
										<label>
											<input type="radio" class="ace" value="Ya" data-bind="checked: pil_ketua, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih7Ya($index(), parent) }}, enable: child == 0 || pil_ketua() == 'Ya'" />
											<span class="lbl"> Ya</span>
										</label>
									</div>
									<div class="radio">
										<label>
											<input type="radio" class="ace" value="Tidak" data-bind="checked: pil_ketua, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih7Tidak() }}, enable: child == 0 || pil_ketua() == 'Tidak'" />
											<span class="lbl"> Tidak</span>
										</label>
									</div>
									<div class="radio">
										<label>
											<input type="radio" class="ace" value="NA" data-bind="checked: pil_ketua, attr:{'name': $index().$data}, enable: child == 0 || pil_ketua() == 'NA'" />
											<span class="lbl"> NA</span>
										</label>
									</div>
								</div>
							</td>										
						</tr>
					</tbody>
				</table>

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
</div>

	<div class="row">
		<div class="col-xs-12 col-sm-12">
			<div class="widget-box transparent">
				<div class="widget-header widget-header-small">
					<h4 class="widget-title smaller">
						<i class="ace-icon fa fa-align-justify bigger-110"></i>
						Catatan Putusan Awal
					</h4>
				</div>

				<div class="widget-body">
					<div class="widget-main">
						<div class="wysiwyg-editor" id="catatan"></div>		
					</div>
				</div>
			</div>
		</div>
	</div>

<div class="clearfix form-actions">
	<div class="col-md-offset-3 col-md-9">
		<button class="btn btn-primary" id="submit" type="button" data-loading-text="Proses..." data-bind="click: function(data, event){save(false, data, event) }, enable: keputusan == ''">
			<i class="ace-icon fa fa-floppy-o bigger-110"></i>
			Simpan & Kirim
		</button>

		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<button class="btn btn-warning" id="back" type="button" data-bind="click: back">
			<i class="ace-icon fa fa-list bigger-110"></i>
			Lihat Daftar
		</button>
	</div>
</div>
