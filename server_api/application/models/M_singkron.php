<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_singkron extends CI_model {
	public function get_token(){
		return $this->db->get_where('setting',['id_setting' => 1])->row_array();
	}

	public function get_mapel(){
		return $this->db->get_where('mapel')->result_array();
	}
	public function get_kelas(){
		$this->db->join('level','kode_level=id_level');
		return $this->db->get_where('kelas')->result_array();
	}
	public function get_siswa(){
		return $this->db->get_where('siswa')->result_array();
	}
	public function get_sesi(){
		return $this->db->get_where('sesi')->result_array();
	}
	public function get_ruang(){
		return $this->db->get_where('ruang')->result_array();
	}

	public function get_mata_pelajaran(){
		return $this->db->get_where('mata_pelajaran')->result_array();
	}
	public function get_jadwal(){
		return $this->db->get_where('ujian',array('status' =>1))->result_array();
	}
	public function get_soalku(){
		return $this->db->get('soal')->result_array();
	}
	public function get_jurusan(){
		return $this->db->get('pk')->result_array();
	}
	
	
}