<?php
class Pemimpin_model extends CI_Model
{
    public function getPemimpin($id = null)
    {
        if ($id === null) {
            return $this->db->get('pemimpin')->result_array();
        } else {
            return $this->db->get_where('pemimpin', ['id' => $id])->result_array();
        }
    }

    public function deletePemimpin($id)
    {
        $this->db->delete('pemimpin', ['id' => $id]);
        return $this->db->affected_rows();
    }
    public function createPemimpin($data)
    {
        
        $this->db->insert('pemimpin', $data);
        return $this->db->affected_rows();
    }
    public function updatePemimpin($data, $id)
    {
        $this->db->update('pemimpin', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }
}