<?php

namespace App\Controllers;

use App\Models\PelangganModel;
use App\Models\PesananModel;

class Pelanggan extends BaseController
{
    protected $pelangganModel;

    public function __construct()
    {
        $this->pelangganModel = new PelangganModel();
    }

    public function index()
    {
        $pesananModel = new PesananModel();
        $pelangganRaw = $this->pelangganModel->findAll();
        
        // Enrich data with orders count and total spends
        $pelanggan = [];
        foreach ($pelangganRaw as $p) {
            $total_orders = $pesananModel->where('pelanggan_id', $p['id'])->countAllResults();
            $total_spend_raw = $pesananModel->selectSum('total_harga')->where('pelanggan_id', $p['id'])->first();
            
            $p['total_orders'] = $total_orders;
            $p['total_spend'] = $total_spend_raw['total_harga'] ?? 0.00;
            $pelanggan[] = $p;
        }

        $data = [
            'title'     => 'Kelola Data Pelanggan',
            'pelanggan' => $pelanggan
        ];
        return view('pelanggan/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Pelanggan Baru'
        ];
        return view('pelanggan/create', $data);
    }

    public function store()
    {
        $rules = [
            'nama'    => 'required|min_length[3]|max_length[100]',
            'telepon' => 'required|min_length[8]|max_length[20]',
            'alamat'  => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $this->pelangganModel->save([
            'nama'    => $this->request->getPost('nama'),
            'telepon' => $this->request->getPost('telepon'),
            'alamat'  => $this->request->getPost('alamat')
        ]);

        return redirect()->to('/pelanggan')->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pelanggan = $this->pelangganModel->find($id);
        if (!$pelanggan) {
            return redirect()->to('/pelanggan')->with('error', 'Pelanggan tidak ditemukan.');
        }

        $data = [
            'title'     => 'Edit Pelanggan',
            'pelanggan' => $pelanggan
        ];
        return view('pelanggan/edit', $data);
    }

    public function update($id)
    {
        $pelanggan = $this->pelangganModel->find($id);
        if (!$pelanggan) {
            return redirect()->to('/pelanggan')->with('error', 'Pelanggan tidak ditemukan.');
        }

        $rules = [
            'nama'    => 'required|min_length[3]|max_length[100]',
            'telepon' => 'required|min_length[8]|max_length[20]',
            'alamat'  => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $this->pelangganModel->update($id, [
            'nama'    => $this->request->getPost('nama'),
            'telepon' => $this->request->getPost('telepon'),
            'alamat'  => $this->request->getPost('alamat')
        ]);

        return redirect()->to('/pelanggan')->with('success', 'Pelanggan berhasil diperbarui.');
    }

    public function delete($id)
    {
        $pelanggan = $this->pelangganModel->find($id);
        if (!$pelanggan) {
            return redirect()->to('/pelanggan')->with('error', 'Pelanggan tidak ditemukan.');
        }

        try {
            $this->pelangganModel->delete($id);
            return redirect()->to('/pelanggan')->with('success', 'Pelanggan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->to('/pelanggan')->with('error', 'Pelanggan tidak bisa dihapus karena memiliki riwayat transaksi/pesanan.');
        }
    }
}
