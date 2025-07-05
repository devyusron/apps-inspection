<div class="container-fluid">

    <div class="m-1 shadow card">
        <div class="card-header mb-4 d-flex justify-content-between align-items-center">
            <h1 class="h3 text-gray-800"><?= $title; ?></h1>
            <a href="" class="btn btn-outline-primary mb-0" data-toggle="modal" data-target="#newLocationModal">
                <i class="fas fa-plus mr-2"></i>
                Add New Location
            </a>
        </div>
        <div class="row">
            <div class="col-lg m-1">
                <?= form_error('lokasi_unit', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                
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
                            <th scope="col">Location Name</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($locations as $loc) : ?>
                            <tr>
                                <th scope="row"><?= $i; ?></th>
                                <td><?= $loc['lokasi_unit']; ?></td>
                                <td>
                                    <a href="#" class="badge badge-success" data-toggle="modal" data-target="#editLocationModal"
                                        data-id="<?= $loc['id']; ?>" data-lokasi_unit="<?= $loc['lokasi_unit']; ?>">edit</a>
                                    <a href="<?= base_url('inspection/delete_lokasi_unit/' . $loc['id']); ?>" class="badge badge-danger" onclick="return confirm('Are you sure you want to delete this unit location?');">delete</a>
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
<div class="modal fade" id="newLocationModal" tabindex="-1" role="dialog" aria-labelledby="newLocationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newLocationModalLabel">Add New Unit Location</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('inspection/lokasi_unit'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="lokasi_unit" name="lokasi_unit" placeholder="Unit Location Name">
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

<div class="modal fade" id="editLocationModal" tabindex="-1" role="dialog" aria-labelledby="editLocationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editLocationModalLabel">Edit Unit Location</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('inspection/edit_lokasi_unit'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" id="edit_location_id" name="id">
                    <input type="hidden" id="original_lokasi_unit_name" name="original_lokasi_unit_name">
                    <div class="form-group">
                        <input type="text" class="form-control" id="edit_lokasi_unit_name" name="lokasi_unit" placeholder="Unit Location Name">
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
    $('#editLocationModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Tombol yang memicu modal
        var id = button.data('id'); // Ambil data-id
        var lokasi_unit_name = button.data('lokasi_unit'); // Ambil data-lokasi_unit

        var modal = $(this);
        modal.find('.modal-body #edit_location_id').val(id); // Set ID ke hidden input
        modal.find('.modal-body #edit_lokasi_unit_name').val(lokasi_unit_name); // Set nama lokasi ke input teks
        modal.find('.modal-body #original_lokasi_unit_name').val(lokasi_unit_name); // Set nama asli untuk validasi
    });

    // Script untuk menghilangkan flashdata message (sudah ada di contoh Anda)
    $(document).ready(function() {
        setTimeout(function() {
            var alertElement = $('.alert');
            if (alertElement.length) {
                alertElement.fadeOut('slow', function() {
                    $(this).remove();
                });
            }
        }, 5000);
    });
</script>