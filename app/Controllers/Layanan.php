<?php

namespace App\Controllers;

use App\Models\LayananModel;

class Layanan extends BaseController
{
    protected $layananModel;

    public function __construct()
    {
        $this->layananModel = new LayananModel();
    }

    public function index()
    {
        $data = [
            'title'   => 'Kelola Jenis Layanan',
            'layanan' => $this->layananModel->findAll()
        ];
        return view('layanan/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Layanan Baru'
        ];
        return view('layanan/create', $data);
    }

    public function store()
    {
        $rules = [
            'nama_layanan' => 'required|min_length[3]|max_length[100]',
            'harga_per_kg' => 'required|numeric|greater_than_equal_to[0]',
            'estimasi_jam' => 'required|integer|greater_than[0]',
            'status'       => 'required|in_list[aktif,nonaktif]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $this->layananModel->save([
            'nama_layanan' => $this->request->getPost('nama_layanan'),
            'harga_per_kg' => $this->request->getPost('harga_per_kg'),
            'estimasi_jam' => $this->request->getPost('estimasi_jam'),
            'deskripsi'    => $this->request->getPost('deskripsi'),
            'status'       => $this->request->getPost('status')
        ]);

        return redirect()->to('/layanan')->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $layanan = $this->layananModel->find($id);
        if (!$layanan) {
            return redirect()->to('/layanan')->with('error', 'Layanan tidak ditemukan.');
        }

        $data = [
            'title'   => 'Edit Layanan',
            'layanan' => $layanan
        ];
        return view('layanan/edit', $data);
    }

    public function update($id)
    {
        $layanan = $this->layananModel->find($id);
        if (!$layanan) {
            return redirect()->to('/layanan')->with('error', 'Layanan tidak ditemukan.');
        }

        $rules = [
            'nama_layanan' => 'required|min_length[3]|max_length[100]',
            'harga_per_kg' => 'required|numeric|greater_than_equal_to[0]',
            'estimasi_jam' => 'required|integer|greater_than[0]',
            'status'       => 'required|in_list[aktif,nonaktif]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $this->layananModel->update($id, [
            'nama_layanan' => $this->request->getPost('nama_layanan'),
            'harga_per_kg' => $this->request->getPost('harga_per_kg'),
            'estimasi_jam' => $this->request->getPost('estimasi_jam'),
            'deskripsi'    => $this->request->getPost('deskripsi'),
            'status'       => $this->request->getPost('status')
        ]);

        return redirect()->to('/layanan')->with('success', 'Layanan berhasil diperbarui.');
    }

    public function delete($id)
    {
        $layanan = $this->layananModel->find($id);
        if (!$layanan) {
            return redirect()->to('/layanan')->with('error', 'Layanan tidak ditemukan.');
        }

        try {
            $this->layananModel->delete($id);
            return redirect()->to('/layanan')->with('success', 'Layanan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->to('/layanan')->with('error', 'Layanan tidak bisa dihapus karena masih digunakan oleh data pesanan.');
        }
    }
}
