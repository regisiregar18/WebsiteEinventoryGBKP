<?php

namespace App\Livewire;

use App\Models\Barang;
use App\Models\Peminjam;
use App\Models\Peminjaman;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use App\Http\Controllers\PagesController;

class FormBarangPinjam extends Component
{
    use WithFileUploads;

    public $data, $showSuggest = true;
    public $in_detail = false, $detail;
    public $nama_peminjam, $barang_pinjaman, $tgl_peminjaman, $id_barang, $tgl_selesai, $no_wa, $bukti_peminjam, $jaminan_peminjam ,$jumlah_pinjam;

    public function mount($detail)
    {
        if (!is_null($detail)) {
            $this->detail = $detail;
            $this->in_detail = true;
            $this->showSuggest = false;
            $this->nama_peminjam = $detail->nama_peminjam;
            $this->barang_pinjaman = $detail->nama_barang;
            $this->id_barang = $detail->id_barang;
            $this->tgl_peminjaman = $detail->tgl_peminjaman;
            $this->tgl_selesai = $detail->tgl_selesai;
        }
    }

    public function submit()
    {
        // Validasi data
        $this->validate([
            'nama_peminjam' => 'required|string',
            'barang_pinjaman' => 'required|string',
            'tgl_peminjaman' => 'required|date',
            'tgl_selesai' => 'required|date',
            'no_wa' => 'required|string',
            'jumlah_pinjam' => 'required|number',
            'bukti_peminjam' => 'image|mimes:png,jpg,jpeg|max:5120',
            'jaminan_peminjam' => 'required|string',
        ]);

        // Simpan data ke database
        BarangPinjam::create([
            'nama_peminjam' => $this->nama_peminjam,
            'barang_pinjaman' => $this->barang_pinjaman,
            'tgl_peminjaman' => $this->tgl_peminjaman,
            'tgl_selesai' => $this->tgl_selesai,
            'no_wa' => $this->no_wa,
            'jumlah_pinjam' => $this->jumlah_pinjam,
            'bukti_peminjam' => $this->bukti_peminjam->store('bukti_peminjam'),
            'jaminan_peminjam' => $this->jaminan_peminjam,
        ]);

        // Emit event untuk memberitahu tabel
        $this->emit('barangPinjamUpdated');

        // Reset form setelah submit
        $this->reset(['nama_peminjam', 'barang_pinjaman', 'tgl_peminjaman', 'tgl_selesai', 'no_wa', 'bukti_peminjam', 'jaminan_peminjam']);
    }

    public function render()
    {
        if (strlen($this->barang_pinjaman) > 2) {
            $this->data = Barang::where('nama_barang', 'LIKE', '%' . $this->barang_pinjaman . '%')
                ->where('status_barang', 'LIKE', '%1%')
                ->get();
        } else {
            $this->data = [];
        }

        return view('livewire.form-barang-pinjam', [
            'data' => $this->data
        ]);
    }

    public function select($id)
    {
        $find = $this->data->find($id);

        $this->id_barang = $find->id;
        $this->barang_pinjaman = $find->nama_barang;

        $this->showSuggest = false;
    }

    public function suggestToggle()
    {
        $this->showSuggest = true;
    }

    public function cekStatusPinjamBarang($idBarang)
    {
        return Peminjaman::where('id_barang', $idBarang)
            ->whereNull('tgl_kembali')->exists();
    }

    public function cekStatusPinjamSendiri($idPeminjam, $idBarang)
    {
        return Peminjaman::where('id_barang', $idBarang)
            ->where('id_peminjam', $idPeminjam)
            ->whereNull('tgl_kembali')->exists();
    }

    public function cekPeminjam($namaPeminjam)
    {
        return Peminjam::where('nama_peminjam', 'LIKE', '%' . $namaPeminjam . '%')->first();
    }

