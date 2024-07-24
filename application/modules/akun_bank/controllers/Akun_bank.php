<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akun_bank extends CI_Controller {

  public function __construct()
  {
    parent::__construct();

    $this->load->model('Akun_bank_model', 'data_model');
  }
 
  public function index()
  {
    $data['title'] = APPNAME.' - Akun Bank';
    $data['page_header'] = 'Akun Bank';
    $data['breadcrumb'] = 'Akun Bank';
    $data['data'] = $this->data_model->get_data();

    if ( $this->session->userdata('is_login_'.APPAUTH) == TRUE && $this->session->userdata('id_group_'.APPAUTH) == 2 )
    {
      $data['css_content'] = 'akun_bank_admin_view_css';
      $data['main_content'] = 'akun_bank_admin_view';
      $data['js_content'] = 'akun_bank_admin_view_js';

      $this->load->view('layout/template', $data);
    }
    else
    {
      $data['data_tarif'] = $this->data_model->get_data_tarif_telaah();
      $data['css_content'] = 'akun_bank_view_css';
      $data['main_content'] = 'akun_bank_view';
      $data['js_content'] = 'akun_bank_view_js';

      $this->load->view('layout/template_web', $data);
    }
  }

  public function validation_form()
  {
    $this->form_validation->set_rules('nama_bank', 'Nama Bank', 'trim|required|max_length[100]');
    $this->form_validation->set_rules('no_rekening', 'No Rekening', 'trim|required|max_length[100]');
    $this->form_validation->set_rules('pemilik_rekening', 'Pemilik Rekening', 'trim|required|max_length[200]');
    $this->form_validation->set_rules('swift_code', 'Swift Code', 'trim|max_length[100]');

    $this->form_validation->set_message('required', '{field} tidak boleh kosong');
    $this->form_validation->set_message('max_length', '{field} tidak boleh melebihi {param} karakter');
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

  function get_tarif_telaah()
  {
    $result = $this->data_model->get_data_tarif_telaah();

    $response = (object) NULL;
    $response->data = array();
    if ($result){
      for($i=0; $i<count($result); $i++){

        switch ($result[$i]['jenis_penelitian']) {
          case 1: $jns_penelitian = 'Observasional'; break;
          case 2: $jns_penelitian = 'Intervensi'; break;
          case 3: $jns_penelitian = 'Uji Klinik'; break;
          default: $jns_penelitian = ''; break;
        }

        switch ($result[$i]['asal_pengusul']) {
          case 1: $asal_pengusul = 'Internal'; break;
          case 2: $asal_pengusul = 'Eksternal'; break;
          default: $asal_pengusul = ''; break;
        }

        switch ($result[$i]['jenis_lembaga']) {
          case 1: $jns_lembaga = 'Pendidikan'; break;
          case 2: $jns_lembaga = 'Rumah Sakit'; break;
          case 3: $jns_lembaga = 'Litbang'; break;
          default: $jns_lembaga = ''; break;
        }

        switch ($result[$i]['status_pengusul']) {
          case 1: $status_pengusul = 'Mahasiswa'; break;
          case 2: $status_pengusul = 'Dosen'; break;
          case 3: $status_pengusul = 'Pelaksana Pelayanan'; break;
          case 4: $status_pengusul = 'Peneliti'; break;
          case 5: $status_pengusul = 'Lainnya'; break;
          default: $status_pengusul = ''; break;
        }

        switch ($result[$i]['strata_pendidikan']) {
          case 1: $strata_pend = 'Diploma III'; break;
          case 2: $strata_pend = 'Diploma IV'; break;
          case 3: $strata_pend = 'S-1'; break;
          case 4: $strata_pend = 'S-2'; break;
          case 5: $strata_pend = 'S-3'; break;
          case 6: $strata_pend = 'Sp-1'; break;
          case 7: $strata_pend = 'Sp-2'; break;
          case 8: $strata_pend = 'Lainnya'; break;
          default: $strata_pend = ''; break;
        }

        $response->data[] = array(
          'id' => $result[$i]['id_tarif_telaah'],
          'jns_penelitian' => $jns_penelitian,
          'asal_pengusul' => $asal_pengusul,
          'jns_lembaga' => $jns_lembaga,
          'status_pengusul' => $status_pengusul,
          'strata_pend' => $strata_pend,
          'tarif' => isset($result[$i]['tarif_telaah']) ? number_format($result[$i]['tarif_telaah'],2,",",".") : ''
        );
      }
    }

    echo json_encode($response->data);
  }

}
