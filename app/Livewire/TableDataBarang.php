<?php

namespace App\Livewire;

use App\Models\Barang;
use Livewire\Component;
use Livewire\WithPagination;

class TableDataBarang extends Component
{
    use WithPagination;

    public $cariBarang, $namaBarang, $kategoriBarang, $statusBarang, $kondisiBarang, $jumlahBarang, $id;
    public $bulan, $tahun;
    public $barangs;

    // Method render untuk menampilkan data
    public function render()
    {
        $query = Barang::query();

        // Pencarian berdasarkan nama atau kode barang
        if (strlen($this->cariBarang) > 2) {
            $query->where('nama_barang', 'LIKE', '%' . $this->cariBarang . '%')
                  ->orWhere('kode_barang', 'LIKE', '%' . $this->cariBarang . '%');
        }

        // Filter berdasarkan bulan dan tahun
        if ($this->bulan && $this->tahun) {
            $query->whereMonth('created_at', $this->bulan)
                  ->whereYear('created_at', $this->tahun);
        }

        // Ambil data terakhir dan paginasi
        $data = $query->latest()->paginate(5);

        return view('livewire.table-data-barang', compact('data'));
    }

    // Fungsi untuk memfilter data saat tombol filter ditekan
    public function filter()
    {
        $this->resetPage();
    }

    public function select($id)
    {
        $this->id = $id;

        $find = Barang::find($this->id);

        $this->namaBarang = $find['nama_barang'];
        $this->kategoriBarang = $find['kategori_barang'];
        $this->statusBarang = $find['status_barang'];
        $this->kondisiBarang = $find['kondisi_barang'];
        $this->jumlahBarang = $find['jumlah_barang'];
    }
}
