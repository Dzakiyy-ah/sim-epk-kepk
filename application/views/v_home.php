<div class="page-header">
  <h1>
    <?php echo isset($page_header) ? $page_header : 'Dashboard' ?>
    <?php if (isset($subheader)) { ?>
    <small>
      <i class="ace-icon fa fa-angle-double-right"></i>
      <?php echo $subheader ?>
    </small>
    <?php } ?>
  </h1>
</div><!-- /.page-header -->

<div class="col-sm-12">
  <h2>Selamat Datang di Aplikasi SIM-EPK KEPPKN</h2>
  <p>Aplikasi di rancang untuk kemudahan penggunaan dalam pengajuan etik penelitian kesehatan oleh Peneliti ke KEPK secara online sistem, dan proses telaah etik secara online sistem.</p>

  <h4>Kemudahan Pengunaan</h4>
  <p>User pada aplikasi ini dikelompokkan antara lain:
    <ul class="list-unstyled spaced">
      <li><i class="ace-icon fa fa-check bigger-110 green"></i> Peneliti (pengusul protokol etik penelitian kesehatan)</li>
      <li><i class="ace-icon fa fa-check bigger-110 green"></i> KEPK (manajemen team Penelaah KEPK)</li>
      <li><i class="ace-icon fa fa-check bigger-110 green"></i> Penelaah (penelaah protokol etik yang diusulkan oleh peneliti berdasarkan 7 standar CIOMS)</li>
      <li><i class="ace-icon fa fa-check bigger-110 green"></i> KEPPKN melakukan monitoring terhadap proses telaah etik KEPK.</li>
    </ul>
  </p>

  <h3>Petunjuk Manual unduh di bawah ini:</h3>
  <ul class="list-unstyled spaced">
    <li><a href="<?php echo base_url()?>home/download/Manual_48_Protokol.docx/<?php echo rawurlencode('Manual_48_Protokol.docx') ?>">Manual 48 Protokol</a></li>
    <li><a href="<?php echo base_url()?>home/download/Check_List_7_Standar_dan_Indikator.pdf/<?php echo rawurlencode('Check_List_7_Standar_dan_Indikator.pdf') ?>">Check List 7 Standar dan Indikator</a></li>
    <li><a href="<?php echo base_url()?>home/download/Formulir_Informed_Consent_WHO.pdf/<?php echo rawurlencode('Formulir_Informed_Consent_WHO.pdf') ?>">Formulir Informed Consent WHO</a></li>
    <li><a href="<?php echo base_url()?>home/download/INFORM_CONSENT_35_BUTIR.docx/<?php echo rawurlencode('INFORM_CONSENT_35_BUTIR.docx') ?>">Formulir Informed Consent 35 Butir</a></li>
  </ul>
</div>

