<h4 class="header lighter smaller blue">
	<i class="ace-icon fa fa-file-o bigger-160 green"></i>
	<strong><?php echo isset($data['no_protokol']) ? $data['no_protokol'] : ''?></strong>
</h4>

<dl>
	<dt>Judul</dt>
	<dd><?php echo isset($data['judul']) ? $data['judul'] : '-' ?></dd>
	<div class="hr hr-dotted"></div>
	<dt>KEPK</dt>
	<dd><?php echo isset($data['nama_kepk']) ? $data['nama_kepk'] : '-' ?></dd>
	<div class="hr hr-dotted"></div>
	<dt>Tanggal Laporan Akhir</dt>
	<dd><?php echo isset($data['tanggal_laporan_akhir']) ? date('d/m/Y', strtotime($data['tanggal_laporan_akhir'])) : '-' ?></dd>
	<div class="hr hr-dotted"></div>
</dl>

<h4 class="header smaller lighter blue">Laporan Akhir</h4>
<div class="form-group">
	<div class="row">
		<div class="col-xs-12 col-sm-12 widget-container-col" id="widget-container-col-1">
			<div class="widget-box" id="widget-box-1">
				<div class="widget-header">
					<h5 class="widget-title"></h5>

					<div class="widget-toolbar">
						<a href="#" data-action="fullscreen" class="orange2">
							<i class="ace-icon fa fa-expand"></i>
						</a>

						<a href="#" data-action="reload">
							<i class="ace-icon fa fa-refresh"></i>
						</a>

						<a href="#" data-action="collapse">
							<i class="ace-icon fa fa-chevron-up"></i>
						</a>

					</div>
				</div>

				<div class="widget-body">
					<div class="widget-main">
						<?php echo isset($data['laporan_akhir']) ? stripslashes($data['laporan_akhir']) : ''?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<h4 class="header smaller lighter blue">Dokumen / Lampiran</h4>
<div class="form-group">
	<?php
	if (isset($dokumen))
	{
		echo '<table class="table">';
		echo '<thead><th></th><th>Nama File</th><th>Deskripsi</th></thead>';
		echo '<tbody>';
		for ($i=0; $i<count($dokumen); $i++)
		{
			echo '<tr>';
			echo '<td width="2%"><a href="'.base_url().'laporan_akhir/download/'.rawurlencode(urlencode($dokumen[$i]['file_name'])).'/'.rawurlencode(urlencode($dokumen[$i]['client_name'])).'" title="Unduh File"><i class="ace-icon fa fa-download bigger-110"></i></a></td>';
			echo '<td width="30%">'.$dokumen[$i]['client_name'].'</td>';
			echo '<td width="68%">'.$dokumen[$i]['deskripsi'].'</td>';
			echo '</tr>';
		}
		echo '</tbody>';
		echo '</table>';
	}
	?>
</div>

<div class="clearfix form-actions">
	<div class="col-md-offset-3 col-md-9">
		<button class="btn btn-warning" type="button" id="back">
			<i class="ace-icon fa fa-list bigger-110"></i>
			Lihat Daftar
		</button>
	</div>
</div>
