<div class="widget-box transparent" id="recent-box">
	<div class="widget-header">
		<h4 class="widget-title lighter smaller">
			<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
			<i class="ace-icon fa fa-file-o bigger-160 orange"></i>
			<?php } else { ?>
			<i class="ace-icon fa fa-file-o bigger-160 green"></i>
			<?php } ?>
			<strong><?php echo isset($pengajuan['no_protokol']) ? $pengajuan['no_protokol'] : ''?></strong>
		</h4>
		<span class="label label-lg label-yellow arrowed-in arrowed-in-right">Expedited</span>

		<div class="widget-toolbar no-border">
			<ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="recent-tab">
				<li class="active">
					<a data-toggle="tab" href="#protokol-tab">Protokol Pengusul</a>
				</li>

				<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
				<li>
					<a data-toggle="tab" href="#ringkasan-tab">Ringkasan Putusan</a>
				</li>
				<?php } else { ?>
				<li>
					<a data-toggle="tab" href="#resume-tab">Resume Sekretaris</a>
				</li>
				<?php } ?>

				<li>
					<a data-toggle="tab" href="#self_assesment-tab">7 Standar</a>
				</li>

				<li>
					<a data-toggle="tab" href="#kelayakan-tab">Kelayakan</a>
				</li>
			</ul>
		</div>
	</div>

	<div class="widget-body">
		<div class="widget-main padding-4">
			<div class="tab-content padding-8">
				<div id="protokol-tab" class="tab-pane active">
					<div class="row">
						<div class="col-sm-6">
							<h3 class="header smaller lighter blue">
								<div class="row">
									<span class="col-sm-8">Surat Pengantar Protokol</span>
								</div>
							</h3>
							<div class="profile-user-info profile-user-info-striped">
								<div class="profile-info-row">
									<div class="profile-info-name"> Nomor </div>
									<div class="profile-info-value">
										<span><?php echo isset($sp['nomor']) ? $sp['nomor'] : '-'?></span>
									</div>
								</div>
								<div class="profile-info-row">
									<div class="profile-info-name"> Tanggal </div>
									<div class="profile-info-value">
										<span><?php echo isset($sp['tanggal']) ? date('d/m/Y', strtotime($sp['tanggal'])) : '-'?></span>
									</div>
								</div>
								<div class="profile-info-row">
									<div class="profile-info-name"> File </div>
									<div class="profile-info-value">
                    <?php echo isset($sp['client_name']) ? $sp['client_name'] : '-'?>&nbsp;
                    <a href="#" data-bind="click: function(){ showFile('uploads/<?php echo isset($sp['file_name']) ? $sp['file_name'] : 0;?>') }" title="Lihat File">
                      <i class="ace-icon fa fa-search bigger-110"></i>
                    </a>&nbsp;
										<a href="<?php echo base_url()?>telaah_expedited/download/<?php echo isset($sp['file_name']) ? rawurlencode(urlencode($sp['file_name'])) : 0;?>/<?php echo isset($sp['client_name']) ? rawurlencode(urlencode($sp['client_name'])) : 0;?>">
											<i class="fa fa-download"></i>
										</a>
									</div>
								</div>
							</div>
						</div>

						<div class="col-sm-6">
							<h3 class="header smaller lighter blue">
								<div class="row">
									<span class="col-sm-8">Bukti Bayar</span>
								</div>
							</h3>
							<div class="profile-user-info profile-user-info-striped">
								<div class="profile-info-row">
									<div class="profile-info-name"> Nomor </div>
									<div class="profile-info-value">
										<span><?php echo isset($bb['nomor']) ? $bb['nomor'] : '-'?></span>
									</div>
								</div>
								<div class="profile-info-row">
									<div class="profile-info-name"> Tanggal </div>
									<div class="profile-info-value">
										<span><?php echo isset($bb['tanggal']) ? date('d/m/Y', strtotime($bb['tanggal'])) : '-'?></span>
									</div>
								</div>
								<div class="profile-info-row">
									<div class="profile-info-name"> File </div>
									<div class="profile-info-value">
                    <?php echo isset($bb['client_name']) ? $bb['client_name'] : '-'?>&nbsp;
                    <a href="#" data-bind="click: function(){ showFile('uploads/<?php echo isset($bb['file_name']) ? $bb['file_name'] : 0;?>') }" title="Lihat File">
                      <i class="ace-icon fa fa-search bigger-110"></i>
                    </a>&nbsp;
										<a href="<?php echo base_url()?>telaah_expedited/download/<?php echo isset($bb['file_name']) ? rawurlencode(urlencode($bb['file_name'])) : 0;?>/<?php echo isset($bb['client_name']) ? rawurlencode(urlencode($bb['client_name'])) : 0;?>">
											<i class="fa fa-download"></i>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>

					<h3 class="header smaller lighter blue">
						<div class="row">
							<span class="col-sm-10">Protokol Etik Penelitian Kesehatan Yang Mengikutsertakan Manusia Sebagai Subyek</span>
							<span class="col-sm-2">
								<a href="#" data-bind="click: print_protokol" class="pull-right">
									<i class="ace-icon fa fa-print bigger-110"></i>
								</a>
							</span>
						</div>
					</h3>

					<div class="row">
						<div class="col-sm-12">
							<div class="tabbable">
								<ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
									<li class="active"><a data-toggle="tab" href="#a">A</a></li>
									<li><a data-toggle="tab" href="#b">B</a></li>
									<li><a data-toggle="tab" href="#c">C</a></li>
									<li><a data-toggle="tab" href="#d">D</a></li>
									<li><a data-toggle="tab" href="#e">E</a></li>
									<li><a data-toggle="tab" href="#f">F</a></li>
									<li><a data-toggle="tab" href="#g">G</a></li>
									<li><a data-toggle="tab" href="#h">H</a></li>
									<li><a data-toggle="tab" href="#i">I</a></li>
									<li><a data-toggle="tab" href="#j">J</a></li>
									<li><a data-toggle="tab" href="#k">K</a></li>
									<li><a data-toggle="tab" href="#l">L</a></li>
									<li><a data-toggle="tab" href="#m">M</a></li>
									<li><a data-toggle="tab" href="#n">N</a></li>
									<li><a data-toggle="tab" href="#o">O</a></li>
									<li><a data-toggle="tab" href="#p">P</a></li>
									<li><a data-toggle="tab" href="#q">Q</a></li>
									<li><a data-toggle="tab" href="#r">R</a></li>
									<li><a data-toggle="tab" href="#s">S</a></li>
									<li><a data-toggle="tab" href="#t">T</a></li>
									<li><a data-toggle="tab" href="#u">U</a></li>
									<li><a data-toggle="tab" href="#v">V</a></li>
									<li><a data-toggle="tab" href="#w">W</a></li>
									<li><a data-toggle="tab" href="#x">X</a></li>
									<li><a data-toggle="tab" href="#y">Y</a></li>
									<li><a data-toggle="tab" href="#z">Z</a></li>
									<li><a data-toggle="tab" href="#aa">AA</a></li>
									<li><a data-toggle="tab" href="#bb">BB</a></li>
									<li><a data-toggle="tab" href="#cc">CC</a></li>
									<li><a data-toggle="tab" href="#link">Link Google Drive Proposal</a></li>
								</ul>

								<div class="tab-content">
									<div id="a" class="tab-pane in active">
										<h4 class="header smaller lighter blue">A. Judul Penelitian (p-protokol no 1)</h4>
										<div class="form-group">
											<input type="text" class="form-control" id="judul" data-bind="value: judul" readonly="readonly">
										</div>

										<div class="form-group">
											<label for="lokasi">1. Lokasi Penelitian</label>
											<input type="text" class="form-control" id="lokasi" data-bind="value: lokasi" readonly="readonly">
										</div>

										<div class="form-group">
											<label for="is_multi_senter">2. Apakah penelitian ini multi-senter</label>
											<div class="radio">
												<label>
													<input name="is_multi_senter" type="radio" class="ace" value="1" data-bind="checked: is_multi_senter, enable: is_multi_senter == 1" />
													<span class="lbl">Ya</span>
												</label>
												<label>
													<input name="is_multi_senter" type="radio" class="ace" value="0" data-bind="checked: is_multi_senter, enable: is_multi_senter == 0" />
													<span class="lbl">Tidak</span>
												</label>
											</div>
										</div>

										<div class="form-group">
											<label for="is_setuju_senter">3. Jika multi-senter apakah sudah mendapatkan persetujuan etik dari senter/institusi yang lain?</label>
											<div class="radio">
												<label>
													<input name="is_setuju_senter" type="radio" class="ace" value="1" data-bind="checked: is_setuju_senter, enable: is_multi_senter == 1 && is_setuju_senter == 1" />
													<span class="lbl">Ya</span>
												</label>
												<label>
													<input name="is_setuju_senter" type="radio" class="ace" value="0" data-bind="checked: is_setuju_senter, enable: is_multi_senter == 1 && is_setuju_senter == 0" />
													<span class="lbl">Tidak</span>
												</label>
											</div>
										</div>

                    <h4 class="header smaller lighter orange">Catatan Penelaah</h4>
                    <div class="form-group">
                      <?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
                      <button class="btn btn-xs btn-warning" data-bind="click: function(data, event){ telaah_before('Catatan Protokol', 'A. Judul Penelitian (p-protokol no 1)', 'catatana') }">
                        <i class="ace-icon fa fa-square bigger-110"></i>
                        Catatan Sebelumnya
                      </button>
                      <?php } ?>
                      <div class="wysiwyg-editor" id="catatanA" data-bind="event:{input: catatan_protokol}"></div>
                    </div>
									</div>

									<div id="b" class="tab-pane">
										<h4 class="header smaller lighter blue">B. Identifikasi (p10)</h4>
										<p class="text-danger">1. Peneliti Utama (CV dilampirkan di Tab CC)</p>
										<p class="text-danger">2. Anggota Peneliti (CV dilampirkan di Tab CC)</p>
										<p class="text-danger">3. Lembaga Sponsor (Nama Lembaga dan Alamat dilampirkan di Tab CC)</p>
									</div>

									<div id="c" class="tab-pane">
										<h4 class="header smaller lighter blue">C. Ringkasan Protokol Penelitian</h4>
										<div class="form-group">
											<label for="c1">1. Ringkasan dalam 200 kata, (ditulis dalam bahasa yang mudah dipahami oleh "awam" bukan dokter/profesional kesehatan)</label>
											<div class="row">
												<div class="col-xs-12 col-sm-12 widget-container-col">
													<div class="widget-box">
														<div class="widget-header">
															<h5 class="widget-title"></h5>

															<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
															<button class="btn btn-xs btn-info" data-bind="click: function(data, event){ uraian_before('C. Ringkasan Protokol Penelitian', 'uraianc1') }">
																<i class="ace-icon fa fa-square bigger-110"></i>
																Data Sebelumnya
															</button>
															<?php } ?>
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
																<?php echo isset($pep['uraianc1']) ? stripslashes($pep['uraianc1']) : ''?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label for="c2">2. Tuliskan mengapa penelitian ini harus dilakukan, manfaatnya untuk penduduk di wilayah penelitian ini dilakukan (Negara, wilayah, lokal) - <small><i>Justifikasi Penelitian (p3) Standar 2/A (Adil)</i></small></label>
											<div class="row">
												<div class="col-xs-12 col-sm-12 widget-container-col">
													<div class="widget-box">
														<div class="widget-header">
															<h5 class="widget-title"></h5>

															<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
															<button class="btn btn-xs btn-info" data-bind="click: function(data, event){ uraian_before('C. Ringkasan Protokol Penelitian', 'uraianc2') }">
																<i class="ace-icon fa fa-square bigger-110"></i>
																Data Sebelumnya
															</button>
															<?php } ?>
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
																<?php echo isset($pep['uraianc2']) ? stripslashes($pep['uraianc2']) : ''?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

                    <h4 class="header smaller lighter orange">Catatan Penelaah</h4>
                    <div class="form-group">
                      <?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
                      <button class="btn btn-xs btn-warning" data-bind="click: function(data, event){ telaah_before('Catatan Protokol', 'C. Ringkasan Protokol Penelitian', 'catatanc') }">
                        <i class="ace-icon fa fa-square bigger-110"></i>
                        Catatan Sebelumnya
                      </button>
                      <?php } ?>
                      <div class="wysiwyg-editor" id="catatanC" data-bind="event:{input: catatan_protokol}"></div>
                    </div>
									</div>

									<div id="d" class="tab-pane">
										<h4 class="header smaller lighter blue">D. Isu Etik yang mungkin dihadapi</h4>
										<div class="form-group">
											<label for="d1">1. Pendapat peneliti tentang isyu etik yang mungkin dihadapi dalam penelitian ini, dan bagaimana cara menanganinya <small><i>(p4)</i></small>.</label>
											<div class="row">
												<div class="col-xs-12 col-sm-12 widget-container-col">
													<div class="widget-box">
														<div class="widget-header">
															<h5 class="widget-title"></h5>
															<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
															<button class="btn btn-xs btn-info" data-bind="click: function(data, event){ uraian_before('D. Isu Etik yang mungkin dihadapi', 'uraiand1') }">
																<i class="ace-icon fa fa-square bigger-110"></i>
																Data Sebelumnya
															</button>
															<?php } ?>
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
																<?php echo isset($pep['uraiand1']) ? stripslashes($pep['uraiand1']) : ''?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

                    <h4 class="header smaller lighter orange">Catatan Penelaah</h4>
                    <div class="form-group">
                      <?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
                      <button class="btn btn-xs btn-warning" data-bind="click: function(data, event){ telaah_before('Catatan Protokol', 'D. Isu Etik yang mungkin dihadapi', 'catatand') }">
                        <i class="ace-icon fa fa-square bigger-110"></i>
                        Catatan Sebelumnya
                      </button>
                      <?php } ?>
                      <div class="wysiwyg-editor" id="catatanD" data-bind="event:{input: catatan_protokol}"></div>
                    </div>
									</div>

									<div id="e" class="tab-pane">
										<h4 class="header smaller lighter blue">E. Ringkasan Kajian Pustaka</h4>
										<div class="form-group">
											<label for="e1">1. Ringkasan hasil-hasil studi sebelumnya yang sesuai topik penelitian, baik yang sudah maupun yang sudah dipublikasikan, termasuk jika ada kajian-kajian pada hewan. Maksimum 1 hal <small><i>(p5)- G 4, S</i></small> ?</label>
											<div class="row">
												<div class="col-xs-12 col-sm-12 widget-container-col">
													<div class="widget-box">
														<div class="widget-header">
															<h5 class="widget-title"></h5>

															<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
															<button class="btn btn-xs btn-info" data-bind="click: function(data, event){ uraian_before('E. Ringkasan Kajian Pustaka', 'uraiane1') }">
																<i class="ace-icon fa fa-square bigger-110"></i>
																Data Sebelumnya
															</button>
															<?php } ?>
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
																<?php echo isset($pep['uraiane1']) ? stripslashes($pep['uraiane1']) : ''?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

                    <h4 class="header smaller lighter orange">Catatan Penelaah</h4>
                    <div class="form-group">
                      <?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
                      <button class="btn btn-xs btn-warning" data-bind="click: function(data, event){ telaah_before('Catatan Protokol', 'E. Ringkasan Kajian Pustaka', 'catatane') }">
                        <i class="ace-icon fa fa-square bigger-110"></i>
                        Catatan Sebelumnya
                      </button>
                      <?php } ?>
                      <div class="wysiwyg-editor" id="catatanE" data-bind="event:{input: catatan_protokol}"></div>
                    </div>
									</div>

									<div id="f" class="tab-pane">
										<h4 class="header smaller lighter blue">F. Kondisi Lapangan</h4>
										<div class="form-group">
											<label for="f1">1. Gambaran singkat tentang lokasi penelitian<small><i>(p8)</i></small></label>
											<div class="row">
												<div class="col-xs-12 col-sm-12 widget-container-col">
													<div class="widget-box">
														<div class="widget-header">
															<h5 class="widget-title"></h5>

															<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
															<button class="btn btn-xs btn-info" data-bind="click: function(data, event){ uraian_before('F. Kondisi Lapangan', 'uraianf1') }">
																<i class="ace-icon fa fa-square bigger-110"></i>
																Data Sebelumnya
															</button>
															<?php } ?>
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
																<?php echo isset($pep['uraianf1']) ? stripslashes($pep['uraianf1']) : ''?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label for="f2">2. Informasi ketersediaan fasilitas yang tersedia di lapangan yang menunjang penelitian</label>
											<div class="row">
												<div class="col-xs-12 col-sm-12 widget-container-col">
													<div class="widget-box">
														<div class="widget-header">
															<h5 class="widget-title"></h5>

															<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
															<button class="btn btn-xs btn-info" data-bind="click: function(data, event){ uraian_before('F. Kondisi Lapangan', 'uraianf2') }">
																<i class="ace-icon fa fa-square bigger-110"></i>
																Data Sebelumnya
															</button>
															<?php } ?>
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
																<?php echo isset($pep['uraianf2']) ? stripslashes($pep['uraianf2']) : ''?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label for="f3">3. Informasi demografis / epidemiologis yang relevan tentang daerah penelitian</label>
											<div class="row">
												<div class="col-xs-12 col-sm-12 widget-container-col">
													<div class="widget-box">
														<div class="widget-header">
															<h5 class="widget-title"></h5>

															<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
															<button class="btn btn-xs btn-info" data-bind="click: function(data, event){ uraian_before('F. Kondisi Lapangan', 'uraianf3') }">
																<i class="ace-icon fa fa-square bigger-110"></i>
																Data Sebelumnya
															</button>
															<?php } ?>
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
																<?php echo isset($pep['uraianf3']) ? stripslashes($pep['uraianf3']) : ''?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

                    <h4 class="header smaller lighter orange">Catatan Penelaah</h4>
                    <div class="form-group">
                      <?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
                      <button class="btn btn-xs btn-warning" data-bind="click: function(data, event){ telaah_before('Catatan Protokol', 'F. Kondisi Lapangan', 'catatanf') }">
                        <i class="ace-icon fa fa-square bigger-110"></i>
                        Catatan Sebelumnya
                      </button>
                      <?php } ?>
                      <div class="wysiwyg-editor" id="catatanF" data-bind="event:{input: catatan_protokol}"></div>
                    </div>
									</div>

									<div id="g" class="tab-pane">
										<h4 class="header smaller lighter blue">G. Disain Penelitian</h4>
										<div class="form-group">
											<label for="g1">1. Tujuan penelitian, hipotesa, pertanyaan penelitian, asumsi dan variabel penelitian <small><i>(p11)</i></small></label>
											<div class="row">
												<div class="col-xs-12 col-sm-12 widget-container-col">
													<div class="widget-box">
														<div class="widget-header">
															<h5 class="widget-title"></h5>

															<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
															<button class="btn btn-xs btn-info" data-bind="click: function(data, event){ uraian_before('G. Disain Penelitian', 'uraiang1') }">
																<i class="ace-icon fa fa-square bigger-110"></i>
																Data Sebelumnya
															</button>
															<?php } ?>
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
																<?php echo isset($pep['uraiang1']) ? stripslashes($pep['uraiang1']) : ''?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label for="g2">2. Deskipsi detil tentang desain penelitian. <small><i>(p12)</i></small></label>
											<div class="row">
												<div class="col-xs-12 col-sm-12 widget-container-col">
													<div class="widget-box">
														<div class="widget-header">
															<h5 class="widget-title"></h5>

															<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
															<button class="btn btn-xs btn-info" data-bind="click: function(data, event){ uraian_before('G. Disain Penelitian', 'uraiang2') }">
																<i class="ace-icon fa fa-square bigger-110"></i>
																Data Sebelumnya
															</button>
															<?php } ?>
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
																<?php echo isset($pep['uraiang2']) ? stripslashes($pep['uraiang2']) : ''?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label for="g3">3. Bila ujicoba klinis, deskripsikan tentang  apakah kelompok treatmen ditentukan secara random, (termasuk bagaimana metodenya), dan apakah blinded atau terbuka. <small><i>(Bila bukan ujicoba klinis cukup tulis: tidak relevan) (p12)</i></small></label>
											<div class="row">
												<div class="col-xs-12 col-sm-12 widget-container-col">
													<div class="widget-box">
														<div class="widget-header">
															<h5 class="widget-title"></h5>

															<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
															<button class="btn btn-xs btn-info" data-bind="click: function(data, event){ uraian_before('G. Disain Penelitian', 'uraiang3') }">
																<i class="ace-icon fa fa-square bigger-110"></i>
																Data Sebelumnya
															</button>
															<?php } ?>
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
																<?php echo isset($pep['uraiang3']) ? stripslashes($pep['uraiang3']) : ''?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

                    <h4 class="header smaller lighter orange">Catatan Penelaah</h4>
                    <div class="form-group">
                      <?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
                      <button class="btn btn-xs btn-warning" data-bind="click: function(data, event){ telaah_before('Catatan Protokol', 'G. Disain Penelitian', 'catatang') }">
                        <i class="ace-icon fa fa-square bigger-110"></i>
                        Catatan Sebelumnya
                      </button>
                      <?php } ?>
                      <div class="wysiwyg-editor" id="catatanG" data-bind="event:{input: catatan_protokol}"></div>
                    </div>
									</div>

									<div id="h" class="tab-pane">
										<h4 class="header smaller lighter blue">H. Sampling</h4>
										<div class="form-group">
											<label for="h1">1. Jumlah subyek yang dibutuhkan dan bagaimana penentuannya secara statistik <small><i>(p13)</i></small></label>
											<div class="row">
												<div class="col-xs-12 col-sm-12 widget-container-col">
													<div class="widget-box">
														<div class="widget-header">
															<h5 class="widget-title"></h5>

															<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
															<button class="btn btn-xs btn-info" data-bind="click: function(data, event){ uraian_before('H. Sampling', 'uraianh1') }">
																<i class="ace-icon fa fa-square bigger-110"></i>
																Data Sebelumnya
															</button>
															<?php } ?>
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
																<?php echo isset($pep['uraianh1']) ? stripslashes($pep['uraianh1']) : ''?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label for="h2">2. Kriteria partisipan atau subyek dan justifikasi exclude/include-nya. <small><i>(Guideline 3) (p12)</i></small></label>
											<div class="row">
												<div class="col-xs-12 col-sm-12 widget-container-col">
													<div class="widget-box">
														<div class="widget-header">
															<h5 class="widget-title"></h5>

															<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
															<button class="btn btn-xs btn-info" data-bind="click: function(data, event){ uraian_before('H. Sampling', 'uraianh2') }">
																<i class="ace-icon fa fa-square bigger-110"></i>
																Data Sebelumnya
															</button>
															<?php } ?>
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
																<?php echo isset($pep['uraianh2']) ? stripslashes($pep['uraianh2']) : ''?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label for="h3">3. <strong>Sampling kelompok rentan</strong>: alasan melibatkan anak anak atau orang dewasa yang tidak mampu memberikan persetujuan setelah penjelasan, atau kelompok rentan, serta langkah langkah bagaimana meminimalisir bila terjadi resiko <small><i>(tulis “<strong>tidak relevan</strong>” bila penelitian tidak mengikutsertakan kelompok rentan)(Guidelines 15, 16 and 17)  (p15)</i></small></label>
											<div class="row">
												<div class="col-xs-12 col-sm-12 widget-container-col">
													<div class="widget-box">
														<div class="widget-header">
															<h5 class="widget-title"></h5>

															<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
															<button class="btn btn-xs btn-info" data-bind="click: function(data, event){ uraian_before('H. Sampling', 'uraianh3') }">
																<i class="ace-icon fa fa-square bigger-110"></i>
																Data Sebelumnya
															</button>
															<?php } ?>
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
																<?php echo isset($pep['uraianh3']) ? stripslashes($pep['uraianh3']) : ''?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

                    <h4 class="header smaller lighter orange">Catatan Penelaah</h4>
                    <div class="form-group">
                      <?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
                      <button class="btn btn-xs btn-warning" data-bind="click: function(data, event){ telaah_before('Catatan Protokol', 'H. Sampling', 'catatanh') }">
                        <i class="ace-icon fa fa-square bigger-110"></i>
                        Catatan Sebelumnya
                      </button>
                      <?php } ?>
                      <div class="wysiwyg-editor" id="catatanH" data-bind="event:{input: catatan_protokol}"></div>
                    </div>
									</div>

									<div id="i" class="tab-pane">
										<h4 class="header smaller lighter blue">I. Intervensi</h4>
										<div class="form-group">
											<label for="i1">1. Desripsi dan penjelasan semua intervensi (metode administrasi treatmen, termasuk rute administrasi, dosis, interval dosis, dan masa treatmen produk yang digunakan <small><i>(tulis “<strong>Tidak relevan</strong>” bila bukan penelitian intervensi) (investigasi dan komparator (p17)</i></small></label>
											<div class="row">
												<div class="col-xs-12 col-sm-12 widget-container-col">
													<div class="widget-box">
														<div class="widget-header">
															<h5 class="widget-title"></h5>

															<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
															<button class="btn btn-xs btn-info" data-bind="click: function(data, event){ uraian_before('I. Intervensi', 'uraiani1') }">
																<i class="ace-icon fa fa-square bigger-110"></i>
																Data Sebelumnya
															</button>
															<?php } ?>
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
																<?php echo isset($pep['uraiani1']) ? stripslashes($pep['uraiani1']) : ''?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label for="i2">2. Rencana dan jastifikasi untuk meneruskan atau menghentikan standar terapi/terapi baku selama penelitian <small><i>(p 4 and 5) (p18)</i></small></label>
											<div class="row">
												<div class="col-xs-12 col-sm-12 widget-container-col">
													<div class="widget-box">
														<div class="widget-header">
															<h5 class="widget-title"></h5>

															<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
															<button class="btn btn-xs btn-info" data-bind="click: function(data, event){ uraian_before('I. Intervensi', 'uraiani2') }">
																<i class="ace-icon fa fa-square bigger-110"></i>
																Data Sebelumnya
															</button>
															<?php } ?>
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
																<?php echo isset($pep['uraiani2']) ? stripslashes($pep['uraiani2']) : ''?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label for="i3">3. Treatmen/Pengobatan lain yang mungkin diberikan atau diperbolehkan, atau menjadi kontraindikasi, selama penelitian <small><i>(p 6) (p19)</i></small></label>
											<div class="row">
												<div class="col-xs-12 col-sm-12 widget-container-col">
													<div class="widget-box">
														<div class="widget-header">
															<h5 class="widget-title"></h5>

															<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
															<button class="btn btn-xs btn-info" data-bind="click: function(data, event){ uraian_before('I. Intervensi', 'uraiani3') }">
																<i class="ace-icon fa fa-square bigger-110"></i>
																Data Sebelumnya
															</button>
															<?php } ?>
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
																<?php echo isset($pep['uraiani3']) ? stripslashes($pep['uraiani3']) : ''?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label for="i4">4. Test klinis atau lab atau test lain yang harus dilakukan <small><i>(p20)</i></small></label>
											<div class="row">
												<div class="col-xs-12 col-sm-12 widget-container-col">
													<div class="widget-box">
														<div class="widget-header">
															<h5 class="widget-title"></h5>

															<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
															<button class="btn btn-xs btn-info" data-bind="click: function(data, event){ uraian_before('I. Intervensi', 'uraiani4') }">
																<i class="ace-icon fa fa-square bigger-110"></i>
																Data Sebelumnya
															</button>
															<?php } ?>
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
																<?php echo isset($pep['uraiani4']) ? stripslashes($pep['uraiani4']) : ''?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

                    <h4 class="header smaller lighter orange">Catatan Penelaah</h4>
                    <div class="form-group">
                      <?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
                      <button class="btn btn-xs btn-warning" data-bind="click: function(data, event){ telaah_before('Catatan Protokol', 'I. Intervensi', 'catatani') }">
                        <i class="ace-icon fa fa-square bigger-110"></i>
                        Catatan Sebelumnya
                      </button>
                      <?php } ?>
                      <div class="wysiwyg-editor" id="catatanI" data-bind="event:{input: catatan_protokol}"></div>
                    </div>
									</div>

									<div id="j" class="tab-pane">
										<h4 class="header smaller lighter blue">J. Monitoring Penelitian</h4>
										<div class="form-group">
											<label for="j1">1. Sampel dari form laporan kasus yang sudah distandarisir, metode pencataran respon teraputik (deskripsi dan evaluasi metode dan frekuensi pengukuran), prosedur follow-up, dan, bila mungkin, ukuran yang diusulkan untuk menentukan tingkat kepatuhan subyek yang menerima treatmen <small><i>(lihat lampiran) (p17)</i></small></label>
											<div class="row">
												<div class="col-xs-12 col-sm-12 widget-container-col">
													<div class="widget-box">
														<div class="widget-header">
															<h5 class="widget-title"></h5>

															<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
															<button class="btn btn-xs btn-info" data-bind="click: function(data, event){ uraian_before('J. Monitoring Penelitian', 'uraianj1') }">
																<i class="ace-icon fa fa-square bigger-110"></i>
																Data Sebelumnya
															</button>
															<?php } ?>
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
																<?php echo isset($pep['uraianj1']) ? stripslashes($pep['uraianj1']) : ''?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

                    <h4 class="header smaller lighter orange">Catatan Penelaah</h4>
                    <div class="form-group">
                      <?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
                      <button class="btn btn-xs btn-warning" data-bind="click: function(data, event){ telaah_before('Catatan Protokol', 'J. Monitoring Penelitian', 'catatanj') }">
                        <i class="ace-icon fa fa-square bigger-110"></i>
                        Catatan Sebelumnya
                      </button>
                      <?php } ?>
                      <div class="wysiwyg-editor" id="catatanJ" data-bind="event:{input: catatan_protokol}"></div>
                    </div>
									</div>

									<div id="k" class="tab-pane">
										<h4 class="header smaller lighter blue">K. Penghentian Penelitian dan Alasannya</h4>
										<div class="form-group">
											<label for="k1">1. Aturan atau kriteria kapan subyek bisa diberhentikan dari penelitian atau uji klinis, atau, dalam hal studi multi senter, kapan sebuah pusat/lembaga di non aktipkan, dan kapan penelitian bisa dihentikan <small><i>(tidak lagi dilanjutkan)  (p22)</i></small></label>
											<div class="row">
												<div class="col-xs-12 col-sm-12 widget-container-col">
													<div class="widget-box">
														<div class="widget-header">
															<h5 class="widget-title"></h5>

															<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
															<button class="btn btn-xs btn-info" data-bind="click: function(data, event){ uraian_before('K. Penghentian  Penelitian dan Alasannya', 'uraiank1') }">
																<i class="ace-icon fa fa-square bigger-110"></i>
																Data Sebelumnya
															</button>
															<?php } ?>
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
																<?php echo isset($pep['uraiank1']) ? stripslashes($pep['uraiank1']) : ''?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

                    <h4 class="header smaller lighter orange">Catatan Penelaah</h4>
                    <div class="form-group">
                      <?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
                      <button class="btn btn-xs btn-warning" data-bind="click: function(data, event){ telaah_before('Catatan Protokol', 'K. Penghentian Penelitian dan Alasannya', 'catatank') }">
                        <i class="ace-icon fa fa-square bigger-110"></i>
                        Catatan Sebelumnya
                      </button>
                      <?php } ?>
                      <div class="wysiwyg-editor" id="catatanK" data-bind="event:{input: catatan_protokol}"></div>
                    </div>
									</div>

									<div id="l" class="tab-pane">
										<h4 class="header smaller lighter blue">L. Adverse Event dan Komplikasi (Kejadian Yang Tidak Diharapkan)</h4>
										<div class="form-group">
											<label for="l1">1. Metode pencatatan dan pelaporan adverse events atau reaksi, dan syarat penanganan komplikasi <small><i>(Guideline 4 dan 23)(p23)</i></small></label>
											<div class="row">
												<div class="col-xs-12 col-sm-12 widget-container-col">
													<div class="widget-box">
														<div class="widget-header">
															<h5 class="widget-title"></h5>

															<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
															<button class="btn btn-xs btn-info" data-bind="click: function(data, event){ uraian_before('L. Adverse Event dan Komplikasi (Kejadian Yang Tidak Diharapkan)', 'uraianl1') }">
																<i class="ace-icon fa fa-square bigger-110"></i>
																Data Sebelumnya
															</button>
															<?php } ?>
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
																<?php echo isset($pep['uraianl1']) ? stripslashes($pep['uraianl1']) : ''?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label for="l2">2. Resiko-resiko yang diketahui dari adverse events, termasuk resiko yang terkait dengan masing masing rencana intervensi, dan terkait dengan obat, vaksin, atau terhadap prosudur yang akan diuji cobakan <small><i>(Guideline 4) (p24)</i></small></label>
											<div class="row">
												<div class="col-xs-12 col-sm-12 widget-container-col">
													<div class="widget-box">
														<div class="widget-header">
															<h5 class="widget-title"></h5>

															<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
															<button class="btn btn-xs btn-info" data-bind="click: function(data, event){ uraian_before('L. Adverse Event dan Komplikasi (Kejadian Yang Tidak Diharapkan)', 'uraianl2') }">
																<i class="ace-icon fa fa-square bigger-110"></i>
																Data Sebelumnya
															</button>
															<?php } ?>
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
																<?php echo isset($pep['uraianl2']) ? stripslashes($pep['uraianl2']) : ''?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

                    <h4 class="header smaller lighter orange">Catatan Penelaah</h4>
                    <div class="form-group">
                      <?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
                      <button class="btn btn-xs btn-warning" data-bind="click: function(data, event){ telaah_before('Catatan Protokol', 'L. Adverse Event dan Komplikasi (Kejadian Yang Tidak Diharapkan)', 'catatanl') }">
                        <i class="ace-icon fa fa-square bigger-110"></i>
                        Catatan Sebelumnya
                      </button>
                      <?php } ?>
                      <div class="wysiwyg-editor" id="catatanL" data-bind="event:{input: catatan_protokol}"></div>
                    </div>
									</div>

									<div id="m" class="tab-pane">
										<h4 class="header smaller lighter blue">M. Penanganan Komplikasi <small>(p27)</small></h4>
										<div class="form-group">
											<label for="m1">
												1. Rencana detil bila ada resiko lebih dari minimal/ luka fisik, membuat rencana detil<br>
												2. Adanya asuransi<br>
												3. Adanya fasilitas pengobatan / biaya pengobatan<br>
												4. Kompensasi jika terjadi disabilitas atau kematian <small><i>(Guideline 14)</i></small>
											</label>
											<div class="row">
												<div class="col-xs-12 col-sm-12 widget-container-col">
													<div class="widget-box">
														<div class="widget-header">
															<h5 class="widget-title"></h5>

															<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
															<button class="btn btn-xs btn-info" data-bind="click: function(data, event){ uraian_before('M. Penanganan Komplikasi <small>(p27)</small>', 'uraianm1') }">
																<i class="ace-icon fa fa-square bigger-110"></i>
																Data Sebelumnya
															</button>
															<?php } ?>
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
																<?php echo isset($pep['uraianm1']) ? stripslashes($pep['uraianm1']) : ''?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

                    <h4 class="header smaller lighter orange">Catatan Penelaah</h4>
                    <div class="form-group">
                      <?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
                      <button class="btn btn-xs btn-warning" data-bind="click: function(data, event){ telaah_before('Catatan Protokol', 'M. Penanganan Komplikasi <small>(p27)</small>', 'catatanm') }">
                        <i class="ace-icon fa fa-square bigger-110"></i>
                        Catatan Sebelumnya
                      </button>
                      <?php } ?>
                      <div class="wysiwyg-editor" id="catatanM" data-bind="event:{input: catatan_protokol}"></div>
                    </div>
									</div>

									<div id="n" class="tab-pane">
										<h4 class="header smaller lighter blue">N. Manfaat</h4>
										<div class="form-group">
											<label for="n1">1. Manfaat penelitian secara pribadi bagi subyek dan bagi yang lainnya <small><i>(Guideline 4) (p25)</i></small></label>
											<div class="row">
												<div class="col-xs-12 col-sm-12 widget-container-col">
													<div class="widget-box">
														<div class="widget-header">
															<h5 class="widget-title"></h5>

															<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
															<button class="btn btn-xs btn-info" data-bind="click: function(data, event){ uraian_before('N. Manfaat', 'uraiann1') }">
																<i class="ace-icon fa fa-square bigger-110"></i>
																Data Sebelumnya
															</button>
															<?php } ?>
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
																<?php echo isset($pep['uraiann1']) ? stripslashes($pep['uraiann1']) : ''?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label for="n2">2. Manfaat penelitian bagi penduduk, termasuk pengetahuan baru yang kemungkinan dihasilkan oleh penelitian <small><i>(Guidelines 1 and 4)(p26)</i></small></label>
											<div class="row">
												<div class="col-xs-12 col-sm-12 widget-container-col">
													<div class="widget-box">
														<div class="widget-header">
															<h5 class="widget-title"></h5>

															<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
															<button class="btn btn-xs btn-info" data-bind="click: function(data, event){ uraian_before('N. Manfaat', 'uraiann2') }">
																<i class="ace-icon fa fa-square bigger-110"></i>
																Data Sebelumnya
															</button>
															<?php } ?>
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
																<?php echo isset($pep['uraiann2']) ? stripslashes($pep['uraiann2']) : ''?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

                    <h4 class="header smaller lighter orange">Catatan Penelaah</h4>
                    <div class="form-group">
                      <?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
                      <button class="btn btn-xs btn-warning" data-bind="click: function(data, event){ telaah_before('Catatan Protokol', 'N. Manfaat', 'catatann') }">
                        <i class="ace-icon fa fa-square bigger-110"></i>
                        Catatan Sebelumnya
                      </button>
                      <?php } ?>
                      <div class="wysiwyg-editor" id="catatanN" data-bind="event:{input: catatan_protokol}"></div>
                    </div>
									</div>

									<div id="o" class="tab-pane">
										<h4 class="header smaller lighter blue">O. Jaminan Keberlanjutan Manfaat <small><i>(p28)</i></small></h4>
										<div class="form-group">
											<label for="o1">
												1. Kemungkinan keberlanjutan akses bila hasil intervensi menghasilkan manfaat yang signifikan, <br>
												2. Modalitas yang tersedia, <br>
												3. Pihak pihak yang akan mendapatkan keberlansungan pengobatan, organisasi yang akan membayar, <br>
												4. Berapa lama <small><i>(Guideline 6)</i></small>
											</label>
											<div class="row">
												<div class="col-xs-12 col-sm-12 widget-container-col">
													<div class="widget-box">
														<div class="widget-header">
															<h5 class="widget-title"></h5>

															<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
															<button class="btn btn-xs btn-info" data-bind="click: function(data, event){ uraian_before('O. Jaminan Keberlanjutan Manfaat <small><i>(p28)</i></small>', 'uraiano1') }">
																<i class="ace-icon fa fa-square bigger-110"></i>
																Data Sebelumnya
															</button>
															<?php } ?>
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
																<?php echo isset($pep['uraiano1']) ? stripslashes($pep['uraiano1']) : ''?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

                    <h4 class="header smaller lighter orange">Catatan Penelaah</h4>
                    <div class="form-group">
                      <?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
                      <button class="btn btn-xs btn-warning" data-bind="click: function(data, event){ telaah_before('Catatan Protokol', 'O. Jaminan Keberlanjutan Manfaat <small><i>(p28)</i></small>', 'catatano') }">
                        <i class="ace-icon fa fa-square bigger-110"></i>
                        Catatan Sebelumnya
                      </button>
                      <?php } ?>
                      <div class="wysiwyg-editor" id="catatanO" data-bind="event:{input: catatan_protokol}"></div>
                    </div>
									</div>

									<div id="p" class="tab-pane">
										<h4 class="header smaller lighter blue">P. Informed Consent <small><i>(Upload IC 35 butir di Tab CC)</i></small></h4>
										<div class="form-group">
											<label for="p1">1. Cara untuk mendapatkan informed consent dan prosudur yang direncanakan untuk mengkomunikasikan informasi penelitian(Persetujuan Setelah Penjelasan/PSP) kepada calon subyek, termasuk nama dan posisi wali bagi yang tidak bisa memberikannya. <small><i>(Guideline 9)(p30)</i></small></label>
											<div class="row">
												<div class="col-xs-12 col-sm-12 widget-container-col">
													<div class="widget-box">
														<div class="widget-header">
															<h5 class="widget-title"></h5>

															<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
															<button class="btn btn-xs btn-info" data-bind="click: function(data, event){ uraian_before('P. Informed Consent <small><i>(Upload IC 35 butir di Tab CC)</i></small>', 'uraianp1') }">
																<i class="ace-icon fa fa-square bigger-110"></i>
																Data Sebelumnya
															</button>
															<?php } ?>
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
																<?php echo isset($pep['uraianp1']) ? stripslashes($pep['uraianp1']) : ''?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label for="p2">2. Khusus Ibu Hamil: adanya perencanaan untuk memonitor kesehatan ibu dan kesehatan anak jangka pendek maupun jangka panjang <small><i>(Guideline 19)(p29)</i></small></label>
											<div class="row">
												<div class="col-xs-12 col-sm-12 widget-container-col">
													<div class="widget-box">
														<div class="widget-header">
															<h5 class="widget-title"></h5>

															<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
															<button class="btn btn-xs btn-info" data-bind="click: function(data, event){ uraian_before('P. Informed Consent <small><i>(Upload IC 35 butir di Tab CC)</i></small>', 'uraianp2') }">
																<i class="ace-icon fa fa-square bigger-110"></i>
																Data Sebelumnya
															</button>
															<?php } ?>
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
																<?php echo isset($pep['uraianp2']) ? stripslashes($pep['uraianp2']) : ''?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

                    <h4 class="header smaller lighter orange">Catatan Penelaah</h4>
                    <div class="form-group">
                      <?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
                      <button class="btn btn-xs btn-warning" data-bind="click: function(data, event){ telaah_before('Catatan Protokol', 'P. Informed Consent <small><i>(Upload IC 35 butir di Tab CC)</i></small>', 'catatanp') }">
                        <i class="ace-icon fa fa-square bigger-110"></i>
                        Catatan Sebelumnya
                      </button>
                      <?php } ?>
                      <div class="wysiwyg-editor" id="catatanP" data-bind="event:{input: catatan_protokol}"></div>
                    </div>
									</div>

									<div id="q" class="tab-pane">
										<h4 class="header smaller lighter blue">Q. Wali <small><i>(p31)</i></small></h4>
										<div class="form-group">
											<label for="q1">1. Adanya wali yang berhak bila calon subyek tidak bisa memberikan informed consent <small><i>(Guidelines 16 and 17)</i></small></label>
											<div class="row">
												<div class="col-xs-12 col-sm-12 widget-container-col">
													<div class="widget-box">
														<div class="widget-header">
															<h5 class="widget-title"></h5>

															<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
															<button class="btn btn-xs btn-info" data-bind="click: function(data, event){ uraian_before('Q. Wali <small><i>(p31)</i></small>', 'uraianq1') }">
																<i class="ace-icon fa fa-square bigger-110"></i>
																Data Sebelumnya
															</button>
															<?php } ?>
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
																<?php echo isset($pep['uraianq1']) ? stripslashes($pep['uraianq1']) : ''?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label for="q2">2. Adanya orang tua atau wali yang berhak bila anak paham tentang informed consent tapi belum cukup umur <small><i>(Guidelines 16 and 17)</i></small></label>
											<div class="row">
												<div class="col-xs-12 col-sm-12 widget-container-col">
													<div class="widget-box">
														<div class="widget-header">
															<h5 class="widget-title"></h5>

															<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
															<button class="btn btn-xs btn-info" data-bind="click: function(data, event){ uraian_before('Q. Wali <small><i>(p31)</i></small>', 'uraianq2') }">
																<i class="ace-icon fa fa-square bigger-110"></i>
																Data Sebelumnya
															</button>
															<?php } ?>
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
																<?php echo isset($pep['uraianq2']) ? stripslashes($pep['uraianq2']) : ''?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

                    <h4 class="header smaller lighter orange">Catatan Penelaah</h4>
                    <div class="form-group">
                      <?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
                      <button class="btn btn-xs btn-warning" data-bind="click: function(data, event){ telaah_before('Catatan Protokol', 'Q. Wali <small><i>(p31)</i></small>', 'catatanq') }">
                        <i class="ace-icon fa fa-square bigger-110"></i>
                        Catatan Sebelumnya
                      </button>
                      <?php } ?>
                      <div class="wysiwyg-editor" id="catatanQ" data-bind="event:{input: catatan_protokol}"></div>
                    </div>
									</div>

									<div id="r" class="tab-pane">
										<h4 class="header smaller lighter blue">R. Bujukan</h4>
										<div class="form-group">
											<label for="r1">1. Deskripsi bujukan atau insentif (bahan kontak) bagi calon subyek untuk ikut berpartisipasi, seperti uang, hadiah, layanan gratis, atau yang lainnya <small><i>(p32)</i></small></label>
											<div class="row">
												<div class="col-xs-12 col-sm-12 widget-container-col">
													<div class="widget-box">
														<div class="widget-header">
															<h5 class="widget-title"></h5>

															<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
															<button class="btn btn-xs btn-info" data-bind="click: function(data, event){ uraian_before('R. Bujukan', 'uraianr1') }">
																<i class="ace-icon fa fa-square bigger-110"></i>
																Data Sebelumnya
															</button>
															<?php } ?>
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
																<?php echo isset($pep['uraianr1']) ? stripslashes($pep['uraianr1']) : ''?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label for="r2">2. Rencana dan prosedur, dan orang yang betanggung jawab untuk menginformasikan bahaya atau keuntungan peserta, atau tentang riset lain tentang topik yang sama, yang bisa mempengaruhi keberlansungan keterlibatan subyek dalam penelitian<small><i>(Guideline 9) (p33)</i></small></label>
											<div class="row">
												<div class="col-xs-12 col-sm-12 widget-container-col">
													<div class="widget-box">
														<div class="widget-header">
															<h5 class="widget-title"></h5>

															<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
															<button class="btn btn-xs btn-info" data-bind="click: function(data, event){ uraian_before('R. Bujukan', 'uraianr2') }">
																<i class="ace-icon fa fa-square bigger-110"></i>
																Data Sebelumnya
															</button>
															<?php } ?>
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
																<?php echo isset($pep['uraianr2']) ? stripslashes($pep['uraianr2']) : ''?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label for="r3">3. Perencanaan untuk menginformasikan hasil penelitian pada subyek atau partisipan <small><i>(p34)</i></small></label>
											<div class="row">
												<div class="col-xs-12 col-sm-12 widget-container-col">
													<div class="widget-box">
														<div class="widget-header">
															<h5 class="widget-title"></h5>

															<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
															<button class="btn btn-xs btn-info" data-bind="click: function(data, event){ uraian_before('R. Bujukan', 'uraianr3') }">
																<i class="ace-icon fa fa-square bigger-110"></i>
																Data Sebelumnya
															</button>
															<?php } ?>
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
																<?php echo isset($pep['uraianr3']) ? stripslashes($pep['uraianr3']) : ''?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

                    <h4 class="header smaller lighter orange">Catatan Penelaah</h4>
                    <div class="form-group">
                      <?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
                      <button class="btn btn-xs btn-warning" data-bind="click: function(data, event){ telaah_before('Catatan Protokol', 'R. Bujukan', 'catatanr') }">
                        <i class="ace-icon fa fa-square bigger-110"></i>
                        Catatan Sebelumnya
                      </button>
                      <?php } ?>
                      <div class="wysiwyg-editor" id="catatanR" data-bind="event:{input: catatan_protokol}"></div>
                    </div>
									</div>

									<div id="s" class="tab-pane">
										<h4 class="header smaller lighter blue">S. Penjagaan Kerahasiaan</h4>
										<div class="form-group">
											<label for="s1">1. Proses rekrutmen subyek (misalnya lewat iklan), serta langkah langkah untuk menjaga privasi dan kerahasiaan selama rekrutmen <small><i>(Guideline 3) (p16)</i></small></label>
											<div class="row">
												<div class="col-xs-12 col-sm-12 widget-container-col">
													<div class="widget-box">
														<div class="widget-header">
															<h5 class="widget-title"></h5>

															<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
															<button class="btn btn-xs btn-info" data-bind="click: function(data, event){ uraian_before('S. Penjagaan Kerahasiaan', 'uraians1') }">
																<i class="ace-icon fa fa-square bigger-110"></i>
																Data Sebelumnya
															</button>
															<?php } ?>
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
																<?php echo isset($pep['uraians1']) ? stripslashes($pep['uraians1']) : ''?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label for="s2">2. Langkah langkah proteksi kerahasiaan data pribadi, dan penghormatan privasi orang, termasuk kehati-hatian untuk mencegah bocornya rahasia hasil test genetik pada keluarga kecuali atas izin dari yang bersangkutan <small><i>(Guidelines 4, 11, 12 and 24) (p 35)</i></small></label>
											<div class="row">
												<div class="col-xs-12 col-sm-12 widget-container-col">
													<div class="widget-box">
														<div class="widget-header">
															<h5 class="widget-title"></h5>

															<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
															<button class="btn btn-xs btn-info" data-bind="click: function(data, event){ uraian_before('S. Penjagaan Kerahasiaan', 'uraians2') }">
																<i class="ace-icon fa fa-square bigger-110"></i>
																Data Sebelumnya
															</button>
															<?php } ?>
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
																<?php echo isset($pep['uraians2']) ? stripslashes($pep['uraians2']) : ''?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label for="s3">3. Informasi tentang bagaimana koding; bila ada, untuk identitas subyek, di mana di simpan dan kapan, bagaimana dan oleh siapa bisa dibuka bila terjadi emergensi <small><i>(Guidelines 11 and 12) (p36)</i></small></label>
											<div class="row">
												<div class="col-xs-12 col-sm-12 widget-container-col">
													<div class="widget-box">
														<div class="widget-header">
															<h5 class="widget-title"></h5>

															<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
															<button class="btn btn-xs btn-info" data-bind="click: function(data, event){ uraian_before('S. Penjagaan Kerahasiaan', 'uraians3') }">
																<i class="ace-icon fa fa-square bigger-110"></i>
																Data Sebelumnya
															</button>
															<?php } ?>
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
																<?php echo isset($pep['uraians3']) ? stripslashes($pep['uraians3']) : ''?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label for="s4">4. Kemungkinan penggunaan lebih jauh dari data personal atau material biologis/BBT <small><i>(p37)</i></small></label>
											<div class="row">
												<div class="col-xs-12 col-sm-12 widget-container-col">
													<div class="widget-box">
														<div class="widget-header">
															<h5 class="widget-title"></h5>

															<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
															<button class="btn btn-xs btn-info" data-bind="click: function(data, event){ uraian_before('S. Penjagaan Kerahasiaan', 'uraians4') }">
																<i class="ace-icon fa fa-square bigger-110"></i>
																Data Sebelumnya
															</button>
															<?php } ?>
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
																<?php echo isset($pep['uraians4']) ? stripslashes($pep['uraians4']) : ''?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

                    <h4 class="header smaller lighter orange">Catatan Penelaah</h4>
                    <div class="form-group">
                      <?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
                      <button class="btn btn-xs btn-warning" data-bind="click: function(data, event){ telaah_before('Catatan Protokol', 'S. Penjagaan Kerahasiaan', 'catatans') }">
                        <i class="ace-icon fa fa-square bigger-110"></i>
                        Catatan Sebelumnya
                      </button>
                      <?php } ?>
                      <div class="wysiwyg-editor" id="catatanS" data-bind="event:{input: catatan_protokol}"></div>
                    </div>
									</div>

									<div id="t" class="tab-pane">
										<h4 class="header smaller lighter blue">T. Rencana Analisis</h4>
										<div class="form-group">
											<label for="t1">1. Deskripsi tentang rencana  analisa statistik, dan kreteria bila atau dalam kondisi bagaimana akan terjadi penghentian dini keseluruhan penelitian <small><i>(Guideline 4) (B,S2)</i></small></label>
											<div class="row">
												<div class="col-xs-12 col-sm-12 widget-container-col">
													<div class="widget-box">
														<div class="widget-header">
															<h5 class="widget-title"></h5>

															<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
															<button class="btn btn-xs btn-info" data-bind="click: function(data, event){ uraian_before('T. Rencana Analisis', 'uraiant1') }">
																<i class="ace-icon fa fa-square bigger-110"></i>
																Data Sebelumnya
															</button>
															<?php } ?>
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
																<?php echo isset($pep['uraiant1']) ? stripslashes($pep['uraiant1']) : ''?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

                    <h4 class="header smaller lighter orange">Catatan Penelaah</h4>
                    <div class="form-group">
                      <?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
                      <button class="btn btn-xs btn-warning" data-bind="click: function(data, event){ telaah_before('Catatan Protokol', 'T. Rencana Analisis', 'catatant') }">
                        <i class="ace-icon fa fa-square bigger-110"></i>
                        Catatan Sebelumnya
                      </button>
                      <?php } ?>
                      <div class="wysiwyg-editor" id="catatanT" data-bind="event:{input: catatan_protokol}"></div>
                    </div>
									</div>

									<div id="u" class="tab-pane">
										<h4 class="header smaller lighter blue">U. Monitor Keamanan</h4>
										<div class="form-group">
											<label for="u1">1. Rencana untuk memonitor keberlansungan keamanan obat atau intervensi lain yang dilakukan dalam penelitian atau trial, dan, bila diperlukan, pembentukan komite independen untuk data dan safety monitoring <small><i>(Guideline 4) (B,S3,S7)</i></small></label>
											<div class="row">
												<div class="col-xs-12 col-sm-12 widget-container-col">
													<div class="widget-box">
														<div class="widget-header">
															<h5 class="widget-title"></h5>

															<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
															<button class="btn btn-xs btn-info" data-bind="click: function(data, event){ uraian_before('U. Monitor Keamanan', 'uraianu1') }">
																<i class="ace-icon fa fa-square bigger-110"></i>
																Data Sebelumnya
															</button>
															<?php } ?>
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
																<?php echo isset($pep['uraianu1']) ? stripslashes($pep['uraianu1']) : ''?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

                    <h4 class="header smaller lighter orange">Catatan Penelaah</h4>
                    <div class="form-group">
                      <?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
                      <button class="btn btn-xs btn-warning" data-bind="click: function(data, event){ telaah_before('Catatan Protokol', 'U. Monitor Keamanan', 'catatanu') }">
                        <i class="ace-icon fa fa-square bigger-110"></i>
                        Catatan Sebelumnya
                      </button>
                      <?php } ?>
                      <div class="wysiwyg-editor" id="catatanU" data-bind="event:{input: catatan_protokol}"></div>
                    </div>
									</div>

									<div id="v" class="tab-pane">
										<h4 class="header smaller lighter blue">V. Konflik Kepentingan</h4>
										<div class="form-group">
											<label for="v1">1. Pengaturan untuk mengatasi konflik finansial atau yang lainnya yang bisa mempengaruhi keputusan para peneliti atau personil lainya; menginformasikan pada komite lembaga tentang adanya conflict of interest; komite mengkomunikasikannya ke komite etik dan kemudian mengkomunikasikan pada para peneliti tentang langkah langkah berikutnya yang harus dilakukan <small><i>(Guideline 25) (p42)</i></small></label>
											<div class="row">
												<div class="col-xs-12 col-sm-12 widget-container-col">
													<div class="widget-box">
														<div class="widget-header">
															<h5 class="widget-title"></h5>

															<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
															<button class="btn btn-xs btn-info" data-bind="click: function(data, event){ uraian_before('V. Konflik Kepentingan', 'uraianv1') }">
																<i class="ace-icon fa fa-square bigger-110"></i>
																Data Sebelumnya
															</button>
															<?php } ?>
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
																<?php echo isset($pep['uraianv1']) ? stripslashes($pep['uraianv1']) : ''?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

                    <h4 class="header smaller lighter orange">Catatan Penelaah</h4>
                    <div class="form-group">
                      <?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
                      <button class="btn btn-xs btn-warning" data-bind="click: function(data, event){ telaah_before('Catatan Protokol', 'V. Konflik Kepentingan', 'catatanv') }">
                        <i class="ace-icon fa fa-square bigger-110"></i>
                        Catatan Sebelumnya
                      </button>
                      <?php } ?>
                      <div class="wysiwyg-editor" id="catatanV" data-bind="event:{input: catatan_protokol}"></div>
                    </div>
									</div>

									<div id="w" class="tab-pane">
										<h4 class="header smaller lighter blue">W. Manfaat Sosial</h4>
										<div class="form-group">
											<label for="w1">1. Untuk penelitian yang dilakukan pada seting sumberdaya lemah, kontribusi yang dilakukan sponsor untuk capacity building untuk review ilmiah dan etika dan untuk riset-riset kesehatan di negara tersebut; dan jaminan bahwa tujuan capacity building adalah agar sesuai nilai dan harapan para partisipan dan komunitas tempat penelitian <small><i>(Guideline 8) (p43)</i></small></label>
											<div class="row">
												<div class="col-xs-12 col-sm-12 widget-container-col">
													<div class="widget-box">
														<div class="widget-header">
															<h5 class="widget-title"></h5>

															<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
															<button class="btn btn-xs btn-info" data-bind="click: function(data, event){ uraian_before('W. Manfaat Sosial', 'uraianw1') }">
																<i class="ace-icon fa fa-square bigger-110"></i>
																Data Sebelumnya
															</button>
															<?php } ?>
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
																<?php echo isset($pep['uraianw1']) ? stripslashes($pep['uraianw1']) : ''?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label for="w2">2. Protokol penelitian (dokumen) yang dikirim ke komite etik harus meliputi deskripsi rencana pelibatan komunitas, dan menunjukkan sumber-sumber yang dialokasikan untuk aktivitas aktivitas pelibatan tersebut. Dokumen ini menjelaskan apa yang sudah dan yang akan dilakukan, kapan dan oleh siapa, untuk memastikan bahwa masyarakat dengan jelas terpetakan untuk memudahkan pelibatan mereka selama riset, untuk memastikan bahwa tujuan riset sesuai kebutuhan masyarakat dan diterima oleh mereka. Bila perlu masyarakat harus dilibatkan dalam penyusunan protokol atau dokumen ini <small><i>(Guideline 7) (p44)</i></small></label>
											<div class="row">
												<div class="col-xs-12 col-sm-12 widget-container-col">
													<div class="widget-box">
														<div class="widget-header">
															<h5 class="widget-title"></h5>

															<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
															<button class="btn btn-xs btn-info" data-bind="click: function(data, event){ uraian_before('W. Manfaat Sosial', 'uraianw2') }">
																<i class="ace-icon fa fa-square bigger-110"></i>
																Data Sebelumnya
															</button>
															<?php } ?>
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
																<?php echo isset($pep['uraianw2']) ? stripslashes($pep['uraianw2']) : ''?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

                    <h4 class="header smaller lighter orange">Catatan Penelaah</h4>
                    <div class="form-group">
                      <?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
                      <button class="btn btn-xs btn-warning" data-bind="click: function(data, event){ telaah_before('Catatan Protokol', 'W. Manfaat Sosial', 'catatanw') }">
                        <i class="ace-icon fa fa-square bigger-110"></i>
                        Catatan Sebelumnya
                      </button>
                      <?php } ?>
                      <div class="wysiwyg-editor" id="catatanW" data-bind="event:{input: catatan_protokol}"></div>
                    </div>
									</div>

									<div id="x" class="tab-pane">
										<h4 class="header smaller lighter blue">X. Hak atas Data</h4>
										<div class="form-group">
											<label for="x1">1. Terutama bila sponsor adalah industri, kontrak yang menyatakan siapa pemilik hak publiksi hasil riset, dan kewajiban untuk menyiapkan bersama dan diberikan pada para PI draft laporan hasil riset <small><i>(Guideline 24) (B dan H, S1,S7)</i></small></label>
											<div class="row">
												<div class="col-xs-12 col-sm-12 widget-container-col">
													<div class="widget-box">
														<div class="widget-header">
															<h5 class="widget-title"></h5>

															<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
															<button class="btn btn-xs btn-info" data-bind="click: function(data, event){ uraian_before('X. Hak atas Data', 'uraianx1') }">
																<i class="ace-icon fa fa-square bigger-110"></i>
																Data Sebelumnya
															</button>
															<?php } ?>
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
																<?php echo isset($pep['uraianx1']) ? stripslashes($pep['uraianx1']) : ''?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

                    <h4 class="header smaller lighter orange">Catatan Penelaah</h4>
                    <div class="form-group">
                      <?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
                      <button class="btn btn-xs btn-warning" data-bind="click: function(data, event){ telaah_before('Catatan Protokol', 'X. Hak atas Data', 'catatanx') }">
                        <i class="ace-icon fa fa-square bigger-110"></i>
                        Catatan Sebelumnya
                      </button>
                      <?php } ?>
                      <div class="wysiwyg-editor" id="catatanX" data-bind="event:{input: catatan_protokol}"></div>
                    </div>
									</div>

									<div id="y" class="tab-pane">
										<h4 class="header smaller lighter blue">Y. Publikasi</h4>
										<div class="form-group">
											<label for="y1">Rencana publikasi hasil pada bidang tertentu (seperti epidemiology, generik, sosiologi) yang bisa beresiko berlawanan dengan kemaslahatan komunitas, masyarakat, keluarga, etnik tertentu, dan meminimalisir resiko kemudharatan kelompok ini dengan selalu mempertahankan kerahasiaan data selama dan setelah penelitian, dan mempublikasi hasil hasil penelitian sedemikian rupa dengan selalu mempertimbangkan martabat dan kemulyaan mereka <small><i>(Guideline 4) (p47)</i></small></label>
											<div class="row">
												<div class="col-xs-12 col-sm-12 widget-container-col">
													<div class="widget-box">
														<div class="widget-header">
															<h5 class="widget-title"></h5>

															<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
															<button class="btn btn-xs btn-info" data-bind="click: function(data, event){ uraian_before('Y. Publikasi', 'uraiany1') }">
																<i class="ace-icon fa fa-square bigger-110"></i>
																Data Sebelumnya
															</button>
															<?php } ?>
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
																<?php echo isset($pep['uraiany1']) ? stripslashes($pep['uraiany1']) : ''?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label for="y2">Bagaimana publikasi bila hasil riset negatip. <small><i>(Guideline 24) (p46)</i></small></label>
											<div class="row">
												<div class="col-xs-12 col-sm-12 widget-container-col">
													<div class="widget-box">
														<div class="widget-header">
															<h5 class="widget-title"></h5>

															<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
															<button class="btn btn-xs btn-info" data-bind="click: function(data, event){ uraian_before('Y. Publikasi', 'uraiany2') }">
																<i class="ace-icon fa fa-square bigger-110"></i>
																Data Sebelumnya
															</button>
															<?php } ?>
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
																<?php echo isset($pep['uraiany2']) ? stripslashes($pep['uraiany2']) : ''?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

                    <h4 class="header smaller lighter orange">Catatan Penelaah</h4>
                    <div class="form-group">
                      <?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
                      <button class="btn btn-xs btn-warning" data-bind="click: function(data, event){ telaah_before('Catatan Protokol', 'Y. Publikasi', 'catatany') }">
                        <i class="ace-icon fa fa-square bigger-110"></i>
                        Catatan Sebelumnya
                      </button>
                      <?php } ?>
                      <div class="wysiwyg-editor" id="catatanY" data-bind="event:{input: catatan_protokol}"></div>
                    </div>
									</div>

									<div id="z" class="tab-pane">
										<h4 class="header smaller lighter blue">Z. Pendanaan</h4>
										<div class="form-group">
											<label for="z1">Sumber dan jumlah dana riset; lembaga funding/sponsor, dan deskripsi komitmen finansial sponsor pada kelembagaan penelitian, pada para peneliti, para subyek riset, dan, bila ada, pada komunitas <small><i>(Guideline 25) (B, S2); (p41)</i></small></label>
											<div class="row">
												<div class="col-xs-12 col-sm-12 widget-container-col">
													<div class="widget-box">
														<div class="widget-header">
															<h5 class="widget-title"></h5>

															<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
															<button class="btn btn-xs btn-info" data-bind="click: function(data, event){ uraian_before('Z. Pendanaan', 'uraianz1') }">
																<i class="ace-icon fa fa-square bigger-110"></i>
																Data Sebelumnya
															</button>
															<?php } ?>
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
																<?php echo isset($pep['uraianz1']) ? stripslashes($pep['uraianz1']) : ''?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

                    <h4 class="header smaller lighter orange">Catatan Penelaah</h4>
                    <div class="form-group">
                      <?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
                      <button class="btn btn-xs btn-warning" data-bind="click: function(data, event){ telaah_before('Catatan Protokol', 'Z. Pendanaan', 'catatanz') }">
                        <i class="ace-icon fa fa-square bigger-110"></i>
                        Catatan Sebelumnya
                      </button>
                      <?php } ?>
                      <div class="wysiwyg-editor" id="catatanZ" data-bind="event:{input: catatan_protokol}"></div>
                    </div>
									</div>

									<div id="aa" class="tab-pane">
										<h4 class="header smaller lighter blue">AA. Komitmen Etik</h4>
										<div class="form-group">
											<label for="aa1">1. Pernyataan peneliti utama bahwa prinsip-prinsip yang tertuang dalam pedoman ini akan dipatuhi (lampirkan scan Surat Pernyataan) <small><i>(p6)</i></small></label>
											<div class="row">
												<div class="col-xs-12 col-sm-12 widget-container-col">
													<div class="widget-box">
														<div class="widget-header">
															<h5 class="widget-title"></h5>

															<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
															<button class="btn btn-xs btn-info" data-bind="click: function(data, event){ uraian_before('AA. Komitmen Etik', 'uraianaa1') }">
																<i class="ace-icon fa fa-square bigger-110"></i>
																Data Sebelumnya
															</button>
															<?php } ?>
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
																<?php echo isset($pep['uraianaa1']) ? stripslashes($pep['uraianaa1']) : ''?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label for="aa2">2. (Track Record) Riwayat usulan review protokol etik sebelumnya dan hasilnya (isi dengan judul da tanggal penelitian, dan hasil review Komite Etik) (lampirkan Daftar Riwayat Usulan Kaji Etiknya) <small><i>(p7)</i></small></label>
											<div class="row">
												<div class="col-xs-12 col-sm-12 widget-container-col">
													<div class="widget-box">
														<div class="widget-header">
															<h5 class="widget-title"></h5>

															<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
															<button class="btn btn-xs btn-info" data-bind="click: function(data, event){ uraian_before('AA. Komitmen Etik', 'uraianaa2') }">
																<i class="ace-icon fa fa-square bigger-110"></i>
																Data Sebelumnya
															</button>
															<?php } ?>
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
																<?php echo isset($pep['uraianaa2']) ? stripslashes($pep['uraianaa2']) : ''?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label for="aa3">3. Pernyataan bahwa bila terdapat bukti adanya pemalsuan data akan ditangani sesuai peraturan /ketentuan yang berlaku <small><i>(p48)</i></small></label>
											<div class="row">
												<div class="col-xs-12 col-sm-12 widget-container-col">
													<div class="widget-box">
														<div class="widget-header">
															<h5 class="widget-title"></h5>

															<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
															<button class="btn btn-xs btn-info" data-bind="click: function(data, event){ uraian_before('AA. Komitmen Etik', 'uraianaa3') }">
																<i class="ace-icon fa fa-square bigger-110"></i>
																Data Sebelumnya
															</button>
															<?php } ?>
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
																<?php echo isset($pep['uraianaa3']) ? stripslashes($pep['uraianaa3']) : ''?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

                    <h4 class="header smaller lighter orange">Catatan Penelaah</h4>
                    <div class="form-group">
                      <?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
                      <button class="btn btn-xs btn-warning" data-bind="click: function(data, event){ telaah_before('Catatan Protokol', 'AA. Komitmen Etik', 'catatanaa') }">
                        <i class="ace-icon fa fa-square bigger-110"></i>
                        Catatan Sebelumnya
                      </button>
                      <?php } ?>
                      <div class="wysiwyg-editor" id="catatanAA" data-bind="event:{input: catatan_protokol}"></div>
                    </div>
									</div>

									<div id="bb" class="tab-pane">
										<h4 class="header smaller lighter blue">BB. Daftar Pustaka</h4>
										<label for="bb1">Daftar referensi yang dirujuk dalam protokol <small><i>(p40)</i></small></label>
										<div class="row">
											<div class="col-xs-12 col-sm-12 widget-container-col">
												<div class="widget-box">
													<div class="widget-header">
														<h5 class="widget-title"></h5>

														<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
														<button class="btn btn-xs btn-info" data-bind="click: function(data, event){ uraian_before('BB. Daftar Pustak', 'uraianbb1') }">
															<i class="ace-icon fa fa-square bigger-110"></i>
															Data Sebelumnya
														</button>
														<?php } ?>
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
															<?php echo isset($pep['uraianbb1']) ? stripslashes($pep['uraianbb1']) : ''?>
														</div>
													</div>
												</div>
											</div>
										</div>

                    <h4 class="header smaller lighter orange">Catatan Penelaah</h4>
                    <div class="form-group">
                      <?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
                      <button class="btn btn-xs btn-warning" data-bind="click: function(data, event){ telaah_before('Catatan Protokol', 'BB. Daftar Pustaka', 'catatanbb') }">
                        <i class="ace-icon fa fa-square bigger-110"></i>
                        Catatan Sebelumnya
                      </button>
                      <?php } ?>
                      <div class="wysiwyg-editor" id="catatanBB" data-bind="event:{input: catatan_protokol}"></div>
                    </div>
									</div>

									<div id="cc" class="tab-pane">
										<h4 class="header smaller lighter blue">CC. Lampiran</h4>
										<p>1. CV Peneliti Utama</p>
										<ul class="list-unstyled">
											<?php 
											if ($lampiran_pep)
											{
												for ($i=0; $i<count($lampiran_pep); $i++)
												{
													if ($lampiran_pep[$i]['lampiran'] == 1)
													{
														echo '<li>';
														echo '<i class="fa fa-paperclip">&nbsp;&nbsp;&nbsp;</i>'.$lampiran_pep[$i]['client_name'].'&nbsp;&nbsp;&nbsp';
                            echo '<a href="#" data-bind="click: function(){ showFile(\'uploads/'.$lampiran_pep[$i]['file_name'].'\') }" title="Lihat File"><i class="ace-icon fa fa-search bigger-110"></i></a>&nbsp;&nbsp;';
														echo '<a href="';
														echo base_url().'telaah_expedited/download/'.rawurlencode(urlencode($lampiran_pep[$i]['file_name'])).'/'.rawurlencode(urlencode($lampiran_pep[$i]['client_name'])).'">';
														echo '<i class="fa fa-download"></i></a>';
														echo '</li>';
													}
												}
											}
											?>
										</ul>
										<div class="hr hr-dotted hr-18"></div>

										<p>2. CV Anggota Peneliti</p>
										<ul class="list-unstyled">
											<?php 
											if ($lampiran_pep)
											{
												for ($i=0; $i<count($lampiran_pep); $i++)
												{
													if ($lampiran_pep[$i]['lampiran'] == 2)
													{
														echo '<li>';
														echo '<i class="fa fa-paperclip">&nbsp;&nbsp;&nbsp;</i>'.$lampiran_pep[$i]['client_name'].'&nbsp;&nbsp;&nbsp';
                            echo '<a href="#" data-bind="click: function(){ showFile(\'uploads/'.$lampiran_pep[$i]['file_name'].'\') }" title="Lihat File"><i class="ace-icon fa fa-search bigger-110"></i></a>&nbsp;&nbsp;';
														echo '<a href="';
														echo base_url().'telaah_expedited/download/'.rawurlencode(urlencode($lampiran_pep[$i]['file_name'])).'/'.rawurlencode(urlencode($lampiran_pep[$i]['client_name'])).'">';
														echo '<i class="fa fa-download"></i></a>';
														echo '</li>';
													}
												}
											}
											?>
										</ul>
										<div class="hr hr-dotted hr-18"></div>

										<p>3. Daftar Lembaga Sponsor</p>
										<ul class="list-unstyled">
											<?php 
											if ($lampiran_pep)
											{
												for ($i=0; $i<count($lampiran_pep); $i++)
												{
													if ($lampiran_pep[$i]['lampiran'] == 3)
													{
														echo '<li>';
														echo '<i class="fa fa-paperclip">&nbsp;&nbsp;&nbsp;</i>'.$lampiran_pep[$i]['client_name'].'&nbsp;&nbsp;&nbsp';
                            echo '<a href="#" data-bind="click: function(){ showFile(\'uploads/'.$lampiran_pep[$i]['file_name'].'\') }" title="Lihat File"><i class="ace-icon fa fa-search bigger-110"></i></a>&nbsp;&nbsp;';
														echo '<a href="';
														echo base_url().'telaah_expedited/download/'.rawurlencode(urlencode($lampiran_pep[$i]['file_name'])).'/'.rawurlencode(urlencode($lampiran_pep[$i]['client_name'])).'">';
														echo '<i class="fa fa-download"></i></a>';
														echo '</li>';
													}
												}
											}
											?>
										</ul>
										<div class="hr hr-dotted hr-18"></div>

										<p>4. Surat-surat pernyataan</p>
										<ul class="list-unstyled">
											<?php 
											if ($lampiran_pep)
											{
												for ($i=0; $i<count($lampiran_pep); $i++)
												{
													if ($lampiran_pep[$i]['lampiran'] == 4)
													{
														echo '<li>';
														echo '<i class="fa fa-paperclip">&nbsp;&nbsp;&nbsp;</i>'.$lampiran_pep[$i]['client_name'].'&nbsp;&nbsp;&nbsp';
                            echo '<a href="#" data-bind="click: function(){ showFile(\'uploads/'.$lampiran_pep[$i]['file_name'].'\') }" title="Lihat File"><i class="ace-icon fa fa-search bigger-110"></i></a>&nbsp;&nbsp;';
														echo '<a href="';
														echo base_url().'telaah_expedited/download/'.rawurlencode(urlencode($lampiran_pep[$i]['file_name'])).'/'.rawurlencode(urlencode($lampiran_pep[$i]['client_name'])).'">';
														echo '<i class="fa fa-download"></i></a>';
														echo '</li>';
													}
												}
											}
											?>
										</ul>
										<div class="hr hr-dotted hr-18"></div>
										<p>5. Formulir Laporan kasus/Kuesioner, dll</p>
										<ul class="list-unstyled">
											<?php 
											if ($lampiran_pep)
											{
												for ($i=0; $i<count($lampiran_pep); $i++)
												{
													if ($lampiran_pep[$i]['lampiran'] == 5)
													{
														echo '<li>';
														echo '<i class="fa fa-paperclip">&nbsp;&nbsp;&nbsp;</i>'.$lampiran_pep[$i]['client_name'].'&nbsp;&nbsp;&nbsp';
                            echo '<a href="#" data-bind="click: function(){ showFile(\'uploads/'.$lampiran_pep[$i]['file_name'].'\') }" title="Lihat File"><i class="ace-icon fa fa-search bigger-110"></i></a>&nbsp;&nbsp;';
														echo '<a href="';
														echo base_url().'telaah_expedited/download/'.rawurlencode(urlencode($lampiran_pep[$i]['file_name'])).'/'.rawurlencode(urlencode($lampiran_pep[$i]['client_name'])).'">';
														echo '<i class="fa fa-download"></i></a>';
														echo '</li>';
													}
												}
											}
											?>
										</ul>
										<div class="hr hr-dotted hr-18"></div>
										<p>6. Informed Consent 35 butir</p>
										<ul class="list-unstyled">
											<?php 
											if ($lampiran_pep)
											{
												for ($i=0; $i<count($lampiran_pep); $i++)
												{
													if ($lampiran_pep[$i]['lampiran'] == 6)
													{
														echo '<li>';
														echo '<i class="fa fa-paperclip">&nbsp;&nbsp;&nbsp;</i>'.$lampiran_pep[$i]['client_name'].'&nbsp;&nbsp;&nbsp';
                            echo '<a href="#" data-bind="click: function(){ showFile(\'uploads/'.$lampiran_pep[$i]['file_name'].'\') }" title="Lihat File"><i class="ace-icon fa fa-search bigger-110"></i></a>&nbsp;&nbsp;';
														echo '<a href="';
														echo base_url().'telaah_expedited/download/'.rawurlencode(urlencode($lampiran_pep[$i]['file_name'])).'/'.rawurlencode(urlencode($lampiran_pep[$i]['client_name'])).'">';
														echo '<i class="fa fa-download"></i></a>';
														echo '</li>';
													}
												}
											}
											?>
										</ul>
										<div class="hr hr-dotted hr-18"></div>

                    <h4 class="header smaller lighter orange">Catatan Penelaah</h4>
                    <div class="form-group">
                      <?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
                      <button class="btn btn-xs btn-warning" data-bind="click: function(data, event){ telaah_before('Catatan Protokol', 'CC. Lampiran', 'catatancc') }">
                        <i class="ace-icon fa fa-square bigger-110"></i>
                        Catatan Sebelumnya
                      </button>
                      <?php } ?>
                      <div class="wysiwyg-editor" id="catatanCC" data-bind="event:{input: catatan_protokol}"></div>
                    </div>
									</div>

									<div id="link" class="tab-pane">
										<h4 class="header smaller lighter blue">Link Google Drive Proposal</h4>
										<div class="form-group">
                    <?php 
                    if (isset($pep['link_proposal']) && $pep['link_proposal'] != "")
                    {
                      echo '<a href="'.$pep['link_proposal'].'" target="_blank">'.$pep['link_proposal'].'</a>';
                    } 
                    else echo '<i>null</i>'; 
                    ?>
										</div>

                    <h4 class="header smaller lighter orange">Catatan Penelaah</h4>
                    <div class="form-group">
                      <?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
                      <button class="btn btn-xs btn-warning" data-bind="click: function(data, event){ telaah_before('Catatan Protokol', 'Link Google Drive Proposal', 'catatan_link_proposal') }">
                        <i class="ace-icon fa fa-square bigger-110"></i>
                        Catatan Sebelumnya
                      </button>
                      <?php } ?>
                      <div class="wysiwyg-editor" id="catatan_link_proposal" data-bind="event:{input: catatan_protokol}"></div>
                    </div>
									</div>

								</div>
							</div>
						</div><!-- /.col -->
					</div>

				</div>

				<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
				<div id="ringkasan-tab" class="tab-pane">

					<h3 class="header smaller lighter blue">Ringkasan Putusan</h3>
					<div class="row">
						<div class="col-xs-12 col-sm-12 widget-container-col">
							<div class="widget-box">
								<div class="widget-header">
									<h5 class="widget-title"></h5>

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
										<?php echo isset($putusan['ringkasan']) ? stripslashes($putusan['ringkasan']) : ''?>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
				<?php } else { ?>
				<div id="resume-tab" class="tab-pane">

        <?php 
        if (!empty($resume)) {
          for ($i=0; $i<count($resume); $i++) {
        ?>
					<h3 class="header smaller lighter blue">Resume</h3>
					<div class="row">
						<div class="col-xs-12 col-sm-12 widget-container-col" >
							<div class="widget-box">
								<div class="widget-header">
									<h5 class="widget-title"></h5>

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
										<?php echo isset($resume[$i]['resume']) ? stripslashes($resume[$i]['resume']) : '<em>null</em>'?>
									</div>
								</div>
							</div>
						</div>
					</div>
        <?php } } // end for & if !empty(resume) ?>

				</div><!-- /.#resume -->
				<?php } ?>

				<div id="self_assesment-tab" class="tab-pane">
          <div class="alert alert-info" data-bind="visible: id() == 0">
            <button type="button" class="close" data-dismiss="alert">
              <i class="ace-icon fa fa-times"></i>
            </button>
            Pilihan Penelaah beberapa item/poin <strong>7-Standar Kelainan Etik Penelitian</strong> secara default terisi "Ya"
          </div>

          <h3 class="header smaller lighter blue">
						7 Standar
						<div class="pull-right">
							<a href="#" data-bind="click: print_sa">
								<i class="ace-icon fa fa-print bigger-110"></i>
							</a>
						</div>
					</h3>

					<div id="fuelux-wizard-container">
						<div>
							<ul class="steps">
								<li data-step="1" class="active">
									<span class="step">1</span>
									<span class="title">Nilai Sosial/Klinis</span>
								</li>

								<li data-step="2">
									<span class="step">2</span>
									<span class="title">Nilai Ilmiah</span>
								</li>

								<li data-step="3">
									<span class="step">3</span>
									<span class="title">Pemerataan Beban dan Manfaat</span>
								</li>

								<li data-step="4">
									<span class="step">4</span>
									<span class="title">Potensi Manfaat dan Resiko</span>
								</li>

								<li data-step="5">
									<span class="step">5</span>
									<span class="title">Bujukan/ Eksploitasi/ Iducement</span>
								</li>

								<li data-step="6">
									<span class="step">6</span>
									<span class="title">Rahasia dan Privacy</span>
								</li>

								<li data-step="7">
									<span class="step">7</span>
									<span class="title">Informed Consent</span>
								</li>
							</ul>
						</div>

						<hr />

						<div class="step-content pos-rel">
							<div class="step-pane active" data-step="1">
								<div class="form-group pull-right">
									<button class="btn btn-sm" id="reset1" data-bind="click: reset1">
										<i class="ace-icon fa fa-circle bigger-110"></i>
										Kosongkan
									</button>
								</div>

								<table class="table table-bordered table-hover">
									<thead>
										<tr>
											<th width="5%">No</th>
											<th width="60%">7-STANDAR KELAIKAN ETIK PENELITIAN</th>
											<th width="10%">PENELITI</th>
											<th width="25%">PENELAAH</th>
										</tr>
									</thead>
                  <tbody data-bind="foreach: self_assesment1">
                    <tr data-bind="attr: {'class': level == 0 ? 'active' : ''}">
                      <td data-bind="html: no_tampilan, attr: {'align': level == 0 ? 'left': 'right'} "></td>
                      <td>
                        <div data-bind="if: level == 0">
                          <strong><span data-bind="html: uraian_master"></span></strong>
                          <br/><span data-bind="html: uraian == uraian_master ? '' : uraian"></span>
                        </div>
                        <div data-bind="if: level > 0">
                          <span data-bind="html: uraian"></span>
                        </div>
                      </td>
                      <td>
                        <div class="control-group" data-bind="visible: just_header == 0">
                          <div class="radio">
                            <label>
                              <input type="radio" class="ace" value="Ya" data-bind="checked: pil_pengaju, attr:{'name': $index().$data}, enable: pil_pengaju == 'Ya'" />
                              <span class="lbl"> Ya</span>
                            </label>
                          </div>
                          <div class="radio">
                            <label>
                              <input type="radio" class="ace" value="Tidak" data-bind="checked: pil_pengaju, attr:{'name': $index().$data}, enable: pil_pengaju == 'Tidak'" />
                              <span class="lbl"> Tidak</span>
                            </label>
                          </div>
                        </div>
                      </td>
											<td>
												<div class="control-group" data-bind="visible: just_header == 0">
													<div class="radio">
														<label>
															<input type="radio" class="ace" value="Ya" data-bind="checked: pil_penelaah, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih1Ya($index(), parent) }}, enable: child == 0 || pil_penelaah() == 'Ya'" />
															<span class="lbl"> Ya</span>
														</label>
														<label>
															<input type="radio" class="ace" value="Tidak" data-bind="checked: pil_penelaah, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih1Tidak() }}, enable: child == 0 || pil_penelaah() == 'Tidak'" />
															<span class="lbl"> Tidak</span>
														</label>
													</div>
                          <textarea class="form-control" placeholder="Catatan Penelaah" data-bind="value: cat_penelaah, visible: child == 0, valueUpdate: 'input', event: { input: $root.catatan_sa(1) }" style="font-size: 11px;"></textarea>
												</div>
											</td>
										</tr>
									</tbody>
								</table>

								<h3 class="header smaller lighter blue">Justifikasi Peneliti (Nilai Sosial/Klinis):</h3>
								<div class="form-group">
                  <?php echo isset($sac['justifikasi1']) && strlen(trim($sac['justifikasi1'])) > 0 ? $sac['justifikasi1'] : '<i>null</i>' ?>
								</div>

								<h3 class="header smaller lighter orange">Catatan Penelaah (Nilai Sosial/Klinis):</h3>
								<div class="form-group">
                  <?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
                  <button class="btn btn-xs btn-warning" data-bind="click: function(data, event){ telaah_before('Catatan 7 Standar', 'Nilai Sosial/Klinis', 'catatan_sa1') }">
                    <i class="ace-icon fa fa-square bigger-110"></i>
                    Catatan Sebelumnya
                  </button>
                  <?php } ?>
                  <div class="well" id="catatan1"></div>
                </div>
              </div>

							<div class="step-pane" data-step="2">
								<div class="form-group pull-right">
									<button class="btn btn-sm" id="reset2" data-bind="click: reset2">
										<i class="ace-icon fa fa-circle bigger-110"></i>
										Kosongkan
									</button>
								</div>

								<table class="table table-bordered table-hover">
									<thead>
										<tr>
											<th width="5%">No</th>
											<th width="60%">7-STANDAR KELAIKAN ETIK PENELITIAN</th>
											<th width="10%">PENELITI</th>
											<th width="25%">PENELAAH</th>
										</tr>
									</thead>
									<tbody data-bind="foreach: self_assesment2">
										<tr data-bind="attr: {'class': level == 0 ? 'active' : ''}">
											<td data-bind="html: no_tampilan, attr: {'align': level == 0 ? 'left': 'right'} "></td>
											<td>
												<div data-bind="if: level == 0">
													<strong><span data-bind="html: uraian_master"></span></strong>
													<br/><span data-bind="html: uraian == uraian_master ? '' : uraian"></span>
												</div>
												<div data-bind="if: level > 0">
													<span data-bind="html: uraian"></span>
												</div>
											</td>
											<td>
												<div class="control-group" data-bind="visible: just_header == 0">
													<div class="radio">
														<label>
															<input type="radio" class="ace" value="Ya" data-bind="checked: pil_pengaju, attr:{'name': $index().$data}, enable: pil_pengaju == 'Ya'" />
															<span class="lbl"> Ya</span>
														</label>
													</div>
													<div class="radio">
														<label>
															<input type="radio" class="ace" value="Tidak" data-bind="checked: pil_pengaju, attr:{'name': $index().$data}, enable: pil_pengaju == 'Tidak'" />
															<span class="lbl"> Tidak</span>
														</label>
													</div>
												</div>
											</td>
											<td>
												<div class="control-group" data-bind="visible: just_header == 0">
													<div class="radio">
														<label>
															<input type="radio" class="ace" value="Ya" data-bind="checked: pil_penelaah, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih2Ya($index(), parent) }}, enable: child == 0 || pil_penelaah() == 'Ya'" />
															<span class="lbl"> Ya</span>
														</label>
														<label>
															<input type="radio" class="ace" value="Tidak" data-bind="checked: pil_penelaah, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih2Tidak() }}, enable: child == 0 || pil_penelaah() == 'Tidak'" />
															<span class="lbl"> Tidak</span>
														</label>
													</div>
                          <textarea class="form-control" placeholder="Catatan Penelaah" data-bind="value: cat_penelaah, visible: child == 0, valueUpdate: 'input', event: { input: $root.catatan_sa(2) }" style="font-size: 11px;"></textarea>
												</div>
											</td>
										</tr>
									</tbody>
								</table>

								<h3 class="header smaller lighter blue">Justifikasi Peneliti (Nilai Ilmiah):</h3>
								<div class="form-group">
                  <?php echo isset($sac['justifikasi2']) && strlen(trim($sac['justifikasi2'])) > 0 ? $sac['justifikasi2'] : '<i>null</i>' ?>
								</div>

								<h3 class="header smaller lighter orange">Catatan Penelaah (Nilai Ilmiah):</h3>
								<div class="form-group">
                  <?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
                  <button class="btn btn-xs btn-warning" data-bind="click: function(data, event){ telaah_before('Catatan 7 Standar', 'Nilai Ilmiah', 'catatan_sa2') }">
                    <i class="ace-icon fa fa-square bigger-110"></i>
                    Catatan Sebelumnya
                  </button>
                  <?php } ?>
									<div class="well" id="catatan2"></div>		
								</div>

							</div>

							<div class="step-pane" data-step="3">
								<div class="form-group pull-right">
									<button class="btn btn-sm" id="reset3" data-bind="click: reset3">
										<i class="ace-icon fa fa-circle bigger-110"></i>
										Kosongkan
									</button>
								</div>

								<table class="table table-bordered table-hover">
									<thead>
										<tr>
											<th width="5%">No</th>
											<th width="60%">7-STANDAR KELAIKAN ETIK PENELITIAN</th>
											<th width="10%">PENELITI</th>
											<th width="25%">PENELAAH</th>
										</tr>
									</thead>
									<tbody data-bind="foreach: self_assesment3">
										<tr data-bind="attr: {'class': level == 0 ? 'active' : ''}">
											<td data-bind="html: no_tampilan, attr: {'align': level == 0 ? 'left': 'right'} "></td>
											<td>
												<div data-bind="if: level == 0">
													<strong><span data-bind="html: uraian_master"></span></strong>
													<br/><span data-bind="html: uraian == uraian_master ? '' : uraian"></span>
												</div>
												<div data-bind="if: level > 0">
													<span data-bind="html: uraian"></span>
												</div>
											</td>
											<td>
												<div class="control-group" data-bind="visible: just_header == 0">
													<div class="radio">
														<label>
															<input type="radio" class="ace" value="Ya" data-bind="checked: pil_pengaju, attr:{'name': $index().$data}, enable: pil_pengaju == 'Ya'" />
															<span class="lbl"> Ya</span>
														</label>
													</div>
													<div class="radio">
														<label>
															<input type="radio" class="ace" value="Tidak" data-bind="checked: pil_pengaju, attr:{'name': $index().$data}, enable: pil_pengaju == 'Tidak'" />
															<span class="lbl"> Tidak</span>
														</label>
													</div>
												</div>
											</td>
											<td>
												<div class="control-group" data-bind="visible: just_header == 0">
													<div class="radio">
														<label>
															<input type="radio" class="ace" value="Ya" data-bind="checked: pil_penelaah, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih3Ya($index(), parent) }}, enable: child == 0 || pil_penelaah() == 'Ya'" />
															<span class="lbl"> Ya</span>
														</label>
														<label>
															<input type="radio" class="ace" value="Tidak" data-bind="checked: pil_penelaah, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih3Tidak() }}, enable: child == 0 || pil_penelaah() == 'Tidak'" />
															<span class="lbl"> Tidak</span>
														</label>
													</div>
                          <textarea class="form-control" placeholder="Catatan Penelaah" data-bind="value: cat_penelaah, visible: child == 0, valueUpdate: 'input', event: { input: $root.catatan_sa(3) }" style="font-size: 11px;"></textarea>
												</div>
											</td>
										</tr>
									</tbody>
								</table>

								<h3 class="header smaller lighter blue">Justifikasi Peneliti (Pemerataan Beban dan Manfaat):</h3>
								<div class="form-group">
                  <?php echo isset($sac['justifikasi3']) && strlen(trim($sac['justifikasi3'])) > 0 ? $sac['justifikasi3'] : '<i>null</i>' ?>
								</div>

								<h3 class="header smaller lighter orange">Catatan Penelaah (Pemerataan Beban dan Manfaat):</h3>
								<div class="form-group">
                  <?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
                  <button class="btn btn-xs btn-warning" data-bind="click: function(data, event){ telaah_before('Catatan 7 Standar', 'Pemerataan Beban dan Manfaat', 'catatan_sa3') }">
                    <i class="ace-icon fa fa-square bigger-110"></i>
                    Catatan Sebelumnya
                  </button>
                  <?php } ?>
									<div class="well" id="catatan3"></div>		
								</div>

							</div>

							<div class="step-pane" data-step="4">
								<div class="form-group pull-right">
									<button class="btn btn-sm" id="reset4" data-bind="click: reset4">
										<i class="ace-icon fa fa-circle bigger-110"></i>
										Kosongkan
									</button>
								</div>

								<table class="table table-bordered table-hover">
									<thead>
										<tr>
											<th width="5%">No</th>
											<th width="60%">7-STANDAR KELAIKAN ETIK PENELITIAN</th>
											<th width="10%">PENELITI</th>
											<th width="25%">PENELAAH</th>
										</tr>
									</thead>
									<tbody data-bind="foreach: self_assesment4">
										<tr data-bind="attr: {'class': level == 0 ? 'active' : ''}">
											<td data-bind="html: no_tampilan, attr: {'align': level == 0 ? 'left': 'right'} "></td>
											<td>
												<div data-bind="if: level == 0">
													<strong><span data-bind="html: uraian_master"></span></strong>
													<br/><span data-bind="html: uraian == uraian_master ? '' : uraian"></span>
												</div>
												<div data-bind="if: level > 0">
													<span data-bind="html: uraian"></span>
												</div>
											</td>
											<td>
												<div class="control-group" data-bind="visible: just_header == 0">
													<div class="radio">
														<label>
															<input type="radio" class="ace" value="Ya" data-bind="checked: pil_pengaju, attr:{'name': $index().$data}, enable: pil_pengaju == 'Ya'" />
															<span class="lbl"> Ya</span>
														</label>
													</div>
													<div class="radio">
														<label>
															<input type="radio" class="ace" value="Tidak" data-bind="checked: pil_pengaju, attr:{'name': $index().$data}, enable: pil_pengaju == 'Tidak'" />
															<span class="lbl"> Tidak</span>
														</label>
													</div>
												</div>
											</td>
											<td>
												<div class="control-group" data-bind="visible: just_header == 0">
													<div class="radio">
														<label>
															<input type="radio" class="ace" value="Ya" data-bind="checked: pil_penelaah, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih4Ya($index(), parent) }}, enable: child == 0 || pil_penelaah() == 'Ya'" />
															<span class="lbl"> Ya</span>
														</label>
														<label>
															<input type="radio" class="ace" value="Tidak" data-bind="checked: pil_penelaah, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih4Tidak() }}, enable: child == 0 || pil_penelaah() == 'Tidak'" />
															<span class="lbl"> Tidak</span>
														</label>
													</div>
                          <textarea class="form-control" placeholder="Catatan Penelaah" data-bind="value: cat_penelaah, visible: child == 0, valueUpdate: 'input', event: { input: $root.catatan_sa(4) }" style="font-size: 11px;"></textarea>
												</div>
											</td>
										</tr>
									</tbody>
								</table>

								<h3 class="header smaller lighter blue">Justifikasi Peneliti (Potensi Manfaat dan Resiko):</h3>
								<div class="form-group">
                  <?php echo isset($sac['justifikasi4']) && strlen(trim($sac['justifikasi4'])) > 0 ? $sac['justifikasi4'] : '<i>null</i>' ?>
								</div>

								<h3 class="header smaller lighter orange">Catatan Penelaah (Potensi Manfaat dan Resiko):</h3>
								<div class="form-group">
                  <?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
                  <button class="btn btn-xs btn-warning" data-bind="click: function(data, event){ telaah_before('Catatan 7 Standar', 'Potensi Manfaat dan Resiko', 'catatan_sa4') }">
                    <i class="ace-icon fa fa-square bigger-110"></i>
                    Catatan Sebelumnya
                  </button>
                  <?php } ?>
									<div class="well" id="catatan4"></div>		
								</div>

							</div>

							<div class="step-pane" data-step="5">
								<div class="form-group pull-right">
									<button class="btn btn-sm" id="reset5" data-bind="click: reset5">
										<i class="ace-icon fa fa-circle bigger-110"></i>
										Kosongkan
									</button>
								</div>

								<table class="table table-bordered table-hover">
									<thead>
										<tr>
											<th width="5%">No</th>
											<th width="60%">7-STANDAR KELAIKAN ETIK PENELITIAN</th>
											<th width="10%">PENELITI</th>
											<th width="25%">PENELAAH</th>
										</tr>
									</thead>
									<tbody data-bind="foreach: self_assesment5">
										<tr data-bind="attr: {'class': level == 0 ? 'active' : ''}">
											<td data-bind="html: no_tampilan, attr: {'align': level == 0 ? 'left': 'right'} "></td>
											<td>
												<div data-bind="if: level == 0">
													<strong><span data-bind="html: uraian_master"></span></strong>
													<br/><span data-bind="html: uraian == uraian_master ? '' : uraian"></span>
												</div>
												<div data-bind="if: level > 0">
													<span data-bind="html: uraian"></span>
												</div>
											</td>
											<td>
												<div class="control-group" data-bind="visible: just_header == 0">
													<div class="radio">
														<label>
															<input type="radio" class="ace" value="Ya" data-bind="checked: pil_pengaju, attr:{'name': $index().$data}, enable: pil_pengaju == 'Ya'" />
															<span class="lbl"> Ya</span>
														</label>
													</div>
													<div class="radio">
														<label>
															<input type="radio" class="ace" value="Tidak" data-bind="checked: pil_pengaju, attr:{'name': $index().$data}, enable: pil_pengaju == 'Tidak'" />
															<span class="lbl"> Tidak</span>
														</label>
													</div>
												</div>
											</td>
											<td>
												<div class="control-group" data-bind="visible: just_header == 0">
													<div class="radio">
														<label>
															<input type="radio" class="ace" value="Ya" data-bind="checked: pil_penelaah, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih5Ya($index(), parent) }}, enable: child == 0 || pil_penelaah() == 'Ya'" />
															<span class="lbl"> Ya</span>
														</label>
														<label>
															<input type="radio" class="ace" value="Tidak" data-bind="checked: pil_penelaah, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih5Tidak() }}, enable: child == 0 || pil_penelaah() == 'Tidak'" />
															<span class="lbl"> Tidak</span>
														</label>
													</div>
                          <textarea class="form-control" placeholder="Catatan Penelaah" data-bind="value: cat_penelaah, visible: child == 0, valueUpdate: 'input', event: { input: $root.catatan_sa(5) }" style="font-size: 11px;"></textarea>
												</div>
											</td>
										</tr>
									</tbody>
								</table>

								<h3 class="header smaller lighter blue">Justifikasi Peneliti (Bujukan/ Eksploitasi/ Iducement):</h3>
								<div class="form-group">
                  <?php echo isset($sac['justifikasi5']) && strlen(trim($sac['justifikasi5'])) > 0 ? $sac['justifikasi5'] : '<i>null</i>' ?>
								</div>

								<h3 class="header smaller lighter orange">Catatan Penelaah (Bujukan/ Eksploitasi/ Iducement):</h3>
								<div class="form-group">
                  <?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
                  <button class="btn btn-xs btn-warning" data-bind="click: function(data, event){ telaah_before('Catatan 7 Standar', 'Bujukan/ Eksploitasi/ Iducement', 'catatan_sa5') }">
                    <i class="ace-icon fa fa-square bigger-110"></i>
                    Catatan Sebelumnya
                  </button>
                  <?php } ?>
									<div class="well" id="catatan5"></div>		
								</div>

							</div>

							<div class="step-pane" data-step="6">
								<div class="form-group pull-right">
									<button class="btn btn-sm" id="reset6" data-bind="click: reset6">
										<i class="ace-icon fa fa-circle bigger-110"></i>
										Kosongkan
									</button>
								</div>

								<table class="table table-bordered table-hover">
									<thead>
										<tr>
											<th width="5%">No</th>
											<th width="60%">7-STANDAR KELAIKAN ETIK PENELITIAN</th>
											<th width="10%">PENELITI</th>
											<th width="25%">PENELAAH</th>
										</tr>
									</thead>
									<tbody data-bind="foreach: self_assesment6">
										<tr data-bind="attr: {'class': level == 0 ? 'active' : ''}">
											<td data-bind="html: no_tampilan, attr: {'align': level == 0 ? 'left': 'right'} "></td>
											<td>
												<div data-bind="if: level == 0">
													<strong><span data-bind="html: uraian_master"></span></strong>
													<br/><span data-bind="html: uraian == uraian_master ? '' : uraian"></span>
												</div>
												<div data-bind="if: level > 0">
													<span data-bind="html: uraian"></span>
												</div>
											</td>
											<td>
												<div class="control-group" data-bind="visible: just_header == 0">
													<div class="radio">
														<label>
															<input type="radio" class="ace" value="Ya" data-bind="checked: pil_pengaju, attr:{'name': $index().$data}, enable: pil_pengaju == 'Ya'" />
															<span class="lbl"> Ya</span>
														</label>
													</div>
													<div class="radio">
														<label>
															<input type="radio" class="ace" value="Tidak" data-bind="checked: pil_pengaju, attr:{'name': $index().$data}, enable: pil_pengaju == 'Tidak'" />
															<span class="lbl"> Tidak</span>
														</label>
													</div>
												</div>
											</td>
											<td>
												<div class="control-group" data-bind="visible: just_header == 0">
													<div class="radio">
														<label>
															<input type="radio" class="ace" value="Ya" data-bind="checked: pil_penelaah, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih6Ya($index(), parent) }}, enable: child == 0 || pil_penelaah() == 'Ya'" />
															<span class="lbl"> Ya</span>
														</label>
														<label>
															<input type="radio" class="ace" value="Tidak" data-bind="checked: pil_penelaah, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih6Tidak() }}, enable: child == 0 || pil_penelaah() == 'Tidak'" />
															<span class="lbl"> Tidak</span>
														</label>
													</div>
                          <textarea class="form-control" placeholder="Catatan Penelaah" data-bind="value: cat_penelaah, visible: child == 0, valueUpdate: 'input', event: { input: $root.catatan_sa(6) }" style="font-size: 11px;"></textarea>
												</div>
											</td>										
										</tr>
									</tbody>
								</table>

								<h3 class="header smaller lighter blue">Justifikasi Peneliti (Rahasia dan Privacy):</h3>
								<div class="form-group">
                  <?php echo isset($sac['justifikasi6']) && strlen(trim($sac['justifikasi6'])) > 0 ? $sac['justifikasi6'] : '<i>null</i>' ?>
								</div>

								<h3 class="header smaller lighter orange">Catatan Penelaah (Rahasia dan Privacy):</h3>
								<div class="form-group">
                  <?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
                  <button class="btn btn-xs btn-warning" data-bind="click: function(data, event){ telaah_before('Catatan 7 Standar', 'Rahasia dan Privacy', 'catatan_sa6') }">
                    <i class="ace-icon fa fa-square bigger-110"></i>
                    Catatan Sebelumnya
                  </button>
                  <?php } ?>
									<div class="well" id="catatan6"></div>		
								</div>

							</div>

							<div class="step-pane" data-step="7">
								<div class="form-group pull-right">
									<button class="btn btn-sm" id="reset7" data-bind="click: reset7">
										<i class="ace-icon fa fa-circle bigger-110"></i>
										Kosongkan
									</button>
								</div>

								<table class="table table-bordered table-hover">
									<thead>
										<tr>
											<th width="5%">No</th>
											<th width="60%">7-STANDAR KELAIKAN ETIK PENELITIAN</th>
											<th width="10%">PENELITI</th>
											<th width="25%">PENELAAH</th>
										</tr>
									</thead>
									<tbody data-bind="foreach: self_assesment7">
										<tr data-bind="attr: {'class': level == 0 ? 'active' : ''}">
											<td data-bind="html: no_tampilan, attr: {'align': level == 0 ? 'left': 'right'} "></td>
											<td>
												<div data-bind="if: level == 0">
													<strong><span data-bind="html: uraian_master"></span></strong>
													<br/><span data-bind="html: uraian == uraian_master ? '' : uraian"></span>
												</div>
												<div data-bind="if: level > 0">
													<span data-bind="html: uraian"></span>
												</div>
											</td>
											<td>
												<div class="control-group" data-bind="visible: just_header == 0">
													<div class="radio">
														<label>
															<input type="radio" class="ace" value="Ya" data-bind="checked: pil_pengaju, attr:{'name': $index().$data}, enable: pil_pengaju == 'Ya'" />
															<span class="lbl"> Ya</span>
														</label>
													</div>
													<div class="radio">
														<label>
															<input type="radio" class="ace" value="Tidak" data-bind="checked: pil_pengaju, attr:{'name': $index().$data}, enable: pil_pengaju == 'Tidak'" />
															<span class="lbl"> Tidak</span>
														</label>
													</div>
												</div>
											</td>
											<td>
												<div class="control-group" data-bind="visible: just_header == 0">
													<div class="radio">
														<label>
															<input type="radio" class="ace" value="Ya" data-bind="checked: pil_penelaah, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih7Ya($index(), parent) }}, enable: child == 0 || pil_penelaah() == 'Ya'" />
															<span class="lbl"> Ya</span>
														</label>
														<label>
															<input type="radio" class="ace" value="Tidak" data-bind="checked: pil_penelaah, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih7Tidak() }}, enable: child == 0 || pil_penelaah() == 'Tidak'" />
															<span class="lbl"> Tidak</span>
														</label>
													</div>
                          <textarea class="form-control" placeholder="Catatan Penelaah" data-bind="value: cat_penelaah, visible: child == 0, valueUpdate: 'input', event: { input: $root.catatan_sa(7) }" style="font-size: 11px;"></textarea>
												</div>
											</td>										
										</tr>
									</tbody>
								</table>

								<h3 class="header smaller lighter blue">Justifikasi Peneliti (Informed Consent):</h3>
								<div class="form-group">
                  <?php echo isset($sac['justifikasi7']) && strlen(trim($sac['justifikasi7'])) > 0 ? $sac['justifikasi7'] : '<i>null</i>' ?>
								</div>

								<h3 class="header smaller lighter orange">Catatan Penelaah (Informed Consent):</h3>
								<div class="form-group">
                  <?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
                  <button class="btn btn-xs btn-warning" data-bind="click: function(data, event){ telaah_before('Catatan 7 Standar', 'Informed Consent', 'catatan_sa7') }">
                    <i class="ace-icon fa fa-square bigger-110"></i>
                    Catatan Sebelumnya
                  </button>
                  <?php } ?>
									<div class="well" id="catatan7"></div>		
								</div>

							</div>

						</div>
					</div>

					<hr />
					<div class="wizard-actions">
						<button class="btn btn-sm btn-prev">
							<i class="ace-icon fa fa-arrow-left"></i>
							Sebelumnya
						</button>

						<button class="btn btn-sm btn-success btn-next" data-last="Selesai">
							Selanjutnya
							<i class="ace-icon fa fa-arrow-right icon-on-right"></i>
						</button>
					</div>

				</div>

				<div id="kelayakan-tab" class="tab-pane">
          <div class="row">
            <span class="col-sm-12 text-right">
              <button class="btn btn-app btn-light btn-xs" data-bind="click: print_telaah_expedited">
                <i class="ace-icon fa fa-print bigger-160"></i>
                Cetak
              </button>
            </span>
          </div>

          <h3 class="header smaller lighter blue">Kelayakan</h3>
					<div class="form-group">
						<div class="radio">
							<label>
								<input name="kelayakan" type="radio" class="ace" value="LE" data-bind="checked: kelayakan" />
								<span class="lbl"> Layak Etik</span>
							</label>
							<label>
								<input name="kelayakan" type="radio" class="ace" value="R" data-bind="checked: kelayakan" />
								<span class="lbl"> Perbaikan</span>
							</label>
							<label>
								<input name="kelayakan" type="radio" class="ace" value="F" data-bind="checked: kelayakan" />
								<span class="lbl"> Full Board</span>
							</label>
						</div>
					</div>

					<h3 class="header smaller lighter orange">Catatan</h3>
					<div class="row">
            <div class="col-xs-12 col-sm-12 widget-container-col">
              <h5 class="header smaller lighter orange">Catatan Protokol</h5>
              <?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
              <button class="btn btn-xs btn-warning" data-bind="click: function(data, event){ telaah_before('Catatan Protokol', '', 'catatan_protokol') }">
                <i class="ace-icon fa fa-square bigger-110"></i>
                Catatan Sebelumnya
              </button>
              <?php } ?>
              <div class="well" id="catatan_protokol"></div>
            </div>

            <div class="col-xs-12 col-sm-12 widget-container-col">
              <h5 class="header smaller lighter orange">Catatan 7 Standar</h5>
              <?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
              <button class="btn btn-xs btn-warning" data-bind="click: function(data, event){ telaah_before('Catatan 7 Standar', '', 'catatan_7standar') }">
                <i class="ace-icon fa fa-square bigger-110"></i>
                Catatan Sebelumnya
              </button>
              <?php } ?>
              <div class="well" id="catatan_7standar"></div>
            </div>
					</div>

				</div><!-- /.#keputusan -->

			</div>
		</div><!-- /.widget-main -->
	</div><!-- /.widget-body -->
