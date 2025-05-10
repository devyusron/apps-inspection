<div class="container-fluid">
    <!-- Page Heading -->
    <div class="m-1 shadow card">
        <div class="card-header mb-4 d-flex justify-content-between align-items-center">
            <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
        </div>
        <!-- <?php if ($this->session->flashdata('swal')): ?>
            <script>
            Swal.fire(<?php echo json_encode($this->session->flashdata('swal')); ?>);
            </script>
        <?php endif; ?> -->
        <div class="row">
            <div class="col-lg m-2">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Form</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; foreach ($inspection_template as $form): ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= htmlspecialchars($form['nama_template']); ?></td>
                                    <td><?= htmlspecialchars($form['deskripsi_template']); ?></td>
                                    <td>
                                    <button type="button" class="btn btn-warning btn-sm lihat-template" data-id="<?= $form['id_template']; ?>" data-toggle="modal" data-target="#modalInspection"><i class="fas fa-clipboard-check"></i></button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalInspection" tabindex="-1" role="dialog" aria-labelledby="modalInspectionLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="modalInspectionLabel">Inspection form</h5>
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
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('.lihat-template').on('click', function() {
            var id_template = $(this).data('id');
            var modalBody = $('#inspection-detail-content');
            modalBody.empty(); // Kosongkan isi modal sebelum menampilkan data baru
            $.ajax({
                url: '<?= site_url('inspection/view_form/'); ?>' + id_template,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data && data.length > 0) {
                        var html = '<div class="row">';
                        html += '<div class="col-md-6">';
                        html += '<div class="form-group row">';
                        html += '<label for="customer" class="col-sm-3 col-form-label">Customer</label>';
                        html += '<div class="col-sm-9"><input readonly type="text" class="form-control form-control-sm" id="customer" name="customer"></div>';
                        html += '</div>';
                        html += '<div class="form-group row">';
                        html += '<label for="address" class="col-sm-3 col-form-label">Address</label>';
                        html += '<div class="col-sm-9"><textarea readonly class="form-control form-control-sm" id="address" name="address"></textarea></div>';
                        html += '</div>';
                        html += '<div class="form-group row">';
                        html += '<label for="attachment" class="col-sm-3 col-form-label">Other Attachment</label>';
                        html += '<div class="col-sm-9"><input readonly type="text" class="form-control form-control-sm" id="attachment" name="attachment"></div>';
                        html += '</div>';
                        html += '</div>';
                        html += '<div class="col-md-6">';
                        html += '<div class="form-group row">';
                        html += '<label for="mechine" class="col-sm-3 col-form-label">Mechine</label>';
                        html += '<div class="col-sm-9"><input readonly type="text" class="form-control form-control-sm" id="mechine" name="mechine"></div>';
                        html += '</div>';
                        html += '<div class="form-group row">';
                        html += '<label for="model_no" class="col-sm-3 col-form-label">Model No.</label>';
                        html += '<div class="col-sm-9"><input readonly type="text" class="form-control form-control-sm" id="model_no" name="model_no"></div>';
                        html += '</div>';
                        html += '<div class="form-group row">';
                        html += '<label for="serial_no" class="col-sm-3 col-form-label">Serial No.</label>';
                        html += '<div class="col-sm-9"><input readonly type="text" class="form-control form-control-sm" id="serial_no" name="serial_no"></div>';
                        html += '</div>';
                        html += '<div class="form-group row">';
                        html += '<label for="hours" class="col-sm-3 col-form-label">Hours</label>';
                        html += '<div class="col-sm-9"><input readonly type="text" class="form-control form-control-sm" id="hours" name="hours"></div>';
                        html += '</div>';
                        html += '<div class="form-group row">';
                        html += '<label for="inspection_d" class="col-sm-3 col-form-label">Inspection Date</label>';
                        html += '<div class="col-sm-9"><input readonly type="date" class="form-control form-control-sm" id="inspection_d" name="inspection_d"></div>';
                        html += '</div>';
                        html += '</div>';
                        html += '</div>'; // End of row

                        html += '<hr class="mt-2 mb-2">'; // Garis pemisah antara info atas dan tabel

                        html += '<table class="table table-bordered">';
                        html += '<thead><tr><th>Group</th><th>Item</th><th>Add</th><th>Clean Up</th><th>Lubricate</th><th>Replace Or Change</th><th>Adjust</th><th>Test or Check</th><th>Remark</th></tr></thead><tbody>';
                        $.each(data, function(i, item) {
                            html += '<tr>';
                            html += '<td>' + item.nama_group + '</td>';
                            html += '<td>' + item.nama_item + '</td>';
                            html += '<td class="text-center"></td>';
                            html += '<td class="text-center"></td>';
                            html += '<td class="text-center"></td>';
                            html += '<td class="text-center"></td>';
                            html += '<td class="text-center"></td>';
                            html += '<td class="text-center"></td>';
                            html += '<td></td>';
                            html += '</tr>';
                        });
                        html += '</tbody></table>';
                        html += '<div class="form-group mt-3">';
                        html += '<label for="additional_comment">Additional Comment :</label>';
                        html += '<textarea readonly class="form-control" id="additional_comment" name="additional_comment" rows="3"></textarea>';
                        html += '</div>';

                        html += '<div class="row mt-3">';
                        html += '<div class="col-md-6">';
                        html += '<label for="acknowledge">Acknowledge :</label>';
                        html += '<input readonly type="text" class="form-control form-control-sm" id="acknowledge" name="acknowledge">';
                        html += '</div>';
                        html += '<div class="col-md-6">';
                        html += '<label for="mechanic">Mechanic :</label>';
                        html += '<input readonly type="text" class="form-control form-control-sm" id="mechanic" name="mechanic">';
                        html += '</div>';
                        html += '</div>';
                        modalBody.append(html);
                        $('#modalInspection').modal('show');
                        // Swal.fire({
                        //     text: 'Data berhasil ditampilkan!',
                        //     icon: 'success',
                        //     timer: 1500,
                        //     showConfirmButton: false
                        // });
                    } else {
                        modalBody.append('<p>Tidak ada item inspeksi untuk template ini.</p>');
                        $('#modalInspection').modal('show');
                    }
                },
                error: function(xhr, status, error) {
                    modalBody.append('<p>Terjadi kesalahan saat mengambil data.</p>');
                    $('#modalInspection').modal('show');
                    console.error(xhr, status, error);
                }
            });
        });
    });
</script>