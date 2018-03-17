<?php

class Result_model extends CI_Model {
    public function __construct(){
        parent::__construct();
    }

    public function get() {
        $query = $this->db->get('result_temp');
        return $query->row();
    }

    public function create(array $data) {
        $data = array(
            'cluster_kmean' => $data['cluster_kmean'],
            'tfidf' => $data['tfidf']
        );

        $this->db->insert('result_temp', $data);
    }

    public function update(array $data) {
        $data = array(
            'id' => $this->getLastDataId() ?? 1,
            'cluster_kmean' => $data['cluster_kmean'],
            'tfidf' => $data['tfidf']
        );

        $this->db->update('result_temp', $data, ['id' => $this->getLastDataId() ?? 1]);
    }

    public function getLastDataId() {
        $this->db->select_max('id');
        $query = $this->db->get('result_temp')->row();
        return $query->id;
    }
}
