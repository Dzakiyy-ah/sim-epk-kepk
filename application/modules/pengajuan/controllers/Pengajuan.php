<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengajuan extends CI_Controller {

  public function __construct()
  {
    parent::__construct();

    $this->load->model('Pengajuan_model', 'data_model');
  }
 
  public function index()
  {
    $data['title'] = APPNAME.' - Pengajuan';
    $data['page_header'] = 'Pengajuan Kaji Etik Protokol Penelitian';
    $data['breadcrumb'] = 'Pengajuan';
    $data['css_content'] = 'pengajuan_view_css';
    $data['main_content'] = 'pengajuan_view';
    $data['js_content'] = 'pengajuan_view_js';
 
    $this->load->view('layout/template', $data);
  }

  public function form($id=0)
  {
    $data['title'] = APPNAME.' - Pengajuan';
    $data['page_header'] = 'Form Pengajuan Kaji Etik Protokol Penelitian';
    $data['breadcrumb'] = 'Form Pengajuan';
    $data['css_content'] = 'pengajuan_form_css';
    $data['main_content'] = 'pengajuan_form';
    $data['js_content'] = 'pengajuan_form_js';
    $data['kepk'] = $this->data_model->get_data_kepk();

    if ($id > 0)
    {
      $data['data'] = $this->data_model->get_data_by_id($id);
      $data['sp'] = $this->data_model->get_data_sp_by_id($id);
      $data['bb'] = $this->data_model->get_data_bb_by_id($id);
    }

    $this->load->view('layout/template', $data);
  }

  public function validation_form()
  {
    $this->form_validation->set_rules('id_kepk', 'KEPK', 'trim|required');
    $this->form_validation->set_rules('jns_penelitian', 'Jenis Penelitian', 'trim|required');
    $this->form_validation->set_rules('asal_pengusul', 'Asal Pengusul', 'trim|required');
    $this->form_validation->set_rules('jns_lembaga', 'Jenis Lembaga Asal Pengusul', 'trim|required');
    $this->form_validation->set_rules('status_pengusul', 'Status Pengusul', 'trim|required');
    $this->form_validation->set_rules('strata_pend', 'Strata Pendidikan', 'trim|required');
    $this->form_validation->set_rules('judul', 'Judul Protokol', 'trim|required|max_length[500]|callback_check_judul_exist');
    $this->form_validation->set_rules('title', 'Title of Protokol', 'trim|required|max_length[500]');
    $this->form_validation->set_rules('nm_ketua', 'Ketua Pelaksana / Peneliti Utama', 'trim|required|max_length[200]');
    $this->form_validation->set_rules('telp_peneliti', 'Nomor Telepon Peneliti', 'trim|required|max_length[20]');
    $this->form_validation->set_rules('email_peneliti', 'Email Peneliti', 'trim|required|valid_email|max_length[100]');
    $this->form_validation->set_rules('nm_institusi', 'Nama Institusi', 'trim|required|max_length[200]');
    $this->form_validation->set_rules('alm_inst', 'Alamat Institusi', 'trim|required');
    $this->form_validation->set_rules('telp_inst', 'Nomor Telepon Institusi / Fax', 'trim|required|max_length[20]');
    $this->form_validation->set_rules('email_inst', 'Email Institusi', 'trim|required|valid_email|max_length[100]');
    $this->form_validation->set_rules('sumber_dana', 'Sumber Dana', 'trim|required|max_length[100]');
    $this->form_validation->set_rules('total_dana', 'Total Dana', 'trim|required');
    $this->form_validation->set_rules('penelitian', 'Penelitian', 'trim|required');
    $this->form_validation->set_rules('tempat_penelitian', 'Tempat Penelitian', 'trim|required|max_length[200]');
    $this->form_validation->set_rules('waktu_mulai', 'Waktu Mulai Penelitian', 'trim|required|callback_check_valid_waktu_mulai');
    $this->form_validation->set_rules('waktu_selesai', 'Waktu Selesai Penelitian', 'trim|required|callback_check_valid_waktu_selesai');
    $this->form_validation->set_rules('tempat_multi_senter', 'Tempat Multi Senter', 'callback_check_tempat_multi_senter');
    $this->form_validation->set_rules('anggota_peneliti', 'Anggota Penelitian', 'callback_check_id_pengusul');

    $this->form_validation->set_message('required', '{field} tidak boleh kosong');
    $this->form_validation->set_message('max_length', '{field} tidak boleh melebihi {param} karakter');
    $this->form_validation->set_message('valid_email', '{field} tidak valid');
  }

  function check_judul_exist($judul)
  {
    $id_pengajuan = $this->input->post('id');
    $id_pengusul = $this->session->userdata('id_pengusul');
    $id_kepk = $this->input->post('id_kepk');
    $check = $this->data_model->check_data_judul($id_pengajuan, $id_pengusul, $id_kepk, $judul);

    if ($check === TRUE) return TRUE;
    else
    {
      $this->form_validation->set_message('check_judul_exist', $check);          
      return FALSE;
    } 
  }

  function check_tempat_multi_senter($tempat)
  {
    $is_multi_senter = $this->input->post('is_multi_senter');

    if ($is_multi_senter === 'true' && trim($tempat) == '') {
        $this->form_validation->set_message('check_tempat_multi_senter', 'Tempat Multi Senter belum diisi');
        return FALSE;
    }
    else return TRUE;
  }

  function check_valid_waktu_mulai($waktu_mulai)
  {
  	$inserted = $this->input->post('inserted');
  	$waktu_mulai = prepare_date($waktu_mulai);

  	if (strtotime($waktu_mulai) < strtotime($inserted)){
  		$this->form_validation->set_message('check_valid_waktu_mulai', 'Waktu Mulai Penelitian tidak boleh kurang dari waktu pengajuan.');
  		return FALSE;
  	}
  	else return TRUE;
  }

  function check_valid_waktu_selesai($waktu_selesai)
  {
  	$waktu_mulai = prepare_date($this->input->post('waktu_mulai'));
  	$waktu_selesai = prepare_date($waktu_selesai);

  	if (strtotime($waktu_selesai) < strtotime($waktu_mulai)){
  		$this->form_validation->set_message('check_valid_waktu_selesai', 'Waktu Selesai Penelitian tidak valid');
  		return FALSE;
  	}
  	else return TRUE;
  }

  function check_id_pengusul($nomor)
  {
    $nomor_null = array();
    $nomor_null_text = '';
    $nomor_failed = array();
    $nomor_failed_text = '';
    $anggota = $this->input->post('anggota_peneliti') ? json_decode($this->input->post('anggota_peneliti')) : '';
    for ($a=0; $a<count($anggota); $a++)
    {
      $nomor = isset($anggota[$a]->nomor) ? $anggota[$a]->nomor : 0;
      $nama = isset($anggota[$a]->nama) ? $anggota[$a]->nama : '';
      $id_pengusul = isset($anggota[$a]->nomor) ? $this->data_model->get_id_pengusul_by_nomor($anggota[$a]->nomor) : 0;

      if ($nama != '')
      {
        if ($nomor == '')
        {
          $nomor_null[] = $nama;
          // $this->form_validation->set_message('check_id_pengusul', 'Masukkan nomor anggota penelitian '.$nama);
          // return FALSE;          
        }
        else 
        {
          if ($id_pengusul == 0)
          {
            $nomor_failed[] = $nomor;
            // $this->form_validation->set_message('check_id_pengusul', 'Anggota penelitian '.$nama.' belum terdaftar');
            // return FALSE;          
          }
        }
      }
    }

    if (count($nomor_null) > 0)
    {
      for ($x=0; $x<count($nomor_null); $x++)
      {
        if ($x+1 < count($nomor_null) && $x != 0)
          $nomor_null_text .= ', ';
        else if ($x+1 == count($nomor_null) && $x != 0)
          $nomor_null_text .= ' dan ';

        $nomor_null_text .= $nomor_null[$x];
      }
      $this->form_validation->set_message('check_id_pengusul', 'Masukkan nomor anggota penelitian '.$nomor_null_text);
      return FALSE;          
    }
    else if (count($nomor_failed) > 0) {
      for ($y=0; $y<count($nomor_failed); $y++)
      {
        if ($y+1 < count($nomor_failed) && $y != 0)
          $nomor_failed_text .= ', ';
        else if ($y+1 == count($nomor_failed) && $y != 0)
          $nomor_failed_text .= ' dan ';
        
        $nomor_failed_text .= $nomor_failed[$y];
      }
      $this->form_validation->set_message('check_id_pengusul', 'Nomor anggota penelitian '.$nomor_failed_text.' tidak terdaftar');
      return FALSE;          
    }
    else
      return TRUE;

  }

  public function proses()
  {
    $oper = $this->input->post('oper');

    if ($oper == 'del')
      return $this->hapus();
    
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
          'id' => $result[$i]['id_pengajuan'],
          'no_protokol' => $result[$i]['no_protokol'],
          'no_gabungan' => $result[$i]['nomor'] . $result[$i]['no_protokol'],
          'judul' => $result[$i]['judul'],
          'tanggal' => date('d/m/Y', strtotime($result[$i]['tanggal_pengajuan'])),
          'kepk' => $result[$i]['nama_kepk'],
          'mulai' => date('d/m/Y', strtotime($result[$i]['waktu_mulai'])),
          'selesai' => date('d/m/Y', strtotime($result[$i]['waktu_selesai']))
        );
      }
    }
    
    echo json_encode($response);
  }

  function get_anggota_by_id($id)
  {
    $result = $this->data_model->get_data_anggota_by_id($id);

    $response = (object) NULL;
    $response->data = array();
    if ($result){
      for($i=0; $i<count($result); $i++){
        $response->data[] = array(
          'id' => $result[$i]['id_ap'],
          'nama' => $result[$i]['nama'],
          'nomor' => $result[$i]['nomor'],
        );
      }
    }
    
    echo json_encode($response->data);
  }

  function get_pa_by_id($id)
  {
    $result = $this->data_model->get_data_pa_by_id($id);

    $response = (object) NULL;
    $response->data = array();
    if ($result){
      for($i=0; $i<count($result); $i++){
        $response->data[] = array(
          'id' => $result[$i]['id_pa'],
          'nama' => $result[$i]['nama'],
          'institusi' => $result[$i]['institusi'],
          'tugas' => $result[$i]['tugas'],
          'telp' => $result[$i]['telp'],
        );
      }
    }
    
    echo json_encode($response->data);
  }

  function get_tarif_telaah_by_param($id_kepk=0, $jns_penelitian=0, $asal_pengusul=0, $jns_lembaga=0, $status_pengusul=0, $strata_pend=0)
  {
    $result = $this->data_model->get_data_tarif_telaah_by_param($id_kepk, $jns_penelitian, $asal_pengusul, $jns_lembaga, $status_pengusul, $strata_pend);

    $response = (object) NULL;
    if (isset($result['tarif_telaah']))
      $response->tarif_telaah = number_format($result['tarif_telaah'],2,",",".");
    else
      $response->tarif_telaah = '';

    echo json_encode($response);
  }

  public function do_upload($file)
  {
    $response = (object)null;

    $dir = './uploads/';
    if (!is_dir($dir)) {
      mkdir($dir, 0777, true);         
      chmod($dir, 0777);
    }

    $config['upload_path'] = $dir;
    $config['allowed_types'] = 'pdf|png|jpg|jpeg';
    $config['max_size'] = 100000;
    $config['encrypt_name'] = TRUE;

    $this->load->library('upload', $config);

    if ( ! $this->upload->do_upload($file))
    {
      $response->isSuccess = FALSE;
      $response->message = $this->upload->display_errors();
    }
    else
    {
      $response->isSuccess = TRUE;
      $response->message = 'Data berhasil diunggah';
      $response->data_fileupload = $this->upload->data();
      $response->file = $file;
    }

    echo json_encode($response);
  }

