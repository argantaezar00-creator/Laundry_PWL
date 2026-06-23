<?php

namespace App\Controllers;

use App\Models\PesananModel;
use App\Models\PelangganModel;
use App\Models\LayananModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $pesananModel = new PesananModel();
        $pelangganModel = new PelangganModel();
        $layananModel = new LayananModel();

        $today = date('Y-m-d');

        // Card Stats
        $total_hari_ini = $pesananModel->where('tgl_masuk', $today)->countAllResults();
        $selesai_hari_ini = $pesananModel->where('status_sop', 'selesai')->where('tgl_selesai', $today)->countAllResults();
        
        $pendapatan_hari_ini_raw = $pesananModel->selectSum('nominal_bayar')
                                               ->where('created_at >=', $today . ' 00:00:00')
                                               ->where('created_at <=', $today . ' 23:59:59')
                                               ->first();
        $pendapatan_hari_ini = $pendapatan_hari_ini_raw['nominal_bayar'] ?? 0;

        $total_pelanggan = $pelangganModel->countAllResults();

        // Latest orders
        $latest_orders = $pesananModel->getDetailedPesanan();
        $latest_orders = array_slice($latest_orders, 0, 5);

        // Chart Data: Last 7 Days
        $chart_labels = [];
        $chart_orders = [];
        $chart_revenue = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $chart_labels[] = date('d M', strtotime($date));

            // Count orders on this day
            $count = $pesananModel->where('tgl_masuk', $date)->countAllResults();
            $chart_orders[] = $count;

            // Count revenue collected on this day
            $rev_raw = $pesananModel->selectSum('nominal_bayar')
                                    ->where('created_at >=', $date . ' 00:00:00')
                                    ->where('created_at <=', $date . ' 23:59:59')
                                    ->first();
            $chart_revenue[] = (float)($rev_raw['nominal_bayar'] ?? 0);
        }

        $data = [
            'title' => 'Dashboard Laundry',
            'stats' => [
                'total_hari_ini'   => $total_hari_ini,
                'selesai_hari_ini' => $selesai_hari_ini,
                'pendapatan'       => $pendapatan_hari_ini,
                'total_pelanggan'  => $total_pelanggan,
            ],
            'latest_orders' => $latest_orders,
            'chart' => [
                'labels'  => $chart_labels,
                'orders'  => $chart_orders,
                'revenue' => $chart_revenue,
            ]
        ];

        return view('dashboard/index', $data);
    }
}
