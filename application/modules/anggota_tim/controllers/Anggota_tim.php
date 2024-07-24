<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anggota_tim extends Userpage_Controller {

  var $API ="";

  public function __construct()
  {
    parent::__construct();

    $this->API = APISERVER;
    $this->load->library('curl');

    $this->load->model('Anggota_tim_model', 'data_model');
  }
  
  public function index()
  {
    $data['title'] = APPNAME.' - Anggota Tim KEPK';
    $data['page_header'] = 'Anggota Tim KEPK';
    $data['breadcrumb'] = 'Anggota Tim KEPK';
    $data['css_content'] = 'anggota_tim_view_css';
    $data['main_content'] = 'anggota_tim_view';
    $data['js_content'] = 'anggota_tim_view_js';
 
    $this->load->view('layout/template', $data);
  }

  function import_data()
  {
    $response = (object)null;

    $kepk = $this->data_model->get_data_kodefikasi_token();
    $nomor_kep = $kepk['kodefikasi'];
    $token = $kepk['token'];
    $data =  json_decode($this->curl->simple_get($this->API.'/anggota_timkep?nomor_kep='.$nomor_kep.'&token='.$token));

    if (count($data) > 0)
    {
      $this->data_model->fill_data_import($data);

      $success = $this->data_model->save_data();
      if ($success)
      {
        $response->isSuccess = TRUE;
        $response->message = 'Data berhasil diimpor.<br/>Jumlah Data: '.$this->data_model->jml_data.'<br/>Jumlah Insert: '.$this->data_model->jml_insert.'<br/>Jumlah Update: '.$this->data_model->jml_update;
        $response->jml_data = $this->data_model->jml_data;
        $response->jml_insert = $this->data_model->jml_insert;
        $response->jml_update = $this->data_model->jml_update;

        $data['arr_no_anggota'] = $this->data_model->arr_no_anggota;
        $data['imported'] = 1;
        $update =  $this->curl->simple_put($this->API.'/anggotatimkep_is_imported', $data, array(CURLOPT_BUFFERSIZE => 10)); 
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
      $response->message = 'Data Anggota tidak ditemukan.';
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

    if ($result){
      for($i=0; $i<count($result); $i++){
        $response->rows[$i] = array(
          'id' => $result[$i]['id_atk'],
          'nomor' => $result[$i]['nomor'],
          'nama' => $result[$i]['nama'],
          'nik' => $result[$i]['nik'],
          'email' => $result[$i]['email'],
          'no_telp' => $result[$i]['no_telepon'],
          'no_hp' => $result[$i]['no_hp'],
          'no_sertifikat' => $result[$i]['no_sertifikat_ed_edl']
        );
      }
    }

    echo json_encode($response);
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

        $data['arr_no_anggota'] = array($this->data_model->no_anggota_del);
        $data['imported'] = 0;
        $update =  $this->curl->simple_put($this->API.'/anggotatimkep_is_imported', $data, array(CURLOPT_BUFFERSIZE => 10)); 
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
