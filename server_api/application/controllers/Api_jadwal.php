<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Api_jadwal extends REST_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_singkron','singkron');
    
  }
  
  public function index_get()
  {
    $idtoke = $this->get('token');
   
    $token = $this->singkron->get_token();
    if($token['db_token']==$idtoke){
      $user = $this->singkron->get_jadwal();
      if($user){
        $this->response([
          'status' => TRUE,
           'info' =>'ok',
          'data' => $user
        ], REST_Controller::HTTP_OK);
        $this->response($user, 200);
      }
      else{
        $this->response([
          'status' => FALSE,
           'info' =>'ko',
          'pesan' => 'TIDAK DI TEMUKAN'
        ], REST_Controller::HTTP_NOT_FOUND);
      }
    }
    else{
        $this->response([
          'status' => FALSE,
           'info' =>'ko',
          'pesan' => 'Token Tidak Valid'
        ], REST_Controller::HTTP_NOT_FOUND);
    }
    
  }


}
?>