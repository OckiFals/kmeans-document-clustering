<?php

class tambah_dokumen extends CI_Model {
    public function __construct(){
        parent::__construct();
    }

    public function addDoc_skripsi(){
        $data = array(
            'judul_skripsi' =>$this->input->post('judul_skripsi'),
            'fakultas' =>$this->input->post('fakultas'),
            'tahun' =>$this->input->post('tahun'),
            'abstrak' =>$this->input->post('abstrak'),
            'kata_kunci' =>$this->input->post('kata_kunci'),
            'dapus' =>$this->input->post('dapus'),
            'file_type' =>$this->input->post('dokumen'),                
        );

        $this->db->insert('tambah_dokumen', $data);
    }

    public function read(){
        $query = $this->db->get('tambah_dokumen');
        return $query->result();
    }

    public function count() {
        $query = $this->db->query('SELECT * FROM tambah_dokumen');
        return $query->num_rows();
    }
   
}