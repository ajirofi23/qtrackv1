<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function generate_user_id() {
        $date = date('Ymd');
        $random = mt_rand(1000, 9999);
        return 'U' . $date . $random;
    }

    public function register_user($data) {
        return $this->db->insert('tbl_users', $data);
    }

    public function is_email($email) {
        $this->db->where('email', $email);
        $query = $this->db->get('tbl_users');
        return $query->num_rows() > 0;
    }

    public function get_user_by_token($token) {
        $this->db->where('token', $token);
        return $this->db->get('tbl_users')->row();
    }

    public function activate_user($id_user) {
        $this->db->where('id_user', $id_user);
        $this->db->update('tbl_users', array('status' => '1'));
    }

    public function get_user_by_email($email) {
        $this->db->where('email', $email);
        $query = $this->db->get('tbl_users');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return null;
        }
    }

    public function get_data($tables) {
        $this->load->database();
        if (empty($tables)) {
            return array();
        }
        $query = $this->db->get($tables);
        if ($query) {
            return $query->result_array();
        } else {
            return array();
        }
    }

    public function get_data_by_id($table,$field, $id) {
        return $this->db->get_where($table, array($field => $id))->row();
    }

    public function Insert_Data($data, $table) {
        return $this->db->insert($table, $data);
    }

    public function update_data($table, $data, $conditions) {
        $this->db->where($conditions);
        return $this->db->update($table, $data);
    }

    public function hapus($pk, $id, $table) {
        if (empty($id)) {
            $this->session->set_flashdata('status', 'error');
            $this->session->set_flashdata('message', 'ID tidak valid.');
            return false;
        }
        $this->db->where($pk, $id);
        $delete = $this->db->delete($table);
        if ($delete) {
            $this->session->set_flashdata('status', 'success');
            $this->session->set_flashdata('message', 'Data berhasil dihapus.');
            return true;
        } else {
            $this->session->set_flashdata('status', 'error');
            $this->session->set_flashdata('message', 'Gagal menghapus data.');
            return false;
        }
    }

    public function is_data($field, $table, $data) {
        $this->db->where($field, $data);
        $query = $this->db->get($table);
        return $query->num_rows() > 0;
    }

    public function get_data_by_condition($table, $conditions) {
        return $this->db->get_where($table, $conditions)->row();
    }

    public function get_relation($table1, $joins = array(), $select = '*', $where = array(), $order_by = '', $limit = null, $offset = null) {
        // Mengatur kolom yang dipilih
        $this->db->select($select);
        $this->db->from($table1);
    
        // Loop untuk menambahkan join
        foreach ($joins as $join) {
            $this->db->join($join['table'], $join['condition'], $join['type'] ?? 'inner');
        }
    
        // Kondisi WHERE
        if (!empty($where)) {
            $this->db->where($where);
        }
    
        // Pengurutan
        if (!empty($order_by)) {
            $this->db->order_by($order_by);
        }
    
        // Limit dan Offset
        if ($limit !== null && $offset !== null) {
            $this->db->limit($limit, $offset);
        }
    
        return $this->db->get()->result_array();
    }

    public function GetWHERE($table, $where) {
        // Loop untuk menambahkan kondisi WHERE
        foreach ($where as $field => $value) {
            $this->db->where($field, $value);
        }
    
        // Eksekusi query
        $query = $this->db->get($table);
    
        // Cek apakah data ada
        return $query->num_rows() > 0;
    }
}