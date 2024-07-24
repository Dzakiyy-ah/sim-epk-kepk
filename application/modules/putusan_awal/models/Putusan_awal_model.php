<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Putusan_awal_model extends Core_Model { 

  var $fieldmap_filter;
  var $data_penelaah;
  var $data_lay_person;
  var $data_konsultan;
  var $data_sa;
  var $data_kirim;
  var $purge_pe;
  var $purge_lp;
  var $purge_konsultan;

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
      'tgl_pa' => 'date(pa.inserted)',
      'klasifikasi' => "case pa.klasifikasi
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
    $klasifikasi = $this->input->post('klasifikasi') ? $this->input->post('klasifikasi') : '';
    $id_atk_pelapor = $this->input->post('pelapor') ? $this->input->post('pelapor') : 0;
    $remove_str = array("\n", "\r\n", "\r");
    $catatan = $this->input->post('catatan') ? addslashes(str_replace($remove_str, ' ', $this->input->post('catatan'))) : '';

    if ($this->session->userdata('id_group_'.APPAUTH) == 7)
    {
      $id_atk_ketua = $this->get_id_atk($this->session->userdata('id_user_'.APPAUTH));

      $this->data = array( 
        'id_pa' => $id, 
        'id_pep' => $id_pep, 
        'klasifikasi' => $klasifikasi, 
        'id_atk_ketua' => $id_atk_ketua, 
        'id_atk_pelapor' => $id_atk_pelapor, 
        'catatan' => $catatan 
      );
    }
    else if ($this->session->userdata('id_group_'.APPAUTH) == 8)
    {
      $id_atk_wakil_ketua = $this->get_id_atk($this->session->userdata('id_user_'.APPAUTH));

      $this->data = array( 
        'id_pa' => $id, 
        'id_pep' => $id_pep, 
        'klasifikasi' => $klasifikasi, 
        'id_atk_wakil_ketua' => $id_atk_wakil_ketua, 
        'id_atk_pelapor' => $id_atk_pelapor, 
        'catatan' => $catatan 
      );
    }

    $penelaah = $this->input->post('penelaah_etik') ? $this->input->post('penelaah_etik') : '';
    if ($penelaah) 
    { 
      for ($i=0; $i<count($penelaah); $i++) 
      { 
        $this->data_penelaah[] = array('id_atk_penelaah' => $penelaah[$i]);
      } 
    } 

    $lay_person = $this->input->post('lay_person') ? $this->input->post('lay_person') : '';
    if ($lay_person) 
    { 
      for ($i=0; $i<count($lay_person); $i++) 
      { 
        $this->data_lay_person[] = array('id_atk_lay_person' => $lay_person[$i]);
      } 
    } 

    $konsultan = $this->input->post('konsultan') ? $this->input->post('konsultan') : '';
    if ($konsultan) 
    { 
      for ($i=0; $i<count($konsultan); $i++) 
      { 
        $this->data_konsultan[] = array('id_atk_konsultan' => $konsultan[$i]);
      } 
    } 

    $this->purge_pe = $this->input->post('purge_pe') ? $this->input->post('purge_pe') : '';
    $this->purge_lp = $this->input->post('purge_lp') ? $this->input->post('purge_lp') : '';
    $this->purge_konsultan = $this->input->post('purge_konsultan') ? $this->input->post('purge_konsultan') : '';

    $sa1 = $this->input->post('self_assesment1') ? json_decode($this->input->post('self_assesment1')) : '';
    for ($i=0; $i<count($sa1); $i++) 
    { 
      $id_jsk = isset($sa1[$i]->id) ? $sa1[$i]->id : 0;
      $pil = isset($sa1[$i]->pil_ketua) ? $sa1[$i]->pil_ketua : '';
      
      $this->data_sa[] = array('id_jsk'=>$id_jsk, 'pilihan'=>$pil);
    } 

    $sa2 = $this->input->post('self_assesment2') ? json_decode($this->input->post('self_assesment2')) : '';
    for ($i=0; $i<count($sa2); $i++) 
    { 
      $id_jsk = isset($sa2[$i]->id) ? $sa2[$i]->id : 0;
      $pil = isset($sa2[$i]->pil_ketua) ? $sa2[$i]->pil_ketua : '';
      
      $this->data_sa[] = array('id_jsk'=>$id_jsk, 'pilihan'=>$pil);
    } 

    $sa3 = $this->input->post('self_assesment3') ? json_decode($this->input->post('self_assesment3')) : '';
    for ($i=0; $i<count($sa3); $i++) 
    { 
      $id_jsk = isset($sa3[$i]->id) ? $sa3[$i]->id : 0;
      $pil = isset($sa3[$i]->pil_ketua) ? $sa3[$i]->pil_ketua : '';
    
      $this->data_sa[] = array('id_jsk'=>$id_jsk, 'pilihan'=>$pil);
    } 

    $sa4 = $this->input->post('self_assesment4') ? json_decode($this->input->post('self_assesment4')) : '';
    for ($i=0; $i<count($sa4); $i++) 
    { 
      $id_jsk = isset($sa4[$i]->id) ? $sa4[$i]->id : 0;
      $pil = isset($sa4[$i]->pil_ketua) ? $sa4[$i]->pil_ketua : '';
    
      $this->data_sa[] = array('id_jsk'=>$id_jsk, 'pilihan'=>$pil);
    }

    $sa5 = $this->input->post('self_assesment5') ? json_decode($this->input->post('self_assesment5')) : '';
    for ($i=0; $i<count($sa5); $i++) 
    { 
      $id_jsk = isset($sa5[$i]->id) ? $sa5[$i]->id : 0;
      $pil = isset($sa5[$i]->pil_ketua) ? $sa5[$i]->pil_ketua : '';
      
      $this->data_sa[] = array('id_jsk'=>$id_jsk, 'pilihan'=>$pil);
    } 

    $sa6 = $this->input->post('self_assesment6') ? json_decode($this->input->post('self_assesment6')) : '';
    for ($i=0; $i<count($sa6); $i++)
    { 
      $id_jsk = isset($sa6[$i]->id) ? $sa6[$i]->id : 0;
      $pil = isset($sa6[$i]->pil_ketua) ? $sa6[$i]->pil_ketua : '';
    
      $this->data_sa[] = array('id_jsk'=>$id_jsk, 'pilihan'=>$pil);
    } 

    $sa7 = $this->input->post('self_assesment7') ? json_decode($this->input->post('self_assesment7')) : '';
    for ($i=0; $i<count($sa7); $i++) 
    { 
      $id_jsk = isset($sa7[$i]->id) ? $sa7[$i]->id : 0;
      $pil = isset($sa7[$i]->pil_ketua) ? $sa7[$i]->pil_ketua : '';
      
      $this->data_sa[] = array('id_jsk'=>$id_jsk, 'pilihan'=>$pil);
    } 

    $this->data_kirim = array( 
      'id_pep' => $id_pep, 
      'id_kepk' => $this->session->userdata('id_kepk_tim'), 
      'id_atk_ketua' => $id_atk_ketua, 
      'klasifikasi' => 1, 
      'keputusan' => 'LE'
    );
  
  } 

  public function save_detail() 
  { 
    $this->insert_putusan_awal();
    
    if ($this->data['klasifikasi'] === "1")
    { 
      $this->insert_putusan_awal_self_assesment();
      $this->hapus_penelaah();
      $this->hapus_lay_person();
      $this->hapus_konsultan();
      $this->kirim_kesekretariatan();
    } 
    else if ($this->data['klasifikasi'] === "2")
    { 
      $this->hapus_putusan_awal_self_assesment();
      $this->insert_penelaah();
      $this->insert_konsultan();
      $this->hapus_lay_person();
    } 
    else if ($this->data['klasifikasi'] === "3")
    { 
      $this->hapus_putusan_awal_self_assesment();
      $this->insert_penelaah();
      $this->insert_lay_person();
      $this->insert_konsultan();
    } 
  }

  function insert_putusan_awal() 
  { 
    if (isset($this->data['id_pa']) && $this->data['id_pa'] > 0) 
    { 
      $this->db->where('id_pa', $this->data['id_pa']);
      $this->db->update('tb_putusan_awal', $this->data);
      $this->check_trans_status('update tb_putusan_awal failed');
      $this->id = $this->data['id_pa'];
      $aktivitas = 'Edit Putusan Telaah Awal Protokol '.$this->input->post('no_protokol');
      $id_user_kepk = $this->get_id_atk($this->session->userdata('id_user_'.APPAUTH));
      $id_user =$this->session->userdata('id_user_'.APPAUTH);
      simpan_logaktivitas_tim_kepk($aktivitas, $id_user_kepk, $id_user);
    } 
    else 
    { 
      unset($this->data['id_pa']);
      $this->db->insert('tb_putusan_awal', $this->data);
      $this->check_trans_status('insert tb_putusan_awal failed');
      $this->id = $this->db->insert_id();
      $aktivitas = 'Insert Putusan Telaah Awal Protokol '.$this->input->post('no_protokol');
      $id_user_kepk = $this->get_id_atk($this->session->userdata('id_user_'.APPAUTH));
      $id_user =$this->session->userdata('id_user_'.APPAUTH);
      simpan_logaktivitas_tim_kepk($aktivitas, $id_user_kepk, $id_user);
    } 
  } 

  function insert_putusan_awal_self_assesment()
  { 
    $data_update = array();
    $data_insert = array();
    for ($i=0; $i<count($this->data_sa); $i++) 
    { 
      $this->db->select('id_pasa')->from('tb_putusan_awal_self_assesment')->where('id_pa', $this->id)->where('id_jsk', $this->data_sa[$i]['id_jsk']);
      $rs = $this->db->get()->row_array();

      if ($rs) 
      {
        $data_update[] = array(
          'id_pasa' => $rs['id_pasa'],
          'id_pa' => $this->id,
          'id_jsk' => $this->data_sa[$i]['id_jsk'],
          'pilihan' => $this->data_sa[$i]['pilihan']
        );
      }
      else
      { 
        $data_insert[] = array(
          'id_pa' => $this->id,
          'id_jsk' => $this->data_sa[$i]['id_jsk'],
          'pilihan' => $this->data_sa[$i]['pilihan']
        );
      } 
    } 

    if (!empty($data_update)){
      $this->db->update_batch('tb_putusan_awal_self_assesment', $data_update, 'id_pasa');
      $this->check_trans_status('update tb_putusan_awal_self_assesment failed');
    }

    if (!empty($data_insert)){
      $this->db->insert_batch('tb_putusan_awal_self_assesment', $data_insert);
      $this->check_trans_status('insert tb_putusan_awal_self_assesment failed');
    }
  } 

  function insert_penelaah() 
  { 
    if ($this->purge_pe) 
    { 
      $this->db->where_in('id_atk_penelaah', $this->purge_pe);
      $this->db->where('id_pa', $this->id);
      $this->db->delete('tb_penelaah_mendalam');
      $this->check_trans_status('delete tb_penelaah_mendalam failed');
    } 

    if (isset($this->data_penelaah))
    {
      for ($i=0; $i<count($this->data_penelaah); $i++)
      { 
        $this->db->select('1')->from('tb_penelaah_mendalam')->where('id_atk_penelaah', $this->data_penelaah[$i]['id_atk_penelaah'])->where('id_pa', $this->id);
        $rs = $this->db->get()->row_array();

        if ($rs) 
        { 
          $this->db->where('id_pa', $this->id);
          $this->db->where('id_atk_penelaah', $this->data_penelaah[$i]['id_atk_penelaah']);
          $this->db->update('tb_penelaah_mendalam', $this->data_penelaah[$i]);
          $this->check_trans_status('update tb_penelaah_mendalam failed');
        }
        else
        { 
          $this->data_penelaah[$i]['id_pa'] = $this->id;
          $this->db->insert('tb_penelaah_mendalam', $this->data_penelaah[$i]);
          $this->check_trans_status('insert tb_penelaah_mendalam failed');
        } 
      } 
    } 
  } 

  function insert_lay_person() 
  { 
    if ($this->purge_lp) 
    { 
      $this->db->where_in('id_atk_lay_person', $this->purge_lp);
      $this->db->where('id_pa', $this->id);
      $this->db->delete('tb_lay_person');
      $this->check_trans_status('delete tb_lay_person failed');
    } 

    if (isset($this->data_lay_person)) 
    { 
      for ($i=0; $i<count($this->data_lay_person); $i++)
      { 
        $this->db->select('1')->from('tb_lay_person')->where('id_atk_lay_person', $this->data_lay_person[$i]['id_atk_lay_person'])->where('id_pa', $this->id);
        $rs = $this->db->get()->row_array();

        if ($rs)
        { 
          $this->db->where('id_pa', $this->id);
          $this->db->where('id_atk_lay_person', $this->data_lay_person[$i]['id_atk_lay_person']);
          $this->db->update('tb_lay_person', $this->data_lay_person[$i]);
          $this->check_trans_status('update tb_lay_person failed');
        }
        else
        { 
          $this->data_lay_person[$i]['id_pa'] = $this->id;
          $this->db->insert('tb_lay_person', $this->data_lay_person[$i]);
          $this->check_trans_status('insert tb_lay_person failed');
        } 
      } 
    } 
  } 

  function insert_konsultan() 
  { 
    if ($this->purge_konsultan)
    { 
      $this->db->where_in('id_atk_konsultan', $this->purge_konsultan);
      $this->db->where('id_pa', $this->id);
      $this->db->delete('tb_konsultan_independen');
      $this->check_trans_status('delete tb_konsultan_independen failed');
    }

    if (isset($this->data_konsultan))
    { 
      for ($i=0; $i<count($this->data_konsultan); $i++)
      { 
        $this->db->select('1')->from('tb_konsultan_independen')->where('id_atk_konsultan', $this->data_konsultan[$i]['id_atk_konsultan'])->where('id_pa', $this->id);
        $rs = $this->db->get()->row_array();

        if ($rs) 
        { 
          $this->db->where('id_pa', $this->id);
          $this->db->where('id_atk_konsultan', $this->data_konsultan[$i]['id_atk_konsultan']);
          $this->db->update('tb_konsultan_independen', $this->data_konsultan[$i]);
          $this->check_trans_status('update tb_konsultan_independen failed');
        } 
        else 
        { 
          $this->data_konsultan[$i]['id_pa'] = $this->id;
          $this->db->insert('tb_konsultan_independen', $this->data_konsultan[$i]);
          $this->check_trans_status('insert tb_konsultan_independen failed');
        } 
      } 
    } 
  } 

  function hapus_putusan_awal_self_assesment()
  { 
    $this->db->where('id_pa', $this->id);
    $this->db->delete('tb_putusan_awal_self_assesment');
    $this->check_trans_status('delete tb_putusan_awal_self_assesment failed');
  } 

  function hapus_penelaah()
  { 
    $this->db->where('id_pa', $this->id);
    $this->db->delete('tb_penelaah_mendalam');
    $this->check_trans_status('delete tb_penelaah_mendalam failed');
  } 

  function hapus_lay_person() 
  { 
    $this->db->where('id_pa', $this->id);
    $this->db->delete('tb_lay_person');
    $this->check_trans_status('delete tb_lay_person failed');
  } 

  function hapus_konsultan() 
  { 
    $this->db->where('id_pa', $this->id);
    $this->db->delete('tb_konsultan_independen');
    $this->check_trans_status('delete tb_konsultan_independen failed');
  } 

  function kirim_kesekretariatan() 
  { 
    $this->db->select('1')->from('tb_kirim_putusan_ke_sekretariat')->where('id_pep', $this->data_kirim['id_pep']);
    $rs = $this->db->get()->row_array();
    
    if ($rs) 
    { 
      $this->db->where('id_pep', $this->data_kirim['id_pep']);
      $this->db->update('tb_kirim_putusan_ke_sekretariat', $this->data_kirim);
      $this->check_trans_status('update tb_kirim_putusan_ke_sekretariat failed');
    } 
    else 
    { 
      $this->db->insert('tb_kirim_putusan_ke_sekretariat', $this->data_kirim);
      $this->check_trans_status('insert tb_kirim_putusan_ke_sekretariat failed');
    } 

    $this->db->select('p.no_protokol');
    $this->db->from('tb_pengajuan as p');
    $this->db->join('tb_pep as e', 'e.id_pengajuan = p.id_pengajuan');
    $this->db->where('e.id_pep', $this->data_kirim['id_pep']);
    $rs2 = $this->db->get()->row_array();
    $aktivitas = 'Kirim Putusan Layak Etik Protokol '.$rs2['no_protokol'].' ke Kesekretariatan';
    $id_user_kepk = $this->data_kirim['id_atk_ketua'];
    $id_user =$this->session->userdata('id_user_'.APPAUTH);
    simpan_logaktivitas_tim_kepk($aktivitas, $id_user_kepk, $id_user);
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

  public function get_data_jqgrid($param, $isCount=FALSE, $CompileOnly=False)
  {
    $id_atk_ketua = $this->get_id_atk($this->session->userdata('id_user_'.APPAUTH));
    
    $this->db->select("
      pa.id_pa,
      case pa.klasifikasi
        when 1 then 'Exempted'
        when 2 then 'Expedited'
        when 3 then 'Full Board'
        when 4 then 'Tidak Bisa Ditelaah'
      end as klasifikasi,
      p.no_protokol, 
      p.judul, 
      p.waktu_mulai, 
      p.waktu_selesai, 
      p.inserted as tanggal_pengajuan, 
      k.nama_kepk,
      pa.inserted as tanggal_pa
    ");
    $this->db->from('tb_putusan_awal as pa');
    $this->db->join('tb_pep as e', 'e.id_pep = pa.id_pep');
    $this->db->join('tb_pengajuan as p', 'p.id_pengajuan = e.id_pengajuan');
    $this->db->join('tb_kepk as k', 'k.id_kepk = p.id_kepk');
    $this->db->where('pa.id_atk_ketua', $id_atk_ketua);

    // proses parameter pencarian, jika ada
    if (isset($param['_search']) && $param['_search'] == 'true' )
    {
      $fld = $param['search_fld'];
      switch($fld){
        case 'tgl_pengajuan': $str = prepare_date($param['search_str']); break;
        case 'mulai': $str = prepare_date($param['search_str']); break;
        case 'selesai': $str = prepare_date($param['search_str']); break;
        case 'tgl_pa': $str = prepare_date($param['search_str']); break;
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
    $this->db->select('pa.id_pa, pa.id_pep, pa.id_atk_pelapor, pa.klasifikasi, pa.catatan, p.no_protokol, p.judul');
    $this->db->from('tb_putusan_awal as pa');
    $this->db->join('tb_pep as e', 'e.id_pep = pa.id_pep');
    $this->db->join('tb_pengajuan as p', 'p.id_pengajuan = e.id_pengajuan');
    $this->db->where('pa.id_pa', $id);
    $result = $this->db->get()->row_array();
    return $result;
  } 

  function get_data_protokol() 
  { 
    $this->db->select('e.id_pep, p.no_protokol, p.judul, kr.inserted');
    $this->db->from('tb_pep as e');
    $this->db->join('tb_pengajuan as p', 'p.id_pengajuan = e.id_pengajuan');
		$this->db->join('tb_kirim_ke_kepk as kr', 'kr.id_pengajuan = e.id_pengajuan and kr.id_pep = e.id_pep and kr.id_kepk = p.id_kepk');
    $this->db->join('tb_resume as r', 'r.id_pep = e.id_pep');
    $this->db->join('tb_putusan_awal as pa', 'pa.id_pep = e.id_pep', 'left');
    $this->db->where('p.id_kepk', $this->session->userdata('id_kepk_tim'));
    $this->db->where('pa.id_pa is null');
    $this->db->where('r.lanjut_telaah', 'YA');
    $result = $this->db->get()->result_array();
    return $result;
  } 

  public function get_data_standar_kelaikan($id, $id_pep) 
  { 
    $this->db->select('e.id_pengajuan');
    $this->db->from('tb_pep as e');
    $this->db->where('e.id_pep', $id_pep);
    $rs = $this->db->get()->row_array();
    $id_pengajuan = isset($rs['id_pengajuan']) ? $rs['id_pengajuan'] : 0;
    
    $this->db->select("jsk.*, msk.uraian as uraian_master, dsac.pilihan as pilihan_pengaju, pasa.pilihan as pilihan_ketua");
    $this->db->from('tb_jabaran_standar_kelaikan as jsk');
    $this->db->join('tb_master_standar_kelaikan as msk', 'msk.id_msk = jsk.id_msk');
    $this->db->join('tb_detail_sa_cek as dsac', 'dsac.id_jsk = jsk.id_jsk');
    $this->db->join('tb_self_assesment_cek as sac', 'sac.id_sac = dsac.id_sac and sac.id_pengajuan = '.$id_pengajuan);
    $this->db->join('tb_putusan_awal_self_assesment as pasa', 'pasa.id_jsk = jsk.id_jsk and pasa.id_pa = '.$id, 'left');
    $result = $this->db->get()->result_array();

    return $result;
  } 

  public function get_data_jumlah_klasifikasi_penelaah_by_id($id_pep) 
  { 
    $this->db->select('
      coalesce((select count(a.id_ta) from tb_telaah_awal as a where a.klasifikasi_usulan = 1 and a.id_pep = ta.id_pep), 0) as jumlah_exempted,
      coalesce((select count(a.id_ta) from tb_telaah_awal as a where a.klasifikasi_usulan = 2 and a.id_pep = ta.id_pep), 0) as jumlah_expedited,
      coalesce((select count(a.id_ta) from tb_telaah_awal as a where a.klasifikasi_usulan = 3 and a.id_pep = ta.id_pep), 0) as jumlah_fullboard
    ');
    $this->db->from('tb_telaah_awal as ta');
    $this->db->where('ta.id_pep', $id_pep);
    $result = $this->db->get()->row_array();
    
    return $result;
  } 

  public function get_data_resume_by_id($id_pep)
  {
    $this->db->select('r.id_atk_sekretaris, r.resume, a.nomor, a.nama');
    $this->db->from('tb_resume as r');
    $this->db->join('tb_anggota_tim_kepk as a', 'a.id_atk = r.id_atk_sekretaris');
    $this->db->where('r.id_pep', $id_pep);
    $result = $this->db->get()->result_array();

    return $result;
  }

  public function get_data_telaah_awal_by_id($id_pep) 
  { 
    $this->db->select('ta.id_ta, ta.id_atk_penelaah, ta.klasifikasi_usulan, ta.catatan_protokol, ta.catatan_7standar, a.nomor, a.nama');
    $this->db->from('tb_telaah_awal as ta');
    $this->db->join('tb_anggota_tim_kepk as a', 'a.id_atk = ta.id_atk_penelaah');
    $this->db->where('ta.id_pep', $id_pep);
    $result = $this->db->get()->result_array();

    return $result;
  } 

  public function get_data_telaah_awal_by_id_ta($id_ta) 
  { 
    $this->db->select('ta.klasifikasi_usulan, ta.catatan_protokol, ta.catatan_7standar, p.no_protokol, p.judul, a.nama as nama_penelaah');
    $this->db->from('tb_telaah_awal as ta');
    $this->db->join('tb_pep as e', 'e.id_pep = ta.id_pep');
    $this->db->join('tb_pengajuan as p', 'p.id_pengajuan = e.id_pengajuan');
    $this->db->join('tb_anggota_tim_kepk as a', 'a.id_atk = ta.id_atk_penelaah');
    $this->db->where('ta.id_ta', $id_ta);
    $result = $this->db->get()->row_array();

    return $result;
  } 

  public function get_data_penelaah() 
  { 
    $this->db->select('a.id_atk, a.nomor, a.nama');
    $this->db->from('tb_anggota_tim_kepk as a');
    $this->db->join('tb_struktur_tim_kepk as s', 's.id_atk = a.id_atk');
    $this->db->join('tb_tim_kepk as tk', 'tk.id_tim_kepk = s.id_tim_kepk');
    $this->db->where('a.id_kepk', $this->session->userdata('id_kepk_tim'));
    $this->db->where('s.jabatan', 5);
    $this->db->where('tk.aktif', 1);
    $result = $this->db->get()->result_array();

    return $result;
  } 

  public function get_data_lay_person() 
  { 
    $this->db->select('a.id_atk, a.nomor, a.nama');
    $this->db->from('tb_anggota_tim_kepk as a');
    $this->db->join('tb_struktur_tim_kepk as s', 's.id_atk = a.id_atk');
    $this->db->join('tb_tim_kepk as tk', 'tk.id_tim_kepk = s.id_tim_kepk');
    $this->db->where('a.id_kepk', $this->session->userdata('id_kepk_tim'));
    $this->db->where('s.jabatan', 6);
    $this->db->where('tk.aktif', 1);
    $result = $this->db->get()->result_array();

    return $result;
  } 

  public function get_data_konsultan() 
  { 
    $this->db->select('a.id_atk, a.nomor, a.nama');
    $this->db->from('tb_anggota_tim_kepk as a');
    $this->db->join('tb_struktur_tim_kepk as s', 's.id_atk = a.id_atk');
    $this->db->join('tb_tim_kepk as tk', 'tk.id_tim_kepk = s.id_tim_kepk');
    $this->db->where('a.id_kepk', $this->session->userdata('id_kepk_tim'));
    $this->db->where('s.jabatan', 7);
    $this->db->where('tk.aktif', 1);
    $result = $this->db->get()->result_array();

    return $result;
  } 

  function get_data_penelaah_by_id($id) 
  { 
    $this->db->select('pm.id_atk_penelaah, a.nomor, a.nama');
    $this->db->from('tb_penelaah_mendalam as pm');
    $this->db->join('tb_anggota_tim_kepk as a', 'a.id_atk = pm.id_atk_penelaah');
    $this->db->where('pm.id_pa', $id);
    $result = $this->db->get()->result_array();
   
    return $result;
  }

  function get_data_lay_person_by_id($id) 
  { 
    $this->db->select('lp.id_atk_lay_person');
    $this->db->from('tb_lay_person as lp');
    $this->db->where('lp.id_pa', $id);
    $result = $this->db->get()->result_array();
  
    return $result;
  } 

  function get_data_konsultan_by_id($id) 
  { 
    $this->db->select('ki.id_atk_konsultan');
    $this->db->from('tb_konsultan_independen as ki');
    $this->db->where('ki.id_pa', $id);
    $result = $this->db->get()->result_array();

    return $result;
  }

}