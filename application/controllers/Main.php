<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('tambah_dokumen');
        $this->load->model('stopword');
      

    }

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *        http://example.com/index.php/welcome
     *    - or -
     *        http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function index()
    {
      
        $this->load->view('header');
        $this->load->view('dashboard');
        $this->load->view('sidebar');
        $this->load->view('footer');

    }
    public function daftarpaper()
    {
        $data['query']=$this->tambah_dokumen->read();
        $this->load->view('header');
        $this->load->view('daftarpaper', $data);
        $this->load->view('sidebar');
        $this->load->view('footer');

    }
    
    // public function forminput()
    // {
      
    //     $this->load->view('header');
    //     $this->load->view('forminput');
    //     $this->load->view('sidebar');
    //     $this->load->view('footer');

    // }
     public function klustering()
    {
        $data['kluster'] = $this->input->get('kluster');
        if($data['kluster']!= null || $data['kluster']!= ""){
            $state = "proses_kluster";
        } else {
            $state = "";
        }
        $this->session->set_userdata("state", $state);
        $this->session->set_userdata($data);
        $this->load->view('header');
        $this->load->view('klustering',$data);
        $this->load->view('sidebar');
        $this->load->view('footer');

    }
     public function stopwords()
    {
         $data['query']=$this->stopword->read();
        $this->load->view('header');
        $this->load->view('stopwords', $data);
        $this->load->view('sidebar');
        $this->load->view('footer');

    }
    public function manualisasi()
    {
        // $data['query']=$this->stopword->read();
        $this->load->view('header');
        $this->load->view('manualisasi');
        $this->load->view('sidebar');
        $this->load->view('footer');

    }

    public function proses(){
        $klustering = $this->input->post('klustering');
        redirect(base_url('klustering?kluster='.$klustering));
    }

}