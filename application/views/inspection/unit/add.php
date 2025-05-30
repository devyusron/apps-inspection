<div class="container-fluid">
    <!-- Page Heading -->
    <div class="m-1 shadow card">
        <div class="card-header mb-4 d-flex justify-content-between align-items-center">
            <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
        </div>
        <div class="row">
            <div class="col-lg m-2">
                <?php echo form_open('inspection/insert_unit'); ?>
                    <div class="form-group">
                        <label for="serial_number">Serial Number</label>
                        <input type="text" class="form-control" id="serial_number" name="serial_number" required>
                    </div>
                    <div class="form-group">
                        <label for="machine_no">Machine Number</label>
                        <input type="text" class="form-control" id="machine_no" name="machine_no">
                        <?= form_error('machine_no', '<small class="text-danger">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <label for="model_no">Model Number</label>
                        <input type="text" class="form-control" id="model_no" name="model_no">
                        <?= form_error('model_no', '<small class="text-danger">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <label for="id_produk">ID Produk</label>
                        <select class="form-control" id="id_produk" name="id_produk" required>
                            <option value="">Pilih Produk</option>
                            <?php foreach ($products as $product): ?>
                                <option value="<?= $product['id_produk']; ?>"><?= htmlspecialchars($product['nama_produk']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status_inspection">Status Inspeksi</label>
                        <input type="text" class="form-control" id="status_inspection" name="status_inspection" value="Belum Inspeksi" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="qty">Kuantitas</label>
                        <input type="number" class="form-control" id="qty" name="qty" value="1" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="kondisi_unit">Kondisi Unit</label>
                        <select class="form-control" id="kondisi_unit" name="kondisi_unit" required>
                            <option value="" disabled selected>Pilih Kondisi</option>
                            <option value="Berfungsi">Berfungsi</option>
                            <option value="Tidak Berfungsi">Tidak Berfungsi</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_masuk">Tanggal Masuk</label>
                        <input type="datetime-local" class="form-control" id="tanggal_masuk" name="tanggal_masuk" required>
                    </div>
                    <!-- <div class="form-group">
                        <label for="tanggal_keluar">Tanggal Keluar</label>
                        <input type="datetime-local" class="form-control" id="tanggal_keluar" name="tanggal_keluar">
                    </div> -->
                    <div class="form-group">
                        <label for="status_unit">Status Unit</label>
                        <select class="form-control" id="status_unit" name="status_unit" required>
                            <option value="" disabled selected>Pilih Status</option>
                            <option value="Baru">Baru</option>
                            <option value="Perbaikan">Perbaikan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="lokasi_unit">Lokasi Unit</label>
                        <select class="form-control" id="lokasi_unit" name="lokasi_unit" required>
                            <option value="" disabled selected>Pilih Lokasi</option>
                            <option value="Vendor">Vendor</option>
                            <option value="Gudang">Gudang</option>
                            <option value="Customer">Customer</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="keterangan_unit">Keterangan Unit</label>
                        <textarea class="form-control" id="keterangan_unit" name="keterangan_unit"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
                    <script>
                        $('#id_produk').select2(); // Coba inisialisasi di sini (hanya untuk debug)
                    </script>
                    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <script>
                        window.onload = function() {
                            var tanggalMasukInput = document.getElementById('tanggal_masuk');
                            var now = new Date();
                            var tahun = now.getFullYear();
                            var bulan = String(now.getMonth() + 1).padStart(2, '0'); // Bulan dimulai dari 0
                            var hari = String(now.getDate()).padStart(2, '0');
                            var jam = String(now.getHours()).padStart(2, '0');
                            var menit = String(now.getMinutes()).padStart(2, '0');
                            var detik = String(now.getSeconds()).padStart(2, '0');
                            var dateTimeFormat = tahun + '-' + bulan + '-' + hari + 'T' + jam + ':' + menit;
                            tanggalMasukInput.value = dateTimeFormat;
                        };
                    </script>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>