<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();

	}

	public function cek_login($username, $password, $id_group)
	{
		$this->db->select('1')->from('tb_users')
			->where('username', $username)->where('password', $password)->where('id_group', $id_group)->where('aktif', 1);
		$rs = $this->db->get()->row_array();

		if ($rs) return TRUE;

		return FALSE;
	}

	function cek_data_exist($username, $email, $id_group)
	{
		$this->db->select('1')->from('tb_users')
			->where('username', $username)->where('email', $email)->where('id_group', $id_group)->where('aktif', 1);
		$rs = $this->db->get()->row_array();

		if ($rs) return TRUE;

		return FALSE;
	}

 	function check_trans_status($exception)
  {
    if ($this->db->trans_status() === FALSE) {
      throw new Exception($exception);
    }
  }

	function update_password()
	{
    $this->db->trans_start();
    try {
    	$password_baru = $this->input->post('passw_baru1') ? md5($this->input->post('passw_baru1')) : md5($this->session->userdata('username'));

			$this->db->where('username', $this->session->userdata('username'));
			$this->db->where('id_group', $this->session->userdata('id_group'));
			$this->db->update('tb_users', array('password'=>$password_baru));
  		$this->check_trans_status('update tb_users failed');

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

	public function get_user_data($username='', $password='', $id_group=0)
	{
		$this->db->select('
				u.id_user, 
				u.nama, 
				u.username, 
				u.id_group,
        u.id_kepk,
        u.id_pengusul,
				g.nama as nama_group,
				coalesce((select t.id_kepk from tb_tim_kepk as t join tb_struktur_tim_kepk as s on s.id_tim_kepk = t.id_tim_kepk join tb_users as u2 on u2.id_stk = s.id_stk where u2.id_user = u.id_user), 0) as id_kepk_tim,
				coalesce((select k.nama_kepk from tb_tim_kepk as t join tb_struktur_tim_kepk as s on s.id_tim_kepk = t.id_tim_kepk join tb_kepk as k on k.id_kepk = t.id_kepk join tb_users as u2 on u2.id_stk = s.id_stk where u2.id_user = u.id_user), 0) as nama_kepk
		');
		$this->db->from('tb_users as u');
		$this->db->join('tb_group as g', 'g.id_group = u.id_group');
		$this->db->where('u.username', $username);
		$this->db->where('u.password', $password);
		$this->db->where('u.id_group', $id_group);
		$this->db->where('u.aktif', 1);
		$result = $this->db->get()->row_array();

		return $result;
	}

  function get_data_kepk()
  {
    $this->db->select('k.id_kepk, k.nama_kepk');
    $this->db->from('tb_kepk as k');
    $result = $this->db->get()->row_array();

    return $result;
  }

}
