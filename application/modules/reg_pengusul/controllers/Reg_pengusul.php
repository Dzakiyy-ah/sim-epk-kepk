<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reg_pengusul extends CI_Controller {

  var $API ="";

  public function __construct()
  {
    parent::__construct();

    $this->API = APISERVER;
    $this->load->library('curl');
    $this->load->library('secure');

    $this->load->model('Reg_pengusul_model', 'data_model');
  }
 
  public function index()
  {
    $data['title'] = APPNAME.' - Pendaftaran Peneliti';
    $data['page_header'] = 'Pendaftaran Peneliti';
    $data['breadcrumb'] = 'Pendaftaran Peneliti';
    $data['css_content'] = 'reg_pengusul_view_css';
    $data['main_content'] = 'reg_pengusul_view';
    $data['js_content'] = 'reg_pengusul_view_js';
    $data['isset_kepk'] = $this->data_model->check_isset_data_kepk();
    $data['opt_country'] = $this->data_model->get_data_opt_countries();
    $data['opt_wilayah'] = $this->data_model->get_data_opt_wilayah();
 
    $this->load->view('layout/template_web', $data);
  }

  public function validation_form()
  {
    $this->form_validation->set_rules('no_anggota', 'Nomor Anggota', 'trim|required|max_length[50]|is_unique[tb_pengusul.nomor]');
    $this->form_validation->set_rules('nama', 'Nama', 'trim|required|max_length[200]');
    $this->form_validation->set_rules('nik', 'NIK', 'trim|required|max_length[100]|is_unique[tb_pengusul.nik]');
    $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'trim|required|max_length[100]');
    $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
    $this->form_validation->set_rules('tgl_lahir', 'Tanggal Lahir', 'trim|required');
    $this->form_validation->set_rules('kewarganegaraan', 'Kewarganegaraan', 'trim|required');
    $this->form_validation->set_rules('negara', 'Negara', 'trim|required');
    $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
    $this->form_validation->set_rules('jalan', 'Jalan', 'trim|max_length[100]');
    $this->form_validation->set_rules('no_rumah', 'No. Rumah', 'trim|max_length[10]');
    $this->form_validation->set_rules('rt', 'RT', 'trim|max_length[5]');
    $this->form_validation->set_rules('rw', 'RW', 'trim|max_length[5]');
    $this->form_validation->set_rules('kode_pos', 'Kode Pos', 'trim|max_length[10]');

    if ($this->input->post('negara') == 'WNI')
    {
      $this->form_validation->set_rules('propinsi', 'Propinsi', 'trim|required');
      $this->form_validation->set_rules('kabupaten', 'Kabupaten/Kotamadya', 'trim|required');
      $this->form_validation->set_rules('kecamatan', 'Kecamatan', 'trim|required');
    }
    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[100]|is_unique[tb_pengusul.email]');
    $this->form_validation->set_rules('no_telp', 'Nomor Telepon', 'trim|max_length[20]');
    $this->form_validation->set_rules('no_hp', 'Nomor Handphone', 'trim|required|max_length[20]');

    $this->form_validation->set_message('required', '{field} tidak boleh kosong');
    $this->form_validation->set_message('max_length', '{field} tidak boleh melebihi {param} karakter');
    $this->form_validation->set_message('valid_email', '{field} tidak valid');
    $this->form_validation->set_message('is_unique', '{field} sudah terdaftar');
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
        $id = $this->secure->encrypt_url($this->data_model->id);
        $response->url_cetak = base_url().'reg_pengusul/cetak_reg_pengusul/'.$id;

        // $this->kirim_email($response->id, $response->password);
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

  function get_peneliti_by_no($nomor)
  {
    $response = (object)null;

    $data = json_decode($this->curl->simple_get($this->API.'/anggota_nontimkep_by_nomor?nomor_anggota='.$nomor));

    if (!empty($data))
    {
      $response->isSuccess = TRUE;
      $response->message = 'Data Peneliti dengan nomor anggota '.$nomor.' ditemukan.';
      $response->data = $data;
    }
    else
    {
      $response->isSuccess = FALSE;
      $response->message = 'Data Peneliti dengan nomor anggota <strong><u>"'.$nomor.'"</u></strong> tidak ditemukan.';
    }

    echo json_encode($response);
  }

  function get_dokumen_peneliti_by_no($nomor)
  {
    $response = (object)null;

    $data = json_decode($this->curl->simple_get($this->API.'/dokumen_anggota_nontimkep_by_nomor?nomor_anggota='.$nomor));

    if (!empty($data))
    {
      foreach($data as $key=>$val)
      {
        $file_name = $val->file_name;
        $content = file_get_contents(UPLOAD_DIR_SERVER . $file_name);
        file_put_contents('./uploads/'.$file_name, $content);
      }

      $response->isSuccess = TRUE;
      $response->message = 'Data Dokumen Peneliti ditemukan.';
      $response->data = $data;
    }
    else
    {
      $response->isSuccess = FALSE;
      $response->message = 'Data Dokumen Peneliti tidak ditemukan.';
    }

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
  
/*  public function kirim_email($id, $password)
  {
    $data = $this->data_model->get_data_pengusul_by_id($id);

    $htmlContent = '<h3>Pendaftaran Peneliti</h3>';
    $htmlContent .= '<hr>';
    $htmlContent = '
        <table border="0">
        <tr><td width="30%">Nama</td><td width="2%">:</td>
            <td width="40%">'.$data['nama'].'</td></tr>
        <tr><td width="30%">NIK KTP</td><td width="2%">:</td>
            <td width="40%">'.$data['nik'].'</td></tr>
        <tr><td>Alamat</td><td>:</td>
            <td>'.$data['alamat'].'</td></tr>
        <tr><td>Kabupaten/Kotamadya</td><td>:</td>
            <td>'.$data['kabupaten'].'</td></tr>
        <tr><td>Propinsi</td><td>:</td>
            <td>'.$data['propinsi'].'</td></tr>
        <tr><td>Nomor Telepon Instansi</td><td>:</td>
            <td>'.$data['no_telepon'].'</td></tr>
        <tr><td>Email Peneliti</td><td>:</td>
            <td>'.$data['email'].'</td></tr>
        </table>';
    $htmlContent .= '<i>Username</i> : '.$data['nomor'].'<br>';
    $htmlContent .= '<i>Password</i> : '.$password.'<br>';
    $htmlContent .= '<i style="font-size: 9">Segera ganti password setelah login</i>';
        
    $config['mailtype'] = 'html';
    $this->email->initialize($config);
    $this->email->to($data['email']);
    $this->email->from('no-reply@keppk.web.id','KEPPKN');
    $this->email->subject('Pendaftaran Peneliti');
    $this->email->message($htmlContent);
    $this->email->send();
  }*/

  public function cetak_reg_pengusul($id=0)
  {
    $this->load->library('Pdf');

    // create new PDF document
    $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('E-Protokol');
    $pdf->SetTitle('Pendaftaran Peneliti');
    $pdf->SetSubject('Pendaftaran Peneliti');

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

    $id = $this->secure->decrypt_url($id);

    $data = $this->data_model->get_data_pengusul_by_id($id);

    $pdf->writeHTML('<h3>Pendaftaran Peneliti</h3>', true, false, true, false, '');
    $pdf->writeHTML('<h1>'.$data['nama_kepk'].'</h1>', true, false, true, false, '');
    $pdf->writeHTML('<hr>', true, false, true, false, '');

    $html = '
        <table border="0">
        <tr><td width="30%">Nomor</td><td width="2%">:</td>
            <td width="40%">'.$data['nomor'].'</td></tr>
        <tr><td>Nama</td><td>:</td>
            <td>'.$data['nama'].'</td></tr>
        <tr><td>NIK</td><td>:</td>
            <td>'.$data['nik'].'</td></tr>
        <tr><td>Kewarganegaraan</td><td>:</td>
            <td>'.$data['kewarganegaraan'].'</td></tr>
        <tr><td>Negara</td><td>:</td>
            <td>'.$data['negara'].'</td></tr>
        <tr><td>Nomor Telepon</td><td>:</td>
            <td>'.$data['no_telepon'].'</td></tr>
        <tr><td>Nomor Handphone</td><td>:</td>
            <td>'.$data['no_hp'].'</td></tr>
        <tr><td>Email Peneliti</td><td>:</td>
            <td>'.$data['email'].'</td></tr>
        </table>';

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
    $pdf->write2DBarcode('Nomor: '.$data['nomor'], 'QRCODE,L', 150, 38, 50, 50, $style, 'N');

    //Close and output PDF document
    $pdf->Output('registrasi-peneliti.pdf', 'I');
  }

}
?>