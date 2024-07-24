<?php 
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Userpage_Controller extends Core_Controller
{

  public function __construct()
  {
    parent::__construct();
		$this->load->model('auth/auth_model', 'auth');
		$url = $this->uri->slash_segment(1);
	
    // cek apakah sudah login, bila belum tampilkan halaman login
    if ($this->session->userdata('is_login_'.APPAUTH) != TRUE){
      redirect ('auth');
    }
		else
		{
			if ($url == "/")
			{
				redirect('dashboard');
			}
			else
			{
				$pages1 = array('dashboard/');
				$pages2 = array('dashboard/', 'user_profil/', 'kepk/', 'anggota_tim/', 'struktur_tim/', 'penelaah_etik/', 'peneliti/', 'kop_surat/', 'tandatangan_ketua/', 'tarif_telaah/', 'kirim_keppkn/');
				$pages3 = array('dashboard/', 'user_profil/', 'pengajuan/', 'self_assesment/', 'protokol/', 'hasil_telaah/', 'perbaikan/', 'monev/', 'laporan_akhir/', 'pemberitahuan_fullboard/', 'progress_protokol/');
				$pages4 = array('dashboard/', 'user_profil/', 'resume/', 'putusan_expedited/', 'putusan_fullboard/', 'monev/', 'laporan_akhir/', 'progress_protokol/', 'statistik_protokol/');
				$pages5 = array('dashboard/', 'user_profil/', 'dokumentasi/', 'surat_pembebasan/', 'surat_persetujuan/', 'surat_perbaikan/', 'upload_surat/', 'pemberitahuan_fullboard/', 'dokumen_pengarsipan/', 'progress_protokol/');
				$pages6 = array('dashboard/', 'user_profil/', 'telaah_awal/', 'telaah_expedited/', 'telaah_fullboard/', 'putusan_expedited/', 'putusan_fullboard/');
				$pages7 = array('dashboard/', 'user_profil/', 'putusan_awal/', 'putusan_expedited/', 'putusan_fullboard/', 'monev/', 'laporan_akhir/', 'progress_protokol/');
        $pages8 = array('dashboard/', 'user_profil/', 'putusan_awal/', 'putusan_expedited/', 'putusan_fullboard/', 'monev/', 'laporan_akhir/', 'progress_protokol/');
				$group = $this->session->userdata('id_group_'.APPAUTH);

				if ($url == 'users/')
				{
					$url2 = $this->uri->slash_segment(2);
					if ($url2 != 'user_profil/' && $url2 != 'form_password/' && $url2 != 'proses_ganti_password/')
					{
		        show_error('Anda tidak memiliki akses ke halaman ini.');
					}
				}
				else
				{
					switch ($group) {
						case 1: if (!in_array($url, $pages1)){
							        show_error('Anda tidak memiliki akses ke halaman ini.');
										}
								break;
						case 2: if (!in_array($url, $pages2)){
							        show_error('Anda tidak memiliki akses ke halaman ini.');
										}
								break;
						case 3: if (!in_array($url, $pages3)){
							        show_error('Anda tidak memiliki akses ke halaman ini.');
										}
								break;
						case 4: if (!in_array($url, $pages4)){
							        show_error('Anda tidak memiliki akses ke halaman ini.');
										}
								break;
						case 5: if (!in_array($url, $pages5)){
							        show_error('Anda tidak memiliki akses ke halaman ini.');
										}
								break;
						case 6: if (!in_array($url, $pages6)){
							        show_error('Anda tidak memiliki akses ke halaman ini.');
										}
								break;
						case 7: if (!in_array($url, $pages7)){
							        show_error('Anda tidak memiliki akses ke halaman ini.');
										}
								break;
						case 8: if (!in_array($url, $pages8)){
							        show_error('Anda tidak memiliki akses ke halaman ini.');
										}
								break;
					}
				}

			}

		}

  }

}