<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kepk_model extends Core_Model {

	public function __construct()
	{
		parent::__construct();

	}

	public function get_data_kepk()
	{
    $this->db->select("
        k.id_kepk,
        k.kodefikasi, 
        k.nama_kepk, 
        k.no_surat_penetapan, 
        k.alamat as alamat_kepk,
        k.jalan as jalan_kepk,
        k.no_rumah as no_rumah_kepk,
        k.rt as rt_kepk,
        k.rw as rw_kepk,
        k.kode_pos as kode_pos_kepk,
        k.email as email_kepk,
        k.no_telepon as no_telp_kepk, 
        k.aktif,
        k.token,
        l.nama_lembaga,
        l.alamat as alamat_lembaga,
        l.jalan as jalan_lembaga,
        l.no_rumah as no_rumah_lembaga,
        l.rt as rt_lembaga,
        l.rw as rw_lembaga,
        l.kode_pos as kode_pos_lembaga,
        l.email as email_lembaga,
        l.no_telepon as no_telp_lembaga,
        w1.nama as propinsi_kepk,
        w2.nama as kabupaten_kepk,
        w3.nama as kecamatan_kepk,
        w4.nama as propinsi_lembaga,
        w5.nama as kabupaten_lembaga,
        w6.nama as kecamatan_lembaga
      ");
    $this->db->from('tb_kepk as k');
    $this->db->join('tb_lembaga as l', 'l.id_lembaga = k.id_lembaga');
    $this->db->join('wilayah as w1', 'w1.kode = k.kode_propinsi');
    $this->db->join('wilayah as w2', 'w2.kode = k.kode_kabupaten');
    $this->db->join('wilayah as w3', 'w3.kode = k.kode_kecamatan');
    $this->db->join('wilayah as w4', 'w4.kode = l.kode_propinsi');
    $this->db->join('wilayah as w5', 'w5.kode = l.kode_kabupaten');
    $this->db->join('wilayah as w6', 'w6.kode = l.kode_kecamatan');
		$this->db->where('k.id_kepk', $this->session->userdata('id_kepk'));
		$result = $this->db->get()->row_array();

		return $result;
	}
  
}
