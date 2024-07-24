<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Surat_perbaikan_model extends Core_Model {

  var $fieldmap_filter;
  var $no_dokumen;

	public function __construct()
	{
		parent::__construct();

    $this->fieldmap_filter = array(
      'no_protokol' => 'p.no_protokol',
      'judul' => 'p.judul',
      'no_surat' => 'er.no_surat',
      'tgl_surat' => 'date(er.tanggal_surat)',
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
	  	'id_ethical_revision' => $id,
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
		if (isset($this->data['id_ethical_revision']) && $this->data['id_ethical_revision'] > 0)
		{
			unset($this->data['no_dokumen']);
			$this->db->where('id_ethical_revision', $this->data['id_ethical_revision']);
			$this->db->update('tb_ethical_revision', $this->data);
			$this->check_trans_status('update tb_ethical_revision failed');
			$this->id = $this->data['id_ethical_revision'];

			$aktivitas = 'Edit Surat Perbaikan Etik Protokol '.$this->input->post('no_protokol');
			$id_user_kepk = $this->get_id_atk_kesekretariatan($this->session->userdata('id_user_'.APPAUTH));
			$id_user =$this->session->userdata('id_user_'.APPAUTH);
			simpan_logaktivitas_tim_kepk($aktivitas, $id_user_kepk, $id_user);
		}
		else
		{
			unset($this->data['id_ethical_revision']);
			$this->db->insert('tb_ethical_revision', $this->data);
			$this->check_trans_status('insert tb_ethical_revision failed');
			$this->id = $this->db->insert_id();

			$aktivitas = 'Insert Surat Perbaikan Etik Protokol '.$this->input->post('no_protokol');
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
			$keputusan = 'R';
			$jenis_surat = 'Perbaikan Etik';
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
		$this->db->select('max(left(er.no_dokumen,5)) as max_no');
		$this->db->from('tb_ethical_revision as er');
		$this->db->where('year(er.inserted)', $year);
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

		return $nol.$no.'/ER/'.$year.'/'.$kodefikasi;
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

		return isset($result['id_atk']) ? $result['id_atk'] : 0;
	}

  public function get_data_jqgrid($param, $isCount=FALSE, $CompileOnly=False)
  {
    $id_atk_kesekretariatan = $this->get_id_atk_kesekretariatan($this->session->userdata('id_user_'.APPAUTH));

    $this->db->select("
        er.id_ethical_revision,
        er.no_surat,
        er.tanggal_surat,
        p.no_protokol, 
        p.judul
      ");
    $this->db->from('tb_ethical_revision as er');
    $this->db->join('tb_pep as e', 'e.id_pep = er.id_pep');
    $this->db->join('tb_pengajuan as p', 'p.id_pengajuan = e.id_pengajuan');
    $this->db->where('er.id_atk_kesekretariatan', $id_atk_kesekretariatan);

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
			if(kr.keputusan='R', 'Perbaikan', '') as keputusan, 
			case kr.klasifikasi
				when 2 then 'Expedited'
				when 3 then 'Full Board'
				when 4 then 'Tidak Bisa Ditelaah'
			end as klasifikasi
		");
		$this->db->from('tb_ethical_revision as ea');
		$this->db->join('tb_pep as e', 'e.id_pep = ea.id_pep');
		$this->db->join('tb_pengajuan as p', 'p.id_pengajuan = e.id_pengajuan');
		$this->db->join('tb_kirim_putusan_ke_sekretariat as kr', 'kr.id_pep = ea.id_pep');
		$this->db->where('ea.id_ethical_revision', $id);
		$result = $this->db->get()->row_array();

		return $result;
	}

	function get_data_ethical_revision_by_id($id)
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
		$this->db->where('er.id_ethical_revision', $id);
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
				when 4 then 'Tidak Bisa Ditelaah'
			end as klasifikasi,
			if(kr.keputusan='R', 'Perbaikan', '') as keputusan,
			p.no_protokol,
			p.judul
		");
    $this->db->from('tb_kirim_putusan_ke_sekretariat as kr');
    $this->db->join('tb_pep as e', 'e.id_pep = kr.id_pep');
    $this->db->join('tb_pengajuan as p', 'p.id_pengajuan = e.id_pengajuan');
    $this->db->join('tb_ethical_revision as er', 'er.id_pep = e.id_pep', 'left');
    $this->db->where('kr.keputusan', 'R');
    $this->db->where('p.id_kepk', $this->session->userdata('id_kepk_tim'));
    $this->db->where('er.id_ethical_revision is null');
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

  function get_data_no_protokol_by_id_pep($id_pep)
  {
    $this->db->select('p.no_protokol');
    $this->db->from('tb_pengajuan as p');
    $this->db->join('tb_pep as e', 'e.id_pengajuan = p.id_pengajuan');
    $this->db->where('e.id_pep', $id_pep);
    $result = $this->db->get()->row_array();

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

  function check_is_kirim($id)
  {
    $this->db->select('1')->from('tb_kirim_surat_ke_peneliti as kr')
        ->join('tb_ethical_revision as er', 'er.id_pep = kr.id_pep')
        ->where('er.id_ethical_revision', $id);

    $rs = $this->db->get()->row_array();

    if ($rs)
      return 1;

    return 0;
  }

}