</div><!-- /.widget-box -->

<div class="clearfix form-actions">
	<div class="col-md-offset-3 col-md-9">
		<button class="btn btn-primary" id="submit" type="button" data-loading-text="Proses..." data-bind="click: function(data, event){save(false, data, event) }, enable: is_putusan == 0">
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

<?php if (isset($pep['revisi_ke']) && $pep['revisi_ke'] > 0) { ?>
<div id="my-modal" class="modal fade" tabindex="-1">
	<div class="modal-dialog" style="width: 1000px">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="smaller lighter blue no-margin"><span data-bind="html: title_modal"></span></h3>
			</div>

			<div class="modal-body">
				<div class="row">
					<div class="col-xs-12">
						<i class="ace-icon fa fa-spinner fa-spin orange bigger-125" data-bind="visible: load_data_sebelumnya()"></i>
						<!-- PAGE CONTENT BEGINS -->
						<div class="clearfix">

							<div class="pull-right" data-bind="visible: jumlah_uraian() > 0">
								<span class="green middle bolder">#&nbsp;</span>

								<div class="btn-toolbar inline middle no-margin">
									<div data-toggle="buttons" class="btn-group no-margin" data-bind="foreach: uraian_sebelumnya">
										<label data-bind="attr: {'class': $index()+1 == $root.jumlah_uraian() ? 'btn btn-sm btn-yellow active' : 'btn btn-sm btn-yellow'}">
											<span class="bigger-110" data-bind="text: $index()+1"></span>

											<input type="radio" name="uraian_before_aktif" data-bind="checkedValue: $index()+1, event: {change: function(data, event){$root.showUraian($index()+1)}}" />
										</label>
									</div>
								</div>
							</div>
						</div>

						<div class="hr dotted"></div>

						<div data-bind="foreach: uraian_sebelumnya">
							<div data-bind="attr:{'class': $index()+1 < $root.jumlah_uraian() ? 'hide' : ''}">
								<div data-bind="attr: {'id': $index()+1+'_uraian_before'}" class="uraian_before">
									<p><i class="ace-icon fa fa-calendar"></i> <span data-bind="text: tgl"></span></p>
									<p data-bind="html: uraian.length > 0 ? uraian : '<i>null</i>'"></p>
								</div>
							</div>
						</div>

            <p data-bind="visible: jumlah_uraian() == 0"><em>null</em></p>

						<!-- PAGE CONTENT ENDS -->
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div>

			<div class="modal-footer">
				<button class="btn btn-sm btn-warning pull-right" data-dismiss="modal">
					<i class="ace-icon fa fa-times"></i>
					Tutup
				</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>

<div id="my-modal-telaah" class="modal fade" tabindex="-1">
  <div class="modal-dialog" style="width: 1000px">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="smaller lighter blue no-margin"><u><span data-bind="html: title_modal"></span></u> <i class="ace-icon fa fa-angle-double-right"></i> <span data-bind="html: subtitle_modal"></span></h3>
      </div>

      <div class="modal-body">
        <div class="row">
          <div class="col-xs-12">
            <i class="ace-icon fa fa-spinner fa-spin orange bigger-125" data-bind="visible: load_data_sebelumnya()"></i>
            <!-- PAGE CONTENT BEGINS -->
            <div class="clearfix">

              <div class="pull-right" data-bind="visible: jumlah_telaah() > 0">
                <span class="green middle bolder">#&nbsp;</span>

                <div class="btn-toolbar inline middle no-margin">
                  <div data-toggle="buttons" class="btn-group no-margin" data-bind="foreach: telaah_sebelumnya">
                    <label data-bind="attr: {'class': $index()+1 == $root.jumlah_telaah() ? 'btn btn-sm btn-yellow active' : 'btn btn-sm btn-yellow'}">
                      <span class="bigger-110" data-bind="text: $index()+1"></span>

                      <input type="radio" name="telaah_before_aktif" data-bind="checkedValue: $index()+1, event: {change: function(data, event){$root.showTelaah($index()+1)}}" />
                    </label>
                  </div>
                </div>
              </div>
            </div>

            <div class="hr dotted"></div>

            <div data-bind="foreach: telaah_sebelumnya">
              <div data-bind="attr:{'class': $index()+1 < $root.jumlah_telaah() ? 'hide' : ''}">
                <div data-bind="attr: {'id': $index()+1+'_telaah_before'}" class="telaah_before">
                  <p><i class="ace-icon fa fa-calendar"></i> <span data-bind="text: tgl"></span></p>
                  <p data-bind="html: catatan.length > 0 ? catatan : '<i>null</i>'"></p>
                </div>
              </div>
            </div>

            <p data-bind="visible: jumlah_telaah() == 0"><em>null</em></p>

            <!-- PAGE CONTENT ENDS -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div>

      <div class="modal-footer">
        <button class="btn btn-sm btn-warning pull-right" data-dismiss="modal">
          <i class="ace-icon fa fa-times"></i>
          Tutup
        </button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
<?php } ?>