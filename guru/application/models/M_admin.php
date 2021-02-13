<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_admin extends CI_model {

	function __construct(){
    parent::__construct(); 
    $this->db->protect_identifiers('pengawas', TRUE);
  }
  function cache($id){
    $this->output->cache($id); 
  }
  

  //CRUD ALL-----------------------------------
  public function tambah_data($tabel,$data){
    $query = $this->db->insert($tabel,$data);
    if($query==true){ return 1; }else{ return 0;}
  }
  public function tambah_data_array($tabel,$data){
    $query = $this->db->insert_batch($tabel,$data);
  }
  public function update_data($where,$data,$tabel){ 
    $this->db->where($where);
    $query =$this->db->update($tabel, $data);
    if($query==true){ return 1; }else{ return 0;}
  }
  public function hapus_semua($tabel,$where){ 
    $this->db->where($where);
    $query = $this->db->delete($tabel);
    if($query==true){ return 1; }else{ return 0;}
  }

  
//&ujian -------------------------------------------------------------------  
  public function get_ujian()
  {
    $this->db->select('id_ujian,ujian.id_mapel as mapel,ujian.nama as nama');
    $this->db->from('ujian');
    $this->db->join('mapel', 'mapel.id_mapel = ujian.id_mapel','INNER');
    return $this->db->get()->result();
  }
  function siswa_noujian($ujian,$kelas){
    $siswa = $this->db->get_where('siswa', array('id_kelas' => $kelas))->result();
    foreach ($siswa as $data) {
      $idsiswa =  $data->id_siswa;
      $cek = $this->db->get_where('nilai', array('id_ujian' => $ujian,'id_siswa' =>$idsiswa))->num_rows();
      if($cek > 0){ }else{
        $array[] = array(
          'username' =>$data->username,
          'id_siswa' =>$data->id_siswa,
          'nama_siswa' =>$data->nama,
          'kelas' => $data->id_kelas,
          'jurusan' =>$data->idpk,
          'status' =>1
        );

      }
    }
    return $json = json_encode($array);
  }
//&kelas dan Level-------------------------------------------------------------------
  function get_kelas()//
  {
    $this->db->cache_on();
    return $this->db->get('kelas')->result();
  }
  function get_kelas_by_guru($id=null)//
  {
    $this->db->distinct();
    $this->db->select('amKelas');
    $this->db->where('amIdGuru', $id); 
    $abs_mapel =$this->db->get('absensi_mapel')->result();
    foreach ($abs_mapel as $vl) {
       $kelas = $this->db->get_where('kelas', array('idkls' => $vl->amKelas))->result();
       foreach ($kelas as $kls) {
         $data= array(
          'idkls' =>$kls->idkls,
          'id_kelas' =>$kls->id_kelas,
         );
       }
       $data2[]=$data;
    }
     return $data2;
    ///echo"asdssadasd";
  }
  function get_level() //
  {
    $this->db->cache_on();
    return $this->db->get('level')->result();
  }
  function v_siswa($idkls){
    $this->db->cache_off();
    return $this->db->get_where('siswa', array('id_kelas' => $idkls))->result();
  }
//&mapel -------------------------------------------------------------------
  function get_mapel_by($id=null)
  {
    $this->db->cache_off();
    if($id==null){
      return $this->db->get('mata_pelajaran')->result();
    }
    else{
      return $this->db->get_where('mata_pelajaran', array('kode_level' => $id))->result();
    }
  }
  function get_mapel_by2($id=null)
  {
    $this->db->cache_off();
    if($id==null){
      return $this->db->get('mata_pelajaran')->result();
    }
    else{
      return $this->db->get_where('mata_pelajaran', array('idmapel' => $id))->result();
    }
  }
  function get_kelas_by($id=null)
  {
    $this->db->cache_off();
    if($id==null){
      return $this->db->get('kelas')->result();
    }
    else{
      return $this->db->get_where('kelas', array('id_level' => $id))->result();
    }
  }
//&materi ---------------------------------------------------------
  function get_materi_by($id)
  { //get meteri
    $this->db->cache_off();
    $this->db->join('pengawas', 'materi2.id_guru = pengawas.id_pengawas');
    $this->db->join('mata_pelajaran', 'mata_pelajaran.kode_mapel = materi2.materi2_mapel');
    return $this->db->get_where('materi2', array('materi2.id_guru' => $id))->result();
  }
  function get_materi_by2($id)
  { //untuk get edi materi
    $this->db->cache_off();
    return $this->db->get_where('materi2', array('materi2_id' => $id))->result();
  }
//&tugas---------------------------------------------------------
  function get_tugas_by($id)
  { //get tugas
    $this->db->cache_off();
    $this->db->join('pengawas', 'tugas.id_guru = pengawas.id_pengawas');
    $this->db->where('tugas.id_guru',$id);
    return $query = $this->db->get('tugas')->result();
  }
  function get_tugas_by2($id)
  { //untuk get edi tugas
    $this->db->cache_off();
    return $this->db->get_where('tugas', array('id_tugas' => $id))->result();
  }
  function get_nilai_tugas($id,$id_siswa=null)
  { //untuk get edi nilia tugas
    $this->db->cache_off();
    if(empty($id_siswa)){
      $this->db->join('siswa', 'jawaban_tugas.id_siswa = siswa.id_siswa');
      return $this->db->get_where('jawaban_tugas', array('id_tugas' => $id))->result();
    }
    else{
      return $this->db->get_where('jawaban_tugas', array('id_tugas' => $id,'id_siswa' =>$id_siswa))->row_array();
    }
    
  }



}