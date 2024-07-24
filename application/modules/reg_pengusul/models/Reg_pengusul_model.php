<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reg_pengusul_model extends Core_Model {

	var $data_dok;
  var $data_user;
  var $username;
  var $password;

	public function __construct()
	{
		parent::__construct();

	}

	public function fill_data()
	{
    $id_kepk = $this->get_data_id_kepk();
    $nomor = $this->input->post('no_anggota') ? $this->input->post('no_anggota') : '';
  	$nama = $this->input->post('nama') ? $this->input->post('nama') : '';
  	$nik = $this->input->post('nik') ? $this->input->post('nik') : '';
    $tempat_lahir = $this->input->post('tempat_lahir') ? $this->input->post('tempat_lahir') : '';
    $tgl_lahir = $this->input->post('tgl_lahir') ? $this->input->post('tgl_lahir') : '';
    $kewarganegaraan = $this->input->post('kewarganegaraan') ? $this->input->post('kewarganegaraan') : '';
    $id_country = $this->input->post('negara') ? $this->input->post('negara') : '';
	  $alamat = $this->input->post('alamat') ? $this->input->post('alamat') : '';
    $jalan = $this->input->post('jalan') ? $this->input->post('jalan') : '';
    $no_rumah = $this->input->post('no_rumah') ? $this->input->post('no_rumah') : '';
    $rt = $this->input->post('rt') ? $this->input->post('rt') : '';
    $rw = $this->input->post('rw') ? $this->input->post('rw') : '';
    $kode_propinsi = $this->input->post('propinsi') ? $this->input->post('propinsi') : '';
    $kode_kabupaten = $this->input->post('kabupaten') ? $this->input->post('kabupaten') : '';
    $kode_kecamatan = $this->input->post('kecamatan') ? $this->input->post('kecamatan') : '';
    $kode_pos = $this->input->post('kode_pos') ? $this->input->post('kode_pos') : '';
    $no_telp = $this->input->post('no_telp') ? $this->input->post('no_telp') : '';
    $no_hp = $this->input->post('no_hp') ? $this->input->post('no_hp') : '';
    $email = $this->input->post('email') ? $this->input->post('email') : '';
    $username = $this->input->post('username') ? $this->input->post('username') : '';
    $password = $this->input->post('password') ? $this->input->post('password') : '';

	  $this->data = array(
        'id_kepk' => $id_kepk,
	  		'nomor' => $nomor,
		  	'nama' => $nama,
		  	'nik' => $nik,
        'tempat_lahir' => $tempat_lahir,
        'tgl_lahir' => $tgl_lahir,
        'kewarganegaraan' => $kewarganegaraan,
        'id_country' => $id_country,
				'alamat' => $alamat,
        'jalan' => $jalan,
        'no_rumah' => $no_rumah,
        'rt' => $rt,
        'rw' => $rw,
				'kode_propinsi' => $kode_propinsi,
				'kode_kabupaten' => $kode_kabupaten,
        'kode_kecamatan' => $kode_kecamatan,
        'kode_pos' => $kode_pos,
				'no_telepon' => $no_telp,
        'no_hp' => $no_hp,
				'email' => $email,
        'aktif' => 1
		);

    $this->data_user = array(
        'nama' => $nama,
        'username' => $username,
        'password' => $password,
        'email' => $email,
        'id_group' => 3,
        'aktif' => 1
    );

    $dokumen = $this->input->post('dokumen') ? $this->input->post('dokumen') : '';
    if ($dokumen)
    {
      for ($i=0; $i<count($dokumen); $i++)
      {
        $deskripsi = $dokumen[$i]['deskripsi'] ? $dokumen[$i]['deskripsi'] : '';
        $client_name = $dokumen[$i]['client_name'] ? $dokumen[$i]['client_name'] : '';
        $file_name = $dokumen[$i]['file_name'] ? $dokumen[$i]['file_name'] : '';
        $file_size = $dokumen[$i]['file_size'] ? $dokumen[$i]['file_size'] : '';
        $file_type = $dokumen[$i]['file_type'] ? $dokumen[$i]['file_type'] : '';
        $file_ext = $dokumen[$i]['file_ext'] ? $dokumen[$i]['file_ext'] : '';

        $this->data_dok[] = array('deskripsi_file' => $deskripsi, 'client_name' => $client_name, 'file_name' => $file_name, 'file_size' => $file_size, 'file_type' => $file_type, 'file_ext' => $file_ext);
      }
    }

	}

	public function save_detail()
	{
		$this->insert_pengusul();
    $this->insert_dokumen();
    $this->insert_users();
	}

	public function insert_pengusul()
	{
		$this->db->insert('tb_pengusul', $this->data);
		$this->check_trans_status('insert tb_pengusul failed');
		$this->id = $this->db->insert_id();
	}

  public function insert_dokumen()
  {
    if ($this->data_dok && count($this->data_dok) > 0)
    {
      for ($i=0; $i<count($this->data_dok); $i++)
      {
        $this->data_dok[$i]['id_pengusul'] = $this->id;
        $this->db->insert('tb_dokumen_pengusul', $this->data_dok[$i]);
        $this->check_trans_status('insert tb_dokumen_pengusul failed');
      }
    }
  }

  function insert_users()
  {
    $this->data_user['id_pengusul'] = $this->id;
    $this->db->insert('tb_users', $this->data_user);
    $this->check_trans_status('insert tb_users failed');
  }

  function get_data_id_kepk()
  {
    $this->db->select('id_kepk')->from('tb_kepk');
    $result = $this->db->get()->row_array();

    return isset($result['id_kepk']) ? $result['id_kepk'] : 0;
  }
	
  function get_data_pengusul_by_id($id)
  {
    $this->db->select("p.nomor, p.nama, p.nik, p.kewarganegaraan, p.no_telepon, p.no_hp, p.email, k.nama_kepk, c.name as negara");
    $this->db->from('tb_pengusul as p');
    $this->db->join('tb_kepk as k', 'k.id_kepk = p.id_kepk');
    $this->db->join('countries as c', 'c.id = p.id_country');
    $this->db->where('p.id_pengusul', $id);
    $result = $this->db->get()->row_array();

    return $result;
  }

  function get_data_opt_wilayah()
	{
		$this->db->select('w.*');
		$this->db->from('wilayah as w');
		$result = $this->db->get()->result_array();

		return $result;
	}

  function get_data_opt_countries()
  {
    $this->db->select('c.id, c.name');
    $this->db->from('countries as c');
    $result = $this->db->get()->result_array();

    return $result;
  }

  function check_isset_data_kepk()
  {
    $this->db->select('1')->from('tb_kepk')->where('aktif = 1');
    $rs = $this->db->get()->row_array();

    return $rs ? 1 : 0;
  }

}
