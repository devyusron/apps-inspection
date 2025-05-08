<div class="container-fluid">
    <!-- Page Heading -->
    <div class="m-1 shadow card">
        <div class="card-header mb-4 d-flex justify-content-between align-items-center">
            <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
        </div>
        <div class="row">
            <div class="col-lg m-2">
                <?php echo form_open('inspection/update_unit/' . $unit['unit_id']); ?>
                    <div class="form-group">
                        <label for="serial_number">Serial Number</label>
                        <input type="text" class="form-control" id="serial_number" name="serial_number"value="<?= htmlspecialchars($unit['serial_number']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="id_produk">ID Produk</label>
                        <select class="form-control" id="id_produk" name="id_produk" required>
                            <option value="">Pilih Produk</option>
                            <?php foreach ($products as $product): ?>
                                <option value="<?= $product['id_produk']; ?>" <?= ($unit['id_produk'] == $product['id_produk']) ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($product['nama_produk']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status_inspection">Status Inspeksi</label>
                        <select class="form-control" id="status_inspection" name="status_inspection" required>
                            <option value="" disabled selected>Pilih Status Inspeksi</option>
                            <option value="Belum Inspeksi" <?= (isset($unit['status_inspection']) && $unit['status_inspection'] == 'Belum Inspeksi') ? 'selected' : ''; ?>>Belum Inspeksi</option>
                            <option value="Sudah Inspeksi" <?= (isset($unit['status_inspection']) && $unit['status_inspection'] == 'Sudah Inspeksi') ? 'selected' : ''; ?>>Sudah Inspeksi</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="qty">Kuantitas</label>
                        <input type="number" class="form-control" id="qty" name="qty" value="<?= $unit['qty']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="kondisi_unit">Kondisi Unit</label>
                        <select class="form-control" id="kondisi_unit" name="kondisi_unit" required>
                            <option value="" disabled selected>Pilih Kondisi</option>
                            <option value="Berfungsi" <?= (isset($unit['kondisi_unit']) && $unit['kondisi_unit'] == 'Berfungsi') ? 'selected' : ''; ?>>Berfungsi</option>
                            <option value="Tidak Berfungsi" <?= (isset($unit['kondisi_unit']) && $unit['kondisi_unit'] == 'Tidak Berfungsi') ? 'selected' : ''; ?>>Tidak Berfungsi</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_masuk">Tanggal Masuk</label>
                        <input type="datetime-local" class="form-control" id="tanggal_masuk" name="tanggal_masuk"
                            value="<?= str_replace(' ', 'T', $unit['tanggal_masuk']); ?>" required>
                    </div>
                    <!-- <div class="form-group">
                        <label for="tanggal_keluar">Tanggal Keluar</label>
                        <input type="datetime-local" class="form-control" id="tanggal_keluar" name="tanggal_keluar"
                            value="<?= str_replace(' ', 'T', $unit['tanggal_keluar']); ?>">
                    </div> -->
                    <div class="form-group">
                        <label for="status_unit">Status Unit</label>
                        <select class="form-control" id="status_unit" name="status_unit" required>
                            <option value="" disabled selected>Pilih Status</option>
                            <option value="Baru" <?= (isset($unit['status_unit']) && $unit['status_unit'] == 'Baru') ? 'selected' : ''; ?>>Baru</option>
                            <option value="Perbaikan" <?= (isset($unit['status_unit']) && $unit['status_unit'] == 'Perbaikan') ? 'selected' : ''; ?>>Perbaikan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="lokasi_unit">Lokasi Unit</label>
                        <select class="form-control" id="lokasi_unit" name="lokasi_unit" required>
                            <option value="" disabled selected>Pilih Lokasi</option>
                            <option value="Vendor" <?= (isset($unit['lokasi_unit']) && $unit['lokasi_unit'] == 'Vendor') ? 'selected' : ''; ?>>Vendor</option>
                            <option value="Gudang" <?= (isset($unit['lokasi_unit']) && $unit['lokasi_unit'] == 'Gudang') ? 'selected' : ''; ?>>Gudang</option>
                            <option value="Customer" <?= (isset($unit['lokasi_unit']) && $unit['lokasi_unit'] == 'Customer') ? 'selected' : ''; ?>>Customer</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="keterangan_unit">Keterangan Unit</label>
                        <textarea class="form-control" id="keterangan_unit" name="keterangan_unit"><?= htmlspecialchars($unit['keterangan_unit']); ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
                    <script>
                        $('#id_produk').select2(); // Coba inisialisasi di sini (hanya untuk debug)
                    </script>
                    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
                    <script>
                        $(document).ready(function() {
                            // ... kode JavaScript lain Anda
                        });
                    </script>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>