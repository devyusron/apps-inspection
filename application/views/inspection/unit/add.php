<h1><?= $title; ?></h1>

<?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

<?php echo form_open('inspection/insert_unit'); ?>
    <div class="form-group">
        <label for="serial_number">Serial Number</label>
        <input type="text" class="form-control" id="serial_number" name="serial_number" required>
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
        <input type="text" class="form-control" id="status_inspection" name="status_inspection" required>
    </div>
    <div class="form-group">
        <label for="qty">Kuantitas</label>
        <input type="number" class="form-control" id="qty" name="qty" required>
    </div>
    <div class="form-group">
        <label for="kondisi_unit">Kondisi Unit</label>
        <input type="text" class="form-control" id="kondisi_unit" name="kondisi_unit" required>
    </div>
    <div class="form-group">
        <label for="tanggal_masuk">Tanggal Masuk</label>
        <input type="datetime-local" class="form-control" id="tanggal_masuk" name="tanggal_masuk" required>
    </div>
    <div class="form-group">
        <label for="tanggal_keluar">Tanggal Keluar</label>
        <input type="datetime-local" class="form-control" id="tanggal_keluar" name="tanggal_keluar">
    </div>
    <div class="form-group">
        <label for="status_unit">Status Unit</label>
        <input type="text" class="form-control" id="status_unit" name="status_unit" required>
    </div>
    <div class="form-group">
        <label for="lokasi_unit">Lokasi Unit</label>
        <input type="text" class="form-control" id="lokasi_unit" name="lokasi_unit" required>
    </div>
    <div class="form-group">
        <label for="keterangan_unit">Keterangan Unit</label>
        <textarea class="form-control" id="keterangan_unit" name="keterangan_unit"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
<?php echo form_close(); ?>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>