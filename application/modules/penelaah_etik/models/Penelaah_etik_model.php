<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penelaah_etik_model extends Core_Model {
	
	var $fieldmap_filter;

	public function __construct()
	{
		parent::__construct();

		$this->fieldmap_filter = array(
			'nama' => 'a.nama',
			'kepk' =>  'a.nama_kepk',
			'telaah_cepat' => 'a.telaah_cepat',
			'telaah_expedited' => 'a.telaah_expedited',
			'telaah_fullboard' => 'a.telaah_fullboard'
		);
	}

	function get_data_penelaah_etik($param, $isCount=FALSE, $CompileOnly=False)
	{
		$bulan = $this->input->post('bulan') ? $this->input->post('bulan') : 0;
		$tahun = $this->input->post('tahun') ? $this->input->post('tahun') : 0;

    $subquery = "
			select atk.id_atk, atk.nama, atk.id_kepk, k.nama_kepk,
			(select count(*) from tb_pengajuan as p
				where p.id_pengajuan in 
				(
			    	select e.id_pengajuan from tb_pep as e join tb_telaah_awal as ta on ta.id_pep = e.id_pep
				 		where ta.id_atk_penelaah = atk.id_atk 
				 			and (".$bulan." = 0 or month(ta.inserted) = ".$bulan.") 
				 			and (".$tahun." = 0 or year(ta.inserted) = ".$tahun.")
				)
			) as telaah_awal,
			(select count(*) from tb_pengajuan as p
				where p.id_pengajuan in 
				(
			    	select e.id_pengajuan from tb_pep as e join tb_telaah_expedited as te on te.id_pep = e.id_pep
				 		where te.id_atk_penelaah = atk.id_atk 
				 			and (".$bulan." = 0 or month(te.inserted) = ".$bulan.") 
				 			and (".$tahun." = 0 or year(te.inserted) = ".$tahun.")
				)
			) as telaah_expedited,
			(select count(*) from tb_pengajuan as p
				where p.id_pengajuan in
				(
			    	select e.id_pengajuan from tb_pep as e join tb_telaah_fullboard as tf on tf.id_pep = e.id_pep
				 		where tf.id_atk_penelaah = atk.id_atk 
				 			and (".$bulan." = 0 or month(tf.inserted) = ".$bulan.") 
				 			and (".$tahun." = 0 or year(tf.inserted) = ".$tahun.")
				)
			) as telaah_fullboard
			from tb_anggota_tim_kepk as atk
			join tb_struktur_tim_kepk as stk on stk.id_atk = atk.id_atk
			join tb_kepk as k on k.id_kepk = atk.id_kepk
			where stk.jabatan = 5
			group by atk.id_atk
			order by k.nama_kepk, atk.nama
	  ";

		$query = "
			select a.id_atk, a.nama, a.id_kepk, a.nama_kepk, a.telaah_awal, a.telaah_expedited, a.telaah_fullboard
			from (".$subquery.") as a where 1 = 1";

		if (in_array($this->session->userdata('id_group_'.APPAUTH), array(4,9,10)))
			$query .= " and a.id_kepk = ".$this->session->userdata('id_kepk_tim');

   // proses parameter pencarian, jika ada
    if (isset($param['_search']) && $param['_search'] == 'true' )
    {
    	$fld = $param['search_fld'];
    	$str = $param['search_str'];
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
      $query .= "order by ".$ob." ".$param['sort_direction'];
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
