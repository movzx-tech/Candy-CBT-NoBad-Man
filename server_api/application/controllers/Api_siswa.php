<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;


class Api_siswa extends REST_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_siswa_api','siswa');
    
  }
    // function index_get(){
    //   $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
    //   if ($this->cache->apc->is_supported())
    //   {
    //     echo"suppor";
    //   }
    //   else{
    //     echo "no support";
    //   }
    // }
  function dekripsi($string)
  {
    $output = false;

    $encrypt_method = "AES-256-CBC";
    $secret_key = 'abcdefghijklmnopqrstuvwxyzABNCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%^&*()_+|}{:?><';
    $secret_iv = 'abcdefghijklmnopqrstuvwxyzABNCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%^&*()_+|}{:?><';

      // hash
    $key = hash('sha256', $secret_key);

      // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);

    return $output;
  }

  public function index_get()
  {

    $id = $this->get('id');
    $user = $this->siswa->get_user($id);
    if($user){
      $this->response([
        'status' => TRUE,
        'info' =>'ok',
        'data' => $user
      ], REST_Controller::HTTP_OK);
      $this->response($user, 200);
              // jika gagal
              //$this->response(array('status' => 'success'), 201);
              //$this->response(array('status' => 'fail', 502));
    }
    else{
      $this->response([
        'status' => FALSE,
        'info' =>'ko',
        'pesan' => 'TIDAK DI TEMUKAN'
      ], REST_Controller::HTTP_NOT_FOUND);
    }
  }
 

}
?>