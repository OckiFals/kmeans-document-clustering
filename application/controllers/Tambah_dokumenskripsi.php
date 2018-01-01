<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tambah_dokumenskripsi extends CI_Controller
{

    public function __construct(){
        parent::__construct();
        $this->load->model('tambah_dokumen');
    }


    public function index()
    {
        // if ("2" !== $this->session->userdata('level') && "3" !==  $this->session->userdata('level') )
        //     die('Anda tida memiliki hak akses!');

        if ($this->input->server('REQUEST_METHOD')==='POST'){
            $this->tambah_dokumen->addDoc_skripsi();
            redirect(base_url('daftarpaper'));
        
         }
         else{

             $data['query']=$this->tambah_dokumen->read();
             $this->load->view('header');
             $this->load->view('forminput');
             $this->load->view('sidebar');
             $this->load->view('footer');
         }

    }

   

}