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
                <form action="<?= site_url('inspection/index_list_inspection'); ?>" method="get">
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
                        <!-- <div class="col-md-2 mb-2">
                            <label for="status_inspection">Status Inspection:</label>
                            <select class="form-control form-control-sm" id="status_inspection" name="status_inspection">
                                <option value="">Pilih Status</option>
                                <option value="Sudah Inspeksi">Sudah Inspeksi</option>
                                <option value="Belum Inspeksi">Belum Inspeksi</option>
                            </select>
                        </div> -->
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
                    <a href="<?= site_url('inspection/index_list_inspection'); ?>" class="btn btn-secondary btn-sm">Reset Filter</a>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-lg m-2">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable">
                        <thead>
                            <tr>
                                <th>ID Unit</th>
                                <th>Serial Number</th>
                                <th>Machine No</th>      
                                <th>Model No</th>
                                <th>Nama Produk</th>
                                <th>Qty</th>
                                <th>Kondisi Unit</th>
                                <th>Tanggal Masuk</th>
                                <th>Status Unit</th>
                                <th>Lokasi Unit</th>
                                <th>Keterangan Unit</th>
                                <th>Status Inspeksi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; foreach ($units as $unit): ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= htmlspecialchars($unit['serial_number']); ?></td>
                                    <td><?= isset($unit['machine_no']) ? htmlspecialchars($unit['machine_no']) : '-'; ?></td>
                                    <td><?= isset($unit['model_no']) ? htmlspecialchars($unit['model_no']) : '-'; ?></td>
                                    <td><?= htmlspecialchars($unit['nama_produk']); ?></td>
                                    <td><?= $unit['qty']; ?></td>
                                    <td><?= htmlspecialchars($unit['kondisi_unit']); ?></td>
                                    <td><?= $unit['tanggal_masuk']; ?></td>
                                    <td><?= htmlspecialchars($unit['status_unit']); ?></td>
                                    <td><?= htmlspecialchars($unit['lokasi_unit']); ?></td>
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
                                        <a href="#" class="btn btn-success btn-sm lihat-template"
                                        data-toggle="tooltip" data-placement="top" title="Inspeksi"
                                        data-unit-id="<?= $unit['unit_id']; ?>" 
                                        data-machine-no="<?= isset($unit['machine_no']) ? $unit['machine_no'] : '-'; ?>" 
                                        data-model-no="<?= isset($unit['model_no']) ? $unit['model_no'] : '-' ?>"  
                                        data-serial-number="<?= $unit['serial_number']?>"> 
                                            <i class="fas fa-clipboard-check"></i>
                                        </a>
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