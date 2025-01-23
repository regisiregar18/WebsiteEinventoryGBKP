<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Barang</title>
</head>
<body>
    <h1>Detail Barang</h1>
    <p><strong>Kode Barang:</strong> {{ $barang->kode_barang }}</p>
    <p><strong>Nama Barang:</strong> {{ $barang->nama_barang }}</p>
    <p><strong>Kategori:</strong> {{ $barang->kategori_barang }}</p>
    <p><strong>Status:</strong> {{ $barang->status_barang == 1 ? 'Bisa Dipinjam' : 'Tidak Bisa Dipinjam' }}</p>
    <p><strong>Kondisi:</strong> {{ $barang->kondisi_barang == 1 ? 'Bisa Dipakai' : 'Rusak' }}</p>
    <p><strong>Jumlah Barang:</strong> {{ $barang->jumlah_barang }}</p>
    <p><strong>Tanggal Ditambahkan:</strong> {{ $barang->created_at->format('d M Y') }}</p>
    <p><strong>Gambar:</strong></p>
    <img src="{{ asset('storage/barang/gambar/' . $barang->gambar) }}" alt="Gambar Barang" width="200">
</body>
</html>
