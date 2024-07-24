<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Self_assesment_model extends Core_Model {

	var $fieldmap_filter;
  var $data_detail;

	public function __construct()
	{
		parent::__construct();

    $this->fieldmap_filter = array(
      'no_protokol' => 'p.no_protokol',
      'judul' => 'p.judul',
      'tgl_pengajuan' => 'date(p.inserted)',
      'kepk' => 'k.nama_kepk',
      'mulai' => 'date(p.waktu_mulai)',
      'selesai' => 'date(p.waktu_selesai)',
      'tgl_sa' => 'date(s.inserted)'
    );

	}

	public function fill_data()
	{
		$id = $this->input->post('id') ? $this->input->post('id') : 0;
		$id_pengajuan = $this->input->post('id_pengajuan') ? $this->input->post('id_pengajuan') : 0;
		$justifikasi1 = $this->input->post('justifikasi1') ? $this->input->post('justifikasi1') : '';
		$justifikasi2 = $this->input->post('justifikasi2') ? $this->input->post('justifikasi2') : '';
		$justifikasi3 = $this->input->post('justifikasi3') ? $this->input->post('justifikasi3') : '';
		$justifikasi4 = $this->input->post('justifikasi4') ? $this->input->post('justifikasi4') : '';
		$justifikasi5 = $this->input->post('justifikasi5') ? $this->input->post('justifikasi5') : '';
		$justifikasi6 = $this->input->post('justifikasi6') ? $this->input->post('justifikasi6') : '';
		$justifikasi7 = $this->input->post('justifikasi7') ? $this->input->post('justifikasi7') : '';

		$this->data = array(
				'id_sac' => $id,
				'id_pengajuan' => $id_pengajuan,
				'justifikasi1' => $justifikasi1,
				'justifikasi2' => $justifikasi2,
				'justifikasi3' => $justifikasi3,
				'justifikasi4' => $justifikasi4,
				'justifikasi5' => $justifikasi5,
				'justifikasi6' => $justifikasi6,
				'justifikasi7' => $justifikasi7,
		);

 		$sa1 = $this->input->post('self_assesment1') ? json_decode($this->input->post('self_assesment1')) : '';
 		for ($i=0; $i<count($sa1); $i++)
 		{
			$id_jsk = isset($sa1[$i]->id) ? $sa1[$i]->id : 0;
		 	$pil = isset($sa1[$i]->pil) ? $sa1[$i]->pil : '';

		 	$this->data_detail[] = array('id_jsk'=>$id_jsk, 'pilihan'=>$pil);
		}

 		$sa2 = $this->input->post('self_assesment2') ? json_decode($this->input->post('self_assesment2')) : '';
 		for ($i=0; $i<count($sa2); $i++)
 		{
		 	$id_jsk = isset($sa2[$i]->id) ? $sa2[$i]->id : 0;
		 	$pil = isset($sa2[$i]->pil) ? $sa2[$i]->pil : '';

		 	$this->data_detail[] = array('id_jsk'=>$id_jsk, 'pilihan'=>$pil);
		}

 		$sa3 = $this->input->post('self_assesment3') ? json_decode($this->input->post('self_assesment3')) : '';
 		for ($i=0; $i<count($sa3); $i++)
 		{
			$id_jsk = isset($sa3[$i]->id) ? $sa3[$i]->id : 0;
		 	$pil = isset($sa3[$i]->pil) ? $sa3[$i]->pil : '';

		 	$this->data_detail[] = array('id_jsk'=>$id_jsk, 'pilihan'=>$pil);
		}

 		$sa4 = $this->input->post('self_assesment4') ? json_decode($this->input->post('self_assesment4')) : '';
 		for ($i=0; $i<count($sa4); $i++)
 		{
		 	$id_jsk = isset($sa4[$i]->id) ? $sa4[$i]->id : 0;
		 	$pil = isset($sa4[$i]->pil) ? $sa4[$i]->pil : '';

		 	$this->data_detail[] = array('id_jsk'=>$id_jsk, 'pilihan'=>$pil);
		}

 		$sa5 = $this->input->post('self_assesment5') ? json_decode($this->input->post('self_assesment5')) : '';
 		for ($i=0; $i<count($sa5); $i++)
 		{
		 	$id_jsk = isset($sa5[$i]->id) ? $sa5[$i]->id : 0;
		 	$pil = isset($sa5[$i]->pil) ? $sa5[$i]->pil : '';

		 	$this->data_detail[] = array('id_jsk'=>$id_jsk, 'pilihan'=>$pil);
		}

 		$sa6 = $this->input->post('self_assesment6') ? json_decode($this->input->post('self_assesment6')) : '';
 		for ($i=0; $i<count($sa6); $i++)
 		{
			$id_jsk = isset($sa6[$i]->id) ? $sa6[$i]->id : 0;
		 	$pil = isset($sa6[$i]->pil) ? $sa6[$i]->pil : '';

		 	$this->data_detail[] = array('id_jsk'=>$id_jsk, 'pilihan'=>$pil);
		}

 		$sa7 = $this->input->post('self_assesment7') ? json_decode($this->input->post('self_assesment7')) : '';
 		for ($i=0; $i<count($sa7); $i++)
 		{
		 	$id_jsk = isset($sa7[$i]->id) ? $sa7[$i]->id : 0;
		 	$pil = isset($sa7[$i]->pil) ? $sa7[$i]->pil : '';

		 	$this->data_detail[] = array('id_jsk'=>$id_jsk, 'pilihan'=>$pil);
		}

	}

	public function save_detail()
	{
		$this->insert_master();
		$this->insert_detail();
	}

	public function insert_master()
	{
		if (isset($this->data['id_sac']) && $this->data['id_sac'] > 0)
		{
			$this->db->where('id_sac', $this->data['id_sac']);
			$this->db->where('id_pengajuan', $this->data['id_pengajuan']);
			$this->db->update('tb_self_assesment_cek', $this->data);
			$this->id = $this->data['id_sac'];
			$this->check_trans_status('update tb_self_assesment_cek failed');
		}
		else
		{
			$this->db->insert('tb_self_assesment_cek', $this->data);
			$this->id = $this->db->insert_id();
			$this->check_trans_status('insert tb_self_assesment_cek failed');
		}

	}

	public function insert_detail()
	{
    $data_update = array();
    $data_insert = array();
		for ($i=0; $i<count($this->data_detail); $i++)
		{
			$this->db->select('id_dsac')->from('tb_detail_sa_cek')->where('id_sac', $this->id)->where('id_jsk', $this->data_detail[$i]['id_jsk'])->where('id_jsk', $this->data_detail[$i]['id_jsk']);
			$rs = $this->db->get()->row_array();

			if ($rs)
			{
        $data_update[] = array(
          'id_dsac' => $rs['id_dsac'],
          'id_sac' => $this->id,
          'id_jsk' => $this->data_detail[$i]['id_jsk'],
          'pilihan' => $this->data_detail[$i]['pilihan']
        );
			}
			else
			{
        $data_insert[] = array(
          'id_sac' => $this->id,
          'id_jsk' => $this->data_detail[$i]['id_jsk'],
          'pilihan' => $this->data_detail[$i]['pilihan']
        );
			}
		}

    if (!empty($data_update)){
      $this->db->update_batch('tb_detail_sa_cek', $data_update, 'id_dsac');
      $this->check_trans_status('update tb_detail_sa_cek failed');
    }

    if (!empty($data_insert)){
      $this->db->insert_batch('tb_detail_sa_cek', $data_insert);
      $this->check_trans_status('insert tb_detail_sa_cek failed');
    }
	}

	function kirim_data($id_pengajuan)
	{
    $this->db->trans_start();
    try {
    	$this->db->select('p.id_kepk, e.id_pep');
    	$this->db->from('tb_pengajuan as p');
    	$this->db->join('tb_pep as e', 'e.id_pengajuan = p.id_pengajuan and e.revisi_ke = 0');
    	$this->db->where('p.id_pengajuan', $id_pengajuan);
    	$result = $this->db->get()->row_array();

      $this->db->select('1')->from('tb_kirim_ke_kepk')->where('id_pengajuan', $id_pengajuan)->where('id_pep', $result['id_pep']);
    	$rs = $this->db->get()->row_array();

    	$data = array(
    		'id_pengajuan'=>$id_pengajuan,
    		'id_pep'=>$result['id_pep'],
    		'id_kepk'=>$result['id_kepk'],
    	);

    	if ($rs)
    	{
        $this->db->where('id_pep', $result['id_pep']);
    		$this->db->where('id_pengajuan', $id_pengajuan);
    		$this->db->update('tb_kirim_ke_kepk', $data);
				$this->check_trans_status('update tb_kirim_ke_kepk failed');
    	}
    	else
    	{
				$this->db->insert('tb_kirim_ke_kepk', $data);
				$this->check_trans_status('insert tb_kirim_ke_kepk failed');
    	}

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
    $this->db->select('s.id_sac, p.id_pengajuan, p.no_protokol, p.judul, p.waktu_mulai, p.waktu_selesai, p.inserted as tanggal_pengajuan, k.nama_kepk, s.inserted as tanggal_sa');
    $this->db->from('tb_pengajuan as p');
    $this->db->join('tb_kepk as k', 'k.id_kepk = p.id_kepk');
    $this->db->join('tb_self_assesment_cek as s', 's.id_pengajuan = p.id_pengajuan');
    $this->db->where('p.id_pengusul', $this->session->userdata('id_pengusul'));
    $this->db->where('s.revisi_ke', 0);
    $this->db->order_by('s.inserted desc');

    // proses parameter pencarian, jika ada
    if (isset($param['_search']) && $param['_search'] == 'true' )
    {
      $fld = $param['search_fld'];
      switch($fld){
        case 'tgl_pengajuan': $str = prepare_date($param['search_str']); break;
        case 'mulai': $str = prepare_date($param['search_str']); break;
        case 'selesai': $str = prepare_date($param['search_str']); break;
        case 'tgl_sa': $str = prepare_date($param['search_str']); break;
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
		$this->db->select('sac.*, e.id_pep, p.id_pengajuan, p.no_protokol, p.judul, p.id_kepk');
		$this->db->from('tb_self_assesment_cek as sac');
		$this->db->join('tb_pengajuan as p', 'p.id_pengajuan = sac.id_pengajuan');
		$this->db->join('tb_pep as e', 'e.id_pengajuan = p.id_pengajuan');
		$this->db->where('sac.id_sac', $id);
		$result = $this->db->get()->row_array();

		return $result;
	}

	function get_data_pengajuan()
	{
		$this->db->select('p.id_pengajuan, p.no_protokol, p.judul');
		$this->db->from('tb_pengajuan as p');
    $this->db->join('tb_pep as e', 'e.id_pengajuan = p.id_pengajuan');
    $this->db->join('tb_self_assesment_cek as sac', 'sac.id_pengajuan = p.id_pengajuan and sac.revisi_ke = 0', 'left');
		$this->db->where('p.id_pengusul', $this->session->userdata('id_pengusul'));
		$this->db->where('sac.id_sac is null');
		$this->db->where('e.revisi_ke = 0');
		$result = $this->db->get()->result_array();

		return $result;
	}

	public function get_data_standar_kelaikan($id)
	{
		$this->db->select("jsk.*, msk.uraian as uraian_master, dsac.pilihan");
		$this->db->from('tb_jabaran_standar_kelaikan as jsk');
		$this->db->join('tb_master_standar_kelaikan as msk', 'msk.id_msk = jsk.id_msk');
		$this->db->join('tb_detail_sa_cek as dsac', 'dsac.id_jsk = jsk.id_jsk and dsac.id_sac = '.$id, 'left');
		$result = $this->db->get()->result_array();

		return $result;
	}

	function get_data_klasifikasi($id)
	{
		$this->db->select("(
			select pa2.klasifikasi from tb_putusan_awal as pa2 where pa2.id_pa = max(pa.id_pa)) as klasifikasi
		");
		$this->db->from('tb_putusan_awal as pa');
		$this->db->join('tb_pep as e', 'e.id_pep = pa.id_pep');
		$this->db->join('tb_self_assesment_cek as sac', 'sac.id_pengajuan = e.id_pengajuan');
		$this->db->where('sac.id_sac', $id);
		$result = $this->db->get()->row_array();

		return $result;
	}

	function get_data_keputusan($id)
	{
		$this->db->select("(
			select pe.keputusan from tb_putusan_expedited as pe where pe.id_pep = max(e.id_pep)
		  union 
  		select pf.keputusan from tb_putusan_fullboard as pf where pf.id_pep = max(e.id_pep)
		) as keputusan");
		$this->db->from('tb_pep as e');
		$this->db->join('tb_self_assesment_cek as sac', 'sac.id_pengajuan = e.id_pengajuan');
		$this->db->where('sac.id_sac', $id);
		$result = $this->db->get()->row_array();

		return $result;
	}

	function get_data_protokol_by_idpengajuan($id_pengajuan)
	{
		$this->db->select('p.no_protokol, p.judul, p.nama_ketua, p.id_kepk, k.nama_kepk');
		$this->db->from('tb_pengajuan as p');
		$this->db->join('tb_kepk as k', 'k.id_kepk = p.id_kepk');
		$this->db->where('p.id_pengajuan', $id_pengajuan);
		$result = $this->db->get()->row_array();

		return $result;
	}

	function get_data_tim_kepk_by_idkepk($id_kepk)
	{
		$this->db->select('atk.nomor, atk.nama, atk.email');
		$this->db->distinct();
		$this->db->from('tb_struktur_tim_kepk as stk');
		$this->db->join('tb_tim_kepk as tk', 'tk.id_tim_kepk = stk.id_tim_kepk');
		$this->db->join('tb_anggota_tim_kepk as atk', 'atk.id_atk = stk.id_atk');
		$this->db->where('tk.id_kepk', $id_kepk);
		$this->db->where('tk.aktif', 1);
		$result = $this->db->get()->result_array();

		return $result;
	}

  public function get_data_cetak_protokol_by_idpengajuan($id_pengajuan)
  {
    $this->db->select('e.*, p.no_protokol, p.judul, p.tempat_penelitian, p.is_multi_senter, p.is_setuju_senter');
    $this->db->from('tb_pep as e');
    $this->db->join('tb_pengajuan as p', 'p.id_pengajuan = e.id_pengajuan');
    $this->db->where('e.id_pengajuan', $id_pengajuan);
    $result = $this->db->get()->row_array();

    return $result;
  }

  function get_data_uraian_harus_terisi($id_pengajuan)
  {
    $this->db->select('e.id_pep,
      e.uraianc1, e.uraianc2, e.uraiang1, e.uraiang2, e.uraiang3, e.uraianh1, e.uraianh2, e.uraianh3,
      e.uraiani1, e.uraiani2, e.uraiani3, e.uraiani4, e.uraianj1, e.uraiank1, e.uraianl1, e.uraianl2, 
      e.uraianm1, e.uraiann1, e.uraiann2, e.uraiano1, e.uraianp1, e.uraianp2, e.uraianr1, e.uraianr2,
      e.uraianr3, e.uraians1, e.uraians2, e.uraians3, e.uraians4, e.uraiant1, e.uraianu1, e.uraianv1,
      e.uraianw1, e.uraianw2, e.uraianx1, e.uraiany1, e.uraiany2');
    $this->db->from('tb_pep as e');
    $this->db->where('e.revisi_ke = 0'); // hanya protokol yg pertama dibuat
    $this->db->where('e.id_pengajuan', $id_pengajuan);
    $result = $this->db->get()->row_array();

    return $result;
  }

  function check_lampiran($id_pep, $lampiran)
  {
    $this->db->select('1')->from('tb_lampiran_pep')
      ->where('id_pep', $id_pep)->where('lampiran', $lampiran);
    $rs = $this->db->get()->row_array();

    if ($rs)
      return TRUE;

    return FALSE;
  }

  function check_is_resume($id)
	{
		$this->db->select('1')->from('tb_resume as r')
				->join('tb_pep as e', 'e.id_pep = r.id_pep')
				->join('tb_self_assesment_cek as sac', 'sac.id_pengajuan = e.id_pengajuan')
				->where('sac.id_sac', $id);

		$rs = $this->db->get()->row_array();

		if ($rs)
			return 1;

		return 0;
	}

	function check_is_kirim($id)
	{
		$this->db->select('1')->from('tb_kirim_ke_kepk as kr')
				->join('tb_self_assesment_cek as sac', 'sac.id_pengajuan = kr.id_pengajuan')
				->where('sac.id_sac', $id);

		$rs = $this->db->get()->row_array();

		if ($rs)
			return 1;

		return 0;
	}

	function check_duplikasi_pengajuan($id, $id_pengajuan)
	{
		$this->db->select('1')->from('tb_self_assesment_cek')
				->where('id_pengajuan', $id_pengajuan)
				->where('id_sac <>', $id);
		$rs = $this->db->get()->row_array();

		if ($rs)
			return TRUE;

		return FALSE;
	}

  function check_is_save($id_pengajuan)
  {
    $this->db->select('1')->from('tb_self_assesment_cek')
        ->where('id_pengajuan', $id_pengajuan)
        ->where('revisi_ke = 0');
    $rs = $this->db->get()->row_array();

    if ($rs)
      return TRUE;

    return FALSE;
  }

	function delete_detail($id)
	{
		$this->delete_detail_sa_cek($id);
		$this->delete_sa_cek($id);
	}

	function delete_sa_cek($id)
	{
		$this->db->where('id_sac', $id);
		$this->db->delete('tb_self_assesment_cek');
	}

	function delete_detail_sa_cek($id)
	{
		$this->db->where('id_sac', $id);
		$this->db->delete('	tb_detail_sa_cek');
	}

}
