<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pemberitahuan_fullboard extends Userpage_Controller {

  public function __construct()
  {
    parent::__construct();

    $this->load->model('Pemberitahuan_fullboard_model', 'data_model');
  }
 
  public function index()
  {
    $data['title'] = APPNAME.' - Pemberitahuan Fullboard';
    $data['page_header'] = 'Daftar Pemberitahuan Fullboard';
    $data['breadcrumb'] = 'Pemberitahuan Fullboard';

    if ($this->session->userdata('id_group_'.APPAUTH) == 5) // Kesekretariatan KEPK
    {
      $data['css_content'] = 'pemberitahuan_fullboard_view1_css';
      $data['main_content'] = 'pemberitahuan_fullboard_view1';
      $data['js_content'] = 'pemberitahuan_fullboard_view1_js';
    }
    else if ($this->session->userdata('id_group_'.APPAUTH) == 3) // Peneliti
    {
      $data['css_content'] = 'pemberitahuan_fullboard_view2_css';
      $data['main_content'] = 'pemberitahuan_fullboard_view2';
      $data['js_content'] = 'pemberitahuan_fullboard_view2_js';
    }
 
    $this->load->view('layout/template', $data);
  }

  public function form($id=0)
  {
    if ($this->session->userdata('id_group_'.APPAUTH) == 3)
      $this->index();

    $data['title'] = APPNAME.' - Pemberitahuan Fullboard';
    $data['page_header'] = 'Form Pemberitahuan Fullboard';
    $data['breadcrumb'] = 'Pemberitahuan Fullboard';
    $data['css_content'] = 'pemberitahuan_fullboard_form_css';
    $data['main_content'] = 'pemberitahuan_fullboard_form';
    $data['js_content'] = 'pemberitahuan_fullboard_form_js';
    $data['protokol'] = $this->data_model->get_data_protokol();

    if ($id > 0) {
      $data['data'] = $this->data_model->get_data_by_id($id);
      $data['is_kirim'] = $this->data_model->check_is_kirim($id);
    }

    $this->load->view('layout/template', $data);
  }

  public function validation_form()
  { 
    $this->form_validation->set_rules('id_pep', 'Nomor Protokol', 'trim|required|is_natural_no_zero');

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
          'id' => $result[$i]['id_bfbd'],
          'id_pep' => $result[$i]['id_pep'],
          'no_protokol' => $result[$i]['no_protokol'],
          'judul' => $result[$i]['judul'],
          'nama_ketua' => $result[$i]['nama_ketua'],
          'telp_peneliti' => $result[$i]['telp_peneliti'],
          'email_peneliti' => $result[$i]['email_peneliti'],
          'tgl_fb' => date('d/m/Y', strtotime($result[$i]['tgl_fullboard'])),
          'jam_fb' => date('H:i', strtotime($result[$i]['jam_fullboard'])),
          'tempat_fb' => $result[$i]['tempat_fullboard'],
          'tgl_pemberitahuan' => date('d/m/Y', strtotime($result[$i]['tanggal_pemberitahuan'])),
        );
      }
    }
    
    echo json_encode($response);
  }

  function get_pengajuan_by_id_pep($id_pep=0)
  {
    $result = $this->data_model->get_data_pengajuan_by_id_pep($id_pep);

    $response = (object) NULL;
    $response->data = array();
    if ($result){
      $response->data['nama_ketua'] = isset($result['nama_ketua']) ? $result['nama_ketua'] : '-';
      $response->data['telp_peneliti'] = isset($result['telp_peneliti']) ? $result['telp_peneliti'] : '-';
      $response->data['email_peneliti'] = isset($result['email_peneliti']) ? $result['email_peneliti'] : '-';
      $response->data['nama_institusi'] = isset($result['nama_institusi']) ? $result['nama_institusi'] : '-';
      $response->data['alamat_institusi'] = isset($result['alamat_institusi']) ? $result['alamat_institusi'] : '-';
      $response->data['telp_institusi'] = isset($result['telp_institusi']) ? $result['telp_institusi'] : '-';
      $response->data['email_institusi'] = isset($result['email_institusi']) ? $result['email_institusi'] : '-';
    }

    echo json_encode($response->data);
  }

  function get_anggota_penelitian_by_id_pep($id_pep=0)
  {
    $result = $this->data_model->get_data_anggota_penelitian_by_id_pep($id_pep);

    $response = (object) NULL;
    $response->data = array();
    if ($result){
      for($i=0; $i<count($result); $i++){
        $response->data[] = array(
          'nama' => $result[$i]['nama']
        );
      }
    }

    echo json_encode($response->data);
  }

  function get_penelaah_fullboard_by_id_pep($id_pep=0)
  {
    $result = $this->data_model->get_data_penelaah_fullboard_by_id_pep($id_pep);

    $response = (object) NULL;
    $response->data = array();
    if ($result){
      for($i=0; $i<count($result); $i++){
        $response->data[] = array(
          'nama' => $result[$i]['nama']
        );
      }
    }

    echo json_encode($response->data);
  }

  function get_lay_person_fullboard_by_id_pep($id_pep=0)
  {
    $result = $this->data_model->get_data_lay_person_fullboard_by_id_pep($id_pep);

    $response = (object) NULL;
    $response->data = array();
    if ($result){
      for($i=0; $i<count($result); $i++){
        $response->data[] = array(
          'nama' => $result[$i]['nama']
        );
      }
    }

    echo json_encode($response->data);
  }

  public function cetak_surat($id=0, $id_pep=0)
  {
    $this->load->library('Pdf');

    // create new PDF document
    $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('E-Protokol');
    $pdf->SetTitle('Pemberitahuan Full Board');
    $pdf->SetSubject('Pemberitahuan Full Board');

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
    $pdf->SetFont('times', '', 14);

    // add a page
    $pdf->AddPage();

    $data_pf = $this->data_model->get_data_by_id($id);
    $data_pg = $this->data_model->get_data_pengajuan_by_id_pep($id_pep);
    $data_kop = $this->data_model->get_data_kop_surat_by_id_pep($id_pep);
    $data_ketua = $this->data_model->get_data_ketua_kepk_by_id_pep($id_pep);
    $data_pe = $this->data_model->get_data_penelaah_fullboard_by_id_pep($id_pep);
    $data_lp = $this->data_model->get_data_lay_person_fullboard_by_id_pep($id_pep);

    if (isset($data_kop['file_name']) && file_exists('./uploads/'.$data_kop['file_name']))
      $pdf->writeHTMLCell(210, '', 0, 5, '<img src="./uploads/'.$data_kop['file_name'].'">', 0, 1, false, true, 'L', false);

    $html = '<table border="0">';
    $html .= '<thead>';
    $html .= '<tr><th align="center"><strong>Pemberitahuan Fullboard</strong></th></tr>';
    $html .= '</thead>';
    $html .= '</table>';

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    // set font
    $pdf->SetFont('times', '', 10);

    $tgl_fb = date('d-m-Y', strtotime($data_pf['tgl_fullboard']));
    $jam_fb = date('H:i', strtotime($data_pf['jam_fullboard']));
    $html = '<p align="justify">Bersama ini memberitahukan kepada Bapak/Ibu/Saudara:</p>';
    $html .= '<table border="0">';
    $html .= '<tr><td width="15%">Nama</td><td>: '.$data_pg['nama_ketua'].'</td></tr>';
    $html .= '<tr><td width="15%">Nomor Telepon</td><td>: '.$data_pg['telp_peneliti'].'</td></tr>';
    $html .= '<tr><td width="15%">Email</td><td>: '.$data_pg['email_peneliti'].'</td></tr>';
    $html .= '<tr><td width="15%">Institusi</td><td>: '.$data_pg['nama_institusi'].'</td></tr>';
    $html .= '</table>';
    $html .= '<p align="justify">Sebagai Ketua Pelaksana/Peneliti Utama</p>';

    if ($this->session->userdata('id_group_'.APPAUTH) == 5)
    {
      $html .= '<p align="justify">Dan juga kepada Bapak/Ibu/Saudara:</p>';
      $html .= '<table border="0">';
      for ($i=0; $i<count($data_pe); $i++)
      {
        $no = $i+1;
        $html .= '<tr><td>'.$no.'. '.$data_pe[$i]['nama'].'</td></tr>';
      }
      $html .= '<tr><td>Sebagai Penelaah Fullboard.</td></tr>';
      $html .= '</table>';
      $html .= '<br/><br/>';

      if (!empty($data_lp))
      {
        $html .= '<table border="0">';
        for ($i=0; $i<count($data_lp); $i++)
        {
          $no = $i+1;
          $html .= '<tr><td>'.$no.'. '.$data_lp[$i]['nama'].'</td></tr>';
        }
        $html .= '<tr><td>Sebagai Lay Person.</td></tr>';
        $html .= '</table>';
      }
    }

    $html .= '<p align="justify">Untuk melakukan pertemuan fullboard dari Protokol dengan Nomor '.$data_pf['no_protokol'].' dan Judul '.$data_pf['judul'].' yang akan diselenggarakan pada:</p>';
    $html .= '<table border="0">';
    $html .= '<tr><td width="15%">Tanggal</td><td>: '.$tgl_fb.'</td></tr>';
    $html .= '<tr><td width="15%">Jam</td><td>: '.$jam_fb.'</td></tr>';
    $html .= '<tr><td width="15%">Tempat</td><td>: '.$data_pf['tempat_fullboard'].'</td></tr>';
    $html .= '</table>';
    $html .= '<p align="justify">Demikian pemberitahuan ini, semoga bisa menjadi periksa.</p>';

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
    $html .= '<tr><td width="30%"></td><td width="40%"></td><td width="30%" align="center">'.$data_ketua['nama_ketua'].'</td></tr>';
    $html .= '</table>';

    if ($this->session->userdata('id_group_'.APPAUTH) == 3)
      $pdf->writeHTMLCell(0, '', '', 160, $html, 0, 0, 0, true, 'L', true);
    else if ($this->session->userdata('id_group_'.APPAUTH) == 5)
      $pdf->writeHTMLCell(0, '', '', 210, $html, 0, 0, 0, true, 'L', true);

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

    if ($this->session->userdata('id_group_'.APPAUTH) == 3)
      $pdf->write2DBarcode(date('Y-m-d H:i:s').' | '.$data_pf['no_protokol'].' | '.$data_ketua['nomor_ketua'].' | '.$data_ketua['nik_ketua'], 'QRCODE,L', 20, 165, 20, 20, $style, 'N');
    else if ($this->session->userdata('id_group_'.APPAUTH) == 5)
      $pdf->write2DBarcode(date('Y-m-d H:i:s').' | '.$data_pf['no_protokol'].' | '.$data_ketua['nomor_ketua'].' | '.$data_ketua['nik_ketua'], 'QRCODE,L', 20, 215, 20, 20, $style, 'N');

    //Close and output PDF document
    $pdf->Output('pemberitahuan-fullboard.pdf', 'I');
  }

}
?>