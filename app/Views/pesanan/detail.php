<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Rincian & Pelacakan Pesanan</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/pesanan">Pesanan</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $pesanan['kode_pesanan'] ?></li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2">
        <a href="/pesanan/struk/<?= $pesanan['id'] ?>" target="_blank" class="btn btn-secondary-premium">
            <i class="fa-solid fa-print me-2"></i> Cetak Struk
        </a>
        <a href="/pesanan/edit/<?= $pesanan['id'] ?>" class="btn btn-outline-primary rounded-3 px-3">
            <i class="fa-solid fa-pencil me-1"></i> Edit Pesanan
        </a>
    </div>
</div>

<!-- SOP Stepper Pipeline -->
<div class="card card-premium border-0 mb-4">
    <div class="card-header-premium">
        <span>Standard Operating Procedure (SOP) Tracking</span>
    </div>
    <div class="card-body p-4">
        <div class="row g-2 justify-content-between position-relative">
            <!-- Background progress line -->
            <div class="position-absolute top-50 start-0 translate-y-middle w-100 d-none d-lg-block" style="height: 4px; background-color: #e2e8f0; z-index: 1;"></div>
            
            <?php 
                $keys = array_keys($sop_steps);
                $currentIndex = array_search($pesanan['status_sop'], $keys);
            ?>

            <?php foreach ($sop_steps as $key => $step): ?>
                <?php 
                    $index = array_search($key, $keys);
                    $isActive = $index <= $currentIndex;
                    $isCurrent = $key == $pesanan['status_sop'];
                    
                    $colorClass = 'text-muted bg-white border';
                    $lineColor = '#e2e8f0';
                    if ($isActive) {
                        $colorClass = 'text-white bg-primary border-primary';
                        if ($key == 'selesai') {
                            $colorClass = 'text-white bg-success border-success';
                        }
                    }
                    if ($isCurrent) {
                        $colorClass = 'text-white bg-warning border-warning shadow';
                    }
                ?>
                <div class="col-12 col-lg text-center d-flex d-lg-block align-items-center gap-3 mb-2 mb-lg-0" style="z-index: 2;">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mx-lg-auto mb-lg-2 <?= $colorClass ?>" style="width: 45px; height: 45px; font-size: 1.1rem;">
                        <i class="fa-solid <?= $step['icon'] ?>"></i>
                    </div>
                    <div>
                        <div class="small fw-bold text-dark"><?= $step['label'] ?></div>
                        <div class="text-muted" style="font-size: 0.75rem;">
                            <?php if ($isCurrent): ?>
                                <span class="badge bg-warning text-dark px-2">Sedang Diproses</span>
                            <?php elseif ($isActive): ?>
                                <span class="text-success fw-semibold"><i class="fa-solid fa-check"></i> Selesai</span>
                            <?php else: ?>
                                <span class="text-secondary">Menunggu</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Left Column: Details -->
    <div class="col-12 col-md-7">
        <!-- Details Card -->
        <div class="card card-premium border-0 mb-4">
            <div class="card-header-premium">
                <span>Informasi Transaksi</span>
            </div>
            <div class="card-body p-4">
                <table class="table table-borderless align-middle mb-0">
                    <tbody>
                        <tr>
                            <td class="text-muted ps-0" width="35%">Kode Pesanan</td>
                            <td class="fw-bold text-primary">: <?= $pesanan['kode_pesanan'] ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted ps-0">Nama Pelanggan</td>
                            <td class="fw-semibold text-dark">: <?= esc($pesanan['nama_pelanggan']) ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted ps-0">Nomor Telepon</td>
                            <td>: 
                                <a href="https://wa.me/<?= str_replace(['+', '-', ' '], '', $pesanan['telepon']) ?>" target="_blank" class="text-decoration-none text-success">
                                    <i class="fa-brands fa-whatsapp me-1"></i> <?= esc($pesanan['telepon']) ?>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted ps-0">Alamat Pelanggan</td>
                            <td class="small text-secondary">: <?= esc($pesanan['alamat']) ?></td>
                        </tr>
                        <tr class="border-top">
                            <td class="text-muted ps-0 pt-2">Layanan Paket</td>
                            <td class="fw-semibold text-dark pt-2">: <?= esc($pesanan['nama_layanan']) ?> (Rp <?= number_format($pesanan['harga_per_kg'], 0, ',', '.') ?>/Kg)</td>
                        </tr>
                        <tr>
                            <td class="text-muted ps-0">Berat Cucian</td>
                            <td class="fw-semibold text-dark">: <?= $pesanan['berat_kg'] ?> Kg</td>
                        </tr>
                        <tr>
                            <td class="text-muted ps-0">Total Tagihan</td>
                            <td class="fw-bold text-danger fs-5">: Rp <?= number_format($pesanan['total_harga'], 0, ',', '.') ?></td>
                        </tr>
                        <tr class="border-top">
                            <td class="text-muted ps-0 pt-2">Tanggal Masuk</td>
                            <td class="text-dark pt-2">: <?= date('d F Y', strtotime($pesanan['tgl_masuk'])) ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted ps-0">Estimasi Selesai</td>
                            <td class="text-dark">: <?= date('d F Y', strtotime($pesanan['tgl_estimasi'])) ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted ps-0">Tanggal Selesai SOP</td>
                            <td class="text-dark">: <?= $pesanan['tgl_selesai'] ? date('d F Y', strtotime($pesanan['tgl_selesai'])) : '-' ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted ps-0">Catatan Khusus</td>
                            <td class="text-warning fw-semibold">: <?= esc($pesanan['catatan']) ?: '-' ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- History Log Card -->
        <div class="card card-premium border-0 mb-4">
            <div class="card-header-premium">
                <span>Log Riwayat Operasional SOP</span>
            </div>
            <div class="card-body p-4">
                <div class="timeline">
                    <?php if (empty($riwayat)): ?>
                        <p class="text-muted small">Belum ada riwayat pergerakan status.</p>
                    <?php else: ?>
                        <div class="d-flex flex-column gap-3">
                            <?php foreach ($riwayat as $r): ?>
                                <div class="d-flex gap-3 position-relative">
                                    <div class="text-center">
                                        <div class="rounded-circle bg-secondary bg-opacity-25" style="width: 12px; height: 12px; margin-top: 5px;"></div>
                                    </div>
                                    <div>
                                        <div class="fw-bold small text-dark">
                                            Status: 
                                            <span class="badge badge-sop badge-<?= $r['status_baru'] ?>">
                                                <?= str_replace('_', ' ', $r['status_baru']) ?>
                                            </span>
                                        </div>
                                        <div class="text-muted small"><?= esc($r['catatan']) ?></div>
                                        <div class="text-secondary" style="font-size: 0.7rem;"><i class="fa-solid fa-clock me-1"></i> <?= date('d M Y - H:i', strtotime($r['created_at'])) ?> WIB</div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Update status & payments -->
    <div class="col-12 col-md-5">
        <!-- Update SOP Status -->
        <div class="card card-premium border-0 mb-4">
            <div class="card-header-premium">
                <span>Update Status Operasional (SOP)</span>
            </div>
            <div class="card-body p-4">
                <form action="/pesanan/update-status/<?= $pesanan['id'] ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="status_sop_update" class="form-label fw-semibold">Pilih Tahap SOP Selanjutnya</label>
                        <select class="form-select" id="status_sop_update" name="status_sop">
                            <option value="masuk" <?= $pesanan['status_sop'] == 'masuk' ? 'selected' : '' ?>>Order Masuk (Penerimaan)</option>
                            <option value="timbang" <?= $pesanan['status_sop'] == 'timbang' ? 'selected' : '' ?>>Ditimbang & Sortir</option>
                            <option value="cuci" <?= $pesanan['status_sop'] == 'cuci' ? 'selected' : '' ?>>Proses Cuci & Kering</option>
                            <option value="setrika" <?= $pesanan['status_sop'] == 'setrika' ? 'selected' : '' ?>>Setrika Selesai</option>
                            <option value="kemas" <?= $pesanan['status_sop'] == 'kemas' ? 'selected' : '' ?>>Pengemasan & Labeling</option>
                            <option value="siap_ambil" <?= $pesanan['status_sop'] == 'siap_ambil' ? 'selected' : '' ?>>Siap Ambil di Rak</option>
                            <option value="selesai" <?= $pesanan['status_sop'] == 'selesai' ? 'selected' : '' ?>>Selesai Diserahkan (Closed)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="catatan_sop" class="form-label fw-semibold">Catatan Proses</label>
                        <textarea class="form-control" id="catatan_sop" name="catatan" rows="2" placeholder="Masukkan catatan pengerjaan (misal: Selesai setrika, dimasukkan ke rak A)..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-premium w-100">
                        <i class="fa-solid fa-circle-chevron-right me-2"></i> Perbarui Status SOP
                    </button>
                </form>
            </div>
        </div>

        <!-- Update Payment -->
        <div class="card card-premium border-0">
            <div class="card-header-premium">
                <span>Status Pembayaran & Keuangan</span>
            </div>
            <div class="card-body p-4">
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">Status Saat Ini:</span>
                        <span class="badge badge-sop badge-<?= $pesanan['status_bayar'] ?> fs-6">
                            <?= strtoupper($pesanan['status_bayar']) ?>
                        </span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">Sudah Dibayar:</span>
                        <span class="fw-bold text-success">Rp <?= number_format($pesanan['nominal_bayar'], 0, ',', '.') ?></span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-0">
                        <span class="text-muted">Sisa Tagihan:</span>
                        <?php $sisa = $pesanan['total_harga'] - $pesanan['nominal_bayar']; ?>
                        <span class="fw-bold text-<?= $sisa > 0 ? 'danger' : 'success' ?>">
                            Rp <?= number_format($sisa, 0, ',', '.') ?>
                        </span>
                    </div>
                </div>

                <form action="/pesanan/update-pembayaran/<?= $pesanan['id'] ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="status_bayar_update" class="form-label fw-semibold">Update Status Bayar</label>
                        <select class="form-select" id="status_bayar_update" name="status_bayar">
                            <option value="belum" <?= $pesanan['status_bayar'] == 'belum' ? 'selected' : '' ?>>Belum Bayar</option>
                            <option value="dp" <?= $pesanan['status_bayar'] == 'dp' ? 'selected' : '' ?>>Uang Muka (DP)</option>
                            <option value="lunas" <?= $pesanan['status_bayar'] == 'lunas' ? 'selected' : '' ?>>Lunas</option>
                        </select>
                    </div>
                    <div class="mb-3" id="nominalContainerUpdate" style="display: <?= $pesanan['status_bayar'] == 'dp' ? 'block' : 'none' ?>;">
                        <label for="nominal_bayar_update" class="form-label fw-semibold">Nominal Bayar (Rp)</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" step="0.01" class="form-control" id="nominal_bayar_update" name="nominal_bayar" value="<?= $pesanan['nominal_bayar'] ?>">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-secondary-premium w-100">
                        <i class="fa-solid fa-wallet me-2"></i> Perbarui Pembayaran
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const select = document.getElementById('status_bayar_update');
        const container = document.getElementById('nominalContainerUpdate');
        const input = document.getElementById('nominal_bayar_update');
        const totalHarga = <?= $pesanan['total_harga'] ?>;

        select.addEventListener('change', function () {
            if (this.value === 'dp') {
                container.style.display = 'block';
            } else if (this.value === 'belum') {
                container.style.display = 'none';
                input.value = 0;
            } else {
                container.style.display = 'none';
                input.value = totalHarga;
            }
        });
    });
</script>
<?= $this->endSection() ?>
