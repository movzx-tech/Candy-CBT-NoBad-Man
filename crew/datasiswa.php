<?php
//setting up one redis-----------------------------------------
require "../vendor/autoload.php";
use RedisClient\RedisClient;
use RedisClient\Client\Version\RedisClient2x6;
use RedisClient\ClientFactory;

$Redis = new RedisClient();

//setting up one redis-----------------------------------------

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
	include '../config/config.default.php';

	try { 
		if($Redis->exists("siswaall"))
     {
     	$jsonResult = $Redis->get("siswaall");
      echo $jsonResult;
     }else{
     	$query = mysqli_query($koneksi, "SELECT * FROM siswa ORDER BY nama ASC");
			$jsonResult = '{"data" : [ ';
			$i = 0;
			while ($data = mysqli_fetch_assoc($query)) {
				if ($i != 0) {
					$jsonResult .= ',';
				}
				$jsonResult .= json_encode($data);
				$i++;
			}
			$jsonResult .= ']}';
			$Redis->set("siswaall",$jsonResult);
			$Redis->expire("siswaall",60);
			echo $jsonResult;
		 }//end if
	}//end try
	catch (Exception $e) { 
		$query = mysqli_query($koneksi, "SELECT * FROM siswa ORDER BY nama ASC");
		$jsonResult = '{"data" : [ ';
		$i = 0;
		while ($data = mysqli_fetch_assoc($query)) {
			if ($i != 0) {
				$jsonResult .= ',';
			}
			$jsonResult .= json_encode($data);
			$i++;
		}
		$jsonResult .= ']}';
		
		
		echo $jsonResult;
	} 
} else {
	echo '<script>window.location="404.html"</script>';
}

