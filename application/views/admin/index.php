<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Jumlah Brand</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_produk; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-truck fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Jumlah Unit</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_unit; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-cog fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Unit Sudah Inspeksi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $unit_sudah_inspeksi; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book-open fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Unit Belum Inspeksi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $unit_belum_inspeksi; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->

    <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Unit</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Serial Number</th>
                                    <th>Nama Brand</th>
                                    <th>Tanggal Inspeksi</th>
                                    <th>Status Inspeksi</th>
                                    </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($units as $unit) : ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $unit['serial_number']; ?></td>
                                        <td><?= $unit['nama_produk']; ?></td>
                                        <td><?= $unit['tanggal_inspeksi']; ?></td>
                                        <td>
                                            <?php if ($unit['status_inspection'] == 'Belum Inspeksi'): ?>
                                                <span class="badge badge-danger">Belum Inspeksi</span>
                                            <?php elseif ($unit['status_inspection'] == 'Sudah Inspeksi'): ?>
                                                <span class="badge badge-success">Sudah Inspeksi</span>
                                            <?php else: ?>
                                                <?= htmlspecialchars($unit['status_inspection']); ?> 
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

        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Dashboard Unit</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="unitPieChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-primary"></i> Sudah Inspeksi
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-warning"></i> Belum Inspeksi
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        var ctx = document.getElementById('unitPieChart').getContext('2d');
        var unitSudahInspeksi = <?php echo $unit_sudah_inspeksi; ?>;
        var unitBelumInspeksi = <?php echo $unit_belum_inspeksi; ?>;
        console.log(unitBelumInspeksi)

        var unitPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Sudah Inspeksi', 'Belum Inspeksi'],
                datasets: [{
                    label: 'Unit',
                    data: [unitSudahInspeksi, unitBelumInspeksi],
                    backgroundColor: [
                        'rgba(54, 185, 204, 0.8)',
                        'rgba(255, 205, 86, 0.8)'
                    ],
                    hoverBackgroundColor: [
                        'rgba(54, 185, 204, 1)',
                        'rgba(255, 205, 86, 1)'
                    ],
                    borderColor: 'rgba(78, 115, 223, 1)',
                }],
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                },
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        fontColor: '#333',
                        usePointStyle: true,
                        padding: 20
                    }
                },
                plugins: {
                    labels: {
                        render: 'percentage',
                        fontColor: '#fff',
                        position: 'outside',
                        precision: 0
                    }
                }
            },
        });
    });
</script>