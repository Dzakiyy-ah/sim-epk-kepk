<form class="form-horizontal" role="form" id="frm" method="post">
  <h4 class="header smaller lighter blue">Nomor - Judul Protokol</h4>
	<div class="form-group">
    <div class="col-sm-12">
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

  <h4 class="header smaller lighter blue">Peneliti Utama</h4>
  <div class="form-group">
    <div class="col-sm-4">
      <label for="nama_ketua">Ketua Pelaksana / Peneliti Utama</label>
      <input type="text" id="nama_ketua" placeholder="Ketua Pelaksana / Peneliti Utama" class="form-control" data-bind="value: nama_ketua" readonly="true" />
    </div>
    <div class="col-sm-2">
      <label for="telp_peneliti">Nomor Telepon</label>
      <input type="text" id="telp_peneliti" placeholder="Nomor Telepon" class="form-control" data-bind="value: telp_peneliti" readonly="true" />
    </div>
    <div class="col-sm-2">
      <label for="email_peneliti">Email</label>
      <input type="text" id="email_peneliti" placeholder="Email" class="form-control" data-bind="value: email_peneliti" readonly="true" />
    </div>
  </div>

  <h4 class="header smaller lighter blue">Anggota Penelitian</h4>
  <span data-bind="visible: anggota().length == 0">-</span>
	<ul data-bind="foreach: anggota">
		<li data-bind="text: nama_anggota"></li>
	</ul>

  <h4 class="header smaller lighter blue">Asal Institusi Peneliti Utama</h4>
  <div class="form-group">
    <div class="col-sm-3">
      <label for="nama_institusi">Nama Institusi</label>
      <input type="text" id="nama_institusi" placeholder="Nama Institusi" class="form-control" data-bind="value: nama_institusi" readonly="true" />
    </div>
  </div>

  <div class="space-4"></div>

  <div class="form-group">
    <div class="col-sm-9">
      <label for="alamat_institusi">Alamat Institusi</label>
      <textarea id="alamat_institusi" placeholder="Alamat Institusi" class="autosize-transition form-control" data-bind="value: alamat_institusi" readonly="true"></textarea>
    </div>
  </div>

  <div class="form-group">
    <div class="col-sm-3">
      <label for="telp_institusi">Nomor Telepon Institusi/Fax</label>
      <input type="text" id="telp_institusi" placeholder="Nomor Telepon Institusi/Fax" class="form-control" data-bind="value: telp_institusi" readonly="true" />
    </div>

    <div class="col-sm-3">
      <label for="email_institusi">Email Institusi</label>
      <input type="text" id="email_institusi" placeholder="Email Institusi" class="form-control" data-bind="value: email_institusi" readonly="true" />
    </div>
  </div>

  <h4 class="header smaller lighter blue">Penelaah Fullboard</h4>
  <ol data-bind="foreach: penelaah">
    <li data-bind="text: nama_penelaah"></li>
  </ol>

  <h4 class="header smaller lighter blue">Lay Person</h4>
  <ol data-bind="foreach: lay_person">
    <li data-bind="text: nama_lay_person"></li>
  </ol>

  <h4 class="header smaller lighter blue">Tanggal, Jam & Waktu Fullboard</h4>
  <div class="form-group">
    <div class="col-sm-3">
      <label for="tgl_fb"> Tanggal </label>
      <div class="input-group">
        <input class="form-control date-picker" id="tgl_fb" type="text" data-date-format="dd-mm-yyyy" data-bind="value: tgl_fb" />
        <span class="input-group-addon">
          <i class="fa fa-calendar bigger-110"></i>
        </span>
      </div>
    </div>
    <div class="col-sm-3">
      <label for="jam_fb">Jam</label>
      <div class="input-group">
        <input class="form-control" id="jam_fb" type="text" data-bind="value: jam_fb" />
        <span class="input-group-addon">
          <i class="fa fa-clock-o bigger-110"></i>
        </span>
      </div>
    </div>
    <div class="col-sm-6">
      <label for="tempat_fb">Tempat</label>
      <input type="text" id="tempat_fb" placeholder="Tempat" class="form-control" data-bind="value: tempat_fb" />
    </div>
  </div>

	<div class="clearfix form-actions">
		<div class="col-md-offset-3 col-md-9">
			<button class="btn btn-primary" id="submit" type="button" data-loading-text="Proses..." data-bind="click: function(data, event){save(false, data, event) }">
				<i class="ace-icon fa fa-floppy-o bigger-110"></i>
				Simpan
			</button>

			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<button class="btn btn-warning" id="back" type="button" data-bind="click: back">
				<i class="ace-icon fa fa-list bigger-110"></i>
				Lihat Daftar
			</button>

      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <button class="btn btn-default" id="print" type="button" data-bind="click: print, enable: id() > 0">
        <i class="ace-icon fa fa-print bigger-110"></i>
        Cetak
      </button>

			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<button class="btn btn-success" id="kirim" type="button" data-bind="click: kirim, enable: id() > 0 && is_kirim() == 0">
				<i class="ace-icon fa fa-envelope bigger-110"></i>
				<span data-bind="text: lbl_btn_kirim"></span> ke Peneliti
			</button>
		</div>
	</div>

</form>
