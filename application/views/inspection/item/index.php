<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Data Inspection Item</h6>
          <?php if($this->session->userdata('role_id') == '1') : ?>
          <a href="<?= site_url('inspection/create_inspection_item'); ?>" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> Tambah Item</a>
          <?php endif; ?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Grup</th>
                            <th>Item</th>
                            <th>Template</th> <th>Urutan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($inspection_items as $item) : ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= htmlspecialchars($item['nama_group']); ?></td>
                                <td><?= htmlspecialchars($item['nama_item']); ?></td>
                                <td><?= htmlspecialchars($item['nama_template'] ?? 'N/A'); ?></td> <td><?= $item['urutan']; ?></td>
                                <td>
                                    <?php if($this->session->userdata('role_id') == '1') : ?>
                                    <a href="<?= site_url('inspection/edit_inspection_item/' . $item['id_item']); ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                    <a href="<?= site_url('inspection/delete_inspection_item/' . $item['id_item']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin?')"><i class="fas fa-trash"></i> Hapus</a>
                                    <?php else : ?>
                                        -
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