<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daftar_pengajuan_model extends CI_Model {
	
	var $fieldmap_filter;

	public function __construct()
	{
		parent::__construct();

		$this->fieldmap_filter = array(
			'no_protokol' => 'a.no_protokol',
			'judul' => 'a.judul', 
			'kepk' =>  'a.nama_kepk',
			'nama_ketua' => 'a.nama_ketua',
      'tgl_pengajuan' => 'date(a.tanggal_pengajuan)',
      'klasifikasi' => 'a.klasifikasi',
      'tgl_keputusan' => 'date(a.tanggal_keputusan)'
		);
	}

	function get_data($param, $isCount=FALSE, $CompileOnly=False)
	{
		$id_kepk = $this->input->post('id_kepk') ? $this->input->post('id_kepk') : 0;

    $subquery = "
      select p.id_pengajuan, p.no_protokol, p.judul, k.nama_kepk, p.nama_ketua, p.inserted as tanggal_pengajuan, null as klasifikasi, null as tanggal_keputusan
      from tb_pengajuan as p
      join tb_kepk as k on k.id_kepk = p.id_kepk
      left join tb_pep as e on e.id_pengajuan = p.id_pengajuan
      left join tb_kirim_ke_kepk as kr on kr.id_pengajuan = p.id_pengajuan
      where kr.id_kirim is null
    
      union
    
      select p.id_pengajuan, p.no_protokol, p.judul, k.nama_kepk, p.nama_ketua, p.inserted as tanggal_pengajuan, null as klasifikasi, null as tanggal_keputusan
      from tb_pengajuan as p
      join tb_kepk as k on k.id_kepk = p.id_kepk
      join tb_pep as e on e.id_pengajuan = p.id_pengajuan
      join tb_resume as r on r.id_pep = e.id_pep
      left join tb_putusan_awal as pa on pa.id_pep = e.id_pep
      where r.lanjut_telaah = 'YA' and pa.id_pa is null
    
      union
    
      select p.id_pengajuan, p.no_protokol, p.judul, k.nama_kepk, p.nama_ketua, p.inserted as tanggal_pengajuan, 'TBD' as klasifikasi, null as tanggal_keputusan
      from tb_pengajuan as p
      join tb_kepk as k on k.id_kepk = p.id_kepk
      join tb_pep as e on e.id_pengajuan = p.id_pengajuan
      join tb_resume as r on r.id_pep = e.id_pep
      where r.lanjut_telaah = 'TBD'
    
      union
    
      select p.id_pengajuan, p.no_protokol, p.judul, k.nama_kepk, p.nama_ketua, p.inserted as tanggal_pengajuan, 'DITOLAK' as klasifikasi, null as tanggal_keputusan
      from tb_pengajuan as p
      join tb_kepk as k on k.id_kepk = p.id_kepk
      join tb_pep as e on e.id_pengajuan = p.id_pengajuan
      join tb_resume as r on r.id_pep = e.id_pep
      where r.lanjut_telaah = 'DITOLAK'
    
      union
    
      select p.id_pengajuan, p.no_protokol, p.judul, k.nama_kepk, p.nama_ketua, p.inserted as tanggal_pengajuan, 'Exempted' as klasifikasi, kps.inserted as tanggal_keputusan
      from tb_pengajuan as p
      join tb_kepk as k on k.id_kepk = p.id_kepk
      join tb_pep as e on e.id_pengajuan = p.id_pengajuan
      join tb_putusan_awal as pa on pa.id_pep = e.id_pep
      left join tb_kirim_putusan_ke_sekretariat as kps on kps.id_pep = e.id_pep and kps.klasifikasi = 1
      where pa.klasifikasi = 1
    
      union
    
      select p.id_pengajuan, p.no_protokol, p.judul, k.nama_kepk, p.nama_ketua, p.inserted as tanggal_pengajuan, 
        if (x.klasifikasi is null, 
          case pa.klasifikasi 
            when 2 then 
            if (p.id_pengajuan in (
              select e3.id_pengajuan from tb_pep as e3 
              join tb_putusan_awal_expedited_to_fullboard as paef on paef.id_pep = e3.id_pep
            ), 'Full Board', 'Expedited') 
            when 3 then 'Full Board' 
          end, 
          case x.klasifikasi 
            when 2 then 'Expedited' 
            when 3 then 'Full Board' 
          end) as klasifikasi,
          x.inserted as tanggal_keputusan
      from tb_pengajuan as p
      join tb_kepk as k on k.id_kepk = p.id_kepk
      join tb_pep as e on e.id_pengajuan = p.id_pengajuan
      join tb_putusan_awal as pa on pa.id_pep = e.id_pep
      left join (
        select e2.id_pengajuan, kps.klasifikasi, kps.inserted 
        from tb_pep as e2 
        join tb_kirim_putusan_ke_sekretariat as kps on kps.id_pep = e2.id_pep
        where kps.keputusan = 'LE' and (kps.klasifikasi = 2 or kps.klasifikasi = 3)
      ) as x on x.id_pengajuan = p.id_pengajuan
      where pa.klasifikasi = 2 or pa.klasifikasi = 3
      
      order by id_pengajuan
    ";

		$query = "
			select a.no_protokol, a.judul, a.nama_kepk, a.nama_ketua, a.tanggal_pengajuan, a.klasifikasi, a.tanggal_keputusan from (".$subquery.") as a where 1 = 1";

   // proses parameter pencarian, jika ada
    if (isset($param['_search']) && $param['_search'] == 'true' )
    {
    	$fld = $param['search_fld'];
      switch($fld){
        case 'tgl_pengajuan': $str = prepare_date($param['search_str']); break;
        case 'tgl_keputusan': $str = prepare_date($param['search_str']); break;
        default : $str = $param['search_str']; break;
      }
    	$op = $param['search_op'];

    	if (strlen($str) > 0)
    	{
	    	switch ($op) {
	    		case 'eq': $query .= " and ".$this->fieldmap_filter[$fld] . " = '" . $str . "'"; break;
	    		case 'ne': $query .= " and ".$this->fieldmap_filter[$fld] . " <> '" . $str . "'"; break;
	    		case 'bw': $query .= " and ".$this->fieldmap_filter[$fld] . " LIKE '%" . $str . "'"; break;
	    		case 'bn': $query .= " and ".$this->fieldmap_filter[$fld] . " NOT LIKE '%" . $str . "'"; break;
	    		case 'ew': $query .= " and ".$this->fieldmap_filter[$fld] . " LIKE '" . $str . "%'"; break;
	    		case 'en': $query .= " and ".$this->fieldmap_filter[$fld] . " NOT LIKE '" . $str . "%'"; break;
	    		case 'cn': $query .= " and ".$this->fieldmap_filter[$fld] . " LIKE '%" . $str . "%'"; break;
	    		case 'nc': $query .= " and ".$this->fieldmap_filter[$fld] . " NOT LIKE '%" . $str . "%'"; break;
	    		case 'nu': $query .= " and ".$this->fieldmap_filter[$fld] . " IS NULL"; break;
	    		case 'nn': $query .= " and ".$this->fieldmap_filter[$fld] . " IS NOT NULL"; break;
	    		case 'in': $query .= " and ".$this->fieldmap_filter[$fld] . " LIKE '" . $str . "'"; break;
	    		case 'ni': $query .= " and ".$this->fieldmap_filter[$fld] . " NOT LIKE '" . $str . "'"; break;
	    	}
	    }
    }

    if (isset($param['sort_by']) && $param['sort_by'] != null && !$isCount && $ob = get_order_by_str($param['sort_by'], $this->fieldmap_filter))
    {
      $query .= " order by ".$ob." ".$param['sort_direction'];
    }

    isset($param['limit']) && $param['limit'] ? $query .= " limit ".$param['limit']['end']." offset ".$param['limit']['start'] : '';
    $sql = $this->db->query($query);

    if ($isCount) {
      $result = $sql->num_rows();
      return $result;
    }
    else
    {
      if ($CompileOnly)
      {
        return $sql->get_compiled_select();
      }
      else
      {
        return $sql->result_array();
      }
    }
    
		return $result;
	}

}
