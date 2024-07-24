<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kirim_keppkn extends Userpage_Controller {

  var $API ="";

  public function __construct()
  {
    parent::__construct();

    $this->API = APISERVER;
    $this->load->library('curl');

    $this->load->model('Kirim_keppkn_model', 'data_model');
  }
 
  public function index()
  {
    $data['title'] = APPNAME.' - Kirim Protokol ke KEPPKN';
    $data['page_header'] = 'Kirim Protokol ke KEPPKN';
    $data['breadcrumb'] = 'Kirim Protokol ke KEPPKN';
    $data['css_content'] = 'kirim_keppkn_view_css';
    $data['main_content'] = 'kirim_keppkn_view';
    $data['js_content'] = 'kirim_keppkn_view_js';
 
    $this->load->view('layout/template', $data);
  }

  public function validation_form()
  {
    $this->form_validation->set_rules('tgl_awal', 'Tanggal Dari', 'trim|required');
    $this->form_validation->set_rules('tgl_akhir', 'Tanggal Sampai', 'trim|required');

    $this->form_validation->set_message('required', '{field} tidak boleh kosong');
  }

  public function proses()
  {
    $response = (object)null;

    $this->load->library('form_validation');
    $this->validation_form();

    if ($this->form_validation->run() == TRUE)
    {
      $success = array();
      $fail = array();
      $err_msg = array();
      $json_data = '';
      $this->data_model->fill_data();
      $data = $this->data_model->data;

      if (!empty($data))
      {
        $response->isSuccess = FALSE;
        foreach ($data as $key=>$val)
        {
          $no_protokol = $key;
          $value = $val;
          $insert = $this->curl->simple_post($this->API.'/kirim_data_protokol_v2023', $val, array(CURLOPT_BUFFERSIZE => 10));

          if (!empty($insert))
          {
            $json_data = json_decode($insert, true);
            $status = $json_data['status'];
            $message = $json_data['message'];
            if ($status == 'success')
            {
              $this->data_model->save_data_kirim($no_protokol);
              $response->isSuccess = TRUE;
              $response->result[] = $json_data;
              $response->message = 'Pengiriman Pengajuan Protokol selesai';
            }
            else 
            {
              if ($message == 'KEPK tidak ditemukan')
              {
                $response->isSuccess = FALSE;
                $response->message = $message;
                break;
              }
              else if ($message == 'Token tidak valid')
              {
                $response->isSuccess = FALSE;
                $response->message = $message;
                break;
              }
              else
              {
                $response->isSuccess = TRUE;
                $response->result[] = $json_data;
                $response->message = 'Pengiriman Pengajuan Protokol selesai';
              }
            }
          }
        }
      }
      else
      {
        $response->isSuccess = FALSE;
        $response->message = 'Tidak ada data pengajuan yang bisa dikirim.';
      }
    }
    else
    {
      $response->isSuccess = FALSE;
      $response->message = validation_errors();
    }

    echo json_encode($response);
  }

  function get_daftar_protokol_terkirim()
  {
    $param = array(
      "_search" => $this->input->post('_search'),
      "search_fld" => $this->input->post('searchField'),
      "search_op" => $this->input->post('searchOper'),
      "search_str" => $this->input->post('searchString'),
      "sort_by" => $this->input->post('sidx'),
      "sort_direction" => $this->input->post('sord')
    );

    $count = $this->data_model->get_data_protokol_terkirim($param, TRUE);

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

    $result = $this->data_model->get_data_protokol_terkirim($param);
    $response->page = $page;
    $response->total = $total_pages;
    $response->records = $count;

    if ($result){
      for($i=0; $i<count($result); $i++){
        $id = $result[$i]['id_kirim_ke_keppkn'];

        $response->rows[$i] = array(
          'id' => $id,
          'no_protokol' => $result[$i]['no_protokol'],
          'judul' => $result[$i]['judul'],
          'klasifikasi' => $result[$i]['klasifikasi'],
          'tgl_pengajuan' => $result[$i]['tanggal_pengajuan'] == NULL ? '' : date('d/m/Y', strtotime($result[$i]['tanggal_pengajuan'])),
          'tgl_protokol' => $result[$i]['tanggal_protokol'] == NULL ? '' : date('d/m/Y', strtotime($result[$i]['tanggal_protokol'])),
          'tgl_kirim' => $result[$i]['waktu_kirim'] == NULL ? '' : date('d/m/Y', strtotime($result[$i]['waktu_kirim']))
        );
      }
    }
    
    echo json_encode($response);
  }

}
