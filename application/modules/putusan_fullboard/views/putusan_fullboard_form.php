<blockquote>
  <div class="row">
    <div class="col-sm-2">Tanggal Fullboard</div><div class="col-sm-10">: <?php echo isset($fullboard['tgl_fullboard']) ? date('d/m/Y', strtotime($fullboard['tgl_fullboard'])) : '-' ?></div>
  </div>
  <div class="row">
    <div class="col-sm-2">Jam Fullboard</div><div class="col-sm-10">: <?php echo isset($fullboard['jam_fullboard']) ? date('H:i', strtotime($fullboard['jam_fullboard'])) : '-' ?></div>
  </div>
  <div class="row">
    <div class="col-sm-2">Tempat Fullboard</div><div class="col-sm-10">: <?php echo isset($fullboard['tempat_fullboard']) ? $fullboard['tempat_fullboard'] : '-' ?></div>
  </div>
</blockquote>
<div class="widget-box transparent" id="recent-box">
	<div class="widget-header">
		<h4 class="widget-title lighter smaller">
			<?php if (isset($pengajuan['revisi_ke']) && $pengajuan['revisi_ke'] > 0) { ?>
			<i class="ace-icon fa fa-file-o bigger-160 orange"></i>
			<?php } else { ?>
			<i class="ace-icon fa fa-file-o bigger-160 green"></i>
			<?php } ?>
			<strong><?php echo isset($pengajuan['no_protokol']) ? $pengajuan['no_protokol'] : ''?></strong>
		</h4>

		<div class="widget-toolbar no-border">
			<ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="recent-tab">
				<li class="active">
					<a data-toggle="tab" href="#protokol-tab">Protokol</a>
				</li>

				<li>
					<a data-toggle="tab" href="#telaah-tab">Telaah</a>
				</li>

				<li>
					<a data-toggle="tab" href="#kelayakan_keputusan-tab">Kelayakan & Keputusan</a>
				</li>

        <li data-bind="visible: keputusan() == 'LE'">
          <a data-toggle="tab" href="#self_assesment-tab">7 Standar</a>
        </li>
			</ul>
		</div>
	</div>

	<div class="widget-body">
		<div class="widget-main padding-4">
			<div class="tab-content padding-8">

				<div id="protokol-tab" class="tab-pane active">
					<h3 class="header smaller lighter blue">Protokol</h3>
					<dl>
						<dt>Judul</dt>
						<dd><?php echo isset($pengajuan['judul']) ? $pengajuan['judul'] : ''?></dd>
						<div class="hr hr-dotted"></div>
						<dt>Nama Ketua</dt>
						<dd><?php echo isset($pengajuan['nama_ketua']) ? $pengajuan['nama_ketua'] : ''?></dd>
						<div class="hr hr-dotted"></div>
						<dt>Lokasi Penelitian</dt>
						<dd><?php echo isset($pengajuan['tempat_penelitian']) ? $pengajuan['tempat_penelitian'] : ''?></dd>
						<div class="hr hr-dotted"></div>
						<dt>Apakah penelitian ini multi-senter?</dt>
						<dd>
							<?php echo isset($pengajuan['is_multi_senter']) && $pengajuan['is_multi_senter'] == 1 ? 'Ya' : 'Tidak'?>
						</dd>
						<div class="hr hr-dotted"></div>
						<dt>Jika multi-senter apakah sudah mendapatkan persetujuan etik dari senter/institusi yang lain?</dt>
						<dd>
							<?php
							if (isset($pengajuan['is_multi_senter']) && $pengajuan['is_multi_senter'] == 1) {
								echo isset($pengajuan['is_setuju_senter']) && $pengajuan['is_setuju_senter'] == 1 ? 'Ya' : 'Tidak';
							}
							else echo '-';
							?>
						</dd>
						<div class="hr hr-dotted"></div>
					</dl>

          <h3 class="header smaller lighter blue">
            <div class="row">
              <span class="col-sm-12">Catatan Protokol</span>
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
                    <div class="row" data-bind="foreach: telaah_fbd">
                      <div class="col-xs-12 col-sm-12 widget-container-col">
                        <div class="widget-box">
                          <div class="widget-header">
                            <h6 class="widget-title bigger lighter">
                              <i class="ace-icon fa fa-comments bigger-120"></i>
                              <span data-bind="text: no"></span> - <span data-bind="text: nama"></span>
                            </h6>

                            <div class="widget-toolbar">
                              <?php if (isset($pengajuan['revisi_ke']) && $pengajuan['revisi_ke'] > 0) { ?>
                              <button class="btn btn-xs btn-info" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'A. Judul Penelitian (p-protokol no 1)', 'catatana', id, no, nama) }">
                                <i class="ace-icon fa fa-square bigger-110"></i>
                                Catatan Sebelumnya
                              </button>
                              <?php } ?>

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
                              <h5 class="header smaller lighter blue">Catatan Penelaah</h5>
                              <p data-bind="html: cata.length > 0 ? cata : '<i>null</i>'"></p>
                              <div class="hr hr-dotted"></div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="hr hr-dotted"></div>
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
                    <div class="row" data-bind="foreach: telaah_fbd">
                      <div class="col-xs-12 col-sm-12 widget-container-col">
                        <div class="widget-box">
                          <div class="widget-header">
                            <h6 class="widget-title bigger lighter">
                              <i class="ace-icon fa fa-comments bigger-120"></i>
                              <span data-bind="text: no"></span> - <span data-bind="text: nama"></span>
                            </h6>

                            <div class="widget-toolbar">
                              <?php if (isset($pengajuan['revisi_ke']) && $pengajuan['revisi_ke'] > 0) { ?>
                              <button class="btn btn-xs btn-info" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'C. Ringkasan Protokol Penelitian', 'catatanc', id, no, nama) }">
                                <i class="ace-icon fa fa-square bigger-110"></i>
                                Catatan Sebelumnya
                              </button>
                              <?php } ?>

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
                              <h5 class="header smaller lighter blue">Catatan Penelaah</h5>
                              <p data-bind="html: catc.length > 0 ? catc : '<i>null</i>'"></p>
                              <div class="hr hr-dotted"></div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="hr hr-dotted"></div>
                    </div>
                  </div>

                  <div id="d" class="tab-pane">
                    <h4 class="header smaller lighter blue">D. Isu Etik yang mungkin dihadapi</h4>
                    <div class="row" data-bind="foreach: telaah_fbd">
                      <div class="col-xs-12 col-sm-12 widget-container-col">
                        <div class="widget-box">
                          <div class="widget-header">
                            <h6 class="widget-title bigger lighter">
                              <i class="ace-icon fa fa-comments bigger-120"></i>
                              <span data-bind="text: no"></span> - <span data-bind="text: nama"></span>
                            </h6>

                            <div class="widget-toolbar">
                              <?php if (isset($pengajuan['revisi_ke']) && $pengajuan['revisi_ke'] > 0) { ?>
                              <button class="btn btn-xs btn-info" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'D. Isu Etik yang mungkin dihadapi', 'catatand', id, no, nama) }">
                                <i class="ace-icon fa fa-square bigger-110"></i>
                                Catatan Sebelumnya
                              </button>
                              <?php } ?>

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
                              <h5 class="header smaller lighter blue">Catatan Penelaah</h5>
                              <p data-bind="html: catd.length > 0 ? catd : '<i>null</i>'"></p>
                              <div class="hr hr-dotted"></div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="hr hr-dotted"></div>
                    </div>
                  </div>

                  <div id="e" class="tab-pane">
                    <h4 class="header smaller lighter blue">E. Ringkasan Kajian Pustaka</h4>
                    <div class="row" data-bind="foreach: telaah_fbd">
                      <div class="col-xs-12 col-sm-12 widget-container-col">
                        <div class="widget-box">
                          <div class="widget-header">
                            <h6 class="widget-title bigger lighter">
                              <i class="ace-icon fa fa-comments bigger-120"></i>
                              <span data-bind="text: no"></span> - <span data-bind="text: nama"></span>
                            </h6>

                            <div class="widget-toolbar">
                              <?php if (isset($pengajuan['revisi_ke']) && $pengajuan['revisi_ke'] > 0) { ?>
                              <button class="btn btn-xs btn-info" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'E. Ringkasan Kajian Pustaka', 'catatane', id, no, nama) }">
                                <i class="ace-icon fa fa-square bigger-110"></i>
                                Catatan Sebelumnya
                              </button>
                              <?php } ?>

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
                              <h5 class="header smaller lighter blue">Catatan Penelaah</h5>
                              <p data-bind="html: cate.length > 0 ? cate : '<i>null</i>'"></p>
                              <div class="hr hr-dotted"></div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="hr hr-dotted"></div>
                    </div>
                  </div>

                  <div id="f" class="tab-pane">
                    <h4 class="header smaller lighter blue">F. Kondisi Lapangan</h4>
                    <div class="row" data-bind="foreach: telaah_fbd">
                      <div class="col-xs-12 col-sm-12 widget-container-col">
                        <div class="widget-box">
                          <div class="widget-header">
                            <h6 class="widget-title bigger lighter">
                              <i class="ace-icon fa fa-comments bigger-120"></i>
                              <span data-bind="text: no"></span> - <span data-bind="text: nama"></span>
                            </h6>

                            <div class="widget-toolbar">
                              <?php if (isset($pengajuan['revisi_ke']) && $pengajuan['revisi_ke'] > 0) { ?>
                              <button class="btn btn-xs btn-info" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'F. Kondisi Lapangan', 'catatanf', id, no, nama) }">
                                <i class="ace-icon fa fa-square bigger-110"></i>
                                Catatan Sebelumnya
                              </button>
                              <?php } ?>

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
                              <h5 class="header smaller lighter blue">Catatan Penelaah</h5>
                              <p data-bind="html: catf.length > 0 ? catf : '<i>null</i>'"></p>
                              <div class="hr hr-dotted"></div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="hr hr-dotted"></div>
                    </div>
                  </div>

                  <div id="g" class="tab-pane">
                    <h4 class="header smaller lighter blue">G. Disain Penelitian</h4>
                    <div class="row" data-bind="foreach: telaah_fbd">
                      <div class="col-xs-12 col-sm-12 widget-container-col">
                        <div class="widget-box">
                          <div class="widget-header">
                            <h6 class="widget-title bigger lighter">
                              <i class="ace-icon fa fa-comments bigger-120"></i>
                              <span data-bind="text: no"></span> - <span data-bind="text: nama"></span>
                            </h6>

                            <div class="widget-toolbar">
                              <?php if (isset($pengajuan['revisi_ke']) && $pengajuan['revisi_ke'] > 0) { ?>
                              <button class="btn btn-xs btn-info" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'G. Disain Penelitian', 'catatang', id, no, nama) }">
                                <i class="ace-icon fa fa-square bigger-110"></i>
                                Catatan Sebelumnya
                              </button>
                              <?php } ?>

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
                              <h5 class="header smaller lighter blue">Catatan Penelaah</h5>
                              <p data-bind="html: catg.length > 0 ? catg : '<i>null</i>'"></p>
                              <div class="hr hr-dotted"></div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="hr hr-dotted"></div>
                    </div>
                  </div>

                  <div id="h" class="tab-pane">
                    <h4 class="header smaller lighter blue">H. Sampling</h4>
                    <div class="row" data-bind="foreach: telaah_fbd">
                      <div class="col-xs-12 col-sm-12 widget-container-col">
                        <div class="widget-box">
                          <div class="widget-header">
                            <h6 class="widget-title bigger lighter">
                              <i class="ace-icon fa fa-comments bigger-120"></i>
                              <span data-bind="text: no"></span> - <span data-bind="text: nama"></span>
                            </h6>

                            <div class="widget-toolbar">
                              <?php if (isset($pengajuan['revisi_ke']) && $pengajuan['revisi_ke'] > 0) { ?>
                              <button class="btn btn-xs btn-info" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'H. Sampling', 'catatanh', id, no, nama) }">
                                <i class="ace-icon fa fa-square bigger-110"></i>
                                Catatan Sebelumnya
                              </button>
                              <?php } ?>

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
                              <h5 class="header smaller lighter blue">Catatan Penelaah</h5>
                              <p data-bind="html: cath.length > 0 ? cath : '<i>null</i>'"></p>
                              <div class="hr hr-dotted"></div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="hr hr-dotted"></div>
                    </div>
                  </div>

                  <div id="i" class="tab-pane">
                    <h4 class="header smaller lighter blue">I. Intervensi</h4>
                    <div class="row" data-bind="foreach: telaah_fbd">
                      <div class="col-xs-12 col-sm-12 widget-container-col">
                        <div class="widget-box">
                          <div class="widget-header">
                            <h6 class="widget-title bigger lighter">
                              <i class="ace-icon fa fa-comments bigger-120"></i>
                              <span data-bind="text: no"></span> - <span data-bind="text: nama"></span>
                            </h6>

                            <div class="widget-toolbar">
                              <?php if (isset($pengajuan['revisi_ke']) && $pengajuan['revisi_ke'] > 0) { ?>
                              <button class="btn btn-xs btn-info" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'I. Intervensi', 'catatani', id, no, nama) }">
                                <i class="ace-icon fa fa-square bigger-110"></i>
                                Catatan Sebelumnya
                              </button>
                              <?php } ?>

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
                              <h5 class="header smaller lighter blue">Catatan Penelaah</h5>
                              <p data-bind="html: cati.length > 0 ? cati : '<i>null</i>'"></p>
                              <div class="hr hr-dotted"></div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="hr hr-dotted"></div>
                    </div>
                  </div>

                  <div id="j" class="tab-pane">
                    <h4 class="header smaller lighter blue">J. Monitoring Penelitian</h4>
                    <div class="row" data-bind="foreach: telaah_fbd">
                      <div class="col-xs-12 col-sm-12 widget-container-col">
                        <div class="widget-box">
                          <div class="widget-header">
                            <h6 class="widget-title bigger lighter">
                              <i class="ace-icon fa fa-comments bigger-120"></i>
                              <span data-bind="text: no"></span> - <span data-bind="text: nama"></span>
                            </h6>

                            <div class="widget-toolbar">
                              <?php if (isset($pengajuan['revisi_ke']) && $pengajuan['revisi_ke'] > 0) { ?>
                              <button class="btn btn-xs btn-info" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'J. Monitoring Penelitian', 'catatanj', id, no, nama) }">
                                <i class="ace-icon fa fa-square bigger-110"></i>
                                Catatan Sebelumnya
                              </button>
                              <?php } ?>

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
                              <h5 class="header smaller lighter blue">Catatan Penelaah</h5>
                              <p data-bind="html: catj.length > 0 ? catj : '<i>null</i>'"></p>
                              <div class="hr hr-dotted"></div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="hr hr-dotted"></div>
                    </div>
                  </div>

                  <div id="k" class="tab-pane">
                    <h4 class="header smaller lighter blue">K. Penghentian  Penelitian dan Alasannya</h4>
                    <div class="row" data-bind="foreach: telaah_fbd">
                      <div class="col-xs-12 col-sm-12 widget-container-col">
                        <div class="widget-box">
                          <div class="widget-header">
                            <h6 class="widget-title bigger lighter">
                              <i class="ace-icon fa fa-comments bigger-120"></i>
                              <span data-bind="text: no"></span> - <span data-bind="text: nama"></span>
                            </h6>

                            <div class="widget-toolbar">
                              <?php if (isset($pengajuan['revisi_ke']) && $pengajuan['revisi_ke'] > 0) { ?>
                              <button class="btn btn-xs btn-info" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'K. Penghentian  Penelitian dan Alasannya', 'catatank', id, no, nama) }">
                                <i class="ace-icon fa fa-square bigger-110"></i>
                                Catatan Sebelumnya
                              </button>
                              <?php } ?>

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
                              <h5 class="header smaller lighter blue">Catatan Penelaah</h5>
                              <p data-bind="html: catk.length > 0 ? catk : '<i>null</i>'"></p>
                              <div class="hr hr-dotted"></div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="hr hr-dotted"></div>
                    </div>
                  </div>

                  <div id="l" class="tab-pane">
                    <h4 class="header smaller lighter blue">L. Adverse Event dan Komplikasi (Kejadian Yang Tidak Diharapkan)</h4>
                    <div class="row" data-bind="foreach: telaah_fbd">
                      <div class="col-xs-12 col-sm-12 widget-container-col">
                        <div class="widget-box">
                          <div class="widget-header">
                            <h6 class="widget-title bigger lighter">
                              <i class="ace-icon fa fa-comments bigger-120"></i>
                              <span data-bind="text: no"></span> - <span data-bind="text: nama"></span>
                            </h6>

                            <div class="widget-toolbar">
                              <?php if (isset($pengajuan['revisi_ke']) && $pengajuan['revisi_ke'] > 0) { ?>
                              <button class="btn btn-xs btn-info" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'L. Adverse Event dan Komplikasi (Kejadian Yang Tidak Diharapkan)', 'catatanl', id, no, nama) }">
                                <i class="ace-icon fa fa-square bigger-110"></i>
                                Catatan Sebelumnya
                              </button>
                              <?php } ?>

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
                              <h5 class="header smaller lighter blue">Catatan Penelaah</h5>
                              <p data-bind="html: catl.length > 0 ? catl : '<i>null</i>'"></p>
                              <div class="hr hr-dotted"></div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="hr hr-dotted"></div>
                    </div>
                  </div>

                  <div id="m" class="tab-pane">
                    <h4 class="header smaller lighter blue">M. Penanganan Komplikasi <small>(p27)</small></h4>
                    <div class="row" data-bind="foreach: telaah_fbd">
                      <div class="col-xs-12 col-sm-12 widget-container-col">
                        <div class="widget-box">
                          <div class="widget-header">
                            <h6 class="widget-title bigger lighter">
                              <i class="ace-icon fa fa-comments bigger-120"></i>
                              <span data-bind="text: no"></span> - <span data-bind="text: nama"></span>
                            </h6>

                            <div class="widget-toolbar">
                              <?php if (isset($pengajuan['revisi_ke']) && $pengajuan['revisi_ke'] > 0) { ?>
                              <button class="btn btn-xs btn-info" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'M. Penanganan Komplikasi <small>(p27)</small>', 'catatanm', id, no, nama) }">
                                <i class="ace-icon fa fa-square bigger-110"></i>
                                Catatan Sebelumnya
                              </button>
                              <?php } ?>

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
                              <h5 class="header smaller lighter blue">Catatan Penelaah</h5>
                              <p data-bind="html: catm.length > 0 ? catm : '<i>null</i>'"></p>
                              <div class="hr hr-dotted"></div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="hr hr-dotted"></div>
                    </div>
                  </div>

                  <div id="n" class="tab-pane">
                    <h4 class="header smaller lighter blue">N. Manfaat</h4>
                    <div class="row" data-bind="foreach: telaah_fbd">
                      <div class="col-xs-12 col-sm-12 widget-container-col">
                        <div class="widget-box">
                          <div class="widget-header">
                            <h6 class="widget-title bigger lighter">
                              <i class="ace-icon fa fa-comments bigger-120"></i>
                              <span data-bind="text: no"></span> - <span data-bind="text: nama"></span>
                            </h6>

                            <div class="widget-toolbar">
                              <?php if (isset($pengajuan['revisi_ke']) && $pengajuan['revisi_ke'] > 0) { ?>
                              <button class="btn btn-xs btn-info" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'N. Manfaat', 'catatann', id, no, nama) }">
                                <i class="ace-icon fa fa-square bigger-110"></i>
                                Catatan Sebelumnya
                              </button>
                              <?php } ?>

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
                              <h5 class="header smaller lighter blue">Catatan Penelaah</h5>
                              <p data-bind="html: catn.length > 0 ? catn : '<i>null</i>'"></p>
                              <div class="hr hr-dotted"></div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="hr hr-dotted"></div>
                    </div>
                  </div>

                  <div id="o" class="tab-pane">
                    <h4 class="header smaller lighter blue">O. Jaminan Keberlanjutan Manfaat <small><i>(p28)</i></small></h4>
                    <div class="row" data-bind="foreach: telaah_fbd">
                      <div class="col-xs-12 col-sm-12 widget-container-col">
                        <div class="widget-box">
                          <div class="widget-header">
                            <h6 class="widget-title bigger lighter">
                              <i class="ace-icon fa fa-comments bigger-120"></i>
                              <span data-bind="text: no"></span> - <span data-bind="text: nama"></span>
                            </h6>

                            <div class="widget-toolbar">
                              <?php if (isset($pengajuan['revisi_ke']) && $pengajuan['revisi_ke'] > 0) { ?>
                              <button class="btn btn-xs btn-info" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'O. Jaminan Keberlanjutan Manfaat <small><i>(p28)</i></small>', 'catatano', id, no, nama) }">
                                <i class="ace-icon fa fa-square bigger-110"></i>
                                Catatan Sebelumnya
                              </button>
                              <?php } ?>

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
                              <h5 class="header smaller lighter blue">Catatan Penelaah</h5>
                              <p data-bind="html: cato.length > 0 ? cato : '<i>null</i>'"></p>
                              <div class="hr hr-dotted"></div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="hr hr-dotted"></div>
                    </div>
                  </div>

                  <div id="p" class="tab-pane">
                    <h4 class="header smaller lighter blue">P. Informed Consent <small><i>(Upload IC 35 butir di Tab CC)</i></small></h4>
                    <div class="row" data-bind="foreach: telaah_fbd">
                      <div class="col-xs-12 col-sm-12 widget-container-col">
                        <div class="widget-box">
                          <div class="widget-header">
                            <h6 class="widget-title bigger lighter">
                              <i class="ace-icon fa fa-comments bigger-120"></i>
                              <span data-bind="text: no"></span> - <span data-bind="text: nama"></span>
                            </h6>

                            <div class="widget-toolbar">
                              <?php if (isset($pengajuan['revisi_ke']) && $pengajuan['revisi_ke'] > 0) { ?>
                              <button class="btn btn-xs btn-info" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'P. Informed Consent <small><i>(Upload IC 35 butir di Tab CC)</i></small>', 'catatanp', id, no, nama) }">
                                <i class="ace-icon fa fa-square bigger-110"></i>
                                Catatan Sebelumnya
                              </button>
                              <?php } ?>

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
                              <h5 class="header smaller lighter blue">Catatan Penelaah</h5>
                              <p data-bind="html: catp.length > 0 ? catp : '<i>null</i>'"></p>
                              <div class="hr hr-dotted"></div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="hr hr-dotted"></div>
                    </div>
                  </div>

                  <div id="q" class="tab-pane">
                    <h4 class="header smaller lighter blue">Q. Wali <small><i>(p31)</i></small></h4>
                    <div class="row" data-bind="foreach: telaah_fbd">
                      <div class="col-xs-12 col-sm-12 widget-container-col">
                        <div class="widget-box">
                          <div class="widget-header">
                            <h6 class="widget-title bigger lighter">
                              <i class="ace-icon fa fa-comments bigger-120"></i>
                              <span data-bind="text: no"></span> - <span data-bind="text: nama"></span>
                            </h6>

                            <div class="widget-toolbar">
                              <?php if (isset($pengajuan['revisi_ke']) && $pengajuan['revisi_ke'] > 0) { ?>
                              <button class="btn btn-xs btn-info" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'Q. Wali <small><i>(p31)</i></small>', 'catatanq', id, no, nama) }">
                                <i class="ace-icon fa fa-square bigger-110"></i>
                                Catatan Sebelumnya
                              </button>
                              <?php } ?>

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
                              <h5 class="header smaller lighter blue">Catatan Penelaah</h5>
                              <p data-bind="html: catq.length > 0 ? catq : '<i>null</i>'"></p>
                              <div class="hr hr-dotted"></div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="hr hr-dotted"></div>
                    </div>
                  </div>

                  <div id="r" class="tab-pane">
                    <h4 class="header smaller lighter blue">R. Bujukan</h4>
                    <div class="row" data-bind="foreach: telaah_fbd">
                      <div class="col-xs-12 col-sm-12 widget-container-col">
                        <div class="widget-box">
                          <div class="widget-header">
                            <h6 class="widget-title bigger lighter">
                              <i class="ace-icon fa fa-comments bigger-120"></i>
                              <span data-bind="text: no"></span> - <span data-bind="text: nama"></span>
                            </h6>

                            <div class="widget-toolbar">
                              <?php if (isset($pengajuan['revisi_ke']) && $pengajuan['revisi_ke'] > 0) { ?>
                              <button class="btn btn-xs btn-info" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'R. Bujukan', 'catatanr', id, no, nama) }">
                                <i class="ace-icon fa fa-square bigger-110"></i>
                                Catatan Sebelumnya
                              </button>
                              <?php } ?>

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
                              <h5 class="header smaller lighter blue">Catatan Penelaah</h5>
                              <p data-bind="html: catr.length > 0 ? catr : '<i>null</i>'"></p>
                              <div class="hr hr-dotted"></div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="hr hr-dotted"></div>
                    </div>
                  </div>

                  <div id="s" class="tab-pane">
                    <h4 class="header smaller lighter blue">S. Penjagaan Kerahasiaan</h4>
                    <div class="row" data-bind="foreach: telaah_fbd">
                      <div class="col-xs-12 col-sm-12 widget-container-col">
                        <div class="widget-box">
                          <div class="widget-header">
                            <h6 class="widget-title bigger lighter">
                              <i class="ace-icon fa fa-comments bigger-120"></i>
                              <span data-bind="text: no"></span> - <span data-bind="text: nama"></span>
                            </h6>

                            <div class="widget-toolbar">
                              <?php if (isset($pengajuan['revisi_ke']) && $pengajuan['revisi_ke'] > 0) { ?>
                              <button class="btn btn-xs btn-info" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'S. Penjagaan Kerahasiaan', 'catatans', id, no, nama) }">
                                <i class="ace-icon fa fa-square bigger-110"></i>
                                Catatan Sebelumnya
                              </button>
                              <?php } ?>

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
                              <h5 class="header smaller lighter blue">Catatan Penelaah</h5>
                              <p data-bind="html: cats.length > 0 ? cats : '<i>null</i>'"></p>
                              <div class="hr hr-dotted"></div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="hr hr-dotted"></div>
                    </div>
                  </div>

                  <div id="t" class="tab-pane">
                    <h4 class="header smaller lighter blue">T. Rencana Analisis</h4>
                    <div class="row" data-bind="foreach: telaah_fbd">
                      <div class="col-xs-12 col-sm-12 widget-container-col">
                        <div class="widget-box">
                          <div class="widget-header">
                            <h6 class="widget-title bigger lighter">
                              <i class="ace-icon fa fa-comments bigger-120"></i>
                              <span data-bind="text: no"></span> - <span data-bind="text: nama"></span>
                            </h6>

                            <div class="widget-toolbar">
                              <?php if (isset($pengajuan['revisi_ke']) && $pengajuan['revisi_ke'] > 0) { ?>
                              <button class="btn btn-xs btn-info" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'T. Rencana Analisis', 'catatant', id, no, nama) }">
                                <i class="ace-icon fa fa-square bigger-110"></i>
                                Catatan Sebelumnya
                              </button>
                              <?php } ?>

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
                              <h5 class="header smaller lighter blue">Catatan Penelaah</h5>
                              <p data-bind="html: catt.length > 0 ? catt : '<i>null</i>'"></p>
                              <div class="hr hr-dotted"></div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="hr hr-dotted"></div>
                    </div>
                  </div>

                  <div id="u" class="tab-pane">
                    <h4 class="header smaller lighter blue">U. Monitor Keamanan</h4>
                    <div class="row" data-bind="foreach: telaah_fbd">
                      <div class="col-xs-12 col-sm-12 widget-container-col">
                        <div class="widget-box">
                          <div class="widget-header">
                            <h6 class="widget-title bigger lighter">
                              <i class="ace-icon fa fa-comments bigger-120"></i>
                              <span data-bind="text: no"></span> - <span data-bind="text: nama"></span>
                            </h6>

                            <div class="widget-toolbar">
                              <?php if (isset($pengajuan['revisi_ke']) && $pengajuan['revisi_ke'] > 0) { ?>
                              <button class="btn btn-xs btn-info" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'U. Monitor Keamanan', 'catatanu', id, no, nama) }">
                                <i class="ace-icon fa fa-square bigger-110"></i>
                                Catatan Sebelumnya
                              </button>
                              <?php } ?>

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
                              <h5 class="header smaller lighter blue">Catatan Penelaah</h5>
                              <p data-bind="html: catu.length > 0 ? catu : '<i>null</i>'"></p>
                              <div class="hr hr-dotted"></div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="hr hr-dotted"></div>
                    </div>
                  </div>

                  <div id="v" class="tab-pane">
                    <h4 class="header smaller lighter blue">V. Konflik Kepentingan</h4>
                    <div class="row" data-bind="foreach: telaah_fbd">
                      <div class="col-xs-12 col-sm-12 widget-container-col">
                        <div class="widget-box">
                          <div class="widget-header">
                            <h6 class="widget-title bigger lighter">
                              <i class="ace-icon fa fa-comments bigger-120"></i>
                              <span data-bind="text: no"></span> - <span data-bind="text: nama"></span>
                            </h6>

                            <div class="widget-toolbar">
                              <?php if (isset($pengajuan['revisi_ke']) && $pengajuan['revisi_ke'] > 0) { ?>
                              <button class="btn btn-xs btn-info" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'V. Konflik Kepentingan', 'catatanv', id, no, nama) }">
                                <i class="ace-icon fa fa-square bigger-110"></i>
                                Catatan Sebelumnya
                              </button>
                              <?php } ?>

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
                              <h5 class="header smaller lighter blue">Catatan Penelaah</h5>
                              <p data-bind="html: catv.length > 0 ? catv : '<i>null</i>'"></p>
                              <div class="hr hr-dotted"></div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="hr hr-dotted"></div>
                    </div>
                  </div>

                  <div id="w" class="tab-pane">
                    <h4 class="header smaller lighter blue">W. Manfaat Sosial</h4>
                    <div class="row" data-bind="foreach: telaah_fbd">
                      <div class="col-xs-12 col-sm-12 widget-container-col">
                        <div class="widget-box">
                          <div class="widget-header">
                            <h6 class="widget-title bigger lighter">
                              <i class="ace-icon fa fa-comments bigger-120"></i>
                              <span data-bind="text: no"></span> - <span data-bind="text: nama"></span>
                            </h6>

                            <div class="widget-toolbar">
                              <?php if (isset($pengajuan['revisi_ke']) && $pengajuan['revisi_ke'] > 0) { ?>
                              <button class="btn btn-xs btn-info" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'W. Manfaat Sosial', 'catatanw', id, no, nama) }">
                                <i class="ace-icon fa fa-square bigger-110"></i>
                                Catatan Sebelumnya
                              </button>
                              <?php } ?>

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
                              <h5 class="header smaller lighter blue">Catatan Penelaah</h5>
                              <p data-bind="html: catw.length > 0 ? catw : '<i>null</i>'"></p>
                              <div class="hr hr-dotted"></div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="hr hr-dotted"></div>
                    </div>
                  </div>

                  <div id="x" class="tab-pane">
                    <h4 class="header smaller lighter blue">X. Hak atas Data</h4>
                    <div class="row" data-bind="foreach: telaah_fbd">
                      <div class="col-xs-12 col-sm-12 widget-container-col">
                        <div class="widget-box">
                          <div class="widget-header">
                            <h6 class="widget-title bigger lighter">
                              <i class="ace-icon fa fa-comments bigger-120"></i>
                              <span data-bind="text: no"></span> - <span data-bind="text: nama"></span>
                            </h6>

                            <div class="widget-toolbar">
                              <?php if (isset($pengajuan['revisi_ke']) && $pengajuan['revisi_ke'] > 0) { ?>
                              <button class="btn btn-xs btn-info" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'X. Hak atas Data', 'catatanx', id, no, nama) }">
                                <i class="ace-icon fa fa-square bigger-110"></i>
                                Catatan Sebelumnya
                              </button>
                              <?php } ?>

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
                              <h5 class="header smaller lighter blue">Catatan Penelaah</h5>
                              <p data-bind="html: catx.length > 0 ? catx : '<i>null</i>'"></p>
                              <div class="hr hr-dotted"></div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="hr hr-dotted"></div>
                    </div>
                  </div>

                  <div id="y" class="tab-pane">
                    <h4 class="header smaller lighter blue">Y. Publikasi</h4>
                    <div class="row" data-bind="foreach: telaah_fbd">
                      <div class="col-xs-12 col-sm-12 widget-container-col">
                        <div class="widget-box">
                          <div class="widget-header">
                            <h6 class="widget-title bigger lighter">
                              <i class="ace-icon fa fa-comments bigger-120"></i>
                              <span data-bind="text: no"></span> - <span data-bind="text: nama"></span>
                            </h6>

                            <div class="widget-toolbar">
                              <?php if (isset($pengajuan['revisi_ke']) && $pengajuan['revisi_ke'] > 0) { ?>
                              <button class="btn btn-xs btn-info" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'Y. Publikasi', 'catatany', id, no, nama) }">
                                <i class="ace-icon fa fa-square bigger-110"></i>
                                Catatan Sebelumnya
                              </button>
                              <?php } ?>

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
                              <h5 class="header smaller lighter blue">Catatan Penelaah</h5>
                              <p data-bind="html: caty.length > 0 ? caty : '<i>null</i>'"></p>
                              <div class="hr hr-dotted"></div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="hr hr-dotted"></div>
                    </div>
                  </div>

                  <div id="z" class="tab-pane">
                    <h4 class="header smaller lighter blue">Z. Pendanaan</h4>
                    <div class="row" data-bind="foreach: telaah_fbd">
                      <div class="col-xs-12 col-sm-12 widget-container-col">
                        <div class="widget-box">
                          <div class="widget-header">
                            <h6 class="widget-title bigger lighter">
                              <i class="ace-icon fa fa-comments bigger-120"></i>
                              <span data-bind="text: no"></span> - <span data-bind="text: nama"></span>
                            </h6>

                            <div class="widget-toolbar">
                              <?php if (isset($pengajuan['revisi_ke']) && $pengajuan['revisi_ke'] > 0) { ?>
                              <button class="btn btn-xs btn-info" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'Z. Pendanaan', 'catatanz', id, no, nama) }">
                                <i class="ace-icon fa fa-square bigger-110"></i>
                                Catatan Sebelumnya
                              </button>
                              <?php } ?>

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
                              <h5 class="header smaller lighter blue">Catatan Penelaah</h5>
                              <p data-bind="html: catz.length > 0 ? catz : '<i>null</i>'"></p>
                              <div class="hr hr-dotted"></div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="hr hr-dotted"></div>
                    </div>
                  </div>

                  <div id="aa" class="tab-pane">
                    <h4 class="header smaller lighter blue">AA. Komitmen Etik</h4>
                    <div class="row" data-bind="foreach: telaah_fbd">
                      <div class="col-xs-12 col-sm-12 widget-container-col">
                        <div class="widget-box">
                          <div class="widget-header">
                            <h6 class="widget-title bigger lighter">
                              <i class="ace-icon fa fa-comments bigger-120"></i>
                              <span data-bind="text: no"></span> - <span data-bind="text: nama"></span>
                            </h6>

                            <div class="widget-toolbar">
                              <?php if (isset($pengajuan['revisi_ke']) && $pengajuan['revisi_ke'] > 0) { ?>
                              <button class="btn btn-xs btn-info" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'AA. Komitmen Etik', 'catatanaa', id, no, nama) }">
                                <i class="ace-icon fa fa-square bigger-110"></i>
                                Catatan Sebelumnya
                              </button>
                              <?php } ?>

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
                              <h5 class="header smaller lighter blue">Catatan Penelaah</h5>
                              <p data-bind="html: cataa.length > 0 ? cataa : '<i>null</i>'"></p>
                              <div class="hr hr-dotted"></div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="hr hr-dotted"></div>
                    </div>
                  </div>

                  <div id="bb" class="tab-pane">
                    <h4 class="header smaller lighter blue">BB. Daftar Pustaka</h4>
                    <div class="row" data-bind="foreach: telaah_fbd">
                      <div class="col-xs-12 col-sm-12 widget-container-col">
                        <div class="widget-box">
                          <div class="widget-header">
                            <h6 class="widget-title bigger lighter">
                              <i class="ace-icon fa fa-comments bigger-120"></i>
                              <span data-bind="text: no"></span> - <span data-bind="text: nama"></span>
                            </h6>

                            <div class="widget-toolbar">
                              <?php if (isset($pengajuan['revisi_ke']) && $pengajuan['revisi_ke'] > 0) { ?>
                              <button class="btn btn-xs btn-info" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'BB. Daftar Pustaka', 'catatanbb', id, no, nama) }">
                                <i class="ace-icon fa fa-square bigger-110"></i>
                                Catatan Sebelumnya
                              </button>
                              <?php } ?>

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
                              <h5 class="header smaller lighter blue">Catatan Penelaah</h5>
                              <p data-bind="html: catbb.length > 0 ? catbb : '<i>null</i>'"></p>
                              <div class="hr hr-dotted"></div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="hr hr-dotted"></div>
                    </div>
                  </div>

                  <div id="cc" class="tab-pane">
                    <h4 class="header smaller lighter blue">CC. Lampiran</h4>
                    <div class="row" data-bind="foreach: telaah_fbd">
                      <div class="col-xs-12 col-sm-12 widget-container-col">
                        <div class="widget-box">
                          <div class="widget-header">
                            <h6 class="widget-title bigger lighter">
                              <i class="ace-icon fa fa-comments bigger-120"></i>
                              <span data-bind="text: no"></span> - <span data-bind="text: nama"></span>
                            </h6>

                            <div class="widget-toolbar">
                              <?php if (isset($pengajuan['revisi_ke']) && $pengajuan['revisi_ke'] > 0) { ?>
                              <button class="btn btn-xs btn-info" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'CC. Lampiran', 'catatancc', id, no, nama) }">
                                <i class="ace-icon fa fa-square bigger-110"></i>
                                Catatan Sebelumnya
                              </button>
                              <?php } ?>

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
                              <h5 class="header smaller lighter blue">Catatan Penelaah</h5>
                              <p data-bind="html: catcc.length > 0 ? catcc : '<i>null</i>'"></p>
                              <div class="hr hr-dotted"></div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="hr hr-dotted"></div>
                    </div>
                  </div>

                  <div id="link" class="tab-pane">
                    <h4 class="header smaller lighter blue">Link Google Drive Proposal</h4>
                    <div class="row" data-bind="foreach: telaah_fbd">
                      <div class="col-xs-12 col-sm-12 widget-container-col">
                        <div class="widget-box">
                          <div class="widget-header">
                            <h6 class="widget-title bigger lighter">
                              <i class="ace-icon fa fa-comments bigger-120"></i>
                              <span data-bind="text: no"></span> - <span data-bind="text: nama"></span>
                            </h6>

                            <div class="widget-toolbar">
                              <?php if (isset($pengajuan['revisi_ke']) && $pengajuan['revisi_ke'] > 0) { ?>
                              <button class="btn btn-xs btn-info" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'Link Google Drive Proposal', 'catatan_link_proposal', id, no, nama) }">
                                <i class="ace-icon fa fa-square bigger-110"></i>
                                Catatan Sebelumnya
                              </button>
                              <?php } ?>

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
                              <h5 class="header smaller lighter blue">Catatan Penelaah</h5>
                              <p data-bind="html: catlink.length > 0 ? catlink : '<i>null</i>'"></p>
                              <div class="hr hr-dotted"></div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="hr hr-dotted"></div>
                    </div>
                  </div>

                </div>
              </div>
            </div><!-- /.col -->
          </div>
				</div>

				<div id="telaah-tab" class="tab-pane">
					<div class="widget-box transparent">
						<div class="widget-header">
							<div class="widget-toolbar no-border">
								<ul class="nav nav-tabs background-blue" id="recent-tab">
									<li class="active">
										<a data-toggle="tab" href="#satu-tab">Nilai Sosial/Klinis</a>
									</li>

									<li>
										<a data-toggle="tab" href="#dua-tab">Nilai Ilmiah</a>
									</li>

									<li>
										<a data-toggle="tab" href="#tiga-tab">Pemerataan Beban dan Manfaat</a>
									</li>

									<li>
										<a data-toggle="tab" href="#empat-tab">Potensi Manfaat dan Resiko</a>
									</li>

									<li>
										<a data-toggle="tab" href="#lima-tab">Bujukan/ Eksploitasi/ Iducement</a>
									</li>

									<li>
										<a data-toggle="tab" href="#enam-tab">Rahasia dan Privacy</a>
									</li>

									<li>
										<a data-toggle="tab" href="#tujuh-tab">Informed Consent</a>
									</li>
								</ul>
							</div>
						</div>

						<div class="widget-body">
							<div class="tab-content">
								<div id="satu-tab" class="tab-pane active">
									<h5 class="header smaller lighter blue">1. Nilai Sosial/Klinis</h5>
									<div class="row" data-bind="foreach: telaah_fbd">
										<div class="col-xs-12 col-sm-12 widget-container-col">
											<div class="widget-box">
												<div class="widget-header">
													<h6 class="widget-title bigger lighter">
														<i class="ace-icon fa fa-comments bigger-120"></i>
														<span data-bind="text: no"></span> - <span data-bind="text: nama"></span>
													</h6>

													<div class="widget-toolbar">
                            <?php if (isset($pengajuan['revisi_ke']) && $pengajuan['revisi_ke'] > 0) { ?>
                            <button class="btn btn-xs btn-info" data-bind="click: function(data, event){ $root.telaah_before('Catatan 7 Standar', '1. Nilai Sosial/Klinis', 'catatan_sa1', id, no, nama) }">
                              <i class="ace-icon fa fa-square bigger-110"></i>
                              Catatan Sebelumnya
                            </button>
                            <?php } ?>

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
														<h5 class="header smaller lighter blue">Catatan Penelaah (Nilai Sosial/Klinis)</h5>
														<p data-bind="html: cat1.length > 0 ? cat1 : '<i>null</i>'"></p>
														<div class="hr hr-dotted"></div>
													</div>
												</div>
											</div>
										</div>

										<div class="hr hr-dotted"></div>
									</div>
								</div>

								<div id="dua-tab" class="tab-pane">
									<h5 class="header smaller lighter blue">2. Nilai Ilmiah</h5>
									<div class="row" data-bind="foreach: telaah_fbd">
										<div class="col-xs-12 col-sm-12 widget-container-col">
											<div class="widget-box">
												<div class="widget-header">
													<h6 class="widget-title bigger lighter">
														<i class="ace-icon fa fa-comments bigger-120"></i>
														<span data-bind="text: no"></span> - <span data-bind="text: nama"></span>
													</h6>

													<div class="widget-toolbar">
                            <?php if (isset($pengajuan['revisi_ke']) && $pengajuan['revisi_ke'] > 0) { ?>
                            <button class="btn btn-xs btn-info" data-bind="click: function(data, event){ $root.telaah_before('Catatan 7 Standar', '2. Nilai Ilmiah', 'catatan_sa2', id, no, nama) }">
                              <i class="ace-icon fa fa-square bigger-110"></i>
                              Catatan Sebelumnya
                            </button>
                            <?php } ?>

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
														<h5 class="header smaller lighter blue">Catatan Penelaah (Nilai Ilmiah)</h5>
														<p data-bind="html: cat2.length > 0 ? cat2 : '<i>null</i>'"></p>
														<div class="hr hr-dotted"></div>
													</div>
												</div>
											</div>
										</div>

										<div class="hr hr-dotted"></div>
									</div>
								</div>

								<div id="tiga-tab" class="tab-pane">
									<h5 class="header smaller lighter blue">3. Pemerataan Beban dan Manfaat</h5>
									<div class="row" data-bind="foreach: telaah_fbd">
										<div class="col-xs-12 col-sm-12 widget-container-col">
											<div class="widget-box">
												<div class="widget-header">
													<h6 class="widget-title bigger lighter">
														<i class="ace-icon fa fa-comments bigger-120"></i>
														<span data-bind="text: no"></span> - <span data-bind="text: nama"></span>
													</h6>

													<div class="widget-toolbar">
                            <?php if (isset($pengajuan['revisi_ke']) && $pengajuan['revisi_ke'] > 0) { ?>
                            <button class="btn btn-xs btn-info" data-bind="click: function(data, event){ $root.telaah_before('Catatan 7 Standar', '3. Pemerataan Beban dan Manfaat', 'catatan_sa3', id, no, nama) }">
                              <i class="ace-icon fa fa-square bigger-110"></i>
                              Catatan Sebelumnya
                            </button>
                            <?php } ?>

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
														<h5 class="header smaller lighter blue">Catatan Penelaah (Pemerataan Beban dan Manfaat)</h5>
														<p data-bind="html: cat3.length > 0 ? cat3 : '<i>null</i>'"></p>
														<div class="hr hr-dotted"></div>
													</div>
												</div>
											</div>
										</div>

										<div class="hr hr-dotted"></div>
									</div>
								</div>

								<div id="empat-tab" class="tab-pane">
									<h5 class="header smaller lighter blue">4. Potensi Manfaat dan Resiko</h5>
									<div class="row" data-bind="foreach: telaah_fbd">
										<div class="col-xs-12 col-sm-12 widget-container-col">
											<div class="widget-box">
												<div class="widget-header">
													<h6 class="widget-title bigger lighter">
														<i class="ace-icon fa fa-comments bigger-120"></i>
														<span data-bind="text: no"></span> - <span data-bind="text: nama"></span>
													</h6>

													<div class="widget-toolbar">
                            <?php if (isset($pengajuan['revisi_ke']) && $pengajuan['revisi_ke'] > 0) { ?>
                            <button class="btn btn-xs btn-info" data-bind="click: function(data, event){ $root.telaah_before('Catatan 7 Standar', '4. Potensi Manfaat dan Resiko', 'catatan_sa4', id, no, nama) }">
                              <i class="ace-icon fa fa-square bigger-110"></i>
                              Catatan Sebelumnya
                            </button>
                            <?php } ?>

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
														<h5 class="header smaller lighter blue">Catatan Penelaah (Potensi Manfaat dan Resiko)</h5>
														<p data-bind="html: cat4.length > 0 ? cat4 : '<i>null</i>'"></p>
														<div class="hr hr-dotted"></div>
													</div>
												</div>
											</div>
										</div>

										<div class="hr hr-dotted"></div>
									</div>
								</div>

								<div id="lima-tab" class="tab-pane">
									<h5 class="header smaller lighter blue">5. Bujukan/ Eksploitasi/ Iducement</h5>
									<div class="row" data-bind="foreach: telaah_fbd">
										<div class="col-xs-12 col-sm-12 widget-container-col">
											<div class="widget-box">
												<div class="widget-header">
													<h6 class="widget-title bigger lighter">
														<i class="ace-icon fa fa-comments bigger-120"></i>
														<span data-bind="text: no"></span> - <span data-bind="text: nama"></span>
													</h6>

													<div class="widget-toolbar">
                            <?php if (isset($pengajuan['revisi_ke']) && $pengajuan['revisi_ke'] > 0) { ?>
                            <button class="btn btn-xs btn-info" data-bind="click: function(data, event){ $root.telaah_before('Catatan 7 Standar', '5. Bujukan/ Eksploitasi/ Iducement', 'catatan_sa5', id, no, nama) }">
                              <i class="ace-icon fa fa-square bigger-110"></i>
                              Catatan Sebelumnya
                            </button>
                            <?php } ?>

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
														<h5 class="header smaller lighter blue">Catatan Penelaah (Bujukan/ Eksploitasi/ Iducement)</h5>
														<p data-bind="html: cat5.length > 0 ? cat5 : '<i>null</i>'"></p>
														<div class="hr hr-dotted"></div>
													</div>
												</div>
											</div>
										</div>

										<div class="hr hr-dotted"></div>
									</div>
								</div>

								<div id="enam-tab" class="tab-pane">
									<h5 class="header smaller lighter blue">6. Rahasia dan Privacy</h5>
									<div class="row" data-bind="foreach: telaah_fbd">
										<div class="col-xs-12 col-sm-12 widget-container-col">
											<div class="widget-box">
												<div class="widget-header">
													<h6 class="widget-title bigger lighter">
														<i class="ace-icon fa fa-comments bigger-120"></i>
														<span data-bind="text: no"></span> - <span data-bind="text: nama"></span>
													</h6>

													<div class="widget-toolbar">
                            <?php if (isset($pengajuan['revisi_ke']) && $pengajuan['revisi_ke'] > 0) { ?>
                            <button class="btn btn-xs btn-info" data-bind="click: function(data, event){ $root.telaah_before('Catatan 7 Standar', '6. Rahasia dan Privacy', 'catatan_sa6', id, no, nama) }">
                              <i class="ace-icon fa fa-square bigger-110"></i>
                              Catatan Sebelumnya
                            </button>
                            <?php } ?>

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
														<h5 class="header smaller lighter blue">Catatan Penelaah (Rahasia dan Privacy)</h5>
														<p data-bind="html: cat6.length > 0 ? cat6 : '<i>null</i>'"></p>
														<div class="hr hr-dotted"></div>
													</div>
												</div>
											</div>
										</div>

										<div class="hr hr-dotted"></div>
									</div>
								</div>

								<div id="tujuh-tab" class="tab-pane">
									<h5 class="header smaller lighter blue">7. Informed Consent</h5>
									<div class="row" data-bind="foreach: telaah_fbd">
										<div class="col-xs-12 col-sm-12 widget-container-col">
											<div class="widget-box">
												<div class="widget-header">
													<h6 class="widget-title bigger lighter">
														<i class="ace-icon fa fa-comments bigger-120"></i>
														<span data-bind="text: no"></span> - <span data-bind="text: nama"></span>
													</h6>

													<div class="widget-toolbar">
                            <?php if (isset($pengajuan['revisi_ke']) && $pengajuan['revisi_ke'] > 0) { ?>
                            <button class="btn btn-xs btn-info" data-bind="click: function(data, event){ $root.telaah_before('Catatan 7 Standar', '7. Informed Consent', 'catatan_sa7', id, no, nama) }">
                              <i class="ace-icon fa fa-square bigger-110"></i>
                              Catatan Sebelumnya
                            </button>
                            <?php } ?>

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
														<h5 class="header smaller lighter blue">Catatan Penelaah (Informed Consent)</h5>
														<p data-bind="html: cat7.length > 0 ? cat7 : '<i>null</i>'"></p>
														<div class="hr hr-dotted"></div>
													</div>
												</div>
											</div>
										</div>

										<div class="hr hr-dotted"></div>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>

				<div id="kelayakan_keputusan-tab" class="tab-pane">
					<h3 class="header smaller lighter blue">Kelayakan</h3>
					<div class="row" data-bind="foreach: telaah_fbd">
						<div class="col-xs-12 col-sm-12 widget-container-col">
							<div class="widget-box">
								<div class="widget-header">
									<h6 class="widget-title bigger lighter">
										<i class="ace-icon fa fa-flag bigger-120"></i>
										<span data-bind="text: no"></span> - <span data-bind="text: nama"></span>
									</h6>

									<div class="widget-toolbar">
                    <?php if (isset($pengajuan['revisi_ke']) && $pengajuan['revisi_ke'] > 0) { ?>
                    <button class="btn btn-xs btn-info" data-bind="click: function(data, event){ $root.kelayakan_before('Kelayakan', '', 'catatana', id, no, nama) }">
                      <i class="ace-icon fa fa-square bigger-110"></i>
                      Kelayakan Sebelumnya
                    </button>
                    <?php } ?>

                    <a href="#" data-bind="click: function(data, event){$root.print_telaah_fullboard(id, data, event) }">
                      <i class="ace-icon fa fa-print"></i>
                    </a>

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
										<div class="radio">
											<label>
												<input type="radio" class="ace" value="LE" data-bind="checked: kelayakan, attr:{'name': $index().$data}, enable: kelayakan == 'LE'" />
												<span class="lbl"> Layak Etik</span>
											</label>
											<label>
												<input type="radio" class="ace" value="R" data-bind="checked: kelayakan, attr:{'name': $index().$data}, enable: kelayakan == 'R'" />
												<span class="lbl"> Perbaikan</span>
											</label>
										</div>
                    <h5 class="header smaller lighter blue">Catatan Protokol</h5>
                    <p data-bind="html: catprotokol.length > 0 ? catprotokol : '<i>null</i>'"></p>
                    <h5 class="header smaller lighter blue">Catatan 7 Standar</h5>
                    <p data-bind="html: cat7standar.length > 0 ? cat7standar : '<i>null</i>'"></p>
									</div>
								</div>
							</div>
						</div>

						<div class="hr hr-dotted"></div>
					</div>

					<h3 class="header smaller lighter blue">Ringkasan Putusan Telaah Fullboard</h3>
					<div class="form-group">
						<div class="wysiwyg-editor" id="ringkasan"></div>
					</div>

					<h3 class="header smaller lighter blue">Keputusan</h3>
					<div class="row">
						<div class="radio">
							<label>
								<input name="keputusan" type="radio" class="ace" value="LE" data-bind="checked: keputusan" />
								<span class="lbl"> Layak Etik</span>
							</label>
							<label>
								<input name="keputusan" type="radio" class="ace" value="R" data-bind="checked: keputusan" />
								<span class="lbl"> Perbaikan</span>
							</label>
						</div>
            <div class="alert alert-block alert-info" data-bind="visible: keputusan() == 'LE'">
              <button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>
              <i class="ace-icon fa fa-info-circle blue"></i>
              Keputusan Layak Etik.  <a href="#" data-bind="click: show7standar"><i class="ace-icon fa fa-hand-o-right icon-animated-hand-pointer blue"></i> Isi 7 Standar</a>
            </div>
          </div>

				</div><!-- /.#kelayakan&keputusan -->

        <div id="self_assesment-tab" class="tab-pane">
          <div class="alert alert-info" data-bind="visible: id() == 0">
            <button type="button" class="close" data-dismiss="alert">
              <i class="ace-icon fa fa-times"></i>
            </button>
            Pilihan Penelaah beberapa item/poin <strong>7-Standar Kelainan Etik Penelitian</strong> secara default terisi "Ya"
          </div>

          <h3 class="header smaller lighter blue">
            Self Assesment

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
                <?php if ($this->session->userdata('id_group_'.APPAUTH) == 6) { ?>
                <div class="form-group pull-right">
                  <button class="btn btn-sm" id="reset1" data-bind="click: reset1">
                    <i class="ace-icon fa fa-circle bigger-110"></i>
                    Kosongkan
                  </button>
                </div>
                <?php } ?>

                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th width="5%">No</th>
                      <th width="75%">7-STANDAR KELAIKAN ETIK PENELITIAN</th>
                      <th width="10%">PENELITI</th>
                      <th width="10%">PENELAAH</th>
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
                              <input type="radio" class="ace" value="Ya" data-bind="checked: pil_pelapor, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih1Ya($index(), parent) }}, enable: $root.id_group == 6 ? child == 0 || pil_pelapor() == 'Ya' : pil_pelapor() == 'Ya'" />
                              <span class="lbl"> Ya</span>
                            </label>
                          </div>
                          <div class="radio">
                            <label>
                              <input type="radio" class="ace" value="Tidak" data-bind="checked: pil_pelapor, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih1Tidak() }}, enable: $root.id_group == 6 ? child == 0 || pil_pelapor() == 'Tidak' : pil_pelapor() == 'Tidak'" />
                              <span class="lbl"> Tidak</span>
                            </label>
                          </div>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <div class="step-pane" data-step="2">
                <?php if ($this->session->userdata('id_group_'.APPAUTH) == 6) { ?>
                <div class="form-group pull-right">
                  <button class="btn btn-sm" id="reset2" data-bind="click: reset2">
                    <i class="ace-icon fa fa-circle bigger-110"></i>
                    Kosongkan
                  </button>
                </div>
                <?php } ?>

                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th width="5%">No</th>
                      <th width="75%">7-STANDAR KELAIKAN ETIK PENELITIAN</th>
                      <th width="10%">PENELITI</th>
                      <th width="10%">PENELAAH</th>
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
                              <input type="radio" class="ace" value="Ya" data-bind="checked: pil_pelapor, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih2Ya($index(), parent) }}, enable: $root.id_group == 6 ? child == 0 || pil_pelapor() == 'Ya' : pil_pelapor() == 'Ya'" />
                              <span class="lbl"> Ya</span>
                            </label>
                          </div>
                          <div class="radio">
                            <label>
                              <input type="radio" class="ace" value="Tidak" data-bind="checked: pil_pelapor, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih2Tidak() }}, enable: $root.id_group == 6 ? child == 0 || pil_pelapor() == 'Tidak' : pil_pelapor() == 'Tidak'" />
                              <span class="lbl"> Tidak</span>
                            </label>
                          </div>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <div class="step-pane" data-step="3">
                <?php if ($this->session->userdata('id_group_'.APPAUTH) == 6) { ?>
                <div class="form-group pull-right">
                  <button class="btn btn-sm" id="reset3" data-bind="click: reset3">
                    <i class="ace-icon fa fa-circle bigger-110"></i>
                    Kosongkan
                  </button>
                </div>
                <?php } ?>

                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th width="5%">No</th>
                      <th width="75%">7-STANDAR KELAIKAN ETIK PENELITIAN</th>
                      <th width="10%">PENELITI</th>
                      <th width="10%">PENELAAH</th>
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
                              <input type="radio" class="ace" value="Ya" data-bind="checked: pil_pelapor, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih3Ya($index(), parent) }}, enable: $root.id_group == 6 ? child == 0 || pil_pelapor() == 'Ya' : pil_pelapor() == 'Ya'" />
                              <span class="lbl"> Ya</span>
                            </label>
                          </div>
                          <div class="radio">
                            <label>
                              <input type="radio" class="ace" value="Tidak" data-bind="checked: pil_pelapor, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih3Tidak() }}, enable: $root.id_group == 6 ? child == 0 || pil_pelapor() == 'Tidak' : pil_pelapor() == 'Tidak'" />
                              <span class="lbl"> Tidak</span>
                            </label>
                          </div>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <div class="step-pane" data-step="4">
                <?php if ($this->session->userdata('id_group_'.APPAUTH) == 6) { ?>
                <div class="form-group pull-right">
                  <button class="btn btn-sm" id="reset4" data-bind="click: reset4">
                    <i class="ace-icon fa fa-circle bigger-110"></i>
                    Kosongkan
                  </button>
                </div>
                <?php } ?>

                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th width="5%">No</th>
                      <th width="75%">7-STANDAR KELAIKAN ETIK PENELITIAN</th>
                      <th width="10%">PENELITI</th>
                      <th width="10%">PENELAAH</th>
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
                              <input type="radio" class="ace" value="Ya" data-bind="checked: pil_pelapor, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih4Ya($index(), parent) }}, enable: $root.id_group == 6 ? child == 0 || pil_pelapor() == 'Ya' : pil_pelapor() == 'Ya'" />
                              <span class="lbl"> Ya</span>
                            </label>
                          </div>
                          <div class="radio">
                            <label>
                              <input type="radio" class="ace" value="Tidak" data-bind="checked: pil_pelapor, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih4Tidak() }}, enable: $root.id_group == 6 ? child == 0 || pil_pelapor() == 'Tidak' : pil_pelapor() == 'Tidak'" />
                              <span class="lbl"> Tidak</span>
                            </label>
                          </div>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <div class="step-pane" data-step="5">
                <?php if ($this->session->userdata('id_group_'.APPAUTH) == 6) { ?>
                <div class="form-group pull-right">
                  <button class="btn btn-sm" id="reset5" data-bind="click: reset5">
                    <i class="ace-icon fa fa-circle bigger-110"></i>
                    Kosongkan
                  </button>
                </div>
                <?php } ?>

                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th width="5%">No</th>
                      <th width="75%">7-STANDAR KELAIKAN ETIK PENELITIAN</th>
                      <th width="10%">PENELITI</th>
                      <th width="10%">PENELAAH</th>
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
                              <input type="radio" class="ace" value="Ya" data-bind="checked: pil_pelapor, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih5Ya($index(), parent) }}, enable: $root.id_group == 6 ? child == 0 || pil_pelapor() == 'Ya' : pil_pelapor() == 'Ya'" />
                              <span class="lbl"> Ya</span>
                            </label>
                          </div>
                          <div class="radio">
                            <label>
                              <input type="radio" class="ace" value="Tidak" data-bind="checked: pil_pelapor, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih5Tidak() }}, enable: $root.id_group == 6 ? child == 0 || pil_pelapor() == 'Tidak' : pil_pelapor() == 'Tidak'" />
                              <span class="lbl"> Tidak</span>
                            </label>
                          </div>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <div class="step-pane" data-step="6">
                <?php if ($this->session->userdata('id_group_'.APPAUTH) == 6) { ?>
                <div class="form-group pull-right">
                  <button class="btn btn-sm" id="reset6" data-bind="click: reset6">
                    <i class="ace-icon fa fa-circle bigger-110"></i>
                    Kosongkan
                  </button>
                </div>
                <?php } ?>

                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th width="5%">No</th>
                      <th width="75%">7-STANDAR KELAIKAN ETIK PENELITIAN</th>
                      <th width="10%">PENELITI</th>
                      <th width="10%">PENELAAH</th>
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
                              <input type="radio" class="ace" value="Ya" data-bind="checked: pil_pelapor, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih6Ya($index(), parent) }}, enable: $root.id_group == 6 ? child == 0 || pil_pelapor() == 'Ya' : pil_pelapor() == 'Ya'" />
                              <span class="lbl"> Ya</span>
                            </label>
                          </div>
                          <div class="radio">
                            <label>
                              <input type="radio" class="ace" value="Tidak" data-bind="checked: pil_pelapor, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih6Tidak() }}, enable: $root.id_group == 6 ? child == 0 || pil_pelapor() == 'Tidak' : pil_pelapor() == 'Tidak'" />
                              <span class="lbl"> Tidak</span>
                            </label>
                          </div>
                        </div>
                      </td>                   
                    </tr>
                  </tbody>
                </table>
              </div>

              <div class="step-pane" data-step="7">
                <?php if ($this->session->userdata('id_group_'.APPAUTH) == 6) { ?>
                <div class="form-group pull-right">
                  <button class="btn btn-sm" id="reset7" data-bind="click: reset7">
                    <i class="ace-icon fa fa-circle bigger-110"></i>
                    Kosongkan
                  </button>
                </div>
                <?php } ?>

                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th width="5%">No</th>
                      <th width="75%">7-STANDAR KELAIKAN ETIK PENELITIAN</th>
                      <th width="10%">PENELITI</th>
                      <th width="10%">PENELAAH</th>
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
                              <input type="radio" class="ace" value="Ya" data-bind="checked: pil_pelapor, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih7Ya($index(), parent) }}, enable: $root.id_group == 6 ? child == 0 || pil_pelapor() == 'Ya' : pil_pelapor() == 'Ya'" />
                              <span class="lbl"> Ya</span>
                            </label>
                          </div>
                          <div class="radio">
                            <label>
                              <input type="radio" class="ace" value="Tidak" data-bind="checked: pil_pelapor, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih7Tidak() }}, enable: $root.id_group == 6 ? child == 0 || pil_pelapor() == 'Tidak' : pil_pelapor() == 'Tidak'" />
                              <span class="lbl"> Tidak</span>
                            </label>
                          </div>
                        </div>
                      </td>                   
                    </tr>
                  </tbody>
                </table>
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
			</div>
		</div><!-- /.widget-main -->
	</div><!-- /.widget-body -->
