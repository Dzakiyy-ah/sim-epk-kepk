<div class="form-horizontal">
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-top"> Nomor Protokol </label>

		<div class="col-sm-9">
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

	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right"> Klasifikasi/ Proses </label>

		<div class="col-sm-9">
			<label class="control-label" data-bind="text: klasifikasi"></label>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right"> Keputusan </label>

		<div class="col-sm-9">
			<label class="control-label" data-bind="text: keputusan"></label>
		</div>
	</div>

	<div class="hr hr-16 hr-dotted"></div>

	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right"> Nomor Surat </label>

		<div class="col-sm-9">
			<input type="text" id="no_surat" placeholder="Nomor Surat" class="col-xs-5 col-sm-6" data-bind="value: no_surat" />
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right"> Nomor Dokumen </label>

		<div class="col-sm-9">
			<input type="text" id="no_dokumen" placeholder="Nomor Dokumen" class="col-xs-5 col-sm-6" data-bind="value: no_dokumen" disabled="disabled" />
			<span class="help-inline col-xs-12 col-sm-7" data-bind="visible: id() == 0">
				<span class="middle">Terisi jika sudah tersimpan</span>
			</span>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right"> Tanggal Surat </label>

		<div class="col-sm-3">
			<div class="input-group">
				<input class="form-control date-picker" id="tgl_surat" type="text" data-date-format="dd-mm-yyyy" data-bind="value: tgl_surat" />
				<span class="input-group-addon">
					<i class="fa fa-calendar bigger-110"></i>
				</span>
			</div>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right"> Masa Berlaku </label>

		<div class="col-sm-3">
			<div class="input-daterange input-group" data-date-format="dd-mm-yyyy" >
				<input type="text" class="input-sm form-control" name="start" data-bind="value: awal_berlaku" />
				<span class="input-group-addon">
					<i class="fa fa-exchange"></i>
				</span>

				<input type="text" class="input-sm form-control" name="end" data-bind="value: akhir_berlaku" />
			</div>
		</div>
	</div>

	<div class="hr hr-16 hr-dotted"></div>

  <h3 class="header smaller lighter blue">
  	<span data-bind="text: klasifikasi() == 'Tidak Bisa Ditelaah' ? 'Alasan TBD' : 'Catatan Penelaah'"></span>&nbsp;<span class="badge badge-info" data-bind="text: klasifikasi() == 'Tidak Bisa Ditelaah' ? '' : catatan_telaah().length"></span>
    <div class="pull-right">
      <a href="#" data-bind="click: print_telaah_alasan">
        <i class="ace-icon fa fa-print bigger-110"></i>
      </a>
    </div>
  </h3>
  <div class="row" data-bind="foreach: catatan_telaah, visible: klasifikasi() != 'Tidak Bisa Ditelaah'">
    <div class="col-xs-12 col-sm-12 widget-container-col">
      <div class="widget-box">
        <div class="widget-header">
          <h6 class="widget-title bigger lighter">
            <i class="ace-icon fa fa-flag bigger-120"></i>
            Catatan Penelaah #<span data-bind="text: $index()+1"></span>
          </h6>

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
            <h5 class="header smaller lighter blue">Catatan Protokol</h5>
            <p data-bind="html: catatan_protokol.length > 0 ? catatan_protokol : '<i>null</i>'"></p>
            <h5 class="header smaller lighter blue">Catatan 7 Standar</h5>
            <p data-bind="html: catatan_7standar.length > 0 ? catatan_7standar : '<i>null</i>'"></p>
          </div>
        </div>
      </div>
    </div>

    <div class="hr hr-dotted"></div>
  </div>

  <div row="" data-bind="visible: klasifikasi() == 'Tidak Bisa Ditelaah'">
  	<textarea class="form-control" data-bind="value: alasan_tbd" disabled="disabled"></textarea>
  </div>

	<div class="clearfix form-actions">
		<div class="col-md-offset-3 col-md-9">
			<button class="btn btn-primary" id="submit" type="button" data-loading-text="Proses..." data-bind="click: function(data, event){save(false, data, event) }, enable: id() == 0 && is_kirim() == 0">
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

</div>
