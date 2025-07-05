<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Account extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Pastikan Anda memiliki helper 'is_logged_in()' atau sesuaikan dengan sistem otentikasi Anda
        is_logged_in(); 
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['title'] = 'User Management';
        // Mengambil data user yang sedang login
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        // Mengambil semua data user dari tabel 'user'
        $data['users_management'] = $this->db->get('user')->result_array();
        
        // Mengambil data roles untuk dropdown di form
        $data['roles'] = $this->db->get('user_role')->result_array();

        // Rules untuk validasi form tambah user
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'This email has already registered!'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => 'Password mismatch!',
            'min_length' => 'Password too short!'
        ]);
        $this->form_validation->set_rules('password2', 'Repeat Password', 'required|trim|matches[password]');
        $this->form_validation->set_rules('role_id', 'Role', 'required');
        
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('account/index', $data); // View untuk menampilkan daftar user
            $this->load->view('templates/footer');
        } else {
            // Proses penambahan user baru
            $data = [
                'name' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'image' => 'default.jpg', // Default image
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'role_id' => $this->input->post('role_id'),
                'is_active' => $this->input->post('is_active') ? 1 : 0, // Checkbox for active status
                'date_created' => time()
            ];

            $this->db->insert('user', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New user added!</div>');
            redirect('account');
        }
    }

    public function edit()
    {
        $data['title'] = 'Edit User';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        
        $user_id = $this->input->post('id');
        $data['user_item'] = $this->db->get_where('user', ['id' => $user_id])->row_array();
        $data['roles'] = $this->db->get('user_role')->result_array(); // Untuk dropdown roles

        // Rules untuk validasi form edit user
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('role_id', 'Role', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/edit', $data); // Anda perlu membuat view 'user/edit'
            $this->load->view('templates/footer');
        } else {
            $name = htmlspecialchars($this->input->post('name', true));
            $role_id = $this->input->post('role_id');
            $is_active = $this->input->post('is_active') ? 1 : 0;
            $email_original = $this->input->post('email_original'); // Hidden field untuk email asli

            $update_data = [
                'name' => $name,
                'role_id' => $role_id,
                'is_active' => $is_active
            ];

            // Cek jika password diisi, update password juga
            $new_password = $this->input->post('new_password');
            if (!empty($new_password)) {
                $this->form_validation->set_rules('new_password', 'New Password', 'trim|min_length[3]|matches[confirm_new_password]', [
                    'matches' => 'New password mismatch!',
                    'min_length' => 'New password too short!'
                ]);
                $this->form_validation->set_rules('confirm_new_password', 'Confirm New Password', 'trim|matches[new_password]');

                if ($this->form_validation->run() == false) {
                    $this->load->view('templates/header', $data);
                    $this->load->view('templates/sidebar', $data);
                    $this->load->view('templates/topbar', $data);
                    $this->load->view('user/edit', $data);
                    $this->load->view('templates/footer');
                    return; // Hentikan eksekusi jika validasi password gagal
                } else {
                    $update_data['password'] = password_hash($new_password, PASSWORD_DEFAULT);
                }
            }

            // Cek jika email diubah, tambahkan validasi is_unique
            $email_input = htmlspecialchars($this->input->post('email', true));
            if ($email_input != $email_original) {
                $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
                    'is_unique' => 'This email has already registered!'
                ]);
                if ($this->form_validation->run() == false) {
                    $this->load->view('templates/header', $data);
                    $this->load->view('templates/sidebar', $data);
                    $this->load->view('templates/topbar', $data);
                    $this->load->view('user/edit', $data);
                    $this->load->view('templates/footer');
                    return; // Hentikan eksekusi jika validasi email gagal
                } else {
                    $update_data['email'] = $email_input;
                }
            }
            
            $this->db->where('id', $user_id);
            $this->db->update('user', $update_data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">User updated!</div>');
            redirect('account');
        }
    }

    public function delete($id)
    {
        if (!is_numeric($id)) {
            redirect('account'); // Redirect jika ID tidak valid
        }
        $this->db->where('id', $id);
        $this->db->delete('user');
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">User deleted!</div>');
        redirect('account');
    }
}