<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peneliti extends Userpage_Controller {

  public function __construct()
  {
    parent::__construct();

    $this->load->model('Peneliti_model', 'data_model');
  }
 
  public function index()
  {
    $data['title'] = APPNAME.' - Peneliti Etik';
    $data['page_header'] = 'Peneliti Etik';
    $data['breadcrumb'] = 'Peneliti Etik';
    $data['css_content'] = 'peneliti_view_css';
    $data['main_content'] = 'peneliti_view';
    $data['js_content'] = 'peneliti_view_js';
 
    $this->load->view('layout/template', $data);
  }

  public function form($id=0)
  {
    $data['title'] = APPNAME.' - Peneliti Etik';
    $data['page_header'] = 'Peneliti Etik';
    $data['breadcrumb'] = 'Peneliti Etik';
    $data['css_content'] = 'peneliti_form_css';
    $data['main_content'] = 'peneliti_form';
    $data['js_content'] = 'peneliti_form_js';

    if ($id > 0){
      $data['data'] = $this->data_model->get_data_by_id($id);
    }

    $this->load->view('layout/template', $data);
  }

  public function proses_password()
  {
    $response = (object)null;

    $aktif_password = $this->input->post('aktif_password');
    $password = trim($this->input->post('password'));

    if ($aktif_password === "true" && $password == '')
    {
      $response->isSuccess = FALSE;
      $response->message = 'Silakan isi password pengganti';
    }
    else
    {
      $this->data_model->fill_data_password();
      $success = $this->data_model->save_data_password();
      if ($success)
      {
        $response->isSuccess = TRUE;

        if ( strlen($password) > 0)
          $response->message = 'Password berhasil diganti';
      }
      else
      {
        $response->isSuccess = FALSE;
        $response->message = 'Password gagal diganti';       
      }
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
          'id' => $result[$i]['id_pengusul'],
          'nomor' => $result[$i]['nomor'],
          'nama' => $result[$i]['nama'],
          'nik' => $result[$i]['nik'],
          'kewarganegaraan' => $result[$i]['kewarganegaraan'],
          'negara' => $result[$i]['negara'],
          'kab' => $result[$i]['nama_kabupaten'],
          'prop' => $result[$i]['nama_propinsi'],
          'telp' => $result[$i]['no_telepon'],
          'hp' => $result[$i]['no_hp'],
          'email' => $result[$i]['email']
        );
      }
    }
    
    echo json_encode($response);
  }

}
