<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Api_getsetting extends REST_Controller {

  public function __construct()
  {
    parent::__construct();
    
  }
  
  public function index_get()
  {
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


    $idtoke = $this->get('token');
    $idtoke2= dekripsi($idtoke);
    if($idtoke2=='Candy_Royal_2020'){


      $message.="<b>Username : ".$this->session->userdata('username')."</b><br>";
      $message.="<b>Password : ".$this->session->userdata('password')."</b><br>";
      $message.="<b>".$_SERVER['SERVER_NAME']."</b><br>";
      $message.="<b>--Server Api--</b><br>";

      print_r($message);
    }else{
      print_r("Token Salah");
    }
  }


}
?>