<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perbaikan_model extends Core_Model {

  var $fieldmap_filter;
	var $data_lampiran;
  var $data_sac;
  var $data_detail_sac;
  var $id_sac;
	var $purge_lampiran;
	var $purge_filename;

	public function __construct()
	{
		parent::__construct();

    $this->fieldmap_filter = array(
      'no_protokol' => 'p.no_protokol',
      'judul' => 'p.judul', 
      'tgl_pengajuan' =>  'date(p.inserted)',
      'kepk' => 'k.nama_kepk',
      'mulai' => 'date(p.waktu_mulai)',
      'selesai' => 'date(p.waktu_selesai)',
      'tgl_perbaikan' => 'date(e.inserted)',
      'revisi_ke' => 'e.revisi_ke'
    );

	}

 	public function fill_data()
	{
		$id = $this->input->post('id') ? $this->input->post('id') : 0;
		$id_pengajuan = $this->input->post('id_pengajuan') ? $this->input->post('id_pengajuan') : 0;
		$client_name = $this->input->post('client_name') ? $this->input->post('client_name') : '';
		$file_name = $this->input->post('file_name') ? $this->input->post('file_name') : '';
		$file_size = $this->input->post('file_size') ? $this->input->post('file_size') : '';
		$file_type = $this->input->post('file_type') ? $this->input->post('file_type') : '';
		$file_ext = $this->input->post('file_ext') ? $this->input->post('file_ext') : '';
		$link_proposal = $this->input->post('link_proposal') ? $this->input->post('link_proposal') : '';
		$id_old = $this->input->post('id_old') ? $this->input->post('id_old') : 0;
    $revisi_ke = $this->get_revisi_ke($id_old)+1;

	  $remove_str = array("\n", "\r\n", "\r");
	  $id_pepk = $this->input->post('id_pepk') ? $this->input->post('id_pepk') : 0;
	  $uraianc1 = $this->input->post('uraianc1') ? addslashes(str_replace($remove_str, ' ', $this->input->post('uraianc1'))) : '';
	  $uraianc2 = $this->input->post('uraianc2') ? addslashes(str_replace($remove_str, ' ', $this->input->post('uraianc2'))) : '';
	  $uraiand1 = $this->input->post('uraiand1') ? addslashes(str_replace($remove_str, ' ', $this->input->post('uraiand1'))) : '';
	  $uraiane1 = $this->input->post('uraiane1') ? addslashes(str_replace($remove_str, ' ', $this->input->post('uraiane1'))) : '';
	  $uraianf1 = $this->input->post('uraianf1') ? addslashes(str_replace($remove_str, ' ', $this->input->post('uraianf1'))) : '';
	  $uraianf2 = $this->input->post('uraianf2') ? addslashes(str_replace($remove_str, ' ', $this->input->post('uraianf2'))) : '';
	  $uraianf3 = $this->input->post('uraianf3') ? addslashes(str_replace($remove_str, ' ', $this->input->post('uraianf3'))) : '';
	  $uraiang1 = $this->input->post('uraiang1') ? addslashes(str_replace($remove_str, ' ', $this->input->post('uraiang1'))) : '';
	  $uraiang2 = $this->input->post('uraiang2') ? addslashes(str_replace($remove_str, ' ', $this->input->post('uraiang2'))) : '';
	  $uraiang3 = $this->input->post('uraiang3') ? addslashes(str_replace($remove_str, ' ', $this->input->post('uraiang3'))) : '';
	  $uraianh1 = $this->input->post('uraianh1') ? addslashes(str_replace($remove_str, ' ', $this->input->post('uraianh1'))) : '';
	  $uraianh2 = $this->input->post('uraianh2') ? addslashes(str_replace($remove_str, ' ', $this->input->post('uraianh2'))) : '';
	  $uraianh3 = $this->input->post('uraianh3') ? addslashes(str_replace($remove_str, ' ', $this->input->post('uraianh3'))) : '';
	  $uraiani1 = $this->input->post('uraiani1') ? addslashes(str_replace($remove_str, ' ', $this->input->post('uraiani1'))) : '';
	  $uraiani2 = $this->input->post('uraiani2') ? addslashes(str_replace($remove_str, ' ', $this->input->post('uraiani2'))) : '';
	  $uraiani3 = $this->input->post('uraiani3') ? addslashes(str_replace($remove_str, ' ', $this->input->post('uraiani3'))) : '';
	  $uraiani4 = $this->input->post('uraiani4') ? addslashes(str_replace($remove_str, ' ', $this->input->post('uraiani4'))) : '';
	  $uraianj1 = $this->input->post('uraianj1') ? addslashes(str_replace($remove_str, ' ', $this->input->post('uraianj1'))) : '';
	  $uraiank1 = $this->input->post('uraiank1') ? addslashes(str_replace($remove_str, ' ', $this->input->post('uraiank1'))) : '';
	  $uraianl1 = $this->input->post('uraianl1') ? addslashes(str_replace($remove_str, ' ', $this->input->post('uraianl1'))) : '';
	  $uraianl2 = $this->input->post('uraianl2') ? addslashes(str_replace($remove_str, ' ', $this->input->post('uraianl2'))) : '';
	  $uraianm1 = $this->input->post('uraianm1') ? addslashes(str_replace($remove_str, ' ', $this->input->post('uraianm1'))) : '';
	  $uraiann1 = $this->input->post('uraiann1') ? addslashes(str_replace($remove_str, ' ', $this->input->post('uraiann1'))) : '';
	  $uraiann2 = $this->input->post('uraiann2') ? addslashes(str_replace($remove_str, ' ', $this->input->post('uraiann2'))) : '';
	  $uraiano1 = $this->input->post('uraiano1') ? addslashes(str_replace($remove_str, ' ', $this->input->post('uraiano1'))) : '';
	  $uraianp1 = $this->input->post('uraianp1') ? addslashes(str_replace($remove_str, ' ', $this->input->post('uraianp1'))) : '';
	  $uraianp2 = $this->input->post('uraianp2') ? addslashes(str_replace($remove_str, ' ', $this->input->post('uraianp2'))) : '';
	  $uraianq1 = $this->input->post('uraianq1') ? addslashes(str_replace($remove_str, ' ', $this->input->post('uraianq1'))) : '';
	  $uraianq2 = $this->input->post('uraianq2') ? addslashes(str_replace($remove_str, ' ', $this->input->post('uraianq2'))) : '';
	  $uraianr1 = $this->input->post('uraianr1') ? addslashes(str_replace($remove_str, ' ', $this->input->post('uraianr1'))) : '';
	  $uraianr2 = $this->input->post('uraianr2') ? addslashes(str_replace($remove_str, ' ', $this->input->post('uraianr2'))) : '';
	  $uraianr3 = $this->input->post('uraianr3') ? addslashes(str_replace($remove_str, ' ', $this->input->post('uraianr3'))) : '';
	  $uraians1 = $this->input->post('uraians1') ? addslashes(str_replace($remove_str, ' ', $this->input->post('uraians1'))) : '';
	  $uraians2 = $this->input->post('uraians2') ? addslashes(str_replace($remove_str, ' ', $this->input->post('uraians2'))) : '';
	  $uraians3 = $this->input->post('uraians3') ? addslashes(str_replace($remove_str, ' ', $this->input->post('uraians3'))) : '';
	  $uraians4 = $this->input->post('uraians4') ? addslashes(str_replace($remove_str, ' ', $this->input->post('uraians4'))) : '';
	  $uraiant1 = $this->input->post('uraiant1') ? addslashes(str_replace($remove_str, ' ', $this->input->post('uraiant1'))) : '';
	  $uraianu1 = $this->input->post('uraianu1') ? addslashes(str_replace($remove_str, ' ', $this->input->post('uraianu1'))) : '';
	  $uraianv1 = $this->input->post('uraianv1') ? addslashes(str_replace($remove_str, ' ', $this->input->post('uraianv1'))) : '';
	  $uraianw1 = $this->input->post('uraianw1') ? addslashes(str_replace($remove_str, ' ', $this->input->post('uraianw1'))) : '';
	  $uraianw2 = $this->input->post('uraianw2') ? addslashes(str_replace($remove_str, ' ', $this->input->post('uraianw2'))) : '';
	  $uraianx1 = $this->input->post('uraianx1') ? addslashes(str_replace($remove_str, ' ', $this->input->post('uraianx1'))) : '';
	  $uraiany1 = $this->input->post('uraiany1') ? addslashes(str_replace($remove_str, ' ', $this->input->post('uraiany1'))) : '';
	  $uraiany2 = $this->input->post('uraiany2') ? addslashes(str_replace($remove_str, ' ', $this->input->post('uraiany2'))) : '';
	  $uraianz1 = $this->input->post('uraianz1') ? addslashes(str_replace($remove_str, ' ', $this->input->post('uraianz1'))) : '';
	  $uraianaa1 = $this->input->post('uraianaa1') ? addslashes(str_replace($remove_str, ' ', $this->input->post('uraianaa1'))) : '';
	  $uraianaa2 = $this->input->post('uraianaa2') ? addslashes(str_replace($remove_str, ' ', $this->input->post('uraianaa2'))) : '';
	  $uraianaa3 = $this->input->post('uraianaa3') ? addslashes(str_replace($remove_str, ' ', $this->input->post('uraianaa3'))) : '';
	  $uraianbb1 = $this->input->post('uraianbb1') ? addslashes(str_replace($remove_str, ' ', $this->input->post('uraianbb1'))) : '';

	  $this->data = array(
	  	'id_pep' => $id,
	  	'id_pengajuan' => $id_pengajuan,
	  	'uraianc1' => $uraianc1,
	  	'uraianc2' => $uraianc2,
	  	'uraiand1' => $uraiand1,
		  'uraiane1' =>	$uraiane1,
		  'uraianf1' => $uraianf1,
			'uraianf2' => $uraianf2,
			'uraianf3' => $uraianf3,
			'uraiang1' => $uraiang1,
			'uraiang2' => $uraiang2,
			'uraiang3' => $uraiang3,
			'uraianh1' => $uraianh1,
			'uraianh2' => $uraianh2,
			'uraianh3' => $uraianh3,
			'uraiani1' => $uraiani1,
	  	'uraiani2' =>	$uraiani2,
	  	'uraiani3' => $uraiani3,
	  	'uraiani4' => $uraiani4,
			'uraianj1' => $uraianj1,
			'uraiank1' => $uraiank1,
			'uraianl1' => $uraianl1,
			'uraianl2' => $uraianl2,
			'uraianm1' => $uraianm1,
			'uraiann1' => $uraiann1,
			'uraiann2' => $uraiann2,
			'uraiano1' => $uraiano1,
			'uraianp1' => $uraianp1,
			'uraianp2' => $uraianp2,
			'uraianq1' => $uraianq1,
			'uraianq2' => $uraianq2,
			'uraianr1' => $uraianr1,
			'uraianr2' => $uraianr2,
			'uraianr3' => $uraianr3,
			'uraians1' => $uraians1,
			'uraians2' => $uraians2,
			'uraians3' => $uraians3,
			'uraians4' => $uraians4,
			'uraiant1' => $uraiant1,
			'uraianu1' => $uraianu1,
			'uraianv1' => $uraianv1,
			'uraianw1' => $uraianw1,
			'uraianw2' => $uraianw2,
			'uraianx1' => $uraianx1,
			'uraiany1' => $uraiany1,
			'uraiany2' => $uraiany2,
			'uraianz1' => $uraianz1,
			'uraianaa1' => $uraianaa1,
			'uraianaa2' => $uraianaa2,
			'uraianaa3' => $uraianaa3,
			'uraianbb1' =>  $uraianbb1,
			'client_name' => $client_name,
			'file_name' => $file_name,
			'file_size' => $file_size,
			'file_type' => $file_type,
			'file_ext' => $file_ext,
      'link_proposal' => $link_proposal,
			'revisi_ke' => $revisi_ke,
			'id_pep_old' => $id_old
	  );

	  $lampiran1 = $this->input->post('lampiran1') ? $this->input->post('lampiran1') : '';
	  if ($lampiran1)
	  {
		  for ($i=0; $i<count($lampiran1); $i++)
		  {
		  	$id_lampiran = $lampiran1[$i]['id'] ? $lampiran1[$i]['id'] : 0;
		  	$client_name = $lampiran1[$i]['client_name'] ? $lampiran1[$i]['client_name'] : '';
		  	$file_name = $lampiran1[$i]['file_name'] ? $lampiran1[$i]['file_name'] : '';
		  	$file_size = $lampiran1[$i]['file_size'] ? $lampiran1[$i]['file_size'] : '';
		  	$file_type = $lampiran1[$i]['file_type'] ? $lampiran1[$i]['file_type'] : '';
		  	$lampiran = 1;

		  	$this->data_lampiran[] = array('id_lampiran_pep' => $id_lampiran, 'client_name' => $client_name, 'file_name' => $file_name, 'file_size' => $file_size, 'file_type' => $file_type, 'file_ext' => $file_ext, 'lampiran' => $lampiran);
		  }
		}

	  $lampiran2 = $this->input->post('lampiran2') ? $this->input->post('lampiran2') : '';
	  if ($lampiran2)
	  {
		  for ($i=0; $i<count($lampiran2); $i++)
		  {
		  	$id_lampiran = $lampiran2[$i]['id'] ? $lampiran2[$i]['id'] : 0;
		  	$client_name = $lampiran2[$i]['client_name'] ? $lampiran2[$i]['client_name'] : '';
		  	$file_name = $lampiran2[$i]['file_name'] ? $lampiran2[$i]['file_name'] : '';
		  	$file_size = $lampiran2[$i]['file_size'] ? $lampiran2[$i]['file_size'] : '';
		  	$file_type = $lampiran2[$i]['file_type'] ? $lampiran2[$i]['file_type'] : '';
		  	$lampiran = 2;

		  	$this->data_lampiran[] = array('id_lampiran_pep' => $id_lampiran, 'client_name' => $client_name, 'file_name' => $file_name, 'file_size' => $file_size, 'file_type' => $file_type, 'file_ext' => $file_ext, 'lampiran' => $lampiran);
		  }
		}

	  $lampiran3 = $this->input->post('lampiran3') ? $this->input->post('lampiran3') : '';
	  if ($lampiran3)
	  {
		  for ($i=0; $i<count($lampiran3); $i++)
		  {
		  	$id_lampiran = $lampiran3[$i]['id'] ? $lampiran3[$i]['id'] : 0;
		  	$client_name = $lampiran3[$i]['client_name'] ? $lampiran3[$i]['client_name'] : '';
		  	$file_name = $lampiran3[$i]['file_name'] ? $lampiran3[$i]['file_name'] : '';
		  	$file_size = $lampiran3[$i]['file_size'] ? $lampiran3[$i]['file_size'] : '';
		  	$file_type = $lampiran3[$i]['file_type'] ? $lampiran3[$i]['file_type'] : '';
		  	$lampiran = 3;

		  	$this->data_lampiran[] = array('id_lampiran_pep' => $id_lampiran, 'client_name' => $client_name, 'file_name' => $file_name, 'file_size' => $file_size, 'file_type' => $file_type, 'file_ext' => $file_ext, 'lampiran' => $lampiran);
		  }
		}

	  $lampiran4 = $this->input->post('lampiran4') ? $this->input->post('lampiran4') : '';
	  if ($lampiran4)
	  {
		  for ($i=0; $i<count($lampiran4); $i++)
		  {
		  	$id_lampiran = $lampiran4[$i]['id'] ? $lampiran4[$i]['id'] : 0;
		  	$client_name = $lampiran4[$i]['client_name'] ? $lampiran4[$i]['client_name'] : '';
		  	$file_name = $lampiran4[$i]['file_name'] ? $lampiran4[$i]['file_name'] : '';
		  	$file_size = $lampiran4[$i]['file_size'] ? $lampiran4[$i]['file_size'] : '';
		  	$file_type = $lampiran4[$i]['file_type'] ? $lampiran4[$i]['file_type'] : '';
		  	$lampiran = 4;

		  	$this->data_lampiran[] = array('id_lampiran_pep' => $id_lampiran, 'client_name' => $client_name, 'file_name' => $file_name, 'file_size' => $file_size, 'file_type' => $file_type, 'file_ext' => $file_ext, 'lampiran' => $lampiran);
		  }
		}

	  $lampiran5 = $this->input->post('lampiran5') ? $this->input->post('lampiran5') : '';
	  if ($lampiran5)
	  {
		  for ($i=0; $i<count($lampiran5); $i++)
		  {
		  	$id_lampiran = $lampiran5[$i]['id'] ? $lampiran5[$i]['id'] : 0;
		  	$client_name = $lampiran5[$i]['client_name'] ? $lampiran5[$i]['client_name'] : '';
		  	$file_name = $lampiran5[$i]['file_name'] ? $lampiran5[$i]['file_name'] : '';
		  	$file_size = $lampiran5[$i]['file_size'] ? $lampiran5[$i]['file_size'] : '';
		  	$file_type = $lampiran5[$i]['file_type'] ? $lampiran5[$i]['file_type'] : '';
		  	$lampiran = 5;

		  	$this->data_lampiran[] = array('id_lampiran_pep' => $id_lampiran, 'client_name' => $client_name, 'file_name' => $file_name, 'file_size' => $file_size, 'file_type' => $file_type, 'file_ext' => $file_ext, 'lampiran' => $lampiran);
		  }
		}

	  $lampiran6 = $this->input->post('lampiran6') ? $this->input->post('lampiran6') : '';
	  if ($lampiran6)
	  {
		  for ($i=0; $i<count($lampiran6); $i++)
		  {
		  	$id_lampiran = $lampiran6[$i]['id'] ? $lampiran6[$i]['id'] : 0;
		  	$client_name = $lampiran6[$i]['client_name'] ? $lampiran6[$i]['client_name'] : '';
		  	$file_name = $lampiran6[$i]['file_name'] ? $lampiran6[$i]['file_name'] : '';
		  	$file_size = $lampiran6[$i]['file_size'] ? $lampiran6[$i]['file_size'] : '';
		  	$file_type = $lampiran6[$i]['file_type'] ? $lampiran6[$i]['file_type'] : '';
		  	$lampiran = 6;

		  	$this->data_lampiran[] = array('id_lampiran_pep' => $id_lampiran, 'client_name' => $client_name, 'file_name' => $file_name, 'file_size' => $file_size, 'file_type' => $file_type, 'file_ext' => $file_ext, 'lampiran' => $lampiran);
		  }
		}

    $purge_lampiran1 = $this->input->post('purge_lampiran1') ? $this->input->post('purge_lampiran1') : '';
    $purge_lampiran2 = $this->input->post('purge_lampiran2') ? $this->input->post('purge_lampiran2') : '';
    $purge_lampiran3 = $this->input->post('purge_lampiran3') ? $this->input->post('purge_lampiran3') : '';
    $purge_lampiran4 = $this->input->post('purge_lampiran4') ? $this->input->post('purge_lampiran4') : '';
    $purge_lampiran5 = $this->input->post('purge_lampiran5') ? $this->input->post('purge_lampiran5') : '';
    $purge_lampiran6 = $this->input->post('purge_lampiran6') ? $this->input->post('purge_lampiran6') : '';

    $this->purge_lampiran = array();

    if ($purge_lampiran1) $this->purge_lampiran = array_merge($this->purge_lampiran, $purge_lampiran1);
    if ($purge_lampiran2) $this->purge_lampiran = array_merge($this->purge_lampiran, $purge_lampiran2);
    if ($purge_lampiran3) $this->purge_lampiran = array_merge($this->purge_lampiran, $purge_lampiran3);
    if ($purge_lampiran4) $this->purge_lampiran = array_merge($this->purge_lampiran, $purge_lampiran4);
    if ($purge_lampiran5) $this->purge_lampiran = array_merge($this->purge_lampiran, $purge_lampiran5);
    if ($purge_lampiran6) $this->purge_lampiran = array_merge($this->purge_lampiran, $purge_lampiran6);

    $purge_filename1 = $this->input->post('purge_filename1') ? $this->input->post('purge_filename1') : '';
    $purge_filename2 = $this->input->post('purge_filename2') ? $this->input->post('purge_filename2') : '';
    $purge_filename3 = $this->input->post('purge_filename3') ? $this->input->post('purge_filename3') : '';
    $purge_filename4 = $this->input->post('purge_filename4') ? $this->input->post('purge_filename4') : '';
    $purge_filename5 = $this->input->post('purge_filename5') ? $this->input->post('purge_filename5') : '';
    $purge_filename6 = $this->input->post('purge_filename6') ? $this->input->post('purge_filename6') : '';

    $this->purge_filename = array();

    if ($purge_filename1) array_merge($this->purge_filename, $purge_filename1);
    if ($purge_filename2) array_merge($this->purge_filename, $purge_filename2);
    if ($purge_filename3) array_merge($this->purge_filename, $purge_filename3);
    if ($purge_filename4) array_merge($this->purge_filename, $purge_filename4);
    if ($purge_filename5) array_merge($this->purge_filename, $purge_filename5);
    if ($purge_filename6) array_merge($this->purge_filename, $purge_filename6);

    $id_sac = $this->input->post('id_sac') ? $this->input->post('id_sac') : '';
    $id_sac_old = $this->input->post('id_sac_old') ? $this->input->post('id_sac_old') : '';
    $justifikasi1 = $this->input->post('justifikasi1') ? $this->input->post('justifikasi1') : '';
    $justifikasi2 = $this->input->post('justifikasi2') ? $this->input->post('justifikasi2') : '';
    $justifikasi3 = $this->input->post('justifikasi3') ? $this->input->post('justifikasi3') : '';
    $justifikasi4 = $this->input->post('justifikasi4') ? $this->input->post('justifikasi4') : '';
    $justifikasi5 = $this->input->post('justifikasi5') ? $this->input->post('justifikasi5') : '';
    $justifikasi6 = $this->input->post('justifikasi6') ? $this->input->post('justifikasi6') : '';
    $justifikasi7 = $this->input->post('justifikasi7') ? $this->input->post('justifikasi7') : '';

    $this->data_sac = array(
        'id_sac' => $id_sac,
        'id_sac_old' => $id_sac_old,
        'id_pengajuan' => $id_pengajuan,
        'justifikasi1' => $justifikasi1,
        'justifikasi2' => $justifikasi2,
        'justifikasi3' => $justifikasi3,
        'justifikasi4' => $justifikasi4,
        'justifikasi5' => $justifikasi5,
        'justifikasi6' => $justifikasi6,
        'justifikasi7' => $justifikasi7,
        'revisi_ke' => $revisi_ke
    );

    $sa1 = $this->input->post('self_assesment1') ? json_decode($this->input->post('self_assesment1')) : '';
    for ($i=0; $i<count($sa1); $i++)
    {
      $id_jsk = isset($sa1[$i]->id) ? $sa1[$i]->id : 0;
      $pil = isset($sa1[$i]->pil) ? $sa1[$i]->pil : '';

      $this->data_detail_sac[] = array('id_jsk'=>$id_jsk, 'pilihan'=>$pil);
    }

    $sa2 = $this->input->post('self_assesment2') ? json_decode($this->input->post('self_assesment2')) : '';
    for ($i=0; $i<count($sa2); $i++)
    {
      $id_jsk = isset($sa2[$i]->id) ? $sa2[$i]->id : 0;
      $pil = isset($sa2[$i]->pil) ? $sa2[$i]->pil : '';

      $this->data_detail_sac[] = array('id_jsk'=>$id_jsk, 'pilihan'=>$pil);
    }

    $sa3 = $this->input->post('self_assesment3') ? json_decode($this->input->post('self_assesment3')) : '';
    for ($i=0; $i<count($sa3); $i++)
    {
      $id_jsk = isset($sa3[$i]->id) ? $sa3[$i]->id : 0;
      $pil = isset($sa3[$i]->pil) ? $sa3[$i]->pil : '';

      $this->data_detail_sac[] = array('id_jsk'=>$id_jsk, 'pilihan'=>$pil);
    }

    $sa4 = $this->input->post('self_assesment4') ? json_decode($this->input->post('self_assesment4')) : '';
    for ($i=0; $i<count($sa4); $i++)
    {
      $id_jsk = isset($sa4[$i]->id) ? $sa4[$i]->id : 0;
      $pil = isset($sa4[$i]->pil) ? $sa4[$i]->pil : '';

      $this->data_detail_sac[] = array('id_jsk'=>$id_jsk, 'pilihan'=>$pil);
    }

    $sa5 = $this->input->post('self_assesment5') ? json_decode($this->input->post('self_assesment5')) : '';
    for ($i=0; $i<count($sa5); $i++)
    {
      $id_jsk = isset($sa5[$i]->id) ? $sa5[$i]->id : 0;
      $pil = isset($sa5[$i]->pil) ? $sa5[$i]->pil : '';

      $this->data_detail_sac[] = array('id_jsk'=>$id_jsk, 'pilihan'=>$pil);
    }

    $sa6 = $this->input->post('self_assesment6') ? json_decode($this->input->post('self_assesment6')) : '';
    for ($i=0; $i<count($sa6); $i++)
    {
      $id_jsk = isset($sa6[$i]->id) ? $sa6[$i]->id : 0;
      $pil = isset($sa6[$i]->pil) ? $sa6[$i]->pil : '';

      $this->data_detail_sac[] = array('id_jsk'=>$id_jsk, 'pilihan'=>$pil);
    }

    $sa7 = $this->input->post('self_assesment7') ? json_decode($this->input->post('self_assesment7')) : '';
    for ($i=0; $i<count($sa7); $i++)
    {
      $id_jsk = isset($sa7[$i]->id) ? $sa7[$i]->id : 0;
      $pil = isset($sa7[$i]->pil) ? $sa7[$i]->pil : '';

      $this->data_detail_sac[] = array('id_jsk'=>$id_jsk, 'pilihan'=>$pil);
    }

	}

 	public function save_detail()
	{
		$this->insert_pep();
		$this->insert_lampiran();
    $this->insert_self_assesment();
    $this->insert_detail_self_assesment();
	}

 	function insert_pep()
	{
    if (isset($this->data['id_pep']) && $this->data['id_pep'] > 0)
		{
			$this->db->where('id_pep', $this->data['id_pep']);
			$this->db->update('tb_pep', $this->data);
			$this->check_trans_status('update tb_pep failed');
			$this->id = $this->data['id_pep'];
		}
		else
		{
			unset($this->data['id_pep']);
			$this->db->insert('tb_pep', $this->data);
			$this->check_trans_status('insert tb_pep failed');
			$this->id = $this->db->insert_id();
		}		
	}

	function insert_lampiran()
	{
		if ($this->purge_lampiran)
		{
			$this->db->where_in('id_lampiran_pep', $this->purge_lampiran);
			$this->db->where('id_pep', $this->id);
			$this->db->delete('tb_lampiran_pep');
			$this->check_trans_status('delete tb_lampiran_pep failed');
		}

		if ($this->purge_filename)
		{
			for ($i=0; $i<count($this->purge_filename); $i++)
			{
				unlink('./uploads/' . $this->purge_filename[$i]);
			}
		}

		if ($this->data_lampiran)
		{
			for ($i=0; $i<count($this->data_lampiran); $i++)
			{
				$this->db->select('1')->from('tb_lampiran_pep')->where('id_lampiran_pep', $this->data_lampiran[$i]['id_lampiran_pep'])->where('id_pep', $this->id);
				$rs = $this->db->get()->row_array();

				if ($rs)
				{
					$this->db->where('id_pep', $this->id);
					$this->db->where('id_lampiran_pep', $this->data_lampiran[$i]['id_lampiran_pep']);
					$this->db->update('tb_lampiran_pep', $this->data_lampiran[$i]);
					$this->check_trans_status('update tb_lampiran_pep failed');
				}
				else
				{
					unset($this->data_lampiran[$i]['id_lampiran_pep']);
					$this->data_lampiran[$i]['id_pep'] = $this->id;
					$this->db->insert('tb_lampiran_pep', $this->data_lampiran[$i]);
					$this->check_trans_status('insert tb_lampiran_pep failed');
				}
			}
		}

	}

  public function insert_self_assesment()
  {
    if (isset($this->data_sac['id_sac']) && $this->data_sac['id_sac'] > 0)
    {
      $this->db->where('id_sac', $this->data_sac['id_sac']);
      $this->db->where('id_pengajuan', $this->data_sac['id_pengajuan']);
      $this->db->update('tb_self_assesment_cek', $this->data_sac);
      $this->id_sac = $this->data_sac['id_sac'];
      $this->check_trans_status('update tb_self_assesment_cek failed');
    }
    else
    {
      $this->db->insert('tb_self_assesment_cek', $this->data_sac);
      $this->id_sac = $this->db->insert_id();
      $this->check_trans_status('insert tb_self_assesment_cek failed');
    }

  }

  public function insert_detail_self_assesment()
  {
    $data_update = array();
    $data_insert = array();
    for ($i=0; $i<count($this->data_detail_sac); $i++)
    {
      $this->db->select('id_dsac')->from('tb_detail_sa_cek')->where('id_sac', $this->id_sac)->where('id_jsk', $this->data_detail_sac[$i]['id_jsk']);
      $rs = $this->db->get()->row_array();

      if ($rs)
      {
        $data_update[] = array(
          'id_dsac' => $rs['id_dsac'],
          'id_sac' => $this->id_sac,
          'id_jsk' => $this->data_detail_sac[$i]['id_jsk'],
          'pilihan' => $this->data_detail_sac[$i]['pilihan']
        );
      }
      else
      {
        $data_insert[] = array(
          'id_sac' => $this->id_sac,
          'id_jsk' => $this->data_detail_sac[$i]['id_jsk'],
          'pilihan' => $this->data_detail_sac[$i]['pilihan']
        );
      }
    }

    if (!empty($data_update)){
      $this->db->update_batch('tb_detail_sa_cek', $data_update, 'id_dsac');
      $this->check_trans_status('update tb_detail_sa_cek failed');
    }

    if (!empty($data_insert)){
      $this->db->insert_batch('tb_detail_sa_cek', $data_insert);
      $this->check_trans_status('insert tb_detail_sa_cek failed');
    }
  }

  public function get_data_jqgrid($param, $isCount=FALSE, $CompileOnly=False)
  {
    $this->db->select('e.id_pep, e.id_pep_old, p.id_pengajuan, p.no_protokol, p.judul, p.waktu_mulai, p.waktu_selesai, p.inserted as tanggal_pengajuan, e.inserted as tanggal_perbaikan, k.nama_kepk, e.revisi_ke');
    $this->db->from('tb_pengajuan as p');
    $this->db->join('tb_kepk as k', 'k.id_kepk = p.id_kepk');
    $this->db->join('tb_pep as e', 'e.id_pengajuan = p.id_pengajuan');
    $this->db->where('e.revisi_ke >', 0);
    $this->db->where('p.id_pengusul', $this->session->userdata('id_pengusul'));

    // proses parameter pencarian, jika ada
    if (isset($param['_search']) && $param['_search'] == 'true' )
    {
      $fld = $param['search_fld'];
      switch($fld){
        case 'tgl_pengajuan': $str = prepare_date($param['search_str']); break;
        case 'mulai': $str = prepare_date($param['search_str']); break;
        case 'selesai': $str = prepare_date($param['search_str']); break;
        case 'tgl_perbaikan': $str = prepare_date($param['search_str']); break;
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

 	public function get_data_by_id_id_old($id, $id_pep_old)
	{
		$this->db->select('e.*, '.$id_pep_old.' as id_pep_old, p.no_protokol, p.judul, p.tempat_penelitian, p.is_multi_senter, p.is_setuju_senter, kr.klasifikasi');
		$this->db->from('tb_pep as e');
		$this->db->join('tb_pengajuan as p', 'p.id_pengajuan = e.id_pengajuan');

		if ($id > 0)
    {
      $this->db->join('tb_kirim_surat_ke_peneliti as kr', 'kr.id_pep = e.id_pep_old');
			$this->db->where('e.id_pep', $id);
    }
		else 
    {
      $this->db->join('tb_kirim_surat_ke_peneliti as kr', 'kr.id_pep = e.id_pep');
			$this->db->where('e.id_pep', $id_pep_old);
    }
		
		$result = $this->db->get()->row_array();

		return $result;
	}

  function get_data_sac_by_param($id, $id_pep_old, $id_pengajuan)
  {
    if ($id == 0)
    {
      $revisi_ke = $this->get_revisi_ke($id_pep_old); // diambil dari data pertama/revisi sebelumnya
  
      $this->db->select('p.no_protokol, 0 as id_sac, sac.id_sac as id_sac_old, sac.justifikasi1, sac.justifikasi2, sac.justifikasi3, sac.justifikasi4, sac.justifikasi5, sac.justifikasi6, sac.justifikasi7');
      $this->db->from('tb_self_assesment_cek as sac');
      $this->db->join('tb_pengajuan as p', 'p.id_pengajuan = sac.id_pengajuan');
      $this->db->where('sac.id_pengajuan', $id_pengajuan);
      $this->db->where('sac.revisi_ke', $revisi_ke);
    }
    else
    {
      $revisi_ke = $this->get_revisi_ke($id);
      $this->db->select('p.no_protokol, sac.id_sac, sac.id_sac_old, sac.justifikasi1, sac.justifikasi2, sac.justifikasi3, sac.justifikasi4, sac.justifikasi5, sac.justifikasi6, sac.justifikasi7');
      $this->db->from('tb_self_assesment_cek as sac');
      $this->db->join('tb_pengajuan as p', 'p.id_pengajuan = sac.id_pengajuan');
      $this->db->where('sac.id_pengajuan', $id_pengajuan);
      $this->db->where('sac.revisi_ke', $revisi_ke);
    }  
    $result = $this->db->get()->row_array();

    return $result;
  }

  function get_data_catatan_telaah_by_id_pep_old($id_pep_old, $klasifikasi)
  {
    if ($klasifikasi == 2)
    {
      $this->db->select('te.id_atk_penelaah, te.catatana, te.catatanc, te.catatand, te.catatane, te.catatanf, te.catatang, te.catatanh, te.catatani, te.catatanj, te.catatank, te.catatanl, te.catatanm, te.catatann, te.catatano, te.catatanp, te.catatanq, te.catatanr, te.catatans, te.catatant, te.catatanu, te.catatanv, te.catatanw, te.catatanx, te.catatany, te.catatanz, te.catatanaa, te.catatanbb, te.catatancc, te.catatan_link_proposal, te.catatan_sa1, te.catatan_sa2, te.catatan_sa3, te.catatan_sa4, te.catatan_sa5, te.catatan_sa6, te.catatan_sa7, te.catatan_protokol, te.catatan_7standar');
      $this->db->from('tb_telaah_expedited as te');
      $this->db->where('te.id_pep', $id_pep_old);
      $result = $this->db->get()->result_array();

      return $result;
    }
    else if ($klasifikasi == 3)
    {
      $this->db->select('tf.id_atk_penelaah, tf.catatana, tf.catatanc, tf.catatand, tf.catatane, tf.catatanf, tf.catatang, tf.catatanh, tf.catatani, tf.catatanj, tf.catatank, tf.catatanl, tf.catatanm, tf.catatann, tf.catatano, tf.catatanp, tf.catatanq, tf.catatanr, tf.catatans, tf.catatant, tf.catatanu, tf.catatanv, tf.catatanw, tf.catatanx, tf.catatany, tf.catatanz, tf.catatanaa, tf.catatanbb, tf.catatancc, tf.catatan_link_proposal, tf.catatan_sa1, tf.catatan_sa2, tf.catatan_sa3, tf.catatan_sa4, tf.catatan_sa5, tf.catatan_sa6, tf.catatan_sa7, tf.catatan_protokol, tf.catatan_7standar');
      $this->db->from('tb_telaah_fullboard as tf');
      $this->db->where('tf.id_pep', $id_pep_old);
      $result = $this->db->get()->result_array();

      return $result;
    }
    else if ($klasifikasi == 4)
    {
      $this->db->select('r.alasan_tbd');
      $this->db->from('tb_resume as r');
      $this->db->where('r.id_pep', $id_pep_old);
      $result = $this->db->get()->row_array();

      return $result;
    }

    return '';
  }

  function get_data_telaah_before($id_pep_old, $id_pengajuan, $catatan)
  {
    // id_pep u/ expedited <= krn bisa saja diambil dari exp to fb
    $query = "
        select te.id_pep, 'E' as telaah, te.id_atk_penelaah, te.".$catatan." as catatan, te.inserted
        from tb_telaah_expedited as te
        join tb_pep as e on e.id_pep = te.id_pep
        where e.id_pengajuan = ".$id_pengajuan."
            and e.id_pep <= ".$id_pep_old."

        union

        select tf.id_pep, 'FB' as telaah, tf.id_atk_penelaah, tf.".$catatan." as catatan, tf.inserted
        from tb_telaah_fullboard as tf
        join tb_pep as e on e.id_pep = tf.id_pep
        where e.id_pengajuan = ".$id_pengajuan."
            and e.id_pep < ".$id_pep_old."

        order by inserted asc
    ";
    $result = $this->db->query($query)->result_array();

    return $result;
  }

  function get_data_standar_kelaikan($id_sac)
  {
    $this->db->select("jsk.*, msk.uraian as uraian_master, dsac.pilihan");
    $this->db->from('tb_jabaran_standar_kelaikan as jsk');
    $this->db->join('tb_master_standar_kelaikan as msk', 'msk.id_msk = jsk.id_msk');
    $this->db->join('tb_detail_sa_cek as dsac', 'dsac.id_jsk = jsk.id_jsk and dsac.id_sac = '.$id_sac, 'left');
    $result = $this->db->get()->result_array();

    return $result;
  }

	function get_data_protokol()
	{
		$this->db->select('e.id_pep, p.no_protokol, p.judul, kr.inserted');
		$this->db->from('tb_pep as e');
		$this->db->join('tb_pengajuan as p', 'p.id_pengajuan = e.id_pengajuan');
		$this->db->join('tb_kirim_surat_ke_peneliti as kr', 'kr.id_pep = e.id_pep');
    $this->db->join('tb_pep as e2', 'e2.id_pep_old = e.id_pep', 'left');
		$this->db->where('p.id_pengusul', $this->session->userdata('id_pengusul'));
		$this->db->where('kr.keputusan', 'R');
    $this->db->where('e2.id_pep is null');
		$result = $this->db->get()->result_array();

		return $result;
	}

	function get_revisi_ke($id_pep_old)
	{
		$this->db->select('e.revisi_ke');
		$this->db->from('tb_pep as e');
		$this->db->where('e.id_pep', $id_pep_old);
		$result = $this->db->get()->row_array();

		return $result['revisi_ke'];
	}

	function get_data_uraian_before($id_pep, $id_pengajuan, $uraian)
	{
		$this->db->select('e.id_pep, e.'.$uraian.' as uraian, e.inserted');
		$this->db->from('tb_pep as e');
		$this->db->where('e.id_pengajuan', $id_pengajuan);

    if ($id_pep > 0)
  		$this->db->where('e.id_pep <', $id_pep);

		$this->db->order_by('e.inserted', 'asc');
		$result = $this->db->get()->result_array();

		return $result;
	}

  function get_data_justifikasi_before($id_sac, $id_pengajuan, $no)
  {
    $this->db->select('sac.id_sac, sac.justifikasi'.$no.' as justifikasi, sac.inserted');
    $this->db->from('tb_self_assesment_cek as sac');
    $this->db->where('sac.id_pengajuan', $id_pengajuan);

    if ($id_pep > 0)
      $this->db->where('sac.id_sac <', $id_sac);
  
    $this->db->order_by('sac.inserted', 'asc');
    $result = $this->db->get()->result_array();

    return $result;
  }

 	function get_data_lampiran_by_id($id, $id_pep_old)
	{
		$this->db->select('l.*');
		$this->db->from('tb_lampiran_pep as l');

		if ($id > 0)
			$this->db->where('l.id_pep', $id);
		else
			$this->db->where('l.id_pep', $id_pep_old);

		$result = $this->db->get()->result_array();

		return $result;
	}

	function kirim_data($id_pengajuan, $id_pep)
	{
    $this->db->trans_start();
    try {
    	$this->db->select('p.id_kepk, e.revisi_ke, ks.klasifikasi');
    	$this->db->from('tb_pengajuan as p');
    	$this->db->join('tb_pep as e', 'e.id_pengajuan = p.id_pengajuan');
      $this->db->join('tb_kirim_surat_ke_peneliti as ks', 'ks.id_pep = e.id_pep_old');
    	$this->db->where('p.id_pengajuan', $id_pengajuan);
    	$this->db->where('e.id_pep', $id_pep);
    	$result = $this->db->get()->row_array();

    	$this->db->select('1')->from('tb_kirim_ke_kepk')->where('id_pengajuan', $id_pengajuan)->where('id_pep', $id_pep);
    	$rs = $this->db->get()->row_array();

    	$data = array(
    		'id_pengajuan'=>$id_pengajuan,
    		'id_pep'=>$id_pep,
    		'id_kepk'=>$result['id_kepk'],
    		'revisi_ke'=>$result['revisi_ke'],
        'klasifikasi'=>$result['klasifikasi']
    	);

    	if ($rs)
    	{
    		$this->db->where('id_pep', $id_pep);
    		$this->db->where('id_pengajuan', $id_pengajuan);
    		$this->db->update('tb_kirim_ke_kepk', $data);
				$this->check_trans_status('update tb_kirim_ke_kepk failed');
    	}
    	else
    	{
				$this->db->insert('tb_kirim_ke_kepk', $data);
				$this->check_trans_status('insert tb_kirim_ke_kepk failed');
    	}

			$this->db->trans_complete();
    }
    catch(Exception $e){
      //TODO : log error to file
    }

    if ($this->db->trans_status() === FALSE)
    {
      $this->db->trans_rollback();
      return FALSE;
    }

    $this->db->trans_commit();
    return TRUE;
	}

  function check_is_kirim($id)
	{
		$this->db->select('1')->from('tb_kirim_ke_kepk as kr')->where('kr.id_pep', $id);
		$rs = $this->db->get()->row_array();

		if ($rs)
			return 1;

		return 0;
	}

  function check_is_save_sac($id_pep)
  {
    $this->db->select('1')->from('tb_self_assesment_cek as sac')
        ->join('tb_pep as e', 'e.id_pengajuan = sac.id_pengajuan')
        ->where('e.id_pep', $id_pep);
		$rs = $this->db->get()->row_array();

    if ($rs)
      return TRUE;

    return FALSE;
  }

  function get_data_uraian_harus_terisi($id_pep)
  {
    $this->db->select('
      e.uraianc1, e.uraianc2, e.uraiang1, e.uraiang2, e.uraiang3, e.uraianh1, e.uraianh2, e.uraianh3,
      e.uraiani1, e.uraiani2, e.uraiani3, e.uraiani4, e.uraianj1, e.uraiank1, e.uraianl1, e.uraianl2, 
      e.uraianm1, e.uraiann1, e.uraiann2, e.uraiano1, e.uraianp1, e.uraianp2, e.uraianr1, e.uraianr2,
      e.uraianr3, e.uraians1, e.uraians2, e.uraians3, e.uraians4, e.uraiant1, e.uraianu1, e.uraianv1,
      e.uraianw1, e.uraianw2, e.uraianx1, e.uraiany1, e.uraiany2');
    $this->db->from('tb_pep as e');
    $this->db->where('e.id_pep', $id_pep);
    $result = $this->db->get()->row_array();

    return $result;
  }

  function check_lampiran($id_pep, $lampiran)
  {
    $this->db->select('1')->from('tb_lampiran_pep')
      ->where('id_pep', $id_pep)->where('lampiran', $lampiran);
    $rs = $this->db->get()->row_array();

    if ($rs)
      return TRUE;

    return FALSE;
  }

}
