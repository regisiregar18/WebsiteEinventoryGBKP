<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class TableBarangKembali extends Component
{
    use WithPagination;

    public $cariPeminjaman;

    public function render()
    {
        if (strlen($this->cariPeminjaman) > 2) {
            $data = DB::table('barangs')
                ->join('peminjamen', 'barangs.id', '=', 'peminjamen.id_barang')
                ->join('peminjams', 'peminjams.id', '=', 'peminjamen.id_peminjam')
                ->select('barangs.nama_barang', 'barangs.kode_barang', 'barangs.kategori_barang', 'peminjamen.*', 'peminjams.nama_peminjam')
                ->whereNotNull('peminjamen.tgl_kembali')
                ->where('barangs.nama_barang', 'LIKE', '%' . $this->cariPeminjaman . '%')
                ->orWhere('barangs.kode_barang', 'LIKE', '%' . $this->cariPeminjaman . '%')
                ->orderBy('peminjamen.created_at', 'DESC')
                ->paginate(10);
        } else {
            $data = DB::table('barangs')
                ->join('peminjamen', 'barangs.id', '=', 'peminjamen.id_barang')
                ->join('peminjams', 'peminjams.id', '=', 'peminjamen.id_peminjam')
                ->select('barangs.nama_barang', 'barangs.kode_barang', 'barangs.kategori_barang', 'peminjamen.*', 'peminjams.nama_peminjam')
                ->whereNotNull('peminjamen.tgl_kembali')
                ->orderBy('peminjamen.created_at', 'DESC')
                ->paginate(10);
        }

        return view('livewire.table-barang-kembali', compact('data'));
    }
}
