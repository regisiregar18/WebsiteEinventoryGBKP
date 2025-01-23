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
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\ErrorCorrectionLevel;


class BarangController extends Controller
{ 
    public function index(Request $request)
        {
            $data = Barang::all(); // Ambil semua data barang dari database
            return view('admin.data-barang', compact('data')); // Kirim data ke view
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
        // Validasi input
    $validatedData = $request->validate([
        'nama_barang' => 'required',
        'kategori_barang' => 'required',
        'status_barang' => 'required',
        'kondisi_barang' => 'required',
        'jumlah_barang' => 'required',
        'gambar' => 'required|image|mimes:png,jpg,jpeg|max:35840'
    ]);

    // Simpan file gambar
    $gambarPath = $request->file('gambar')->store('public/barang/gambar');
    $gambarName = basename($gambarPath);

    // Generate kode unik
    do {
        $kodeBarang = 'GBKP - ' . rand(1000, 9999);
    } while (Barang::where('kode_barang', $kodeBarang)->exists());

    // Simpan data barang ke database
    $createdBarang = Barang::create([
        'kode_barang' => $kodeBarang,
        'nama_barang' => $validatedData['nama_barang'],
        'kategori_barang' => $validatedData['kategori_barang'],
        'status_barang' => $validatedData['status_barang'],
        'kondisi_barang' => $validatedData['kondisi_barang'],
        'jumlah_barang' => $validatedData['jumlah_barang'],
        'gambar' => $gambarName,
    ]);

    // Buat QR Code
    $result = Builder::create()
        ->writer(new PngWriter())
        ->data(route('barangs.show', $createdBarang->id))
        ->encoding(new Encoding('UTF-8'))
        ->errorCorrectionLevel(Endroid\QrCode\ErrorCorrectionLevel::HIGH)
        ->size(300) // Ukuran QR Code
        ->margin(10) // Margin QR Code
        ->build();

    // Simpan QR Code ke file
    $qrCodePath = 'public/barang/qr-codes/' . $createdBarang->id . '.png';
    $filePath = storage_path('app/' . $qrCodePath);
    $result->saveToFile($filePath);

    // Update path QR Code di database
    $createdBarang->update(['qr_code' => $qrCodePath]);

    var_dump(class_exists('Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevel'));

    // Redirect dengan pesan sukses
    return redirect()->back()->with('success', 'Data berhasil disimpan dan QR Code dibuat!');
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
    public function show($id)
    {
        $barang = Barang::findOrFail($id);

        // Kirim data ke view
        return view('barangs.show', compact('barang'));
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
