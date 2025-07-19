<style>
    #inspection-detail-content {
        overflow: visible !important;
        height: auto !important;
        max-height: none !important;
    }
</style>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="m-1 shadow card">
        <div class="card-header mb-4 d-flex justify-content-between align-items-center">
            <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
        </div>
        <?php if ($this->session->flashdata('swal')): ?>
            <script>
            Swal.fire(<?php echo json_encode($this->session->flashdata('swal')); ?>);
            </script>
        <?php endif; ?>
        <div class="row m-2">
            <div class="col">
                <form action="<?= site_url('inspection/result'); ?>" method="get">
                    <div class="form-row">
                        <!-- <div class="col-md-2 mb-2">
                            <label for="tanggal_mulai">Tanggal Masuk Start:</label>
                            <input type="date" class="form-control form-control-sm" id="tanggal_mulai" name="tanggal_mulai"
                                value="<?= $this->input->get('tanggal_mulai'); ?>">
                        </div>
                        <div class="col-md-2 mb-2">
                            <label for="tanggal_akhir">Tanggal Masuk End:</label>
                            <input type="date" class="form-control form-control-sm" id="tanggal_akhir" name="tanggal_akhir"
                                value="<?= $this->input->get('tanggal_akhir'); ?>">
                        </div> -->
                        <div class="col-md-2 mb-2">
                            <label for="nama_produk">Nama Brand:</label>
                            <select class="form-control form-control-sm" id="nama_produk" name="nama_produk">
                                <option value="">Semua Brand</option>
                                <?php foreach ($daftar_produk as $produk): ?>
                                    <option value="<?= htmlspecialchars($produk['nama_produk']); ?>"
                                        <?= ($this->input->get('nama_produk') == $produk['nama_produk']) ? 'selected' : ''; ?>>
                                        <?= htmlspecialchars($produk['nama_produk']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2 mb-2">
                            <label for="serial_number">Serial Number:</label>
                            <input type="text" class="form-control  form-control-sm" name="serial_number" id="serial_number">
                        </div>
                        <div class="col-md-2 mb-2">
                            <label for="tanggal_mulai">Tanggal Masuk:</label>
                            <input type="date" class="form-control form-control-sm" id="tanggal_mulai" name="tanggal_mulai"
                                    value="<?= $this->input->get('tanggal_mulai'); ?>">
                        </div>
                        <!-- <div class="col-md-2 mb-2">
                            <label for="status_inspection">Status Inspection:</label>
                            <select class="form-control form-control-sm" id="status_inspection" name="status_inspection">
                                <option value="">Pilih Status</option>
                                <option value="Sudah Inspeksi">Sudah Inspeksi</option>
                                <option value="Belum Inspeksi">Belum Inspeksi</option>
                            </select>
                        </div> -->
                        <!-- <div class="col-md-2 mb-2">
                            <label for="kondisi_unit">Kondisi Unit:</label>
                            <select class="form-control form-control-sm" id="kondisi_unit" name="kondisi_unit">
                                <option value="">Pilih Kondisi</option>
                                <option value="Berfungsi">Berfungsi</option>
                                <option value="Tidak Berfungsi">Tidak Berfungsi</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-2">
                            <label for="lokasi_unit">Lokasi Unit:</label>
                            <select class="form-control form-control-sm" id="lokasi_unit" name="lokasi_unit">
                                <option value="">Pilih Lokasi</option>
                                <?php foreach ($lokasi_units as $lokasi) : ?>
                                    <option value="<?= $lokasi['id']; ?>"><?= $lokasi['lokasi_unit']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div> -->
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                    <a href="<?= site_url('inspection/result'); ?>" class="btn btn-secondary btn-sm">Reset Filter</a>
                    <!-- <a href="<?= site_url('inspection/export_excel'); ?>" class="btn btn-success btn-sm mb-2">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </a> -->
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-lg m-2">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable1">
                        <thead>
                            <tr>
                                <th>ID Unit</th>
                                <th>Nama Brand</th>
                                <th>Type Unit</th>
                                <th>Serial Number</th>
                                <th>Engine Plate</th>
                                <th>Machine No</th>      
                                <th>Model No</th>
                                <!-- <th>Qty</th>
                                <th>Kondisi Unit</th>
                                <th>Tanggal Masuk</th>
                                <th>Status Unit</th> -->
                                <th>Lokasi Unit</th>
                                <th>Keterangan Unit</th>
                                <th>Status Inspeksi</th>
                                <th>Status Approve</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; foreach ($units as $unit): ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= htmlspecialchars($unit['nama_produk']); ?></td>
                                    <td><?= htmlspecialchars($unit['type_unit']); ?></td>
                                    <td><?= htmlspecialchars($unit['serial_number']); ?></td>
                                    <td><?= htmlspecialchars($unit['engine_plate']); ?></td>
                                    <td><?= isset($unit['machine_no']) ? htmlspecialchars($unit['machine_no']) : '-'; ?></td>
                                    <td><?= isset($unit['model_no']) ? htmlspecialchars($unit['model_no']) : '-'; ?></td>
                                    <!-- <td><?= $unit['qty']; ?></td> -->
                                    <!-- <td><?= htmlspecialchars($unit['kondisi_unit']); ?></td> -->
                                    <!-- <td><?= $unit['tanggal_masuk']; ?></td> -->
                                    <!-- <td><?= htmlspecialchars($unit['status_unit']); ?></td> -->
                                    <td><?= htmlspecialchars($unit['lokasi']); ?></td>
                                    <td><?= htmlspecialchars($unit['keterangan_unit']); ?></td>
                                    <td>
                                        <?php if ($unit['status_inspection'] == 'Belum Inspeksi'): ?>
                                            <span class="badge badge-danger">Belum Inspeksi</span>
                                        <?php elseif ($unit['status_inspection'] == 'Sudah Inspeksi'): ?>
                                            <span class="badge badge-success">Sudah Inspeksi</span>
                                        <?php else: ?>
                                            <?= htmlspecialchars($unit['status_inspection']); ?> 
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($unit['approve_manager'] == '0'): ?>
                                            <span class="badge badge-danger">Belum Approve</span>
                                        <?php elseif ($unit['approve_manager'] == '1'): ?>
                                            <span class="badge badge-success">Sudah Approve</span>
                                        <?php else: ?>
                                            <span class="badge badge-danger">Belum Inspeksi</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($this->session->userdata('role') == 'Manager') : ?>
                                            <?php if ($unit['approve_manager'] == '0'): ?>
                                                <a href="#" class="btn btn-danger btn-sm btn-approve-manager"
                                                    data-toggle="tooltip" data-placement="top" title="Approve Manager"
                                                    data-unit-id="<?= $unit['id_inspection']; ?>">  <i class="fas fa-user-check"></i>
                                                </a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php if ($unit['approve_manager'] == '0'): ?>
                                            <a href="#" class="btn btn-warning btn-sm btn-reject-inspection"
                                                data-toggle="tooltip" data-placement="top" title="Reject Inspection"
                                                data-inspection-id="<?= $unit['id_inspection']; ?>"
                                                data-unit-id-for-status="<?= $unit['unit_id']; ?>">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        <?php endif; ?>
                                        <button type="button" class="btn btn-success btn-sm lihat-template-result" 
                                            data-inspection-id="<?= $unit['id_inspection']; ?>"
                                            data-unit-id="<?= $unit['unit_id']; ?>"
                                            data-machine-no="<?= isset($unit['machine_no']) ? $unit['machine_no'] : '-'; ?>" 
                                            data-model-no="<?= isset($unit['model_no']) ? $unit['model_no'] : '-' ?>"  
                                            data-serial-number="<?= $unit['serial_number']?>"
                                            data-id="<?= $unit['id_template']; ?>" 
                                            data-toggle="modal" title="Hasil Inspeksi" 
                                            data-target="#modalInspectionResult"><i class="fas fa-search"></i></button>
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
<div class="modal fade" id="modalInspectionResult" tabindex="-1" role="dialog" aria-labelledby="modalInspectionResultLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalInspectionResultLabel">Detail Inspeksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="inspection-detail-content">
                <p>Memuat data...</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <!-- <button type="button" class="btn btn-danger" id="downloadPdfBtn" 
                data-inspection-id="<?= $unit['id_inspection']; ?>"
                data-unit-id="<?= $unit['unit_id']; ?>"
                data-machine-no="<?= $unit['machine_no']; ?>" 
                data-model-no="<?= $unit['model_no']; ?>" 
                data-serial-number="<?= $unit['serial_number']?>"
                data-template-id="<?= $unit['id_template']; ?>" >Download PDF</button> -->
                <button id="download-pdf" class="btn btn-danger">Download PDF</button>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $('#nama_produk').select2(); // Coba inisialisasi di sini (hanya untuk debug)
    $('#status_inspection').select2(); // Coba inisialisasi di sini (hanya untuk debug)
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://unpkg.com/jspdf-autotable@3.5.20/dist/jspdf.plugin.autotable.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox-plus-jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
$(document).ready(function() {
    // ... (Kode untuk btn-approve-manager yang sudah ada) ...

    // --- SCRIPT UNTUK REJECT/DELETE INSPECTION ---
    $(document).on('click', '.btn-reject-inspection', function(e) {
        e.preventDefault();

        const inspectionId = $(this).data('inspection-id');
        const unitIdForStatus = $(this).data('unit-id-for-status'); // ID dari tabel `unit`
        const button = $(this); // Simpan referensi tombol

        Swal.fire({
            title: 'Konfirmasi Rejection?',
            text: "Anda akan menghapus data inspeksi ini dan mengembalikan status unit menjadi 'Belum Inspeksi'. Tindakan ini tidak dapat dibatalkan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33', // Merah untuk reject
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus Inspeksi!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url("inspection/reject_inspection"); ?>', // URL ke controller reject
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        inspection_id: inspectionId,
                        unit_id_for_status: unitIdForStatus // Kirim ID unit untuk update status
                    },
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Loading...',
                            text: 'Memproses penghapusan inspeksi...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },
                    success: function(response) {
                        Swal.close();

                        if (response.status === 'success') {
                            Swal.fire(
                                'Berhasil!',
                                response.message,
                                'success'
                            ).then(() => {
                                // Refresh halaman untuk melihat perubahan
                                window.location.reload();
                                // Atau jika ingin update UI tanpa reload, Anda perlu lebih banyak logika
                                // Misalnya, sembunyikan baris tabel terkait inspeksi yang dihapus
                                // button.closest('tr').remove();
                            });
                        } else {
                            Swal.fire(
                                'Gagal!',
                                response.message,
                                'error'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.close();
                        Swal.fire(
                            'Error!',
                            'Terjadi kesalahan saat menghubungi server: ' + error,
                            'error'
                        );
                        console.error('AJAX Error: ', status, error, xhr);
                    }
                });
            }
        });
    });
    // --- AKHIR SCRIPT UNTUK REJECT/DELETE INSPECTION ---

});
</script>
<script>
    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true
    })
