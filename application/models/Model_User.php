<?php

class Model_User extends CI_Model {

    public function getUser($iduser)
    {
        return $this->db->get_where('user', ['id_users' => $iduser])->result_array();
    }

    public function insertUser($datauser)
    {
        $this->db->insert('user', $datauser);
        return $this->db->affected_rows();
    }

    public function updateUser($datauser, $email)
    {
        $this->db->update('user', $datauser, ['email' => $email]);
        return $this->db->affected_rows();
    }
}
