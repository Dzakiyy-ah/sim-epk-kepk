<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kepk extends Userpage_Controller {

  public function __construct()
  {
    parent::__construct();

    $this->load->model('Kepk_model', 'data_model');
  }
 
  public function index()
  {
    $data['title'] = APPNAME.' - KEPK';
    $data['page_header'] = 'KEPK';
    $data['breadcrumb'] = 'KEPK';
    $data['css_content'] = 'kepk_view_css';
    $data['main_content'] = 'kepk_view';
    $data['data'] = $this->data_model->get_data_kepk();

    $this->load->view('layout/template', $data);
  }

}
