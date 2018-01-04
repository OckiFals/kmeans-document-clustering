<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Document_model');
        $this->load->model('Stopword_model');
        $this->load->helper('stemming_helper');
    }

    public function index() {
        $this->load->view('header');
        $this->load->view('documents/list', [
            'documents' => $this->Document_model->getAll()
        ]);
        $this->load->view('sidebar');
        $this->load->view('footer');
    }

    public function add() {
        if ('POST' === $this->input->server('REQUEST_METHOD')) {
            $this->Document_model->create();
            redirect(base_url('main'));
        } else {
            $this->load->view('header');
            $this->load->view('documents/add');
            $this->load->view('sidebar');
            $this->load->view('footer');
        }
    }

    public function delete($id) {
        $this->delete_dokumen->hapus_data($id);
        redirect(base_url('main'));
    }

    public function klustering() {
        $this->load->view('header');
        $this->load->view('klustering', [
            'kluster' => $this->input->get('kluster'),
            'doc_count' => $this->Document_model->count(),
            'stemming' => new Stemming_helper()
        ]);
        $this->load->view('sidebar');
        $this->load->view('footer');
    }

    public function stopwords() {
        $this->load->view('header');
        $this->load->view('stopwords', [
            'query' => $this->Stopword_model->getAll()
        ]);
        $this->load->view('sidebar');
        $this->load->view('footer');
    }

    public function manualisasi() {
        $this->load->view('header');
        $this->load->view('manualisasi');
        $this->load->view('sidebar');
        $this->load->view('footer');
    }
}