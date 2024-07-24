<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Struktur_tim_model extends Core_Model {

  var $data_import;
  var $data_stk_old;
	var $data_struktur;
	var $data_user;
  var $jml_data;
  var $jml_insert;
  var $jml_update;
  var $arr_id_timkep;
  var $id_timkep_del;
  var $purge_waketua;
	var $purge_sekretaris;
	var $purge_kesekretariatan;
	var $purge_penelaah;
	var $purge_lay_person;
	var $purge_konsultan;

	public function __construct()
	{
		parent::__construct();

    $this->fieldmap_filter = array(
      'id' => 't.id_tim_kepk',
      'aktif_kepk' => "case k.aktif
                        when 1 then 'Ya'
                        when 0 then 'Tidak'
                      end",
      'aktif_tim_kepk' => "case t.aktif
                            when 1 then 'Ya'
                            when 0 then 'Tidak'
                          end", 
      'ketua' => '(select a.nama from tb_anggota_tim_kepk as a join tb_struktur_tim_kepk as s on s.id_atk = a.id_atk where a.id_kepk = t.id_kepk and s.id_tim_kepk = t.id_tim_kepk and s.jabatan = 1)'
    );
	}

  function fill_data_import($data)
  {
    for($i=0; $i<count($data); $i++)
    {
      $this->data_import[$data[$i]->id_timkep]['id_kepk'] = $this->session->userdata('id_kepk');
      $this->data_import[$data[$i]->id_timkep]['periode_awal'] = $data[$i]->periode_awal;
      $this->data_import[$data[$i]->id_timkep]['periode_akhir'] = $data[$i]->periode_akhir;
      $this->data_import[$data[$i]->id_timkep]['aktif'] = $data[$i]->aktif;

      if ($data[$i]->jabatan == 1)
        $this->data_import[$data[$i]->id_timkep]['ketua'][] = $data[$i]->nomor_anggota;
      else if ($data[$i]->jabatan == 2)
        $this->data_import[$data[$i]->id_timkep]['waketua'][] = $data[$i]->nomor_anggota;
      else if ($data[$i]->jabatan == 3)
        $this->data_import[$data[$i]->id_timkep]['sekretaris'][] = $data[$i]->nomor_anggota;
      else if ($data[$i]->jabatan == 4)
        $this->data_import[$data[$i]->id_timkep]['kesekretariatan'][] = $data[$i]->nomor_anggota;
      else if ($data[$i]->jabatan == 5)
        $this->data_import[$data[$i]->id_timkep]['penelaah'][] = $data[$i]->nomor_anggota;
      else if ($data[$i]->jabatan == 6)
        $this->data_import[$data[$i]->id_timkep]['lay_person'][] = $data[$i]->nomor_anggota;
      else if ($data[$i]->jabatan == 7)
        $this->data_import[$data[$i]->id_timkep]['konsultan'][] = $data[$i]->nomor_anggota;

    }
  }

  function fill_data_stk_old()
  {
    $data_stk_old = $this->get_data_struktur_tim_kepk();

    if (count($data_stk_old) > 0)
    {
      for ($i=0; $i<count($data_stk_old); $i++)
      {
        $this->data_stk_old[$data_stk_old[$i]['id_timkep_pusat']]['id_kepk'] = $this->session->userdata('id_kepk');
        $this->data_stk_old[$data_stk_old[$i]['id_timkep_pusat']]['periode_awal'] = $data_stk_old[$i]['periode_awal'];
        $this->data_stk_old[$data_stk_old[$i]['id_timkep_pusat']]['periode_akhir'] = $data_stk_old[$i]['periode_akhir'];

        if ($data_stk_old[$i]['jabatan'] == 1)
          $this->data_stk_old[$data_stk_old[$i]['id_timkep_pusat']]['ketua'][] = $data_stk_old[$i]['nomor'];
        else if ($data_stk_old[$i]['jabatan'] == 2)
          $this->data_stk_old[$data_stk_old[$i]['id_timkep_pusat']]['waketua'][] = $data_stk_old[$i]['nomor'];
        else if ($data_stk_old[$i]['jabatan'] == 3)
          $this->data_stk_old[$data_stk_old[$i]['id_timkep_pusat']]['sekretaris'][] = $data_stk_old[$i]['nomor'];
        else if ($data_stk_old[$i]['jabatan'] == 4)
          $this->data_stk_old[$data_stk_old[$i]['id_timkep_pusat']]['kesekretariatan'][] = $data_stk_old[$i]['nomor'];
        else if ($data_stk_old[$i]['jabatan'] == 5)
          $this->data_stk_old[$data_stk_old[$i]['id_timkep_pusat']]['penelaah'][] = $data_stk_old[$i]['nomor'];
        else if ($data_stk_old[$i]['jabatan'] == 6)
          $this->data_stk_old[$data_stk_old[$i]['id_timkep_pusat']]['lay_person'][] = $data_stk_old[$i]['nomor'];
        else if ($data_stk_old[$i]['jabatan'] == 7)
          $this->data_stk_old[$data_stk_old[$i]['id_timkep_pusat']]['konsultan'][] = $data_stk_old[$i]['nomor'];

      }

      // get purge

      foreach ($this->data_stk_old as $key=>$value)
      {
        if (isset($value['waketua']) && count($value['waketua']) > 0)
        {
          // wakil ketua
          for ($i=0; $i<count($value['waketua']); $i++)
          {
            if (!in_array($value['waketua'][$i], $this->data_import[$key]['waketua']))
              $this->purge_waketua[$key][] = $value['waketua'][$i];
          }
        }

        if (isset($value['sekretaris']) && count($value['sekretaris']) > 0)
        {
          // sekretaris
          for ($i=0; $i<count($value['sekretaris']); $i++)
          {
            if (!in_array($value['sekretaris'][$i], $this->data_import[$key]['sekretaris']))
              $this->purge_sekretaris[$key][] = $value['sekretaris'][$i];
          }
        }

        if (isset($value['kesekretariatan']) && count($value['kesekretariatan']) > 0)
        {
          // kesekretariatan
          for ($i=0; $i<count($value['kesekretariatan']); $i++)
          {
            if (!in_array($value['kesekretariatan'][$i], $this->data_import[$key]['kesekretariatan']))
              $this->purge_kesekretariatan[$key][] = $value['kesekretariatan'][$i];
          }
        }

        if (isset($value['penelaah']) && count($value['penelaah']) > 0)
        {
          // penelaah
          for ($i=0; $i<count($value['penelaah']); $i++)
          {
            if (!in_array($value['penelaah'][$i], $this->data_import[$key]['penelaah']))
              $this->purge_penelaah[$key][] = $value['penelaah'][$i];
          }
        }

        if (isset($value['lay_person']) && count($value['lay_person']) > 0)
        {
          // lay_person
          for ($i=0; $i<count($value['lay_person']); $i++)
          {
            if (!in_array($value['lay_person'][$i], $this->data_import[$key]['lay_person']))
              $this->purge_lay_person[$key][] = $value['lay_person'][$i];
          }
        }

        if (isset($value['konsultan']) && count($value['konsultan']) > 0)
        {
          // konsultan
          for ($i=0; $i<count($value['konsultan']); $i++)
          {
            if (!in_array($value['konsultan'][$i], $this->data_import[$key]['konsultan']))
              $this->purge_konsultan[$key][] = $value['konsultan'][$i];
          }
        }

      }

    }
  }

  function save_detail()
  {
    $this->jml_data = 0;
    $this->jml_insert = 0;
    $this->jml_update = 0;
    $this->arr_id_timkep = array();
    foreach($this->data_import as $key=>$value)
    {
      $this->db->select('id_tim_kepk')->from('tb_tim_kepk')->where('id_timkep_pusat', $key);
      $rs = $this->db->get()->row_array();

      if ($rs)
      {
        $update = array(
          'id_timkep_pusat' => $key,
          'id_kepk' => $value['id_kepk'],
          'periode_awal' => $value['periode_awal'],
          'periode_akhir' => $value['periode_akhir'],
          'aktif' => $value['aktif']
        );

        $this->db->where('id_timkep_pusat', $key);
        $this->db->update('tb_tim_kepk', $update);
        $this->check_trans_status('update tb_tim_kepk failed');
        $id_tk = $rs['id_tim_kepk'];

        $this->jml_update++;

        if (isset($value['ketua']) && count($value['ketua']) > 0)
        {
          $ketua_old = isset($this->data_stk_old[$key]['ketua'][0]) ? $this->data_stk_old[$key]['ketua'][0] : 0;
          if ($value['ketua'][0] != $ketua_old) // jika ketua diganti maka diubah
          {
            // get data ketua baru
            $nomor = $value['ketua'][0];
            $this->db->select('id_atk, nama, email')->from('tb_anggota_tim_kepk')->where('nomor', $nomor);
            $rs1a = $this->db->get()->row_array();

            if ($rs1a)
            {
              // get id_stk
              $this->db->select('id_stk')->from('tb_struktur_tim_kepk')->where('id_tim_kepk', $id_tk)->where('jabatan', 1);
              $rs1b = $this->db->get()->row_array();
              $id_stk1 = $rs1b['id_stk'];

              if ($rs1b)
              {
                // update tb_struktur_tim_kepk
                $update1a = array('id_atk' => $rs1a['id_atk']);
                $this->db->where('id_stk', $id_stk1);
                $this->db->update('tb_struktur_tim_kepk', $update1a);
                $this->check_trans_status('update tb_struktur_tim_kepk failed');

                // update tb_users, username = password = nomor
                $update1b = array(
                  'nama' => $rs1a['nama'], 
                  'username' => $nomor, 
                  'password' => md5($nomor), 
                  'email' => $rs1a['email'], 
                  'id_group' => 7,
                  'id_kepk' => $value['id_kepk'],
                  'id_stk' => $id_stk1,
                  'aktif' => 1
                );
                $this->db->where('id_stk', $id_stk1);
                $this->db->update('tb_users', $update1b);
                $this->check_trans_status('update tb_users failed');
              }
              else
              {
                $insert1a = array('id_tim_kepk' => $id_tk, 'id_atk' => $rs1a['id_atk'], 'jabatan' => 1);
                $this->db->insert('tb_struktur_tim_kepk', $insert1a);
                $this->check_trans_status('insert tb_struktur_tim_kepk failed');
                $id_stk1 = $this->db->insert_id();

                $insert1b = array(
                  'nama' => $rs1a['nama'], 
                  'username' => $nomor, 
                  'password' => md5($nomor), 
                  'email' => $rs1a['email'], 
                  'id_group' => 7,
                  'id_kepk' => $value['id_kepk'],
                  'id_stk' => $id_stk1,
                  'aktif' => 1
                );
                $this->db->insert('tb_users', $insert1b);
                $this->check_trans_status('insert tb_users failed');
              }
            }
          }
        }

        if (isset($value['waketua']) && count($value['waketua']) > 0)
        {
          $waketua_old = isset($this->data_stk_old[$key]['waketua']) ? $this->data_stk_old[$key]['waketua'] : array();
          // wakil ketua
          for ($b=0; $b<count($value['waketua']); $b++)
          {
            $nomor = $value['waketua'][$b];
            $this->db->select('id_atk, nama, email')->from('tb_anggota_tim_kepk')->where('nomor', $nomor);
            $rs2a = $this->db->get()->row_array();

            if (in_array($value['waketua'][$b], $waketua_old))
            {
              // get id_stk
              $this->db->select('id_stk')->from('tb_struktur_tim_kepk')->where('id_tim_kepk', $id_tk)->where('id_atk', $rs2a['id_atk'])->where('jabatan', 2);
              $rs2b = $this->db->get()->row_array();
              $id_stk2 = $rs2b['id_stk'];

              $update2a = array(
                'nama' => $rs2a['nama'], 
                'username' => $nomor, 
                'password' => md5($nomor), 
                'email' => $rs2a['email'], 
                'id_group' => 8,
                'id_kepk' => $value['id_kepk'],
                'id_stk' => $id_stk2,
                'aktif' => 1
              );
              $this->db->where('id_stk', $id_stk2);
              $this->db->update('tb_users', $update2a);
              $this->check_trans_status('update tb_users failed');
            }
            else
            {
              if (isset($rs2a['id_atk']))
              {
                $insert2a = array('id_tim_kepk' => $id_tk, 'id_atk' => $rs2a['id_atk'], 'jabatan' => 2);
                $this->db->insert('tb_struktur_tim_kepk', $insert2a);
                $this->check_trans_status('insert tb_struktur_tim_kepk failed');
                $id_stk2 = $this->db->insert_id();

                $insert2b = array(
                  'nama' => $rs2a['nama'], 
                  'username' => $nomor, 
                  'password' => md5($nomor), 
                  'email' => $rs2a['email'], 
                  'id_group' => 8,
                  'id_kepk' => $value['id_kepk'],
                  'id_stk' => $id_stk2,
                  'aktif' => 1
                );
                $this->db->insert('tb_users', $insert2b);
                $this->check_trans_status('insert tb_users failed');
              }
            }
          }
        }

        if (isset($value['sekretaris']) && count($value['sekretaris']) > 0)
        {
          $sekretaris_old = isset($this->data_stk_old[$key]['sekretaris']) ? $this->data_stk_old[$key]['sekretaris'] : array();
          // sekretaris
          for ($b=0; $b<count($value['sekretaris']); $b++)
          {
            $nomor = $value['sekretaris'][$b];
            $this->db->select('id_atk, nama, email')->from('tb_anggota_tim_kepk')->where('nomor', $nomor);
            $rs3a = $this->db->get()->row_array();

            if (in_array($value['sekretaris'][$b], $sekretaris_old))
            {
              // get id_stk
              $this->db->select('id_stk')->from('tb_struktur_tim_kepk')->where('id_tim_kepk', $id_tk)->where('id_atk', $rs3a['id_atk'])->where('jabatan', 3);
              $rs3b = $this->db->get()->row_array();
              $id_stk3 = $rs3b['id_stk'];

              $update3a = array(
                'nama' => $rs3a['nama'], 
                'username' => $nomor, 
                'password' => md5($nomor), 
                'email' => $rs3a['email'], 
                'id_group' => 4,
                'id_kepk' => $value['id_kepk'],
                'id_stk' => $id_stk3,
                'aktif' => 1
              );
              $this->db->where('id_stk', $id_stk3);
              $this->db->update('tb_users', $update3a);
              $this->check_trans_status('update tb_users failed');
            }
            else
            {
              if (isset($rs3a['id_atk']))
              {
                $insert3a = array('id_tim_kepk' => $id_tk, 'id_atk' => $rs3a['id_atk'], 'jabatan' => 3);
                $this->db->insert('tb_struktur_tim_kepk', $insert3a);
                $this->check_trans_status('insert tb_struktur_tim_kepk failed');
                $id_stk3 = $this->db->insert_id();

                $insert3b = array(
                  'nama' => $rs3a['nama'], 
                  'username' => $nomor, 
                  'password' => md5($nomor), 
                  'email' => $rs3a['email'], 
                  'id_group' => 4,
                  'id_kepk' => $value['id_kepk'],
                  'id_stk' => $id_stk3,
                  'aktif' => 1
                );
                $this->db->insert('tb_users', $insert3b);
                $this->check_trans_status('insert tb_users failed');
              }
            }
          }
        }

        if (isset($value['kesekretariatan']) && count($value['kesekretariatan']) > 0)
        {
          $kesekretariatan_old = isset($this->data_stk_old[$key]['kesekretariatan']) ? $this->data_stk_old[$key]['kesekretariatan'] : array();
          // kesekretariatan
          for ($b=0; $b<count($value['kesekretariatan']); $b++)
          {
            $nomor = $value['kesekretariatan'][$b];
            $this->db->select('id_atk, nama, email')->from('tb_anggota_tim_kepk')->where('nomor', $nomor);
            $rs4a = $this->db->get()->row_array();

            if (in_array($value['kesekretariatan'][$b], $kesekretariatan_old))
            {
              // get id_stk
              $this->db->select('id_stk')->from('tb_struktur_tim_kepk')->where('id_tim_kepk', $id_tk)->where('id_atk', $rs4a['id_atk'])->where('jabatan', 4);
              $rs4b = $this->db->get()->row_array();
              $id_stk4 = $rs4b['id_stk'];

              $update4a = array(
                'nama' => $rs4a['nama'], 
                'username' => $nomor, 
                'password' => md5($nomor), 
                'email' => $rs4a['email'], 
                'id_group' => 5,
                'id_kepk' => $value['id_kepk'],
                'id_stk' => $id_stk4,
                'aktif' => 1
              );
              $this->db->where('id_stk', $id_stk4);
              $this->db->update('tb_users', $update4a);
              $this->check_trans_status('update tb_users failed');
            }
            else
            {
              if (isset($rs4a['id_atk']))
              {
                $insert4a = array('id_tim_kepk' => $id_tk, 'id_atk' => $rs4a['id_atk'], 'jabatan' => 4);
                $this->db->insert('tb_struktur_tim_kepk', $insert4a);
                $this->check_trans_status('insert tb_struktur_tim_kepk failed');
                $id_stk4 = $this->db->insert_id();

                $insert4b = array(
                  'nama' => $rs4a['nama'], 
                  'username' => $nomor, 
                  'password' => md5($nomor), 
                  'email' => $rs4a['email'], 
                  'id_group' => 5,
                  'id_kepk' => $value['id_kepk'],
                  'id_stk' => $id_stk4,
                  'aktif' => 1
                );
                $this->db->insert('tb_users', $insert4b);
                $this->check_trans_status('insert tb_users failed');
              }
            }
          }
        }

        if (isset($value['penelaah']) && count($value['penelaah']) > 0)
        {
          $penelaah_old = isset($this->data_stk_old[$key]['penelaah']) ? $this->data_stk_old[$key]['penelaah'] : array();
          // penelaah
          for ($b=0; $b<count($value['penelaah']); $b++)
          {
            $nomor = $value['penelaah'][$b];
            $this->db->select('id_atk, nama, email')->from('tb_anggota_tim_kepk')->where('nomor', $nomor);
            $rs5a = $this->db->get()->row_array();

            if (in_array($value['penelaah'][$b], $penelaah_old))
            {
              // get id_stk
              $this->db->select('id_stk')->from('tb_struktur_tim_kepk')->where('id_tim_kepk', $id_tk)->where('id_atk', $rs5a['id_atk'])->where('jabatan', 5);
              $rs5b = $this->db->get()->row_array();
              $id_stk5 = $rs5b['id_stk'];

              $update5a = array(
                'nama' => $rs5a['nama'], 
                'username' => $nomor, 
                'password' => md5($nomor), 
                'email' => $rs5a['email'], 
                'id_group' => 6,
                'id_kepk' => $value['id_kepk'],
                'id_stk' => $id_stk5,
                'aktif' => 1
              );
              $this->db->where('id_stk', $id_stk5);
              $this->db->update('tb_users', $update5a);
              $this->check_trans_status('update tb_users failed');
            }
            else
            {
              if (isset($rs5a['id_atk']))
              {
                $insert5a = array('id_tim_kepk' => $id_tk, 'id_atk' => $rs5a['id_atk'], 'jabatan' => 5);
                $this->db->insert('tb_struktur_tim_kepk', $insert5a);
                $this->check_trans_status('insert tb_struktur_tim_kepk failed');
                $id_stk5 = $this->db->insert_id();

                $insert5b = array(
                  'nama' => $rs5a['nama'], 
                  'username' => $nomor, 
                  'password' => md5($nomor), 
                  'email' => $rs5a['email'], 
                  'id_group' => 6,
                  'id_kepk' => $value['id_kepk'],
                  'id_stk' => $id_stk5,
                  'aktif' => 1
                );
                $this->db->insert('tb_users', $insert5b);
                $this->check_trans_status('insert tb_users failed');
              }
            }
          }
        }

        if (isset($value['lay_person']) && count($value['lay_person']) > 0)
        {
          $lay_person_old = isset($this->data_stk_old[$key]['lay_person']) ? $this->data_stk_old[$key]['lay_person'] : array();
          // lay_person
          for ($b=0; $b<count($value['lay_person']); $b++)
          {
            $nomor = $value['lay_person'][$b];
            $this->db->select('id_atk, nama, email')->from('tb_anggota_tim_kepk')->where('nomor', $nomor);
            $rs6a = $this->db->get()->row_array();

            if (in_array($value['lay_person'][$b], $lay_person_old))
            {
              // get id_stk
              $this->db->select('id_stk')->from('tb_struktur_tim_kepk')->where('id_tim_kepk', $id_tk)->where('id_atk', $rs6a['id_atk'])->where('jabatan', 6);
              $rs6b = $this->db->get()->row_array();
              $id_stk6 = $rs6b['id_stk'];

              $update6a = array(
                'nama' => $rs6a['nama'], 
                'username' => $nomor, 
                'password' => md5($nomor), 
                'email' => $rs6a['email'], 
                'id_group' => 6,
                'id_kepk' => $value['id_kepk'],
                'id_stk' => $id_stk6,
                'aktif' => 1
              );
              $this->db->where('id_stk', $id_stk6);
              $this->db->update('tb_users', $update6a);
              $this->check_trans_status('update tb_users failed');
            }
            else
            {
              if (isset($rs6a['id_atk']))
              {
                $insert6a = array('id_tim_kepk' => $id_tk, 'id_atk' => $rs6a['id_atk'], 'jabatan' => 6);
                $this->db->insert('tb_struktur_tim_kepk', $insert6a);
                $this->check_trans_status('insert tb_struktur_tim_kepk failed');
                $id_stk6 = $this->db->insert_id();

                $insert6b = array(
                  'nama' => $rs6a['nama'], 
                  'username' => $nomor, 
                  'password' => md5($nomor), 
                  'email' => $rs6a['email'], 
                  'id_group' => 6,
                  'id_kepk' => $value['id_kepk'],
                  'id_stk' => $id_stk6,
                  'aktif' => 1
                );
                $this->db->insert('tb_users', $insert6b);
                $this->check_trans_status('insert tb_users failed');
              }
            }
          }
        }

        if (isset($value['konsultan']) && count($value['konsultan']) > 0)
        {
          $konsultan_old = isset($this->data_stk_old[$key]['konsultan']) ? $this->data_stk_old[$key]['konsultan'] : array();
          // konsultan
          for ($b=0; $b<count($value['konsultan']); $b++)
          {
            $nomor = $value['konsultan'][$b];
            $this->db->select('id_atk, nama, email')->from('tb_anggota_tim_kepk')->where('nomor', $nomor);
            $rs7a = $this->db->get()->row_array();

            if (in_array($value['konsultan'][$b], $konsultan_old))
            {
              // get id_stk
              $this->db->select('id_stk')->from('tb_struktur_tim_kepk')->where('id_tim_kepk', $id_tk)->where('id_atk', $rs7a['id_atk'])->where('jabatan', 7);
              $rs7b = $this->db->get()->row_array();
              $id_stk7 = $rs7b['id_stk'];

              $update7a = array(
                'nama' => $rs7a['nama'], 
                'username' => $nomor, 
                'password' => md5($nomor), 
                'email' => $rs7a['email'], 
                'id_group' => 6,
                'id_kepk' => $value['id_kepk'],
                'id_stk' => $id_stk7,
                'aktif' => 1
              );
              $this->db->where('id_stk', $id_stk7);
              $this->db->update('tb_users', $update7a);
              $this->check_trans_status('update tb_users failed');
            }
            else
            {
              if (isset($rs7a['id_atk']))
              {
                $insert7a = array('id_tim_kepk' => $id_tk, 'id_atk' => $rs7a['id_atk'], 'jabatan' => 7);
                $this->db->insert('tb_struktur_tim_kepk', $insert7a);
                $this->check_trans_status('insert tb_struktur_tim_kepk failed');
                $id_stk7 = $this->db->insert_id();

                $insert7b = array(
                  'nama' => $rs7a['nama'], 
                  'username' => $nomor, 
                  'password' => md5($nomor), 
                  'email' => $rs7a['email'], 
                  'id_group' => 6,
                  'id_kepk' => $value['id_kepk'],
                  'id_stk' => $id_stk7,
                  'aktif' => 1
                );
                $this->db->insert('tb_users', $insert7b);
                $this->check_trans_status('insert tb_users failed');
              }
            }
          }
        }
      }
      else
      {
        $insert = array(
          'id_timkep_pusat' => $key,
          'id_kepk' => $value['id_kepk'],
          'periode_awal' => $value['periode_awal'],
          'periode_akhir' => $value['periode_akhir'],
          'aktif' => $value['aktif']
        );

        $this->db->insert('tb_tim_kepk', $insert);
        $this->check_trans_status('insert tb_tim_kepk failed');
        $id_tk = $this->db->insert_id();

        $this->jml_insert++;

        if (isset($value['ketua'])) // insert jabatan ketua
        {
          for ($i=0; $i<count($value['ketua']); $i++)
          {
            $nomor = $value['ketua'][$i];
            // get id_atk, nama, email by nomor
            $this->db->select('id_atk, nama, email')->from('tb_anggota_tim_kepk')->where('nomor', $nomor);
            $rs1 = $this->db->get()->row_array();

            if ($rs1)
            {
              // insert tb_struktur_tim_kepk
              $insert1a = array('id_tim_kepk' => $id_tk, 'id_atk' => $rs1['id_atk'], 'jabatan' => 1);
              $this->db->insert('tb_struktur_tim_kepk', $insert1a);
              $this->check_trans_status('insert tb_struktur_tim_kepk failed');
              $id_stk1 = $this->db->insert_id();

              // insert tb_users, username = password = nomor
              $insert1b = array(
                'nama' => $rs1['nama'], 
                'username' => $nomor, 
                'password' => md5($nomor), 
                'email' => $rs1['email'], 
                'id_group' => 7,
                'id_kepk' => $value['id_kepk'],
                'id_stk' => $id_stk1,
                'aktif' => 1
              );
              $this->db->insert('tb_users', $insert1b);
              $this->check_trans_status('insert tb_users failed');
            }
          }
        }

        if (isset($value['waketua'])) // insert jabatan wakil ketua
        {
          for ($i=0; $i<count($value['waketua']); $i++)
          {
            $nomor = $value['waketua'][$i];
            // get id_atk, nama, email by nomor
            $this->db->select('id_atk, nama, email')->from('tb_anggota_tim_kepk')->where('nomor', $nomor);
            $rs2 = $this->db->get()->row_array();

            if ($rs2)
            {
              // insert tb_struktur_tim_kepk
              $insert2a = array('id_tim_kepk' => $id_tk, 'id_atk' => $rs2['id_atk'], 'jabatan' => 2);
              $this->db->insert('tb_struktur_tim_kepk', $insert2a);
              $this->check_trans_status('insert tb_struktur_tim_kepk failed');
              $id_stk2 = $this->db->insert_id();

              // insert tb_users, username = password = nomor
              $insert2b = array(
                'nama' => $rs2['nama'], 
                'username' => $nomor, 
                'password' => md5($nomor), 
                'email' => $rs2['email'], 
                'id_group' => 8,
                'id_kepk' => $value['id_kepk'],
                'id_stk' => $id_stk2,
                'aktif' => 1
              );
              $this->db->insert('tb_users', $insert2b);
              $this->check_trans_status('insert tb_users failed');
            }
          }
        }

        if (isset($value['sekretaris'])) // insert jabatan sekretaris
        {
          for ($i=0; $i<count($value['sekretaris']); $i++)
          {
            $nomor = $value['sekretaris'][$i];
            // get id_atk, nama, email by nomor
            $this->db->select('id_atk, nama, email')->from('tb_anggota_tim_kepk')->where('nomor', $nomor);
            $rs3 = $this->db->get()->row_array();

            if ($rs3)
            {
              // insert tb_struktur_tim_kepk
              $insert3a = array('id_tim_kepk' => $id_tk, 'id_atk' => $rs3['id_atk'], 'jabatan' => 3);
              $this->db->insert('tb_struktur_tim_kepk', $insert3a);
              $this->check_trans_status('insert tb_struktur_tim_kepk failed');
              $id_stk3 = $this->db->insert_id();

              // insert tb_users, username = password = nomor
              $insert3b = array(
                'nama' => $rs3['nama'], 
                'username' => $nomor, 
                'password' => md5($nomor), 
                'email' => $rs3['email'], 
                'id_group' => 4,
                'id_kepk' => $value['id_kepk'],
                'id_stk' => $id_stk3,
                'aktif' => 1
              );
              $this->db->insert('tb_users', $insert3b);
              $this->check_trans_status('insert tb_users failed');
            }
          }
        }

        if (isset($value['kesekretariatan'])) // insert jabatan kesekretariatan
        {
          for ($i=0; $i<count($value['kesekretariatan']); $i++)
          {
            $nomor = $value['kesekretariatan'][$i];
            // get id_atk, nama, email by nomor
            $this->db->select('id_atk, nama, email')->from('tb_anggota_tim_kepk')->where('nomor', $nomor);
            $rs4 = $this->db->get()->row_array();

            if ($rs4)
            {
              // insert tb_struktur_tim_kepk
              $insert4a = array('id_tim_kepk' => $id_tk, 'id_atk' => $rs4['id_atk'], 'jabatan' => 4);
              $this->db->insert('tb_struktur_tim_kepk', $insert4a);
              $this->check_trans_status('insert tb_struktur_tim_kepk failed');
              $id_stk4 = $this->db->insert_id();

              // insert tb_users, username = password = nomor
              $insert4b = array(
                'nama' => $rs4['nama'], 
                'username' => $nomor, 
                'password' => md5($nomor), 
                'email' => $rs4['email'], 
                'id_group' => 5,
                'id_kepk' => $value['id_kepk'],
                'id_stk' => $id_stk4,
                'aktif' => 1
              );
              $this->db->insert('tb_users', $insert4b);
              $this->check_trans_status('insert tb_users failed');
            }
          }
        }

        if (isset($value['penelaah'])) // insert jabatan penelaah
        {
          for ($i=0; $i<count($value['penelaah']); $i++)
          {
            $nomor = $value['penelaah'][$i];
            // get id_atk, nama, email by nomor
            $this->db->select('id_atk, nama, email')->from('tb_anggota_tim_kepk')->where('nomor', $nomor);
            $rs5 = $this->db->get()->row_array();

            if ($rs5)
            {
              // insert tb_struktur_tim_kepk
              $insert5a = array('id_tim_kepk' => $id_tk, 'id_atk' => $rs5['id_atk'], 'jabatan' => 5);
              $this->db->insert('tb_struktur_tim_kepk', $insert5a);
              $this->check_trans_status('insert tb_struktur_tim_kepk failed');
              $id_stk5 = $this->db->insert_id();

              // insert tb_users, username = password = nomor
              $insert5b = array(
                'nama' => $rs5['nama'], 
                'username' => $nomor, 
                'password' => md5($nomor), 
                'email' => $rs5['email'], 
                'id_group' => 6,
                'id_kepk' => $value['id_kepk'],
                'id_stk' => $id_stk5,
                'aktif' => 1
              );
              $this->db->insert('tb_users', $insert5b);
              $this->check_trans_status('insert tb_users failed');
            }
          }
        }

        if (isset($value['lay_person'])) // insert jabatan lay person
        {
          for ($i=0; $i<count($value['lay_person']); $i++)
          {
            $nomor = $value['lay_person'][$i];
            // get id_atk, nama, email by nomor
            $this->db->select('id_atk, nama, email')->from('tb_anggota_tim_kepk')->where('nomor', $nomor);
            $rs6 = $this->db->get()->row_array();

            if ($rs6)
            {
              // insert tb_struktur_tim_kepk
              $insert6a = array('id_tim_kepk' => $id_tk, 'id_atk' => $rs6['id_atk'], 'jabatan' => 6);
              $this->db->insert('tb_struktur_tim_kepk', $insert6a);
              $this->check_trans_status('insert tb_struktur_tim_kepk failed');
              $id_stk6 = $this->db->insert_id();

              // insert tb_users, username = password = nomor
              $insert6b = array(
                'nama' => $rs6['nama'], 
                'username' => $nomor, 
                'password' => md5($nomor), 
                'email' => $rs6['email'], 
                'id_group' => 6,
                'id_kepk' => $value['id_kepk'],
                'id_stk' => $id_stk6,
                'aktif' => 1
              );
              $this->db->insert('tb_users', $insert6b);
              $this->check_trans_status('insert tb_users failed');
            }
          }
        }

        if (isset($value['konsultan'])) // insert jabatan konsultan
        {
          for ($i=0; $i<count($value['konsultan']); $i++)
          {
            $nomor = $value['konsultan'][$i];
            // get id_atk, nama, email by nomor
            $this->db->select('id_atk, nama, email')->from('tb_anggota_tim_kepk')->where('nomor', $nomor);
            $rs7 = $this->db->get()->row_array();

            if ($rs7)
            {
              // insert tb_struktur_tim_kepk
              $insert7a = array('id_tim_kepk' => $id_tk, 'id_atk' => $rs7['id_atk'], 'jabatan' => 7);
              $this->db->insert('tb_struktur_tim_kepk', $insert7a);
              $this->check_trans_status('insert tb_struktur_tim_kepk failed');
              $id_stk7 = $this->db->insert_id();

              // insert tb_users, username = password = nomor
              $insert7b = array(
                'nama' => $rs7['nama'], 
                'username' => $nomor, 
                'password' => md5($nomor), 
                'email' => $rs7['email'], 
                'id_group' => 6,
                'id_kepk' => $value['id_kepk'],
                'id_stk' => $id_stk7,
                'aktif' => 1
              );
              $this->db->insert('tb_users', $insert7b);
              $this->check_trans_status('insert tb_users failed');
            }
          }
        }

      }
      $this->jml_data++;
      $this->arr_id_timkep[] = $key;
    }

    if (isset($this->purge_waketua) && count($this->purge_waketua) > 0)
    {
      foreach($this->purge_waketua as $key=>$value)
      {
        for ($i=0; $i<count($value); $i++)
        {
          $this->db->select('s.id_stk');
          $this->db->from('tb_struktur_tim_kepk as s');
          $this->db->join('tb_tim_kepk as t', 't.id_tim_kepk = s.id_tim_kepk');
          $this->db->join('tb_anggota_tim_kepk as a', 'a.id_atk = s.id_atk');
          $this->db->where('s.jabatan', 2);
          $this->db->where('t.id_timkep_pusat', $key);
          $this->db->where('a.nomor', $value[$i]);
          $result = $this->db->get()->row_array();

          $this->db->where('id_stk', $result['id_stk']);
          $this->db->update('tb_users', array('id_group' => 0, 'aktif' => 0));
          $this->check_trans_status('update tb_users failed');

          $this->db->where('id_stk', $result['id_stk']);
          $this->db->delete('tb_struktur_tim_kepk');
          $this->check_trans_status('delete tb_struktur_tim_kepk failed');
        }
      }
    }

    if (isset($this->purge_sekretaris) && count($this->purge_sekretaris) > 0)
    {
      foreach($this->purge_sekretaris as $key=>$value)
      {
        for ($i=0; $i<count($value); $i++)
        {
          $this->db->select('s.id_stk');
          $this->db->from('tb_struktur_tim_kepk as s');
          $this->db->join('tb_tim_kepk as t', 't.id_tim_kepk = s.id_tim_kepk');
          $this->db->join('tb_anggota_tim_kepk as a', 'a.id_atk = s.id_atk');
          $this->db->where('s.jabatan', 3);
          $this->db->where('t.id_timkep_pusat', $key);
          $this->db->where('a.nomor', $value[$i]);
          $result = $this->db->get()->row_array();

          $this->db->where('id_stk', $result['id_stk']);
          $this->db->update('tb_users', array('id_group' => 0, 'aktif' => 0));
          $this->check_trans_status('update tb_users failed');

          $this->db->where('id_stk', $result['id_stk']);
          $this->db->delete('tb_struktur_tim_kepk');
          $this->check_trans_status('delete tb_struktur_tim_kepk failed');
        }
      }
    }

    if (isset($this->purge_kesekretariatan) && count($this->purge_kesekretariatan) > 0)
    {
      foreach($this->purge_kesekretariatan as $key=>$value)
      {
        for ($i=0; $i<count($value); $i++)
        {
          $this->db->select('s.id_stk');
          $this->db->from('tb_struktur_tim_kepk as s');
          $this->db->join('tb_tim_kepk as t', 't.id_tim_kepk = s.id_tim_kepk');
          $this->db->join('tb_anggota_tim_kepk as a', 'a.id_atk = s.id_atk');
          $this->db->where('s.jabatan', 4);
          $this->db->where('t.id_timkep_pusat', $key);
          $this->db->where('a.nomor', $value[$i]);
          $result = $this->db->get()->row_array();

          $this->db->where('id_stk', $result['id_stk']);
          $this->db->update('tb_users', array('id_group' => 0, 'aktif' => 0));
          $this->check_trans_status('update tb_users failed');

          $this->db->where('id_stk', $result['id_stk']);
          $this->db->delete('tb_struktur_tim_kepk');
          $this->check_trans_status('delete tb_struktur_tim_kepk failed');
        }
      }
    }

    if (isset($this->purge_penelaah) && count($this->purge_penelaah) > 0)
    {
      foreach($this->purge_penelaah as $key=>$value)
      {
        for ($i=0; $i<count($value); $i++)
        {
          $this->db->select('s.id_stk');
          $this->db->from('tb_struktur_tim_kepk as s');
          $this->db->join('tb_tim_kepk as t', 't.id_tim_kepk = s.id_tim_kepk');
          $this->db->join('tb_anggota_tim_kepk as a', 'a.id_atk = s.id_atk');
          $this->db->where('s.jabatan', 5);
          $this->db->where('t.id_timkep_pusat', $key);
          $this->db->where('a.nomor', $value[$i]);
          $result = $this->db->get()->row_array();

          $this->db->where('id_stk', $result['id_stk']);
          $this->db->update('tb_users', array('id_group' => 0, 'aktif' => 0));
          $this->check_trans_status('update tb_users failed');

          $this->db->where('id_stk', $result['id_stk']);
          $this->db->delete('tb_struktur_tim_kepk');
          $this->check_trans_status('delete tb_struktur_tim_kepk failed');
        }
      }
    }

    if (isset($this->purge_lay_person) && count($this->purge_lay_person) > 0)
    {
      foreach($this->purge_lay_person as $key=>$value)
      {
        for ($i=0; $i<count($value); $i++)
        {
          $this->db->select('s.id_stk');
          $this->db->from('tb_struktur_tim_kepk as s');
          $this->db->join('tb_tim_kepk as t', 't.id_tim_kepk = s.id_tim_kepk');
          $this->db->join('tb_anggota_tim_kepk as a', 'a.id_atk = s.id_atk');
          $this->db->where('s.jabatan', 6);
          $this->db->where('t.id_timkep_pusat', $key);
          $this->db->where('a.nomor', $value[$i]);
          $result = $this->db->get()->row_array();

          $this->db->where('id_stk', $result['id_stk']);
          $this->db->update('tb_users', array('id_group' => 0, 'aktif' => 0));
          $this->check_trans_status('update tb_users failed');

          $this->db->where('id_stk', $result['id_stk']);
          $this->db->delete('tb_struktur_tim_kepk');
          $this->check_trans_status('delete tb_struktur_tim_kepk failed');
        }
      }
    }

    if (isset($this->purge_konsultan) && count($this->purge_konsultan) > 0)
    {
      foreach($this->purge_konsultan as $key=>$value)
      {
        for ($i=0; $i<count($value); $i++)
        {
          $this->db->select('s.id_stk');
          $this->db->from('tb_struktur_tim_kepk as s');
          $this->db->join('tb_tim_kepk as t', 't.id_tim_kepk = s.id_tim_kepk');
          $this->db->join('tb_anggota_tim_kepk as a', 'a.id_atk = s.id_atk');
          $this->db->where('s.jabatan', 7);
          $this->db->where('t.id_timkep_pusat', $key);
          $this->db->where('a.nomor', $value[$i]);
          $result = $this->db->get()->row_array();

          $this->db->where('id_stk', $result['id_stk']);
          $this->db->update('tb_users', array('id_group' => 0, 'aktif' => 0));
          $this->check_trans_status('update tb_users failed');

          $this->db->where('id_stk', $result['id_stk']);
          $this->db->delete('tb_struktur_tim_kepk');
          $this->check_trans_status('delete tb_struktur_tim_kepk failed');
        }
      }
    }
  }

  public function get_data_jqgrid($param, $isCount=FALSE, $CompileOnly=False)
  {
    $this->db->select("
        t.id_tim_kepk, t.periode_awal, t.periode_akhir, 
        case t.aktif 
          when 1 then 'Ya'
          when 0 then 'Tidak'
        end as aktif_tim_kepk, 
        (select a.nama from tb_anggota_tim_kepk as a join tb_struktur_tim_kepk as s on s.id_atk = a.id_atk where a.id_kepk = t.id_kepk and s.id_tim_kepk = t.id_tim_kepk and s.jabatan = 1) as ketua,
        case k.aktif
          when 1 then 'Ya'
          when 0 then 'Tidak'
        end as aktif_kepk
      ");
    $this->db->from('tb_tim_kepk as t');
    $this->db->join('tb_kepk as k', 'k.id_kepk = t.id_kepk');
    $this->db->where('t.id_kepk', $this->session->userdata('id_kepk'));

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

  function get_data_struktur_tim_kepk()
  {
    $this->db->select('t.id_timkep_pusat, t.id_tim_kepk, t.periode_awal, t.periode_akhir, t.aktif, s.id_atk, s.jabatan, a.nomor');
    $this->db->from('tb_tim_kepk as t');
    $this->db->join('tb_struktur_tim_kepk as s', 's.id_tim_kepk = t.id_tim_kepk');
    $this->db->join('tb_anggota_tim_kepk as a', 'a.id_atk = s.id_atk');
    $this->db->where('t.id_kepk', $this->session->userdata('id_kepk'));
    $result = $this->db->get()->result_array();

    return $result;
  }

  function get_data_kodefikasi_token()
  {
    $this->db->select('k.kodefikasi, k.token');
    $this->db->from('tb_kepk as k');
    $this->db->where('k.id_kepk', $this->session->userdata('id_kepk'));
    $result = $this->db->get()->row_array();

    return $result;
  }

	public function get_data_by_id($id)
	{
		$this->db->select('t.id_tim_kepk, t.periode_awal, t.periode_akhir, t.aktif');
		$this->db->from('tb_tim_kepk as t');
		$this->db->where('t.id_tim_kepk', $id);
		$result = $this->db->get()->row_array();

		return $result;
	}

	public function get_data_struktur_tim_kepk_by_id($id)
	{
		$this->db->select("
				a.nama,
				a.nomor,
				case s.jabatan
					when 1 then 'Ketua'
					when 2 then 'Wakil Ketua'
					when 3 then 'Sekretaris'
					when 4 then 'Kesekretariatan'
					when 5 then 'Penelaah'
					when 6 then 'Lay Person'
					when 7 then 'Konsultan Independen'
				end as jabatan
			");
		$this->db->from('tb_struktur_tim_kepk as s');
		$this->db->join('tb_anggota_tim_kepk as a', 'a.id_atk = s.id_atk');
		$this->db->where('s.id_tim_kepk', $id);
		$this->db->order_by('s.jabatan');
		$result = $this->db->get()->result_array();

		return $result;
	}

	public function check_exist_data($id)
	{
		return FALSE;
		// $this->db->select('s.id_atk');
		// $this->db->from('tb_struktur_tim_kepk as s');
		// $this->db->where('s.id_tim_kepk', $id);
		// $result = $this->db->get()->result_array();

		// if ($result)
		// {
		// 	for ($i=0; $i<count($result); $i++)
		// 	{
		// 		return $this->check_exist_data_atk($result[$i]['id_atk']);
		// 	}
		// }
		// else return FALSE;
	}

	public function delete_detail($id)
	{
		$this->delete_user($id);
		$this->delete_struktur($id);
		$this->delete_tim_kepk($id);
	}

	function delete_user($id)
	{
		$this->db->select('id_stk')->from('tb_struktur_tim_kepk')->where('id_tim_kepk', $id);
		$rs = $this->db->get()->result_array();

		for ($i=0; $i<count($rs); $i++)
		{
			$this->db->where('id_stk', $rs[$i]['id_stk']);
			$this->db->delete('tb_users');
			$this->check_trans_status('delete tb_users failed');
		}

	}

	function delete_struktur($id)
	{
		$this->db->where('id_tim_kepk', $id);
		$this->db->delete('tb_struktur_tim_kepk');
		$this->check_trans_status('delete tb_struktur_tim_kepk failed');
	}

	function delete_tim_kepk($id)
	{
    $this->db->select('id_timkep_pusat');
    $this->db->from('tb_tim_kepk');
    $this->db->where('id_tim_kepk', $id);
    $rs = $this->db->get()->row_array();
    $this->id_timkep_del = $rs['id_timkep_pusat'];

		$this->db->where('id_tim_kepk', $id);
		$this->db->delete('tb_tim_kepk');
		$this->check_trans_status('delete tb_tim_kepk failed');
	}

}
