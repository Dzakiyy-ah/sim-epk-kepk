<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dokumen_pengarsipan_model extends Core_Model {

  var $fieldmap_filter;
	var $data_dokumen;
	var $purge_dokumen;

	public function __construct()
	{
		parent::__construct();

    $this->fieldmap_filter = array(
      'no_protokol' => 'p.no_protokol',
      'judul' => 'p.judul',
      'tgl_dokarsip' => 'date(da.inserted)',
    );
	}

	public function fill_data()
	{
		$id = $this->input->post('id') ? $this->input->post('id') : 0;
		$id_pengajuan = $this->input->post('id_pengajuan') ? $this->input->post('id_pengajuan') : 0;
		$id_atk_kesekretariatan = $this->get_id_atk_kesekretariatan($this->session->userdata('id_user_'.APPAUTH));

	  $this->data = array(
	  	'id_dok_arsip' => $id,
	  	'id_pengajuan' => $id_pengajuan,
	  	'id_atk_kesekretariatan' => $id_atk_kesekretariatan
	  );

		$dokumen = $this->input->post('dokumen') ? json_decode($this->input->post('dokumen')) : '';
		for ($b=0; $b<count($dokumen); $b++)
		{
			$id_dda = isset($dokumen[$b]->id) ? $dokumen[$b]->id : 0;
			$deskripsi = isset($dokumen[$b]->deskripsi) ? $dokumen[$b]->deskripsi : '';
			$client_name = isset($dokumen[$b]->client_name) ? $dokumen[$b]->client_name : '';
			$file_name = isset($dokumen[$b]->file_name) ? $dokumen[$b]->file_name : '';
			$file_size = isset($dokumen[$b]->file_size) ? $dokumen[$b]->file_size : '';
			$file_type = isset($dokumen[$b]->file_type) ? $dokumen[$b]->file_type : '';
			$file_ext = isset($dokumen[$b]->file_ext) ? $dokumen[$b]->file_ext : '';
			$this->data_dokumen[] = array('id_dda'=>$id_dda, 'file_name'=>$file_name, 'deskripsi'=>$deskripsi, 'client_name'=>$client_name, 'file_size'=>$file_size, 'file_type'=>$file_type, 'file_ext'=>$file_ext);
		}
		$this->purge_dokumen = $this->input->post('purge_dokumen') ? $this->input->post('purge_dokumen') : '';

		$this->purge_filename = $this->input->post('purge_filename') ? $this->input->post('purge_filename') : '';
	}

	public function save_detail()
	{
		$this->insert_dokumen_pengarsipan();
		$this->insert_detail_surat();
	}

	function insert_dokumen_pengarsipan()
	{
		if (isset($this->data['id_dok_arsip']) && $this->data['id_dok_arsip'] > 0)
		{
			$this->db->where('id_dok_arsip', $this->data['id_dok_arsip']);
			$this->db->update('tb_dokumen_pengarsipan', $this->data);
			$this->check_trans_status('update tb_dokumen_pengarsipan failed');
			$this->id = $this->data['id_dok_arsip'];

			$aktivitas = 'Edit Dokumen Pengarsipan Protokol '.$this->input->post('no_protokol');
			$id_user_kepk = $this->get_id_atk_kesekretariatan($this->session->userdata('id_user_'.APPAUTH));
			$id_user =$this->session->userdata('id_user_'.APPAUTH);
			simpan_logaktivitas_tim_kepk($aktivitas, $id_user_kepk, $id_user);
		}
		else
		{
			unset($this->data['id_dok_arsip']);
			$this->db->insert('tb_dokumen_pengarsipan', $this->data);
			$this->check_trans_status('insert tb_dokumen_pengarsipan failed');
			$this->id = $this->db->insert_id();

			$aktivitas = 'Insert Dokumen Pengarsipan Protokol '.$this->input->post('no_protokol');
			$id_user_kepk = $this->get_id_atk_kesekretariatan($this->session->userdata('id_user_'.APPAUTH));
			$id_user =$this->session->userdata('id_user_'.APPAUTH);
			simpan_logaktivitas_tim_kepk($aktivitas, $id_user_kepk, $id_user);
		}		
	}

	public function insert_detail_surat()
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
			$this->db->where_in('id_dda', $this->purge_dokumen);
			$this->db->delete('tb_detail_dokarsip');
			$this->check_trans_status('delete tb_detail_dokarsip failed');
    }

  	for ($i=0; $i<count($this->data_dokumen); $i++)
  	{
  		$this->db->select('1')->from('tb_detail_dokarsip')->where('id_dda', $this->data_dokumen[$i]['id_dda'])->where('id_dok_arsip', $this->id);
  		$rs = $this->db->get()->row_array();

  		if ($rs)
  		{
  			$this->db->where('id_dok_arsip', $this->id);
  			$this->db->where('id_dda', $this->data_dokumen[$i]['id_dda']);
  			$this->db->update('tb_detail_dokarsip', $this->data_dokumen[$i]);
	  		$this->check_trans_status('update tb_detail_dokarsip failed');
  		}
  		else
  		{
	  		unset($this->data_dokumen[$i]['id_dda']);
  			$this->data_dokumen[$i]['id_dok_arsip'] = $this->id;
  			$this->db->insert('tb_detail_dokarsip', $this->data_dokumen[$i]);
	  		$this->check_trans_status('insert tb_detail_dokarsip failed');
  		}
  	}
	}

	function get_id_atk_kesekretariatan($id_user)
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
    $id_atk_kesekretariatan = $this->get_id_atk_kesekretariatan($this->session->userdata('id_user_'.APPAUTH));

    $this->db->select("
        da.id_dok_arsip,
        p.no_protokol, 
        p.judul, 
        da.inserted as tanggal_dokarsip
      ");
    $this->db->from('tb_dokumen_pengarsipan as da');
    $this->db->join('tb_pengajuan as p', 'p.id_pengajuan = da.id_pengajuan');
    $this->db->where('da.id_atk_kesekretariatan', $id_atk_kesekretariatan);
    $this->db->order_by('da.inserted', 'desc');

    // proses parameter pencarian, jika ada
    if (isset($param['_search']) && $param['_search'] == 'true' )
    {
      $fld = $param['search_fld'];
      switch($fld){
        case 'tanggal_dokarsip': $str = prepare_date($param['search_str']); break;
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
		$this->db->select('da.id_dok_arsip, da.id_pengajuan, p.no_protokol, p.judul, p.nama_ketua, p.tempat_penelitian, p.is_multi_senter, p.is_setuju_senter');
		$this->db->from('tb_dokumen_pengarsipan as da');
    $this->db->join('tb_pengajuan as p', 'p.id_pengajuan = da.id_pengajuan');
		$this->db->where('da.id_dok_arsip', $id);
		$result = $this->db->get()->row_array();

		return $result;
	}

  function get_data_pengajuan_by_idpengajuan($id_pengajuan)
  {
    $this->db->select('p.judul, p.nama_ketua, p.tempat_penelitian, p.is_multi_senter, p.is_setuju_senter');
    $this->db->from('tb_pengajuan as p');
    $this->db->where('p.id_pengajuan', $id_pengajuan);
    $result = $this->db->get()->row_array();

    return $result;
  }

	function get_data_fileupload_by_id($id)
	{
		$this->db->select('d.id_dda, d.deskripsi, d.file_name, d.client_name, d.file_size, d.file_type, d.file_ext');
		$this->db->from('tb_detail_dokarsip as d');
		$this->db->where('d.id_dok_arsip', $id);
		$result = $this->db->get()->result_array();

		return $result;
	}

	function get_data_protokol()
	{
    $this->db->select('p.id_pengajuan, p.no_protokol, p.judul');
    $this->db->from('tb_pengajuan as p');
    $this->db->join('tb_dokumen_pengarsipan as da', 'da.id_pengajuan = p.id_pengajuan', 'left');
    $this->db->where('da.id_dok_arsip is null');
		$result = $this->db->get()->result_array();

		return $result;
	}

  function get_data_pep_by_id_pengajuan($id_pengajuan)
  {
    $this->db->select('e.id_pep, e.link_proposal, e.revisi_ke');
    $this->db->from('tb_pep as e');
    $this->db->where('e.id_pengajuan', $id_pengajuan);
    $result = $this->db->get()->result_array();

    return $result;
  }

  function get_data_surat_surat_by_id_pengajuan($id_pengajuan)
  {
    $query = "
      select ee.id_pep, 'ethical_exemption' as jenis_surat, 'Ethical Exemption' as nama_surat, 1 as klasifikasi
      from tb_ethical_exemption as ee
      join tb_pep as e on e.id_pep = ee.id_pep
      where e.id_pengajuan = ".$id_pengajuan."

      union

      select ea.id_pep, 'ethical_approval' as jenis_surat, 'Ethical Approval' as nama_surat, kr.klasifikasi
      from tb_ethical_approval as ea
      join tb_pep as e on e.id_pep = ea.id_pep
      join tb_kirim_surat_ke_peneliti as kr on kr.id_pep = e.id_pep
      where e.id_pengajuan = ".$id_pengajuan."

      union

      select er.id_pep, 'ethical_revision' as jenis_surat, 'Ethical Revision' as nama_surat, kr.klasifikasi
      from tb_ethical_revision as er
      join tb_pep as e on e.id_pep = er.id_pep
      join tb_kirim_surat_ke_peneliti as kr on kr.id_pep = e.id_pep
      where e.id_pengajuan = ".$id_pengajuan."

      order by id_pep asc
    ";

		$result = $this->db->query($query)->result_array();

		return $result;
  }

  function get_data_protokol_by_id_pep($id_pep)
  {
    $this->db->select('e.*, p.no_protokol, p.judul, p.tempat_penelitian, p.is_multi_senter, p.is_setuju_senter');
    $this->db->from('tb_pep as e');
    $this->db->join('tb_pengajuan as p', 'p.id_pengajuan = e.id_pengajuan');
    $this->db->where('e.id_pep', $id_pep);
    $result = $this->db->get()->row_array();

    return $result;
  }

  function get_data_lampiran_ic_by_id_pep($id_pep)
  {
    $this->db->select('lp.lampiran, lp.file_name, lp.client_name');
    $this->db->from('tb_lampiran_pep as lp');
    $this->db->where('lp.id_pep', $id_pep);
    $result = $this->db->get()->result_array();

    return $result;
  }

	function get_data_pengajuan_by_id_pengajuan($id_pengajuan)
	{
		$this->db->select('p.no_protokol, p.judul, p.nama_ketua, p.telp_peneliti, p.email_peneliti, p.inserted as tanggal_pengajuan, k.nama_kepk');
		$this->db->from('tb_pengajuan as p');
		$this->db->join('tb_kepk as k', 'k.id_kepk = p.id_kepk');
		$this->db->where('p.id_pengajuan', $id_pengajuan);
		$result = $this->db->get()->row_array();

		return $result;
	}

	function get_data_timeline_protokol_by_id_pengajuan($id_pengajuan)
	{
    $this->db->select('vdpp.id_pengajuan, vdpp.aktivitas, vdpp.waktu_aktivitas, date(vdpp.waktu_aktivitas) as tanggal, time(vdpp.waktu_aktivitas) as waktu, vdpp.author, vdpp.id_pep, vdpp.klasifikasi_usulan, vdpp.klasifikasi_putusan, vdpp.revisi_ke, vdpp.resume, vdpp.lanjut_telaah, vdpp.alasan_tbd, vdpp.alasan_ditolak, vdpp.kelayakan, vdpp.catatan_protokol, vdpp.catatan_7standar, vdpp.keputusan, vdpp.no_dokumen');
    $this->db->from('v_detail_progress_protokol as vdpp');
    $this->db->where('vdpp.id_pengajuan', $id_pengajuan);
    $this->db->order_by('vdpp.waktu_aktivitas');
    $result = $this->db->get()->result_array();

		return $result;
	}

  function get_data_penelaah_awal_by_id_pengajuan($id_pengajuan)
  {
    $this->db->select('atk.nomor, atk.nama');
    $this->db->from('tb_anggota_tim_kepk as atk');
    $this->db->join('tb_penelaah_awal as pa', 'pa.id_atk_penelaah = atk.id_atk');
    $this->db->join('tb_resume as r', 'r.id_resume = pa.id_resume');
    $this->db->join('tb_pep as e', 'e.id_pep = r.id_pep');
    $this->db->where('e.id_pengajuan', $id_pengajuan);
    $result = $this->db->get()->result_array();

    return $result;
  }

	function get_data_penelaah_by_id_pengajuan($id_pengajuan)
	{
		$query = "
			select e.id_pep, atk.nomor, atk.nama, 'Pelapor' as jabatan, 'Putusan Awal' as aktivitas
			from tb_anggota_tim_kepk as atk
			join tb_putusan_awal as pa on pa.id_atk_pelapor = atk.id_atk
			join tb_pep as e on e.id_pep = pa.id_pep
			where e.id_pengajuan = ".$id_pengajuan."

			union 

			select e.id_pep, atk.nomor, atk.nama, 'Penelaah' as jabatan, 'Putusan Awal' as aktivitas
			from tb_anggota_tim_kepk as atk
			join tb_penelaah_mendalam as pm on pm.id_atk_penelaah = atk.id_atk
			join tb_putusan_awal as pa on pa.id_pa = pm.id_pa
			join tb_pep as e on e.id_pep = pa.id_pep
			where e.id_pengajuan = ".$id_pengajuan."
			  and atk.id_atk not in (select pa2.id_atk_pelapor from tb_putusan_awal as pa2 where pa2.id_pa = pa.id_pa)
			  
			union 

			select e.id_pep, atk.nomor, atk.nama, 'Lay Person' as jabatan, 'Putusan Awal' as aktivitas
			from tb_anggota_tim_kepk as atk
			join tb_lay_person as lp on lp.id_atk_lay_person = atk.id_atk
			join tb_putusan_awal as pa on pa.id_pa = lp.id_pa
			join tb_pep as e on e.id_pep = pa.id_pep
			where e.id_pengajuan = ".$id_pengajuan." 

			union 

			select e.id_pep, atk.nomor, atk.nama, 'Konsultan Independen' as jabatan, 'Putusan Awal' as aktivitas
			from tb_anggota_tim_kepk as atk
			join tb_konsultan_independen as ki on ki.id_atk_konsultan = atk.id_atk
			join tb_putusan_awal as pa on pa.id_pa = ki.id_pa
			join tb_pep as e on e.id_pep = pa.id_pep
			where e.id_pengajuan = ".$id_pengajuan."

      union		

      select e.id_pep, atk.nomor, atk.nama, 'Pelapor' as jabatan, 'Putusan Expedited ke Full Board' as aktivitas
      from tb_anggota_tim_kepk as atk
      join tb_putusan_awal_expedited_to_fullboard as paef on paef.id_atk_pelapor = atk.id_atk
      join tb_pep as e on e.id_pep = paef.id_pep
      where e.id_pengajuan = ".$id_pengajuan."

      union 

      select e.id_pep, atk.nomor, atk.nama, 'Penelaah' as jabatan, 'Putusan Expedited ke Full Board' as aktivitas
      from tb_anggota_tim_kepk as atk
      join tb_penelaah_mendalam_exptofb as pmef on pmef.id_atk_penelaah = atk.id_atk
      join tb_putusan_awal_expedited_to_fullboard as paef on paef.id_paef = pmef.id_paef
      join tb_pep as e on e.id_pep = paef.id_pep
      where e.id_pengajuan = ".$id_pengajuan."
        and atk.id_atk not in (select paef2.id_atk_pelapor from tb_putusan_awal_expedited_to_fullboard as paef2 where paef2.id_paef = paef.id_paef)
        
      union 

      select e.id_pep, atk.nomor, atk.nama, 'Lay Person' as jabatan, 'Putusan Expedited ke Full Board' as aktivitas
      from tb_anggota_tim_kepk as atk
      join tb_lay_person_exptofb as lp on lp.id_atk_lay_person = atk.id_atk
      join tb_putusan_awal_expedited_to_fullboard as paef on paef.id_paef = lp.id_paef
      join tb_pep as e on e.id_pep = paef.id_pep
      where e.id_pengajuan = ".$id_pengajuan." 

      union 

      select e.id_pep, atk.nomor, atk.nama, 'Konsultan Independen' as jabatan, 'Putusan Expedited ke Full Board' as aktivitas
      from tb_anggota_tim_kepk as atk
      join tb_konsultan_independen_exptofb as ki on ki.id_atk_konsultan = atk.id_atk
      join tb_putusan_awal_expedited_to_fullboard as paef on paef.id_paef = ki.id_paef
      join tb_pep as e on e.id_pep = paef.id_pep
      where e.id_pengajuan = ".$id_pengajuan."		
    ";

		$result = $this->db->query($query)->result_array();

		return $result;
	}

  function get_data_kop_surat()
  {
    $this->db->select('ks.file_name');
    $this->db->from('tb_kop_surat as ks');
    $this->db->where('ks.id_kepk', $this->session->userdata('id_kepk'));
    $result = $this->db->get()->row_array();

    return $result;
  }

  function get_data_ttd_ketua()
  {
    $this->db->select('tk.file_name');
    $this->db->from('tb_tandatangan_ketua as tk');
    $this->db->where('tk.id_kepk', $this->session->userdata('id_kepk'));
    $result = $this->db->get()->row_array();

    return $result;
  }

	function get_data_ketua_kepk()
	{
		$this->db->select('a.id_kepk, a.nama, a.nomor, a.nik');
		$this->db->from('tb_anggota_tim_kepk as a');
		$this->db->join('tb_struktur_tim_kepk as s', 's.id_atk = a.id_atk');
		$this->db->join('tb_tim_kepk as tk', 'tk.id_tim_kepk = s.id_tim_kepk');
		$this->db->where('s.jabatan', 1);
		$this->db->where('tk.id_kepk', $this->session->userdata('id_kepk_tim'));
		$this->db->where('tk.aktif', 1);
		$result = $this->db->get()->row_array();

		return $result;
	}

  function get_data_ethical_exemption_by_id_pep($id_pep)
	{
		$this->db->select("
			ee.no_surat, 
			ee.no_dokumen,
			ee.tanggal_surat, 
			ee.awal_berlaku, 
			ee.akhir_berlaku, 
			p.no_protokol, 
			p.judul, 
			p.title,
			p.nama_ketua,
			p.nama_institusi,
			p.id_pengajuan
		");
		$this->db->from('tb_ethical_exemption as ee');
		$this->db->join('tb_pep as e', 'e.id_pep = ee.id_pep');
		$this->db->join('tb_pengajuan as p', 'p.id_pengajuan = e.id_pengajuan');
		$this->db->where('ee.id_pep', $id_pep);
		$result = $this->db->get()->row_array();

		return $result;
	}

	function get_data_ethical_approval_by_id_pep($id_pep)
	{
		$this->db->select("
			ea.no_surat, 
			ea.no_dokumen,
			ea.tanggal_surat, 
			ea.awal_berlaku, 
			ea.akhir_berlaku,
      e.revisi_ke, 
			p.no_protokol, 
			p.judul, 
			p.title,
			p.nama_ketua,
			p.nama_institusi,
			p.id_pengajuan
		");
		$this->db->from('tb_ethical_approval as ea');
		$this->db->join('tb_pep as e', 'e.id_pep = ea.id_pep');
		$this->db->join('tb_pengajuan as p', 'p.id_pengajuan = e.id_pengajuan');
		$this->db->where('ea.id_pep', $id_pep);
		$result = $this->db->get()->row_array();

		return $result;
	}

	function get_data_ethical_revision_by_id_pep($id_pep)
	{
		$this->db->select("
			er.no_surat, 
			er.no_dokumen,
			er.tanggal_surat, 
			er.awal_berlaku, 
			er.akhir_berlaku, 
			p.no_protokol, 
			p.judul, 
			p.nama_ketua,
			p.id_pengajuan,
			kr.klasifikasi,
			k.kodefikasi,
			k.nama_kepk,
			k.alamat,
			k.email,
			k.no_telepon
		");
		$this->db->from('tb_ethical_revision as er');
		$this->db->join('tb_pep as e', 'e.id_pep = er.id_pep');
		$this->db->join('tb_pengajuan as p', 'p.id_pengajuan = e.id_pengajuan');
		$this->db->join('tb_kirim_putusan_ke_sekretariat as kr', 'kr.id_pep = er.id_pep');
		$this->db->join('tb_kepk as k', 'k.id_kepk = p.id_kepk');
		$this->db->where('er.id_pep', $id_pep);
		$result = $this->db->get()->row_array();

		return $result;
	}

  function get_anggota_penelitian_by_id_pengajuan($id_pengajuan)
	{
		$this->db->select('ap.nama, p.nomor');
		$this->db->from('tb_anggota_penelitian as ap');
		$this->db->join('tb_pengusul as p', 'p.id_pengusul = ap.id_pengusul');
		$this->db->where('ap.id_pengajuan', $id_pengajuan);
		$result = $this->db->get()->result_array();

		return $result;
	}

  public function get_data_standar_kelaikan($id_pep)
	{
		$this->db->select('e.id_pengajuan, coalesce(pa.id_pa, 0) as id_pa');
		$this->db->from('tb_pep as e');
    $this->db->join('tb_putusan_awal as pa', 'pa.id_pep = e.id_pep', 'left');
		$this->db->where('e.id_pep', $id_pep);
		$rs = $this->db->get()->row_array();
		$id_pengajuan = isset($rs['id_pengajuan']) ? $rs['id_pengajuan'] : 0;
    $id_pa = isset($rs['id_pa']) ? $rs['id_pa'] : 0;

		$this->db->select("jsk.*, msk.uraian as uraian_master, dsac.pilihan as pilihan_pengaju, pasa.pilihan as pilihan_sekretaris");
		$this->db->from('tb_jabaran_standar_kelaikan as jsk');
		$this->db->join('tb_master_standar_kelaikan as msk', 'msk.id_msk = jsk.id_msk');
		$this->db->join('tb_detail_sa_cek as dsac', 'dsac.id_jsk = jsk.id_jsk');
		$this->db->join('tb_self_assesment_cek as sac', 'sac.id_sac = dsac.id_sac and sac.id_pengajuan = '.$id_pengajuan);
		$this->db->join('tb_putusan_awal_self_assesment as pasa', 'pasa.id_jsk = jsk.id_jsk and pasa.id_pa = '.$id_pa, 'left');
		$result = $this->db->get()->result_array();

		return $result;
	}

  public function get_data_telaah_expedited_by_idpep($id_pep)
  {
    $this->db->select('te.id_texp, te.catatan_protokol, te.catatan_7standar');
    $this->db->from('tb_telaah_expedited as te');
    $this->db->where('te.id_pep', $id_pep);
    $result = $this->db->get()->result_array();

    return $result;
  }

  public function get_data_telaah_fullboard_by_idpep($id_pep)
  {
    $this->db->select('tf.id_tfbd, tf.catatan_protokol, tf.catatan_7standar');
    $this->db->from('tb_telaah_fullboard as tf');
    $this->db->where('tf.id_pep', $id_pep);
    $result = $this->db->get()->result_array();

    return $result;
  }

  function get_data_alasan_tbd_by_idpep($id_pep)
  {
  	$this->db->select('r.alasan_tbd');
  	$this->db->from('tb_resume as r');
  	$this->db->where('r.id_pep', $id_pep);
    $result = $this->db->get()->row_array();

    return $result;
  }

}
