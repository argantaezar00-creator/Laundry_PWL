<?php

namespace App\Controllers;

use App\Models\PesananModel;
use App\Models\PelangganModel;
use App\Models\LayananModel;
use App\Models\RiwayatStatusModel;

class Pesanan extends BaseController
{
    protected $pesananModel;
    protected $pelangganModel;
    protected $layananModel;
    protected $riwayatModel;

    public function __construct()
    {
        $this->pesananModel = new PesananModel();
        $this->pelangganModel = new PelangganModel();
        $this->layananModel = new LayananModel();
        $this->riwayatModel = new RiwayatStatusModel();
    }

    public function index()
    {
        $status_sop = $this->request->getGet('status_sop');
        $status_bayar = $this->request->getGet('status_bayar');

        $query = $this->pesananModel->select('pesanan.*, pelanggan.nama as nama_pelanggan, layanan.nama_layanan')
                                    ->join('pelanggan', 'pelanggan.id = pesanan.pelanggan_id')
                                    ->join('layanan', 'layanan.id = pesanan.layanan_id');

        if (!empty($status_sop)) {
            $query->where('status_sop', $status_sop);
        }
        if (!empty($status_bayar)) {
            $query->where('status_bayar', $status_bayar);
        }

        $pesanan = $query->orderBy('pesanan.id', 'DESC')->findAll();

        $data = [
            'title'        => 'Kelola Pesanan Laundry',
            'pesanan'      => $pesanan,
            'status_sop'   => $status_sop,
            'status_bayar' => $status_bayar
        ];
        return view('pesanan/index', $data);
    }

    public function create()
    {
        $data = [
            'title'     => 'Buat Pesanan Baru',
            'pelanggan' => $this->pelangganModel->findAll(),
            'layanan'   => $this->layananModel->where('status', 'aktif')->findAll()
        ];
        return view('pesanan/create', $data);
    }

