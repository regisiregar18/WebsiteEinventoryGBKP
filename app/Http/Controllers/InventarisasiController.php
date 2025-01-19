<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventarisasi;
use Illuminate\Support\Facades\Storage;

class InventarisasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'target_dana' => 'required|numeric',
            'dana_masuk' => 'required|numeric',
            'gambar' => 'required|image|mimes:png,jpg,jpeg|max:5120'
        ]);

        // Save image file
        $request->file('gambar')
            ->storeAs('public/inventaris/gambar', $request->gambar->hashName());

        Inventarisasi::create([
            'nama_barang' => $request->nama_barang,
            'target_dana' => $request->target_dana,
            'dana_masuk' => $request->dana_masuk,
            'gambar' => $request->gambar->hashName()
        ]);

        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Inventarisasi $inventarisasi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventarisasi $inventarisasi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = Inventarisasi::find($id);

        $request->validate([
            'nama_barang' => 'required',
            'target_dana' => 'required|numeric',
            'dana_masuk' => 'required|numeric',
            'gambar' => 'image|mimes:png,jpg,jpeg|max:5120'
        ]);

        if ($request->hasFile('gambar')) {

            // Hapus image
            $berkas_path = ('public/inventaris/gambar/' . basename($data->gambar));
            Storage::delete($berkas_path);

            // Save image file
            $request->file('gambar')
                ->storeAs('public/inventaris/gambar', $request->gambar->hashName());

            $data->update([
                'nama_barang' => $request->nama_barang,
                'target_dana' => $request->target_dana,
                'dana_masuk' => $request->dana_masuk,
                'gambar' => $request->gambar->hashName()
            ]);

            return redirect()->back()->with('success', 'Data berhasil diupdate!');
        }


        $data->update([
            'nama_barang' => $request->nama_barang,
            'target_dana' => $request->target_dana,
            'dana_masuk' => $request->dana_masuk,
        ]);

        return redirect()->back()->with('success', 'Data berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Inventarisasi::find($id);

        // Hapus image
        $berkas_path = ('public/inventaris/gambar/' . basename($data->gambar));
        Storage::delete($berkas_path);

        $data->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}
