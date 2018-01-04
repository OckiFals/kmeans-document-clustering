<?php

class Stopword_model extends CI_Model {
    public function __construct(){
        parent::__construct();
    }

    public function getAll() {
        $query = $this->db->get('stopword');
        return $query->result();
    }

    public function update() {
        $data = array(
            'id' => $this->input->post('id'),
            'stopword' => $this->input->post('stopword'),                
        );

        $this->db->insert('stopword', $data);
    }
}