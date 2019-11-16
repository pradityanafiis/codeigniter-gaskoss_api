<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class User extends CI_Controller {

    use REST_Controller {
        REST_Controller::__construct as private __resTraitConstruct;
    }

    function __construct()
    {
        parent::__construct();
        $this->__resTraitConstruct();
        $this->load->model('Model_User', 'user');
        $this->load->library('encryption');
    }

    public function index_get()
    {
        $iduser = $this->get('iduser');

        if ($iduser == null) {
            $this->response([
                'status' => FALSE,
                'message' => "Gagal, ID user belum dimasukkan."
            ], 400);
        } else {
            $datauser = $this->user->getUser($iduser);
            if ($datauser) {
                $this->response([
                    'status' => TRUE,
                    'data' => $datauser
                ], 200);
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Data user tidak ditemukan.'
                ], 404);
            }
        }
    }

    public function index_post()
    {
        $datauser = array(
            'email' => $this->post('email'),
            'password' => sha1($this->post('password')),
            'nama' => $this->post('nama'),
            'telepon' => $this->post('telepon'),
            'created_at' => date('Y-m-d H:i:s')
        );

        if ($this->user->insertUser($datauser)) {
            $this->response([
                'status' => TRUE,
                'message' => 'Berhasil registrasi user.',
            ], 201);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Gagal registrasi user.',
            ], 400);
        }
    }

    public function index_put()
    {
        $email = $this->put('email');

        $datauser = array(
            'password' => sha1($this->put('password')),
            'nama' => $this->put('nama'),
            'telepon' => $this->put('telepon'),
            'updated_at' => date('Y-m-d H:i:s')
        );

        if ($this->user->updateUser($datauser, $email)) {
            $this->response([
                'status' => TRUE,
                'message' => 'Berhasil ubah user.',
            ], 200);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Gagal ubah user.',
            ], 400);
        }
    }
}
