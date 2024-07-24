<div class="alert alert-info">
  <button type="button" class="close" data-dismiss="alert">
    <i class="ace-icon fa fa-times"></i>
  </button>
  Pilih <strong>Tanggal Pengajuan</strong>

   sebelum mengirim data protokol ke KEPPKN. Hanya Protokol Layak Etik yang akan dikirim.
  <br />
</div>

<form class="form-horizontal" role="form" id="frm">
  <label>Tanggal Pengajuan</label>
  <div class="row">
    <div class="col-xs-8 col-sm-4">
      <div class="input-daterange input-group" data-date-format="dd/mm/yyyy">
        <input type="text" class="input-sm form-control" name="tgl_awal" placeholder="Dari" data-bind="value: tgl_awal" />
        <span class="input-group-addon">
          <i class="fa fa-exchange"></i>
        </span>

        <input type="text" class="input-sm form-control" name="tgl_akhir" placeholder="Sampai" data-bind="value: tgl_akhir" />
      </div>
    </div>
  </div>
</form>

<div class="space-4"></div>

<div class="alert alert-success" data-bind="visible: notif_alert">
  <h4>Jumlah Pengajuan yang dikirim: <span data-bind="text: jml_pengajuan"></span></h4>
  <ul class="list-unstyled spaced" data-bind="foreach: notif">
    <li data-bind="attr:{'class': status == 'success' ? '' : 'text-danger'}">
      <i data-bind="attr:{'class': status == 'success' ? 'ace-icon fa fa-check bigger-110 green' : 'ace-icon fa fa-times bigger-110 red'}"></i>
      <span data-bind="text: message"></span>
    </li>
  </ul>
</div>

<div class="space-4"></div>

<div class="clearfix form-actions">
	<div class="col-md-offset-3 col-md-9">
		<button class="btn btn-info" id="submit" type="button" data-loading-text="Proses..." data-bind="click: function(data, event){kirim(false, data, event) }">
			<i class="ace-icon fa fa-floppy-o bigger-110"></i>
			Kirim
		</button>
	</div>
</div>

<div class="space-12"></div>

<table id="grid-table"></table>

<div id="grid-pager"></div>