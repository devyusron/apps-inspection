<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Template</h6>
                </div>
                <div class="card-body">
                    <form action="<?= site_url('inspection/update_template'); ?>" method="post">
                        <input type="hidden" name="id_template" value="<?= $inspection_template['id_template']; ?>">
                        <div class="form-group">
                            <label for="nama_template">Template Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama_template" name="nama_template" value="<?= htmlspecialchars($inspection_template['nama_template']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="deskripsi_template">Description</label>
                            <textarea class="form-control" id="deskripsi_template" name="deskripsi_template"><?= htmlspecialchars($inspection_template['deskripsi_template']); ?></textarea>
                        </div>
                         <div class="form-group">
                            <label for="created_by">Created By</label>
                            <input type="text" class="form-control" id="created_by" name="created_by"  value="<?= htmlspecialchars($inspection_template['created_by']); ?>">
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="<?= site_url('inspection/index_template'); ?>" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>