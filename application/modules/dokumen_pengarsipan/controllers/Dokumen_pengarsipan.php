<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dokumen_pengarsipan extends Userpage_Controller {

  public function __construct()
  {
    parent::__construct();

    $this->load->model('Dokumen_pengarsipan_model', 'data_model');
  }
 
  public function index()
  {
    $data['title'] = APPNAME.' - Dokumen & Pengarsipan';
    $data['page_header'] = 'Dokumen & Pengarsipan';
    $data['breadcrumb'] = 'Dokumen & Pengarsipan';
    $data['css_content'] = 'dokumen_pengarsipan_view_css';
    $data['main_content'] = 'dokumen_pengarsipan_view';
    $data['js_content'] = 'dokumen_pengarsipan_view_js';
 
    $this->load->view('layout/template', $data);
  }

  public function form($id=0)
  {
    $data['title'] = APPNAME.' - Dokumen & Pengarsipan';
    $data['page_header'] = 'Form Dokumen & Pengarsipan';
    $data['breadcrumb'] = 'Dokumen & Pengarsipan';
    $data['css_content'] = 'dokumen_pengarsipan_form_css';
    $data['main_content'] = 'dokumen_pengarsipan_form';
    $data['js_content'] = 'dokumen_pengarsipan_form_js';
    $data['protokol'] = $this->data_model->get_data_protokol();

    if ($id > 0) {
      $data['data'] = $this->data_model->get_data_by_id($id);
    }

    $this->load->view('layout/template', $data);
  }

  function detail_progress($id_pengajuan=0)
  {
    $data['title'] = APPNAME.' - Protokol Etik Penelitian';
    $data['page_header'] = 'Detail Progress Protokol Etik Penelitian';
    $data['breadcrumb'] = 'Detail Progress Protokol Etik Penelitian';
    $data['timeline'] = $this->get_timeline_protokol_by_id_pengajuan($id_pengajuan);
    $data['pengajuan'] = $this->data_model->get_data_pengajuan_by_id_pengajuan($id_pengajuan);
    $data['penelaah_awal'] = $this->data_model->get_data_penelaah_awal_by_id_pengajuan($id_pengajuan);
    $data['penelaah'] = $this->data_model->get_data_penelaah_by_id_pengajuan($id_pengajuan);

    $this->load->view('progress_protokol_detail', $data);
  }

  public function validation_form()
  { 
    $this->form_validation->set_rules('id_pengajuan', 'Nomor Protokol', 'trim|required|is_natural_no_zero');

    $this->form_validation->set_message('required', '{field} tidak boleh kosong.');
    $this->form_validation->set_message('is_natural_no_zero', 'Harus memilih {field}.');
  }

  public function proses()
  {
    $response = (object)null;

    $this->load->library('form_validation');
    $this->validation_form();

    if ($this->form_validation->run() == TRUE)
    {
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
    }
    else
    {
      $response->isSuccess = FALSE;
      $response->message = validation_errors();
    }

    echo json_encode($response);
  }

  public function get_daftar()
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
        $response->rows[] = array(
          'id' => $result[$i]['id_dok_arsip'],
          'no_protokol' => $result[$i]['no_protokol'],
          'judul' => $result[$i]['judul'],
          'tgl_dokarsip' => date('d/m/Y', strtotime($result[$i]['tanggal_dokarsip'])),
        );
      }
    }
    
    echo json_encode($response);
  }

  function get_timeline_protokol_by_id_pengajuan($id_pengajuan)
  {
    $result = $this->data_model->get_data_timeline_protokol_by_id_pengajuan($id_pengajuan);

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

  function get_pengajuan_by_idpengajuan($id_pengajuan=0)
  {
    $result = $this->data_model->get_data_pengajuan_by_idpengajuan($id_pengajuan);

    $response = (object) NULL;
    $response->judul = isset($result['judul']) ? $result['judul'] : '-';
    $response->nama_ketua = isset($result['nama_ketua']) ? $result['nama_ketua'] : '-';
    $response->lokasi = isset($result['tempat_penelitian']) ? $result['tempat_penelitian'] : '-';
    $response->is_multi_senter = isset($result['is_multi_senter']) ? ($result['is_multi_senter'] == 1 ? 'Ya' : 'Tidak') : '-';
    $response->is_setuju_senter =  isset($result['is_multi_senter']) && $result['is_multi_senter'] == 1 ? (isset($result['is_setuju_senter']) && $result['is_setuju_senter'] == 1 ? 'Ya' : 'Tidak') : '-';

    echo json_encode($response);
  }

  function get_pep_by_id_pengajuan($id_pengajuan=0)
  {
    $result = $this->data_model->get_data_pep_by_id_pengajuan($id_pengajuan);

    $response = (object) NULL;

    if ($result)
    {
      for($i=0; $i<count($result); $i++)
      {
        $id_pep = $result[$i]['id_pep'];
        $response->data[] = array(
            'id' => $id_pep, 
            'link_proposal' => $result[$i]['link_proposal'], 
            'revisi' => $result[$i]['revisi_ke']
          );
        $lampiran_ic = $this->data_model->get_data_lampiran_ic_by_id_pep($id_pep);
        if ($lampiran_ic)
        {
          for ($j=0; $j<count($lampiran_ic); $j++)
          {
            $response->data[$i]['lampiran_ic'][] = array(
              'lampiran' => $lampiran_ic[$j]['lampiran'],
              'file_name' => $lampiran_ic[$j]['file_name'],
              'client_name' => $lampiran_ic[$j]['client_name']
            );
          }
        }
      }
    }

    echo json_encode($response->data);
  }

  function get_surat_surat_by_id_pengajuan($id_pengajuan=0)
  {
    $result = $this->data_model->get_data_surat_surat_by_id_pengajuan($id_pengajuan);

    $response = (object) NULL;

    if ($result){
      for($i=0; $i<count($result); $i++){
        switch($result[$i]['jenis_surat']){
          case 'ethical_exemption': $lampiran = '7 Standar Kelaikan Etik Penelitian'; break;
          case 'ethical_approval': $lampiran = '7 Standar Kelaikan Etik Penelitian'; break;
          case 'ethical_revision': 
                if ($result[$i]['klasifikasi'] == 2) $lampiran = 'Catatan Penelaah Expedited';
                else if ($result[$i]['klasifikasi'] == 3) $lampiran = 'Catatan Penelaah Full Board';
                else if ($result[$i]['klasifikasi'] == 4) $lampiran = 'Alasan TBD';
              break;
          default: '';
        }

        $response->data[] = array(
          'id' => $result[$i]['id_pep'],
          'jenis_surat' => $result[$i]['jenis_surat'],
          'nama_surat' => $result[$i]['nama_surat'],
          'klasifikasi' => $result[$i]['klasifikasi'],
          'lampiran' => $lampiran
        );
      }
    }

    echo json_encode($response->data);
  }
  
  function get_fileupload_by_id($id=0)
  {
    $result = $this->data_model->get_data_fileupload_by_id($id);

    $response = (object) NULL;
    $response->data = array();
    if ($result){
      for($i=0; $i<count($result); $i++){
        $response->data[] = array(
          'id' => $result[$i]['id_dda'],
          'deskripsi' => $result[$i]['deskripsi'],
          'file_name' => $result[$i]['file_name'],
          'client_name' => $result[$i]['client_name'],
          'file_size' => $result[$i]['file_size'],
          'file_type' => $result[$i]['file_type'],
          'file_ext' => $result[$i]['file_ext']
        );
      }
    }
    
    echo json_encode($response->data);
  }

  public function do_upload()
  {
    $response = (object)null;

    $dir = './dokumen_arsip/';
    if (!is_dir($dir)) {
      mkdir($dir, 0777, true);         
      chmod($dir, 0777);
    }

    $config['upload_path'] = $dir;
    $config['allowed_types'] = 'pdf|png|jpg|jpeg';
    $config['max_size'] = 100000000;
    $config['encrypt_name'] = TRUE;

    $this->load->library('upload', $config);

    if ( ! $this->upload->do_upload('file'))
    {
      $response->isSuccess = FALSE;
      $response->message = $this->upload->display_errors();
    }
    else
    {
      $response->isSuccess = TRUE;
      $response->message = 'Data berhasil diunggah';
      $response->data_fileupload = $this->upload->data();
    }

    echo json_encode($response);
  }

  function cek_file_exist($file_name)
  {
    $response = (object)null;

    if (file_exists('./dokumen_arsip/'.$file_name))
      $response->isSuccess = TRUE;
    else
      $response->isSuccess = FALSE;

    echo json_encode($response);
  }

  public function download($file_name, $client_name)
  {
    $this->load->helper('download');

    $pathfile = './dokumen_arsip/'.$file_name;
    $data = file_get_contents($pathfile);
    $client_name = urldecode(rawurldecode($client_name));

    force_download($client_name, $data);
  }

  public function download_lampiran_ic($file_name, $client_name)
  {
    $this->load->helper('download');

    $pathfile = './uploads/'.$file_name;
    $data = file_get_contents($pathfile);

    $client_name = urldecode(rawurldecode($client_name));
    
    force_download($client_name, $data);
  }

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

    $data = $this->data_model->get_data_protokol_by_id_pep($id_pep);

    if ($data['revisi_ke'] > 0)
      $pdf->writeHTML('<i>Perbaikan #'.$data['revisi_ke'].' dari nomor protokol '.$data['no_protokol'].'</i><br/>');

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

  function cetak_surat($id_pep=0, $jns_surat='', $klasifikasi=0)
  {
    switch($jns_surat){
      case 'ethical_exemption': return $this->cetak_ethical_exemption($id_pep); break;
      case 'ethical_approval': return $this->cetak_ethical_approval($id_pep); break;
      case 'ethical_revision': 
        if ($klasifikasi == 2) return $this->cetak_ethical_revision_expedited($id_pep);
        else if ($klasifikasi == 3) return $this->cetak_ethical_revision_fullboard($id_pep);
        else if ($klasifikasi == 4) return $this->cetak_ethical_revision_tbd($id_pep);
        break;
      default: '';
    }
  }

  public function cetak_ethical_exemption($id_pep=0)
  {
    $this->load->library('Pdf');

    // create new PDF document
    $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('E-Protokol');
    $pdf->SetTitle('Pembebasan Etik');
    $pdf->SetSubject('Pembebasan Etik');

    // remove default header/footer
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, 0);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
        require_once(dirname(__FILE__).'/lang/eng.php');
        $pdf->setLanguageArray($l);
    }

    // ---------------------------------------------------------

    // set font
    $pdf->SetFont('times', '', 10);

    // add a page
    $pdf->AddPage();

    $data_kop = $this->data_model->get_data_kop_surat();
    $data_ttd = $this->data_model->get_data_ttd_ketua();
    $data_ketua = $this->data_model->get_data_ketua_kepk();
    $data_ethical = $this->data_model->get_data_ethical_exemption_by_id_pep($id_pep);

    if (isset($data_kop['file_name']) && file_exists('./uploads/'.$data_kop['file_name']))
      $pdf->writeHTMLCell(210, '', 0, 5, '<img src="./uploads/'.$data_kop['file_name'].'">', 0, 1, false, true, 'L', false);

    $html = '<table border="0">';
    $html .= '<thead>';
    $html .= '<tr><th align="center"></th></tr>';
    $html .= '<tr><th align="center"><strong>KETERANGAN LAYAK ETIK</strong></th></tr>';
    $html .= '<tr><th align="center"><i>DESCRIPTION OF ETHICAL EXEMPTION</i></th></tr>';
    $html .= '<tr><th align="center">"ETHICAL EXEMPTION"</th></tr>';
    $html .= '<tr><th align="center"><br/></th></tr>';
    $html .= '<tr><th align="center">No.'.$data_ethical['no_surat'].'</th></tr>';
    $html .= '</thead>';
    $html .= '</table>';

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    // set font
    $pdf->SetFont('times', '', 10);

    $html = '<p>Protokol penelitian versi 1 yang diusulkan oleh :';
    $html .= '<br/><i>The research protocol proposed by</i></p>';

    $html .= '<table border="0">';
    $html .= '<thead>';
    $html .= '<tr><th width="30%"><u>Peneliti utama</u></th>
                  <th width="2%">:</th>
                  <th>'.$data_ethical['nama_ketua'].'</th></tr>';
    $html .= '<tr><th width="30%"><i>Principal In Investigator</i></th>
                  <th width="2%"></th>
                  <th></th></tr>';
    $html .= '<tr><th width="30%"></th>
                  <th width="2%"></th>
                  <th></th></tr>';
    $html .= '<tr><th width="30%"><u>Nama Institusi</u></th>
                  <th width="2%">:</th>
                  <th>'.$data_ethical['nama_institusi'].'</th></tr>';
    $html .= '<tr><th width="30%"><i>Name of the Institution</i></th>
                  <th width="2%"></th>
                  <th></th></tr>';
    $html .= '</thead>';
    $html .= '</table>';

    $html .= '<p>Dengan judul:<br/><i>Title</i></p>';

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    // set font
    $pdf->SetFont('times', '', 10);

    $html = '<p align="center"><strong>"'.$data_ethical['judul'].'"</strong></p>';
    $html .= '<p align="center"><i>"'.$data_ethical['title'].'"</strong></p>';
    $html .= '<p></p>';

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    // set font
    $pdf->SetFont('times', '', 10);

    $tgl = date('d', strtotime($data_ethical['tanggal_surat']));
    $bln = nama_bulan(date('m', strtotime($data_ethical['tanggal_surat'])));
    $thn = date('Y', strtotime($data_ethical['tanggal_surat']));
    $tgl_surat = $tgl.' '.$bln.' '.$thn;

    $tgl_awal = date('d', strtotime($data_ethical['awal_berlaku']));
    $bln_awal = nama_bulan(date('m', strtotime($data_ethical['awal_berlaku'])));
    $thn_awal = date('Y', strtotime($data_ethical['awal_berlaku']));
    $awal = $tgl_awal.' '.$bln_awal.' '.$thn_awal;

    $tgl_akhir = date('d', strtotime($data_ethical['akhir_berlaku']));
    $bln_akhir = nama_bulan(date('m', strtotime($data_ethical['akhir_berlaku'])));
    $thn_akhir = date('Y', strtotime($data_ethical['akhir_berlaku']));
    $akhir = $tgl_akhir.' '.$bln_akhir.' '.$thn_akhir;

    $html = '<p align="justify">Dinyatakan layak etik sesuai 7 (tujuh) Standar WHO 2011, yaitu 1) Nilai Sosial, 2) Nilai Ilmiah, 3)  Pemerataan Beban dan Manfaat, 4) Risiko, 5) Bujukan/Eksploitasi, 6) Kerahasiaan dan Privacy, dan 7) Persetujuan Setelah Penjelasan, yang  merujuk pada  Pedoman CIOMS 2016. Hal ini seperti yang  ditunjukkan oleh terpenuhinya indikator setiap standar.</p>';
    $html .= '<p align="justify"><i>Declared to be ethically appropriate in accordance to 7 (seven) WHO 2011 Standards, 1) Social Values, 2) Scientific Values, 3) Equitable Assessment and Benefits, 4) Risks, 5) Persuasion/Exploitation, 6) Confidentiality and Privacy, and 7) Informed Concent, referring to the 2016 CIOMS Guidelines. This is as indicated by the fulfillment of the indicators of each standard.</i></p>';
    $html .= '<p align="justify">Pernyataan Laik Etik ini berlaku selama kurun waktu tanggal '.$awal.' sampai dengan tanggal '.$akhir.'.</p>';
    $html .= '<p align="justify"><i>This declaration of ethics applies during the period '.date('F d, Y', strtotime($data_ethical['awal_berlaku'])).' until '.date('F d, Y', strtotime($data_ethical['akhir_berlaku'])).'.</i></p>';

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    if (isset($data_ttd['file_name']) && $data_ttd['file_name'] != '')
      $ttd = '<img src="./uploads/'.$data_ttd['file_name'].'" height="80">';
    else
      $ttd = '<br/><br/><br/><br/><br/>';

    $html = '<table border="0">';
    $html .= '<tr>
                <td width="50%"></td>
                <td width="50%" align="center"><i>'.date('F d, Y', strtotime($data_ethical['tanggal_surat'])).'</i></td>
              </tr>';
    $html .= '<tr>
                <td width="50%"></td>
                <td width="50%" align="center"><i>Chairperson,</i></td>
              </tr>';
    $html .= '<tr>
                <td width="50%"></td>
                <td width="50%" align="center">'.$ttd.'</td>
              </tr>';
    $html .= '<tr>
                <td width="50%"></td>
                <td width="50%" align="center">'.$data_ketua['nama'].'</td>
              </tr>';
    $html .= '</table>';

    $pdf->writeHTMLCell(0, '', '', 220, $html, 0, 0, 0, true, 'L', true);

    // set style for barcode
    $style = array(
        'border' => 2,
        'vpadding' => 'auto',
        'hpadding' => 'auto',
        'fgcolor' => array(0,0,0),
        'bgcolor' => false, //array(255,255,255)
        'module_width' => 1, // width of a single module in points
        'module_height' => 1 // height of a single module in points
    );

    $pdf->write2DBarcode(date('Y-m-d H:i:s').' | '.$data_ethical['no_protokol'].' | '.$data_ketua['nomor'].' | '.$data_ketua['nik'].' | '.$data_ethical['no_dokumen'], 'QRCODE,L', 20, 230, 20, 20, $style, 'N');

    $id_pengajuan = $data_ethical['id_pengajuan'];
    $data_anggota = $this->data_model->get_anggota_penelitian_by_id_pengajuan($id_pengajuan);

    if (!empty($data_anggota))
    {
      $html = '<p>Anggota Peneliti : ';
      for ($x=0; $x<count($data_anggota); $x++)
      {
        $html .= $data_anggota[$x]['nama'];

        if ($x == count($data_anggota)-2)
          $html .= ' dan ';
        else if ($x < count($data_anggota)-1)
          $html .= ', ';
      }
      $html .= '</p>';

      $pdf->writeHTMLCell(0, '', '', 260, $html, 0, 0, 0, true, 'L', true);
    }

    // set font
    $pdf->SetFont('times', '', 8);

    $pdf->writeHTMLCell(0, '', '', 285, $data_ethical['no_dokumen'], 0, 0, 0, true, 'R', true);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set font
    $pdf->SetFont('helvetica', '', 12);

    // add a page
    $pdf->AddPage();

    $data_sa = $this->data_model->get_data_standar_kelaikan($id_pep);

    $html = '<table border="0">';
    $html .= '<thead>';
    $html .= '<tr><th align="center"><strong><u>7 STANDAR</u></strong></th></tr>';
    $html .= '<tr><th align="center"><strong>NOMOR PROTOKOL : '.$data_ethical['no_protokol'].'</strong></th></tr>';
    $html .= '</thead>';
    $html .= '</table>';

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    // set font
    $pdf->SetFont('helvetica', '', 10);

    $html = '<table border="1" cellpadding="5">';
    $html .= '<thead>';
    $html .= '<tr>
                <th width="8%"></th>
                <th width="77%">7-STANDAR KELAIKAN ETIK PENELITIAN</th>
                <th width="15%" align="center">SEKRETARIS</th>
              </tr>';
    $html .= '</thead>';
    $html .= '<tbody>';

    for($i=0; $i<count($data_sa); $i++){
      if ($data_sa[$i]['pilihan_sekretaris'] != '')
      {
        $html .= '<tr nobr="true" class="';
        $html .= $data_sa[$i]['level'] == 0 ? 'active' : '';
        $html .= '">';
        $html .= '<td width="8%" align="';
        $html .= $data_sa[$i]['level'] == 0 ? 'left': 'right';
        $html .= '">'.$data_sa[$i]['nomor'].'</td>';
        $html .= '<td width="77%"><div>';
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
        $html .= '<td width="15%" align="center">'.$data_sa[$i]['pilihan_sekretaris'].'</td>';
        $html .= '</tr>';
      }
    }
    $html .= '</tbody>';
    $html .= '</table>';

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    //Close and output PDF document
    $pdf->Output('ethical-exemption-self-assesment.pdf', 'I');
  }

  public function cetak_ethical_approval($id_pep=0)
  {
    $this->load->library('Pdf');

    // create new PDF document
    $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('E-Protokol');
    $pdf->SetTitle('Persetujuan Etik');
    $pdf->SetSubject('Persetujuan Etik');

    // remove default header/footer
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, 0);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
        require_once(dirname(__FILE__).'/lang/eng.php');
        $pdf->setLanguageArray($l);
    }

    // ---------------------------------------------------------

    // set font
    $pdf->SetFont('times', '', 10);

    // add a page
    $pdf->AddPage();

    $data_kop = $this->data_model->get_data_kop_surat();
    $data_ttd = $this->data_model->get_data_ttd_ketua();
    $data_ketua = $this->data_model->get_data_ketua_kepk();
    $data_ethical = $this->data_model->get_data_ethical_approval_by_id_pep($id_pep);

    $id_pep = isset($data_ethical['id_pep']) ? $data_ethical['id_pep'] : 0;

    if (isset($data_kop['file_name']) && file_exists('./uploads/'.$data_kop['file_name']))
      $pdf->writeHTMLCell(210, '', 0, 5, '<img src="./uploads/'.$data_kop['file_name'].'">', 0, 1, false, true, 'L', false);

    $html = '<table border="0">';
    $html .= '<thead>';
    $html .= '<tr><th align="center"></th></tr>';
    $html .= '<tr><th align="center"><strong>KETERANGAN LAYAK ETIK</strong></th></tr>';
    $html .= '<tr><th align="center"><i>DESCRIPTION OF ETHICAL APPROVAL</i></th></tr>';
    $html .= '<tr><th align="center">"ETHICAL APPROVAL"</th></tr>';
    $html .= '<tr><th align="center"><br/></th></tr>';
    $html .= '<tr><th align="center">No.'.$data_ethical['no_surat'].'</th></tr>';
    $html .= '</thead>';
    $html .= '</table>';

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    // set font
    $pdf->SetFont('times', '', 10);

    $versi = isset($data_ethical['revisi_ke']) ? $data_ethical['revisi_ke']+1 : 1;
    $html = '<p>Protokol penelitian versi '.$versi.' yang diusulkan oleh :';
    $html .= '<br/><i>The research protocol proposed by</i></p>';

    $html .= '<table border="0">';
    $html .= '<thead>';
    $html .= '<tr><th width="30%"><u>Peneliti utama</u></th>
                  <th width="2%">:</th>
                  <th>'.$data_ethical['nama_ketua'].'</th></tr>';
    $html .= '<tr><th width="30%"><i>Principal In Investigator</i></th>
                  <th width="2%"></th>
                  <th></th></tr>';
    $html .= '<tr><th width="30%"></th>
                  <th width="2%"></th>
                  <th></th></tr>';
    $html .= '<tr><th width="30%"><u>Nama Institusi</u></th>
                  <th width="2%">:</th>
                  <th>'.$data_ethical['nama_institusi'].'</th></tr>';
    $html .= '<tr><th width="30%"><i>Name of the Institution</i></th>
                  <th width="2%"></th>
                  <th></th></tr>';
    $html .= '</thead>';
    $html .= '</table>';

    $html .= '<p>Dengan judul:<br/><i>Title</i></p>';

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    // set font
    $pdf->SetFont('times', '', 10);

    $html = '<p align="center"><strong>"'.$data_ethical['judul'].'"</strong></p>';
    $html .= '<p align="center"><i>"'.$data_ethical['title'].'"</strong></p>';
    $html .= '<p></p>';

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    // set font
    $pdf->SetFont('times', '', 10);

    $tgl = date('d', strtotime($data_ethical['tanggal_surat']));
    $bln = nama_bulan(date('m', strtotime($data_ethical['tanggal_surat'])));
    $thn = date('Y', strtotime($data_ethical['tanggal_surat']));
    $tgl_surat = $tgl.' '.$bln.' '.$thn;

    $tgl_awal = date('d', strtotime($data_ethical['awal_berlaku']));
    $bln_awal = nama_bulan(date('m', strtotime($data_ethical['awal_berlaku'])));
    $thn_awal = date('Y', strtotime($data_ethical['awal_berlaku']));
    $awal = $tgl_awal.' '.$bln_awal.' '.$thn_awal;

    $tgl_akhir = date('d', strtotime($data_ethical['akhir_berlaku']));
    $bln_akhir = nama_bulan(date('m', strtotime($data_ethical['akhir_berlaku'])));
    $thn_akhir = date('Y', strtotime($data_ethical['akhir_berlaku']));
    $akhir = $tgl_akhir.' '.$bln_akhir.' '.$thn_akhir;

    $html = '<p align="justify">Dinyatakan layak etik sesuai 7 (tujuh) Standar WHO 2011, yaitu 1) Nilai Sosial, 2) Nilai Ilmiah, 3)  Pemerataan Beban dan Manfaat, 4) Risiko, 5) Bujukan/Eksploitasi, 6) Kerahasiaan dan Privacy, dan 7) Persetujuan Setelah Penjelasan, yang  merujuk pada  Pedoman CIOMS 2016. Hal ini seperti yang  ditunjukkan oleh terpenuhinya indikator setiap standar.</p>';
    $html .= '<p align="justify"><i>Declared to be ethically appropriate in accordance to 7 (seven) WHO 2011 Standards, 1) Social Values, 2) Scientific Values, 3) Equitable Assessment and Benefits, 4) Risks, 5) Persuasion/Exploitation, 6) Confidentiality and Privacy, and 7) Informed Concent, referring to the 2016 CIOMS Guidelines. This is as indicated by the fulfillment of the indicators of each standard.</i></p>';
    $html .= '<p align="justify">Pernyataan Laik Etik ini berlaku selama kurun waktu tanggal '.$awal.' sampai dengan tanggal '.$akhir.'.</p>';
    $html .= '<p align="justify"><i>This declaration of ethics applies during the period '.date('F d, Y', strtotime($data_ethical['awal_berlaku'])).' until '.date('F d, Y', strtotime($data_ethical['akhir_berlaku'])).'.</i></p>';

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    if (isset($data_ttd['file_name']) && $data_ttd['file_name'] != '')
      $ttd = '<img src="./uploads/'.$data_ttd['file_name'].'" height="80">';
    else
      $ttd = '<br/><br/><br/><br/><br/>';

    $html = '<table border="0">';
    $html .= '<tr>
                <td width="50%"></td>
                <td width="50%" align="center"><i>'.date('F d, Y', strtotime($data_ethical['tanggal_surat'])).'</i></td>
              </tr>';
    $html .= '<tr>
                <td width="50%"></td>
                <td width="50%" align="center"><i>Chairperson,</i></td>
              </tr>';
    $html .= '<tr>
                <td width="50%"></td>
                <td width="50%" align="center">'.$ttd.'</td>
              </tr>';
    $html .= '<tr>
                <td width="50%"></td>
                <td width="50%" align="center">'.$data_ketua['nama'].'</td>
              </tr>';
    $html .= '</table>';

    $pdf->writeHTMLCell(0, '', '', 220, $html, 0, 0, 0, true, 'L', true);

    // set style for barcode
    $style = array(
        'border' => 2,
        'vpadding' => 'auto',
        'hpadding' => 'auto',
        'fgcolor' => array(0,0,0),
        'bgcolor' => false, //array(255,255,255)
        'module_width' => 1, // width of a single module in points
        'module_height' => 1 // height of a single module in points
    );

    $pdf->write2DBarcode(date('Y-m-d H:i:s').' | '.$data_ethical['no_protokol'].' | '.$data_ketua['nomor'].' | '.$data_ketua['nik'].' | '.$data_ethical['no_dokumen'], 'QRCODE,L', 20, 230, 20, 20, $style, 'N');

    $id_pengajuan = $data_ethical['id_pengajuan'];
    $data_anggota = $this->data_model->get_anggota_penelitian_by_id_pengajuan($id_pengajuan);

    if (!empty($data_anggota))
    {
      $html = '<p>Anggota Peneliti : ';
      for ($x=0; $x<count($data_anggota); $x++)
      {
        $html .= $data_anggota[$x]['nama'];

        if ($x == count($data_anggota)-2)
          $html .= ' dan ';
        else if ($x < count($data_anggota)-1)
          $html .= ', ';
      }
      $html .= '</p>';

      $pdf->writeHTMLCell(0, '', '', 260, $html, 0, 0, 0, true, 'L', true);
    }

    // set font
    $pdf->SetFont('times', '', 8);

    $pdf->writeHTMLCell(0, '', '', 285, $data_ethical['no_dokumen'], 0, 0, 0, true, 'R', true);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set font
    $pdf->SetFont('helvetica', '', 12);

    // add a page
    $pdf->AddPage();

    $data_sa = $this->data_model->get_data_standar_kelaikan($id_pep);

    $html = '<table border="0">';
    $html .= '<thead>';
    $html .= '<tr><th align="center"><strong><u>7 STANDAR</u></strong></th></tr>';
    $html .= '<tr><th align="center"><strong>NOMOR PROTOKOL : '.$data_ethical['no_protokol'].'</strong></th></tr>';
    $html .= '</thead>';
    $html .= '</table>';

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    // set font
    $pdf->SetFont('helvetica', '', 10);

    $html = '<table border="1" cellpadding="5">';
    $html .= '<thead>';
    $html .= '<tr>
                <th width="8%"></th>
                <th width="77%">7-STANDAR KELAIKAN ETIK PENELITIAN</th>
                <th width="15%" align="center">PENELAAH</th>
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
          $html .= '<td width="8%" align="';
          $html .= $data_sa[$i]['level'] == 0 ? 'left': 'right';
          $html .= '">'.$data_sa[$i]['nomor_tampilan'].'</td>';
          $html .= '<td width="77%"><div>';
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
          $html .= '<td width="15%" align="center">'.$data_sa[$i]['pilihan_penelaah'].'</td>';
          $html .= '</tr>';
        }
      }
      else
      {
        $html .= '<tr>';
        $html .= '<td width="8%"></td>';
        $html .= '<td width="77%">'.$data_sa[$i]['uraian'].'</td>';
        $html .= '<td width="15%"></td>';
        $html .= '</tr>';
      }
    }
    $html .= '</tbody>';
    $html .= '</table>';

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    //Close and output PDF document
    $pdf->Output('ethical-approval-self-assesment.pdf', 'I');
  }

  public function cetak_ethical_revision_expedited($id_pep=0)
  {
    $this->load->library('Pdf');

    // create new PDF document
    $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('E-Protokol');
    $pdf->SetTitle('Perbaikan Etik');
    $pdf->SetSubject('Perbaikan Etik');

    // remove default header/footer
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, 0);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
        require_once(dirname(__FILE__).'/lang/eng.php');
        $pdf->setLanguageArray($l);
    }

    // ---------------------------------------------------------

    // set font
    $pdf->SetFont('times', '', 10);

    // add a page
    $pdf->AddPage();

    $data_kop = $this->data_model->get_data_kop_surat();

    if (isset($data_kop['file_name']) && file_exists('./uploads/'.$data_kop['file_name']))
      $pdf->writeHTMLCell(210, '', 0, 5, '<img src="./uploads/'.$data_kop['file_name'].'">', 0, 1, false, true, 'L', false);

    $html = '<table border="0">';
    $html .= '<thead>';
    $html .= '<tr><th align="center"><strong><u>PERBAIKAN ETIK</u></strong></th></tr>';
    $html .= '</thead>';
    $html .= '</table>';

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    // set font
    $pdf->SetFont('times', '', 10);

    $data_ketua = $this->data_model->get_data_ketua_kepk();
    $data_ethical = $this->data_model->get_data_ethical_revision_by_id_pep($id_pep);

    $html = '<table border="0">';
    $html .= '<thead>';
    $html .= '<tr><th align="center">
                <strong>Komite Etik Penelitian Kesehatan (KEPK) '.$data_ethical['nama_kepk'].'</strong>
              </th></tr>';
    $html .= '<tr><th align="center">
                <strong>Nomor Registrasi Pada KEPPKN : '.$data_ethical['kodefikasi'].'</strong></th></tr>';
    $html .= '<tr><th align="center">
                <strong>Terdaftar/Terakreditasi</strong></th></tr>';
    $html .= '</thead>';
    $html .= '</table>';
    $html .= '<hr>';
    $html .= '<table border="0" style="margin-top: 20px">';
    $html .= '<thead>';
    $html .= '<tr><th align="center"><strong>Surat Pernyataan Perbaikan Etik Penelitian Kesehatan</strong></th></tr>';
    $html .= '</thead>';
    $html .= '</table>';
    $html .= '<hr>';
    $html .= '<br/>';
    $html .= '<div style="margin-bottom: 40px"></div>';
    $html .= '<div align="center"><strong>Nomor : '.$data_ethical['no_surat'].'</strong></div>';
    $html .= '<div style="margin-bottom: 10px"></div>';

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    // set font
    $pdf->SetFont('helvetica', '', 10);

    $tgl = date('d', strtotime($data_ethical['tanggal_surat']));
    $bln = nama_bulan(date('m', strtotime($data_ethical['tanggal_surat'])));
    $thn = date('Y', strtotime($data_ethical['tanggal_surat']));
    $tgl_surat = $tgl.' '.$bln.' '.$thn;

    $tgl_awal = date('d', strtotime($data_ethical['awal_berlaku']));
    $bln_awal = nama_bulan(date('m', strtotime($data_ethical['awal_berlaku'])));
    $thn_awal = date('Y', strtotime($data_ethical['awal_berlaku']));
    $awal = $tgl_awal.' '.$bln_awal.' '.$thn_awal;

    $tgl_akhir = date('d', strtotime($data_ethical['akhir_berlaku']));
    $bln_akhir = nama_bulan(date('m', strtotime($data_ethical['akhir_berlaku'])));
    $thn_akhir = date('Y', strtotime($data_ethical['akhir_berlaku']));
    $akhir = $tgl_akhir.' '.$bln_akhir.' '.$thn_akhir;

    $html = '<p align="justify">Protokol penelitian yang diusulkan oleh: <strong>'.$data_ethical['nama_ketua'].'</strong> dengan judul: <strong>'.$data_ethical['judul'].'</strong> dinyatakan diperbaiki ';
    if ($data_ethical['klasifikasi'] < 4) {
      $html .= ' sesuai 7 (tujuh) Standar WHO 2011, yaitu 1) Nilai Sosial, 2) Nilai Ilmiah, 3) Pemerataan Beban dan Manfaat, 4) Risiko, 5) Bujukan/Eksploitasi, 6) Kerahasiaan dan Privacy, dan 7) Penjelasan Sebelum Persetujuan, yang merujuk pada Pedoman CIOMS 2016. Hal ini seperti yang ditunjukkan oleh terpenuhinya indikator masing-masing Standar, sebagaimana terlampir.</p>';
    } else {
      $html .= '(belum bisa ditelaah etik) sesuai 7 (tujuh) Standar WHO 2011, yaitu 1) Nilai Sosial, 2) Nilai Ilmiah, 3) Pemerataan Beban dan Manfaat, 4) Risiko, 5) Bujukan/Eksploitasi, 6) Kerahasiaan dan Privacy, dan 7) Penjelasan Sebelum Persetujuan, yang merujuk pada Pedoman CIOMS 2016.</p>';
    }
    $html .= '<p align="justify">Pernyataan Perbaikan Etik ini berlaku selama kurun waktu tanggal '.$awal.' sampai dengan tanggal '.$akhir.'.</p>';

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    $data_ttd = $this->data_model->get_data_ttd_ketua();

    if (isset($data_ttd['file_name']) && $data_ttd['file_name'] != '')
      $ttd = '<img src="./uploads/'.$data_ttd['file_name'].'" height="80">';
    else
      $ttd = '<br/><br/><br/><br/><br/>';

    $html = '<table border="0">';
    $html .= '<tr><td width="30%"></td><td width="40%"></td><td width="30%" align="center">Ketua KEPK,</td></tr>';
    $html .= '<tr><td width="30%"></td><td width="40%"></td><td width="30%" align="center">'.$ttd.'</td></tr>';
    $html .= '<tr><td width="30%"></td><td width="40%"></td><td width="30%" align="center">'.$data_ketua['nama'].'</td></tr>';
    $html .= '</table>';

    $pdf->writeHTMLCell(0, '', '', 140, $html, 0, 0, 0, true, 'L', true);

    // set style for barcode
    $style = array(
        'border' => 2,
        'vpadding' => 'auto',
        'hpadding' => 'auto',
        'fgcolor' => array(0,0,0),
        'bgcolor' => false, //array(255,255,255)
        'module_width' => 1, // width of a single module in points
        'module_height' => 1 // height of a single module in points
    );

    $pdf->write2DBarcode(date('Y-m-d H:i:s').' | '.$data_ethical['no_protokol'].' | '.$data_ketua['nomor'].' | '.$data_ketua['nik'].' | '.$data_ethical['no_dokumen'], 'QRCODE,L', 20, 145, 20, 20, $style, 'N');
    $id_pengajuan = $data_ethical['id_pengajuan'];
    $data_anggota = $this->data_model->get_anggota_penelitian_by_id_pengajuan($id_pengajuan);

    $html = '<br/><br/><br/><br/>';

    if (!empty($data_anggota))
    {
      $html .= '<p>Anggota Peneliti : ';
      for ($x=0; $x<count($data_anggota); $x++)
      {
        $html .= $data_anggota[$x]['nama'];

        if ($x == count($data_anggota)-2)
          $html .= ' dan ';
        else if ($x < count($data_anggota)-1)
          $html .= ', ';
      }
      $html .= '</p>';
    }

    $html .= '<table border="0">';
    $html .= '<tr><td colspan="2">Catatan untuk Peneliti dan Para Pihak : </td></tr>';
    $html .= '<tr><td width="4%">1)</td><td width="96%">Setiap pelaksanaan yang menyimpang dari protokol etik penelitian ini, harus sudah dilaporkan kepada kami untuk memperoleh pertimbangan dan persetujuan; </td></tr>';
    $html .= '<tr><td>2)</td><td>Setiap kejadian yg tidak diharapkan, yang timbul dari pelaksanaan penelitian ini harus segera dilaporkan kepada kami</td></tr>';
    $html .= '<tr><td>3)</td><td>Peneliti bersedia untuk sewaktu-waktu memperoleh pemantauan pelaksanaan penelitian</td></tr>';
    $html .= '<tr><td>4)</td><td>Para pihak terkait dapat menyampaikan aduan terkait dengan pelaksanaan penelitian ini kepada kami melalui e-mail, maupun WA kepada Nomor HP kami</td></tr>';
    $html .= '<tr><td>5)</td><td>Peneliti harus memasukkan laporan tahunan (berupa ringkasan/ abstrak) kepada kami, atau laporan akhir (abstrak) jika penelitian tidak melebihi 1 (satu) tahun</td></tr>';
    $html .= '</table>';

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    // set font
    $pdf->SetFont('times', '', 8);

    $pdf->writeHTMLCell(0, '', '', 285, $data_ethical['no_dokumen'], 0, 0, 0, true, 'R', true);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set font
    $pdf->SetFont('helvetica', '', 12);

    // add a page
    $pdf->AddPage();

    $html = '<table border="0">';
    $html .= '<thead>';
    $html .= '<tr><th align="center"><strong><u>RINGKASAN KOMPILASI PROTOKOL</u></strong></th></tr>';
    $html .= '<tr><th align="center"><strong>NOMOR PROTOKOL : '.$data_ethical['no_protokol'].'</strong></th></tr>';
    $html .= '</thead>';
    $html .= '</table>';

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    // set font
    $pdf->SetFont('helvetica', '', 10);

    $data_telaah = $this->data_model->get_data_telaah_expedited_by_idpep($id_pep);

    $html = '';
    if ($data_telaah)
    {
      for ($i=0; $i<count($data_telaah); $i++)
      {
        $no = $i+1;
        $catatan_protokol = stripslashes($data_telaah[$i]['catatan_protokol']);
        $catatan_7standar = stripslashes($data_telaah[$i]['catatan_7standar']);
        $html .= '<h2><u>Catatan Penelaah # '.$no.'</u></h2>';        
        $html .= '<strong><u>Catatan Protokol</u></strong>';
        $html .= '<p class="justify">';
        $html .= $catatan_protokol;
        $html .= '</p>';
        $html .= '<strong><u>Catatan 7 Standar</u></strong>';
        $html .= '<p class="justify">';
        $html .= $catatan_7standar;
        $html .= '</p>';
        $html .= '<br/>';
      }
    }

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    //Close and output PDF document
    $pdf->Output('ethical-revision-catatan-telaah-expedited.pdf', 'I');
  }

  public function cetak_ethical_revision_fullboard($id_pep=0)
  {
    $this->load->library('Pdf');

    // create new PDF document
    $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('E-Protokol');
    $pdf->SetTitle('Perbaikan Etik');
    $pdf->SetSubject('Perbaikan Etik');

    // remove default header/footer
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, 0);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
        require_once(dirname(__FILE__).'/lang/eng.php');
        $pdf->setLanguageArray($l);
    }

    // ---------------------------------------------------------

    // set font
    $pdf->SetFont('times', '', 10);

    // add a page
    $pdf->AddPage();

    $data_kop = $this->data_model->get_data_kop_surat();

    if (isset($data_kop['file_name']) && file_exists('./uploads/'.$data_kop['file_name']))
      $pdf->writeHTMLCell(210, '', 0, 5, '<img src="./uploads/'.$data_kop['file_name'].'">', 0, 1, false, true, 'L', false);

    $html = '<table border="0">';
    $html .= '<thead>';
    $html .= '<tr><th align="center"><strong><u>PERBAIKAN ETIK</u></strong></th></tr>';
    $html .= '</thead>';
    $html .= '</table>';

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    // set font
    $pdf->SetFont('times', '', 10);

    $data_ketua = $this->data_model->get_data_ketua_kepk();
    $data_ethical = $this->data_model->get_data_ethical_revision_by_id_pep($id_pep);

    $html = '<table border="0">';
    $html .= '<thead>';
    $html .= '<tr><th align="center">
                <strong>Komite Etik Penelitian Kesehatan (KEPK) '.$data_ethical['nama_kepk'].'</strong>
              </th></tr>';
    $html .= '<tr><th align="center">
                <strong>Nomor Registrasi Pada KEPPKN : '.$data_ethical['kodefikasi'].'</strong></th></tr>';
    $html .= '<tr><th align="center">
                <strong>Terdaftar/Terakreditasi</strong></th></tr>';
    $html .= '</thead>';
    $html .= '</table>';
    $html .= '<hr>';
    $html .= '<table border="0" style="margin-top: 20px">';
    $html .= '<thead>';
    $html .= '<tr><th align="center"><strong>Surat Pernyataan Perbaikan Etik Penelitian Kesehatan</strong></th></tr>';
    $html .= '</thead>';
    $html .= '</table>';
    $html .= '<hr>';
    $html .= '<br/>';
    $html .= '<div style="margin-bottom: 40px"></div>';
    $html .= '<div align="center"><strong>Nomor : '.$data_ethical['no_surat'].'</strong></div>';
    $html .= '<div style="margin-bottom: 10px"></div>';

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    // set font
    $pdf->SetFont('helvetica', '', 10);

    $tgl = date('d', strtotime($data_ethical['tanggal_surat']));
    $bln = nama_bulan(date('m', strtotime($data_ethical['tanggal_surat'])));
    $thn = date('Y', strtotime($data_ethical['tanggal_surat']));
    $tgl_surat = $tgl.' '.$bln.' '.$thn;

    $tgl_awal = date('d', strtotime($data_ethical['awal_berlaku']));
    $bln_awal = nama_bulan(date('m', strtotime($data_ethical['awal_berlaku'])));
    $thn_awal = date('Y', strtotime($data_ethical['awal_berlaku']));
    $awal = $tgl_awal.' '.$bln_awal.' '.$thn_awal;

    $tgl_akhir = date('d', strtotime($data_ethical['akhir_berlaku']));
    $bln_akhir = nama_bulan(date('m', strtotime($data_ethical['akhir_berlaku'])));
    $thn_akhir = date('Y', strtotime($data_ethical['akhir_berlaku']));
    $akhir = $tgl_akhir.' '.$bln_akhir.' '.$thn_akhir;

    $html = '<p align="justify">Protokol penelitian yang diusulkan oleh: <strong>'.$data_ethical['nama_ketua'].'</strong> dengan judul: <strong>'.$data_ethical['judul'].'</strong> dinyatakan diperbaiki ';
    if ($data_ethical['klasifikasi'] < 4) {
      $html .= ' sesuai 7 (tujuh) Standar WHO 2011, yaitu 1) Nilai Sosial, 2) Nilai Ilmiah, 3) Pemerataan Beban dan Manfaat, 4) Risiko, 5) Bujukan/Eksploitasi, 6) Kerahasiaan dan Privacy, dan 7) Penjelasan Sebelum Persetujuan, yang merujuk pada Pedoman CIOMS 2016. Hal ini seperti yang ditunjukkan oleh terpenuhinya indikator masing-masing Standar, sebagaimana terlampir.</p>';
    } else {
      $html .= '(belum bisa ditelaah etik) sesuai 7 (tujuh) Standar WHO 2011, yaitu 1) Nilai Sosial, 2) Nilai Ilmiah, 3) Pemerataan Beban dan Manfaat, 4) Risiko, 5) Bujukan/Eksploitasi, 6) Kerahasiaan dan Privacy, dan 7) Penjelasan Sebelum Persetujuan, yang merujuk pada Pedoman CIOMS 2016.</p>';
    }
    $html .= '<p align="justify">Pernyataan Perbaikan Etik ini berlaku selama kurun waktu tanggal '.$awal.' sampai dengan tanggal '.$akhir.'.</p>';

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    $data_ttd = $this->data_model->get_data_ttd_ketua();

    if (isset($data_ttd['file_name']) && $data_ttd['file_name'] != '')
      $ttd = '<img src="./uploads/'.$data_ttd['file_name'].'" height="80">';
    else
      $ttd = '<br/><br/><br/><br/><br/>';

    $html = '<table border="0">';
    $html .= '<tr><td width="30%"></td><td width="40%"></td><td width="30%" align="center">Ketua KEPK,</td></tr>';
    $html .= '<tr><td width="30%"></td><td width="40%"></td><td width="30%" align="center">'.$ttd.'</td></tr>';
    $html .= '<tr><td width="30%"></td><td width="40%"></td><td width="30%" align="center">'.$data_ketua['nama'].'</td></tr>';
    $html .= '</table>';

    $pdf->writeHTMLCell(0, '', '', 140, $html, 0, 0, 0, true, 'L', true);

    // set style for barcode
    $style = array(
        'border' => 2,
        'vpadding' => 'auto',
        'hpadding' => 'auto',
        'fgcolor' => array(0,0,0),
        'bgcolor' => false, //array(255,255,255)
        'module_width' => 1, // width of a single module in points
        'module_height' => 1 // height of a single module in points
    );

    $pdf->write2DBarcode(date('Y-m-d H:i:s').' | '.$data_ethical['no_protokol'].' | '.$data_ketua['nomor'].' | '.$data_ketua['nik'].' | '.$data_ethical['no_dokumen'], 'QRCODE,L', 20, 145, 20, 20, $style, 'N');
    $id_pengajuan = $data_ethical['id_pengajuan'];
    $data_anggota = $this->data_model->get_anggota_penelitian_by_id_pengajuan($id_pengajuan);

    $html = '<br/><br/><br/><br/>';

    if (!empty($data_anggota))
    {
      $html .= '<p>Anggota Peneliti : ';
      for ($x=0; $x<count($data_anggota); $x++)
      {
        $html .= $data_anggota[$x]['nama'];

        if ($x == count($data_anggota)-2)
          $html .= ' dan ';
        else if ($x < count($data_anggota)-1)
          $html .= ', ';
      }
      $html .= '</p>';
    }

    $html .= '<table border="0">';
    $html .= '<tr><td colspan="2">Catatan untuk Peneliti dan Para Pihak : </td></tr>';
    $html .= '<tr><td width="4%">1)</td><td width="96%">Setiap pelaksanaan yang menyimpang dari protokol etik penelitian ini, harus sudah dilaporkan kepada kami untuk memperoleh pertimbangan dan persetujuan; </td></tr>';
    $html .= '<tr><td>2)</td><td>Setiap kejadian yg tidak diharapkan, yang timbul dari pelaksanaan penelitian ini harus segera dilaporkan kepada kami</td></tr>';
    $html .= '<tr><td>3)</td><td>Peneliti bersedia untuk sewaktu-waktu memperoleh pemantauan pelaksanaan penelitian</td></tr>';
    $html .= '<tr><td>4)</td><td>Para pihak terkait dapat menyampaikan aduan terkait dengan pelaksanaan penelitian ini kepada kami melalui e-mail, maupun WA kepada Nomor HP kami</td></tr>';
    $html .= '<tr><td>5)</td><td>Peneliti harus memasukkan laporan tahunan (berupa ringkasan/ abstrak) kepada kami, atau laporan akhir (abstrak) jika penelitian tidak melebihi 1 (satu) tahun</td></tr>';
    $html .= '</table>';

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    // set font
    $pdf->SetFont('times', '', 8);

    $pdf->writeHTMLCell(0, '', '', 285, $data_ethical['no_dokumen'], 0, 0, 0, true, 'R', true);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set font
    $pdf->SetFont('helvetica', '', 12);

    // add a page
    $pdf->AddPage();

    $html = '<table border="0">';
    $html .= '<thead>';
    $html .= '<tr><th align="center"><strong><u>RINGKASAN KOMPILASI PROTOKOL</u></strong></th></tr>';
    $html .= '<tr><th align="center"><strong>NOMOR PROTOKOL : '.$data_ethical['no_protokol'].'</strong></th></tr>';
    $html .= '</thead>';
    $html .= '</table>';

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    // set font
    $pdf->SetFont('helvetica', '', 10);

    $data_telaah = $this->data_model->get_data_telaah_fullboard_by_idpep($id_pep);

    $html = '';
    if ($data_telaah)
    {
      for ($i=0; $i<count($data_telaah); $i++)
      {
        $no = $i+1;
        $catatan_protokol = stripslashes($data_telaah[$i]['catatan_protokol']);
        $catatan_7standar = stripslashes($data_telaah[$i]['catatan_7standar']);
        $html .= '<h2><u>Catatan Penelaah # '.$no.'</u></h2>';
        $html .= '<strong><u>Catatan Protokol</u></strong>';
        $html .= '<p class="justify">';
        $html .= $catatan_protokol;
        $html .= '</p>';
        $html .= '<strong><u>Catatan 7 Standar</u></strong>';
        $html .= '<p class="justify">';
        $html .= $catatan_7standar;
        $html .= '</p>';
        $html .= '<br/>';
      }
    }

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    //Close and output PDF document
    $pdf->Output('ethical-revision-catatan-telaah-fullboard.pdf', 'I');
  }

  public function cetak_ethical_revision_tbd($id_pep=0)
  {
    $this->load->library('Pdf');

    // create new PDF document
    $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('E-Protokol');
    $pdf->SetTitle('Perbaikan Etik');
    $pdf->SetSubject('Perbaikan Etik');

    // remove default header/footer
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, 0);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
        require_once(dirname(__FILE__).'/lang/eng.php');
        $pdf->setLanguageArray($l);
    }

    // ---------------------------------------------------------

    // set font
    $pdf->SetFont('times', '', 10);

    // add a page
    $pdf->AddPage();

    $data_kop = $this->data_model->get_data_kop_surat();

    if (isset($data_kop['file_name']) && file_exists('./uploads/'.$data_kop['file_name']))
      $pdf->writeHTMLCell(210, '', 0, 5, '<img src="./uploads/'.$data_kop['file_name'].'">', 0, 1, false, true, 'L', false);

    $html = '<table border="0">';
    $html .= '<thead>';
    $html .= '<tr><th align="center"><strong><u>PERBAIKAN ETIK</u></strong></th></tr>';
    $html .= '</thead>';
    $html .= '</table>';

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    // set font
    $pdf->SetFont('times', '', 10);

    $data_ketua = $this->data_model->get_data_ketua_kepk();
    $data_ethical = $this->data_model->get_data_ethical_revision_by_id_pep($id_pep);

    $html = '<table border="0">';
    $html .= '<thead>';
    $html .= '<tr><th align="center">
                <strong>Komite Etik Penelitian Kesehatan (KEPK) '.$data_ethical['nama_kepk'].'</strong>
              </th></tr>';
    $html .= '<tr><th align="center">
                <strong>Nomor Registrasi Pada KEPPKN : '.$data_ethical['kodefikasi'].'</strong></th></tr>';
    $html .= '<tr><th align="center">
                <strong>Terdaftar/Terakreditasi</strong></th></tr>';
    $html .= '</thead>';
    $html .= '</table>';
    $html .= '<hr>';
    $html .= '<table border="0" style="margin-top: 20px">';
    $html .= '<thead>';
    $html .= '<tr><th align="center"><strong>Surat Pernyataan Perbaikan Etik Penelitian Kesehatan</strong></th></tr>';
    $html .= '</thead>';
    $html .= '</table>';
    $html .= '<hr>';
    $html .= '<br/>';
    $html .= '<div style="margin-bottom: 40px"></div>';
    $html .= '<div align="center"><strong>Nomor : '.$data_ethical['no_surat'].'</strong></div>';
    $html .= '<div style="margin-bottom: 10px"></div>';

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    // set font
    $pdf->SetFont('helvetica', '', 10);

    $tgl = date('d', strtotime($data_ethical['tanggal_surat']));
    $bln = nama_bulan(date('m', strtotime($data_ethical['tanggal_surat'])));
    $thn = date('Y', strtotime($data_ethical['tanggal_surat']));
    $tgl_surat = $tgl.' '.$bln.' '.$thn;

    $tgl_awal = date('d', strtotime($data_ethical['awal_berlaku']));
    $bln_awal = nama_bulan(date('m', strtotime($data_ethical['awal_berlaku'])));
    $thn_awal = date('Y', strtotime($data_ethical['awal_berlaku']));
    $awal = $tgl_awal.' '.$bln_awal.' '.$thn_awal;

    $tgl_akhir = date('d', strtotime($data_ethical['akhir_berlaku']));
    $bln_akhir = nama_bulan(date('m', strtotime($data_ethical['akhir_berlaku'])));
    $thn_akhir = date('Y', strtotime($data_ethical['akhir_berlaku']));
    $akhir = $tgl_akhir.' '.$bln_akhir.' '.$thn_akhir;

    $html = '<p align="justify">Protokol penelitian yang diusulkan oleh: <strong>'.$data_ethical['nama_ketua'].'</strong> dengan judul: <strong>'.$data_ethical['judul'].'</strong> dinyatakan diperbaiki ';
    if ($data_ethical['klasifikasi'] < 4) {
      $html .= ' sesuai 7 (tujuh) Standar WHO 2011, yaitu 1) Nilai Sosial, 2) Nilai Ilmiah, 3) Pemerataan Beban dan Manfaat, 4) Risiko, 5) Bujukan/Eksploitasi, 6) Kerahasiaan dan Privacy, dan 7) Penjelasan Sebelum Persetujuan, yang merujuk pada Pedoman CIOMS 2016. Hal ini seperti yang ditunjukkan oleh terpenuhinya indikator masing-masing Standar, sebagaimana terlampir.</p>';
    } else {
      $html .= '(belum bisa ditelaah etik) sesuai 7 (tujuh) Standar WHO 2011, yaitu 1) Nilai Sosial, 2) Nilai Ilmiah, 3) Pemerataan Beban dan Manfaat, 4) Risiko, 5) Bujukan/Eksploitasi, 6) Kerahasiaan dan Privacy, dan 7) Penjelasan Sebelum Persetujuan, yang merujuk pada Pedoman CIOMS 2016.</p>';
    }
    $html .= '<p align="justify">Pernyataan Perbaikan Etik ini berlaku selama kurun waktu tanggal '.$awal.' sampai dengan tanggal '.$akhir.'.</p>';

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    $data_ttd = $this->data_model->get_data_ttd_ketua();

    if (isset($data_ttd['file_name']) && $data_ttd['file_name'] != '')
      $ttd = '<img src="./uploads/'.$data_ttd['file_name'].'" height="80">';
    else
      $ttd = '<br/><br/><br/><br/><br/>';

    $html = '<table border="0">';
    $html .= '<tr><td width="30%"></td><td width="40%"></td><td width="30%" align="center">Ketua KEPK,</td></tr>';
    $html .= '<tr><td width="30%"></td><td width="40%"></td><td width="30%" align="center">'.$ttd.'</td></tr>';
    $html .= '<tr><td width="30%"></td><td width="40%"></td><td width="30%" align="center">'.$data_ketua['nama'].'</td></tr>';
    $html .= '</table>';

    $pdf->writeHTMLCell(0, '', '', 140, $html, 0, 0, 0, true, 'L', true);

    // set style for barcode
    $style = array(
        'border' => 2,
        'vpadding' => 'auto',
        'hpadding' => 'auto',
        'fgcolor' => array(0,0,0),
        'bgcolor' => false, //array(255,255,255)
        'module_width' => 1, // width of a single module in points
        'module_height' => 1 // height of a single module in points
    );

    $pdf->write2DBarcode(date('Y-m-d H:i:s').' | '.$data_ethical['no_protokol'].' | '.$data_ketua['nomor'].' | '.$data_ketua['nik'].' | '.$data_ethical['no_dokumen'], 'QRCODE,L', 20, 145, 20, 20, $style, 'N');
    $id_pengajuan = $data_ethical['id_pengajuan'];
    $data_anggota = $this->data_model->get_anggota_penelitian_by_id_pengajuan($id_pengajuan);

    $html = '<br/><br/><br/><br/>';

    if (!empty($data_anggota))
    {
      $html .= '<p>Anggota Peneliti : ';
      for ($x=0; $x<count($data_anggota); $x++)
      {
        $html .= $data_anggota[$x]['nama'];

        if ($x == count($data_anggota)-2)
          $html .= ' dan ';
        else if ($x < count($data_anggota)-1)
          $html .= ', ';
      }
      $html .= '</p>';
    }

    $html .= '<table border="0">';
    $html .= '<tr><td colspan="2">Catatan untuk Peneliti dan Para Pihak : </td></tr>';
    $html .= '<tr><td width="4%">1)</td><td width="96%">Setiap pelaksanaan yang menyimpang dari protokol etik penelitian ini, harus sudah dilaporkan kepada kami untuk memperoleh pertimbangan dan persetujuan; </td></tr>';
    $html .= '<tr><td>2)</td><td>Setiap kejadian yg tidak diharapkan, yang timbul dari pelaksanaan penelitian ini harus segera dilaporkan kepada kami</td></tr>';
    $html .= '<tr><td>3)</td><td>Peneliti bersedia untuk sewaktu-waktu memperoleh pemantauan pelaksanaan penelitian</td></tr>';
    $html .= '<tr><td>4)</td><td>Para pihak terkait dapat menyampaikan aduan terkait dengan pelaksanaan penelitian ini kepada kami melalui e-mail, maupun WA kepada Nomor HP kami</td></tr>';
    $html .= '<tr><td>5)</td><td>Peneliti harus memasukkan laporan tahunan (berupa ringkasan/ abstrak) kepada kami, atau laporan akhir (abstrak) jika penelitian tidak melebihi 1 (satu) tahun</td></tr>';
    $html .= '</table>';

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    // set font
    $pdf->SetFont('times', '', 8);

    $pdf->writeHTMLCell(0, '', '', 285, $data_ethical['no_dokumen'], 0, 0, 0, true, 'R', true);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set font
    $pdf->SetFont('helvetica', '', 12);

    // add a page
    $pdf->AddPage();

    $html = '<table border="0">';
    $html .= '<thead>';
    $html .= '<tr><th align="center"><strong><u>ALASAN PROTOKOL TBD</u></strong></th></tr>';
    $html .= '<tr><th align="center"><strong>NOMOR PROTOKOL : '.$data_ethical['no_protokol'].'</strong></th></tr>';
    $html .= '</thead>';
    $html .= '</table>';

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    // set font
    $pdf->SetFont('helvetica', '', 10);

    $data_alasan_tbd = $this->data_model->get_data_alasan_tbd_by_idpep($id_pep);

    $html = '';
    if ($data_alasan_tbd)
      $html .= $data_alasan_tbd['alasan_tbd'];

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    //Close and output PDF document
    $pdf->Output('ethical-revision-tbd.pdf', 'I');
  }

}
?>