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
                                <option value="Gudang">Gudang</option>
                                <option value="Vendor">Vendor</option>
                                <option value="Customer">Customer</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                    <a href="<?= site_url('inspection/result'); ?>" class="btn btn-secondary btn-sm">Reset Filter</a>
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
                                    <td><?= htmlspecialchars($unit['machine_no']); ?></td>
                                    <td><?= htmlspecialchars($unit['model_no']); ?></td>
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
                                        <button type="button" class="btn btn-success btn-sm lihat-template-result" 
                                            data-inspection-id="<?= $unit['id_inspection']; ?>"
                                            data-unit-id="<?= $unit['unit_id']; ?>"
                                            data-machine-no="<?= $unit['machine_no']; ?>" 
                                            data-model-no="<?= $unit['model_no']; ?>" 
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