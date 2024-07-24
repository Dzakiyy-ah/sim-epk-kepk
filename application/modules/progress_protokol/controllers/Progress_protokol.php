<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Progress_protokol extends Userpage_Controller {

  public function __construct()
  {
    parent::__construct();

    $this->load->model('Progress_protokol_model', 'data_model');
  }
 
  public function index()
  {
    $data['title'] = APPNAME.' - Progress Protokol Etik Penelitian';
    $data['page_header'] = 'Progress Protokol Etik Penelitian';
    $data['breadcrumb'] = 'Progress Protokol Etik Penelitian';
    $data['kepk'] = $this->data_model->get_data_kepk();
    $data['css_content'] = 'progress_protokol_view_css';
    $data['main_content'] = 'progress_protokol_view';
    $data['js_content'] = 'progress_protokol_view_js';
 
    $this->load->view('layout/template', $data);
  }

  function detail_progress($id=0)
  {
    $data['title'] = APPNAME.' - Protokol Etik Penelitian';
    $data['page_header'] = 'Detail Progress Protokol Etik Penelitian';
    $data['breadcrumb'] = 'Detail Progress Protokol Etik Penelitian';
    if ($this->session->userdata('id_group_'.APPAUTH) == 3)
    {
      $data['css_content'] = 'progress_protokol_detail1_css';
      $data['main_content'] = 'progress_protokol_detail1';
      $data['js_content'] = 'progress_protokol_detail1_js';
    }
    else
    {
      $data['css_content'] = 'progress_protokol_detail2_css';
      $data['main_content'] = 'progress_protokol_detail2';
      $data['js_content'] = 'progress_protokol_detail2_js';
    }
    
    $data['timeline'] = $this->get_timeline_protokol_by_id($id);
    $data['pengajuan'] = $this->data_model->get_data_pengajuan_by_id($id);
    $data['penelaah_awal'] = $this->data_model->get_data_penelaah_awal_by_id($id);
    $data['penelaah'] = $this->data_model->get_data_penelaah_by_id($id);

    $this->load->view('layout/template', $data);
  }

  function get_daftar()
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

    if ($result){
      for($i=0; $i<count($result); $i++){
        $id = $result[$i]['id_pengajuan'];

        $response->rows[$i] = array(
          'id' => $id,
          'no_protokol' => $result[$i]['no_protokol'],
          'judul' => $result[$i]['judul'],
          'kepk' => $result[$i]['nama_kepk'],
          'klasifikasi' => $result[$i]['klasifikasi'],
          'tgl_pengajuan' => $result[$i]['tanggal_pengajuan'] == NULL ? '' : date('d/m/Y', strtotime($result[$i]['tanggal_pengajuan'])),
          'tgl_protokol' => $result[$i]['tanggal_protokol'] == NULL ? '' : date('d/m/Y', strtotime($result[$i]['tanggal_protokol'])),
          'tgl_keputusan' => $result[$i]['tanggal_keputusan'] == NULL ? '' : date('d/m/Y', strtotime($result[$i]['tanggal_keputusan'])),
          'hari_efektif' => $this->get_hari_efektif_by_id($id)
        );
      }
    }
    
    echo json_encode($response);
  }

  function get_timeline_protokol_by_id($id)
  {
    $result = $this->data_model->get_data_timeline_protokol_by_id($id);

    $response = (object) NULL;
    $response->data = array();
    if ($result){
      for($i=0; $i<count($result); $i++){
        $tgl = $result[$i]['tanggal'];
        $response->data[$tgl][] = array(
          'aktivitas' => $result[$i]['aktivitas'],
          'time' => $result[$i]['waktu'],
          'author' => $result[$i]['author'],
          'id_pep' => $result[$i]['id_pep'],
          'klasifikasi_usulan' => $result[$i]['klasifikasi_usulan'],
          'klasifikasi_putusan' => $result[$i]['klasifikasi_putusan'],
          'revisi_ke' => $result[$i]['revisi_ke'],
          'resume' => $result[$i]['resume'],
          'lanjut_telaah' => $result[$i]['lanjut_telaah'],
          'alasan_tbd' => $result[$i]['alasan_tbd'],
          'alasan_ditolak' => $result[$i]['alasan_ditolak'],
          'kelayakan' => $result[$i]['kelayakan'],
          'catatan_protokol' => $result[$i]['catatan_protokol'],
          'catatan_7standar' => $result[$i]['catatan_7standar'],
          'keputusan' => $result[$i]['keputusan'],
          'no_dokumen' => $result[$i]['no_dokumen']
        );
      }
    }

    return $response->data;
  }

  function get_penelaah_by_id($id)
  {
    $result = $this->data_model->get_data_penelaah_by_id($id);

    $response = (object) NULL;
    $response->data = array();
    if ($result){
      $no = array();
      for($i=0; $i<count($result); $i++){
        if (!in_array($result[$i]['nomor'], $no)){
          $response->data[] = array(
            'no' => $result[$i]['nomor'],
            'nama' => $result[$i]['nama'],
            'jabatan' => $result[$i]['jabatan'],
          );
        }
        $no[] = $result[$i]['nomor'];
      }
    }
    
    echo json_encode($response->data);
  }

  function get_hari_efektif_by_id($id)
  {
    $proses_terakhir = $this->data_model->get_data_waktu_proses_terakhir_by_id($id);
    $kirim_ke_kepk = $this->data_model->get_data_waktu_kirim_ke_kepk_by_id($id);
    $hari = get_working_days($kirim_ke_kepk, $proses_terakhir);

    return $hari;
  }

