<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Kelola Jenis Layanan</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Layanan</li>
            </ol>
        </nav>
    </div>
    <a href="/layanan/create" class="btn btn-premium">
        <i class="fa-solid fa-plus me-2"></i> Tambah Layanan
    </a>
</div>

<div class="card card-premium border-0 mb-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4" width="5%">No</th>
                        <th>Nama Layanan</th>
                        <th>Harga / Kg</th>
                        <th>Estimasi Waktu</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                        <th class="text-end pe-4" width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($layanan)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Belum ada data jenis layanan. Silakan buat baru.</td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($layanan as $l): ?>
                            <tr>
                                <td class="ps-4"><?= $no++ ?></td>
                                <td class="fw-bold"><?= esc($l['nama_layanan']) ?></td>
                                <td class="text-success fw-semibold">Rp <?= number_format($l['harga_per_kg'], 0, ',', '.') ?></td>
                                <td><?= esc($l['estimasi_jam']) ?> Jam</td>
                                <td><span class="text-muted small"><?= esc($l['deskripsi']) ?: '-' ?></span></td>
                                <td>
                                    <?php if ($l['status'] == 'aktif'): ?>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 rounded">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="/layanan/edit/<?= $l['id'] ?>" class="btn btn-sm btn-outline-primary rounded-3">
                                            <i class="fa-solid fa-pencil me-1"></i> Edit
                                        </a>
                                        <form action="/layanan/delete/<?= $l['id'] ?>" method="post" onsubmit="return confirm('Apakah Anda yakin ingin menghapus layanan ini?');">
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
