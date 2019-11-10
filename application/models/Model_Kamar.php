<?php

class Model_kamar extends CI_Model {
    
    public function getPenginapan($idpenginapan = null, $iduser = null)
    {
        if ($idpenginapan != null) {
            return $this->db->get_where('penginapan', ['IDPENGINAPAN' => $idpenginapan])->result_array();
        } elseif ($iduser != null) {
            return $this->db->get_where('penginapan', ['IDUSER' => $iduser])->result_array();
        } else {
            return $this->db->get('penginapan')->result_array();
        }
    }

    public function insertKamar($datakamar)
    {
        $this->db->insert('kamar', $datakamar);
        return $this->db->affected_rows();
    }

    public function updatePenginapan($datapenginapan, $idpenginapan)
    {
        $this->db->update('penginapan', $datapenginapan, ['IDPENGINAPAN' => $idpenginapan]);
        return $this->db->affected_rows();
    }

    public function deletePenginapan($idpenginapan)
    {
        $this->db->delete('penginapan', ['IDPENGINAPAN' => $idpenginapan]);
        return $this->db->affected_rows();
    }
}