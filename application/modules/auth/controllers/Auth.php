<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

  public function __construct()
  {
    parent::__construct();

    $this->load->model('Auth_model', 'data_model');
    $this->load->helper('captcha');
  }
 
  public function index()
  {
    redirect('home');
  }

  public function login()
  {
    $vals = array(
            'img_path'      => './captcha/',
            'img_url'       => base_url().'captcha/',
            'font_path'     => '/system/fonts/texb.ttf',
            'img_width'     => '90',
            'img_height'    => 30,
            'expiration'    => 7200,
            'word_length'   => 3,
            'font_size'     => 14,
            'img_id'        => 'Imageid',
            'pool'          => '0123456789',

            // White background and border, black text and red grid
            'colors'        => array(
                    'background' => array(255, 255, 255),
                    'border' => array(255, 255, 255),
                    'text' => array(0, 0, 0),
                    'grid' => array(255, 40, 40)
            )
    );
    $cap = create_captcha($vals);

  //   // Debugging: Periksa apakah captcha berhasil dibuat
  //   if (!$cap) {
  //     log_message('error', 'Captcha creation failed');
  //     show_error('Captcha creation failed');
  // }

  // if (!isset($cap['image'])) {
  //     log_message('error', 'Captcha image not set');
  //     show_error('Captcha image not set');
  // }

    $this->session->unset_userdata('captchaCode');
    $this->session->set_userdata('captchaCode', isset($cap['word']) ? $cap['word'] : '');

    $data['title'] = APPNAME.' - Log in';
    $data['page_header'] = 'Log in';
    $data['captcha_img'] = isset($cap['image']) ? $cap['image'] : '';

    $this->load->view('login_view', $data);
  }

  function refresh_captcha()
  {
    $vals = array(
            'img_path'      => '../../../captcha/',
            'img_url'       => base_url().'captcha/',
            'font_path'     => '/system/fonts/texb.ttf',
            'img_width'     => '90',
            'img_height'    => 30,
            'expiration'    => 7200,
            'word_length'   => 3,
            'font_size'     => 14,
            'img_id'        => 'Imageid',
            'pool'          => '0123456789',

            // White background and border, black text and red grid
            'colors'        => array(
                    'background' => array(255, 255, 255),
                    'border' => array(255, 255, 255),
                    'text' => array(0, 0, 0),
                    'grid' => array(255, 40, 40)
            )
    );
    $cap = create_captcha($vals);

    $this->session->unset_userdata('captchaCode');
    $this->session->set_userdata('captchaCode', isset($cap['word']) ? $cap['word'] : '');

    echo isset($cap['image']) ? $cap['image'] : '';
  }

  function login_keppkn()
  {
    $this->session->sess_destroy();

    $data['title'] = APPNAME.' - Log in';
    $data['page_header'] = 'Log in';

    $this->load->view('login_keppkn_view', $data);
  }

  public function password1()
  {
    if (!$this->session->userdata('ganti_password') || $this->session->userdata('ganti_password') < 1)
      redirect('auth/login/');

    $data['title'] = APPNAME.' - Perbarui Password';
    $data['page_header'] = 'Perbarui Password';

    $this->load->view('password_view1', $data);
  }

  public function password2()
  {
    if (!$this->session->userdata('ganti_password') || $this->session->userdata('ganti_password') < 2)
      redirect('auth/login/');

    $data['title'] = APPNAME.' - Perbarui Password';
    $data['page_header'] = 'Perbarui Password';

    $this->load->view('password_view2', $data);
  }

  public function validation_form()
  {
    $this->form_validation->set_rules('username', 'Username', 'trim|required|max_length[100]');
    $this->form_validation->set_rules('password', 'Password', 'trim|required');
    $this->form_validation->set_rules('captcha', 'Captcha', 'trim|required|callback_valid_captcha');

    $this->form_validation->set_message('required', '{field} tidak boleh kosong');
    $this->form_validation->set_message('max_length', '{field} tidak boleh melebihi {param} karakter');
  }

  public function validation_form_password1()
  {
    $this->form_validation->set_rules('username2', 'Username', 'trim|required|max_length[100]');
    $this->form_validation->set_rules('email2', 'Email', 'trim|required|valid_email');

    $this->form_validation->set_message('required', 'Masukkan {field}');
    $this->form_validation->set_message('max_length', '{field} lebih dari {param} karakter');
    $this->form_validation->set_message('valid_email', '{field} tidak valid');
  }

  public function validation_form_password2()
  {
    $this->form_validation->set_rules('passw_baru1', 'Password Baru', 'trim|required');
    $this->form_validation->set_rules('passw_baru2', 'Ulangi Password Baru', 'trim|required|matches[passw_baru1]');

    $this->form_validation->set_message('required', '{field} tidak boleh kosong');
    $this->form_validation->set_message('matches', '{field} tidak sama');
  }

  function valid_captcha($captcha)
  {
    if ($captcha == $this->session->userdata('captchaCode'))
    {
      return TRUE;
    }
    else
    {
      $this->form_validation->set_message('valid_captcha', 'Captcha salah');
      return FALSE;
    }
  }

  function proses_login()
  {
    $this->load->library('form_validation');
    $this->validation_form();

    if ($this->form_validation->run() == TRUE)
    {
      $username = $this->input->post('username') ? $this->input->post('username') : '';
      $password = $this->input->post('password') ? md5($this->input->post('password')) : '';
      $id_group = $this->input->post('group') ? $this->input->post('group') : 0;
      $cek_login = $this->data_model->cek_login($username, $password, $id_group);

      if ($cek_login)
      {
        $users = $this->data_model->get_user_data($username, $password, $id_group);
        $kepk = $this->data_model->get_data_kepk();
        $user_data = array(
                      'id_user_'.APPAUTH => $users['id_user'],
                      'username_'.APPAUTH => $users['username'], 
                      'id_group_'.APPAUTH => $users['id_group'], 
                      'nama_group_'.APPAUTH => $users['nama_group'],
                      'nama_user_'.APPAUTH => $users['nama'],
                      'is_login_'.APPAUTH => TRUE,
                      'id_kepk' => isset($users['id_kepk']) ? $kepk['id_kepk'] : 0,
                      'nama_kepk' => isset($users['nama_kepk']) ? $kepk['nama_kepk'] : '',
                      'id_kepk_tim' => $users['id_kepk_tim'],
                      'id_pengusul' => $users['id_pengusul']
                    );

        $this->session->set_userdata($user_data);

        redirect('home');
      }
      else
      {
        $this->session->set_flashdata('error_login', 'Username atau password salah');
        redirect('auth/login');
      }
    }
    else
    {
      $this->session->set_flashdata('error_login', validation_errors());
      redirect('auth/login');
    }
  }

  function proses_login_keppkn()
  {
    $this->load->library('form_validation');
    $this->validation_form();

    if ($this->form_validation->run() == TRUE)
    {
      $username = $this->input->post('username') ? $this->input->post('username') : '';
      $password = $this->input->post('password') ? md5($this->input->post('password')) : '';
      $id_group = 7;
      $cek_login = $this->data_model->cek_login($username, $password, $id_group);

      if ($cek_login)
      {
        $users = $this->data_model->get_user_data($username, $password, $id_group);
        $user_data = array(
                      'id_user_'.APPAUTH=>$users['id_user'],
                      'username_'.APPAUTH=>$users['username'], 
                      'id_group_'.APPAUTH=>$users['id_group'], 
                      'nama_group_'.APPAUTH=>$users['nama_group'],
                      'nama_user_'.APPAUTH=>$users['nama'],
                      'is_login_'.APPAUTH=>TRUE
                    );

        $this->session->set_userdata($user_data);

        redirect('home');
      }
      else
      {
        $this->session->set_flashdata('error_login', 'Username atau password salah');
        redirect('auth/login_keppkn');
      }
    }
    else
    {
      $this->session->set_flashdata('error_login', validation_errors());
      redirect('auth/login_keppkn');
    }
  }

  function proses_password1()
  {
    $response = (object)null;

    $this->load->library('form_validation');
    $this->validation_form_password1();

    if ($this->form_validation->run() == TRUE)
    {
      $username = $this->input->post('username2') ? $this->input->post('username2') : '';
      $email = $this->input->post('email2') ? $this->input->post('email2') : '';
      $id_group = $this->input->post('group2') ? $this->input->post('group2') : 0;
      $cek_data_exist = $this->data_model->cek_data_exist($username, $email, $id_group);

      if ($cek_data_exist)
      {
        $password_data = array('username'=>$username, 'email'=>$email, 'id_group'=>$id_group, 'ganti_password'=>1);

        $this->session->set_userdata($password_data);
        redirect('auth/password1');
      }
      else
      {
        $password_data = array('username'=>$username, 'email'=>$email, 'id_group'=>$id_group, 'ganti_password'=>1);

        $this->session->set_userdata($password_data);

        $this->session->set_flashdata('error_password', 'Username dan Email tidak ada');
        redirect('auth/password1');
      }
    }
    else
    {
      $password_data = array('username'=>$username, 'email'=>$email, 'id_group'=>$id_group, 'ganti_password'=>1);

      $this->session->set_userdata($password_data);

      $this->session->set_flashdata('error_password', validation_errors());
      redirect('auth/password1');
    }
  }
 
  function proses_password2()
  {
    $response = (object)null;

    $this->load->library('form_validation');
    $this->validation_form_password2();

    if ($this->form_validation->run() == TRUE)
    {
      $update_password = $this->data_model->update_password();
      if ($update_password)
      {
        $password_data = array(
                'username'=>$this->session->userdata('username'), 
                'email'=>$this->session->userdata('email'),
                'id_group'=>$this->session->userdata('id_group'), 
                'ganti_password'=>2
        );

        $this->session->set_userdata($password_data);
        redirect('auth/password2');
      }
      else
      {
        $password_data = array(
                'username'=>$this->session->userdata('username'), 
                'email'=>$this->session->userdata('email'),
                'id_group'=>$this->session->userdata('id_group'), 
                'ganti_password'=>2
        );

        $this->session->set_userdata($password_data);

        $this->session->set_flashdata('error_password', 'Penggantian Password Gagal');
        redirect('auth/password2');
      }
    }
    else
    {
      $password_data = array(
              'username'=>$this->session->userdata('username'), 
              'email'=>$this->session->userdata('email'),
              'id_group'=>$this->session->userdata('id_group'), 
              'ganti_password'=>2
      );

      $this->session->set_userdata($password_data);

      $this->session->set_flashdata('error_password', validation_errors());
      redirect('auth/password2');
    }
  }

  function logout()
  {
    $this->session->sess_destroy();
    redirect('auth/login');
  }

  function logout_keppkn()
  {
    $this->session->sess_destroy();
    redirect('auth/login_keppkn');
  }

}
?>