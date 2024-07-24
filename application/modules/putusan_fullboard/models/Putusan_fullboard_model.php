<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Putusan_fullboard_model extends Core_Model {

  var $fieldmap_filter;
	var $data_sa;

	public function __construct()
	{
		parent::__construct();

    $this->fieldmap_filter = array(
      'no_protokol' => 'p.no_protokol',
      'judul' => 'p.judul',
      'tgl_pengajuan' => 'date(p.inserted)',
      'tgl_perbaikan' => 'date(e.inserted)',
      'kepk' => 'k.nama_kepk',
      'revisi_ke' => 'e.revisi_ke',
      'mulai' => 'date(p.waktu_mulai)',
      'selesai' => 'date(p.waktu_selesai)',
      'tgl_putusan' => 'date(pf.inserted)',
      'keputusan' => "case pf.keputusan
                        when 'LE' then 'Layak Etik'
                        when 'R' then 'Perbaikan'
                      end"
    );
	}

	public function fill_data()
	{
	  $id = $this->input->post('id') ? $this->input->post('id') : 0;
		$id_pep = $this->input->post('id_pep') ? $this->input->post('id_pep') : 0;
		$keputusan = $this->input->post('keputusan') ? $this->input->post('keputusan') : '';		
	  $remove_str = array("\n", "\r\n", "\r");
		$ringkasan = $this->input->post('ringkasan') ? addslashes(str_replace($remove_str, ' ', $this->input->post('ringkasan'))) : '';

	  $this->data = array(
	  	'id_pfbd' => $id,
	  	'id_pep' => $id_pep,
	  	'keputusan' => $keputusan,
	  	'ringkasan' => $ringkasan
	  );

 		$sa1 = $this->input->post('self_assesment1') ? json_decode($this->input->post('self_assesment1')) : '';
 		for ($i=0; $i<count($sa1); $i++)
 		{
			$id_jsk = isset($sa1[$i]->id) ? $sa1[$i]->id : 0;
		 	$pil = isset($sa1[$i]->pil_pelapor) ? $sa1[$i]->pil_pelapor : '';
      $catatan = isset($sa1[$i]->cat_pelapor) ? $sa1[$i]->cat_pelapor : '';

		 	$this->data_sa[] = array('id_jsk'=>$id_jsk, 'pilihan'=>$pil, 'catatan'=>$catatan);
		}

 		$sa2 = $this->input->post('self_assesment2') ? json_decode($this->input->post('self_assesment2')) : '';
 		for ($i=0; $i<count($sa2); $i++)
 		{
			$id_jsk = isset($sa2[$i]->id) ? $sa2[$i]->id : 0;
		 	$pil = isset($sa2[$i]->pil_pelapor) ? $sa2[$i]->pil_pelapor : '';
      $catatan = isset($sa2[$i]->cat_pelapor) ? $sa2[$i]->cat_pelapor : '';

		 	$this->data_sa[] = array('id_jsk'=>$id_jsk, 'pilihan'=>$pil, 'catatan'=>$catatan);
		}

 		$sa3 = $this->input->post('self_assesment3') ? json_decode($this->input->post('self_assesment3')) : '';
 		for ($i=0; $i<count($sa3); $i++)
 		{
			$id_jsk = isset($sa3[$i]->id) ? $sa3[$i]->id : 0;
		 	$pil = isset($sa3[$i]->pil_pelapor) ? $sa3[$i]->pil_pelapor : '';
      $catatan = isset($sa3[$i]->cat_pelapor) ? $sa3[$i]->cat_pelapor : '';

		 	$this->data_sa[] = array('id_jsk'=>$id_jsk, 'pilihan'=>$pil, 'catatan'=>$catatan);
		}

 		$sa4 = $this->input->post('self_assesment4') ? json_decode($this->input->post('self_assesment4')) : '';
 		for ($i=0; $i<count($sa4); $i++)
 		{
			$id_jsk = isset($sa4[$i]->id) ? $sa4[$i]->id : 0;
		 	$pil = isset($sa4[$i]->pil_pelapor) ? $sa4[$i]->pil_pelapor : '';
      $catatan = isset($sa4[$i]->cat_pelapor) ? $sa4[$i]->cat_pelapor : '';

		 	$this->data_sa[] = array('id_jsk'=>$id_jsk, 'pilihan'=>$pil, 'catatan'=>$catatan);
		}

 		$sa5 = $this->input->post('self_assesment5') ? json_decode($this->input->post('self_assesment5')) : '';
 		for ($i=0; $i<count($sa5); $i++)
 		{
			$id_jsk = isset($sa5[$i]->id) ? $sa5[$i]->id : 0;
		 	$pil = isset($sa5[$i]->pil_pelapor) ? $sa5[$i]->pil_pelapor : '';
      $catatan = isset($sa5[$i]->cat_pelapor) ? $sa5[$i]->cat_pelapor : '';

		 	$this->data_sa[] = array('id_jsk'=>$id_jsk, 'pilihan'=>$pil, 'catatan'=>$catatan);
		}

 		$sa6 = $this->input->post('self_assesment6') ? json_decode($this->input->post('self_assesment6')) : '';
 		for ($i=0; $i<count($sa6); $i++)
 		{
			$id_jsk = isset($sa6[$i]->id) ? $sa6[$i]->id : 0;
		 	$pil = isset($sa6[$i]->pil_pelapor) ? $sa6[$i]->pil_pelapor : '';
      $catatan = isset($sa6[$i]->cat_pelapor) ? $sa6[$i]->cat_pelapor : '';

		 	$this->data_sa[] = array('id_jsk'=>$id_jsk, 'pilihan'=>$pil, 'catatan'=>$catatan);
		}

 		$sa7 = $this->input->post('self_assesment7') ? json_decode($this->input->post('self_assesment7')) : '';
 		for ($i=0; $i<count($sa7); $i++)
 		{
			$id_jsk = isset($sa7[$i]->id) ? $sa7[$i]->id : 0;
		 	$pil = isset($sa7[$i]->pil_pelapor) ? $sa7[$i]->pil_pelapor : '';
      $catatan = isset($sa7[$i]->cat_pelapor) ? $sa7[$i]->cat_pelapor : '';

		 	$this->data_sa[] = array('id_jsk'=>$id_jsk, 'pilihan'=>$pil, 'catatan'=>$catatan);
		}

	}

 	public function save_detail()
	{
		$this->insert_putusan_fullboard();
   
    // lampiran 7 standar hanya untuk keputusan Layak Etik
    if ($this->data['keputusan'] == 'LE')
  		$this->insert_putusan_fullboard_self_assesment();
    else
      $this->hapus_putusan_fullboard_self_assesment();
	}

	function insert_putusan_fullboard()
	{
    if ($this->session->userdata('id_group_'.APPAUTH) == 4) // as sekretaris
    {
      $id_atk_sekretaris = $this->get_id_atk($this->session->userdata('id_user_'.APPAUTH));
      $this->data['id_atk_sekretaris'] = $id_atk_sekretaris;

      $this->db->select('1')->from('tb_putusan_fullboard')
        ->where('id_pfbd', $this->data['id_pfbd'])
        ->where('id_atk_sekretaris', $id_atk_sekretaris);
      $rs = $this->db->get()->row_array();

      if ($rs)
      {
        if ($this->session->userdata('keputusan') != $this->data['keputusan'])
          $this->data['update_sekretaris'] = date('Y-m-d H:i:s');

        $aktivitas = 'Sekretaris mengubah Putusan Telaah Full Board '.$this->input->post('no_protokol');
      }
      else
      {
        $this->data['insert_sekretaris'] = date('Y-m-d H:i:s');
        $this->data['update_sekretaris'] = date('Y-m-d H:i:s');
        $aktivitas = 'Sekretaris membuat Putusan Telaah Full Board '.$this->input->post('no_protokol');
      }

      $this->db->where('id_pep', $this->data['id_pep']);
      $this->db->update('tb_putusan_fullboard', $this->data);
      $this->check_trans_status('update tb_putusan_fullboard failed');
      $this->id = $this->data['id_pfbd'];

      $id_user_kepk = $this->get_id_atk($this->session->userdata('id_user_'.APPAUTH));
      $id_user =$this->session->userdata('id_user_'.APPAUTH);
      simpan_logaktivitas_tim_kepk($aktivitas, $id_user_kepk, $id_user);
    }
    else if ($this->session->userdata('id_group_'.APPAUTH) == 6) // as pelapor
    {
      $id_atk_pelapor = $this->get_id_atk($this->session->userdata('id_user_'.APPAUTH));
      $this->data['id_atk_pelapor'] = $id_atk_pelapor;

      $this->db->select('1')->from('tb_putusan_fullboard')
        ->where('id_pep', $this->data['id_pep'])
        ->where('id_atk_pelapor', $id_atk_pelapor);
      $rs = $this->db->get()->row_array();

      if ($rs)
      {
        if ($this->session->userdata('keputusan') != $this->data['keputusan'])
          $this->data['update_pelapor'] = date('Y-m-d H:i:s');

        $this->db->where('id_atk_pelapor', $id_atk_pelapor);
        $this->db->where('id_pep', $this->data['id_pep']);
        $this->db->update('tb_putusan_fullboard', $this->data);
        $this->check_trans_status('update tb_putusan_fullboard failed');
        $this->id = $this->data['id_pfbd'];

        $aktivitas = 'Pelapor mengubah Putusan Telaah Full Board '.$this->input->post('no_protokol');
      }
      else
      {
        $this->data['insert_pelapor'] = date('Y-m-d H:i:s');
        $this->data['update_pelapor'] = date('Y-m-d H:i:s');

        unset($this->data['id_pfbd']);
        $this->db->insert('tb_putusan_fullboard', $this->data);
        $this->id = $this->db->insert_id();

        $aktivitas = 'Pelapor membuat Putusan Telaah Full Board '.$this->input->post('no_protokol');
      }

      $id_user_kepk = $this->get_id_atk($this->session->userdata('id_user_'.APPAUTH));
      $id_user =$this->session->userdata('id_user_'.APPAUTH);
      simpan_logaktivitas_tim_kepk($aktivitas, $id_user_kepk, $id_user);
    }
    else if ($this->session->userdata('id_group_'.APPAUTH) == 7) // as ketua
    {
      $id_atk_ketua = $this->get_id_atk($this->session->userdata('id_user_'.APPAUTH));
      $this->data['id_atk_ketua'] = $id_atk_ketua;

      $this->db->select('1')->from('tb_putusan_fullboard')
        ->where('id_pep', $this->data['id_pep'])
        ->where('id_atk_ketua', $id_atk_ketua);
      $rs = $this->db->get()->row_array();

      if ($rs)
      {
        if ($this->session->userdata('keputusan') != $this->data['keputusan'])
          $this->data['update_ketua'] = date('Y-m-d H:i:s');
  
        $aktivitas = 'Ketua mengubah Putusan Telaah Full Board '.$this->input->post('no_protokol');
      }
      else
      {
        $this->data['insert_ketua'] = date('Y-m-d H:i:s');
        $this->data['update_ketua'] = date('Y-m-d H:i:s');
        $aktivitas = 'Ketua membuat Putusan Telaah Full Board '.$this->input->post('no_protokol');
      }

      $this->db->where('id_pep', $this->data['id_pep']);
      $this->db->update('tb_putusan_fullboard', $this->data);
      $this->check_trans_status('update tb_putusan_fullboard failed');
      $this->id = $this->data['id_pfbd'];
  
      $id_user_kepk = $this->get_id_atk($this->session->userdata('id_user_'.APPAUTH));
      $id_user =$this->session->userdata('id_user_'.APPAUTH);
      simpan_logaktivitas_tim_kepk($aktivitas, $id_user_kepk, $id_user);
    }
    else if ($this->session->userdata('id_group_'.APPAUTH) == 8) // as wakil ketua
    {
      $id_atk_wakil_ketua = $this->get_id_atk($this->session->userdata('id_user_'.APPAUTH));
      $this->data['id_atk_wakil_ketua'] = $id_atk_wakil_ketua;

      $this->db->select('1')->from('tb_putusan_fullboard')
        ->where('id_pep', $this->data['id_pep'])
        ->where('id_atk_wakil_ketua', $id_atk_wakil_ketua);
      $rs = $this->db->get()->row_array();

      if ($rs)
      {
        if ($this->session->userdata('keputusan') != $this->data['keputusan'])
          $this->data['update_wakil_ketua'] = date('Y-m-d H:i:s');
  
        $aktivitas = 'Wakil Ketua mengubah Putusan Telaah Full Board '.$this->input->post('no_protokol');
      }
      else
      {
        $this->data['insert_wakil_ketua'] = date('Y-m-d H:i:s');
        $this->data['update_wakil_ketua'] = date('Y-m-d H:i:s');
        $aktivitas = 'Wakil Ketua membuat Putusan Telaah Full Board '.$this->input->post('no_protokol');
      }

      $this->db->where('id_pep', $this->data['id_pep']);
      $this->db->update('tb_putusan_fullboard', $this->data);
      $this->check_trans_status('update tb_putusan_fullboard failed');
      $this->id = $this->data['id_pfbd'];
  
      $id_user_kepk = $this->get_id_atk($this->session->userdata('id_user_'.APPAUTH));
      $id_user =$this->session->userdata('id_user_'.APPAUTH);
      simpan_logaktivitas_tim_kepk($aktivitas, $id_user_kepk, $id_user);
		}

    $this->session->set_userdata(array('keputusan'=>$this->data['keputusan'])); // menyimpan hasil keputusan terbaru ke dalam session
	}

 	function insert_putusan_fullboard_self_assesment()
	{
    $data_update = array();
    $data_insert = array();
		for ($i=0; $i<count($this->data_sa); $i++)
		{
			$this->db->select('id_pfsa')->from('tb_putusan_fullboard_self_assesment')->where('id_pfbd', $this->id)->where('id_jsk', $this->data_sa[$i]['id_jsk']);
			$rs = $this->db->get()->row_array();

			if ($rs)
			{
        $data_update[] = array(
          'id_pfsa' => $rs['id_pfsa'],
          'id_pfbd' => $this->id,
          'id_jsk' => $this->data_sa[$i]['id_jsk'],
          'pilihan' => $this->data_sa[$i]['pilihan'],
          'catatan' => $this->data_sa[$i]['catatan']
        );
			}
			else
			{
        $data_insert[] = array(
          'id_pfbd' => $this->id,
          'id_jsk' => $this->data_sa[$i]['id_jsk'],
          'pilihan' => $this->data_sa[$i]['pilihan'],
          'catatan' => $this->data_sa[$i]['catatan']
        );
			}
		}

    if (!empty($data_update)){
      $this->db->update_batch('tb_putusan_fullboard_self_assesment', $data_update, 'id_pfsa');
      $this->check_trans_status('update tb_putusan_fullboard_self_assesment failed');
    }

    if (!empty($data_insert)){
      $this->db->insert_batch('tb_putusan_fullboard_self_assesment', $data_insert);
      $this->check_trans_status('insert tb_putusan_fullboard_self_assesment failed');
    }
	}

  function hapus_putusan_fullboard_self_assesment()
  {
    $this->db->where('id_pfbd', $this->id);
    $this->db->delete('tb_putusan_fullboard_self_assesment');
    $this->check_trans_status('delete tb_putusan_fullboard_self_assesment failed');
  }

	function kirim_data($id_pep, $keputusan, $no_protokol)
	{
    $this->db->trans_start();
    try {

			$id_atk = $this->get_id_atk($this->session->userdata('id_user_'.APPAUTH));

    	if ($this->session->userdata('id_group_'.APPAUTH) == 4) // as sekretaris
    	{
	    	$this->db->select('1')->from('tb_kirim_putusan_ke_ketua')
          ->where('id_pep', $id_pep)
          ->where('klasifikasi = 3')
          ->where('id_atk_sekretaris', $id_atk); // proses insert dari pelapor
	    	$rs = $this->db->get()->row_array();

        // cukup update karena dari pelapor proses insertnya
	    	if ($rs)
	    	{
          $data = array(
            'id_pep'=>$id_pep, 
            'id_kepk'=>$this->session->userdata('id_kepk_tim'),
            'id_atk_sekretaris'=>$id_atk,
            'klasifikasi'=>3,
            'keputusan'=>$keputusan
          );
	    	}
	    	else
	    	{
          $data = array(
            'id_pep'=>$id_pep, 
            'id_kepk'=>$this->session->userdata('id_kepk_tim'),
            'id_atk_sekretaris'=>$id_atk,
            'insert_sekretaris'=>date('Y-m-d H:i:s'),
            'klasifikasi'=>3,
            'keputusan'=>$keputusan
          );
	    	}

        $this->db->where('klasifikasi = 3');
        $this->db->where('id_pep', $id_pep);
        $this->db->update('tb_kirim_putusan_ke_ketua', $data);
        $this->check_trans_status('update tb_kirim_putusan_ke_ketua failed');

				$aktivitas = 'Sekretaris mengirim Putusan Telaah Full Board Protokol '.$no_protokol.' ke Ketua';
				$id_user_kepk = $id_atk;
				$id_user =$this->session->userdata('id_user_'.APPAUTH);
				simpan_logaktivitas_tim_kepk($aktivitas, $id_user_kepk, $id_user);
    	}
    	else if ($this->session->userdata('id_group_'.APPAUTH) == 6) // as pelapor (mengirim ke sekretaris & juga ketua)
    	{
    		$this->db->select('1')->from('tb_kirim_putusan_ke_sekretaris')->where('id_pep', $id_pep)->where('klasifikasi = 3');
    		$rs = $this->db->get()->row_array();

	    	$data = array(
	    		'id_pep'=>$id_pep, 
	    		'id_kepk'=>$this->session->userdata('id_kepk_tim'),
	    		'id_atk_pelapor'=>$id_atk,
	    		'klasifikasi'=>3,
	    		'keputusan'=>$keputusan
	    	);

    		if ($rs)
    		{
          $this->db->where('klasifikasi = 3');
    			$this->db->where('id_pep', $id_pep);
    			$this->db->update('tb_kirim_putusan_ke_sekretaris', $data);
					$this->check_trans_status('update tb_kirim_putusan_ke_sekretaris failed');
    		}
    		else
    		{
    			$this->db->insert('tb_kirim_putusan_ke_sekretaris', $data);
					$this->check_trans_status('insert tb_kirim_putusan_ke_sekretaris failed');
    		}

				$aktivitas = 'Pelapor mengirim Putusan Telaah Full Board Protokol '.$no_protokol.' ke Sekretaris';
				$id_user_kepk = $id_atk;
				$id_user =$this->session->userdata('id_user_'.APPAUTH);
				simpan_logaktivitas_tim_kepk($aktivitas, $id_user_kepk, $id_user);

	    	$this->db->select('1')->from('tb_kirim_putusan_ke_ketua')->where('id_pep', $id_pep)->where('klasifikasi = 3');
	    	$rs = $this->db->get()->row_array();

	    	$data = array(
	    		'id_pep'=>$id_pep, 
	    		'id_kepk'=>$this->session->userdata('id_kepk_tim'),
	    		'id_atk_pelapor'=>$id_atk,
	    		'klasifikasi'=>3,
	    		'keputusan'=>$keputusan
	    	);

	    	if ($rs)
	    	{
          $this->db->where('klasifikasi = 3');
	    		$this->db->where('id_pep', $id_pep);
	    		$this->db->update('tb_kirim_putusan_ke_ketua', $data);
					$this->check_trans_status('update tb_kirim_putusan_ke_ketua failed');
	    	}
	    	else
	    	{
          $data['insert_pelapor'] = date('Y-m-d H:i:s');
					$this->db->insert('tb_kirim_putusan_ke_ketua', $data);
					$this->check_trans_status('insert tb_kirim_putusan_ke_ketua failed');
	    	}

				$aktivitas = 'Pelapor mengirim Putusan Telaah Full Board Protokol '.$no_protokol.' ke Ketua';
				$id_user_kepk = $id_atk;
				$id_user =$this->session->userdata('id_user_'.APPAUTH);
				simpan_logaktivitas_tim_kepk($aktivitas, $id_user_kepk, $id_user);        
    	}
    	else if ($this->session->userdata('id_group_'.APPAUTH) == 7) // as ketua
    	{
	    	$this->db->select('1')->from('tb_kirim_putusan_ke_sekretariat')->where('id_pep', $id_pep)->where('klasifikasi = 3');
	    	$rs = $this->db->get()->row_array();

	    	$data = array(
	    		'id_pep'=>$id_pep, 
	    		'id_kepk'=>$this->session->userdata('id_kepk_tim'),
	    		'id_atk_ketua'=>$id_atk,
	    		'klasifikasi'=>3,
	    		'keputusan'=>$keputusan
	    	);

	    	if ($rs)
	    	{
          $this->db->where('klasifikasi = 3');
	    		$this->db->where('id_pep', $id_pep);
	    		$this->db->update('tb_kirim_putusan_ke_sekretariat', $data);
					$this->check_trans_status('update tb_kirim_putusan_ke_sekretariat failed');
	    	}
	    	else
	    	{
					$this->db->insert('tb_kirim_putusan_ke_sekretariat', $data);
					$this->check_trans_status('insert tb_kirim_putusan_ke_sekretariat failed');
	    	}

				$aktivitas = 'Ketua mengirim Putusan Telaah Full Board Protokol '.$no_protokol.' ke Kesekretariatan';
				$id_user_kepk = $id_atk;
				$id_user =$this->session->userdata('id_user_'.APPAUTH);
				simpan_logaktivitas_tim_kepk($aktivitas, $id_user_kepk, $id_user);
    	}
    	else if ($this->session->userdata('id_group_'.APPAUTH) == 8) // as wakil ketua
    	{
	    	$this->db->select('1')->from('tb_kirim_putusan_ke_sekretariat')->where('id_pep', $id_pep)->where('klasifikasi = 3');
	    	$rs = $this->db->get()->row_array();

	    	$data = array(
	    		'id_pep'=>$id_pep, 
	    		'id_kepk'=>$this->session->userdata('id_kepk_tim'),
	    		'id_atk_wakil_ketua'=>$id_atk,
	    		'klasifikasi'=>3,
	    		'keputusan'=>$keputusan
	    	);

	    	if ($rs)
	    	{
          $this->db->where('klasifikasi = 3');
	    		$this->db->where('id_pep', $id_pep);
	    		$this->db->update('tb_kirim_putusan_ke_sekretariat', $data);
					$this->check_trans_status('update tb_kirim_putusan_ke_sekretariat failed');
	    	}
	    	else
	    	{
					$this->db->insert('tb_kirim_putusan_ke_sekretariat', $data);
					$this->check_trans_status('insert tb_kirim_putusan_ke_sekretariat failed');
	    	}

				$aktivitas = 'Wakil Ketua mengirim Putusan Telaah Full Board Protokol '.$no_protokol.' ke Kesekretariatan';
				$id_user_kepk = $id_atk;
				$id_user =$this->session->userdata('id_user_'.APPAUTH);
				simpan_logaktivitas_tim_kepk($aktivitas, $id_user_kepk, $id_user);
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
    $id_atk = $this->get_id_atk($this->session->userdata('id_user_'.APPAUTH));

    $this->db->select("
        pf.id_pfbd,
        pf.id_pep,
        p.no_protokol, 
        p.judul, 
        p.waktu_mulai, 
        p.waktu_selesai, 
        p.inserted as tanggal_pengajuan, 
        k.nama_kepk, 
        case pf.keputusan
          when 'LE' then 'Layak Etik'
          when 'R' then 'Perbaikan'
        end as keputusan,
        pf.inserted as tanggal_putusan,
        e.inserted as tanggal_protokol,
        e.revisi_ke
      ");
    $this->db->from('tb_putusan_fullboard as pf');
    $this->db->join('tb_pep as e', 'e.id_pep = pf.id_pep');
    $this->db->join('tb_pengajuan as p', 'p.id_pengajuan = e.id_pengajuan');
    $this->db->join('tb_kepk as k', 'k.id_kepk = p.id_kepk');

    if ($this->session->userdata('id_group_'.APPAUTH) == 4){ // as sekretaris
      $this->db->where("pf.id_atk_sekretaris = ".$id_atk);
    }
    else if ($this->session->userdata('id_group_'.APPAUTH) == 6){ // as pelapor
      $this->db->where('pf.id_atk_pelapor', $id_atk);
    }
    else if ($this->session->userdata('id_group_'.APPAUTH) == 7){ // as ketua
      $this->db->where('pf.id_atk_ketua', $id_atk);
    }
    else if ($this->session->userdata('id_group_'.APPAUTH) == 8){ // as wakil ketua
      $this->db->where('pf.id_atk_wakil_ketua', $id_atk);
    }

    // proses parameter pencarian, jika ada
    if (isset($param['_search']) && $param['_search'] == 'true' )
    {
      $fld = $param['search_fld'];
      switch($fld){
        case 'tgl_pengajuan': $str = prepare_date($param['search_str']); break;
        case 'tgl_perbaikan': $str = prepare_date($param['search_str']); break;
        case 'mulai': $str = prepare_date($param['search_str']); break;
        case 'selesai': $str = prepare_date($param['search_str']); break;
        case 'tgl_putusan': $str = prepare_date($param['search_str']); break;
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

  function get_data_pemberitahuan_fullboard_by_idpep($id_pep)
  {
    $this->db->select('pf.tgl_fullboard, pf.jam_fullboard, pf.tempat_fullboard');
    $this->db->from('tb_pemberitahuan_fullboard as pf');
    $this->db->where('pf.id_pep', $id_pep);
    $result = $this->db->get()->row_array();

    return $result;
  }

 	function get_data_by_id($id)
	{
		$this->db->select('pf.id_pfbd, pf.id_atk_sekretaris, pf.id_atk_ketua, pf.id_atk_wakil_ketua, pf.ringkasan, pf.keputusan');
		$this->db->from('tb_putusan_fullboard as pf');
		$this->db->where('pf.id_pfbd', $id);
		$result = $this->db->get()->row_array();

		return $result;
	}

	function get_data_protokol()
	{
    if ($this->session->userdata('id_group_'.APPAUTH) == 4)
    {
      $this->db->select('pf.id_pfbd, e.id_pep, p.no_protokol, p.judul, pf.inserted, e.revisi_ke');
      $this->db->from('tb_putusan_fullboard as pf');
      $this->db->join('tb_pep as e', 'e.id_pep = pf.id_pep');
      $this->db->join('tb_pengajuan as p', 'p.id_pengajuan = e.id_pengajuan');
      $this->db->join('tb_kepk as k', 'k.id_kepk = p.id_kepk');
      $this->db->join('tb_kirim_putusan_ke_sekretaris as kr', 'kr.id_pep = pf.id_pep');
      $this->db->where('p.id_kepk', $this->session->userdata('id_kepk_tim'));
      $this->db->where('pf.id_atk_sekretaris = 0');
      $this->db->where('pf.id_atk_ketua = 0'); // jika sudah dibuat keputusan oleh ketua maka sekretaris tidak bisa lagi memproses
      $this->db->where('pf.id_atk_wakil_ketua = 0'); // jika sudah dibuat keputusan oleh waketua maka sekretaris tidak bisa lagi memproses
      $this->db->where('kr.klasifikasi = 3');

      $result = $this->db->get()->result_array();
    }
    else if ($this->session->userdata('id_group_'.APPAUTH) == 6)
    {
  		$id_atk_pelapor = $this->get_id_atk($this->session->userdata('id_user_'.APPAUTH));

  		$query = "
  			select e.id_pep, p.no_protokol, p.judul, pa.inserted, e.revisi_ke
  			from tb_pep as e
  			join tb_pengajuan as p on p.id_pengajuan = e.id_pengajuan
  			join tb_putusan_awal as pa on pa.id_pep = e.id_pep
        join tb_telaah_fullboard as tf on tf.id_pep = e.id_pep
        left join tb_putusan_fullboard as pf on pf.id_pep = e.id_pep and pf.id_atk_pelapor = ".$id_atk_pelapor."
  			where p.id_kepk = ".$this->session->userdata('id_kepk_tim')."
  				and pa.klasifikasi = 3
          and pa.id_atk_pelapor = ".$id_atk_pelapor."
          and pf.id_pfbd is null

  			union 

        select e.id_pep, p.no_protokol, p.judul, paef.inserted, e.revisi_ke
        from tb_pep as e
        join tb_pengajuan as p on p.id_pengajuan = e.id_pengajuan
        join tb_putusan_awal_expedited_to_fullboard as paef on paef.id_pep = e.id_pep
        join tb_telaah_fullboard as tf on tf.id_pep = e.id_pep
        left join tb_putusan_fullboard as pf on pf.id_pep = e.id_pep and pf.id_atk_pelapor = ".$id_atk_pelapor."
        where p.id_kepk = ".$this->session->userdata('id_kepk_tim')."
          and paef.klasifikasi = 3
          and paef.id_atk_pelapor = ".$id_atk_pelapor."
          and pf.id_pfbd is null

        union 

  			select e.id_pep, p.no_protokol, p.judul, x.inserted, e.revisi_ke
  			from tb_pep as e
  			join tb_pengajuan as p on p.id_pengajuan = e.id_pengajuan
  			join (
  			  select e2.id_pengajuan, pa2.inserted, pa2.id_atk_pelapor from tb_pep as e2
  			  join tb_putusan_awal as pa2 on pa2.id_pep = e2.id_pep
  			  where pa2.klasifikasi = 3
  			) as x on x.id_pengajuan = e.id_pengajuan
        join tb_telaah_fullboard as tf on tf.id_pep = e.id_pep
        left join tb_putusan_fullboard as pf on pf.id_pep = e.id_pep and pf.id_atk_pelapor = ".$id_atk_pelapor."
  			where p.id_kepk = ".$this->session->userdata('id_kepk_tim')."
          and x.id_atk_pelapor = ".$id_atk_pelapor."
          and pf.id_pfbd is null
  				and e.revisi_ke > 0

        union 

        select e.id_pep, p.no_protokol, p.judul, x.inserted, e.revisi_ke
        from tb_pep as e
        join tb_pengajuan as p on p.id_pengajuan = e.id_pengajuan
        join (
          select e2.id_pengajuan, paef2.inserted, paef2.id_atk_pelapor from tb_pep as e2
          join tb_putusan_awal_expedited_to_fullboard as paef2 on paef2.id_pep = e2.id_pep
          where paef2.klasifikasi = 3
        ) as x on x.id_pengajuan = e.id_pengajuan
        join tb_telaah_fullboard as tf on tf.id_pep = e.id_pep
        left join tb_putusan_fullboard as pf on pf.id_pep = e.id_pep and pf.id_atk_pelapor = ".$id_atk_pelapor."
        where p.id_kepk = ".$this->session->userdata('id_kepk_tim')."
          and x.id_atk_pelapor = ".$id_atk_pelapor."
          and pf.id_pfbd is null
          and e.revisi_ke > 0
  		";
  
      $result = $this->db->query($query)->result_array();
    }
    else if ($this->session->userdata('id_group_'.APPAUTH) == 7 || $this->session->userdata('id_group_'.APPAUTH) == 8)
		{
      $this->db->select('pf.id_pfbd, e.id_pep, p.no_protokol, p.judul, pf.inserted, e.revisi_ke');
      $this->db->from('tb_putusan_fullboard as pf');
      $this->db->join('tb_pep as e', 'e.id_pep = pf.id_pep');
      $this->db->join('tb_pengajuan as p', 'p.id_pengajuan = e.id_pengajuan');
      $this->db->join('tb_kepk as k', 'k.id_kepk = p.id_kepk');
      $this->db->join('tb_kirim_putusan_ke_ketua as kr', 'kr.id_pep = pf.id_pep');
      $this->db->where('p.id_kepk', $this->session->userdata('id_kepk_tim'));
      $this->db->where('pf.id_atk_ketua = 0');
      $this->db->where('pf.id_atk_wakil_ketua = 0');
      $this->db->where('kr.klasifikasi = 3');

      $result = $this->db->get()->result_array();
		}

		return $result;
	}

	public function get_data_pengajuan_by_idpep($id_pep)
	{
		$this->db->select('p.id_pengajuan, p.no_protokol, p.judul, p.nama_ketua, p.tempat_penelitian, p.is_multi_senter, p.is_setuju_senter, e.revisi_ke');
		$this->db->from('tb_pengajuan as p');
		$this->db->join('tb_pep as e', 'e.id_pengajuan = p.id_pengajuan');
		$this->db->where('e.id_pep', $id_pep);
		$result = $this->db->get()->row_array();

		return $result;
	}

 	public function get_data_telaah_fullboard_by_idpep($id_pep)
	{
		$this->db->select('tf.id_tfbd, tf.kelayakan, tf.catatana, tf.catatanc, tf.catatand, tf.catatane, tf.catatanf, tf.catatang, tf.catatanh, tf.catatani, tf.catatanj, tf.catatank, tf.catatanl, tf.catatanm, tf.catatann, tf.catatano, tf.catatanp, tf.catatanq, tf.catatanr, tf.catatans, tf.catatant, tf.catatanu, tf.catatanv, tf.catatanw, tf.catatanx, tf.catatany, tf.catatanz, tf.catatanaa, tf.catatanbb, tf.catatancc, tf.catatan_link_proposal, tf.catatan_protokol, tf.catatan_sa1, tf.catatan_sa2, tf.catatan_sa3, tf.catatan_sa4, tf.catatan_sa5, tf.catatan_sa6, tf.catatan_sa7, tf.catatan_7standar, a.nama, a.nomor');
		$this->db->from('tb_telaah_fullboard as tf');
		$this->db->join('tb_anggota_tim_kepk as a', 'a.id_atk = tf.id_atk_penelaah');
		$this->db->where('tf.id_pep', $id_pep);
		$result = $this->db->get()->result_array();

		return $result;
	}

	function get_data_telaah_before($id_pep, $id_pengajuan, $catatan, $id_penelaah)
  {
    // id_pep u/ expedited <= krn bisa saja diambil dari exp to fb
    $query = "
        select 
          te.id_pep, 
          case te.kelayakan
            when 'LE' then 'Layak Etik'
            when 'R' then 'Perbaikan'
            when 'F' then 'Full Board'
          end as kelayakan, 
          te.".$catatan." as catatan, te.catatan_protokol, te.catatan_7standar, te.inserted
        from tb_telaah_expedited as te
        join tb_pep as e on e.id_pep = te.id_pep
        where e.id_pengajuan = ".$id_pengajuan."
            and e.id_pep <= ".$id_pep."
            and te.id_atk_penelaah = ".$id_penelaah."

        union

        select 
          tf.id_pep, 
          case tf.kelayakan
            when 'LE' then 'Layak Etik'
            when 'R' then 'Perbaikan'
          end as kelayakan, 
          tf.".$catatan." as catatan, tf.catatan_protokol, tf.catatan_7standar, tf.inserted
        from tb_telaah_fullboard as tf
        join tb_pep as e on e.id_pep = tf.id_pep
        where e.id_pengajuan = ".$id_pengajuan."
            and e.id_pep < ".$id_pep."
            and tf.id_atk_penelaah = ".$id_penelaah."

        order by inserted asc
    ";
    $result = $this->db->query($query)->result_array();

    return $result;
  }

	public function get_data_standar_kelaikan($id, $id_pep)
	{
		$id_atk_pelapor = $this->get_id_atk($this->session->userdata('id_user_'.APPAUTH));

		$this->db->select('e.id_pengajuan, e.revisi_ke');
		$this->db->from('tb_pep as e');
		$this->db->where('e.id_pep', $id_pep);
		$rs = $this->db->get()->row_array();
		$id_pengajuan = $rs['id_pengajuan'];
    $revisi_ke = $rs['revisi_ke'];

		$this->db->select("jsk.*, msk.uraian as uraian_master, dsac.pilihan as pilihan_pengaju, pfsa.pilihan as pilihan_pelapor, pfsa.catatan");
		$this->db->from('tb_jabaran_standar_kelaikan as jsk');
		$this->db->join('tb_master_standar_kelaikan as msk', 'msk.id_msk = jsk.id_msk');
		$this->db->join('tb_detail_sa_cek as dsac', 'dsac.id_jsk = jsk.id_jsk');
		$this->db->join('tb_self_assesment_cek as sac', 'sac.id_sac = dsac.id_sac and sac.id_pengajuan = '.$id_pengajuan.' and sac.revisi_ke = '.$revisi_ke);
		$this->db->join('tb_putusan_fullboard_self_assesment as pfsa', 'pfsa.id_jsk = jsk.id_jsk and pfsa.id_pfbd = '.$id, 'left');
		$result = $this->db->get()->result_array();

		return $result;
	}

  function get_data_telaah_fullboard_by_id_tfbd($id_tfbd)
  {
		$this->db->select('t.kelayakan, t.catatan_protokol, t.catatan_7standar, atk.nama as nama_penelaah');
		$this->db->from('tb_telaah_fullboard as t');
    $this->db->join('tb_anggota_tim_kepk as atk', 'atk.id_atk = t.id_atk_penelaah');
		$this->db->where('t.id_tfbd', $id_tfbd);
		$result = $this->db->get()->row_array();

		return $result;
  }

  function check_is_kirim($id_pep)
	{
		if ($this->session->userdata('id_group_'.APPAUTH) == 6)
		{
			$this->db->select('1')->from('tb_kirim_putusan_ke_sekretaris as kr')
          ->where('kr.klasifikasi = 3')
					->where('kr.id_pep', $id_pep);
		}
		else if ($this->session->userdata('id_group_'.APPAUTH) == 4)
		{
			$this->db->select('1')->from('tb_kirim_putusan_ke_ketua as kr')
          ->where('kr.klasifikasi = 3')
          ->where('kr.id_atk_sekretaris > 0')
					->where('kr.id_pep', $id_pep);
		}
		else if ($this->session->userdata('id_group_'.APPAUTH) == 7 || $this->session->userdata('id_group_'.APPAUTH) == 8)
		{
			$this->db->select('1')->from('tb_kirim_putusan_ke_sekretariat as kr')
          ->where('kr.klasifikasi = 3')
					->where('kr.id_pep', $id_pep);
		}

		$rs = $this->db->get()->row_array();

		if ($rs)
			return 1;

		return 0;
	}

	function check_is_save($id_pep)
	{
		if ($this->session->userdata('id_group_'.APPAUTH) == 6)
		{
			$id_atk_pelapor = $this->get_id_atk($this->session->userdata('id_user_'.APPAUTH));
			$this->db->select('1')->from('tb_putusan_fullboard')
					->where('id_pep', $id_pep)
					->where('id_atk_pelapor', $id_atk_pelapor);
		}
		else if ($this->session->userdata('id_group_'.APPAUTH) == 4)
		{
			$id_atk_sekretaris = $this->get_id_atk($this->session->userdata('id_user_'.APPAUTH));
			$this->db->select('1')->from('tb_putusan_fullboard')
					->where('id_pep', $id_pep)
					->where('id_atk_sekretaris', $id_atk_sekretaris);
		}
		else if ($this->session->userdata('id_group_'.APPAUTH) == 7)
		{
			$id_atk_ketua = $this->get_id_atk($this->session->userdata('id_user_'.APPAUTH));
			$this->db->select('1')->from('tb_putusan_fullboard')
					->where('id_pep', $id_pep)
					->where('id_atk_ketua', $id_atk_ketua);
		}
		else if ($this->session->userdata('id_group_'.APPAUTH) == 8)
		{
			$id_atk_wakil_ketua = $this->get_id_atk($this->session->userdata('id_user_'.APPAUTH));
			$this->db->select('1')->from('tb_putusan_fullboard')
					->where('id_pep', $id_pep)
					->where('id_atk_wakil_ketua', $id_atk_wakil_ketua);
		}

		$rs = $this->db->get()->row_array();

		if ($rs)
			return TRUE;

		return FALSE;
	}

  function check_is_save_ketua_waketua($id_pep)
  {
    if ($this->session->userdata('id_group_'.APPAUTH) == 4)
    {
      $this->db->select('id_atk_ketua, id_atk_wakil_ketua')->from('tb_putusan_fullboard')
        ->where('id_pep', $id_pep);
      $rs = $this->db->get()->row_array();

      if ($rs)
      {
        if ($rs['id_atk_ketua'] > 0)
          return 'Ketua';
        else if ($rs['id_atk_wakil_ketua'] > 0)
          return 'Wakil Ketua';
        else
          return '';
      }
      else
        return '';
    }
    else if ($this->session->userdata('id_group_'.APPAUTH) == 7)
    {
      $this->db->select('1')->from('tb_putusan_fullboard')
        ->where('id_atk_wakil_ketua > 0')
        ->where('id_pep', $id_pep);
      $rs = $this->db->get()->row_array();

      if ($rs)
          return 'Wakil Ketua';
      else
        return '';
    }
    else if ($this->session->userdata('id_group_'.APPAUTH) == 8)
    {
      $this->db->select('1')->from('tb_putusan_fullboard')
        ->where('id_atk_ketua > 0')
        ->where('id_pep', $id_pep);
      $rs = $this->db->get()->row_array();

      if ($rs)
          return 'Ketua';
      else
        return '';
    }
  }

/*	public function check_exist_data($id)
	{
		$this->db->select('s.id_atk');
		$this->db->from('tb_struktur_tim_kepk as s');
		$this->db->where('s.id_tim_kepk', $id);
		$result = $this->db->get()->result_array();

		if ($result)
		{
			for ($i=0; $i<count($result); $i++)
			{
				return $this->check_exist_data_atk($result[$i]['id_atk']);
			}
		}
		else return FALSE;
	}*/

}
