<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_kepk extends CI_Controller {

  var $API ="";

  public function __construct()
  {
    parent::__construct();

    $this->API = APISERVER;
    $this->load->library('curl');

    $this->load->model('Data_kepk_model', 'data_model');
  }
 
  public function index()
  {
    $data['title'] = APPNAME.' - KEPK';
    $data['page_header'] = 'KEPK';
    $data['breadcrumb'] = 'KEPK';
    $data['data'] = $this->data_model->get_data();
    $data['css_content'] = 'data_kepk_view_css';
    $data['main_content'] = 'data_kepk_view';
    $data['js_content'] = 'data_kepk_view_js';
    $data['data'] = $this->data_model->get_data();
 
    $this->load->view('layout/template_web', $data);
  }

  public function validation_form()
  {
    $this->form_validation->set_rules('no_kep', 'Nomor KEPK', 'trim|required');
    $this->form_validation->set_rules('token', 'Token', 'trim|required');

    $this->form_validation->set_message('required', '{field} harus diisi');
  }

  function proses_import()
  {
    $response = (object)null;

    $this->load->library('form_validation');
    $this->validation_form();

    if ($this->form_validation->run() == TRUE)
    {
      $nomor_kep = $this->input->post('no_kep');
      $token = $this->input->post('token');
      $data = json_decode($this->curl->simple_get($this->API.'/kep?nomor_kep='.$nomor_kep.'&token='.$token), true);

      if (!empty($data))
      {
        $this->data_model->fill_data_json($data);
        $success = $this->data_model->save_data();
        if ($success)
        {
          $response->isSuccess = TRUE;
          $response->message = 'Data berhasil diimpor. Anda dapat login dengan username & password yg sama di SIM-EPK KEPPKN. Jika tidak bisa gunakan nomor KEPK sebagai username dan password untuk login.';
        }
        else
        {
          $response->isSuccess = FALSE;
          $response->message = 'Data gagal diimpor';       
        }
      }
      else
      {
        $response->isSuccess = FALSE;
        $response->message = 'Data KEPK dengan nomor <strong><u>"'.$nomor_kep.'"</u></strong> dan token <strong><u>'.$token.'</u></strong> tidak ditemukan.';
      }
    }
    else
    {
      $response->isSuccess = FALSE;
      $response->message = validation_errors();
    }
    
    echo json_encode($response);
  }

  function registrasi($kodefikasi)
  {
    $response = (object)null;

    $nomor_kep = $kodefikasi;
    $token = $this->data_model->get_data_token_by_kodefikasi($kodefikasi);
    $app_version = file_get_contents('version', true);
    $data = array(
      'nomor_kep' => $nomor_kep,
      'token' => $token,
      'app_version' => $app_version
    );

    $insert =  $this->curl->simple_post($this->API.'/register_kep', $data, array(CURLOPT_BUFFERSIZE => 10)); 

    if (!empty($insert))
    {
      $json_data = json_decode($insert, true);

      if (isset($json_data['status']) && $json_data['status'] == 'success')
      {
        $success = $this->data_model->aktifkan_kepk($kodefikasi);

        if ($success)
        {
          $data = isset($json_data['data']) ? $json_data['data'] : '';
          if (!empty($data)){
            $sn = $data['serial_number'];
            file_put_contents('./uploads/sn', $sn);
          }

          $response->isSuccess = TRUE;
          $response->message = 'Registrasi berhasil. KEPK sudah diaktifkan. Gunakan nomor KEPK sebagai username dan password untuk pertama kali login.';
        }
        else
        {
          $response->isSuccess = FALSE;
          $response->message = 'Ada kesalahan proses aktifasi KEPK di aplikasi lokal Anda.';
        }
      }
      else
      {
        $response->isSuccess = FALSE;
        $response->message = isset($json_data['message']) ? $json_data['message'] : 'Registrasi ke SIM-EPK KEPPKN Gagal';
      }
    }

    echo json_encode($response);
  }

  function get_kep($nomor_kep, $token)
  {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $this->API.'/kep?nomor_kep='.$nomor_kep.'&token='.$token);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    $headers = curl_getinfo($ch);
    print_r(curl_error($ch));

    print "Content-Type: " . $headers['content_type'] . "\n";
    print "response: $result\n";
  }

}
