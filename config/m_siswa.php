<?php
error_reporting(0);
session_cache_expire(0);
session_cache_limiter(0);
session_start();
set_time_limit(0);

(isset($_SESSION['id_user'])) ? $id_user = $_SESSION['id_user'] : $id_user = 0;
//cek validasi tokenya untuk upload dan import
(isset($_SESSION['token'])) ? $token = $_SESSION['token'] : $token = 1;

(isset($_SESSION['token1'])) ? $token1 = $_SESSION['token1'] : $token1 = 2;

include 'setting_url.php';


define("KEY", "76310EEFF2B5D3C887F238976A421B638CFEB0942AB8249CD0A29B125C91B3E5");

if (strpos($_SERVER['HTTP_USER_AGENT'], 'Netscape')) {
    $browser = 'Netscape';
} else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox')) {
    $browser = 'Firefox';
} else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome')) {
    $browser = 'Chrome';
} else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Opera')) {
    $browser = 'Opera';
} else if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE')) {
    $browser = 'Internet Explorer';
} else $browser = 'Other';

//setting up one redis-----------------------------------------
require "vendor/autoload.php";
use RedisClient\RedisClient;
use RedisClient\Client\Version\RedisClient2x6;
use RedisClient\ClientFactory;

$Redis = new RedisClient();

//setting up one redis-----------------------------------------

class Siswa extends Db{
  public $redis;
  function RedisKoneksi(){

    return $this->redis   = new RedisClient();
  }
  function WaktuLamaCache(){
    return 60; //dalam detik
    //1 jam 3600
  }
  
  /*
    -&materi
  */
  private function idsiswa(){ 
    $idsiswa = $_SESSION['id_siswa'];
    return $idsiswa;
   }
   private function idkelas(){ 
    $idkelas = $_SESSION['id_kelas'];
    return $idkelas;
   }

//bagian siswa index.php
  function Status_sudah_ujian($id_siswa,$id_mapel,$id_ujian){
    $sql="SELECT selesai FROM nilai WHERE id_ujian='$id_ujian' AND id_mapel='$id_mapel' AND id_siswa='$id_siswa'";
    $log=$this->con->query($sql) or die($this->con->error);
    while ($data=$log->fetch_array()) {
        $hasil = $data['selesai'];
    }
    return $hasil;

  }
//&materi-----------------------------
  function v_siswa(){
    $id = $this->idsiswa();
    $sql="SELECT * FROM siswa WHERE id_siswa='$id'";
    $log=$this->con->query($sql) or die($this->con->error);
    $exec = mysqli_fetch_array($log);
    return $exec;
  }
  function v_siswa2(){
    $sql="SELECT id_siswa,id_kelas,idpk,level,ruang,sesi FROM siswa WHERE status_siswa=1 ";
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
  }
  //----------------Pangging Materi----------------------
  function paging($halaman,$materi2_mapel,$kodelv){
    $kelas = $_SESSION['id_kelas'];
    $result=$this->con->query("SELECT * FROM materi2 where materi2_mapel='$materi2_mapel' AND kode_level='$kodelv' ") or die($this->con->error);
    foreach ($result as $value) {
      $datakelas = unserialize($value['kelas']);
      if (in_array($kelas, $datakelas) or in_array('semua', $datakelas)){
        $array[]=$value;
      }
    } 
    $total = count($array);
    $pages = ceil($total/$halaman);
    return  $pages;
  }
  function halaman(){
    $halaman = 5;
    return $halaman;
  }
  function mulai($halaman){
    $page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
    $start = ($page - 1) * $halaman;
    return $start;
  }
  function get_materi($mulai,$halaman,$kelas,$guru, $level3, $idmapel3){ //DAFTAR MATERI
    $tglnow = strtotime(date("Y-m-d H:i:s"));
    $sql="SELECT *,materi2.kode_level AS kodelv FROM materi2 
    INNER JOIN mata_pelajaran ON materi2.materi2_mapel=mata_pelajaran.kode_mapel 
    WHERE materi2.kode_level='$level3' AND materi2_mapel='$idmapel3' ORDER BY materi2_tgl DESC LIMIT $mulai, $halaman";
    $query = $this->con->query($sql) or die($this->con->error);
    foreach ($query as $value) {
      $rilis = strtotime($value['materi2_tgl_rilis']);
      if($tglnow >=$rilis  ){
        $datakelas = unserialize($value['kelas']);
        if (in_array($kelas, $datakelas) or in_array('semua', $datakelas)){
          $array[]=$value;
        }
      }

    }
    return  $array;
  }
  function get_materi2($guru,$level,$idmapel2){ //untuk menjumlhakan materi
    $sql="SELECT COUNT(materi2_id) AS jml FROM materi2 
    WHERE id_guru=$guru AND kode_level='$level' AND materi2_mapel='$idmapel2'";
    $query = $this->con->query($sql) or die($this->con->error);
    $exec =$query->fetch_array();
    return $exec;
  }

