<form class="" role="form" id="frm" method="post">
  <h4 class="header smaller lighter blue">Protokol</h4>
  <div class="row">
	 <div class="form-group">
      <div class="col-sm-12">
  			<select class="select2 form-control" id="id_pengajuan" data-bind="value: id_pengajuan, enable: id() == 0" data-placeholder="Nomor Protokol">
  				<option value=""></option>
  				<?php
  				if (isset($protokol))
  				{
  					for ($i=0; $i<count($protokol); $i++)
  					{
  						echo '<option value="'.$protokol[$i]['id_pengajuan'].'">'.$protokol[$i]['no_protokol'].' - '.$protokol[$i]['judul'].'</option>';
  					}

  					if (isset($data['id_pengajuan']) && $data['id_pengajuan'] > 0)
  					{
  						echo '<option value="'.$data['id_pengajuan'].'">'.$data['no_protokol'].' - '.$data['judul'].'</option>';
  					}
  				}
  				?>
  			</select>
      </div>
    </div>
	</div>

  <div class="hr hr-16 hr-dotted"></div>

  <div class="row">
    <div class="form-group">
      <div class="col-sm-12">
        <dl>
          <dt>Judul</dt>
          <dd data-bind="text: judul"></dd>
          <div class="hr hr-dotted"></div>
          <dt>Nama Ketua</dt>
          <dd data-bind="text: nama_ketua"></dd>
          <div class="hr hr-dotted"></div>
          <dt>Lokasi Penelitian</dt>
          <dd data-bind="text: lokasi"></dd>
          <div class="hr hr-dotted"></div>
          <dt>Apakah penelitian ini multi-senter?</dt>
          <dd data-bind="text: is_multi_senter"></dd>
          <div class="hr hr-dotted"></div>
          <dt>Jika multi-senter apakah sudah mendapatkan persetujuan etik dari senter/institusi yang lain?</dt>
          <dd data-bind="text: is_setuju_senter"></dd>
          <div class="hr hr-dotted"></div>
        </dl>
      </div>
    </div>
  </div>

  <h4 class="header smaller lighter blue">Protokol</h4>
  <ul class="spaced2" data-bind="foreach: protokol">
    <li>
      <h5 class="smaller lighter"><a href="#" data-bind="click: function(data, event){ $root.print_protokol(id, data, event) }">Protokol <span data-bind="text: revisi == 0 ? 'Awal' : 'Perbaikan #'+$data.revisi"></span> <i class="ace-icon fa fa-print"></i></a></h5>
      <p><a data-bind="attr: {href: link_proposal}, visible: link_proposal != ''" target="_blank"><i class="ace-icon fa fa-external-link"></i> <span data-bind="text: link_proposal"></span></a></p>
      Lampiran CV Peneliti Utama
      <ul class="list-unstyled" data-bind="foreach: lampiran_ic">
        <li data-bind="if: lampiran == 1">
          <i class="fa fa-paperclip"></i> 
          <a data-bind="attr: {'href': '<?php echo base_url()?>dokumen_pengarsipan/download_lampiran_ic/'+$data.file_name+'/'+$data.client_name}"><span data-bind="text: client_name"></span> <i class="fa fa-download"></i></a>
        </li>
      </ul>
      <br/>
      Lampiran CV Anggota Peneliti
      <ul class="list-unstyled" data-bind="foreach: lampiran_ic">
        <li data-bind="if: lampiran == 2">
          <i class="fa fa-paperclip"></i> 
          <a data-bind="attr: {'href': '<?php echo base_url()?>dokumen_pengarsipan/download_lampiran_ic/'+$data.file_name+'/'+$data.client_name}"><span data-bind="text: client_name"></span> <i class="fa fa-download"></i></a>
        </li>
      </ul>
      <br/>
      Lampiran Daftar Lembaga Sponsor
      <ul class="list-unstyled" data-bind="foreach: lampiran_ic">
        <li data-bind="if: lampiran == 3">
          <i class="fa fa-paperclip"></i> 
          <a data-bind="attr: {'href': '<?php echo base_url()?>dokumen_pengarsipan/download_lampiran_ic/'+$data.file_name+'/'+$data.client_name}"><span data-bind="text: client_name"></span> <i class="fa fa-download"></i></a>
        </li>
      </ul>
      <br/>
      Lampiran Surat-surat pernyataan
      <ul class="list-unstyled" data-bind="foreach: lampiran_ic">
        <li data-bind="if: lampiran == 4">
          <i class="fa fa-paperclip"></i> 
          <a data-bind="attr: {'href': '<?php echo base_url()?>dokumen_pengarsipan/download_lampiran_ic/'+$data.file_name+'/'+$data.client_name}"><span data-bind="text: client_name"></span> <i class="fa fa-download"></i></a>
        </li>
      </ul>
      <br/>
      Lampiran Instrumen/Kuesioner, dll
      <ul class="list-unstyled" data-bind="foreach: lampiran_ic">
        <li data-bind="if: lampiran == 5">
          <i class="fa fa-paperclip"></i> 
          <a data-bind="attr: {'href': '<?php echo base_url()?>dokumen_pengarsipan/download_lampiran_ic/'+$data.file_name+'/'+$data.client_name}"><span data-bind="text: client_name"></span> <i class="fa fa-download"></i></a>
        </li>
      </ul>
      <br/>
      Lampiran Informed Consent 35 butir
      <ul class="list-unstyled" data-bind="foreach: lampiran_ic">
        <li data-bind="if: lampiran == 6">
          <i class="fa fa-paperclip"></i> 
          <a data-bind="attr: {'href': '<?php echo base_url()?>dokumen_pengarsipan/download_lampiran_ic/'+$data.file_name+'/'+$data.client_name}"><span data-bind="text: client_name"></span> <i class="fa fa-download"></i></a>
        </li>
      </ul>
      <hr>
    </li>
  </ul>

  <h4 class="header smaller lighter blue">Surat Pembebasan, Persetujuan, dan Perbaikan</h4>
  <ul class="list-unstyled spaced2" data-bind="foreach: surat_surat">
    <li><i class="ace-icon fa fa-angle-right bigger-110"></i> <a href="#" data-bind="click: function(data, event){ $root.print_surat(id, jenis_surat, klasifikasi, data, event) }"> <span data-bind="text: nama_surat"></span> & <span data-bind="text: lampiran"></span> <i class="ace-icon fa fa-print"></i></a></li>
  </ul>

  <h4 class="header smaller lighter blue">Progress Protokol <a href="#" id="print_progress_protokol"><i class="ace-icon fa fa-print bigger-110"></i></a></h4>
  <iframe data-bind="attr: {src: ifr_progress_protokol}" width="100%" height="300" id="ifr_progress_protokol"></iframe>

  <div class="hr hr-16 hr-dotted"></div>

  <h4 class="header smaller lighter blue">Unggah Dokumen & Arsip</h4>
  <div class="row">
  	<div class="form-group">
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
                <a href="#" data-bind="click: function() { $root.showFile(file_name)} "><i class="ace-icon fa fa-search bigger-110"></i></a>
              </td>
              <td width="2%">
                <a href="#" data-bind="click: function() { $root.downloadFile(file_name, client_name)} "><i class="ace-icon fa fa-download bigger-110"></i></a>
              </td>
        			<td width="2%">
        				<a href="#" data-bind="click: $root.removeDokumen"><i class="ace-icon fa fa-trash-o bigger-110"></i></a>
        			</td>
        			<td width="30%" data-bind="text: client_name"></td>
        			<td width="62%">
        				<input type="text" placeholder="Deskripsi/Nama File" class="col-xs-10 col-sm-12" data-bind="value: deskripsi">
        			</td>
        		</tr>
        	</tbody>
        </table>
  		</div>
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
		</div>
	</div>

</form>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Tutup</span></button>
        <h4 class="modal-title">Lihat File</h4>
      </div>
      <div class="modal-body" id="myModalbody">
        <div id="show_data_modal"></div>
        <h5>Unduh file jika tidak bisa tampil</h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="ace-icon fa fa-icon fa-close"></i> Tutup</button>
      </div>
    </div>
  </div>
</div>
<!-- end modal -->