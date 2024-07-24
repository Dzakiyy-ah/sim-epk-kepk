<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Struktur_tim extends Userpage_Controller {

  var $API ="";

  public function __construct()
  {
    parent::__construct();

    $this->API = APISERVER;
    $this->load->library('curl');

    $this->load->model('Struktur_tim_model', 'data_model');
  }
  
  public function index()
  {
    $data['title'] = APPNAME.' - Struktur Tim KEPK';
    $data['page_header'] = 'Struktur Tim KEPK';
    $data['breadcrumb'] = 'Struktur Tim KEPK';
    $data['css_content'] = 'struktur_tim_view_css';
    $data['main_content'] = 'struktur_tim_view';
    $data['js_content'] = 'struktur_tim_view_js';
 
    $this->load->view('layout/template', $data);
  }

  public function lihat($id=0)
  {
    $data['title'] = APPNAME.' - Detail Tim KEPK';
    $data['page_header'] = 'Detail Struktur Tim KEPK';
    $data['breadcrumb'] = 'Struktur Tim KEPK';
    $data['css_content'] = 'struktur_tim_lihat_css';
    $data['main_content'] = 'struktur_tim_lihat';
    $data['js_content'] = 'struktur_tim_lihat_js';

    if ($id > 0)
      $data['data'] = $this->data_model->get_data_by_id($id);

    $this->load->view('layout/template', $data);
    
  }

  function import_data()
  {
    $response = (object)null;

    $kepk = $this->data_model->get_data_kodefikasi_token();
    $nomor_kep = $kepk['kodefikasi'];
    $token = $kepk['token'];
    $data =  json_decode($this->curl->simple_get($this->API.'/struktur_timkep?nomor_kep='.$nomor_kep.'&token='.$token));

    if (count($data) > 0)
    {
      $this->data_model->fill_data_import($data);
      $this->data_model->fill_data_stk_old();
      
      $success = $this->data_model->save_data();
      if ($success)
      {
        $response->isSuccess = TRUE;
        $response->message = 'Data berhasil diimpor';
        $response->message = 'Data berhasil diimpor.<br/>Jumlah Data: '.$this->data_model->jml_data.'<br/>Jumlah Insert: '.$this->data_model->jml_insert.'<br/>Jumlah Update: '.$this->data_model->jml_update;
        $response->jml_data = $this->data_model->jml_data;
        $response->jml_insert = $this->data_model->jml_insert;
        $response->jml_update = $this->data_model->jml_update;

        $data['arr_id_timkep'] = $this->data_model->arr_id_timkep;
        $data['imported'] = 1;
        $update =  $this->curl->simple_put($this->API.'/timkep_is_imported', $data, array(CURLOPT_BUFFERSIZE => 10)); 
      }
      else
      {
        $response->isSuccess = FALSE;
        $response->message = 'Data gagal diimpor';       
        $response->jml_data = 0;
        $response->jml_insert = 0;
        $response->jml_update = 0;
      }
    }
    else
    {
      $response->isSuccess = FALSE;
      $response->message = 'Struktur Tim KEPK tidak ditemukan.';
      $response->jml_data = 0;
      $response->jml_insert = 0;
      $response->jml_update = 0;
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
          'id' => $result[$i]['id_tim_kepk'],
          'periode' => date('d/m/Y', strtotime($result[$i]['periode_awal'])).' s/d '.date('d/m/Y', strtotime($result[$i]['periode_akhir'])),
          'ketua' => $result[$i]['ketua'],
          'aktif_kepk' => $result[$i]['aktif_kepk'],
          'aktif_tim_kepk' => $result[$i]['aktif_tim_kepk']
        );
      }
    }
    
    echo json_encode($response);
  }

  public function get_daftar_struktur_by_id($id)
  {
    $result = $this->data_model->get_data_struktur_tim_kepk_by_id($id);

    $response = (object) NULL;
    $response->data = array();
    if ($result){
      for($i=0; $i<count($result); $i++){
        $response->data[] = array(
          'no' => $i+1,
          'nomor' => $result[$i]['nomor'],
          'nama' => $result[$i]['nama'],
          'jabatan' => $result[$i]['jabatan']
        );
      }
    }

    echo json_encode($response->data);
  }

  public function hapus()
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
        $response->message = 'Data berhasil dihapus';

        $data['arr_id_timkep'] = array($this->data_model->id_timkep_del);
        $data['imported'] = 0;
        $update =  $this->curl->simple_put($this->API.'/timkep_is_imported', $data, array(CURLOPT_BUFFERSIZE => 10)); 
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
