<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Surat_perbaikan extends Userpage_Controller {

  public function __construct()
  {
    parent::__construct();

    $this->load->model('Surat_perbaikan_model', 'data_model');
  }
 
  public function index()
  {
    $data['title'] = APPNAME.' - Surat Perbaikan Etik';
    $data['page_header'] = 'Daftar Surat Perbaikan Etik';
    $data['breadcrumb'] = 'Surat Perbaikan Etik';
    $data['css_content'] = 'surat_perbaikan_view_css';
    $data['main_content'] = 'surat_perbaikan_view';
    $data['js_content'] = 'surat_perbaikan_view_js';
 
    $this->load->view('layout/template', $data);
  }

  public function form($id=0)
  {
    $data['title'] = APPNAME.' - Surat Perbaikan Etik';
    $data['page_header'] = 'Form Surat Perbaikan Etik';
    $data['breadcrumb'] = 'Surat Perbaikan Etik';
    $data['css_content'] = 'surat_perbaikan_form_css';
    $data['main_content'] = 'surat_perbaikan_form';
    $data['js_content'] = 'surat_perbaikan_form_js';
    $data['protokol'] = $this->data_model->get_data_protokol();

    if ($id > 0) {
      $data['is_kirim'] = $this->data_model->check_is_kirim($id);
      $data['data'] = $this->data_model->get_data_by_id($id);
    }

    $this->load->view('layout/template', $data);
  }

  public function validation_form()
  { 
    $this->form_validation->set_rules('id_pep', 'Nomor Protokol', 'trim|required|is_natural_no_zero');
    $this->form_validation->set_rules('no_surat', 'Nomor Surat', 'trim|required');
    $this->form_validation->set_rules('tgl_surat', 'Tanggal Surat', 'trim|required');
    $this->form_validation->set_rules('awal_berlaku', 'Masa Berlaku', 'trim|required');
    $this->form_validation->set_rules('akhir_berlaku', 'Masa Berlaku', 'trim|required');

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
        $response->no_dokumen = $this->data_model->no_dokumen;
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

  function kirim()
  {
    $response = (object)null;

    $success = $this->data_model->kirim_data();
    if ($success)
    {
      $response->isSuccess = TRUE;
      $response->message = 'Data berhasil dikirim';
    }
    else
    {
      $response->isSuccess = FALSE;
      $response->message = 'Data gagal dikirim';       
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
          'id' => $result[$i]['id_ethical_revision'],
          'no_surat' => $result[$i]['no_surat'],
          'tgl_surat' => date('d/m/Y', strtotime($result[$i]['tanggal_surat'])),
          'no_protokol' => $result[$i]['no_protokol'],
          'judul' => $result[$i]['judul'],
        );
      }
    }
    
    echo json_encode($response);
  }

  function get_telaah_expedited_by_idpep($id_pep)
  {
    $result = $this->data_model->get_data_telaah_expedited_by_idpep($id_pep);

    $response = (object) NULL;
    $response->data = array();
    if ($result){
      for($i=0; $i<count($result); $i++){
        $response->data[] = array(
          'id' => $result[$i]['id_texp'],
          'catatan_protokol' => stripslashes($result[$i]['catatan_protokol']),
          'catatan_7standar' => stripslashes($result[$i]['catatan_7standar'])
        );
      }
    }
    
    echo json_encode($response->data);
  }

  function get_telaah_fullboard_by_idpep($id_pep)
  {
    $result = $this->data_model->get_data_telaah_fullboard_by_idpep($id_pep);

    $response = (object) NULL;
    $response->data = array();
    if ($result){
      for($i=0; $i<count($result); $i++){
        $response->data[] = array(
          'id' => $result[$i]['id_tfbd'],
          'catatan_protokol' => stripslashes($result[$i]['catatan_protokol']),
          'catatan_7standar' => stripslashes($result[$i]['catatan_7standar'])
        );
      }
    }
    
    echo json_encode($response->data);
  }

  function get_alasan_tbd_by_idpep($id_pep=0)
  {
    $result = $this->data_model->get_data_alasan_tbd_by_idpep($id_pep);

    $response = (object) NULL;
    if ($result)
      $response->alasan_tbd = $result['alasan_tbd'];
    else
      $response->alasan_tbd = '';

    echo json_encode($response);    
  }

  public function cetak_surat($id=0)
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
    $data_ethical = $this->data_model->get_data_ethical_revision_by_id($id);

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

    //Close and output PDF document
    $pdf->Output('ethical-revision.pdf', 'I');
  }

  public function cetak_catatan_expedited($id=0, $id_pep=0)
  {
    $this->load->library('Pdf');

    // create new PDF document
    $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('E-Protokol');
    $pdf->SetTitle('Catatan Penelaah');
    $pdf->SetSubject('Catatan Penelaah');

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

    $data_protokol = $this->data_model->get_data_no_protokol_by_id_pep($id_pep);
    $data_ethical = $this->data_model->get_data_ethical_revision_by_id($id);

    $html = '<table border="0">';
    $html .= '<thead>';
    $html .= '<tr><th align="center"><strong><u>RINGKASAN KOMPILASI PROTOKOL</u></strong></th></tr>';
    $html .= '<tr><th align="center"><strong>NOMOR PROTOKOL : '.$data_protokol['no_protokol'].'</strong></th></tr>';
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
    $pdf->Output('catatan-telaah-ethical-revision.pdf', 'I');
  }

  public function cetak_catatan_fullboard($id=0, $id_pep=0)
  {
    $this->load->library('Pdf');

    // create new PDF document
    $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('E-Protokol');
    $pdf->SetTitle('Catatan Penelaah');
    $pdf->SetSubject('Catatan Penelaah');

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

    $data_protokol = $this->data_model->get_data_no_protokol_by_id_pep($id_pep);
    $data_ethical = $this->data_model->get_data_ethical_revision_by_id($id);

    $html = '<table border="0">';
    $html .= '<thead>';
    $html .= '<tr><th align="center"><strong><u>RINGKASAN KOMPILASI PROTOKOL</u></strong></th></tr>';
    $html .= '<tr><th align="center"><strong>NOMOR PROTOKOL : '.$data_protokol['no_protokol'].'</strong></th></tr>';
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
    $pdf->Output('catatan-telaah-ethical-revision.pdf', 'I');
  }

  public function cetak_alasan_tbd($id=0, $id_pep=0)
  {
    $this->load->library('Pdf');

    // create new PDF document
    $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('E-Protokol');
    $pdf->SetTitle('Alasan TBD');
    $pdf->SetSubject('Alasan TBD');

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

    $data_protokol = $this->data_model->get_data_no_protokol_by_id_pep($id_pep);
    $data_ethical = $this->data_model->get_data_ethical_revision_by_id($id);

    $html = '<table border="0">';
    $html .= '<thead>';
    $html .= '<tr><th align="center"><strong><u>ALASAN PROTOKOL TBD</u></strong></th></tr>';
    $html .= '<tr><th align="center"><strong>NOMOR PROTOKOL : '.$data_protokol['no_protokol'].'</strong></th></tr>';
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
    $pdf->Output('alasan-tbd-ethical-revision.pdf', 'I');
  }

}
?>