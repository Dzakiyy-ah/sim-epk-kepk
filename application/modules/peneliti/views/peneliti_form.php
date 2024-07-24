<form class="form-horizontal" role="form">
	<h4 class="header blue bolder smaller">Identitas Peneliti</h4>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="nomor"> Nomor </label>

		<div class="col-sm-9">
			<label class="col-sm-9" style="padding-top: 6px">
				<strong><?php echo isset($data['nomor']) ? $data['nomor'] : '' ?></strong>
			</label>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="nama"> Nama </label>

		<div class="col-sm-9">
			<label class="col-sm-9" style="padding-top: 6px">
				<strong><?php echo isset($data['nama']) ? $data['nama'] : '' ?></strong>
			</label>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="nik"> NIK </label>

		<div class="col-sm-9">
			<label class="col-sm-9" style="padding-top: 6px">
				<strong><?php echo isset($data['nik']) ? $data['nik'] : '' ?></strong>
			</label>
		</div>
	</div>

	<hr class="hr hr-dotted">

	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="kewarganegaraan"> Kewarganegaraan </label>

		<div class="col-sm-9">
			<label class="col-sm-9" style="padding-top: 6px">
				<strong><?php echo isset($data['kewarganegaraan']) ? $data['kewarganegaraan'] : '' ?></strong>
			</label>
		</div>
	</div>

  <div class="form-group">
    <label class="col-sm-3 control-label no-padding-right" for="negara"> Negara </label>

    <div class="col-sm-9">
      <label class="col-sm-9" style="padding-top: 6px">
        <strong><?php echo isset($data['negara']) ? $data['negara'] : '' ?></strong>
      </label>
    </div>
  </div>

	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="kabupaten"> Kabupaten/Kota </label>
		<div class="col-sm-9">
			<label class="col-sm-9" style="padding-top: 6px">
				<strong><?php echo isset($data['nama_kabupaten']) ? $data['nama_kabupaten'] : '' ?></strong>
			</label>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="propinsi"> Propinsi </label>
		<div class="col-sm-9">
			<label class="col-sm-9" style="padding-top: 6px">
				<strong><?php echo isset($data['nama_propinsi']) ? $data['nama_propinsi'] : '' ?></strong>
			</label>
		</div>
	</div>

	<hr class="hr hr-dotted">

	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="no_telepon"> Nomor Telepon </label>

		<div class="col-sm-9">
			<label class="col-sm-9" style="padding-top: 6px">
				<strong><?php echo isset($data['no_telepon']) ? $data['no_telepon'] : '' ?></strong>
			</label>
		</div>
	</div>

  <div class="form-group">
    <label class="col-sm-3 control-label no-padding-right" for="no_hp"> Nomor Handphone </label>

    <div class="col-sm-9">
      <label class="col-sm-9" style="padding-top: 6px">
        <strong><?php echo isset($data['no_hp']) ? $data['no_hp'] : '' ?></strong>
      </label>
    </div>
  </div>

	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="email"> Email </label>

		<div class="col-sm-9">
			<label class="col-sm-9" style="padding-top: 6px">
				<strong><?php echo isset($data['email']) ? $data['email'] : '' ?></strong>
			</label>
		</div>
	</div>

	<hr class="hr hr-dotted">

	<h4 class="header blue bolder smaller">Password</h4>

	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="password"> Ganti Password </label>

		<div class="col-sm-9">
			<input type="password" id="password" placeholder="Password" class="col-xs-10 col-sm-5" data-bind="value: password, enable: aktif_password() == true" />
			<span class="help-inline col-xs-12 col-sm-7">
				<label class="middle">
					<input class="ace" type="checkbox" id="aktif_password" data-bind="checked: aktif_password" />
					<span class="lbl"> Ganti! </span>
				</label>
			</span>
		</div>
	</div>

	<div class="clearfix form-actions">
		<div class="col-md-offset-3 col-md-9">
			<button class="btn btn-primary" id="submit" type="button" data-loading-text="Proses..." data-bind="click: function(data, event){save(false, data, event) }, enable: aktif_password() == true">
				<i class="ace-icon fa fa-floppy-o bigger-110"></i>
				Simpan
			</button>

			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<button class="btn btn-warning" id="back" type="button" data-bind="click: back">
				<i class="ace-icon fa fa-list bigger-110"></i>
				Lihat Data
			</button>
		</div>
	</div>

</form>
