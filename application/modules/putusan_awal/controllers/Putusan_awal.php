<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Putusan_awal extends Userpage_Controller { 
  public function __construct() 
  {
    parent::__construct();
    $this->load->model('Putusan_awal_model', 'data_model');
  }

  public function index() 
  {
    $data['title'] = APPNAME.' - Putusan Telaah Awal Protokol';
    $data['page_header'] = 'Daftar Putusan Telaah Awal Protokol';
    $data['breadcrumb'] = 'Putusan Telaah Awal Protokol';
    $data['css_content'] = 'putusan_awal_view_css';
    $data['main_content'] = 'putusan_awal_view';
    $data['js_content'] = 'putusan_awal_view_js';

    $this->load->view('layout/template', $data);
 }

 public function form($id=0) 
 {
    $data['title'] = APPNAME.' - Putusan Telaah Awal Protokol';
    $data['page_header'] = 'Form Putusan Telaah Awal Protokol';
    $data['breadcrumb'] = 'Putusan Telaah Awal Protokol';
    $data['css_content'] = 'putusan_awal_form_css';
    $data['main_content'] = 'putusan_awal_form';
    $data['js_content'] = 'putusan_awal_form_js';
    $data['protokol'] = $this->data_model->get_data_protokol();
    $data['data_penelaah'] = $this->data_model->get_data_penelaah();
    $data['data_lay_person'] = $this->data_model->get_data_lay_person();
    $data['data_konsultan'] = $this->data_model->get_data_konsultan();
  
    if ($id > 0) 
    { 
      $data['data'] = $this->data_model->get_data_by_id($id);
      $data['penelaah_etik'] = $this->data_model->get_data_penelaah_by_id($id);
      $data['lay_person'] = $this->data_model->get_data_lay_person_by_id($id);
      $data['konsultan'] = $this->data_model->get_data_konsultan_by_id($id);
    } 
    
    $this->load->view('layout/template', $data);
  }

   public function validation_form() 
  {
    $this->form_validation->set_rules('id_pep', 'Nomor Protokol', 'trim|required|is_natural_no_zero');
    $this->form_validation->set_rules('klasifikasi', 'Klasifikasi Protokol', 'trim|required|is_natural_no_zero');
    $this->form_validation->set_rules('telaah_awal[]', 'Penelaah', 'callback_check_jumlah_penelaah_awal');
    
    if ($this->input->post('klasifikasi') > 1){ 
      $this->form_validation->set_rules('penelaah_etik', 'Penelaah Etik', 'callback_check_penelaah');
    } 

    if ($this->input->post('klasifikasi') == 2 || $this->input->post('klasifikasi') == 3){
      $this->form_validation->set_rules('pelapor', 'Pelapor', 'trim|required|is_natural_no_zero');
    }

    $this->form_validation->set_message('required', '{field} tidak boleh kosong.');
    $this->form_validation->set_message('is_natural_no_zero', 'Harus memilih {field}.');
  }

  function check_jumlah_penelaah_awal($penelaah)
  {
    if (empty($penelaah))
    {
      $this->form_validation->set_message('check_jumlah_penelaah_awal', 'Harus ada 2 penelaah awal yang telah menelaah');
      return FALSE;
    }
    else
    {
      $jml = count(json_decode($penelaah));
      if ($jml == 2)
        return TRUE;
      else
      {
        $this->form_validation->set_message('check_jumlah_penelaah_awal', 'Harus ada 2 penelaah awal yang telah menelaah');
        return FALSE;
      }
    }
  }

  public function check_penelaah($str) 
  {
    $pe = $this->input->post('penelaah_etik');
    $lp = $this->input->post('lay_person');
    $klasifikasi = $this->input->post('klasifikasi');
    $jml_pe = !empty($pe) ? count($pe) : 0;
    $jml_lp = !empty($lp) ? count($lp) : 0;
    
    switch ($klasifikasi) {
      case 3: $klas = 'Full Board'; break;
      case 2: $klas = 'Expedited';break;
      default: $klas = ''; break;
    } 

    if ($klasifikasi == 2 && $jml_pe < 2) 
    { 
      $this->form_validation->set_message('check_penelaah', 'Penelaah Etik '.$klas.' minimal berjumlah 2 penelaah');
      return FALSE;
    } 
    else if ($klasifikasi == 3 && $jml_pe + $jml_lp < 5) 
    { 
      $this->form_validation->set_message('check_penelaah', 'Penelaah Etik '.$klas.' minimal berjumlah 5 penelaah & lay person');
      return FALSE;
    } 
    else 
    { 
      return TRUE;
    }
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
      for($i=0; $i<count($result); $i++)
      {
        $response->rows[] = array( 
          'id' => $result[$i]['id_pa'], 
          'no_protokol' => $result[$i]['no_protokol'], 
          'judul' => $result[$i]['judul'], 
          'tgl_pengajuan' => date('d/m/Y', strtotime($result[$i]['tanggal_pengajuan'])), 
          'kepk' => $result[$i]['nama_kepk'], 'mulai' => date('d/m/Y', strtotime($result[$i]['waktu_mulai'])), 
          'selesai' => date('d/m/Y', strtotime($result[$i]['waktu_selesai'])), 
          'tgl_pa' => date('d/m/Y', strtotime($result[$i]['tanggal_pa'])), 
          'klasifikasi' => $result[$i]['klasifikasi'] 
        );
      } 
    } 

    echo json_encode($response);
  } 

  function get_standar_kelaikan($id, $id_pep) 
  { 
    $result = $this->data_model->get_data_standar_kelaikan($id, $id_pep);
    
    $response = (object) NULL;
    $response->data = array();
    
    if ($result){
      for($i=0; $i<count($result); $i++)
      { 
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
          'pil_ketua' => $result[$i]['pilihan_ketua'],
          'just_header' => $result[$i]['just_header']
        );
      } 
    } 

    echo json_encode($response->data);
  } 

   function get_persen_klasifikasi($id_pep=0) 
  { 
    $result = $this->data_model->get_data_jumlah_klasifikasi_penelaah_by_id($id_pep);
    
    $response = (object) NULL;
    if ($result) 
    { 
      $exempted = $result['jumlah_exempted'];
      $expedited = $result['jumlah_expedited'];
      $fullboad = $result['jumlah_fullboard'];
      $total = $exempted + $expedited + $fullboad;
      $persen1 = ($exempted/$total) * 100;
      $persen2 = ($expedited/$total) * 100;
      $persen3 = ($fullboad/$total) * 100;
      $response->isSuccess = TRUE;
      $response->persen1 = $persen1;
      $response->persen2 = $persen2;
      $response->persen3 = $persen3;
      $response->total = $total;
    } 
    else 
      $response->isSuccess = FALSE;

    echo json_encode($response);
  } 

  function get_resume($id_pep=0) 
  { 
    $result = $this->data_model->get_data_resume_by_id($id_pep);

    $response = (object) NULL;
    $response->data = array();
    if ($result) { 
      for ($i=0; $i<count($result); $i++) 
      { 
        $response->data[] = array( 
          'id_atk' => $result[$i]['id_atk_sekretaris'],
          'resume' => stripslashes($result[$i]['resume']),
          'nomor' => $result[$i]['nomor'], 
          'nama' => $result[$i]['nama'] 
        );
      } 
    } 

    echo json_encode($response->data);
  } 

  function get_telaah_awal($id_pep=0) 
  { 
    $result = $this->data_model->get_data_telaah_awal_by_id($id_pep);

    $response = (object) NULL;
    $response->data = array();
    if ($result) { 
      for ($i=0; $i<count($result); $i++) 
      { 
        $response->data[] = array( 
          'id_ta' => $result[$i]['id_ta'], 
          'id_atk' => $result[$i]['id_atk_penelaah'], 
          'klasifikasi' => $result[$i]['klasifikasi_usulan'],
          'catatan_protokol' => stripslashes($result[$i]['catatan_protokol']),
          'catatan_7standar' => stripslashes($result[$i]['catatan_7standar']),
          'nomor' => $result[$i]['nomor'], 
          'nama' => $result[$i]['nama'] 
        );
      } 
    } 

    echo json_encode($response->data);
  } 

  function get_protokol() 
  { 
    $result = $this->data_model->get_data_protokol();
    
    $response = (object) NULL;
    $response->data = array();
    if ($result){ 
      for($i=0; $i<count($result); $i++)
      { 
        $date_diff = time() - strtotime($result[$i]['inserted']);
        $response->data[] = array( 
          'id_pep' => $result[$i]['id_pep'], 
          'no' => $result[$i]['no_protokol'], 
          'judul' => $result[$i]['judul'], 
          'waktu' => date('d/m/Y H:i:s', strtotime($result[$i]['inserted'])), 
          'hari_ke' => round($date_diff / (60*60*24)) 
        );
      } 
    } 

    echo json_encode($response->data);
  }

  public function cetak_telaah_awal($id_ta=0)
  {
    $this->load->library('Pdf');

    // create new PDF document
    $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('E-Protokol');
    $pdf->SetTitle('Telaah Awal');
    $pdf->SetSubject('Telaah Awal');

    // remove default header/footer
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP-10, PDF_MARGIN_RIGHT);
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

    $data_telaah = $this->data_model->get_data_telaah_awal_by_id_ta($id_ta);
    if (isset($data_telaah['klasifikasi_usulan']))
    {
      switch($data_telaah['klasifikasi_usulan'])
      {
        case 1: $klasifikasi_usulan = 'Exempted'; break;
        case 2: $klasifikasi_usulan = 'Expedited'; break;
        case 3: $klasifikasi_usulan = 'Full Board'; break;
        default: $klasifikasi_usulan = '';
      }
    }
    $penelaah = isset($data_telaah['nama_penelaah']) ? $data_telaah['nama_penelaah'] : '';

    $pdf->writeHTML('<h1>Telaah Awal</h1><br/>', true, false, true, false, 'C');

    $html = '<table border="0">';
    $html .= '<tr>
                <td width="18%">No. Protokol</td>
                <td width="2%">:</td>
                <td width="80%">'.$data_telaah['no_protokol'].'</td>
              </tr>';
    $html .= '<tr>
                <td width="18%">Judul</td>
                <td width="2%">:</td>
                <td width="80%">'.$data_telaah['judul'].'</td>
              </tr>';
    $html .= '<tr>
                <td width="18%">Penelaah Awal</td>
                <td width="2%">:</td>
                <td width="80%">'.$penelaah.'</td>
              </tr>';
    $html .= '<tr>
                <td width="18%">Klasifikasi Usulan</td>
                <td width="2%">:</td>
                <td width="80%">'.$klasifikasi_usulan.'</td>
              </tr>';
    $html .= '</table><br/>';

    $pdf->writeHTML($html, true, false, true, false, '');

    $pdf->writeHTML('<h2>Catatan Protokol</h2><hr/>', true, false, true, false, '');
    $pdf->writeHTML(isset($data_telaah['catatan_protokol']) ? stripslashes($data_telaah['catatan_protokol']) : '', true, false, true, false, '');
    $pdf->writeHTML('<h2>Catatan 7 Standar</h2><hr/>', true, false, true, false, '');
    $pdf->writeHTML(isset($data_telaah['catatan_7standar']) ? $data_telaah['catatan_7standar'] : '', true, false, true, false, '');

    //Close and output PDF document
    $pdf->Output('telaah-awal.pdf', 'I');
  }

} 
?>