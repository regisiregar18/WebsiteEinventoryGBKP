<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Barang;
use Illuminate\Support\Str;
use App\Models\DonasiJemaat;
use Illuminate\Http\Request;
use App\Models\DanaPersembahan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    
    public function index(Request $request)
        {
            $sortColumn = $request->input('sort', 'nama_barang'); // Default sorting by 'nama_barang'
            $sortDirection = $request->input('direction', 'asc'); // Default direction is 'asc'
        
            $data = Barang::orderBy($sortColumn, $sortDirection)->paginate(10);
        
            return view('admin.data-barang', compact('data', 'sortColumn', 'sortDirection'));
        }
    

    
    public function create()
    {
        //
    }

    

    //  Function cek kode_barang
    public function generateCode($code)
    {
        return Barang::where('kode_barang', 'LIKE', '%' . $code . '%')->exists();
    }

    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'nama_barang' => 'required',
            'kategori_barang' => 'required',
            'status_barang' => 'required',
            'kondisi_barang' => 'required',
            'jumlah_barang' => 'required',
            'gambar' => 'required|image|mimes:png,jpg,jpeg|max:35840'
        ]);

        // Save image file
        $request->file('gambar')
            ->storeAs('public/barang/gambar', $request->gambar->hashName());

        // Generate random code
        $code = rand();

        // Cek code
        if ($this->generateCode($code)) {
            // Jika code ada yg sama dg data terdahulu, maka generate ulang
            $code = rand();
        }

        // Jika semua aman, maka simpan data
        Barang::create([
            'kode_barang' => 'GBKP - ' . $code,
            'nama_barang' => $request->nama_barang,
            'kategori_barang' => $request->kategori_barang,
            'status_barang' => $request->status_barang,
            'kondisi_barang' => $request->kondisi_barang,
            'jumlah_barang' => $request->jumlah_barang,
            'gambar' => $request->gambar->hashName()
        ]);

        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }

    public function printDataBarang()
    {
        $data = DB::table('barangs')
            ->select('barangs.nama_barang', 'barangs.kode_barang', 'barangs.kategori_barang', 'barangs.status_barang', 'barangs.kondisi_barang', 'barangs.gambar', 'barangs.jumlah_barang')
            ->whereNotNull('barangs.updated_at')
            ->orderBy('barangs.created_at', 'DESC')
            ->get();

        $now = Carbon::now();

        return view('print.data-barang', compact('data', 'now'));
    }

    public function printBarangKembali()
    {
        $data = DB::table('barangs')
            ->join('peminjamen', 'barangs.id', '=', 'peminjamen.id_barang')
            ->join('peminjams', 'peminjams.id', '=', 'peminjamen.id_peminjam')
            ->select('barangs.nama_barang', 'barangs.kode_barang', 'barangs.kategori_barang', 'peminjamen.*', 'peminjams.nama_peminjam')
            ->whereNotNull('peminjamen.tgl_kembali')
            ->orderBy('peminjamen.created_at', 'DESC')
            ->get();

        $now = Carbon::now();

        return view('print.barang-kembali', compact('data', 'now'));
    }

    public function printBarangPinjam()
    {
        $data = DB::table('barangs')
            ->join('peminjamen', 'barangs.id', '=', 'peminjamen.id_barang')
            ->join('peminjams', 'peminjams.id', '=', 'peminjamen.id_peminjam')
            ->select('barangs.nama_barang', 'barangs.kode_barang', 'barangs.kategori_barang', 'peminjamen.*', 'peminjams.nama_peminjam')
            ->whereNull('peminjamen.tgl_kembali')
            ->orderBy('peminjamen.created_at', 'DESC')
            ->get();

        $now = Carbon::now();

        return view('print.barang-pinjam', compact('data', 'now'));
    }

    public function printDanaMasuk()
    {
        $persembahan = DanaPersembahan::latest()->get();
        $totalPersembahan = DB::table('dana_persembahans')->sum('jumlah_persembahan');

        $donasiJemaat = DonasiJemaat::latest()->get();
        $totalDonasiJemaat = DB::table('donasi_jemaats')->sum('jumlah_donasi');

        $now = Carbon::now();

        return view('print.donasi-jemaat', compact('persembahan', 'totalPersembahan', 'donasiJemaat', 'totalDonasiJemaat', 'now'));
    }

    public function showBarangPinjam($id)
    {
        $data = DB::table('barangs')
            ->join('peminjamen', 'barangs.id', '=', 'peminjamen.id_barang')
            ->join('peminjams', 'peminjams.id', '=', 'peminjamen.id_peminjam')
            ->select('barangs.nama_barang', 'barangs.kode_barang', 'peminjamen.*', 'peminjams.nama_peminjam')
            ->where('peminjamen.id', $id)
            ->first();

        return view('admin.edit-barang-pinjam', compact('data'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Barang $barang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Barang $barang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate input
        $request->validate([
            'nama_barang' => 'required',
            'kategori_barang' => 'required',
            'status_barang' => 'required',
            'kondisi_barang' => 'required',
            'jumlah_barang' => 'required',
            'gambar' => 'image|mimes:png,jpg,jpeg|max:35840'
        ]);

        $data = Barang::find($id);

        if ($request->hasFile('gambar')) {

            // Hapus image
            $berkas_path = ('public/barang/gambar/' . basename($data->gambar));
            Storage::delete($berkas_path);

            // Save image file
            $request->file('gambar')
                ->storeAs('public/barang/gambar', $request->gambar->hashName());

            // Jika semua aman, maka simpan data
            $data->update([
                'nama_barang' => $request->nama_barang,
                'kategori_barang' => $request->kategori_barang,
                'status_barang' => $request->status_barang,
                'kondisi_barang' => $request->kondisi_barang,
                'jumlah_barang' => $request->jumlah_barang,
                'gambar' => $request->gambar->hashName()
            ]);

            return redirect()->back()->with('success', 'Data berhasil diupdate!');
        }

        // Jika semua aman, maka simpan data
        $data->update([
            'nama_barang' => $request->nama_barang,
            'kategori_barang' => $request->kategori_barang,
            'status_barang' => $request->status_barang,
            'kondisi_barang' => $request->kondisi_barang,
            'jumlah_barang' => $request->jumlah_barang,
        ]);

        return redirect()->back()->with('success', 'Data berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Barang::find($id);

        // Hapus gambar
        $berkas_path = ('public/barang/gambar/' . basename($data->gambar));
        Storage::delete($berkas_path);

        $data->delete();

        return redirect('/dashboard/data-barang')->with('success', 'Data berhasil dihapus!');
    }

    public function filter(Request $request)
{
    $bulan = $request->input('bulan');
    $tahun = $request->input('tahun');

    // Membuat query untuk mengfilter barang berdasarkan bulan dan tahun
    $query = Barang::query();

    if ($request->filled('bulan') && $request->filled('tahun')) {
        $query->whereMonth('created_at', $request->bulan)
              ->whereYear('created_at', $request->tahun);
    }

    
    $data = $query->latest()->paginate(10); 

    // Mendefinisikan variabel untuk ditampilkan di view
    $id = null; 
    $namaBarang = null;
    $kategoriBarang = null;
    $statusBarang = null;
    $kondisiBarang = null;
    $jumlahBarang = null;

    // Cek apakah data tidak kosong sebelum mengambil informasi barang
    if ($data->isNotEmpty()) {
        $id = $data->first()->id; // Ambil ID dari data pertama
        $namaBarang = $data->first()->nama_barang;
        $kategoriBarang = $data->first()->kategori_barang;
        $statusBarang = $data->first()->status_barang;
        $kondisiBarang = $data->first()->kondisi_barang;
        $jumlahBarang = $data->first()->jumlah_barang;
    }

    return view('livewire.table-data-barang', compact('data', 'id', 'namaBarang', 'kategoriBarang', 'statusBarang', 'kondisiBarang', 'jumlahBarang', 'bulan', 'tahun'));
}



}
