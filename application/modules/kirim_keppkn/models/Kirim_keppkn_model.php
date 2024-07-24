<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kirim_keppkn_model extends Core_Model {

  var $fieldmap_filter;
  var $data_pengajuan;
  var $data_protokol;
  var $data_perbaikan_protokol;
  var $data_kirim_ke_kepk;
  var $data_resume_sekretaris;
  var $data_telaah_awal;
  var $data_putusan_awal;
  var $data_telaah_expedited;
  var $data_telaah_fullboard;
  var $data_pelaporan_expedited;
  var $data_pelaporan_fullboard;
  var $data_keputusan;
  var $data_kirim_ke_peneliti;
  var $no_kepk;
  var $token;

	public function __construct()
	{
		parent::__construct();

    $this->fieldmap_filter = array(
      'no_protokol' => 'b.no_protokol',
      'judul' => 'b.judul'
    );

	}

 	public function fill_data()
	{
		$tgl_awal = $this->input->post('tgl_awal') ? prepare_date($this->input->post('tgl_awal')) : '';
		$tgl_akhir = $this->input->post('tgl_akhir') ? prepare_date($this->input->post('tgl_akhir')) : '';

    $kepk = $this->get_data_kepk();
    $data = $this->get_data_pengajuan_by_tgl($tgl_awal, $tgl_akhir);

    if (!empty($data))
    {
      for ($i=0; $i<count($data); $i++)
      {
        $this->data[$data[$i]['no_protokol']]['version'] = file_get_contents('version', true);
        $this->data[$data[$i]['no_protokol']]['no_kep'] = $kepk['kodefikasi'];
        $this->data[$data[$i]['no_protokol']]['token'] = $kepk['token'];
        $this->data[$data[$i]['no_protokol']]['no_protokol'] = $data[$i]['no_protokol'];

        $aktv = str_replace(" ", "_", strtolower(trim($data[$i]['aktivitas'])));
        if ($aktv == 'pengajuan')
        {
          $this->data[$data[$i]['no_protokol']]['urutan_proses'][] = array(
            'aktivitas' => $data[$i]['aktivitas'],
            'no_peneliti' => $data[$i]['nomor_author'],
            'judul' => $data[$i]['judul'],
            'nama_ketua_peneliti' => $data[$i]['nama_ketua'],
            'telp_peneliti' => $data[$i]['telp_peneliti'],
            'email_peneliti' => $data[$i]['email_peneliti'],
            'jenis_penelitian' => $data[$i]['jenis_penelitian'],
            'asal_pengusul' => $data[$i]['asal_pengusul'],
            'jenis_lembaga' => $data[$i]['jenis_lembaga'],
            'status_pengusul' => $data[$i]['status_pengusul'],
            'strata_pendidikan' => $data[$i]['strata_pendidikan'],
            'waktu' => $data[$i]['waktu_aktivitas']
          );
        }
        else if ($aktv == 'protokol')
        {
          $this->data[$data[$i]['no_protokol']]['urutan_proses'][] = array(
            'aktivitas' => $data[$i]['aktivitas'],
            'revisi_ke' => $data[$i]['revisi_ke'],
            'waktu' => $data[$i]['waktu_aktivitas']
          );
        }
        else if ($aktv == 'kirim_ke_kepk')
        {
          $this->data[$data[$i]['no_protokol']]['urutan_proses'][] = array(
            'aktivitas' => $data[$i]['aktivitas'],
            'revisi_ke' => $data[$i]['revisi_ke'],
            'waktu' => $data[$i]['waktu_aktivitas']
          );
        }
        else if ($aktv == 'resume_sekretaris')
        {
          $id_pengajuan = $data[$i]['id_pengajuan'];
          $penelaah_awal = $this->get_data_penelaah_awal_by_id($id_pengajuan);
          $pa = array();
          if (!empty($penelaah_awal) && $data[$i]['lanjut_telaah'] == 'YA')
          {
            for ($j=0; $j<count($penelaah_awal); $j++)
            {
              $pa[] = array(
                'nomor' => $penelaah_awal[$j]['nomor'],
                'nama' =>  $penelaah_awal[$j]['nama']
              );
            }
          }

          $this->data[$data[$i]['no_protokol']]['urutan_proses'][] = array(
            'aktivitas' => $data[$i]['aktivitas'],
            'no_anggota' => $data[$i]['nomor_author'],
            'resume' => $data[$i]['resume'],
            'lanjut_telaah' => $data[$i]['lanjut_telaah'],
            'alasan_tbd' => $data[$i]['alasan_tbd'],
            'alasan_ditolak' => $data[$i]['alasan_ditolak'],
            'waktu' => $data[$i]['waktu_aktivitas'],
            'penelaah_awal' => $pa
          );
        }
        else if ($aktv == 'telaah_awal')
        {
          $this->data[$data[$i]['no_protokol']]['urutan_proses'][] = array(
            'aktivitas' => $data[$i]['aktivitas'],
            'no_anggota' => $data[$i]['nomor_author'],
            'klasifikasi_usulan' => $data[$i]['klasifikasi_usulan'],
            'catatan_protokol' => $data[$i]['catatan_protokol'],
            'catatan_7standar' => $data[$i]['catatan_7standar'],
            'waktu' => $data[$i]['waktu_aktivitas']
          );
        }        
        else if ($aktv == 'putusan_awal_ketua')
        {
          $penelaah = array();
          if ($data[$i]['klasifikasi_putusan'] == 2 || $data[$i]['klasifikasi_putusan'] == 3)
          {
            $id_pep = $data[$i]['id_pep'];
            $data_penelaah = $this->get_data_penelaah_by_id_pep($id_pep);
            if (!empty($data_penelaah))
            {
              for ($j=0; $j<count($data_penelaah); $j++)
              {
                if ($data_penelaah[$j]['aktivitas'] == 'Putusan Awal')
                  $penelaah[] = array(
                    'nomor' => $data_penelaah[$j]['nomor'],
                    'nama' => $data_penelaah[$j]['nama'],
                    'jabatan' => $data_penelaah[$j]['jabatan']
                  );
              }
            }
          }

          $this->data[$data[$i]['no_protokol']]['urutan_proses'][] = array(
            'aktivitas' => $data[$i]['aktivitas'],
            'no_anggota' => $data[$i]['nomor_author'],
            'klasifikasi_putusan' => $data[$i]['klasifikasi_putusan'],
            'penelaah' => $penelaah,
            'waktu' => $data[$i]['waktu_aktivitas']
          );
        }
        else if ($aktv == 'putusan_awal_wakil_ketua')
        {
          $penelaah = array();
          if ($data[$i]['klasifikasi_putusan'] == 2 || $data[$i]['klasifikasi_putusan'] == 3)
          {
            $id_pep = $data[$i]['id_pep'];
            $data_penelaah = $this->get_data_penelaah_by_id_pep($id_pep);
            if (!empty($data_penelaah))
            {
              for ($j=0; $j<count($data_penelaah); $j++)
              {
                if ($data_penelaah[$j]['aktivitas'] == 'Putusan Awal')
                  $penelaah[] = array(
                    'nomor' => $data_penelaah[$j]['nomor'],
                    'nama' => $data_penelaah[$j]['nama'],
                    'jabatan' => $data_penelaah[$j]['jabatan']
                  );
              }
            }
          }

          $this->data[$data[$i]['no_protokol']]['urutan_proses'][] = array(
            'aktivitas' => $data[$i]['aktivitas'],
            'no_anggota' => $data[$i]['nomor_author'],
            'klasifikasi_putusan' => $data[$i]['klasifikasi_putusan'],
            'penelaah' => $penelaah,
            'waktu' => $data[$i]['waktu_aktivitas']
          );
        }
        else if ($aktv == 'telaah_expedited')
        {
          $this->data[$data[$i]['no_protokol']]['urutan_proses'][] = array(
            'aktivitas' => $data[$i]['aktivitas'],
            'no_anggota' => $data[$i]['nomor_author'],
            'kelayakan' => $data[$i]['kelayakan'],
            'catatan_protokol' => $data[$i]['catatan_protokol'],
            'catatan_7standar' => $data[$i]['catatan_7standar'],
            'waktu' => $data[$i]['waktu_aktivitas']
          );
        }        
        else if ($aktv == 'telaah_full_board')
        {
          $this->data[$data[$i]['no_protokol']]['urutan_proses'][] = array(
            'aktivitas' => $data[$i]['aktivitas'],
            'no_anggota' => $data[$i]['nomor_author'],
            'kelayakan' => $data[$i]['kelayakan'],
            'catatan_protokol' => $data[$i]['catatan_protokol'],
            'catatan_7standar' => $data[$i]['catatan_7standar'],
            'waktu' => $data[$i]['waktu_aktivitas']
          );
        }        
        else if ($aktv == 'pelaporan_expedited')
        {
          $this->data[$data[$i]['no_protokol']]['urutan_proses'][] = array(
            'aktivitas' => $data[$i]['aktivitas'],
            'no_anggota' => $data[$i]['nomor_author'],
            'keputusan' => $data[$i]['keputusan'],
            'waktu' => $data[$i]['waktu_aktivitas']
          );
        }
        else if ($aktv == 'pelaporan_full_board')
        {
          $this->data[$data[$i]['no_protokol']]['urutan_proses'][] = array(
            'aktivitas' => $data[$i]['aktivitas'],
            'no_anggota' => $data[$i]['nomor_author'],
            'keputusan' => $data[$i]['keputusan'],
            'waktu' => $data[$i]['waktu_aktivitas']
          );
        }
        else if ($aktv == 'putusan_expedited_ke_full_board_ketua')
        {
          $penelaah = array();
          $id_pep = $data[$i]['id_pep'];
          $data_penelaah = $this->get_data_penelaah_by_id_pep($id_pep);
          if (!empty($data_penelaah))
          {
            for ($j=0; $j<count($data_penelaah); $j++)
            {
              if ($data_penelaah[$j]['aktivitas'] == 'Putusan Expedited ke Full Board')
                $penelaah[] = array(
                  'nomor' => $data_penelaah[$j]['nomor'],
                  'nama' => $data_penelaah[$j]['nama'],
                  'jabatan' => $data_penelaah[$j]['jabatan']
                );
            }
          }

          $this->data[$data[$i]['no_protokol']]['urutan_proses'][] = array(
            'aktivitas' => $data[$i]['aktivitas'],
            'no_anggota' => $data[$i]['nomor_author'],
            'klasifikasi_putusan' => $data[$i]['klasifikasi_putusan'],
            'penelaah' => $penelaah,
            'waktu' => $data[$i]['waktu_aktivitas']
          );
        }
        else if ($aktv == 'putusan_expedited_ke_full_board_wakil_ketua')
        {
          $penelaah = array();
          $id_pep = $data[$i]['id_pep'];
          $data_penelaah = $this->get_data_penelaah_by_id_pep($id_pep);
          if (!empty($data_penelaah))
          {
            for ($j=0; $j<count($data_penelaah); $j++)
            {
              if ($data_penelaah[$j]['aktivitas'] == 'Putusan Expedited ke Full Board')
                $penelaah[] = array(
                  'nomor' => $data_penelaah[$j]['nomor'],
                  'nama' => $data_penelaah[$j]['nama'],
                  'jabatan' => $data_penelaah[$j]['jabatan']
                );
            }
          }

          $this->data[$data[$i]['no_protokol']]['urutan_proses'][] = array(
            'aktivitas' => $data[$i]['aktivitas'],
            'no_anggota' => $data[$i]['nomor_author'],
            'klasifikasi_putusan' => $data[$i]['klasifikasi_putusan'],
            'penelaah' => $penelaah,
            'waktu' => $data[$i]['waktu_aktivitas']
          );
        }
        else if ($aktv == 'keputusan')
        {
          $this->data[$data[$i]['no_protokol']]['urutan_proses'][] = array(
            'aktivitas' => $data[$i]['aktivitas'],
            'no_anggota' => $data[$i]['nomor_author'],
            'klasifikasi_putusan' => $data[$i]['klasifikasi_putusan'],
            'keputusan' => $data[$i]['keputusan'],
            'waktu' => $data[$i]['waktu_aktivitas']
          );
        }        
        else if ($aktv == 'kirim_ke_peneliti')
        {
          $this->data[$data[$i]['no_protokol']]['urutan_proses'][] = array(
            'aktivitas' => $data[$i]['aktivitas'],
            'no_anggota' => $data[$i]['nomor_author'],
            'klasifikasi_putusan' => $data[$i]['klasifikasi_putusan'],
            'keputusan' => $data[$i]['keputusan'],
            'no_dokumen' => $data[$i]['no_dokumen'],
            'waktu' => $data[$i]['waktu_aktivitas']
          );
        }        
        else if ($aktv == 'perbaikan_protokol')
        {
          $this->data[$data[$i]['no_protokol']]['urutan_proses'][] = array(
            'aktivitas' => $data[$i]['aktivitas'],
            'revisi_ke' => $data[$i]['revisi_ke'],
            'waktu' => $data[$i]['waktu_aktivitas']
          );
        }
      }
    }

	}

  function get_data_protokol_terkirim($param, $isCount=FALSE, $CompileOnly=False)
  {
    $query = "
      select a.id_kirim_ke_keppkn, a.id_pengajuan, a.waktu_kirim, b.no_protokol, b.judul, b.klasifikasi, b.tanggal_pengajuan, b.tanggal_protokol from tb_kirim_ke_keppkn as a join v_daftar_progress_protokol as b on b.id_pengajuan = a.id_pengajuan where 1 = 1";

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

  function save_data_kirim($no_protokol)
  {
    $this->db->select('id_pengajuan');
    $this->db->from('tb_pengajuan');
    $this->db->where('no_protokol', $no_protokol);
    $rs = $this->db->get()->row_array();
    $id_pengajuan = isset($rs['id_pengajuan']) ? $rs['id_pengajuan'] : 0;

    $this->db->select('1')->from('tb_kirim_ke_keppkn')->where('id_pengajuan', $id_pengajuan);
    $rs = $this->db->get()->row_array();

    if (!$rs)
    {
      $data = array('id_pengajuan' => $id_pengajuan, 'waktu_kirim' => date('Y-m-d H:i:s'));
      $this->db->insert('tb_kirim_ke_keppkn', $data);
    }
  }

  function get_data_kepk()
  {
    $this->db->select('k.kodefikasi, k.token');
    $this->db->from('tb_kepk as k');
    $this->db->where('k.id_kepk', $this->session->userdata('id_kepk'));
    $result = $this->db->get()->row_array();

    return $result;
  }

  function get_data_pengajuan_by_tgl($tgl_awal, $tgl_akhir)
  {
    $this->db->select("v.*, p.jenis_penelitian, p.asal_pengusul, p.jenis_lembaga, p.status_pengusul, p.strata_pendidikan");
    $this->db->from('v_detail_progress_protokol as v');
    $this->db->join('tb_pengajuan as p', 'p.id_pengajuan = v.id_pengajuan');
    $this->db->where("date(p.inserted) between '".$tgl_awal."' and '".$tgl_akhir."'");
    $this->db->where("v.id_pengajuan in (select v2.id_pengajuan from v_detail_progress_protokol as v2 where v2.keputusan = 'LE')");
    $this->db->order_by('v.waktu_aktivitas');
    $result = $this->db->get()->result_array();

    return $result;
  }

  function get_data_penelaah_awal_by_id($id)
  {
    $this->db->select('atk.nomor, atk.nama');
    $this->db->from('tb_anggota_tim_kepk as atk');
    $this->db->join('tb_penelaah_awal as pa', 'pa.id_atk_penelaah = atk.id_atk');
    $this->db->join('tb_resume as r', 'r.id_resume = pa.id_resume');
    $this->db->join('tb_pep as e', 'e.id_pep = r.id_pep');
    $this->db->where('e.id_pengajuan', $id);
    $result = $this->db->get()->result_array();

    return $result;
  }

  function get_data_penelaah_by_id_pep($id_pep)
  {
		$query = "
			select e.id_pep, atk.nomor, atk.nama, 'Pelapor' as jabatan, 'Putusan Awal' as aktivitas
			from tb_anggota_tim_kepk as atk
			join tb_putusan_awal as pa on pa.id_atk_pelapor = atk.id_atk
			join tb_pep as e on e.id_pep = pa.id_pep
			where e.id_pep = ".$id_pep."

			union 

			select e.id_pep, atk.nomor, atk.nama, 'Penelaah' as jabatan, 'Putusan Awal' as aktivitas
			from tb_anggota_tim_kepk as atk
			join tb_penelaah_mendalam as pm on pm.id_atk_penelaah = atk.id_atk
			join tb_putusan_awal as pa on pa.id_pa = pm.id_pa
			join tb_pep as e on e.id_pep = pa.id_pep
			where e.id_pep = ".$id_pep."
			  and atk.id_atk not in (select pa2.id_atk_pelapor from tb_putusan_awal as pa2 where pa2.id_pa = pa.id_pa)
			  
			union 

			select e.id_pep, atk.nomor, atk.nama, 'Lay Person' as jabatan, 'Putusan Awal' as aktivitas
			from tb_anggota_tim_kepk as atk
			join tb_lay_person as lp on lp.id_atk_lay_person = atk.id_atk
			join tb_putusan_awal as pa on pa.id_pa = lp.id_pa
			join tb_pep as e on e.id_pep = pa.id_pep
			where e.id_pep = ".$id_pep." 

			union 

			select e.id_pep, atk.nomor, atk.nama, 'Konsultan Independen' as jabatan, 'Putusan Awal' as aktivitas
			from tb_anggota_tim_kepk as atk
			join tb_konsultan_independen as ki on ki.id_atk_konsultan = atk.id_atk
			join tb_putusan_awal as pa on pa.id_pa = ki.id_pa
			join tb_pep as e on e.id_pep = pa.id_pep
			where e.id_pep = ".$id_pep."

      union		

      select e.id_pep, atk.nomor, atk.nama, 'Pelapor' as jabatan, 'Putusan Expedited ke Full Board' as aktivitas
      from tb_anggota_tim_kepk as atk
      join tb_putusan_awal_expedited_to_fullboard as paef on paef.id_atk_pelapor = atk.id_atk
      join tb_pep as e on e.id_pep = paef.id_pep
      where e.id_pep = ".$id_pep."

      union 

      select e.id_pep, atk.nomor, atk.nama, 'Penelaah' as jabatan, 'Putusan Expedited ke Full Board' as aktivitas
      from tb_anggota_tim_kepk as atk
      join tb_penelaah_mendalam_exptofb as pmef on pmef.id_atk_penelaah = atk.id_atk
      join tb_putusan_awal_expedited_to_fullboard as paef on paef.id_paef = pmef.id_paef
      join tb_pep as e on e.id_pep = paef.id_pep
      where e.id_pep = ".$id_pep."
        and atk.id_atk not in (select paef2.id_atk_pelapor from tb_putusan_awal_expedited_to_fullboard as paef2 where paef2.id_paef = paef.id_paef)
        
      union 

      select e.id_pep, atk.nomor, atk.nama, 'Lay Person' as jabatan, 'Putusan Expedited ke Full Board' as aktivitas
      from tb_anggota_tim_kepk as atk
      join tb_lay_person_exptofb as lp on lp.id_atk_lay_person = atk.id_atk
      join tb_putusan_awal_expedited_to_fullboard as paef on paef.id_paef = lp.id_paef
      join tb_pep as e on e.id_pep = paef.id_pep
      where e.id_pep = ".$id_pep." 

      union 

      select e.id_pep, atk.nomor, atk.nama, 'Konsultan Independen' as jabatan, 'Putusan Expedited ke Full Board' as aktivitas
      from tb_anggota_tim_kepk as atk
      join tb_konsultan_independen_exptofb as ki on ki.id_atk_konsultan = atk.id_atk
      join tb_putusan_awal_expedited_to_fullboard as paef on paef.id_paef = ki.id_paef
      join tb_pep as e on e.id_pep = paef.id_pep
      where e.id_pep = ".$id_pep."		
    ";

    $result = $this->db->query($query)->result_array();

    return $result;
  }
}
