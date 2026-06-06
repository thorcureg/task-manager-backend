<?php
class Base_model extends CI_Model{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    function get_all_tasks($table){
        $this->db->select('*');
        $this->db->from($table);
        $query = $this->db->get();
        return $query->result();
        
    }
    function insert_task($table,$task=[]){
        $this->db->insert(
            $table,$task
        );
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    function update_task($table, $id, $task=[]){
        $this->db->where('id', $id);
        $this->db->update(
            $table,
            $task
        );
        return $this->db->affected_rows() > 0;
    }
    function delete_task($table, $id){
        $this->db->where('id', $id);
        $this->db->delete($table);
        return $this->db->affected_rows() > 0;
    }
}
?>