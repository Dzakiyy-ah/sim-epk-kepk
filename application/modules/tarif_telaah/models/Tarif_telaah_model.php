<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tarif_telaah_model extends Core_Model {

  var $fieldmap_filter;

	public function __construct()
	{
		parent::__construct();

    $this->fieldmap_filter = array(
      'jns_penelitian' => "case tt.jenis_penelitian
                            when 1 then 'Observasional'
                            when 2 then 'Intervensi'
                            when 3 then 'Uji Klinik'
                          end",
      'asal_pengusul' => "case tt.asal_pengusul
                            when 1 then 'Internal'
                            when 2 then 'Eksternal'
                          end",
      'jns_lembaga' => "case tt.jenis_lembaga
                          when 1 then 'Pendidikan'
                          when 2 then 'Rumah Sakit'
                          when 3 then 'Litbang'
                        end",
      'status_pengusul' => "case tt.status_pengusul
                              when 1 then 'Mahasiswa'
                              when 2 then'Dosen'
                              when 3 then 'Pelaksana Pelayanan'
                              when 4 then 'Peneliti'
                              when 5 then 'Lainnya'
                            end",
      'strata_pend' => "case tt.strata_pendidikan
                          when 1 then 'Diploma III'
                          when 2 then 'Diploma IV'
                          when  3 then 'S-1'
                          when  4 then 'S-2'
                          when  5 then 'S-3'
                          when  6 then 'Sp-1'
                          when  7 then 'Sp-2'
                          when  8 then 'Lainnya'
                        end",
      'tarif' => 'tt.tarif_telaah'
    );
	}

	public function fill_data()
	{
		$id = $this->input->post('id') ? $this->input->post('id') : 0;
    $id_kepk = $this->session->userdata('id_kepk');
		$jns_penelitian = $this->input->post('jns_penelitian') ? $this->input->post('jns_penelitian') : '';
		$asal_pengusul = $this->input->post('asal_pengusul') ? $this->input->post('asal_pengusul') : '';
		$jns_lembaga = $this->input->post('jns_lembaga') ? $this->input->post('jns_lembaga') : '';
		$status_pengusul = $this->input->post('status_pengusul') ? $this->input->post('status_pengusul') : '';
    $strata_pend = $this->input->post('strata_pend') ? $this->input->post('strata_pend') : '';
    $tarif = $this->input->post('tarif') ? $this->input->post('tarif') : NULL;

		$this->data = array(
        'id_tarif_telaah' => $id,
				'id_kepk' => $id_kepk,
				'jenis_penelitian' => $jns_penelitian, 
				'asal_pengusul' => $asal_pengusul, 
				'jenis_lembaga' => $jns_lembaga, 
				'status_pengusul' => $status_pengusul,
        'strata_pendidikan' => $strata_pend,
        'tarif_telaah' => $tarif
		);

	}

	public function save_detail()
	{
    $this->insert_tarif_telaah();
	}

	public function insert_tarif_telaah()
	{
    if (isset($this->data['id_tarif_telaah']) && $this->data['id_tarif_telaah'] > 0)
    {
			$this->db->where('id_tarif_telaah', $this->data['id_tarif_telaah']);
			$this->db->update('tb_tarif_telaah', $this->data);
			$this->check_trans_status('update tb_tarif_telaah failed');
      $this->id = $this->data['id_tarif_telaah'];

			$aktivitas = 'Edit Tarif/Biaya Telaah';
			$id_user_kepk = $this->session->userdata('id_user_'.APPAUTH);
			$id_user = $this->session->userdata('id_user_'.APPAUTH);
			simpan_logaktivitas_tim_kepk($aktivitas, $id_user_kepk, $id_user);
		}
		else
		{
			$this->db->insert('tb_tarif_telaah', $this->data);
			$this->check_trans_status('insert tb_tarif_telaah failed');
      $this->id = $this->db->insert_id();

			$aktivitas = 'Insert Tarif/Biaya Telaah';
			$id_user_kepk = $this->session->userdata('id_user_'.APPAUTH);
			$id_user = $this->session->userdata('id_user_'.APPAUTH);
			simpan_logaktivitas_tim_kepk($aktivitas, $id_user_kepk, $id_user);
		}
	}

  public function get_data_jqgrid($param, $isCount=FALSE, $CompileOnly=False)
  {
    $this->db->select("
      tt.id_tarif_telaah, 
      case tt.jenis_penelitian
        when 1 then 'Observasional'
        when 2 then 'Intervensi'
        when 3 then 'Uji Klinik'
      end as jenis_penelitian, 
      case tt.asal_pengusul
        when 1 then 'Internal'
        when 2 then 'Eksternal'
      end as asal_pengusul, 
      case tt.jenis_lembaga
        when 1 then 'Pendidikan'
        when 2 then 'Rumah Sakit'
        when 3 then 'Litbang'
      end as jenis_lembaga, 
      case tt.status_pengusul
        when 1 then 'Mahasiswa'
        when 2 then'Dosen'
        when 3 then 'Pelaksana Pelayanan'
        when 4 then 'Peneliti'
        when 5 then 'Lainnya'
      end as status_pengusul, 
      case tt.strata_pendidikan
        when 1 then 'Diploma III'
        when 2 then 'Diploma IV'
        when  3 then 'S-1'
        when  4 then 'S-2'
        when  5 then 'S-3'
        when  6 then 'Sp-1'
        when  7 then 'Sp-2'
        when  8 then 'Lainnya'
      end as strata_pendidikan, 
      tt.tarif_telaah");
    $this->db->from('tb_tarif_telaah as tt');
    $this->db->order_by('tt.jenis_penelitian, tt.asal_pengusul, tt.jenis_lembaga, tt.status_pengusul, tt.strata_pendidikan', 'asc');

    // proses parameter pencarian, jika ada
    if (isset($param['_search']) && $param['_search'] == 'true' )
    {
      $fld = $param['search_fld'];
      $str = $param['search_str'];
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

  function get_data_by_id($id)
  {
    $this->db->select('tt.id_tarif_telaah, tt.jenis_penelitian, tt.asal_pengusul, tt.jenis_lembaga, tt.status_pengusul, tt.strata_pendidikan, tt.tarif_telaah');
    $this->db->from('tb_tarif_telaah as tt');
    $this->db->where('tt.id_tarif_telaah', $id);
    $result = $this->db->get()->row_array();

    return $result;
  }

  function cek_duplikasi_parameter_tarif($id, $jns_penelitian, $asal_pengusul, $jns_lembaga, $status_pengusul, $strata_pend)
  {
    $this->db->select('1')
        ->from('tb_tarif_telaah')
        ->where('jenis_penelitian', $jns_penelitian)
        ->where('asal_pengusul', $asal_pengusul)
        ->where('jenis_lembaga', $jns_lembaga)
        ->where('status_pengusul', $status_pengusul)
        ->where('strata_pendidikan', $strata_pend)
        ->where('id_tarif_telaah <>', $id);
    $rs = $this->db->get()->row_array();

    if ($rs)
      return TRUE;

    return FAlSE;
  }

  function delete_detail($id)
  {
    $this->delete_tarif_telaah($id);
  }

  function delete_tarif_telaah($id)
  {
    $this->db->where('id_tarif_telaah', $id);
    $this->db->delete('tb_tarif_telaah');
    $this->check_trans_status('delete tb_tarif_telaah failed');
  }

}
