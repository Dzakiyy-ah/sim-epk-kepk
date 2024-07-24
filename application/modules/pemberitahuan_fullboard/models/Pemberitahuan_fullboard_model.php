<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pemberitahuan_fullboard_model extends Core_Model {

  var $fieldmap_filter;

	public function __construct()
	{
		parent::__construct();

    $this->fieldmap_filter = array(
      'no_protokol' => 'p.no_protokol',
      'judul' => 'p.judul',
      'nama_ketua' => 'p.nama_ketua',
      'telp_peneliti' => 'p.telp_peneliti',
      'email_peneliti' => 'p.email_peneliti',
      'tgl_fb' => 'date(pf.tgl_fullboard)',
      'jam_fb' => 'time(pf.jam_fullboard)',
      'tempat_fb' => 'pf.tempat_fullboard',
      'tgl_pemberitahuan' => 'date(pf.inserted)'
    );

	}

	public function fill_data()
	{
		$id = $this->input->post('id') ? $this->input->post('id') : 0;
		$id_pep = $this->input->post('id_pep') ? $this->input->post('id_pep') : 0;
		$id_atk_kesekretariatan = $this->get_id_atk_kesekretariatan($this->session->userdata('id_user_'.APPAUTH));
    $tgl_fb = $this->input->post('tgl_fb') ? date('Y-m-d', strtotime($this->input->post('tgl_fb'))) : null;
    $jam_fb = $this->input->post('jam_fb') ? $this->input->post('jam_fb') : null;
    $tempat_fb = $this->input->post('tempat_fb') ? $this->input->post('tempat_fb') : '';

	  $this->data = array(
	  	'id_bfbd' => $id,
	  	'id_pep' => $id_pep,
	  	'id_atk_kesekretariatan' => $id_atk_kesekretariatan,
      'tgl_fullboard' => $tgl_fb,
      'jam_fullboard' => $jam_fb,
      'tempat_fullboard' => $tempat_fb
	  );

	}

	public function save_detail()
	{
		$this->insert_pemberitahuan_fullboard();
	}

	function insert_pemberitahuan_fullboard()
	{
		if (isset($this->data['id_bfbd']) && $this->data['id_bfbd'] > 0)
		{
			$this->db->where('id_bfbd', $this->data['id_bfbd']);
			$this->db->update('tb_pemberitahuan_fullboard', $this->data);
			$this->check_trans_status('update tb_pemberitahuan_fullboard failed');
			$this->id = $this->data['id_bfbd'];

			$aktivitas = 'Edit Pemberitahuan Fullboard Protokol '.$this->input->post('no_protokol');
			$id_user_kepk = $this->get_id_atk_kesekretariatan($this->session->userdata('id_user_'.APPAUTH));
			$id_user =$this->session->userdata('id_user_'.APPAUTH);
			simpan_logaktivitas_tim_kepk($aktivitas, $id_user_kepk, $id_user);
		}
		else
		{
			unset($this->data['id_bfbd']);
			$this->db->insert('tb_pemberitahuan_fullboard', $this->data);
			$this->check_trans_status('insert tb_pemberitahuan_fullboard failed');
			$this->id = $this->db->insert_id();

			$aktivitas = 'Insert Pemberitahuan Fullboard Protokol '.$this->input->post('no_protokol');
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
  		$no_protokol = $this->input->post('no_protokol') ? $this->input->post('no_protokol') : '';

  		$this->db->select('1')->from('tb_kirim_bfbd_ke_peneliti')->where('id_pep', $id_pep);
  		$rs = $this->db->get()->row_array();

    	$data = array(
    		'id_pep'=>$id_pep, 
    		'id_kepk'=>$this->session->userdata('id_kepk_tim'),
    		'id_atk_kesekretariatan'=>$id_atk_kesekretariatan,
    	);

  		if ($rs)
  		{
  			$this->db->where('id_pep', $id_pep);
  			$this->db->update('tb_kirim_bfbd_ke_peneliti', $data);
				$this->check_trans_status('update tb_kirim_bfbd_ke_peneliti failed');
  		}
  		else
  		{
  			$this->db->insert('tb_kirim_bfbd_ke_peneliti', $data);
				$this->check_trans_status('insert tb_kirim_bfbd_ke_peneliti failed');
  		}

			$aktivitas = 'Kirim Pemberitahuan Fullboard Protokol '.$no_protokol.' ke Peneliti';
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

	function get_id_atk_kesekretariatan($id_user)
	{
		$this->db->select('s.id_atk');
		$this->db->from('tb_struktur_tim_kepk as s');
		$this->db->join('tb_users as u', 'u.id_stk = s.id_stk');
		$this->db->where('u.id_user', $id_user);
		$result = $this->db->get()->row_array();

		return isset($result['id_atk']) ? $result['id_atk'] : 0;
	}

  public function get_data_jqgrid($param, $isCount=FALSE, $CompileOnly=False)
  {
    $id_atk_kesekretariatan = $this->get_id_atk_kesekretariatan($this->session->userdata('id_user_'.APPAUTH));

    $this->db->select("
        pf.id_bfbd,
        pf.id_pep,
        p.no_protokol,
        p.judul,
        p.nama_ketua, 
        p.telp_peneliti, 
        p.email_peneliti, 
        pf.tgl_fullboard,
        pf.jam_fullboard,
        pf.tempat_fullboard,
        pf.inserted as tanggal_pemberitahuan
      ");
    $this->db->from('tb_pemberitahuan_fullboard as pf');
    $this->db->join('tb_pep as e', 'e.id_pep = pf.id_pep');
    $this->db->join('tb_pengajuan as p', 'p.id_pengajuan = e.id_pengajuan');
    
    if ($this->session->userdata('id_group_'.APPAUTH) == 5)
      $this->db->where('pf.id_atk_kesekretariatan', $id_atk_kesekretariatan);
    else if ($this->session->userdata('id_group_'.APPAUTH) == 3)
    {
      $this->db->join('tb_kirim_bfbd_ke_peneliti as kr', 'kr.id_pep = e.id_pep');
      $this->db->where('p.id_pengusul', $this->session->userdata('id_pengusul'));
    }
    
    $this->db->order_by('pf.inserted', 'desc');

    // proses parameter pencarian, jika ada
    if (isset($param['_search']) && $param['_search'] == 'true' )
    {
      $fld = $param['search_fld'];
      switch($fld){
        case 'tgl_fb': $str = prepare_date($param['search_str']); break;
        case 'tgl_pemberitahuan': $str = prepare_date($param['search_str']); break;
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
		$this->db->select('pf.id_bfbd, pf.id_pep, pf.tgl_fullboard, pf.jam_fullboard, pf.tempat_fullboard, p.no_protokol, p.judul');
		$this->db->from('tb_pemberitahuan_fullboard as pf');
		$this->db->join('tb_pep as e', 'e.id_pep = pf.id_pep');
		$this->db->join('tb_pengajuan as p', 'p.id_pengajuan = e.id_pengajuan');
		$this->db->where('pf.id_bfbd', $id);
		$result = $this->db->get()->row_array();

		return $result;
	}

	function get_data_protokol()
	{
		$query = "
      select e.id_pep, p.no_protokol, p.judul, pa.inserted, e.revisi_ke
      from tb_pep as e
      join tb_pengajuan as p on p.id_pengajuan = e.id_pengajuan
      join tb_putusan_awal as pa on pa.id_pep = e.id_pep
      left join tb_pemberitahuan_fullboard as pf on pf.id_pep = e.id_pep
      where p.id_kepk = ".$this->session->userdata('id_kepk_tim')."
        and pa.klasifikasi = 3
        and pf.id_bfbd is null
        and e.revisi_ke = 0

      union

      select e.id_pep, p.no_protokol, p.judul, paef.inserted, e.revisi_ke
      from tb_pep as e
      join tb_pengajuan as p on p.id_pengajuan = e.id_pengajuan
      join tb_putusan_awal_expedited_to_fullboard as paef on paef.id_pep = e.id_pep
      left join tb_pemberitahuan_fullboard as pf on pf.id_pep = e.id_pep
      where p.id_kepk = ".$this->session->userdata('id_kepk_tim')."
        and paef.klasifikasi = 3
        and pf.id_bfbd is null

      union

      select e.id_pep, p.no_protokol, p.judul, kr.inserted, e.revisi_ke
      from tb_pep as e
      join tb_pengajuan as p on p.id_pengajuan = e.id_pengajuan
      join tb_kirim_ke_kepk as kr on kr.id_pengajuan = e.id_pengajuan and kr.id_pep = e.id_pep and kr.id_kepk = p.id_kepk
      join (select e2.id_pengajuan, pa2.inserted from tb_pep as e2 join tb_putusan_awal as pa2 on pa2.id_pep = e2.id_pep join tb_penelaah_mendalam as pm2 on pm2.id_pa = pa2.id_pa where pa2.klasifikasi = 3) as x on x.id_pengajuan = p.id_pengajuan
      left join tb_pemberitahuan_fullboard as pf on pf.id_pep = e.id_pep
      where p.id_kepk = ".$this->session->userdata('id_kepk_tim')."
        and kr.klasifikasi = 3
        and pf.id_bfbd is null
        and e.revisi_ke > 0

      union

      select e.id_pep, p.no_protokol, p.judul, kr.inserted, e.revisi_ke
      from tb_pep as e
      join tb_pengajuan as p on p.id_pengajuan = e.id_pengajuan
      join tb_kirim_ke_kepk as kr on kr.id_pengajuan = e.id_pengajuan and kr.id_pep = e.id_pep and kr.id_kepk = p.id_kepk
      join (select e2.id_pengajuan, paef2.inserted from tb_pep as e2 join tb_putusan_awal_expedited_to_fullboard as paef2 on paef2.id_pep = e2.id_pep join tb_penelaah_mendalam_exptofb as peef2 on peef2.id_paef = paef2.id_paef where paef2.klasifikasi = 3) as x on x.id_pengajuan = p.id_pengajuan
      left join tb_pemberitahuan_fullboard as pf on pf.id_pep = e.id_pep
      where p.id_kepk = ".$this->session->userdata('id_kepk_tim')."
        and kr.klasifikasi = 3
        and pf.id_bfbd is null
        and e.revisi_ke > 0
		";

		$result = $this->db->query($query)->result_array();

		return $result;
	}

	function get_data_pengajuan_by_id_pep($id_pep)
	{
		$this->db->select('p.nama_ketua, p.telp_peneliti, p.email_peneliti, p.nama_institusi, p.alamat_institusi, p.telp_institusi, p.email_institusi');
		$this->db->from('tb_pengajuan as p');
		$this->db->join('tb_pep as e', 'e.id_pengajuan = p.id_pengajuan');
		$this->db->where('e.id_pep', $id_pep);
		$result = $this->db->get()->row_array();

		return $result;
	}

	function get_data_anggota_penelitian_by_id_pep($id_pep)
	{
		$this->db->select('ap.nama');
		$this->db->from('tb_anggota_penelitian as ap');
		$this->db->join('tb_pengajuan as p', 'p.id_pengajuan = ap.id_pengajuan');
		$this->db->join('tb_pep as e', 'e.id_pengajuan = p.id_pengajuan');
		$this->db->where('e.id_pep', $id_pep);
		$result = $this->db->get()->result_array();

		return $result;
	}

  function get_data_penelaah_fullboard_by_id_pep($id_pep)
  {
    $query = "
      select a.nama from tb_anggota_tim_kepk as a 
      join tb_penelaah_mendalam as pm on pm.id_atk_penelaah = a.id_atk 
      join tb_putusan_awal as pa on pa.id_pa = pm.id_pa
      where pa.id_pep = ".$id_pep."

      union

      select a.nama from tb_anggota_tim_kepk as a
      join tb_penelaah_mendalam_exptofb as pme on pme.id_atk_penelaah = a.id_atk
      join tb_putusan_awal_expedited_to_fullboard as paef on paef.id_paef = pme.id_paef
      where paef.id_pep = ".$id_pep."
    ";

    $result = $this->db->query($query)->result_array();
   
    return $result;
  }

  function get_data_lay_person_fullboard_by_id_pep($id_pep)
  {
    $query = "
      select a.nama from tb_anggota_tim_kepk as a 
      join tb_lay_person as lp on lp.id_atk_lay_person = a.id_atk 
      join tb_putusan_awal as pa on pa.id_pa = lp.id_pa
      where pa.id_pep = ".$id_pep."

      union

      select a.nama from tb_anggota_tim_kepk as a
      join tb_lay_person_exptofb as lpe on lpe.id_atk_lay_person = a.id_atk
      join tb_putusan_awal_expedited_to_fullboard as paef on paef.id_paef = lpe.id_paef
      where paef.id_pep = ".$id_pep."
    ";

    $result = $this->db->query($query)->result_array();
   
    return $result;
  }

  function get_data_kop_surat_by_id_pep($id_pep)
  {
    $this->db->select('ks.file_name');
    $this->db->from('tb_kop_surat as ks');

    if ($this->session->userdata('id_group_'.APPAUTH) == 3)
    {
      $this->db->join('tb_pengajuan as p', 'p.id_kepk = ks.id_kepk');
      $this->db->join('tb_pep as e', 'e.id_pengajuan = p.id_pengajuan');
      $this->db->where('e.id_pep', $id_pep);
    }
    else if ($this->session->userdata('id_group_'.APPAUTH) == 5)
      $this->db->where('ks.id_kepk', $this->session->userdata('id_kepk'));
  
    $result = $this->db->get()->row_array();

    return $result;
  }

  function get_data_ketua_kepk_by_id_pep($id_pep)
  {
    $this->db->select('a.nama as nama_ketua, a.nomor as nomor_ketua, a.nik as nik_ketua');
    $this->db->from('tb_anggota_tim_kepk as a');
    $this->db->join('tb_struktur_tim_kepk as s', 's.id_atk = a.id_atk');

    if ($this->session->userdata('id_group_'.APPAUTH) == 3)
    {
      $this->db->join('tb_pengajuan as p', 'p.id_kepk = a.id_kepk');
      $this->db->join('tb_pep as e', 'e.id_pengajuan = p.id_pengajuan');
      $this->db->where('e.id_pep', $id_pep);
    }
    else if ($this->session->userdata('id_group_'.APPAUTH) == 5)
    {
      $this->db->where('a.id_kepk', $this->session->userdata('id_kepk_tim'));
    }

    $this->db->where('s.jabatan = 1');
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
		$this->db->select('1')->from('tb_kirim_bfbd_ke_peneliti as kr')
				->join('tb_pemberitahuan_fullboard as pf', 'pf.id_pep = kr.id_pep')
				->where('pf.id_bfbd', $id);

		$rs = $this->db->get()->row_array();

		if ($rs)
			return 1;

		return 0;
	}

}
