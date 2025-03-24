<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GetAntrian extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('M_Model'); // Load model
    }

    public function index() {
       

        // Ambil data layanan dari model
        $data['data_layanan'] = $this->M_Model->get_data('tbl_layanan');
        $data['title'] = 'Antrian';

        // Load view
        $this->load->view('get_antrian.php', $data);
    }

    public function simpan_antrian() {
        // Pastikan request adalah POST
        if ($this->input->post()) {
            // Ambil data dari POST
            $id_layanan = $this->input->post('id_layanan');
            $no_antrian = $this->input->post('nomor');

            // Validasi data
            if (empty($id_layanan) || empty($no_antrian)) {
                $response = [
                    'status'  => 'error',
                    'message' => 'Data tidak lengkap. Pastikan id_layanan dan nomor terisi.'
                ];
                echo json_encode($response);
                return;
            }

            // Data untuk disimpan
            $data = [
                'no_antrian' => $no_antrian,
                'id_layanan' => $id_layanan,
                'status'     => 'buat', // Default status
                'waktu_buat'  => date('Y-m-d H:i:s') // Timestamp
            ];

            // Simpan data ke database
            if ($this->M_Model->Insert_Data($data, 'tbl_antrian')) {
                $response = [
                    'status'  => 'success',
                    'message' => 'Berhasil menyimpan data antrian.'
                ];
            } else {
                $response = [
                    'status'  => 'error',
                    'message' => 'Terjadi kesalahan saat menyimpan data.'
                ];
            }

            // Set header JSON
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
        } else {
            // Jika bukan request POST, tampilkan error
            show_error('No direct script access allowed', 403);
        }
    }

    public function get_last_antrian() {
        $today = date('Y-m-d'); // Ambil tanggal hari ini
        $id_layanan = $this->input->post('id_layanan');
        $this->db->select('no_antrian');
        $this->db->from('tbl_antrian');
        $this->db->where('id_layanan', $id_layanan);
        $this->db->where('DATE(waktu_buat)', $today); // Filter berdasarkan tanggal hari ini
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
    
        $query = $this->db->get();
    
        if ($query->num_rows() > 0) {
            return $query->row()->no_antrian; // Ambil nilai no_antrian
        } else {
            return 0; // Jika tidak ada data, kembalikan 0
        }
    }
}