<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="m-1 shadow card">
    <div class="card-header mb-4 d-flex justify-content-between align-items-center">
        <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
        <?php if($this->session->userdata('role_id') == 1 or $this->session->userdata('role') == 'After Sales' or $this->session->userdata('role') == 'Admin Service') : ?>
        <a href="" class="btn btn-outline-primary mb-3" data-toggle="modal" data-target="#newMenuModal">
            <i class="fas fa-plus mr-2"></i>
            Add Brand
        </a>
        <?php endif; ?>
        </div>
        <div class="row m-2">
            <div class="col-md-12">
                <form action="<?= site_url('inspection/master_produk'); ?>" method="get">
                    <div class="form-row">
                        <div class="col-md-2 mb-2">
                            <label for="nama_produk">Nama Brand:</label>
                            <select class="form-control form-control-sm" id="nama_produk" name="nama_produk">
                                <option value="">Semua Brand</option>
                                <?php foreach ($nama_produk_list as $produk): ?>
                                    <option value="<?= htmlspecialchars($produk['nama_produk']); ?>"
                                        <?= ($this->input->get('nama_produk') == $produk['nama_produk']) ? 'selected' : ''; ?>>
                                        <?= htmlspecialchars($produk['nama_produk']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2 mb-2">
                            <label for="tanggal_mulai">Tanggal Masuk:</label>
                            <input type="date" class="form-control form-control-sm" id="tanggal_mulai" name="tanggal_mulai"
                                    value="<?= $this->input->get('tanggal_mulai'); ?>">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                    <a href="<?= site_url('inspection/master_produk'); ?>" class="btn btn-secondary btn-sm">Reset Filter</a>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-lg m-2">
                <?= form_error('inspection/master_produk', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                <?php if ($this->session->flashdata('message')): ?>
                    <?php echo $this->session->flashdata('message'); ?>
                    <script>
                        setTimeout(function() {
                            var alertElement = document.querySelector('.alert'); // Sesuaikan selector jika perlu
                            if (alertElement) {
                                alertElement.style.display = 'none';
                            }
                        }, 5000);
                    </script>
                    <?php $this->session->unset_userdata('message'); ?>
                <?php endif; ?>
                <div class="table-responsive">
                <table class="table table-hover" id="dataTable">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama Brand</th>
                            <!-- <th scope="col">Kode Produk</th> -->
                            <th scope="col">Type Unit</th>
                            <th scope="col">Gambar</th>
                            <th scope="col">Deskripsi</th>
                            <th scope="col">Berat</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($master_produk as $m) : ?>
                            <tr>
                                <th scope="row"><?= $i; ?></th>
                                <td><?= $m['nama_produk']; ?></td>
                                <td><?= $m['dimensi_produk']; ?></td>
                                <!-- <td><?= $m['kode_produk']; ?></td> -->
                                <td>
                                    <?php if ($m['url_gambar_produk']) : ?>
                                        <img src="<?= base_url('assets/img/produk/') . $m['url_gambar_produk']; ?>" alt="<?= $m['nama_produk']; ?>" width="50">
                                    <?php else : ?>
                                        No Image
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php
                                    $deskripsi = $m['deskripsi_produk'];
                                    $maxLength = 10; // Tentukan panjang maksimal substring
                                    $shortDescription = strlen($deskripsi) > $maxLength ? substr($deskripsi, 0, $maxLength) . '...' : $deskripsi;
                                    ?>
                                    <span title="<?= htmlspecialchars($deskripsi); ?>"><?= htmlspecialchars($shortDescription); ?></span>
                                </td>
                                <td><?= $m['berat_produk']; ?></td>
                                <td><?= $m['is_active'] == 1 ? 'Ready' : 'Booking'; ?></td>
                                <td>
                                    <?php if($this->session->userdata('role_id') == 1 or $this->session->userdata('role') == 'After Sales' or $this->session->userdata('role') == 'Admin Service') : ?>
                                    <a href="#" class="badge badge-success" data-toggle="modal" data-target="#editMenuModal"
                                        data-id_produk="<?= $m['id_produk']; ?>"
                                        data-nama_produk="<?= $m['nama_produk']; ?>"
                                        data-kode_produk="<?= $m['kode_produk']; ?>"
                                        data-url_gambar_produk="<?= $m['url_gambar_produk']; ?>"
                                        data-deskripsi_produk="<?= $m['deskripsi_produk']; ?>"
                                        data-harga_produk="<?= $m['harga_produk']; ?>"
                                        data-harga_asli="<?= $m['harga_asli']; ?>"
                                        data-harga_diskon="<?= $m['harga_diskon']; ?>"
                                        data-stok_produk="<?= $m['stok_produk']; ?>"
                                        data-minimum_stok_produk="<?= $m['minimum_stok_produk']; ?>"
                                        data-kategori_produk="<?= $m['kategori_produk']; ?>"
                                        data-brand_produk="<?= $m['brand_produk']; ?>"
                                        data-tag_produk="<?= $m['tag_produk']; ?>"
                                        data-dimensi_produk="<?= $m['dimensi_produk']; ?>"
                                        data-berat_produk="<?= $m['berat_produk']; ?>"
                                        data-warna_produk="<?= $m['warna_produk']; ?>"
                                        data-is_active="<?= $m['is_active']; ?>"><i class="fas fa-edit"></i></a>
                                    <a href="<?= base_url('inspection/delete_master_produk/' . $m['id_produk']); ?>" class="badge badge-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?');"><i class="fas fa-trash-alt"></i></a>
                                    <?php else : ?>
                                    <a class="badge badge-success disabled-link"><i class="fas fa-edit"></i></a>
                                    <a class="badge badge-danger disabled-link"><i class="fas fa-trash-alt"></i></a>
                                    <?php endif; ?>
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
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->
<!-- Modal -->
<div class="modal fade" id="editMenuModal" tabindex="-1" role="dialog" aria-labelledby="editMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMenuModalLabel">Edit Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('inspection/edit_master_produk'); ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="id_produk" id="id_produk">
                    <div class="form-group">
                        <label for="nama_produk">Nama Brand</label>
                        <input type="text" class="form-control" id="nama_produk" name="nama_produk" required>
                    </div>
                    <div class="form-group">
                        <label for="url_gambar_produk">Gambar Produk</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="url_gambar_produk" name="url_gambar_produk">
                            <label class="custom-file-label" for="url_gambar_produk">Pilih file</label>
                        </div>
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                        <img id="preview_gambar" src="" alt="Preview" width="100" class="mt-2">
                    </div>
                    <div class="form-group">
                        <label for="deskripsi_produk">Deskripsi Produk</label>
                        <textarea class="form-control" id="deskripsi_produk" name="deskripsi_produk" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="dimensi_produk">Type Unit</label>
                        <input type="text" class="form-control" id="dimensi_produk" name="dimensi_produk" required>
                    </div>
                    <div class="form-group">
                        <label for="berat_produk">Berat</label>
                        <input type="text" class="form-control" id="berat_produk" name="berat_produk" required>
                    </div>
                    <div class="form-group">
                        <label for="is_active">Status</label>
                        <select class="form-control" id="is_active" name="is_active">
                            <option value="1">Ready</option>
                            <option value="0">Booking</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script>
    $('#editMenuModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id_produk = button.data('id_produk')
        var nama_produk = button.data('nama_produk')
        var kode_produk = button.data('kode_produk')
        var url_gambar_produk = button.data('url_gambar_produk')
        var deskripsi_produk = button.data('deskripsi_produk')
        var harga_produk = button.data('harga_produk')
        var harga_asli = button.data('harga_asli')
        var harga_diskon = button.data('harga_diskon')
        var stok_produk = button.data('stok_produk')
        var minimum_stok_produk = button.data('minimum_stok_produk')
        var kategori_produk = button.data('kategori_produk')
        var brand_produk = button.data('brand_produk')
        var tag_produk = button.data('tag_produk')
        var dimensi_produk = button.data('dimensi_produk')
        var berat_produk = button.data('berat_produk')
        var warna_produk = button.data('warna_produk')
        var is_active = button.data('is_active')

        var modal = $(this)
        modal.find('.modal-body #id_produk').val(id_produk)
        modal.find('.modal-body #nama_produk').val(nama_produk)
        modal.find('.modal-body #kode_produk').val(kode_produk)
        if (url_gambar_produk) {
            modal.find('.modal-body #preview_gambar').attr('src', '<?= base_url('assets/img/produk/') ?>' + url_gambar_produk);
        } else {
            modal.find('.modal-body #preview_gambar').attr('src', '');
        }
        modal.find('.modal-body #deskripsi_produk').val(deskripsi_produk)
        modal.find('.modal-body #harga_produk').val(harga_produk)
        modal.find('.modal-body #harga_asli').val(harga_asli)
        modal.find('.modal-body #harga_diskon').val(harga_diskon)
        modal.find('.modal-body #stok_produk').val(stok_produk)
        modal.find('.modal-body #minimum_stok_produk').val(minimum_stok_produk)
        modal.find('.modal-body #kategori_produk').val(kategori_produk)
        modal.find('.modal-body #brand_produk').val(brand_produk)
        modal.find('.modal-body #tag_produk').val(tag_produk)
        modal.find('.modal-body #dimensi_produk').val(dimensi_produk)
        modal.find('.modal-body #berat_produk').val(berat_produk)
        modal.find('.modal-body #warna_produk').val(warna_produk)
        modal.find('.modal-body #is_active').val(is_active)
    })

    // Add event listener for file input change
    $('#editMenuModal').on('change', '#url_gambar_produk', function() {
        const file = this.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function(event){
                $('#preview_gambar').attr('src', event.target.result);
            };
            reader.readAsDataURL(file);
        } else {
            $('#preview_gambar').attr('src', '');
        }
    });

    // Initialize DataTable (assuming you have the DataTables library included)
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>

