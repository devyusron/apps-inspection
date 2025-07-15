<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inspection extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // date_default_timezone_set('Asia/Jakarta');
        // is_logged_in();
        $this->load->helper('url');
        $this->load->library('upload');
    }

    public function approve_manager()
    {
        // Pastikan hanya request AJAX yang diproses
        if (!$this->input->is_ajax_request()) {
            show_404(); // Atau redirect ke halaman lain
            exit;
        }

        $id_inspection = $this->input->post('unit_id');

        // Validasi input
        if (empty($id_inspection) || !is_numeric($id_inspection)) {
            echo json_encode(['status' => 'error', 'message' => 'ID Inspeksi tidak valid!']);
            exit;
        }

        // Data untuk diupdate
        $data = [
            'approve_manager' => 1 // Set menjadi 1 (approved)
        ];

        // Lakukan update ke database
        // Diasumsikan nama tabel adalah 'inspection' dan primary key adalah 'id_inspection'
        $this->db->where('id_inspection', $id_inspection);
        $this->db->update('inspection', $data);

        // Cek apakah update berhasil
        if ($this->db->affected_rows() > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Inspeksi berhasil di-approve oleh Manager!']);
        } else {
            // Bisa jadi ID tidak ditemukan atau sudah di-approve sebelumnya
            echo json_encode(['status' => 'error', 'message' => 'Gagal meng-approve inspeksi. Data tidak ditemukan atau sudah di-approve.']);
        }
    }

    public function reject_inspection()
    {
        // Pastikan hanya request AJAX yang diproses
        if (!$this->input->is_ajax_request()) {
            show_404();
            exit;
        }

        $inspection_id = $this->input->post('inspection_id');
        $unit_id_for_status = $this->input->post('unit_id_for_status'); // ID dari tabel 'unit'

        // Validasi input
        if (empty($inspection_id) || !is_numeric($inspection_id) || empty($unit_id_for_status) || !is_numeric($unit_id_for_status)) {
            echo json_encode(['status' => 'error', 'message' => 'ID Inspeksi atau ID Unit tidak valid!']);
            exit;
        }

        // --- Mulai Transaksi Database ---
        // Ini memastikan kedua operasi (delete dan update) berhasil atau keduanya gagal
        $this->db->trans_start();

        // 1. Hapus data dari tabel 'inspection'
        $this->db->where('id_inspection', $inspection_id);
        $this->db->delete('inspection');
        $deleted_rows = $this->db->affected_rows();

        // 2. Update status_inspection di tabel 'unit' menjadi 'Belum Inspeksi'
        $this->db->where('unit_id', $unit_id_for_status);
        $this->db->update('unit', ['status_inspection' => 'Belum Inspeksi']);
        $updated_rows = $this->db->affected_rows();

        // --- Selesaikan Transaksi Database ---
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            // Transaksi gagal, roll back
            echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus inspeksi dan memperbarui status unit.']);
        } else {
            // Transaksi berhasil
            if ($deleted_rows > 0) {
                echo json_encode(['status' => 'success', 'message' => 'Inspeksi berhasil dihapus dan status unit diatur ulang.']);
            } else {
                // Ini bisa terjadi jika inspeksi_id tidak ditemukan, tapi unit_id_for_status mungkin ada
                echo json_encode(['status' => 'error', 'message' => 'Inspeksi tidak ditemukan atau gagal dihapus, tetapi status unit mungkin telah diperbarui.']);
            }
        }
        exit; // Penting untuk menghentikan eksekusi setelah mengirim JSON
    }

    /* produk */
    public function master_produk()
    {
        $data['title'] = 'Master Produk';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $nama_produk_filter = $this->input->get('nama_produk');
        $kode_produk_filter = $this->input->get('kode_produk');
        $tanggal_mulai = $this->input->get('tanggal_mulai');
        $tanggal_akhir = $this->input->get('tanggal_akhir');
        $this->db->select('*');
        $this->db->from('master_produk');
        $this->db->order_by('id_produk', 'DESC'); // Atau sesuaikan dengan kolom pengurutan Anda
        if ($nama_produk_filter) {
            $this->db->like('nama_produk', $nama_produk_filter);
        }
        if ($kode_produk_filter) {
            $this->db->like('kode_produk', $kode_produk_filter);
        }
        if ($tanggal_mulai && $tanggal_akhir) {
            $this->db->where('created_at >=', $tanggal_mulai . ' 00:00:00');
            $this->db->where('created_at <=', $tanggal_akhir . ' 23:59:59');
        } else if($tanggal_mulai){
            $this->db->where('date(created_at) =', $tanggal_mulai);
        }
        $data['master_produk'] = $this->db->get()->result_array();
        // Untuk dropdown Nama Produk
        // $this->db->select("concat(nama_produk,'[',dimensi_produk,']') as nama_produk");
        $this->db->select("nama_produk");
        $this->db->distinct();
        $data['nama_produk_list'] = $this->db->get('master_produk')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('inspection/master_produk', $data);
        $this->load->view('templates/footer');
    }

    public function add_master_produk()
    {
        $this->form_validation->set_rules('nama_produk', 'Nama Produk', 'required|trim');
        $this->form_validation->set_rules('dimensi_produk', 'Type Unit', 'required');
        $this->form_validation->set_rules('deskripsi_produk', 'Deskripsi Produk', 'required');
        $this->form_validation->set_rules('berat_produk', 'Berat', 'required');
        if (empty($_FILES['url_gambar_produk']['name'])) {
            $this->form_validation->set_rules('url_gambar_produk', 'Gambar Produk', 'required', [
                'required' => 'Gambar Produk wajib diisi.'
            ]);
        }
        if ($this->form_validation->run() == FALSE) {
            $this->master_produk(); // Reload halaman master produk dengan menampilkan error validasi (jika ada)
        } else {
            $upload_result = $this->_uploadImage_master_produk(); // Panggil fungsi upload gambar

            // --- START PERBAIKAN UNTUK MENGATASI TYPEERROR ---
            // Tambahkan pengecekan tipe data sebelum mengakses offset array
            if (!is_array($upload_result)) {
                // Log pesan error untuk debugging lebih lanjut
                log_message('error', 'Unexpected return type from _uploadImage_master_produk: ' . gettype($upload_result) . ' Value: ' . print_r($upload_result, true));
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Terjadi kesalahan internal saat upload gambar. Silakan coba lagi.</div>');
                $this->master_produk(); // Memuat ulang halaman master produk
                return; // Hentikan eksekusi
            }
            // --- END PERBAIKAN UNTUK MENGATASI TYPEERROR ---

            if ($upload_result['status']) { // Jika upload berhasil
                $data = [
                    'nama_produk' => htmlspecialchars($this->input->post('nama_produk', true)),
                    'kode_produk' => htmlspecialchars($this->input->post('kode_produk', true)),
                    'url_gambar_produk' => $upload_result['file_name'], // Gunakan nama file yang berhasil diupload
                    'deskripsi_produk' => htmlspecialchars($this->input->post('deskripsi_produk', true)),
                    'harga_produk' => htmlspecialchars($this->input->post('harga_produk', true)),
                    'harga_asli' => htmlspecialchars($this->input->post('harga_asli', true)),
                    'harga_diskon' => htmlspecialchars($this->input->post('harga_diskon', true)),
                    'stok_produk' => htmlspecialchars($this->input->post('stok_produk', true)),
                    'minimum_stok_produk' => htmlspecialchars($this->input->post('minimum_stok_produk', true)),
                    'kategori_produk' => htmlspecialchars($this->input->post('kategori_produk', true)),
                    'brand_produk' => htmlspecialchars($this->input->post('brand_produk', true)),
                    'tag_produk' => htmlspecialchars($this->input->post('tag_produk', true)),
                    'dimensi_produk' => htmlspecialchars($this->input->post('dimensi_produk', true)),
                    'berat_produk' => htmlspecialchars($this->input->post('berat_produk', true)),
                    'warna_produk' => htmlspecialchars($this->input->post('warna_produk', true)),
                    'is_active' => $this->input->post('is_active') ? 1 : 0,
                    'created_by' => $this->session->userdata('user_id') ? $this->session->userdata('user_id') : 'SYSTEM',
                    'created_at' => date('Y-m-d H:i:s')
                ];
                $this->db->insert('master_produk', $data);
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Produk berhasil ditambahkan!</div>');
                redirect('inspection/master_produk');
            } else {
                // Jika upload gagal, tampilkan error upload
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal upload gambar: ' . $upload_result['error'] . '</div>');
                // Penting: Jangan lakukan insert ke DB jika upload gagal
                $this->master_produk(); // Memuat ulang halaman master produk dengan error upload
            }
        }
    }

    public function edit_master_produk()
    {
        $id_produk = $this->input->post('id_produk');
        $this->form_validation->set_rules('nama_produk', 'Nama Produk', 'required|trim');
        $this->form_validation->set_rules('dimensi_produk', 'Type Unit', 'required');
        $this->form_validation->set_rules('deskripsi_produk', 'Deskripsi Produk', 'required');
        $this->form_validation->set_rules('berat_produk', 'Berat', 'required');
        // Tambahkan rules validasi lain sesuai kebutuhan

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . validation_errors() . '</div>');
            $this->master_produk();
        } else {
            $data = [
                'nama_produk' => htmlspecialchars($this->input->post('nama_produk', true)),
                'kode_produk' => htmlspecialchars($this->input->post('kode_produk', true)),
                'deskripsi_produk' => htmlspecialchars($this->input->post('deskripsi_produk', true)),
                'harga_produk' => htmlspecialchars($this->input->post('harga_produk', true)),
                'harga_asli' => htmlspecialchars($this->input->post('harga_asli', true)),
                'harga_diskon' => htmlspecialchars($this->input->post('harga_diskon', true)),
                'stok_produk' => htmlspecialchars($this->input->post('stok_produk', true)),
                'minimum_stok_produk' => htmlspecialchars($this->input->post('minimum_stok_produk', true)),
                'kategori_produk' => htmlspecialchars($this->input->post('kategori_produk', true)),
                'brand_produk' => htmlspecialchars($this->input->post('brand_produk', true)),
                'tag_produk' => htmlspecialchars($this->input->post('tag_produk', true)),
                'dimensi_produk' => htmlspecialchars($this->input->post('dimensi_produk', true)),
                'berat_produk' => htmlspecialchars($this->input->post('berat_produk', true)),
                'warna_produk' => htmlspecialchars($this->input->post('warna_produk', true)),
                'is_active' => $this->input->post('is_active') ? 1 : 0,
                // 'updated_by' => $this->session->userdata('user_id') ? $this->session->userdata('user_id') : 'SYSTEM',
                // 'updated_at' => date('Y-m-d H:i:s')
            ];

            // Cek apakah ada file gambar baru yang diupload
            if (!empty($_FILES['url_gambar_produk']['name'])) {
                $upload_data = $this->_uploadImage_master_produk();

                // Tambahkan pengecekan tipe data sebelum mengakses offset array
                if (!is_array($upload_data)) {
                    log_message('error', 'Unexpected return type from _uploadImage_master_produk in edit_master_produk: ' . gettype($upload_data) . ' Value: ' . print_r($upload_data, true));
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Terjadi kesalahan internal saat upload gambar. Silakan coba lagi.</div>');
                    redirect('inspection/master_produk');
                    return;
                }

                if ($upload_data['status']) {
                    // Hapus gambar lama jika ada dan upload berhasil
                    $old_image = $this->db->get_where('master_produk', ['id_produk' => $id_produk])->row()->url_gambar_produk;
                    if ($old_image && file_exists(FCPATH . 'assets/img/produk/' . $old_image)) {
                        unlink(FCPATH . 'assets/img/produk/' . $old_image);
                    }
                    $data['url_gambar_produk'] = $upload_data['file_name'];
                } else {
                    // Jika upload gambar baru gagal, tampilkan error dan jangan update produk
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal upload gambar: ' . $upload_data['error'] . '</div>');
                    redirect('inspection/master_produk'); // Redirect agar pesan error tampil
                    return; // Hentikan eksekusi
                }
            }
            
            $this->db->where('id_produk', $id_produk);
            $this->db->update('master_produk', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Produk berhasil diupdate!</div>');
            redirect('inspection/master_produk');
        }
    }

    public function delete_master_produk($id_produk)
    {
        if (!is_numeric($id_produk)) {
            redirect('inspection/master_produk'); // Redirect jika ID tidak valid
        }
        $product = $this->db->get_where('master_produk', ['id_produk' => $id_produk])->row();
        if ($product && $product->url_gambar_produk && file_exists(FCPATH . 'assets/img/produk/' . $product->url_gambar_produk)) {
            unlink(FCPATH . 'assets/img/produk/' . $product->url_gambar_produk);
        }
        $this->db->where('id_produk', $id_produk);
        $this->db->delete('master_produk');
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Produk berhasil dihapus!</div>');
        redirect('inspection/master_produk');
    }

    private function _uploadImage_master_produk()
    {
        $config['upload_path'] = './assets/img/produk/';
        $config['allowed_types'] = '*';
        $config['max_size'] = 2048;
        $config['overwrite'] = true;
        $microtime = microtime(true);
        $microtime_str = str_replace('.', '', (string) $microtime);
        $timestamp_milisecond = substr($microtime_str, 0, 10);
        $config['file_name'] = 'produk_' . $timestamp_milisecond;
        // Inisialisasi ulang library upload dengan konfigurasi baru
        $this->upload->initialize($config);

        // --- DEBUGGING: Tambahkan logging untuk path upload dan keberadaan folder ---
        log_message('debug', 'Upload Path yang digunakan: ' . $config['upload_path']);
        if (!is_dir($config['upload_path'])) {
            log_message('error', 'Direktori upload TIDAK DITEMUKAN atau TIDAK DAPAT DIAKSES: ' . $config['upload_path']);
            // Coba buat direktori jika tidak ada (opsional, bisa di-handle manual juga)
            if (!mkdir($config['upload_path'], 0777, TRUE)) {
                log_message('error', 'Gagal membuat direktori upload: ' . $config['upload_path']);
                return ['status' => false, 'error' => 'Direktori upload tidak dapat dibuat atau diakses.'];
            }
            log_message('debug', 'Direktori upload berhasil dibuat: ' . $config['upload_path']);
        } else {
            log_message('debug', 'Direktori upload DITEMUKAN: ' . $config['upload_path']);
        }
        // --- END DEBUGGING ---

        if ($this->upload->do_upload('url_gambar_produk')) {
            // Upload berhasil
            return ['status' => true, 'file_name' => $this->upload->data('file_name')];
        } else {
            // Upload gagal, kembalikan status false dan pesan error
            log_message('error', 'Gagal do_upload: ' . $this->upload->display_errors('', ''));
            return ['status' => false, 'error' => $this->upload->display_errors('', '')];
        }
    }
    /* end produk */

    /* unit */
    public function index_unit() {
        $ci = get_instance();
        if (!$ci->session->userdata('email')) {
            redirect('auth');
            return;
        }
        $data['lokasi_units'] = $this->db->get('lokasi_unit')->result_array();
        $this->db->select('*');
        $this->db->from('inspection_template');
        $data['inspection_template'] = $this->db->get()->result_array();
        $tanggal_mulai = $this->input->get('tanggal_mulai');
        $tanggal_akhir = $this->input->get('tanggal_akhir');
        $nama_produk_filter = $this->input->get('nama_produk');
        $kondisi_unit = $this->input->get('kondisi_unit');
        $lokasi_unit = $this->input->get('lokasi_unit');
        $status_inspection = $this->input->get('status_inspection');
        // $this->db->select("concat(nama_produk,'[',dimensi_produk,']') as nama_produk");
        $this->db->select("nama_produk");
        $this->db->distinct();
        $data['daftar_produk'] = $this->db->get('master_produk')->result_array();
        $this->db->select('unit.*, master_produk.nama_produk, inspection.inspection_template_id as id_template, inspection.id_inspection as id_inspection,approve_manager');
        $this->db->from('unit');
        $this->db->join('master_produk', 'unit.id_produk = master_produk.id_produk');
        $this->db->join('inspection', 'unit.unit_id = inspection.unit_id', 'left');
        $this->db->order_by('unit_id', 'DESC');
        if ($tanggal_mulai && $tanggal_akhir) {
            $this->db->where('unit.tanggal_masuk >=', $tanggal_mulai . ' 00:00:00');
            $this->db->where('unit.tanggal_masuk <=', $tanggal_akhir . ' 23:59:59');
        }
        if ($nama_produk_filter) {
            $this->db->like('master_produk.nama_produk', $nama_produk_filter);
        }
        if ($lokasi_unit) {
            $this->db->like('unit.lokasi_unit', $lokasi_unit);
        }
        if ($kondisi_unit) {
            $this->db->like('unit.kondisi_unit', $kondisi_unit);
        }
        if ($status_inspection) {
            $this->db->like('unit.status_inspection', $status_inspection);
        }
        $data['units'] = $this->db->get()->result_array();
        $data['title'] = 'List Unit';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('inspection/unit/index', $data);
        $this->load->view('templates/footer');
        $this->session->unset_userdata('swal');
    }

    public function add_unit() {
        $this->db->select("nama_produk");
        $this->db->distinct();
        // $this->db->select("concat(nama_produk,' [',dimensi_produk,']') as nama_produk,id_produk");
        $data['products'] = $this->db->get('master_produk')->result_array();
        $data['title'] = 'Tambah Unit';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('inspection/unit/add', $data);
        $this->load->view('templates/footer');
    }

    public function insert_unit() {
        $this->form_validation->set_rules('serial_number', 'Serial Number', 'required|trim|is_unique[unit.serial_number]');
        $this->form_validation->set_rules('id_produk', 'ID Produk', 'required|trim|numeric');
        $this->form_validation->set_rules('qty', 'Kuantitas', 'required|trim|numeric|greater_than[0]');
        $this->form_validation->set_rules('kondisi_unit', 'Kondisi Unit', 'required|trim');
        $this->form_validation->set_rules('tanggal_masuk', 'Tanggal Masuk', 'required|trim');
        $this->form_validation->set_rules('status_unit', 'Status Unit', 'required|trim');
        $this->form_validation->set_rules('lokasi_unit', 'Lokasi Unit', 'required|trim');
        $this->form_validation->set_rules('keterangan_unit', 'Keterangan Unit', 'trim');
        $this->form_validation->set_rules('machine_no', 'Machine Number', 'trim'); // Tambah validasi
        $this->form_validation->set_rules('model_no', 'Model Number', 'trim');     // Tambah validasi
        if ($this->form_validation->run() == FALSE) {
            $this->add_unit();
        } else {
            $data_unit = [
                'serial_number' => $this->input->post('serial_number'),
                'id_produk' => $this->input->post('id_produk'),
                'status_inspection' => $this->input->post('status_inspection'),
                'qty' => $this->input->post('qty'),
                'kondisi_unit' => $this->input->post('kondisi_unit'),
                'tanggal_masuk' => $this->input->post('tanggal_masuk'),
                'tanggal_keluar' => $this->input->post('tanggal_keluar'),
                'status_unit' => $this->input->post('status_unit'),
                'lokasi_unit' => $this->input->post('lokasi_unit'),
                'keterangan_unit' => $this->input->post('keterangan_unit'),
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => $this->session->userdata('user_id'),
                'machine_no' => $this->input->post('machine_no'), // Simpan data
                'model_no' => $this->input->post('model_no'),     // Simpan data
            ];
            $this->db->trans_start(); // Mulai transaksi database
            if ($this->db->insert('unit', $data_unit)) {
                $id_produk = $this->input->post('id_produk');
                $qty_added = $this->input->post('qty');
                $this->db->set('stok_produk', 'stok_produk + ' . $qty_added, FALSE);
                $this->db->where('id_produk', $id_produk);
                $this->db->update('master_produk');
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $this->session->unset_userdata('swal');
                    $this->session->set_flashdata('swal', [
                        'title' => 'Gagal!',
                        'text' => 'Terjadi kesalahan saat menambahkan unit dan memperbarui stok produk.',
                        'icon' => 'error',
                        'showConfirmButton' => true,
                    ]);
                    $this->add_unit();
                } else {
                    $this->db->trans_commit();
                    $this->session->unset_userdata('swal');
                    $this->session->set_flashdata('swal', [
                        'title' => 'Berhasil!',
                        'text' => 'Data unit telah ditambahkan.',
                        'icon' => 'success',
                        'showConfirmButton' => false,
                        'timer' => 1500
                    ]);
                    redirect('inspection/index_unit');
                }
            } else {
                $this->db->trans_rollback();
                $this->session->unset_userdata('swal');
                $this->session->set_flashdata('swal', [
                    'title' => 'Gagal!',
                    'text' => 'Terjadi kesalahan saat menambahkan data unit.',
                    'icon' => 'error',
                    'showConfirmButton' => true,
                ]);
                $this->add_unit();
            }
        }
    }

    public function edit_unit($id) {
        $data['unit'] = $this->db->get_where('unit', ['unit_id' => $id])->row_array();
        $data['products'] = $this->db->get('master_produk')->result_array();
        $data['title'] = 'Edit Unit';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('inspection/unit/edit', $data);
        $this->load->view('templates/footer');
    }

    public function update_unit($id) {
        $this->form_validation->set_rules('serial_number', 'Serial Number', 'required|trim|callback_check_serial_number_update[' . $id . ']');
        $this->form_validation->set_rules('id_produk', 'ID Produk', 'required|trim|numeric');
        $this->form_validation->set_rules('qty', 'Kuantitas', 'required|trim|numeric|greater_than[0]');
        $this->form_validation->set_rules('kondisi_unit', 'Kondisi Unit', 'required|trim');
        $this->form_validation->set_rules('tanggal_masuk', 'Tanggal Masuk', 'required|trim');
        $this->form_validation->set_rules('status_unit', 'Status Unit', 'required|trim');
        $this->form_validation->set_rules('lokasi_unit', 'Lokasi Unit', 'required|trim');
        $this->form_validation->set_rules('keterangan_unit', 'Keterangan Unit', 'trim');
        $this->form_validation->set_rules('machine_no', 'Machine Number', 'trim'); // Tambah validasi
        $this->form_validation->set_rules('model_no', 'Model Number', 'trim');     // Tambah validasi
        if ($this->form_validation->run() == FALSE) {
            $this->edit_unit($id);
        } else {
            $unit_data_lama = $this->db->get_where('unit', ['unit_id' => $id])->row_array();
            if (!$unit_data_lama) {
                $this->session->set_flashdata('error', 'Data unit tidak ditemukan.');
                redirect('inspection/index_unit');
                return;
            }
            $qty_lama = $unit_data_lama['qty'];
            $qty_baru = $this->input->post('qty');
            $id_produk = $this->input->post('id_produk');
            $data_unit_baru = [
                'serial_number' => $this->input->post('serial_number'),
                'id_produk' => $id_produk,
                'status_inspection' => $this->input->post('status_inspection'),
                'qty' => $qty_baru,
                'kondisi_unit' => $this->input->post('kondisi_unit'),
                'tanggal_masuk' => $this->input->post('tanggal_masuk'),
                'tanggal_keluar' => $this->input->post('tanggal_keluar'),
                'status_unit' => $this->input->post('status_unit'),
                'lokasi_unit' => $this->input->post('lokasi_unit'),
                'keterangan_unit' => $this->input->post('keterangan_unit'),
                // 'updated_at' => date('Y-m-d H:i:s'),
                // 'updated_by' => $this->session->userdata('user_id')
                'machine_no' => $this->input->post('machine_no'), // Update data
                'model_no' => $this->input->post('model_no'),     // Update data
            ];
            $this->db->trans_start(); // Mulai transaksi database
            $this->db->where('unit_id', $id);
            if ($this->db->update('unit', $data_unit_baru)) {
                $selisih_qty = $qty_baru - $qty_lama;
                if ($selisih_qty != 0) {
                    $this->db->set('stok_produk', 'stok_produk + (' . $selisih_qty . ')', FALSE);
                    $this->db->where('id_produk', $id_produk);
                    $this->db->update('master_produk');
                }
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $this->session->unset_userdata('swal');
                    $this->session->set_flashdata('swal', [
                        'title' => 'Gagal!',
                        'text' => 'Terjadi kesalahan saat memperbarui unit dan stok produk.',
                        'icon' => 'error',
                        'showConfirmButton' => true,
                    ]);
                    $this->edit_unit($id);
                } else {
                    $this->db->trans_commit();
                    $this->session->unset_userdata('swal');
                    $this->session->set_flashdata('swal', [
                        'title' => 'Berhasil!',
                        'text' => 'Data unit berhasil diperbarui dan stok produk disesuaikan.',
                        'icon' => 'success',
                        'showConfirmButton' => false,
                        'timer' => 1500
                    ]);
                    redirect('inspection/index_unit');
                }
            } else {
                $this->db->trans_rollback();
                $this->session->unset_userdata('swal');
                $this->session->set_flashdata('swal', [
                    'title' => 'Gagal!',
                    'text' => 'Terjadi kesalahan saat memperbarui data unit.',
                    'icon' => 'error',
                    'showConfirmButton' => true,
                ]);
                $this->edit_unit($id);
            }
        }
    }

    public function delete_unit($id) {
        $unit_data = $this->db->get_where('unit', ['unit_id' => $id])->row_array();
        if (!$unit_data) {
            $this->session->set_flashdata('error', 'Data unit tidak ditemukan.');
            redirect('inspection/index_unit');
            return;
        }
        $id_produk = $unit_data['id_produk'];
        $qty_dihapus = $unit_data['qty'];
        $this->db->trans_start(); // Mulai transaksi database
        if ($this->db->delete('unit', ['unit_id' => $id])) {
            $this->db->set('stok_produk', 'stok_produk - ' . $qty_dihapus, FALSE);
            $this->db->where('id_produk', $id_produk);
            $this->db->update('master_produk');
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Terjadi kesalahan saat menghapus unit dan memperbarui stok produk.');
            } else {
                $this->db->trans_commit();
                $this->session->unset_userdata('swal');
                $this->session->set_flashdata('swal', [
                    'title' => 'Berhasil!',
                    'text' => 'Data unit telah dihapus.',
                    'icon' => 'success',
                    'showConfirmButton' => false,
                    'timer' => 1500
                ]);
            }
        } else {
            $this->db->trans_rollback(); // Jaga-jaga jika ada transaksi yang tidak sengaja dimulai
            $this->session->unset_userdata('swal');
            $this->session->set_flashdata('swal', [
                'title' => 'Gagal!',
                'text' => 'Terjadi kesalahan saat menghapus data unit.',
                'icon' => 'error',
                'showConfirmButton' => false,
                'timer' => 1500
            ]);
        }
        redirect('inspection/index_unit');
    }

    public function check_serial_number_update($serial_number, $id) {
        $this->db->where('serial_number', $serial_number);
        $this->db->where('unit_id !=', $id);
        $query = $this->db->get('unit');
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('check_serial_number_update', 'Serial Number sudah digunakan.');
            return FALSE;
        }
        return TRUE;
    }
    /* end unit */

    /* form inspection */
    public function index_form() {
        $this->db->select('*');
        $this->db->from('inspection_template');
        $data['inspection_template'] = $this->db->get()->result_array();
        $data['title'] = 'Form Inspection';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('inspection/form/index', $data);
        $this->load->view('templates/footer');
    }

    public function edit_form($id) {
        $this->db->select('*');
        $this->db->from('inspection_template');
        $this->db->where('id_template', $id);
        $data['inspection_template'] = $this->db->get()->row_array();
        if(!$data['inspection_template']){
            redirect('inspection/index_form');
        }
        $data['title'] = 'Edit Form Inspection';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('inspection/form/edit', $data); //create this file
        $this->load->view('templates/footer');
    }

    public function update_form() {
        $id = $this->input->post('id_template');
        $data = [
            'nama_template' => $this->input->post('nama_template'),
            'deskripsi_template' => $this->input->post('deskripsi_template'),
        ];
        $this->db->where('id_template', $id);
        $this->db->update('inspection_template', $data);
        $this->session->set_flashdata('message', 'Form inspection berhasil diupdate');
        redirect('inspection/index_form');
    }

    public function view_form($id) {
        $query = $this->db->query("
            SELECT
                ii.id_item,
                ii.nama_group,
                ii.nama_item
            FROM
                inspection_template it
            JOIN
                inspection_item ii ON ii.id_template = it.id_template
            WHERE
                it.id_template = ?
            ORDER BY
                ii.urutan ASC
        ", [$id]);
        $template_items = $query->result_array();
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($template_items));
    }

    public function view_result_inspection($id) {
        $query = $this->db->query("
            SELECT
                inspection_template_id,model_no,machine_no,serial_number,customer,address,attachment,time(i.tanggal_inspeksi) hours,i.additional_comment,
                date(i.tanggal_inspeksi) tanggal_inspeksi,
                i.mechanic,
                i.approve_manager,
                i.acknowledge,
                i.additional_comment,
                i.photo_inspection,
                i.photo_hourmeter,
                i.photo_engine_plate,
                i.photo_1,
                i.photo_2,
                i.photo_3,
                i.photo_4,
                i.photo_5,
                i.photo_6,
                i.photo_serialnumber,
                ii.nama_group,
                ii.nama_item,
                id.add,
                id.clean_up,
                id.lubricate,
                id.replace_change,
                id.adjust,
                id.test_check,
                id.remark
            FROM
                inspection i
            JOIN
                inspection_template it ON it.id_template = i.inspection_template_id
            JOIN
                inspection_detail id ON id.inspection_id = i.id_inspection
            JOIN
                inspection_item ii ON ii.id_item = id.item_id
            join unit on unit.unit_id = i.unit_id
            WHERE
                i.id_inspection = ?
            ORDER BY
                ii.urutan ASC -- Menambahkan ORDER BY agar hasilnya terurut, jika ada kolom 'urutan' di inspection_item
        ", [$id]);
        $inspection_results = $query->result_array();
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($inspection_results));
    }
    /* end form inspection */

    /* list inspection */
    public function index_list_inspection() {
        $data['lokasi_units'] = $this->db->get('lokasi_unit')->result_array();
        $tanggal_mulai = $this->input->get('tanggal_mulai');
        $tanggal_akhir = $this->input->get('tanggal_akhir');
        $nama_produk_filter = $this->input->get('nama_produk');
        $kondisi_unit = $this->input->get('kondisi_unit');
        $lokasi_unit = $this->input->get('lokasi_unit');
        $data['daftar_produk'] = $this->db->get('master_produk')->result_array();
        $this->db->select('unit.*, master_produk.nama_produk');
        $this->db->from('unit');
        $this->db->join('master_produk', 'unit.id_produk = master_produk.id_produk');
        $this->db->order_by('unit_id', 'DESC');
        $this->db->where('unit.status_inspection', 'Belum Inspeksi');
        if ($tanggal_mulai && $tanggal_akhir) {
            $this->db->where('unit.tanggal_masuk >=', $tanggal_mulai . ' 00:00:00');
            $this->db->where('unit.tanggal_masuk <=', $tanggal_akhir . ' 23:59:59');
        }
        if ($nama_produk_filter) {
            $this->db->like('master_produk.nama_produk', $nama_produk_filter);
        }
        if ($lokasi_unit) {
            $this->db->like('unit.lokasi_unit', $lokasi_unit);
        }
        if ($kondisi_unit) {
            $this->db->like('unit.kondisi_unit', $kondisi_unit);
        }
        $data['units'] = $this->db->get()->result_array();
        $data['title'] = 'List Inspection';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->db->select('*');
        $this->db->from('inspection_template');
        $data['inspection_template'] = $this->db->get()->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('inspection/list_inspection', $data);
        $this->load->view('templates/footer');
        $this->session->unset_userdata('swal');
    }

    public function result() {
        $data['lokasi_units'] = $this->db->get('lokasi_unit')->result_array();
        $tanggal_mulai = $this->input->get('tanggal_mulai');
        $tanggal_akhir = $this->input->get('tanggal_akhir');
        $nama_produk_filter = $this->input->get('nama_produk');
        $kondisi_unit = $this->input->get('kondisi_unit');
        $lokasi_unit = $this->input->get('lokasi_unit');
        $data['daftar_produk'] = $this->db->get('master_produk')->result_array();
        $this->db->select('unit.*, master_produk.nama_produk, inspection.inspection_template_id as id_template, inspection.id_inspection as id_inspection,approve_manager');
        $this->db->from('unit');
        $this->db->join('master_produk', 'unit.id_produk = master_produk.id_produk');
        $this->db->join('inspection', 'unit.unit_id = inspection.unit_id', 'left');
        $this->db->order_by('unit_id', 'DESC');
        $this->db->where('unit.status_inspection', 'Sudah Inspeksi');
        if ($tanggal_mulai && $tanggal_akhir) {
            $this->db->where('unit.tanggal_masuk >=', $tanggal_mulai . ' 00:00:00');
            $this->db->where('unit.tanggal_masuk <=', $tanggal_akhir . ' 23:59:59');
        }
        if ($nama_produk_filter) {
            $this->db->like('master_produk.nama_produk', $nama_produk_filter);
        }
        if ($lokasi_unit) {
            $this->db->like('unit.lokasi_unit', $lokasi_unit);
        }
        if ($kondisi_unit) {
            $this->db->like('unit.kondisi_unit', $kondisi_unit);
        }
        $data['units'] = $this->db->get()->result_array();
        $data['title'] = 'Result Inspection';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->db->select('*');
        $this->db->from('inspection_template');
        $data['inspection_template'] = $this->db->get()->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('inspection/result_inspection', $data);
        $this->load->view('templates/footer');
        $this->session->unset_userdata('swal');
    }

    public function export_excel()
    {
        $this->load->library('excel');

        $objPHPExcel = $this->excel->createSpreadsheet();
        $sheet = $objPHPExcel->getActiveSheet();

        // Ambil data unit seperti sebelumnya
        $this->db->select('unit.*, master_produk.nama_produk');
        $this->db->from('unit');
        $this->db->join('master_produk', 'unit.id_produk = master_produk.id_produk');
        $this->db->where('unit.status_inspection', 'Sudah Inspeksi');
        $units = $this->db->get()->result_array();

        // Header kolom
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Serial Number');
        $sheet->setCellValue('C1', 'Machine No');
        $sheet->setCellValue('D1', 'Model No');
        $sheet->setCellValue('E1', 'Nama Produk');
        $sheet->setCellValue('F1', 'Qty');
        $sheet->setCellValue('G1', 'Kondisi Unit');
        $sheet->setCellValue('H1', 'Tanggal Masuk');
        $sheet->setCellValue('I1', 'Status Unit');
        $sheet->setCellValue('J1', 'Lokasi Unit');
        $sheet->setCellValue('K1', 'Keterangan Unit');
        $sheet->setCellValue('L1', 'Status Inspeksi');

        $row = 2;
        $no = 1;
        foreach ($units as $unit) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $unit['serial_number']);
            $sheet->setCellValue('C' . $row, $unit['machine_no']);
            $sheet->setCellValue('D' . $row, $unit['model_no']);
            $sheet->setCellValue('E' . $row, $unit['nama_produk']);
            $sheet->setCellValue('F' . $row, $unit['qty']);
            $sheet->setCellValue('G' . $row, $unit['kondisi_unit']);
            $sheet->setCellValue('H' . $row, $unit['tanggal_masuk']);
            $sheet->setCellValue('I' . $row, $unit['status_unit']);
            $sheet->setCellValue('J' . $row, $unit['lokasi_unit']);
            $sheet->setCellValue('K' . $row, $unit['keterangan_unit']);
            $sheet->setCellValue('L' . $row, $unit['status_inspection']);
            $row++;
        }

        $filename = 'Result_Inspection_' . date('Ymd_His') . '.xls';

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = $this->excel->createWriter($objPHPExcel);
        $writer->save('php://output');
        exit;
    }

    public function submit_inspection()
    {
        $input_data = file_get_contents('php://input');
        $post_data = json_decode($input_data, TRUE);
        if ($post_data) { // Periksa apakah decoding berhasil
            $unit_id = $post_data['unit_id'];
            $inspection_data = array(
                'unit_id' => $unit_id,
                'tanggal_inspeksi' => date('Y-m-d H:i:s'),
                'mechanic' => $post_data['mechanic'],
                'customer' => $post_data['customer'],
                'address' => $post_data['address'],
                'attachment' => $post_data['attachment'],
                'acknowledge' => $post_data['acknowledge'],
                'additional_comment' => $post_data['additional_comment'],
                'created_by' => 'user_yang_login',
                'inspection_template_id' => $post_data['template_id'],
                'photo_inspection' => 0
            );
            $this->db->insert('inspection', $inspection_data);
            $inspection_id = $this->db->insert_id();
            // $inspection_id = 24;
            if ($inspection_id) {
                $item_data = $post_data['items'];
                if (is_array($item_data) && !empty($item_data)) {
                    $detail_data = array();
                    foreach ($item_data as $item) {
                        if (isset($item['id_item'])) {
                            $detail_data[] = array(
                                'inspection_id' => $inspection_id,
                                'item_id' => $item['id_item'],
                                'test_check' => isset($item['test_check']) ? $item['test_check'] : null,
                                'remark' => isset($item['remark']) ? $item['remark'] : null,
                                'add' => isset($item['add']) ? $item['add'] : 0,
                                'clean_up' => isset($item['clean_up']) ? $item['clean_up'] : 0,
                                'lubricate' => isset($item['lubricate']) ? $item['lubricate'] : 0,
                                'replace_change' => isset($item['replace_change']) ? $item['replace_change'] : 0,
                                'adjust' => isset($item['adjust']) ? $item['adjust'] : 0
                            );
                        } else {
                            $response = array('status' => 'error', 'message' => 'item_id tidak ada.');
                            $this->output
                                ->set_content_type('application/json')
                                ->set_output(json_encode($response));
                            return;
                        }
                    }
                    if (!empty($detail_data)) {
                        $this->db->insert_batch('inspection_detail', $detail_data);
                        $this->db->where('unit_id', $unit_id);
                        $this->db->update('unit', array('status_inspection' => 'Sudah Inspeksi'));
                        $response = array('status' => 'success', 'message' => 'Data inspeksi berhasil disimpan dan status unit diupdate.','inspection_id'=> $inspection_id);
                    } else {
                        $response = array('status' => 'warning', 'message' => 'Data detail inspeksi kosong.');
                        $this->db->delete('inspection', array('id_inspection' => $inspection_id));
                    }
                } else {
                    $response = array('status' => 'warning', 'message' => 'Tidak ada data item inspeksi untuk disimpan.');
                    $this->db->delete('inspection', array('id_inspection' => $inspection_id));
                }
            } else {
                $response = array('status' => 'error', 'message' => 'Gagal menyimpan data inspeksi utama.');
            }
        } else {
            $response = array('status' => 'error', 'message' => 'Tidak ada data POST yang diterima.');
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    // public function upload_inspection_photo() {
    //     // $response = array('fils' => $_FILES, 'post' => $this->input->post());
    //     $response = array('status' => 'error', 'message' => 'Terjadi kesalahan saat upload foto.');

    //     if ($this->input->method() == 'post') {
    //         $inspection_id = $this->input->post('inspection_id'); // Ambil ID inspeksi dari FormData

    //         if (empty($inspection_id)) {
    //             $response['message'] = 'ID Inspeksi tidak ditemukan.';
    //             echo json_encode($response);
    //             return;
    //         }

    //         if (!empty($_FILES['photo_inspection']['name'])) {
    //             $original_filename = $_FILES['photo_inspection']['name'];
    //             $file_extension = pathinfo($original_filename, PATHINFO_EXTENSION);
                
    //             // Gunakan timestamp untuk nama file yang unik
    //             list($usec, $sec) = explode(" ", microtime());
    //             $milliseconds = round($usec * 1000);
    //             $new_file_name = 'inspection_' . $sec . sprintf('%03d', $milliseconds) . '.' . $file_extension;

    //             $config['upload_path']   = FCPATH . 'assets/img/inspection_photos/'; // Pastikan path ini benar dan dapat ditulis
    //             $config['allowed_types'] = 'gif|jpg|png|jpeg'; // Menambahkan 'gif' ke allowed_types
    //             $config['max_size']      = 2048; // 2MB
    //             $config['file_name']     = $new_file_name; // Gunakan nama file yang sudah digenerate

    //             // Pastikan direktori ada
    //             if (!is_dir($config['upload_path'])) {
    //                 mkdir($config['upload_path'], 0777, TRUE); // Buat direktori jika belum ada
    //             }

    //             // Inisialisasi ulang library upload dengan konfigurasi baru
    //             $this->upload->initialize($config);
    //             $this->upload->set_allowed_types('*');
    //             if ($this->upload->do_upload('photo_inspection')) {
    //                 $upload_data = $this->upload->data();
    //                 $photo_path = $upload_data['file_name']; // Simpan hanya nama file

    //                 // Update kolom photo_inspection di tabel 'inspection'
    //                 $this->db->where('id_inspection', $inspection_id); // Sesuaikan dengan nama kolom ID di tabel inspection Anda
    //                 $update = $update_success = $this->db->update('inspection', array('photo_inspection' => $photo_path));

    //                 if ($update_success) {
    //                     $response['status'] = 'success';
    //                     $response['message'] = 'Foto berhasil diupload dan disimpan.';
    //                 } else {
    //                     // Jika gagal update database, hapus file yang sudah diupload
    //                     unlink($upload_data['full_path']);
    //                     $response['message'] = 'Gagal menyimpan path foto ke database.';
    //                 }
    //             } else {
    //                 $response['message'] = 'Gagal upload foto: ' . $this->upload->display_errors('', '');
    //             }
    //         } else {
    //             $response['status'] = 'success'; // Jika tidak ada foto yang diupload, tetap anggap sukses
    //             $response['message'] = 'Tidak ada foto yang diupload.';
    //         }
    //     } else {
    //         $response['message'] = 'Metode request tidak diizinkan.';
    //     }
    //     echo json_encode($response);
    // }
    public function upload_inspection_photo() {
        $response = array('status' => 'error', 'message' => 'Terjadi kesalahan saat upload foto.');

        if ($this->input->method() == 'post') {
            $inspection_id = $this->input->post('inspection_id');

            if (empty($inspection_id)) {
                $response['message'] = 'ID Inspeksi tidak ditemukan.';
                echo json_encode($response);
                return;
            }

            // Definisi nama-nama kolom foto di database Anda
            $photo_columns = [
                'photo_inspection',
                'photo_hourmeter',
                'photo_engine_plate',
                'photo_1',
                'photo_2',
                'photo_3',
                'photo_4',
                'photo_5',
                'photo_6',
                'photo_serialnumber'
            ];

            $uploaded_photos = []; // Untuk menyimpan nama file yang berhasil diupload
            $errors = []; // Untuk menyimpan error upload

            foreach ($photo_columns as $column_name) {
                // Periksa apakah ada file yang diupload untuk kolom ini
                if (!empty($_FILES[$column_name]['name'])) {
                    // Konfigurasi upload untuk setiap file
                    $config['upload_path']   = FCPATH . 'assets/img/inspection_photos/';
                    $config['allowed_types'] = '*';
                    $config['max_size']      = 2048; // 2MB
                    $config['overwrite']     = FALSE; // Jangan menimpa file dengan nama yang sama
                    
                    // Generate nama file unik menggunakan microtime
                    list($usec, $sec) = explode(" ", microtime());
                    $milliseconds = round($usec * 1000);
                    $file_extension = pathinfo($_FILES[$column_name]['name'], PATHINFO_EXTENSION);
                    $new_file_name = $column_name . '_' . $sec . sprintf('%03d', $milliseconds) . '.' . $file_extension;
                    $config['file_name'] = $new_file_name;

                    // Pastikan direktori ada
                    if (!is_dir($config['upload_path'])) {
                        mkdir($config['upload_path'], 0777, TRUE); // Buat direktori jika belum ada
                    }

                    // Inisialisasi ulang library upload dengan konfigurasi spesifik untuk file ini
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload($column_name)) {
                        $upload_data = $this->upload->data();
                        $uploaded_photos[$column_name] = $upload_data['file_name'];
                    } else {
                        $errors[$column_name] = $this->upload->display_errors('', '');
                    }
                }
            }

            // Update database hanya jika ada foto yang berhasil diupload
            if (!empty($uploaded_photos)) {
                $this->db->where('id_inspection', $inspection_id); // Sesuaikan dengan nama kolom ID di tabel inspection Anda
                $update_success = $this->db->update('inspection', $uploaded_photos);

                if ($update_success) {
                    $response['status'] = 'success';
                    $response['message'] = 'Foto(foto) berhasil diupload dan disimpan.';
                    if (!empty($errors)) {
                        $response['message'] .= ' Namun, beberapa foto gagal diupload: ' . implode(', ', array_values($errors));
                        $response['status'] = 'warning'; // Set status warning jika ada yang gagal
                    }
                } else {
                    $response['message'] = 'Gagal menyimpan path foto ke database.';
                    // Jika gagal update database, hapus semua file yang sudah terupload
                    foreach($uploaded_photos as $filename) {
                        unlink($config['upload_path'] . $filename);
                    }
                }
            } else {
                // Jika tidak ada foto yang diupload atau semua gagal
                if (empty($errors)) {
                    $response['status'] = 'success'; // Anggap sukses jika memang tidak ada foto yang diupload
                    $response['message'] = 'Tidak ada foto yang diupload.';
                } else {
                    $response['message'] = 'Semua foto gagal diupload: ' . implode(', ', array_values($errors));
                }
            }
        } else {
            $response['message'] = 'Metode request tidak diizinkan.';
        }
        echo json_encode($response);
    }

    public function view_hasil_inspeksi($unit_id) {
        $this->db->select('i.*, mp.nama_produk');
        $this->db->from('inspection i');
        $this->db->join('unit u', 'i.unit_id = u.unit_id');
        $this->db->join('master_produk mp', 'u.id_produk = mp.id_produk');
        $this->db->where('i.unit_id', $unit_id);
        $inspection = $this->db->get()->row_array();
    
        $this->db->select('*');
        $this->db->from('inspection_detail id');
        $this->db->where('id.inspection_id', $inspection['id_inspection']); // Gunakan ID inspeksi
        $detail_inspeksi = $this->db->get()->result_array();
    
        $data['title'] = 'Hasil Inspeksi Unit ' . $inspection['no_unit'];
        $data['inspection'] = $inspection;
        $data['detail_inspeksi'] = $detail_inspeksi;
    
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('inspection/result_inspection_id', $data);
        $this->load->view('templates/footer');
    }
    /* end list inspection */

    /* inspection item */
    public function index_inspection_item()
    {
        $this->db->select('inspection_item.*, inspection_template.nama_template');
        $this->db->from('inspection_item');
        $this->db->join('inspection_template', 'inspection_item.id_template = inspection_template.id_template', 'left'); // Gunakan LEFT JOIN
        $query = $this->db->get();
        $data['inspection_items'] = $query->result_array();
        $data['title'] = 'Item Inspection';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('inspection/item/index', $data);
        $this->load->view('templates/footer');
    }

    public function create_inspection_item()
    {
        $data['title'] = 'Create Inspection Item';
        $data['inspection_template'] = $this->db->get('inspection_template')->result_array();
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('inspection/item/create', $data);
        $this->load->view('templates/footer');
        $this->session->unset_userdata('message');
    }

    public function save_inspection_item()
    {
        $this->form_validation->set_rules('nama_group', 'Group Name', 'required');
        $this->form_validation->set_rules('nama_item', 'Item Name', 'required');
        $this->form_validation->set_rules('urutan', 'Order', 'integer');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('inspection/create_inspection_item'); // Redirect tanpa id_template
        } else {
            $data = [
                'nama_group' => $this->input->post('nama_group'),
                'nama_item' => $this->input->post('nama_item'),
                'urutan' => $this->input->post('urutan'),
                'id_template' => $this->input->post('id_template')
            ];

            $this->db->insert('inspection_item', $data);
            $this->session->set_flashdata('message', 'Inspection item berhasil ditambahkan.');
            $this->session->unset_userdata('message');
            redirect('inspection/index_inspection_item'); // Redirect tanpa id_template
        }
    }

    public function edit_inspection_item($id_item)
    {
        $data['inspection_item'] = $this->db->get_where('inspection_item', ['id_item' => $id_item])->row_array();
         if (!$data['inspection_item']) {
            $this->session->unset_userdata('message');
             $this->session->set_flashdata('error', 'Inspection item tidak ditemukan.');
            redirect('inspection/index_inspection_item/');
        }
        $data['title'] = 'Edit Inspection Item';
        $data['inspection_template'] = $this->db->get('inspection_template')->result_array();
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('inspection/item/edit', $data);
        $this->load->view('templates/footer');
    }

    public function update_inspection_item()
    {
        $this->form_validation->set_rules('nama_group', 'Group Name', 'required');
        $this->form_validation->set_rules('nama_item', 'Item Name', 'required');
        $this->form_validation->set_rules('urutan', 'Order', 'integer');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('inspection/edit_inspection_item/'.$this->input->post('id_item'));
        } else {
            $id_item = $this->input->post('id_item');
            $data = [
                'nama_group' => $this->input->post('nama_group'),
                'nama_item' => $this->input->post('nama_item'),
                'urutan' => $this->input->post('urutan'),
                'id_template' => $this->input->post('id_template'),
            ];

            $this->db->where('id_item', $id_item);
            $this->db->update('inspection_item', $data);
            $this->session->unset_userdata('message');
            $this->session->set_flashdata('message', 'Inspection item berhasil diupdate.');
            redirect('inspection/index_inspection_item'); // Redirect
        }
    }

    public function delete_inspection_item($id_item)
    {
        $this->db->where('id_item', $id_item);
        $this->db->delete('inspection_item');
         if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('message', 'Inspection item berhasil dihapus.');
        } else {
             $this->session->set_flashdata('error', 'Inspection item gagal dihapus.');
        }
        redirect('inspection/index_inspection_item'); // Redirect
        $this->session->unset_userdata('message');
    }
    /* end inspection item */

    /* template inspection */
    public function index_template()
    {
        $query = $this->db->get('inspection_template');
        $data['inspection_templates'] = $query->result_array();
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Template Inspection';
        $this->load->view('templates/header', $data); // Load header
        $this->load->view('templates/sidebar', $data); // Load sidebar
        $this->load->view('templates/topbar', $data);    //load topbar
        $this->load->view('inspection/template/index', $data);
        $this->load->view('templates/footer'); // Load footer
        $this->session->unset_userdata('message');
    }

    public function create_template()
    {
        $data['title'] = 'Create Inspection Template';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);  //load header
        $this->load->view('templates/sidebar', $data);  //load sidebar
        $this->load->view('templates/topbar', $data);    //load topbar
        $this->load->view('inspection/template/create');
        $this->load->view('templates/footer'); //load footer
    }

    public function save_template()
    {
        $this->form_validation->set_rules('nama_template', 'Template Name', 'required');
        $this->form_validation->set_rules('deskripsi_template', 'Description', 'trim');
        $this->form_validation->set_rules('created_by', 'Created By', 'trim');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('inspection/create_template');
        } else {
            $data = [
                'nama_template' => $this->input->post('nama_template'),
                'deskripsi_template' => $this->input->post('deskripsi_template'),
                'created_at' => date('Y-m-d H:i:s'), // Set created_at here
                'created_by' => $this->input->post('created_by'),
            ];

            $this->db->insert('inspection_template', $data);
            $this->session->unset_userdata('message');
            $this->session->set_flashdata('message', 'Inspection template berhasil ditambahkan.');
            redirect('inspection/index_template');
        }
    }

    public function edit_template($id_template)
    {
        $query = $this->db->get_where('inspection_template', ['id_template' => $id_template]);
        $data['inspection_template'] = $query->row_array();
        if (!$data['inspection_template']) {
            $this->session->unset_userdata('message');
            $this->session->set_flashdata('error', 'Inspection template tidak ditemukan.');
            redirect('inspection/index_template');
        }
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Edit Inspection Template';
        $this->load->view('templates/header', $data); //load header
        $this->load->view('templates/sidebar', $data); //load side bar
        $this->load->view('templates/topbar', $data);    //load topbar
        $this->load->view('inspection/template/edit', $data);
        $this->load->view('templates/footer');  //load footer
    }

    public function update_template()
    {
        $this->form_validation->set_rules('nama_template', 'Template Name', 'required');
        $this->form_validation->set_rules('deskripsi_template', 'Description', 'trim');
        $this->form_validation->set_rules('created_by', 'Created By', 'trim');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('inspection/edit_template/' . $this->input->post('id_template'));
        } else {
            $id_template = $this->input->post('id_template');
            $data = [
                'nama_template' => $this->input->post('nama_template'),
                'deskripsi_template' => $this->input->post('deskripsi_template'),
                'created_by' => $this->input->post('created_by'),
            ];

            $this->db->where('id_template', $id_template);
            $this->db->update('inspection_template', $data);
            $this->session->unset_userdata('message');
            $this->session->set_flashdata('message', 'Inspection template berhasil diupdate.');
            redirect('inspection/index_template');
        }
    }

    public function delete_template($id_template)
    {
        $this->db->where('id_template', $id_template);
        $this->db->delete('inspection_template');
        $this->session->unset_userdata('message');
        $this->session->set_flashdata('message', 'Inspection template berhasil dihapus.');
        redirect('inspection/index_template');
    }
    /* end template inspection */

    /* lokasi unit */
    public function lokasi_unit()
    {
        $data['title'] = 'Lokasi Unit';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        // Mengambil semua data lokasi unit
        $data['locations'] = $this->db->get('lokasi_unit')->result_array();

        // Validasi untuk penambahan lokasi unit baru
        $this->form_validation->set_rules('lokasi_unit', 'Location Name', 'required|trim|is_unique[lokasi_unit.lokasi_unit]', [
            'is_unique' => 'This location name already exists!'
        ]);

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('inspection/lokasi_unit', $data); // View untuk lokasi unit
            $this->load->view('templates/footer');
        } else {
            // Proses penambahan lokasi unit baru
            $this->db->insert('lokasi_unit', ['lokasi_unit' => htmlspecialchars($this->input->post('lokasi_unit', true))]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New unit location added!</div>');
            redirect('inspection/lokasi_unit');
        }
    }

    public function edit_lokasi_unit()
    {
        $data['title'] = 'Edit Unit Location';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $id = $this->input->post('id');
        $original_location_name = $this->input->post('original_lokasi_unit_name');
        $new_location_name = htmlspecialchars($this->input->post('lokasi_unit', true));

        $this->form_validation->set_rules('lokasi_unit', 'Location Name', 'required|trim');

        // Tambahkan validasi is_unique hanya jika nama lokasi diubah
        if ($new_location_name != $original_location_name) {
            $this->form_validation->set_rules('lokasi_unit', 'Location Name', 'is_unique[lokasi_unit.lokasi_unit]', [
                'is_unique' => 'This location name already exists!'
            ]);
        }

        if ($this->form_validation->run() == false) {
            // Jika validasi gagal, kembalikan ke halaman daftar lokasi
            // (Mungkin dengan modal edit terbuka jika menggunakan AJAX untuk form submit)
            // Untuk kesederhanaan, kita akan redirect jika form gagal divalidasi
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . validation_errors() . '</div>');
            redirect('inspection/lokasi_unit');
        } else {
            // Proses update lokasi unit
            $this->db->where('id', $id);
            $this->db->update('lokasi_unit', ['lokasi_unit' => $new_location_name]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Unit location updated!</div>');
            redirect('inspection/lokasi_unit');
        }
    }

    public function delete_lokasi_unit($id)
    {
        if (!is_numeric($id)) {
            redirect('inspection/lokasi_unit'); // Redirect jika ID tidak valid
        }

        $this->db->where('id', $id);
        $this->db->delete('lokasi_unit');

        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Unit location deleted!</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">Failed to delete unit location or location not found.</div>');
        }
        
        redirect('inspection/lokasi_unit');
    }
    /* end lokasi unit */

    /* Brand CRUD */
    public function brand()
    {
        $ci = get_instance();
        if (!$ci->session->userdata('email')) {
            redirect('auth');
            return;
        }
        $data['title'] = 'Brand';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['brands'] = $this->db->get('brand')->result_array();
        $this->form_validation->set_rules('brand', 'Brand Name', 'required|trim|is_unique[brand.brand]', [
            'is_unique' => 'This brand name already exists!'
        ]);
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('inspection/brand', $data); // View untuk brand
            $this->load->view('templates/footer');
        } else {
            $this->db->insert('brand', ['brand' => htmlspecialchars($this->input->post('brand', true))]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New brand added!</div>');
            redirect('inspection/brand');
        }
    }

    public function edit_brand()
    {
        $data['title'] = 'Edit Brand';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $id = $this->input->post('id'); // Ambil ID brand dari input hidden
        $original_brand_name = $this->input->post('original_brand'); // Ambil nama brand asli untuk validasi
        $new_brand_name = htmlspecialchars($this->input->post('brand', true)); 
        $this->form_validation->set_rules('brand', 'Brand Name', 'required|trim');
        if ($new_brand_name != $original_brand_name) {
            $this->form_validation->set_rules('brand', 'Brand Name', 'is_unique[brand.brand]', [
                'is_unique' => 'This brand name already exists!'
            ]);
        }
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . validation_errors() . '</div>');
            redirect('inspection/brand');
        } else {
            $this->db->where('id', $id); // Pastikan kolom ID di tabel brand adalah 'id'
            $this->db->update('brand', ['brand' => $new_brand_name]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Brand updated!</div>');
            redirect('inspection/brand');
        }
    }

    public function delete_brand($id)
    {
        $this->db->where('id', $id); // Pastikan kolom ID di tabel brand adalah 'id'
        $this->db->delete('brand');
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Brand deleted!</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">Failed to delete brand or brand not found.</div>');
        }
        redirect('inspection/brand');
    }
    /* End Brand CRUD */
}
