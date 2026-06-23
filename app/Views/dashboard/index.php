<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="row g-4 mb-4">
    <!-- Stat 1 -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card card-premium p-3 border-0 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fw-medium d-block mb-1">Pesanan Hari Ini</span>
                    <h3 class="fw-bold mb-0 text-primary"><?= $stats['total_hari_ini'] ?></h3>
                </div>
                <div class="p-3 bg-primary bg-opacity-10 text-primary rounded-4">
                    <i class="fa-solid fa-file-signature fs-4"></i>
                </div>
            </div>
        </div>
    </div>
    <!-- Stat 2 -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card card-premium p-3 border-0 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fw-medium d-block mb-1">Selesai Hari Ini</span>
                    <h3 class="fw-bold mb-0 text-success"><?= $stats['selesai_hari_ini'] ?></h3>
                </div>
                <div class="p-3 bg-success bg-opacity-10 text-success rounded-4">
                    <i class="fa-solid fa-circle-check fs-4"></i>
                </div>
            </div>
        </div>
    </div>
    <!-- Stat 3 -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card card-premium p-3 border-0 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fw-medium d-block mb-1">Pendapatan Hari Ini</span>
                    <h3 class="fw-bold mb-0 text-warning">Rp <?= number_format($stats['pendapatan'], 0, ',', '.') ?></h3>
                </div>
                <div class="p-3 bg-warning bg-opacity-10 text-warning rounded-4">
                    <i class="fa-solid fa-money-bill-wave fs-4"></i>
                </div>
            </div>
        </div>
    </div>
    <!-- Stat 4 -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card card-premium p-3 border-0 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fw-medium d-block mb-1">Total Pelanggan</span>
                    <h3 class="fw-bold mb-0 text-info"><?= $stats['total_pelanggan'] ?></h3>
                </div>
                <div class="p-3 bg-info bg-opacity-10 text-info rounded-4">
                    <i class="fa-solid fa-users fs-4"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Chart Column -->
    <div class="col-12 col-lg-8">
        <div class="card card-premium border-0 h-100">
            <div class="card-header-premium d-flex justify-content-between align-items-center">
                <span>Grafik Transaksi Laundry (7 Hari Terakhir)</span>
                <i class="fa-solid fa-chart-area text-muted"></i>
            </div>
            <div class="card-body p-4">
                <canvas id="laundryChart" height="280"></canvas>
            </div>
        </div>
    </div>

    <!-- Quick SOP Actions or Overview -->
    <div class="col-12 col-lg-4">
        <div class="card card-premium border-0 h-100">
            <div class="card-header-premium">
                <span>Operasional Laundry (SOP)</span>
            </div>
            <div class="card-body p-4">
                <p class="text-muted mb-4 small">Alur status pengerjaan laundry pelanggan berdasarkan Standard Operating Procedure.</p>
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <span class="badge badge-sop badge-masuk">1</span>
                        <div class="small fw-semibold">Order Masuk (Penerimaan)</div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <span class="badge badge-sop badge-timbang">2</span>
                        <div class="small fw-semibold">Proses Timbang & Sortir</div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <span class="badge badge-sop badge-cuci">3</span>
                        <div class="small fw-semibold">Cuci & Pengeringan</div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <span class="badge badge-sop badge-setrika">4</span>
                        <div class="small fw-semibold">Penyetrikaan Rapi</div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <span class="badge badge-sop badge-kemas">5</span>
                        <div class="small fw-semibold">Kemas & Labeling</div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <span class="badge badge-sop badge-siap_ambil">6</span>
                        <div class="small fw-semibold">Siap Ambil di Rak</div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <span class="badge badge-sop badge-selesai">7</span>
                        <div class="small fw-semibold">Selesai diserahkan</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Latest Orders Table -->
<div class="card card-premium border-0 mb-4">
    <div class="card-header-premium d-flex justify-content-between align-items-center">
        <span>Pesanan Terbaru</span>
        <a href="/pesanan" class="btn btn-sm btn-outline-primary rounded-3">Lihat Semua</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Kode</th>
                        <th>Pelanggan</th>
                        <th>Layanan</th>
                        <th>Berat (Kg)</th>
                        <th>Total Harga</th>
                        <th>Status SOP</th>
                        <th>Status Bayar</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($latest_orders)): ?>
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">Belum ada data pesanan.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($latest_orders as $o): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-primary"><?= $o['kode_pesanan'] ?></td>
                                <td><?= esc($o['nama_pelanggan']) ?></td>
                                <td><?= esc($o['nama_layanan']) ?></td>
                                <td><?= $o['berat_kg'] ?> Kg</td>
                                <td>Rp <?= number_format($o['total_harga'], 0, ',', '.') ?></td>
                                <td>
                                    <span class="badge badge-sop badge-<?= $o['status_sop'] ?>">
                                        <?= str_replace('_', ' ', $o['status_sop']) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-sop badge-<?= $o['status_bayar'] ?>">
                                        <?= $o['status_bayar'] ?>
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <a href="/pesanan/detail/<?= $o['id'] ?>" class="btn btn-sm btn-light border-0 rounded-circle text-primary" title="Detail">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('laundryChart').getContext('2d');
        
        // Data generated from Backend controller Dashboard
        const chartLabels = <?= json_encode($chart['labels']) ?>;
        const chartOrders = <?= json_encode($chart['orders']) ?>;
        const chartRevenue = <?= json_encode($chart['revenue']) ?>;

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartLabels,
                datasets: [
                    {
                        label: 'Pendapatan (Rp)',
                        data: chartRevenue,
                        backgroundColor: 'rgba(79, 70, 229, 0.75)',
                        borderColor: '#4f46e5',
                        borderWidth: 1,
                        borderRadius: 6,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Jumlah Pesanan',
                        data: chartOrders,
                        type: 'line',
                        backgroundColor: '#10b981',
                        borderColor: '#10b981',
                        borderWidth: 3,
                        pointRadius: 4,
                        tension: 0.3,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        grid: {
                            color: '#f1f5f9'
                        },
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        grid: {
                            drawOnChartArea: false
                        },
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            boxWidth: 12,
                            font: {
                                family: "'Outfit', sans-serif"
                            }
                        }
                    }
                }
            }
        });
    });
</script>
<?= $this->endSection() ?>