    public function store()
    {
        $rules = [
            'pelanggan_id'  => 'required|integer',
            'layanan_id'    => 'required|integer',
            'berat_kg'      => 'required|numeric|greater_than[0]',
            'status_bayar'  => 'required|in_list[belum,dp,lunas]',
            'nominal_bayar' => 'permit_empty|numeric|greater_than_equal_to[0]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $pelanggan_id = $this->request->getPost('pelanggan_id');
        $layanan_id = $this->request->getPost('layanan_id');
        $berat_kg = $this->request->getPost('berat_kg');
        $status_bayar = $this->request->getPost('status_bayar');
        $nominal_bayar = $this->request->getPost('nominal_bayar') ?: 0.00;

        // Fetch selected service to calculate price and estimated time
        $layanan = $this->layananModel->find($layanan_id);
        if (!$layanan) {
            return redirect()->back()->with('error', 'Layanan tidak valid.')->withInput();
        }

        $total_harga = $berat_kg * $layanan['harga_per_kg'];
        if ($status_bayar == 'lunas') {
            $nominal_bayar = $total_harga;
        }

        // Generate Invoice Code (LAU-YYYYMMDD-XXXX)
        $datePrefix = date('Ymd');
        $lastOrder = $this->pesananModel->where('tgl_masuk', date('Y-m-d'))
                                        ->orderBy('id', 'DESC')
                                        ->first();
        $nextNumber = 1;
        if ($lastOrder) {
            $parts = explode('-', $lastOrder['kode_pesanan']);
            $lastNum = (int)end($parts);
            $nextNumber = $lastNum + 1;
        }
        $kode_pesanan = 'LAU-' . $datePrefix . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        // Date calculations
        $tgl_masuk = date('Y-m-d');
        $estimasi_jam = $layanan['estimasi_jam'];
        $tgl_estimasi = date('Y-m-d', strtotime("+$estimasi_jam hours"));

        // Save order
        $pesanan_id = $this->pesananModel->insert([
            'kode_pesanan'  => $kode_pesanan,
            'pelanggan_id'  => $pelanggan_id,
            'layanan_id'    => $layanan_id,
            'berat_kg'      => $berat_kg,
            'total_harga'   => $total_harga,
            'status_sop'    => 'masuk',
            'status_bayar'  => $status_bayar,
            'nominal_bayar' => $nominal_bayar,
            'catatan'       => $this->request->getPost('catatan'),
            'tgl_masuk'     => $tgl_masuk,
            'tgl_estimasi'  => $tgl_estimasi,
            'tgl_selesai'   => null,
        ]);

        // Insert initial history status
        $this->riwayatModel->insert([
            'pesanan_id'  => $pesanan_id,
            'status_lama' => null,
            'status_baru' => 'masuk',
            'catatan'     => 'Pesanan baru dibuat dan didaftarkan ke sistem.'
        ]);

        return redirect()->to('/pesanan/detail/' . $pesanan_id)->with('success', 'Pesanan berhasil dibuat.');
    }

    public function detail($id)
    {
        $pesanan = $this->pesananModel->getDetailedPesanan($id);
        if (!$pesanan) {
            return redirect()->to('/pesanan')->with('error', 'Pesanan tidak ditemukan.');
        }

        $riwayat = $this->riwayatModel->where('pesanan_id', $id)->orderBy('created_at', 'ASC')->findAll();

        $sop_steps = [
            'masuk'      => ['label' => 'Order Masuk', 'icon' => 'fa-file-invoice'],
            'timbang'    => ['label' => 'Ditimbang', 'icon' => 'fa-weight-hanging'],
            'cuci'       => ['label' => 'Proses Cuci', 'icon' => 'fa-soap'],
            'setrika'    => ['label' => 'Setrika Selesai', 'icon' => 'fa-tshirt'],
            'kemas'      => ['label' => 'Pengemasan', 'icon' => 'fa-box-open'],
            'siap_ambil' => ['label' => 'Siap Ambil', 'icon' => 'fa-clipboard-check'],
            'selesai'    => ['label' => 'Selesai/Diambil', 'icon' => 'fa-handshake']
        ];

        $data = [
            'title'     => 'Detail Pesanan ' . $pesanan['kode_pesanan'],
            'pesanan'   => $pesanan,
            'riwayat'   => $riwayat,
            'sop_steps' => $sop_steps
        ];

        return view('pesanan/detail', $data);
    }

    public function edit($id)
    {
        $pesanan = $this->pesananModel->find($id);
        if (!$pesanan) {
            return redirect()->to('/pesanan')->with('error', 'Pesanan tidak ditemukan.');
        }

        $data = [
            'title'     => 'Edit Pesanan',
            'pesanan'   => $pesanan,
            'pelanggan' => $this->pelangganModel->findAll(),
            'layanan'   => $this->layananModel->where('status', 'aktif')->findAll()
        ];
        return view('pesanan/edit', $data);
    }

    public function update($id)
    {
        $pesanan = $this->pesananModel->find($id);
        if (!$pesanan) {
            return redirect()->to('/pesanan')->with('error', 'Pesanan tidak ditemukan.');
        }

        $rules = [
            'pelanggan_id'  => 'required|integer',
            'layanan_id'    => 'required|integer',
            'berat_kg'      => 'required|numeric|greater_than[0]',
            'status_bayar'  => 'required|in_list[belum,dp,lunas]',
            'nominal_bayar' => 'permit_empty|numeric|greater_than_equal_to[0]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $pelanggan_id = $this->request->getPost('pelanggan_id');
        $layanan_id = $this->request->getPost('layanan_id');
        $berat_kg = $this->request->getPost('berat_kg');
        $status_bayar = $this->request->getPost('status_bayar');
        $nominal_bayar = $this->request->getPost('nominal_bayar') ?: 0.00;

        $layanan = $this->layananModel->find($layanan_id);
        $total_harga = $berat_kg * $layanan['harga_per_kg'];
        if ($status_bayar == 'lunas') {
            $nominal_bayar = $total_harga;
        }

        $this->pesananModel->update($id, [
            'pelanggan_id'  => $pelanggan_id,
            'layanan_id'    => $layanan_id,
            'berat_kg'      => $berat_kg,
            'total_harga'   => $total_harga,
            'status_bayar'  => $status_bayar,
            'nominal_bayar' => $nominal_bayar,
            'catatan'       => $this->request->getPost('catatan'),
        ]);

        return redirect()->to('/pesanan/detail/' . $id)->with('success', 'Detail pesanan berhasil diperbarui.');
    }

    /**
     * Move to the next SOP status
     */
    public function updateStatus($id)
    {
        $pesanan = $this->pesananModel->find($id);
        if (!$pesanan) {
            return redirect()->to('/pesanan')->with('error', 'Pesanan tidak ditemukan.');
        }

        $status_baru = $this->request->getPost('status_sop');
        $catatan = $this->request->getPost('catatan') ?: 'Status dipindahkan ke ' . $status_baru;

        $status_lama = $pesanan['status_sop'];

        $updateData = ['status_sop' => $status_baru];

        // If status becomes 'selesai', write the completion date
        if ($status_baru == 'selesai') {
            $updateData['tgl_selesai'] = date('Y-m-d');
            // If it's done, set status_bayar as lunas if full nominal paid
            if ($pesanan['status_bayar'] !== 'lunas') {
                $updateData['status_bayar'] = 'lunas';
                $updateData['nominal_bayar'] = $pesanan['total_harga'];
            }
        } else {
            $updateData['tgl_selesai'] = null;
        }

        $this->pesananModel->update($id, $updateData);

        // Record to status history log
        $this->riwayatModel->insert([
            'pesanan_id'  => $id,
            'status_lama' => $status_lama,
            'status_baru' => $status_baru,
            'catatan'     => $catatan
        ]);

        return redirect()->to('/pesanan/detail/' . $id)->with('success', 'Status operasional SOP berhasil diupdate.');
    }

    /**
     * Update payment details
     */
    public function updatePembayaran($id)
    {
        $pesanan = $this->pesananModel->find($id);
        if (!$pesanan) {
            return redirect()->to('/pesanan')->with('error', 'Pesanan tidak ditemukan.');
        }

        $status_bayar = $this->request->getPost('status_bayar');
        $nominal_bayar = $this->request->getPost('nominal_bayar');

        if ($status_bayar == 'lunas') {
            $nominal_bayar = $pesanan['total_harga'];
        }

        $this->pesananModel->update($id, [
            'status_bayar'  => $status_bayar,
            'nominal_bayar' => $nominal_bayar
        ]);

        return redirect()->to('/pesanan/detail/' . $id)->with('success', 'Data transaksi pembayaran berhasil diperbarui.');
    }

    /**
     * Thermal Print Receipt View
     */
    public function struk($id)
    {
        $pesanan = $this->pesananModel->getDetailedPesanan($id);
        if (!$pesanan) {
            return 'Struk tidak ditemukan.';
        }

        $data = [
            'pesanan' => $pesanan
        ];

        return view('pesanan/struk', $data);
    }

    public function delete($id)
    {
        $pesanan = $this->pesananModel->find($id);
        if (!$pesanan) {
            return redirect()->to('/pesanan')->with('error', 'Pesanan tidak ditemukan.');
        }

        $this->pesananModel->delete($id);
        return redirect()->to('/pesanan')->with('success', 'Pesanan berhasil dihapus dari sistem.');
    }
}
