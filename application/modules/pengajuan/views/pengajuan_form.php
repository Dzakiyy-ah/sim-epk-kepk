<form class="form-horizontal" role="form" enctype="multipart/form-data" method="post">
	<h4 class="header smaller lighter blue">KEPK Tujuan</h4>
	<div class="form-group">
		<div class="col-sm-12">
			<label for="kepk">Nama KEPK</label>
      <input type="text" id="nama_kepk" class="form-control" data-bind="value: nama_kepk" readonly="true" />
		</div>
  </div>
  <div class="form-group">
		<div class="col-sm-4">
 			<label for="nama_bank">Nama Bank</label>
			<input type="text" id="nama_bank" class="form-control" data-bind="value: nama_bank" readonly="true" />
		</div>
		<div class="col-sm-8">
 			<label for="no_rekening">No Rekening</label>
			<input type="text" id="no_rekening" class="form-control" data-bind="value: no_rekening" readonly="true" />
		</div>
  </div>
  <div class="form-group">
		<div class="col-sm-8">
 			<label for="pemilik_rekening">Pemilik Rekening</label>
			<input type="text" id="pemilik_rekening" class="form-control" data-bind="value: pemilik_rekening" readonly="true" />
		</div>
		<div class="col-sm-2">
 			<label for="swift_code">Swift Code</label>
			<input type="text" id="swift_code" class="form-control" data-bind="value: swift_code" readonly="true" />
		</div>
    <div class="col-sm-2">
      <label for="tarif_telaah">Tarif/Biaya Telaah</label>
      <input type="text" id="tarif_telaah" class="form-control" data-bind="value: tarif_telaah" readonly="true" style="text-align: right;" />
    </div>
	</div>

	<h4 class="header smaller lighter blue">Judul Protokol</h4>
	<div class="form-group">
		<div class="col-sm-2">
			<select class="select2 form-control" id="jns_penelitian" data-bind="value: jns_penelitian, enable: id() == 0" data-placeholder="Jenis Penelitian">
				<option value=""></option>
				<option value="1">Observasional</option>
				<option value="2">Intervensi</option>
				<option value="3">Uji Klinik</option>
			</select>
		</div>

		<div class="col-sm-2">
			<select class="select2 form-control" id="asal_pengusul" data-bind="value: asal_pengusul, enable: id() == 0" data-placeholder="Asal Pengusul">
				<option value=""></option>
				<option value="1">Internal</option>
				<option value="2">Eksternal</option>
			</select>
		</div>

		<div class="col-sm-2">
			<select class="select2 form-control" id="jns_lembaga" data-bind="value: jns_lembaga, enable: id() == 0" data-placeholder="Jenis Lembaga Asal Pengusul" >
				<option value=""></option>
				<option value="1">Pendidikan</option>
				<option value="2">Rumah Sakit</option>
				<option value="3">Litbang</option>
			</select>
		</div>

		<div class="col-sm-2">
			<select class="select2 form-control" id="status_pengusul" data-bind="value: status_pengusul, enable: id() == 0" data-placeholder="Status Pengusul">
				<option value=""></option>
				<option value="1">Mahasiswa</option>
				<option value="2">Dosen</option>
				<option value="3">Pelaksana Pelayanan</option>
				<option value="4">Peneliti</option>
				<option value="5">Lainnya</option>
			</select>
		</div>

		<div class="col-sm-2">
			<select class="select2 form-control" id="strata_pend" data-bind="value: strata_pend, enable: id() == 0" data-placeholder="Strata Pendidikan Pengusul">
				<option value=""></option>
				<option value="1">Diploma III</option>
				<option value="2">Diploma IV</option>
				<option value="3">S-1</option>
				<option value="4">S-2</option>
				<option value="5">S-3</option>
				<option value="6">Sp-1</option>
				<option value="7">Sp-2</option>
				<option value="8">Lainnya</option>
			</select>
		</div>

	</div>

	<div class="form-group">
		<div class="col-sm-10">
			<label for="judul">Judul</label>
			<input type="text" id="judul" placeholder="Judul" class="form-control" data-bind="value: judul" />
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-10">
			<label for="title"><em>Title</em></label>
			<input type="text" id="title" placeholder="Title" class="form-control" data-bind="value: title" />
		</div>
	</div>

	<div class="space-4"></div>

	<h4 class="header smaller lighter blue">Peneliti Utama</h4>
	<div class="form-group">
		<div class="col-sm-4">
			<label for="nm_ketua">Ketua Pelaksana / Peneliti Utama</label>
			<input type="text" id="nm_ketua" placeholder="Ketua Pelaksana / Peneliti Utama" class="form-control" data-bind="value: nm_ketua" />
			<div><small>Nama dan Gelar</small></div>
		</div>
		<div class="col-sm-2">
			<label for="telp_peneliti">Nomor Telepon</label>
			<input type="text" id="telp_peneliti" placeholder="Nomor Telepon" class="form-control" data-bind="value: telp_peneliti" />
		</div>
		<div class="col-sm-2">
			<label for="email_peneliti">Email</label>
			<input type="text" id="email_peneliti" placeholder="Email" class="form-control" data-bind="value: email_peneliti" />
		</div>
	</div>
	<h5 class="header smaller lighter blue">Anggota Penelitian</h5>
	<table class="table">
		<thead>
			<tr><th>Nama, Gelar</th><th>Nomor (Username Peneliti)</th></tr>
		</thead>
		<tbody data-bind="foreach: anggota_peneliti">
			<tr>
				<td>
					<input type="text" class="form-control" data-bind="value: nama" />
					<div><a href='#' data-bind='click: $root.removeAnggotaPeneliti'>Hapus</a></div>
				</td>
				<td><input type="text" class="form-control" data-bind="value: nomor" /></td>
			</tr>
		</tbody>
	</table>
	<button class="btn btn-xs" type="button" data-bind="click: addAnggotaPeneliti">
		<i class="ace-icon glyphicon glyphicon-plus"></i>Tambah Anggota Penelitian
	</button>

	<div class="space-4"></div>

	<h4 class="header smaller lighter blue">Komunikasi yang diinginkan</h4>
	<div class="form-group">
		<div class="col-sm-5">
			<div class="control-group">
				<div class="checkbox">
					<label>
						<input type="checkbox" class="ace" value="telepon" data-bind="checked: komunikasi" />
						<span class="lbl"> Telepon</span>
					</label>

					<label>
						<input type="checkbox" class="ace" value="email" data-bind="checked: komunikasi" />
						<span class="lbl"> Email</span>
					</label>

					<label>
						<input  type="checkbox" class="ace" value="fax" data-bind="checked: komunikasi" />
						<span class="lbl"> Fax</span>
					</label>

				</div>

			</div>
		</div>
	</div>

	<div class="space-4"></div>

	<h4 class="header smaller lighter blue">Asal Institusi Peneliti Utama</h4>
	<div class="form-group">
		<div class="col-sm-3">
			<label for="nm_institusi">Nama Institusi</label>
			<input type="text" id="nm_institusi" placeholder="Nama Institusi" class="form-control" data-bind="value: nm_institusi" />
		</div>
	</div>

	<div class="space-4"></div>

	<div class="form-group">
		<div class="col-sm-9">
			<label for="alm_inst">Alamat Institusi</label>
			<textarea id="alm_inst" placeholder="Alamat Institusi" class="autosize-transition form-control" data-bind="value: alm_inst"></textarea>
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-3">
			<label for="telp_inst">Nomor Telepon Institusi/Fax</label>
			<input type="text" id="telp_inst" placeholder="Nomor Telepon Institusi/Fax" class="form-control" data-bind="value: telp_inst" />
		</div>

		<div class="col-sm-3">
			<label for="email_inst">Email Institusi</label>
			<input type="text" id="email_inst" placeholder="Email Institusi" class="form-control" data-bind="value: email_inst" />
		</div>
	</div>

	<div class="space-4"></div>

	<h4 class="header smaller lighter blue">Sumber Dana</h4>
	<div class="form-group">
		<div class="col-sm-3">
			<label for="sumber_dana">Sumber Dana</label>
			<input type="text" id="sumber_dana" placeholder="Sumber Dana" class="form-control" data-bind="value: sumber_dana" />
		</div>
		<div class="col-sm-3">
			<label for="total_dana">Total Dana</label>
			<input type="text" id="total_dana" placeholder="Total Dana" class="form-control" data-bind="value: total_dana" />
			<div><small>Gunakan titik ( . ) sebagai koma ( , ) misal: <strong>2000.00</strong> bukan <del>2.000,00</del></small></div>
		</div>
	</div>

	<div class="space-4"></div>

	<h4 class="header smaller lighter blue">Penelitian</h4>
	<div class="form-group">
		<div class="col-sm-5">
			<div class="control-group">
				<div class="radio">
					<label>
						<input name="penelitian" type="radio" class="ace" value="non" data-bind="checked: penelitian" />
						<span class="lbl"> Bukan kerjasama</span>
					</label>
				</div>

				<div class="radio">
					<label>
						<input name="penelitian" type="radio" class="ace" value="nasional" data-bind="checked: penelitian" />
						<span class="lbl"> Kerjasama nasional</span>
					</label>
				</div>

				<div class="radio">
					<label>
						<input name="penelitian" type="radio" class="ace" value="internasional" data-bind="checked: penelitian" />
						<span class="lbl"> Kerjasama internasional, Jumlah negara yang terlibat : </span>
						<input type="text" class="input-sm" id="jml_negara" data-bind="value: jml_negara" />
					</label>
				</div>

				<div class="radio">
					<label>
						<input name="penelitian" type="radio" class="ace" value="asing" data-bind="checked: penelitian" />
						<span class="lbl"> Melibatkan peneliti asing</span>
					</label>
				</div>

			</div>
		</div>
	</div>

	<h4 class="header smaller lighter blue">Diisi jika melibatkan peneliti asing</h4>
	<table class="table">
		<thead>
			<tr><th>Nama, Gelar</th><th>Institusi Peneliti Asing</th><th>Tugas & Fungsi</th><th>No. Telepon/Fax</th></tr>
		</thead>
		<tbody data-bind="foreach: peneliti_asing">
			<tr>
				<td>
					<input type="text" class="form-control" data-bind="value: nama" />
					<div><a href='#' data-bind='click: $root.removePenelitiAsing'>Hapus</a></div>
				</td>
				<td><input type="text" class="form-control" data-bind="value: institusi" /></td>
				<td><input type="text" class="form-control" data-bind="value: tugas" /></td>
				<td><input type="text" class="form-control" data-bind="value: telp" /></td>
			</tr>
		</tbody>
	</table>
	<button class="btn btn-xs" type="button" data-bind="click: addPenelitiAsing">
		<i class="ace-icon glyphicon glyphicon-plus"></i>Tambah Peneliti Asing
	</button>

	<div class="space-4"></div>

	<h4 class="header smaller lighter blue">Tempat dan Waktu Penelitian</h4>
	<div class="form-group">
		<div class="col-sm-3">
			<input type="text" id="tempat_penelitian" placeholder="Tempat" class="form-control" data-bind="value: tempat_penelitian" />
		</div>
		<div class="col-xs-8 col-sm-4">
			<div class="input-daterange input-group" data-date-format="dd/mm/yyyy">
				<input type="text" class="form-control" name="waktu_mulai" placeholder="Mulai" data-bind="value: waktu_mulai" />
				<span class="input-group-addon">
					<i class="fa fa-exchange"></i>
				</span>
				<input type="text" class="form-control" name="waktu_selesai" placeholder="Selesai" data-bind="value: waktu_selesai" />
			</div>
		</div>
	</div>

	<div class="space-4"></div>

	<h4 class="header smaller lighter blue">
		Apakah penelitian ini multi-senter?
		<label class="inline">
			<input id="is_multi_senter" type="checkbox" class="ace ace-switch" data-bind="checked: is_multi_senter" />
			<span class="lbl middle" data-lbl="Ya&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tidak"></span>
		</label>
	</h4>
	<div class="form-group" data-bind="visible: is_multi_senter()">					
		<div class="col-sm-5">
			<label for="tempat_multi_senter">Tempat Multi Senter</label>
			<input type="text" id="tempat_multi_senter" placeholder="Tempat Multi Senter" class="form-control" data-bind="value: tempat_multi_senter" />
		</div>
	</div>

	<div class="space-4"></div>
	
	<h4 class="header smaller lighter blue" data-bind="visible: is_multi_senter()">
		Jika multi-senter apakah sudah mendapatkan persetujuan etik dari senter/institusi yang lain?
		<label class="inline">
			<input id="is_setuju_senter" type="checkbox" class="ace ace-switch" data-bind="checked: is_setuju_senter" />
			<span class="lbl middle" data-lbl="Ya&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tidak"></span>
		</label>
	</h4>

	<div class="space-4"></div>

	<div class="row">
		<div class="col-sm-6">
			<h4 class="header smaller lighter blue">Surat Pengantar</h4>
			<div class="row">
				<div class="col-sm-8">
					<label for="no_sp"> Nomor Surat </label>
					<input type="text" id="no_sp" placeholder="Nomor" class="form-control" data-bind="value: no_sp" />
				</div>
				<div class="col-sm-4">
					<label for="tgl_sp">Tanggal Surat</label>
					<div class="input-group">
						<input type="text" id="tgl_sp" placeholder="Tanggal" class="form-control date-picker" data-date-format="dd/mm/yyyy" data-bind="value: tgl_sp" />
						<span class="input-group-addon">
							<i class="fa fa-calendar bigger-110"></i>
						</span>
					</div>
				</div>
			</div>

			<div class="space-4"></div>

			<div class="row">
				<div class="col-sm-12">
					<label for="sp">File Surat Pengantar</label>
					<input type="file" name="sp" id="sp" data-bind="event: {change: function(){do_upload('sp')}}" style="opacity:0; height: 0px" />
					<div class="input-group">
						<input type="text" class="form-control" placeholder="Unggah Surat Pengantar" data-bind="value: client_name_sp" readonly="true" />
						<span class="input-group-btn">
							<button type="button" id="btn_sp" class="btn btn-default btn-sm" data-loading-text="Proses unggah..." data-bind="click: function(data, event){upload('sp') }">
								<span class="ace-icon fa fa-upload icon-on-right bigger-110"></span>
							</button>
						</span>
					</div>
          <p><small>pdf | png | jpg | jpeg</small></p>
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<h4 class="header smaller lighter blue">Bukti Bayar <small class="text-danger"><i>(*Bagi instansi yang tidak memungut biaya mahasiswanya, upload Kartu Mahasiswa)</i></small></h4>
			 
			<div class="row">
				<div class="col-sm-8">
					<label for="no_bb"> Nomor Bukti Bayar <span class="text-danger">(*Nomor Mahasiswa)</span> </label>
					<input type="text" id="no_bb" placeholder="Nomor" class="form-control" data-bind="value: no_bb" />
				</div>
				<div class="col-sm-4">
					<label for="tgl_bb">Tanggal Bukti Bayar</label>
					<div class="input-group">
						<input type="text" id="tgl_bb" placeholder="Tanggal" class="form-control date-picker" data-date-format="dd/mm/yyyy" data-bind="value: tgl_bb" />
						<span class="input-group-addon">
							<i class="fa fa-calendar bigger-110"></i>
						</span>
					</div>
				</div>
			</div>

			<div class="space-4"></div>

			<div class="row">
				<div class="col-sm-12">
					<label for="bb">File Bukti Bayar <span class="text-danger">(*Kartu Mahasiswa)</span></label>
					<input type="file" name="bb" id="bb" data-bind="event: {change: function(){do_upload('bb')}}" style="opacity:0; height: 0px" />
					<div class="input-group">
						<input type="text" class="form-control" placeholder="Unggah Surat Pengantar" data-bind="value: client_name_bb" readonly="true" />
						<span class="input-group-btn">
							<button type="button" id="btn_bb" class="btn btn-default btn-sm" data-loading-text="Proses unggah..." data-bind="click: function(data, event){upload('bb') }">
								<span class="ace-icon fa fa-upload icon-on-right bigger-110"></span>
							</button>
						</span>
					</div>
          <p><small>pdf | png | jpg | jpeg</small></p>
				</div>
			</div>		
		</div>
	</div>

	<div class="clearfix form-actions">
		<div class="col-md-offset-3 col-md-9">
			<button class="btn btn-info" id="submit" type="button" data-loading-text="Proses..." data-bind="click: function(data, event){save(false, data, event) }">
				<i class="ace-icon fa fa-floppy-o bigger-110"></i>
				Simpan
			</button>

			&nbsp; &nbsp; &nbsp;
			<button class="btn btn-warning" type="button" data-bind="click: back, enable: !processing()">
				<i class="ace-icon fa fa-list bigger-110"></i>
				Lihat Daftar
			</button>

			&nbsp; &nbsp; &nbsp;
			<button class="btn btn-success" type="button" data-bind="click: lanjut, enable: !processing()">
				<i class="ace-icon fa fa-arrow-right bigger-110"></i>
				Lanjut ke Protokol
			</button>
		</div>
	</div>

</form>

