<div class="container-fluid">
    <!-- Page Heading -->
    <div class="m-1 shadow card">
        <div class="card-header mb-4 d-flex justify-content-between align-items-center">
            <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
            <?php if($this->session->userdata('role_id') == 1) : ?>
            <a href="<?= site_url('inspection/add_unit'); ?>" class="btn btn-outline-primary">
                <i class="fas fa-plus mr-2"></i>
                Tambah Unit
            </a>
            <?php endif; ?>
        </div>
        <?php if ($this->session->flashdata('swal')): ?>
            <script>
            Swal.fire(<?php echo json_encode($this->session->flashdata('swal')); ?>);
            </script>
        <?php endif; ?>
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
                                <option value="Sudah Inspeksi">Sudah Inspeksi</option>
                                <option value="Belum Inspeksi">Belum Inspeksi</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-2">
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
                                <th>Machine No</th>      
                                <th>Model No</th>
                                <th>Qty</th>
                                <th>Kondisi Unit</th>
                                <th>Tanggal Masuk</th>
                                <!-- <th>Tanggal Keluar</th> -->
                                <th>Status Unit</th>
                                <th>Lokasi Unit</th>
                                <th>Keterangan Unit</th>
                                <!-- <th>Created At</th>
                                <th>Created By</th> -->
                                <th>Status Inspeksi</th>
                                <th>Status Approve</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; foreach ($units as $unit): ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= htmlspecialchars($unit['serial_number']); ?></td>
                                    <td><?= htmlspecialchars($unit['nama_produk']); ?></td>
                                    <td><?= isset($unit['machine_no']) ? htmlspecialchars($unit['machine_no']) : '-'; ?></td>    
                                    <td><?= isset($unit['model_no']) ? htmlspecialchars($unit['model_no']) : '-'; ?>
                                    <td><?= $unit['qty']; ?></td>
                                    <td><?= htmlspecialchars($unit['kondisi_unit']); ?></td>
                                    <td><?= $unit['tanggal_masuk']; ?></td>
                                    <!-- <td><?= $unit['tanggal_keluar']; ?></td> -->
                                    <td><?= htmlspecialchars($unit['status_unit']); ?></td>
                                    <td><?= htmlspecialchars($unit['lokasi_unit']); ?></td>
                                    <td><?= htmlspecialchars($unit['keterangan_unit']); ?></td>
                                    <!-- <td><?= $unit['created_at']; ?></td>
                                    <td><?= htmlspecialchars($unit['created_by']); ?></td> -->
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
                                        <?php if ($unit['status_inspection'] == 'Belum Inspeksi') : ?>
                                            <a href="#" class="btn btn-success btn-sm lihat-template"
                                                data-toggle="tooltip" data-placement="top" title="Inspeksi"
                                                data-unit-id="<?= $unit['unit_id']; ?>"
                                                data-machine-no="<?= isset($unit['machine_no']) ? $unit['machine_no'] : '-'; ?>" 
                                                data-model-no="<?= isset($unit['model_no']) ? $unit['model_no'] : '-' ?>" 
                                                data-serial-number="<?= $unit['serial_number']?>"> 
                                                <i class="fas fa-clipboard-check"></i>
                                            </a>
                                        <?php else : ?>
                                            <button type="button" class="btn btn-success btn-sm lihat-template-result" 
                                            data-inspection-id="<?= $unit['id_inspection']; ?>"
                                            data-unit-id="<?= $unit['unit_id']; ?>"
                                            data-machine-no="<?= $unit['machine_no']; ?>" 
                                            data-model-no="<?= $unit['model_no']; ?>" 
                                            data-serial-number="<?= $unit['serial_number']?>"
                                            data-id="<?= $unit['id_template']; ?>" 
                                            data-toggle="modal" title="Hasil Inspeksi" 
                                            data-target="#modalInspectionResult"><i class="fas fa-search"></i></button>
                                        <?php endif; ?>
                                        <?php if($this->session->userdata('role_id') == 1) : ?>
                                            <a href="<?= site_url('inspection/edit_unit/' . $unit['unit_id']); ?>" class="btn btn-warning btn-sm"
                                                data-toggle="tooltip" data-placement="top" title="Edit Unit">
                                                <i class="fas fa-edit"></i> 
                                            </a>
                                            <a href="#" class="btn btn-danger btn-sm btn-delete"
                                                data-toggle="tooltip" data-placement="top" title="Hapus Unit"
                                                data-unit-id="<?= $unit['unit_id']; ?>">  <i class="fas fa-trash-alt"></i>
                                            </a>
                                        <?php endif; ?>
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
<div class="modal fade" id="modalInspectionResult" tabindex="-1" role="dialog" aria-labelledby="modalInspectionResultLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalInspectionResultLabel">Inspection form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="inspection-detail-content">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalInspection" tabindex="-1" role="dialog" aria-labelledby="modalInspectionLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalInspectionLabel">Pilih Form PDI</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="inspection-detail-content">
                <?php foreach ($inspection_template as $template) : ?>
                    <button class="btn btn-outline-primary btn-block mb-2 pdi-form-button"
                            data-template-id="<?= $template['id_template'] ?>">
                        <?= $template['nama_template'] ?>
                    </button>
                <?php endforeach; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalFormView" tabindex="-1" role="dialog" aria-labelledby="modalFormViewLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalFormViewLabel">Form Inspeksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="form-view-content" style="overflow-y: auto; max-height: 80vh;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
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
<script>
$(document).ready(function() {
    $('.btn-delete').on('click', function(e) {
        e.preventDefault(); // Prevent default link behavior
        var unitId = $(this).data('unit-id'); // Ambil ID unit dari data atribut
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda tidak akan dapat mengembalikan unit ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika pengguna mengkonfirmasi, arahkan ke URL penghapusan
                window.location.href = "<?= site_url('inspection/delete_unit/'); ?>" + unitId;
            }
        });
    });
    $('.lihat-template-result').on('click', function() {
        let hasil_inspeksi;
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
                            html += '<div class="col-sm-9"><textarea readonly class="form-control form-control-sm" id="address" name="address" value="' + hasil_inspeksi[0].address + '">' + hasil_inspeksi[0].address + '</textarea></div>';
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
                                html += '<td class="text-center">'+getCheckbox(item.add)+'</td>';
                                html += '<td class="text-center">'+getCheckbox(item.clean_up)+'</td>';
                                html += '<td class="text-center">'+getCheckbox(item.lubricate)+'</td>';
                                html += '<td class="text-center">'+getCheckbox(item.replace_change)+'</td>';
                                html += '<td class="text-center">'+getCheckbox(item.adjust)+'</td>';
                                html += '<td class="text-center">'+getCheckbox(item.test_check)+'</td>';
                                html += '<td><textarea readonly class="form-control form-control-sm" rows="1">' + (item.remark || '') + '</textarea></td>';
                                html += '</tr>';
                            });
                            html += '</tbody></table>';
                            html += '<div class="form-group mt-3">';
                            html += '<label for="additional_comment">Additional Comment :</label>';
                            html += '<textarea readonly class="form-control" id="additional_comment" name="additional_comment" rows="3">'+hasil_inspeksi[0].additional_comment+'</textarea>';
                            html += '</div>';
                            html += '<div class="form-group mt-3">';
                            html += '<label for="photo_inspection">Photo Inspection :</label>';
                            // html += '<input type="file" class="form-control-file" id="photo_inspection" name="photo_inspection" accept="image/*" required>';
                            html += '<a href="<?= base_url('assets/img/inspection_photos/'); ?>' + hasil_inspeksi[0].photo_inspection + '" data-lightbox="inspection-photo" data-title="Foto Inspeksi">';
                            html += '<img src="<?= base_url('assets/img/inspection_photos/'); ?>' + hasil_inspeksi[0].photo_inspection + '" class="img-fluid" alt="Inspection Photo" style="max-width: 300px; border-radius: 8px;">';
                            html += '</div>';
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
                            // Swal.fire({
                            //     text: 'Data berhasil ditampilkan!',
                            //     icon: 'success',
                            //     timer: 1500,
                            //     showConfirmButton: false
                            // });
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
});
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox-plus-jquery.min.js"></script>
<script>
    // Konfigurasi Lightbox2 (opsional, bisa disesuaikan)
    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true
    })
