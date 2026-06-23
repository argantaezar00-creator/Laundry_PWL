<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="mb-4">
    <h4 class="fw-bold mb-0">Edit Jenis Layanan</h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="/layanan">Layanan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>
</div>

<div class="card card-premium border-0 max-width-md mx-auto" style="max-width: 700px;">
    <div class="card-header-premium">
        <span>Form Edit Layanan</span>
    </div>
    <div class="card-body p-4">
        <!-- Display Validation Errors -->
        <?php $validation = session('validation'); ?>

        <form action="/layanan/update/<?= $layanan['id'] ?>" method="post">
            <?= csrf_field() ?>

            <!-- Nama Layanan -->
            <div class="mb-3">
                <label for="nama_layanan" class="form-label fw-semibold">Nama Layanan <span class="text-danger">*</span></label>
                <input type="text" class="form-control <?= (isset($validation) && $validation->hasError('nama_layanan')) ? 'is-invalid' : '' ?>" id="nama_layanan" name="nama_layanan" value="<?= old('nama_layanan', $layanan['nama_layanan']) ?>" placeholder="Contoh: Cuci Setrika (Komplit)">
                <div class="invalid-feedback">
                    <?= isset($validation) ? $validation->getError('nama_layanan') : '' ?>
                </div>
            </div>

            <div class="row">
                <!-- Harga per Kg -->
                <div class="col-md-6 mb-3">
                    <label for="harga_per_kg" class="form-label fw-semibold">Harga per Kg (Rp) <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" step="0.01" class="form-control <?= (isset($validation) && $validation->hasError('harga_per_kg')) ? 'is-invalid' : '' ?>" id="harga_per_kg" name="harga_per_kg" value="<?= old('harga_per_kg', $layanan['harga_per_kg']) ?>" placeholder="8000">
                    </div>
                    <div class="text-danger small mt-1">
                        <?= isset($validation) ? $validation->getError('harga_per_kg') : '' ?>
                    </div>
                </div>

                <!-- Estimasi Jam -->
                <div class="col-md-6 mb-3">
                    <label for="estimasi_jam" class="form-label fw-semibold">Estimasi Selesai (Jam) <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="number" class="form-control <?= (isset($validation) && $validation->hasError('estimasi_jam')) ? 'is-invalid' : '' ?>" id="estimasi_jam" name="estimasi_jam" value="<?= old('estimasi_jam', $layanan['estimasi_jam']) ?>" placeholder="24">
                        <span class="input-group-text">Jam</span>
                    </div>
                    <div class="text-danger small mt-1">
                        <?= isset($validation) ? $validation->getError('estimasi_jam') : '' ?>
                    </div>
                </div>
            </div>

            <!-- Status -->
            <div class="mb-3">
                <label for="status" class="form-label fw-semibold">Status Layanan <span class="text-danger">*</span></label>
                <select class="form-select <?= (isset($validation) && $validation->hasError('status')) ? 'is-invalid' : '' ?>" id="status" name="status">
                    <option value="aktif" <?= old('status', $layanan['status']) == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                    <option value="nonaktif" <?= old('status', $layanan['status']) == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                </select>
                <div class="invalid-feedback">
                    <?= isset($validation) ? $validation->getError('status') : '' ?>
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="mb-4">
                <label for="deskripsi" class="form-label fw-semibold">Deskripsi / Catatan Tambahan</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Jelaskan detail cakupan layanan laundry..."><?= old('deskripsi', $layanan['deskripsi']) ?></textarea>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="/layanan" class="btn btn-secondary-premium">Batal</a>
                <button type="submit" class="btn btn-premium">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
