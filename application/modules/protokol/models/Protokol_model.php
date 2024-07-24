<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Protokol_model extends Core_Model {

  var $fieldmap_filter;
	var $data_lampiran;
	var $purge_lampiran;
	var $purge_filename;

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
      'tgl_protokol' => 'date(e.inserted)',
    );

	}

	public function fill_data()
	{
		$id = $this->input->post('id') ? $this->input->post('id') : 0;
		$id_pengajuan = $this->input->post('id_pengajuan') ? $this->input->post('id_pengajuan') : 0;
		$judul = $this->input->post('judul') ? $this->input->post('judul') : '';
		$tempat = $this->input->post('lokasi') ? $this->input->post('lokasi') : '';
	  $is_multi_senter = $this->input->post('is_multi_senter') ? $this->input->post('is_multi_senter') : '';
	  $is_setuju_senter = $this->input->post('is_setuju_senter') ? $this->input->post('is_setuju_senter') : '';
		$client_name = $this->input->post('client_name') ? $this->input->post('client_name') : '';
		$file_name = $this->input->post('file_name') ? $this->input->post('file_name') : '';
		$file_size = $this->input->post('file_size') ? $this->input->post('file_size') : '';
		$file_type = $this->input->post('file_type') ? $this->input->post('file_type') : '';
		$file_ext = $this->input->post('file_ext') ? $this->input->post('file_ext') : '';
		$link_proposal = $this->input->post('link_proposal') ? $this->input->post('link_proposal') : '';

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
      'link_proposal' => $link_proposal
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

	}

	public function save_detail()
	{
		$this->insert_pep();
		$this->insert_lampiran();
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

  public function get_data_jqgrid($param, $isCount=FALSE, $CompileOnly=False)
  {
    $this->db->select('e.id_pep, p.id_pengajuan, p.no_protokol, p.judul, p.waktu_mulai, p.waktu_selesai, p.inserted as tanggal_pengajuan, k.nama_kepk, e.inserted as tanggal_protokol');
    $this->db->from('tb_pengajuan as p');
    $this->db->join('tb_kepk as k', 'k.id_kepk = p.id_kepk');
    $this->db->join('tb_pep as e', 'e.id_pengajuan = p.id_pengajuan');
    $this->db->where('p.id_pengusul', $this->session->userdata('id_pengusul'));
    $this->db->where('e.revisi_ke', 0);
    $this->db->order_by('e.inserted desc');

    // proses parameter pencarian, jika ada
    if (isset($param['_search']) && $param['_search'] == 'true' )
    {
      $fld = $param['search_fld'];
      switch($fld){
        case 'tgl_pengajuan': $str = prepare_date($param['search_str']); break;
        case 'mulai': $str = prepare_date($param['search_str']); break;
        case 'selesai': $str = prepare_date($param['search_str']); break;
        case 'tgl_protokol': $str = prepare_date($param['search_str']); break;
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
		$this->db->select('e.*, p.no_protokol, p.judul, p.tempat_penelitian, p.is_multi_senter, p.is_setuju_senter');
		$this->db->from('tb_pep as e');
		$this->db->join('tb_pengajuan as p', 'p.id_pengajuan = e.id_pengajuan');
		$this->db->where('e.id_pep', $id);
		$result = $this->db->get()->row_array();

		return $result;
	}

	function get_data_lampiran_by_id($id)
	{
		$this->db->select('l.*');
		$this->db->from('tb_lampiran_pep as l');
		$this->db->where('l.id_pep', $id);
		$result = $this->db->get()->result_array();

		return $result;
	}

	function get_data_pengajuan()
	{
		$this->db->select('p.id_pengajuan, p.no_protokol, p.judul, p.tempat_penelitian, p.is_multi_senter, p.is_setuju_senter');
		$this->db->from('tb_pengajuan as p');
		$this->db->where('p.id_pengusul', $this->session->userdata('id_pengusul'));
		$this->db->where('p.id_pengajuan not in (select e.id_pengajuan from tb_pep as e)');
		$result = $this->db->get()->result_array();

		return $result;
	}

  function get_data_klasifikasi_putusan_by_id_pengajuan($id_pengajuan)
  {
    $this->db->select('max(e.id_pep) as id_pep');
    $this->db->from('tb_pep as e');
    $this->db->where('e.id_pengajuan', $id_pengajuan);
    $rs = $this->db->get()->row_array();
    $id_pep = isset($rs['id_pep']) ? $rs['id_pep'] : 0;

    $this->db->select("
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
      end as keputusan
    ");
    $this->db->from('tb_kirim_surat_ke_peneliti as kr');
    $this->db->where('kr.id_pep', $id_pep);
    $result = $this->db->get()->row_array();

    return $result;
  }

	function check_is_resume($id)
	{
		$this->db->select('1')->from('tb_resume')->where('id_pep', $id);
		$rs = $this->db->get()->row_array();
		
		if ($rs)
			return 1;

		return 0;
	}

	function check_exist_data($id)
	{
		$this->db->select('1')->from('tb_self_assesment_cek as sac')
				->join('tb_pep as e', 'e.id_pengajuan = sac.id_pengajuan')
				->where('e.id_pep', $id);
		$rs = $this->db->get()->row_array();

		if ($rs)
			return TRUE;

		return FALSE;
	}

	function delete_detail($id)
	{
		$this->delete_lampiran($id);
		$this->delete_pep($id);
	}

	function delete_pep($id)
	{
		$this->db->where('id_pep', $id);
		$this->db->delete('tb_pep');
	}

	function delete_lampiran($id)
	{
		$this->db->where('id_pep', $id);
		$this->db->delete('tb_lampiran_pep');
	}

}
