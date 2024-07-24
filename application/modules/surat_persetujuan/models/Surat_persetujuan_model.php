<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Surat_persetujuan_model extends Core_Model {

  var $fieldmap_filter;
  var $no_dokumen;

	public function __construct()
	{
		parent::__construct();

    $this->fieldmap_filter = array(
      'no_protokol' => 'p.no_protokol',
      'judul' => 'p.judul',
      'no_surat' => 'ea.no_surat',
      'tgl_surat' => 'date(ea.tanggal_surat)',
    );
	}

	public function fill_data()
	{
		$id = $this->input->post('id') ? $this->input->post('id') : 0;
		$id_pep = $this->input->post('id_pep') ? $this->input->post('id_pep') : 0;
		$no_surat = $this->input->post('no_surat') ? $this->input->post('no_surat') : '';
		$tgl_surat = $this->input->post('tgl_surat') ? date('Y-m-d', strtotime($this->input->post('tgl_surat'))) : '';
		$awal_berlaku = $this->input->post('awal_berlaku') ? date('Y-m-d', strtotime($this->input->post('awal_berlaku'))) : '';
		$akhir_berlaku = $this->input->post('akhir_berlaku') ? date('Y-m-d', strtotime($this->input->post('akhir_berlaku'))) : '';
		$id_atk_kesekretariatan = $this->get_id_atk_kesekretariatan($this->session->userdata('id_user_'.APPAUTH));
		$id_atk_ketua = $this->get_id_atk_ketua($this->session->userdata('id_kepk_tim'));
		$this->no_dokumen = $this->get_no_dokumen();

	  $this->data = array(
	  	'id_ethical_approval' => $id,
	  	'id_pep' => $id_pep,
	  	'id_atk_kesekretariatan' => $id_atk_kesekretariatan,
	  	'id_atk_ketua' => $id_atk_ketua,
	  	'no_surat' => $no_surat,
		'no_dokumen' => $this->no_dokumen,
	  	'tanggal_surat' => $tgl_surat,
	  	'awal_berlaku' => $awal_berlaku,
	  	'akhir_berlaku' => $akhir_berlaku,
	  );

	}

	public function save_detail()
	{
		$this->insert_ethical();
	}

	function insert_ethical()
	{
		if (isset($this->data['id_ethical_approval']) && $this->data['id_ethical_approval'] > 0)
		{
			unset($this->data['no_dokumen']);
			$this->db->where('id_ethical_approval', $this->data['id_ethical_approval']);
			$this->db->update('tb_ethical_approval', $this->data);
			$this->check_trans_status('update tb_ethical_approval failed');
			$this->id = $this->data['id_ethical_approval'];

			$aktivitas = 'Edit Surat Persetujuan Etik Protokol '.$this->input->post('no_protokol');
			$id_user_kepk = $this->get_id_atk_kesekretariatan($this->session->userdata('id_user_'.APPAUTH));
			$id_user =$this->session->userdata('id_user_'.APPAUTH);
			simpan_logaktivitas_tim_kepk($aktivitas, $id_user_kepk, $id_user);
		}
		else
		{
			unset($this->data['id_ethical_approval']);
			$this->db->insert('tb_ethical_approval', $this->data);
			$this->check_trans_status('insert tb_ethical_approval failed');
			$this->id = $this->db->insert_id();

			$aktivitas = 'Insert Surat Persetujuan Etik Protokol '.$this->input->post('no_protokol');
			$id_user_kepk = $this->get_id_atk_kesekretariatan($this->session->userdata('id_user_'.APPAUTH));
			$id_user =$this->session->userdata('id_user_'.APPAUTH);
			simpan_logaktivitas_tim_kepk($aktivitas, $id_user_kepk, $id_user);
		}		
	}

	function kirim_data()
	{
		$this->db->trans_start();
		try {

			$id_atk_kesekretariatan = $this->get_id_atk_kesekretariatan($this->session->userdata('id_user_'.APPAUTH));
			$id_pep = $this->input->post('id_pep') ? $this->input->post('id_pep') : 0;
			$klas = $this->input->post('klasifikasi');
			switch($klas){
				case 'Expedited': $klasifikasi = 2; break;
				case 'Full Board': $klasifikasi = 3; break;
				default: $klasifikasi = 0;
			}
			$keputusan = 'LE';
			$jenis_surat = 'Persetujuan Etik';
			$no_protokol = $this->input->post('no_protokol') ? $this->input->post('no_protokol') : '';

			$this->db->select('1')->from('tb_kirim_surat_ke_peneliti')->where('id_pep', $id_pep);
			$rs = $this->db->get()->row_array();

			$data = array(
				'id_pep'=>$id_pep, 
				'id_kepk'=>$this->session->userdata('id_kepk_tim'),
				'id_atk_kesekretariatan'=>$id_atk_kesekretariatan,
				'klasifikasi'=>$klasifikasi,
				'keputusan'=>$keputusan,
				'jenis_surat'=>$jenis_surat
			);

			if ($rs)
			{
				$this->db->where('id_pep', $id_pep);
				$this->db->update('tb_kirim_surat_ke_peneliti', $data);
				$this->check_trans_status('update tb_kirim_surat_ke_peneliti failed');
			}
			else
			{
				$this->db->insert('tb_kirim_surat_ke_peneliti', $data);
				$this->check_trans_status('insert tb_kirim_surat_ke_peneliti failed');
			}

			$aktivitas = 'Kirim Surat '.$jenis_surat.' Protokol '.$no_protokol.' ke Peneliti';
			$id_user_kepk = $id_atk_kesekretariatan;
			$id_user =$this->session->userdata('id_user_'.APPAUTH);
			simpan_logaktivitas_tim_kepk($aktivitas, $id_user_kepk, $id_user);

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

	function get_no_dokumen()
	{
		$this->db->select('k.kodefikasi');
		$this->db->from('tb_kepk as k');
		$this->db->where('k.id_kepk', $this->session->userdata('id_kepk'));
		$result = $this->db->get()->row_array();
		$kodefikasi = $result['kodefikasi'];

		$year = date('Y');
		$this->db->select('max(left(ea.no_dokumen,5)) as max_no');
		$this->db->from('tb_ethical_approval as ea');
		$this->db->where('year(ea.inserted)', $year);
		$rs = $this->db->get()->row_array();

		if ($rs) {
			$max_no = (int)$rs['max_no'];
			$no = $max_no + 1;
		}
		else $no = 1;

		$len = strlen($no);
		$nol = '';
		while($len<=4){
			$nol .= '0';
			$len++;
		}

		return $nol.$no.'/EA/'.$year.'/'.$kodefikasi;
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

	function get_id_atk_ketua($id_kepk)
	{
		$this->db->select('stk.id_atk');
		$this->db->from('tb_struktur_tim_kepk as stk');
		$this->db->join('tb_tim_kepk as t', 't.id_tim_kepk = stk.id_tim_kepk');
		$this->db->join('(select s.id_tim_kepk from tb_struktur_tim_kepk as s join tb_users as u on u.id_stk = s.id_stk where u.id_user = '.$this->session->userdata('id_user_'.APPAUTH).') as x', 'x.id_tim_kepk = stk.id_tim_kepk');
		$this->db->where('stk.jabatan', 1);
		$this->db->where('t.id_kepk', $id_kepk);
		$result = $this->db->get()->row_array();

		return $result['id_atk'];
	}

  public function get_data_jqgrid($param, $isCount=FALSE, $CompileOnly=False)
  {
    $id_atk_kesekretariatan = $this->get_id_atk_kesekretariatan($this->session->userdata('id_user_'.APPAUTH));

    $this->db->select("
        ea.id_ethical_approval,
        ea.no_surat,
        ea.tanggal_surat,
        p.no_protokol, 
        p.judul
      ");
    $this->db->from('tb_ethical_approval as ea');
    $this->db->join('tb_pep as e', 'e.id_pep = ea.id_pep');
    $this->db->join('tb_pengajuan as p', 'p.id_pengajuan = e.id_pengajuan');
    $this->db->where('ea.id_atk_kesekretariatan', $id_atk_kesekretariatan);

    // proses parameter pencarian, jika ada
    if (isset($param['_search']) && $param['_search'] == 'true' )
    {
      $fld = $param['search_fld'];
      switch($fld){
        case 'tgl_surat': $str = prepare_date($param['search_str']); break;
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
		$this->db->select("
			ea.*, 
			p.no_protokol, 
			p.judul, 
			if(kr.keputusan='LE', 'Layak Etik', '') as keputusan, 
			case kr.klasifikasi
				when 2 then 'Expedited'
				when 3 then 'Full Board'
			end as klasifikasi
		");
		$this->db->from('tb_ethical_approval as ea');
		$this->db->join('tb_pep as e', 'e.id_pep = ea.id_pep');
		$this->db->join('tb_pengajuan as p', 'p.id_pengajuan = e.id_pengajuan');
		$this->db->join('tb_kirim_putusan_ke_sekretariat as kr', 'kr.id_pep = ea.id_pep');
		$this->db->where('ea.id_ethical_approval', $id);
		$result = $this->db->get()->row_array();

		return $result;
	}

	function get_data_ethical_approval_by_id($id)
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
		$this->db->where('ea.id_ethical_approval', $id);
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

	function get_data_protokol()
	{
		$this->db->select("
			kr.id_pep,
			case kr.klasifikasi
				when 2 then 'Expedited'
				when 3 then 'Full Board'
			end as klasifikasi,
			if(kr.keputusan='LE', 'Layak Etik', '') as keputusan,
			p.no_protokol,
			p.judul
		");
		$this->db->from('tb_kirim_putusan_ke_sekretariat as kr');
		$this->db->join('tb_pep as e', 'e.id_pep = kr.id_pep');
		$this->db->join('tb_pengajuan as p', 'p.id_pengajuan = e.id_pengajuan');
    $this->db->join('tb_ethical_approval as ep', 'ep.id_pep = e.id_pep', 'left');
		$this->db->where('kr.keputusan', 'LE');
		$this->db->where('kr.klasifikasi <> 1');
    $this->db->where('ep.id_ethical_approval is null');
		$this->db->where('p.id_kepk', $this->session->userdata('id_kepk_tim'));
		$result = $this->db->get()->result_array();

		return $result;
	}

	public function get_data_standar_kelaikan($id_pep)
	{
		$this->db->select('e.id_pengajuan, e.revisi_ke');
		$this->db->from('tb_pep as e');
		$this->db->where('e.id_pep', $id_pep);
		$rs = $this->db->get()->row_array();
		$id_pengajuan = isset($rs['id_pengajuan']) ? $rs['id_pengajuan'] : 0;
    $revisi_ke = isset($rs['revisi_ke']) ? $rs['revisi_ke'] : 0;

		$this->db->select("jsk.*, msk.uraian as uraian_master, dsac.pilihan as pilihan_pengaju,
				(select sa.pilihan from tb_putusan_expedited_self_assesment as sa join tb_putusan_expedited as ko on ko.id_pexp = sa.id_pexp
					where ko.id_pep = ".$id_pep." and sa.id_jsk = jsk.id_jsk
									union
					select sa2.pilihan from tb_putusan_fullboard_self_assesment as sa2 join tb_putusan_fullboard as ko2 on ko2.id_pfbd = sa2.id_pfbd
					where ko2.id_pep = ".$id_pep." and sa2.id_jsk = jsk.id_jsk) as pilihan_penelaah
		");
		$this->db->from('tb_jabaran_standar_kelaikan as jsk');
		$this->db->join('tb_master_standar_kelaikan as msk', 'msk.id_msk = jsk.id_msk');
		$this->db->join('tb_detail_sa_cek as dsac', 'dsac.id_jsk = jsk.id_jsk');
		$this->db->join('tb_self_assesment_cek as sac', 'sac.id_sac = dsac.id_sac and sac.id_pengajuan = '.$id_pengajuan.' and sac.revisi_ke = '.$revisi_ke);
		$result = $this->db->get()->result_array();

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

  function check_is_kirim($id)
  {
    $this->db->select('1')->from('tb_kirim_surat_ke_peneliti as kr')
        ->join('tb_ethical_approval as ea', 'ea.id_pep = kr.id_pep')
        ->where('ea.id_ethical_approval', $id);

    $rs = $this->db->get()->row_array();

    if ($rs)
      return 1;

    return 0;
  }

}
