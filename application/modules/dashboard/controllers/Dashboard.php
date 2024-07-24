<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Userpage_Controller {

  public function __construct()
  {
    parent::__construct();

    $this->load->model('Dashboard_model', 'data_model');

  }
 
  public function index()
  {
    $data['title'] = APPNAME.' - Dashboard';
    $data['page_header'] = 'Dashboard';
    $data['breadcrumb'] = 'Dashboard';

    $id_group = $this->session->userdata('id_group_'.APPAUTH);
    switch ($id_group) {
      case 1: 
        $data['main_content'] = 'dashboard_admin_view';
        break;
      
      case 2: 
        $data['main_content'] = 'dashboard_kepk_view';
        break;

      case 3: 
        $data['css_content'] = 'dashboard_pengusul_view_css';
        $data['main_content'] = 'dashboard_pengusul_view';
        $data['js_content'] = 'dashboard_pengusul_view_js';
        break;

      case 4: 
        $data['css_content'] = 'dashboard_sekretaris_view_css';
        $data['main_content'] = 'dashboard_sekretaris_view';
        $data['js_content'] = 'dashboard_sekretaris_view_js';
        break;

      case 5: 
        $data['css_content'] = 'dashboard_sekretariat_view_css';
        $data['main_content'] = 'dashboard_sekretariat_view';
        $data['js_content'] = 'dashboard_sekretariat_view_js';
        break;

      case 6: 
        $data['css_content'] = 'dashboard_penelaah_view_css';
        $data['main_content'] = 'dashboard_penelaah_view';
        $data['js_content'] = 'dashboard_penelaah_view_js';
        break;

      case 7: 
        $data['css_content'] = 'dashboard_ketua_view_css';
        $data['main_content'] = 'dashboard_ketua_view';
        $data['js_content'] = 'dashboard_ketua_view_js';
        break;

      case 8: 
        $data['css_content'] = 'dashboard_waketua_view_css';
        $data['main_content'] = 'dashboard_waketua_view';
        $data['js_content'] = 'dashboard_waketua_view_js';
        break;
    }
 
    $this->load->view('layout/template', $data);
  }

  function get_pembebasan_etik()
  {
    $result = $this->data_model->get_data_pembebasan_etik();

    $response = (object) NULL;
    $response->data = array();
    if ($result){
      for($i=0; $i<count($result); $i++){
        $response->data[] = array(
          'id' => $result[$i]['id_pep'],
          'no' => $result[$i]['no_protokol'],
          'judul' => $result[$i]['judul'],
          'waktu' => date('d/m/Y H:i:s', strtotime($result[$i]['inserted'])),
          'hari_ke' => get_working_days(date('Y-m-d', strtotime($result[$i]['inserted'])), date('Y-m-d'))
        );
      }
    }

    echo json_encode($response->data);
  }

  function get_persetujuan_etik()
  {
    $result = $this->data_model->get_data_persetujuan_etik();

    $response = (object) NULL;
    $response->data = array();
    if ($result){
      for($i=0; $i<count($result); $i++){
        $response->data[] = array(
          'id' => $result[$i]['id_pep'],
          'no' => $result[$i]['no_protokol'],
          'judul' => $result[$i]['judul'],
          'waktu' => date('d/m/Y H:i:s', strtotime($result[$i]['inserted'])),
          'hari_ke' => get_working_days(date('Y-m-d', strtotime($result[$i]['inserted'])), date('Y-m-d'))
        );
      }
    }

    echo json_encode($response->data);
  }

  function get_perbaikan_etik()
  {
    $result = $this->data_model->get_data_perbaikan_etik();

    $response = (object) NULL;
    $response->data = array();
    if ($result){
      for($i=0; $i<count($result); $i++){
        $response->data[] = array(
          'id' => $result[$i]['id_pep'],
          'no' => $result[$i]['no_protokol'],
          'judul' => $result[$i]['judul'],
          'waktu' => date('d/m/Y H:i:s', strtotime($result[$i]['inserted'])),
          'hari_ke' => get_working_days(date('Y-m-d', strtotime($result[$i]['inserted'])), date('Y-m-d'))
        );
      }
    }

    echo json_encode($response->data);
  }

  function get_telaah_pelapor()
  {
    $result = $this->data_model->get_data_telaah_pelapor();

    $response = (object) NULL;
    $response->data = array();
    if ($result){
      for($i=0; $i<count($result); $i++){
        $tim_penelaah = $this->data_model->get_data_tim_penelaah_by_id_pengajuan($result[$i]['id_pengajuan']);
        $anggota = '';
        for ($a=0; $a<count($tim_penelaah); $a++)
        {
          $anggota .= $tim_penelaah[$a]['nama'];

          if ($a < count($tim_penelaah) - 1)
          {
            if ($a == count($tim_penelaah) - 2)
              $anggota .= ' dan ';
            else
              $anggota .= ', ';
          }
        }

        $klasifikasi = $result[$i]['klasifikasi'] == 2 ? 'Expedited' : 'Full Board';
        $response->data[] = array(
          'id' => $result[$i]['id_pep'],
          'no' => $result[$i]['no_protokol'],
          'judul' => $result[$i]['judul'],
          'klasifikasi' => $klasifikasi,
          'anggota' => $anggota
        );
      }
    }

    echo json_encode($response->data);
  }

  function get_putusan_fullboard()
  {
    $result = $this->data_model->get_data_putusan_fullboard();

    $response = (object) NULL;
    $response->data = array();
    if ($result){
      for($i=0; $i<count($result); $i++){
        $response->data[] = array(
          'id' => $result[$i]['id_pep'],
          'no' => $result[$i]['no_protokol'],
          'judul' => $result[$i]['judul'],
          'waktu' => date('d/m/Y H:i:s', strtotime($result[$i]['inserted'])),
          'hari_ke' => get_working_days(date('Y-m-d', strtotime($result[$i]['inserted'])), date('Y-m-d'))
        );
      }
    }

    echo json_encode($response->data);
  }

  function get_pemberitahuan_fullboard()
  {
    $result = $this->data_model->get_data_pemberitahuan_fullboard();

    $response = (object) NULL;
    $response->data = array();
    if ($result){
      for($i=0; $i<count($result); $i++){
        $response->data[] = array(
          'id' => $result[$i]['id_bfbd'],
          'no' => $result[$i]['no_protokol'],
          'judul' => $result[$i]['judul'],
          'tgl_fb' => date('d/m/Y', strtotime($result[$i]['tgl_fullboard'])),
          'jam_fb' => date('H:i', strtotime($result[$i]['jam_fullboard'])),
          'tempat_fb' => $result[$i]['tempat_fullboard'],
          'waktu' => date('d/m/Y H:i:s', strtotime($result[$i]['inserted'])),
          'hari_ke' => get_working_days(date('Y-m-d', strtotime($result[$i]['inserted'])), date('Y-m-d'))
        );
      }
    }

    echo json_encode($response->data);
  }

  function get_protokol_belum_kirim()
  {
    $result = $this->data_model->get_data_protokol_belum_kirim();

    $response = (object) NULL;
    $response->data = array();
    if ($result){
      for($i=0; $i<count($result); $i++){
        if ($this->session->userdata('id_group_'.APPAUTH) == 3)
        {
          $response->data[] = array(
            'id_pengajuan' => $result[$i]['id_pengajuan'],
            'id_pep' => $result[$i]['id_pep'],
            'no' => $result[$i]['no_protokol'],
            'judul' => $result[$i]['judul'],
            'revisi' => $result[$i]['revisi_ke'],
            'klasifikasi' => $result[$i]['klasifikasi']
          );
        }
        else if ($this->session->userdata('id_group_'.APPAUTH) == 6)
        {
          $response->data[] = array(
            'id_pengajuan' => $result[$i]['id_pengajuan'],
            'id_pep' => $result[$i]['id_pep'],
            'no' => $result[$i]['no_protokol'],
            'judul' => $result[$i]['judul'],
            'revisi' => $result[$i]['revisi_ke'],
            'klasifikasi' => $result[$i]['klasifikasi'],
            'keputusan' => $result[$i]['keputusan']
          );
        }
      }
    }

    echo json_encode($response->data);
  }

  public function get_daftar_pengajuan_ditolak()
  {
    $param = array(
      "_search" => $this->input->post('_search'),
      "search_fld" => $this->input->post('searchField'),
      "search_op" => $this->input->post('searchOper'),
      "search_str" => $this->input->post('searchString'),
      "sort_by" => $this->input->post('sidx'),
      "sort_direction" => $this->input->post('sord')
    );

    $count = $this->data_model->get_data_protokol_jqgrid($param, TRUE);

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

    $result = $this->data_model->get_data_protokol_jqgrid($param);
    $response->page = $page;
    $response->total = $total_pages;
    $response->records = $count;

    $response->rows = array();
    if ($result){
      for($i=0; $i<count($result); $i++){
        $response->rows[] = array(
          'id' => $result[$i]['id_pengajuan'],
          'no_protokol' => $result[$i]['no_protokol'],
          'judul' => $result[$i]['judul'],
          'tanggal' => date('d/m/Y', strtotime($result[$i]['tanggal_pengajuan'])),
          'kepk' => $result[$i]['nama_kepk'],
          'alasan_ditolak' => $result[$i]['alasan_ditolak']
        );
      }
    }
    
    echo json_encode($response);
  }

}
