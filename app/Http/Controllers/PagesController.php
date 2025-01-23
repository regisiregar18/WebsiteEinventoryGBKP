<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\DonasiJemaat;
use Illuminate\Http\Request;
use App\Models\Inventarisasi;
use App\Models\DanaPersembahan;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    public function index()
    {
        $alatMusik = Barang::where('kategori_barang', 'alat musik')->get();
        $kendaraan = Barang::where('kategori_barang', 'kendaraan')->get();
        $properti = Barang::where('kategori_barang', 'properti')->get();
        $elektronik = Barang::where('kategori_barang', 'elektronik')->get();
        $inventaris = Inventarisasi::latest()->first();

        return view('home', compact('alatMusik', 'kendaraan', 'properti', 'elektronik', 'inventaris'));
    }

    public function dashboard()
    {
        // Liat Peminjam
        $listPeminjam = DB::table('barangs')
    ->join('peminjamen', 'barangs.id', '=', 'peminjamen.id_barang')
    ->join('peminjams', 'peminjams.id', '=', 'peminjamen.id_peminjam')
    ->select(
        'peminjams.nama_peminjam',
        'peminjamen.tgl_peminjaman',
        'peminjamen.tgl_kembali',
        'barangs.kondisi_barang',
        'barangs.nama_barang' // Tambahkan kolom ini
    )
    ->orderBy('peminjamen.tgl_kembali', 'DESC')
    ->paginate(10);

        $bulan = [
            'jan', 'feb', 'mar', 'apr', 'mei', 'jun',
            'jul', 'agu', 'sep', 'okt', 'nov', 'des'
        ];


        $barangBaik = DB::table('barangs')
                ->where('kondisi_barang', 1) // Kondisi "baik"
                ->count();

    // Hitung total barang dengan kondisi rusak (0)
    $barangRusak = DB::table('barangs')
                ->where('kondisi_barang', 0) // Kondisi "rusak"
                ->count(); 
        
                $result = DB::table('barangs')
                ->select('kondisi_barang', DB::raw('COUNT(*) as jumlah'))
                ->groupBy('kondisi_barang')
                ->get();

    // Membuat array untuk menyimpan data jumlah barang berdasarkan kondisi
    $data = [];
    foreach ($result as $row) {
        $data[$row->kondisi_barang] = $row->jumlah;
    }

    // Menggunakan array $data untuk menentukan jumlah barang baik dan rusak
    $barangBaik = $data[1] ?? 0;  // Jika kondisi_barang = 1, jumlah barang baik
    $barangRusak = $data[0] ?? 0; // Jika kondisi_barang = 0, jumlah barang rusak

    // Debug: Cek nilai barang baik dan rusak
    \Log::info('Barang Baik:', [$barangBaik]);
    \Log::info('Barang Rusak:', [$barangRusak]);
    \Log::info('Data Group By:', $result->toArray());

                
        // Menghitung total barang tersedia
        $totalBarang = DB::table('barangs')->count();

        // Menghitung total barang perbulan
        $totatBarangPerBulan = [];
        for ($i = 0; $i < 12; $i++) {
            $getPerBulan = DB::table('barangs')->whereMonth('created_at', $i + 1)->count();
            array_push($totatBarangPerBulan, $getPerBulan);
        }

        // Barang Belum Kembali
        $barangBelumKembali = DB::table('peminjamen')->whereNull('tgl_kembali')->count();

        // Menghitung peminjam belum kembali perbulan
        $totatBelumKembaliPerBulan = [];
        for ($i = 0; $i < 12; $i++) {
            $getPerBulan = DB::table('peminjamen')->whereNull('tgl_kembali')->whereMonth('created_at', $i + 1)->count();
            array_push($totatBelumKembaliPerBulan, $getPerBulan);
        }


        // Barang Sudah Kembali
        $barangSudahKembali = DB::table('peminjamen')->whereNotNull('tgl_kembali')->count();

        // Menghitung peminjam sudah kembali perbulan
        $totatSudahKembaliPerBulan = [];
        for ($i = 0; $i < 12; $i++) {
            $getPerBulan = DB::table('peminjamen')->whereNotNull('tgl_kembali')->whereMonth('created_at', $i + 1)->count();
            array_push($totatSudahKembaliPerBulan, $getPerBulan);
        }

        return view('admin.dashboard', compact('listPeminjam', 'barangBaik', 'barangRusak', 'totalBarang', 'barangBelumKembali', 'barangSudahKembali', 'totatBarangPerBulan', 'totatBelumKembaliPerBulan', 'totatSudahKembaliPerBulan'));
    }

    public function filterPeminjaman(Request $request)
{
    $query = Peminjaman::query()
    -> join('peminjams', 'peminjamen.id_peminjam', '=', 'peminjams.id') // Sesuaikan dengan nama kolom yang tepat
    -> select('peminjamen.*', 'peminjams.nama_peminjam');

    
    if ($request->filled('bulan') && $request->filled('tahun')) {
        $query->whereMonth('tgl_peminjaman', $request->bulan)
              ->whereYear('tgl_peminjaman', $request->tahun);
    }

    $listPeminjam = $query->paginate(10);

    // Hitung jumlah peminjam yang sudah dan belum dikembalikan
    $barangBelumKembali = Peminjaman::whereNull('tgl_kembali')->count(); // Menghitung dari semua peminjaman
    $barangSudahKembali = Peminjaman::whereNotNull('tgl_kembali')->count();

    $totalBarang = Barang::count(); // Menghitung total barang
    $barangBaik = Barang::where('kondisi_barang', 0)->count(); // Hitung barang baik
    $barangRusak = Barang::where('kondisi_barang', 1)->count(); // Hitung barang rusak

    return view('admin.dashboard', compact(
        'listPeminjam',
        'totalBarang',
        'barangBelumKembali',
        'barangSudahKembali',
        'barangBaik',
        'barangRusak'
    ));
}
    public function dataBarang()
    {
        return view('admin.data-barang');
    }

    public function barangKembali()
    {
        return view('admin.barang-kembali');
    }

    public function barangPinjam()
    {
        return view('admin.barang-pinjam');
    }

    public function danaMasuk()
    {
        $donasiJemaat = DonasiJemaat::latest()->get();
        return view('admin.dana-masuk', compact('donasiJemaat'));
    }

    public function inventarisasi()
    {
        $data = Inventarisasi::latest()->first();

        return view('admin.inventarisasi', compact('data'));
    }

    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function profile()
    {
        $data = Auth::user();

        return view('admin.profile', compact('data'));
    }

    public function settings()
    {
        $data = Auth::user();

        return view('admin.settings', compact('data'));
    }


}
