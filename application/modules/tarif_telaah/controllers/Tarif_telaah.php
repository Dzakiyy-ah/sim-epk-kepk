<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tarif_telaah extends Userpage_Controller {

  public function __construct()
  {
    parent::__construct();

    $this->load->model('Tarif_telaah_model', 'data_model');
  }
 
  public function index()
  {
    $data['title'] = APPNAME.' - Tarif/Biaya Telaah';
    $data['page_header'] = 'Tarif/Biaya Telaah';
    $data['breadcrumb'] = 'Tarif/Biaya Telaah';
    $data['css_content'] = 'tarif_telaah_view_css';
    $data['main_content'] = 'tarif_telaah_view';
    $data['js_content'] = 'tarif_telaah_view_js';

    $this->load->view('layout/template', $data);
  }

  public function form($id=0)
  {
    $data['title'] = APPNAME.' - Tarif/Biaya Telaah';
    $data['page_header'] = 'Form Tarif/Biaya Telaah';
    $data['breadcrumb'] = 'Tarif/Biaya Telaah';
    $data['css_content'] = 'tarif_telaah_form_css';
    $data['main_content'] = 'tarif_telaah_form';
    $data['js_content'] = 'tarif_telaah_form_js';

    if ($id > 0) {
      $data['data'] = $this->data_model->get_data_by_id($id);
    }

    $this->load->view('layout/template', $data);
  }

  public function validation_form()
  {
    $this->form_validation->set_rules('id', 'ID', 'callback_duplikasi_parameter_tarif');
    $this->form_validation->set_rules('jns_penelitian', 'Jenis Penelitian', 'trim|required');
    $this->form_validation->set_rules('asal_pengusul', 'Asal Pengusul', 'trim|required');
    $this->form_validation->set_rules('jns_lembaga', 'Jenis Lembaga Asal Pengusul', 'trim|required');
    $this->form_validation->set_rules('status_pengusul', 'Status Pengusul', 'trim|required');
    $this->form_validation->set_rules('strata_pend', 'Strata Pendidikan Pengusul', 'trim|required');

    $this->form_validation->set_message('required', '{field} tidak boleh kosong');
  }

  function duplikasi_parameter_tarif($id)
  {
    $jns_penelitian = $this->input->post('jns_penelitian');
    $asal_pengusul = $this->input->post('asal_pengusul');
    $jns_lembaga = $this->input->post('jns_lembaga');
    $status_pengusul = $this->input->post('status_pengusul');
    $strata_pend = $this->input->post('strata_pend');

    $result = $this->data_model->cek_duplikasi_parameter_tarif($id, $jns_penelitian, $asal_pengusul, $jns_lembaga, $status_pengusul, $strata_pend);

    if ($result)
    {
      $this->form_validation->set_message('duplikasi_parameter_tarif', 'Tarif/Biaya Telaah untuk parameter (Jenis Penelitian, Asal Pengusul, Jenis Lembaga Asal Pengusul, Status Pengusul, Strata Pendidikan Pengusul) ini sudah ada');
      return FALSE;
    }
    else
    {
      return TRUE;
    }
  }

  public function proses()
  {
    $response = (object)null;

    $oper = $this->input->post('oper');
    if ($oper == 'del')
      return $this->hapus();

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
          'id' => $result[$i]['id_tarif_telaah'],
          'jns_penelitian' => $result[$i]['jenis_penelitian'],
          'asal_pengusul' => $result[$i]['asal_pengusul'],
          'jns_lembaga' => $result[$i]['jenis_lembaga'],
          'status_pengusul' => $result[$i]['status_pengusul'],
          'strata_pend' => $result[$i]['strata_pendidikan'],
          'tarif' => isset($result[$i]['tarif_telaah']) ? number_format($result[$i]['tarif_telaah'],2,",",".") : ''
        );
      }
    }

    echo json_encode($response);
  }

  function hapus()
  {
    $response = (object)null;

    $id = $this->input->post('id');
    $delete = $this->data_model->delete_data($id);
    if ($delete)
    {
      $response->isSuccess = TRUE;
      $response->message = 'Data berhasil dihapus';
    }
    else
    {
      $response->isSuccess = FALSE;
      $response->message = 'Data gagal dihapus';       
    }

    echo json_encode($response);
  }

}
