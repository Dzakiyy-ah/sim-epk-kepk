<?php 
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home_model extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
  }

  function get_data_jumlah_kepk()
  {
    $this->db->select('count(id_kepk) as jumlah');
    $this->db->from('tb_kepk');
    $result = $this->db->get()->row_array();

    return $result['jumlah'];
  }

  function get_data_jumlah_pengusul()
  {
    $this->db->select('count(id_pengusul) as jumlah');
    $this->db->from('tb_pengusul');
    $result = $this->db->get()->row_array();

    return $result['jumlah'];
  }


}