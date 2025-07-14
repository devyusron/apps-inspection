<div class="container-fluid">

    <div class="m-1 shadow card">
        <div class="card-header mb-4 d-flex justify-content-between align-items-center">
            <h1 class="h3 text-gray-800"><?= $title; ?></h1>
            <a href="" class="btn btn-outline-primary mb-0" data-toggle="modal" data-target="#newBrandModal">
                <i class="fas fa-plus mr-2"></i>
                Add New Brand
            </a>
        </div>
        <div class="row">
            <div class="col-lg m-1">
                <?= form_error('brand', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                
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

                <table class="table table-hover" id="dataTable">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Brand Name</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($brands as $brand) : ?>
                            <tr>
                                <th scope="row"><?= $i; ?></th>
                                <td><?= $brand['brand']; ?></td>
                                <td>
                                    <a href="#" class="badge badge-success" data-toggle="modal" data-target="#editBrandModal"
                                        data-id="<?= $brand['id']; ?>" data-brand="<?= $brand['brand']; ?>">edit</a>
                                    <a href="<?= base_url('inspection/delete_brand/' . $brand['id']); ?>" class="badge badge-danger" onclick="return confirm('Are you sure you want to delete this brand?');">delete</a>
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

<!-- Modal Add New Brand -->
<div class="modal fade" id="newBrandModal" tabindex="-1" role="dialog" aria-labelledby="newBrandModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newBrandModalLabel">Add New Brand</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('inspection/brand'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="brand" name="brand" placeholder="Brand Name">
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

<!-- Modal Edit Brand -->
<div class="modal fade" id="editBrandModal" tabindex="-1" role="dialog" aria-labelledby="editBrandModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBrandModalLabel">Edit Brand</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('inspection/edit_brand'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" id="edit_brand_id" name="id">
                    <input type="hidden" id="original_brand" name="original_brand">
                    <div class="form-group">
                        <input type="text" class="form-control" id="edit_brand" name="brand" placeholder="Brand Name">
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

<!-- JavaScript untuk mengisi data ke modal edit -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script>
    $('#editBrandModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Tombol yang memicu modal
        var id = button.data('id'); // Ambil data-id
        var brand = button.data('brand'); // Ambil data-brand

        var modal = $(this);
        modal.find('.modal-body #edit_brand_id').val(id); // Set ID ke hidden input
        modal.find('.modal-body #edit_brand').val(brand); // Set nama brand ke input teks
        modal.find('.modal-body #original_brand').val(brand); // Set nama asli untuk validasi
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
