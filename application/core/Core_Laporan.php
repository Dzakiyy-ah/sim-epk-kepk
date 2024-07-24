<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Core_Laporan extends Userpage_Controller {

  var $path2engine;
  var $path2fr3;
  var $path2cache;
  var $path2output;
  var $attachment;
  var $fr3;
  var $nama_laporan;
  var $default_param;

  public function __construct()
  {
    parent::__construct();
    $this->load->helper('path');
    $this->path2engine = dirname( realpath(SELF) )."/assets/fr/";
    $this->path2fr3 = $this->path2engine . 'fr3/';
    $this->path2cache = $this->path2engine . 'cache/';
    $this->path2output = $this->path2engine . 'output/';
    $this->attachment = 1; // 0 : show in the browser;  1 : download file
    $this->default_param = array();

  }

  protected function start($param)
  {
    $this->load->helper('file');

    $data = 'ReportName='. $param['fr3'] ."\n";
    $data .= 'OutputType='. $param['format'] ."\n";
    $data .= 'DriverName='.$this->db->dbdriver."\n";
    $data .= 'Connection=DB Express'."\n";
    $data .= 'DBPort='.$this->db->port."\n";
    $data .= 'DBServer='.$this->db->hostname."\n";
    $data .= 'DBName='.$this->db->database."\n";
    $data .= 'DBUser='. $this->db->username."\n";
    $data .= 'DBPassword='. $this->db->password."\n";

    if (isset($param['opt'])) {
      foreach($param['opt'] as $key => $value){
        if (is_array($value)) {
          $value = json_encode($value);
        }
        $data.=$key.'='.$value."\n";
      }
    }

    $in = tempnam($this->path2cache, "in");
    write_file($in, $data);
    $out = basename( $in, '.tmp');
    $outfile = $this->path2output.$out;

// print_r('exec(DISPLAY=:100 wine '.$this->path2engine.'RepEngine.exe "'.$in.'" "'.$outfile.'" 2>'.$this->path2engine.'RepEngine.log)');
// die();
    if( PHP_OS == 'WIN32' || PHP_OS == 'WINNT')
    {
      exec($this->path2engine.'RepEngine.exe "'.$in.'" "'.$outfile.'"');
    }
    else
    {
      exec('DISPLAY=:100 wine '.$this->path2engine.'RepEngine.exe "'.$in.'" "'.$outfile.'" 2>'.$this->path2engine.'RepEngine.log');
    }

    $response = (object) NULL;
    if (file_exists($outfile.".ok"))
    {
      $response->isSuccessful = TRUE;
      $response->id = $out;
      $response->nama = rawurlencode($param['nama']);
    }
    else
    {
      $response->isSuccessful = FALSE;
      $response->message = 'Laporan gagal dibuat.';
    }
    echo json_encode($response);
  }

  function proses()
  {
    $fr3 = $this->path2fr3.$this->input->post('fr3');
    $nama = $this->input->post('nama');
    $format = $this->input->post('format');
    $param['fr3'] = $fr3;
    $param['nama'] = $nama;
    $param['format'] = $format ? $format : 'pdf';
    // parameter default
    foreach($this->default_param as $key => $val)
    {
      $param['opt'][$key] = $val;
    }

    $post = $this->input->post();
    if (is_array($post)) {
      foreach( $post as $key => $value )
      {
        $param['opt'][ $key ] = $value;
      }
    }

    $this->start($param);
  }

  public function view($key = '', $reportname = '')
  {
    $this->load->helper('file');

    $ext = "";
    if( PHP_OS == 'WIN32' || PHP_OS == 'WINNT') $ext = ".tmp";

    if (!file_exists($this->path2cache.$key.$ext)) {
      $this->output->set_status_header(500);
      return;
    }

    $config = file($this->path2cache.$key.$ext);
    $filetype = explode('=', $config[1]);
    $filetype = preg_replace("/[\n\r]/","", $filetype[1]);
    $filetype = $filetype == 'rtf' ? 'doc' : $filetype;

    $filename = $key. "." .$filetype;
    $fileerr = $key.".err";

    if (file_exists($this->path2output.$filename)) {
      $outfile = $reportname. "." .$filetype;

      header('Content-Disposition: ' . ($this->attachment == 1 ? 'attachment; ' : '') .'filename="'.$outfile.'"');
      switch ($filetype){
        case 'pdf' :
          header('Content-Type: application/pdf');
          break;
        case 'xls' :
          header('Content-Type: application/xls');
          break;
        case 'xlsx' :
          header('Content-Type: application/xls');
          break;
        case 'doc' :
          header('Content-Type: application/doc');
          break;
        case 'docx' :
          header('Content-Type: application/doc');
          break;
        case 'odt' :
          header('Content-Type: application/odt');
          break;
        case 'ods' :
          header('Content-Type: application/odf');
          break;
      }

      header('Content-Length: '.filesize($this->path2output.$filename));
      header('Cache-Control: no-store');
      readfile($this->path2output.$filename);
    }
    elseif (file_exists($this->path2output.$fileerr)) {
      $this->output->set_status_header(500);
    }
  }

}