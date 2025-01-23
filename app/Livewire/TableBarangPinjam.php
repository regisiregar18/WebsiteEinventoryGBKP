<?php

namespace App\Livewire;

use App\Models\Peminjaman;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use App\Models\Barang;

class TableBarangPinjam extends Component
{
    use WithPagination;

    public $idPeminjaman, $cariPeminjaman, $bukti_peminjaman;
    public $nama_peminjam, $no_wa, $jaminan_peminjam; // Deklarasikan properti yang hilang
    public $id_barang, $tgl_peminjaman, $tgl_selesai, $bukti_peminjam, $jumlah_pinjam;

    public function render()
    {
        if (strlen($this->cariPeminjaman) > 2) {
            $data = DB::table('barangs')
                ->join('peminjamen', 'barangs.id', '=', 'peminjamen.id_barang')
                ->join('peminjams', 'peminjams.id', '=', 'peminjamen.id_peminjam')
                ->select('barangs.nama_barang', 'barangs.kode_barang', 'peminjamen.*', 
                'peminjams.nama_peminjam', 'peminjams.no_wa', 'peminjams.jaminan_peminjam', 'peminjams.jumlah_pinjam', 'peminjams.bukti_peminjam', 'peminjamen.tgl_selesai', 'peminjamen.tgl_peminjaman')
                ->whereNull('peminjamen.tgl_kembali')
                ->where('peminjams.nama_peminjam', 'LIKE', '%' . $this->cariPeminjaman . '%')
                ->orWhere('barangs.nama_barang', 'LIKE', '%' . $this->cariPeminjaman . '%')
                ->orderBy('peminjamen.created_at', 'DESC')
                ->paginate(5);
        } else {
            $data = DB::table('barangs')
                ->join('peminjamen', 'barangs.id', '=', 'peminjamen.id_barang')
                ->join('peminjams', 'peminjams.id', '=', 'peminjamen.id_peminjam')
                ->select('barangs.nama_barang', 'barangs.kode_barang', 'peminjamen.*', 
                'peminjams.nama_peminjam', 'peminjams.no_wa', 'peminjams.jaminan_peminjam', 'peminjams.bukti_peminjam', 'peminjams.jumlah_pinjam', 'peminjamen.tgl_selesai', 'peminjamen.tgl_peminjaman')
                ->whereNull('peminjamen.tgl_kembali')
                ->orderBy('peminjamen.created_at', 'DESC')
                ->paginate(5);
        }

        return view('livewire.table-barang-pinjam', compact('data'));
    }

    protected $listeners = ['barangPinjamUpdated' => 'refreshTable'];

    public function refreshTable()
    {
        // Render ulang tabel untuk menampilkan data terbaru
        $this->render();
    }

    public function select($id)
    {
        $this->idPeminjaman = $id;
    }

    public function confirmKembalikan()
{
    $now = Carbon::now();
    
    // Ambil data peminjaman berdasarkan ID yang dipilih
    $data = Peminjaman::find($this->idPeminjaman);
    
    // Pastikan data ditemukan
    if ($data) {
        // Ambil data barang berdasarkan ID barang di peminjaman
        $barang = Barang::find($data->id_barang);

        // Pastikan barang ditemukan
        if ($barang) {
            // Update stok barang, jumlah barang bertambah sesuai jumlah pinjam
            $barang->update([
                'jumlah_barang' => $barang->jumlah_barang + $data->jumlah_pinjam
            ]);

            // Update status peminjaman, set tanggal kembali
            $data->update([
                'tgl_kembali' => $now->toDateString()
            ]);
            
            return redirect('/dashboard/barang-pinjam')->with('success', 'Barang sukses dikembalikan dan stok diperbarui!');
        } else {
            return redirect('/dashboard/barang-pinjam')->with('error', 'Barang tidak ditemukan!');
        }
    } else {
        return redirect('/dashboard/barang-pinjam')->with('error', 'Peminjaman tidak ditemukan!');
    }
}


    public function confirmHapus()
    {
        $data = Peminjaman::find($this->idPeminjaman);

        $data->delete();

        return redirect('/dashboard/barang-pinjam')->with('success', 'Data berhasil dihapus!');
    }
}