<!-- Modal -->
<div class="modal fade" id="newMenuModal" tabindex="-1" role="dialog" aria-labelledby="newMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newMenuModalLabel">Tambah Brand</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('inspection/add_master_produk'); ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_produk">Nama Brand</label>
                                <input type="text" class="form-control" id="nama_produk" name="nama_produk" placeholder="Nama Produk" required>
                            </div>
                            <div class="form-group">
                                <label for="url_gambar_produk">Gambar Produk</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="url_gambar_produk" name="url_gambar_produk">
                                    <label class="custom-file-label" for="url_gambar_produk">Pilih file</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="deskripsi_produk">Deskripsi Produk</label>
                                <textarea class="form-control" id="deskripsi_produk" name="deskripsi_produk" placeholder="Deskripsi Produk" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dimensi_produk">Type Unit</label>
                                <input type="text" class="form-control" id="dimensi_produk" name="dimensi_produk" placeholder="Type Unit" required>
                            </div>
                            <div class="form-group">
                                <label for="berat_produk">Berat</label>
                                <input type="text" class="form-control" id="berat_produk" name="berat_produk" placeholder="Berat" required>
                            </div>
                            <div class="form-group">
                                <label for="is_active">Status</label>
                                <select class="form-control" id="is_active" name="is_active">
                                    <option value="1" selected>Ready</option>
                                    <option value="0">Booking</option>
                                </select>
                            </div>
                            </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
<script>
    $('#nama_produk').select2(); 
</script>