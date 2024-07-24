<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akun_bank_model extends Core_Model {

	public function __construct()
	{
		parent::__construct();

	}

	public function fill_data()
	{
		$id_kepk = $this->session->userdata('id_kepk');
		$nama_bank = $this->input->post('nama_bank') ? $this->input->post('nama_bank') : '';
		$no_rekening = $this->input->post('no_rekening') ? $this->input->post('no_rekening') : '';
		$pemilik_rekening = $this->input->post('pemilik_rekening') ? $this->input->post('pemilik_rekening') : '';
		$swift_code = $this->input->post('swift_code') ? $this->input->post('swift_code') : '';

		$this->data = array(
				'id_kepk' => $id_kepk,
				'nama_bank' => $nama_bank, 
				'no_rekening' => $no_rekening, 
				'pemilik_rekening' => $pemilik_rekening, 
				'swift_code' => $swift_code
		);

	}

	public function save_detail()
	{
		$this->update_kepk();
	}

  public function update_kepk()
  {
    $this->db->where('id_kepk', $this->data['id_kepk']);
    $this->db->update('tb_kepk', $this->data);
    $this->check_trans_status('update tb_kop_surat failed');

    $aktivitas = 'Edit Akun Bank';
    $id_user_kepk = $this->session->userdata('id_user_'.APPAUTH);
    $id_user = $this->session->userdata('id_user_'.APPAUTH);
    simpan_logaktivitas_tim_kepk($aktivitas, $id_user_kepk, $id_user);
  }

	public function get_data()
	{
		$this->db->select('k.nama_bank, k.no_rekening, k.pemilik_rekening, k.swift_code');
		$this->db->from('tb_kepk as k');
  	$result = $this->db->get()->row_array();

		return $result;
	}

  function get_data_tarif_telaah()
  {
    $this->db->select('tt.id_tarif_telaah, tt.jenis_penelitian, tt.asal_pengusul, tt.jenis_lembaga, tt.status_pengusul, tt.strata_pendidikan, tt.tarif_telaah');
    $this->db->from('tb_tarif_telaah as tt');
    $this->db->order_by('tt.jenis_penelitian, tt.asal_pengusul, tt.jenis_lembaga, tt.status_pengusul, tt.strata_pendidikan', 'asc');
    $result = $this->db->get()->result_array();

    return $result;
  }

}
