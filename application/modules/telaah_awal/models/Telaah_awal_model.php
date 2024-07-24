<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Telaah_awal_model extends Core_Model {

	var $fieldmap_filter;
  var $data_sa;

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
      'tgl_telaah' => 'date(pk.inserted)',
      'klasifikasi_usulan' => "case ta.klasifikasi_usulan
                                when 1 then 'Exempted'
                                when 2 then 'Expedited'
                                when 3 then 'Full Board'
                                when 4 then 'Tidak Bisa Ditelaah'
                              end"
    );

	}

	public function fill_data()
	{
		$id = $this->input->post('id') ? $this->input->post('id') : 0;
		$id_pep = $this->input->post('id_pep') ? $this->input->post('id_pep') : 0;
		$klasifikasi_usulan = $this->input->post('klasifikasi_usulan') ? $this->input->post('klasifikasi_usulan') : '';
		$id_penelaah = $this->get_id_atk_penelaah($this->session->userdata('id_user_'.APPAUTH));
	  $remove_str = array("\n", "\r\n", "\r");
    $catA = $this->input->post('catatanA') ? addslashes(str_replace($remove_str, ' ', $this->input->post('catatanA'))) : '';
    $catC = $this->input->post('catatanC') ? addslashes(str_replace($remove_str, ' ', $this->input->post('catatanC'))) : '';
    $catD = $this->input->post('catatanD') ? addslashes(str_replace($remove_str, ' ', $this->input->post('catatanD'))) : '';
    $catE = $this->input->post('catatanE') ? addslashes(str_replace($remove_str, ' ', $this->input->post('catatanE'))) : '';
    $catF = $this->input->post('catatanF') ? addslashes(str_replace($remove_str, ' ', $this->input->post('catatanF'))) : '';
    $catG = $this->input->post('catatanG') ? addslashes(str_replace($remove_str, ' ', $this->input->post('catatanG'))) : '';
    $catH = $this->input->post('catatanH') ? addslashes(str_replace($remove_str, ' ', $this->input->post('catatanH'))) : '';
    $catI = $this->input->post('catatanI') ? addslashes(str_replace($remove_str, ' ', $this->input->post('catatanI'))) : '';
    $catJ = $this->input->post('catatanJ') ? addslashes(str_replace($remove_str, ' ', $this->input->post('catatanJ'))) : '';
    $catK = $this->input->post('catatanK') ? addslashes(str_replace($remove_str, ' ', $this->input->post('catatanK'))) : '';
    $catL = $this->input->post('catatanL') ? addslashes(str_replace($remove_str, ' ', $this->input->post('catatanL'))) : '';
    $catM = $this->input->post('catatanM') ? addslashes(str_replace($remove_str, ' ', $this->input->post('catatanM'))) : '';
    $catN = $this->input->post('catatanN') ? addslashes(str_replace($remove_str, ' ', $this->input->post('catatanN'))) : '';
    $catO = $this->input->post('catatanO') ? addslashes(str_replace($remove_str, ' ', $this->input->post('catatanO'))) : '';
    $catP = $this->input->post('catatanP') ? addslashes(str_replace($remove_str, ' ', $this->input->post('catatanP'))) : '';
    $catQ = $this->input->post('catatanQ') ? addslashes(str_replace($remove_str, ' ', $this->input->post('catatanQ'))) : '';
    $catR = $this->input->post('catatanR') ? addslashes(str_replace($remove_str, ' ', $this->input->post('catatanR'))) : '';
    $catS = $this->input->post('catatanS') ? addslashes(str_replace($remove_str, ' ', $this->input->post('catatanS'))) : '';
    $catT = $this->input->post('catatanT') ? addslashes(str_replace($remove_str, ' ', $this->input->post('catatanT'))) : '';
    $catU = $this->input->post('catatanU') ? addslashes(str_replace($remove_str, ' ', $this->input->post('catatanU'))) : '';
    $catV = $this->input->post('catatanV') ? addslashes(str_replace($remove_str, ' ', $this->input->post('catatanV'))) : '';
    $catW = $this->input->post('catatanW') ? addslashes(str_replace($remove_str, ' ', $this->input->post('catatanW'))) : '';
    $catX = $this->input->post('catatanX') ? addslashes(str_replace($remove_str, ' ', $this->input->post('catatanX'))) : '';
    $catY = $this->input->post('catatanY') ? addslashes(str_replace($remove_str, ' ', $this->input->post('catatanY'))) : '';
    $catZ = $this->input->post('catatanZ') ? addslashes(str_replace($remove_str, ' ', $this->input->post('catatanZ'))) : '';
    $catAA = $this->input->post('catatanAA') ? addslashes(str_replace($remove_str, ' ', $this->input->post('catatanAA'))) : '';
    $catBB = $this->input->post('catatanBB') ? addslashes(str_replace($remove_str, ' ', $this->input->post('catatanBB'))) : '';
    $catCC = $this->input->post('catatanCC') ? addslashes(str_replace($remove_str, ' ', $this->input->post('catatanCC'))) : '';
    $cat_link_proposal = $this->input->post('catatan_link_proposal') ? addslashes(str_replace($remove_str, ' ', $this->input->post('catatan_link_proposal'))) : '';
    $catatan_protokol = $this->input->post('catatan_protokol') ? addslashes(str_replace($remove_str, ' ', $this->input->post('catatan_protokol'))) : '';

	  $cat1 = $this->input->post('catatan1') ? addslashes(str_replace($remove_str, ' ', $this->input->post('catatan1'))) : '';
	  $cat2 = $this->input->post('catatan2') ? addslashes(str_replace($remove_str, ' ', $this->input->post('catatan2'))) : '';
	  $cat3 = $this->input->post('catatan3') ? addslashes(str_replace($remove_str, ' ', $this->input->post('catatan3'))) : '';
	  $cat4 = $this->input->post('catatan4') ? addslashes(str_replace($remove_str, ' ', $this->input->post('catatan4'))) : '';
	  $cat5 = $this->input->post('catatan5') ? addslashes(str_replace($remove_str, ' ', $this->input->post('catatan5'))) : '';
	  $cat6 = $this->input->post('catatan6') ? addslashes(str_replace($remove_str, ' ', $this->input->post('catatan6'))) : '';
	  $cat7 = $this->input->post('catatan7') ? addslashes(str_replace($remove_str, ' ', $this->input->post('catatan7'))) : '';
    $catatan_7standar = $this->input->post('catatan_7standar') ? addslashes(str_replace($remove_str, ' ', $this->input->post('catatan_7standar'))) : '';

	  $this->data = array(
	  	'id_ta' => $id,
	  	'id_pep' => $id_pep,
	  	'klasifikasi_usulan' => $klasifikasi_usulan,
	  	'id_atk_penelaah' => $id_penelaah,
      'catatana' => $catA,
      'catatanc' => $catC,
      'catatand' => $catD,
      'catatane' => $catE,
      'catatanf' => $catF,
      'catatang' => $catG,
      'catatanh' => $catH,
      'catatani' => $catI,
      'catatanj' => $catJ,
      'catatank' => $catK,
      'catatanl' => $catL,
      'catatanm' => $catM,
      'catatann' => $catN,
      'catatano' => $catO,
      'catatanp' => $catP,
      'catatanq' => $catQ,
      'catatanr' => $catR,
      'catatans' => $catS,
      'catatant' => $catT,
      'catatanu' => $catU,
      'catatanv' => $catV,
      'catatanw' => $catW,
      'catatanx' => $catX,
      'catatany' => $catY,
      'catatanz' => $catZ,
      'catatanaa' => $catAA,
      'catatanbb' => $catBB,
      'catatancc' => $catCC,
      'catatan_link_proposal' => $cat_link_proposal,
      'catatan_protokol' => $catatan_protokol,
      'catatan1' => $cat1,
      'catatan2' => $cat2,
      'catatan3' => $cat3,
      'catatan4' => $cat4,
      'catatan5' => $cat5,
      'catatan6' => $cat6,
      'catatan7' => $cat7,
      'catatan_7standar' => $catatan_7standar
	  );

 		$sa1 = $this->input->post('self_assesment1') ? json_decode($this->input->post('self_assesment1')) : '';
 		for ($i=0; $i<count($sa1); $i++)
 		{
			$id_jsk = isset($sa1[$i]->id) ? $sa1[$i]->id : 0;
		 	$pil = isset($sa1[$i]->pil_penelaah) ? $sa1[$i]->pil_penelaah : '';
      $catatan = isset($sa1[$i]->cat_penelaah) ? $sa1[$i]->cat_penelaah : '';

		 	$this->data_sa[] = array('id_jsk'=>$id_jsk, 'pilihan'=>$pil, 'catatan'=>$catatan);
		}

 		$sa2 = $this->input->post('self_assesment2') ? json_decode($this->input->post('self_assesment2')) : '';
 		for ($i=0; $i<count($sa2); $i++)
 		{
			$id_jsk = isset($sa2[$i]->id) ? $sa2[$i]->id : 0;
		 	$pil = isset($sa2[$i]->pil_penelaah) ? $sa2[$i]->pil_penelaah : '';
      $catatan = isset($sa2[$i]->cat_penelaah) ? $sa2[$i]->cat_penelaah : '';

		 	$this->data_sa[] = array('id_jsk'=>$id_jsk, 'pilihan'=>$pil, 'catatan'=>$catatan);
		}

 		$sa3 = $this->input->post('self_assesment3') ? json_decode($this->input->post('self_assesment3')) : '';
 		for ($i=0; $i<count($sa3); $i++)
 		{
			$id_jsk = isset($sa3[$i]->id) ? $sa3[$i]->id : 0;
		 	$pil = isset($sa3[$i]->pil_penelaah) ? $sa3[$i]->pil_penelaah : '';
      $catatan = isset($sa3[$i]->cat_penelaah) ? $sa3[$i]->cat_penelaah : '';

		 	$this->data_sa[] = array('id_jsk'=>$id_jsk, 'pilihan'=>$pil, 'catatan'=>$catatan);
		}

 		$sa4 = $this->input->post('self_assesment4') ? json_decode($this->input->post('self_assesment4')) : '';
 		for ($i=0; $i<count($sa4); $i++)
 		{
			$id_jsk = isset($sa4[$i]->id) ? $sa4[$i]->id : 0;
		 	$pil = isset($sa4[$i]->pil_penelaah) ? $sa4[$i]->pil_penelaah : '';
      $catatan = isset($sa4[$i]->cat_penelaah) ? $sa4[$i]->cat_penelaah : '';

		 	$this->data_sa[] = array('id_jsk'=>$id_jsk, 'pilihan'=>$pil, 'catatan'=>$catatan);
		}

 		$sa5 = $this->input->post('self_assesment5') ? json_decode($this->input->post('self_assesment5')) : '';
 		for ($i=0; $i<count($sa5); $i++)
 		{
			$id_jsk = isset($sa5[$i]->id) ? $sa5[$i]->id : 0;
		 	$pil = isset($sa5[$i]->pil_penelaah) ? $sa5[$i]->pil_penelaah : '';
      $catatan = isset($sa5[$i]->cat_penelaah) ? $sa5[$i]->cat_penelaah : '';

		 	$this->data_sa[] = array('id_jsk'=>$id_jsk, 'pilihan'=>$pil, 'catatan'=>$catatan);
		}

 		$sa6 = $this->input->post('self_assesment6') ? json_decode($this->input->post('self_assesment6')) : '';
 		for ($i=0; $i<count($sa6); $i++)
 		{
			$id_jsk = isset($sa6[$i]->id) ? $sa6[$i]->id : 0;
		 	$pil = isset($sa6[$i]->pil_penelaah) ? $sa6[$i]->pil_penelaah : '';
      $catatan = isset($sa6[$i]->cat_penelaah) ? $sa6[$i]->cat_penelaah : '';

		 	$this->data_sa[] = array('id_jsk'=>$id_jsk, 'pilihan'=>$pil, 'catatan'=>$catatan);
		}

 		$sa7 = $this->input->post('self_assesment7') ? json_decode($this->input->post('self_assesment7')) : '';
 		for ($i=0; $i<count($sa7); $i++)
 		{
			$id_jsk = isset($sa7[$i]->id) ? $sa7[$i]->id : 0;
		 	$pil = isset($sa7[$i]->pil_penelaah) ? $sa7[$i]->pil_penelaah : '';
      $catatan = isset($sa7[$i]->cat_penelaah) ? $sa7[$i]->cat_penelaah : '';

		 	$this->data_sa[] = array('id_jsk'=>$id_jsk, 'pilihan'=>$pil, 'catatan'=>$catatan);
		}

	}

	public function save_detail()
	{
		$this->insert_telaah_awal();
		$this->insert_telaah_self_assesment();
	}

	function insert_telaah_awal()
	{
		$this->db->select('1')->from('tb_telaah_awal')->where('id_ta', $this->data['id_ta']);
		$rs = $this->db->get()->row_array();

		if ($rs)
		{
			$this->db->where('id_ta', $this->data['id_ta']);
			$this->db->update('tb_telaah_awal', $this->data);
			$this->check_trans_status('update tb_telaah_awal failed');
			$this->id = $this->data['id_ta'];

			$aktivitas = 'Edit Telaah Awal Protokol '.$this->input->post('no_protokol');
			$id_user_kepk = $this->get_id_atk_penelaah($this->session->userdata('id_user_'.APPAUTH));
			$id_user =$this->session->userdata('id_user_'.APPAUTH);
			simpan_logaktivitas_tim_kepk($aktivitas, $id_user_kepk, $id_user);
		}
		else
		{
			unset($this->data['id_ta']);
			$this->db->insert('tb_telaah_awal', $this->data);
			$this->check_trans_status('insert tb_telaah_awal failed');
			$this->id = $this->db->insert_id();

			$aktivitas = 'Insert Telaah Awal Protokol '.$this->input->post('no_protokol');
			$id_user_kepk = $this->get_id_atk_penelaah($this->session->userdata('id_user_'.APPAUTH));
			$id_user =$this->session->userdata('id_user_'.APPAUTH);
			simpan_logaktivitas_tim_kepk($aktivitas, $id_user_kepk, $id_user);
		}		
	}

	public function insert_telaah_self_assesment()
	{
    $data_update = array();
    $data_insert = array();

    if (!empty($this->data_sa))
    {
      for ($i=0; $i<count($this->data_sa); $i++)
      {
        $this->db->select('id_tsa')->from('tb_telaah_self_assesment')->where('id_ta', $this->id)->where('id_jsk', $this->data_sa[$i]['id_jsk']);
        $rs = $this->db->get()->row_array();

        if ($rs)
        {
          $data_update[] = array(
            'id_tsa' => $rs['id_tsa'],
            'id_ta' => $this->id,
            'id_jsk' => $this->data_sa[$i]['id_jsk'],
            'pilihan' => $this->data_sa[$i]['pilihan'],
            'catatan' => $this->data_sa[$i]['catatan']
          );
        }
        else
        {
          $data_insert[] = array(
            'id_ta' => $this->id,
            'id_jsk' => $this->data_sa[$i]['id_jsk'],
            'pilihan' => $this->data_sa[$i]['pilihan'],
            'catatan' => $this->data_sa[$i]['catatan']
          );
        }
      }
    }

    if (!empty($data_update)){
      $this->db->update_batch('tb_telaah_self_assesment', $data_update, 'id_tsa');
      $this->check_trans_status('update tb_telaah_self_assesment failed');
    }

    if (!empty($data_insert)){
      $this->db->insert_batch('tb_telaah_self_assesment', $data_insert);
      $this->check_trans_status('insert tb_telaah_self_assesment failed');
    }
	}

	function get_id_atk_penelaah($id_user)
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
    $id_atk_penelaah = $this->get_id_atk_penelaah($this->session->userdata('id_user_'.APPAUTH));

    $this->db->select("
        ta.id_ta,
        ta.id_pep,
        p.no_protokol, 
        p.judul, 
        p.waktu_mulai, 
        p.waktu_selesai, 
        p.inserted as tanggal_pengajuan, 
        k.nama_kepk, 
        case ta.klasifikasi_usulan
          when 1 then 'Exempted'
          when 2 then 'Expedited'
          when 3 then 'Full Board'
          when 4 then 'Tidak Bisa Ditelaah'
        end as klasifikasi_usulan, 
        ta.inserted as tanggal_telaah
      ");
    $this->db->from('tb_telaah_awal as ta');
    $this->db->join('tb_pep as e', 'e.id_pep = ta.id_pep');
    $this->db->join('tb_pengajuan as p', 'p.id_pengajuan = e.id_pengajuan');
    $this->db->join('tb_kepk as k', 'k.id_kepk = p.id_kepk');
    $this->db->where('ta.id_atk_penelaah', $id_atk_penelaah);

    // proses parameter pencarian, jika ada
    if (isset($param['_search']) && $param['_search'] == 'true' )
    {
      $fld = $param['search_fld'];
      switch($fld){
        case 'tgl_pengajuan': $str = prepare_date($param['search_str']); break;
        case 'mulai': $str = prepare_date($param['search_str']); break;
        case 'selesai': $str = prepare_date($param['search_str']); break;
        case 'tgl_telaah': $str = prepare_date($param['search_str']); break;
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

	function get_data_protokol()
	{
    /*
    - Telaah awal bisa dilakukan jika sudah ada resume. Dan hanya penelaah yg ditunjuk yg bisa melakukan telaah.
    - Jika sudah diputuskan awal, maka sudah tidak bisa ditelaah awal lagi.
    */
		$id_atk_penelaah = $this->get_id_atk_penelaah($this->session->userdata('id_user_'.APPAUTH));

		$this->db->select('e.id_pep, p.no_protokol, p.judul, e.revisi_ke, kr.inserted');
		$this->db->from('tb_pep as e');
		$this->db->join('tb_pengajuan as p', 'p.id_pengajuan = e.id_pengajuan');
		$this->db->join('tb_kirim_ke_kepk as kr', 'kr.id_pengajuan = e.id_pengajuan and kr.id_pep = e.id_pep and kr.id_kepk = p.id_kepk');
		$this->db->join('tb_resume as r', 'r.id_pep = e.id_pep');
		$this->db->join('tb_penelaah_awal as pa', 'pa.id_resume = r.id_resume');
		$this->db->join('tb_telaah_awal as ta', 'ta.id_pep = e.id_pep and ta.id_atk_penelaah = pa.id_atk_penelaah', 'left');
    $this->db->join('tb_putusan_awal as pw', 'pw.id_pep = e.id_pep', 'left');
		$this->db->where('pa.id_atk_penelaah', $id_atk_penelaah);
		$this->db->where('ta.id_ta is null');
    $this->db->where('pw.id_pa is null');
		$result = $this->db->get()->result_array();

		return $result;
	}

	public function get_data_pengajuan_by_idpep($id_pep)
	{
		$this->db->select('p.id_pengajuan, p.no_protokol, p.judul, p.nama_ketua, p.tempat_penelitian, p.is_multi_senter, p.is_setuju_senter');
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

	public function get_data_self_assesment_cek_by_idpep($id_pep)
	{
		$this->db->select('s.*');
		$this->db->from('tb_self_assesment_cek as s');
		$this->db->join('tb_pep as e', 'e.id_pengajuan = s.id_pengajuan and e.revisi_ke = s.revisi_ke');
		$this->db->where('e.id_pep', $id_pep);
		$result = $this->db->get()->row_array();

		return $result;
	}

	public function get_data_klasifikasi_by_idpep($id_pep)
	{
		$this->db->select('pa.klasifikasi');
		$this->db->from('tb_putusan_awal as pa');
		$this->db->where('pa.id_pep', $id_pep);
		$result = $this->db->get()->row_array();

		return $result;
	}

  public function get_data_resume_by_idpep($id_pep)
  {
	$this->db->select("'Sekretaris' as peresume, r.resume");
	$this->db->from('tb_resume as r');
	$this->db->where('r.id_pep', $id_pep);
	$result = $this->db->get()->result_array();

    return $result;
  }

	public function get_data_telaah_by_id($id)
	{
		$id_atk_penelaah = $this->get_id_atk_penelaah($this->session->userdata('id_user_'.APPAUTH));

		$this->db->select('ta.id_ta, ta.klasifikasi_usulan, ta.catatana, ta.catatanc, ta.catatand, ta.catatane, ta.catatanf, ta.catatang, ta.catatanh, ta.catatani, ta.catatanj, ta.catatank, ta.catatanl, ta.catatanm, ta.catatann, ta.catatano, ta.catatanp, ta.catatanq, ta.catatanr, ta.catatans, ta.catatant, ta.catatanu, ta.catatanv, ta.catatanw, ta.catatanx, ta.catatany, ta.catatanz, ta.catatanaa, ta.catatanbb, ta.catatancc, ta.catatan_link_proposal, ta.catatan_protokol, ta.catatan1, ta.catatan2, ta.catatan3, ta.catatan4, ta.catatan5, ta.catatan6, ta.catatan7, ta.catatan_7standar, atk.nama as nama_penelaah');
		$this->db->from('tb_telaah_awal as ta');
    $this->db->join('tb_anggota_tim_kepk as atk', 'atk.id_atk = ta.id_atk_penelaah');
		$this->db->where('ta.id_ta', $id);
		$this->db->where('ta.id_atk_penelaah', $id_atk_penelaah);
		$result = $this->db->get()->row_array();

		return $result;
	}

	public function get_data_standar_kelaikan($id, $id_pep)
	{
		$this->db->select('e.id_pengajuan, e.revisi_ke');
		$this->db->from('tb_pep as e');
		$this->db->where('e.id_pep', $id_pep);
		$rs = $this->db->get()->row_array();
		$id_pengajuan = $rs['id_pengajuan'];
    $revisi_ke = $rs['revisi_ke'];

		$this->db->select("jsk.*, msk.uraian as uraian_master, dsac.pilihan as pilihan_pengaju, tsa.pilihan as pilihan_penelaah, tsa.catatan");
		$this->db->from('tb_jabaran_standar_kelaikan as jsk');
		$this->db->join('tb_master_standar_kelaikan as msk', 'msk.id_msk = jsk.id_msk');
		$this->db->join('tb_detail_sa_cek as dsac', 'dsac.id_jsk = jsk.id_jsk');
		$this->db->join('tb_self_assesment_cek as sac', 'sac.id_sac = dsac.id_sac and sac.id_pengajuan = '.$id_pengajuan.' and sac.revisi_ke = '.$revisi_ke);
		$this->db->join('tb_telaah_self_assesment as tsa', 'tsa.id_jsk = jsk.id_jsk and tsa.id_ta = '.$id, 'left');
		$result = $this->db->get()->result_array();

		return $result;
	}

	public function check_exist_data($id)
	{
		$this->db->select('1')->from('tb_putusan_awal as pa')
				->join('tb_telaah_awal as ta', 'ta.id_pep = pa.id_pep')
				->where('ta.id_ta', $id);
		$rs = $this->db->get()->row_array();

		if ($rs)
			return TRUE;

		return FALSE;
	}

	function check_is_telaah_awal($id_pep)
	{
		$this->db->select('1')->from('tb_putusan_awal')->where('id_pep', $id_pep);
		$rs = $this->db->get()->row_array();
		
		if ($rs)
			return TRUE;

		return FALSE;
	}

	function check_valid_penelaah($id_pep)
	{
		$id_atk_penelaah = $this->get_id_atk_penelaah($this->session->userdata('id_user_'.APPAUTH));

		$this->db->select('1');
		$this->db->from('tb_penelaah_awal as pa');
		$this->db->join('tb_resume as r', 'r.id_resume = pa.id_resume');
		$this->db->where('r.id_pep', $id_pep);
		$this->db->where('pa.id_atk_penelaah', $id_atk_penelaah);
		$rs = $this->db->get()->row_array();
		
		if ($rs)
			return TRUE;

		return FALSE;
	}

	function delete_detail($id)
	{
		$this->delete_telaah_self_assesment($id);
		$this->delete_telaah_awal($id);
	}

	function delete_telaah_awal($id)
	{
		$this->db->where('id_ta', $id);
		$this->db->delete('tb_telaah_awal');
	}

	function delete_telaah_self_assesment($id)
	{
		$this->db->where('id_ta', $id);
		$this->db->delete('tb_telaah_self_assesment');
	}

}