</script>
<script>
    $(document).ready(function() {
        let hasil_inspeksi;
        $('.lihat-template-result').on('click', function() {
            var id_inspection = $(this).data('inspection-id');
            var id_template = $(this).data('id');
            $.ajax({
                url: '<?= site_url('inspection/view_result_inspection/'); ?>' + id_inspection,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    hasil_inspeksi = response;
                    console.log(response)
                    var modalBody = $('#inspection-detail-content');
                    modalBody.empty(); // Kosongkan isi modal sebelum menampilkan data baru
                    $.ajax({
                        url: '<?= site_url('inspection/view_form/'); ?>' + id_template,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            // console.log(data)
                            if (data && data.length > 0) {
                                var html = '<div class="row">';
                                html += '<div class="col-md-6">';
                                html += '<div class="form-group row">';
                                html += '<label for="customer" class="col-sm-3 col-form-label">Customer</label>';
                                html += '<div class="col-sm-9"><input readonly type="text" class="form-control form-control-sm" id="customer" name="customer" value="' + hasil_inspeksi[0].customer + '"></div>';
                                html += '</div>';
                                html += '<div class="form-group row">';
                                html += '<label for="address" class="col-sm-3 col-form-label">Address</label>';
                                html += '<div class="col-sm-9"><textarea readonly class="form-control form-control-sm" id="address" name="address">' + hasil_inspeksi[0].address + '</textarea></div>';
                                html += '</div>';
                                html += '<div class="form-group row">';
                                html += '<label for="attachment" class="col-sm-3 col-form-label">Other Attachment</label>';
                                html += '<div class="col-sm-9"><input readonly type="text" class="form-control form-control-sm" id="attachment" name="attachment" value="' + hasil_inspeksi[0].attachment + '"></div>';
                                html += '</div>';
                                html += '<div class="form-group row">';
                                html += '<label for="approve_manager" class="col-sm-3 col-form-label">Approve Manager</label>';
                                let approveStatus = '';
                                if (hasil_inspeksi[0].approve_manager == 1) {
                                    approveStatus = 'Sudah Approve';
                                } else {
                                    approveStatus = 'Belum Approve';
                                }
                                html += '<div class="col-sm-9"><input readonly type="text" class="form-control form-control-sm" id="approve_manager" name="approve_manager" value="' + approveStatus + '"></div>';
                                html += '</div>';
                                html += '</div>';
                                html += '<div class="col-md-6">';
                                html += '<div class="form-group row">';
                                html += '<label for="mechine" class="col-sm-3 col-form-label">Mechine</label>';
                                html += '<div class="col-sm-9"><input readonly type="text" class="form-control form-control-sm" id="mechine" name="mechine" value="' + hasil_inspeksi[0].machine_no + '"></div>';
                                html += '</div>';
                                html += '<div class="form-group row">';
                                html += '<label for="model_no" class="col-sm-3 col-form-label">Model No.</label>';
                                html += '<div class="col-sm-9"><input readonly type="text" class="form-control form-control-sm" id="model_no" name="model_no" value="' + hasil_inspeksi[0].model_no + '"></div>';
                                html += '</div>';
                                html += '<div class="form-group row">';
                                html += '<label for="serial_no" class="col-sm-3 col-form-label">Serial No.</label>';
                                html += '<div class="col-sm-9"><input readonly type="text" class="form-control form-control-sm" id="serial_no" name="serial_no" value="' + hasil_inspeksi[0].serial_number + '"></div>';
                                html += '</div>';
                                html += '<div class="form-group row">';
                                html += '<label for="hours" class="col-sm-3 col-form-label">Hours</label>';
                                html += '<div class="col-sm-9"><input readonly type="text" class="form-control form-control-sm" id="hours" name="hours" value="' + hasil_inspeksi[0].hours + '"></div>';
                                html += '</div>';
                                html += '<div class="form-group row">';
                                html += '<label for="inspection_d" class="col-sm-3 col-form-label">Inspection Date</label>';
                                html += '<div class="col-sm-9"><input readonly type="date" class="form-control form-control-sm" id="inspection_d" name="inspection_d" value="' + hasil_inspeksi[0].tanggal_inspeksi + '"></div>';
                                html += '</div>';
                                html += '</div>';
                                html += '</div>'; // End of row

                                html += '<hr class="mt-2 mb-2">'; // Garis pemisah antara info atas dan tabel

                                html += '<table class="table table-bordered">';
                                html += '<thead><tr><th>Group</th><th>Item</th><th>Add</th><th>Clean Up</th><th>Lubricate</th><th>Replace Or Change</th><th>Adjust</th><th>Test or Check</th><th>Remark</th></tr></thead><tbody>';
                                const getCheckbox = (value) => {
                                    const checked = value == 1 ? 'checked' : '';
                                    return `<input type="checkbox" ${checked} disabled>`; // Checkbox disabled karena ini tampilan hasil
                                };
                                $.each(hasil_inspeksi, function(i, item) {
                                    html += '<tr>';
                                    html += '<td>' + item.nama_group + '</td>';
                                    html += '<td>' + item.nama_item + '</td>';
                                    html += '<td class="text-center">' + getCheckbox(item.add) + '</td>';
                                    html += '<td class="text-center">' + getCheckbox(item.clean_up) + '</td>';
                                    html += '<td class="text-center">' + getCheckbox(item.lubricate) + '</td>';
                                    html += '<td class="text-center">' + getCheckbox(item.replace_change) + '</td>';
                                    html += '<td class="text-center">' + getCheckbox(item.adjust) + '</td>';
                                    html += '<td class="text-center">' + getCheckbox(item.test_check) + '</td>';
                                    html += '<td><textarea readonly class="form-control form-control-sm" rows="1">' + (item.remark || '') + '</textarea></td>';
                                    html += '</tr>';
                                });
                                html += '</tbody></table>';
                                html += '<div class="form-group mt-3">';
                                html += '<label for="additional_comment">Additional Comment :</label>';
                                html += '<textarea readonly class="form-control" id="additional_comment" name="additional_comment" rows="3">' + hasil_inspeksi[0].additional_comment + '</textarea>';
                                html += '</div>';
                                html += '<div class="form-group mt-3">'; // Ini adalah div untuk foto utama
                                html += '<label>Photos:</label>'; // Label umum untuk semua foto

                                // --- START GRID FOTO ---
                                html += '<div class="row">'; // Baris untuk menampung semua foto

                                // Definisi semua nama field foto Anda
                                const photoFields = [
                                    { name: 'photo_inspection', label: 'Inspection Photo' },
                                    { name: 'photo_hourmeter', label: 'Hourmeter Photo' },
                                    { name: 'photo_engine_plate', label: 'Engine Plate Photo' },
                                    { name: 'photo_1', label: 'Photo 1' },
                                    { name: 'photo_2', label: 'Photo 2' },
                                    { name: 'photo_3', label: 'Photo 3' },
                                    { name: 'photo_4', label: 'Photo 4' },
                                    { name: 'photo_5', label: 'Photo 5' },
                                    { name: 'photo_6', label: 'Photo 6' },
                                    { name: 'photo_serialnumber', label: 'Serial Number Photo' }
                                ];

                                // Iterasi melalui setiap field foto
                                photoFields.forEach(field => {
                                    const photoFileName = hasil_inspeksi[0][field.name]; // Ambil nama file dari objek data
                                    if (photoFileName) { // Hanya tampilkan jika nama file ada (tidak null/empty)
                                        // Gunakan col-md-4 untuk 3 foto per baris di desktop, col-sm-6 untuk 2 foto di tablet, col-12 untuk 1 foto di hp
                                        html += `<div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4 text-center">`;
                                        html += `<p class="mb-1 text-muted small">${field.label}</p>`; // Label di bawah/atas foto
                                        html += `<a href="<?= base_url('assets/img/inspection_photos/'); ?>${photoFileName}" data-lightbox="inspection-photos" data-title="${field.label}">`;
                                        html += `<img src="<?= base_url('assets/img/inspection_photos/'); ?>${photoFileName}" class="img-fluid rounded shadow-sm" alt="${field.label}" style="max-height: 200px; object-fit: contain;">`;
                                        html += `</a>`;
                                        html += `</div>`;
                                    }
                                });

                                html += '</div>'; // End of row for photos
                                html += '</div>'; // End of form-group for photos
                                // --- END GRID FOTO ---

                                html += '<div class="row mt-3">';
                                html += '<div class="col-md-6">';
                                html += '<label for="acknowledge">Acknowledge :</label>';
                                html += '<input readonly type="text" class="form-control form-control-sm" id="acknowledge" name="acknowledge" value="' + hasil_inspeksi[0].acknowledge + '" required>';
                                html += '</div>';
                                html += '<div class="col-md-6">';
                                html += '<label for="mechanic">Mechanic :</label>';
                                html += '<input readonly type="text" class="form-control form-control-sm" id="mechanic" name="mechanic" value="' + hasil_inspeksi[0].mechanic + '" required>';
                                html += '</div>';
                                html += '</div>';
                                modalBody.append(html);
                                $('#modalInspectionResult').modal('show');
                                // ... (Swal.fire yang dikomentari) ...
                            } else {
                                modalBody.append('<p>Tidak ada item inspeksi untuk template ini.</p>');
                                $('#modalInspectionResult').modal('show');
                            }
                        },
                        error: function(xhr, status, error) {
                            modalBody.append('<p>Terjadi kesalahan saat mengambil data.</p>');
                            $('#modalInspectionResult').modal('show');
                            console.error(xhr, status, error);
                        }
                    });
                },
                error: function(xhr, status, error) {
                    modalBody.append('<p>Terjadi kesalahan saat mengambil data.</p>');
                    $('#modalInspectionResult').modal('show');
                    console.error(xhr, status, error);
                }
            });
        });

        document.getElementById('download-pdf').addEventListener('click', async () => {
            const detailContent = document.getElementById('inspection-detail-content');
            
            // Tampilkan loading Swal
            Swal.fire({
                title: 'Sedang membuat PDF...',
                text: 'Mohon tunggu sebentar.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Tunggu semua gambar selesai dimuat
            const images = detailContent.querySelectorAll('img');
            await Promise.all(
                Array.from(images).map(img => {
                    if (img.complete) return Promise.resolve();
                    return new Promise(resolve => {
                        img.onload = img.onerror = resolve;
                    });
                })
            );

            html2canvas(detailContent, {
                scale: 2,
                useCORS: true
            }).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                const pdf = new jspdf.jsPDF('p', 'mm', 'a4');

                const pdfWidth = pdf.internal.pageSize.getWidth();
                const pdfHeight = pdf.internal.pageSize.getHeight();

                const imgWidth = pdfWidth;
                const imgHeight = (canvas.height * pdfWidth) / canvas.width;

                let heightLeft = imgHeight;
                let position = 0;

                // Halaman pertama
                pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                heightLeft -= pdfHeight;

                while (heightLeft > 0) {
                    position = heightLeft - imgHeight;
                    pdf.addPage();
                    pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                    heightLeft -= pdfHeight;
                }

                // Tutup swal loading dan simpan
                Swal.close();
                pdf.save('hasil-inspeksi-'+hasil_inspeksi[0].serial_number+'.pdf');
            }).catch((err) => {
                // Tutup loading dan tampilkan error
                Swal.close();
                Swal.fire('Gagal', 'Terjadi kesalahan saat membuat PDF', 'error');
                console.error(err);
            });
        });

        $('#downloadPdfBtn').on('click', function() {
            var templateId = $(this).data('template-id');
            var unitId = $(this).data('unit-id');
            var id_inspection = $(this).data('inspection-id');
            var id_template = $(this).data('template-id');
            generatePdf(id_inspection, id_template); // Panggil fungsi generatePdf
        });
    });

    // function generatePdf(id_inspection, id_template) {
    //     const { jsPDF } = window.jspdf;
    //     const doc = new jsPDF();
    //     let filename = "hasil_inspeksi_" + id_inspection + ".pdf";
    // }
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // Event listener untuk tombol approve manager
    $(document).on('click', '.btn-approve-manager', function(e) {
        e.preventDefault(); // Mencegah link default berfungsi

        const unitId = $(this).data('unit-id');
        const button = $(this); // Simpan referensi tombol

        Swal.fire({
            title: 'Konfirmasi Approve?',
            text: "Anda akan meng-approve inspeksi ini sebagai Manager. Tindakan ini tidak bisa dibatalkan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Approve!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url("inspection/approve_manager"); ?>', // URL ke controller approve
                    type: 'POST',
                    dataType: 'json', // Harap respons dalam format JSON
                    data: {
                        unit_id: unitId
                    },
                    beforeSend: function() {
                        // Opsi: Tampilkan loading spinner
                        Swal.fire({
                            title: 'Loading...',
                            text: 'Memproses persetujuan...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },
                    success: function(response) {
                        Swal.close(); // Tutup loading spinner

                        if (response.status === 'success') {
                            Swal.fire(
                                'Berhasil!',
                                response.message,
                                'success'
                            ).then(() => {
                                // Opsional: Ubah tampilan tombol atau refresh halaman
                                // Anda bisa mengubah kelas tombol, teks, atau menyembunyikannya
                                button.removeClass('btn-danger').addClass('btn-success');
                                button.html('<i class="fas fa-check"></i> Disetujui'); // Contoh teks/ikon baru
                                button.tooltip('dispose'); // Hapus tooltip lama
                                button.attr('title', 'Telah Disetujui'); // Atur title baru
                                button.prop('disabled', true); // Nonaktifkan tombol setelah diapprove
                                // Jika Anda ingin me-refresh halaman:
                                // window.location.reload(); 
                            });
                        } else {
                            Swal.fire(
                                'Gagal!',
                                response.message,
                                'error'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.close(); // Tutup loading spinner
                        Swal.fire(
                            'Error!',
                            'Terjadi kesalahan saat menghubungi server: ' + error,
                            'error'
                        );
                        console.error('AJAX Error: ', status, error, xhr);
                    }
                });
            }
        });
    });
});
</script>