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
        $idkamar = $this->get('id_kamar');
        $idpenginapan = $this->get('id_penginapan');
        $iduser = $this->get('id_users');

        if ($idkamar != null) {
            $datakamar = $this->kamar->getKamar($idkamar, null, null);
        } elseif ($idpenginapan != null) {
            $datakamar = $this->kamar->getKamar(null, $idpenginapan, null);
        } elseif ($iduser != null) {
            $datakamar = $this->kamar->getKamar(null, null, $iduser);
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
            'id_penginapan' => $this->post('id_penginapan'),
            'tipe' => $this->post('tipe'),
            'harga' => $this->post('harga'),
            'fasilitas' => $this->post('fasilitas'),
            'kapasitas' => $this->post('kapasitas'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
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
        $idkamar = $this->put('id_kamar');

        $datakamar = array(
            'tipe' => $this->put('tipe'),
            'harga' => $this->put('harga'),
            'fasilitas' => $this->put('fasilitas'),
            'kapasitas' => $this->put('kapasitas'),
            'updated_at' => date('Y-m-d H:i:s')
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
        $idkamar = $this->delete('id_kamar');

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