/*  public function cetak_protokol($id=0)
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

    $data = $this->data_model->get_data_by_id($id);

    $pdf->writeHTML('<h2>A. Judul Penelitian (p-protokol no 1)</h2>', true, false, true, false, '');
    $A = '<div>Judul : <br/>'.$data['judul'].'</div>';
    $A .= '<div>Lokasi Penelitian : <br/>'.$data['tempat_penelitian'].'</div>';
    $A .= '<div>Apakah penelitian ini multi-senter? ';
    $A .= $data['is_multi_senter'] === "1" ? 'Ya' :'Tidak';
    $A .= '</div>';
    $A .= '<div>Jika multi-senter apakah sudah mendapatkan persetujuan etik dari senter/institusi yang lain?';
    
    if ($data['is_multi_senter'] === "1"){
      $A .= $data['is_setuju_senter'] === "1" ? 'Ya' : 'Tidak';
    }
    else $A .= " -";
    $A .= '</div>';
    $pdf->writeHTML($A, true, false, true, false, '');

    // add a page
    $pdf->AddPage();

    $pdf->writeHTML('<h2>C. Ringkasan Protokol Penelitian</h2>', true, false, true, false, '');
    $pdf->writeHTML('<br/><p>1. Ringkasan dalam 200 kata, (ditulis dalam bahasa yang mudah dipahami oleh "awam" bukan dokter/profesional kesehatan)</p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data['uraianc1']), true, false, true, false, '');
    $pdf->writeHTML('<br/><p>2. Tuliskan mengapa penelitian ini harus dilakukan, manfaatnya untuk penduduk di wilayah penelitian ini dilakukan (Negara, wilayah, lokal) - <small><i>Justifikasi Penelitian (p3) Standar 2/A (Adil)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data['uraianc2']), true, false, true, false, '');
    
    // add a page
    $pdf->AddPage();
    $pdf->writeHTML('<h2>D. Isu Etik yang mungkin dihadapi</h2>', true, false, true, false, '');
    $pdf->writeHTML('<br/><p>1. Pendapat peneliti tentang isyu etik yang mungkin dihadapi dalam penelitian ini, dan bagaimana cara menanganinya <small><i>(p4)</i></small>.</p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data['uraiand1']), true, false, true, false, '');

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML('<h2>E. Ringkasan Kajian Pustaka</h2>', true, false, true, false, '');
    $pdf->writeHTML('<br/><p>1. Ringkasan hasil-hasil studi sebelumnya yang sesuai topik penelitian, baik yang sudah maupun yang sudah dipublikasikan, termasuk jika ada kajian-kajian pada hewan. Maksimum 1 hal <small><i>(p5)- G 4, S</i></small> ?</p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data['uraiane1']), true, false, true, false, '');

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML('<h2>F. Kondisi Lapangan</h2>', true, false, true, false, '');
    $pdf->writeHTML('<br/><p>1. Gambaran singkat tentang lokasi penelitian<small><i>(p8)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data['uraianf1']), true, false, true, false, '');
    $pdf->writeHTML('<br/><p>2. Informasi ketersediaan fasilitas yang tersedia di lapangan yang menunjang penelitian</p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data['uraianf2']), true, false, true, false, '');
    $pdf->writeHTML('<br/><p>3. Informasi demografis / epidemiologis yang relevan tentang daerah penelitian</p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data['uraianf3']), true, false, true, false, '');

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML('<h2>G. Disain Penelitian</h2>', true, false, true, false, '');
    $pdf->writeHTML('<br/><p>1. Tujuan penelitian, hipotesa, pertanyaan penelitian, asumsi dan variabel penelitian <small><i>(p11)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data['uraiang1']), true, false, true, false, '');
    $pdf->writeHTML('<br/><p>2. Deskipsi detil tentang desain penelitian. <small><i>(p12)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data['uraiang2']), true, false, true, false, '');
    $pdf->writeHTML('<br/><p>3. Bila ujicoba klinis, deskripsikan tentang  apakah kelompok treatmen ditentukan secara random, (termasuk bagaimana metodenya), dan apakah blinded atau terbuka. <small><i>(Bila bukan ujicoba klinis cukup tulis: tidak relevan) (p12)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data['uraiang3']), true, false, true, false, '');

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML('<h2>H. Sampling</h2>', true, false, true, false, '');
    $pdf->writeHTML('<br/><p>1. Jumlah subyek yang dibutuhkan dan bagaimana penentuannya secara statistik <small><i>(p13)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data['uraianh1']), true, false, true, false, '');
    $pdf->writeHTML('<br/><p>2. Kriteria partisipan atau subyek dan justifikasi exclude/include-nya. <small><i>(Guideline 3) (p12)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data['uraianh2']), true, false, true, false, '');
    $pdf->writeHTML('<br/><p>3. <strong>Sampling kelompok rentan</strong>: alasan melibatkan anak anak atau orang dewasa yang tidak mampu memberikan persetujuan setelah penjelasan, atau kelompok rentan, serta langkah langkah bagaimana meminimalisir bila terjadi resiko <small><i>(tulis “<strong>tidak relevan</strong>” bila penelitian tidak mengikutsertakan kelompok rentan)(Guidelines 15, 16 and 17)  (p15)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data['uraianh3']), true, false, true, false, '');

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML('<h2>I. Intervensi</h2>', true, false, true, false, '');
    $pdf->writeHTML('<br/><p>1. Desripsi dan penjelasan semua intervensi (metode administrasi treatmen, termasuk rute administrasi, dosis, interval dosis, dan masa treatmen produk yang digunakan <small><i>(tulis “<strong>Tidak relevan</strong>” bila bukan penelitian intervensi) (investigasi dan komparator (p17)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data['uraiani1']), true, false, true, false, '');
    $pdf->writeHTML('<br/><p>2. Rencana dan jastifikasi untuk meneruskan atau menghentikan standar terapi/terapi baku selama penelitian <small><i>(p 4 and 5) (p18)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data['uraiani2']), true, false, true, false, '');
    $pdf->writeHTML('<br/><p>3. Treatmen/Pengobatan lain yang mungkin diberikan atau diperbolehkan, atau menjadi kontraindikasi, selama penelitian <small><i>(p 6) (p19)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data['uraiani3']), true, false, true, false, '');
    $pdf->writeHTML('<br/><p>4. Test klinis atau lab atau test lain yang harus dilakukan <small><i>(p20)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data['uraiani4']), true, false, true, false, '');

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML('<h2>J. Monitoring Penelitian</h2>', true, false, true, false, '');
    $pdf->writeHTML('<br/><p>1. Sampel dari form laporan kasus yang sudah distandarisir, metode pencataran respon teraputik (deskripsi dan evaluasi metode dan frekuensi pengukuran), prosedur follow-up, dan, bila mungkin, ukuran yang diusulkan untuk menentukan tingkat kepatuhan subyek yang menerima treatmen <small><i>(lihat lampiran) (p17)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data['uraianj1']), true, false, true, false, '');

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML('<h2>K. Penghentian  Penelitian dan Alasannya</h2>', true, false, true, false, '');
    $pdf->writeHTML('<br/><p>1. Aturan atau kriteria kapan subyek bisa diberhentikan dari penelitian atau uji klinis, atau, dalam hal studi multi senter, kapan sebuah pusat/lembaga di non aktipkan, dan kapan penelitian bisa dihentikan <small><i>(tidak lagi dilanjutkan)  (p22)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data['uraiank1']), true, false, true, false, '');

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML('<h2>L. Adverse Event dan Komplikasi (Kejadian Yang Tidak Diharapkan)</h2>', true, false, true, false, '');
    $pdf->writeHTML('<br/><p>1. Metode pencatatan dan pelaporan adverse events atau reaksi, dan syarat penanganan komplikasi <small><i>(Guideline 4 dan 23)(p23)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data['uraianl1']), true, false, true, false, '');
    $pdf->writeHTML('<br/><p>2. Resiko-resiko yang diketahui dari adverse events, termasuk resiko yang terkait dengan masing masing rencana intervensi, dan terkait dengan obat, vaksin, atau terhadap prosudur yang akan diuji cobakan <small><i>(Guideline 4) (p24)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data['uraianl2']), true, false, true, false, '');

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML('<h2>M. Penanganan Komplikasi <small>(p27)</small></h2>', true, false, true, false, '');
    $pdf->writeHTML('<br/><p>1. Rencana detil bila ada resiko lebih dari minimal/ luka fisik, membuat rencana detil<br>2. Adanya asuransi<br>3. Adanya fasilitas pengobatan / biaya pengobatan<br>4. Kompensasi jika terjadi disabilitas atau kematian <small><i>(Guideline 14)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data['uraianm1']), true, false, true, false, '');

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML('<h2>N. Manfaat</h2>', true, false, true, false, '');
    $pdf->writeHTML('<br/><p>1. Manfaat penelitian secara pribadi bagi subyek dan bagi yang lainnya <small><i>(Guideline 4) (p25)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data['uraiann1']), true, false, true, false, '');
    $pdf->writeHTML('<br/><p>2. Manfaat penelitian bagi penduduk, termasuk pengetahuan baru yang kemungkinan dihasilkan oleh penelitian <small><i>(Guidelines 1 and 4)(p26)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data['uraiann2']), true, false, true, false, '');

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML('<h2>O. Jaminan Keberlanjutan Manfaat <small><i>(p28)</i></small></h2>', true, false, true, false, '');
    $pdf->writeHTML('<br/><p>1. Kemungkinan keberlanjutan akses bila hasil intervensi menghasilkan manfaat yang signifikan, <br>2. Modalitas yang tersedia, <br>3. Pihak pihak yang akan mendapatkan keberlansungan pengobatan, organisasi yang akan membayar, <br>4. Berapa lama <small><i>(Guideline 6)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data['uraiano1']), true, false, true, false, '');

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML('<h2>P. Informed Consent</h2>', true, false, true, false, '');
    $pdf->writeHTML('<br/><p>1. Cara untuk mendapatkan informed consent dan prosudur yang direncanakan untuk mengkomunikasikan informasi penelitian(Penjelasan Sebelum Persetujuan/PSP) kepada calon subyek, termasuk nama dan posisi wali bagi yang tidak bisa memberikannya. <small><i>(Guideline 9)(p30)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data['uraianp1']), true, false, true, false, '');
    $pdf->writeHTML('<br/><p>2. Khusus Ibu Hamil: adanya perencanaan untuk memonitor kesehatan ibu dan kesehatan anak jangka pendek maupun jangka panjang <small><i>(Guideline 19)(p29)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data['uraianp2']), true, false, true, false, '');

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML('<h2>Q. Wali <small><i>(p31)</i></small></h2>', true, false, true, false, '');
    $pdf->writeHTML('<br/><p>1. Adanya wali yang berhak bila calon subyek tidak bisa memberikan informed consent <small><i>(Guidelines 16 and 17)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data['uraianq1']), true, false, true, false, '');
    $pdf->writeHTML('<br/><p>2. Adanya orang tua atau wali yang berhak bila anak paham tentang informed consent tapi belum cukup umur <small><i>(Guidelines 16 and 17)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data['uraianq2']), true, false, true, false, '');

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML('<h2>R. Bujukan</h2>', true, false, true, false, '');
    $pdf->writeHTML('<br/><p>1. Deskripsi bujukan atau insentif (bahan kontak) bagi calon subyek untuk ikut berpartisipasi, seperti uang, hadiah, layanan gratis, atau yang lainnya <small><i>(p32)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data['uraianr1']), true, false, true, false, '');
    $pdf->writeHTML('<br/><p>2. Rencana dan prosedur, dan orang yang betanggung jawab untuk menginformasikan bahaya atau keuntungan peserta, atau tentang riset lain tentang topik yang sama, yang bisa mempengaruhi keberlansungan keterlibatan subyek dalam penelitian<small><i>(Guideline 9) (p33)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data['uraianr2']), true, false, true, false, '');
    $pdf->writeHTML('<br/><p>3. Perencanaan untuk menginformasikan hasil penelitian pada subyek atau partisipan <small><i>(p34)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data['uraianr3']), true, false, true, false, '');

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML('<h2>S. Penjagaan Kerahasiaan</h2>', true, false, true, false, '');
    $pdf->writeHTML('<br/><p>1. Proses rekrutmen subyek (misalnya lewat iklan), serta langkah langkah untuk menjaga privasi dan kerahasiaan selama rekrutmen <small><i>(Guideline 3) (p16)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data['uraians1']), true, false, true, false, '');
    $pdf->writeHTML('<br/><p>2. Langkah langkah proteksi kerahasiaan data pribadi, dan penghormatan privasi orang, termasuk kehati-hatian untuk mencegah bocornya rahasia hasil test genetik pada keluarga kecuali atas izin dari yang bersangkutan <small><i>(Guidelines 4, 11, 12 and 24) (p 35)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data['uraians2']), true, false, true, false, '');
    $pdf->writeHTML('<br/><p>3. Informasi tentang bagaimana koding; bila ada, untuk identitas subyek, di mana di simpan dan kapan, bagaimana dan oleh siapa bisa dibuka bila terjadi emergensi <small><i>(Guidelines 11 and 12) (p36)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data['uraians3']), true, false, true, false, '');
    $pdf->writeHTML('<br/><p>4. Kemungkinan penggunaan lebih jauh dari data personal atau material biologis/BBT <small><i>(p37)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data['uraians4']), true, false, true, false, '');

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML('<h2>T. Rencana Analisis</h2>', true, false, true, false, '');
    $pdf->writeHTML('<br/><p>1. Deskripsi tentang rencana  analisa statistik, dan kreteria bila atau dalam kondisi bagaimana akan terjadi penghentian dini keseluruhan penelitian <small><i>(Guideline 4) (B,S2)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data['uraiant1']), true, false, true, false, '');

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML('<h2>V. Konflik Kepentingan</h2>', true, false, true, false, '');
    $pdf->writeHTML('<br/><p>1. Pengaturan untuk mengatasi konflik finansial atau yang lainnya yang bisa mempengaruhi keputusan para peneliti atau personil lainya; menginformasikan pada komite lembaga tentang adanya conflict of interest; komite mengkomunikasikannya ke komite etik dan kemudian mengkomunikasikan pada para peneliti tentang langkah langkah berikutnya yang harus dilakukan <small><i>(Guideline 25) (p42)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data['uraianv1']), true, false, true, false, '');

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML('<h2>W. Manfaat Sosial</h2>', true, false, true, false, '');
    $pdf->writeHTML('<br/><p>1. Untuk penelitian yang dilakukan pada seting sumberdaya lemah, kontribusi yang dilakukan sponsor untuk capacity building untuk review ilmiah dan etika dan untuk riset-riset kesehatan di negara tersebut; dan jaminan bahwa tujuan capacity building adalah agar sesuai nilai dan harapan para partisipan dan komunitas tempat penelitian <small><i>(Guideline 8) (p43)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data['uraianw1']), true, false, true, false, '');
    $pdf->writeHTML('<br/><p>2. Protokol penelitian (dokumen) yang dikirim ke komite etik harus meliputi deskripsi rencana pelibatan komunitas, dan menunjukkan sumber-sumber yang dialokasikan untuk aktivitas aktivitas pelibatan tersebut. Dokumen ini menjelaskan apa yang sudah dan yang akan dilakukan, kapan dan oleh siapa, untuk memastikan bahwa masyarakat dengan jelas terpetakan untuk memudahkan pelibatan mereka selama riset, untuk memastikan bahwa tujuan riset sesuai kebutuhan masyarakat dan diterima oleh mereka. Bila perlu masyarakat harus dilibatkan dalam penyusunan protokol atau dokumen ini <small><i>(Guideline 7) (p44)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data['uraianw2']), true, false, true, false, '');

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML('<h2>X. Hak atas Data</h2>', true, false, true, false, '');
    $pdf->writeHTML('<br/><p>1. Terutama bila sponsor adalah industri, kontrak yang menyatakan siapa pemilik hak publiksi hasil riset, dan kewajiban untuk menyiapkan bersama dan diberikan pada para PI draft laporan hasil riset <small><i>(Guideline 24) (B dan H, S1,S7)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data['uraianx1']), true, false, true, false, '');

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML('<h2>Y. Publikasi</h2>', true, false, true, false, '');
    $pdf->writeHTML('<br/><p>Rencana publikasi hasil pada bidang tertentu (seperti epidemiology, generik, sosiologi) yang bisa beresiko berlawanan dengan kemaslahatan komunitas, masyarakat, keluarga, etnik tertentu, dan meminimalisir resiko kemudharatan kelompok ini dengan selalu mempertahankan kerahasiaan data selama dan setelah penelitian, dan mempublikasi hasil hasil penelitian sedemikian rupa dengan selalu mempertimbangkan martabat dan kemulyaan mereka <small><i>(Guideline 4) (p47)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data['uraiany1']), true, false, true, false, '');
    $pdf->writeHTML('<br/><p>Bagaimana publikasi bila hasil riset negatip. <small><i>(Guideline 24) (p46)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data['uraiany2']), true, false, true, false, '');

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML('<h2>Z. Pendanaan</h2>', true, false, true, false, '');
    $pdf->writeHTML('<br/><p>Sumber dan jumlah dana riset; lembaga funding/sponsor, dan deskripsi komitmen finansial sponsor pada kelembagaan penelitian, pada para peneliti, para subyek riset, dan, bila ada, pada komunitas <small><i>(Guideline 25) (B, S2); (p41)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data['uraianz1']), true, false, true, false, '');

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML('<h2>AA. Komitmen Etik</h2>', true, false, true, false, '');
    $pdf->writeHTML('<br/><p>1. Pernyataan peneliti utama bahwa prinsip-prinsip yang tertuang dalam pedoman ini akan dipatuhi (lampirkan scan Surat Pernyataan) <small><i>(p6)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data['uraianaa1']), true, false, true, false, '');
    $pdf->writeHTML('<br/><p>2. (Track Record) Riwayat usulan review protokol etik sebelumnya dan hasilnya (isi dengan judul da tanggal penelitian, dan hasil review Komite Etik) (lampirkan Daftar Riwayat Usulan Kaji Etiknya) <small><i>(p7)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data['uraianaa2']), true, false, true, false, '');
    $pdf->writeHTML('<br/><p>3. Pernyataan bahwa bila terdapat bukti adanya pemalsuan data akan ditangani sesuai peraturan /ketentuan yang berlaku <small><i>(p48)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data['uraianaa3']), true, false, true, false, '');

    // add a page
    $pdf->AddPage();
    $pdf->writeHTML('<h2>BB. Daftar Pustaka</h2>', true, false, true, false, '');
    $pdf->writeHTML('<br/><p>Daftar referensi yang dirujuk dalam protokol <small><i>(p40)</i></small></p>', true, false, true, false, '');
    $pdf->writeHTML(stripslashes($data['uraianbb1']), true, false, true, false, '');

    //Close and output PDF document
    $pdf->Output('protokol.pdf', 'I');
  }
*/
}
