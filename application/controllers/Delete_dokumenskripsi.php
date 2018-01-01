<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Delete_dokumenskripsi extends CI_Controller
{

    public function __construct(){
        parent::__construct();
        $this->load->model('delete_dokumen');
    }



function hapus($id_dokumen){
        $query = array('id_dokumen' => $id_dokumen);
        $this->delete_dokumen->hapus_data($query,'tambah_dokumen');
         redirect(base_url('daftarpaper'));
    }

}