<?php

class delete_dokumen extends CI_Model {
    public function __construct(){
        parent::__construct();

    }


    public function read(){
        $query = $this->db->get('tambah_dokumen');
        return $query->result();
    }
 
    function update_data(){
        return $this->db->get('tambah_dokumen');
    }
 
    function hapus_data($query,$tambah_dokumen){
        $this->db->where($query);
        $this->db->delete($tambah_dokumen);
}
}