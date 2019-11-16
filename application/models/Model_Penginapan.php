<?php

class Model_Penginapan extends CI_Model {

    public function getPenginapan($idpenginapan = null, $iduser = null)
    {
        if ($idpenginapan != null) {
            return $this->db->get_where('penginapan', ['id_penginapan' => $idpenginapan])->result_array();
        } elseif ($iduser != null) {
            return $this->db->get_where('penginapan', ['id_user' => $iduser])->result_array();
        } else {
            return $this->db->get('penginapan')->result_array();
        }
    }

    public function insertPenginapan($datapenginapan)
    {
        $this->db->insert('penginapan', $datapenginapan);
        return $this->db->affected_rows();
    }

    public function updatePenginapan($datapenginapan, $idpenginapan)
    {
        $this->db->update('penginapan', $datapenginapan, ['id_penginapan' => $idpenginapan]);
        return $this->db->affected_rows();
    }

    public function deletePenginapan($idpenginapan)
    {
        $this->db->delete('penginapan', ['id_penginapan' => $idpenginapan]);
        return $this->db->affected_rows();
    }
}
