<form class="form-horizontal" role="form">
	<div class="form-group">
    <div class="col-sm-4">
      <label for="nama_bank">Nama Bank</label>
      <input type="text" id="nama_bank" class="form-control" data-bind="value: nama_bank" />
    </div>
    <div class="col-sm-8">
      <label for="no_rekening">No Rekening</label>
      <input type="text" id="no_rekening" class="form-control" data-bind="value: no_rekening" />
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-8">
      <label for="pemilik_rekening">Pemilik Rekening</label>
      <input type="text" id="pemilik_rekening" class="form-control" data-bind="value: pemilik_rekening" />
    </div>
    <div class="col-sm-4">
      <label for="swift_code">Swift Code</label>
      <input type="text" id="swift_code" class="form-control" data-bind="value: swift_code" />
    </div>
	</div>

	<div class="clearfix form-actions">
		<div class="col-md-offset-3 col-md-9">
			<button class="btn btn-primary" id="submit" type="button" data-loading-text="Proses..." data-bind="click: function(data, event){save(false, data, event) }">
				<i class="ace-icon fa fa-floppy-o bigger-110"></i>
				Simpan
			</button>
		</div>
	</div>

</form>
