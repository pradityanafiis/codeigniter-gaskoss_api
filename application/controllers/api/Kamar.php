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

        if ($datakamar) {
            $this->response([
                'status' => TRUE,
                'data' => $datakamar
            ], 200);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Data kamar tidak ditemukan'
            ], 404);
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
        $idkamar = $this->put('idkamar');

        $datakamar = array(
            'HARGA' => $this->put('harga'),
            'FASILITAS' => $this->put('fasilitas'),
            'KAPASITAS' => $this->put('kapasitas')
        );

        if ($this->kamar->updateKamar($datakamar, $idkamar)) {
            $this->response([
                'status' => TRUE,
                'message' => 'Berhasil ubah kamar.',
            ], 200);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Gagal ubah kamar.',
            ], 400);
        }
    }

    public function index_delete()
    {
        $idkamar = $this->delete('idkamar');

        if ($idkamar == null) {
            $this->response([
                'status' => FALSE,
                'message' => "Gagal, ID kamar belum dimasukkan."
            ], 400);
        } else {
            if ($this->kamar->deleteKamar($idkamar)) {
                $this->response([
                    'status' => TRUE,
                    'message' => 'Berhasil hapus kamar.'
                ], 200);
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Gagal, ID kamar tidak ditemukan.'
                ], 400);
            }
        }
    }
}