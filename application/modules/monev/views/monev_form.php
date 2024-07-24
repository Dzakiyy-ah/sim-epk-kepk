<form class="" role="form" enctype="multipart/form-data" id="frm" method="post">
	<h4 class="header smaller lighter blue"> Nomor Protokol </h4>
	<div class="row">
		<div class="form-group">
			<div class="col-sm-12">
				<select class="select2 form-control" id="id_pep" data-bind="value: id_pep, enable: id() == 0" data-placeholder="Nomor Protokol">
					<option value=""></option>
					<?php
					if (isset($data_protokol))
					{
						for ($i=0; $i<count($data_protokol); $i++)
						{
							echo '<option value="'.$data_protokol[$i]['id_pep'].'">'.$data_protokol[$i]['no_protokol'].' - '.$data_protokol[$i]['judul'].'</option>';
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
	</div>

	<div class="space-4"></div>
	<div class="hr hr-18 dotted"></div>

	<h4 class="header smaller lighter blue"> Kendala selama penelitian </h4>
	<div class="row">
		<div class="col-xs-12 col-sm-12 widget-container-col">
			<div class="wysiwyg-editor" id="kendala"></div>
		</div>
	</div>

	<div class="hr hr-18 dotted"></div>

	<h4 class="header smaller lighter blue"> Unggah / Lampirkan Dokumen </h4>
	<div class="row">
		<div class="col-sm-12">
      <input type="file" name="file" id="file" data-bind="event: {change: do_upload}" style="opacity:0; height: 0px">
      <button class="btn btn-default btn-sm" type="button" id="upload" data-bind="click: upload" data-loading-text="Proses..."> Telusuri <i class="fa fa-upload"></i></button>
      <p><small>pdf | png | jpg | jpeg</small></p>
      <div class="hr hr-8 hr-dotted"></div>
      <table class="table">
      	<tbody data-bind="foreach: dokumen">
      		<tr>
      			<td width="2%"><i class="ace-icon fa fa-paperclip bigger-110"></i></td>
      			<td width="2%">
      				<a href="#" data-bind="click: $root.removeDokumen"><i class="ace-icon fa fa-trash-o bigger-110"></i></a>
      			</td>
      			<td width="30%" data-bind="text: client_name"></td>
      			<td width="66%">
      				<input type="text" placeholder="Deskripsi/Nama File" class="col-xs-10 col-sm-12" data-bind="value: deskripsi">
      			</td>
      		</tr>
      	</tbody>
      </table>
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
		</div>
	</div>

</form>
