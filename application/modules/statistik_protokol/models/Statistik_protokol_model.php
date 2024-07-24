<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Statistik_protokol_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();

	}

	function get_data_jenis_penelitian_by_param($periode, $penelitian)
	{
		$periode = date('Ym', strtotime($periode));

		$this->db->select('count(p.id_pengajuan) as jumlah');
		$this->db->from('tb_pengajuan as p');
		$this->db->where("extract(year_month from p.inserted) = '".$periode."'");
		$this->db->where('p.jenis_penelitian', $penelitian);
		$this->db->where('p.id_kepk', $this->session->userdata('id_kepk_tim'));
		$result = $this->db->get()->row_array();

		if ($result)
			return $result['jumlah'];

		return 0;
	}

	function get_data_asal_pengusul_by_param($periode, $asal)
	{
		$periode = date('Ym', strtotime($periode));

		$this->db->select('count(p.id_pengajuan) as jumlah');
		$this->db->from('tb_pengajuan as p');
		$this->db->where("extract(year_month from p.inserted) = '".$periode."'");
		$this->db->where('p.asal_pengusul', $asal);
		$this->db->where('p.id_kepk', $this->session->userdata('id_kepk_tim'));
		$result = $this->db->get()->row_array();

		if ($result)
			return $result['jumlah'];

		return 0;
	}

	function get_data_jenis_lembaga_by_param($periode, $lembaga)
	{
		$periode = date('Ym', strtotime($periode));

		$this->db->select('count(p.id_pengajuan) as jumlah');
		$this->db->from('tb_pengajuan as p');
		$this->db->where("extract(year_month from p.inserted) = '".$periode."'");
		$this->db->where('p.jenis_lembaga', $lembaga);
		$this->db->where('p.id_kepk', $this->session->userdata('id_kepk_tim'));
		$result = $this->db->get()->row_array();

		if ($result)
			return $result['jumlah'];

		return 0;
	}

	function get_data_status_pengusul_by_param($periode, $status)
	{
		$periode = date('Ym', strtotime($periode));

		$this->db->select('count(p.id_pengajuan) as jumlah');
		$this->db->from('tb_pengajuan as p');
		$this->db->where("extract(year_month from p.inserted) = '".$periode."'");
		$this->db->where('p.status_pengusul', $status);
		$this->db->where('p.id_kepk', $this->session->userdata('id_kepk_tim'));
		$result = $this->db->get()->row_array();

		if ($result)
			return $result['jumlah'];

		return 0;
	}

	function get_data_strata_pendidikan_by_param($periode, $pendidikan)
	{
		$periode = date('Ym', strtotime($periode));

		$this->db->select('count(p.id_pengajuan) as jumlah');
		$this->db->from('tb_pengajuan as p');
		$this->db->where("extract(year_month from p.inserted) = '".$periode."'");
		$this->db->where('p.strata_pendidikan', $pendidikan);
		$this->db->where('p.id_kepk', $this->session->userdata('id_kepk_tim'));
		$result = $this->db->get()->row_array();

		if ($result)
			return $result['jumlah'];

		return 0;
	}

}
