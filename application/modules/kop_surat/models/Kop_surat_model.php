<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kop_surat_model extends Core_Model {

	public function __construct()
	{
		parent::__construct();

	}

	public function fill_data()
	{
		$id_kepk = $this->session->userdata('id_kepk');
		$client_name = $this->input->post('client_name') ? $this->input->post('client_name') : '';
		$file_name = $this->input->post('file_name') ? $this->input->post('file_name') : '';
		$file_size = $this->input->post('file_size') ? $this->input->post('file_size') : '';
		$file_type = $this->input->post('file_type') ? $this->input->post('file_type') : '';
		$file_ext = $this->input->post('file_ext') ? $this->input->post('file_ext') : '';

		$this->data = array(
				'id_kepk' => $id_kepk,
				'client_name' => $client_name, 
				'file_name' => $file_name, 
				'file_size' => $file_size, 
				'file_type' => $file_type, 
				'file_ext' => $file_ext
		);

	}

	public function save_detail()
	{
		$this->insert_kop_surat();
	}

	public function insert_kop_surat()
	{
		$this->db->select('1')->from('tb_kop_surat')->where('id_kepk', $this->session->userdata('id_kepk'));
		$rs = $this->db->get()->row_array();

		if ($rs)
		{
			$this->db->where('id_kepk', $this->session->userdata('id_kepk'));
			$this->db->update('tb_kop_surat', $this->data);
			$this->check_trans_status('update tb_kop_surat failed');

			$aktivitas = 'Edit Kop Surat';
			$id_user_kepk = $this->session->userdata('id_user_'.APPAUTH);
			$id_user = $this->session->userdata('id_user_'.APPAUTH);
			simpan_logaktivitas_tim_kepk($aktivitas, $id_user_kepk, $id_user);
		}
		else
		{
			$this->db->insert('tb_kop_surat', $this->data);
			$this->check_trans_status('insert tb_kop_surat failed');

			$aktivitas = 'Insert Kop Surat';
			$id_user_kepk = $this->session->userdata('id_user_'.APPAUTH);
			$id_user = $this->session->userdata('id_user_'.APPAUTH);
			simpan_logaktivitas_tim_kepk($aktivitas, $id_user_kepk, $id_user);
		}
	}

	public function get_data()
	{
		$this->db->select('hs.client_name, hs.file_name, hs.file_size, hs.file_type, hs.file_ext');
		$this->db->from('tb_kop_surat as hs');
		$this->db->where('hs.id_kepk', $this->session->userdata('id_kepk'));
		$result = $this->db->get()->row_array();

		return $result;
	}

}
