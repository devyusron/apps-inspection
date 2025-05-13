<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Inspeksi</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>No. Unit</th>
                    <td><?= $inspection['no_unit']; ?></td>
                </tr>
                <tr>
                    <th>Nama Produk</th>
                    <td><?= $inspection['nama_produk']; ?></td>
                </tr>
                <tr>
                    <th>Tanggal Inspeksi</th>
                    <td><?= $inspection['tanggal_inspeksi']; ?></td>
                </tr>
                 <tr>
                    <th>Mechanic</th>
                    <td><?= $inspection['mechanic']; ?></td>
                </tr>
                <tr>
                    <th>Acknowledge</th>
                    <td><?= $inspection['acknowledge']; ?></td>
                </tr>
                <tr>
                    <th>Additional Comment</th>
                    <td><?= $inspection['additional_comment']; ?></td>
                </tr>
            </table>

            <h6 class="mt-4 font-weight-bold text-primary">Detail Inspeksi</h6>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Group</th>
                            <th>Item</th>
                            <th>Test Check</th>
                            <th>Remark</th>
                            <th>Add</th>
                            <th>Clean Up</th>
                            <th>Lubricate</th>
                            <th>Replace/Change</th>
                            <th>Adjust</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($detail_inspeksi as $detail) : ?>
                            <tr>
                                <td><?= $detail['nama_group']; ?></td>
                                <td><?= $detail['nama_item']; ?></td>
                                <td><?= $detail['test_check']; ?></td>
                                <td><?= $detail['remark']; ?></td>
                                <td><?= $detail['add'] == 1 ? 'Ya' : 'Tidak'; ?></td>
                                <td><?= $detail['clean_up'] == 1 ? 'Ya' : 'Tidak'; ?></td>
                                <td><?= $detail['lubricate'] == 1 ? 'Ya' : 'Tidak'; ?></td>
                                <td><?= $detail['replace_change'] == 1 ? 'Ya' : 'Tidak'; ?></td>
                                <td><?= $detail['adjust'] == 1 ? 'Ya' : 'Tidak'; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>