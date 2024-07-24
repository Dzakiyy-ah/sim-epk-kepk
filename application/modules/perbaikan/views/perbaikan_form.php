<?php if (isset($data['klasifikasi']) && ($data['klasifikasi'] == 2 || $data['klasifikasi'] == 3)) { ?>
<div class="row">
  <div class="col-sm-3 pull-right">
    <h4 class="smaller lighter">
      <i class="ace-icon fa fa-hand-o-right icon-animated-hand-pointer orange"></i>
      <a href="#" data-toggle="modal" class="orange" data-bind="click: print_catatan_telaah">Cetak Catatan Penelaah (pdf)</a>
      <i class="ace-icon fa fa-print icon-animated-hand-pointer orange"></i>
    </h4>
  </div>
</div>
<?php } ?>

<div class="widget-box transparent">
	<div class="widget-header">
		<h4 class="widget-title lighter smaller">
			<i class="ace-icon fa fa-file-o bigger-160 orange"></i>
			<strong><?php echo isset($data['no_protokol']) ? $data['no_protokol'] : ''?></strong>
		</h4>
    <span class="label label-lg label-warning arrowed-in-right arrowed"> Perbaikan <span data-bind="text: '#'+revisi_ke"></span> </span>
    <?php
      if (isset($data['klasifikasi']))
      {
        echo '&nbsp;';
        switch ($data['klasifikasi']) {
          case 2: echo '<span class="label label-lg label-yellow arrowed-in arrowed-in-right">Expedited</span>';
            break;
          case 3: echo '<span class="label label-lg label-yellow arrowed-in arrowed-in-right">Full Board</span>';
            break;
          case 4: echo '<span class="label label-lg label-yellow arrowed-in arrowed-in-right">Tidak Bisa Ditelaah</span>';
            break;
          default: echo '';
            break;
        }
      }
    ?>

    <div class="widget-toolbar no-border">
      <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="recent-tab">
        <li class="active">
          <a data-toggle="tab" href="#protokol-tab">Protokol</a>
        </li>

        <li>
          <a data-toggle="tab" href="#self_assesment-tab">Self Assesment</a>
        </li>
      </ul>
    </div>
	</div>

	<div class="widget-body">
		<div class="widget-main padding-4">
      <div class="tab-content padding-8">
        <div id="protokol-tab" class="tab-pane active">
          <h3 class="header smaller lighter blue">
            <div class="row">
              <span class="col-sm-10">Protokol Etik Penelitian Kesehatan Yang Mengikutsertakan Manusia Sebagai Subyek</span>
              <span class="col-sm-2">
                <label class="inline">
                  <small class="green"><strong>Validasi Protokol</strong></small>
                  <input id="gritter-light" type="checkbox" class="ace ace-switch" data-bind="checked: valid_protokol" />
                  <span class="lbl middle" data-lbl="ON&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;OFF"></span>
                </label>
                <a href="#" data-bind="click: print_protokol" class="pull-right">
                  <i class="ace-icon fa fa-print bigger-110"></i>
                </a>
              </span>
            </div>
          </h3>

  				<div class="row">
  					<div class="col-sm-12">
              <?php
              if (isset($data['klasifikasi']) && $data['klasifikasi'] == 4)
              {
                echo '<h5 class="header smaller lighter blue">Alasan TBD</h5>';
                echo '<textarea class="form-control" disabled="disabled">'.$cat_telaah['alasan_tbd'].'</textarea>';
                echo '<div class="hr hr-dotted hr-18"></div>';
              }
              ?>
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

                  <?php if (isset($data['klasifikasi']) && $data['klasifikasi'] != 4) { ?>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-xs-12 col-sm-12 widget-container-col" >
                          <div class="widget-box widget-color-orange">
                            <div class="widget-header">
                              <h5 class="widget-title">Catatan Penelaah</h5>

                              <div class="widget-toolbar">
                                <?php if (isset($revisi_ke) && $revisi_ke+1 > 1) { ?>
                                <button class="btn btn-xs btn-default" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'A. Judul Penelitian (p-protokol no 1)', 'catatana') }">
                                  <i class="ace-icon fa fa-square bigger-110"></i>
                                  Catatan Sebelumnya
                                </button>
                                <?php } ?>

                                <a href="#" data-action="fullscreen">
                                  <i class="ace-icon fa fa-expand"></i>
                                </a>

                                <a href="#" data-action="collapse">
                                  <i class="ace-icon fa fa-chevron-up"></i>
                                </a>

                              </div>
                            </div>

                            <div class="widget-body">
                              <div class="widget-main">
                              <?php
                              if (!empty($cat_telaah))
                              {
                                for ($i=0; $i<count($cat_telaah); $i++)
                                {
                                  $no = $i+1;
                                  echo '<h6 class="header smaller lighter">Penelaah #'.$no.'</h6>';
                                  echo isset($cat_telaah[$i]['catatana']) && strlen(trim($cat_telaah[$i]['catatana'])) > 0 ? stripslashes($cat_telaah[$i]['catatana']) : '<i>null</i>';
                                  echo '<br/>';
                                }
                              }
                              else echo '<i>null</i>';
                              ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>

  									<div class="form-group">
  										<input type="text" class="form-control" id="judul" data-bind="value: judul" disabled="true">
  									</div>

  									<div class="form-group">
  										<label for="lokasi">1. Lokasi Penelitian</label>
  										<input type="text" class="form-control" id="lokasi" data-bind="value: lokasi" disabled="true">
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

  								</div>

  								<div id="b" class="tab-pane">
  									<h4 class="header smaller lighter blue">B. Identifikasi (p10)</h4>
  									<p class="text-danger">1. Peneliti Utama (CV dilampirkan di Tab CC)</p>
  									<p class="text-danger">2. Anggota Peneliti (CV dilampirkan di Tab CC)</p>
  									<p class="text-danger">3. Lembaga Sponsor (Nama Lembaga dan Alamat dilampirkan di Tab CC)</p>
  								</div>

  								<div id="c" class="tab-pane">
  									<h4 class="header smaller lighter blue">C. Ringkasan Protokol Penelitian</h4>

                  <?php if (isset($data['klasifikasi']) && $data['klasifikasi'] != 4) { ?>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-xs-12 col-sm-12 widget-container-col" >
                          <div class="widget-box widget-color-orange">
                            <div class="widget-header">
                              <h5 class="widget-title">Catatan Penelaah</h5>

                              <div class="widget-toolbar">
                                <?php if (isset($revisi_ke) && $revisi_ke+1 > 1) { ?>
                                <button class="btn btn-xs btn-default" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'C. Ringkasan Protokol Penelitian', 'catatanc') }">
                                  <i class="ace-icon fa fa-square bigger-110"></i>
                                  Catatan Sebelumnya
                                </button>
                                <?php } ?>

                                <a href="#" data-action="fullscreen">
                                  <i class="ace-icon fa fa-expand"></i>
                                </a>

                                <a href="#" data-action="collapse">
                                  <i class="ace-icon fa fa-chevron-up"></i>
                                </a>

                              </div>
                            </div>

                            <div class="widget-body">
                              <div class="widget-main">
                              <?php
                              if (!empty($cat_telaah))
                              {
                                for ($i=0; $i<count($cat_telaah); $i++)
                                {
                                  $no = $i+1;
                                  echo '<h6 class="header smaller lighter">Penelaah #'.$no.'</h6>';
                                  echo isset($cat_telaah[$i]['catatanc']) && strlen(trim($cat_telaah[$i]['catatanc'])) > 0 ? stripslashes($cat_telaah[$i]['catatanc']) : '<i>null</i>';
                                  echo '<br/>';
                                }
                              }
                              else echo '<i>null</i>';
                              ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>

  									<div class="form-group">
  										<button class="btn btn-xs btn-info pull-right" data-bind="click: function(data, event){ uraian_before('C. Ringkasan Protokol Penelitian', 'uraianc1') }">
  											<i class="ace-icon fa fa-square bigger-110"></i>
  											Data Sebelumnya
  										</button>
  									</div>
  									<div class="form-group">
  										<label for="c1">1. Ringkasan dalam 200 kata, (ditulis dalam bahasa yang mudah dipahami oleh "awam" bukan dokter/profesional kesehatan)</label>
  										<div class="wysiwyg-editor" id="c1"></div>
  									</div>
  									<div class="form-group">
  										<button class="btn btn-xs btn-info pull-right" data-bind="click: function(data, event){ uraian_before('C. Ringkasan Protokol Penelitian', 'uraianc2') }">
  											<i class="ace-icon fa fa-square bigger-110"></i>
  											Data Sebelumnya
  										</button>
  									</div>
  									<div class="form-group">
  										<label for="c2">
  											2. Tuliskan mengapa penelitian ini harus dilakukan, manfaatnya untuk penduduk di wilayah penelitian ini dilakukan (Negara, wilayah, lokal) - <small><i>Justifikasi Penelitian (p3) Standar 2/A (Adil)</i></small>
  										</label>
  										<div class="wysiwyg-editor" id="c2"></div>
  									</div>

  								</div>

  								<div id="d" class="tab-pane">
  									<h4 class="header smaller lighter blue">D. Isu Etik yang mungkin dihadapi</h4>

                  <?php if (isset($data['klasifikasi']) && $data['klasifikasi'] != 4) { ?>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-xs-12 col-sm-12 widget-container-col" >
                          <div class="widget-box widget-color-orange">
                            <div class="widget-header">
                              <h5 class="widget-title">Catatan Penelaah</h5>

                              <div class="widget-toolbar">
                                <?php if (isset($revisi_ke) && $revisi_ke+1 > 1) { ?>
                                <button class="btn btn-xs btn-default" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'D. Isu Etik yang mungkin dihadapi', 'catatand') }">
                                  <i class="ace-icon fa fa-square bigger-110"></i>
                                  Catatan Sebelumnya
                                </button>
                                <?php } ?>

                                <a href="#" data-action="fullscreen">
                                  <i class="ace-icon fa fa-expand"></i>
                                </a>

                                <a href="#" data-action="collapse">
                                  <i class="ace-icon fa fa-chevron-up"></i>
                                </a>

                              </div>
                            </div>

                            <div class="widget-body">
                              <div class="widget-main">
                              <?php
                              if (!empty($cat_telaah))
                              {
                                for ($i=0; $i<count($cat_telaah); $i++)
                                {
                                  $no = $i+1;
                                  echo '<h6 class="header smaller lighter">Penelaah #'.$no.'</h6>';
                                  echo isset($cat_telaah[$i]['catatand']) && strlen(trim($cat_telaah[$i]['catatand'])) > 0 ? stripslashes($cat_telaah[$i]['catatand']) : '<i>null</i>';
                                  echo '<br/>';
                                }
                              }
                              else echo '<i>null</i>';
                              ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>

  									<div class="form-group">
  										<button class="btn btn-xs btn-info pull-right" data-bind="click: function(data, event){ uraian_before('D. Isu Etik yang mungkin dihadapi', 'uraiand1') }">
  											<i class="ace-icon fa fa-square bigger-110"></i>
  											Data Sebelumnya
  										</button>
  									</div>
  									<div class="form-group">
  										<label for="d1">
  											1. Pendapat peneliti tentang isyu etik yang mungkin dihadapi dalam penelitian ini, dan bagaimana cara menanganinya <small><i>(p4)</i></small>.
  										</label>
  										<div class="wysiwyg-editor" id="d1"></div>
  									</div>
  								</div>

  								<div id="e" class="tab-pane">
  									<h4 class="header smaller lighter blue">E. Ringkasan Kajian Pustaka</h4>

                  <?php if (isset($data['klasifikasi']) && $data['klasifikasi'] != 4) { ?>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-xs-12 col-sm-12 widget-container-col" >
                          <div class="widget-box widget-color-orange">
                            <div class="widget-header">
                              <h5 class="widget-title">Catatan Penelaah</h5>

                              <div class="widget-toolbar">
                                <?php if (isset($revisi_ke) && $revisi_ke+1 > 1) { ?>
                                <button class="btn btn-xs btn-default" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'E. Ringkasan Kajian Pustaka', 'catatane') }">
                                  <i class="ace-icon fa fa-square bigger-110"></i>
                                  Catatan Sebelumnya
                                </button>
                                <?php } ?>

                                <a href="#" data-action="fullscreen">
                                  <i class="ace-icon fa fa-expand"></i>
                                </a>

                                <a href="#" data-action="collapse">
                                  <i class="ace-icon fa fa-chevron-up"></i>
                                </a>

                              </div>
                            </div>

                            <div class="widget-body">
                              <div class="widget-main">
                              <?php
                              if (!empty($cat_telaah))
                              {
                                for ($i=0; $i<count($cat_telaah); $i++)
                                {
                                  $no = $i+1;
                                  echo '<h6 class="header smaller lighter">Penelaah #'.$no.'</h6>';
                                  echo isset($cat_telaah[$i]['catatane']) && strlen(trim($cat_telaah[$i]['catatane'])) > 0 ? stripslashes($cat_telaah[$i]['catatane']) : '<i>null</i>';
                                  echo '<br/>';
                                }
                              }
                              else echo '<i>null</i>';
                              ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>

  									<div class="form-group">
  										<button class="btn btn-xs btn-info pull-right" data-bind="click: function(data, event){ uraian_before('E. Ringkasan Kajian Pustaka', 'uraiane1') }">
  											<i class="ace-icon fa fa-square bigger-110"></i>
  											Data Sebelumnya
  										</button>
  									</div>
  									<div class="form-group">
  										<label for="e1">
  											1. Ringkasan hasil-hasil studi sebelumnya yang sesuai topik penelitian, baik yang sudah maupun yang sudah dipublikasikan, termasuk jika ada kajian-kajian pada hewan. Maksimum 1 hal <small><i>(p5)- G 4, S</i></small> ?
  										</label>
  										<div class="wysiwyg-editor" id="e1"></div>
  									</div>
  								</div>

  								<div id="f" class="tab-pane">
  									<h4 class="header smaller lighter blue">F. Kondisi Lapangan</h4>

                  <?php if (isset($data['klasifikasi']) && $data['klasifikasi'] != 4) { ?>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-xs-12 col-sm-12 widget-container-col" >
                          <div class="widget-box widget-color-orange">
                            <div class="widget-header">
                              <h5 class="widget-title">Catatan Penelaah</h5>

                              <div class="widget-toolbar">
                                <?php if (isset($revisi_ke) && $revisi_ke+1 > 1) { ?>
                                <button class="btn btn-xs btn-default" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'F. Kondisi Lapangan', 'catatanf') }">
                                  <i class="ace-icon fa fa-square bigger-110"></i>
                                  Catatan Sebelumnya
                                </button>
                                <?php } ?>

                                <a href="#" data-action="fullscreen">
                                  <i class="ace-icon fa fa-expand"></i>
                                </a>

                                <a href="#" data-action="collapse">
                                  <i class="ace-icon fa fa-chevron-up"></i>
                                </a>

                              </div>
                            </div>

                            <div class="widget-body">
                              <div class="widget-main">
                              <?php
                              if (!empty($cat_telaah))
                              {
                                for ($i=0; $i<count($cat_telaah); $i++)
                                {
                                  $no = $i+1;
                                  echo '<h6 class="header smaller lighter">Penelaah #'.$no.'</h6>';
                                  echo isset($cat_telaah[$i]['catatanf']) && strlen(trim($cat_telaah[$i]['catatanf'])) > 0 ? stripslashes($cat_telaah[$i]['catatanf']) : '<i>null</i>';
                                  echo '<br/>';
                                }
                              }
                              else echo '<i>null</i>';
                              ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>

  									<div class="form-group">
  										<button class="btn btn-xs btn-info pull-right" data-bind="click: function(data, event){ uraian_before('F. Kondisi Lapangan', 'uraianf1') }">
  											<i class="ace-icon fa fa-square bigger-110"></i>
  											Data Sebelumnya
  										</button>
  									</div>
  									<div class="form-group">
  										<label for="f1">1. Gambaran singkat tentang lokasi penelitian<small><i>(p8)</i></small></label>
  										<div class="wysiwyg-editor" id="f1"></div>
  									</div>
  									<div class="form-group">
  										<button class="btn btn-xs btn-info pull-right" data-bind="click: function(data, event){ uraian_before('F. Kondisi Lapangan', 'uraianf2') }">
  											<i class="ace-icon fa fa-square bigger-110"></i>
  											Data Sebelumnya
  										</button>
  									</div>
  									<div class="form-group">
  										<label for="f2">2. Informasi ketersediaan fasilitas yang tersedia di lapangan yang menunjang penelitian</label>
  										<div class="wysiwyg-editor" id="f2"></div>
  									</div>
  									<div class="form-group">
  										<button class="btn btn-xs btn-info pull-right" data-bind="click: function(data, event){ uraian_before('F. Kondisi Lapangan', 'uraianf3') }">
  											<i class="ace-icon fa fa-square bigger-110"></i>
  											Data Sebelumnya
  										</button>
  									</div>
  									<div class="form-group">
  										<label for="f3">3. Informasi demografis / epidemiologis yang relevan tentang daerah penelitian</label>
  										<div class="wysiwyg-editor" id="f3"></div>
  									</div>
  								</div>

  								<div id="g" class="tab-pane">
  									<h4 class="header smaller lighter blue">G. Disain Penelitian</h4>

                  <?php if (isset($data['klasifikasi']) && $data['klasifikasi'] != 4) { ?>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-xs-12 col-sm-12 widget-container-col" >
                          <div class="widget-box widget-color-orange">
                            <div class="widget-header">
                              <h5 class="widget-title">Catatan Penelaah</h5>

                              <div class="widget-toolbar">
                                <?php if (isset($revisi_ke) && $revisi_ke+1 > 1) { ?>
                                <button class="btn btn-xs btn-default" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'G. Disain Penelitian', 'catatang') }">
                                  <i class="ace-icon fa fa-square bigger-110"></i>
                                  Catatan Sebelumnya
                                </button>
                                <?php } ?>

                                <a href="#" data-action="fullscreen">
                                  <i class="ace-icon fa fa-expand"></i>
                                </a>

                                <a href="#" data-action="collapse">
                                  <i class="ace-icon fa fa-chevron-up"></i>
                                </a>

                              </div>
                            </div>

                            <div class="widget-body">
                              <div class="widget-main">
                              <?php
                              if (!empty($cat_telaah))
                              {
                                for ($i=0; $i<count($cat_telaah); $i++)
                                {
                                  $no = $i+1;
                                  echo '<h6 class="header smaller lighter">Penelaah #'.$no.'</h6>';
                                  echo isset($cat_telaah[$i]['catatang']) && strlen(trim($cat_telaah[$i]['catatang'])) > 0 ? stripslashes($cat_telaah[$i]['catatang']) : '<i>null</i>';
                                  echo '<br/>';
                                }
                              }
                              else echo '<i>null</i>';
                              ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>

  									<div class="form-group">
  										<button class="btn btn-xs btn-info pull-right" data-bind="click: function(data, event){ uraian_before('G. Disain Penelitian', 'uraiang1') }">
  											<i class="ace-icon fa fa-square bigger-110"></i>
  											Data Sebelumnya
  										</button>
  									</div>
  									<div class="form-group">
  										<label for="g1">1. Tujuan penelitian, hipotesa, pertanyaan penelitian, asumsi dan variabel penelitian <small><i>(p11)</i></small></label>
  										<div class="wysiwyg-editor" id="g1"></div>
  									</div>
  									<div class="form-group">
  										<button class="btn btn-xs btn-info pull-right" data-bind="click: function(data, event){ uraian_before('G. Disain Penelitian', 'uraiang2') }">
  											<i class="ace-icon fa fa-square bigger-110"></i>
  											Data Sebelumnya
  										</button>
  									</div>
  									<div class="form-group">
  										<label for="g2">2. Deskipsi detil tentang desain penelitian. <small><i>(p12)</i></small></label>
  										<div class="wysiwyg-editor" id="g2"></div>
  									</div>
  									<div class="form-group">
  										<button class="btn btn-xs btn-info pull-right" data-bind="click: function(data, event){ uraian_before('G. Disain Penelitian', 'uraiang3') }">
  											<i class="ace-icon fa fa-square bigger-110"></i>
  											Data Sebelumnya
  										</button>
  									</div>
  									<div class="form-group">
  										<label for="g3">3. Bila ujicoba klinis, deskripsikan tentang  apakah kelompok treatmen ditentukan secara random, (termasuk bagaimana metodenya), dan apakah blinded atau terbuka. <small><i>(Bila bukan ujicoba klinis cukup tulis: tidak relevan) (p12)</i></small></label>
  										<div class="wysiwyg-editor" id="g3"></div>
  									</div>
  								</div>

  								<div id="h" class="tab-pane">
  									<h4 class="header smaller lighter blue">H. Sampling</h4>

                  <?php if (isset($data['klasifikasi']) && $data['klasifikasi'] != 4) { ?>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-xs-12 col-sm-12 widget-container-col" >
                          <div class="widget-box widget-color-orange">
                            <div class="widget-header">
                              <h5 class="widget-title">Catatan Penelaah</h5>

                              <div class="widget-toolbar">
                                <?php if (isset($revisi_ke) && $revisi_ke+1 > 1) { ?>
                                <button class="btn btn-xs btn-default" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'H. Sampling', 'catatanh') }">
                                  <i class="ace-icon fa fa-square bigger-110"></i>
                                  Catatan Sebelumnya
                                </button>
                                <?php } ?>

                                <a href="#" data-action="fullscreen">
                                  <i class="ace-icon fa fa-expand"></i>
                                </a>

                                <a href="#" data-action="collapse">
                                  <i class="ace-icon fa fa-chevron-up"></i>
                                </a>

                              </div>
                            </div>

                            <div class="widget-body">
                              <div class="widget-main">
                              <?php
                              if (!empty($cat_telaah))
                              {
                                for ($i=0; $i<count($cat_telaah); $i++)
                                {
                                  $no = $i+1;
                                  echo '<h6 class="header smaller lighter">Penelaah #'.$no.'</h6>';
                                  echo isset($cat_telaah[$i]['catatanh']) && strlen(trim($cat_telaah[$i]['catatanh'])) > 0 ? stripslashes($cat_telaah[$i]['catatanh']) : '<i>null</i>';
                                  echo '<br/>';
                                }
                              }
                              else echo '<i>null</i>';
                              ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>

  									<div class="form-group">
  										<button class="btn btn-xs btn-info pull-right" data-bind="click: function(data, event){ uraian_before('H. Sampling', 'uraianh1') }">
  											<i class="ace-icon fa fa-square bigger-110"></i>
  											Data Sebelumnya
  										</button>
  									</div>
  									<div class="form-group">
  										<label for="h1">1. Jumlah subyek yang dibutuhkan dan bagaimana penentuannya secara statistik <small><i>(p13)</i></small></label>
  										<div class="wysiwyg-editor" id="h1"></div>
  									</div>
  									<div class="form-group">
  										<button class="btn btn-xs btn-info pull-right" data-bind="click: function(data, event){ uraian_before('H. Sampling', 'uraianh2') }">
  											<i class="ace-icon fa fa-square bigger-110"></i>
  											Data Sebelumnya
  										</button>
  									</div>
  									<div class="form-group">
  										<label for="h2">2. Kriteria partisipan atau subyek dan justifikasi exclude/include-nya. <small><i>(Guideline 3) (p12)</i></small></label>
  										<div class="wysiwyg-editor" id="h2"></div>
  									</div>
  									<div class="form-group">
  										<button class="btn btn-xs btn-info pull-right" data-bind="click: function(data, event){ uraian_before('H. Sampling', 'uraianh3') }">
  											<i class="ace-icon fa fa-square bigger-110"></i>
  											Data Sebelumnya
  										</button>
  									</div>
  									<div class="form-group">
  										<label for="h3">3. <strong>Sampling kelompok rentan</strong>: alasan melibatkan anak anak atau orang dewasa yang tidak mampu memberikan persetujuan setelah penjelasan, atau kelompok rentan, serta langkah langkah bagaimana meminimalisir bila terjadi resiko <small><i>(tulis “<strong>tidak relevan</strong>” bila penelitian tidak mengikutsertakan kelompok rentan)(Guidelines 15, 16 and 17)  (p15)</i></small></label>
  										<div class="wysiwyg-editor" id="h3"></div>
  									</div>
  								</div>

  								<div id="i" class="tab-pane">
  									<h4 class="header smaller lighter blue">I. Intervensi</h4>

                  <?php if (isset($data['klasifikasi']) && $data['klasifikasi'] != 4) { ?>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-xs-12 col-sm-12 widget-container-col" >
                          <div class="widget-box widget-color-orange">
                            <div class="widget-header">
                              <h5 class="widget-title">Catatan Penelaah</h5>

                              <div class="widget-toolbar">
                                <?php if (isset($revisi_ke) && $revisi_ke+1 > 1) { ?>
                                <button class="btn btn-xs btn-default" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'I. Intervensi', 'catatani') }">
                                  <i class="ace-icon fa fa-square bigger-110"></i>
                                  Catatan Sebelumnya
                                </button>
                                <?php } ?>

                                <a href="#" data-action="fullscreen">
                                  <i class="ace-icon fa fa-expand"></i>
                                </a>

                                <a href="#" data-action="collapse">
                                  <i class="ace-icon fa fa-chevron-up"></i>
                                </a>

                              </div>
                            </div>

                            <div class="widget-body">
                              <div class="widget-main">
                              <?php
                              if (!empty($cat_telaah))
                              {
                                for ($i=0; $i<count($cat_telaah); $i++)
                                {
                                  $no = $i+1;
                                  echo '<h6 class="header smaller lighter">Penelaah #'.$no.'</h6>';
                                  echo isset($cat_telaah[$i]['catatani']) && strlen(trim($cat_telaah[$i]['catatani'])) > 0 ? stripslashes($cat_telaah[$i]['catatani']) : '<i>null</i>';
                                  echo '<br/>';
                                }
                              }
                              else echo '<i>null</i>';
                              ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>

  									<div class="form-group">
  										<button class="btn btn-xs btn-info pull-right" data-bind="click: function(data, event){ uraian_before('I. Intervensi', 'uraiani1') }">
  											<i class="ace-icon fa fa-square bigger-110"></i>
  											Data Sebelumnya
  										</button>
  									</div>
  									<div class="form-group">
  										<label for="i1">1. Desripsi dan penjelasan semua intervensi (metode administrasi treatmen, termasuk rute administrasi, dosis, interval dosis, dan masa treatmen produk yang digunakan <small><i>(tulis “<strong>Tidak relevan</strong>” bila bukan penelitian intervensi) (investigasi dan komparator (p17)</i></small></label>
  										<div class="wysiwyg-editor" id="i1"></div>
  									</div>
  									<div class="form-group">
  										<button class="btn btn-xs btn-info pull-right" data-bind="click: function(data, event){ uraian_before('I. Intervensi', 'uraiani2') }">
  											<i class="ace-icon fa fa-square bigger-110"></i>
  											Data Sebelumnya
  										</button>
  									</div>
  									<div class="form-group">
  										<label for="i2">2. Rencana dan jastifikasi untuk meneruskan atau menghentikan standar terapi/terapi baku selama penelitian <small><i>(p 4 and 5) (p18)</i></small></label>
  										<div class="wysiwyg-editor" id="i2"></div>
  									</div>
  									<div class="form-group">
  										<button class="btn btn-xs btn-info pull-right" data-bind="click: function(data, event){ uraian_before('I. Intervensi', 'uraiani3') }">
  											<i class="ace-icon fa fa-square bigger-110"></i>
  											Data Sebelumnya
  										</button>
  									</div>
  									<div class="form-group">
  										<label for="i3">3. Treatmen/Pengobatan lain yang mungkin diberikan atau diperbolehkan, atau menjadi kontraindikasi, selama penelitian <small><i>(p 6) (p19)</i></small></label>
  										<div class="wysiwyg-editor" id="i3"></div>
  									</div>
  									<div class="form-group">
  										<button class="btn btn-xs btn-info pull-right" data-bind="click: function(data, event){ uraian_before('I. Intervensi', 'uraiani4') }">
  											<i class="ace-icon fa fa-square bigger-110"></i>
  											Data Sebelumnya
  										</button>
  									</div>
  									<div class="form-group">
  										<label for="i4">4. Test klinis atau lab atau test lain yang harus dilakukan <small><i>(p20)</i></small></label>
  										<div class="wysiwyg-editor" id="i4"></div>
  									</div>
  								</div>

  								<div id="j" class="tab-pane">
  									<h4 class="header smaller lighter blue">J. Monitoring Penelitian</h4>

                  <?php if (isset($data['klasifikasi']) && $data['klasifikasi'] != 4) { ?>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-xs-12 col-sm-12 widget-container-col" >
                          <div class="widget-box widget-color-orange">
                            <div class="widget-header">
                              <h5 class="widget-title">Catatan Penelaah</h5>

                              <div class="widget-toolbar">
                                <?php if (isset($revisi_ke) && $revisi_ke+1 > 1) { ?>
                                <button class="btn btn-xs btn-default" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'J. Monitoring Penelitian', 'catatanj') }">
                                  <i class="ace-icon fa fa-square bigger-110"></i>
                                  Catatan Sebelumnya
                                </button>
                                <?php } ?>

                                <a href="#" data-action="fullscreen">
                                  <i class="ace-icon fa fa-expand"></i>
                                </a>

                                <a href="#" data-action="collapse">
                                  <i class="ace-icon fa fa-chevron-up"></i>
                                </a>

                              </div>
                            </div>

                            <div class="widget-body">
                              <div class="widget-main">
                              <?php
                              if (!empty($cat_telaah))
                              {
                                for ($i=0; $i<count($cat_telaah); $i++)
                                {
                                  $no = $i+1;
                                  echo '<h6 class="header smaller lighter">Penelaah #'.$no.'</h6>';
                                  echo isset($cat_telaah[$i]['catatanj']) && strlen(trim($cat_telaah[$i]['catatanj'])) > 0 ? stripslashes($cat_telaah[$i]['catatanj']) : '<i>null</i>';
                                  echo '<br/>';
                                }
                              }
                              else echo '<i>null</i>';
                              ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>

  									<div class="form-group">
  										<button class="btn btn-xs btn-info pull-right" data-bind="click: function(data, event){ uraian_before('J. Monitoring Penelitian', 'uraianj1') }">
  											<i class="ace-icon fa fa-square bigger-110"></i>
  											Data Sebelumnya
  										</button>
  									</div>
  									<div class="form-group">
  										<label for="j1">1. Sampel dari form laporan kasus yang sudah distandarisir, metode pencataran respon teraputik (deskripsi dan evaluasi metode dan frekuensi pengukuran), prosedur follow-up, dan, bila mungkin, ukuran yang diusulkan untuk menentukan tingkat kepatuhan subyek yang menerima treatmen <small><i>(lihat lampiran) (p17)</i></small></label>
  										<div class="wysiwyg-editor" id="j1"></div>
  									</div>
  								</div>

  								<div id="k" class="tab-pane">
  									<h4 class="header smaller lighter blue">K. Penghentian  Penelitian dan Alasannya</h4>

                  <?php if (isset($data['klasifikasi']) && $data['klasifikasi'] != 4) { ?>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-xs-12 col-sm-12 widget-container-col" >
                          <div class="widget-box widget-color-orange">
                            <div class="widget-header">
                              <h5 class="widget-title">Catatan Penelaah</h5>

                              <div class="widget-toolbar">
                                <?php if (isset($revisi_ke) && $revisi_ke+1 > 1) { ?>
                                <button class="btn btn-xs btn-default" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'K. Penghentian  Penelitian dan Alasannya', 'catatank') }">
                                  <i class="ace-icon fa fa-square bigger-110"></i>
                                  Catatan Sebelumnya
                                </button>
                                <?php } ?>

                                <a href="#" data-action="fullscreen">
                                  <i class="ace-icon fa fa-expand"></i>
                                </a>

                                <a href="#" data-action="collapse">
                                  <i class="ace-icon fa fa-chevron-up"></i>
                                </a>

                              </div>
                            </div>

                            <div class="widget-body">
                              <div class="widget-main">
                              <?php
                              if (!empty($cat_telaah))
                              {
                                for ($i=0; $i<count($cat_telaah); $i++)
                                {
                                  $no = $i+1;
                                  echo '<h6 class="header smaller lighter">Penelaah #'.$no.'</h6>';
                                  echo isset($cat_telaah[$i]['catatank']) && strlen(trim($cat_telaah[$i]['catatank'])) > 0 ? stripslashes($cat_telaah[$i]['catatank']) : '<i>null</i>';
                                  echo '<br/>';
                                }
                              }
                              else echo '<i>null</i>';
                              ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>

  									<div class="form-group">
  										<button class="btn btn-xs btn-info pull-right" data-bind="click: function(data, event){ uraian_before('K. Penghentian  Penelitian dan Alasannya', 'uraiank1') }">
  											<i class="ace-icon fa fa-square bigger-110"></i>
  											Data Sebelumnya
  										</button>
  									</div>
  									<div class="form-group">
  										<label for="k1">1. Aturan atau kriteria kapan subyek bisa diberhentikan dari penelitian atau uji klinis, atau, dalam hal studi multi senter, kapan sebuah pusat/lembaga di non aktipkan, dan kapan penelitian bisa dihentikan <small><i>(tidak lagi dilanjutkan)  (p22)</i></small></label>
  										<div class="wysiwyg-editor" id="k1"></div>
  									</div>
  								</div>

  								<div id="l" class="tab-pane">
  									<h4 class="header smaller lighter blue">L. Adverse Event dan Komplikasi (Kejadian Yang Tidak Diharapkan)</h4>

                  <?php if (isset($data['klasifikasi']) && $data['klasifikasi'] != 4) { ?>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-xs-12 col-sm-12 widget-container-col" >
                          <div class="widget-box widget-color-orange">
                            <div class="widget-header">
                              <h5 class="widget-title">Catatan Penelaah</h5>

                              <div class="widget-toolbar">
                                <?php if (isset($revisi_ke) && $revisi_ke+1 > 1) { ?>
                                <button class="btn btn-xs btn-default" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'L. Adverse Event dan Komplikasi (Kejadian Yang Tidak Diharapkan)', 'catatanl') }">
                                  <i class="ace-icon fa fa-square bigger-110"></i>
                                  Catatan Sebelumnya
                                </button>
                                <?php } ?>

                                <a href="#" data-action="fullscreen">
                                  <i class="ace-icon fa fa-expand"></i>
                                </a>

                                <a href="#" data-action="collapse">
                                  <i class="ace-icon fa fa-chevron-up"></i>
                                </a>

                              </div>
                            </div>

                            <div class="widget-body">
                              <div class="widget-main">
                              <?php
                              if (!empty($cat_telaah))
                              {
                                for ($i=0; $i<count($cat_telaah); $i++)
                                {
                                  $no = $i+1;
                                  echo '<h6 class="header smaller lighter">Penelaah #'.$no.'</h6>';
                                  echo isset($cat_telaah[$i]['catatanl']) && strlen(trim($cat_telaah[$i]['catatanl'])) > 0 ? stripslashes($cat_telaah[$i]['catatanl']) : '<i>null</i>';
                                  echo '<br/>';
                                }
                              }
                              else echo '<i>null</i>';
                              ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>

  									<div class="form-group">
  										<button class="btn btn-xs btn-info pull-right" data-bind="click: function(data, event){ uraian_before('L. Adverse Event dan Komplikasi (Kejadian Yang Tidak Diharapkan)', 'uraianl1') }">
  											<i class="ace-icon fa fa-square bigger-110"></i>
  											Data Sebelumnya
  										</button>
  									</div>
  									<div class="form-group">
  										<label for="l1">1. Metode pencatatan dan pelaporan adverse events atau reaksi, dan syarat penanganan komplikasi <small><i>(Guideline 4 dan 23)(p23)</i></small></label>
  										<div class="wysiwyg-editor" id="l1"></div>
  									</div>
  									<div class="form-group">
  										<button class="btn btn-xs btn-info pull-right" data-bind="click: function(data, event){ uraian_before('L. Adverse Event dan Komplikasi (Kejadian Yang Tidak Diharapkan)', 'uraianl2') }">
  											<i class="ace-icon fa fa-square bigger-110"></i>
  											Data Sebelumnya
  										</button>
  									</div>
  									<div class="form-group">
  										<label for="l2">2. Resiko-resiko yang diketahui dari adverse events, termasuk resiko yang terkait dengan masing masing rencana intervensi, dan terkait dengan obat, vaksin, atau terhadap prosudur yang akan diuji cobakan <small><i>(Guideline 4) (p24)</i></small></label>
  										<div class="wysiwyg-editor" id="l2"></div>
  									</div>
  								</div>

  								<div id="m" class="tab-pane">
  									<h4 class="header smaller lighter blue">M. Penanganan Komplikasi <small>(p27)</small></h4>

                  <?php if (isset($data['klasifikasi']) && $data['klasifikasi'] != 4) { ?>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-xs-12 col-sm-12 widget-container-col" >
                          <div class="widget-box widget-color-orange">
                            <div class="widget-header">
                              <h5 class="widget-title">Catatan Penelaah</h5>

                              <div class="widget-toolbar">
                                <?php if (isset($revisi_ke) && $revisi_ke+1 > 1) { ?>
                                <button class="btn btn-xs btn-default" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'M. Penanganan Komplikasi <small>(p27)</small>', 'catatanm') }">
                                  <i class="ace-icon fa fa-square bigger-110"></i>
                                  Catatan Sebelumnya
                                </button>
                                <?php } ?>

                                <a href="#" data-action="fullscreen">
                                  <i class="ace-icon fa fa-expand"></i>
                                </a>

                                <a href="#" data-action="collapse">
                                  <i class="ace-icon fa fa-chevron-up"></i>
                                </a>

                              </div>
                            </div>

                            <div class="widget-body">
                              <div class="widget-main">
                              <?php
                              if (!empty($cat_telaah))
                              {
                                for ($i=0; $i<count($cat_telaah); $i++)
                                {
                                  $no = $i+1;
                                  echo '<h6 class="header smaller lighter">Penelaah #'.$no.'</h6>';
                                  echo isset($cat_telaah[$i]['catatanm']) && strlen(trim($cat_telaah[$i]['catatanm'])) > 0 ? stripslashes($cat_telaah[$i]['catatanm']) : '<i>null</i>';
                                  echo '<br/>';
                                }
                              }
                              else echo '<i>null</i>';
                              ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>

  									<div class="form-group">
  										<button class="btn btn-xs btn-info pull-right" data-bind="click: function(data, event){ uraian_before('M. Penanganan Komplikasi <small>(p27)</small>', 'uraianm1') }">
  											<i class="ace-icon fa fa-square bigger-110"></i>
  											Data Sebelumnya
  										</button>
  									</div>
  									<div class="form-group">
  										<label for="m1">
  											1. Rencana detil bila ada resiko lebih dari minimal/ luka fisik, membuat rencana detil<br>
  											2. Adanya asuransi<br>
  											3. Adanya fasilitas pengobatan / biaya pengobatan<br>
  											4. Kompensasi jika terjadi disabilitas atau kematian <small><i>(Guideline 14)</i></small>
  										</label>
  										<div class="wysiwyg-editor" id="m1"></div>
  									</div>
  								</div>

  								<div id="n" class="tab-pane">
  									<h4 class="header smaller lighter blue">N. Manfaat</h4>

                  <?php if (isset($data['klasifikasi']) && $data['klasifikasi'] != 4) { ?>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-xs-12 col-sm-12 widget-container-col" >
                          <div class="widget-box widget-color-orange">
                            <div class="widget-header">
                              <h5 class="widget-title">Catatan Penelaah</h5>

                              <div class="widget-toolbar">
                                <?php if (isset($revisi_ke) && $revisi_ke+1 > 1) { ?>
                                <button class="btn btn-xs btn-default" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'N. Manfaat', 'catatann') }">
                                  <i class="ace-icon fa fa-square bigger-110"></i>
                                  Catatan Sebelumnya
                                </button>
                                <?php } ?>

                                <a href="#" data-action="fullscreen">
                                  <i class="ace-icon fa fa-expand"></i>
                                </a>

                                <a href="#" data-action="collapse">
                                  <i class="ace-icon fa fa-chevron-up"></i>
                                </a>

                              </div>
                            </div>

                            <div class="widget-body">
                              <div class="widget-main">
                              <?php
                              if (!empty($cat_telaah))
                              {
                                for ($i=0; $i<count($cat_telaah); $i++)
                                {
                                  $no = $i+1;
                                  echo '<h6 class="header smaller lighter">Penelaah #'.$no.'</h6>';
                                  echo isset($cat_telaah[$i]['catatann']) && strlen(trim($cat_telaah[$i]['catatann'])) > 0 ? stripslashes($cat_telaah[$i]['catatann']) : '<i>null</i>';
                                  echo '<br/>';
                                }
                              }
                              else echo '<i>null</i>';
                              ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>

  									<div class="form-group">
  										<button class="btn btn-xs btn-info pull-right" data-bind="click: function(data, event){ uraian_before('N. Manfaat', 'uraiann1') }">
  											<i class="ace-icon fa fa-square bigger-110"></i>
  											Data Sebelumnya
  										</button>
  									</div>
  									<div class="form-group">
  										<label for="n1">1. Manfaat penelitian secara pribadi bagi subyek dan bagi yang lainnya <small><i>(Guideline 4) (p25)</i></small></label>
  										<div class="wysiwyg-editor" id="n1"></div>
  									</div>
  									<div class="form-group">
  										<button class="btn btn-xs btn-info pull-right" data-bind="click: function(data, event){ uraian_before('N. Manfaat', 'uraiann2') }">
  											<i class="ace-icon fa fa-square bigger-110"></i>
  											Data Sebelumnya
  										</button>
  									</div>
  									<div class="form-group">
  										<label for="n2">2. Manfaat penelitian bagi penduduk, termasuk pengetahuan baru yang kemungkinan dihasilkan oleh penelitian <small><i>(Guidelines 1 and 4)(p26)</i></small></label>
  										<div class="wysiwyg-editor" id="n2"></div>
  									</div>
  								</div>

  								<div id="o" class="tab-pane">
  									<h4 class="header smaller lighter blue">O. Jaminan Keberlanjutan Manfaat <small><i>(p28)</i></small></h4>

                  <?php if (isset($data['klasifikasi']) && $data['klasifikasi'] != 4) { ?>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-xs-12 col-sm-12 widget-container-col" >
                          <div class="widget-box widget-color-orange">
                            <div class="widget-header">
                              <h5 class="widget-title">Catatan Penelaah</h5>

                              <div class="widget-toolbar">
                                <?php if (isset($revisi_ke) && $revisi_ke+1 > 1) { ?>
                                <button class="btn btn-xs btn-default" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'O. Jaminan Keberlanjutan Manfaat <small><i>(p28)</i></small>', 'catatano') }">
                                  <i class="ace-icon fa fa-square bigger-110"></i>
                                  Catatan Sebelumnya
                                </button>
                                <?php } ?>

                                <a href="#" data-action="fullscreen">
                                  <i class="ace-icon fa fa-expand"></i>
                                </a>

                                <a href="#" data-action="collapse">
                                  <i class="ace-icon fa fa-chevron-up"></i>
                                </a>

                              </div>
                            </div>

                            <div class="widget-body">
                              <div class="widget-main">
                              <?php
                              if (!empty($cat_telaah))
                              {
                                for ($i=0; $i<count($cat_telaah); $i++)
                                {
                                  $no = $i+1;
                                  echo '<h6 class="header smaller lighter">Penelaah #'.$no.'</h6>';
                                  echo isset($cat_telaah[$i]['catatano']) && strlen(trim($cat_telaah[$i]['catatano'])) > 0 ? stripslashes($cat_telaah[$i]['catatano']) : '<i>null</i>';
                                  echo '<br/>';
                                }
                              }
                              else echo '<i>null</i>';
                              ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>

  									<div class="form-group">
  										<button class="btn btn-xs btn-info pull-right" data-bind="click: function(data, event){ uraian_before('O. Jaminan Keberlanjutan Manfaat <small><i>(p28)</i></small>', 'uraiano1') }">
  											<i class="ace-icon fa fa-square bigger-110"></i>
  											Data Sebelumnya
  										</button>
  									</div>
  									<div class="form-group">
  										<label for="o1">
  											1. Kemungkinan keberlanjutan akses bila hasil intervensi menghasilkan manfaat yang signifikan, <br>
  											2. Modalitas yang tersedia, <br>
  											3. Pihak pihak yang akan mendapatkan keberlansungan pengobatan, organisasi yang akan membayar, <br>
  											4. Berapa lama <small><i>(Guideline 6)</i></small>
  										</label>
  										<br>
  										<div class="wysiwyg-editor" id="o1"></div>
  									</div>
  								</div>

  								<div id="p" class="tab-pane">
  									<h4 class="header smaller lighter blue">P. Informed Consent <small><i>(Upload IC 35 butir di Tab CC)</i></small></h4>

                  <?php if (isset($data['klasifikasi']) && $data['klasifikasi'] != 4) { ?>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-xs-12 col-sm-12 widget-container-col" >
                          <div class="widget-box widget-color-orange">
                            <div class="widget-header">
                              <h5 class="widget-title">Catatan Penelaah</h5>

                              <div class="widget-toolbar">
                                <?php if (isset($revisi_ke) && $revisi_ke+1 > 1) { ?>
                                <button class="btn btn-xs btn-default" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'P. Informed Consent <small><i>(Upload IC 35 butir di Tab CC)</i></small>', 'catatanp') }">
                                  <i class="ace-icon fa fa-square bigger-110"></i>
                                  Catatan Sebelumnya
                                </button>
                                <?php } ?>

                                <a href="#" data-action="fullscreen">
                                  <i class="ace-icon fa fa-expand"></i>
                                </a>

                                <a href="#" data-action="collapse">
                                  <i class="ace-icon fa fa-chevron-up"></i>
                                </a>

                              </div>
                            </div>

                            <div class="widget-body">
                              <div class="widget-main">
                              <?php
                              if (!empty($cat_telaah))
                              {
                                for ($i=0; $i<count($cat_telaah); $i++)
                                {
                                  $no = $i+1;
                                  echo '<h6 class="header smaller lighter">Penelaah #'.$no.'</h6>';
                                  echo isset($cat_telaah[$i]['catatanp']) && strlen(trim($cat_telaah[$i]['catatanp'])) > 0 ? stripslashes($cat_telaah[$i]['catatanp']) : '<i>null</i>';
                                  echo '<br/>';
                                }
                              }
                              else echo '<i>null</i>';
                              ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>

  									<div class="form-group">
  										<button class="btn btn-xs btn-info pull-right" data-bind="click: function(data, event){ uraian_before('P. Informed Consent <small><i>(Upload IC 35 butir di Tab CC)</i></small>', 'uraianp1') }">
  											<i class="ace-icon fa fa-square bigger-110"></i>
  											Data Sebelumnya
  										</button>
  									</div>
  									<div class="form-group">
  										<label for="p1">1. Cara untuk mendapatkan informed consent dan prosudur yang direncanakan untuk mengkomunikasikan informasi penelitian(Persetujuan Setelah Penjelasan/PSP) kepada calon subyek, termasuk nama dan posisi wali bagi yang tidak bisa memberikannya. <small><i>(Guideline 9)(p30)</i></small></label>
  										<div class="wysiwyg-editor" id="p1"></div>
  									</div>
  									<div class="form-group">
  										<button class="btn btn-xs btn-info pull-right" data-bind="click: function(data, event){ uraian_before('P. Informed Consent <small><i>(Upload IC 35 butir di Tab CC)</i></small>', 'uraianp2') }">
  											<i class="ace-icon fa fa-square bigger-110"></i>
  											Data Sebelumnya
  										</button>
  									</div>
  									<div class="form-group">
  										<label for="p2">2. Khusus Ibu Hamil: adanya perencanaan untuk memonitor kesehatan ibu dan kesehatan anak jangka pendek maupun jangka panjang <small><i>(Guideline 19)(p29)</i></small></label>
  										<div class="wysiwyg-editor" id="p2"></div>
  									</div>
  								</div>

  								<div id="q" class="tab-pane">
  									<h4 class="header smaller lighter blue">Q. Wali <small><i>(p31)</i></small></h4>

                  <?php if (isset($data['klasifikasi']) && $data['klasifikasi'] != 4) { ?>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-xs-12 col-sm-12 widget-container-col" >
                          <div class="widget-box widget-color-orange">
                            <div class="widget-header">
                              <h5 class="widget-title">Catatan Penelaah</h5>

                              <div class="widget-toolbar">
                                <?php if (isset($revisi_ke) && $revisi_ke+1 > 1) { ?>
                                <button class="btn btn-xs btn-default" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'Q. Wali <small><i>(p31)</i></small>', 'catatanq') }">
                                  <i class="ace-icon fa fa-square bigger-110"></i>
                                  Catatan Sebelumnya
                                </button>
                                <?php } ?>

                                <a href="#" data-action="fullscreen">
                                  <i class="ace-icon fa fa-expand"></i>
                                </a>

                                <a href="#" data-action="collapse">
                                  <i class="ace-icon fa fa-chevron-up"></i>
                                </a>

                              </div>
                            </div>

                            <div class="widget-body">
                              <div class="widget-main">
                              <?php
                              if (!empty($cat_telaah))
                              {
                                for ($i=0; $i<count($cat_telaah); $i++)
                                {
                                  $no = $i+1;
                                  echo '<h6 class="header smaller lighter">Penelaah #'.$no.'</h6>';
                                  echo isset($cat_telaah[$i]['catatanq']) && strlen(trim($cat_telaah[$i]['catatanq'])) > 0 ? stripslashes($cat_telaah[$i]['catatanq']) : '<i>null</i>';
                                  echo '<br/>';
                                }
                              }
                              else echo '<i>null</i>';
                              ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>

  									<div class="form-group">
  										<button class="btn btn-xs btn-info pull-right" data-bind="click: function(data, event){ uraian_before('Q. Wali <small><i>(p31)</i></small>', 'uraianq1') }">
  											<i class="ace-icon fa fa-square bigger-110"></i>
  											Data Sebelumnya
  										</button>
  									</div>
  									<div class="form-group">
  										<label for="q1">1. Adanya wali yang berhak bila calon subyek tidak bisa memberikan informed consent <small><i>(Guidelines 16 and 17)</i></small></label>
  										<div class="wysiwyg-editor" id="q1"></div>
  									</div>
  									<div class="form-group">
  										<button class="btn btn-xs btn-info pull-right" data-bind="click: function(data, event){ uraian_before('Q. Wali <small><i>(p31)</i></small>', 'uraianq2') }">
  											<i class="ace-icon fa fa-square bigger-110"></i>
  											Data Sebelumnya
  										</button>
  									</div>
  									<div class="form-group">
  										<label for="q2">2. Adanya orang tua atau wali yang berhak bila anak paham tentang informed consent tapi belum cukup umur <small><i>(Guidelines 16 and 17)</i></small></label>
  										<div class="wysiwyg-editor" id="q2"></div>
  									</div>
  								</div>

  								<div id="r" class="tab-pane">
  									<h4 class="header smaller lighter blue">R. Bujukan</h4>

                  <?php if (isset($data['klasifikasi']) && $data['klasifikasi'] != 4) { ?>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-xs-12 col-sm-12 widget-container-col" >
                          <div class="widget-box widget-color-orange">
                            <div class="widget-header">
                              <h5 class="widget-title">Catatan Penelaah</h5>

                              <div class="widget-toolbar">
                                <?php if (isset($revisi_ke) && $revisi_ke+1 > 1) { ?>
                                <button class="btn btn-xs btn-default" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'R. Bujukan', 'catatanr') }">
                                  <i class="ace-icon fa fa-square bigger-110"></i>
                                  Catatan Sebelumnya
                                </button>
                                <?php } ?>

                                <a href="#" data-action="fullscreen">
                                  <i class="ace-icon fa fa-expand"></i>
                                </a>

                                <a href="#" data-action="collapse">
                                  <i class="ace-icon fa fa-chevron-up"></i>
                                </a>

                              </div>
                            </div>

                            <div class="widget-body">
                              <div class="widget-main">
                              <?php
                              if (!empty($cat_telaah))
                              {
                                for ($i=0; $i<count($cat_telaah); $i++)
                                {
                                  $no = $i+1;
                                  echo '<h6 class="header smaller lighter">Penelaah #'.$no.'</h6>';
                                  echo isset($cat_telaah[$i]['catatanr']) && strlen(trim($cat_telaah[$i]['catatanr'])) > 0 ? stripslashes($cat_telaah[$i]['catatanr']) : '<i>null</i>';
                                  echo '<br/>';
                                }
                              }
                              else echo '<i>null</i>';
                              ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>

  									<div class="form-group">
  										<button class="btn btn-xs btn-info pull-right" data-bind="click: function(data, event){ uraian_before('R. Bujukan', 'uraianr1') }">
  											<i class="ace-icon fa fa-square bigger-110"></i>
  											Data Sebelumnya
  										</button>
  									</div>
  									<div class="form-group">
  										<label for="r1">1. Deskripsi bujukan atau insentif (bahan kontak) bagi calon subyek untuk ikut berpartisipasi, seperti uang, hadiah, layanan gratis, atau yang lainnya <small><i>(p32)</i></small></label>
  										<div class="wysiwyg-editor" id="r1"></div>
  									</div>
  									<div class="form-group">
  										<button class="btn btn-xs btn-info pull-right" data-bind="click: function(data, event){ uraian_before('R. Bujukan', 'uraianr2') }">
  											<i class="ace-icon fa fa-square bigger-110"></i>
  											Data Sebelumnya
  										</button>
  									</div>
  									<div class="form-group">
  										<label for="r2">2. Rencana dan prosedur, dan orang yang betanggung jawab untuk menginformasikan bahaya atau keuntungan peserta, atau tentang riset lain tentang topik yang sama, yang bisa mempengaruhi keberlansungan keterlibatan subyek dalam penelitian<small><i>(Guideline 9) (p33)</i></small></label>
  										<div class="wysiwyg-editor" id="r2"></div>
  									</div>
  									<div class="form-group">
  										<button class="btn btn-xs btn-info pull-right" data-bind="click: function(data, event){ uraian_before('R. Bujukan', 'uraianr3') }">
  											<i class="ace-icon fa fa-square bigger-110"></i>
  											Data Sebelumnya
  										</button>
  									</div>
  									<div class="form-group">
  										<label for="r3">3. Perencanaan untuk menginformasikan hasil penelitian pada subyek atau partisipan <small><i>(p34)</i></small></label>
  										<div class="wysiwyg-editor" id="r3"></div>
  									</div>
  								</div>

  								<div id="s" class="tab-pane">
  									<h4 class="header smaller lighter blue">S. Penjagaan Kerahasiaan</h4>

                  <?php if (isset($data['klasifikasi']) && $data['klasifikasi'] != 4) { ?>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-xs-12 col-sm-12 widget-container-col" >
                          <div class="widget-box widget-color-orange">
                            <div class="widget-header">
                              <h5 class="widget-title">Catatan Penelaah</h5>

                              <div class="widget-toolbar">
                                <?php if (isset($revisi_ke) && $revisi_ke+1 > 1) { ?>
                                <button class="btn btn-xs btn-default" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'S. Penjagaan Kerahasiaan', 'catatans') }">
                                  <i class="ace-icon fa fa-square bigger-110"></i>
                                  Catatan Sebelumnya
                                </button>
                                <?php } ?>

                                <a href="#" data-action="fullscreen">
                                  <i class="ace-icon fa fa-expand"></i>
                                </a>

                                <a href="#" data-action="collapse">
                                  <i class="ace-icon fa fa-chevron-up"></i>
                                </a>

                              </div>
                            </div>

                            <div class="widget-body">
                              <div class="widget-main">
                              <?php
                              if (!empty($cat_telaah))
                              {
                                for ($i=0; $i<count($cat_telaah); $i++)
                                {
                                  $no = $i+1;
                                  echo '<h6 class="header smaller lighter">Penelaah #'.$no.'</h6>';
                                  echo isset($cat_telaah[$i]['catatans']) && strlen(trim($cat_telaah[$i]['catatans'])) > 0 ? stripslashes($cat_telaah[$i]['catatans']) : '<i>null</i>';
                                  echo '<br/>';
                                }
                              }
                              else echo '<i>null</i>';
                              ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>

  									<div class="form-group">
  										<button class="btn btn-xs btn-info pull-right" data-bind="click: function(data, event){ uraian_before('S. Penjagaan Kerahasiaan', 'uraians1') }">
  											<i class="ace-icon fa fa-square bigger-110"></i>
  											Data Sebelumnya
  										</button>
  									</div>
  									<div class="form-group">
  										<label for="s1">1. Proses rekrutmen subyek (misalnya lewat iklan), serta langkah langkah untuk menjaga privasi dan kerahasiaan selama rekrutmen <small><i>(Guideline 3) (p16)</i></small></label>
  										<div class="wysiwyg-editor" id="s1"></div>
  									</div>
  									<div class="form-group">
  										<button class="btn btn-xs btn-info pull-right" data-bind="click: function(data, event){ uraian_before('S. Penjagaan Kerahasiaan', 'uraians2') }">
  											<i class="ace-icon fa fa-square bigger-110"></i>
  											Data Sebelumnya
  										</button>
  									</div>
  									<div class="form-group">
  										<label for="s2">2. Langkah langkah proteksi kerahasiaan data pribadi, dan penghormatan privasi orang, termasuk kehati-hatian untuk mencegah bocornya rahasia hasil test genetik pada keluarga kecuali atas izin dari yang bersangkutan <small><i>(Guidelines 4, 11, 12 and 24) (p 35)</i></small></label>
  										<div class="wysiwyg-editor" id="s2"></div>
  									</div>
  									<div class="form-group">
  										<button class="btn btn-xs btn-info pull-right" data-bind="click: function(data, event){ uraian_before('S. Penjagaan Kerahasiaan', 'uraians3') }">
  											<i class="ace-icon fa fa-square bigger-110"></i>
  											Data Sebelumnya
  										</button>
  									</div>
  									<div class="form-group">
  										<label for="s3">3. Informasi tentang bagaimana koding; bila ada, untuk identitas subyek, di mana di simpan dan kapan, bagaimana dan oleh siapa bisa dibuka bila terjadi emergensi <small><i>(Guidelines 11 and 12) (p36)</i></small></label>
  										<div class="wysiwyg-editor" id="s3"></div>
  									</div>
  									<div class="form-group">
  										<button class="btn btn-xs btn-info pull-right" data-bind="click: function(data, event){ uraian_before('S. Penjagaan Kerahasiaan', 'uraians4') }">
  											<i class="ace-icon fa fa-square bigger-110"></i>
  											Data Sebelumnya
  										</button>
  									</div>
  									<div class="form-group">
  										<label for="s4">4. Kemungkinan penggunaan lebih jauh dari data personal atau material biologis/BBT <small><i>(p37)</i></small></label>
  										<div class="wysiwyg-editor" id="s4"></div>
  									</div>
  								</div>

  								<div id="t" class="tab-pane">
  									<h4 class="header smaller lighter blue">T. Rencana Analisis</h4>

                  <?php if (isset($data['klasifikasi']) && $data['klasifikasi'] != 4) { ?>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-xs-12 col-sm-12 widget-container-col" >
                          <div class="widget-box widget-color-orange">
                            <div class="widget-header">
                              <h5 class="widget-title">Catatan Penelaah</h5>

                              <div class="widget-toolbar">
                                <?php if (isset($revisi_ke) && $revisi_ke+1 > 1) { ?>
                                <button class="btn btn-xs btn-default" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'T. Rencana Analisis', 'catatant') }">
                                  <i class="ace-icon fa fa-square bigger-110"></i>
                                  Catatan Sebelumnya
                                </button>
                                <?php } ?>

                                <a href="#" data-action="fullscreen">
                                  <i class="ace-icon fa fa-expand"></i>
                                </a>

                                <a href="#" data-action="collapse">
                                  <i class="ace-icon fa fa-chevron-up"></i>
                                </a>

                              </div>
                            </div>

                            <div class="widget-body">
                              <div class="widget-main">
                              <?php
                              if (!empty($cat_telaah))
                              {
                                for ($i=0; $i<count($cat_telaah); $i++)
                                {
                                  $no = $i+1;
                                  echo '<h6 class="header smaller lighter">Penelaah #'.$no.'</h6>';
                                  echo isset($cat_telaah[$i]['catatant']) && strlen(trim($cat_telaah[$i]['catatant'])) > 0 ? stripslashes($cat_telaah[$i]['catatant']) : '<i>null</i>';
                                  echo '<br/>';
                                }
                              }
                              else echo '<i>null</i>';
                              ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>

  									<div class="form-group">
  										<button class="btn btn-xs btn-info pull-right" data-bind="click: function(data, event){ uraian_before('T. Rencana Analisis', 'uraiant1') }">
  											<i class="ace-icon fa fa-square bigger-110"></i>
  											Data Sebelumnya
  										</button>
  									</div>
  									<div class="form-group">
  										<label for="t1">1. Deskripsi tentang rencana  analisa statistik, dan kreteria bila atau dalam kondisi bagaimana akan terjadi penghentian dini keseluruhan penelitian <small><i>(Guideline 4) (B,S2)</i></small></label>
  										<div class="wysiwyg-editor" id="t1"></div>
  									</div>
  								</div>

  								<div id="u" class="tab-pane">
  									<h4 class="header smaller lighter blue">U. Monitor Keamanan</h4>

                  <?php if (isset($data['klasifikasi']) && $data['klasifikasi'] != 4) { ?>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-xs-12 col-sm-12 widget-container-col" >
                          <div class="widget-box widget-color-orange">
                            <div class="widget-header">
                              <h5 class="widget-title">Catatan Penelaah</h5>

                              <div class="widget-toolbar">
                                <?php if (isset($revisi_ke) && $revisi_ke+1 > 1) { ?>
                                <button class="btn btn-xs btn-default" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'U. Monitor Keamanan', 'catatanu') }">
                                  <i class="ace-icon fa fa-square bigger-110"></i>
                                  Catatan Sebelumnya
                                </button>
                                <?php } ?>

                                <a href="#" data-action="fullscreen">
                                  <i class="ace-icon fa fa-expand"></i>
                                </a>

                                <a href="#" data-action="collapse">
                                  <i class="ace-icon fa fa-chevron-up"></i>
                                </a>

                              </div>
                            </div>

                            <div class="widget-body">
                              <div class="widget-main">
                              <?php
                              if (!empty($cat_telaah))
                              {
                                for ($i=0; $i<count($cat_telaah); $i++)
                                {
                                  $no = $i+1;
                                  echo '<h6 class="header smaller lighter">Penelaah #'.$no.'</h6>';
                                  echo isset($cat_telaah[$i]['catatanu']) && strlen(trim($cat_telaah[$i]['catatanu'])) > 0 ? stripslashes($cat_telaah[$i]['catatanu']) : '<i>null</i>';
                                  echo '<br/>';
                                }
                              }
                              else echo '<i>null</i>';
                              ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>

  									<div class="form-group">
  										<button class="btn btn-xs btn-info pull-right" data-bind="click: function(data, event){ uraian_before('U. Monitor Keamanan', 'uraianu1') }">
  											<i class="ace-icon fa fa-square bigger-110"></i>
  											Data Sebelumnya
  										</button>
  									</div>
  									<div class="form-group">
  										<label for="u1">1. Rencana untuk memonitor keberlansungan keamanan obat atau intervensi lain yang dilakukan dalam penelitian atau trial, dan, bila diperlukan, pembentukan komite independen untuk data dan safety monitoring <small><i>(Guideline 4) (B,S3,S7)</i></small></label>
  										<div class="wysiwyg-editor" id="u1"></div>
  									</div>
  								</div>

  								<div id="v" class="tab-pane">
  									<h4 class="header smaller lighter blue">V. Konflik Kepentingan</h4>

                  <?php if (isset($data['klasifikasi']) && $data['klasifikasi'] != 4) { ?>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-xs-12 col-sm-12 widget-container-col" >
                          <div class="widget-box widget-color-orange">
                            <div class="widget-header">
                              <h5 class="widget-title">Catatan Penelaah</h5>

                              <div class="widget-toolbar">
                                <?php if (isset($revisi_ke) && $revisi_ke+1 > 1) { ?>
                                <button class="btn btn-xs btn-default" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'V. Konflik Kepentingan', 'catatanv') }">
                                  <i class="ace-icon fa fa-square bigger-110"></i>
                                  Catatan Sebelumnya
                                </button>
                                <?php } ?>

                                <a href="#" data-action="fullscreen">
                                  <i class="ace-icon fa fa-expand"></i>
                                </a>

                                <a href="#" data-action="collapse">
                                  <i class="ace-icon fa fa-chevron-up"></i>
                                </a>

                              </div>
                            </div>

                            <div class="widget-body">
                              <div class="widget-main">
                              <?php
                              if (!empty($cat_telaah))
                              {
                                for ($i=0; $i<count($cat_telaah); $i++)
                                {
                                  $no = $i+1;
                                  echo '<h6 class="header smaller lighter">Penelaah #'.$no.'</h6>';
                                  echo isset($cat_telaah[$i]['catatanv']) && strlen(trim($cat_telaah[$i]['catatanv'])) > 0 ? stripslashes($cat_telaah[$i]['catatanv']) : '<i>null</i>';
                                  echo '<br/>';
                                }
                              }
                              else echo '<i>null</i>';
                              ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>

  									<div class="form-group">
  										<button class="btn btn-xs btn-info pull-right" data-bind="click: function(data, event){ uraian_before('V. Konflik Kepentingan', 'uraianv1') }">
  											<i class="ace-icon fa fa-square bigger-110"></i>
  											Data Sebelumnya
  										</button>
  									</div>
  									<div class="form-group">
  										<label for="v1">1. Pengaturan untuk mengatasi konflik finansial atau yang lainnya yang bisa mempengaruhi keputusan para peneliti atau personil lainya; menginformasikan pada komite lembaga tentang adanya conflict of interest; komite mengkomunikasikannya ke komite etik dan kemudian mengkomunikasikan pada para peneliti tentang langkah langkah berikutnya yang harus dilakukan <small><i>(Guideline 25) (p42)</i></small></label>
  										<div class="wysiwyg-editor" id="v1"></div>
  									</div>
  								</div>

  								<div id="w" class="tab-pane">
  									<h4 class="header smaller lighter blue">W. Manfaat Sosial</h4>

                  <?php if (isset($data['klasifikasi']) && $data['klasifikasi'] != 4) { ?>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-xs-12 col-sm-12 widget-container-col" >
                          <div class="widget-box widget-color-orange">
                            <div class="widget-header">
                              <h5 class="widget-title">Catatan Penelaah</h5>

                              <div class="widget-toolbar">
                                <?php if (isset($revisi_ke) && $revisi_ke+1 > 1) { ?>
                                <button class="btn btn-xs btn-default" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'W. Manfaat Sosial', 'catatanw') }">
                                  <i class="ace-icon fa fa-square bigger-110"></i>
                                  Catatan Sebelumnya
                                </button>
                                <?php } ?>

                                <a href="#" data-action="fullscreen">
                                  <i class="ace-icon fa fa-expand"></i>
                                </a>

                                <a href="#" data-action="collapse">
                                  <i class="ace-icon fa fa-chevron-up"></i>
                                </a>

                              </div>
                            </div>

                            <div class="widget-body">
                              <div class="widget-main">
                              <?php
                              if (!empty($cat_telaah))
                              {
                                for ($i=0; $i<count($cat_telaah); $i++)
                                {
                                  $no = $i+1;
                                  echo '<h6 class="header smaller lighter">Penelaah #'.$no.'</h6>';
                                  echo isset($cat_telaah[$i]['catatanw']) && strlen(trim($cat_telaah[$i]['catatanw'])) > 0 ? stripslashes($cat_telaah[$i]['catatanw']) : '<i>null</i>';
                                  echo '<br/>';
                                }
                              }
                              else echo '<i>null</i>';
                              ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>

  									<div class="form-group">
  										<button class="btn btn-xs btn-info pull-right" data-bind="click: function(data, event){ uraian_before('W. Manfaat Sosial', 'uraianw1') }">
  											<i class="ace-icon fa fa-square bigger-110"></i>
  											Data Sebelumnya
  										</button>
  									</div>
  									<div class="form-group">
  										<label for="w1">1. Untuk penelitian yang dilakukan pada seting sumberdaya lemah, kontribusi yang dilakukan sponsor untuk capacity building untuk review ilmiah dan etika dan untuk riset-riset kesehatan di negara tersebut; dan jaminan bahwa tujuan capacity building adalah agar sesuai nilai dan harapan para partisipan dan komunitas tempat penelitian <small><i>(Guideline 8) (p43)</i></small></label>
  										<div class="wysiwyg-editor" id="w1"></div>
  									</div>
  									<div class="form-group">
  										<button class="btn btn-xs btn-info pull-right" data-bind="click: function(data, event){ uraian_before('W. Manfaat Sosial', 'uraianw2') }">
  											<i class="ace-icon fa fa-square bigger-110"></i>
  											Data Sebelumnya
  										</button>
  									</div>
  									<div class="form-group">
  										<label for="w2">2. Protokol penelitian (dokumen) yang dikirim ke komite etik harus meliputi deskripsi rencana pelibatan komunitas, dan menunjukkan sumber-sumber yang dialokasikan untuk aktivitas aktivitas pelibatan tersebut. Dokumen ini menjelaskan apa yang sudah dan yang akan dilakukan, kapan dan oleh siapa, untuk memastikan bahwa masyarakat dengan jelas terpetakan untuk memudahkan pelibatan mereka selama riset, untuk memastikan bahwa tujuan riset sesuai kebutuhan masyarakat dan diterima oleh mereka. Bila perlu masyarakat harus dilibatkan dalam penyusunan protokol atau dokumen ini <small><i>(Guideline 7) (p44)</i></small></label>
  										<div class="wysiwyg-editor" id="w2"></div>
  									</div>
  								</div>

  								<div id="x" class="tab-pane">
  									<h4 class="header smaller lighter blue">X. Hak atas Data</h4>

                  <?php if (isset($data['klasifikasi']) && $data['klasifikasi'] != 4) { ?>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-xs-12 col-sm-12 widget-container-col" >
                          <div class="widget-box widget-color-orange">
                            <div class="widget-header">
                              <h5 class="widget-title">Catatan Penelaah</h5>

                              <div class="widget-toolbar">
                                <?php if (isset($revisi_ke) && $revisi_ke+1 > 1) { ?>
                                <button class="btn btn-xs btn-default" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'X. Hak atas Data', 'catatanx') }">
                                  <i class="ace-icon fa fa-square bigger-110"></i>
                                  Catatan Sebelumnya
                                </button>
                                <?php } ?>

                                <a href="#" data-action="fullscreen">
                                  <i class="ace-icon fa fa-expand"></i>
                                </a>

                                <a href="#" data-action="collapse">
                                  <i class="ace-icon fa fa-chevron-up"></i>
                                </a>

                              </div>
                            </div>

                            <div class="widget-body">
                              <div class="widget-main">
                              <?php
                              if (!empty($cat_telaah))
                              {
                                for ($i=0; $i<count($cat_telaah); $i++)
                                {
                                  $no = $i+1;
                                  echo '<h6 class="header smaller lighter">Penelaah #'.$no.'</h6>';
                                  echo isset($cat_telaah[$i]['catatanx']) && strlen(trim($cat_telaah[$i]['catatanx'])) > 0 ? stripslashes($cat_telaah[$i]['catatanx']) : '<i>null</i>';
                                  echo '<br/>';
                                }
                              }
                              else echo '<i>null</i>';
                              ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>

  									<div class="form-group">
  										<button class="btn btn-xs btn-info pull-right" data-bind="click: function(data, event){ uraian_before('X. Hak atas Data', 'uraianx1') }">
  											<i class="ace-icon fa fa-square bigger-110"></i>
  											Data Sebelumnya
  										</button>
  									</div>
  									<div class="form-group">
  										<label for="x1">1. Terutama bila sponsor adalah industri, kontrak yang menyatakan siapa pemilik hak publiksi hasil riset, dan kewajiban untuk menyiapkan bersama dan diberikan pada para PI draft laporan hasil riset <small><i>(Guideline 24) (B dan H, S1,S7)</i></small></label>
  										<div class="wysiwyg-editor" id="x1"></div>
  									</div>
  								</div>

  								<div id="y" class="tab-pane">
  									<h4 class="header smaller lighter blue">Y. Publikasi</h4>

                  <?php if (isset($data['klasifikasi']) && $data['klasifikasi'] != 4) { ?>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-xs-12 col-sm-12 widget-container-col" >
                          <div class="widget-box widget-color-orange">
                            <div class="widget-header">
                              <h5 class="widget-title">Catatan Penelaah</h5>

                              <div class="widget-toolbar">
                                <?php if (isset($revisi_ke) && $revisi_ke+1 > 1) { ?>
                                <button class="btn btn-xs btn-default" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'Y. Publikasi', 'catatany') }">
                                  <i class="ace-icon fa fa-square bigger-110"></i>
                                  Catatan Sebelumnya
                                </button>
                                <?php } ?>

                                <a href="#" data-action="fullscreen">
                                  <i class="ace-icon fa fa-expand"></i>
                                </a>

                                <a href="#" data-action="collapse">
                                  <i class="ace-icon fa fa-chevron-up"></i>
                                </a>

                              </div>
                            </div>

                            <div class="widget-body">
                              <div class="widget-main">
                              <?php
                              if (!empty($cat_telaah))
                              {
                                for ($i=0; $i<count($cat_telaah); $i++)
                                {
                                  $no = $i+1;
                                  echo '<h6 class="header smaller lighter">Penelaah #'.$no.'</h6>';
                                  echo isset($cat_telaah[$i]['catatany']) && strlen(trim($cat_telaah[$i]['catatany'])) > 0 ? stripslashes($cat_telaah[$i]['catatany']) : '<i>null</i>';
                                  echo '<br/>';
                                }
                              }
                              else echo '<i>null</i>';
                              ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>

  									<div class="form-group">
  										<button class="btn btn-xs btn-info pull-right" data-bind="click: function(data, event){ uraian_before('Y. Publikasi', 'uraiany1') }">
  											<i class="ace-icon fa fa-square bigger-110"></i>
  											Data Sebelumnya
  										</button>
  									</div>
  									<div class="form-group">
  										<label for="y1">Rencana publikasi hasil pada bidang tertentu (seperti epidemiology, generik, sosiologi) yang bisa beresiko berlawanan dengan kemaslahatan komunitas, masyarakat, keluarga, etnik tertentu, dan meminimalisir resiko kemudharatan kelompok ini dengan selalu mempertahankan kerahasiaan data selama dan setelah penelitian, dan mempublikasi hasil hasil penelitian sedemikian rupa dengan selalu mempertimbangkan martabat dan kemulyaan mereka <small><i>(Guideline 4) (p47)</i></small></label>
  										<div class="wysiwyg-editor" id="y1"></div>
  									</div>
  									<div class="form-group">
  										<button class="btn btn-xs btn-info pull-right" data-bind="click: function(data, event){ uraian_before('Y. Publikasi', 'uraiany2') }">
  											<i class="ace-icon fa fa-square bigger-110"></i>
  											Data Sebelumnya
  										</button>
  									</div>
  									<div class="form-group">
  										<label for="y2">Bagaimana publikasi bila hasil riset negatip. <small><i>(Guideline 24) (p46)</i></small></label>
  										<div class="wysiwyg-editor" id="y2"></div>
  									</div>
  								</div>

  								<div id="z" class="tab-pane">
  									<h4 class="header smaller lighter blue">Z. Pendanaan</h4>

                  <?php if (isset($data['klasifikasi']) && $data['klasifikasi'] != 4) { ?>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-xs-12 col-sm-12 widget-container-col" >
                          <div class="widget-box widget-color-orange">
                            <div class="widget-header">
                              <h5 class="widget-title">Catatan Penelaah</h5>

                              <div class="widget-toolbar">
                                <?php if (isset($revisi_ke) && $revisi_ke+1 > 1) { ?>
                                <button class="btn btn-xs btn-default" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'Z. Pendanaan', 'catatanz') }">
                                  <i class="ace-icon fa fa-square bigger-110"></i>
                                  Catatan Sebelumnya
                                </button>
                                <?php } ?>

                                <a href="#" data-action="fullscreen">
                                  <i class="ace-icon fa fa-expand"></i>
                                </a>

                                <a href="#" data-action="collapse">
                                  <i class="ace-icon fa fa-chevron-up"></i>
                                </a>

                              </div>
                            </div>

                            <div class="widget-body">
                              <div class="widget-main">
                              <?php
                              if (!empty($cat_telaah))
                              {
                                for ($i=0; $i<count($cat_telaah); $i++)
                                {
                                  $no = $i+1;
                                  echo '<h6 class="header smaller lighter">Penelaah #'.$no.'</h6>';
                                  echo isset($cat_telaah[$i]['catatanz']) && strlen(trim($cat_telaah[$i]['catatanz'])) > 0 ? stripslashes($cat_telaah[$i]['catatanz']) : '<i>null</i>';
                                  echo '<br/>';
                                }
                              }
                              else echo '<i>null</i>';
                              ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>

  									<div class="form-group">
  										<button class="btn btn-xs btn-info pull-right" data-bind="click: function(data, event){ uraian_before('Z. Pendanaan', 'uraianz1') }">
  											<i class="ace-icon fa fa-square bigger-110"></i>
  											Data Sebelumnya
  										</button>
  									</div>
  									<div class="form-group">
  										<label for="z1">Sumber dan jumlah dana riset; lembaga funding/sponsor, dan deskripsi komitmen finansial sponsor pada kelembagaan penelitian, pada para peneliti, para subyek riset, dan, bila ada, pada komunitas <small><i>(Guideline 25) (B, S2); (p41)</i></small></label>
  										<div class="wysiwyg-editor" id="z1"></div>
  									</div>
  								</div>

  								<div id="aa" class="tab-pane">
  									<h4 class="header smaller lighter blue">AA. Komitmen Etik</h4>

                  <?php if (isset($data['klasifikasi']) && $data['klasifikasi'] != 4) { ?>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-xs-12 col-sm-12 widget-container-col" >
                          <div class="widget-box widget-color-orange">
                            <div class="widget-header">
                              <h5 class="widget-title">Catatan Penelaah</h5>

                              <div class="widget-toolbar">
                                <?php if (isset($revisi_ke) && $revisi_ke+1 > 1) { ?>
                                <button class="btn btn-xs btn-default" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'AA. Komitmen Etik', 'catatanaa') }">
                                  <i class="ace-icon fa fa-square bigger-110"></i>
                                  Catatan Sebelumnya
                                </button>
                                <?php } ?>

                                <a href="#" data-action="fullscreen">
                                  <i class="ace-icon fa fa-expand"></i>
                                </a>

                                <a href="#" data-action="collapse">
                                  <i class="ace-icon fa fa-chevron-up"></i>
                                </a>

                              </div>
                            </div>

                            <div class="widget-body">
                              <div class="widget-main">
                              <?php
                              if (!empty($cat_telaah))
                              {
                                for ($i=0; $i<count($cat_telaah); $i++)
                                {
                                  $no = $i+1;
                                  echo '<h6 class="header smaller lighter">Penelaah #'.$no.'</h6>';
                                  echo isset($cat_telaah[$i]['catatanaa']) && strlen(trim($cat_telaah[$i]['catatanaa'])) > 0 ? stripslashes($cat_telaah[$i]['catatanaa']) : '<i>null</i>';
                                  echo '<br/>';
                                }
                              }
                              else echo '<i>null</i>';
                              ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>

  									<div class="form-group">
  										<button class="btn btn-xs btn-info pull-right" data-bind="click: function(data, event){ uraian_before('AA. Komitmen Etik', 'uraianaa1') }">
  											<i class="ace-icon fa fa-square bigger-110"></i>
  											Data Sebelumnya
  										</button>
  									</div>
  									<div class="form-group">
  										<label for="aa1">1. Pernyataan peneliti utama bahwa prinsip-prinsip yang tertuang dalam pedoman ini akan dipatuhi (lampirkan scan Surat Pernyataan) <small><i>(p6)</i></small></label>
  										<div class="wysiwyg-editor" id="aa1"></div>
  									</div>
  									<div class="form-group">
  										<button class="btn btn-xs btn-info pull-right" data-bind="click: function(data, event){ uraian_before('AA. Komitmen Etik', 'uraianaa2') }">
  											<i class="ace-icon fa fa-square bigger-110"></i>
  											Data Sebelumnya
  										</button>
  									</div>
  									<div class="form-group">
  										<label for="aa2">2. (Track Record) Riwayat usulan review protokol etik sebelumnya dan hasilnya (isi dengan judul da tanggal penelitian, dan hasil review Komite Etik) (lampirkan Daftar Riwayat Usulan Kaji Etiknya) <small><i>(p7)</i></small></label>
  										<div class="wysiwyg-editor" id="aa2"></div>
  									</div>
  									<div class="form-group">
  										<button class="btn btn-xs btn-info pull-right" data-bind="click: function(data, event){ uraian_before('AA. Komitmen Etik', 'uraianaa3') }">
  											<i class="ace-icon fa fa-square bigger-110"></i>
  											Data Sebelumnya
  										</button>
  									</div>
  									<div class="form-group">
  										<label for="aa3">3. Pernyataan bahwa bila terdapat bukti adanya pemalsuan data akan ditangani sesuai peraturan /ketentuan yang berlaku <small><i>(p48)</i></small></label>
  										<div class="wysiwyg-editor" id="aa3"></div>
  									</div>
  								</div>

  								<div id="bb" class="tab-pane">
  									<h4 class="header smaller lighter blue">BB. Daftar Pustaka</h4>

                  <?php if (isset($data['klasifikasi']) && $data['klasifikasi'] != 4) { ?>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-xs-12 col-sm-12 widget-container-col" >
                          <div class="widget-box widget-color-orange">
                            <div class="widget-header">
                              <h5 class="widget-title">Catatan Penelaah</h5>

                              <div class="widget-toolbar">
                                <?php if (isset($revisi_ke) && $revisi_ke+1 > 1) { ?>
                                <button class="btn btn-xs btn-default" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'BB. Daftar Pustaka', 'catatanbb') }">
                                  <i class="ace-icon fa fa-square bigger-110"></i>
                                  Catatan Sebelumnya
                                </button>
                                <?php } ?>

                                <a href="#" data-action="fullscreen">
                                  <i class="ace-icon fa fa-expand"></i>
                                </a>

                                <a href="#" data-action="collapse">
                                  <i class="ace-icon fa fa-chevron-up"></i>
                                </a>

                              </div>
                            </div>

                            <div class="widget-body">
                              <div class="widget-main">
                              <?php
                              if (!empty($cat_telaah))
                              {
                                for ($i=0; $i<count($cat_telaah); $i++)
                                {
                                  $no = $i+1;
                                  echo '<h6 class="header smaller lighter">Penelaah #'.$no.'</h6>';
                                  echo isset($cat_telaah[$i]['catatanbb']) && strlen(trim($cat_telaah[$i]['catatanbb'])) > 0 ? stripslashes($cat_telaah[$i]['catatanbb']) : '<i>null</i>';
                                  echo '<br/>';
                                }
                              }
                              else echo '<i>null</i>';
                              ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>

  									<div class="form-group">
  										<button class="btn btn-xs btn-info pull-right" data-bind="click: function(data, event){ uraian_before('BB. Daftar Pustaka', 'uraianbb1') }">
  											<i class="ace-icon fa fa-square bigger-110"></i>
  											Data Sebelumnya
  										</button>
  									</div>
  									<label for="bb1">Daftar referensi yang dirujuk dalam protokol <small><i>(p40)</i></small></label>
  									<div class="wysiwyg-editor" id="bb1"></div>
  								</div>

  								<div id="cc" class="tab-pane">
  									<h4 class="header smaller lighter blue">CC. Lampiran</h4>

                  <?php if (isset($data['klasifikasi']) && $data['klasifikasi'] != 4) { ?>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-xs-12 col-sm-12 widget-container-col" >
                          <div class="widget-box widget-color-orange">
                            <div class="widget-header">
                              <h5 class="widget-title">Catatan Penelaah</h5>

                              <div class="widget-toolbar">
                                <?php if (isset($revisi_ke) && $revisi_ke+1 > 1) { ?>
                                <button class="btn btn-xs btn-default" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'CC. Lampiran', 'catatancc') }">
                                  <i class="ace-icon fa fa-square bigger-110"></i>
                                  Catatan Sebelumnya
                                </button>
                                <?php } ?>

                                <a href="#" data-action="fullscreen">
                                  <i class="ace-icon fa fa-expand"></i>
                                </a>

                                <a href="#" data-action="collapse">
                                  <i class="ace-icon fa fa-chevron-up"></i>
                                </a>

                              </div>
                            </div>

                            <div class="widget-body">
                              <div class="widget-main">
                              <?php
                              if (!empty($cat_telaah))
                              {
                                for ($i=0; $i<count($cat_telaah); $i++)
                                {
                                  $no = $i+1;
                                  echo '<h6 class="header smaller lighter">Penelaah #'.$no.'</h6>';
                                  echo isset($cat_telaah[$i]['catatancc']) && strlen(trim($cat_telaah[$i]['catatancc'])) > 0 ? stripslashes($cat_telaah[$i]['catatancc']) : '<i>null</i>';
                                  echo '<br/>';
                                }
                              }
                              else echo '<i>null</i>';
                              ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>

  									<p>
  										<h5>1. CV Peneliti Utama</h5>
  										<input type="file" name="lampiran1" id="lampiran1" data-bind="event: {change: function(){do_upload('lampiran1')}}" style="opacity:0; height: 0px" />
  										<button type="button" id="lampiran1-btn" data-loading-text="Proses..." class="btn btn-default btn-sm" data-bind="click: function(data, event){upload('lampiran1') }">
  											Unggah File &nbsp; <span class="ace-icon fa fa-upload icon-on-right bigger-110"></span>
  										</button>
                      <p><small>pdf | png | jpg | jpeg</small></p>
  										<ul class="list-unstyled" data-bind="foreach: lampiran1">
  					            <li>
  					              <i class="fa fa-paperclip"></i> 
  					              <span data-bind="text: client_name"></span>&nbsp;
  					              <a data-bind="attr: {'href': '<?php echo base_url()?>perbaikan/download/'+$data.file_name+'/'+$data.client_name}"><i class="fa fa-download"></i></a>&nbsp;
  					              <a href="#" data-bind="click: $root.removeLampiran1"><i class="glyphicon glyphicon-trash"></i></a>
  					            </li>
  						        </ul>
  						        <div class="hr hr-dotted hr-18"></div>
  									</p>	
  									<p>
  										<h5>2. CV Anggota Peneliti</h5>
  										<input type="file" name="lampiran2" id="lampiran2" data-bind="event: {change: function(){do_upload('lampiran2')}}" style="opacity:0; height: 0px" />
  										<button type="button" id="lampiran2-btn" data-loading-text="Proses..." class="btn btn-default btn-sm" data-bind="click: function(data, event){upload('lampiran2') }">
  											Unggah File &nbsp; <span class="ace-icon fa fa-upload icon-on-right bigger-110"></span>
  										</button>
                      <p><small>pdf | png | jpg | jpeg</small></p>
  										<ul class="list-unstyled" data-bind="foreach: lampiran2">
  					            <li>
  					              <i class="fa fa-paperclip"></i> 
  					              <span data-bind="text: client_name"></span>&nbsp;
  					              <a data-bind="attr: {'href': '<?php echo base_url()?>perbaikan/download/'+$data.file_name+'/'+$data.client_name}"><i class="fa fa-download"></i></a>&nbsp;
  					              <a href="#" data-bind="click: $root.removeLampiran2"><i class="glyphicon glyphicon-trash"></i></a>
  					            </li>
  						        </ul>
  						        <div class="hr hr-dotted hr-18"></div>
  									</p>
  									<p>
  										<h5>3. Daftar Lembaga Sponsor</h5>
  										<input type="file" name="lampiran3" id="lampiran3" data-bind="event: {change: function(){do_upload('lampiran3')}}" style="opacity:0; height: 0px" />
  										<button type="button" id="lampiran3-btn" data-loading-text="Proses..." class="btn btn-default btn-sm" data-bind="click: function(data, event){upload('lampiran3') }">
  											Unggah File &nbsp; <span class="ace-icon fa fa-upload icon-on-right bigger-110"></span>
  										</button>
                      <p><small>pdf | png | jpg | jpeg</small></p>
  										<ul class="list-unstyled" data-bind="foreach: lampiran3">
  					            <li>
  					              <i class="fa fa-paperclip"></i> 
  					              <span data-bind="text: client_name"></span>&nbsp;
  					              <a data-bind="attr: {'href': '<?php echo base_url()?>perbaikan/download/'+$data.file_name+'/'+$data.client_name}"><i class="fa fa-download"></i></a>&nbsp;
  					              <a href="#" data-bind="click: $root.removeLampiran3"><i class="glyphicon glyphicon-trash"></i></a>
  					            </li>
  						        </ul>
  						        <div class="hr hr-dotted hr-18"></div>
  									</p>
  									<p>
  										<h5>4. Surat-surat pernyataan</h5>
  										<input type="file" name="lampiran4" id="lampiran4" data-bind="event: {change: function(){do_upload('lampiran4')}}" style="opacity:0; height: 0px" />
  										<button type="button" id="lampiran4-btn" data-loading-text="Proses..." class="btn btn-default btn-sm" data-bind="click: function(data, event){upload('lampiran4') }">
  											Unggah File &nbsp; <span class="ace-icon fa fa-upload icon-on-right bigger-110"></span>
  										</button>
                      <p><small>pdf | png | jpg | jpeg</small></p>
  										<ul class="list-unstyled" data-bind="foreach: lampiran4">
  					            <li>
  					              <i class="fa fa-paperclip"></i> 
  					              <span data-bind="text: client_name"></span>&nbsp;
  					              <a data-bind="attr: {'href': '<?php echo base_url()?>perbaikan/download/'+$data.file_name+'/'+$data.client_name}"><i class="fa fa-download"></i></a>&nbsp;
  					              <a href="#" data-bind="click: $root.removeLampiran4"><i class="glyphicon glyphicon-trash"></i></a>
  					            </li>
  						        </ul>
  						        <div class="hr hr-dotted hr-18"></div>
  									</p>
  									<p>
  										<h5>5. Instrumen/Kuesioner, dll</h5>
  										<input type="file" name="lampiran5" id="lampiran5" data-bind="event: {change: function(){do_upload('lampiran5')}}" style="opacity:0; height: 0px" />
  										<button type="button" id="lampiran5-btn" data-loading-text="Proses..." class="btn btn-default btn-sm" data-bind="click: function(data, event){upload('lampiran5') }">
  											Unggah File &nbsp; <span class="ace-icon fa fa-upload icon-on-right bigger-110"></span>
  										</button>
                      <p><small>pdf | png | jpg | jpeg</small></p>
  										<ul class="list-unstyled" data-bind="foreach: lampiran5">
  					            <li>
  					              <i class="fa fa-paperclip"></i> 
  					              <span data-bind="text: client_name"></span>&nbsp;
  					              <a data-bind="attr: {'href': '<?php echo base_url()?>perbaikan/download/'+$data.file_name+'/'+$data.client_name}"><i class="fa fa-download"></i></a>&nbsp;
  					              <a href="#" data-bind="click: $root.removeLampiran5"><i class="glyphicon glyphicon-trash"></i></a>
  					            </li>
  						        </ul>
  						        <div class="hr hr-dotted hr-18"></div>
  									</p>
  									<p>
  										<h5>6. Informed Consent 35 butir</h5>
  										<input type="file" name="lampiran6" id="lampiran6" data-bind="event: {change: function(){do_upload('lampiran6')}}" style="opacity:0; height: 0px" />
  										<button type="button" id="lampiran6-btn" data-loading-text="Proses..." class="btn btn-default btn-sm" data-bind="click: function(data, event){upload('lampiran6') }">
  											Unggah File &nbsp; <span class="ace-icon fa fa-upload icon-on-right bigger-110"></span>
  										</button>
                      <p><small>pdf | png | jpg | jpeg</small></p>
  										<ul class="list-unstyled" data-bind="foreach: lampiran6">
  					            <li>
  					              <i class="fa fa-paperclip"></i> 
  					              <span data-bind="text: client_name"></span>&nbsp;
  					              <a data-bind="attr: {'href': '<?php echo base_url()?>perbaikan/download/'+$data.file_name+'/'+$data.client_name}"><i class="fa fa-download"></i></a>&nbsp;
  					              <a href="#" data-bind="click: $root.removeLampiran6"><i class="glyphicon glyphicon-trash"></i></a>
  					            </li>
  						        </ul>
  						        <div class="hr hr-dotted hr-18"></div>
  									</p>
  								</div>

  								<div id="link" class="tab-pane">
                    <h4 class="header smaller lighter blue">Link Google Drive Proposal</h4>
                    <?php if (isset($data['klasifikasi']) && $data['klasifikasi'] != 4) { ?>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-xs-12 col-sm-12 widget-container-col" >
                          <div class="widget-box widget-color-orange">
                            <div class="widget-header">
                              <h5 class="widget-title">Catatan Penelaah</h5>

                              <div class="widget-toolbar">
                                <?php if (isset($revisi_ke) && $revisi_ke+1 > 1) { ?>
                                <button class="btn btn-xs btn-default" data-bind="click: function(data, event){ $root.telaah_before('Catatan Protokol', 'Link Google Drive Proposal', 'catatan_link_proposal') }">
                                  <i class="ace-icon fa fa-square bigger-110"></i>
                                  Catatan Sebelumnya
                                </button>
                                <?php } ?>

                                <a href="#" data-action="fullscreen">
                                  <i class="ace-icon fa fa-expand"></i>
                                </a>

                                <a href="#" data-action="collapse">
                                  <i class="ace-icon fa fa-chevron-up"></i>
                                </a>

                              </div>
                            </div>

                            <div class="widget-body">
                              <div class="widget-main">
                              <?php
                              if (!empty($cat_telaah))
                              {
                                for ($i=0; $i<count($cat_telaah); $i++)
                                {
                                  $no = $i+1;
                                  echo '<h6 class="header smaller lighter">Penelaah #'.$no.'</h6>';
                                  echo isset($cat_telaah[$i]['catatan_link_proposal']) && strlen(trim($cat_telaah[$i]['catatan_link_proposal'])) > 0 ? stripslashes($cat_telaah[$i]['catatan_link_proposal']) : '<i>null</i>';
                                  echo '<br/>';
                                }
                              }
                              else echo '<i>null</i>';
                              ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>

                    <div class="form-group">
                      <input type="text" name="link_proposal" class="form-control" id="link_proposal" data-bind="value: link_proposal" />
  									</div>

  								</div>

  							</div>
  						</div>
  					</div><!-- /.col -->
  				</div><!-- /.row -->
        </div><!-- /.protokol-tab -->

        <div id="self_assesment-tab" class="tab-pane">
          <h3 class="header smaller lighter blue">
            <div class="row">
              <span class="col-sm-10">Self Assesment</span>
              <span class="col-sm-2">
                <a href="#" data-bind="click: print_sa" class="pull-right">
                  <i class="ace-icon fa fa-print bigger-110"></i>
                </a>
              </span>
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

              <?php if (isset($data['klasifikasi']) && $data['klasifikasi'] != 4) { ?>
                <div class="form-group">
                  <div class="row">
                    <div class="col-xs-12 col-sm-12 widget-container-col" >
                      <div class="widget-box widget-color-orange">
                        <div class="widget-header">
                          <h5 class="widget-title">Catatan Penelaah</h5>

                          <div class="widget-toolbar">
                            <?php if (isset($revisi_ke) && $revisi_ke+1 > 1) { ?>
                            <button class="btn btn-xs btn-default" data-bind="click: function(data, event){ $root.telaah_before('Catatan 7 Standar', 'Nilai Sosial/Klinis', 'catatan_sa1') }">
                              <i class="ace-icon fa fa-square bigger-110"></i>
                              Catatan Sebelumnya
                            </button>
                            <?php } ?>

                            <a href="#" data-action="fullscreen">
                              <i class="ace-icon fa fa-expand"></i>
                            </a>

                            <a href="#" data-action="collapse">
                              <i class="ace-icon fa fa-chevron-up"></i>
                            </a>

                          </div>
                        </div>

                        <div class="widget-body">
                          <div class="widget-main">
                          <?php
                          if (!empty($cat_telaah))
                          {
                            for ($i=0; $i<count($cat_telaah); $i++)
                            {
                              $no = $i+1;
                              echo '<h6 class="header smaller lighter">Penelaah #'.$no.'</h6>';
                              echo isset($cat_telaah[$i]['catatan_sa1']) && strlen(trim($cat_telaah[$i]['catatan_sa1'])) > 0 ? stripslashes($cat_telaah[$i]['catatan_sa1']) : '<i>null</i>';
                              echo '<br/>';
                            }
                          }
                          else echo '<i>null</i>';
                          ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php } ?>

                <div class="form-group pull-right">
                  <button class="btn btn-sm" id="reset1" data-bind="click: reset1">
                    <i class="ace-icon fa fa-circle bigger-110"></i>
                    Kosongkan
                  </button>
                </div>

                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <tr><th width="5%">No</th><th width="80%">7-STANDAR KELAIKAN ETIK PENELITIAN</th><th width="15%">PILIHAN</th>
                    </tr>
                  </thead>
                  <tbody data-bind="foreach: self_assesment1">
                    <tr data-bind="attr: {'class': level == 0 ? 'active' : ''}">
                      <td data-bind="text: no_tampilan, attr: {'align': level == 0 ? 'left': 'right'} "></td>
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
                        <div class="control-group">
                          <div class="radio" data-bind="visible: just_header == 0">
                            <label>
                              <input type="radio" class="ace" value="Ya" data-bind="checked: pil, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih1Ya($index(), parent) }}, enable: child == 0 || pil() == 'Ya'" />
                              <span class="lbl"> Ya</span>
                            </label>
                            <label>
                              <input type="radio" class="ace" value="Tidak" data-bind="checked: pil, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih1Tidak() }}, enable: child == 0 || pil() == 'Tidak'" />
                              <span class="lbl"> Tidak</span>
                            </label>
                          </div>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>

                <h3 class="header smaller lighter blue">Justifikasi Nilai Sosial/Klinis:</h3>
                <div class="form-group">
                  <textarea id="justifikasi1" class="autosize-transition form-control" data-bind="value: justifikasi1"></textarea>
                </div>

              </div>

              <div class="step-pane" data-step="2">

              <?php if (isset($data['klasifikasi']) && $data['klasifikasi'] != 4) { ?>
                <div class="form-group">
                  <div class="row">
                    <div class="col-xs-12 col-sm-12 widget-container-col" >
                      <div class="widget-box widget-color-orange">
                        <div class="widget-header">
                          <h5 class="widget-title">Catatan Penelaah</h5>

                          <div class="widget-toolbar">
                            <?php if (isset($revisi_ke) && $revisi_ke+1 > 1) { ?>
                            <button class="btn btn-xs btn-default" data-bind="click: function(data, event){ $root.telaah_before('Catatan 7 Standar', 'Nilai Ilmiah', 'catatan_sa2') }">
                              <i class="ace-icon fa fa-square bigger-110"></i>
                              Catatan Sebelumnya
                            </button>
                            <?php } ?>

                            <a href="#" data-action="fullscreen">
                              <i class="ace-icon fa fa-expand"></i>
                            </a>

                            <a href="#" data-action="collapse">
                              <i class="ace-icon fa fa-chevron-up"></i>
                            </a>

                          </div>
                        </div>

                        <div class="widget-body">
                          <div class="widget-main">
                          <?php
                          if (!empty($cat_telaah))
                          {
                            for ($i=0; $i<count($cat_telaah); $i++)
                            {
                              $no = $i+1;
                              echo '<h6 class="header smaller lighter">Penelaah #'.$no.'</h6>';
                              echo isset($cat_telaah[$i]['catatan_sa2']) && strlen(trim($cat_telaah[$i]['catatan_sa2'])) > 0 ? stripslashes($cat_telaah[$i]['catatan_sa2']) : '<i>null</i>';
                              echo '<br/>';
                            }
                          }
                          else echo '<i>null</i>';
                          ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php } ?>

                <div class="form-group pull-right">
                  <button class="btn btn-sm" id="reset2" data-bind="click: reset2">
                    <i class="ace-icon fa fa-circle bigger-110"></i>
                    Kosongkan
                  </button>
                </div>

                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <tr><th width="5%">No</th><th width="80%">7-STANDAR KELAIKAN ETIK PENELITIAN</th><th width="15%">PILIHAN</th>
                    </tr>
                  </thead>
                  <tbody data-bind="foreach: self_assesment2">
                    <tr data-bind="attr: {'class': level == 0 ? 'active' : ''}">
                      <td data-bind="text: no_tampilan, attr: {'align': level == 0 ? 'left': 'right'} "></td>
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
                        <div class="control-group">
                          <div class="radio" data-bind="visible: just_header == 0">
                            <label>
                              <input type="radio" class="ace" value="Ya" data-bind="checked: pil, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih2Ya($index(), parent) }}, enable: child == 0 || pil() == 'Ya'" />
                              <span class="lbl"> Ya</span>
                            </label>
                            <label>
                              <input type="radio" class="ace" value="Tidak" data-bind="checked: pil, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih2Tidak() }}, enable: child == 0 || pil() == 'Tidak'" />
                              <span class="lbl"> Tidak</span>
                            </label>
                          </div>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>

                <h3 class="header smaller lighter blue">Justifikasi Nilai Ilmiah:</h3>
                <div class="form-group">
                  <textarea id="justifikasi2" class="autosize-transition form-control" data-bind="value: justifikasi2"></textarea>
                </div>

              </div>

              <div class="step-pane" data-step="3">

              <?php if (isset($data['klasifikasi']) && $data['klasifikasi'] != 4) { ?>
                <div class="form-group">
                  <div class="row">
                    <div class="col-xs-12 col-sm-12 widget-container-col" >
                      <div class="widget-box widget-color-orange">
                        <div class="widget-header">
                          <h5 class="widget-title">Catatan Penelaah</h5>

                          <div class="widget-toolbar">
                            <?php if (isset($revisi_ke) && $revisi_ke+1 > 1) { ?>
                            <button class="btn btn-xs btn-default" data-bind="click: function(data, event){ $root.telaah_before('Catatan 7 Standar', 'Pemerataan Beban dan Manfaat', 'catatan_sa3') }">
                              <i class="ace-icon fa fa-square bigger-110"></i>
                              Catatan Sebelumnya
                            </button>
                            <?php } ?>

                            <a href="#" data-action="fullscreen">
                              <i class="ace-icon fa fa-expand"></i>
                            </a>

                            <a href="#" data-action="collapse">
                              <i class="ace-icon fa fa-chevron-up"></i>
                            </a>

                          </div>
                        </div>

                        <div class="widget-body">
                          <div class="widget-main">
                          <?php
                          if (!empty($cat_telaah))
                          {
                            for ($i=0; $i<count($cat_telaah); $i++)
                            {
                              $no = $i+1;
                              echo '<h6 class="header smaller lighter">Penelaah #'.$no.'</h6>';
                              echo isset($cat_telaah[$i]['catatan_sa3']) && strlen(trim($cat_telaah[$i]['catatan_sa3'])) > 0 ? stripslashes($cat_telaah[$i]['catatan_sa3']) : '<i>null</i>';
                              echo '<br/>';
                            }
                          }
                          else echo '<i>null</i>';
                          ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php } ?>

                <div class="form-group pull-right">
                  <button class="btn btn-sm" id="reset3" data-bind="click: reset3">
                    <i class="ace-icon fa fa-circle bigger-110"></i>
                    Kosongkan
                  </button>
                </div>

                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <tr><th width="5%">No</th><th width="80%">7-STANDAR KELAIKAN ETIK PENELITIAN</th><th width="15%">PILIHAN</th>
                    </tr>
                  </thead>
                  <tbody data-bind="foreach: self_assesment3">
                    <tr data-bind="attr: {'class': level == 0 ? 'active' : ''}">
                      <td data-bind="text: no_tampilan, attr: {'align': level == 0 ? 'left': 'right'} "></td>
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
                        <div class="control-group">
                          <div class="radio" data-bind="visible: just_header == 0">
                            <label>
                              <input type="radio" class="ace" value="Ya" data-bind="checked: pil, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih3Ya($index(), parent) }}, enable: child == 0 || pil() == 'Ya'" />
                              <span class="lbl"> Ya</span>
                            </label>
                            <label>
                              <input type="radio" class="ace" value="Tidak" data-bind="checked: pil, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih3Tidak() }}, enable: child == 0 || pil() == 'Tidak'" />
                              <span class="lbl"> Tidak</span>
                            </label>
                          </div>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>

                <h3 class="header smaller lighter blue">Justifikasi Pemerataan Beban dan Manfaat:</h3>
                <div class="form-group">
                  <textarea id="justifikasi3" class="autosize-transition form-control" data-bind="value: justifikasi3"></textarea>
                </div>

              </div>

              <div class="step-pane" data-step="4">

              <?php if (isset($data['klasifikasi']) && $data['klasifikasi'] != 4) { ?>
                <div class="form-group">
                  <div class="row">
                    <div class="col-xs-12 col-sm-12 widget-container-col" >
                      <div class="widget-box widget-color-orange">
                        <div class="widget-header">
                          <h5 class="widget-title">Catatan Penelaah</h5>

                          <div class="widget-toolbar">
                            <?php if (isset($revisi_ke) && $revisi_ke+1 > 1) { ?>
                            <button class="btn btn-xs btn-default" data-bind="click: function(data, event){ $root.telaah_before('Catatan 7 Standar', 'Potensi Manfaat dan Resiko', 'catatan_sa4') }">
                              <i class="ace-icon fa fa-square bigger-110"></i>
                              Catatan Sebelumnya
                            </button>
                            <?php } ?>

                            <a href="#" data-action="fullscreen">
                              <i class="ace-icon fa fa-expand"></i>
                            </a>

                            <a href="#" data-action="collapse">
                              <i class="ace-icon fa fa-chevron-up"></i>
                            </a>

                          </div>
                        </div>

                        <div class="widget-body">
                          <div class="widget-main">
                          <?php
                          if (!empty($cat_telaah))
                          {
                            for ($i=0; $i<count($cat_telaah); $i++)
                            {
                              $no = $i+1;
                              echo '<h6 class="header smaller lighter">Penelaah #'.$no.'</h6>';
                              echo isset($cat_telaah[$i]['catatan_sa4']) && strlen(trim($cat_telaah[$i]['catatan_sa4'])) > 0 ? stripslashes($cat_telaah[$i]['catatan_sa4']) : '<i>null</i>';
                              echo '<br/>';
                            }
                          }
                          else echo '<i>null</i>';
                          ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php } ?>

                <div class="form-group pull-right">
                  <button class="btn btn-sm" id="reset4" data-bind="click: reset4">
                    <i class="ace-icon fa fa-circle bigger-110"></i>
                    Kosongkan
                  </button>
                </div>

                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <tr><th width="5%">No</th><th width="80%">7-STANDAR KELAIKAN ETIK PENELITIAN</th><th width="15%">PILIHAN</th>
                    </tr>
                  </thead>
                  <tbody data-bind="foreach: self_assesment4">
                    <tr data-bind="attr: {'class': level == 0 ? 'active' : ''}">
                      <td data-bind="text: no_tampilan, attr: {'align': level == 0 ? 'left': 'right'} "></td>
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
                        <div class="control-group">
                          <div class="radio" data-bind="visible: just_header == 0">
                            <label>
                              <input type="radio" class="ace" value="Ya" data-bind="checked: pil, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih4Ya($index(), parent) }}, enable: child == 0 || pil() == 'Ya'" />
                              <span class="lbl"> Ya</span>
                            </label>
                            <label>
                              <input type="radio" class="ace" value="Tidak" data-bind="checked: pil, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih4Tidak() }}, enable: child == 0 || pil() == 'Tidak'" />
                              <span class="lbl"> Tidak</span>
                            </label>
                          </div>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>

                <h3 class="header smaller lighter blue">Justifikasi Potensi Manfaat dan Resiko:</h3>
                <div class="form-group">
                  <textarea id="justifikasi4" class="autosize-transition form-control" data-bind="value: justifikasi4"></textarea>
                </div>

              </div>

              <div class="step-pane" data-step="5">

              <?php if (isset($data['klasifikasi']) && $data['klasifikasi'] != 4) { ?>
                <div class="form-group">
                  <div class="row">
                    <div class="col-xs-12 col-sm-12 widget-container-col" >
                      <div class="widget-box widget-color-orange">
                        <div class="widget-header">
                          <h5 class="widget-title">Catatan Penelaah</h5>

                          <div class="widget-toolbar">
                            <?php if (isset($revisi_ke) && $revisi_ke+1 > 1) { ?>
                            <button class="btn btn-xs btn-default" data-bind="click: function(data, event){ $root.telaah_before('Catatan 7 Standar', 'Bujukan/ Eksploitasi/ Iducement', 'catatan_sa5') }">
                              <i class="ace-icon fa fa-square bigger-110"></i>
                              Catatan Sebelumnya
                            </button>
                            <?php } ?>

                            <a href="#" data-action="fullscreen">
                              <i class="ace-icon fa fa-expand"></i>
                            </a>

                            <a href="#" data-action="collapse">
                              <i class="ace-icon fa fa-chevron-up"></i>
                            </a>

                          </div>
                        </div>

                        <div class="widget-body">
                          <div class="widget-main">
                          <?php
                          if (!empty($cat_telaah))
                          {
                            for ($i=0; $i<count($cat_telaah); $i++)
                            {
                              $no = $i+1;
                              echo '<h6 class="header smaller lighter">Penelaah #'.$no.'</h6>';
                              echo isset($cat_telaah[$i]['catatan_sa5']) && strlen(trim($cat_telaah[$i]['catatan_sa5'])) > 0 ? stripslashes($cat_telaah[$i]['catatan_sa5']) : '<i>null</i>';
                              echo '<br/>';
                            }
                          }
                          else echo '<i>null</i>';
                          ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php } ?>

                <div class="form-group pull-right">
                  <button class="btn btn-sm" id="reset5" data-bind="click: reset5">
                    <i class="ace-icon fa fa-circle bigger-110"></i>
                    Kosongkan
                  </button>
                </div>

                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <tr><th width="5%">No</th><th width="80%">7-STANDAR KELAIKAN ETIK PENELITIAN</th><th width="15%">PILIHAN</th>
                    </tr>
                  </thead>
                  <tbody data-bind="foreach: self_assesment5">
                    <tr data-bind="attr: {'class': level == 0 ? 'active' : ''}">
                      <td data-bind="text: no_tampilan, attr: {'align': level == 0 ? 'left': 'right'} "></td>
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
                        <div class="control-group">
                          <div class="radio" data-bind="visible: just_header == 0">
                            <label>
                              <input type="radio" class="ace" value="Ya" data-bind="checked: pil, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih5Ya($index(), parent) }}, enable: child == 0 || pil() == 'Ya'" />
                              <span class="lbl"> Ya</span>
                            </label>
                            <label>
                              <input type="radio" class="ace" value="Tidak" data-bind="checked: pil, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih5Tidak() }}, enable: child == 0 || pil() == 'Tidak'" />
                              <span class="lbl"> Tidak</span>
                            </label>
                          </div>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>

                <h3 class="header smaller lighter blue">Justifikasi Bujukan/ Eksploitasi/ Iducement:</h3>
                <div class="form-group">
                  <textarea id="justifikasi5" class="autosize-transition form-control" data-bind="value: justifikasi5"></textarea>
                </div>

              </div>

              <div class="step-pane" data-step="6">

              <?php if (isset($data['klasifikasi']) && $data['klasifikasi'] != 4) { ?>
                <div class="form-group">
                  <div class="row">
                    <div class="col-xs-12 col-sm-12 widget-container-col" >
                      <div class="widget-box widget-color-orange">
                        <div class="widget-header">
                          <h5 class="widget-title">Catatan Penelaah</h5>

                          <div class="widget-toolbar">
                            <?php if (isset($revisi_ke) && $revisi_ke+1 > 1) { ?>
                            <button class="btn btn-xs btn-default" data-bind="click: function(data, event){ $root.telaah_before('Catatan 7 Standar', 'Rahasia dan Privacy', 'catatan_sa6') }">
                              <i class="ace-icon fa fa-square bigger-110"></i>
                              Catatan Sebelumnya
                            </button>
                            <?php } ?>

                            <a href="#" data-action="fullscreen">
                              <i class="ace-icon fa fa-expand"></i>
                            </a>

                            <a href="#" data-action="collapse">
                              <i class="ace-icon fa fa-chevron-up"></i>
                            </a>

                          </div>
                        </div>

                        <div class="widget-body">
                          <div class="widget-main">
                          <?php
                          if (!empty($cat_telaah))
                          {
                            for ($i=0; $i<count($cat_telaah); $i++)
                            {
                              $no = $i+1;
                              echo '<h6 class="header smaller lighter">Penelaah #'.$no.'</h6>';
                              echo isset($cat_telaah[$i]['catatan_sa6']) && strlen(trim($cat_telaah[$i]['catatan_sa6'])) > 0 ? stripslashes($cat_telaah[$i]['catatan_sa6']) : '<i>null</i>';
                              echo '<br/>';
                            }
                          }
                          else echo '<i>null</i>';
                          ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php } ?>

                <div class="form-group pull-right">
                  <button class="btn btn-sm" id="reset6" data-bind="click: reset6">
                    <i class="ace-icon fa fa-circle bigger-110"></i>
                    Kosongkan
                  </button>
                </div>

                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <tr><th width="5%">No</th><th width="80%">7-STANDAR KELAIKAN ETIK PENELITIAN</th><th width="15%">PILIHAN</th>
                    </tr>
                  </thead>
                  <tbody data-bind="foreach: self_assesment6">
                    <tr data-bind="attr: {'class': level == 0 ? 'active' : ''}">
                      <td data-bind="text: no_tampilan, attr: {'align': level == 0 ? 'left': 'right'} "></td>
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
                        <div class="control-group">
                          <div class="radio" data-bind="visible: just_header == 0">
                            <label>
                              <input type="radio" class="ace" value="Ya" data-bind="checked: pil, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih6Ya($index(), parent) }}, enable: child == 0 || pil() == 'Ya'" />
                              <span class="lbl"> Ya</span>
                            </label>
                            <label>
                              <input type="radio" class="ace" value="Tidak" data-bind="checked: pil, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih6Tidak() }}, enable: child == 0 || pil() == 'Tidak'" />
                              <span class="lbl"> Tidak</span>
                            </label>
                          </div>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>

                <h3 class="header smaller lighter blue">Justifikasi Rahasia dan Privacy:</h3>
                <div class="form-group">
                  <textarea id="justifikasi6" class="autosize-transition form-control" data-bind="value: justifikasi6"></textarea>
                </div>

              </div>

              <div class="step-pane" data-step="7">

              <?php if (isset($data['klasifikasi']) && $data['klasifikasi'] != 4) { ?>
                <div class="form-group">
                  <div class="row">
                    <div class="col-xs-12 col-sm-12 widget-container-col" >
                      <div class="widget-box widget-color-orange">
                        <div class="widget-header">
                          <h5 class="widget-title">Catatan Penelaah</h5>

                          <div class="widget-toolbar">
                            <?php if (isset($revisi_ke) && $revisi_ke+1 > 1) { ?>
                            <button class="btn btn-xs btn-default" data-bind="click: function(data, event){ $root.telaah_before('Catatan 7 Standar', 'Informed Consent', 'catatan_sa7') }">
                              <i class="ace-icon fa fa-square bigger-110"></i>
                              Catatan Sebelumnya
                            </button>
                            <?php } ?>

                            <a href="#" data-action="fullscreen">
                              <i class="ace-icon fa fa-expand"></i>
                            </a>

                            <a href="#" data-action="collapse">
                              <i class="ace-icon fa fa-chevron-up"></i>
                            </a>

                          </div>
                        </div>

                        <div class="widget-body">
                          <div class="widget-main">
                          <?php
                          if (!empty($cat_telaah))
                          {
                            for ($i=0; $i<count($cat_telaah); $i++)
                            {
                              $no = $i+1;
                              echo '<h6 class="header smaller lighter">Penelaah #'.$no.'</h6>';
                              echo isset($cat_telaah[$i]['catatan_sa7']) && strlen(trim($cat_telaah[$i]['catatan_sa7'])) > 0 ? stripslashes($cat_telaah[$i]['catatan_sa7']) : '<i>null</i>';
                              echo '<br/>';
                            }
                          }
                          else echo '<i>null</i>';
                          ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php } ?>

                <div class="form-group pull-right">
                  <button class="btn btn-sm" id="reset7" data-bind="click: reset7">
                    <i class="ace-icon fa fa-circle bigger-110"></i>
                    Kosongkan
                  </button>
                </div>

                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <tr><th width="5%">No</th><th width="80%">7-STANDAR KELAIKAN ETIK PENELITIAN</th><th width="15%">PILIHAN</th>
                    </tr>
                  </thead>
                  <tbody data-bind="foreach: self_assesment7">
                    <tr data-bind="attr: {'class': level == 0 ? 'active' : ''}">
                      <td data-bind="text: no_tampilan, attr: {'align': level == 0 ? 'left': 'right'} "></td>
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
                        <div class="control-group">
                          <div class="radio" data-bind="visible: just_header == 0">
                            <label>
                              <input type="radio" class="ace" value="Ya" data-bind="checked: pil, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih7Ya($index(), parent) }}, enable: child == 0 || pil() == 'Ya'" />
                              <span class="lbl"> Ya</span>
                            </label>
                            <label>
                              <input type="radio" class="ace" value="Tidak" data-bind="checked: pil, attr:{'name': $index().$data}, event:{ change: function() { $root.pilih7Tidak() }}, enable: child == 0 || pil() == 'Tidak'" />
                              <span class="lbl"> Tidak</span>
                            </label>
                          </div>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>

                <h3 class="header smaller lighter blue">Justifikasi Informed Consent:</h3>
                <div class="form-group">
                  <textarea id="justifikasi7" class="autosize-transition form-control" data-bind="value: justifikasi7"></textarea>
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
      </div><!-- /.tab-content -->

		</div><!-- /.widget-main -->
	</div><!-- /.widget-body -->
</div><!-- /.widget-box -->

<div class="clearfix form-actions">
	<div class="col-md-offset-3 col-md-9">
		<button class="btn btn-info" id="submit" type="button" data-loading-text="Proses..." data-bind="click: function(data, event){save(false, data, event) }, enable: is_kirim() == 0">
			<i class="ace-icon fa fa-floppy-o bigger-110"></i>
			Simpan
		</button>

		&nbsp; &nbsp; &nbsp;
		<button class="btn btn-warning" type="button" data-bind="click: back, enable: !processing()">
			<i class="ace-icon fa fa-list bigger-110"></i>
			Lihat Daftar
		</button>

		&nbsp; &nbsp; &nbsp;
		<button class="btn btn-success" id="kirim" type="button" data-loading-text="Mengirim..." data-bind="click: kirim, enable: id() > 0 && is_kirim() == 0">
			<i class="ace-icon fa fa-envelope bigger-110"></i>
			<span data-bind="text: lbl_btn_kirim"></span> ke KEPK
		</button>
	</div>
</div>

<div id="my-modal-uraian" class="modal fade" tabindex="-1">
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
								<span class="green middle bolder">#</span>

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
								<div data-bind="attr: {'id': $index()+1}" class="uraian_before">
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

<?php if (isset($revisi_ke) && $revisi_ke+1 > 1) { ?>
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
                <span class="green middle bolder">Telaah&nbsp;#</span>

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
                  <div data-bind="foreach: penelaah">
                    <h6 class="header smaller lighter">Penelaah #<span data-bind="text: $index()+1"></span></h6>
                    <p data-bind="html: catatan.length > 0 ? catatan : '<i>null</i>'"></p>
                  </div>
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