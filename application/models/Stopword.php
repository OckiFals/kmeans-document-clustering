<?php

class stopword extends CI_Model {
    public function __construct(){
        parent::__construct();
    }

    public function edit_stopword(){
        $data = array(
            'id' =>$this->input->post('id'),
            'stopword' =>$this->input->post('stopword'),                
        );

        $this->db->insert('stopword', $data);
    }

    public function read(){
        $query = $this->db->get('stopword');
        return $query->result();
    }
   
}