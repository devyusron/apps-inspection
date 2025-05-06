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

    public function master_produk()
    {
        $data['title'] = 'Master Produk';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['master_produk'] = $this->db->get('master_produk')->result_array();
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
        // Tambahkan rules validasi lain sesuai kebutuhan

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

            // Handle upload gambar jika ada perubahan
            $upload_data = $this->_uploadImage_master_produk();
            if ($upload_data) {
                $data['url_gambar_produk'] = $upload_data;
                // Hapus gambar lama jika ada
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

        // Hapus gambar terkait jika ada
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

        // Mendapatkan microtime sebagai float (detik dan pecahan mikro)
        $microtime = microtime(true);

        // Mengubah float menjadi string dan menghilangkan titik desimal
        $microtime_str = str_replace('.', '', (string) $microtime);

        // Mengambil 10 digit pertama (atau lebih, tergantung presisi)
        $timestamp_milisecond = substr($microtime_str, 0, 10);

        $config['file_name'] = 'produk_' . $timestamp_milisecond;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('url_gambar_produk')) {
            return $this->upload->data('file_name');
        } else {
            return '';
        }
    }
}
