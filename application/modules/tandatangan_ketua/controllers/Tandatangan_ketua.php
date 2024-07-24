<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tandatangan_ketua extends Userpage_Controller {

  public function __construct()
  {
    parent::__construct();

    $this->load->model('Tandatangan_ketua_model', 'data_model');
  }
 
  public function index()
  {
    $data['title'] = APPNAME.' - Tanda Tangan Ketua';
    $data['page_header'] = 'Tanda Tangan Ketua';
    $data['breadcrumb'] = 'Tanda Tangan Ketua';
    $data['data'] = $this->data_model->get_data();
    $data['css_content'] = 'tandatangan_ketua_view_css';
    $data['main_content'] = 'tandatangan_ketua_view';
    $data['js_content'] = 'tandatangan_ketua_view_js';

    $this->load->view('layout/template', $data);
  }

  public function validation_form()
  {
    $this->form_validation->set_rules('client_name', 'Tanda Tangan Ketua', 'trim|required');

    $this->form_validation->set_message('required', '{field} tidak boleh kosong');
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

  public function do_upload()
  {
    $response = (object)null;

    $dir = './uploads/';
    if (!is_dir($dir)) {
      mkdir($dir, 0777, true);         
      chmod($dir, 0777);
    }

    $config['upload_path'] = $dir;
    $config['allowed_types'] = 'jpg|jpeg|png';
    $config['max_size'] = 100000;
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

  function pratinjau_cetak($file_name='')
  {
    $this->load->library('Pdf');

    // create new PDF document
    $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('E-Protokol');
    $pdf->SetTitle('Pratinjau Cetak Tanda Tangan Ketua');
    $pdf->SetSubject('Pratinjau Cetak Tanda Tangan Ketua');

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

    $data_kop = $this->data_model->get_data_kop_surat();
    $data_kepk = $this->data_model->get_data_ketua_kepk();

    // set font
    $pdf->SetFont('times', '', 10);

    // add a page
    $pdf->AddPage();

    if (isset($data_kop['file_name']) && file_exists('./uploads/'.$data_kop['file_name']))
      $pdf->writeHTMLCell(210, '', 0, 5, '<img src="./uploads/'.$data_kop['file_name'].'">', 0, 1, false, true, 'L', false);
    // if ($file_name != '')
    //   $pdf->writeHTMLCell(210, '', 0, 5, '<img src="./uploads/'.$file_name.'">', 0, 1, false, true, 'L', false);

    $html = '<table border="0">';
    $html .= '<thead>';
    $html .= '<tr><th align="center"></th></tr>';
    $html .= '<tr><th align="center"><strong>Lorem ipsum dolor sit amet</strong></th></tr>';
    $html .= '</thead>';
    $html .= '</table>';

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    // set font
    $pdf->SetFont('times', '', 10);

    $html = '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>';
    $html .= '<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>';

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    if ($file_name != '')
      $ttd = '<img src="./uploads/'.$file_name.'" height="80">';
    else 
      $ttd = '<br/><br/><br/><br/><br/>';

    $html = '<table border="0">';
    $html .= '<tr>
                <td width="50%"></td>
                <td width="50%" align="center"><i>'.date('F d, Y').'</i></td>
              </tr>';
    $html .= '<tr>
                <td width="50%"></td>
                <td width="50%" align="center"><i>Professor and Chairperson,</i></td>
              </tr>';
    $html .= '<tr>
                <td width="50%"></td>
                <td width="50%" align="center">'.$ttd.'</td>
              </tr>';
    $html .= '<tr>
                <td width="50%"></td>
                <td width="50%" align="center">'.$data_kepk['nama'].'</td>
              </tr>';
    $html .= '</table>';

    $pdf->writeHTMLCell(0, '', '', 150, $html, 0, 0, 0, true, 'L', true);

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

    $pdf->write2DBarcode(date('Y-m-d H:i:s').' | 1234567890 | '.$data_kepk['nomor'].' | '.$data_kepk['nik'], 'QRCODE,L', 20, 160, 20, 20, $style, 'N');

    //Close and output PDF document
    $pdf->Output('pratinjau-cetak-tandatangan-ketua.pdf', 'I');  
  }

}
