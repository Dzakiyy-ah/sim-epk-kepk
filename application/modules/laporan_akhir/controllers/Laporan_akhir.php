<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_akhir extends Userpage_Controller {

  public function __construct()
  {
    parent::__construct();

    $this->load->model('Laporan_akhir_model', 'data_model');
  }
 
  public function index()
  {
    $data['title'] = APPNAME.' - Laporan Akhir';
    $data['page_header'] = 'Daftar Laporan Akhir';
    $data['breadcrumb'] = 'Daftar Laporan Akhir';
    $data['css_content'] = 'laporan_akhir_view_css';
    $data['main_content'] = 'laporan_akhir_view';
    $data['js_content'] = 'laporan_akhir_view_js';
 
    $this->load->view('layout/template', $data);
  }

  public function form($id=0)
  {
    $data['title'] = APPNAME.' - Laporan Akhir';
    $data['page_header'] = 'Form Laporan Akhir';
    $data['breadcrumb'] = 'Form Laporan Akhir';
    $data['css_content'] = 'laporan_akhir_form_css';
    $data['main_content'] = 'laporan_akhir_form';
    $data['js_content'] = 'laporan_akhir_form_js';
    $data['data_protokol'] = $this->data_model->get_data_protokol();
 
    if ($id > 0)
    {
      $data['data'] = $this->data_model->get_data_by_id($id);
      $data['dokumen'] = $this->data_model->get_data_fileupload_by_id($id);
    }

    $this->load->view('layout/template', $data);
  }

  public function detail($id=0)
  {
    $data['title'] = APPNAME.' - Laporan Akhir';
    $data['page_header'] = 'Detail Laporan Akhir';
    $data['breadcrumb'] = 'Detail Laporan Akhir';
    $data['css_content'] = 'laporan_akhir_detail_css';
    $data['main_content'] = 'laporan_akhir_detail';
    $data['js_content'] = 'laporan_akhir_detail_js';
 
    if ($id > 0)
    {
      $data['data'] = $this->data_model->get_data_detail_by_id($id);
      $data['dokumen'] = $this->data_model->get_data_fileupload_by_id($id);
    }

    $this->load->view('layout/template', $data);
  }

  public function validation_form()
  {
    $this->form_validation->set_rules('id_pep', 'Nomor Protokol', 'trim|required|is_natural_no_zero');

    $this->form_validation->set_message('required', '{field} tidak boleh kosong');
    $this->form_validation->set_message('is_natural_no_zero', '{field} tidak boleh kosong');
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
          'id' => $result[$i]['id_laporan_akhir'],
          'no_protokol' => $result[$i]['no_protokol'],
          'judul' => $result[$i]['judul'],
          'kepk' => $result[$i]['nama_kepk'],
          'tgl_laporan_akhir' => date('d/m/Y', strtotime($result[$i]['tanggal_laporan_akhir'])),
        );
      }
    }
    
    echo json_encode($response);
  }

  function get_fileupload_by_id($id=0)
  {
    $result = $this->data_model->get_data_fileupload_by_id($id);

    $response = (object) NULL;
    $response->data = array();
    if ($result){
      for($i=0; $i<count($result); $i++){
        $response->data[] = array(
          'id' => $result[$i]['id_lad'],
          'deskripsi' => $result[$i]['deskripsi'],
          'file_name' => $result[$i]['file_name'],
          'client_name' => $result[$i]['client_name'],
          'file_size' => $result[$i]['file_size'],
          'file_type' => $result[$i]['file_type'],
          'file_ext' => $result[$i]['file_ext']
        );
      }
    }
    
    echo json_encode($response->data);
  }

  function get_protokol()
  {
    $result = $this->data_model->get_data_protokol();

    $response = (object) NULL;
    $response->data = array();
    if ($result){
      for($i=0; $i<count($result); $i++){
        $response->data[] = array(
          'id_pep' => $result[$i]['id_pep'],
          'no' => $result[$i]['no_protokol'],
          'judul' => $result[$i]['judul']
        );
      }
    }

    echo json_encode($response->data);
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
    $config['allowed_types'] = 'pdf|png|jpg|jpeg';
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

  public function download($file_name, $client_name)
  {
    $this->load->helper('download');

    $pathfile = './uploads/'.$file_name;
    $data = file_get_contents($pathfile);
    $client_name = urldecode(rawurldecode($client_name));

    force_download($client_name, $data);
  }

}
