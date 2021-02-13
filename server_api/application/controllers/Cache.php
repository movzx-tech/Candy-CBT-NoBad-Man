<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;
class Cache extends REST_Controller{

    public function __construct()
    {
      parent::__construct();
    }
   
    function index_get(){
      $this->db->cache_delete_all();
      $data = "Oke Cache Sudah Di Hapus Bersih";
      //$this->response($data, 200);
      $this->response([
                  'status' => TRUE,
                  'Pesan' => $data
              ], REST_Controller::HTTP_OK);
              //$this->response('asd', 200);
    }
   
}
?>