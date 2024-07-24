<form class="form-horizontal" role="form">
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="passw_lama"> Password Lama </label>

		<div class="col-sm-9">
			<input type="password" id="passw_lama" placeholder="Password Lama" class="col-xs-10 col-sm-5" data-bind="value: passw_lama" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="passw_baru1"> Password Baru </label>

		<div class="col-sm-9">
			<input type="password" id="passw_baru1" placeholder="Password Baru" class="col-xs-10 col-sm-5" data-bind="value: passw_baru1" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="passw_baru2"> Konfirmasi Password Baru </label>

		<div class="col-sm-9">
			<input type="password" id="passw_baru2" placeholder="Konfirmasi Password Baru" class="col-xs-10 col-sm-5" data-bind="value: passw_baru2" />
		</div>
	</div>

	<div class="clearfix form-actions">
		<div class="col-md-offset-3 col-md-9">
			<button class="btn btn-info" type="button" data-loading-text="Proses..." data-bind="click: function(data, event){save(false, data, event) }">
				<i class="ace-icon fa fa-check bigger-110"></i>
				Simpan
			</button>

			&nbsp; &nbsp; &nbsp;
			<button class="btn" type="reset">
				<i class="ace-icon fa fa-undo bigger-110"></i>
				Batal
			</button>
		</div>
	</div>	
</form>
