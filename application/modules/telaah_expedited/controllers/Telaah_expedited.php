<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Telaah_expedited extends Userpage_Controller {

  public function __construct()
  {
    parent::__construct();

    $this->load->model('Telaah_expedited_model', 'data_model');
  }
 
  public function index()
  {
    $data['title'] = APPNAME.' - Telaah Expedited';
    $data['page_header'] = 'Daftar Telaah Expedited';
    $data['breadcrumb'] = 'Telaah Expedited';
    $data['css_content'] = 'telaah_expedited_view_css';
    $data['main_content'] = 'telaah_expedited_view';
    $data['js_content'] = 'telaah_expedited_view_js';
    $data['protokol'] = $this->data_model->get_data_protokol();

    $this->load->view('layout/template', $data);
  }

  public function form($id=0, $id_pep=0)
  {
    $pep = $this->data_model->get_data_pep_by_idpep($id_pep);

    $data['title'] = APPNAME.' - Telaah Expedited';
    $data['page_header'] = $pep['revisi_ke'] > 0 ? 'Form Telaah Expedited (Perbaikan)' : 'Form Telaah Expedited';
    $data['breadcrumb'] = 'Telaah Expedited';
    $data['css_content'] = 'telaah_expedited_form_css';
    $data['main_content'] = 'telaah_expedited_form';
    $data['js_content'] = 'telaah_expedited_form_js';
    $data['pengajuan'] = $this->data_model->get_data_pengajuan_by_idpep($id_pep);
    $data['sp'] = $this->data_model->get_data_surat_pengantar_by_idpep($id_pep);
    $data['bb'] = $this->data_model->get_data_bukti_bayar_by_idpep($id_pep);
    $data['pep'] = $pep;
    $data['lampiran_pep'] = $this->data_model->get_data_lampiran_pep_by_idpep($id_pep);
    $data['resume'] = $this->data_model->get_data_resume_by_idpep($id_pep);
    $data['sac'] = $this->data_model->get_data_self_assesment_cek_by_idpep($id_pep);
    $data['is_putusan'] = $this->data_model->check_is_putusan($id_pep);
    $data['putusan'] = $this->data_model->get_data_putusan($id_pep);

    if ($id > 0){
      $data['data'] = $this->data_model->get_data_by_id($id);
    }

    $this->load->view('layout/template', $data);
  }

  public function validation_form()
  {
    // $this->form_validation->set_rules('kelayakan', 'Kelayakan', 'trim|required');

    // $this->form_validation->set_message('required', 'Harus memilih {field}.');
  }

  public function proses()
  {
    $response = (object)null;

    $this->load->library('form_validation');
    // $this->validation_form();

    // if ($this->form_validation->run() == TRUE)
    // {
      $this->data_model->fill_data();
      $success = $this->data_model->save_data();
      if ($success)
      {
        $response->isSuccess = TRUE;
        $response->message = 'Data berhasil disimpan';
        $response->id = $this->data_model->id;
      }
      else
      {
        $response->isSuccess = FALSE;
        $response->message = 'Data gagal disimpan';       
      }
    // }
    // else
    // {
    //   $response->isSuccess = FALSE;
    //   $response->message = validation_errors();
    // }

    echo json_encode($response);
  }

  public function get_daftar1()
  {
    $param = array(
      "_search" => $this->input->post('_search'),
      "search_fld" => $this->input->post('searchField'),
      "search_op" => $this->input->post('searchOper'),
      "search_str" => $this->input->post('searchString'),
      "sort_by" => $this->input->post('sidx'),
      "sort_direction" => $this->input->post('sord')
    );

    $count = $this->data_model->get_data_jqgrid($param, TRUE);

    $response = (object) NULL;

    $page = $this->input->post('page');
    $limit = $this->input->post('rows');
    $total_pages = ceil($count/$limit);

    if ($page > $total_pages) $page = $total_pages;
    $start = $limit * $page - $limit;
    if($start < 0) $start = 0;
    $param['limit'] = array(
        'start' => $start,
        'end' => $limit
    );

    $result = $this->data_model->get_data_jqgrid($param);
    $response->page = $page;
    $response->total = $total_pages;
    $response->records = $count;

    $response->rows = array();
    if ($result){
      for($i=0; $i<count($result); $i++){
        if ($result[$i]['revisi_ke'] == 0)
        {
          $response->rows[] = array(
            'id' => $result[$i]['id_texp'],
            'id_pep' => $result[$i]['id_pep'],
            'no_protokol' => $result[$i]['no_protokol'],
            'judul' => $result[$i]['judul'],
            'tgl_pengajuan' => date('d/m/Y', strtotime($result[$i]['tanggal_pengajuan'])),
            'kepk' => $result[$i]['nama_kepk'],
            'mulai' => date('d/m/Y', strtotime($result[$i]['waktu_mulai'])),
            'selesai' => date('d/m/Y', strtotime($result[$i]['waktu_selesai'])),
            'tgl_telaah' => date('d/m/Y', strtotime($result[$i]['tanggal_telaah'])),
            'kelayakan' => $result[$i]['kelayakan']
          );
        }
      }
    }
    
    echo json_encode($response);
  }

  public function get_daftar2()
  {
    $param = array(
      "_search" => $this->input->post('_search'),
      "search_fld" => $this->input->post('searchField'),
      "search_op" => $this->input->post('searchOper'),
      "search_str" => $this->input->post('searchString'),
      "sort_by" => $this->input->post('sidx'),
      "sort_direction" => $this->input->post('sord')
    );

    $count = $this->data_model->get_data_jqgrid($param, TRUE);

    $response = (object) NULL;

    $page = $this->input->post('page');
    $limit = $this->input->post('rows');
    $total_pages = ceil($count/$limit);

    if ($page > $total_pages) $page = $total_pages;
    $start = $limit * $page - $limit;
    if($start < 0) $start = 0;
    $param['limit'] = array(
        'start' => $start,
        'end' => $limit
    );

    $result = $this->data_model->get_data_jqgrid($param);
    $response->page = $page;
    $response->total = $total_pages;
    $response->records = $count;

    $response->rows = array();
    if ($result){
      for($i=0; $i<count($result); $i++){
        if ($result[$i]['revisi_ke'] > 0)
        {
          $response->rows[] = array(
            'id' => $result[$i]['id_texp'],
            'id_pep' => $result[$i]['id_pep'],
            'no_protokol' => $result[$i]['no_protokol'],
            'judul' => $result[$i]['judul'],
            'tgl_pengajuan' => date('d/m/Y', strtotime($result[$i]['tanggal_pengajuan'])),
            'tgl_perbaikan' => date('d/m/Y', strtotime($result[$i]['tanggal_protokol'])),
            'revisi_ke' => $result[$i]['revisi_ke'],
            'kepk' => $result[$i]['nama_kepk'],
            'mulai' => date('d/m/Y', strtotime($result[$i]['waktu_mulai'])),
            'selesai' => date('d/m/Y', strtotime($result[$i]['waktu_selesai'])),
            'tgl_telaah' => date('d/m/Y', strtotime($result[$i]['tanggal_telaah'])),
            'kelayakan' => $result[$i]['kelayakan']
          );
        }
      }
    }
    
    echo json_encode($response);
  }

  function get_protokol()
  {
    $result = $this->data_model->get_data_protokol();

    $response = (object) NULL;
    $response->data = array();
    if ($result){
      for($i=0; $i<count($result); $i++){
        $response->data[] = array(
          'id_pep' => $result[$i]['id_pep'],
          'no' => $result[$i]['no_protokol'],
          'judul' => $result[$i]['judul'],
          'waktu' => date('d/m/Y H:i:s', strtotime($result[$i]['inserted'])),
          'revisi_ke' => $result[$i]['revisi_ke'],
          'hari_ke' => get_working_days(date('Y-m-d', strtotime($result[$i]['inserted'])), date('Y-m-d'))
        );
      }
    }

    echo json_encode($response->data);
  }

  function get_uraian_before($id_pep, $id_pengajuan, $uraian)
  {
    $result = $this->data_model->get_data_uraian_before($id_pep, $id_pengajuan, $uraian);

    $response = (object) NULL;
    $response->jumlah = count($result);
    $response->data = array();
    if ($result){
      for($i=0; $i<count($result); $i++){
        $response->data[] = array(
          'id' => $result[$i]['id_pep'],
          'tgl' => date('d/m/Y', strtotime($result[$i]['inserted'])),
          'uraian' => stripslashes($result[$i]['uraian'])
        );
      }
    }

    echo json_encode($response);
  }

  function get_catatan_before($id_pep, $id_pengajuan, $catatan)
  {
    $result = $this->data_model->get_data_catatan_before($id_pep, $id_pengajuan, $catatan);

    $response = (object) NULL;
    $response->jumlah = count($result);
    $response->data = array();
    if ($result){
      for($i=0; $i<count($result); $i++){
        $response->data[] = array(
          'id' => $result[$i]['id_pep'],
          'tgl' => date('d/m/Y', strtotime($result[$i]['inserted'])),
          'catatan' => stripslashes($result[$i]['catatan'])
        );
      }
    }

    echo json_encode($response);
  }

  function cek_file_upload_exist($file_name)
  {
    $response = (object)null;

    if (file_exists('./uploads/'.$file_name))
      $response->isSuccess = TRUE;
    else
      $response->isSuccess = FALSE;

    echo json_encode($response);
  }

  public function download($file_name, $client_name)
  {
    $this->load->helper('download');

    $pathfile = './uploads/'.$file_name;
    $data = file_get_contents($pathfile);
    $client_name = urldecode(rawurldecode($client_name));

    force_download($client_name, $data);
  }

  function get_standar_kelaikan($id, $id_pep)
  {
    $result = $this->data_model->get_data_standar_kelaikan($id, $id_pep);

    $response = (object) NULL;
    $response->data = array();
    if ($result){
      for($i=0; $i<count($result); $i++){
        $response->data[] = array(
          'id' => $result[$i]['id_jsk'],
          'idx_std' => $result[$i]['indeks_standar'],
          'no_tampilan' => $result[$i]['nomor_tampilan'],
          'no' => $result[$i]['nomor'],
          'level' => $result[$i]['level'],
          'parent' => $result[$i]['parent'],
          'child' => $result[$i]['child'],
          'uraian' => $result[$i]['uraian'],
          'uraian_master' => $result[$i]['uraian_master'],
          'pil_pengaju' => $result[$i]['pilihan_pengaju'],
          'pil_penelaah' => $result[$i]['pilihan_penelaah'],
          'cat_penelaah' => $result[$i]['catatan'],
          'just_header' => $result[$i]['just_header']
        );
      }
    }
    
    echo json_encode($response->data);
  }

/*  public function hapus()
  {
    $response = (object)null;

    $id = $this->input->post('id');

    $check = $this->data_model->check_exist_data($id);

    if ($check)
    {
      $response->isSuccess = FALSE;
      $response->message = 'Data dipakai di tabel lain';
    }
    else
    {
      $result = $this->data_model->delete_data($id);

      if ($result)
      {
        $response->isSuccess = TRUE;
        $response->message = 'Data tim KEPK berhasil dihapus';
      }
      else
      {
        $response->isSuccess = FALSE;
        $response->message = 'Data tim KEPK gagal dihapus';
      }     
    }
    
    echo json_encode($response);
  }*/

  public function cetak_protokol($id_pep=0)
  {
    $this->load->library('Pdf');

    // create new PDF document
    $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('E-Protokol');
    $pdf->SetTitle('Protokol');
    $pdf->SetSubject('Protokol');

    // remove default header/footer
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
        require_once(dirname(__FILE__).'/lang/eng.php');
        $pdf->setLanguageArray($l);
    }

    // ---------------------------------------------------------

    // set font
    $pdf->SetFont('times', '', 12);

    // add a page
    $pdf->AddPage();

    $data_pengajuan = $this->data_model->get_data_pengajuan_by_idpep($id_pep);
    $revisi_ke = $data_pengajuan['revisi_ke'];
    $data_pep = $this->data_model->get_data_pep_by_idpep($id_pep);

    if ($revisi_ke > 0)
      $pdf->writeHTML('<i>Perbaikan #'.$revisi_ke.' dari nomor protokol '.$data_pengajuan['no_protokol'].'</i><br/>');

    $pdf->writeHTML('<h2>A. Judul Penelitian (p-protokol no 1)</h2>', true, false, true, false, '');
    $A = '<div>Judul : <br/>'.$data_pengajuan['judul'].'</div>';
    $A .= '<div>Lokasi Penelitian : <br/>'.$data_pengajuan['tempat_penelitian'].'</div>';
    $A .= '<div>Apakah penelitian ini multi-senter? ';
    $A .= $data_pengajuan['is_multi_senter'] === "1" ? 'Ya' :'Tidak';
    $A .= '</div>';
    $A .= '<div>Jika multi-senter apakah sudah mendapatkan persetujuan etik dari senter/institusi yang lain?';
    
    if ($data_pengajuan['is_multi_senter'] === "1"){
      $A .= $data_pengajuan['is_setuju_senter'] === "1" ? 'Ya' : 'Tidak';
    }
    else $A .= " -";
    $A .= '</div>';
    $pdf->writeHTML($A, true, false, true, false, '');

    // add a page
    $pdf->AddPage();

    $pdf->writeHTML('<h2>C. Ringkasan Protokol Penelitian</h2>', true, false, true, false, '');
    $pdf->writeHTML('<br/><p>1. Ringkasan dalam 200 kata, (ditulis dalam bahasa yang mudah dipahami oleh "awam" bukan dokter/profesional kesehatan)</p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data_pep['uraianc1']), true, false, true, false, '');
    $pdf->writeHTML('<br/><p>2. Tuliskan mengapa penelitian ini harus dilakukan, manfaatnya untuk penduduk di wilayah penelitian ini dilakukan (Negara, wilayah, lokal) - <small><i>Justifikasi Penelitian (p3) Standar 2/A (Adil)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data_pep['uraianc2']), true, false, true, false, '');
    
    // add a page
    $pdf->AddPage();
    $pdf->writeHTML('<h2>D. Isu Etik yang mungkin dihadapi</h2>', true, false, true, false, '');
    $pdf->writeHTML('<br/><p>1. Pendapat peneliti tentang isyu etik yang mungkin dihadapi dalam penelitian ini, dan bagaimana cara menanganinya <small><i>(p4)</i></small>.</p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data_pep['uraiand1']), true, false, true, false, '');

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML('<h2>E. Ringkasan Kajian Pustaka</h2>', true, false, true, false, '');
    $pdf->writeHTML('<br/><p>1. Ringkasan hasil-hasil studi sebelumnya yang sesuai topik penelitian, baik yang sudah maupun yang sudah dipublikasikan, termasuk jika ada kajian-kajian pada hewan. Maksimum 1 hal <small><i>(p5)- G 4, S</i></small> ?</p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data_pep['uraiane1']), true, false, true, false, '');

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML('<h2>F. Kondisi Lapangan</h2>', true, false, true, false, '');
    $pdf->writeHTML('<br/><p>1. Gambaran singkat tentang lokasi penelitian<small><i>(p8)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data_pep['uraianf1']), true, false, true, false, '');
    $pdf->writeHTML('<br/><p>2. Informasi ketersediaan fasilitas yang tersedia di lapangan yang menunjang penelitian</p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data_pep['uraianf2']), true, false, true, false, '');
    $pdf->writeHTML('<br/><p>3. Informasi demografis / epidemiologis yang relevan tentang daerah penelitian</p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data_pep['uraianf3']), true, false, true, false, '');

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML('<h2>G. Disain Penelitian</h2>', true, false, true, false, '');
    $pdf->writeHTML('<br/><p>1. Tujuan penelitian, hipotesa, pertanyaan penelitian, asumsi dan variabel penelitian <small><i>(p11)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data_pep['uraiang1']), true, false, true, false, '');
    $pdf->writeHTML('<br/><p>2. Deskipsi detil tentang desain penelitian. <small><i>(p12)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data_pep['uraiang2']), true, false, true, false, '');
    $pdf->writeHTML('<br/><p>3. Bila ujicoba klinis, deskripsikan tentang  apakah kelompok treatmen ditentukan secara random, (termasuk bagaimana metodenya), dan apakah blinded atau terbuka. <small><i>(Bila bukan ujicoba klinis cukup tulis: tidak relevan) (p12)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data_pep['uraiang3']), true, false, true, false, '');

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML('<h2>H. Sampling</h2>', true, false, true, false, '');
    $pdf->writeHTML('<br/><p>1. Jumlah subyek yang dibutuhkan dan bagaimana penentuannya secara statistik <small><i>(p13)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data_pep['uraianh1']), true, false, true, false, '');
    $pdf->writeHTML('<br/><p>2. Kriteria partisipan atau subyek dan justifikasi exclude/include-nya. <small><i>(Guideline 3) (p12)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data_pep['uraianh2']), true, false, true, false, '');
    $pdf->writeHTML('<br/><p>3. <strong>Sampling kelompok rentan</strong>: alasan melibatkan anak anak atau orang dewasa yang tidak mampu memberikan persetujuan setelah penjelasan, atau kelompok rentan, serta langkah langkah bagaimana meminimalisir bila terjadi resiko <small><i>(tulis “<strong>tidak relevan</strong>” bila penelitian tidak mengikutsertakan kelompok rentan)(Guidelines 15, 16 and 17)  (p15)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data_pep['uraianh3']), true, false, true, false, '');

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML('<h2>I. Intervensi</h2>', true, false, true, false, '');
    $pdf->writeHTML('<br/><p>1. Desripsi dan penjelasan semua intervensi (metode administrasi treatmen, termasuk rute administrasi, dosis, interval dosis, dan masa treatmen produk yang digunakan <small><i>(tulis “<strong>Tidak relevan</strong>” bila bukan penelitian intervensi) (investigasi dan komparator (p17)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data_pep['uraiani1']), true, false, true, false, '');
    $pdf->writeHTML('<br/><p>2. Rencana dan jastifikasi untuk meneruskan atau menghentikan standar terapi/terapi baku selama penelitian <small><i>(p 4 and 5) (p18)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data_pep['uraiani2']), true, false, true, false, '');
    $pdf->writeHTML('<br/><p>3. Treatmen/Pengobatan lain yang mungkin diberikan atau diperbolehkan, atau menjadi kontraindikasi, selama penelitian <small><i>(p 6) (p19)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data_pep['uraiani3']), true, false, true, false, '');
    $pdf->writeHTML('<br/><p>4. Test klinis atau lab atau test lain yang harus dilakukan <small><i>(p20)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data_pep['uraiani4']), true, false, true, false, '');

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML('<h2>J. Monitoring Penelitian</h2>', true, false, true, false, '');
    $pdf->writeHTML('<br/><p>1. Sampel dari form laporan kasus yang sudah distandarisir, metode pencataran respon teraputik (deskripsi dan evaluasi metode dan frekuensi pengukuran), prosedur follow-up, dan, bila mungkin, ukuran yang diusulkan untuk menentukan tingkat kepatuhan subyek yang menerima treatmen <small><i>(lihat lampiran) (p17)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data_pep['uraianj1']), true, false, true, false, '');

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML('<h2>K. Penghentian  Penelitian dan Alasannya</h2>', true, false, true, false, '');
    $pdf->writeHTML('<br/><p>1. Aturan atau kriteria kapan subyek bisa diberhentikan dari penelitian atau uji klinis, atau, dalam hal studi multi senter, kapan sebuah pusat/lembaga di non aktipkan, dan kapan penelitian bisa dihentikan <small><i>(tidak lagi dilanjutkan)  (p22)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data_pep['uraiank1']), true, false, true, false, '');

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML('<h2>L. Adverse Event dan Komplikasi (Kejadian Yang Tidak Diharapkan)</h2>', true, false, true, false, '');
    $pdf->writeHTML('<br/><p>1. Metode pencatatan dan pelaporan adverse events atau reaksi, dan syarat penanganan komplikasi <small><i>(Guideline 4 dan 23)(p23)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data_pep['uraianl1']), true, false, true, false, '');
    $pdf->writeHTML('<br/><p>2. Resiko-resiko yang diketahui dari adverse events, termasuk resiko yang terkait dengan masing masing rencana intervensi, dan terkait dengan obat, vaksin, atau terhadap prosudur yang akan diuji cobakan <small><i>(Guideline 4) (p24)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data_pep['uraianl2']), true, false, true, false, '');

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML('<h2>M. Penanganan Komplikasi <small>(p27)</small></h2>', true, false, true, false, '');
    $pdf->writeHTML('<br/><p>1. Rencana detil bila ada resiko lebih dari minimal/ luka fisik, membuat rencana detil<br>2. Adanya asuransi<br>3. Adanya fasilitas pengobatan / biaya pengobatan<br>4. Kompensasi jika terjadi disabilitas atau kematian <small><i>(Guideline 14)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data_pep['uraianm1']), true, false, true, false, '');

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML('<h2>N. Manfaat</h2>', true, false, true, false, '');
    $pdf->writeHTML('<br/><p>1. Manfaat penelitian secara pribadi bagi subyek dan bagi yang lainnya <small><i>(Guideline 4) (p25)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data_pep['uraiann1']), true, false, true, false, '');
    $pdf->writeHTML('<br/><p>2. Manfaat penelitian bagi penduduk, termasuk pengetahuan baru yang kemungkinan dihasilkan oleh penelitian <small><i>(Guidelines 1 and 4)(p26)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data_pep['uraiann2']), true, false, true, false, '');

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML('<h2>O. Jaminan Keberlanjutan Manfaat <small><i>(p28)</i></small></h2>', true, false, true, false, '');
    $pdf->writeHTML('<br/><p>1. Kemungkinan keberlanjutan akses bila hasil intervensi menghasilkan manfaat yang signifikan, <br>2. Modalitas yang tersedia, <br>3. Pihak pihak yang akan mendapatkan keberlansungan pengobatan, organisasi yang akan membayar, <br>4. Berapa lama <small><i>(Guideline 6)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data_pep['uraiano1']), true, false, true, false, '');

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML('<h2>P. Informed Consent</h2>', true, false, true, false, '');
    $pdf->writeHTML('<br/><p>1. Cara untuk mendapatkan informed consent dan prosudur yang direncanakan untuk mengkomunikasikan informasi penelitian(Penjelasan Sebelum Persetujuan/PSP) kepada calon subyek, termasuk nama dan posisi wali bagi yang tidak bisa memberikannya. <small><i>(Guideline 9)(p30)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data_pep['uraianp1']), true, false, true, false, '');
    $pdf->writeHTML('<br/><p>2. Khusus Ibu Hamil: adanya perencanaan untuk memonitor kesehatan ibu dan kesehatan anak jangka pendek maupun jangka panjang <small><i>(Guideline 19)(p29)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data_pep['uraianp2']), true, false, true, false, '');

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML('<h2>Q. Wali <small><i>(p31)</i></small></h2>', true, false, true, false, '');
    $pdf->writeHTML('<br/><p>1. Adanya wali yang berhak bila calon subyek tidak bisa memberikan informed consent <small><i>(Guidelines 16 and 17)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data_pep['uraianq1']), true, false, true, false, '');
    $pdf->writeHTML('<br/><p>2. Adanya orang tua atau wali yang berhak bila anak paham tentang informed consent tapi belum cukup umur <small><i>(Guidelines 16 and 17)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data_pep['uraianq2']), true, false, true, false, '');

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML('<h2>R. Bujukan</h2>', true, false, true, false, '');
    $pdf->writeHTML('<br/><p>1. Deskripsi bujukan atau insentif (bahan kontak) bagi calon subyek untuk ikut berpartisipasi, seperti uang, hadiah, layanan gratis, atau yang lainnya <small><i>(p32)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data_pep['uraianr1']), true, false, true, false, '');
    $pdf->writeHTML('<br/><p>2. Rencana dan prosedur, dan orang yang betanggung jawab untuk menginformasikan bahaya atau keuntungan peserta, atau tentang riset lain tentang topik yang sama, yang bisa mempengaruhi keberlansungan keterlibatan subyek dalam penelitian<small><i>(Guideline 9) (p33)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data_pep['uraianr2']), true, false, true, false, '');
    $pdf->writeHTML('<br/><p>3. Perencanaan untuk menginformasikan hasil penelitian pada subyek atau partisipan <small><i>(p34)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data_pep['uraianr3']), true, false, true, false, '');

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML('<h2>S. Penjagaan Kerahasiaan</h2>', true, false, true, false, '');
    $pdf->writeHTML('<br/><p>1. Proses rekrutmen subyek (misalnya lewat iklan), serta langkah langkah untuk menjaga privasi dan kerahasiaan selama rekrutmen <small><i>(Guideline 3) (p16)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data_pep['uraians1']), true, false, true, false, '');
    $pdf->writeHTML('<br/><p>2. Langkah langkah proteksi kerahasiaan data pribadi, dan penghormatan privasi orang, termasuk kehati-hatian untuk mencegah bocornya rahasia hasil test genetik pada keluarga kecuali atas izin dari yang bersangkutan <small><i>(Guidelines 4, 11, 12 and 24) (p 35)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data_pep['uraians2']), true, false, true, false, '');
    $pdf->writeHTML('<br/><p>3. Informasi tentang bagaimana koding; bila ada, untuk identitas subyek, di mana di simpan dan kapan, bagaimana dan oleh siapa bisa dibuka bila terjadi emergensi <small><i>(Guidelines 11 and 12) (p36)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data_pep['uraians3']), true, false, true, false, '');
    $pdf->writeHTML('<br/><p>4. Kemungkinan penggunaan lebih jauh dari data personal atau material biologis/BBT <small><i>(p37)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data_pep['uraians4']), true, false, true, false, '');

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML('<h2>T. Rencana Analisis</h2>', true, false, true, false, '');
    $pdf->writeHTML('<br/><p>1. Deskripsi tentang rencana  analisa statistik, dan kreteria bila atau dalam kondisi bagaimana akan terjadi penghentian dini keseluruhan penelitian <small><i>(Guideline 4) (B,S2)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data_pep['uraiant1']), true, false, true, false, '');

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML('<h2>V. Konflik Kepentingan</h2>', true, false, true, false, '');
    $pdf->writeHTML('<br/><p>1. Pengaturan untuk mengatasi konflik finansial atau yang lainnya yang bisa mempengaruhi keputusan para peneliti atau personil lainya; menginformasikan pada komite lembaga tentang adanya conflict of interest; komite mengkomunikasikannya ke komite etik dan kemudian mengkomunikasikan pada para peneliti tentang langkah langkah berikutnya yang harus dilakukan <small><i>(Guideline 25) (p42)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data_pep['uraianv1']), true, false, true, false, '');

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML('<h2>W. Manfaat Sosial</h2>', true, false, true, false, '');
    $pdf->writeHTML('<br/><p>1. Untuk penelitian yang dilakukan pada seting sumberdaya lemah, kontribusi yang dilakukan sponsor untuk capacity building untuk review ilmiah dan etika dan untuk riset-riset kesehatan di negara tersebut; dan jaminan bahwa tujuan capacity building adalah agar sesuai nilai dan harapan para partisipan dan komunitas tempat penelitian <small><i>(Guideline 8) (p43)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data_pep['uraianw1']), true, false, true, false, '');
    $pdf->writeHTML('<br/><p>2. Protokol penelitian (dokumen) yang dikirim ke komite etik harus meliputi deskripsi rencana pelibatan komunitas, dan menunjukkan sumber-sumber yang dialokasikan untuk aktivitas aktivitas pelibatan tersebut. Dokumen ini menjelaskan apa yang sudah dan yang akan dilakukan, kapan dan oleh siapa, untuk memastikan bahwa masyarakat dengan jelas terpetakan untuk memudahkan pelibatan mereka selama riset, untuk memastikan bahwa tujuan riset sesuai kebutuhan masyarakat dan diterima oleh mereka. Bila perlu masyarakat harus dilibatkan dalam penyusunan protokol atau dokumen ini <small><i>(Guideline 7) (p44)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data_pep['uraianw2']), true, false, true, false, '');

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML('<h2>X. Hak atas Data</h2>', true, false, true, false, '');
    $pdf->writeHTML('<br/><p>1. Terutama bila sponsor adalah industri, kontrak yang menyatakan siapa pemilik hak publiksi hasil riset, dan kewajiban untuk menyiapkan bersama dan diberikan pada para PI draft laporan hasil riset <small><i>(Guideline 24) (B dan H, S1,S7)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data_pep['uraianx1']), true, false, true, false, '');

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML('<h2>Y. Publikasi</h2>', true, false, true, false, '');
    $pdf->writeHTML('<br/><p>Rencana publikasi hasil pada bidang tertentu (seperti epidemiology, generik, sosiologi) yang bisa beresiko berlawanan dengan kemaslahatan komunitas, masyarakat, keluarga, etnik tertentu, dan meminimalisir resiko kemudharatan kelompok ini dengan selalu mempertahankan kerahasiaan data selama dan setelah penelitian, dan mempublikasi hasil hasil penelitian sedemikian rupa dengan selalu mempertimbangkan martabat dan kemulyaan mereka <small><i>(Guideline 4) (p47)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data_pep['uraiany1']), true, false, true, false, '');
    $pdf->writeHTML('<br/><p>Bagaimana publikasi bila hasil riset negatip. <small><i>(Guideline 24) (p46)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data_pep['uraiany2']), true, false, true, false, '');

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML('<h2>Z. Pendanaan</h2>', true, false, true, false, '');
    $pdf->writeHTML('<br/><p>Sumber dan jumlah dana riset; lembaga funding/sponsor, dan deskripsi komitmen finansial sponsor pada kelembagaan penelitian, pada para peneliti, para subyek riset, dan, bila ada, pada komunitas <small><i>(Guideline 25) (B, S2); (p41)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data_pep['uraianz1']), true, false, true, false, '');

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML('<h2>AA. Komitmen Etik</h2>', true, false, true, false, '');
    $pdf->writeHTML('<br/><p>1. Pernyataan peneliti utama bahwa prinsip-prinsip yang tertuang dalam pedoman ini akan dipatuhi (lampirkan scan Surat Pernyataan) <small><i>(p6)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data_pep['uraianaa1']), true, false, true, false, '');
    $pdf->writeHTML('<br/><p>2. (Track Record) Riwayat usulan review protokol etik sebelumnya dan hasilnya (isi dengan judul da tanggal penelitian, dan hasil review Komite Etik) (lampirkan Daftar Riwayat Usulan Kaji Etiknya) <small><i>(p7)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data_pep['uraianaa2']), true, false, true, false, '');
    $pdf->writeHTML('<br/><p>3. Pernyataan bahwa bila terdapat bukti adanya pemalsuan data akan ditangani sesuai peraturan /ketentuan yang berlaku <small><i>(p48)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data_pep['uraianaa3']), true, false, true, false, '');

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML('<h2>BB. Daftar Pustaka</h2>', true, false, true, false, '');
    $pdf->writeHTML('<br/><p>Daftar referensi yang dirujuk dalam protokol <small><i>(p40)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data_pep['uraianbb1']), true, false, true, false, '');

    //Close and output PDF document
    $pdf->Output('protokol.pdf', 'I');
  }

  public function cetak_sa($id=0, $id_pep=0)
  {
    $this->load->library('Pdf');

    // create new PDF document
    $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('E-Protokol');
    $pdf->SetTitle('7 Standar');
    $pdf->SetSubject('7 Standar');

    // remove default header/footer
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
        require_once(dirname(__FILE__).'/lang/eng.php');
        $pdf->setLanguageArray($l);
    }

    // ---------------------------------------------------------

    // set font
    $pdf->SetFont('helvetica', '', 12);

    // add a page
    $pdf->AddPage();

    $data_pengajuan = $this->data_model->get_data_pengajuan_by_idpep($id_pep);
    $revisi_ke = $data_pengajuan['revisi_ke'];
    $data_sa = $this->data_model->get_data_standar_kelaikan($id, $id_pep);
    $data_telaah = $this->data_model->get_data_by_id($id);
    $penelaah = isset($data_telaah['nama_penelaah']) ? $data_telaah['nama_penelaah'] : '';

    $html = '<table border="0">';
    $html .= '<thead>';

    if ($revisi_ke == 0)
      $html .= '<tr><th align="center"><strong><u>7 STANDAR</u></strong></th></tr>';
    else if ($revisi_ke > 0)
      $html .= '<tr><th align="center"><strong><u>7 STANDAR (PERBAIKAN #'.$revisi_ke.')</u></strong></th></tr>';

    $html .= '<tr><th align="center"><strong>NOMOR PROTOKOL : '.$data_pengajuan['no_protokol'].'</strong></th></tr>';
    $html .= '</thead>';
    $html .= '</table>';

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    // set font
    $pdf->SetFont('helvetica', '', 8);

    $html = '<p><b>Penelaah Expedited: '.$penelaah.'</b></p>';
    $html .= '<table border="1" cellpadding="5">';
    $html .= '<thead>';
    $html .= '<tr>
                <th width="6%"></th>
                <th width="54%">7-STANDAR KELAIKAN ETIK PENELITIAN</th>
                <th width="10%" align="center">PENELITI</th>
                <th width="10%" align="center">PENELAAH</th>
                <th width="20%" align="center">CATATAN PENELAAH</th>
              </tr>';
    $html .= '</thead>';
    $html .= '<tbody>';

    for($i=0; $i<count($data_sa); $i++)
    {
      if ($data_sa[$i]['just_header'] == 0)
      {
        if ($data_sa[$i]['pilihan_penelaah'] != '')
        {
          $html .= '<tr nobr="true" class="';
          $html .= $data_sa[$i]['level'] == 0 ? 'active' : '';
          $html .= '">';
          $html .= '<td width="6%" align="';
          $html .= $data_sa[$i]['level'] == 0 ? 'left': 'right';
          $html .= '">'.$data_sa[$i]['nomor_tampilan'].'</td>';
          $html .= '<td width="54%"><div>';
          if ($data_sa[$i]['level'] == 0){
            $html .= '<strong>'.$data_sa[$i]['uraian_master'].'</strong>';
            $html .= '<br/>';
            $html .= '<i>';
            $html .= $data_sa[$i]['uraian'] == $data_sa[$i]['uraian_master'] ? '' : $data_sa[$i]['uraian'];
            $html .= '</i>';
          }
          else {
            $html .= $data_sa[$i]['uraian'];
          }
          $html .= '</div></td>';
          $html .= '<td width="10%" align="center">'.$data_sa[$i]['pilihan_pengaju'].'</td>';
          $html .= '<td width="10%" align="center">'.$data_sa[$i]['pilihan_penelaah'].'</td>';
          $html .= '<td width="20%">'.$data_sa[$i]['catatan'].'</td>';
          $html .= '</tr>';
        }  
      }
      else
      {
        $html .= '<tr>';
        $html .= '<td width="6%"></td>';
        $html .= '<td width="54%">'.$data_sa[$i]['uraian'].'</td>';
        $html .= '<td width="10%"></td>';
        $html .= '<td width="10%"></td>';
        $html .= '<td width="20%"></td>';
        $html .= '</tr>';
      }
    }
    $html .= '</tbody>';
    $html .= '</table>';

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    //Close and output PDF document
    $pdf->Output('7-standar.pdf', 'I');
  }

  public function cetak_telaah_expedited($id=0, $id_pep=0)
  {
    $this->load->library('Pdf');

    // create new PDF document
    $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('E-Protokol');
    $pdf->SetTitle('Telaah Expedited');
    $pdf->SetSubject('Telaah Expedited');

    // remove default header/footer
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
        require_once(dirname(__FILE__).'/lang/eng.php');
        $pdf->setLanguageArray($l);
    }

    // ---------------------------------------------------------

    // set font
    $pdf->SetFont('times', '', 12);

    // add a page
    $pdf->AddPage();

    $data_pengajuan = $this->data_model->get_data_pengajuan_by_idpep($id_pep);
    $revisi_ke = $data_pengajuan['revisi_ke'];
    $data_telaah = $this->data_model->get_data_by_id($id);
    $penelaah = isset($data_telaah['nama_penelaah']) ? $data_telaah['nama_penelaah'] : '';
    if (isset($data_telaah['kelayakan']))
    {
      switch($data_telaah['kelayakan'])
      {
        case 'LE': $kelayakan = 'Layak Etik'; break;
        case 'R': $kelayakan = 'Perbaikan'; break;
        case 'F': $kelayakan = 'Full Board'; break;
        default: $kelayakan = '';
      }
    }

    $pdf->writeHTML('<h1>Telaah Expedited</h1><br/>', true, false, true, false, 'C');

    $html = '<table border="0">';

    $html .= '<tr>
                <td width="15%">No. Protokol</td>
                <td width="2%">:</td>
                <td width="85%">'.$data_pengajuan['no_protokol'].'</td>
              </tr>';
    if ($revisi_ke > 0)
    {
      $html .= '<tr>
                  <td width="15%">Perbaikan ke</td>
                  <td width="2%">:</td>
                  <td width="85%">'.$revisi_ke.'</td>
                </tr>';
    }
    $html .= '<tr>
                <td width="15%">Judul</td>
                <td width="2%">:</td>
                <td width="85%">'.$data_pengajuan['judul'].'</td>
              </tr>';
    $html .= '<tr>
                <td width="15%">Penelaah</td>
                <td width="2%">:</td>
                <td width="85%">'.$penelaah.'</td>
              </tr>';
    $html .= '<tr>
                <td width="15%">Kelayakan</td>
                <td width="2%">:</td>
                <td width="85%">'.$kelayakan.'</td>
              </tr>';
    $html .= '</table><br/>';

    $pdf->writeHTML($html, true, false, true, false, '');

    $pdf->writeHTML('<h2>Catatan Protokol</h2><hr/>', true, false, true, false, '');
    $pdf->writeHTML(isset($data_telaah['catatan_protokol']) ? stripslashes($data_telaah['catatan_protokol']) : '', true, false, true, false, '');
    $pdf->writeHTML('<h2>Catatan 7 Standar</h2><hr/>', true, false, true, false, '');
    $pdf->writeHTML(isset($data_telaah['catatan_7standar']) ? $data_telaah['catatan_7standar'] : '', true, false, true, false, '');

    //Close and output PDF document
    $pdf->Output('telaah-expedited.pdf', 'I');
  }

}
?>