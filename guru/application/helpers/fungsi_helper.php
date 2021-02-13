<?php
function HariIndo($hari)
 {
   $daftar_hari = array(
     'Sunday' => 'Minggu',
     'Monday' => 'Senin',
     'Tuesday' => 'Selasa',
     'Wednesday' => 'Rabu',
     'Thursday' => 'Kamis',
     'Friday' => 'Jumat',
     'Saturday' => 'Sabtu'
   );
   return $daftar_hari[$hari];
 } 
function selectAktif($data1=null,$data2=null)
{
    //untuk select option
    $selected = 'selected="selected"';
    if(!$data1==null){
        if($data1==$data2){ echo $selected;  }else{ echo"";}
    }
} 
function bulanIndo($bulan) {
  switch ($bulan) {
    case '1':
      return 'Januari';
    case '2':
      return 'Februari';
    case '3':
      return 'Maret';
    case '4':
      return 'April';
    case '5':
      return 'Mei';
    case '6':
      return 'Juni';
    case '7':
      return 'Juli';
    case '8':
      return 'Agustus';
    case '9':
      return 'September';
    case '10':
      return 'Oktober';
    case '11':
      return 'November';
    case '12':
      return 'Desember';
    default:
      return 'Bulan tidak valid';
  }
}
  function buat_tanggal($format, $time = null)
  {
    $time = ($time == null) ? time() : strtotime($time);
    $str = date($format, $time);
    for ($t = 1; $t <= 9; $t++) {
      $str = str_replace("0$t ", "$t ", $str);
    }
    $str = str_replace("Jan", "Januari", $str);
    $str = str_replace("Feb", "Februari", $str);
    $str = str_replace("Mar", "Maret", $str);
    $str = str_replace("Apr", "April", $str);
    $str = str_replace("May", "Mei", $str);
    $str = str_replace("Jun", "Juni", $str);
    $str = str_replace("Jul", "Juli", $str);
    $str = str_replace("Aug", "Agustus", $str);
    $str = str_replace("Sep", "September", $str);
    $str = str_replace("Oct", "Oktober", $str);
    $str = str_replace("Nov", "Nopember", $str);
    $str = str_replace("Dec", "Desember", $str);
    $str = str_replace("Mon", "Senin", $str);
    $str = str_replace("Tue", "Selasa", $str);
    $str = str_replace("Wed", "Rabu", $str);
    $str = str_replace("Thu", "Kamis", $str);
    $str = str_replace("Fri", "Jumat", $str);
    $str = str_replace("Sat", "Sabtu", $str);
    $str = str_replace("Sun", "Minggu", $str);
    return $str;
  }
  function lamaujian($seconds)
  {

    if ($seconds) {
      $gmdate = gmdate("z:H:i:s", $seconds);
      $data = explode(":", $gmdate);

      $string = isset($data[0]) && $data[0] > 0 ? $data[0] . " Hari" : "";
      $string .= isset($data[1]) && $data[1] > 0 ? $data[1] . " Jam " : "";
      $string .= isset($data[2]) && $data[2] > 0 ? $data[2] . " Menit " : "";
            // $string .= isset($data[3]) && $data[3] > 0 ? $data[3] . " Detik " : "";
    } else {
      $string = '--';
    }
    return $string;
  }
?>