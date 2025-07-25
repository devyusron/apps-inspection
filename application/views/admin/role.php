<div class="container-fluid">

    <div class="m-1 shadow card">
        <div class="card-header mb-4 d-flex justify-content-between align-items-center">
            <h1 class="h3 text-gray-800"><?= $title; ?></h1>
            <a href="" class="btn btn-outline-primary mb-0" data-toggle="modal" data-target="#newRoleModal">
                <i class="fas fa-plus mr-2"></i>
                Add New Role
            </a>
        </div>
        <div class="row">
            <div class="col-lg m-1">
                <?= form_error('role', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                
                <?php if ($this->session->flashdata('message')): ?>
                    <?php echo $this->session->flashdata('message'); ?>
                    <script>
                        // Script untuk menghilangkan flashdata message setelah 5 detik
                        setTimeout(function() {
                            var alertElement = document.querySelector('.alert');
                            if (alertElement) {
                                alertElement.style.display = 'none';
                            }
                        }, 5000);
                    </script>
                    <?php $this->session->unset_userdata('message'); // Hapus flashdata setelah ditampilkan ?>
                <?php endif; ?>

                <br>
                <!-- <a href="<?= base_url('admin/cetak'); ?>" class="btn btn-primary" target="_blank">Cetak</a> -->
                <br>
                <table class="table table-hover" id="dataTable">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Role</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($role as $r) : ?>
                            <tr>
                                <th scope="row"><?= $i; ?></th>
                                <td><?= $r['role']; ?></td>
                                <td>
                                    <a href="<?= base_url('admin/roleaccess/') . $r['id']; ?>" class="badge badge-warning">access</a>
                                    <a href="#" class="badge badge-success" data-toggle="modal" data-target="#editRoleModal"
                                        data-id="<?= $r['id']; ?>" data-role="<?= $r['role']; ?>">edit</a>
                                    <a href="<?= base_url('admin/deleteRole/' . $r['id']); ?>" class="badge badge-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus role ini? Ini juga akan menghapus semua akses menu yang terkait!');">delete</a>
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
<div class="modal fade" id="newRoleModal" tabindex="-1" role="dialog" aria-labelledby="newRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newRoleModalLabel">Add New Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/role'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="role" name="role" placeholder="Role name">
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

<div class="modal fade" id="editRoleModal" tabindex="-1" role="dialog" aria-labelledby="editRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRoleModalLabel">Edit Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/editRole'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" id="edit_role_id" name="id">
                    <input type="hidden" id="original_role_name" name="original_role_name"> <div class="form-group">
                        <input type="text" class="form-control" id="edit_role_name" name="role" placeholder="Role name">
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
    // Script untuk mengisi data ke modal edit saat tombol edit diklik
    $('#editRoleModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Tombol yang memicu modal
        var id = button.data('id'); // Ambil data-id dari tombol
        var role_name = button.data('role'); // Ambil data-role dari tombol

        var modal = $(this);
        modal.find('.modal-body #edit_role_id').val(id); // Set ID ke hidden input
        modal.find('.modal-body #edit_role_name').val(role_name); // Set nama role ke input teks
        modal.find('.modal-body #original_role_name').val(role_name); // Set nama role asli ke hidden input
    });

    // Script untuk menghilangkan flashdata message (sudah ada di contoh Anda, tapi saya masukkan kembali untuk kelengkapan)
    $(document).ready(function() {
        setTimeout(function() {
            var alertElement = $('.alert');
            if (alertElement.length) {
                alertElement.fadeOut('slow', function() {
                    $(this).remove();
                });
            }
        }, 5000); // 5000 milidetik = 5 detik
    });
</script>