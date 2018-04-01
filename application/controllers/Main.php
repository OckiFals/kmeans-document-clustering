<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Document_model');
        $this->load->model('Stopword_model');
        $this->load->model('Result_model');
        $this->load->helper('stemming_helper');
        $this->load->helper('clustering_helper');
        $this->load->helper('silhoutte_helper');
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
	
	public function edit($id) {
		if ('POST' === $this->input->server('REQUEST_METHOD')) {
            $this->Document_model->update($id);
            redirect(base_url('main'));
        } else {
			$this->load->view('header');
			$this->load->view('documents/edit', [
				'document' => $this->Document_model->getById($id)
			]);
			$this->load->view('sidebar');
			$this->load->view('footer');
		}
	}

    public function delete($id) {
        $this->delete_dokumen->hapus_data($id);
        redirect(base_url('main'));
    }

    public function klustering() {
        $kluster = $this->input->get('kluster');
        $this->load->view('header');
        if ('' == $kluster || null == $kluster) {
            $this->load->view('klustering', [
                'kluster' => $this->input->get('kluster'),
                'doc_count' => $this->Document_model->count()
            ]);
        } else if ('silhoutte-test' !== $this->input->get('stage')) { // process
            $abstrak_id = [];
            $clustering_helper = new Clustering_helper();
            $documents = $this->Document_model->getAll();
            foreach ($documents as $index => $doc) {
                $abstrak_id['d' . ($index + 1)] = $doc->id;
            }
            $cluster_kmean = $clustering_helper->process($kluster);

            // create new results if table is empty
            if (NULL === $this->Result_model->getLastDataId()) {
                $this->Result_model->create([
                    'cluster_kmean' => json_encode($cluster_kmean),
                    'tfidf' => json_encode($clustering_helper->getTfidfHasil())
                ]);
            } else { //update
                $this->Result_model->update([
                    'cluster_kmean' => json_encode($cluster_kmean),
                    'tfidf' => json_encode($clustering_helper->getTfidfHasil())
                ]);
            }
            $this->load->view('klustering', [
                'kluster' => $this->input->get('kluster'),
                'doc_count' => $this->Document_model->count(),
                'cluster_kmean' => $cluster_kmean,
                'abstrak_id' => $abstrak_id
            ]);
        } else { // silhoutte test
            $abstrak_id = [];
            $documents = $this->Document_model->getAll();
            foreach ($documents as $index => $doc) {
                $abstrak_id['d' . ($index + 1)] = $doc->id;
            }
            $result = $this->Result_model->get();
            $cluster_kmean = json_decode($result->cluster_kmean, TRUE);
            $tfidf = json_decode($result->tfidf, TRUE);
            $silhoutte_helper = new Silhoutte_helper($tfidf, $kluster, $cluster_kmean);
            $this->load->view('klustering', [
                'kluster' => $this->input->get('kluster'),
                'doc_count' => $this->Document_model->count(),
                'cluster_kmean' => $cluster_kmean,
                'silhoutte_results' => $silhoutte_helper->process(),
                'abstrak_id' => $abstrak_id
            ]);
        }
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
