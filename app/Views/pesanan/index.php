<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Pesanan Laundry</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pesanan</li>
            </ol>
        </nav>
    </div>
    <a href="/pesanan/create" class="btn btn-premium">
        <i class="fa-solid fa-cart-plus me-2"></i> Buat Pesanan Baru
    </a>
</div>

<!-- Filter Card -->
<div class="card card-premium border-0 mb-4">
    <div class="card-body p-4">
        <form action="/pesanan" method="get" class="row g-3 align-items-end">
            <!-- SOP Status Filter -->
            <div class="col-12 col-md-4">
                <label for="status_sop" class="form-label small fw-semibold text-muted">Filter Status SOP</label>
                <select class="form-select" id="status_sop" name="status_sop">
                    <option value="">-- Semua Status SOP --</option>
                    <option value="masuk" <?= $status_sop == 'masuk' ? 'selected' : '' ?>>Order Masuk</option>
                    <option value="timbang" <?= $status_sop == 'timbang' ? 'selected' : '' ?>>Ditimbang</option>
                    <option value="cuci" <?= $status_sop == 'cuci' ? 'selected' : '' ?>>Proses Cuci</option>
                    <option value="setrika" <?= $status_sop == 'setrika' ? 'selected' : '' ?>>Setrika Selesai</option>
                    <option value="kemas" <?= $status_sop == 'kemas' ? 'selected' : '' ?>>Pengemasan</option>
                    <option value="siap_ambil" <?= $status_sop == 'siap_ambil' ? 'selected' : '' ?>>Siap Ambil</option>
                    <option value="selesai" <?= $status_sop == 'selesai' ? 'selected' : '' ?>>Selesai / Diambil</option>
                </select>
            </div>

            <!-- Payment Status Filter -->
            <div class="col-12 col-md-4">
                <label for="status_bayar" class="form-label small fw-semibold text-muted">Filter Status Bayar</label>
                <select class="form-select" id="status_bayar" name="status_bayar">
                    <option value="">-- Semua Status Bayar --</option>
                    <option value="belum" <?= $status_bayar == 'belum' ? 'selected' : '' ?>>Belum Bayar</option>
                    <option value="dp" <?= $status_bayar == 'dp' ? 'selected' : '' ?>>DP (Uang Muka)</option>
                    <option value="lunas" <?= $status_bayar == 'lunas' ? 'selected' : '' ?>>Lunas</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="col-12 col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-premium flex-grow-1">
                    <i class="fa-solid fa-filter me-2"></i> Filter
                </button>
                <a href="/pesanan" class="btn btn-secondary-premium">
                    <i class="fa-solid fa-rotate-left"></i>
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Orders Table -->
<div class="card card-premium border-0 mb-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Kode Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Layanan</th>
                        <th>Berat (Kg)</th>
                        <th>Total Harga</th>
                        <th>Tgl Masuk</th>
                        <th>Status SOP</th>
                        <th>Pembayaran</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pesanan)): ?>
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-folder-open fs-2 d-block mb-3"></i>
                                Tidak ditemukan data pesanan yang sesuai filter.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($pesanan as $o): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-primary"><?= $o['kode_pesanan'] ?></td>
                                <td class="fw-semibold"><?= esc($o['nama_pelanggan']) ?></td>
                                <td><?= esc($o['nama_layanan']) ?></td>
                                <td><?= $o['berat_kg'] ?> Kg</td>
                                <td>Rp <?= number_format($o['total_harga'], 0, ',', '.') ?></td>
                                <td><?= date('d M Y', strtotime($o['tgl_masuk'])) ?></td>
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
                                    <div class="d-flex justify-content-end gap-1">
                                        <a href="/pesanan/detail/<?= $o['id'] ?>" class="btn btn-sm btn-outline-primary rounded-3" title="Detail / SOP Tracking">
                                            <i class="fa-solid fa-eye me-1"></i> Detail
                                        </a>
                                        <a href="/pesanan/edit/<?= $o['id'] ?>" class="btn btn-sm btn-light border rounded-3" title="Edit Pesanan">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                        <form action="/pesanan/delete/<?= $o['id'] ?>" method="post" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pesanan ini dari sistem?');">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-sm btn-light text-danger border rounded-3" title="Hapus">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
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