  //---------------- / Pangging Materi----------------------
  function guru_materi($level){
    $sql="SELECT nama,id_guru,kelas,materi2.kode_level as kodelevel,materi2.materi2_mapel as idmapel2,nama_mapel FROM pengawas 
    INNER JOIN materi2 ON materi2.id_guru = pengawas.id_pengawas 
    INNER JOIN mata_pelajaran ON mata_pelajaran.kode_mapel = materi2.materi2_mapel 
    WHERE materi2.kode_level='$level' 
    GROUP BY materi2.materi2_mapel,id_guru";
    $query = $this->con->query($sql) or die($this->con->error);
    // foreach ($query as $value) {
    //   $datakelas = unserialize($value['kelas']);
    //   if (in_array($this->idkelas(), $datakelas) or in_array('semua', $datakelas)){
    //     $array[]=$value;
    //     echo'asd';
    //   }
    // }
    
    return  $query;
  }
  function baca_materi(){
    $id =$_GET['id']; 
    $guru = dekripsi($id);
    $idm=$_GET['idmateri']; 
    $idmateri = dekripsi($idm);

    try {
      //echo $this->RedisKoneksi()->ping();
      $sql="SELECT * FROM materi2 INNER JOIN mata_pelajaran ON materi2.materi2_mapel=mata_pelajaran.kode_mapel INNER JOIN pengawas ON materi2.id_guru = pengawas.id_pengawas WHERE materi2_id='$idmateri' and materi2.id_guru=$guru ";
      $log=$this->con->query($sql) or die($this->con->error);

      //proses cache ------------------------------------------------------------
      if($this->RedisKoneksi()->exists("baca_materi".$idmateri))
      {
        $array = json_decode($this->RedisKoneksi()->get("baca_materi".$idmateri));
        return $array;
      }
      else{
        $array = array();
        foreach ($log as $value) {
          $array[]=$value;
          
        }
        $data_json = json_encode($array);

        $this->RedisKoneksi()->set("baca_materi".$idmateri, $data_json);
        $this->RedisKoneksi()->expire("baca_materi".$idmateri,$this->WaktuLamaCache());
        //var_dump($array);
        
        return json_decode($data_json);
      } 
      //proses cache ------------------------------------------------------------
    }
    catch (Exception $e) { 
      $sql="SELECT * FROM materi2 INNER JOIN mata_pelajaran ON materi2.materi2_mapel=mata_pelajaran.kode_mapel INNER JOIN pengawas ON materi2.id_guru = pengawas.id_pengawas WHERE materi2_id='$idmateri' and materi2.id_guru=$guru ";
      $log=$this->con->query($sql) or die($this->con->error);
      $array = array();
        foreach ($log as $value) {
          $array[]=$value;
          
        }
        $data_json = json_encode($array);
        return json_decode($data_json);
    }   

  }
  function video_materi($guru2){
    if(empty($_GET['idvideo'])){ $id2=null; }else{ $id2=$_GET['idvideo']; }
    $id = dekripsi($id2);
    $guru = dekripsi($guru2);
    $sql="SELECT * FROM materi2 INNER JOIN mata_pelajaran ON materi2.materi2_mapel=mata_pelajaran.kode_mapel INNER JOIN pengawas ON materi2.id_guru = pengawas.id_pengawas WHERE materi2_id='$id' and materi2.id_guru=$guru ";
    $log=$this->con->query($sql) or die($this->con->error);
   $exec = mysqli_fetch_array($log);
    return $exec;
  }
  function next_materi(){
    $sql="SELECT MAX(materi2_id)as max FROM materi2";
    $log=$this->con->query($sql) or die($this->con->error);
    $exec = mysqli_fetch_array($log);
    return $exec;
    
  }
  function prev_materi(){
    $sql="SELECT MIN(materi2_id) as min FROM materi2";
    $log=$this->con->query($sql) or die($this->con->error);
    $exec = mysqli_fetch_array($log);
    return $exec;
  }
//asbensi ---------------------------------------------- 
  function getJamSekolah(){
    $sql="SELECT * FROM jam_skl";
    $log=$this->con->query($sql) or die($this->con->error);
    $exec = mysqli_fetch_array($log);
    return $exec;
  }
  //untuk ambil tahun di opsi pilihan
  function getTahun()
  {
    $sql ="SELECT DISTINCT YEAR(absTgl) AS tahun FROM absensi";
     $log=$this->con->query($sql) or die($this->con->error);
     return $log;
    
  }
  function getAbsenDetail()
  {
    @$tahun=$_GET['tahun'];
    @$bulan=$_GET['bulan']; 
    @$idsiswa=$_GET['siswa'];
    

    if(!empty($tahun)){
      $sql ="SELECT absId,absFoto,absUrlFoto,absIdSiswa,absTgl,absJamIn,absJamOut,absStatus,siswa.nama AS namasiswa,kelas.nama 
       FROM absensi 
       INNER JOIN siswa ON siswa.id_siswa=absensi.absIdSiswa
       INNER JOIN kelas ON kelas.idkls=absensi.absIdKelas 
       WHERE MONTH(absTgl)=$bulan AND YEAR(absTgl)=$tahun AND absIdSiswa=$idsiswa";
   
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
    }  
  }
  // //untuk cek absen cronjob
  // function getAbsenCronJob($idsiswa,$tgl)
  // {
   
