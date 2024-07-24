<div class="alert alert-block alert-info">
  <button type="button" class="close" data-dismiss="alert">
    <i class="ace-icon fa fa-times"></i>
  </button>
  <i class="ace-icon fa fa-lightbulb-o green"></i>
  Tips: Gunakan <strong class="blue">Tombol Simpan & Tambah Data Baru</strong> jika ingin menambahkan data baru lagi tanpa kembali ke halaman Daftar
</div>

<div class="form-horizontal">
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-top"> Jenis Penelitian </label>

		<div class="col-sm-9">
      <select class="select2 form-control" id="jns_penelitian" data-bind="value: jns_penelitian, enable: id() == 0" data-placeholder="Jenis Penelitian">
        <option value=""></option>
        <option value="1">Observasional</option>
        <option value="2">Intervensi</option>
        <option value="3">Uji Klinik</option>
      </select>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right"> Asal Pengusul </label>

		<div class="col-sm-9">
      <select class="select2 form-control" id="asal_pengusul" data-bind="value: asal_pengusul, enable: id() == 0" data-placeholder="Asal Pengusul">
        <option value=""></option>
        <option value="1">Internal</option>
        <option value="2">Eksternal</option>
      </select>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right"> Jenis Lembaga Asal Pengusul </label>

		<div class="col-sm-9">
      <select class="select2 form-control" id="jns_lembaga" data-bind="value: jns_lembaga, enable: id() == 0" data-placeholder="Jenis Lembaga Asal Pengusul" >
        <option value=""></option>
        <option value="1">Pendidikan</option>
        <option value="2">Rumah Sakit</option>
        <option value="3">Litbang</option>
      </select>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right"> Status Pengusul </label>

		<div class="col-sm-9">
      <select class="select2 form-control" id="status_pengusul" data-bind="value: status_pengusul, enable: id() == 0" data-placeholder="Status Pengusul">
        <option value=""></option>
        <option value="1">Mahasiswa</option>
        <option value="2">Dosen</option>
        <option value="3">Pelaksana Pelayanan</option>
        <option value="4">Peneliti</option>
        <option value="5">Lainnya</option>
      </select>
		</div>
	</div>

  <div class="form-group">
    <label class="col-sm-3 control-label no-padding-right"> Strata Pendidikan Pengusul </label>

    <div class="col-sm-9">
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

  <div class="hr hr-16 hr-dotted"></div>

  <div class="form-group">
    <label class="col-sm-3 control-label no-padding-right"> Tarif/Biaya Telaah </label>

    <div class="col-sm-9">
      <input type="text" id="no_surat" placeholder="Tarif/Biaya Telaah" class="col-xs-5 col-sm-6" data-bind="value: tarif" style="text-align: right;" />
    </div>
  </div>

	<div class="clearfix form-actions">
		<div class="col-md-offset-3 col-md-9">
			<button class="btn btn-primary" id="submit" type="button" data-loading-text="Proses..." data-bind="click: function(data, event){save(false, data, event) }">
				<i class="ace-icon fa fa-floppy-o bigger-110"></i>
				Simpan
			</button>

      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <button class="btn btn-primary" id="submit" type="button" data-loading-text="Proses..." data-bind="click: function(data, event){save(true, data, event) }">
        <i class="ace-icon fa fa-floppy-o bigger-110"></i><i class="ace-icon fa fa-plus bigger-110"></i>
        Simpan & Tambah Data Baru
      </button>

			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<button class="btn btn-warning" id="back" type="button" data-bind="click: back">
				<i class="ace-icon fa fa-list bigger-110"></i>
				Lihat Daftar
			</button>

		</div>
	</div>

</div>
