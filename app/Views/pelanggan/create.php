<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="mb-4">
    <h4 class="fw-bold mb-0">Tambah Pelanggan Baru</h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="/pelanggan">Pelanggan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah</li>
        </ol>
    </nav>
</div>

<div class="card card-premium border-0 max-width-md mx-auto" style="max-width: 700px;">
    <div class="card-header-premium">
        <span>Form Data Pelanggan</span>
    </div>
    <div class="card-body p-4">
        <!-- Display Validation Errors -->
        <?php $validation = session('validation'); ?>

        <form action="/pelanggan/store" method="post">
            <?= csrf_field() ?>

            <!-- Nama Pelanggan -->
            <div class="mb-3">
                <label for="nama" class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" class="form-control <?= (isset($validation) && $validation->hasError('nama')) ? 'is-invalid' : '' ?>" id="nama" name="nama" value="<?= old('nama') ?>" placeholder="Contoh: Ahmad Fauzi">
                <div class="invalid-feedback">
                    <?= isset($validation) ? $validation->getError('nama') : '' ?>
                </div>
            </div>

            <!-- Nomor Telepon -->
            <div class="mb-3">
                <label for="telepon" class="form-label fw-semibold">Nomor Telepon (WhatsApp) <span class="text-danger">*</span></label>
                <input type="text" class="form-control <?= (isset($validation) && $validation->hasError('telepon')) ? 'is-invalid' : '' ?>" id="telepon" name="telepon" value="<?= old('telepon') ?>" placeholder="Contoh: 081234567890">
                <div class="invalid-feedback">
                    <?= isset($validation) ? $validation->getError('telepon') : '' ?>
                </div>
            </div>

            <!-- Alamat -->
            <div class="mb-4">
                <label for="alamat" class="form-label fw-semibold">Alamat Lengkap <span class="text-danger">*</span></label>
                <textarea class="form-control <?= (isset($validation) && $validation->hasError('alamat')) ? 'is-invalid' : '' ?>" id="alamat" name="alamat" rows="4" placeholder="Tulis alamat penjemputan/pengantaran pakaian..."><?= old('alamat') ?></textarea>
                <div class="invalid-feedback">
                    <?= isset($validation) ? $validation->getError('alamat') : '' ?>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="/pelanggan" class="btn btn-secondary-premium">Batal</a>
                <button type="submit" class="btn btn-premium">Simpan Pelanggan</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
