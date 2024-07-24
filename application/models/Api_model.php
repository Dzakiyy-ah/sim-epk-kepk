<?php 
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api_model extends CI_Model
{

  var $data;
  var $id_pengajuan;
  var $id_protokol;
  var $error_message;

  public function __construct()
  {
    parent::__construct();
  }

  public function fill_data_progress_protokol($nomor_kep, $token, $tgl_awal, $tgl_akhir)
	{
    $data = $this->get_data_progress_protokol($nomor_kep, $token, $tgl_awal, $tgl_akhir);

    if (!empty($data))
    {
      for ($i=0; $i<count($data); $i++)
      {
        $this->data[$data[$i]['no_protokol']]['version'] = file_get_contents('version', true);
        $this->data[$data[$i]['no_protokol']]['no_kep'] = $nomor_kep;
        $this->data[$data[$i]['no_protokol']]['token'] = $token;
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

    return $this->data;
	}

  function get_data_progress_protokol($nomor_kep, $token, $tgl_awal, $tgl_akhir)
  {
    $this->db->select("v.*, p.jenis_penelitian, p.asal_pengusul, p.jenis_lembaga, p.status_pengusul, p.strata_pendidikan");
    $this->db->from('v_detail_progress_protokol as v');
    $this->db->join('tb_pengajuan as p', 'p.id_pengajuan = v.id_pengajuan');
    $this->db->join('tb_kepk as k', 'k.id_kepk = p.id_kepk');
    $this->db->where('k.kodefikasi', $nomor_kep);
    $this->db->where('k.token', $token);
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
