<?php

namespace App\Livewire;

use App\Models\Peminjaman;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class TableBarangPinjam extends Component
{
    use WithPagination;

    public $idPeminjaman, $cariPeminjaman, $bukti_peminjaman;
    public $nama_peminjam, $no_wa, $jaminan_peminjam; // Deklarasikan properti yang hilang
    public $id_barang, $tgl_peminjaman, $tgl_selesai, $bukti_peminjam;

    public function render()
    {
        if (strlen($this->cariPeminjaman) > 2) {
            $data = DB::table('barangs')
                ->join('peminjamen', 'barangs.id', '=', 'peminjamen.id_barang')
                ->join('peminjams', 'peminjams.id', '=', 'peminjamen.id_peminjam')
                ->select('barangs.nama_barang', 'barangs.kode_barang', 'peminjamen.*', 
                'peminjams.nama_peminjam', 'peminjams.no_wa', 'peminjams.jaminan_peminjam', 'peminjams.bukti_peminjam', 'peminjamen.tgl_selesai', 'peminjamen.tgl_peminjaman')
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
                'peminjams.nama_peminjam', 'peminjams.no_wa', 'peminjams.jaminan_peminjam', 'peminjams.bukti_peminjam', 'peminjamen.tgl_selesai', 'peminjamen.tgl_peminjaman')
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

        $data = Peminjaman::find($this->idPeminjaman);

        $data->update([
            'tgl_kembali' => $now->toDateString()
        ]);

        return redirect('/dashboard/barang-pinjam')->with('success', 'Barang sukses dikembalikan!');
    }

    public function confirmHapus()
    {
        $data = Peminjaman::find($this->idPeminjaman);

        $data->delete();

        return redirect('/dashboard/barang-pinjam')->with('success', 'Data berhasil dihapus!');
    }
}
