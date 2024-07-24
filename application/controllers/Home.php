<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[\AllowDynamicProperties]

class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

    $this->load->model('Home_model', 'data_model');
	}

	public function index()
	{
		$data['title'] = APPNAME.' - Home';
		$data['page_header'] = 'Home';
		$data['jumlah_kepk'] = $this->data_model->get_data_jumlah_kepk();
		$data['jumlah_pengusul'] = $this->data_model->get_data_jumlah_pengusul();

		if ($this->session->userdata('is_login_'.APPAUTH) == TRUE)
      redirect('dashboard');

    $data['main_content'] = 'v_home';

    $this->load->view('layout/template_web', $data);
	}

  public function download($file_name, $client_name)
  {
    $this->load->helper('download');
 
    $pathfile = './manual/'.$file_name;
    $data = file_get_contents($pathfile);

    $client_name = urldecode(rawurldecode($client_name));

    force_download($client_name, $data);
  }

}
