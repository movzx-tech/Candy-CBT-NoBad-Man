<?php 

//-------------Jika di Localhost-----------------
$uri = $_SERVER['REQUEST_URI'];
$pageurl = explode("/", $uri);
if ($uri == '/') {
    $homeurl = "http://" . $_SERVER['HTTP_HOST'];
    (isset($pageurl[1])) ? $pg = $pageurl[1] : $pg = '';
    (isset($pageurl[2])) ? $ac = $pageurl[2] : $ac = '';
    (isset($pageurl[3])) ? $id = $pageurl[3] : $id = 0;
} else {
    $homeurl = "http://" . $_SERVER['HTTP_HOST'] . "/" . $pageurl[1];
    (isset($pageurl[2])) ? $pg = $pageurl[2] : $pg = '';
    (isset($pageurl[3])) ? $ac = $pageurl[3] : $ac = '';
    (isset($pageurl[4])) ? $id = $pageurl[4] : $id = 0;
}

//-------------Jika di Localhost-----------------

//---Matikan Salah Satu 

//-------------Jika di Hosting-----------------
//$uri = $_SERVER['REQUEST_URI'];
//$pageurl = explode("/",$uri);

//$homeurl = "http://".$_SERVER['HTTP_HOST']; //---tambah s pada http jika web sudah mendukung https
//(isset($pageurl[1])) ? $pg = $pageurl[1] : $pg = '';
//(isset($pageurl[2])) ? $ac = $pageurl[2] : $ac = '';
//(isset($pageurl[3])) ? $id = $pageurl[3] : $id = 0;
//-------------Jika di Hosting-----------------

$crew ='crew';
$linkguru = 'guru'; //untuk menuju ke folder guru
$serverApiKu='server_api';

require "config.database.php";
$setting = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM setting WHERE id_setting='1'"));

//time CBT ------------------------------------
$no = $jam = $mnt = $dtk = 0;
$info = '';
$waktu = date('H:i:s');
$tanggal = date('Y-m-d');
$datetime = date('Y-m-d H:i:s');
//------------------------------------

?>