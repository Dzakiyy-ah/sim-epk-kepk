<div class="page-header">
	<h1>
		<?php echo isset($page_header) ? $page_header : 'Dashboard' ?>
		<?php if (isset($subheader)) { ?>
		<small>
			<i class="ace-icon fa fa-angle-double-right"></i>
			<?php echo $subheader ?>
		</small>
		<?php } ?>
	</h1>
</div><!-- /.page-header -->

<?php if (isset($isset_kepk) && $isset_kepk == 1) { ?>
<div class="alert alert-block alert-info" data-bind="visible: !registered()">
  <button type="button" class="close" data-dismiss="alert">
    <i class="ace-icon fa fa-times"></i>
  </button>
  <i class="ace-icon fa fa-info-circle blue"></i>
  Masukkan nomor anggota untuk memulai pendaftaran peneliti.
</div>

<form class="form-horizontal" role="form" id="frm" data-bind="visible: !registered()">
  <div class="form-group">
    <label class="col-sm-3 control-label no-padding-right" for="no_anggota"> Nomor Anggota </label>
    <div class="col-sm-9">
      <div class="input-group">
        <input type="text" class="form-control search-query" placeholder="Nomor Anggota" data-bind="value: no_anggota" />
        <span class="input-group-btn">
          <button type="button" class="btn btn-purple btn-sm" id="search_peneliti" data-loading-text="Menampilkan..." data-bind="click: tampilkan_data_peneliti">
            <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
            Cari
          </button>
        </span>
      </div>
    </div>
  </div>

	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="nama"> Nama </label>
		<div class="col-sm-9">
			<input type="text" id="nama" placeholder="Nama" class="form-control" data-bind="value: nama" disabled="disabled" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="nik"> NIK </label>
		<div class="col-sm-9">
			<input type="text" id="nik" placeholder="NIK" class="form-control" data-bind="value: nik" disabled="disabled" />
		</div>
	</div>
  <div class="form-group">
    <label class="col-sm-3 control-label no-padding-right" for="ttl"> Tempat, Tanggal Lahir </label>
    <div class="col-sm-6">
      <input type="text" id="tempat_lahir" placeholder="Tempat Lahir" class="form-control" data-bind="value: tempat_lahir" disabled="disabled" />
    </div>
    <div class="col-sm-3">
      <input type="text" id="tgl_lahir" placeholder="Tanggal Lahir" class="form-control" data-bind="value: tgl_lahir" disabled="disabled" />
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-3 control-label no-padding-right" for="kewarganegaraan"> Kewarganegaraan </label>
    <div class="col-sm-9">
      <div class="radio">
        <label>
          <input name="kewarganegaraan" type="radio" class="ace" value="WNI" data-bind="checked: kewarganegaraan, enable: kewarganegaraan() == 'WNI'" />
          <span class="lbl"> WNI</span>
        </label>
        <label>
          <input name="kewarganegaraan" type="radio" class="ace" value="WNA" data-bind="checked: kewarganegaraan, enable: kewarganegaraan() == 'WNA'" />
          <span class="lbl"> WNA</span>
        </label>
      </div>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-3 control-label no-padding-right" for="negara"> Negara </label>
    <div class="col-sm-9">
      <select class="form-control" id="negara" data-placeholder="Negara" data-bind="value: negara" disabled="disabled">
        <option value=""></option>
        <?php
        for ($a=0; $a<count($opt_country); $a++)
        {
          echo '<option value="'.$opt_country[$a]['id'].'">'.$opt_country[$a]['name'].'</option>';
        }
        ?>
      </select>
    </div>
  </div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="alamat"> Alamat </label>
		<div class="col-sm-9">
			<textarea id="alamat" class="autosize-transition form-control" data-bind="value: alamat" disabled="disabled"></textarea>
		</div>
	</div>
  <div class="form-group">
    <label class="col-sm-3 control-label no-padding-right" for="jalan"> Jalan </label>
    <div class="col-sm-9">
      <input type="text" id="jalan" placeholder="Jalan" class="form-control" data-bind="value: jalan" disabled="disabled" />
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-3 control-label no-padding-right" for="no_rumah"> Nomor </label>
    <div class="col-sm-9">
      <input type="text" id="no_rumah" placeholder="Nomor" class="form-control" data-bind="value: no_rumah" disabled="disabled" />
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-3 control-label no-padding-right" for="rt_rw"> RT / RW </label>
    <div class="col-sm-1">
      <input type="text" id="rt" placeholder="RT" class="form-control" data-bind="value: rt" disabled="disabled" />
    </div>
    <div class="col-sm-1">
      <input type="text" id="rw" placeholder="RW" class="form-control" data-bind="value: rw" disabled="disabled" />
    </div>
  </div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="propinsi"> Propinsi </label>
		<div class="col-sm-9">
			<select class="form-control" id="propinsi" data-placeholder="Propinsi" data-bind="value: propinsi" disabled="disabled">
				<option value=""></option>
				<?php
				for ($a=0; $a<count($opt_wilayah); $a++)
				{
					if (strlen($opt_wilayah[$a]['kode']) == 2)
					{
						echo '<option value="'.$opt_wilayah[$a]['kode'].'">'.$opt_wilayah[$a]['nama'].'</option>';
					}
				}
				?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="kabupaten"> Kabupaten/Kotamadya </label>
		<div class="col-sm-9">
			<select class="form-control" id="kabupaten" data-placeholder="Kabupaten/Kotamadya" data-bind="value: kabupaten" disabled="disabled">
				<option value=""></option>
				<?php
				for ($a=0; $a<count($opt_wilayah); $a++)
				{
					if (strlen($opt_wilayah[$a]['kode']) > 3 && strlen($opt_wilayah[$a]['kode']) < 6)
					{
						echo '<option value="'.$opt_wilayah[$a]['kode'].'">'.$opt_wilayah[$a]['nama'].'</option>';
					}
				}
				?>
			</select>
		</div>
	</div>
  <div class="form-group">
    <label class="col-sm-3 control-label no-padding-right" for="kecamatan"> Kecamatan </label>
    <div class="col-sm-9">
      <select class="form-control" id="kecamatan" data-placeholder="Kecamatan" data-bind="value: kecamatan" disabled="disabled">
        <option value=""></option>
        <?php
        for ($a=0; $a<count($opt_wilayah); $a++)
        {
          if (strlen($opt_wilayah[$a]['kode']) == 8)
          {
            echo '<option value="'.$opt_wilayah[$a]['kode'].'">'.$opt_wilayah[$a]['nama'].'</option>';
          }
        }
        ?>
      </select>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-3 control-label no-padding-right" for="kode_pos"> Kode Pos </label>
    <div class="col-sm-9">
      <input type="text" id="kode_pos" placeholder="Kode Pos" class="col-xs-10 col-sm-5" data-bind="value: kode_pos" disabled="disabled" />
    </div>
  </div>

  <div class="form-group">
    <label class="col-sm-3 control-label no-padding-right" for="ln_solid"></label>
    <div class="col-sm-9">
    	<div class="hr hr-16"></div>
    </div>
  </div>

  <div class="form-group">
    <label class="col-sm-3 control-label no-padding-right" for="email"> Email </label>
    <div class="col-sm-9">
      <input type="text" id="email" placeholder="Email" class="col-xs-10 col-sm-5" data-bind="value: email" disabled="disabled" />
    </div>
  </div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="no_telp"> Nomor Telepon </label>
		<div class="col-sm-9">
			<input type="text" id="no_telp" placeholder="Nomor Telepon" class="col-xs-10 col-sm-5" data-bind="value: no_telp" disabled="disabled" />
		</div>
	</div>
  <div class="form-group">
    <label class="col-sm-3 control-label no-padding-right" for="no_hp"> Nomor Handphone </label>
    <div class="col-sm-9">
      <input type="text" id="no_hp" placeholder="Nomor HP" class="col-xs-10 col-sm-5" data-bind="value: no_hp" disabled="disabled" />
    </div>
  </div>
<!--   <div class="form-group">
    <label class="col-sm-3 control-label no-padding-right" for="dokumen"> Dokumen </label>
    <div class="col-sm-9" id="dokumen">
      <table class="table">
        <tbody data-bind="foreach: dokumen">
          <tr>
            <td width="2%"><i class="fa fa-paperclip"></i></td>
            <td width="30%"><span data-bind="text: deskripsi"></span></td>
            <td width="30%">
              <span data-bind="text: client_name"></span>&nbsp;
              <a href="#" data-bind="click: function(){ $root.showFile('uploads/'+file_name) }" title="Lihat File">
                <i class="fa fa-search"></i>
              </a>&nbsp;
              <a data-bind="attr: {'href': '<?php echo base_url() ?>reg_pengusul/download/'+rawurlencode(file_name)+'/'+rawurlencode(client_name)}" title="Unduh File">
                <i class="fa fa-download"></i>
              </a>&nbsp;
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div> -->

	<div class="clearfix form-actions">
		<div class="col-md-offset-3 col-md-9">
			<button class="btn btn-info" id="submit" type="button" data-loading-text="Proses..." data-bind="click: function(data, event){save(false, data, event) }">
				<i class="ace-icon fa fa-check bigger-110"></i>
				Simpan
			</button>

			&nbsp; &nbsp; &nbsp;
			<button class="btn" type="reset" data-bind="enable: !processing()">
				<i class="ace-icon fa fa-undo bigger-110"></i>
				Batal
			</button>
		</div>
	</div>

</form>

<div class="alert alert-block alert-success" data-bind="visible: registered()">
  <h4 class="blue">Pendaftaran Peneliti Berhasil</h4>
  <span class="bigger-125">Username dan Password sama dengan SIM-EPK KEPPKN</span>
  <br>
  <a data-bind="attr: { href: url }" class="btn btn-grey" title="Cetak" target="_blank"><i class="ace-icon fa fa-print align-top bigger-125 icon-on-right"></i> Cetak</a>
</div>

<div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Lihat File</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="show_data_modal"></div>
        <h5>Unduh file jika tidak bisa tampil</h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
<?php } else { ?>
<div class="alert alert-block alert-warning">
  <button type="button" class="close" data-dismiss="alert">
    <i class="ace-icon fa fa-times"></i>
  </button>
  <i class="ace-icon fa fa-exclamation-triangle yellow"></i>
  KEPK belum aktif
</div>
<?php } ?>