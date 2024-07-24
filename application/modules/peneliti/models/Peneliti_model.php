<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peneliti_model extends Core_Model {

  var $fieldmap_filter;
	var $data_password;

	public function __construct()
	{
		parent::__construct();

    $this->fieldmap_filter = array(
      'nomor' => 'p.nomor',
      'nama' => 'p.nama',
      'nik' => 'p.nik',
      'kewarganegaraan' => 'p.kewarganegaraan',
      'negara' => 'c.name',
      'kab' => 'w2.nama',
      'prop' => 'w1.nama',
      'telp' => 'p.no_telepon',
      'hp' => 'p.no_hp',
      'email' => 'p.email'
    );
	}

	function fill_data_password()
	{
		$id_user = $this->input->post('id_user') ? $this->input->post('id_user') : 0;
		$aktif_password = $this->input->post('aktif_password') && $this->input->post('aktif_password') === 'true' ? 1 : 0;
		$password = $this->input->post('password') && $aktif_password == 1 ? md5($this->input->post('password')) : '';

		$this->data_password = array('id_user'=>$id_user, 'password'=>$password);
	}

	function save_data_password()
	{
    $this->db->trans_start();
    try {
      $this->db->where('id_user', $this->data_password['id_user']);
      $this->db->update('tb_users', $this->data_password);
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

  public function get_data_jqgrid($param, $isCount=FALSE, $CompileOnly=False)
  {
    $this->db->select('p.id_pengusul, p.nomor, p.nama, p.nik, p.kewarganegaraan, p.no_telepon, p.no_hp, p.email, c.name as negara, w1.nama as nama_propinsi, w2.nama as nama_kabupaten');
    $this->db->from('tb_pengusul as p');
    $this->db->join('countries as c', 'c.id = p.id_country', 'left');
    $this->db->join('wilayah as w1', 'w1.kode = p.kode_propinsi', 'left');
    $this->db->join('wilayah as w2', 'w2.kode = p.kode_kabupaten', 'left');

    // proses parameter pencarian, jika ada
    if (isset($param['_search']) && $param['_search'] == 'true' )
    {
      $fld = $param['search_fld'];
      $str = $param['search_str'];
      $op = $param['search_op'];

      if (strlen($str) > 0)
      {
        switch ($op) {
          case 'eq': $this->db->where($this->fieldmap_filter[$fld] . " = '" .$str . "'"); break;
          case 'ne': $this->db->where($this->fieldmap_filter[$fld] . " <> '" . $str . "'"); break;
          case 'bw': $this->db->where($this->fieldmap_filter[$fld] . " LIKE '%" . $str . "'"); break;
          case 'bn': $this->db->where($this->fieldmap_filter[$fld] . " NOT LIKE '%" . $str . "'"); break;
          case 'ew': $this->db->where($this->fieldmap_filter[$fld] . " LIKE '" . $str . "%'"); break;
          case 'en': $this->db->where($this->fieldmap_filter[$fld] . " NOT LIKE '" . $str . "%'"); break;
          case 'cn': $this->db->where($this->fieldmap_filter[$fld] . " LIKE '%" . $str . "%'"); break;
          case 'nc': $this->db->where($this->fieldmap_filter[$fld] . " NOT LIKE '%" . $str . "%'"); break;
          case 'nu': $this->db->where($this->fieldmap_filter[$fld] . " IS NULL"); break;
          case 'nn': $this->db->where($this->fieldmap_filter[$fld] . " IS NOT NULL"); break;
          case 'in': $this->db->where($this->fieldmap_filter[$fld] . " LIKE '" . $str . "'"); break;
          case 'ni': $this->db->where($this->fieldmap_filter[$fld] . " NOT LIKE '" . $str . "'"); break;
        }
      }
    }

    if (isset($param['sort_by']) && $param['sort_by'] != null && !$isCount && $ob = get_order_by_str($param['sort_by'], $this->fieldmap_filter))
    {
      $this->db->order_by($ob, $param['sort_direction']);
    }

    isset($param['limit']) && $param['limit'] ? $this->db->limit($param['limit']['end'], $param['limit']['start']) : '';

    if ($isCount) {
      $result = $this->db->count_all_results();
      return $result;
    }
    else
    {
      if ($CompileOnly)
      {
        return $this->db->get_compiled_select();
      }
      else
      {
        return $this->db->get()->result_array();
      }
    }
    
    return $result;
  }

	function get_data_by_id($id)
	{
    $this->db->select('p.id_pengusul, p.nomor, p.nama, p.nik, p.kewarganegaraan, p.no_telepon, p.no_hp, p.email, u.id_user, c.name as negara, w1.nama as nama_propinsi, w2.nama as nama_kabupaten');
		$this->db->from('tb_pengusul as p');
    $this->db->join('tb_users as u', 'u.id_pengusul = p.id_pengusul');
    $this->db->join('countries as c', 'c.id = p.id_country', 'left');
    $this->db->join('wilayah as w1', 'w1.kode = p.kode_propinsi', 'left');
    $this->db->join('wilayah as w2', 'w2.kode = p.kode_kabupaten', 'left');
		$this->db->where('p.id_pengusul', $id);
		$result = $this->db->get()->row_array();

		return $result;
	}
	
}
