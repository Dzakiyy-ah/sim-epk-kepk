<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monev_model extends Core_Model {

  	var $fieldmap_filter;
	var $data_dokumen;
	var $purge_dokumen;

	public function __construct()
	{
		parent::__construct();

    $this->fieldmap_filter = array(
      'no_protokol' => 'p.no_protokol',
      'judul' => 'p.judul',
      'kepk' => 'k.nama_kepk',
      'tgl_monev' => 'date(m.inserted)'
    );
	}

	public function fill_data()
	{
		$id = $this->input->post('id') ? $this->input->post('id') : 0;
		$id_pep = $this->input->post('id_pep') ? $this->input->post('id_pep') : 0;
	  	$remove_str = array("\n", "\r\n", "\r");
	  	$kendala = $this->input->post('kendala') ? addslashes(str_replace($remove_str, ' ', $this->input->post('kendala'))) : '';

		$this->data = array(
			'id_monev' => $id,
			'id_pep' => $id_pep,
			'kendala' => $kendala
		);

		$dokumen = $this->input->post('dokumen') ? json_decode($this->input->post('dokumen')) : '';
		for ($b=0; $b<count($dokumen); $b++)
		{
			$id_md = isset($dokumen[$b]->id) ? $dokumen[$b]->id : 0;
			$deskripsi = isset($dokumen[$b]->deskripsi) ? $dokumen[$b]->deskripsi : '';
			$client_name = isset($dokumen[$b]->client_name) ? $dokumen[$b]->client_name : '';
			$file_name = isset($dokumen[$b]->file_name) ? $dokumen[$b]->file_name : '';
			$file_size = isset($dokumen[$b]->file_size) ? $dokumen[$b]->file_size : '';
			$file_type = isset($dokumen[$b]->file_type) ? $dokumen[$b]->file_type : '';
			$file_ext = isset($dokumen[$b]->file_ext) ? $dokumen[$b]->file_ext : '';
			$this->data_dokumen[] = array('id_md'=>$id_md, 'file_name'=>$file_name, 'deskripsi'=>$deskripsi, 'client_name'=>$client_name, 'file_size'=>$file_size, 'file_type'=>$file_type, 'file_ext'=>$file_ext);
		}
		$this->purge_dokumen = $this->input->post('purge_dokumen') ? $this->input->post('purge_dokumen') : '';

		$this->purge_filename = $this->input->post('purge_filename') ? $this->input->post('purge_filename') : '';

	}

	public function save_detail()
	{
		$this->insert_monev();
		$this->insert_monev_dokumen();
	}

	function insert_monev()
	{
		if (isset($this->data['id_monev']) && $this->data['id_monev'] > 0)
		{
			$this->db->where('id_monev', $this->data['id_monev']);
			$this->db->update('tb_monev', $this->data);
			$this->check_trans_status('update tb_monev failed');
			$this->id = $this->data['id_monev'];
		}
		else
		{
			unset($this->data['id_monev']);
			$this->db->insert('tb_monev', $this->data);
			$this->check_trans_status('insert tb_monev failed');
			$this->id = $this->db->insert_id();
		}		
	}

	public function insert_monev_dokumen()
	{
		if ($this->purge_filename)
		{
	    for ($a=0; $a<count($this->purge_filename); $a++)
  		{
  			$dir = './uploads/';
	  		$path = $dir.$this->purge_filename[$a];
  			if (file_exists($path)) {	unlink($path); }
  		}
		}

    if ($this->purge_dokumen)
    {
			$this->db->where_in('id_md', $this->purge_dokumen);
			$this->db->delete('tb_monev_dokumen');
			$this->check_trans_status('delete tb_monev_dokumen failed');
    }

  	for ($i=0; $i<count($this->data_dokumen); $i++)
  	{
  		$this->db->select('1')->from('tb_monev_dokumen as md');
  		$this->db->where('md.id_md', $this->data_dokumen[$i]['id_md']);
  		$this->db->where('md.id_monev', $this->id);
  		$rs = $this->db->get()->row_array();

  		if ($rs)
  		{
  			$this->db->where('id_monev', $this->id);
  			$this->db->where('id_md', $this->data_dokumen[$i]['id_md']);
  			$this->db->update('tb_monev_dokumen', $this->data_dokumen[$i]);
	  		$this->check_trans_status('update tb_monev_dokumen failed');
  		}
  		else
  		{
	  		unset($this->data_dokumen[$i]['id_md']);
  			$this->data_dokumen[$i]['id_monev'] = $this->id;
  			$this->db->insert('tb_monev_dokumen', $this->data_dokumen[$i]);
	  		$this->check_trans_status('insert tb_monev_dokumen failed');
  		}
  	}

	}

  public function get_data_jqgrid($param, $isCount=FALSE, $CompileOnly=False)
  {
    $this->db->select('m.id_monev, p.no_protokol, p.judul, k.nama_kepk, m.inserted as tanggal_monev');
    $this->db->from('tb_monev as m');
    $this->db->join('tb_pep as e', 'e.id_pep = m.id_pep');
    $this->db->join('tb_pengajuan as p', 'p.id_pengajuan = e.id_pengajuan');
    $this->db->join('tb_kepk as k', 'k.id_kepk = p.id_kepk');

    if ($this->session->userdata('id_group_'.APPAUTH) == 3) {
      $this->db->where('p.id_pengusul', $this->session->userdata('id_pengusul'));
    }
    else {
      $this->db->where('p.id_kepk', $this->session->userdata('id_kepk_tim'));
    }

    // proses parameter pencarian, jika ada
    if (isset($param['_search']) && $param['_search'] == 'true' )
    {
      $fld = $param['search_fld'];
      switch($fld){
        case 'tgl_monev': $str = prepare_date($param['search_str']); break;
        default : $str = $param['search_str']; break;
      }
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

	public function get_data_by_id($id)
	{
		$this->db->select('m.id_monev, m.id_pep, m.kendala, p.no_protokol, p.judul');
		$this->db->from('tb_monev as m');
		$this->db->join('tb_pep as e', 'e.id_pep = m.id_pep');
		$this->db->join('tb_pengajuan as p', 'p.id_pengajuan = e.id_pengajuan');
		$this->db->where('m.id_monev', $id);
		$result = $this->db->get()->row_array();

		return $result;
	}

	public function get_data_detail_by_id($id)
	{
		$this->db->select('m.id_monev, m.kendala, p.no_protokol, p.judul, k.nama_kepk, m.inserted as tanggal_monev');
		$this->db->from('tb_monev as m');
		$this->db->join('tb_pep as e', 'e.id_pep = m.id_pep');
		$this->db->join('tb_pengajuan as p', 'p.id_pengajuan = e.id_pengajuan');
		$this->db->join('tb_kepk as k', 'k.id_kepk = p.id_kepk');
		$this->db->where('m.id_monev', $id);
		$result = $this->db->get()->row_array();

		return $result;
	}

	function get_data_protokol()
	{
		$this->db->select("
				kr.id_pep,
				p.no_protokol, 
				p.judul
			");
		$this->db->from('tb_kirim_surat_ke_peneliti as kr');
		$this->db->join('tb_pep as e', 'e.id_pep = kr.id_pep');
		$this->db->join('tb_pengajuan as p', 'p.id_pengajuan = e.id_pengajuan');
    	$this->db->join('tb_monev as m', 'm.id_pep = kr.id_pep', 'left');
		$this->db->where('kr.keputusan', 'LE');
		$this->db->where('p.id_pengusul', $this->session->userdata('id_pengusul'));
		$this->db->where('m.id_monev is null');
		$result = $this->db->get()->result_array();

		return $result;
	}

	function get_data_fileupload_by_id($id)
	{
		$this->db->select('d.id_md, d.deskripsi, d.file_name, d.client_name, d.file_size, d.file_type, d.file_ext');
		$this->db->from('tb_monev_dokumen as d');
		$this->db->where('d.id_monev', $id);
		$result = $this->db->get()->result_array();

		return $result;
	}

}
