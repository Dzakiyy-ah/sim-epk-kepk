<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Surat_persetujuan extends Userpage_Controller {

  public function __construct()
  {
    parent::__construct();

    $this->load->model('Surat_persetujuan_model', 'data_model');
  }
 
  public function index()
  {
    $data['title'] = APPNAME.' - Surat Persetujuan Etik';
    $data['page_header'] = 'Daftar Surat Persetujuan Etik';
    $data['breadcrumb'] = 'Surat Persetujuan Etik';
    $data['css_content'] = 'surat_persetujuan_view_css';
    $data['main_content'] = 'surat_persetujuan_view';
    $data['js_content'] = 'surat_persetujuan_view_js';
 
    $this->load->view('layout/template', $data);
  }

  public function form($id=0)
  {
    $data['title'] = APPNAME.' - Surat Persetujuan Etik';
    $data['page_header'] = 'Form Surat Persetujuan Etik';
    $data['breadcrumb'] = 'Surat Persetujuan Etik';
    $data['css_content'] = 'surat_persetujuan_form_css';
    $data['main_content'] = 'surat_persetujuan_form';
    $data['js_content'] = 'surat_persetujuan_form_js';
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
          'id' => $result[$i]['id_ethical_approval'],
          'no_surat' => $result[$i]['no_surat'],
          'tgl_surat' => date('d/m/Y', strtotime($result[$i]['tanggal_surat'])),
          'no_protokol' => $result[$i]['no_protokol'],
          'judul' => $result[$i]['judul'],
        );
      }
    }
    
    echo json_encode($response);
  }

  function get_standar_kelaikan($id_pep=0)
  {
    $result = $this->data_model->get_data_standar_kelaikan($id_pep);

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
          'just_header' => $result[$i]['just_header']
        );
      }
    }
    
    echo json_encode($response->data);
  }

  public function cetak_surat($id=0)
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
    $data_ethical = $this->data_model->get_data_ethical_approval_by_id($id);

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

    //Close and output PDF document
    $pdf->Output('ethical-approval.pdf', 'I');
  }

  public function cetak_sa($id=0, $id_pep=0)
  {
    $this->load->library('Pdf');

    // create new PDF document
    $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('E-Protokol');
    $pdf->SetTitle('Self Assesment');
    $pdf->SetSubject('Self Assesment');

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

    $data_ethical = $this->data_model->get_data_ethical_approval_by_id($id);
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
    $pdf->Output('self-assesment-ethical-approval.pdf', 'I');
  }

}
?>