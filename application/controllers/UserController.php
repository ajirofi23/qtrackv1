<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_Model');
        if(!$this->session->userdata()){
          redirect('AuthController');
        }
    }

    public function index() {
        $data['title'] = 'home';
        $data['conten'] = 'users/home';

        // Lakukan join antara tbl_loket, tbl_layanan, dan tbl_users
        $this->db->select('tbl_loket.*, tbl_layanan.nama as nama_layanan, tbl_users.nama_lengkap'); // Pilih kolom yang ingin diambil
        $this->db->from('tbl_loket'); // Tabel utama
        $this->db->join('tbl_layanan', 'tbl_layanan.id_layanan = tbl_loket.id_layanan', 'left'); // Join dengan tbl_layanan
        $this->db->join('tbl_users', 'tbl_users.id_loket = tbl_loket.id_loket', 'left'); // Join dengan tbl_users
    
        // Tambahkan kondisi WHERE berdasarkan status loket
        $this->db->where('tbl_loket.status', '1'); // Hanya ambil data dengan status '1' (aktif)
    
        // Tambahkan kondisi WHERE khusus untuk operator
        if ($this->session->userdata('roles') == "operator") {
            $this->db->where('tbl_users.id_user', $this->session->userdata('user_id')); // Hanya ambil data loket yang terkait dengan operator
        }
    
        // Eksekusi query
        $query = $this->db->get();
    
        // Ambil hasil query
        $data['data_loket'] = $query->result_array();
        // Load view
        $this->load->view('users/template', $data);
    }

    public function ambil_antrian(){
        // Ambil data layanan dari model
        $data['data_layanan'] = $this->M_Model->get_data('tbl_layanan');
        $data['title'] = 'Antrian';
        $data['conten'] = 'users/ambil_antrian';

        // Load view
        $this->load->view('users/template', $data);
    }

    public function histori(){

        $data['title'] = 'Antrian';
        $data['conten'] = 'users/histori';

        // Load view
        $this->load->view('users/template', $data);
    }

    
}
