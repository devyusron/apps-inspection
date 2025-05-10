<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inspection extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // date_default_timezone_set('Asia/Jakarta');
        // is_logged_in();
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
        }
        $data['master_produk'] = $this->db->get()->result_array();
        // Untuk dropdown Nama Produk
        $this->db->select('nama_produk');
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
        $this->form_validation->set_rules('kode_produk', 'Kode Produk', 'trim');
        $this->form_validation->set_rules('deskripsi_produk', 'Deskripsi Produk', 'trim');
        $this->form_validation->set_rules('harga_produk', 'Harga', 'trim|numeric');
        $this->form_validation->set_rules('stok_produk', 'Stok', 'trim|numeric');
        if ($this->form_validation->run() == FALSE) {
            $this->master_produk(); // Reload halaman master produk dengan menampilkan error validasi (jika ada)
        } else {
            $data = [
                'nama_produk' => $this->input->post('nama_produk'),
                'kode_produk' => $this->input->post('kode_produk'),
                'url_gambar_produk' => $this->_uploadImage_master_produk(), // Fungsi untuk upload gambar
                'deskripsi_produk' => $this->input->post('deskripsi_produk'),
                'harga_produk' => $this->input->post('harga_produk'),
                'harga_asli' => $this->input->post('harga_asli'),
                'harga_diskon' => $this->input->post('harga_diskon'),
                'stok_produk' => $this->input->post('stok_produk'),
                'minimum_stok_produk' => $this->input->post('minimum_stok_produk'),
                'kategori_produk' => $this->input->post('kategori_produk'),
                'brand_produk' => $this->input->post('brand_produk'),
                'tag_produk' => $this->input->post('tag_produk'),
                'dimensi_produk' => $this->input->post('dimensi_produk'),
                'berat_produk' => $this->input->post('berat_produk'),
                'warna_produk' => $this->input->post('warna_produk'),
                'is_active' => $this->input->post('is_active') ? 1 : 0,
                'created_by' => $this->session->userdata('user_id') ? $this->session->userdata('user_id') : 'SYSTEM',
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->db->insert('master_produk', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Produk berhasil ditambahkan!</div>');
            redirect('inspection/master_produk');
        }
    }

    public function edit_master_produk()
    {
        $id_produk = $this->input->post('id_produk');
        $this->form_validation->set_rules('nama_produk', 'Nama Produk', 'required|trim');
        // Tambahkan rules validasi lain sesuai kebutuhan

        if ($this->form_validation->run() == FALSE) {
            $this->master_produk(); // Reload halaman master produk dengan menampilkan error validasi (jika ada)
        } else {
            $data = [
                'nama_produk' => $this->input->post('nama_produk'),
                'kode_produk' => $this->input->post('kode_produk'),
                'deskripsi_produk' => $this->input->post('deskripsi_produk'),
                'harga_produk' => $this->input->post('harga_produk'),
                'harga_asli' => $this->input->post('harga_asli'),
                'harga_diskon' => $this->input->post('harga_diskon'),
                'stok_produk' => $this->input->post('stok_produk'),
                'minimum_stok_produk' => $this->input->post('minimum_stok_produk'),
                'kategori_produk' => $this->input->post('kategori_produk'),
                'brand_produk' => $this->input->post('brand_produk'),
                'tag_produk' => $this->input->post('tag_produk'),
                'dimensi_produk' => $this->input->post('dimensi_produk'),
                'berat_produk' => $this->input->post('berat_produk'),
                'warna_produk' => $this->input->post('warna_produk'),
                'is_active' => $this->input->post('is_active') ? 1 : 0,
                // 'updated_by' => $this->session->userdata('user_id') ? $this->session->userdata('user_id') : 'SYSTEM',
                // 'updated_at' => date('Y-m-d H:i:s')
            ];
            $upload_data = $this->_uploadImage_master_produk();
            if ($upload_data) {
                $data['url_gambar_produk'] = $upload_data;
                $old_image = $this->db->get_where('master_produk', ['id_produk' => $id_produk])->row()->url_gambar_produk;
                if ($old_image && file_exists(FCPATH . 'assets/img/produk/' . $old_image)) {
                    unlink(FCPATH . 'assets/img/produk/' . $old_image);
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
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = 2048;
        $config['overwrite'] = true;
        $microtime = microtime(true);
        $microtime_str = str_replace('.', '', (string) $microtime);
        $timestamp_milisecond = substr($microtime_str, 0, 10);
        $config['file_name'] = 'produk_' . $timestamp_milisecond;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('url_gambar_produk')) {
            return $this->upload->data('file_name');
        } else {
            return '';
        }
    }
    /* end produk */

    /* unit */
    public function index_unit() {
        $tanggal_mulai = $this->input->get('tanggal_mulai');
        $tanggal_akhir = $this->input->get('tanggal_akhir');
        $nama_produk_filter = $this->input->get('nama_produk');
        $data['daftar_produk'] = $this->db->get('master_produk')->result_array();
        $this->db->select('unit.*, master_produk.nama_produk');
        $this->db->from('unit');
        $this->db->join('master_produk', 'unit.id_produk = master_produk.id_produk');
        $this->db->order_by('unit_id', 'DESC');
        if ($tanggal_mulai && $tanggal_akhir) {
            $this->db->where('unit.tanggal_masuk >=', $tanggal_mulai . ' 00:00:00');
            $this->db->where('unit.tanggal_masuk <=', $tanggal_akhir . ' 23:59:59');
        }
        if ($nama_produk_filter) {
            $this->db->like('master_produk.nama_produk', $nama_produk_filter);
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
                'created_by' => $this->session->userdata('user_id')
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
    /* end form inspection */

    /* list inspection */
    public function index_list_inspection() {
        $tanggal_mulai = $this->input->get('tanggal_mulai');
        $tanggal_akhir = $this->input->get('tanggal_akhir');
        $nama_produk_filter = $this->input->get('nama_produk');
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

    public function submit_inspection() {
        // $this->form_validation->set_rules('unit_id', 'Unit ID', 'required|numeric');
        // $this->form_validation->set_rules('template_id', 'Template ID', 'required|numeric');
    
        // if ($this->form_validation->run() == FALSE) {
        //     $this->output->set_status_header(400);
        //     echo json_encode(array('error' => validation_errors()));
        //     return;
        // }
    
        // $unit_id = $this->input->post('unit_id');
        // $template_id = $this->input->post('template_id');
        // $inspection_date = date('Y-m-d H:i:s');
        // $additional_comment = $this->input->post('additional_comment');
        // $acknowledge = $this->input->post('acknowledge');
        // $mechanic = $this->input->post('mechanic');
    
        // $inspection_data = array(
        //     'unit_id' => $unit_id,
        //     'inspection_template_id' => $template_id,
        //     'tanggal_inspeksi' => $inspection_date,
        //     'additional_comment' => $additional_comment,
        //     'acknowledge' => $acknowledge,
        //     'mechanic' => $mechanic,
        // );
    
        // $this->db->insert('inspection', $inspection_data);
        // $inspection_id = $this->db->insert_id();
    
        // $detail_data = array();
        // $item_ids = $this->input->post('item_id'); // Get the array of item IDs
        // $adds = $this->input->post('add');
        // $clean_ups = $this->input->post('clean_up');
        // $lubricates = $this->input->post('lubricate');
        // $replace_changes = $this->input->post('replace_change');
        // $adjusts = $this->input->post('adjust');
        // $test_checks = $this->input->post('test_check');
        // $remarks = $this->input->post('remark');
    
        // if ($item_ids) { // Check if item_ids array is not empty
        //     foreach ($item_ids as $index => $item_id) {
        //         $detail_data[] = array(
        //             'inspection_id' => $inspection_id,
        //             'item_id' => $item_id,
        //             'add' => isset($adds[$item_id]) ? $adds[$item_id] : 0,
        //             'clean_up' => isset($clean_ups[$item_id]) ? $clean_ups[$item_id] : 0,
        //             'lubricate' => isset($lubricates[$item_id]) ? $lubricates[$item_id] : 0,
        //             'replace_change' => isset($replace_changes[$item_id]) ? $replace_changes[$item_id] : 0,
        //             'adjust' => isset($adjusts[$item_id]) ? $adjusts[$item_id] : 0,
        //             'test_check' => isset($test_checks[$item_id]) ? $test_checks[$item_id] : '', //sesuaikan dengan varchar
        //             'remark' => isset($remarks[$item_id]) ? $remarks[$item_id] : NULL,
        //         );
        //     }
        //     $this->db->insert_batch('inspection_detail', $detail_data);
        // }
    
        // $this->db->where('id_unit', $unit_id);
        // $this->db->update('unit', array('status_inspeksi' => 'Sudah Inspeksi'));
    
        // echo json_encode(array('success' => 'Inspeksi berhasil disimpan!'));
        echo json_encode(array('success' => $this->input->post()));
    }
    /* end list inspection */
}
