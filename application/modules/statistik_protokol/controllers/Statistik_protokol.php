<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Statistik_protokol extends Userpage_Controller {

  public function __construct()
  {
    parent::__construct();

    $this->load->model('Statistik_protokol_model', 'data_model');

  }
 
  public function index()
  {
    $data['title'] = APPNAME.' - Statistik Protokol';
    $data['page_header'] = 'Statistik Protokol';
    $data['breadcrumb'] = 'Statistik Protokol';
    $data['css_content'] = 'statistik_protokol_view_css';
    $data['main_content'] = 'statistik_protokol_view';
    $data['js_content'] = 'statistik_protokol_view_js';
 
    $this->load->view('layout/template', $data);
  }

  function get_statistik_by_periode($periode)
  {
    $response = (object) NULL;

    $response->jenis_penelitian1 = $this->data_model->get_data_jenis_penelitian_by_param($periode, 1);
    $response->jenis_penelitian2 = $this->data_model->get_data_jenis_penelitian_by_param($periode, 2);
    $response->jenis_penelitian3 = $this->data_model->get_data_jenis_penelitian_by_param($periode, 3);
    $response->asal_pengusul1 = $this->data_model->get_data_asal_pengusul_by_param($periode, 1);
    $response->asal_pengusul2 = $this->data_model->get_data_asal_pengusul_by_param($periode, 2);
    $response->jenis_lembaga1 = $this->data_model->get_data_jenis_lembaga_by_param($periode, 1);
    $response->jenis_lembaga2 = $this->data_model->get_data_jenis_lembaga_by_param($periode, 2);
    $response->jenis_lembaga3 = $this->data_model->get_data_jenis_lembaga_by_param($periode, 3);
    $response->status_pengusul1 = $this->data_model->get_data_status_pengusul_by_param($periode, 1);
    $response->status_pengusul2 = $this->data_model->get_data_status_pengusul_by_param($periode, 2);
    $response->status_pengusul3 = $this->data_model->get_data_status_pengusul_by_param($periode, 3);
    $response->status_pengusul4 = $this->data_model->get_data_status_pengusul_by_param($periode, 4);
    $response->status_pengusul5 = $this->data_model->get_data_status_pengusul_by_param($periode, 5);
    $response->strata_pendidikan1 = $this->data_model->get_data_strata_pendidikan_by_param($periode, 1);
    $response->strata_pendidikan2 = $this->data_model->get_data_strata_pendidikan_by_param($periode, 2);
    $response->strata_pendidikan3 = $this->data_model->get_data_strata_pendidikan_by_param($periode, 3);
    $response->strata_pendidikan4 = $this->data_model->get_data_strata_pendidikan_by_param($periode, 4);
    $response->strata_pendidikan5 = $this->data_model->get_data_strata_pendidikan_by_param($periode, 5);
    $response->strata_pendidikan6 = $this->data_model->get_data_strata_pendidikan_by_param($periode, 6);
    $response->strata_pendidikan7 = $this->data_model->get_data_strata_pendidikan_by_param($periode, 7);
    $response->strata_pendidikan8 = $this->data_model->get_data_strata_pendidikan_by_param($periode, 8);

    echo json_encode($response);
  }

}
