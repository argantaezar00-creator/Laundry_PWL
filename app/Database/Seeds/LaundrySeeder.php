<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LaundrySeeder extends Seeder
{
    public function run()
    {
        // Truncate first to prevent duplicates or foreign key issues if re-seeded
        $this->db->disableForeignKeyChecks();
        $this->db->table('riwayat_status')->truncate();
        $this->db->table('pesanan')->truncate();
        $this->db->table('pelanggan')->truncate();
        $this->db->table('layanan')->truncate();
        $this->db->enableForeignKeyChecks();

        // 1. Seed Layanan
        $layananData = [
            [
                'nama_layanan' => 'Cuci Komplit (Cuci + Setrika)',
                'harga_per_kg' => 8000.00,
                'estimasi_jam' => 48,
                'deskripsi'    => 'Layanan cuci bersih dilanjutkan dengan setrika rapi dan parfum pewangi.',
                'status'       => 'aktif',
                'created_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'nama_layanan' => 'Cuci Kering (Wash only)',
                'harga_per_kg' => 5000.00,
                'estimasi_jam' => 24,
                'deskripsi'    => 'Cuci bersih dan kering tanpa disetrika.',
                'status'       => 'aktif',
                'created_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'nama_layanan' => 'Setrika Saja (Iron only)',
                'harga_per_kg' => 4000.00,
                'estimasi_jam' => 24,
                'deskripsi'    => 'Hanya jasa penyetrikaan pakaian (sudah dalam kondisi bersih).',
                'status'       => 'aktif',
                'created_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'nama_layanan' => 'Express 6 Jam',
                'harga_per_kg' => 15000.00,
                'estimasi_jam' => 6,
                'deskripsi'    => 'Cuci komplit super cepat selesai dalam 6 jam.',
                'status'       => 'aktif',
                'created_at'   => date('Y-m-d H:i:s'),
            ]
        ];
        $this->db->table('layanan')->insertBatch($layananData);

        // 2. Seed Pelanggan
        $pelangganData = [
            [
                'nama'       => 'Budi Setiawan',
                'telepon'    => '081234567890',
                'alamat'     => 'Jl. Merdeka No. 10, Jakarta Pusat',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama'       => 'Susi Susanti',
                'telepon'    => '082345678901',
                'alamat'     => 'Perum Indah Regency Blok B-12, Bekasi',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama'       => 'Roni Wijaya',
                'telepon'    => '083456789012',
                'alamat'     => 'Kost Mahasiswa Kamar 15, Depok',
                'created_at' => date('Y-m-d H:i:s'),
            ]
        ];
        $this->db->table('pelanggan')->insertBatch($pelangganData);

        // 3. Seed Pesanan
        $pesananData = [
            [
                'kode_pesanan'  => 'LAU-' . date('Ymd') . '-0001',
                'pelanggan_id'  => 1, // Budi
                'layanan_id'    => 1, // Cuci Komplit
                'berat_kg'      => 4.5,
                'total_harga'   => 36000.00,
                'status_sop'    => 'cuci',
                'status_bayar'  => 'belum',
                'nominal_bayar' => 0.00,
                'catatan'       => 'Baju kantor harap dipisah',
                'tgl_masuk'     => date('Y-m-d'),
                'tgl_estimasi'  => date('Y-m-d', strtotime('+2 days')),
                'tgl_selesai'   => null,
                'created_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'kode_pesanan'  => 'LAU-' . date('Ymd') . '-0002',
                'pelanggan_id'  => 2, // Susi
                'layanan_id'    => 4, // Express 6 Jam
                'berat_kg'      => 2.0,
                'total_harga'   => 30000.00,
                'status_sop'    => 'selesai',
                'status_bayar'  => 'lunas',
                'nominal_bayar' => 30000.00,
                'catatan'       => 'Gaun pesta hati-hati',
                'tgl_masuk'     => date('Y-m-d', strtotime('-1 day')),
                'tgl_estimasi'  => date('Y-m-d', strtotime('-1 day')),
                'tgl_selesai'   => date('Y-m-d'),
                'created_at'    => date('Y-m-d H:i:s', strtotime('-1 day')),
            ]
        ];
        $this->db->table('pesanan')->insertBatch($pesananData);

        // 4. Seed Riwayat Status
        $riwayatData = [
            [
                'pesanan_id'  => 1,
                'status_lama' => null,
                'status_baru' => 'masuk',
                'catatan'     => 'Pesanan diterima di kasir',
                'created_at'  => date('Y-m-d H:i:s', strtotime('-2 hours')),
            ],
            [
                'pesanan_id'  => 1,
                'status_lama' => 'masuk',
                'status_baru' => 'timbang',
                'catatan'     => 'Barang telah ditimbang (4.5 Kg)',
                'created_at'  => date('Y-m-d H:i:s', strtotime('-1.5 hours')),
            ],
            [
                'pesanan_id'  => 1,
                'status_lama' => 'timbang',
                'status_baru' => 'cuci',
                'catatan'     => 'Pakaian dimasukkan ke mesin cuci 02',
                'created_at'  => date('Y-m-d H:i:s', strtotime('-30 minutes')),
            ],
            [
                'pesanan_id'  => 2,
                'status_lama' => null,
                'status_baru' => 'masuk',
                'catatan'     => 'Pesanan ekspres diterima',
                'created_at'  => date('Y-m-d H:i:s', strtotime('-6 hours')),
            ],
            [
                'pesanan_id'  => 2,
                'status_lama' => 'siap_ambil',
                'status_baru' => 'selesai',
                'catatan'     => 'Diambil oleh pelanggan dan lunas',
                'created_at'  => date('Y-m-d H:i:s'),
            ]
        ];
        $this->db->table('riwayat_status')->insertBatch($riwayatData);
    }
}
