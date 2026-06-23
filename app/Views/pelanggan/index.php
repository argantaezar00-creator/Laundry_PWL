<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Kelola Data Pelanggan</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pelanggan</li>
            </ol>
        </nav>
    </div>
    <a href="/pelanggan/create" class="btn btn-premium">
        <i class="fa-solid fa-user-plus me-2"></i> Tambah Pelanggan
    </a>
</div>

<div class="card card-premium border-0 mb-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4" width="5%">No</th>
                        <th>Nama Pelanggan</th>
                        <th>Nomor Telepon</th>
                        <th>Alamat Lengkap</th>
                        <th>Jumlah Pesanan</th>
                        <th>Total Transaksi</th>
                        <th class="text-end pe-4" width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pelanggan)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Belum ada data pelanggan. Silakan buat baru.</td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($pelanggan as $p): ?>
                            <tr>
                                <td class="ps-4"><?= $no++ ?></td>
                                <td class="fw-bold text-dark"><?= esc($p['nama']) ?></td>
                                <td>
                                    <a href="https://wa.me/<?= str_replace(['+', '-', ' '], '', $p['telepon']) ?>" target="_blank" class="text-decoration-none text-success">
                                        <i class="fa-brands fa-whatsapp me-1"></i> <?= esc($p['telepon']) ?>
                                    </a>
                                </td>
                                <td><span class="text-muted small"><?= esc($p['alamat']) ?: '-' ?></span></td>
                                <td><span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1 rounded"><?= $p['total_orders'] ?> Pesanan</span></td>
                                <td class="fw-semibold text-primary">Rp <?= number_format($p['total_spend'], 0, ',', '.') ?></td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="/pelanggan/edit/<?= $p['id'] ?>" class="btn btn-sm btn-outline-primary rounded-3">
                                            <i class="fa-solid fa-pencil me-1"></i> Edit
                                        </a>
                                        <form action="/pelanggan/delete/<?= $p['id'] ?>" method="post" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pelanggan ini? Seluruh data riwayat pesanan pelanggan ini juga mungkin terdampak.');">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-3">
                                                <i class="fa-solid fa-trash me-1"></i> Hapus
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