  //   $sql ="SELECT * FROM absensi WHERE MONTH(absTgl)=$bulan AND YEAR(absTgl)=$tahun AND absIdSiswa=$idsiswa";
  //   $log=$this->con->query($sql) or die($this->con->error);
  //   return $log;
  //   }  
  // }
//asbensi Per Mapel ----------------------------------------
  function getAbsenMapel($idkelas=null,$hari=null)
  {
    if(empty($hari)){
      $where = " WHERE amKelas=$idkelas ";
    }
    else{
      $where=" WHERE amKelas=$idkelas AND amHari='$hari' ";
    }
   
        $sql ="SELECT * FROM absensi_mapel 
        INNER JOIN mata_pelajaran ON absensi_mapel.amIdMapel=mata_pelajaran.idmapel
        INNER JOIN pengawas ON absensi_mapel.amIdGuru=pengawas.id_pengawas
        INNER JOIN telegram_bot ON tlIdGuru=pengawas.id_pengawas
        $where ";
        $log=$this->con->query($sql) or die($this->con->error);
        
        return  $log;
      
  }
  function getAbsenMapel_by_siswa(){
    @$tahun=$_GET['tahun'];
    @$bulan=$_GET['bulan']; 
    @$idsiswa=$_GET['siswa'];
    @$mapel=$_GET['mapel'];
    //INNER JOIN mata_pelajaran ON mata_pelajaran.idmapel=absensi_mapel_anggota.amaIdMapel
    if(!empty($tahun)){
      $sql ="SELECT * FROM absensi_mapel_anggota
       INNER JOIN siswa ON siswa.id_siswa=absensi_mapel_anggota.amaIdSiswa
       WHERE MONTH(amaTgl)=$bulan AND YEAR(amaTgl)=$tahun AND amaIdSiswa=$idsiswa AND amaIdAbsenMapel=$mapel";
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;
    }  
  }
//Pengumuman --------------------------------
  function getPengumuman($kelas){
   
    $sql ="SELECT * FROM pengumuman INNER JOIN pengawas ON pengawas.id_pengawas=pengumuman.user
    where type='eksternal' ORDER BY date DESC ";
    $log=$this->con->query($sql) or die($this->con->error);
    return $log;


}
//Bot Telegram --------------------------------
  //----send to bot telegram absensi ---------------
  function KirimAbsenTelegram($pesan,$idbot,$idgrub,$nama2,$kelas2,$sekolah2,$nama_mapel){
    //silahakan modifikasi di bagian ini
    $nama = $nama2;
    $kelas = $kelas2;
    $date = date("d-m-Y");
    $jam = date("H:i:s");
    $title = $pesan;
    $sekolah = $sekolah2;
    
    //silahakan modifikasi di bagian ini
    //-----------------------------------------
    $message="<b><i>".$title."</i></b>%0A";
    $message.="<b>".$sekolah."</b>%0A";
    $message.="Mapel : <b>".$nama_mapel."</b>%0A";
    $message.="Nama : <b>".$nama."</b>%0A";
    $message.="Kelas : <b>".$kelas."</b>%0A";
    $message.="Tgl : ".$date."%0A";
    $message.="Jam : ".$jam."%0A";
    //-----------------------------------------
    
    //----------------------No Edit------------------------------------------------------
    $api = 'https://api.telegram.org/bot'.$idbot.'/sendMessage?chat_id='.$idgrub.'&text='.$message.'&parse_mode=HTML';

    $ch = curl_init($api); //inisialisasi awal curl
    curl_setopt($ch, CURLOPT_HEADER, false); // set url 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //return the transfer as a string 
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch); // $output contains the output string 
    curl_close($ch);
    //----------------------No Edit------------------------------------------------------

