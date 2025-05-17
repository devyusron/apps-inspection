<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-8">
          <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Create Item</h6>
            </div>
            <div class="card-body">
                <form action="<?= base_url('inspection/save_inspection_item'); ?>" method="post">
                    <div class="form-group">
                        <label for="nama_group">Nama Grup</label>
                        <input type="text" class="form-control" id="nama_group" name="nama_group" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_item">Nama Item</label>
                        <input type="text" class="form-control" id="nama_item" name="nama_item" required>
                    </div>
                    <div class="form-group">
                        <label for="urutan">Urutan</label>
                        <input type="number" class="form-control" id="urutan" name="urutan">
                    </div>
                    <div class="form-group">
                        <label for="id_template">Template</label>
                        <select class="form-control" id="id_template" name="id_template" required>
                            <option value="">Pilih Template</option>
                            <?php foreach ($inspection_template as $template) : ?>
                                <option value="<?= $template['id_template']; ?>"><?= htmlspecialchars($template['nama_template']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="<?= base_url('inspection/index_inspection_item'); ?>" class="btn btn-secondary">Batal</a>
                </form>
              </div>
            </div>
        </div>
    </div>
</div>