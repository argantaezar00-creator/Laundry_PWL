<?php

namespace App\Models;

use CodeIgniter\Model;

class PesananModel extends Model
{
    protected $table            = 'pesanan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'kode_pesanan', 'pelanggan_id', 'layanan_id', 'berat_kg', 
        'total_harga', 'status_sop', 'status_bayar', 'nominal_bayar', 
        'catatan', 'tgl_masuk', 'tgl_estimasi', 'tgl_selesai'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Get detailed order listings with customer and service details
     */
    public function getDetailedPesanan($id = null)
    {
        $builder = $this->select('pesanan.*, pelanggan.nama as nama_pelanggan, pelanggan.telepon, layanan.nama_layanan, layanan.harga_per_kg')
                        ->join('pelanggan', 'pelanggan.id = pesanan.pelanggan_id')
                        ->join('layanan', 'layanan.id = pesanan.layanan_id');
        
        if ($id === null) {
            return $builder->orderBy('pesanan.id', 'DESC')->findAll();
        }

        return $builder->where('pesanan.id', $id)->first();
    }
}