    return $api;

  }
  function KirimAbsenTelegram2($pesan,$idbot,$idgrub,$nama2,$kelas2,$sekolah2){
    //silahakan modifikasi di bagian ini
    $nama = $nama2;
    $kelas = $kelas2;
    $date = date("d-m-Y");
    $jam = date("H:i:s");
    $title = $pesan;
    $sekolah = $sekolah2;
    $status = 'Hadir';
   
    //silahakan modifikasi di bagian ini
    //-----------------------------------------
    $message="<b><i>".$title."</i></b>%0A";
    $message.="<b>".$sekolah."</b>%0A";
    $message.="Nama : <b>".$nama."</b>%0A";
    $message.="Kelas : <b>".$kelas."</b>%0A";
    $message.="Status : <b>".$status."</b>%0A";
    $message.="Tgl : ".$date."%0A";
    $message.="Jam : ".$jam."%0A";
    //-----------------------------------------
    
    //----------------------No Edit------------------------------------------------------
    $api = 'https://api.telegram.org/bot'.$idbot.'/sendMessage?chat_id='.$idgrub.'&text='.$message.'&parse_mode=HTML';

    $ch = curl_init($api);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close($ch);
    //----------------------No Edit------------------------------------------------------

    return $api;

  }
  function CekAktifSend(){
    $sql="SELECT * FROM bot_telegram WHERE botId=1";
    $log=$this->con->query($sql) or die($this->con->error);
    $exec = mysqli_fetch_array($log);
    return $exec;
  }
}
