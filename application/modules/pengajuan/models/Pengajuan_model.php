<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengajuan_model extends Core_Model {

  var $fieldmap_filter;
	var $data_anggota;
	var $data_pa;
	var $data_sp;
	var $data_bb;
	var $purge_anggota_peneliti;
	var $purge_peneliti_asing;

	public function __construct()
	{
		parent::__construct();

    $this->fieldmap_filter = array(
      'no_protokol' => 'p.no_protokol',
      'no_gabungan' => 'concat(pn.nomor, p.no_protokol)',
      'judul' => 'p.judul',
      'tanggal' => 'date(p.inserted)',
      'kepk' => 'k.nama_kepk',
      'mulai' => 'date(p.waktu_mulai)',
      'selesai' => 'date(p.waktu_selesai)'
    );

	}

	public function fill_data()
	{
		$id = $this->input->post('id') ? $this->input->post('id') : 0;
		$id_kepk = $this->input->post('id_kepk') ? $this->input->post('id_kepk') : 0;
		$id_pengusul = $this->session->userdata('id_pengusul');
  	$jns_penelitian = $this->input->post('jns_penelitian') ? $this->input->post('jns_penelitian') : '';
	  $asal_pengusul = $this->input->post('asal_pengusul') ? $this->input->post('asal_pengusul') : '';
  	$jns_lembaga = $this->input->post('jns_lembaga') ? $this->input->post('jns_lembaga') : '';
	  $status_pengusul = $this->input->post('status_pengusul') ? $this->input->post('status_pengusul') : '';
  	$strata_pend = $this->input->post('strata_pend') ? $this->input->post('strata_pend') : '';
    $tarif_telaah = $this->input->post('tarif_telaah') ? $this->input->post('tarif_telaah') : NULL;

	  $no_protokol = $this->get_nomor_protokol($id_kepk, $jns_penelitian, $asal_pengusul, $jns_lembaga, $status_pengusul, $strata_pend);
	  
	  $judul = $this->input->post('judul') ? $this->input->post('judul') : '';
	  $title = $this->input->post('title') ? $this->input->post('title') : '';
  	$nm_ketua = $this->input->post('nm_ketua') ? $this->input->post('nm_ketua') : '';
	  $telp_peneliti = $this->input->post('telp_peneliti') ? $this->input->post('telp_peneliti') : '';
  	$email_peneliti = $this->input->post('email_peneliti') ? $this->input->post('email_peneliti') : '';
	  $komunikasi = $this->input->post('komunikasi') ? $this->pecah_array($this->input->post('komunikasi')) : '';
  	$nm_institusi = $this->input->post('nm_institusi') ? $this->input->post('nm_institusi') : '';
	  $alm_inst = $this->input->post('alm_inst') ? $this->input->post('alm_inst') : '';
	  $telp_inst = $this->input->post('telp_inst') ? $this->input->post('telp_inst') : '';
	  $email_inst = $this->input->post('email_inst') ? $this->input->post('email_inst') : '';
	  $sumber_dana = $this->input->post('sumber_dana') ? $this->input->post('sumber_dana') : '';
	  $total_dana = $this->input->post('total_dana') ? $this->input->post('total_dana') : '';
	  $penelitian = $this->input->post('penelitian') ? $this->input->post('penelitian') : '';
	  $jml_negara = $this->input->post('jml_negara') && $penelitian == 'internasional' ? $this->input->post('jml_negara') : 0;
	  $tempat_penelitian = $this->input->post('tempat_penelitian') ? $this->input->post('tempat_penelitian') : '';
	  $waktu_mulai = $this->input->post('waktu_mulai') ? prepare_date($this->input->post('waktu_mulai')) : '';
	  $waktu_selesai = $this->input->post('waktu_selesai') ? prepare_date($this->input->post('waktu_selesai')) : '';
	  $is_multi_senter = $this->input->post('is_multi_senter') === 'true' ? 1 : 0;
	  $tempat_multi_senter = $this->input->post('tempat_multi_senter') && $is_multi_senter == 1 ? $this->input->post('tempat_multi_senter') : '';
	  $is_setuju_senter = $this->input->post('is_setuju_senter') === 'true' && $is_multi_senter == 1 ? 1 : 0;

	  $id_sp = $this->input->post('id_sp') ? $this->input->post('id_sp') : 0;
	  $no_sp = $this->input->post('no_sp') ? $this->input->post('no_sp') : '';
	  $tgl_sp = $this->input->post('tgl_sp') ? prepare_date($this->input->post('tgl_sp')) : '';
		$client_name_sp = $this->input->post('client_name_sp') ? $this->input->post('client_name_sp') : '';
		$file_name_sp = $this->input->post('file_name_sp') ? $this->input->post('file_name_sp') : '';
		$file_size_sp = $this->input->post('file_size_sp') ? $this->input->post('file_size_sp') : '';
		$file_type_sp = $this->input->post('file_type_sp') ? $this->input->post('file_type_sp') : '';
		$file_ext_sp = $this->input->post('file_ext_sp') ? $this->input->post('file_ext_sp') : '';

	  $id_bb = $this->input->post('id_bb') ? $this->input->post('id_bb') : 0;
	  $no_bb = $this->input->post('no_bb') ? $this->input->post('no_bb') : '';
	  $tgl_bb = $this->input->post('tgl_bb') ? prepare_date($this->input->post('tgl_bb')) : '';
		$client_name_bb = $this->input->post('client_name_bb') ? $this->input->post('client_name_bb') : '';
		$file_name_bb = $this->input->post('file_name_bb') ? $this->input->post('file_name_bb') : '';
		$file_size_bb = $this->input->post('file_size_bb') ? $this->input->post('file_size_bb') : '';
		$file_type_bb = $this->input->post('file_type_bb') ? $this->input->post('file_type_bb') : '';
		$file_ext_bb = $this->input->post('file_ext_bb') ? $this->input->post('file_ext_bb') : '';

	  $this->data = array(
	  		'id_pengajuan' => $id,
	  		'id_pengusul' => $id_pengusul,
		  	'id_kepk' => $id_kepk,
				'jenis_penelitian' => $jns_penelitian,
				'asal_pengusul' => $asal_pengusul,
				'jenis_lembaga' => $jns_lembaga,
				'status_pengusul' => $status_pengusul,
				'strata_pendidikan' => $strata_pend,
        'tarif_telaah' => $tarif_telaah,
				'no_protokol' => $no_protokol,
				'judul' => $judul,
				'title' => $title,
				'nama_ketua' => $nm_ketua,
				'telp_peneliti' => $telp_peneliti,
				'email_peneliti' => $email_peneliti,
				'komunikasi' => $komunikasi,
				'nama_institusi' => $nm_institusi,
				'alamat_institusi' => $alm_inst,
				'telp_institusi' => $telp_inst,
				'email_institusi' => $email_inst,
				'sumber_dana' => $sumber_dana,
				'total_dana' => $total_dana,
				'penelitian' => $penelitian,
				'jml_negara' => $jml_negara,
				'tempat_penelitian' => $tempat_penelitian,
				'waktu_mulai' => $waktu_mulai,
				'waktu_selesai' => $waktu_selesai,
				'is_multi_senter' => $is_multi_senter,
				'tempat_multi_senter' => $tempat_multi_senter,
				'is_setuju_senter' => $is_setuju_senter
		);

		$anggota = $this->input->post('anggota_peneliti') ? json_decode($this->input->post('anggota_peneliti')) : '';
		for ($a=0; $a<count($anggota); $a++)
		{
		 	$id_ap = isset($anggota[$a]->id) ? $anggota[$a]->id : 0;
		 	$nama = isset($anggota[$a]->nama) ? $anggota[$a]->nama : '';
		 	$id_pengusul = isset($anggota[$a]->nomor) ? $this->get_id_pengusul_by_nomor($anggota[$a]->nomor) : 0;

		 	if ($nama != '' && $anggota[$a]->nomor != '')
		 	{
			 	$this->data_anggota[] = array('id_ap'=>$id_ap, 'nama'=>$nama, 'id_pengusul'=>$id_pengusul);
		 	}
		}

    $this->purge_anggota_peneliti = $this->input->post('purge_anggota_peneliti') ? $this->input->post('purge_anggota_peneliti') : '';

	  if ($penelitian == 'asing')
	  {
			$pa = $this->input->post('peneliti_asing') ? json_decode($this->input->post('peneliti_asing')) : '';
			for ($a=0; $a<count($pa); $a++)
			{
			 	$idpa = isset($pa[$a]->id) ? $pa[$a]->id : 0;
			 	$nama = isset($pa[$a]->nama) ? $pa[$a]->nama : '';
			 	$institusi = isset($pa[$a]->institusi) ? $pa[$a]->institusi : '';
			 	$tugas = isset($pa[$a]->tugas) ? $pa[$a]->tugas : '';
			 	$telp = isset($pa[$a]->telp) ? $pa[$a]->telp : '';

			 	$this->data_pa[] = array('id_pa'=>$idpa, 'nama'=>$nama, 'institusi'=>$institusi, 'tugas'=>$tugas, 'telp'=>$telp);
			}
		}

    $this->purge_peneliti_asing = $this->input->post('purge_peneliti_asing') ? $this->input->post('purge_peneliti_asing') : '';

    $this->data_sp = array(
    		'id_sp' => $id_sp,
				'nomor' => $no_sp,
	 			'tanggal' => $tgl_sp,
				'client_name' =>	$client_name_sp,
				'file_name' => $file_name_sp,
				'file_size' => $file_size_sp,
				'file_type' =>	$file_type_sp,
				'file_ext' => $file_ext_sp
    );

    $this->data_bb = array(
    		'id_bb' => $id_bb,
				'nomor' => $no_bb,
	 			'tanggal' => $tgl_bb,
				'client_name' =>	$client_name_bb,
				'file_name' => $file_name_bb,
				'file_size' => $file_size_bb,
				'file_type' =>	$file_type_bb,
				'file_ext' => $file_ext_bb
    );

	}

	public function save_detail()
	{
		$this->insert_pengajuan();
		$this->insert_anggota();
		$this->insert_pa();
		$this->insert_sp();
		$this->insert_bb();
	}

	public function insert_pengajuan()
	{
		if (isset($this->data['id_pengajuan']) && $this->data['id_pengajuan'] > 0)
		{
			unset($this->data['no_protokol']);
			$this->db->where('id_pengajuan', $this->data['id_pengajuan']);
			$this->db->update('tb_pengajuan', $this->data);
			$this->check_trans_status('update tb_pengajuan failed');
			$this->id = $this->data['id_pengajuan'];
		}
		else
		{
			unset($this->data['id_pengajuan']);
			$this->db->insert('tb_pengajuan', $this->data);
			$this->check_trans_status('insert tb_pengajuan failed');
			$this->id = $this->db->insert_id();
		}
	}

	public function insert_anggota()
	{
		if ($this->purge_anggota_peneliti)
		{
			$this->db->where_in('id_ap', $this->purge_anggota_peneliti);
			$this->db->delete('tb_anggota_penelitian');
			$this->check_trans_status('delete tb_anggota_penelitian failed');
		}

		if (isset($this->data_anggota) && count($this->data_anggota) > 0)
		{
			for ($i=0; $i<count($this->data_anggota); $i++)
			{
				$this->db->select('1')->from('tb_anggota_penelitian')->where('id_ap', $this->data_anggota[$i]['id_ap'])->where('id_pengajuan', $this->id);
				$rs = $this->db->get()->row_array();

				if ($rs)
				{
					$this->db->where('id_pengajuan', $this->id);
					$this->db->where('id_ap', $this->data_anggota[$i]['id_ap']);
					$this->db->update('tb_anggota_penelitian', $this->data_anggota[$i]);
					$this->check_trans_status('update tb_anggota_penelitian failed');
				}
				else
				{
					unset($this->data_anggota['id_ap']);
					$this->data_anggota[$i]['id_pengajuan'] = $this->id;
					$this->db->insert('tb_anggota_penelitian', $this->data_anggota[$i]);
					$this->check_trans_status('insert tb_anggota_penelitian failed');
				}
			}
		}
	}

	public function insert_pa()
	{
		if ($this->purge_peneliti_asing)
		{
			$this->db->where_in('id_pa', $this->purge_peneliti_asing);
			$this->db->delete('tb_peneliti_asing');
			$this->check_trans_status('delete tb_peneliti_asing failed');
		}

    if (isset($this->data_pa) && count($this->data_pa) > 0)
    {
  		for ($i=0; $i<count($this->data_pa); $i++)
  		{
  			$this->db->select('1')->from('tb_peneliti_asing')->where('id_pa', $this->data_pa[$i]['id_pa'])->where('id_pengajuan', $this->id);
  			$rs = $this->db->get()->row_array();

  			if ($rs)
  			{
  				$this->db->where('id_pengajuan', $this->id);
  				$this->db->where('id_pa', $this->data_pa[$i]['id_pa']);
  				$this->db->update('tb_peneliti_asing', $this->data_pa[$i]);
  				$this->check_trans_status('update tb_peneliti_asing failed');
  			}
  			else
  			{
  				unset($this->data_pa['id_pa']);
  				$this->data_pa[$i]['id_pengajuan'] = $this->id;
  				$this->db->insert('tb_peneliti_asing', $this->data_pa[$i]);
  				$this->check_trans_status('insert tb_peneliti_asing failed');
  			}
  		}
    }
	}

	function insert_sp()
	{
		if (isset($this->data_sp['id_sp']) && $this->data_sp['id_sp'] > 0)
		{
			$this->db->where('id_sp', $this->data_sp['id_sp']);
			$this->db->update('tb_surat_pengantar', $this->data_sp);
			$this->check_trans_status('update tb_surat_pengantar failed');
		}
		else
		{
			unset($this->data_sp['id_sp']);
			$this->data_sp['id_pengajuan'] = $this->id;
			$this->db->insert('tb_surat_pengantar', $this->data_sp);
			$this->check_trans_status('insert tb_surat_pengantar failed');
		}		
	}

	function insert_bb()
	{
		if (isset($this->data_bb['id_bb']) && $this->data_bb['id_bb'] > 0)
		{
			$this->db->where('id_bb', $this->data_bb['id_bb']);
			$this->db->update('tb_bukti_bayar', $this->data_bb);
			$this->check_trans_status('update tb_surat_pengantar failed');
		}
		else
		{
			unset($this->data_bb['id_bb']);
			$this->data_bb['id_pengajuan'] = $this->id;
			$this->db->insert('tb_bukti_bayar', $this->data_bb);
			$this->check_trans_status('insert tb_bukti_bayar failed');
		}		
	}

	function get_nomor_protokol($id_kepk, $jns_penelitian, $asal_pengusul, $jns_lembaga, $status_pengusul, $strata_pend)
	{
    $this->db->select('k.kodefikasi');
    $this->db->from('tb_kepk as k');
    $this->db->where('k.id_kepk', $id_kepk);
    $result = $this->db->get()->row_array();
    $kodefikasi = $result['kodefikasi'];

		$this->db->select('max(right(p.no_protokol,5)) as max_no');
		$this->db->from('tb_pengajuan as p');
		$this->db->where('month(p.inserted)', date('m'));
		$this->db->where('year(p.inserted)', date('Y'));
		$this->db->where('p.id_kepk', $id_kepk);
		$result = $this->db->get()->row_array();

		if ($result) {
			$max_no = (int)$result['max_no'];
			$no = $max_no + 1;
		}
		else $no = 1;

		$len = strlen($no);
		$no_acak = date('Ymd');
		while($len<=4){
			$no_acak .= '0';
			$len++;
		}

		return $kodefikasi.$jns_penelitian.$asal_pengusul.$jns_lembaga.$status_pengusul.$strata_pend.$no_acak.$no;
	}

	function get_id_pengusul_by_nomor($nomor)
	{
		$this->db->select('coalesce(p.id_pengusul, 0) as id_pengusul');
		$this->db->from('tb_pengusul as p');
		$this->db->where('p.nomor', $nomor);
		$result = $this->db->get()->row_array();

		if ($result)
			return $result['id_pengusul'];

		return '';
	}
	
	function pecah_array($arr)
	{
		$data = '';
		for ($i=0; $i<count($arr); $i++)
		{
			$data .= $arr[$i];
			if ($i<count($arr)-1) $data .= ',';
		}

		return $data;
	}

  public function get_data_jqgrid($param, $isCount=FALSE, $CompileOnly=False)
  {
    $this->db->select('p.id_pengajuan, p.no_protokol, p.judul, p.waktu_mulai, p.waktu_selesai, p.inserted as tanggal_pengajuan, k.nama_kepk, pn.nomor');
    $this->db->from('tb_pengajuan as p');
    $this->db->join('tb_kepk as k', 'k.id_kepk = p.id_kepk');
    $this->db->join('tb_pengusul as pn', 'pn.id_pengusul = p.id_pengusul');
    $this->db->where('p.id_pengusul', $this->session->userdata('id_pengusul'));

    // proses parameter pencarian, jika ada
    if (isset($param['_search']) && $param['_search'] == 'true' )
    {
      $fld = $param['search_fld'];
      switch($fld){
        case 'tanggal': $str = prepare_date($param['search_str']); break;
        case 'mulai': $str = prepare_date($param['search_str']); break;
        case 'selesai': $str = prepare_date($param['search_str']); break;
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
		$this->db->select('p.*, k.nama_bank, k.no_rekening');
		$this->db->from('tb_pengajuan as p');
		$this->db->join('tb_kepk as k', 'k.id_kepk = p.id_kepk');
		$this->db->where('p.id_pengajuan', $id);
		$result = $this->db->get()->row_array();

		return $result;
	}

	function get_data_kepk()
	{
		$this->db->select('k.id_kepk, k.kodefikasi, k.nama_kepk, k.nama_bank, k.no_rekening, k.pemilik_rekening, k.swift_code');
		$this->db->from('tb_kepk as k');
		$this->db->where('k.aktif', 1);
    $this->db->where('k.id_kepk', $this->session->userdata('id_kepk'));
		$result = $this->db->get()->row_array();

		return $result;
	}

	function get_data_anggota_by_id($id)
	{
		$this->db->select('ap.*, p.nomor');
		$this->db->from('tb_anggota_penelitian as ap');
		$this->db->join('tb_pengusul as p', 'p.id_pengusul = ap.id_pengusul');
		$this->db->where('ap.id_pengajuan', $id);
		$result = $this->db->get()->result_array();

		return $result;
	}

	function get_data_pa_by_id($id)
	{
		$this->db->select('pa.*');
		$this->db->from('tb_peneliti_asing as pa');
		$this->db->where('pa.id_pengajuan', $id);
		$result = $this->db->get()->result_array();

		return $result;
	}

	function get_data_sp_by_id($id)
	{
		$this->db->select('sp.*');
		$this->db->from('tb_surat_pengantar as sp');
		$this->db->where('sp.id_pengajuan', $id);
		$result = $this->db->get()->row_array();

		return $result;
	}

	function get_data_bb_by_id($id)
	{
		$this->db->select('bb.*');
		$this->db->from('tb_bukti_bayar as bb');
		$this->db->where('bb.id_pengajuan', $id);
		$result = $this->db->get()->row_array();

		return $result;
	}

  function get_data_tarif_telaah_by_param($id_kepk, $jns_penelitian, $asal_pengusul, $jns_lembaga, $status_pengusul, $strata_pend)
  {
    $this->db->select('tt.tarif_telaah');
    $this->db->from('tb_tarif_telaah as tt');
    $this->db->where('tt.id_kepk', $id_kepk);
    $this->db->where('tt.jenis_penelitian', $jns_penelitian);
    $this->db->where('tt.asal_pengusul', $asal_pengusul);
    $this->db->where('tt.jenis_lembaga', $jns_lembaga);
    $this->db->where('tt.status_pengusul', $status_pengusul);
    $this->db->where('tt.strata_pendidikan', $strata_pend);
    $result = $this->db->get()->row_array();

    return $result;
  }

	function check_data_judul($id_pengajuan, $id_pengusul, $id_kepk, $judul)
	{
		$this->db->select('count(id_pengajuan) as jumlah')->from('tb_pengajuan')->where('judul', trim($judul))->where('id_pengusul', $id_pengusul)->where('id_pengajuan <>', $id_pengajuan);
		$rs1 = $this->db->get()->row_array();

		if ($rs1['jumlah'] == 2) return 'Judul sudah diajukan ke 2 KEPK';

		$this->db->select('1')->from('tb_pengajuan')->where('judul', $judul)->where('id_pengusul <>', $id_pengusul);
		$rs2 = $this->db->get()->row_array();

		if ($rs2) return 'Judul sudah diajukan oleh pengusul lain';

		return TRUE;
	}

	function check_exist_data($id)
	{
		$this->db->select('1')->from('tb_pep')->where('id_pengajuan', $id);
		$rs = $this->db->get()->row_array();

		if ($rs)
			return TRUE;

		return FALSE;
	}

	function delete_detail($id)
	{
		$this->delete_bb($id);
		$this->delete_sp($id);
		$this->delete_pa($id);
		$this->delete_anggota($id);
		$this->delete_pengajuan($id);
	}

	function delete_bb($id)
	{
		$this->db->where('id_pengajuan', $id);
		$this->db->delete('tb_bukti_bayar');
	}

	function delete_sp($id)
	{
		$this->db->where('id_pengajuan', $id);
		$this->db->delete('tb_surat_pengantar');
	}

	function delete_pa($id)
	{
		$this->db->where('id_pengajuan', $id);
		$this->db->delete('tb_peneliti_asing');
	}

	function delete_anggota($id)
	{
		$this->db->where('id_pengajuan', $id);
		$this->db->delete('tb_anggota_penelitian');
	}

	function delete_pengajuan($id)
	{
		$this->db->where('id_pengajuan', $id);
		$this->db->delete('tb_pengajuan');
	}

}
