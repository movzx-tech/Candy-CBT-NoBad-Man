<?php
require "../config/config.default.php";
require "../config/config.function.php";

if($token == $token1) {


(isset($_SESSION['id_pengawas'])) ? $id_pengawas = $_SESSION['id_pengawas'] : $id_pengawas = 0;
    ($id_pengawas==0) ? header('location:index.php'):null;

$alamat = nl2br($_POST['alamat']);
$header = nl2br($_POST['header']);

// mryes

if(!empty($_POST['XProv'])){ $prop = $_POST['XProv']; }else{ $prop=null; }
if(!empty($_POST['XKab'])){ $kab = $_POST['XKab']; }else{ $kab=null; }
if(!empty($_POST['XKec'])){ $kec  = $_POST['XKec']; }else{ $kec =null; }

if(!empty($_POST['db_token'])){ $token  = $_POST['db_token']; }else{ $db_token =null; }
if(!empty($_POST['db_token1'])){ $token1  = $_POST['db_token1']; }else{ $db_token1 =null; }

if(!empty($_POST['XProv'])){
$sql1 = mysqli_query($koneksi,"SELECT * from inf_lokasi where lokasi_kabupatenkota='$kab' and lokasi_propinsi='$prop' and lokasi_kecamatan='0000' and lokasi_kelurahan='0000'");
$xadm1 = mysqli_fetch_array($sql1);
$xkab= $xadm1['lokasi_nama'];

$sql2 = mysqli_query($koneksi,"SELECT * from inf_lokasi where lokasi_kecamatan='$kec' and lokasi_kabupatenkota='$kab' and lokasi_propinsi='$prop' and lokasi_kelurahan='0000'");
$xadm2 = mysqli_fetch_array($sql2);
$xkec= $xadm2['lokasi_nama'];


$sql3 = mysqli_query($koneksi,"SELECT * from inf_lokasi where lokasi_propinsi='$prop' and lokasi_kecamatan='00' and lokasi_kelurahan='0000' and lokasi_kabupatenkota='00'");
$xadm3 = mysqli_fetch_array($sql3);
$xprop= $xadm3['lokasi_nama'];
}
else{
    $xkab =$_POST['kab1'];
    $xkec =$_POST['kec1'];
}

$protek = $_POST['protek'];
$nip_protek = $_POST['nip_protek'];
$izin_pass = $_POST['izin_pass'];
$izin_materi = $_POST['izin_materi'];
$izin_tugas = $_POST['izin_tugas'];
$izin_info = $_POST['izin_info'];
$izin_ujian = $_POST['izin_ujian'];
$izin_absen = $_POST['izin_absen'];
$izin_absen_mapel = $_POST['izin_absen_mapel'];
$pjj = $_POST['pjj'];
$izi_foto_absen = $_POST['izi_foto_absen'];
$mainten = $_POST['mainten'];

$folder_baru = $_POST['folder_baru'];
$judul_pesan = $_POST['judul_pesan'];
$isi_pesan = $_POST['isi_pesan'];


//mryes
if(!empty($_POST['aplikasi'])){ $apliaksi = $_POST['aplikasi']; }else{ $apliaksi=null; }
if(!empty($_POST['sekolah'])){ $sekolah = $_POST['sekolah']; }else{ $sekolah=null; }
if(!empty($_POST['kode'])){ $kode_skl = $_POST['kode']; }else{ $kode_skl=null; }
if(!empty($_POST['jenjang'])){ $jenjang = $_POST['jenjang']; }else{ $jenjang=null; }

if($sekolah==null and $apliaksi==null and $kode_skl==null and $jenjang==null){
  echo"Cek Lagi Datanya ";
}
else{
$exec = mysqli_query($koneksi, "UPDATE setting SET aplikasi='$_POST[aplikasi]',sekolah='$_POST[sekolah]',kode_sekolah='$_POST[kode]',jenjang='$_POST[jenjang]',kepsek='$_POST[kepsek]',nip='$_POST[nip]',alamat='$alamat',kecamatan='$xkec',kota='$xkab',telp='$_POST[telp]',fax='$_POST[fax]',web='$_POST[web]',email='$_POST[email]',header='$header',ip_server='$_POST[ipserver]',waktu='$_POST[waktu]',XProv='$prop',XKab='$kab',XKec='$kec',db_token='$token',db_token1='$token1',protek='$protek',nip_protek='$nip_protek',izin_pass='$izin_pass',izin_materi='$izin_materi',izin_tugas='$izin_tugas',izin_ujian='$izin_ujian',izin_info='$izin_info',folder_admin='$folder_baru',namapjj='$pjj',izin_absen='$izin_absen',izin_absen_mapel='$izin_absen_mapel',izi_foto_absen='$izi_foto_absen',LoginSiswaMainten='$mainten',IsiPesanSingkat='$isi_pesan',JudulPesanSingkat='$judul_pesan' WHERE id_setting='1'");
}
if ($exec ==true) {

    $extensionList = ['png','jpg','jpeg'];

    if ($_FILES['logo']['name'] <> '') {
          
            $logo = $_FILES['logo']['name'];
            $temp = $_FILES['logo']['tmp_name'];
            $ext1 = explode('.', $logo);
            $ext = end($ext1);

            $ekstensi = $ext1[1]; //ambil extensionya
          
          if(in_array($ekstensi, $extensionList)){
            if ($logo == "") {
            echo "Fatal Error";
            }
            else{ 
                $dest = 'dist/img/logo' . rand(1, 100) . '.' . $ext;
                $upload = move_uploaded_file($temp, '../' . $dest);
                if ($upload) {
                    $exec = mysqli_query($koneksi, "UPDATE setting SET logo='$dest' WHERE id_setting='1'");
                } else {
                    echo "gagal";
                }
              }
          }
          else{
            echo"File Extension Tidak Sesuai";
          }
    }
    if ($_FILES['ttd']['name'] <> '') {
        $logo = $_FILES['ttd']['name'];
        $temp = $_FILES['ttd']['tmp_name'];
        $ext1 = explode('.', $logo);
        $ext = end($ext1);

        $ekstensi = $ext1[1]; //ambil extensionya
          if(in_array($ekstensi, $extensionList)){
            if ($logo == "") {
            echo "Fatal Error";
            }
            else{
              $dest = 'dist/img/ttd'.'.'.$ext;
              $upload = move_uploaded_file($temp, '../' . $dest);
            }
          }
          else{
            echo"File Extension Tidak Sesuai";
          }
            
    }
    if ($_FILES['instansi']['name'] <> '') {
        $logo = $_FILES['instansi']['name'];
        $temp = $_FILES['instansi']['tmp_name'];
        $ext1 = explode('.', $logo);
        $ext = end($ext1);
       
        $ekstensi = $ext1[1]; //ambil extensionya
        if(in_array($ekstensi, $extensionList)){
          if ($logo == "") {
            echo "Fatal Error";
          }
          else{
              $dest = 'dist/img/logo2'.'.'.$ext;
              $upload = move_uploaded_file($temp, '../' . $dest);
          }
        }
        else{
            echo"File Extension Tidak Sesuai";
          }


    }
    if ($_FILES['login_admin']['name'] <> '') {
        $logo = $_FILES['login_admin']['name'];
        $temp = $_FILES['login_admin']['tmp_name'];
        $ext1 = explode('.', $logo);
        $ext = end($ext1);

        $ekstensi = $ext1[1]; //ambil extensionya
          if(in_array($ekstensi, $extensionList)){
            if ($logo == "") {
            echo "Fatal Error";
            }
            else{
              $dest = 'dist/img/loginadmin'.'.'.$ext;
              $upload = move_uploaded_file($temp, '../' . $dest);
            }
          }
          else{
            echo"File Extension Tidak Sesuai";
          }
            
    }
    if ($_FILES['login_siswa']['name'] <> '') {
        $logo = $_FILES['login_siswa']['name'];
        $temp = $_FILES['login_siswa']['tmp_name'];
        $ext1 = explode('.', $logo);
        $ext = end($ext1);

        $ekstensi = $ext1[1]; //ambil extensionya
          if(in_array($ekstensi, $extensionList)){
            if ($logo == "") {
            echo "Fatal Error";
            }
            else{
              $dest = 'dist/img/loginsiswa'.'.'.$ext;
              $upload = move_uploaded_file($temp, '../' . $dest);
            }
          }
          else{
            echo"File Extension Tidak Sesuai";
          }
            
    }
    
} else {
    echo "Gagal menyimpan";
}

}
else{
  jump("$homeurl");
  //echo"keluar";
}