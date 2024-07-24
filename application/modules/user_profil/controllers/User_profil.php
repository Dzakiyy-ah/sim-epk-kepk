<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_profil extends Userpage_Controller {

  public function __construct()
  {
    parent::__construct();

    $this->load->model('User_profil_model', 'data_model');
  }
 
  public function index()
  {
    $data['title'] = APPNAME.' - User Profil';
    $data['page_header'] = 'User Profil';
    $data['breadcrumb'] = 'User Profil';
    $data['css_content'] = 'user_profil_view_css';
    $data['main_content'] = 'user_profil_view';
    $data['js_content'] = 'user_profil_view_js';
    $data['data'] = $this->data_model->get_data();
 
    $this->load->view('layout/template', $data);
  }

  public function form_password($id_user)
  {
    $data['title'] = APPNAME.' - Ganti Password';
    $data['page_header'] = 'User Profil';
    $data['breadcrumb'] = 'User Profil';
    $data['subheader'] = 'Ganti Password';
    $data['css_content'] = 'user_password_form_css';
    $data['main_content'] = 'user_password_form';
    $data['js_content'] = 'user_password_form_js';
 
    $this->load->view('layout/template', $data);
  }

  public function validation_form_password()
  {
    $this->form_validation->set_rules('passw_lama', 'Password Lama', 'trim|required|callback_valid_password');
    $this->form_validation->set_rules('passw_baru1', 'Password Baru', 'trim|required');
    $this->form_validation->set_rules('passw_baru2', 'Konfirmasi Password Baru', 'trim|required|matches[passw_baru1]');

    $this->form_validation->set_message('required', '{field} tidak boleh kosong');
    $this->form_validation->set_message('matches', '{field} harus sama');
  }

  function valid_password($str)
  {
    $id = $this->session->userdata('id_user_'.APPAUTH);
    $result = $this->data_model->check_valid_password($id, $str);

    if (!$result)
    {
      $this->form_validation->set_message('valid_password', '{field} tidak sesuai');
      return FALSE;
    }
    else
    {
      return TRUE;
    }

  }

  public function proses_password()
  {
    $response = (object)null;

    $this->load->library('form_validation');
    $this->validation_form_password();

    if ($this->form_validation->run() == TRUE)
    {
      $this->data_model->fill_data_password();
      $success = $this->data_model->save_data_password();
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
      $response->sql = $this->db->queries;
    }

    echo json_encode($response);
  }

}
