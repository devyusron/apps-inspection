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
                    <a href="<?= site_url('inspection/index_unit'); ?>" class="btn btn-secondary btn-sm">Reset Filter</a>
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
                                        <button type="button" class="btn btn-success btn-sm lihat-template" data-id="<?= $unit['id_template']; ?>" data-toggle="modal" title="Hasil Inspeksi" data-target="#modalInspectionResult"><i class="fas fa-search"></i></button>
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
                <h5 class="modal-title" id="modalInspectionLabel">Detail Inspeksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="inspection-detail-content">
                <p>Memuat data...</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-danger" id="downloadPdfBtn">Download PDF</button> </div>
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
<script>
    $(document).ready(function() {
        $('.lihat-template').on('click', function() {
            var idTemplate = $(this).data('id');
            var unitId = $(this).data('unit-id');
            var modalBody = $('#inspection-detail-content');
            modalBody.html('<p>Memuat data...</p>');
            $('#modalInspection').modal('show');

            $.ajax({
                url: '<?= site_url('inspection/view_form/'); ?>' + idTemplate,
                type: 'GET',
                dataType: 'json',
                data: {
                    unit_id: unitId
                },
                success: function(data) {
                    if (data && data.length > 0) {
                        var html = buildInspectionForm(data);
                        modalBody.html(html);
                        $('#modalInspection').modal('hide'); // Sembunyikan modal ini setelah data diload
                        $('#modalFormView').modal('show'); // Tampilkan modal form
                         $('#downloadPdfBtn').data('template-id', idTemplate); // Simpan template ID
                         $('#downloadPdfBtn').data('unit-id', unitId); // Simpan unit ID

                    } else {
                        modalBody.html('<p>Tidak ada item inspeksi untuk template ini.</p>');
                    }
                },
                error: function(xhr, status, error) {
                    modalBody.html('<p>Terjadi kesalahan saat mengambil data: ' + error + '</p>');
                    console.error(xhr, status, error);
                }
            });
        });

          $('#downloadPdfBtn').on('click', function() {
            var templateId = $(this).data('template-id');
            var unitId = $(this).data('unit-id');
            generatePdf(templateId, unitId); // Panggil fungsi generatePdf
        });
    });

    function buildInspectionForm(data) {
        var html = '<div class="row">';
        html += '<div class="col-md-6">';
        html += '<div class="form-group row">';
        html += '<label for="customer" class="col-sm-3 col-form-label">Customer</label>';
        html += '<div class="col-sm-9"><input readonly type="text" class="form-control form-control-sm" id="customer" name="customer" value="' + data[0].customer + '"></div>';
        html += '</div>';
        html += '<div class="form-group row">';
        html += '<label for="address" class="col-sm-3 col-form-label">Address</label>';
        html += '<div class="col-sm-9"><textarea readonly class="form-control form-control-sm" id="address" name="address">' + data[0].address + '</textarea></div>';
        html += '</div>';
        html += '<div class="form-group row">';
        html += '<label for="attachment" class="col-sm-3 col-form-label">Other Attachment</label>';
        html += '<div class="col-sm-9"><input readonly type="text" class="form-control form-control-sm" id="attachment" name="attachment" value="' + data[0].attachment + '"></div>';
        html += '</div>';
        html += '</div>';
        html += '<div class="col-md-6">';
        html += '<div class="form-group row">';
        html += '<label for="mechine" class="col-sm-3 col-form-label">Mechine</label>';
        html += '<div class="col-sm-9"><input readonly type="text" class="form-control form-control-sm" id="mechine" name="mechine" value="' + data[0].mechine + '"></div>';
        html += '</div>';
        html += '<div class="form-group row">';
        html += '<label for="model_no" class="col-sm-3 col-form-label">Model No.</label>';
        html += '<div class="col-sm-9"><input readonly type="text" class="form-control form-control-sm" id="model_no" name="model_no" value="' + data[0].model_no + '"></div>';
        html += '</div>';
        html += '<div class="form-group row">';
        html += '<label for="serial_no" class="col-sm-3 col-form-label">Serial No.</label>';
        html += '<div class="col-sm-9"><input readonly type="text" class="form-control form-control-sm" id="serial_no" name="serial_no" value="' + data[0].serial_no + '"></div>';
        html += '</div>';
        html += '<div class="form-group row">';
        html += '<label for="hours" class="col-sm-3 col-form-label">Hours</label>';
        html += '<div class="col-sm-9"><input readonly type="text" class="form-control form-control-sm" id="hours" name="hours" value="' + data[0].hours + '"></div>';
        html += '</div>';
        html += '<div class="form-group row">';
        html += '<label for="inspection_d" class="col-sm-3 col-form-label">Inspection Date</label>';
        html += '<div class="col-sm-9"><input readonly type="date" class="form-control form-control-sm" id="inspection_d" name="inspection_d" value="' + data[0].inspection_d + '"></div>';
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
            html += '<td class="text-center">' + (item.add ? '✔' : '') + '</td>';
            html += '<td class="text-center">' + (item.clean_up ? '✔' : '') + '</td>';
            html += '<td class="text-center">' + (item.lubricate ? '✔' : '') + '</td>';
            html += '<td class="text-center">' + (item.replace_change ? '✔' : '') + '</td>';
            html += '<td class="text-center">' + (item.adjust ? '✔' : '') + '</td>';
            html += '<td class="text-center">' + (item.test_check ? '✔' : '') + '</td>';
            html += '<td>' + (item.remark || '') + '</td>';
            html += '</tr>';
        });
        html += '</tbody></table>';

        html += '<div class="form-group mt-3">';
        html += '<label for="additional_comment">Additional Comment :</label>';
        html += '<textarea readonly class="form-control" id="additional_comment" name="additional_comment" rows="3">' + data[0].additional_comment + '</textarea>';
        html += '</div>';

        html += '<div class="row mt-3">';
        html += '<div class="col-md-6">';
        html += '<label for="acknowledge">Acknowledge :</label>';
        html += '<input readonly type="text" class="form-control form-control-sm" id="acknowledge" name="acknowledge" value="' + data[0].acknowledge + '"></div>';
        html += '</div>';
        html += '<div class="col-md-6">';
        html += '<label for="mechanic">Mechanic :</label>';
        html += '<input readonly type="text" class="form-control form-control-sm" id="mechanic" name="mechanic" value="' + data[0].mechanic + '"></div>';
        html += '</div>';
        html += '</div>';
        return html;
    }



    function generatePdf(templateId, unitId) {
        // Menggunakan library jsPDF untuk membuat PDF
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        const title = "Form Hasil Inspeksi";
        const filename = "hasil_inspeksi.pdf";

         $.ajax({
            url: '<?= site_url('inspection/view_form/'); ?>' + templateId,
            type: 'GET',
            dataType: 'json',
            data: {
                unit_id: unitId
            },
            success: function(data) {
                  if (data && data.length > 0) {
                    // Tambahkan title
                    doc.setFontSize(20);
                    doc.text(title, 10, 10);

                    let y = 20;

                    // Tambahkan informasi umum.
                     doc.setFontSize(12);
                    doc.text(`Customer: ${data[0].customer}`, 10, y += 10);
                    doc.text(`Address: ${data[0].address}`, 10, y += 10);
                    doc.text(`Attachment: ${data[0].attachment}`, 10, y += 10);
                    doc.text(`Mechine: ${data[0].mechine}`, 10, y += 10);
                    doc.text(`Model No: ${data[0].model_no}`, 10, y += 10);
                    doc.text(`Serial No: ${data[0].serial_no}`, 10, y += 10);
                    doc.text(`Hours: ${data[0].hours}`, 10, y += 10);
                    doc.text(`Inspection Date: ${data[0].inspection_d}`, 10, y += 10);

                    y += 10;

                    // Tambahkan tabel
                    const headers = [["Group", "Item", "Add", "Clean Up", "Lubricate", "Replace/Change", "Adjust", "Test/Check", "Remark"]];
                    const tableData = data.map(item => [
                        item.nama_group,
                        item.nama_item,
                        item.add ? "✔" : "",
                        item.clean_up ? "✔" : "",
                        item.lubricate ? "✔" : "",
                        item.replace_change ? "✔" : "",
                        item.adjust ? "✔" : "",
                        item.test_check ? "✔" : "",
                        item.remark || ""
                    ]);

                    doc.autoTable({
                        head: headers,
                        body: tableData,
                        startY: y,
                         columnStyles: {
                            0: { cellWidth: 20 },
                            1: { cellWidth: 30 },
                            2: { cellWidth: 15, halign: 'center' },
                            3: { cellWidth: 15, halign: 'center' },
                            4: { cellWidth: 15, halign: 'center' },
                            5: { cellWidth: 25, halign: 'center' },
                            6: { cellWidth: 15, halign: 'center' },
                            7: { cellWidth: 20, halign: 'center' },
                            8: { cellWidth: 30 },
                        },
                    });
                      const finalY = doc.lastAutoTable.finalY + 10;

                    // Tambahkan Komentar
                     doc.setFontSize(12);
                    doc.text("Additional Comment :", 10, finalY);
                    doc.setFontSize(10);
                    const comment = data[0].additional_comment;
                    const lines = doc.splitTextToSize(comment, 180);
                    doc.text(lines, 10, finalY + 5);

                    const acknowledgeY = finalY + 20 + (lines.length * 5);
                    // Tambahkan Acknowledge dan Mechanic
                    doc.setFontSize(12);
                    doc.text(`Acknowledge : ${data[0].acknowledge}`, 10, acknowledgeY);
                    doc.text(`Mechanic : ${data[0].mechanic}`, 100, acknowledgeY);

                    // Simpan PDF
                    doc.save(filename);
                 }
            },
            error: function(xhr, status, error) {
                console.error("Error generating PDF:", error);
                alert("Gagal membuat PDF. Silakan coba lagi.");
            }
        });
    }
</script>