</div><!-- /.widget-box -->

<div class="clearfix form-actions">
	<div class="col-md-offset-3 col-md-9">
		<button class="btn btn-primary" id="submit" type="button" data-loading-text="Proses..." data-bind="click: function(data, event){save(false, data, event) }, enable: is_kirim() == 0">
			<i class="ace-icon fa fa-floppy-o bigger-110"></i>
			Simpan
		</button>

<!-- 		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<button class="btn btn-default" type="button" data-bind="click: cetak, enable: !processing()">
			<i class="ace-icon fa fa-print bigger-110"></i>
			Cetak
		</button>
 -->
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<button class="btn btn-warning" id="back" type="button" data-bind="click: back">
			<i class="ace-icon fa fa-list bigger-110"></i>
			Lihat Daftar
		</button>

		<?php if ($this->session->userdata('id_group_'.APPAUTH) == 6){ ?>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<button class="btn btn-success" id="kirim1" type="button" data-loading-text="Mengirim..." data-bind="click: kirim1, enable: id() > 0 && is_kirim() == 0">
			<i class="ace-icon fa fa-envelope bigger-110"></i>
			<span data-bind="text: lbl_btn_kirim"></span> ke Sekretaris & Ketua
		</button>
		<?php } ?>


		<?php if ($this->session->userdata('id_group_'.APPAUTH) == 4){ ?>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<button class="btn btn-success" id="kirim2" type="button" data-loading-text="Mengirim..." data-bind="click: kirim2, enable: save_sekretaris() > 0 && is_kirim() == 0">
			<i class="ace-icon fa fa-envelope bigger-110"></i>
			<span data-bind="text: lbl_btn_kirim"></span> ke Ketua
		</button>
		<?php } ?>

		<?php if ($this->session->userdata('id_group_'.APPAUTH) == 7){ ?>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<button class="btn btn-success" id="kirim3" type="button" data-loading-text="Mengirim..." data-bind="click: kirim3, enable: save_ketua() > 0 && is_kirim() == 0">
			<i class="ace-icon fa fa-envelope bigger-110"></i>
			<span data-bind="text: lbl_btn_kirim"></span> ke Kesekretariatan
		</button>
		<?php } ?>

    <?php if ($this->session->userdata('id_group_'.APPAUTH) == 8){ ?>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<button class="btn btn-success" id="kirim3" type="button" data-loading-text="Mengirim..." data-bind="click: kirim3, enable: save_wakil_ketua() > 0 && is_kirim() == 0">
			<i class="ace-icon fa fa-envelope bigger-110"></i>
			<span data-bind="text: lbl_btn_kirim"></span> ke Kesekretariatan
		</button>
		<?php } ?>

  </div>
