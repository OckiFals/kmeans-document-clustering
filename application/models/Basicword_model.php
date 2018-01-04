<?php

class Basicword_model extends CI_Model {
    public function __construct(){
        parent::__construct();
    }

    public function getAll() {
        $query = $this->db->get('basicword');
        return $query->result();
    }

    public function filterIN($in_clausa) {
        $query = $this->db->query("SELECT `word` FROM `basicword` WHERE `word` IN $in_clausa");
        return $query->result();
    }
}