<?php

namespace App\Controllers;

use App\Models\PesananModel;
use App\Models\LayananModel;

class Laporan extends BaseController
{
    protected $pesananModel;
    protected $layananModel;

    public function __construct()
    {
        $this->pesananModel = new PesananModel();
        $this->layananModel = new LayananModel();
    }

    public function index()
    {
        $start_date = $this->request->getGet('start_date') ?: date('Y-m-01'); // Default first day of current month
        $end_date = $this->request->getGet('end_date') ?: date('Y-m-d');     // Default today
        $layanan_id = $this->request->getGet('layanan_id');

        $query = $this->pesananModel->select('pesanan.*, pelanggan.nama as nama_pelanggan, layanan.nama_layanan')
                                    ->join('pelanggan', 'pelanggan.id = pesanan.pelanggan_id')
                                    ->join('layanan', 'layanan.id = pesanan.layanan_id')
                                    ->where('pesanan.tgl_masuk >=', $start_date)
                                    ->where('pesanan.tgl_masuk <=', $end_date);

        if (!empty($layanan_id)) {
            $query->where('pesanan.layanan_id', $layanan_id);
        }

        $laporan = $query->orderBy('pesanan.id', 'ASC')->findAll();

        // Calculate aggregates
        $total_pendapatan = 0;
        $total_omset = 0; // Total contract price
        $total_berat = 0;
        $total_selesai = 0;

        foreach ($laporan as $row) {
            $total_pendapatan += $row['nominal_bayar'];
            $total_omset += $row['total_harga'];
            $total_berat += $row['berat_kg'];
            if ($row['status_sop'] == 'selesai') {
                $total_selesai++;
            }
        }

        $data = [
            'title'            => 'Laporan Transaksi Laundry',
            'laporan'          => $laporan,
            'start_date'       => $start_date,
            'end_date'         => $end_date,
            'layanan_id'       => $layanan_id,
            'layanan_list'     => $this->layananModel->findAll(),
            'summary'          => [
                'total_pendapatan' => $total_pendapatan,
                'total_omset'      => $total_omset,
                'total_berat'      => $total_berat,
                'total_transaksi'  => count($laporan),
                'total_selesai'    => $total_selesai
            ]
        ];

        return view('laporan/index', $data);
    }
}
