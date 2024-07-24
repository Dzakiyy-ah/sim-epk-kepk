<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*********************************************************************************************
  SUPER CLASS dari semua Modul
 *********************************************************************************************/
class Core_Controller extends CI_Controller{
  var $data_model;
  var $search_param;
  var $page;
  var $limit;
  var $report_daftar;
  var $message_berhasil_dihapus  = 'Data telah dihapus.';
  var $message_gagal_dihapus  = 'Data tidak bisa dihapus.';

  public function __construct()
  {
    parent::__construct();

    // cek apakah mode maintenance aktif
    // untuk admin, mode maintenance tidak berpengaruh
    $this->maintenance = isset($this->app_config['maintenance']) ? $this->app_config['maintenance'] : '0';
    if ($this->maintenance == '1' )
    {
      if ($this->uri->segment(1)  !== 'admin' && $this->session->userdata('admin') != 1)
      {
        $this->session->sess_destroy();
        $this->load->view('maintenance');
        $this->output->_display();
        die();
      }
    }
  }

  public function index()
  {

  }

  public function get_daftar()
  {
    $this->page = $this->input->post('page') ? $this->input->post('page') : 0; // get the requested page
    $this->limit = $this->input->post('rows') ? $this->input->post('rows') : 0; // get how many rows we want to have into the grid
    $sidx = $this->input->post('sidx') ? $this->input->post('sidx') : ''; // get index row - i.e. user click to sort
    $sord = $this->input->post('sord') ? $this->input->post('sord') : ''; // get the direction if(!$sidx) $sidx =1;

    /* untuk keperluan pencarian */
    $mode  = $this->input->post('m') ? $this->input->post('m') : '';
    $q = $this->input->post('q') ? $this->input->post('q') : '';

    $this->search_param = array (
      "sort_by" => $sidx,
      "sort_direction" => $sord,
      "search_mode" => $mode,
      "q" => $q,
    );
  }

  protected function validasi_form()
  {
    return TRUE;
  }
  
  public function proses()
  {

  }

  public function hapus()
  {

  }

}