<?php
//require("../config/m_admin.php");
require("../config/config.function.php");
require("../config/functions.crud.php");
include("core/c_admin.php"); 

$db= new Budut(); // panggil model 

function tbAbsensi(){ return 'absensi'; }

if($token == $token1)
{
	if(isset($_GET['adm'])){
//&1.tombol selesai -------------------------------------
	   if($_GET['adm']=="tombol_selesai"){
			$cek = $db->tombol_selesai_paksa();
			echo $cek;
		}
		elseif($_GET['adm']=="kunci_tombol_selesai"){
			$cek = $db->kunci_tombol_selesai_paksa();
			echo $cek;
		}
		elseif($_GET['adm']=="cek_siswa"){
			$kls = $_POST['kelas'];
			$ujian = $_POST['ujian'];
			$jrs = $_POST['jrs'];
			$cek = $db->siswa_tidak_ujian($kls,$jrs,$ujian);
			echo $cek;
		}
		else{
			echo 100;
		}

	} //END isset($_GET['adm'])
	if(isset($_GET['esai'])){
//&2. Nilai Essai-------------------------------------
		if($_GET['esai']=="oke"){
			
			$id_nilai =$_POST['id_nilai'];
			$id_ujian =$_POST['id_ujian'];
			$id_mapel =$_POST['id_mapel'];
			$id_siswa =$_POST['id_siswa'];
			$bobot =$_POST['bobot'];

			if(isset($_POST)){
				$id = $_POST;
				//hapus array yang bukan nilia dari soal esai
				unset($id['bobot']);
				unset($id['id_ujian']);
				unset($id['id_mapel']);
				unset($id['id_nilai']);
				unset($id['id_siswa']);

				$esai_total=0;
				foreach ($id as $key => $value) {
					$esai_total += $value;
				}
				$nilai_essai = serialize($id);

			}

			$total = ($esai_total*$bobot)/100;
			
			
			$data_nilai = array(
				'nilai_esai2' => $nilai_essai,
				'nilai_esai' => $total
			);
			$where = array(
				'id_nilai' =>$id_nilai,
				'id_ujian' =>$id_ujian,
				'id_mapel' =>$id_mapel,
				'id_siswa' =>$id_siswa
			);
			
			$tabel='nilai';

			$exc = $db->update($tabel,$data_nilai,$where);
			if($exc == 1){
				echo $exc;
			}
			else{
				echo $exc;
			}
			
			//print_r($data_nilai);
		}
	}
//&3.Materi -----------
	if(isset($_GET['nilai'])){
		if($_GET['nilai']=='remidi'){
			$id = $_POST;
			
			$where = array(
				// 'id_siswa' => $id['id_siswa'],
				// 'id_mapel' => $id['id_mapel']
				'id_nilai' => $id['id_nilai']
			);
			
			$total = ($id['pg'] + $id['esai'] );
			
			$data= array(
				'jml_benar' => $id['jml_bener'],
				'jml_salah' => $id['jml_salah'],
				'skor' => $id['pg'],
				'nilai_esai' => $id['esai'],
				'total' => $total
			);
			
			$tabel ='nilai';
			
			
			$exc = $db->update($tabel,$data,$where);
			if($exc == 1){
				echo $exc;
			}
			else{
				echo $exc;
			}
		}
		//update nilai 0
		if($_GET['nilai']=='nilai_update'){
			$id = $_POST;
			
			$data= array(
				'jml_benar' => $id['benar'],
				'jml_salah' => $id['salah'],
				'skor' => $id['nilai'],
				'total' => $id['nilai'],
				'jawaban' =>$id['sejawab'],
				'jawaban_esai'=>$id['sejawabesai'],
			);
			
			$where = array(
				'id_siswa' => $id['idsiswa'],
				'id_mapel' => $id['idmapel'],
				'id_ujian' => $id['idujian'],
			);
			$tabel ='nilai';
			$exc = $db->update($tabel,$data,$where);
			if($exc == 1){
				echo $exc;
			}
			else{
				echo $exc;
			}

		}

		else{

		}
	}

	if(isset($_GET['hapus'])){
		if($_GET['hapus']=='history'){
			//$id = $_POST;
			$tabel ="jawaban_copy";
			$exc = $db->truncate($tabel);
			if($exc == 1){
				echo $exc; //out 1
			}
			else{
				echo $exc; //out 0
			}
		}
		else if($_GET['hapus']=='redis'){ //hapus all cache redis
			
			//$exc = $db->DelRedisAll();
			echo $_POST['id'];
		}
		else{
			echo 100;
		}
	}

	
//&4.Materi -----------
	if(isset($_GET['materi'])){
		if($_GET['materi']=='cari_mapel'){
			$tabel ="mata_pelajaran";
			$where = array(
				'kode_level' => $_POST['id']
			);
			$exc = $db->cari_data_byid($tabel,$where);
		}
	}
//&5.Absen -----------
	if(isset($_GET['absen'])){
		if($_GET['absen']=='getabsen'){
			$exc = $db->getAbsen($_POST['tahun'],$_POST['bulan'],$_POST['kelas']);
		}
		else if($_GET['absen']=='getsiswa'){
			$kelas = $db->v_kelas2($_POST['id']);
			foreach ($kelas as $kls) {
				$idkelas = $kls['id_kelas'];
			}
			$idjrs='semua';
			$siswas = $db->v_siswa($idkelas,$idjrs);
			foreach ($siswas as $siswa) {
				$data = array(
					'idsiswa' => $siswa['id_siswa'],
					'namasiswa' => $siswa['nama'],
				);
				$data2[]=$data;
			}
			echo json_encode($data2);
		}
		else if($_GET['absen']=='upabsen'){ //update asbensi siswa
			// print_r($_POST);
			$status_asben = $_POST['status_absen'];
			$idsiswa = $_POST['idsiswa'];
			$jam = $db->getJamSkl();
				if($status_asben =='H'){
					$jamin=date($jam['jamIn']);
					$jamout=date($jam['jamOut']);
					$jenis=1;
				}
				else if($status_asben =='T'){
					$jamin=date($jam['jamTerlambat']);
					$jamout=date($jam['jamOut']);
					$jenis=1;
				}
				else if($status_asben =='S'){
					$jamin=date($jam['jamAlpah']);
					$jamout=date($jam['jamAlpah']);
					$jenis=2;
				}
				else if($status_asben =='I'){
					$jamin=date($jam['jamAlpah']);
					$jamout=date($jam['jamAlpah']);
					$jenis=2;
				}
				else if($status_asben =='A'){
					$jamin=date($jam['jamAlpah']);
					$jamout=date($jam['jamAlpah']);
					$jenis=2;
				}
				else{
					$jamin=date('07:30');
					$jamout=date($jam['jamAlpah']);
					$jenis=1;
				}
				$data = array(
					'absJamIn'	=>$jamin,
					'absJamOut'	=>$jamout,
					'absStatus'	=>$status_asben,
					'absJenis'	=>$jenis,
				);
				$where = array(
					'absId'	=>$idsiswa
				);

				$exc = $db->update(tbAbsensi(),$data,$where);
				if($exc == 1){
					echo $exc;
				}
				else{
					echo $exc;
				}

		}
		else if($_GET['absen']=='delabsen'){
			$idabsen = $_POST['idabsen'];
			$where = array('absId'	=>$idabsen);
			$exc = $db->delete(tbAbsensi(),$where);
			if($exc == 'OK'){
					echo 1;
				}
				else{
					echo 0;
				}
			
		}
		else if($_GET['absen']=='jamabsen'){
			$data = array(
					'jamIn'	=>$_POST['jamin'],
					'jamOut'	=>$_POST['jamout'],
					'jamAlpah'	=>$_POST['jamalpa'],
					'jamTerlambat'	=>$_POST['jamterlambat'],
				);
				$where = array(
					'jmId'	=>$_POST['jamid']
				);
			$exc = $db->update('jam_skl',$data,$where);
			if($exc == 1){
					echo $exc;
				}
				else{
					echo $exc;
				}
		}
		else if($_GET['absen']=='tahunabsen'){
			$data = array(
					'thKode'	=>$_POST['kodetahun'],
					'thNama'	=>$_POST['namatahun'],
				);
			
			$table='tahun';
			
			$exc = $db->insert($table,$data);
			if($exc == 1){
					echo $exc;
				}
				else{
					echo $exc;
				}
		}
		else if($_GET['absen']=='updatetahun'){
			$data = array(
					'thKode'	=>$_POST['kode'],
					'thNama'	=>$_POST['nama'],
					'thAktif'	=>$_POST['status'],
				);

			$where = array(
					'thId'	=>$_POST['id']
				);
			
			$table='tahun';
			
			$exc = $db->update($table,$data,$where);
			if($exc == 1){
					echo $exc;
				}
				else{
					echo $exc;
				}
		}
		else if($_GET['absen']=='deletetahun'){
			$table='tahun';
			$id = $_POST['id'];
			$where = array('thId'	=>$id);
			
			$exc = $db->delete($table,$where);
			if($exc == 'OK'){
					echo 1;
				}
				else{
					echo 0;
				}
		}
		else{

		}
	}
//&6.Absen perMapel-----------
	if(isset($_GET['absen_mapel'])){
		if($_GET['absen_mapel']=='insert'){
			$table='absensi_mapel';
			$mapel = $db->getMata_pelajaran($_POST['mapel']);
			$datamapel = mysqli_fetch_assoc($mapel);
			//-------------------
			if($_SESSION['level']=='admin'){
				$idguru = $_POST['idguru'];
			}
			else{
				$idguru = $_SESSION['id_pengawas'];
			}
			$data=array(
				'amKelas'	=>$_POST['idkelas'],
				'amIdMapel'=>$_POST['mapel'],
				'amIdGuru'=>$idguru,
				'amNamaMapel'=>$datamapel['nama_mapel'],
				'amSlag'=>$datamapel['nama_mapel'],
				'amJamMulai'=>$_POST['jamin'],
				'amJamAkhir'=>$_POST['jamout'],
				'amHari'=>$_POST['hari'],
			);
			//-----------
			$where= array(
				'amIdMapel'=>$_POST['mapel'],
				'amIdGuru'=>$_SESSION['id_pengawas'],
				'amKelas'	=>$_POST['idkelas'],
				'amHari'	=>$_POST['hari'],
			);
			$cek = $db->fetch($table,$where);
			if(count($cek) > 1){ echo 99; }
			else{
				
				$exc =  $db->insert($table,$data);
				if($exc == 1){ echo $exc; }else{ echo $exc; }
			}
			
		}
		else if($_GET['absen_mapel']=='update'){
			$table='absensi_mapel';
			$data=array(
				'amSlag'=>$_POST['mapel'],
				'amJamMulai'=>$_POST['jamin2'],
				'amJamAkhir'=>$_POST['jamout2'],
				'amHari'=>$_POST['hari2'],
			);
			//-----------
			$where= array('amId'=>$_POST['id']);
		
			$exc = $db->update($table,$data,$where);
			if($exc == 1){ echo $exc; }else{ echo $exc; }
			
		}
		else if($_GET['absen_mapel']=='delet'){
			$table='absensi_mapel';
			
			$where= array('amId'=>$_POST['id']);
			$exc = $db->delete($table,$where);
			if($exc == 'OK'){ echo 1; }else{ echo 0; }
		}
		else if($_GET['absen_mapel']=='getkelas'){
			//print_r($_POST);
			return $db->kelas_by_level($_POST['idlevel']);
		}
		else if($_GET['absen_mapel']=='getmapel'){
			return $db->getMata_pelajaran_by_level($_POST['idlevel']);
		}
		else{

		}
	}
//&7.Kelas-------------------------------------------------------
	if(isset($_GET['kelas'])){
		if($_GET['kelas']=='getkelas'){
			return $db->kelas_by_level($_POST['idlevel']);
		}
	}
//&8.Bot Telegram-------------------------------------------------------
	if(isset($_GET['telegram'])){
		if($_GET['telegram']=='addchatid'){
			$where= array(
				'tlIdGuru'=>$_POST['idguru'],
			);
			$data=array(
				'tlChatId'	=>$_POST['chatid'],
				//'tlNama'=>$_POST['mapel'],
				'tlIdBotTelegram'=>1,
				'tlIdGuru'=>$_POST['idguru'],
			);
			$cek = $db->fetch('telegram_bot',$where);
			if(count($cek) > 1){ echo 99; }
			else{
				$exc =  $db->insert('telegram_bot',$data);
				echo $exc;
			}
		}
		else if($_GET['telegram']=='updatechatid'){
			$where= array(
				'tlId'=>$_POST['id'],
			);
			$data=array(
				'tlChatId'	=>$_POST['chatid'],
			);
			$exc = $db->update('telegram_bot',$data,$where);
			echo $exc;

		}
		else if($_GET['telegram']=='addbottelegram'){
			$where= array(
				'botId'=>1,
			);
			$data=array(
				'botToken'	=>$_POST['bot_token'],
				'botChatId'	=>$_POST['id_grub'],
			);
			$exc = $db->update('bot_telegram',$data,$where);
			echo $exc;
		}
		else if($_GET['telegram']=='hapustelegram'){
			$where= array(
				'tlId'=>$_POST['id'],
			);
			$exc = $db->delete('telegram_bot',$where);
			if($exc == 'OK'){ echo 1; }else{ echo 0; }
		}
		else if($_GET['telegram']=='aktifsend'){
			if($_POST['id']=='mapel'){ $kolom ='botSendAbsenMapel';}
			else if($_POST['id']=='sekolah'){ $kolom ='botSendAbsenSekolah';}
			else if($_POST['id']=='tugas'){ $kolom ='botSendTugas';}
			else{}
			$where= array(
				'botId'=>1,
			);
			$data=array(
				$kolom =>$_POST['aksi'],
			);
			$exc = $db->update('bot_telegram',$data,$where);
			echo $exc;
		}
		else{ }
	}
//&9.Absen Siswa Mapel --------------------------------------------
	if(isset($_GET['absen_mapel_siswa'])){
		if($_GET['absen_mapel_siswa']=='insert'){
			//print_r($_POST);
		  $table='absensi_mapel_anggota';
			$mapel = $db->getMapelAbsen($_POST['kodemapel']); //cari jam masuk mapel
			foreach ($mapel as $value) {
				$jamMulai = $value['amJamMulai'];
			}
			
			$idsiswa = $_POST['idsiswa'];
			$tgl = date("Y-m-d",strtotime($_POST['tgl']));

			$jml = count($idsiswa);
			for ($i=0; $i <$jml ; $i++) { 
	      $data=array(
	        'amaIdAbsenMapel'=> $_POST['idabsenmapel'],
	        'amaIdKelas'=> $_POST['idkelas'],
	        'amaIdMapel'=> $_POST['kodemapel'],
	        'amaIdSiswa'=> $idsiswa[$i],
	        'amaTgl'=> $tgl ,
	        'amaJamIn'=> $jamMulai,
	        'amaStatus'=> 'H',

	      );
	      $where=array(
	      	'amaTgl' => $tgl,
	      	'amaIdSiswa' =>$idsiswa[$i],
	      	'amaIdMapel'=>$_POST['kodemapel'],
	      	);

	      $cek = $db->fetch($table,$where);
	      if(count($cek) > 1){ }
				else{
					$exc =  $db->insert($table,$data);
	      }
     	 	
    	} //end for
    
    	echo($exc);
			
		}
		else if($_GET['absen_mapel_siswa']=='izin'){
			$table='absensi_mapel_anggota';
			// $mapel = $db->getMapelAbsen($_POST['kodemapel']); //cari jam masuk mapel
			// foreach ($mapel as $value) {
			// 	$jamMulai = $value['amJamMulai'];
			// }
			//untuk absen sekolah ------------------------
			$status_asben = $_POST['ket'];
			$jam = $db->getJamSkl();
				if($status_asben =='H'){
					$jamin=date($jam['jamIn']);
					$jamout=date($jam['jamOut']);
					$jenis=1;
				}
				else if($status_asben =='T'){
					$jamin=date($jam['jamTerlambat']);
					$jamout=date($jam['jamOut']);
					$jenis=2;
				}
				else if($status_asben =='S'){
					$jamin=date($jam['jamAlpah']);
					$jamout=date($jam['jamAlpah']);
					$jenis=2;
				}
				else if($status_asben =='I'){
					$jamin=date($jam['jamAlpah']);
					$jamout=date($jam['jamAlpah']);
					$jenis=2;
				}
				else if($status_asben =='A'){
					$jamin=date($jam['jamAlpah']);
					$jamout=date($jam['jamAlpah']);
					$jenis=2;
				}
				else{
					$jamin=date('07:30');
					$jamout=date($jam['jamAlpah']);
					$jenis=2;
				}
			//untuk absen sekolah ------------------------


			$idsiswa = $_POST['idsiswa'];
			$tgl = date("Y-m-d",strtotime($_POST['tgl']));
			$jml = count($idsiswa);
			for ($i=0; $i <$jml ; $i++) { 
	      $data=array(
	        'amaIdAbsenMapel'=> $_POST['idabsenmapel'],
	        'amaIdKelas'=> $_POST['idkelas'],
	        'amaIdMapel'=> $_POST['kodemapel'],
	        'amaIdSiswa'=> $idsiswa[$i],
	        'amaTgl'=> $tgl ,
	        'amaJamIn'=> '00:00:00',
	        'amaStatus'=> $status_asben,
	        'amaKeterangan'=> $_POST['ktrs'],

	      );
	      $where=array(
	      	'amaTgl' => $tgl,
	      	'amaIdSiswa' =>$idsiswa[$i],
	      	'amaIdMapel'=>$_POST['kodemapel'],
	      );

	      //cek kondisi absen sekolah---------
	      $table2 = 'absensi';
	      $where_skl=array(
	      	'absTgl' => $tgl,
	      	'absIdSiswa' =>$idsiswa[$i],
	      );
	      $data_skl=array(
	      	'absTgl' => $tgl,
	      	'absIdSiswa' =>$idsiswa[$i],
	      	'absIdKelas'=> $_POST['idkelas'],
	      	'absStatus'=> $status_asben,
	      	'absJamIn'=> $jamin,
	      	'absJamOut'=> $jamout,
	      	'absJenis'=> $jenis,
	      	'absKeterangan'=> $_POST['ktrs'],
	      );
	      //cek kondisi absen sekolah---------

	      $cek = $db->fetch($table,$where);
	      if(count($cek) > 1){ }
				else{
					$exc =  $db->insert($table,$data);

					$cek2 = $db->fetch($table2,$where_skl); //cek absen sekolah
					if(count($cek2) > 1){ $db->update($table2,$data_skl,$where_skl); }
					else{ $db->insert($table2,$data_skl); }
					
	      }
     	 	
    	} //end for
    
    	echo($exc);

		}
		else{ }

	}



} //end if token

else{
	jump("$homeurl");
	
}




