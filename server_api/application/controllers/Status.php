<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;
use Phpfastcache\CacheManager;
use Phpfastcache\Config\ConfigurationOption;

class Status extends REST_Controller{

    public function __construct()
    {
      parent::__construct();
      $this->load->model('M_siswa_api','siswa');
      CacheManager::setDefaultConfig(new ConfigurationOption([
      'path' => APPPATH .'/cache',
      ]));
      $this->InstanceCache = CacheManager::getInstance('files');

    }
   
    public function index_get(){
      $this->db->cache_off();
      $id = $this->get('siswaid');
      echo $id; 
      $key = 'siswa_'.$id;
      $CachedString = $this->InstanceCache->getItem($key);
      if (!$CachedString->isHit()) {
        $user = $this->siswa->get_status_user($id);
        $CachedString->set($user)->expiresAfter(180);//in seconds, also accepts Datetime
        $this->InstanceCache->save($CachedString);
        return $user;
      } else {
        return $user = $CachedString->get();
      } 

    }
 
   
}
?>