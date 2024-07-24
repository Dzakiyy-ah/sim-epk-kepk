<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Putusan_fullboard extends Userpage_Controller {

  public function __construct()
  {
    parent::__construct();

    $this->load->model('Putusan_fullboard_model', 'data_model');
  }
 
  public function index()
  {
    $data['title'] = APPNAME.' - Putusan Telaah Full Board';
    $data['page_header'] = 'Daftar Putusan Telaah Full Board';
    $data['breadcrumb'] = 'Putusan Telaah Full Board';
    $data['css_content'] = 'putusan_fullboard_view_css';
    $data['main_content'] = 'putusan_fullboard_view';
    $data['js_content'] = 'putusan_fullboard_view_js';
    $data['protokol'] = $this->data_model->get_data_protokol();

    $this->load->view('layout/template', $data);
  }

  public function form($id=0, $id_pep=0)
  {
    $pengajuan = $this->data_model->get_data_pengajuan_by_idpep($id_pep);

    $data['title'] = APPNAME.' - Putusan Telaah Full Board';
    $data['page_header'] = $pengajuan['revisi_ke'] > 0 ? 'Form Putusan Telaah Full Board (Perbaikan)' : 'Form Putusan Telaah Full Board';
    $data['breadcrumb'] = 'Putusan Telaah Full Board';
    $data['css_content'] = 'putusan_fullboard_form_css';
    $data['main_content'] = 'putusan_fullboard_form';
    $data['js_content'] = 'putusan_fullboard_form_js';
    $data['pengajuan'] = $pengajuan;
    $data['id_pep'] = $id_pep;
    $data['fullboard'] = $this->data_model->get_data_pemberitahuan_fullboard_by_idpep($id_pep);

    if ($id > 0){
      $data['data'] = $this->data_model->get_data_by_id($id);
      $data['is_kirim'] = $this->data_model->check_is_kirim($id_pep);
      $this->session->set_userdata(array('keputusan'=>$data['data']['keputusan']));
    }

    $this->load->view('layout/template', $data);
  }

  public function validation_form()
  {
    $this->form_validation->set_rules('id_pep', 'Protokol', 'callback_is_kirim');

    if ($this->session->userdata('id_group_'.APPAUTH) == 4 || $this->session->userdata('id_group_'.APPAUTH) == 7 || $this->session->userdata('id_group_'.APPAUTH) == 8)
      $this->form_validation->set_rules('id_pep', 'Protokol', 'callback_is_save_ketua_wakil_ketua');

    $this->form_validation->set_rules('keputusan', 'Keputusan', 'trim|required');

    $this->form_validation->set_message('required', '{field} belum dipilih.');
  }

  function is_kirim($id_pep)
  {
    $result = $this->data_model->check_is_kirim($id_pep);

    if ($result == 1)
    {
      $this->form_validation->set_message('is_kirim', 'Protokol tidak bisa diubah lagi karena sudah dikirim');
      return FALSE;
    }
    else
    {
      return TRUE;
    }
  }

  function is_save_ketua_wakil_ketua($id_pep)
  {
    $result = $this->data_model->check_is_save_ketua_waketua($id_pep);

    if ($result !== '')
    {
      $this->form_validation->set_message('is_save_ketua_wakil_ketua', 'Protokol telah dibuat putusan oleh '.$result);
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

  function kirim($id_pep, $keputusan, $no_protokol)
  {
    $response = (object)null;

    $check_is_kirim = $this->data_model->check_is_kirim($id_pep);

    if ($check_is_kirim == 1)
    {
      $response->isSuccess = FALSE;
      $response->message = 'Data sudah dikirim';       
    }
    else
    {
      $check_is_save = $this->data_model->check_is_save($id_pep);

      if ($check_is_save)
      {
        $success = $this->data_model->kirim_data($id_pep, $keputusan, $no_protokol);
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
      }
      else
      {
        $response->isSuccess = FALSE;
        $response->message = 'Simpan data sebelum kirim';
      }
    }

    echo json_encode($response);
  }

  public function get_daftar1()
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
        if ($result[$i]['revisi_ke'] == 0)
        {
          $response->rows[] = array(
            'id' => $result[$i]['id_pfbd'],
            'id_pep' => $result[$i]['id_pep'],
            'no_protokol' => $result[$i]['no_protokol'],
            'judul' => $result[$i]['judul'],
            'tgl_pengajuan' => date('d/m/Y', strtotime($result[$i]['tanggal_pengajuan'])),
            'kepk' => $result[$i]['nama_kepk'],
            'mulai' => date('d/m/Y', strtotime($result[$i]['waktu_mulai'])),
            'selesai' => date('d/m/Y', strtotime($result[$i]['waktu_selesai'])),
            'tgl_putusan' => date('d/m/Y', strtotime($result[$i]['tanggal_putusan'])),
            'keputusan' => $result[$i]['keputusan']
          );
        }
      }
    }
    
    echo json_encode($response);
  }

  public function get_daftar2()
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
        if ($result[$i]['revisi_ke'] > 0)
        {
          $response->rows[] = array(
            'id' => $result[$i]['id_pfbd'],
            'id_pep' => $result[$i]['id_pep'],
            'no_protokol' => $result[$i]['no_protokol'],
            'judul' => $result[$i]['judul'],
            'tgl_pengajuan' => date('d/m/Y', strtotime($result[$i]['tanggal_pengajuan'])),
            'tgl_perbaikan' => date('d/m/Y', strtotime($result[$i]['tanggal_protokol'])),
            'kepk' => $result[$i]['nama_kepk'],
            'revisi_ke' => $result[$i]['revisi_ke'],
            'mulai' => date('d/m/Y', strtotime($result[$i]['waktu_mulai'])),
            'selesai' => date('d/m/Y', strtotime($result[$i]['waktu_selesai'])),
            'tgl_putusan' => date('d/m/Y', strtotime($result[$i]['tanggal_putusan'])),
            'keputusan' => $result[$i]['keputusan']
          );
        }
      }
    }
    
    echo json_encode($response);
  }

  function get_protokol()
  {
    $result = $this->data_model->get_data_protokol();

    $response = (object) NULL;
    $response->data = array();
    if ($result){
      for($i=0; $i<count($result); $i++){
        $response->data[] = array(
          'id' => isset($result[$i]['id_pfbd']) ? $result[$i]['id_pfbd'] : 0, // untuk halaman sekretaris
          'id_pep' => $result[$i]['id_pep'],
          'no' => $result[$i]['no_protokol'],
          'judul' => $result[$i]['judul'],
          'waktu' => date('d/m/Y H:i:s', strtotime($result[$i]['inserted'])),
          'revisi_ke' => $result[$i]['revisi_ke'],
          'hari_ke' => get_working_days(date('Y-m-d', strtotime($result[$i]['inserted'])), date('Y-m-d'))
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
          'no' => $result[$i]['nomor'],
          'nama' => $result[$i]['nama'],
          'kelayakan' => $result[$i]['kelayakan'],
          'cata' => stripslashes($result[$i]['catatana']),
          'catc' => stripslashes($result[$i]['catatanc']),
          'catd' => stripslashes($result[$i]['catatand']),
          'cate' => stripslashes($result[$i]['catatane']),
          'catf' => stripslashes($result[$i]['catatanf']),
          'catg' => stripslashes($result[$i]['catatang']),
          'cath' => stripslashes($result[$i]['catatanh']),
          'cati' => stripslashes($result[$i]['catatani']),
          'catj' => stripslashes($result[$i]['catatanj']),
          'catk' => stripslashes($result[$i]['catatank']),
          'catl' => stripslashes($result[$i]['catatanl']),
          'catm' => stripslashes($result[$i]['catatanm']),
          'catn' => stripslashes($result[$i]['catatann']),
          'cato' => stripslashes($result[$i]['catatano']),
          'catp' => stripslashes($result[$i]['catatanp']),
          'catq' => stripslashes($result[$i]['catatanq']),
          'catr' => stripslashes($result[$i]['catatanr']),
          'cats' => stripslashes($result[$i]['catatans']),
          'catt' => stripslashes($result[$i]['catatant']),
          'catu' => stripslashes($result[$i]['catatanu']),
          'catv' => stripslashes($result[$i]['catatanv']),
          'catw' => stripslashes($result[$i]['catatanw']),
          'catx' => stripslashes($result[$i]['catatanx']),
          'caty' => stripslashes($result[$i]['catatany']),
          'catz' => stripslashes($result[$i]['catatanz']),
          'cataa' => stripslashes($result[$i]['catatanaa']),
          'catbb' => stripslashes($result[$i]['catatanbb']),
          'catcc' => stripslashes($result[$i]['catatancc']),
          'catlink' => stripslashes($result[$i]['catatan_link_proposal']),
          'catprotokol' => stripslashes($result[$i]['catatan_protokol']),
          'cat1' => stripslashes($result[$i]['catatan_sa1']),
          'cat2' => stripslashes($result[$i]['catatan_sa2']),
          'cat3' => stripslashes($result[$i]['catatan_sa3']),
          'cat4' => stripslashes($result[$i]['catatan_sa4']),
          'cat5' => stripslashes($result[$i]['catatan_sa5']),
          'cat6' => stripslashes($result[$i]['catatan_sa6']),
          'cat7' => stripslashes($result[$i]['catatan_sa7']),
          'cat7standar' => stripslashes($result[$i]['catatan_7standar'])
        );
      }
    }
    
    echo json_encode($response->data);
  }

  function get_telaah_before($id_pep, $id_pengajuan, $catatan, $id_penelaah)
  {
    $result = $this->data_model->get_data_telaah_before($id_pep, $id_pengajuan, $catatan, $id_penelaah);

    $response = (object) NULL;
    $response->jumlah = count($result);
    $response->data = array();
    if ($result){
      for($i=0; $i<count($result); $i++){
        $response->data[] = array(
          'id' => $result[$i]['id_pep'],
          'tgl' => date('d/m/Y', strtotime($result[$i]['inserted'])),
          'kelayakan' => $result[$i]['kelayakan'],
          'catatan' => stripslashes($result[$i]['catatan']),
          'catprotokol' => stripslashes($result[$i]['catatan_protokol']),
          'cat7standar' => stripslashes($result[$i]['catatan_7standar'])
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
          'pil_pelapor' => $result[$i]['pilihan_pelapor'],
          'cat_pelapor' => $result[$i]['catatan'],
          'just_header' => $result[$i]['just_header']
        );
      }
    }
    
    echo json_encode($response->data);
  }

