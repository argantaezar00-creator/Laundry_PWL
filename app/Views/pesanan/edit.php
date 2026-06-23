<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="mb-4">
    <h4 class="fw-bold mb-0">Edit Pesanan Laundry</h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="/pesanan">Pesanan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Pesanan</li>
        </ol>
    </nav>
</div>

<div class="row g-4 max-width-lg mx-auto" style="max-width: 900px;">
    <!-- Main Form Column -->
    <div class="col-12 col-md-8">
        <div class="card card-premium border-0">
            <div class="card-header-premium">
                <span>Form Edit Pesanan</span>
            </div>
            <div class="card-body p-4">
                <!-- Display Validation Errors -->
                <?php $validation = session('validation'); ?>

                <form action="/pesanan/update/<?= $pesanan['id'] ?>" method="post" id="formPesanan">
                    <?= csrf_field() ?>

                    <!-- Pilih Pelanggan -->
                    <div class="mb-3">
                        <label for="pelanggan_id" class="form-label fw-semibold">Pilih Pelanggan <span class="text-danger">*</span></label>
                        <select class="form-select <?= (isset($validation) && $validation->hasError('pelanggan_id')) ? 'is-invalid' : '' ?>" id="pelanggan_id" name="pelanggan_id">
                            <option value="">-- Pilih Pelanggan --</option>
                            <?php foreach ($pelanggan as $p): ?>
                                <option value="<?= $p['id'] ?>" <?= old('pelanggan_id', $pesanan['pelanggan_id']) == $p['id'] ? 'selected' : '' ?>><?= esc($p['nama']) ?> - <?= esc($p['telepon']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">
                            <?= isset($validation) ? $validation->getError('pelanggan_id') : '' ?>
                        </div>
                    </div>

                    <!-- Pilih Layanan -->
                    <div class="mb-3">
                        <label for="layanan_id" class="form-label fw-semibold">Pilih Layanan <span class="text-danger">*</span></label>
                        <select class="form-select <?= (isset($validation) && $validation->hasError('layanan_id')) ? 'is-invalid' : '' ?>" id="layanan_id" name="layanan_id">
                            <option value="" data-harga="0">-- Pilih Jenis Layanan --</option>
                            <?php foreach ($layanan as $l): ?>
                                <option value="<?= $l['id'] ?>" data-harga="<?= $l['harga_per_kg'] ?>" data-durasi="<?= $l['estimasi_jam'] ?>" <?= old('layanan_id', $pesanan['layanan_id']) == $l['id'] ? 'selected' : '' ?>>
                                    <?= esc($l['nama_layanan']) ?> (Rp <?= number_format($l['harga_per_kg'], 0, ',', '.') ?>/Kg)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">
                            <?= isset($validation) ? $validation->getError('layanan_id') : '' ?>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Berat (Kg) -->
                        <div class="col-md-6 mb-3">
                            <label for="berat_kg" class="form-label fw-semibold">Berat Pakaian (Kg) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" step="0.01" class="form-control <?= (isset($validation) && $validation->hasError('berat_kg')) ? 'is-invalid' : '' ?>" id="berat_kg" name="berat_kg" value="<?= old('berat_kg', $pesanan['berat_kg']) ?>" placeholder="0.00">
                                <span class="input-group-text">Kg</span>
                            </div>
                            <div class="text-danger small mt-1">
                                <?= isset($validation) ? $validation->getError('berat_kg') : '' ?>
                            </div>
                        </div>

                        <!-- Status Bayar -->
                        <div class="col-md-6 mb-3">
                            <label for="status_bayar" class="form-label fw-semibold">Status Pembayaran <span class="text-danger">*</span></label>
                            <select class="form-select <?= (isset($validation) && $validation->hasError('status_bayar')) ? 'is-invalid' : '' ?>" id="status_bayar" name="status_bayar">
                                <option value="belum" <?= old('status_bayar', $pesanan['status_bayar']) == 'belum' ? 'selected' : '' ?>>Belum Bayar</option>
                                <option value="dp" <?= old('status_bayar', $pesanan['status_bayar']) == 'dp' ? 'selected' : '' ?>>Uang Muka (DP)</option>
                                <option value="lunas" <?= old('status_bayar', $pesanan['status_bayar']) == 'lunas' ? 'selected' : '' ?>>Lunas</option>
                            </select>
                            <div class="invalid-feedback">
                                <?= isset($validation) ? $validation->getError('status_bayar') : '' ?>
                            </div>
                        </div>
                    </div>

                    <!-- Nominal Bayar -->
                    <div class="mb-3" id="nominalBayarContainer">
                        <label for="nominal_bayar" class="form-label fw-semibold">Nominal Uang yang Dibayarkan (Rp)</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" step="0.01" class="form-control <?= (isset($validation) && $validation->hasError('nominal_bayar')) ? 'is-invalid' : '' ?>" id="nominal_bayar" name="nominal_bayar" value="<?= old('nominal_bayar', $pesanan['nominal_bayar']) ?>" placeholder="0">
                        </div>
                        <div class="text-danger small mt-1">
                            <?= isset($validation) ? $validation->getError('nominal_bayar') : '' ?>
                        </div>
                    </div>

                    <!-- Catatan Khusus -->
                    <div class="mb-4">
                        <label for="catatan" class="form-label fw-semibold">Catatan Khusus (Opsional)</label>
                        <textarea class="form-control" id="catatan" name="catatan" rows="3" placeholder="Contoh: Luntur, setrika gantung, lipatan rapi..."><?= old('catatan', $pesanan['catatan']) ?></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="/pesanan/detail/<?= $pesanan['id'] ?>" class="btn btn-secondary-premium">Batal</a>
                        <button type="submit" class="btn btn-premium">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Summary Details Column -->
    <div class="col-12 col-md-4">
        <div class="card card-premium border-0 bg-light-subtle h-100">
            <div class="card-header-premium">
                <span>Rincian Harga</span>
            </div>
            <div class="card-body p-4 d-flex flex-column justify-content-between">
                <div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Harga Layanan:</span>
                        <span class="fw-semibold text-dark" id="disp_harga_per_kg">Rp 0/Kg</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Berat Pakaian:</span>
                        <span class="fw-semibold text-dark" id="disp_berat">0 Kg</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                        <span class="text-muted">Estimasi Pengerjaan:</span>
                        <span class="fw-semibold text-dark" id="disp_durasi">- Jam</span>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="fw-bold text-dark fs-5">Total Bayar:</span>
                        <span class="fw-bold text-primary fs-4" id="disp_total_harga">Rp 0</span>
                    </div>
                </div>

                <div class="alert alert-info border-0 rounded-4 small p-3 mb-0">
                    <i class="fa-solid fa-circle-info me-2 text-info"></i>
                    Merubah jenis layanan atau berat akan mengkalkulasi ulang total tagihan pesanan ini secara otomatis.
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const layananSelect = document.getElementById('layanan_id');
        const beratInput = document.getElementById('berat_kg');
        const statusBayarSelect = document.getElementById('status_bayar');
        const nominalContainer = document.getElementById('nominalBayarContainer');
        const nominalInput = document.getElementById('nominal_bayar');

        // Output fields
        const dispHargaPerKg = document.getElementById('disp_harga_per_kg');
        const dispBerat = document.getElementById('disp_berat');
        const dispDurasi = document.getElementById('disp_durasi');
        const dispTotalHarga = document.getElementById('disp_total_harga');

        function calculateTotal() {
            const selectedOption = layananSelect.options[layananSelect.selectedIndex];
            const price = parseFloat(selectedOption.getAttribute('data-harga')) || 0;
            const duration = selectedOption.getAttribute('data-durasi') || null;
            const weight = parseFloat(beratInput.value) || 0;

            const total = price * weight;

            // Update display card
            dispHargaPerKg.textContent = 'Rp ' + price.toLocaleString('id-ID') + '/Kg';
            dispBerat.textContent = weight.toFixed(2) + ' Kg';
            dispDurasi.textContent = duration ? duration + ' Jam' : '- Jam';
            dispTotalHarga.textContent = 'Rp ' + total.toLocaleString('id-ID');

            // Handling payment field toggling
            const statusBayar = statusBayarSelect.value;
            if (statusBayar === 'dp') {
                nominalContainer.style.display = 'block';
            } else if (statusBayar === 'belum') {
                nominalContainer.style.display = 'none';
                nominalInput.value = 0;
            } else {
                // Lunas
                nominalContainer.style.display = 'none';
                nominalInput.value = total;
            }
        }

        layananSelect.addEventListener('change', calculateTotal);
        beratInput.addEventListener('input', calculateTotal);
        statusBayarSelect.addEventListener('change', calculateTotal);

        // Initial trigger
        calculateTotal();
    });
</script>
<?= $this->endSection() ?>
