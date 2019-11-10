<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Transaksi extends CI_Controller {

    use REST_Controller {
        REST_Controller::__construct as private __resTraitConstruct;
    }

    function __construct()
    {
        parent::__construct();
        $this->__resTraitConstruct();
        $this->load->model('Model_Transaksi', 'transaksi');
    }

    public function index_get()
    {
        $idtransaksi = $this->get('idtransaksi');
        $iduser = $this->get('iduser');

        if ($idtransaksi != null) {
            $datatransaksi = $this->transaksi->getTransaksi($idtransaksi, null);
        } elseif ($iduser != null) {
            $datatransaksi = $this->transaksi->getTransaksi(null, $iduser);
        } else {
            $datatransaksi = $this->transaksi->getTransaksi();
        }

        if ($datatransaksi) {
            $this->response([
                'status' => TRUE,
                'data' => $datatransaksi
            ], 200);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Data transaksi tidak ditemukan'
            ], 404);
        }
    }

    public function index_post()
    {
        $idtransaksi = $this->generate_transaksi_id();
        if ($this->transaksi->check_transaksi_id($idtransaksi) > 0) {
            $idtransaksi = $this->generate_transaksi_id();
        }

        $datatransaksi = array(
            'IDTRANSAKSI' => $idtransaksi,
            'IDUSER' => $this->post('iduser'),
            'IDKAMAR' => $this->post('idkamar'),
            'TANGGALTRANSAKSI' => date('Y-m-d H:i:s'),
            'TANGGALMASUK' => $this->post('tanggalmasuk'),
            'TANGGALKELUAR' => $this->post('tanggalkeluar'),
            'PEMBAYARAN' => $this->post('pembayaran'),
            'STATUS' => '0'
        );

        if ($this->transaksi->insertTransaksi($datatransaksi)) {
            $this->response([
                'status' => TRUE,
                'message' => 'Berhasil menambahkan transaksi.',
            ], 201);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Gagal menambahkan transaksi.',
            ], 400);
        }
    }

    private function generate_transaksi_id()
    {
        $wildcard = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $shuffled = str_shuffle($wildcard);
        $i = 0;
        while ($i <= 8)
        {
            $kode[] = $wildcard[rand(0, strlen($shuffled)-1)];
            $i++;
        }
        return 'T-'.join($kode);
    }
}