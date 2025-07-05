<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // is_logged_in();
    }

    public function cetak()
    {
        $data['title'] = 'Test Cetak';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L']);
        $html = $this->load->view('admin/cetak', $data, true);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['total_produk'] = $this->db->count_all('master_produk');
        $data['total_unit'] = $this->db->count_all('unit');
        $data['unit_sudah_inspeksi'] = $this->db->where('status_inspection', 'Sudah Inspeksi')->count_all_results('unit');
        $data['unit_belum_inspeksi'] = $this->db->where('status_inspection', 'Belum Inspeksi')->count_all_results('unit');
        $data['units'] = $this->db->select('unit.*, master_produk.nama_produk, inspection.tanggal_inspeksi')
        ->from('unit')
        ->join('master_produk', 'unit.id_produk = master_produk.id_produk', 'left')
        ->join('inspection', 'unit.unit_id = inspection.unit_id', 'left') // Gabungkan dengan tabel inspection
        ->get()
        ->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');
    }


    public function role()
    {
        $data['title'] = 'Role';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['role'] = $this->db->get('user_role')->result_array();

        // Validasi untuk penambahan role baru
        $this->form_validation->set_rules('role', 'Role', 'required|trim|is_unique[user_role.role]', [
            'is_unique' => 'This role name already exists!'
        ]);

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/role', $data);
            $this->load->view('templates/footer');
        } else {
            // Proses penambahan role baru
            $this->db->insert('user_role', ['role' => $this->input->post('role')]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New role added!</div>');
            redirect('admin/role');
        }
    }

    // Method untuk mengedit role
    public function editRole()
    {
        $data['title'] = 'Edit Role';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        
        $role_id = $this->input->post('id');
        $data['role_item'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();

        $this->form_validation->set_rules('role', 'Role', 'required|trim');
        
        // Tambahkan validasi is_unique hanya jika nama role diubah
        $original_role_name = $this->input->post('original_role_name'); // Dari hidden input di modal
        $new_role_name = $this->input->post('role');

        if ($new_role_name != $original_role_name) {
            $this->form_validation->set_rules('role', 'Role', 'is_unique[user_role.role]', [
                'is_unique' => 'This role name already exists!'
            ]);
        }

        if ($this->form_validation->run() == false) {
            // Jika validasi gagal, atau pertama kali memuat form edit
            // Anda bisa arahkan kembali ke halaman role dengan modal edit terbuka
            // Namun, untuk kesederhanaan, kita akan tampilkan pesan error jika ada
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/role', $data); // Tampilkan halaman role lagi
            $this->load->view('templates/footer');
        } else {
            // Proses update role
            $updated_role_name = $this->input->post('role');
            $this->db->where('id', $role_id);
            $this->db->update('user_role', ['role' => $updated_role_name]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Role updated!</div>');
            redirect('admin/role');
        }
    }

    // Method untuk menghapus role
    public function deleteRole($id)
    {
        if (!is_numeric($id)) {
            redirect('admin/role'); // Redirect jika ID tidak valid
        }
        $this->db->where('id', $id);
        $this->db->delete('user_role');
        // Juga hapus akses menu yang terkait dengan role ini
        $this->db->where('role_id', $id);
        $this->db->delete('user_access_menu');

        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Role and its access deleted!</div>');
        redirect('admin/role');
    }


    public function roleAccess($role_id)
    {
        $data['title'] = 'Role Access';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();

        $this->db->where('id !=', 1);
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role-access', $data);
        $this->load->view('templates/footer');
    }


    public function changeAccess()
    {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');

        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];

        $result = $this->db->get_where('user_access_menu', $data);

        if ($result->num_rows() < 1) {
            $this->db->insert('user_access_menu', $data);
        } else {
            $this->db->delete('user_access_menu', $data);
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Access Changed!</div>');
    }
}
