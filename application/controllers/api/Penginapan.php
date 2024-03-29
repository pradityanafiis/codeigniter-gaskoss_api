<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Penginapan extends CI_Controller {

    use REST_Controller {
        REST_Controller::__construct as private __resTraitConstruct;
    }

    function __construct()
    {
        parent::__construct();
        $this->__resTraitConstruct();
        $this->load->model('Model_Penginapan', 'penginapan');
    }

    public function index_get()
    {
        $idpenginapan = $this->get('id_penginapan');
        $iduser = $this->get('id_users');

        if ($idpenginapan != null) {
            $datapenginapan = $this->penginapan->getPenginapan($idpenginapan, null);
        } elseif ($iduser != null) {
            $datapenginapan = $this->penginapan->getPenginapan(null, $iduser);
        } else {
            $datapenginapan = $this->penginapan->getPenginapan();
        }

        if ($datapenginapan) {
            $this->response([
                'status' => TRUE,
                'data' => $datapenginapan
            ], 200);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Data penginapan tidak ditemukan.'
            ], 404);
        }
    }

    public function index_post()
    {
        $datapenginapan = array(
          'id_users' => $this->post('id_users'),
          'nama' => $this->post('nama'),
          'alamat' => $this->post('alamat'),
          'latitude' => $this->post('latitude'),
          'longitude' => $this->post('longitude'),
          'telepon' => $this->post('telepon'),
          'created_at' => date('Y-m-d H:i:s'),
          'updated_at' => date('Y-m-d H:i:s')
        );

        if ($this->penginapan->insertPenginapan($datapenginapan)) {
            $this->response([
                'status' => TRUE,
                'message' => 'Berhasil menambahkan penginapan.',
            ], 201);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Gagal menambahkan penginapan.',
            ], 400);
        }
    }

    public function index_put()
    {
        $idpenginapan = $this->put('id_penginapan');

        $datapenginapan = array(
          'nama' => $this->put('nama'),
          'alamat' => $this->put('alamat'),
          'latitude' => $this->put('latitude'),
          'longitude' => $this->put('longitude'),
          'telepon' => $this->put('telepon'),
          'updated_at' => date('Y-m-d H:i:s')
        );

        if ($this->penginapan->updatePenginapan($datapenginapan, $idpenginapan)) {
            $this->response([
                'status' => TRUE,
                'message' => 'Berhasil ubah penginapan.',
            ], 200);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Gagal ubah penginapan.',
            ], 400);
        }
    }

    public function index_delete()
    {
        $idpenginapan = $this->delete('id_penginapan');

        if ($idpenginapan == null) {
            $this->response([
                'status' => FALSE,
                'message' => "Gagal, ID penginapan belum dimasukkan."
            ], 400);
        } else {
            if ($this->penginapan->deletePenginapan($idpenginapan)) {
                $this->response([
                    'status' => TRUE,
                    'message' => 'Berhasil hapus penginapan.'
                ], 200);
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Gagal, ID penginapan tidak ditemukan.'
                ], 400);
            }
        }
    }
}
