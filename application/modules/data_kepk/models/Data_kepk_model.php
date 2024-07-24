<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_kepk_model extends Core_Model {

  var $data_lembaga;
  var $data_kepk;
  var $data_sk;
  var $data_permohonan;
  var $data_izin;
  var $data_user;
  var $id_lembaga;
  var $id_kepk;

	public function __construct()
	{
		parent::__construct();
	}

  function fill_data_json($json_data)
  {
    $this->data_lembaga = array();
    $this->data_kepk = array();
    $this->data_user = array();

    if (!empty($json_data))
    {
      $this->data_lembaga['nama_lembaga'] = isset($json_data['nama_lembaga']) ? $json_data['nama_lembaga'] : '';
      $this->data_lembaga['alamat'] = isset($json_data['alamat_lembaga']) ? $json_data['alamat_lembaga'] : '';
      $this->data_lembaga['jalan'] = isset($json_data['jalan_lembaga']) ? $json_data['jalan_lembaga'] : '';
      $this->data_lembaga['no_rumah'] = isset($json_data['no_rumah_lembaga']) ? $json_data['no_rumah_lembaga'] : '';
      $this->data_lembaga['rt'] = isset($json_data['rt_lembaga']) ? $json_data['rt_lembaga'] : '';
      $this->data_lembaga['rw'] = isset($json_data['rw_lembaga']) ? $json_data['rw_lembaga'] : '';
      $this->data_lembaga['kode_propinsi'] = isset($json_data['kode_propinsi_lembaga']) ? $json_data['kode_propinsi_lembaga'] : '';
      $this->data_lembaga['kode_kabupaten'] = isset($json_data['kode_kabupaten_lembaga']) ? $json_data['kode_kabupaten_lembaga'] : '';
      $this->data_lembaga['kode_kecamatan'] = isset($json_data['kode_kecamatan_lembaga']) ? $json_data['kode_kecamatan_lembaga'] : '';
      $this->data_lembaga['kode_pos'] = isset($json_data['kode_pos_lembaga']) ? $json_data['kode_pos_lembaga'] : '';
      $this->data_lembaga['email'] = isset($json_data['email_lembaga']) ? $json_data['email_lembaga'] : '';
      $this->data_lembaga['no_telepon'] = isset($json_data['no_telp_lembaga']) ? $json_data['no_telp_lembaga'] : '';

      $this->data_kepk['kodefikasi'] = isset($json_data['nomor_kep']) ? $json_data['nomor_kep'] : '';
      $this->data_kepk['nama_kepk'] = isset($json_data['nama_kep']) ? $json_data['nama_kep'] : '';
      $this->data_kepk['no_surat_penetapan'] = isset($json_data['no_surat_penetapan']) ? $json_data['no_surat_penetapan'] : '';
      $this->data_kepk['alamat'] = isset($json_data['alamat_kep']) ? $json_data['alamat_kep'] : '';
      $this->data_kepk['jalan'] = isset($json_data['jalan_kep']) ? $json_data['jalan_kep'] : '';
      $this->data_kepk['no_rumah'] = isset($json_data['no_rumah_kep']) ? $json_data['no_rumah_kep'] : '';
      $this->data_kepk['rt'] = isset($json_data['rt_kep']) ? $json_data['rt_kep'] : '';
      $this->data_kepk['rw'] = isset($json_data['rw_kep']) ? $json_data['rw_kep'] : '';
      $this->data_kepk['kode_propinsi'] = isset($json_data['kode_propinsi_kep']) ? $json_data['kode_propinsi_kep'] : '';
      $this->data_kepk['kode_kabupaten'] = isset($json_data['kode_kabupaten_kep']) ? $json_data['kode_kabupaten_kep'] : '';
      $this->data_kepk['kode_kecamatan'] = isset($json_data['kode_kecamatan_kep']) ? $json_data['kode_kecamatan_kep'] : '';
      $this->data_kepk['kode_pos'] = isset($json_data['kode_pos_kep']) ? $json_data['kode_pos_kep'] : '';
      $this->data_kepk['email'] = isset($json_data['email_kep']) ? $json_data['email_kep'] : '';
      $this->data_kepk['no_telepon'] = isset($json_data['no_telp_kep']) ? $json_data['no_telp_kep'] : '';
      $this->data_kepk['token'] = isset($json_data['token']) ? $json_data['token'] : '';

      $this->data_user['nama'] = isset($json_data['nama_kep']) ? $json_data['nama_kep'] : '';
      $this->data_user['username'] = isset($json_data['username']) ? $json_data['username'] : $json_data['nomor_kep'];
      $this->data_user['password'] = isset($json_data['password']) ? $json_data['password'] : md5($json_data['nomor_kep']);
      $this->data_user['email'] = isset($json_data['email_kep']) ? $json_data['email_kep'] : '';
      $this->data_user['id_group'] = 2;
    }
  }

  function save_detail()
  {
    $this->insert_lembaga();
    $this->insert_kepk();
    $this->insert_users();
  }

  function insert_lembaga()
  {
    if (isset($this->data_lembaga) && count($this->data_lembaga) > 0)
    {
      $this->db->insert('tb_lembaga', $this->data_lembaga);
      $this->check_trans_status('insert tb_lembaga failed');
      $this->id_lembaga = $this->db->insert_id();
    }
  }

  function insert_kepk()
  {
    if (isset($this->data_kepk) && count($this->data_kepk) > 0)
    {
      $this->data_kepk['id_lembaga'] = $this->id_lembaga;
      $this->db->insert('tb_kepk', $this->data_kepk);
      $this->check_trans_status('insert tb_kepk failed');
      $this->id_kepk = $this->db->insert_id();
    }
  }

  function insert_users()
  {
    if (isset($this->data_user) && count($this->data_user) > 0)
    {
      $this->data_user['id_kepk'] = $this->id_kepk;
      $this->db->insert('tb_users', $this->data_user);
      $this->check_trans_status('insert tb_users failed');
    }
  }

  function aktifkan_kepk($kodefikasi)
  {
    $this->db->trans_start();
    try {
      $this->db->select('k.id_kepk');
      $this->db->from('tb_kepk as k');
      $this->db->where('k.kodefikasi', $kodefikasi);
      $rs = $this->db->get()->row_array();
      $id_kepk = isset($rs['id_kepk']) ? $rs['id_kepk'] : 0;

      $this->update_kepk($id_kepk);
      $this->update_users($id_kepk);

      $this->db->trans_complete();
    }
    catch(Exception $e){
      //TODO : log error to file
    }

    if ($this->db->trans_status() === FALSE)
    {
      $this->db->trans_rollback();
      return FALSE;
    }

    $this->db->trans_commit();
    return TRUE;
  }

  function update_kepk($id_kepk)
  {
    $this->db->where('id_kepk', $id_kepk);
    $this->db->update('tb_kepk', array('aktif' => 1, 'status' => 1));
    $this->check_trans_status('update tb_kepk failed');
  }

  function update_users($id_kepk)
  {
    $this->db->where('id_kepk', $id_kepk);
    $this->db->update('tb_users', array('aktif' => 1));
    $this->check_trans_status('update tb_users failed');
  }

	function get_data()
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
		$result = $this->db->get()->row_array();

		return $result;
	}

  function get_data_token_by_kodefikasi($kodefikasi)
  {
    $this->db->select('k.token');
    $this->db->from('tb_kepk as k');
    $this->db->where('k.kodefikasi', $kodefikasi);
    $result = $this->db->get()->row_array();

    return isset($result['token']) ? $result['token'] : '';
  }

}