/*  public function hapus()
  {
    $response = (object)null;

    $id = $this->input->post('id');

    $check = $this->data_model->check_exist_data($id);

    if ($check)
    {
      $response->isSuccess = FALSE;
      $response->message = 'Data dipakai di tabel lain';
    }
    else
    {
      $result = $this->data_model->delete_data($id);

      if ($result)
      {
        $response->isSuccess = TRUE;
        $response->message = 'Data tim KEPK berhasil dihapus';
      }
      else
      {
        $response->isSuccess = FALSE;
        $response->message = 'Data tim KEPK gagal dihapus';
      }     
    }
    
    echo json_encode($response);
  }*/

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

    $data_pengajuan = $this->data_model->get_data_pengajuan_by_idpep($id_pep);
    $data_sa = $this->data_model->get_data_standar_kelaikan($id, $id_pep);

    $html = '<table border="0">';
    $html .= '<thead>';
    $html .= '<tr><th align="center"><strong><u>7 STANDAR</u></strong></th></tr>';
    $html .= '<tr><th align="center"><strong>NOMOR PROTOKOL : '.$data_pengajuan['no_protokol'].'</strong></th></tr>';
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
        if ($data_sa[$i]['pilihan_pelapor'] != '')
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
          $html .= '<td width="15%" align="center">'.$data_sa[$i]['pilihan_pelapor'].'</td>';
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
    $pdf->Output('self-assesment.pdf', 'I');
  }

  public function cetak_telaah_fullboard($id_tfbd=0, $id_pep=0)
  {
    $this->load->library('Pdf');

    // create new PDF document
    $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('E-Protokol');
    $pdf->SetTitle('Telaah Full Board');
    $pdf->SetSubject('Telaah Full Board');

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

    $data_pengajuan = $this->data_model->get_data_pengajuan_by_idpep($id_pep);
    $revisi_ke = $data_pengajuan['revisi_ke'];
    $data_telaah = $this->data_model->get_data_telaah_fullboard_by_id_tfbd($id_tfbd);
    $penelaah = isset($data_telaah['nama_penelaah']) ? $data_telaah['nama_penelaah'] : '';
    if (isset($data_telaah['kelayakan']))
    {
      switch($data_telaah['kelayakan'])
      {
        case 'LE': $kelayakan = 'Layak Etik'; break;
        case 'R': $kelayakan = 'Perbaikan'; break;
        default: $kelayakan = '';
      }
    }

    $pdf->writeHTML('<h1>Telaah Full Board</h1><br/>', true, false, true, false, 'C');

    $html = '<table border="0">';

    $html .= '<tr>
                <td width="15%">No. Protokol</td>
                <td width="2%">:</td>
                <td width="85%">'.$data_pengajuan['no_protokol'].'</td>
              </tr>';
    if ($revisi_ke > 0)
    {
      $html .= '<tr>
                  <td width="15%">Perbaikan ke</td>
                  <td width="2%">:</td>
                  <td width="85%">'.$revisi_ke.'</td>
                </tr>';
    }
    $html .= '<tr>
                <td width="15%">Judul</td>
                <td width="2%">:</td>
                <td width="85%">'.$data_pengajuan['judul'].'</td>
              </tr>';
    $html .= '<tr>
                <td width="15%">Penelaah</td>
                <td width="2%">:</td>
                <td width="85%">'.$penelaah.'</td>
              </tr>';
    $html .= '<tr>
                <td width="15%">Kelayakan</td>
                <td width="2%">:</td>
                <td width="85%">'.$kelayakan.'</td>
              </tr>';
    $html .= '</table><br/>';

    $pdf->writeHTML($html, true, false, true, false, '');

    $pdf->writeHTML('<h2>Catatan Protokol</h2><hr/>', true, false, true, false, '');
    $pdf->writeHTML(isset($data_telaah['catatan_protokol']) ? stripslashes($data_telaah['catatan_protokol']) : '', true, false, true, false, '');
    $pdf->writeHTML('<h2>Catatan 7 Standar</h2><hr/>', true, false, true, false, '');
    $pdf->writeHTML(isset($data_telaah['catatan_7standar']) ? $data_telaah['catatan_7standar'] : '', true, false, true, false, '');

    //Close and output PDF document
    $pdf->Output('telaah-fullboard.pdf', 'I');
  }

}
?>