<div class="container-fluid">
    <div class="m-1 shadow card">
        <div class="card-header mb-4 d-flex justify-content-between align-items-center">
            <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
        </div>
        <div class="row">
            <div class="col-lg m-2">
                <?php echo form_open('inspection/insert_unit'); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="id_produk">Nama Brand</label>
                                <select class="form-control" id="id_produk" name="id_produk" required>
                                    <option value="">Pilih Brand</option>
                                    <?php foreach ($product_units as $units): ?>
                                        <option value="<?= htmlspecialchars($units['nama_produk']); ?>"><?= htmlspecialchars($units['nama_produk']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="type_unit">Type Unit</label>
                                <select class="form-control" id="type_unit" name="type_unit" required disabled>
                                    <option value="">Pilih Type Unit</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="serial_number">Serial Number</label>
                        <input type="text" class="form-control" id="serial_number" name="serial_number" required>
                    </div>
                    <!-- <div class="form-group">
                        <label for="machine_no">Machine Number</label>
                        <input type="text" class="form-control" id="machine_no" name="machine_no">
                        <?= form_error('machine_no', '<small class="text-danger">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <label for="model_no">Model Number</label>
                        <input type="text" class="form-control" id="model_no" name="model_no">
                        <?= form_error('model_no', '<small class="text-danger">', '</small>'); ?>
                    </div> -->
                    <div class="form-group">
                        <label for="engine_plate">Engine Plate</label>
                        <input type="text" class="form-control" id="engine_plate" name="engine_plate">
                        <?= form_error('engine_plate', '<small class="text-danger">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <label for="status_inspection">Status Inspeksi</label>
                        <input type="text" class="form-control" id="status_inspection" name="status_inspection" value="Belum Inspeksi" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="qty">Kuantitas</label>
                        <input type="number" class="form-control" id="qty" name="qty" value="1" readonly required>
                    </div>
                    <!-- <div class="form-group">
                        <label for="kondisi_unit">Status</label>
                        <select class="form-control" id="kondisi_unit" name="kondisi_unit" required>
                            <option value="" disabled selected>Pilih Status</option>
                            <option value="Ready">Ready</option>
                            <option value="Booking">Booking</option>
                        </select>
                    </div> -->
                    <div class="form-group">
                        <label for="tanggal_masuk">Tanggal Masuk</label>
                        <input type="datetime-local" class="form-control" id="tanggal_masuk" name="tanggal_masuk" required>
                    </div>
                    <div class="form-group">
                        <label for="status_unit">Status Unit</label>
                        <select class="form-control" id="status_unit" name="status_unit" required>
                            <option value="" disabled selected>Pilih Status</option>
                            <option value="Ready">Ready</option>
                            <option value="Booking">Booking</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="lokasi_unit">Lokasi Unit:</label>
                        <select class="form-control form-control-sm" id="lokasi_unit" name="lokasi_unit">
                            <option value="">Pilih Lokasi</option>
                            <?php foreach ($lokasi_units as $lokasi) : ?>
                                <option value="<?= $lokasi['id']; ?>"><?= $lokasi['lokasi_unit']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="keterangan_unit">Keterangan Unit</label>
                        <textarea class="form-control" id="keterangan_unit" name="keterangan_unit"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- <script>
    $('#id_produk').select2(); // Coba inisialisasi di sini (hanya untuk debug)
    $('#type_unit').select2(); // Coba inisialisasi di sini (hanya untuk debug)
</script> -->
<script>
    $(document).ready(function() {
        $('#type_unit').prop('disabled', true);
        var tanggalMasukInput = document.getElementById('tanggal_masuk');
        if (tanggalMasukInput) {
            var now = new Date();
            var tahun = now.getFullYear();
            var bulan = String(now.getMonth() + 1).padStart(2, '0');
            var hari = String(now.getDate()).padStart(2, '0');
            var jam = String(now.getHours()).padStart(2, '0');
            var menit = String(now.getMinutes()).padStart(2, '0');
            var dateTimeFormat = tahun + '-' + bulan + '-' + hari + 'T' + jam + ':' + menit;
            tanggalMasukInput.value = dateTimeFormat;
        }

        <?php if ($this->session->flashdata('swal')): ?>
            const swalData = <?= json_encode($this->session->flashdata('swal')); ?>;
            Swal.fire(swalData);
            // Setelah ditampilkan, unset flashdata agar tidak muncul lagi saat refresh
            <?php $this->session->unset_flashdata('swal'); ?>
        <?php endif; ?>
        $('#id_produk').on('select2:select', function (e) {
            // Ketika Select2 memilih sebuah opsi, trigger event 'change' pada elemen asli.
            // Ini akan memastikan handler .on('change') Anda di bawah ini terpicu.
            $(this).trigger('change');
        });
        // Tangani event 'change' pada dropdown 'Nama Brand'
        $('#id_produk').on('change', function() {
            console.log('Event change terpicu. Brand terpilih:', $(this).val()); // Debugging: pastikan event terpicu
            var selectedBrand = $(this).val();
            var typeUnitDropdown = $('#type_unit');

            // Kosongkan dropdown Type Unit dan tambahkan opsi default
            typeUnitDropdown.empty();
            typeUnitDropdown.append('<option value="">Pilih Type Unit</option>');

            if (selectedBrand) {
                typeUnitDropdown.append('<option value="">Memuat Type Unit...</option>'); // Opsi loading
                typeUnitDropdown.prop('disabled', true); // Nonaktifkan sementara

                // Lakukan AJAX request ke controller untuk mendapatkan type unit
                $.ajax({
                    url: '<?= base_url('inspection/get_types_by_brand'); ?>',
                    type: 'POST',
                    data: { nama_produk: selectedBrand },
                    dataType: 'json',
                    success: function(data) {
                        console.log('Data dari server:', data); // Debugging: lihat data yang diterima
                        typeUnitDropdown.empty(); // Hapus opsi "Memuat..." dan default sebelumnya
                        typeUnitDropdown.append('<option value="">Pilih Type Unit</option>'); // Tambahkan opsi default

                        if (data.length > 0) {
                            $.each(data, function(key, value) {
                                typeUnitDropdown.append('<option value="' + value.id_produk + '">' + value.dimensi_produk + '</option>');
                            });
                        } else {
                            typeUnitDropdown.append('<option value="">Tidak ada Type Unit ditemukan</option>');
                        }
                        typeUnitDropdown.prop('disabled', false); // Aktifkan kembali dropdown
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error: " + status + " - " + error); // Debugging: lihat error AJAX
                        typeUnitDropdown.empty();
                        typeUnitDropdown.append('<option value="">Gagal memuat Type Unit</option>');
                        typeUnitDropdown.prop('disabled', false); // Aktifkan kembali dropdown
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Gagal memuat Type Unit. Silakan coba lagi!',
                            });
                        } else {
                            alert('Gagal memuat Type Unit. Silakan coba lagi!');
                        }
                    }
                });
            } else {
                // Jika tidak ada brand yang dipilih, kosongkan dan nonaktifkan Type Unit
                typeUnitDropdown.prop('disabled', true);
            }
        });
        $('#id_produk').on('select2:clear', function (e) {
            $(this).trigger('change'); // Trigger change to reset Type Unit
        });
    });
</script>
