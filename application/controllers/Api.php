<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/Format.php';
require APPPATH . '/libraries/RestController.php';
use chriskacerguis\RestServer\RestController;

class Api extends RestController {

  function __construct()
  {
    // Construct the parent class
    parent::__construct();

    $this->load->model('Api_model', 'data_model');
  }

  public function kep_get()
  {
    $nomor_kep = $this->get('nomor_kep');
    $token = $this->get('token');

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
    $this->db->where('k.kodefikasi', $nomor_kep);
    $this->db->where('k.token', $token);
    $kepk = $this->db->get()->row_array();

    $this->response($kepk, 200);
  }

  public function protokol_get()
  {
    $nomor_kep = $this->get('nomor_kep');
    $token = $this->get('token');
    $tgl_awal = $this->get('tgl_awal');
    $tgl_akhir = $this->get('tgl_akhir');

    $protokol = $this->data_model->fill_data_progress_protokol($nomor_kep, $token, $tgl_awal, $tgl_akhir);

    $this->response($protokol, 200);
  }
}
