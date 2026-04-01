<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Keys_model extends App_Model
{
    private $table_name;

    public function __construct()
    {
        parent::__construct();
        $this->table_name = db_prefix() . 'appapi_keys';
    }

    public function get($id = '')
    {
        if (is_numeric($id)) {
            $this->db->where('id', $id);
            return $this->db->get($this->table_name)->row();
        }
        return $this->db->get($this->table_name)->result_array();
    }

    public function add($data)
    {
        $this->db->insert($this->table_name, $data);
        return $this->db->insert_id();
    }

    public function update($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update($this->table_name, $data);
        return ($this->db->affected_rows() > 0);
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->table_name);
        return ($this->db->affected_rows() > 0);
    }
}
