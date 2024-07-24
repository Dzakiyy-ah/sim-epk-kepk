<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Hasil_telaah_model extends Core_Model { 

  var $fieldmap_filter;

  public function __construct() 
  {
    parent::__construct();

    $this->fieldmap_filter = array(
      'no_protokol' => 'p.no_protokol',
      'judul' => 'p.judul',
      'klasifikasi' => "case kr.klasifikasi
                          when 1 then 'Exempted'
                          when 2 then 'Expedited'
                          when 3 then 'Full Board'
                          when 4 then 'Tidak Bisa Ditelaah'
                        end",
      'keputusan' => "case kr.keputusan
                        when 'LE' then 'Layak Etik'
                        when 'R' then 'Perbaikan'
                        when 'F' then 'Full Board'
                      end",
      'jenis_surat' => 'kr.jenis_surat',
      'tgl_upload' => 'kr.inserted'
    );
  }

  public function get_data_jqgrid($param, $isCount=FALSE, $CompileOnly=False)
  {
    $this->db->select("
        kr.id_pep,
        case kr.klasifikasi
          when 1 then 'Exempted'
          when 2 then 'Expedited'
          when 3 then 'Full Board'
          when 4 then 'Tidak Bisa Ditelaah'
        end as klasifikasi,
        case kr.keputusan
          when 'LE' then 'Layak Etik'
          when 'R' then 'Perbaikan'
          when 'F' then 'Full Board'
        end as keputusan,
        kr.jenis_surat,
        p.no_protokol, 
        p.judul,
        kr.inserted as tanggal_upload
      ");
   $this->db->from('tb_kirim_surat_ke_peneliti as kr');
   $this->db->join('tb_pep as e', 'e.id_pep = kr.id_pep');
   $this->db->join('tb_pengajuan as p', 'p.id_pengajuan = e.id_pengajuan');
   $this->db->where('p.id_pengusul', $this->session->userdata('id_pengusul'));

    // proses parameter pencarian, jika ada
    if (isset($param['_search']) && $param['_search'] == 'true' )
    {
      $fld = $param['search_fld'];
      switch($fld){
        case 'tgl_upload': $str = $this->prepare_datetime($param['search_str']); break;
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
  
  function get_data_file_by_id($id)
  {
    $query = "
      select kr.id_pep, 'Ethical Exemption' as nama_file, kr.klasifikasi, 'ethical_exemption' as jenis_file
      from tb_kirim_surat_ke_peneliti as kr
      where kr.jenis_surat = 'Pembebasan Etik' and kr.id_pep = ".$id."

      union

      select kr.id_pep, '7 Standar Kelaikan Etik Penelitian Ethical' as nama_file, kr.klasifikasi, 'sa_ethical_exemption' as jenis_file
      from tb_kirim_surat_ke_peneliti as kr
      where kr.jenis_surat = 'Pembebasan Etik' and kr.id_pep = ".$id."

      union

      select kr.id_pep, 'Ethical Approval' as nama_file, kr.klasifikasi, 'ethical_approval' as jenis_file
      from tb_kirim_surat_ke_peneliti as kr
      where kr.jenis_surat = 'Persetujuan Etik' and kr.id_pep = ".$id."

      union

      select kr.id_pep, '7 Standar Kelaikan Etik Penelitian' as nama_file, kr.klasifikasi, 'sa_ethical_approval' as jenis_file
      from tb_kirim_surat_ke_peneliti as kr
      where kr.jenis_surat = 'Persetujuan Etik' and kr.id_pep = ".$id."
      union

      select kr.id_pep, 'Ethical Revision' as nama_file, kr.klasifikasi, 'ethical_revision' as jenis_file
      from tb_kirim_surat_ke_peneliti as kr
      where kr.jenis_surat = 'Perbaikan Etik' and kr.id_pep = ".$id."

      union

      select kr.id_pep, 'Catatan Penelaah' as nama_file, kr.klasifikasi, 'catatan_penelaah' as jenis_file
      from tb_kirim_surat_ke_peneliti as kr
      where kr.jenis_surat = 'Perbaikan Etik' and kr.id_pep = ".$id." and kr.klasifikasi <> 4

      union

      select kr.id_pep, 'Alasan TBD' as nama_file, kr.klasifikasi, 'alasan_tbd' as jenis_file
      from tb_kirim_surat_ke_peneliti as kr
      where kr.jenis_surat = 'Perbaikan Etik' and kr.id_pep = ".$id." and kr.klasifikasi = 4

      union

      select ".$id." as id_pep, 'Daftar Tilik Kunjungan Pemantauan' as nama_file, kr.klasifikasi, 'daftar_kunjungan' as jenis_file
      from tb_kirim_surat_ke_peneliti as kr
      where (kr.jenis_surat = 'Pembebasan Etik' or kr.jenis_surat = 'Persetujuan Etik') and kr.id_pep = ".$id."

      union

      select ".$id." as id_pep, 'Report Hasil' as nama_file, kr.klasifikasi, 'report_hasil' as jenis_file
      from tb_kirim_surat_ke_peneliti as kr
      where (kr.jenis_surat = 'Pembebasan Etik' or kr.jenis_surat = 'Persetujuan Etik') and kr.id_pep = ".$id."

      union

      select ".$id." as id_pep, 'Surat Permohonan Usulan Kaji Etik/Revisi/Amandemen' as nama_file, kr.klasifikasi, 'permohonan_usulan' as jenis_file
      from tb_kirim_surat_ke_peneliti as kr
      where (kr.jenis_surat = 'Pembebasan Etik' or kr.jenis_surat = 'Persetujuan Etik') and kr.id_pep = ".$id."

      union

      select ".$id." as id_pep, 'Memoradum Penghentian Penelitian' as nama_file, kr.klasifikasi, 'memorandum_penghentian' as jenis_file
      from tb_kirim_surat_ke_peneliti as kr
      where (kr.jenis_surat = 'Pembebasan Etik' or kr.jenis_surat = 'Persetujuan Etik') and kr.id_pep = ".$id."

      union

      select ".$id." as id_pep, 'Laporan KTD Serius / SAE' as nama_file, kr.klasifikasi, 'laporan_ktd_serius' as jenis_file
      from tb_kirim_surat_ke_peneliti as kr
      where (kr.jenis_surat = 'Pembebasan Etik' or kr.jenis_surat = 'Persetujuan Etik') and kr.id_pep = ".$id."

      union

      select ".$id." as id_pep, 'Catatan Penyimpangan / Ketidakpatuhan / Pelanggaran' as nama_file, kr.klasifikasi, 'catatan_penyimpangan' as jenis_file
      from tb_kirim_surat_ke_peneliti as kr
      where (kr.jenis_surat = 'Pembebasan Etik' or kr.jenis_surat = 'Persetujuan Etik') and kr.id_pep = ".$id."

    ";
		$result = $this->db->query($query)->result_array();

		return $result;
  }

	function get_data_ethical_exemption_by_id_pep($id_pep)
	{
		$this->db->select("
			ee.no_surat, 
			ee.no_dokumen,
			ee.tanggal_surat, 
			ee.awal_berlaku, 
			ee.akhir_berlaku, 
			p.no_protokol, 
			p.judul, 
			p.title,
			p.nama_ketua,
			p.nama_institusi,
			p.id_pengajuan
		");
		$this->db->from('tb_ethical_exemption as ee');
		$this->db->join('tb_pep as e', 'e.id_pep = ee.id_pep');
		$this->db->join('tb_pengajuan as p', 'p.id_pengajuan = e.id_pengajuan');
		$this->db->where('ee.id_pep', $id_pep);
		$result = $this->db->get()->row_array();

		return $result;
	}

	function get_data_ethical_approval_by_id_pep($id_pep)
	{
		$this->db->select("
			ea.no_surat, 
			ea.no_dokumen,
			ea.tanggal_surat, 
			ea.awal_berlaku, 
			ea.akhir_berlaku,
      e.revisi_ke, 
			p.no_protokol, 
			p.judul, 
			p.title,
			p.nama_ketua,
			p.nama_institusi,
			p.id_pengajuan
		");
		$this->db->from('tb_ethical_approval as ea');
		$this->db->join('tb_pep as e', 'e.id_pep = ea.id_pep');
		$this->db->join('tb_pengajuan as p', 'p.id_pengajuan = e.id_pengajuan');
		$this->db->where('ea.id_pep', $id_pep);
		$result = $this->db->get()->row_array();

		return $result;
	}

	function get_data_ethical_revision_by_id_pep($id_pep)
	{
		$this->db->select("
			er.no_surat, 
			er.no_dokumen,
			er.tanggal_surat, 
			er.awal_berlaku, 
			er.akhir_berlaku, 
			p.no_protokol, 
			p.judul, 
			p.nama_ketua,
			p.id_pengajuan,
			kr.klasifikasi,
			k.kodefikasi,
			k.nama_kepk,
			k.alamat,
			k.email,
			k.no_telepon
		");
		$this->db->from('tb_ethical_revision as er');
		$this->db->join('tb_pep as e', 'e.id_pep = er.id_pep');
		$this->db->join('tb_pengajuan as p', 'p.id_pengajuan = e.id_pengajuan');
		$this->db->join('tb_kirim_putusan_ke_sekretariat as kr', 'kr.id_pep = er.id_pep');
		$this->db->join('tb_kepk as k', 'k.id_kepk = p.id_kepk');
		$this->db->where('er.id_pep', $id_pep);
		$result = $this->db->get()->row_array();

		return $result;
	}

  public function get_data_telaah_expedited_by_idpep($id_pep)
  {
    $this->db->select('te.id_texp, te.catatan_protokol, te.catatan_7standar');
    $this->db->from('tb_telaah_expedited as te');
    $this->db->where('te.id_pep', $id_pep);
    $result = $this->db->get()->result_array();

    return $result;
  }

  public function get_data_telaah_fullboard_by_idpep($id_pep)
  {
    $this->db->select('tf.id_tfbd, tf.catatan_protokol, tf.catatan_7standar');
    $this->db->from('tb_telaah_fullboard as tf');
    $this->db->where('tf.id_pep', $id_pep);
    $result = $this->db->get()->result_array();

    return $result;
  }

  function get_data_alasan_tbd_by_idpep($id_pep)
  {
    $this->db->select('r.alasan_tbd');
    $this->db->from('tb_resume as r');
    $this->db->where('r.id_pep', $id_pep);
    $result = $this->db->get()->row_array();

    return $result;
  }

  function get_data_ketua_kepk()
	{
		$this->db->select('a.id_kepk, a.nama, a.nomor, a.nik');
		$this->db->from('tb_anggota_tim_kepk as a');
		$this->db->join('tb_struktur_tim_kepk as s', 's.id_atk = a.id_atk');
		$this->db->join('tb_tim_kepk as tk', 'tk.id_tim_kepk = s.id_tim_kepk');
		$this->db->where('s.jabatan', 1);
		$this->db->where('tk.id_kepk', $this->session->userdata('id_kepk'));
		$this->db->where('tk.aktif', 1);
		$result = $this->db->get()->row_array();

		return $result;
	}

  function get_data_kop_surat()
  {
    $this->db->select('ks.file_name');
    $this->db->from('tb_kop_surat as ks');
    $this->db->where('ks.id_kepk', $this->session->userdata('id_kepk'));
    $result = $this->db->get()->row_array();

    return $result;
  }

  function get_data_ttd_ketua()
  {
    $this->db->select('tk.file_name');
    $this->db->from('tb_tandatangan_ketua as tk');
    $this->db->where('tk.id_kepk', $this->session->userdata('id_kepk'));
    $result = $this->db->get()->row_array();

    return $result;
  }

	function get_anggota_penelitian_by_id_pengajuan($id_pengajuan)
	{
		$this->db->select('ap.nama, p.nomor');
		$this->db->from('tb_anggota_penelitian as ap');
		$this->db->join('tb_pengusul as p', 'p.id_pengusul = ap.id_pengusul');
		$this->db->where('ap.id_pengajuan', $id_pengajuan);
		$result = $this->db->get()->result_array();

		return $result;
	}

  public function get_data_standar_kelaikan_ethical_exemption($id_pep)
	{
		$this->db->select('e.id_pengajuan, coalesce(pa.id_pa, 0) as id_pa');
		$this->db->from('tb_pep as e');
    $this->db->join('tb_putusan_awal as pa', 'pa.id_pep = e.id_pep', 'left');
		$this->db->where('e.id_pep', $id_pep);
		$rs = $this->db->get()->row_array();
		$id_pengajuan = isset($rs['id_pengajuan']) ? $rs['id_pengajuan'] : 0;
    $id_pa = isset($rs['id_pa']) ? $rs['id_pa'] : 0;

		$this->db->select("jsk.*, msk.uraian as uraian_master, dsac.pilihan as pilihan_pengaju, pasa.pilihan as pilihan_sekretaris");
		$this->db->from('tb_jabaran_standar_kelaikan as jsk');
		$this->db->join('tb_master_standar_kelaikan as msk', 'msk.id_msk = jsk.id_msk');
		$this->db->join('tb_detail_sa_cek as dsac', 'dsac.id_jsk = jsk.id_jsk');
		$this->db->join('tb_self_assesment_cek as sac', 'sac.id_sac = dsac.id_sac and sac.id_pengajuan = '.$id_pengajuan);
		$this->db->join('tb_putusan_awal_self_assesment as pasa', 'pasa.id_jsk = jsk.id_jsk and pasa.id_pa = '.$id_pa, 'left');
		$result = $this->db->get()->result_array();

		return $result;
	}

  public function get_data_standar_kelaikan_ethical_approval($id_pep)
	{
		$this->db->select('e.id_pengajuan, e.revisi_ke');
		$this->db->from('tb_pep as e');
		$this->db->where('e.id_pep', $id_pep);
		$rs = $this->db->get()->row_array();
		$id_pengajuan = isset($rs['id_pengajuan']) ? $rs['id_pengajuan'] : 0;
    $revisi_ke = isset($rs['revisi_ke']) ? $rs['revisi_ke'] : 0;

		$this->db->select("jsk.*, msk.uraian as uraian_master, dsac.pilihan as pilihan_pengaju,
				(select sa.pilihan from tb_putusan_expedited_self_assesment as sa join tb_putusan_expedited as ko on ko.id_pexp = sa.id_pexp
					where ko.id_pep = ".$id_pep." and sa.id_jsk = jsk.id_jsk
									union
					select sa2.pilihan from tb_putusan_fullboard_self_assesment as sa2 join tb_putusan_fullboard as ko2 on ko2.id_pfbd = sa2.id_pfbd
					where ko2.id_pep = ".$id_pep." and sa2.id_jsk = jsk.id_jsk) as pilihan_penelaah
		");
		$this->db->from('tb_jabaran_standar_kelaikan as jsk');
		$this->db->join('tb_master_standar_kelaikan as msk', 'msk.id_msk = jsk.id_msk');
		$this->db->join('tb_detail_sa_cek as dsac', 'dsac.id_jsk = jsk.id_jsk');
		$this->db->join('tb_self_assesment_cek as sac', 'sac.id_sac = dsac.id_sac and sac.id_pengajuan = '.$id_pengajuan.' and sac.revisi_ke = '.$revisi_ke);
		$result = $this->db->get()->result_array();

		return $result;
	}

  function get_data_protokol_by_id_pep($id_pep)
  {
    $this->db->select('p.no_protokol, p.judul, p.nama_ketua, e.revisi_ke, k.nama_kepk');
    $this->db->from('tb_pengajuan as p');
    $this->db->join('tb_pep as e', 'e.id_pengajuan = p.id_pengajuan');
    $this->db->join('tb_kepk as k', 'k.id_kepk = p.id_kepk');
    $this->db->where('e.id_pep', $id_pep);
    $rs = $this->db->get()->row_array();

    return $rs;
  }

  function prepare_datetime($datetime)
  {
    $exp = explode(" ", $datetime);
    $date = prepare_date($exp[0]);
    $time = $exp[1];

    return $date." ".$time;
  }
}