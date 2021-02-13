<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_siswa_api extends CI_model {

	public function get_token(){
		return $this->db->get_where('setting',['id_setting' => 1])->row_array();
	}
	public function get_user($id)
	{
		// if($id===null)
		// {
		// 	return $this->db->get('soal')->result_array();
		// }
		// else{
			//return $this->db->get_where('soal',['id_sola' => $id])->result_array();
		// }
		
		$query = $this->db->get_where('ujian',['id_ujian' => $id])->row_array();
		$idmapel = $query['id_mapel'];
		$where = array(
			'id_mapel' => $idmapel,
			'jenis' => '1',
		);
		$mapel = $this->db->get_where('ujian',['id_ujian' => $id, 'id_mapel' => $idmapel])->row_array();
		$soal = $this->db->select('*');
		$soal = $this->db->from('soal');
		$soal = $this->db->where($where);
		$soal = $this->db->get()->result_array();
		foreach ($soal as $key => $value) {
			unset($value['jawaban']);
			$array[] = $value;
		}
		return $array;
		
	}
	 function get_status_user($id){
	 	$where = array(
			'id_mapel' => $idmapel,
			'jenis' => '1',
		);
	 	$this->db->select('cek_tombol_selesai,selesai,blok,online');
	 	$this->db->from('nilai');
	 	$this->db->where($where);
	 	return  $this->db->get()->result_array();
	 }

	
}