</script>
<script>
    function buildInspectionForm(data, unitId, templateId, machineNo, modelNo, serialNumber) {
        var html = '<form id="inspectionForm">';
        html += '<input type="hidden" name="unit_id" value="' + unitId + '">';
        html += '<input type="hidden" name="template_id" value="' + templateId + '">';
        html += '<div class="row">';
        html += '<div class="col-md-6">';
        html += '<div class="form-group row">';
        html += '<label for="customer" class="col-sm-3 col-form-label">Customer</label>';
        html += '<div class="col-sm-9"><input readonly type="text" class="form-control form-control-sm" id="customer" name="customer"></div>';
        html += '</div>';
        html += '<div class="form-group row">';
        html += '<label for="address" class="col-sm-3 col-form-label">Address</label>';
        html += '<div class="col-sm-9"><textarea  class="form-control form-control-sm" id="address" name="address"></textarea></div>';
        html += '</div>';
        html += '<div class="form-group row">';
        html += '<label for="attachment" class="col-sm-3 col-form-label">Other Attachment</label>';
        html += '<div class="col-sm-9"><input  type="text" class="form-control form-control-sm" id="attachment" name="attachment"></div>';
        html += '</div>';
        html += '</div>';
        html += '<div class="col-md-6">';
        html += '<div class="form-group row">';
        html += '<label for="machine_no" class="col-sm-3 col-form-label">Machine</label>';
        html += '<div class="col-sm-9"><input readonly type="text" class="form-control form-control-sm" id="machine_no" name="machine_no" value="' + machineNo + '"></div>';
        html += '</div>';
        html += '<div class="form-group row">';
        html += '<label for="model_no" class="col-sm-3 col-form-label">Model No.</label>';
        html += '<div class="col-sm-9"><input readonly type="text" class="form-control form-control-sm" id="model_no" name="model_no" value="' + modelNo + '"></div>';
        html += '</div>';
        html += '<div class="form-group row">';
        html += '<label for="serial_no" class="col-sm-3 col-form-label">Serial No.</label>';
        html += '<div class="col-sm-9"><input readonly type="text" class="form-control form-control-sm" id="serial_no" name="serial_no" value="' + serialNumber + '"></div>';
        html += '</div>';
        html += '<div class="form-group row">';
        html += '<label for="hours" class="col-sm-3 col-form-label">Hours</label>';
        html += '<div class="col-sm-9"><input  type="text" class="form-control form-control-sm" id="hours" name="hours"></div>';
        html += '</div>';
        html += '<div class="form-group row">';
        html += '<label for="inspection_d" class="col-sm-3 col-form-label">Inspection Date</label>';
        html += '<div class="col-sm-9"><input  type="date" class="form-control form-control-sm" id="inspection_d" name="inspection_d"></div>';
        html += '</div>';
        html += '</div>';
        html += '</div>';

        html += '<hr class="mt-2 mb-2">';

        html += '<table class="table table-bordered">';
        html += '<thead><tr><th>Group</th><th>Item</th><th>Add</th><th>Clean Up</th><th>Lubricate</th><th>Replace Or Change</th><th>Adjust</th><th>Test or Check</th><th>Remark</th></tr></thead><tbody>';
        $.each(data, function(i, item) {
            html += '<tr>';
            html += '<td>' + item.nama_group + '</td>';
            html += '<td>' + item.nama_item + '</td>';
            html += '<td class="text-center"><input type="checkbox" name="add[' + item.id_item + ']" value="1"></td>';
            html += '<td class="text-center"><input type="checkbox" name="clean_up[' + item.id_item + ']" value="1"></td>';
            html += '<td class="text-center"><input type="checkbox" name="lubricate[' + item.id_item + ']" value="1"></td>';
            html += '<td class="text-center"><input type="checkbox" name="replace_change[' + item.id_item + ']" value="1"></td>';
            html += '<td class="text-center"><input type="checkbox" name="adjust[' + item.id_item + ']" value="1"></td>';
            html += '<td class="text-center"><input type="checkbox" name="test_check[' + item.id_item + ']" value="1"></td>';
            html += '<td><input type="text" name="remark[' + item.id_item + ']" class="form-control form-control-sm"></td>';
            html += '</tr>';
        });
        html += '</tbody></table>';

        html += '<div class="form-group mt-3">';
        html += '<label for="additional_comment">Additional Comment :</label>';
        html += '<textarea  class="form-control" id="additional_comment" name="additional_comment" rows="3"></textarea>';
        html += '</div>';
        html += '<div class="form-group mt-3">';
        html += '<label for="photo_inspection">Photo Inspection :</label>';
        html += '<input type="file" class="form-control-file" id="photo_inspection" name="photo_inspection" accept="image/*" required>';
        html += '</div>';
        html += '<div class="row mt-3">';
        html += '<div class="col-md-6">';
        html += '<label for="acknowledge">Acknowledge :</label>';
        html += '<input  type="text" class="form-control form-control-sm" id="acknowledge" name="acknowledge" required>';
        html += '</div>';
        html += '<div class="col-md-6">';
        html += '<label for="mechanic">Mechanic :</label>';
        html += '<input  type="text" class="form-control form-control-sm" id="mechanic" name="mechanic" required>';
        html += '</div>';
        html += '</div>';
        html += '<button type="submit" class="btn btn-primary mt-3">Simpan Inspeksi</button>';
        html += '</form>';
        return html;
    }

    function loadInspectionForm(templateId, unitId, machineNo, modelNo, serialNumber) {
        $.ajax({
            url: '<?= site_url('inspection/view_form/'); ?>/' + templateId,
            type: 'GET',
            dataType: 'json',
            data: {
                unit_id: unitId
            },
            success: function(data) {
                var html = buildInspectionForm(data, unitId, templateId, machineNo, modelNo, serialNumber);
                $('#form-view-content').html(html);
                $('#modalFormView').modal('show');
                setupFormSubmission();
                var timestamp = new Date().getTime();
                $('#customer').val('CUST' + timestamp);
            },
            error: function(xhr, status, error) {
                $('#form-view-content').html('<p>Terjadi kesalahan saat mengambil data: ' + error + '</p>');
                $('#modalFormView').modal('show');
                console.error(xhr, status, error);
            }
        });
    }

    function setupFormSubmission() {
        $('#inspectionForm').submit(function(event) {
            event.preventDefault();

            var formData = {
                unit_id: $('input[name="unit_id"]').val(),
                template_id: $('input[name="template_id"]').val(),
                customer: $('input[name="customer"]').val(),
                address: $('textarea[name="address"]').val(),
                attachment: $('input[name="attachment"]').val(),
                mechine: $('input[name="mechine"]').val(),
                model_no: $('input[name="model_no"]').val(),
                serial_no: $('input[name="serial_no"]').val(),
                hours: $('input[name="hours"]').val(),
                inspection_d: $('input[name="inspection_d"]').val(),
                additional_comment: $('textarea[name="additional_comment"]').val(),
                acknowledge: $('input[name="acknowledge"]').val(),
                mechanic: $('input[name="mechanic"]').val(),
                items: [] // Array untuk menyimpan informasi item tabel
            };

            // Loop melalui setiap baris tabel (kecuali header)
            $('#inspectionForm table tbody tr').each(function() {
                var row = $(this);
                var idItemMatch = row.find('input[type="checkbox"][name^="add"]').attr('name').match(/\[(.*?)\]/);
                if (idItemMatch && idItemMatch[1]) {
                    var idItem = idItemMatch[1];
                    var itemData = {
                        id_item: idItem,
                        add: row.find('input[name="add[' + idItem + ']"]').is(':checked') ? 1 : 0,
                        clean_up: row.find('input[name="clean_up[' + idItem + ']"]').is(':checked') ? 1 : 0,
                        lubricate: row.find('input[name="lubricate[' + idItem + ']"]').is(':checked') ? 1 : 0,
                        replace_change: row.find('input[name="replace_change[' + idItem + ']"]').is(':checked') ? 1 : 0,
                        adjust: row.find('input[name="adjust[' + idItem + ']"]').is(':checked') ? 1 : 0,
                        test_check: row.find('input[name="test_check[' + idItem + ']"]').is(':checked') ? 1 : 0,
                        remark: row.find('input[name="remark[' + idItem + ']"]').val()
                    };
                    formData.items.push(itemData);
                }
            });

            console.log("Data Form yang Dikumpulkan:", formData);

            // Kirim data formData menggunakan AJAX ke server Anda
            $.ajax({
                url: '<?php echo site_url('inspection/submit_inspection'); ?>',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(formData), // Pastikan formData memiliki properti 'items' yang merupakan array
                success: function(response) {
                    console.log(response);
                    if (response.status == 'success') {
                        /* Swal.fire({
                            title: 'Berhasil!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.reload();
                        }); */
                        const inspectionId = response.inspection_id; // Server harus mengembalikan ID inspeksi
                        console.log('ID Inspeksi:', inspectionId);
                        if (inspectionId) {
                            uploadInspectionPhoto(inspectionId);
                        } else {
                            Swal.fire('Error!', 'ID Inspeksi tidak ditemukan setelah submit data utama.', 'error');
                        }
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: response.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(error) {
                    console.error('Error saat mengirim data:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat mengirim data: ' + status + ' - ' + error,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    }

    function uploadInspectionPhoto(inspectionId) {
        const photoFile = $('#photo_inspection')[0].files[0];
        if (photoFile) {
            var formDataPhoto = new FormData();
            formDataPhoto.append('inspection_id', inspectionId); // Kirim ID inspeksi untuk mengaitkan foto
            formDataPhoto.append('photo_inspection', photoFile);
            $.ajax({
                url: '<?php echo site_url('inspection/upload_inspection_photo'); ?>', // Endpoint terpisah untuk upload foto
                type: 'POST',
                data: formDataPhoto,
                processData: false, // Penting untuk FormData
                contentType: false, // Penting untuk FormData
                success: function(response) {
                    console.log(typeof(response));
                    if (response.includes('success')) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Data inspeksi dan foto berhasil disimpan!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire('Error!', 'Gagal mengupload foto: ' + response.message, 'error');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error saat mengupload foto:', textStatus, errorThrown);
                    Swal.fire('Error!', 'Terjadi kesalahan saat mengupload foto: ' + textStatus + ' - ' + errorThrown, 'error');
                }
            });
        } else {
            Swal.fire({
                title: 'Berhasil!',
                text: 'Data inspeksi berhasil disimpan (tanpa foto).',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.reload();
            });
        }
    }

    $(document).ready(function() {
        $('.lihat-template').on('click', function() {
            var unitId = $(this).data('unit-id');
            var machineNo = $(this).data('machine-no');
            var modelNo = $(this).data('model-no');
            var serialNumber = $(this).data('serial-number');
            console.log(unitId);
            $('#modalInspection').data('unit-id', unitId);
            $('#modalInspection').data('machine-no', machineNo);
            $('#modalInspection').data('model-no', modelNo);
            $('#modalInspection').data('serial-number', serialNumber);
            $('#modalInspection').modal('show');
        });

        $('.pdi-form-button').on('click', function() {
            var templateId = $(this).data('template-id');
            var unitId = $('#modalInspection').data('unit-id');
            var machineNo = $('#modalInspection').data('machine-no');
            var modelNo = $('#modalInspection').data('model-no');
            var serialNumber = $('#modalInspection').data('serial-number');
            console.log('Memuat form dengan ID Template:', templateId, 'untuk Unit ID:', unitId);
            $('#modalInspection').modal('hide');
            loadInspectionForm(templateId, unitId, machineNo, modelNo, serialNumber);
        });
    });
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