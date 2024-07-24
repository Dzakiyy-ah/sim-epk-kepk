<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penelaah_etik extends Userpage_Controller {

  public function __construct()
  {
    parent::__construct();

    $this->load->model('Penelaah_etik_model', 'data_model');
  }
 
  public function index()
  {
    $data['title'] = APPNAME.' - Penelaah Etik';
    $data['page_header'] = 'Penelaah Etik';
    $data['breadcrumb'] = 'Penelaah Etik';
    $data['css_content'] = 'penelaah_etik_view_css';
    $data['main_content'] = 'penelaah_etik_view';
    $data['js_content'] = 'penelaah_etik_view_js';
 
    $this->load->view('layout/template', $data);
  }

  function get_daftar_penelaah_etik()
  {
    $param = array(
      "_search" => $this->input->post('_search'),
      "search_fld" => $this->input->post('searchField'),
      "search_op" => $this->input->post('searchOper'),
      "search_str" => $this->input->post('searchString'),
      "sort_by" => $this->input->post('sidx'),
      "sort_direction" => $this->input->post('sord')
    );

    $count = $this->data_model->get_data_penelaah_etik($param, TRUE);

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

    $result = $this->data_model->get_data_penelaah_etik($param);
    $response->page = $page;
    $response->total = $total_pages;
    $response->records = $count;

    if ($result){
      for($i=0; $i<count($result); $i++){
        $response->rows[$i] = array(
          'id' => $result[$i]['id_atk'],
          'nama' => $result[$i]['nama'],
          'kepk' => $result[$i]['nama_kepk'],
          'telaah_awal' => $result[$i]['telaah_awal'],
          'telaah_expedited' => $result[$i]['telaah_expedited'],
          'telaah_fullboard' => $result[$i]['telaah_fullboard']
        );
      }
    }
    
    echo json_encode($response);
  }

}
