<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Telaah_fullboard_model extends Core_Model {

	var $fieldmap_filter;
	var $data_sa;

	public function __construct()
	{
		parent::__construct();

    $this->fieldmap_filter = array(
      'no_protokol' => 'p.no_protokol',
      'judul' => 'p.judul',
      'tgl_pengajuan' => 'date(p.inserted)',
      'tgl_perbaikan' => 'date(e.inserted)',
      'revisi_ke' => 'e.revisi_ke',
      'kepk' => 'k.nama_kepk',
      'mulai' => 'date(p.waktu_mulai)',
      'selesai' => 'date(p.waktu_selesai)',
      'tgl_telaah' => 'date(t.inserted)',
      'kelayakan' => "case t.kelayakan
                        when 'LE' then 'Layak Etik'
                        when 'R' then 'Perbaikan'
                      end"
    );
	}

 	public function fill_data()
	{
		$id = $this->input->post('id') ? $this->input->post('id') : 0;
		$id_pep = $this->input->post('id_pep') ? $this->input->post('id_pep') : 0;
		$kelayakan = $this->input->post('kelayakan') ? $this->input->post('kelayakan') : '';		
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

		$catatan1 = $this->input->post('catatan1') ? addslashes(str_replace($remove_str, ' ', $this->input->post('catatan1'))) : '';
		$catatan2 = $this->input->post('catatan2') ? addslashes(str_replace($remove_str, ' ', $this->input->post('catatan2'))) : '';
		$catatan3 = $this->input->post('catatan3') ? addslashes(str_replace($remove_str, ' ', $this->input->post('catatan3'))) : '';
		$catatan4 = $this->input->post('catatan4') ? addslashes(str_replace($remove_str, ' ', $this->input->post('catatan4'))) : '';
		$catatan5 = $this->input->post('catatan5') ? addslashes(str_replace($remove_str, ' ', $this->input->post('catatan5'))) : '';
		$catatan6 = $this->input->post('catatan6') ? addslashes(str_replace($remove_str, ' ', $this->input->post('catatan6'))) : '';
		$catatan7 = $this->input->post('catatan7') ? addslashes(str_replace($remove_str, ' ', $this->input->post('catatan7'))) : '';
    $catatan_7standar = $this->input->post('catatan_7standar') ? addslashes(str_replace($remove_str, ' ', $this->input->post('catatan_7standar'))) : '';

	  $this->data = array(
      'id_tfbd' => $id,
      'id_pep' => $id_pep,
      'id_atk_penelaah' => $id_penelaah,
      'kelayakan' => $kelayakan,
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
      'catatan_sa1' => $catatan1,
      'catatan_sa2' => $catatan2,
      'catatan_sa3' => $catatan3,
      'catatan_sa4' => $catatan4,
      'catatan_sa5' => $catatan5,
      'catatan_sa6' => $catatan6,
      'catatan_sa7' => $catatan7,
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
		$this->insert_telaah_fullboard();
		$this->insert_fullboard_self_assesment();
	}

	function insert_telaah_fullboard()
	{
		$this->db->select('1')->from('tb_telaah_fullboard')->where('id_tfbd', $this->data['id_tfbd']);
		$rs = $this->db->get()->row_array();

		if ($rs)
		{
			$this->db->where('id_tfbd', $this->data['id_tfbd']);
			$this->db->update('tb_telaah_fullboard', $this->data);
			$this->check_trans_status('update tb_telaah_fullboard failed');
			$this->id = $this->data['id_tfbd'];

			$aktivitas = 'Edit Telaah Full Board '.$this->input->post('no_protokol');
			$id_user_kepk = $this->get_id_atk_penelaah($this->session->userdata('id_user_'.APPAUTH));
			$id_user =$this->session->userdata('id_user_'.APPAUTH);
			simpan_logaktivitas_tim_kepk($aktivitas, $id_user_kepk, $id_user);
		}
		else
		{
			unset($this->data['id_tfbd']);
			$this->db->insert('tb_telaah_fullboard', $this->data);
			$this->check_trans_status('insert tb_telaah_fullboard failed');
			$this->id = $this->db->insert_id();

			$aktivitas = 'Insert Telaah Full Board '.$this->input->post('no_protokol');
			$id_user_kepk = $this->get_id_atk_penelaah($this->session->userdata('id_user_'.APPAUTH));
			$id_user =$this->session->userdata('id_user_'.APPAUTH);
			simpan_logaktivitas_tim_kepk($aktivitas, $id_user_kepk, $id_user);
		}		
	}

	function insert_fullboard_self_assesment()
	{
    $data_update = array();
    $data_insert = array();
		for ($i=0; $i<count($this->data_sa); $i++)
		{
			$this->db->select('id_fsa')->from('tb_fullboard_self_assesment')->where('id_tfbd', $this->id)->where('id_jsk', $this->data_sa[$i]['id_jsk']);
			$rs = $this->db->get()->row_array();

			if ($rs)
			{
        $data_update[] = array(
          'id_fsa' => $rs['id_fsa'],
          'id_tfbd' => $this->id,
          'id_jsk' => $this->data_sa[$i]['id_jsk'],
          'pilihan' => $this->data_sa[$i]['pilihan'],
          'catatan' => $this->data_sa[$i]['catatan']
        );
			}
			else
			{
        $data_insert[] = array(
          'id_tfbd' => $this->id,
          'id_jsk' => $this->data_sa[$i]['id_jsk'],
          'pilihan' => $this->data_sa[$i]['pilihan'],
          'catatan' => $this->data_sa[$i]['catatan']
        );
			}
		}

    if (!empty($data_update)){
      $this->db->update_batch('tb_fullboard_self_assesment', $data_update, 'id_fsa');
      $this->check_trans_status('update tb_fullboard_self_assesment failed');
    }

    if (!empty($data_insert)){
      $this->db->insert_batch('tb_fullboard_self_assesment', $data_insert);
      $this->check_trans_status('insert tb_fullboard_self_assesment failed');
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
        t.id_tfbd,
        t.id_pep,
        p.no_protokol, 
        p.judul, 
        p.waktu_mulai, 
        p.waktu_selesai, 
        p.inserted as tanggal_pengajuan, 
        e.inserted as tanggal_protokol,
        e.revisi_ke,
        k.nama_kepk, 
        case t.kelayakan
          when 'LE' then 'Layak Etik'
          when 'R' then 'Perbaikan'
        end as kelayakan,
        t.inserted as tanggal_telaah
      ");
    $this->db->from('tb_telaah_fullboard as t');
    $this->db->join('tb_pep as e', 'e.id_pep = t.id_pep');
    $this->db->join('tb_pengajuan as p', 'p.id_pengajuan = e.id_pengajuan');
    $this->db->join('tb_kepk as k', 'k.id_kepk = p.id_kepk');
    $this->db->where('t.id_atk_penelaah', $id_atk_penelaah);

    // proses parameter pencarian, jika ada
    if (isset($param['_search']) && $param['_search'] == 'true' )
    {
      $fld = $param['search_fld'];
      switch($fld){
        case 'tgl_pengajuan': $str = prepare_date($param['search_str']); break;
        case 'tgl_perbaikan': $str = prepare_date($param['search_str']); break;
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
		$id_atk_penelaah = $this->get_id_atk_penelaah($this->session->userdata('id_user_'.APPAUTH));

    $query = "
      select e.id_pep, p.no_protokol, p.judul, pf.tgl_fullboard, pf.jam_fullboard, pf.tempat_fullboard, pa.inserted, e.revisi_ke
      from tb_pep as e
      join tb_pengajuan as p on p.id_pengajuan = e.id_pengajuan
      join tb_putusan_awal as pa on pa.id_pep = e.id_pep
      join tb_penelaah_mendalam as pm on pm.id_pa = pa.id_pa and pm.id_atk_penelaah = ".$id_atk_penelaah."
      left join tb_pemberitahuan_fullboard as pf on pf.id_pep = e.id_pep
      left join tb_telaah_fullboard as tf on tf.id_pep = e.id_pep and tf.id_atk_penelaah = ".$id_atk_penelaah."
      left join tb_putusan_fullboard as pfbd on pfbd.id_pep = e.id_pep
      where p.id_kepk = ".$this->session->userdata('id_kepk_tim')."
        and pa.klasifikasi = 3
        and tf.id_tfbd is null
        and pfbd.id_pfbd is null
        and e.revisi_ke = 0

      union

      select e.id_pep, p.no_protokol, p.judul, pf.tgl_fullboard, pf.jam_fullboard, pf.tempat_fullboard, paef.inserted, e.revisi_ke
      from tb_pep as e
      join tb_pengajuan as p on p.id_pengajuan = e.id_pengajuan
      join tb_putusan_awal_expedited_to_fullboard as paef on paef.id_pep = e.id_pep
      join tb_penelaah_mendalam_exptofb as pm on pm.id_paef = paef.id_paef and pm.id_atk_penelaah = ".$id_atk_penelaah."
      left join tb_pemberitahuan_fullboard as pf on pf.id_pep = e.id_pep
      left join tb_telaah_fullboard as tf on tf.id_pep = e.id_pep and tf.id_atk_penelaah = ".$id_atk_penelaah."
      left join tb_putusan_fullboard as pfbd on pfbd.id_pep = e.id_pep
      where p.id_kepk = ".$this->session->userdata('id_kepk_tim')."
        and paef.klasifikasi = 3
        and tf.id_tfbd is null
        and pfbd.id_pfbd is null

      union

      select e.id_pep, p.no_protokol, p.judul, pf.tgl_fullboard, pf.jam_fullboard, pf.tempat_fullboard, x.inserted, e.revisi_ke
      from tb_pep as e
      join tb_pengajuan as p on p.id_pengajuan = e.id_pengajuan
      join tb_kirim_ke_kepk as kr on kr.id_pengajuan = e.id_pengajuan and kr.id_pep = e.id_pep and kr.id_kepk = p.id_kepk
      join (select e2.id_pengajuan, pa2.inserted from tb_pep as e2 join tb_putusan_awal as pa2 on pa2.id_pep = e2.id_pep join tb_penelaah_mendalam as pm2 on pm2.id_pa = pa2.id_pa where pa2.klasifikasi = 3 and pm2.id_atk_penelaah = ".$id_atk_penelaah.") as x on x.id_pengajuan = p.id_pengajuan
      left join tb_pemberitahuan_fullboard as pf on pf.id_pep = e.id_pep
      left join tb_telaah_fullboard as tf on tf.id_pep = e.id_pep and tf.id_atk_penelaah = ".$id_atk_penelaah."
      left join tb_putusan_fullboard as pfbd on pfbd.id_pep = e.id_pep
      where p.id_kepk = ".$this->session->userdata('id_kepk_tim')."
        and kr.klasifikasi = 3
        and tf.id_tfbd is null
        and pfbd.id_pfbd is null
        and e.revisi_ke > 0

      union

      select e.id_pep, p.no_protokol, p.judul, pf.tgl_fullboard, pf.jam_fullboard, pf.tempat_fullboard, x.inserted, e.revisi_ke
      from tb_pep as e
      join tb_pengajuan as p on p.id_pengajuan = e.id_pengajuan
      join tb_kirim_ke_kepk as kr on kr.id_pengajuan = e.id_pengajuan and kr.id_pep = e.id_pep and kr.id_kepk = p.id_kepk
      join (select e2.id_pengajuan, paef2.inserted from tb_pep as e2 join tb_putusan_awal_expedited_to_fullboard as paef2 on paef2.id_pep = e2.id_pep join tb_penelaah_mendalam_exptofb as peef2 on peef2.id_paef = paef2.id_paef where paef2.klasifikasi = 3 and peef2.id_atk_penelaah = ".$id_atk_penelaah.") as x on x.id_pengajuan = p.id_pengajuan
      left join tb_pemberitahuan_fullboard as pf on pf.id_pep = e.id_pep
      left join tb_telaah_fullboard as tf on tf.id_pep = e.id_pep and tf.id_atk_penelaah = ".$id_atk_penelaah."
      left join tb_putusan_fullboard as pfbd on pfbd.id_pep = e.id_pep
      where p.id_kepk = ".$this->session->userdata('id_kepk_tim')."
        and kr.klasifikasi = 3
        and tf.id_tfbd is null
        and pfbd.id_pfbd is null
        and e.revisi_ke > 0
    ";
		$result = $this->db->query($query)->result_array();

		return $result;
	}

	public function get_data_pengajuan_by_idpep($id_pep)
	{
		$this->db->select('p.id_pengajuan, p.no_protokol, p.judul, p.nama_ketua, p.tempat_penelitian, p.is_multi_senter, p.is_setuju_senter, e.revisi_ke, te.id_texp as exp_to_fb');
		$this->db->from('tb_pengajuan as p');
		$this->db->join('tb_pep as e', 'e.id_pengajuan = p.id_pengajuan');
    $this->db->join('tb_telaah_expedited as te', 'te.id_pep = e.id_pep', 'left');
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

	public function get_data_resume_by_idpep($id_pep)
	{
		$this->db->select('r.id_resume, r.resume');
		$this->db->from('tb_resume as r');
		$this->db->where('r.id_pep', $id_pep);
		$result = $this->db->get()->result_array();

    return $result;
	}

  function get_data_pemberitahuan_fullboard_by_idpep($id_pep)
  {
    $this->db->select('pf.tgl_fullboard, pf.jam_fullboard, pf.tempat_fullboard');
    $this->db->from('tb_pemberitahuan_fullboard as pf');
    $this->db->where('pf.id_pep', $id_pep);
    $result = $this->db->get()->row_array();

    return $result;
  }

 	public function get_data_by_id($id)
	{
		$this->db->select('t.*, atk.nama as nama_penelaah');
		$this->db->from('tb_telaah_fullboard as t');
    $this->db->join('tb_anggota_tim_kepk as atk', 'atk.id_atk = t.id_atk_penelaah');
		$this->db->where('t.id_tfbd', $id);
		$result = $this->db->get()->row_array();

		return $result;
	}

	public function get_data_standar_kelaikan($id, $id_pep)
	{
		$id_atk_penelaah = $this->get_id_atk_penelaah($this->session->userdata('id_user_'.APPAUTH));

		$this->db->select('e.id_pengajuan, e.revisi_ke');
		$this->db->from('tb_pep as e');
		$this->db->where('e.id_pep', $id_pep);
		$rs = $this->db->get()->row_array();
		$id_pengajuan = $rs['id_pengajuan'];
    $revisi_ke = $rs['revisi_ke'];

		$this->db->select("jsk.*, msk.uraian as uraian_master, dsac.pilihan as pilihan_pengaju, tea.pilihan as pilihan_penelaah, tea.catatan");
		$this->db->from('tb_jabaran_standar_kelaikan as jsk');
		$this->db->join('tb_master_standar_kelaikan as msk', 'msk.id_msk = jsk.id_msk');
		$this->db->join('tb_detail_sa_cek as dsac', 'dsac.id_jsk = jsk.id_jsk');
		$this->db->join('tb_self_assesment_cek as sac', 'sac.id_sac = dsac.id_sac and sac.id_pengajuan = '.$id_pengajuan.' and sac.revisi_ke = '.$revisi_ke);
		$this->db->join('tb_fullboard_self_assesment as tea', 'tea.id_jsk = jsk.id_jsk and tea.id_tfbd = '.$id, 'left');
		$result = $this->db->get()->result_array();

		return $result;
	}

	function check_is_putusan($id_pep)
	{
		$this->db->select('1')->from('tb_putusan_fullboard')->where('id_pep', $id_pep);
		$rs = $this->db->get()->row_array();
		
		if ($rs)
			return 1;

		return 0;
	}

	function get_data_putusan($id_pep)
	{
    $query = "
        select pe.ringkasan from tb_putusan_expedited as pe join tb_pep as e on e.id_pep_old = pe.id_pep
        where e.id_pep = ".$id_pep."

        union

        select pf.ringkasan from tb_putusan_fullboard as pf join tb_pep as e on e.id_pep_old = pf.id_pep
        where e.id_pep = ".$id_pep."
    ";

    $result = $this->db->query($query)->row_array();

		return $result;
	}

	function get_data_uraian_before($id_pep, $id_pengajuan, $uraian)
	{
		$this->db->select('e.id_pep, e.'.$uraian.' as uraian, e.inserted');
		$this->db->from('tb_pep as e');
		$this->db->where('e.id_pengajuan', $id_pengajuan);
		$this->db->where('e.id_pep <', $id_pep);
		$this->db->order_by('e.inserted', 'asc');
		$result = $this->db->get()->result_array();

		return $result;
	}

  function get_data_catatan_before($id_pep, $id_pengajuan, $catatan)
  {
    $id_penelaah = $this->get_id_atk_penelaah($this->session->userdata('id_user_'.APPAUTH));

    $query = "
        select te.id_pep, te.".$catatan." as catatan, te.inserted
        from tb_telaah_expedited as te
        join tb_pep as e on e.id_pep = te.id_pep
        where e.id_pengajuan = ".$id_pengajuan."
            and e.id_pep <= ".$id_pep."
            and te.id_atk_penelaah = ".$id_penelaah."

        union

        select tf.id_pep, tf.".$catatan." as catatan, tf.inserted
        from tb_telaah_fullboard as tf
        join tb_pep as e on e.id_pep = tf.id_pep
        where e.id_pengajuan = ".$id_pengajuan."
            and e.id_pep < ".$id_pep."
            and tf.id_atk_penelaah = ".$id_penelaah."

        order by inserted asc
    ";

    $result = $this->db->query($query)->result_array();

    return $result;
  }

/*	public function check_exist_data($id)
	{
		$this->db->select('s.id_atk');
		$this->db->from('tb_struktur_tim_kepk as s');
		$this->db->where('s.id_tim_kepk', $id);
		$result = $this->db->get()->result_array();

		if ($result)
		{
			for ($i=0; $i<count($result); $i++)
			{
				return $this->check_exist_data_atk($result[$i]['id_atk']);
			}
		}
		else return FALSE;
	}*/

}
