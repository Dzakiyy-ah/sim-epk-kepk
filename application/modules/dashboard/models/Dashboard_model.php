<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends Core_Model {

	public function __construct()
	{
		parent::__construct();

	}

	function get_id_atk_sekretaris($id_user)
	{
		$this->db->select('s.id_atk');
		$this->db->from('tb_struktur_tim_kepk as s');
		$this->db->join('tb_users as u', 'u.id_stk = s.id_stk');
		$this->db->where('u.id_user', $id_user);
		$result = $this->db->get()->row_array();

		return $result['id_atk'];
	}

	function get_data_pembebasan_etik()
	{
		$this->db->select("e.id_pep, p.no_protokol, p.judul, pa.inserted");
		$this->db->from('tb_pep as e');
		$this->db->join('tb_pengajuan as p', 'p.id_pengajuan = e.id_pengajuan');
		$this->db->join('tb_putusan_awal as pa', 'pa.id_pep = e.id_pep');
    $this->db->join('tb_ethical_exemption as ee', 'ee.id_pep = e.id_pep', 'left');
		$this->db->where('pa.klasifikasi', 1); // klasifikasi 1=Exempted
		$this->db->where('p.id_kepk', $this->session->userdata('id_kepk_tim'));
    $this->db->where('ee.id_ethical_exemption is null');
		$this->db->order_by('p.no_protokol');
		$result = $this->db->get()->result_array();

		return $result;
	}

	function get_data_persetujuan_etik()
	{
		$this->db->select("
			kr.id_pep,
			case kr.klasifikasi
				when 2 then 'Expedited'
				when 3 then 'Full Board'
			end as klasifikasi,
			p.no_protokol,
			p.judul,
			kr.inserted
		");
		$this->db->from('tb_kirim_putusan_ke_sekretariat as kr');
		$this->db->join('tb_pep as e', 'e.id_pep = kr.id_pep');
		$this->db->join('tb_pengajuan as p', 'p.id_pengajuan = e.id_pengajuan');
    $this->db->join('tb_ethical_approval as ep', 'ep.id_pep = e.id_pep', 'left');
		$this->db->where('kr.keputusan', 'LE');
		$this->db->where('kr.klasifikasi <> 1');
		$this->db->where('p.id_kepk', $this->session->userdata('id_kepk_tim'));
    $this->db->where('ep.id_ethical_approval is null');
		$result = $this->db->get()->result_array();

		return $result;
	}

	function get_data_perbaikan_etik()
	{
		$this->db->select("
			kr.id_pep,
			case kr.klasifikasi
				when 2 then 'Expedited'
				when 3 then 'Full Board'
				when 4 then 'Tidak Bisa Ditelaah'
			end as klasifikasi,
			p.no_protokol,
			p.judul,
			kr.inserted
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

	function get_data_telaah_pelapor()
	{
		$id_atk_pelapor = $this->get_id_atk($this->session->userdata('id_user_'.APPAUTH));

    $query = "
      select e.id_pep, p.id_pengajuan, p.no_protokol, p.judul, pa.inserted, e.revisi_ke, pa.klasifikasi
      from tb_pep as e
      join tb_pengajuan as p on p.id_pengajuan = e.id_pengajuan
      join tb_putusan_awal as pa on pa.id_pep = e.id_pep
      left join tb_putusan_expedited as pe on pe.id_pep = e.id_pep and pe.id_atk_pelapor = ".$id_atk_pelapor."
      where p.id_kepk = ".$this->session->userdata('id_kepk_tim')."
        and pa.id_atk_pelapor =".$id_atk_pelapor."
        and pa.klasifikasi = 2
        and pe.id_pexp is null
        and e.revisi_ke = 0

      union

      select e.id_pep, p.id_pengajuan, p.no_protokol, p.judul, x.inserted, e.revisi_ke, x.klasifikasi
      from tb_pep as e
      join tb_pengajuan as p on p.id_pengajuan = e.id_pengajuan
      join tb_kirim_ke_kepk as kr on kr.id_pengajuan = e.id_pengajuan and kr.id_pep = e.id_pep and kr.id_kepk = p.id_kepk
      join (select e2.id_pengajuan, pa2.id_atk_pelapor, pa2.klasifikasi, pa2.inserted from tb_pep as e2 join tb_putusan_awal as pa2 on pa2.id_pep = e2.id_pep where pa2.klasifikasi = 2 and pa2.id_atk_pelapor = ".$id_atk_pelapor.") as x on x.id_pengajuan = p.id_pengajuan
      left join tb_putusan_expedited as pe on pe.id_pep = e.id_pep and pe.id_atk_pelapor = ".$id_atk_pelapor."
      where p.id_kepk = ".$this->session->userdata('id_kepk_tim')."
        and x.id_atk_pelapor =".$id_atk_pelapor."
        and (kr.klasifikasi = 2 or kr.klasifikasi = 4)
        and pe.id_pexp is null
        and e.revisi_ke > 0

      union

      select e.id_pep, p.id_pengajuan, p.no_protokol, p.judul, pa.inserted, e.revisi_ke, pa.klasifikasi
      from tb_pep as e
      join tb_pengajuan as p on p.id_pengajuan = e.id_pengajuan
      join tb_putusan_awal as pa on pa.id_pep = e.id_pep
      left join tb_putusan_fullboard as pf on pf.id_pep = e.id_pep and pf.id_atk_pelapor = ".$id_atk_pelapor."
      where p.id_kepk = ".$this->session->userdata('id_kepk_tim')."
        and pa.id_atk_pelapor =".$id_atk_pelapor."
        and pa.klasifikasi = 3
        and pf.id_pfbd is null
        and e.revisi_ke = 0

      union

      select e.id_pep, p.id_pengajuan, p.no_protokol, p.judul, paef.inserted, e.revisi_ke, paef.klasifikasi
      from tb_pep as e
      join tb_pengajuan as p on p.id_pengajuan = e.id_pengajuan
      join tb_putusan_awal_expedited_to_fullboard as paef on paef.id_pep = e.id_pep
      left join tb_putusan_fullboard as pf on pf.id_pep = e.id_pep and pf.id_atk_pelapor = ".$id_atk_pelapor."
      where p.id_kepk = ".$this->session->userdata('id_kepk_tim')."
        and paef.id_atk_pelapor =".$id_atk_pelapor."
        and paef.klasifikasi = 3
        and pf.id_pfbd is null

      union

      select e.id_pep, p.id_pengajuan, p.no_protokol, p.judul, x.inserted, e.revisi_ke, x.klasifikasi
      from tb_pep as e
      join tb_pengajuan as p on p.id_pengajuan = e.id_pengajuan
      join tb_kirim_ke_kepk as kr on kr.id_pengajuan = e.id_pengajuan and kr.id_pep = e.id_pep and kr.id_kepk = p.id_kepk
      join (select e2.id_pengajuan, pa2.id_atk_pelapor, pa2.klasifikasi, pa2.inserted from tb_pep as e2 join tb_putusan_awal as pa2 on pa2.id_pep = e2.id_pep where pa2.klasifikasi = 3 and pa2.id_atk_pelapor = ".$id_atk_pelapor.") as x on x.id_pengajuan = p.id_pengajuan
      left join tb_putusan_fullboard as pf on pf.id_pep = e.id_pep and pf.id_atk_pelapor = ".$id_atk_pelapor."
      where p.id_kepk = ".$this->session->userdata('id_kepk_tim')."
        and x.id_atk_pelapor =".$id_atk_pelapor."
        and (kr.klasifikasi = 3 or kr.klasifikasi = 4)
        and pf.id_pfbd is null
        and e.revisi_ke > 0

      union

      select e.id_pep, p.id_pengajuan, p.no_protokol, p.judul, x.inserted, e.revisi_ke, x.klasifikasi
      from tb_pep as e
      join tb_pengajuan as p on p.id_pengajuan = e.id_pengajuan
      join tb_kirim_ke_kepk as kr on kr.id_pengajuan = e.id_pengajuan and kr.id_pep = e.id_pep and kr.id_kepk = p.id_kepk
      join (select e2.id_pengajuan, paef2.id_atk_pelapor, paef2.klasifikasi, paef2.inserted from tb_pep as e2 join tb_putusan_awal_expedited_to_fullboard as paef2 on paef2.id_pep = e2.id_pep where paef2.klasifikasi = 3 and paef2.id_atk_pelapor = ".$id_atk_pelapor.") as x on x.id_pengajuan = p.id_pengajuan
      left join tb_putusan_fullboard as pf on pf.id_pep = e.id_pep and pf.id_atk_pelapor = ".$id_atk_pelapor."
      where p.id_kepk = ".$this->session->userdata('id_kepk_tim')."
        and x.id_atk_pelapor =".$id_atk_pelapor."
        and kr.klasifikasi = 3
        and pf.id_pfbd is null
        and e.revisi_ke > 0
    ";

		$result = $this->db->query($query)->result_array();

		return $result;
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

	function get_data_putusan_fullboard()
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

	function get_data_tim_penelaah_by_id_pengajuan($id_pengajuan)
	{
    $query = "
      select atk.nama from tb_anggota_tim_kepk as atk
      join tb_penelaah_mendalam as pm on pm.id_atk_penelaah = atk.id_atk
      join tb_putusan_awal as pa on pa.id_pa = pm.id_pa
      join tb_pep as e on e.id_pep = pa.id_pep
      where e.id_pengajuan = ".$id_pengajuan." and atk.id_kepk = ".$this->session->userdata('id_kepk_tim')."

      union

      select atk.nama from tb_anggota_tim_kepk as atk
      join tb_penelaah_mendalam_exptofb as pmef on pmef.id_atk_penelaah = atk.id_atk
      join tb_putusan_awal_expedited_to_fullboard as paef on paef.id_paef = pmef.id_paef
      join tb_pep as e on e.id_pep = paef.id_pep
      where e.id_pengajuan = ".$id_pengajuan." and atk.id_kepk = ".$this->session->userdata('id_kepk_tim')."
    ";
    $result = $this->db->query($query)->result_array();

    return $result;
	}

  function get_data_pemberitahuan_fullboard()
  {
    $this->db->select("
        pf.id_bfbd,
        pf.tgl_fullboard,
        pf.jam_fullboard,
        pf.tempat_fullboard,
        p.no_protokol,
        p.judul,
        pf.inserted
      ");
    $this->db->from('tb_pemberitahuan_fullboard as pf');
    $this->db->join('tb_pep as e', 'e.id_pep = pf.id_pep');
    $this->db->join('tb_pengajuan as p', 'p.id_pengajuan = e.id_pengajuan');
    $this->db->join('tb_kirim_bfbd_ke_peneliti as kr', 'kr.id_pep = e.id_pep');
    $this->db->where('p.id_pengusul', $this->session->userdata('id_pengusul'));
    $this->db->where('pf.tgl_fullboard >=', date('Y-m-d')); // ditampilkan yg masih belum melewati tgl_fullboardnya
    $this->db->order_by('pf.inserted', 'desc');
    $result = $this->db->get()->result_array();

    return $result;
  }

  public function get_data_protokol_jqgrid($param, $isCount=FALSE, $CompileOnly=False)
  {
    $fieldmap_filter = array(
      'no_protokol' => 'p.no_protokol',
      'judul' => 'p.judul',
      'tanggal' => 'date(p.inserted)',
      'kepk' => 'k.nama_kepk',
      'alasan_ditolak' => 'r.alasan_ditolak'
    );

    $this->db->select('p.id_pengajuan, p.no_protokol, p.judul, p.inserted as tanggal_pengajuan, k.nama_kepk, r.alasan_ditolak');
    $this->db->from('tb_pengajuan as p');
    $this->db->join('tb_kepk as k', 'k.id_kepk = p.id_kepk');
    $this->db->join('tb_pep as e', 'e.id_pengajuan = p.id_pengajuan');
    $this->db->join('tb_resume as r', 'r.id_pep = e.id_pep');
    $this->db->join('tb_pengusul as pn', 'pn.id_pengusul = p.id_pengusul');
    $this->db->where('r.lanjut_telaah', 'DITOLAK');
    $this->db->where('p.id_pengusul', $this->session->userdata('id_pengusul'));

    // proses parameter pencarian, jika ada
    if (isset($param['_search']) && $param['_search'] == 'true' )
    {
      $fld = $param['search_fld'];
      switch($fld){
        case 'tanggal': $str = prepare_date($param['search_str']); break;
        default : $str = $param['search_str']; break;
      }
      $op = $param['search_op'];

      if (strlen($str) > 0)
      {
        switch ($op) {
          case 'eq': $this->db->where($fieldmap_filter[$fld] . " = '" .$str . "'"); break;
          case 'ne': $this->db->where($fieldmap_filter[$fld] . " <> '" . $str . "'"); break;
          case 'bw': $this->db->where($fieldmap_filter[$fld] . " LIKE '%" . $str . "'"); break;
          case 'bn': $this->db->where($fieldmap_filter[$fld] . " NOT LIKE '%" . $str . "'"); break;
          case 'ew': $this->db->where($fieldmap_filter[$fld] . " LIKE '" . $str . "%'"); break;
          case 'en': $this->db->where($fieldmap_filter[$fld] . " NOT LIKE '" . $str . "%'"); break;
          case 'cn': $this->db->where($fieldmap_filter[$fld] . " LIKE '%" . $str . "%'"); break;
          case 'nc': $this->db->where($fieldmap_filter[$fld] . " NOT LIKE '%" . $str . "%'"); break;
          case 'nu': $this->db->where($fieldmap_filter[$fld] . " IS NULL"); break;
          case 'nn': $this->db->where($fieldmap_filter[$fld] . " IS NOT NULL"); break;
          case 'in': $this->db->where($fieldmap_filter[$fld] . " LIKE '" . $str . "'"); break;
          case 'ni': $this->db->where($fieldmap_filter[$fld] . " NOT LIKE '" . $str . "'"); break;
        }
      }
    }

    if (isset($param['sort_by']) && $param['sort_by'] != null && !$isCount && $ob = get_order_by_str($param['sort_by'], $fieldmap_filter))
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

  function get_data_protokol_belum_kirim()
  {
    if ($this->session->userdata('id_group_'.APPAUTH) == 3)
    {
      $query = "
        select p.id_pengajuan, p.no_protokol, p.judul, e.id_pep, e.revisi_ke, 0 as klasifikasi
        from tb_pengajuan as p
        join tb_pep as e on e.id_pengajuan = p.id_pengajuan
        join tb_self_assesment_cek as sac on sac.id_pengajuan = p.id_pengajuan
        left join tb_kirim_ke_kepk as kr on kr.id_pep = e.id_pep
        where kr.id_kirim is null
          and sac.revisi_ke = 0
          and p.id_pengusul = ".$this->session->userdata('id_pengusul')."

        union

        select p.id_pengajuan, p.no_protokol, p.judul, e.id_pep, e.revisi_ke, coalesce(ks.klasifikasi, 0) as klasifikasi
        from tb_pengajuan as p
        join tb_pep as e on e.id_pengajuan = p.id_pengajuan
        join tb_kirim_surat_ke_peneliti as ks on ks.id_pep = e.id_pep_old
        left join tb_kirim_ke_kepk as kr on kr.id_pep = e.id_pep
        where kr.id_kirim is null
          and p.id_pengusul = ".$this->session->userdata('id_pengusul')."
      ";
    }
    else if ($this->session->userdata('id_group_'.APPAUTH) == 6)
    {
      $id_atk_pelapor = $this->get_id_atk($this->session->userdata('id_user_'.APPAUTH));

      $query = "
        select p.id_pengajuan, p.no_protokol, p.judul, e.id_pep, e.revisi_ke, 2 as klasifikasi, pe.keputusan
        from tb_pengajuan as p
        join tb_pep as e on e.id_pengajuan = p.id_pengajuan
        join tb_putusan_expedited as pe on pe.id_pep = e.id_pep
        left join tb_kirim_putusan_ke_sekretaris as ks on ks.id_pep = e.id_pep
        where pe.id_atk_pelapor = ".$id_atk_pelapor." and ks.id_kirim is null

        union

        select p.id_pengajuan, p.no_protokol, p.judul, e.id_pep, e.revisi_ke, 3 as klasifikasi, pf.keputusan
        from tb_pengajuan as p
        join tb_pep as e on e.id_pengajuan = p.id_pengajuan
        join tb_putusan_fullboard as pf on pf.id_pep = e.id_pep
        left join tb_kirim_putusan_ke_sekretaris as ks on ks.id_pep = e.id_pep
        where pf.id_atk_pelapor = ".$id_atk_pelapor." and ks.id_kirim is null
      ";
    }
    $result = $this->db->query($query)->result_array();

    return $result;
  }
  
}
