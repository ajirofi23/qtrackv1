<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AntrianController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('M_Model'); // Load model jika diperlukan
        // check_admin();
    }

    public function index() {
      // Set judul halaman dan konten view
      $data['title']  = 'Antrian';
      $data['conten'] = 'admin/page/antrian/view';
  
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
  
      // Tampilkan view dengan data yang sudah diambil
      $this->load->view('admin/template/template', $data);
  }


  public function get_antrian() {
    // Mengambil id_loket dan id_layanan dari input POST
    $id_loket   = $this->input->post('id_loket');
    $id_layanan = $this->input->post('id_layanan');

    // Cek apakah loket ada dan id_antrian terisi
    $this->db->select('id_antrian');
    $this->db->from('tbl_loket');
    $this->db->where('id_loket', $id_loket);
    $cek_loket  = $this->db->get();
    $loket_data = $cek_loket->row_array();
    (int) $id_antrian = $loket_data['id_antrian'];

    $today = date('Y-m-d'); // Format: Tahun-Bulan-Tanggal
    if($id_antrian > 0){
        $this->db->select('tbl_antrian.*, tbl_layanan.kode as kode_layanan, tbl_antrian.status as status_antrian');
        $this->db->from('tbl_antrian');
        $this->db->join('tbl_layanan', 'tbl_layanan.id_layanan = tbl_antrian.id_layanan', 'left');
        $this->db->where('tbl_antrian.id', $id_antrian);
        $this->db->where('DATE(tbl_antrian.waktu_buat)', $today);
        $this->db->where_in('tbl_antrian.status', ['panggil', 'proses']);
        $query = $this->db->get();
       
    }else{
        $this->db->select('tbl_antrian.*, tbl_layanan.kode as kode_layanan, tbl_antrian.status as status_antrian');
        $this->db->from('tbl_antrian');
        $this->db->join('tbl_layanan', 'tbl_layanan.id_layanan = tbl_antrian.id_layanan', 'left');
        $this->db->where('tbl_antrian.status', 'buat');
        $this->db->where('DATE(tbl_antrian.waktu_buat)', $today);
        $this->db->where('tbl_antrian.id_layanan', $id_layanan);
        $this->db->limit(1);
        $query = $this->db->get();
    }
  
    // Memeriksa apakah ada hasil
    if ($query->num_rows() > 0) {
        // Mengembalikan data dalam format JSON
        echo json_encode($query->result());
    } else {
        // Jika tidak ada antrian, kembalikan pesan default
        echo json_encode(['nomor_antrian' => 'Tidak ada antrian']);
    }
}

public function update_status_antrian() {
    // Ambil data dari input POST
    $id_antrian = $this->input->post('id_antrian');
    $status = $this->input->post('status'); // Status baru: panggil, proses, selesai, batal
    $id_loket = $this->input->post('id_loket'); // ID loket yang terkait

    // Validasi input
    if (empty($id_antrian)) {
        echo json_encode(['status' => 'error', 'message' => 'ID Antrian tidak boleh kosong']);
        return;
    }

    if (empty($status)) {
        echo json_encode(['status' => 'error', 'message' => 'Status tidak boleh kosong']);
        return;
    }

    if (empty($id_loket)) {
        echo json_encode(['status' => 'error', 'message' => 'ID Loket tidak boleh kosong']);
        return;
    }

    // Mulai transaksi database
    $this->db->trans_start();

    // Update tabel tbl_loket berdasarkan status
    if ($status == 'batal' || $status == 'selesai') {
        // Jika status adalah batal atau selesai, set id_antrian di tbl_loket menjadi 0
        $this->db->where('id_loket', $id_loket);
        $this->db->update('tbl_loket', ['id_antrian' => 0]);
    } else {
        // Jika status adalah panggil atau proses, update id_antrian di tbl_loket
        $this->db->where('id_loket', $id_loket);
        $this->db->update('tbl_loket', ['id_antrian' => $id_antrian]);
    }

    // Update status antrian dan waktu terkait di tabel tbl_antrian
    $update_data = ['status' => $status];

    // Tambahkan kolom waktu berdasarkan status
    switch ($status) {
        case 'panggil':
            $update_data['waktu_panggil'] = date('Y-m-d H:i:s'); // Waktu saat ini
            break;
        case 'proses':
            $update_data['waktu_proses'] = date('Y-m-d H:i:s'); // Waktu saat ini
            break;
        case 'selesai':
            $update_data['waktu_selesai'] = date('Y-m-d H:i:s'); // Waktu saat ini
            break;
        case 'batal':
            $update_data['waktu_batal'] = date('Y-m-d H:i:s'); // Waktu saat ini
            break;
    }

    $this->db->where('id', $id_antrian);
    $this->db->update('tbl_antrian', $update_data);

    // Selesaikan transaksi
    $this->db->trans_complete();

    // Cek apakah transaksi berhasil
    if ($this->db->trans_status() === FALSE) {
        // Jika transaksi gagal, kembalikan pesan error
        echo json_encode(['status' => 'error', 'message' => 'Gagal mengupdate status antrian']);
    } else {
        // Jika transaksi berhasil, kembalikan pesan sukses
        echo json_encode(['status' => 'success', 'message' => 'Status antrian berhasil diupdate']);
    }
}

public function get_daftar_antrian_hari_ini() {
    $today = date('Y-m-d'); // Ambil tanggal hari ini

    $this->db->select('tbl_antrian.*, tbl_layanan.kode as kode_layanan, tbl_layanan.nama as nama_layanan,, CONCAT(tbl_layanan.kode, tbl_antrian.no_antrian) as no_antrian');
    $this->db->from('tbl_antrian');
    $this->db->join('tbl_layanan', 'tbl_layanan.id_layanan = tbl_antrian.id_layanan', 'left');
    $this->db->where('DATE(tbl_antrian.waktu_buat)', $today); // Filter berdasarkan tanggal hari ini
    $this->db->order_by('tbl_antrian.waktu_buat', 'ASC');
    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        echo json_encode($query->result());
    } else {
        echo json_encode([]);
    }
}
  
}
