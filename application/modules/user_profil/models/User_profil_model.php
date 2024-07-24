<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_profil_model extends Core_Model {

	public function __construct()
	{
		parent::__construct();

	}

	function fill_data_password()
	{
		$id_user = $this->session->userdata('id_user_'.APPAUTH);
		$password_baru = $this->input->post('passw_baru1') ? md5($this->input->post('passw_baru1')) : '';

		$this->data_password = array('id_user'=>$id_user, 'password'=>$password_baru);
	}

	public function save_data_password()
	{
    $this->db->trans_start();
    try {
    	$this->db->where('id_user', $this->data_password['id_user']);
    	$this->db->update('tb_users', $this->data_password);
    	$this->id = $this->data_password['id_user'];
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

	public function get_data()
	{
		$this->db->select("u.nama, u.username, u.email");
		$this->db->from('tb_users as u');
		$this->db->where('u.id_user', $this->session->userdata('id_user_'.APPAUTH));
		$result = $this->db->get()->row_array();

		return $result;
	}

	public function check_valid_password($id, $passw)
	{
		$this->db->select('1')->from('tb_users as u')->where('u.id_user', $id)->where('u.password', md5($passw));
		$rs = $this->db->get()->row_array();

		if ($rs)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

}