/*  public function kirim_email()
  {
    $htmlContent = '<h1>Mengirim email HTML dengan Codeigniter</h1>';
    $htmlContent .= '<div>Contoh pengiriman email yang memiliki tag HTML dengan menggunakan Codeigniter</div>';
        
    $config['mailtype'] = 'html';
    $this->email->initialize($config);
    $this->email->to('trisugi@yahoo.co.id');
    $this->email->from('admin@jurnalweb.com','JurnalWeb');
    $this->email->subject('Test Email (HTML)');
    $this->email->message($htmlContent);
    $this->email->send();
    echo 'ok';
  }
*/

/*  public function cetak_pengajuan($id_pengajuan=0, $password='')
  {
    $this->load->library('Pdf');

    // create new PDF document
    $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('KEPK');
    $pdf->SetTitle('Formulir Pengajuan Kaji Etik');
    $pdf->SetSubject('Formulir Pengajuan Kaji Etik');

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

    $data_pengajuan = $this->data_model->get_data_pengajuan_by_id($id_pengajuan);

    $pdf->writeHTML('<h3>Formulir Pengajuan Kaji Etik</h3>', true, false, true, false, '');
    $pdf->writeHTML('<hr>', true, false, true, false, '');

    $html = '
        <table border="0">
        <tr><td width="30%">Nomor Protokol</td><td width="2%">:</td>
            <td width="40%">'.$data_pengajuan['no_protokol'].'</td></tr>
        <tr><td>Judul Protokol</td><td>:</td>
            <td>'.$data_pengajuan['judul'].'</td></tr>
        <tr><td>Ketua Pelaksana / Peneliti Utama</td><td>:</td>
            <td>'.$data_pengajuan['nama_ketua'].'</td></tr>
        <tr><td>Nomor Telepon</td><td>:</td>
            <td>'.$data_pengajuan['telp_peneliti'].'</td></tr>
        <tr><td>Email</td><td>:</td>
            <td>'.$data_pengajuan['email_peneliti'].'</td></tr>
        <tr><td>Komunikasi yang diinginkan</td><td>:</td>
            <td>';
    $kom = explode(',', $data_pengajuan['komunikasi']);
    $html .= '<input type="checkbox" name="komunikasi" value="telepon"';
    if (in_array('telepon', $kom)) $html .= ' checked="checked"';
    $html .= ' /> <label for="telepon">Telepon </label>';
    $html .= '<input type="checkbox" name="komunikasi" value="email"';
    if (in_array('email', $kom)) $html .= ' checked="checked"';
    $html .= ' /> <label for="email">Email </label>';
    $html .= '<input type="checkbox" name="komunikasi" value="fax"';
    if (in_array('fax', $kom)) $html .= ' checked="checked"';
    $html .= ' /> <label for="fax">Fax </label>';
    $html .= '</td></tr>';
    $html .= '<tr><td>Institusi Asal Peneliti Utama</td><td>:</td>
                    <td>'.$data_pengajuan['nama_institusi'].'</td></tr>';
    $html .= '<tr><td>Alamat Institusi</td><td>:</td>
                    <td width="70%">'.$data_pengajuan['alamat_institusi'].'</td></tr>';
    $html .= '<tr><td>Nomor Telepon Institusi/Fax</td><td>:</td>
                    <td>'.$data_pengajuan['telp_institusi'].'</td></tr>';
    $html .= '<tr><td>Email Institusi</td><td>:</td>
                    <td>'.$data_pengajuan['email_institusi'].'</td></tr>';
    $html .= '<tr><td>Sumber Dana</td><td>:</td>
                    <td>'.$data_pengajuan['sumber_dana'].'</td></tr>';
    $html .= '<tr><td>Total Dana</td><td>:</td>
                    <td>'.number_format($data_pengajuan['total_dana'],2,",",".").'</td></tr>';
    $html .= '<tr><td>Penelitian</td><td>:</td>';
    $html .= '<td width="70%"><input type="radio" name="penelitian" value="non"';
    if ($data_pengajuan['penelitian'] == 'non') $html .= ' checked="checked"';
    $html .= ' /> <label for="non">Bukan Kerjasama</label><br>';
    $html .= '<input type="radio" name="penelitian" value="nasional"';
    if ($data_pengajuan['penelitian'] == 'nasional') $html .= ' checked="checked"';
    $html .= ' /> <label for="nasional">Kerjasama Nasional</label><br>';
    $html .= '<input type="radio" name="penelitian" value="internasional"';
    if ($data_pengajuan['penelitian'] == 'internasional') $html .= ' checked="checked"';
    $html .= ' /> <label for="internasional">Kerjasama internasional, Jumlah negara yang terlibat : '.$data_pengajuan['jml_negara'].'</label><br>';
    $html .= '<input type="radio" name="penelitian" value="non"';
    if ($data_pengajuan['penelitian'] == 'asing') $html .= ' checked="checked"';
    $html .=' /> <label for="non">Melibatkan peneliti asing</label></td></tr>';
    $html .= '<tr><td>Tempat Penelitian</td><td>:</td><td>'.$data_pengajuan['tempat'].'</td></tr>';
    $html .= '<tr><td>Waktu Penelitian</td><td>:</td>
                <td>'.date('d-m-Y', strtotime($data_pengajuan['waktu_mulai'])).' s/d '.date('d-m-Y', strtotime($data_pengajuan['waktu_selesai'])).'</td></tr>';
    $html .= '</table>';
    $html .= '<p>Apakah protokol pernah diajukan ke Komisi Etik Lain?';
    $html .= $data_pengajuan['is_kepk_lain'] == 1 ? ' Ya' : ' Tidak';
    if ($data_pengajuan['is_kepk_lain'] == 1){
        $html .= strlen($data_pengajuan['kepk_lain']) > 0 ? ' di '.$data_pengajuan['kepk_lain'] : '';
        $html .= $data_pengajuan['status_pengajuan_lama'] == 1 ? ' (Diterima)' : ' (Ditolak)';
    }
    $html .= '</p>';
    $html .= '<i>Password</i> : '.$password.'<br>';
    $html .= '<i style="font-size: 9">Segera ganti password setelah login</i>';

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');
    
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

    // QRCODE,L : QR-CODE Low error correction
    $pdf->write2DBarcode($data_pengajuan['no_protokol'], 'QRCODE,L', 150, 38, 50, 50, $style, 'N');

    //Close and output PDF document
    $pdf->Output('kepk-pengajuan.pdf', 'I');
  }*/

  function hapus()
  {
    $response = (object)null;

    $id = $this->input->post('id');

    $check = $this->data_model->check_exist_data($id);

    if ($check)
    {
      $response->isSuccess = FALSE;
      $response->message = 'Data dipakai di tabel lain. Lihat di daftar protokol.';
    }
    else
    {
      $result = $this->data_model->delete_data($id);

      if ($result)
      {
        $response->isSuccess = TRUE;
        $response->message = 'Data berhasil dihapus';
      }
      else
      {
        $response->isSuccess = FALSE;
        $response->message = 'Data gagal dihapus';
      }     
    }
    
    echo json_encode($response);
  }
}
?>