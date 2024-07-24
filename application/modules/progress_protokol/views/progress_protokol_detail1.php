<div class="row" id="konten">
	<div class="col-xs-12 col-sm-10 col-sm-offset-1">
		<div class="timeline-container">
		<?php 
		$revisi_ke = 0;
		foreach ($timeline as $k=>$v) {
		?>
			<div class="timeline-label">
				<span class="label label-grey arrowed-in-right label-lg">
					<b><?php echo $k ?></b>
				</span>
			</div>

			<?php for ($i=0; $i<count($v); $i++) { ?>

			<div class="timeline-items">
				<div class="timeline-item clearfix">
					<div class="timeline-info">
					<?php 
					switch ($v[$i]['aktivitas']) {
						case 'Pengajuan': 
							echo '<i class="timeline-indicator ace-icon fa fa-file-o btn btn-primary no-hover"></i>';
							break;
						case 'Protokol': 
							echo '<i class="timeline-indicator ace-icon fa fa-book btn btn-warning no-hover"></i>';
							break;
						case 'Perbaikan Protokol': 
							echo '<i class="timeline-indicator ace-icon fa fa-book btn btn-danger no-hover"></i>';
							break;
						case 'Kirim ke KEPK': 
							echo '<i class="timeline-indicator ace-icon fa fa-envelope-o btn btn-inverse no-hover"></i>';
							break;
						case 'Resume Sekretaris': 
							echo '<i class="timeline-indicator ace-icon fa fa-pencil btn btn-pink no-hover"></i>';
							break;
						case 'Telaah Awal': 
							echo '<i class="timeline-indicator ace-icon fa fa-comment-o btn btn-pink no-hover"></i>';
							break;
						case 'Putusan Awal Ketua': 
							echo '<i class="timeline-indicator ace-icon fa fa-flag btn btn-purple no-hover"></i>';
							break;
						case 'Putusan Awal Wakil Ketua': 
							echo '<i class="timeline-indicator ace-icon fa fa-flag btn btn-purple no-hover"></i>';
							break;
						case 'Telaah Expedited': 
							echo '<i class="timeline-indicator ace-icon fa fa-th-large btn btn-grey no-hover"></i>';
							break;
						case 'Telaah Full Board': 
							echo '<i class="timeline-indicator ace-icon fa fa-th btn btn-grey no-hover"></i>';
							break;
						case 'Pelaporan Expedited': 
							echo '<i class="timeline-indicator ace-icon fa fa-info-circle btn btn-yellow no-hover"></i>';
							break;
						case 'Pelaporan Full Board': 
							echo '<i class="timeline-indicator ace-icon fa fa-info-circle btn btn-yellow no-hover"></i>';
							break;
						case 'Putusan Expedited ke Full Board Ketua': 
							echo '<i class="timeline-indicator ace-icon fa fa-flag btn btn-purple no-hover"></i>';
							break;
						case 'Putusan Expedited ke Full Board Wakil Ketua': 
							echo '<i class="timeline-indicator ace-icon fa fa-flag btn btn-purple no-hover"></i>';
							break;
						case 'Keputusan': 
							if ($v[$i]['keputusan'] == 'LE')
								echo '<i class="timeline-indicator ace-icon fa fa-gavel btn btn-success no-hover"></i>';
							else
								echo '<i class="timeline-indicator ace-icon fa fa-gavel btn btn-danger no-hover"></i>';
							break;
						case 'Kirim ke Peneliti': 
							echo '<i class="timeline-indicator ace-icon fa fa-envelope-o btn btn-pink no-hover"></i>';
							break;
					}
					?>
					</div>

					<?php if ($v[$i]['aktivitas'] == 'Pengajuan') { ?>
					<div class="widget-box transparent">
						<div class="widget-header widget-header-small">
							<h5 class="widget-title smaller">
								<strong>Anda</strong>
								Mengajukan Protokol
							</h5>

							<span class="widget-toolbar no-border">
								<i class="ace-icon fa fa-clock-o bigger-110"></i>
								<?php echo $v[$i]['time']; ?>
							</span>

							<span class="widget-toolbar">
								<a href="#" data-action="collapse">
									<i class="ace-icon fa fa-chevron-up"></i>
								</a>
							</span>
						</div>

						<div class="widget-body">
							<div class="widget-main">
								<dl>
									<dt>No Protokol</dt>
									<dd><?php echo isset($pengajuan['no_protokol']) ? $pengajuan['no_protokol'] : '-' ?></dd>
									<div class="hr hr-dotted"></div>
									<dt>Judul</dt>
									<dd><?php echo isset($pengajuan['judul']) ? $pengajuan['judul'] : '-' ?></dd>
									<div class="hr hr-dotted"></div>
									<dt>KEPK</dt>
									<dd><?php echo isset($pengajuan['nama_kepk']) ? $pengajuan['nama_kepk'] : '-' ?></dd>
									<div class="hr hr-dotted"></div>
									<dt>Ketua Pelaksana / Peneliti Utama</dt>
									<dd><?php echo isset($pengajuan['nama_ketua']) ? $pengajuan['nama_ketua'] : '-' ?></dd>
									<div class="hr hr-dotted"></div>
									<dt>Nomor Telepon</dt>
									<dd><?php echo isset($pengajuan['telp_peneliti']) ? $pengajuan['telp_peneliti'] : '-' ?></dd>
									<div class="hr hr-dotted"></div>
									<dt>Email</dt>
									<dd><?php echo isset($pengajuan['email_peneliti']) ? $pengajuan['email_peneliti'] : '-' ?></dd>
									<div class="hr hr-dotted"></div>
								</dl>
							</div>
						</div>
					</div>
					<?php } else if ($v[$i]['aktivitas'] == 'Protokol') { ?>
					<div class="widget-box transparent">
						<div class="widget-body">
							<div class="widget-main">
								<span class="blue"><strong>Anda</strong></span>
								Mengisi Protokol
								<div class="pull-right">
									<i class="ace-icon fa fa-clock-o bigger-110"></i>
									<?php echo $v[$i]['time']; ?>
								</div>
							</div>
						</div>
					</div>
					<?php } else if ($v[$i]['aktivitas'] == 'Perbaikan Protokol') { ?>
					<div class="widget-box transparent">
						<div class="widget-body">
							<div class="widget-main">
								<span class="blue"><strong>Anda</strong></span>
								Memperbaiki Protokol #<?php echo $v[$i]['revisi_ke'] ?>
								<div class="pull-right">
									<i class="ace-icon fa fa-clock-o bigger-110"></i>
									<?php echo $v[$i]['time']; ?>
								</div>
							</div>
						</div>
					</div>
					<?php } else if ($v[$i]['aktivitas'] == 'Kirim ke KEPK') { ?>
					<div class="widget-box transparent">
						<div class="widget-body">
							<div class="widget-main">
								<span class="blue"><strong>Anda</strong></span>
								<?php
								if ($v[$i]['revisi_ke'] == 0)
									echo 'Mengirim Protokol ke KEPK';
								else
									echo 'Mengirim Perbaikan Protokol ke KEPK #'.$v[$i]['revisi_ke']; 
								?>
								<div class="pull-right">
									<i class="ace-icon fa fa-clock-o bigger-110"></i>
									<?php echo $v[$i]['time']; ?>
								</div>
							</div>
						</div>
					</div>
					<?php } else if ($v[$i]['aktivitas'] == 'Resume Sekretaris') { ?>
						<div class="widget-box transparent">
						<div class="widget-header widget-header-small">
							<h5 class="widget-title smaller">
								Resume Protokol oleh Sekretaris
							</h5>

							<span class="widget-toolbar no-border">
								<i class="ace-icon fa fa-clock-o bigger-110"></i>
								<?php echo $v[$i]['time']; ?>
							</span>

							<span class="widget-toolbar">
								<a href="#" data-action="collapse">
									<i class="ace-icon fa fa-chevron-up"></i>
								</a>
							</span>
						</div>

						<div class="widget-body">
							<div class="widget-main">
                <h5 class="header smaller lighter blue">
                  <div class="row">
										<span class="col-sm-12">
											Lanjut Telaah?
											<?php 
											switch($v[$i]['lanjut_telaah']){
												case 'YA': echo '<span class="badge badge-success">YA</span>'; break;
												case 'TBD': echo '<span class="badge badge-warning">TBD</span>'; break;
												case 'DITOLAK': echo '<span class="badge badge-default">DITOLAK</span>'; break;
												default: echo '';
											}
											?>
										</span>
									</div>
                </h5>
                <?php
								if ($v[$i]['lanjut_telaah'] == 'TBD'){
									echo '<strong>Alasan TBD:</strong><br/>';
									echo '<textarea class="autosize-transition form-control" disabled="disabled">'.$v[$i]['alasan_tbd'].'</textarea>';
								}
								else if ($v[$i]['lanjut_telaah'] == 'DITOLAK'){
									echo '<strong>Alasan Ditolak:</strong><br/>';
									echo '<textarea class="autosize-transition form-control" disabled="disabled">'.$v[$i]['alasan_ditolak'].'</textarea>';
								}
								?>
							</div>
						</div>
					</div>
					<?php } else if ($v[$i]['aktivitas'] == 'Telaah Awal') { ?>
					<div class="widget-box transparent">
						<div class="widget-header widget-header-small">
							<h5 class="widget-title smaller">
								Telaah Awal Protokol
							</h5>

							<span class="widget-toolbar no-border">
								<i class="ace-icon fa fa-clock-o bigger-110"></i>
								<?php echo $v[$i]['time']; ?>
							</span>

							<span class="widget-toolbar">
								<a href="#" data-action="collapse">
									<i class="ace-icon fa fa-chevron-up"></i>
								</a>
							</span>
						</div>

						<div class="widget-body">
							<div class="widget-main">
								Klasifikasi Usulan: 
								<span class="green">
								<?php
								switch($v[$i]['klasifikasi_usulan']){
									case 1: echo 'Exempted'; break;
									case 2: echo 'Expedited'; break;
									case 3: echo 'Full Board'; break;
									default: '';
								}
								?>
								</span>
							</div>
						</div>
					</div>
					<?php } else if ($v[$i]['aktivitas'] == 'Putusan Awal Ketua') { ?>
					<div class="widget-box transparent">
						<div class="widget-header widget-header-small">
							<h5 class="widget-title smaller">
								Putusan Awal
							</h5>

							<span class="widget-toolbar no-border">
								<i class="ace-icon fa fa-clock-o bigger-110"></i>
								<?php echo $v[$i]['time']; ?>
							</span>

							<span class="widget-toolbar">
								<a href="#" data-action="collapse">
									<i class="ace-icon fa fa-chevron-up"></i>
								</a>
							</span>
						</div>

						<div class="widget-body">
							<div class="widget-main">
								Putusan Klasifikasi:
								<span class="purple">
								<?php 
								switch($v[$i]['klasifikasi_putusan']){
									case 1: echo 'Exempted'; break;
									case 2: echo 'Expedited'; break;
									case 3: echo 'Full Board'; break;
									case 4: echo 'TBD'; break;
									default: echo '';

								}
								?>
								</span>
							</div>
						</div>
					</div>
					<?php } else if ($v[$i]['aktivitas'] == 'Putusan Awal Wakil Ketua') { ?>
					<div class="widget-box transparent">
						<div class="widget-header widget-header-small">
							<h5 class="widget-title smaller">
								Putusan Awal
							</h5>

							<span class="widget-toolbar no-border">
								<i class="ace-icon fa fa-clock-o bigger-110"></i>
								<?php echo $v[$i]['time']; ?>
							</span>

							<span class="widget-toolbar">
								<a href="#" data-action="collapse">
									<i class="ace-icon fa fa-chevron-up"></i>
								</a>
							</span>
						</div>

						<div class="widget-body">
							<div class="widget-main">
								Putusan Klasifikasi:
								<span class="purple">
								<?php 
								switch($v[$i]['klasifikasi_putusan']){
									case 1: echo 'Exempted'; break;
									case 2: echo 'Expedited'; break;
									case 3: echo 'Full Board'; break;
									case 4: echo 'TBD'; break;
									default: echo '';

								}
								?>
								</span>
							</div>
						</div>
					</div>
					<?php } else if ($v[$i]['aktivitas'] == 'Telaah Expedited') { ?>
					<div class="widget-box transparent">
						<div class="widget-header widget-header-small">
							<h5 class="widget-title smaller">
								Telaah Expedited
							</h5>

							<span class="widget-toolbar no-border">
								<i class="ace-icon fa fa-clock-o bigger-110"></i>
								<?php echo $v[$i]['time']; ?>
							</span>

							<span class="widget-toolbar">
								<a href="#" data-action="collapse">
									<i class="ace-icon fa fa-chevron-up"></i>
								</a>
							</span>
						</div>

						<div class="widget-body">
							<div class="widget-main">
								Kelayakan:
								<span class="purple">
								<?php
								switch($v[$i]['kelayakan']){
									case 'LE': echo 'Layak Etik'; break;
									case 'R': echo 'Perbaikan'; break;
									case 'F': echo 'Full Board'; break;
									default: '';
								} 
								?>
								</span>
							</div>
						</div>
					</div>
					<?php } else if ($v[$i]['aktivitas'] == 'Telaah Full Board') { ?>
					<div class="widget-box transparent">
						<div class="widget-header widget-header-small">
							<h5 class="widget-title smaller">
								Telaah Full Board
							</h5>

							<span class="widget-toolbar no-border">
								<i class="ace-icon fa fa-clock-o bigger-110"></i>
								<?php echo $v[$i]['time']; ?>
							</span>

							<span class="widget-toolbar">
								<a href="#" data-action="collapse">
									<i class="ace-icon fa fa-chevron-up"></i>
								</a>
							</span>
						</div>

						<div class="widget-body">
							<div class="widget-main">
								Kelayakan:
								<span class="purple">
								<?php
								switch($v[$i]['kelayakan']){
									case 'LE': echo 'Layak Etik'; break;
									case 'R': echo 'Perbaikan'; break;
									case 'F': echo 'Full Board'; break;
									default: '';
								} 
								?>
								</span>
							</div>
						</div>
					</div>
					<?php } else if ($v[$i]['aktivitas'] == 'Pelaporan Expedited') { ?>
					<div class="widget-box transparent">
						<div class="widget-header widget-header-small">
							<h5 class="widget-title smaller">
								Laporan Protokol Expedited
							</h5>

							<span class="widget-toolbar no-border">
								<i class="ace-icon fa fa-clock-o bigger-110"></i>
								<?php echo $v[$i]['time']; ?>
							</span>

							<span class="widget-toolbar">
								<a href="#" data-action="collapse">
									<i class="ace-icon fa fa-chevron-up"></i>
								</a>
							</span>
						</div>

						<div class="widget-body">
							<div class="widget-main">
								Keputusan Usulan:
								<span class="purple">
								<?php
									switch ($v[$i]['keputusan']) {
										case 'LE': echo 'Layak Etik'; break;
										case 'R': echo 'Perbaikan'; break;
										case 'F': echo 'Full Board'; break;
										default: echo ''; break;
									}; 
								?>
								</span>
							</div>
						</div>
					</div>
					<?php } else if ($v[$i]['aktivitas'] == 'Pelaporan Full Board') { ?>
					<div class="widget-box transparent">
						<div class="widget-header widget-header-small">
							<h5 class="widget-title smaller">
								Laporan Protokol Full Board
							</h5>

							<span class="widget-toolbar no-border">
								<i class="ace-icon fa fa-clock-o bigger-110"></i>
								<?php echo $v[$i]['time']; ?>
							</span>

							<span class="widget-toolbar">
								<a href="#" data-action="collapse">
									<i class="ace-icon fa fa-chevron-up"></i>
								</a>
							</span>
						</div>

						<div class="widget-body">
							<div class="widget-main">
								Keputusan Usulan:
								<span class="purple">
								<?php
									switch ($v[$i]['keputusan']) {
										case 'LE': echo 'Layak Etik'; break;
										case 'R': echo 'Perbaikan'; break;
										case 'F': echo 'Full Board'; break;
										default: echo ''; break;
									}; 
								?>
								</span>
							</div>
						</div>
					</div>
					<?php } else if ($v[$i]['aktivitas'] == 'Putusan Expedited ke Full Board Ketua') { ?>
					<div class="widget-box transparent">
						<div class="widget-header widget-header-small">
						<h5 class="widget-title smaller">
							Putusan Expedited ke Full Board
						</h5>

						<span class="widget-toolbar no-border">
							<i class="ace-icon fa fa-clock-o bigger-110"></i>
							<?php echo $v[$i]['time']; ?>
						</span>

						<span class="widget-toolbar">
							<a href="#" data-action="collapse">
							<i class="ace-icon fa fa-chevron-up"></i>
							</a>
						</span>
						</div>

						<div class="widget-body">
							<div class="widget-main">
								Putusan Klasifikasi:
								<span class="purple">Full Board</span>
							</div>
						</div>
					</div>
					<?php } else if ($v[$i]['aktivitas'] == 'Putusan Expedited ke Full Board Wakil Ketua') { ?>
					<div class="widget-box transparent">
						<div class="widget-header widget-header-small">
						<h5 class="widget-title smaller">
							Putusan Expedited ke Full Board
						</h5>

						<span class="widget-toolbar no-border">
							<i class="ace-icon fa fa-clock-o bigger-110"></i>
							<?php echo $v[$i]['time']; ?>
						</span>

						<span class="widget-toolbar">
							<a href="#" data-action="collapse">
							<i class="ace-icon fa fa-chevron-up"></i>
							</a>
						</span>
						</div>

						<div class="widget-body">
							<div class="widget-main">
								Putusan Klasifikasi:
								<span class="purple">Full Board</span>
							</div>
						</div>
					</div>
					<?php } else if ($v[$i]['aktivitas'] == 'Keputusan') { ?>
					<div class="widget-box transparent">
						<div class="widget-header widget-header-small">
							<h5 class="widget-title smaller">
								Kirim Keputusan Protokol ke Kesekretariatan 
							</h5>

							<span class="widget-toolbar no-border">
								<i class="ace-icon fa fa-clock-o bigger-110"></i>
								<?php echo $v[$i]['time']; ?>
							</span>

							<span class="widget-toolbar">
								<a href="#" data-action="collapse">
									<i class="ace-icon fa fa-chevron-up"></i>
								</a>
							</span>
						</div>

						<div class="widget-body">
							<div class="widget-main">
								Keputusan:
								<strong>
								<?php 
								switch($v[$i]['keputusan']){
									case 'LE': echo '<span class="green">Layak Etik</span>'; break;
									case 'R': echo '<span class="red">Perbaikan</span>'; break;
									case 'F': echo '<span class="red">Full Board</span>'; break;
									default: echo '';
								}
								?>
								</strong>
							</div>
						</div>
					</div>
					<?php } else if ($v[$i]['aktivitas'] == 'Kirim ke Peneliti') { ?>
					<div class="widget-box transparent">
						<div class="widget-header widget-header-small">
							<h5 class="widget-title smaller">
								Kirim Keputusan Protokol ke Peneliti 
							</h5>

							<span class="widget-toolbar no-border">
								<i class="ace-icon fa fa-clock-o bigger-110"></i>
								<?php echo $v[$i]['time']; ?>
							</span>

							<span class="widget-toolbar">
								<a href="#" data-action="collapse">
									<i class="ace-icon fa fa-chevron-up"></i>
								</a>
							</span>
						</div>

						<div class="widget-body">
							<div class="widget-main">
								Keputusan:
								<strong>
								<?php 
								switch($v[$i]['keputusan']){
									case 'LE': echo '<span class="green">Layak Etik</span>'; break;
									case 'R': echo '<span class="red">Perbaikan</span>'; break;
									case 'F': echo '<span class="red">Full Board</span>'; break;
									default: echo '';
								}
								?>
								</strong>
								<br/>
								No. Dokumen: <?php echo isset($v[$i]['no_dokumen']) ? $v[$i]['no_dokumen'] : ''; ?>
							</div>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
			<?php } // end for $v ?>
		<?php } ?>
		</div>

	</div>
</div>

<div class="clearfix form-actions">
	<div class="col-md-offset-3 col-md-9">
		<button class="btn btn-warning" type="button" id="back">
			<i class="ace-icon fa fa-list bigger-110"></i>
			Lihat Daftar
		</button>

		&nbsp; &nbsp; &nbsp;
		<button class="btn btn-default" type="button" id="printpdf">
		<i class="ace-icon fa fa-file-pdf-o bigger-110"></i>
		Cetak PDF
		</button>
	</div>
</div>