    public function store()
{
    try {
        \Log::debug('Method store() dipanggil');
        \Log::debug('Nilai bukti_peminjam:', [$this->bukti_peminjam]);

        // Validasi termasuk file gambar
        $this->validate([
            'id_barang' => 'required',
            'tgl_peminjaman' => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_peminjaman',
            'nama_peminjam' => 'required',
            'no_wa' => 'required',
            'jumlah_pinjam' => 'required|integer|min:1',
            'jaminan_peminjam' => 'required',
            'bukti_peminjam' => 'image|mimes:png,jpg,jpeg|max:35840'
        ]);

        $this->bukti_peminjam
            ->storeAs('public/bukti/gambar', $this->bukti_peminjam->hashName());

        // Cek status peminjaman barang
        if ($this->cekStatusPinjamBarang($this->id_barang)) {
            return redirect('/dashboard/barang-pinjam')->with('failed', 'Barang masih dipinjam orang lain!');
        }

        // Ambil data barang yang dipinjam
        $barang = Barang::find($this->id_barang);

        if ($barang->jumlah_barang < $this->jumlah_pinjam) {
            return redirect('/dashboard/barang-pinjam')->with('failed', 'Stok barang tidak cukup!');
        }

        // Cek peminjam
        $peminjam = $this->cekPeminjam($this->nama_peminjam);
        if ($peminjam) {
            // Simpan data peminjaman
            Peminjaman::create([
                'id_peminjam' => $peminjam->id,
                'id_barang' => $this->id_barang,
                'tgl_peminjaman' => $this->tgl_peminjaman,
                'tgl_selesai' => $this->tgl_selesai,
                'jumlah_pinjam' => $this->jumlah_pinjam,
                'bukti_peminjam' => $this->bukti_peminjam->hashName(),
                'jaminan_peminjam' => $this->jaminan_peminjam,
            ]);
        } else {
            // Buat peminjam baru dan simpan peminjaman
            $peminjam = Peminjam::create([
                'nama_peminjam' => $this->nama_peminjam,
                'no_wa' => $this->no_wa,
                'bukti_peminjam' => $this->bukti_peminjam->hashName(),
                'jaminan_peminjam' => $this->jaminan_peminjam,
                'jumlah_pinjam' => $this->jumlah_pinjam,
            ]);

            Peminjaman::create([
                'id_peminjam' => $peminjam->id,
                'id_barang' => $this->id_barang,
                'tgl_peminjaman' => $this->tgl_peminjaman,
                'tgl_selesai' => $this->tgl_selesai,
                'bukti_peminjam' => $this->bukti_peminjam->hashName(),
                'jaminan_peminjam' => $this->jaminan_peminjam,
                'jumlah_pinjam' => $this->jumlah_pinjam,
            ]);
        }

        $barang->jumlah_barang -= $this->jumlah_pinjam;
        $barang->save(); // Simpan perubahan stok barang

        return redirect('/dashboard/barang-pinjam')->with('success', 'Barang berhasil dipinjamkan!');
    } catch (\Exception $e) {
        \Log::error($e->getMessage());
        return redirect('/dashboard/barang-pinjam')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}

public function update()
{
    $find = Peminjaman::where('id_peminjam', $this->detail->id_peminjam)
        ->whereNull('tgl_kembali');

    // Cek status peminjaman barang
    if ($this->cekStatusPinjamBarang($this->id_barang)) {
        if (!$this->cekStatusPinjamSendiri($this->detail->id_peminjam, $this->id_barang)) {
            return redirect('/dashboard/barang-pinjam')->with('failed', 'Barang masih dipinjam orang lain!');
        }
    }

    // Cek peminjam apakah sudah ada di database
    $peminjam = $this->cekPeminjam($this->nama_peminjam);
    if ($peminjam) {
        // Jika ada, maka update data peminjam
        $peminjam->update([
            'no_wa' => $this->no_wa, // Update no_wa
            //'bukti_peminjam' => $this->bukti_peminjam->hashName(), // Update bukti_peminjam
            'jaminan_peminjam' => $this->jaminan_peminjam, // Update jaminan_peminjam
            'jumlah_pinjam' => $this->jumlah_pinjam
        ]);
    } else {
        // Jika tidak ada, maka buat dulu di database
        $peminjam = Peminjam::create([
            'nama_peminjam' => $this->nama_peminjam,
            'no_wa' => $this->no_wa,
            //'bukti_peminjam' => $this->bukti_peminjam->hashName(),
            'jaminan_peminjam' => $this->jaminan_peminjam,
            'jumlah_pinjam' => $this->jumlah_pinjam
        ]);
    }

    // Update data peminjaman
    $find->update([
        'id_peminjam' => $peminjam->id,
        'id_barang' => $this->id_barang,
        'tgl_peminjaman' => $this->tgl_peminjaman,
        'tgl_selesai' => $this->tgl_selesai,
        'jumlah_pinjam' => $this->jumlah_pinjam
    ]);

    return redirect('/dashboard/barang-pinjam')->with('success', 'Barang berhasil diupdate!');
}


}
