<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
    <style>
        * {
            font-family: "Poppins", sans-serif;
            font-weight: 400;
            font-style: normal;
        }

        #dataTable {
          font-family: arial, sans-serif;
          border-collapse: collapse;
          width: 100%;
        }
        
        #dataTable td, #dataTable th {
          border: 1px solid black;
          text-align: left;
          padding: 8px;
        }
    </style>
    <main>
    <section class="flex justify-center gap-3 items-center">
        <img src="{{ asset('img/logo.png') }}" alt="Logo" style="width: 100px; height: auto;">
            <div>
                <h1 class="text-4xl font-semibold">E-Inventory</h1>
                <p>GBKP Runggun Pantai Barat</p>
            </div>
        </section>

        <div class="h-[1px] bg-black my-6"></div>

        <section>
            <h1 class="text-center text-3xl font-semibold">Laporan Pengembalian Barang GBKP Runggun Pantai Barat</h1>
        </section>

        <br> <br>

        <section>
            <table id="dataTable">
                <thead>
                    <tr>
                        <th scope="col">
                            No
                        </th>
                        <th scope="col">
                            Kode Barang
                        </th>
                        <th scope="col">
                            Nama Barang
                        </th>
                        <th scope="col">
                            Sub Kategori
                        </th>
                        <th scope="col">
                            Tanggal Kembali
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($data as $item)
                        <tr>
                            <th scope="row">
                                {{ $no++ }}
                            </th>
                            <td>
                                {{ $item->kode_barang }}
                            </td>
                            <td>
                                {{ $item->nama_barang }}
                            </td>
                            <td>
                                {{ $item->kategori_barang }}
                            </td>
                            <td>
                                @php
                                    $date = date_create($item->tgl_kembali)
                                @endphp
                                {{ date_format($date,"d M Y") }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>

        <section class="grid grid-cols-12 mt-8 mb-24">
            <div class="col-span-6">
                <table>
                    <thead>
                        <tr>
                            <td>Mengetahui,</td>
                        </tr>
                        <tr>
                            <td>Dewan Koinonia GBKP Runggun Pantai Barat</td>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="col-span-6">
                <table class="ms-28">
                    <thead>
                        <tr>
                            @php
                                $date = date_create($now->toDateString())
                            @endphp
                            <td>Medan, {{ date_format($date,"d M Y") }}</td>
                        </tr>
                        <tr>
                            <td>Petugas Administrasi</td>
                        </tr>
                    </thead>
                </table>
            </div>
        </section>

        <section class="text-center text-lg">
            <p>Disetujui,</p>
            <p>Pendeta GBKP Runggun Pantai Barat</p>
        </section>
    </main>

    <script>
        window.print();
    </script>
</body>
</html>