<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="mb-4">
    <h4 class="fw-bold mb-0">Laporan Keuangan & Transaksi</h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Laporan</li>
        </ol>
    </nav>
</div>

<!-- Date Filter Card -->
<div class="card card-premium border-0 mb-4">
    <div class="card-body p-4">
        <form action="/laporan" method="get" class="row g-3 align-items-end">
            <!-- Start Date -->
            <div class="col-12 col-md-3">
                <label for="start_date" class="form-label small fw-semibold text-muted">Tanggal Mulai</label>
                <input type="date" class="form-control" id="start_date" name="start_date" value="<?= $start_date ?>">
            </div>

            <!-- End Date -->
            <div class="col-12 col-md-3">
                <label for="end_date" class="form-label small fw-semibold text-muted">Tanggal Selesai</label>
                <input type="date" class="form-control" id="end_date" name="end_date" value="<?= $end_date ?>">
            </div>

            <!-- Layanan Filter -->
            <div class="col-12 col-md-3">
                <label for="layanan_id" class="form-label small fw-semibold text-muted">Filter Jenis Layanan</label>
                <select class="form-select" id="layanan_id" name="layanan_id">
                    <option value="">-- Semua Layanan --</option>
                    <?php foreach ($layanan_list as $lay): ?>
                        <option value="<?= $lay['id'] ?>" <?= $layanan_id == $lay['id'] ? 'selected' : '' ?>><?= esc($lay['nama_layanan']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Actions -->
            <div class="col-12 col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-premium flex-grow-1">
                    <i class="fa-solid fa-sync me-2"></i> Tampilkan
                </button>
                <button type="button" onclick="window.print()" class="btn btn-secondary-premium" title="Print Laporan">
                    <i class="fa-solid fa-print"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Laporan Summaries -->
<div class="row g-4 mb-4">
    <!-- Stat 1: Total Omset (Kontrak) -->
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card card-premium p-3 border-0 h-100 bg-primary bg-opacity-10 text-primary">
            <span class="text-muted fw-medium d-block mb-1">Total Omset Pesanan</span>
            <h4 class="fw-bold mb-0">Rp <?= number_format($summary['total_omset'], 0, ',', '.') ?></h4>
            <small class="text-secondary mt-1 d-block">Nilai total kontrak cucian</small>
        </div>
    </div>

    <!-- Stat 2: Total Pendapatan Masuk -->
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card card-premium p-3 border-0 h-100 bg-success bg-opacity-10 text-success">
            <span class="text-muted fw-medium d-block mb-1">Total Pendapatan Masuk</span>
            <h4 class="fw-bold mb-0">Rp <?= number_format($summary['total_pendapatan'], 0, ',', '.') ?></h4>
            <small class="text-secondary mt-1 d-block">Uang kas masuk yang diterima</small>
        </div>
    </div>

    <!-- Stat 3: Total Berat Cucian -->
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card card-premium p-3 border-0 h-100 bg-info bg-opacity-10 text-info">
            <span class="text-muted fw-medium d-block mb-1">Berat Total Cucian</span>
            <h4 class="fw-bold mb-0"><?= number_format($summary['total_berat'], 2, ',', '.') ?> Kg</h4>
            <small class="text-secondary mt-1 d-block">Beban kerja mesin cuci</small>
        </div>
    </div>

    <!-- Stat 4: Total Transaksi -->
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card card-premium p-3 border-0 h-100 bg-warning bg-opacity-10 text-warning">
            <span class="text-muted fw-medium d-block mb-1">Total Transaksi</span>
            <h4 class="fw-bold mb-0"><?= $summary['total_transaksi'] ?> Nota</h4>
            <small class="text-secondary mt-1 d-block"><?= $summary['total_selesai'] ?> Selesai diserahkan</small>
        </div>
    </div>
</div>

<!-- Laporan Table -->
<div class="card card-premium border-0 mb-4 print-section">
    <div class="card-header-premium d-flex justify-content-between align-items-center">
        <span>Tabel Transaksi Periode: <?= date('d M Y', strtotime($start_date)) ?> s/d <?= date('d M Y', strtotime($end_date)) ?></span>
        <i class="fa-solid fa-file-lines text-muted"></i>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">No</th>
                        <th>Tanggal</th>
                        <th>Kode Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Layanan Paket</th>
                        <th>Berat (Kg)</th>
                        <th>Total Tagihan</th>
                        <th>Uang Diterima</th>
                        <th>Status SOP</th>
                        <th class="pe-4">Status Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($laporan)): ?>
                        <tr>
                            <td colspan="10" class="text-center py-5 text-muted">
                                Tidak ada transaksi terdaftar pada periode tanggal yang dipilih.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($laporan as $row): ?>
                            <tr>
                                <td class="ps-4"><?= $no++ ?></td>
                                <td><?= date('d/m/Y', strtotime($row['tgl_masuk'])) ?></td>
                                <td class="fw-bold text-primary"><?= $row['kode_pesanan'] ?></td>
                                <td class="fw-semibold"><?= esc($row['nama_pelanggan']) ?></td>
                                <td><?= esc($row['nama_layanan']) ?></td>
                                <td><?= $row['berat_kg'] ?> Kg</td>
                                <td>Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                                <td class="text-success fw-semibold">Rp <?= number_format($row['nominal_bayar'], 0, ',', '.') ?></td>
                                <td>
                                    <span class="badge badge-sop badge-<?= $row['status_sop'] ?>">
                                        <?= str_replace('_', ' ', $row['status_sop']) ?>
                                    </span>
                                </td>
                                <td class="pe-4">
                                    <span class="badge badge-sop badge-<?= $row['status_bayar'] ?>">
                                        <?= $row['status_bayar'] ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .print-section, .print-section * {
            visibility: visible;
        }
        .print-section {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
    }
</style>
<?= $this->endSection() ?>
