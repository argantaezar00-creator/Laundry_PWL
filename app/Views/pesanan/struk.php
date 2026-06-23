<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk_<?= $pesanan['kode_pesanan'] ?></title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            width: 280px; /* Thermal printer width */
            margin: 0 auto;
            padding: 10px;
            font-size: 12px;
            color: #000;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .bold {
            font-weight: bold;
        }
        .divider {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            padding: 2px 0;
            vertical-align: top;
        }
        .footer {
            margin-top: 20px;
            font-size: 10px;
        }
        @media print {
            body {
                width: 100%;
                padding: 0;
                margin: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>

    <div class="no-print" style="margin-bottom: 20px; text-align: center;">
        <button onclick="window.print()" style="padding: 5px 15px; cursor: pointer;">Cetak Struk (Print)</button>
        <button onclick="window.close()" style="padding: 5px 15px; cursor: pointer; margin-left: 10px;">Tutup</button>
    </div>

    <!-- Receipt Contents -->
    <div class="text-center">
        <h3 style="margin: 0 0 5px 0;">LAUNDRY PRO</h3>
        <p style="margin: 0; font-size: 10px;">Ruko Clean & Fresh Blok A5</p>
        <p style="margin: 0; font-size: 10px;">Telp: 0812-9999-8888</p>
    </div>

    <div class="divider"></div>

    <!-- Order Metadata -->
    <table>
        <tr>
            <td>No. Struk</td>
            <td class="text-right bold"><?= $pesanan['kode_pesanan'] ?></td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td class="text-right"><?= date('d/m/Y H:i', strtotime($pesanan['created_at'])) ?></td>
        </tr>
        <tr>
            <td>Pelanggan</td>
            <td class="text-right"><?= esc($pesanan['nama_pelanggan']) ?></td>
        </tr>
        <tr>
            <td>HP</td>
            <td class="text-right"><?= esc($pesanan['telepon']) ?></td>
        </tr>
    </table>

    <div class="divider"></div>

    <!-- Items and costs -->
    <table>
        <tr>
            <td class="bold">Layanan</td>
            <td class="text-right bold">Total</td>
        </tr>
        <tr>
            <td>
                <?= esc($pesanan['nama_layanan']) ?><br>
                <?= $pesanan['berat_kg'] ?> Kg x Rp <?= number_format($pesanan['harga_per_kg'], 0, ',', '.') ?>
            </td>
            <td class="text-right" style="vertical-align: bottom;">
                Rp <?= number_format($pesanan['total_harga'], 0, ',', '.') ?>
            </td>
        </tr>
    </table>

    <div class="divider"></div>

    <!-- Payments -->
    <table>
        <tr>
            <td class="bold">Total Tagihan</td>
            <td class="text-right bold">Rp <?= number_format($pesanan['total_harga'], 0, ',', '.') ?></td>
        </tr>
        <tr>
            <td>Dibayarkan (<?= strtoupper($pesanan['status_bayar']) ?>)</td>
            <td class="text-right">Rp <?= number_format($pesanan['nominal_bayar'], 0, ',', '.') ?></td>
        </tr>
        <?php $sisa = $pesanan['total_harga'] - $pesanan['nominal_bayar']; ?>
        <?php if ($sisa > 0): ?>
            <tr>
                <td class="bold text-danger">Sisa Tagihan</td>
                <td class="text-right bold">Rp <?= number_format($sisa, 0, ',', '.') ?></td>
            </tr>
        <?php endif; ?>
    </table>

    <div class="divider"></div>

    <!-- Estimates -->
    <table>
        <tr>
            <td>Estimasi Selesai</td>
            <td class="text-right"><?= date('d/m/Y', strtotime($pesanan['tgl_estimasi'])) ?></td>
        </tr>
        <tr>
            <td>Catatan</td>
            <td class="text-right"><?= esc($pesanan['catatan']) ?: '-' ?></td>
        </tr>
    </table>

    <div class="divider"></div>

    <div class="text-center footer">
        <p style="margin: 0;">Terima kasih atas kepercayaan Anda.</p>
        <p style="margin: 5px 0 0 0;">Pakaian bersih, wangi, rapi, higienis!</p>
        <p style="margin: 5px 0 0 0; font-size: 8px;">Struk ini bukti pengambilan sah.</p>
    </div>

    <script>
        // Automatically open print dialog
        window.addEventListener('load', function() {
            // Un-comment to auto print immediately on page load in browser if desired
            // window.print();
        });
    </script>
</body>
</html>
