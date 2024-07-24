<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anggota_tim_model extends Core_Model {

  var $jml_data;
  var $jml_insert;
  var $jml_update;
  var $arr_no_anggota;
  var $no_anggota_del;

	public function __construct()
	{
		parent::__construct();

    $this->fieldmap_filter = array(
      'id' => 'a.id_atk',
      'nomor' => 'a.nomor',
      'nama' => 'a.nama', 
      'nik' =>  'a.nik',
      'email' => 'a.email',
      'no_telp' => 'a.no_telepon',
      'no_hp' => 'a.no_hp',
      'no_sertifikat' => 'a.no_sertifikat_ed_edl'
    );
	}

  function fill_data_import($data)
  {
    for($i=0; $i<count($data); $i++)
    {
      $this->data[] = array(
        'id_kepk' => $this->session->userdata('id_kepk'),
        'nomor' => $data[$i]->nomor_anggota,
        'nama' => $data[$i]->nama_anggota,
        'nik' => $data[$i]->nik,
        'email' => $data[$i]->email,
        'no_telepon' => $data[$i]->no_telepon,
        'no_hp' => $data[$i]->no_hp,
        'no_sertifikat_ed_edl' => $data[$i]->no_sertifikat_ed_edl,
        'file_name_sertifikat' => $data[$i]->file_name_sertifikat,
        'client_name_sertifikat' => $data[$i]->client_name_sertifikat,
        'file_size_sertifikat' => $data[$i]->file_size_sertifikat,
        'file_type_sertifikat' => $data[$i]->file_type_sertifikat,
        'file_ext_sertifikat' => $data[$i]->file_ext_sertifikat
      );
    }
  }

  function save_detail()
  {
    $this->insert_anggota_tim_kepk();
  }

  function insert_anggota_tim_kepk()
  {
    $this->jml_data = 0;
    $this->jml_insert = 0;
    $this->jml_update = 0;
    $this->arr_no_anggota = array();
    if (count($this->data) > 0)
    {
      for ($i=0; $i<count($this->data); $i++)
      {
        $this->db->select('1')->from('tb_anggota_tim_kepk')->where('nomor', $this->data[$i]['nomor']);
        $rs = $this->db->get()->row_array();

        if ($rs)
        {
          $this->db->where('nomor', $this->data[$i]['nomor']);
          $this->db->update('tb_anggota_tim_kepk', $this->data[$i]);
          $this->check_trans_status('update tb_anggota_tim_kepk failed');
          $this->jml_update++;
        }
        else
        {
          $this->db->insert('tb_anggota_tim_kepk', $this->data[$i]);
          $this->check_trans_status('insert tb_anggota_tim_kepk failed');
          $this->jml_insert++;
        }
        $this->jml_data++;
        $this->arr_no_anggota[] = $this->data[$i]['nomor'];
      }
    }
  }

  public function get_data_jqgrid($param, $isCount=FALSE, $CompileOnly=False)
  {
    $this->db->select('a.id_atk, a.nomor, a.nama, a.nik, a.no_sertifikat_ed_edl, a.email, a.no_telepon, a.no_hp');
    $this->db->from('tb_anggota_tim_kepk as a');
    $this->db->where('a.id_kepk', $this->session->userdata('id_kepk'));

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

  function get_data_kodefikasi_token()
  {
    $this->db->select('k.kodefikasi, k.token');
    $this->db->from('tb_kepk as k');
    $this->db->where('k.id_kepk', $this->session->userdata('id_kepk'));
    $result = $this->db->get()->row_array();

    return $result;
  }

	public function check_exist_data($id)
	{
		$this->db->select('
				(select count(b.id_atk) from tb_struktur_tim_kepk as b where b.id_atk = a.id_atk) as struktur_pakai,
				(select count(c.id_atk_sekretaris) from tb_resume as c where c.id_atk_sekretaris  = a.id_atk) as resume_pakai,
				(select count(d.id_atk_penelaah) from tb_telaah_awal as d where d.id_atk_penelaah = a.id_atk) as penelaah_pakai
			');
		$this->db->from('tb_anggota_tim_kepk as a');
		$this->db->where('a.id_atk', $id);
		$result = $this->db->get()->row_array();

		if (isset($result['struktur_pakai']) && $result['struktur_pakai'] > 0)
			return TRUE;
		else if (isset($result['resume_pakai']) && $result['resume_pakai'] > 0)
			return TRUE;
		else if (isset($result['penelaah_pakai']) && $result['penelaah_pakai'] > 0)
			return TRUE;

		return FALSE;
	}

	public function delete_detail($id)
	{
		$this->delete_anggota_tim_kepk($id);
	}

  function delete_anggota_tim_kepk($id)
  {
    $this->db->select('nomor');
    $this->db->from('tb_anggota_tim_kepk');
    $this->db->where('id_atk', $id);
    $rs = $this->db->get()->row_array();
    $this->no_anggota_del = $rs['nomor'];

  	$this->db->where('id_atk', $id);
  	$this->db->delete('tb_anggota_tim_kepk');
  	$this->check_trans_status('delete tb_anggota_tim_kepk failed');
  }

}
