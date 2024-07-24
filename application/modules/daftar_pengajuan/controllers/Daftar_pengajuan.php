<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daftar_pengajuan extends CI_Controller {

  public function __construct()
  {
    parent::__construct();

    $this->load->model('Daftar_pengajuan_model', 'data_model');
  }
 
  public function index()
  {
    $data['title'] = APPNAME.' - Pengajuan Protokol Etik Penelitian';
    $data['page_header'] = 'Pengajuan Protokol Etik Penelitian';
    $data['breadcrumb'] = 'Pengajuan Protokol Etik Penelitian';
    $data['css_content'] = 'daftar_pengajuan_view_css';
    $data['main_content'] = 'daftar_pengajuan_view';
    $data['js_content'] = 'daftar_pengajuan_view_js';
 
    $this->load->view('layout/template_web', $data);
  }

  function get_daftar()
  {
    $param = array(
      "_search" => $this->input->post('_search'),
      "search_fld" => $this->input->post('searchField'),
      "search_op" => $this->input->post('searchOper'),
      "search_str" => $this->input->post('searchString'),
      "sort_by" => $this->input->post('sidx'),
      "sort_direction" => $this->input->post('sord')
    );

    $count = $this->data_model->get_data($param, TRUE);

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

    $result = $this->data_model->get_data($param);
    $response->page = $page;
    $response->total = $total_pages;
    $response->records = $count;

    if ($result){
      for($i=0; $i<count($result); $i++){
        $response->rows[$i] = array(
          'no_protokol' => $result[$i]['no_protokol'],
          'judul' => $result[$i]['judul'],
          'kepk' => $result[$i]['nama_kepk'],
          'nama_ketua' => $result[$i]['nama_ketua'],
          'tgl_pengajuan' => $result[$i]['tanggal_pengajuan'] == NULL ? '' : date('d/m/Y', strtotime($result[$i]['tanggal_pengajuan'])),
          'klasifikasi' => $result[$i]['klasifikasi'],
          'tgl_keputusan' => $result[$i]['tanggal_keputusan'] == NULL ? '' : date('d/m/Y', strtotime($result[$i]['tanggal_keputusan']))
        );
      }
    }
    
    echo json_encode($response);
  }

}
