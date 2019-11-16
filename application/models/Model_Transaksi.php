<?php

class Model_Transaksi extends CI_Model {

    public function getTransaksi($idtransaksi = null, $iduser = null)
    {
        if ($idtransaksi != null) {
            return $this->db->get_where('transaksi', ['id_transaksi' => $idtransaksi])->result_array();
        } elseif ($iduser != null) {
            return $this->db->get_where('transaksi', ['id_users' => $iduser])->result_array();
        } else {
            return $this->db->get('transaksi')->result_array();
        }
    }

    public function insertTransaksi($datatransaksi)
    {
        $this->db->insert('transaksi', $datatransaksi);
        return $this->db->affected_rows();
    }

    public function check_transaksi_id($idtransaksi)
    {
        return $this->db->get_where('transaksi', ['id_transaksi' => $idtransaksi])->result_array();
    }
}
