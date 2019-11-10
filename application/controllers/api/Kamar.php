<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Kamar extends CI_Controller {

    use REST_Controller {
        REST_Controller::__construct as private __resTraitConstruct;
    }

    function __construct()
    {
        parent::__construct();
        $this->__resTraitConstruct();
        $this->load->model('Model_Kamar', 'kamar');
    }

    public function index_get()
    {
        $idkamar = $this->get('idkamar');
        $idpenginapan = $this->get('idpenginapan');

        if ($idkamar != null) {
            $datakamar = $this->kamar->getKamar($idkamar, null);
        } elseif ($idpenginapan != null) {
            $datakamar = $this->kamar->getKamar(null, $idpenginapan);
        } else {
            $datakamar = $this->kamar->getKamar();
        }
        
    }

    public function index_post()
    {
        $datakamar = array(
            'IDPENGINAPAN' => $this->post('idpenginapan'),
            'HARGA' => $this->post('harga'),
            'FASILITAS' => $this->post('fasilitas'),
            'KAPASITAS' => $this->post('kapasitas')
        );

        if ($this->kamar->insertKamar($datakamar)) {
            $this->response([
                'status' => TRUE,
                'message' => 'Berhasil menambahkan kamar.',
            ], 201);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Gagal menambahkan kamar.',
            ], 400);
        }

    }

    public function index_put()
    {

    }

    public function index_delete()
    {

    }
}