</div>

<?php if (isset($pengajuan['revisi_ke']) && $pengajuan['revisi_ke'] > 0) { ?>
<div id="my-modal-telaah" class="modal fade" tabindex="-1">
  <div class="modal-dialog" style="width: 1000px">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="smaller lighter blue no-margin"><u><span data-bind="html: title_modal"></span></u> <i class="ace-icon fa fa-angle-double-right"></i> <span data-bind="html: subtitle_modal"></span></h3>
        <h6 class="widget-title bigger lighter">
          <i class="ace-icon fa fa-comments bigger-120"></i>
          <span data-bind="text: no_penelaah"></span> - <span data-bind="text: nama_penelaah"></span>
        </h6>
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

<div id="my-modal-kelayakan" class="modal fade" tabindex="-1">
  <div class="modal-dialog" style="width: 1000px">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="smaller lighter blue no-margin"><u><span data-bind="html: title_modal"></span></u> <i class="ace-icon fa fa-angle-double-right"></i> <span data-bind="html: subtitle_modal"></span></h3>
        <h6 class="widget-title bigger lighter">
          <i class="ace-icon fa fa-comments bigger-120"></i>
          <span data-bind="text: no_penelaah"></span> - <span data-bind="text: nama_penelaah"></span>
        </h6>
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

                      <input type="radio" name="kelayakan_before_aktif" data-bind="checkedValue: $index()+1, event: {change: function(data, event){$root.showKelayakan($index()+1)}}" />
                    </label>
                  </div>
                </div>
              </div>
            </div>

            <div class="hr dotted"></div>

            <div data-bind="foreach: telaah_sebelumnya">
              <div data-bind="attr:{'class': $index()+1 < $root.jumlah_telaah() ? 'hide' : ''}">
                <div data-bind="attr: {'id': $index()+1+'_kelayakan_before'}" class="kelayakan_before">
                  <p><i class="ace-icon fa fa-calendar"></i> <span data-bind="text: tgl"></span></p>
                  <span class="label label-lg label-yellow arrowed-in arrowed-in-right" data-bind="text: kelayakan"></span>
                  <h5 class="header smaller lighter blue">Catatan Protokol</h5>
                  <p data-bind="html: catprotokol.length > 0 ? catprotokol : '<i>null</i>'"></p>
                  <h5 class="header smaller lighter blue">Catatan 7 Standar</h5>
                  <p data-bind="html: cat7standar.length > 0 ? cat7standar : '<i>null</i>'"></p>
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