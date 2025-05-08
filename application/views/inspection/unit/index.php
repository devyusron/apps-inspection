<div class="container-fluid">
    <!-- Page Heading -->
    <div class="m-1 shadow card">
        <div class="card-header mb-4 d-flex justify-content-between align-items-center">
            <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
            <a href="<?= site_url('inspection/add_unit'); ?>" class="btn btn-outline-primary">
                <i class="fas fa-plus mr-2"></i>
                Tambah Unit
            </a>
        </div>
        <div class="row m-2">
            <div class="col">
                <form action="<?= site_url('inspection/index_unit'); ?>" method="get">
                    <div class="form-row">
                        <div class="col-md-2 mb-2">
                            <label for="tanggal_mulai">Tanggal Masuk Start:</label>
                            <input type="date" class="form-control form-control-sm" id="tanggal_mulai" name="tanggal_mulai"
                                value="<?= $this->input->get('tanggal_mulai'); ?>">
                        </div>
                        <div class="col-md-2 mb-2">
                            <label for="tanggal_akhir">Tanggal Masuk End:</label>
                            <input type="date" class="form-control form-control-sm" id="tanggal_akhir" name="tanggal_akhir"
                                value="<?= $this->input->get('tanggal_akhir'); ?>">
                        </div>
                        <div class="col-md-2 mb-2">
                            <label for="nama_produk">Nama Produk:</label>
                            <select class="form-control form-control-sm" id="nama_produk" name="nama_produk">
                                <option value="">Semua Produk</option>
                                <?php foreach ($daftar_produk as $produk): ?>
                                    <option value="<?= htmlspecialchars($produk['nama_produk']); ?>"
                                        <?= ($this->input->get('nama_produk') == $produk['nama_produk']) ? 'selected' : ''; ?>>
                                        <?= htmlspecialchars($produk['nama_produk']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2 mb-2">
                            <label for="status_inspection">Status Inspection:</label>
                            <select class="form-control form-control-sm" id="status_inspection" name="status_inspection">
                                <option value="">Pilih Status</option>
                                <option value="">Sudah Inspectionk</option>
                                <option value="">Belum Inspectionk</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                    <a href="<?= site_url('inspection/index_unit'); ?>" class="btn btn-secondary btn-sm">Reset Filter</a>
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
                    <table class="table table-bordered" id="dataTable">
                        <thead>
                            <tr>
                                <th>ID Unit</th>
                                <th>Serial Number</th>
                                <th>Nama Produk</th>
                                <th>Status Inspeksi</th>
                                <th>Qty</th>
                                <th>Kondisi Unit</th>
                                <th>Tanggal Masuk</th>
                                <th>Tanggal Keluar</th>
                                <th>Status Unit</th>
                                <th>Lokasi Unit</th>
                                <th>Keterangan Unit</th>
                                <th>Created At</th>
                                <th>Created By</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($units as $unit): ?>
                                <tr>
                                    <td><?= $unit['unit_id']; ?></td>
                                    <td><?= htmlspecialchars($unit['serial_number']); ?></td>
                                    <td><?= htmlspecialchars($unit['nama_produk']); ?></td>
                                    <td><?= htmlspecialchars($unit['status_inspection']); ?></td>
                                    <td><?= $unit['qty']; ?></td>
                                    <td><?= htmlspecialchars($unit['kondisi_unit']); ?></td>
                                    <td><?= $unit['tanggal_masuk']; ?></td>
                                    <td><?= $unit['tanggal_keluar']; ?></td>
                                    <td><?= htmlspecialchars($unit['status_unit']); ?></td>
                                    <td><?= htmlspecialchars($unit['lokasi_unit']); ?></td>
                                    <td><?= htmlspecialchars($unit['keterangan_unit']); ?></td>
                                    <td><?= $unit['created_at']; ?></td>
                                    <td><?= htmlspecialchars($unit['created_by']); ?></td>
                                    <td>
                                        <a href="<?= site_url('inspection/edit_unit/' . $unit['unit_id']); ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="<?= site_url('inspection/delete_unit/' . $unit['unit_id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus unit ini?')">Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
<script>
    $('#nama_produk').select2(); // Coba inisialisasi di sini (hanya untuk debug)
    $('#status_inspection').select2(); // Coba inisialisasi di sini (hanya untuk debug)
</script>