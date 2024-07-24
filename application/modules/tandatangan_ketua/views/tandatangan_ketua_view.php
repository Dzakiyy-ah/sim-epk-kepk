<form class="form-horizontal" role="form">
	<div class="form-group">
		<div class="col-sm-12">
			<input type="file" name="kop" id="kop" data-bind="event: {change: function(){do_upload()}}" style="opacity:0; height: 0px" />
			<div class="input-group col-sm-6">
				<input type="text" class="form-control" placeholder="Unggah Tanda Tangan Ketua" data-bind="value: client_name" readonly="true" />
				<span class="input-group-btn">
					<button type="button" id="btn_kop" class="btn btn-default btn-sm" data-loading-text="Proses unggah..." data-bind="click: function(data, event){ upload() }">
						<span class="ace-icon fa fa-upload icon-on-right bigger-110"></span>
					</button>
				</span>
			</div>
			<span class="help-inline col-xs-12 col-sm-7">
				<span class="middle">jpg | jpeg | png</span>
			</span>
		</div>
	</div>

  <div class="form-group">
    <div class="col-sm-12">
      <button class="btn btn-info" id="pratinjau" type="button" data-bind="click: pratinjau">
        <i class="ace-icon fa fa-eye bigger-110"></i>
        Pratinjau Cetak
      </button>
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
