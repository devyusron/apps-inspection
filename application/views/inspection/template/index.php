<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <?php if ($this->session->flashdata('message')) : ?>
        <div class="alert alert-success"><?= $this->session->flashdata('message'); ?></div>
    <?php endif; ?>
     <?php if ($this->session->flashdata('error')) : ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Inspection Templates</h6>
            <?php if($this->session->userdata('role_id') == '1') : ?>
            <a href="<?= site_url('inspection/create_template'); ?>" class="btn btn-success"><i class="fas fa-plus"></i> Add Template</a>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Template Name</th>
                            <th>Description</th>
                            <th>Created At</th>
                            <th>Created By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($inspection_templates as $template) : ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= htmlspecialchars($template['nama_template']); ?></td>
                                <td><?= htmlspecialchars($template['deskripsi_template']); ?></td>
                                <td><?= $template['created_at']; ?></td>
                                 <td><?= htmlspecialchars($template['created_by']); ?></td>
                                <td>
                                    <?php if($this->session->userdata('role_id') == '1') : ?>
                                    <a href="<?= site_url('inspection/edit_template/' . $template['id_template']); ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                    <a href="<?= site_url('inspection/delete_template/' . $template['id_template']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i> Delete</a>
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