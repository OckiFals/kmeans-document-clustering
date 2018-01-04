<?php

class Document_model extends CI_Model {
    public function __construct(){
        parent::__construct();
    }

    public function getAll() {
        $query = $this->db->get('document');
        return $query->result();
    }

    public function create() {
        $data = array(
            'judul' =>$this->input->post('judul_skripsi'),
            'fakultas' =>$this->input->post('fakultas'),
            'tahun' =>$this->input->post('tahun'),
            'abstrak' =>$this->input->post('abstrak'),
            'kata_kunci' =>$this->input->post('kata_kunci'),
            'dapus' =>$this->input->post('dapus'),
            'file_type' =>$this->input->post('dokumen'),                
        );
        $this->db->insert('document', $data);
    }

    public function delete($id){
        $this->db->delete('document', ['id' => $id]);
    }

    public function count() {
        $query = $this->db->query('SELECT * FROM document');
        return $query->num_rows();
    }

     public function filterIN($in_clausa) {
        $query = $this->db->query("SELECT * FROM `document` WHERE `id` IN $in_clausa");
        return $query->result();
    }
   
}