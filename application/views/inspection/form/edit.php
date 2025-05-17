<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="row">
        <div class="col-lg-8">
            <form action="<?= base_url('inspection/update_form'); ?>" method="post">
                <input type="hidden" name="id_template" value="<?= $inspection_template['id_template']; ?>">
                <div class="form-group">
                    <label for="nama_template">Nama Form</label>
                    <input type="text" class="form-control" id="nama_template" name="nama_template" value="<?= $inspection_template['nama_template']; ?>">
                </div>
                <div class="form-group">
                    <label for="deskripsi_template">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi_template" name="deskripsi_template"><?= $inspection_template['deskripsi_template']; ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Update Form</button>
                <a href="<?= base_url('inspection/index_form'); ?>" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>