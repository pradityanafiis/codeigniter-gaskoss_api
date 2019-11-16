<?php

class Model_Kamar extends CI_Model {

    public function getKamar($idkamar = null, $idpenginapan = null)
    {
        if ($idkamar != null) {
            return $this->db->get_where('kamar', ['id_kamar' => $idkamar])->result_array();
        } elseif ($idpenginapan != null) {
            return $this->db->get_where('kamar', ['id_penginapan' => $idpenginapan])->result_array();
        } else {
            return $this->db->get('kamar')->result_array();
        }
    }

    public function insertKamar($datakamar)
    {
        $this->db->insert('kamar', $datakamar);
        return $this->db->affected_rows();
    }

    public function updateKamar($datakamar, $idkamar)
    {
        $this->db->update('kamar', $datakamar, ['id_kamar' => $idkamar]);
        return $this->db->affected_rows();
    }

    public function deleteKamar($idkamar)
    {
        $this->db->delete('kamar', ['id_kamar' => $idkamar]);
        return $this->db->affected_rows();
    }
}
