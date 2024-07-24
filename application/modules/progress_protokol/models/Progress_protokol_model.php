<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Progress_protokol_model extends Core_Model {
	
	var $fieldmap_filter;

	public function __construct()
	{
		parent::__construct();

		$this->fieldmap_filter = array(
			'id' => 'a.id_pengajuan',
			'no_protokol' => 'a.no_protokol',
			'judul' => 'a.judul', 
      'tgl_pengajuan' => 'date(a.tanggal_pengajuan)',
      'tgl_protokol' =>  'date(a.tanggal_protokol)',
      'klasifikasi' => 'a.klasifikasi',
      'tgl_keputusan' => 'date(a.tanggal_keputusan)'
		);
	}

	function get_data_jqgrid($param, $isCount=FALSE, $CompileOnly=False)
	{
		$id_kepk = $this->input->post('id_kepk') ? $this->input->post('id_kepk') : 0;

    // get id_atk
    $this->db->select('stk.id_atk');
    $this->db->from('tb_struktur_tim_kepk as stk');
    $this->db->join('tb_users as u', 'u.id_stk = stk.id_stk');
    $this->db->where('u.id_user', $this->session->userdata('id_user_'.APPAUTH));
    $rs = $this->db->get()->row_array();
    $id_atk = isset($rs['id_atk']) ? $rs['id_atk'] : 0;

    $this->db->select('a.id_pengajuan, a.no_protokol, a.judul, a.id_kepk, a.nama_kepk, a.klasifikasi, a.tanggal_pengajuan, a.tanggal_protokol, a.tanggal_keputusan');
    $this->db->from('v_daftar_progress_protokol as a');

    if ($id_kepk > 0)
      $this->db->where('a.id_kepk', $id_kepk);

    if ($this->session->userdata('id_group_'.APPAUTH) == 3)
      $this->db->where('a.id_pengajuan in (select p.id_pengajuan from tb_pengajuan as p where p.id_pengusul = '.$this->session->userdata('id_pengusul').')');
    else if ($this->session->userdata('id_group_'.APPAUTH) == 4)
    {
      $this->db->where('a.id_kepk', $this->session->userdata('id_kepk_tim'));
      $this->db->where('
        a.id_pengajuan in (
          select e.id_pengajuan from tb_pep as e
          join tb_resume as r on r.id_pep = e.id_pep
          where r.id_atk_sekretaris = '.$id_atk.'

          union

          select e.id_pengajuan from tb_pep as e
          join tb_putusan_expedited as pe on pe.id_pep = e.id_pep
          where pe.id_atk_sekretaris = '.$id_atk.'

          union

          select e.id_pengajuan from tb_pep as e
          join tb_putusan_fullboard as pf on pf.id_pep = e.id_pep
          where pf.id_atk_sekretaris = '.$id_atk.'
        )
      ');
    }
    else if ($this->session->userdata('id_group_'.APPAUTH) == 5)
    {
      $this->db->where('a.id_kepk', $this->session->userdata('id_kepk_tim'));
      $this->db->where('
        a.id_pengajuan in (
          select e.id_pengajuan from tb_pep as e
          join tb_ethical_exemption as ee on ee.id_pep = e.id_pep
          where ee.id_atk_kesekretariatan = '.$id_atk.'

          union

          select e.id_pengajuan from tb_pep as e
          join tb_ethical_approval as ea on ea.id_pep = e.id_pep
          where ea.id_atk_kesekretariatan = '.$id_atk.'

          union

          select e.id_pengajuan from tb_pep as e
          join tb_ethical_revision as er on er.id_pep = e.id_pep
          where er.id_atk_kesekretariatan = '.$id_atk.'
        )
      ');
    }
    else if ($this->session->userdata('id_group_'.APPAUTH) == 7)
    {
      $this->db->where('a.id_kepk', $this->session->userdata('id_kepk_tim'));
      $this->db->where('
        a.id_pengajuan in (
          select e.id_pengajuan from tb_pep as e 
          join tb_putusan_awal as pa on pa.id_pep = e.id_pep
          where pa.id_atk_ketua = '.$id_atk.'

          union

          select e.id_pengajuan from tb_pep as e
          join tb_putusan_expedited as pe on pe.id_pep = e.id_pep
          where pe.id_atk_ketua = '.$id_atk.'

          union

          select e.id_pengajuan from tb_pep as e
          join tb_putusan_fullboard as pf on pf.id_pep = e.id_pep
          where pf.id_atk_ketua = '.$id_atk.'
        )'
      );
    }
    else if ($this->session->userdata('id_group_'.APPAUTH) == 8)
    {
      $this->db->where('a.id_kepk', $this->session->userdata('id_kepk_tim'));
      $this->db->where('
        a.id_pengajuan in (
          select e.id_pengajuan from tb_pep as e 
          join tb_putusan_awal as pa on pa.id_pep = e.id_pep
          where pa.id_atk_wakil_ketua = '.$id_atk.'

          union

          select e.id_pengajuan from tb_pep as e
          join tb_putusan_expedited as pe on pe.id_pep = e.id_pep
          where pe.id_atk_wakil_ketua = '.$id_atk.'

          union

          select e.id_pengajuan from tb_pep as e
          join tb_putusan_fullboard as pf on pf.id_pep = e.id_pep
          where pf.id_atk_wakil_ketua = '.$id_atk.'
        )'
      );
    }

    // proses parameter pencarian, jika ada
    if (isset($param['_search']) && $param['_search'] == 'true' )
    {
      $fld = $param['search_fld'];
      switch($fld){
        case 'tgl_pengajuan': $str = prepare_date($param['search_str']); break;
        case 'tgl_protokol': $str = prepare_date($param['search_str']); break;
        case 'tgl_keputusan': $str = prepare_date($param['search_str']); break;
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

  function get_data_penelaah_awal_by_id($id)
  {
    $this->db->select('atk.nomor, atk.nama');
    $this->db->from('tb_anggota_tim_kepk as atk');
    $this->db->join('tb_penelaah_awal as pa', 'pa.id_atk_penelaah = atk.id_atk');
    $this->db->join('tb_resume as r', 'r.id_resume = pa.id_resume');
    $this->db->join('tb_pep as e', 'e.id_pep = r.id_pep');
    $this->db->where('e.id_pengajuan', $id);
    $result = $this->db->get()->result_array();

    return $result;
  }

	function get_data_penelaah_by_id($id)
	{
		$query = "
			select e.id_pep, atk.nomor, atk.nama, 'Pelapor' as jabatan, 'Putusan Awal' as aktivitas
			from tb_anggota_tim_kepk as atk
			join tb_putusan_awal as pa on pa.id_atk_pelapor = atk.id_atk
			join tb_pep as e on e.id_pep = pa.id_pep
			where e.id_pengajuan = ".$id."

			union 

			select e.id_pep, atk.nomor, atk.nama, 'Penelaah' as jabatan, 'Putusan Awal' as aktivitas
			from tb_anggota_tim_kepk as atk
			join tb_penelaah_mendalam as pm on pm.id_atk_penelaah = atk.id_atk
			join tb_putusan_awal as pa on pa.id_pa = pm.id_pa
			join tb_pep as e on e.id_pep = pa.id_pep
			where e.id_pengajuan = ".$id."
			  and atk.id_atk not in (select pa2.id_atk_pelapor from tb_putusan_awal as pa2 where pa2.id_pa = pa.id_pa)
			  
			union 

			select e.id_pep, atk.nomor, atk.nama, 'Lay Person' as jabatan, 'Putusan Awal' as aktivitas
			from tb_anggota_tim_kepk as atk
			join tb_lay_person as lp on lp.id_atk_lay_person = atk.id_atk
			join tb_putusan_awal as pa on pa.id_pa = lp.id_pa
			join tb_pep as e on e.id_pep = pa.id_pep
			where e.id_pengajuan = ".$id." 

			union 

			select e.id_pep, atk.nomor, atk.nama, 'Konsultan Independen' as jabatan, 'Putusan Awal' as aktivitas
			from tb_anggota_tim_kepk as atk
			join tb_konsultan_independen as ki on ki.id_atk_konsultan = atk.id_atk
			join tb_putusan_awal as pa on pa.id_pa = ki.id_pa
			join tb_pep as e on e.id_pep = pa.id_pep
			where e.id_pengajuan = ".$id."

      union		

      select e.id_pep, atk.nomor, atk.nama, 'Pelapor' as jabatan, 'Putusan Expedited ke Full Board' as aktivitas
      from tb_anggota_tim_kepk as atk
      join tb_putusan_awal_expedited_to_fullboard as paef on paef.id_atk_pelapor = atk.id_atk
      join tb_pep as e on e.id_pep = paef.id_pep
      where e.id_pengajuan = ".$id."

      union 

      select e.id_pep, atk.nomor, atk.nama, 'Penelaah' as jabatan, 'Putusan Expedited ke Full Board' as aktivitas
      from tb_anggota_tim_kepk as atk
      join tb_penelaah_mendalam_exptofb as pmef on pmef.id_atk_penelaah = atk.id_atk
      join tb_putusan_awal_expedited_to_fullboard as paef on paef.id_paef = pmef.id_paef
      join tb_pep as e on e.id_pep = paef.id_pep
      where e.id_pengajuan = ".$id."
        and atk.id_atk not in (select paef2.id_atk_pelapor from tb_putusan_awal_expedited_to_fullboard as paef2 where paef2.id_paef = paef.id_paef)
        
      union 

      select e.id_pep, atk.nomor, atk.nama, 'Lay Person' as jabatan, 'Putusan Expedited ke Full Board' as aktivitas
      from tb_anggota_tim_kepk as atk
      join tb_lay_person_exptofb as lp on lp.id_atk_lay_person = atk.id_atk
      join tb_putusan_awal_expedited_to_fullboard as paef on paef.id_paef = lp.id_paef
      join tb_pep as e on e.id_pep = paef.id_pep
      where e.id_pengajuan = ".$id." 

      union 

      select e.id_pep, atk.nomor, atk.nama, 'Konsultan Independen' as jabatan, 'Putusan Expedited ke Full Board' as aktivitas
      from tb_anggota_tim_kepk as atk
      join tb_konsultan_independen_exptofb as ki on ki.id_atk_konsultan = atk.id_atk
      join tb_putusan_awal_expedited_to_fullboard as paef on paef.id_paef = ki.id_paef
      join tb_pep as e on e.id_pep = paef.id_pep
      where e.id_pengajuan = ".$id."		
    ";

		$result = $this->db->query($query)->result_array();

		return $result;
	}

	function get_data_kepk()
	{
		$this->db->select('k.id_kepk, k.nama_kepk');
		$this->db->from('tb_kepk as k');
		$this->db->order_by('k.nama_kepk');
		$result = $this->db->get()->result_array();

		return $result;
	}

	function get_data_timeline_protokol_by_id($id)
	{
    $this->db->select('vdpp.id_pengajuan, vdpp.aktivitas, vdpp.waktu_aktivitas, date(vdpp.waktu_aktivitas) as tanggal, time(vdpp.waktu_aktivitas) as waktu, vdpp.author, vdpp.id_pep, vdpp.klasifikasi_usulan, vdpp.klasifikasi_putusan, vdpp.revisi_ke, vdpp.resume, vdpp.lanjut_telaah, vdpp.alasan_tbd, vdpp.alasan_ditolak, vdpp.kelayakan, vdpp.catatan_protokol, vdpp.catatan_7standar, vdpp.keputusan, vdpp.no_dokumen');
    $this->db->from('v_detail_progress_protokol as vdpp');
    $this->db->where('vdpp.id_pengajuan', $id);
    $this->db->order_by('vdpp.waktu_aktivitas');
    $result = $this->db->get()->result_array();

		return $result;
	}

	function get_data_pengajuan_by_id($id)
	{
		$this->db->select('p.no_protokol, p.judul, p.nama_ketua, p.telp_peneliti, p.email_peneliti, p.inserted as tanggal_pengajuan, k.nama_kepk');
		$this->db->from('tb_pengajuan as p');
		$this->db->join('tb_kepk as k', 'k.id_kepk = p.id_kepk');
		$this->db->where('p.id_pengajuan', $id);
		$result = $this->db->get()->row_array();

		return $result;
	}

  function get_data_waktu_proses_terakhir_by_id($id)
  {
    $this->db->select('date(max(waktu_aktivitas)) as waktu_aktivitas');
    $this->db->from('v_detail_progress_protokol');
    $this->db->where('id_pengajuan', $id);
    $rs = $this->db->get()->row_array();

    return $rs['waktu_aktivitas'];
  }

  function get_data_waktu_kirim_ke_kepk_by_id($id)
  {
    $this->db->select('date(min(waktu_aktivitas)) as waktu_aktivitas'); // min krn dikirim ke kepk tidak cuma sekali jika ada perbaikan
    $this->db->from('v_detail_progress_protokol');
    $this->db->where('aktivitas', 'Kirim ke KEPK');
    $this->db->where('id_pengajuan', $id);
    $rs = $this->db->get()->row_array();

    return $rs['waktu_aktivitas'];
  }

}
