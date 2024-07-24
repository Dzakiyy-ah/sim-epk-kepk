<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hasil_telaah extends Userpage_Controller {

  public function __construct()
  {
    parent::__construct();

    $this->load->model('Hasil_telaah_model', 'data_model');
  }
 
  public function index()
  {
    $data['title'] = APPNAME.' - Hasil Telaah';
    $data['page_header'] = 'Daftar Hasil Telaah';
    $data['breadcrumb'] = 'Hasil Telaah';
    $data['css_content'] = 'hasil_telaah_view_css';
    $data['main_content'] = 'hasil_telaah_view';
    $data['js_content'] = 'hasil_telaah_view_js';
 
    $this->load->view('layout/template', $data);
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
          'id' => $result[$i]['id_pep'],
          'no_protokol' => $result[$i]['no_protokol'],
          'judul' => $result[$i]['judul'],
          'klasifikasi' => $result[$i]['klasifikasi'],
          'keputusan' => $result[$i]['keputusan'],
          'jenis_surat' => $result[$i]['jenis_surat'],
          'tgl_upload' => date('d/m/Y H:i:s', strtotime($result[$i]['tanggal_upload']))
        );
      }
    }
    
    echo json_encode($response);
  }

  public function get_file_by_id($id=0)
  {
    $result = $this->data_model->get_data_file_by_id($id);

    $response = (object) NULL;
    $response->data = array();
    if ($result){
      for($i=0; $i<count($result); $i++){
        $response->data[] = array(
          'id' => $result[$i]['id_pep'],
          'no' => $i+1,
          'nama_file' => $result[$i]['nama_file'],
          'klasifikasi' => $result[$i]['klasifikasi'],
          'jenis_file' => $result[$i]['jenis_file']
        );
      }
    }
    
    echo json_encode($response->data);
  }

  function cetak($id=0, $klasifikasi=0, $jenis_file='')
  {
    switch(urldecode($jenis_file))
    {
      case 'ethical_exemption': $this->cetak_ethical_exemption($id); break;
      case 'sa_ethical_exemption': $this->cetak_sa_ethical_exemption($id); break;
      case 'ethical_approval': $this->cetak_ethical_approval($id); break;
      case 'sa_ethical_approval': $this->cetak_sa_ethical_approval($id); break;
      case 'ethical_revision': $this->cetak_ethical_revision($id); break;
      case 'catatan_penelaah': 
          if ($klasifikasi == 2) $this->cetak_catatan_expedited($id);
          else if ($klasifikasi == 3) $this->cetak_catatan_fullboard($id);
        break;
      case 'alasan_tbd': $this->cetak_alasan_tbd($id); break;
      case 'daftar_kunjungan': $this->cetak_daftar_kunjungan($id); break;
      case 'report_hasil': $this->cetak_report_hasil($id); break;
      case 'permohonan_usulan': $this->cetak_permohonan_usulan($id); break;
      case 'memorandum_penghentian': $this->cetak_memorandum_penghentian($id); break;
      case 'laporan_ktd_serius': $this->cetak_laporan_ktd_serius($id); break;
      case 'catatan_penyimpangan': $this->cetak_catatan_penyimpangan($id); break;
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
    
    //Close and output PDF document
    $pdf->Output('ethical-exempted.pdf', 'I');
  }

  public function cetak_sa_ethical_exemption($id_pep=0)
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

    $data_ethical = $this->data_model->get_data_ethical_exemption_by_id_pep($id_pep);
    $data_sa = $this->data_model->get_data_standar_kelaikan_ethical_exemption($id_pep);

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
    $pdf->Output('self-assesment-ethical-exemption.pdf', 'I');
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

    //Close and output PDF document
    $pdf->Output('ethical-approval.pdf', 'I');
  }

  public function cetak_sa_ethical_approval($id_pep=0)
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

    $data_ethical = $this->data_model->get_data_ethical_approval_by_id_pep($id_pep);
    $data_sa = $this->data_model->get_data_standar_kelaikan_ethical_approval($id_pep);

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

  public function cetak_ethical_revision($id_pep=0)
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

    //Close and output PDF document
    $pdf->Output('ethical-revision.pdf', 'I');
  }

  public function cetak_catatan_expedited($id_pep=0)
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

    $data_ethical = $this->data_model->get_data_ethical_revision_by_id_pep($id_pep);

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
    $pdf->Output('catatan-telaah-ethical-revision.pdf', 'I');
  }

  public function cetak_catatan_fullboard($id_pep=0)
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

    $data_ethical = $this->data_model->get_data_ethical_revision_by_id_pep($id_pep);

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
    $pdf->Output('catatan-telaah-ethical-revision.pdf', 'I');
  }

  public function cetak_alasan_tbd($id_pep=0)
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

    $data_ethical = $this->data_model->get_data_ethical_revision_by_id_pep($id_pep);

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
    $pdf->Output('alasan-tbd-ethical-revision.pdf', 'I');
  }

  public function cetak_daftar_kunjungan($id_pep=0)
  {
    $this->load->library('Pdf');

    // create new PDF document
    $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('E-Protokol');
    $pdf->SetTitle('Daftar Tilik Kunjungan Pemantauan');
    $pdf->SetSubject('Daftar Tilik Kunjungan Pemantauan');

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
    $pdf->SetFont('times', '', 10);

    // add a page
    $pdf->AddPage();

    $data_kop = $this->data_model->get_data_kop_surat();
    $data_protokol = $this->data_model->get_data_protokol_by_id_pep($id_pep);
    $versi = $data_protokol['revisi_ke']+1;

    if (isset($data_kop['file_name']) && file_exists('./uploads/'.$data_kop['file_name']))
      $pdf->writeHTMLCell(210, '', 0, 5, '<img src="./uploads/'.$data_kop['file_name'].'">', 0, 1, false, true, 'L', false);

    $html = '<p align="center"><h3>DAFTAR TILIK KUNJUNGAN PEMANTAUAN</h3></p>';
    $html .= '<table border="1" cellpadding="5">';
    $html .= '<tr>
                <td width="35%">Tanggal Kunjungan:</td>
                <td width="65%">No. Protokol / Versi: '.$data_protokol['no_protokol'].' / '.$versi.'</td>
              </tr>';
    $html .= '<tr>
                <td colspan="2">Judul Penelitian: '.$data_protokol['judul'].'</td>
              </tr>';
    $html .= '<tr>
                <td width="45%">Peneliti Utama:<br/>Telp. Kantor/Fax.:<br/>HP:<br/>E-mail:</td>
                <td width="55%">Kantor/Institusi:<br/>Alamat:<br/>Sponsor:<br/>Alamat:</td>
              </tr>';
    $html .= '<tr>
                <td width="45%">Jumlah Subyek yang Diharapkan:</td>
                <td width="55%">Jumlah Subyek yang Didapat:</td>
              </tr>';
    $html .= '<tr>
                <td width="45%">Apakah Fasilitas Tempat Layak?<br/>&nbsp;&nbsp;&nbsp;&nbsp;Ya&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tidak</td>
                <td width="55%">Komentar:</td>
              </tr>';
    $html .= '<tr>
                <td width="45%">Apakah PSP Terbaru?<br/>&nbsp;&nbsp;&nbsp;&nbsp;Ya&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tidak</td>
                <td width="55%">Komentar:</td>
              </tr>';
    $html .= '<tr>
                <td width="45%">Adakah Dijumpai Kejadian yang Tak Diinginkan?<br/>&nbsp;&nbsp;&nbsp;&nbsp;Ya&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tidak</td>
                <td width="55%">Komentar:</td>
              </tr>';
    $html .= '<tr>
                <td width="45%">Apakah Formulir Catatan Klinis?<br/>&nbsp;&nbsp;&nbsp;&nbsp;Ya&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tidak</td>
                <td width="55%">Komentar:</td>
              </tr>';
    $html .= '<tr>
                <td width="45%">Adakah Penyimpanan Data dan Hasil Investigasi Terjaga?</td>
                <td width="55%">Komentar:</td>
              </tr>';
    $html .= '<tr>
                <td width="45%">Bagaimana Subyek Bekerjasama?<br/>&nbsp;&nbsp;&nbsp;&nbsp;Baik&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cukup&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kurang</td>
                <td width="55%">Komentar:</td>
              </tr>';
    $html .= '<tr>
                <td width="45%">Adakah Tindakan dari Hasil Utama dan kunjungan?</td>
                <td width="55%">Uraian:<br/></td>
              </tr>';
    $html .= '<tr>
                <td width="45%">Lama Kunjungan:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jam:</td>
                <td style="border-right-style: hidden;">Mulai:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Selesai:</td>
              </tr>';
    $html .= '<tr>
                <td width="45%">Nama Representative/ Tim Monitoring</td>
                <td></td>
              </tr>';
    $html .= '</table>';

    $html .= '<br/><br/>';

    $html .= '<table border="0">';
    $html .= '<tr>
                <td width="30%"></td>
                <td width="40%"></td>
                <td width="30%" align="center">Mengetahui,</td>
              </tr>';
    $html .= '<tr>
                <td colspan="3"><br/><br/><br/><br/></td>
              </tr>';
    $html .= '<tr>
                <td width="30%"></td>
                <td width="40%"></td>
                <td width="30%" align="center">Peneliti</td>
              </tr>';
    $html .= '</table>';

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');
    
    //Close and output PDF document
    $pdf->Output('daftar-kunjungan.pdf', 'I');
  }

  public function cetak_report_hasil($id_pep=0)
  {
    $this->load->library('Pdf');

    // create new PDF document
    $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('E-Protokol');
    $pdf->SetTitle('Report Hasil');
    $pdf->SetSubject('Report Hasil');

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
    $pdf->SetFont('times', '', 10);

    // add a page
    $pdf->AddPage();

    $data_kop = $this->data_model->get_data_kop_surat();
    $data_protokol = $this->data_model->get_data_protokol_by_id_pep($id_pep);
    $versi = $data_protokol['revisi_ke']+1;

    if (isset($data_kop['file_name']) && file_exists('./uploads/'.$data_kop['file_name']))
      $pdf->writeHTMLCell(210, '', 0, 5, '<img src="./uploads/'.$data_kop['file_name'].'">', 0, 1, false, true, 'L', false);

    $html = '<p align="center"><h3>REPORT HASIL</h3></p>';
    $html .= '<table border="1" cellpadding="5">';
    $html .= '<tr>
                <td width="35%">Tanggal Kunjungan:</td>
                <td width="65%">No. Protokol / Versi: '.$data_protokol['no_protokol'].' / '.$versi.'</td>
              </tr>';
    $html .= '<tr>
                <td colspan="2">Judul Penelitian: '.$data_protokol['judul'].'</td>
              </tr>';
    $html .= '<tr>
                <td width="45%">Peneliti Utama:<br/>Telp. Kantor/Fax.:<br/>HP:<br/>E-mail:</td>
                <td width="55%">Kantor/Institusi:<br/>Alamat:<br/>Sponsor:<br/>Alamat:</td>
              </tr>';
    $html .= '<tr><td colspan="2">Tujuan:<br/><br/><br/></td></tr>';
    $html .= '<tr><td colspan="2">Lokasi Penelitian:<br/><br/><br/></td></tr>';
    $html .= '<tr><td colspan="2">Pengumpulan Data:<br/><br/><br/></td></tr>';
    $html .= '<tr><td colspan="2">Pengolahan Data:<br/><br/><br/></td></tr>';
    $html .= '<tr><td colspan="2">Hasil Penelitian:<br/><br/><br/></td></tr>';
    $html .= '<tr><td colspan="2">Masalah Etik Selama Penelitian dan Solusi yang Dilakukan Peneliti:<br/><br/><br/><br/></td></tr>';
    $html .= '</table>';

    $html .= '<br/><br/>';

    $html .= '<table border="0">';
    $html .= '<tr>
                <td width="30%"></td>
                <td width="40%"></td>
                <td width="30%" align="center">Mengetahui,</td>
              </tr>';
    $html .= '<tr>
                <td colspan="3"><br/><br/><br/><br/></td>
              </tr>';
    $html .= '<tr>
                <td width="30%"></td>
                <td width="40%"></td>
                <td width="30%" align="center">Peneliti</td>
              </tr>';
    $html .= '</table>';

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');
    
    //Close and output PDF document
    $pdf->Output('report-hasil.pdf', 'I');
  }

  public function cetak_permohonan_usulan($id_pep=0)
  {
    $this->load->library('Pdf');

    // create new PDF document
    $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('E-Protokol');
    $pdf->SetTitle('Surat Permohonan Usulan Kaji Etik/Revisi/Amandemen');
    $pdf->SetSubject('Surat Permohonan Usulan Kaji Etik/Revisi/Amandemen');

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
    $pdf->SetFont('times', '', 10);

    // add a page
    $pdf->AddPage();

    $data_protokol = $this->data_model->get_data_protokol_by_id_pep($id_pep);
    $nama_kepk = substr($data_protokol['nama_kepk'], 0, 3) == 'KEP' ? $data_protokol['nama_kepk'] : 'KEPK '.$data_protokol['nama_kepk'];

    $html = '<table>';
    $html .= '<tr>
                <td width="50%"></td>
                <td width="50%" style="border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black;"> <b>Lampiran 20:</b></td>
              </tr>';
    $html .= '<tr>
                <td width="50%"></td>
                <td width="50%" style="border-left: 1px solid black; border-right: 1px solid black;"> Formulir 01/POB/016</td>
              </tr>';
    $html .= '<tr>
                <td width="50%"></td>
                <td width="50%" style="border-bottom: 1px solid black; border-left: 1px solid black; border-right: 1px solid black;"> Surat Permohonan Usulan Kaji Etik/Revisi/Amandemen</td>
              </tr>';
    $html .= '</table>';

    $pdf->writeHTML($html, true, false, true, false, '');

    $html = '<table border="1" cellpadding="5">';
    $html .= '<tr nobr="true"><td colspan="2" align="center"><b>Diisi oleh peneliti</b></td></tr>';
    $html .= '<tr nobr="true">
                <td width="50%">No. Persetujuan Etik (<i>Ethical Approval</i>):<br/><br/></td>
                <td width="50%">No. Protokol: '.$data_protokol['no_protokol'].'</td>
              </tr>';
    $html .= '<tr nobr="true">
                <td width="50%">Tanggal Persetujuan Etik (<i>Ethical Approval</i>):<br/><br/></td>
                <td width="50%">Tanggal Pengajuan Amandemen:</td>
              </tr>';
    $html .= '<tr nobr="true">
                <td colspan="2">Judul Penelitian: '.$data_protokol['judul'].'</td>
              </tr>';
    $html .= '<tr nobr="true">
                <td width="20%" style="border-style: hidden!important;">Peneliti Utama<br/>Telp. Kantor/Fax.<br/>Telp. Rumah<br/>HP<br/>E-mail</td>
                <td width="80%" style="border-style: hidden!important;">:<br/>:<br/>:<br/>:<br/>:</td>
              </tr>';
    $html .= '<tr nobr="true"><td colspan="2">Amandemen/perubahan yang dilakukan:</td></tr>';
    $html .= '<tr nobr="true"><td colspan="2">Alasan Amandemen:</td></tr>';
    $html .= '<tr nobr="true"><td colspan="2">Jelaskan akibat amandemen terhadap risiko/manfaat bagi subyek:<br/><br/><br/></td></tr>';
    $html .= '<tr nobr="true">
                <td width="50%">Nama & Tanda tangan Peneliti Utama:<br/><br/></td>
                <td width="50%">Tanggal:<br/><br/></td>
              </tr>';
    $html .= '<tr nobr="true"><td colspan="2" align="center"><b>Diisi oleh '.$nama_kepk.'</b></td></tr>';
    $html .= '<tr nobr="true">
                <td width="50%">Nama & Paraf Staf Kesekretariatan:<br/><br/></td>
                <td width="50%">Tanggal:<br/><br/></td>
              </tr>';
    $html .= '<tr nobr="true"><td colspan="2">Jenis Telaah Amandemen:<br/><span style="font-family: zapfdingbats;">&#114;</span> <i>Exempted</i> (dikecualikan)<br/><span style="font-family: zapfdingbats;">&#114;</span> <i>Expedited</i> (perubahan kecil)<br/><span style="font-family: zapfdingbats;">&#114;</span> <i>Fullboard</i> (risiko tinggi atau protokol awal ditelaah melalui <i>fullboard</i>)</td></tr>';
    $html .= '<tr nobr="true">
                <td width="50%">Nama & Tanda tangan Ketua/Sekretaris '.$nama_kepk.':<br/><br/></td>
                <td width="50%">Tanggal:<br/><br/></td>
              </tr>';
    $html .= '<tr nobr="true"><td colspan="2">Kesimpulan rapat:<br/><span style="font-family: zapfdingbats;">&#114;</span> Menyetujui amandemen tanpa perubahan<br/><span style="font-family: zapfdingbats;">&#114;</span> Perlu perbaikan/perubahan amandemen/dokumen Persetujuan Setelah Penjelasan<br/><span style="font-family: zapfdingbats;">&#114;</span> Tidak menyetujui amandemen</td></tr>';
    $html .= '</table>';

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');
    
    //Close and output PDF document
    $pdf->Output('permohonan-usulan.pdf', 'I');
  }

  public function cetak_memorandum_penghentian($id_pep=0)
  {
    $this->load->library('Pdf');

    // create new PDF document
    $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('E-Protokol');
    $pdf->SetTitle('Memoradum Penghentian Penelitian');
    $pdf->SetSubject('Memoradum Penghentian Penelitian');

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
    $pdf->SetFont('times', '', 10);

    // add a page
    $pdf->AddPage();

    $data_protokol = $this->data_model->get_data_protokol_by_id_pep($id_pep);
    $nama_kepk = substr($data_protokol['nama_kepk'], 0, 3) == 'KEP' ? $data_protokol['nama_kepk'] : 'KEPK '.$data_protokol['nama_kepk'];

    $html = '<table>';
    $html .= '<tr>
                <td width="70%"></td>
                <td width="30%" style="border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black;"> <b>Lampiran 22:</b></td>
              </tr>';
    $html .= '<tr>
                <td width="70%"></td>
                <td width="30%" style="border-left: 1px solid black; border-right: 1px solid black;"> Formulir 01/POB 019</td>
              </tr>';
    $html .= '<tr>
                <td width="70%"></td>
                <td width="30%" style="border-bottom: 1px solid black; border-left: 1px solid black; border-right: 1px solid black;"> Memoradum Penghentian Penelitian</td>
              </tr>';
    $html .= '</table>';

    $pdf->writeHTML($html, true, false, true, false, '');

    $html = '<p align="center"><h3>Memoradum Penghentian Penelitian</h3></p>';
    $html .= '<table border="1" cellpadding="5">';
    $html .= '<tr nobr="true">
                <td width="50%" colspan="2">No. Protokol: '.$data_protokol['no_protokol'].'</td>
                <td width="50%" colspan="2">No. Persetujuan Etik:<br/><br/></td>
              </tr>';
    $html .= '<tr nobr="true">
                <td colspan="4">Judul Penelitian: '.$data_protokol['judul'].'</td>
              </tr>';
    $html .= '<tr nobr="true">
                <td width="20%">Peneliti Utama:</td>
                <td width="80%" coslpan="3"></td>
              </tr>';
    $html .= '<tr nobr="true">
                <td width="20%">Telepon:</td>
                <td width="30%"></td>
                <td width="20%"><i>e-mail</i>:</td>
                <td width="30%"></td>
              </tr>';
    $html .= '<tr nobr="true">
                <td width="20%">Institusi:</td>
                <td width="80%" coslpan="3"></td>
              </tr>';
    $html .= '<tr nobr="true">
                <td width="20%">Sponsor:</td>
                <td width="80%" coslpan="3"></td>
              </tr>';
    $html .= '<tr nobr="true">
                <td width="20%">Tanggal persetujuan:</td>
                <td width="30%"></td>
                <td width="20%">Tanggal laporan terakhir:</td>
                <td width="30%"></td>
              </tr>';
    $html .= '<tr nobr="true">
                <td width="20%">Tanggal mulai:</td>
                <td width="30%"></td>
                <td width="20%">Tanggal penghentian:<br/></td>
                <td width="30%"></td>
              </tr>';
    $html .= '<tr nobr="true">
                <td width="20%">Jumlah subyek:</td>
                <td width="30%"></td>
                <td width="20%">Jumlah yang mendaftar:</td>
                <td width="30%"></td>
              </tr>';
    $html .= '<tr nobr="true">
                <td width="20%">Ringkasan hasil:</td>
                <td width="80%" coslpan="3"><br/><br/><br/><br/><br/></td>
              </tr>';
    $html .= '<tr nobr="true">
                <td width="20%">Data akhir/ Aktual data:<br/></td>
                <td width="80%" coslpan="3"></td>
              </tr>';
    $html .= '<tr nobr="true">
                <td width="20%">Tanda tangan Ketua Pelaksana:</td>
                <td width="30%"><br/><br/><br/><br/><br/></td>
                <td width="20%">Tgl:</td>
                <td width="30%"><br/><br/><br/><br/><br/></td>
              </tr>';
    $html .= '</table>';

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');
    
    //Close and output PDF document
    $pdf->Output('memorandum-penghentian.pdf', 'I');
  }

  function cetak_laporan_ktd_serius($id_pep=0)
  {
    $this->load->library('Pdf');

    // create new PDF document
    $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('E-Protokol');
    $pdf->SetTitle('Laporan KTD Serius/SAE');
    $pdf->SetSubject('Laporan KTD Serius/SAE');

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
    $pdf->SetFont('times', '', 10);

    // add a page
    $pdf->AddPage();

    $data_kop = $this->data_model->get_data_kop_surat();
    $data_protokol = $this->data_model->get_data_protokol_by_id_pep($id_pep);
    $versi = $data_protokol['revisi_ke']+1;

    $html = '<table>';
    $html .= '<tr>
                <td width="70%"></td>
                <td width="30%" style="border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black;"> <b>Lampiran 29:</b></td>
              </tr>';
    $html .= '<tr>
                <td width="70%"></td>
                <td width="30%" style="border-left: 1px solid black; border-right: 1px solid black;"> Formulir 01/POB 027</td>
              </tr>';
    $html .= '<tr>
                <td width="70%"></td>
                <td width="30%" style="border-bottom: 1px solid black; border-left: 1px solid black; border-right: 1px solid black;"> Laporan KTD Serius/SAE</td>
              </tr>';
    $html .= '</table>';

    $pdf->writeHTML($html, true, false, true, false, '');

    if (isset($data_kop['file_name']) && file_exists('./uploads/'.$data_kop['file_name']))
      $pdf->writeHTMLCell(210, '', 0, 30, '<img src="./uploads/'.$data_kop['file_name'].'">', 0, 1, false, true, 'L', false);

    $html = '<p align="center"><h3>LAPORAN KTD SERIUS / SAE</h3></p>';
    $html .= '<table border="1" cellpadding="5">';
    $html .= '<tr nobr="true">
                <td width="50%" colspan="2">Tanggal Masuk:</td>
                <td width="50%" colspan="2">No. Protokol: '.$data_protokol['no_protokol'].'</td>
              </tr>';
    $html .= '<tr nobr="true">
                <td colspan="4">Peneliti Utama:</td>
              </tr>';
    $html .= '<tr nobr="true">
                <td colspan="4">Nama & ttd yg menyerahkan:</td>
              </tr>';
    $html .= '<tr nobr="true">
                <td colspan="4">No. Surat Pengantar & Tanggal:</td>
              </tr>';
    $html .= '<tr nobr="true">
                <td colspan="4">Hal:</td>
              </tr>';
    $html .= '<tr nobr="true">
                <td colspan="4">Institusi, alamat:</td>
              </tr>';
    $html .= '<tr nobr="true">
                <td width="20%">Judul Penelitian:<br/>Versi:</td>
                <td colspan="3" width="80%">'.$data_protokol['judul'].'<br/>'.$versi.'</td>
              </tr>';
    $html .= '<tr nobr="true">
                <td colspan="2" width="50%">Nama produk uji:</td>
                <td width="20%">Tgl lapor:</td><td width="30%"></td>
              </tr>';
    $html .= '<tr nobr="true">
                <td colspan="2" width="50%">Sponsor:</td>
                <td width="20%"><span style="font-family: zapfdingbats;">&#114;</span> awal 1</td>
                <td width="30%"><span style="font-family: zapfdingbats;">&#114;</span> Tindak lanjut</td>
              </tr>';
    $html .= '<tr nobr="true">
                <td colspan="2" width="50%">Inisial subyek/nomor:</td>
                <td width="20%">Tgl kejadian:</td><td width="30%"></td>
              </tr>';
    $html .= '<tr nobr="true">
                <td colspan="2" width="50%">Riwayat subyek:</td>
                <td width="20%">Tgl pertama menggunakan:</td><td width="30%"></td>
              </tr>';
    $html .= '<tr nobr="true">
                <td colspan="2" width="50%">Hasil uji laboratorium:</td>
                <td width="20%">Umur:</td>
                <td width="30%"><span style="font-family: zapfdingbats;">&#114;</span> Laki-laki<br/><span style="font-family: zapfdingbats;">&#114;</span> Perempuan</td>
              </tr>';
    $html .= '<tr nobr="true">
                <td colspan="2" width="50%">Lokasi terjadinya KTD Serius<br/><span style="font-family: zapfdingbats;">&#114;</span> <i>On site</i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-family: zapfdingbats;">&#114;</span> <i>Off site</i></td>
                <td colspan="2" width="50%">Terapi/perlakuan:<br/>Hasil terapi <span style="font-family: zapfdingbats;">&#114;</span> berhasil &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-family: zapfdingbats;">&#114;</span> sedang berjalan</td>
              </tr>';
    $html .= '<tr nobr="true">
                <td colspan="2" width="50%">KTD Serius:</td>
                <td colspan="2" width="50%">KTD yang terjadi:<br/><span style="font-family: zapfdingbats;">&#114;</span> Diperlakukan sebelumnya<br/><span style="font-family: zapfdingbats;">&#114;</span> Tidak diperkirakan sebelumnya</td>
              </tr>';
    $html .= '<tr nobr="true">
                <td colspan="2" width="50%">Keparahan:<br/>
                  <span style="font-family: zapfdingbats;">&#114;</span> Kematian<br/>
                  <span style="font-family: zapfdingbats;">&#114;</span> Mengancam hidup<br/>
                  <span style="font-family: zapfdingbats;">&#114;</span> Perawatan <span style="font-family: zapfdingbats;">&#114;</span> awal <span style="font-family: zapfdingbats;">&#114;</span> perpanjangan<br/>
                  <span style="font-family: zapfdingbats;">&#114;</span> Kecacatan/ketidakmampuan<br/>
                  <span style="font-family: zapfdingbats;">&#114;</span> Kelainan bawaan<br/>
                  <span style="font-family: zapfdingbats;">&#114;</span> Lain-lain
                </td>
                <td colspan="2" width="50%">Hubungan dengan: <span style="font-family: zapfdingbats;">&#114;</span>obat <span style="font-family: zapfdingbats;">&#114;</span>alat <span style="font-family: zapfdingbats;">&#114;</span>studi<br/>
                  <span style="font-family: zapfdingbats;">&#114;</span> Tidak berhubungan<br/>
                  <span style="font-family: zapfdingbats;">&#114;</span> Mungkin<br/>
                  <span style="font-family: zapfdingbats;">&#114;</span> Sangat mungkin<br/>
                  <span style="font-family: zapfdingbats;">&#114;</span> Pasti berhubungan<br/>
                  <span style="font-family: zapfdingbats;">&#114;</span> Tidak diketahui
                </td>
              </tr>';
    $html .= '<tr nobr="true">
                <td colspan="2" width="50%">Rekomendasi mengubah protokol?<br/>Rekomendasi mengubah naskah penjelasan?</td>
                <td colspan="2" width="50%"><span style="font-family: zapfdingbats;">&#114;</span> tidak <span style="font-family: zapfdingbats;">&#114;</span> ya, lampirkan proposal<br/><span style="font-family: zapfdingbats;">&#114;</span> tidak <span style="font-family: zapfdingbats;">&#114;</span> ya, lampirkan proposal</td>
              </tr>';
    $html .= '</table>';

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');
    
    //Close and output PDF document
    $pdf->Output('laporan-ktd-serius.pdf', 'I');
  }

  function cetak_catatan_penyimpangan($id_pep=0)
  {
    $this->load->library('Pdf');

    // create new PDF document
    $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('E-Protokol');
    $pdf->SetTitle('Catatan Penyimpangan/Ketidakpatuhan/Pelanggaran');
    $pdf->SetSubject('Catatan Penyimpangan/Ketidakpatuhan/Pelanggaran');

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
    $pdf->SetFont('times', '', 10);

    // add a page
    $pdf->AddPage();

    $data_kop = $this->data_model->get_data_kop_surat();
    $data_protokol = $this->data_model->get_data_protokol_by_id_pep($id_pep);
    $nama_kepk = substr($data_protokol['nama_kepk'], 0, 3) == 'KEP' ? $data_protokol['nama_kepk'] : 'KEPK '.$data_protokol['nama_kepk'];

    $html = '<table>';
    $html .= '<tr>
                <td width="50%"></td>
                <td width="50%" style="border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black;"> <b>Lampiran 30:</b></td>
              </tr>';
    $html .= '<tr>
                <td width="50%"></td>
                <td width="50%" style="border-left: 1px solid black; border-right: 1px solid black;"> Formulir 01/POB 028</td>
              </tr>';
    $html .= '<tr>
                <td width="50%"></td>
                <td width="50%" style="border-bottom: 1px solid black; border-left: 1px solid black; border-right: 1px solid black;"> Catatan Penyimpangan/Ketidakpatuhan/Pelanggaran</td>
              </tr>';
    $html .= '</table>';

    $pdf->writeHTML($html, true, false, true, false, '');

    if (isset($data_kop['file_name']) && file_exists('./uploads/'.$data_kop['file_name']))
      $pdf->writeHTMLCell(210, '', 0, 30, '<img src="./uploads/'.$data_kop['file_name'].'">', 0, 1, false, true, 'L', false);

    $html = '<p align="center"><h3>CATATAN PENYIMPANGAN / KETIDAK PATUHAN / PELANGGARAN</h3></p>';
    $html .= '<table border="1" cellpadding="5">';
    $html .= '<tr nobr="true">
                <td width="60%">No. Protokol: '.$data_protokol['no_protokol'].'</td>
                <td width="40%">Tgl Persetujuan Etik:</td>
              </tr>';
    $html .= '<tr nobr="true">
                <td colspan="2">Judul Penelitian: '.$data_protokol['judul'].'</td>
              </tr>';
    $html .= '<tr nobr="true">
                <td width="60%">Peneliti:</td>
                <td width="40%">No. telp:</td>
              </tr>';
    $html .= '<tr nobr="true">
                <td width="60%">Institusi:</td>
                <td width="40%">No. telp:</td>
              </tr>';
    $html .= '<tr nobr="true">
                <td width="60%">Sponsor:</td>
                <td width="40%">No. telp:</td>
              </tr>';
    $html .= '<tr nobr="true">
                <td width="50%" align="center" style="border-left-color: black;border-bottom-color: white">Penyimpangan dari protokol</td>
                <td width="50%" align="left" style="border-right-color: black;border-bottom-color: white">Ketidakpatuhan</td>
              </tr>';
    $html .= '<tr nobr="true">
                <td width="50%" align="right" style="border-left-color: black;border-top-color: white">Pelanggaran Besar<br/></td>
                <td width="50%" align="left" style="border-right-color: black;border-top-color: white">Kecil<br/></td>
              </tr>';
    $html .= '<tr nobr="true">
                <td colspan="2">Penjelasan:<br/><br/><br/></td>
              </tr>';
    $html .= '<tr nobr="true">
                <td colspan="2">Keputusan '.$nama_kepk.':<br/><br/><br/></td>
              </tr>';
    $html .= '<tr nobr="true">
                <td width="50%">Tindakan yang diambil:<br/><br/></td>
                <td width="50%">Hasil:<br/><br/></td>
              </tr>';
    $html .= '<tr nobr="true">
                <td width="50%">Ditemukan oleh:<br/>Tanggal:<br/></td>
                <td width="50%">Dilaporkan oleh:<br/>Tanggal:<br/></td>
              </tr>';
    $html .= '</table>';

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');
    
    //Close and output PDF document
    $pdf->Output('catatan-penyimpangan.pdf', 'I');
  }

/*   public function download($file_name, $client_name)
  {
    $this->load->helper('download');

    $pathfile = './uploads/'.$file_name;
    $data = file_get_contents($pathfile);

    force_download(urldecode(rawurldecode($client_name)), $data);
  }
 */
}
?>