<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tandatangan_ketua_model extends Core_Model {

	public function __construct()
	{
		parent::__construct();

	}

	public function fill_data()
	{
		$id_kepk = $this->session->userdata('id_kepk');
    $id_atk_ketua = $this->input->post('id_atk') ? $this->input->post('id_atk'): 0;
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
		$this->insert_tandatangan_ketua();
	}

	public function insert_tandatangan_ketua()
	{
		$this->db->select('1')->from('tb_tandatangan_ketua')->where('id_kepk', $this->session->userdata('id_kepk'));
		$rs = $this->db->get()->row_array();

		if ($rs)
		{
			$this->db->where('id_kepk', $this->session->userdata('id_kepk'));
			$this->db->update('tb_tandatangan_ketua', $this->data);
			$this->check_trans_status('update tb_tandatangan_ketua failed');

			$aktivitas = 'Edit Tanda Tangan Ketua';
			$id_user_kepk = $this->session->userdata('id_user_'.APPAUTH);
			$id_user = $this->session->userdata('id_user_'.APPAUTH);
			simpan_logaktivitas_tim_kepk($aktivitas, $id_user_kepk, $id_user);
		}
		else
		{
			$this->db->insert('tb_tandatangan_ketua', $this->data);
			$this->check_trans_status('insert tb_tandatangan_ketua failed');

			$aktivitas = 'Insert Tanda Tangan Ketua';
			$id_user_kepk = $this->session->userdata('id_user_'.APPAUTH);
			$id_user = $this->session->userdata('id_user_'.APPAUTH);
			simpan_logaktivitas_tim_kepk($aktivitas, $id_user_kepk, $id_user);
		}
	}

	public function get_data()
	{
		$this->db->select('tk.client_name, tk.file_name, tk.file_size, tk.file_type, tk.file_ext');
		$this->db->from('tb_tandatangan_ketua as tk');
		$this->db->where('tk.id_kepk', $this->session->userdata('id_kepk'));
		$result = $this->db->get()->row_array();

		return $result;
	}

  function get_data_ketua_kepk()
  {
    $this->db->select('a.id_atk, a.nama, a.nomor, a.nik');
    $this->db->from('tb_anggota_tim_kepk as a');
    $this->db->join('tb_struktur_tim_kepk as s', 's.id_atk = a.id_atk');
    $this->db->join('tb_tim_kepk as t', 't.id_tim_kepk = s.id_tim_kepk');
    $this->db->where('s.jabatan = 1');
    $this->db->where('a.id_kepk', $this->session->userdata('id_kepk'));
    $this->db->where('t.aktif = 1');
    $result = $this->db->get()->row_array();

    return $result;
  }

  function get_data_kop_surat()
  {
    $this->db->select('ks.file_name');
    $this->db->from('tb_kop_surat as ks');
    $this->db->where('ks.id_kepk', $this->session->userdata('id_kepk'));
    $result = $this->db->get()->row_array();

    return $result;
  }
}
