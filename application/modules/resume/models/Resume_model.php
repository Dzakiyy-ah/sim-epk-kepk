<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Resume_model extends Core_Model {

  	var $fieldmap_filter;
	var $data_penelaah;
	var $data_kirim;
	var $purge_pe;

	public function __construct()
	{
		parent::__construct();

		$this->fieldmap_filter = array(
			'no_protokol' => 'p.no_protokol',
			'judul' => 'p.judul', 
			'tgl_pengajuan' =>  'date(p.inserted)',
			'kepk' => 'k.nama_kepk',
			'mulai' => 'date(p.waktu_mulai)',
			'selesai' => 'date(p.waktu_selesai)',
			'tgl_resume' => 'date(r.inserted)'
		);
	}

	public function fill_data()
	{
		$id = $this->input->post('id') ? $this->input->post('id') : 0;
		$id_pep = $this->input->post('id_pep') ? $this->input->post('id_pep') : 0;
		$remove_str = array("\n", "\r\n", "\r");
		$resume = $this->input->post('resume') ? addslashes(str_replace($remove_str, ' ', $this->input->post('resume'))) : '';

		$sp = $this->input->post('sp') && $this->input->post('sp') === 'true' ? 1 : 0;
		$bb = $this->input->post('bb') && $this->input->post('bb') === 'true' ? 1 : 0;
		$pep = $this->input->post('pep') && $this->input->post('pep') === 'true' ? 1 : 0;
		$self_assesment = $this->input->post('self_assesment') && $this->input->post('self_assesment') === 'true' ? 1 : 0;
		$lanjut_telaah = $this->input->post('lanjut_telaah') ? $this->input->post('lanjut_telaah') : '';
		$id_atk_sekretaris = $this->get_id_atk($this->session->userdata('id_user_'.APPAUTH));
		$alasan_tbd = $this->input->post('alasan_tbd') && $this->input->post('lanjut_telaah') === 'TBD' ? $this->input->post('alasan_tbd') : '';
		$alasan_ditolak = $this->input->post('alasan_ditolak') && $this->input->post('lanjut_telaah') === 'DITOLAK' ? $this->input->post('alasan_ditolak') : '';

		$this->data = array(
			'id_resume' => $id,
			'id_pep' => $id_pep,
			'resume' => $resume,
			'id_atk_sekretaris' => $id_atk_sekretaris,
			'surat_pengantar_cek' => $sp,
			'bukti_bayar_cek' => $bb,
			'pep_cek' => $pep,
			'self_assesment_cek' => $self_assesment,
			'lanjut_telaah' => $lanjut_telaah,
      'alasan_tbd' => $alasan_tbd,
			'alasan_ditolak' => $alasan_ditolak
		);

    $penelaah = $this->input->post('penelaah_awal') ? json_decode($this->input->post('penelaah_awal')) : '';
		if (!empty($penelaah)) 
		{ 
			for ($i=0; $i<count($penelaah); $i++) 
			{ 
				$this->data_penelaah[] = array('id_atk_penelaah' => $penelaah[$i]);
			} 
		}

		// data yg dikirim ke kesekretariatan jika TBD
		$this->data_kirim = array(
			'id_pep' => $id_pep,
			'id_kepk' => $this->session->userdata('id_kepk_tim'),
			'id_atk_sekretaris' => $id_atk_sekretaris,
			'klasifikasi' => 4,
			'keputusan' => 'R'
		);

		$this->purge_pe = $this->input->post('purge_pe') ? $this->input->post('purge_pe') : '';
	}

	public function save_detail()
	{
		$this->insert_resume();
		if ($this->data['lanjut_telaah'] == 'YA')
		{
			$this->insert_penelaah_awal();
			$this->hapus_kirim_putusan_ke_sekretariat();
		}
		else if ($this->data['lanjut_telaah'] == 'TBD')
		{
			$this->hapus_penelaah_awal();
			$this->insert_kirim_putusan_ke_sekretariat();
		}
		else if ($this->data['lanjut_telaah'] == 'DITOLAK')
		{
			$this->hapus_penelaah_awal();
			$this->hapus_kirim_putusan_ke_sekretariat();
		}
	}

	function insert_resume()
	{
		if (isset($this->data['id_resume']) && $this->data['id_resume'] > 0)
		{
			$this->db->where('id_resume', $this->data['id_resume']);
			$this->db->update('tb_resume', $this->data);
			$this->check_trans_status('update tb_resume failed');
			$this->id = $this->data['id_resume'];

			$aktivitas = 'Edit Resume Protokol '.$this->input->post('no_protokol');
			$id_user_kepk = $this->get_id_atk($this->session->userdata('id_user_'.APPAUTH));
			$id_user =$this->session->userdata('id_user_'.APPAUTH);
			simpan_logaktivitas_tim_kepk($aktivitas, $id_user_kepk, $id_user);
		}
		else
		{
			unset($this->data['id_resume']);
			$this->db->insert('tb_resume', $this->data);
			$this->check_trans_status('insert tb_resume failed');
			$this->id = $this->db->insert_id();

			$aktivitas = 'Insert Resume Protokol '.$this->input->post('no_protokol');
			$id_user_kepk = $this->get_id_atk($this->session->userdata('id_user_'.APPAUTH));
			$id_user =$this->session->userdata('id_user_'.APPAUTH);
			simpan_logaktivitas_tim_kepk($aktivitas, $id_user_kepk, $id_user);
		}		
	}

	function insert_penelaah_awal() 
  { 
    if ($this->purge_pe) 
    { 
    $this->db->where_in('id_atk_penelaah', $this->purge_pe);
    $this->db->where('id_penelaah_awal', $this->id);
    $this->db->delete('tb_penelaah_awal');
    $this->check_trans_status('delete tb_penelaah_awal failed');
  } 

  if (isset($this->data_penelaah))
  {
    for ($i=0; $i<count($this->data_penelaah); $i++)
    { 
      $this->db->select('1')->from('tb_penelaah_awal')->where('id_atk_penelaah', $this->data_penelaah[$i]['id_atk_penelaah'])->where('id_resume', $this->id);
      $rs = $this->db->get()->row_array();

      if ($rs) 
      { 
        $this->db->where('id_resume', $this->id);
        $this->db->where('id_atk_penelaah', $this->data_penelaah[$i]['id_atk_penelaah']);
        $this->db->update('tb_penelaah_awal', $this->data_penelaah[$i]);
        $this->check_trans_status('update tb_penelaah_awal failed');
      }
      else
      { 
        $this->data_penelaah[$i]['id_resume'] = $this->id;
        $this->db->insert('tb_penelaah_awal', $this->data_penelaah[$i]);
        $this->check_trans_status('insert tb_penelaah_awal failed');
        } 
      } 
    } 
  }

	function hapus_kirim_putusan_ke_sekretariat()
	{
		$this->db->select('id_pep')->from('tb_resume')->where('id_resume', $this->id);
		$rs = $this->db->get()->row_array();

		if ($rs)
		{
			$this->db->where('id_pep', $rs['id_pep']);
			$this->db->delete('tb_kirim_putusan_ke_sekretariat');
		}

	}

	function hapus_penelaah_awal()
	{
		$this->db->where('id_resume', $this->id);
		$this->db->delete('tb_penelaah_awal');
		$this->check_trans_status('delete tb_penelaah_awal failed');
	}

	function insert_kirim_putusan_ke_sekretariat()
	{
		$this->db->select('1')->from('tb_kirim_putusan_ke_sekretariat')->where('id_pep', $this->data_kirim['id_pep'])->where('klasifikasi = 4');
		$rs = $this->db->get()->row_array();

		if ($rs)
		{
			$this->db->where('klasifikasi = 4');
			$this->db->where('id_pep', $this->data_kirim['id_pep']);
			$this->db->update('tb_kirim_putusan_ke_sekretariat', $this->data_kirim);
			$this->check_trans_status('update tb_kirim_putusan_ke_sekretariat failed');
		}
		else
		{
			$this->db->insert('tb_kirim_putusan_ke_sekretariat', $this->data_kirim);
			$this->check_trans_status('insert tb_kirim_putusan_ke_sekretariat failed');
		}
	}

	function get_id_atk($id_user)
	{
		$this->db->select('s.id_atk');
		$this->db->from('tb_struktur_tim_kepk as s');
		$this->db->join('tb_users as u', 'u.id_stk = s.id_stk');
		$this->db->where('u.id_user', $id_user);
		$result = $this->db->get()->row_array();

		return $result['id_atk'];
	}

  public function get_data_jqgrid($param, $isCount=FALSE, $CompileOnly=False)
  {
    $id_atk_sekretaris = $this->get_id_atk($this->session->userdata('id_user_'.APPAUTH));

    $this->db->select("
        r.id_resume,
        r.id_pep,
        p.no_protokol, 
        p.judul, 
        p.waktu_mulai, 
        p.waktu_selesai, 
        p.inserted as tanggal_pengajuan, 
        k.nama_kepk,
        r.inserted as tanggal_resume
      ");
    $this->db->from('tb_resume as r');
    $this->db->join('tb_pep as e', 'e.id_pep = r.id_pep');
    $this->db->join('tb_pengajuan as p', 'p.id_pengajuan = e.id_pengajuan');
    $this->db->join('tb_kepk as k', 'k.id_kepk = p.id_kepk');
    $this->db->where('r.id_atk_sekretaris', $id_atk_sekretaris); 
    $this->db->where('p.id_kepk', $this->session->userdata('id_kepk_tim')); // hanya menampilkan dari kepk yg sama

    // proses parameter pencarian, jika ada
    if (isset($param['_search']) && $param['_search'] == 'true' )
    {
      $fld = $param['search_fld'];
      switch($fld){
        case 'tgl_pengajuan': $str = prepare_date($param['search_str']); break;
        case 'mulai': $str = prepare_date($param['search_str']); break;
        case 'selesai': $str = prepare_date($param['search_str']); break;
        case 'tgl_resume': $str = prepare_date($param['search_str']); break;
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
		$id_atk_sekretaris = $this->get_id_atk($this->session->userdata('id_user_'.APPAUTH));
		
		$this->db->select('r.id_resume, r.resume, r.surat_pengantar_cek, r.bukti_bayar_cek, r.pep_cek, r.self_assesment_cek, r.lanjut_telaah, r.alasan_tbd, r.alasan_ditolak');
		$this->db->from('tb_resume as r');
		$this->db->where('r.id_resume', $id);
		$result = $this->db->get()->row_array();

		return $result;
	}

	function get_data_protokol()
	{
		/*
			jika sudah diresume sekretaris lain, maka sekretaris lain tidak bisa meresume
		*/
		// $id_atk_sekretaris = $this->get_id_atk($this->session->userdata('id_user_'.APPAUTH));

		$this->db->select('e.id_pep, p.no_protokol, p.judul, e.revisi_ke, kr.inserted');
		$this->db->from('tb_pep as e');
		$this->db->join('tb_pengajuan as p', 'p.id_pengajuan = e.id_pengajuan');
		$this->db->join('tb_kirim_ke_kepk as kr', 'kr.id_pengajuan = e.id_pengajuan and kr.id_pep = e.id_pep and kr.id_kepk = p.id_kepk');
		$this->db->join('tb_resume as r', 'r.id_pep = e.id_pep', 'left');
		$this->db->where('p.id_kepk', $this->session->userdata('id_kepk_tim'));
		$this->db->where('(e.revisi_ke = 0 or (e.revisi_ke > 0 and kr.klasifikasi = 4))');
		$this->db->where('r.id_resume is null');
		$result = $this->db->get()->result_array();

		return $result;
	}

	public function get_data_pengajuan_by_idpep($id_pep)
	{
		$this->db->select('p.id_pengajuan, p.no_protokol, p.judul, p.nama_ketua, p.tempat_penelitian, p.is_multi_senter, p.is_setuju_senter, p.telp_peneliti, p.email_peneliti, p.waktu_mulai, p.waktu_selesai');
		$this->db->from('tb_pengajuan as p');
		$this->db->join('tb_pep as e', 'e.id_pengajuan = p.id_pengajuan');
		$this->db->where('e.id_pep', $id_pep);
		$result = $this->db->get()->row_array();

		return $result;
	}

	public function get_data_pep_by_idpep($id_pep)
	{
		$this->db->select('e.*');
		$this->db->from('tb_pep as e');
		$this->db->where('e.id_pep', $id_pep);
		$result = $this->db->get()->row_array();

		return $result;
	}

	public function get_data_surat_pengantar_by_idpep($id_pep)
	{
		$this->db->select('sp.*');
		$this->db->from('tb_surat_pengantar as sp');
		$this->db->join('tb_pep as e', 'e.id_pengajuan = sp.id_pengajuan');
		$this->db->where('e.id_pep', $id_pep);
		$result = $this->db->get()->row_array();

		return $result;
	}

	public function get_data_bukti_bayar_by_idpep($id_pep)
	{
		$this->db->select('bb.*');
		$this->db->from('tb_bukti_bayar as bb');
		$this->db->join('tb_pep as e', 'e.id_pengajuan = bb.id_pengajuan');
		$this->db->where('e.id_pep', $id_pep);
		$result = $this->db->get()->row_array();

		return $result;
	}

	public function get_data_lampiran_pep_by_idpep($id_pep)
	{
		$this->db->select('l.id_lampiran_pep, l.lampiran, l.client_name, l.file_name');
		$this->db->from('tb_lampiran_pep as l');
		$this->db->where('l.id_pep', $id_pep);
		$result = $this->db->get()->result_array();

		return $result;
	}

	public function get_data_standar_kelaikan($id_pep)
	{
		$this->db->select('e.id_pengajuan, e.revisi_ke');
		$this->db->from('tb_pep as e');
		$this->db->where('e.id_pep', $id_pep);
		$rs = $this->db->get()->row_array();
		$id_pengajuan = $rs['id_pengajuan'];
    	$revisi_ke = $rs['revisi_ke'];

		$this->db->select("jsk.*, msk.uraian as uraian_master, dsac.pilihan");
		$this->db->from('tb_jabaran_standar_kelaikan as jsk');
		$this->db->join('tb_master_standar_kelaikan as msk', 'msk.id_msk = jsk.id_msk');
		$this->db->join('tb_detail_sa_cek as dsac', 'dsac.id_jsk = jsk.id_jsk');
		$this->db->join('tb_self_assesment_cek as sac', 'sac.id_sac = dsac.id_sac and sac.id_pengajuan = '.$id_pengajuan.' and sac.revisi_ke = '.$revisi_ke);
		$result = $this->db->get()->result_array();

		return $result;
	}

	public function get_data_self_assesment_cek_by_idpep($id_pep)
	{
		$this->db->select('s.*');
		$this->db->from('tb_self_assesment_cek as s');
		$this->db->join('tb_pep as e', 'e.id_pengajuan = s.id_pengajuan and e.revisi_ke = s.revisi_ke');
		$this->db->where('e.id_pep', $id_pep);
		$result = $this->db->get()->row_array();

		return $result;
	}

	public function get_data_penelaah() 
  	{ 
		$this->db->select('a.id_atk, a.nomor, a.nama');
		$this->db->from('tb_anggota_tim_kepk as a');
		$this->db->join('tb_struktur_tim_kepk as s', 's.id_atk = a.id_atk');
		$this->db->join('tb_tim_kepk as tk','tk.id_tim_kepk = s.id_tim_kepk');
		$this->db->where('a.id_kepk', $this->session->userdata('id_kepk_tim'));
		$this->db->where('s.jabatan', 5);
		$this->db->where('tk.aktif', 1);
	    $result = $this->db->get()->result_array();

    	return $result;
  	}

	function get_data_penelaah_awal_by_id($id)
	{
		$this->db->select('pa.id_atk_penelaah');
		$this->db->from('tb_penelaah_awal as pa');
		$this->db->where('pa.id_resume', $id);
    	$result = $this->db->get()->result_array();

    	return $result;
	}

	function cek_duplikasi_resume($id, $id_pep)
  	{
	    $this->db->select('1')
          ->from('tb_resume')
          ->where('id_pep', $id_pep)
          ->where('id_resume <>', $id);
    	$rs = $this->db->get()->row_array();

	    if ($rs)
    		return TRUE;

    	return FALSE;
  	}

	function check_exist_data($id)
	{
		$this->db->select('lanjut_telaah')->from('tb_resume')->where('id_resume', $id);
		$rs1 = $this->db->get()->row_array();

		if (!$rs1)
			return FALSE;

		if ($rs1['lanjut_telaah'] == 'YA')
		{
			$this->db->select('1')->from('tb_telaah_awal as ta')
				->join('tb_resume as r', 'r.id_pep = ta.id_pep')
				->where('r.id_resume', $id);
			$rs2 = $this->db->get()->row_array();

			if ($rs2)
				return TRUE;

			return FALSE;
		}
		else if ($rs1['lanjut_telaah'] == 'TBD')
		{
			$this->db->select('1')->from('tb_ethical_revision as er')
				->join('tb_resume as r', 'r.id_pep = er.id_pep')
				->where('r.id_resume', $id);
			$rs2 = $this->db->get()->row_array();

			if ($rs2)
				return TRUE;

			return FALSE;
		}
		else return FALSE;
	}

	function delete_detail($id)
	{
		$this->delete_penelaah_awal($id);
		$this->delete_resume($id);
	}

	function delete_resume($id)
	{
		$this->db->where('id_resume', $id);
		$this->db->delete('tb_resume');
	}

	function delete_penelaah_awal($id)
	{
		$this->db->where('id_resume', $id);
		$this->db->delete('tb_penelaah_awal');
	}

}
