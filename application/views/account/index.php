<div class="container-fluid">

    <div class="m-1 shadow card">
        <div class="card-header mb-4 d-flex justify-content-between align-items-center">
            <h1 class="h3 text-gray-800"><?= $title; ?></h1>
            <a href="" class="btn btn-outline-primary mb-0" data-toggle="modal" data-target="#newUserModal">
                <i class="fas fa-plus mr-2"></i>
                Add User
            </a>
        </div>
        <div class="row">
            <div class="col-lg m-1">
                <?= form_error('name', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                <?= form_error('email', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                <?= form_error('password', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                <?= form_error('role_id', '<div class="alert alert-danger" role="alert">', '</div>'); ?>

                <?php if ($this->session->flashdata('message')): ?>
                    <?php echo $this->session->flashdata('message'); ?>
                    <script>
                        setTimeout(function() {
                            var alertElement = document.querySelector('.alert');
                            if (alertElement) {
                                alertElement.style.display = 'none';
                            }
                        }, 5000);
                    </script>
                    <?php $this->session->unset_userdata('message'); ?>
                <?php endif; ?>

                <table class="table table-hover" id="dataTable">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Active</th>
                            <th scope="col">Date Created</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($users_management as $u) : ?>
                            <tr>
                                <th scope="row"><?= $i; ?></th>
                                <td><?= $u['name']; ?></td>
                                <td><?= $u['email']; ?></td>
                                <td>
                                    <?php 
                                        $role = $this->db->get_where('user_role', ['id' => $u['role_id']])->row_array();
                                        echo $role['role'];
                                    ?>
                                </td>
                                <td><?= $u['is_active'] == 1 ? 'Yes' : 'No'; ?></td>
                                <td><?= date('d M Y', $u['date_created']); ?></td>
                                <td>
                                    <a href="#" class="badge badge-success" data-toggle="modal" data-target="#editUserModal"
                                        data-id="<?= $u['id']; ?>"
                                        data-name="<?= $u['name']; ?>"
                                        data-email="<?= $u['email']; ?>"
                                        data-roleid="<?= $u['role_id']; ?>"
                                        data-isactive="<?= $u['is_active']; ?>">edit</a>
                                    <a href="<?= base_url('user/delete/' . $u['id']); ?>" class="badge badge-danger" onclick="return confirm('Are you sure you want to delete this user?');">delete</a>
                                </td>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
<div class="modal fade" id="newUserModal" tabindex="-1" role="dialog" aria-labelledby="newUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newUserModalLabel">Add New User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('account'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Full Name" value="<?= set_value('name'); ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="Email Address" value="<?= set_value('email'); ?>">
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                        </div>
                        <div class="col-sm-6">
                            <label for="password2">Repeat Password</label>
                            <input type="password" class="form-control" id="password2" name="password2" placeholder="Repeat Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="role_id">Role</label>
                        <select name="role_id" id="role_id" class="form-control">
                            <option value="">Select Role</option>
                            <?php foreach ($roles as $r) : ?>
                                <option value="<?= $r['id']; ?>"><?= $r['role']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" checked>
                        <label class="form-check-label" for="is_active">Active?</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('account/edit'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" id="id" name="id">
                    <input type="hidden" id="email_original" name="email_original">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" class="form-control" id="name_edit" name="name">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" id="email_edit" name="email">
                    </div>
                     <div class="form-group row">
                        <div class="col-sm-6">
                            <label for="new_password">New Password (optional)</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" placeholder="New Password">
                        </div>
                        <div class="col-sm-6">
                            <label for="confirm_new_password">Confirm New Password</label>
                            <input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password" placeholder="Confirm New Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="role_id_edit">Role</label>
                        <select name="role_id" id="role_id_edit" class="form-control">
                            <?php foreach ($roles as $r) : ?>
                                <option value="<?= $r['id']; ?>"><?= $r['role']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="is_active_edit" name="is_active" value="1">
                        <label class="form-check-label" for="is_active_edit">Active?</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script>
    $('#editUserModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var name = button.data('name');
        var email = button.data('email');
        var roleid = button.data('roleid');
        var isactive = button.data('isactive');

        var modal = $(this);
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #email_original').val(email); // Simpan email asli
        modal.find('.modal-body #name_edit').val(name);
        modal.find('.modal-body #email_edit').val(email);
        modal.find('.modal-body #role_id_edit').val(roleid);
        modal.find('.modal-body #is_active_edit').prop('checked', isactive == 1);
    });
</script>