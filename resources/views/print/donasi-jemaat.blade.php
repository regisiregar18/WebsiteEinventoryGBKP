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
            <h1 class="text-center text-3xl font-semibold">Laporan Donasi Jemaat GBKP Runggun Pantai Barat</h1>
        </section>

        <br>

        <section>
            <h1 class="text-lg font-semibold mb-3 mt-7">Pesembahan Perorangan</h1>
            <table id="dataTable">
                <thead>
                    <tr>
                        <th scope="col">
                            Nama
                        </th>
                        <th scope="col">
                            Tanggal
                        </th>
                        <th scope="col">
                            Jumlah
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($donasiJemaat as $item)
                        <tr>
                            <td>
                                {{ Str::apa($item->nama) }}
                            </td>
                            <td>
                                {{ $item->updated_at->format('d M Y') }}
                            </td>
                            <td>
                                @currency($item->jumlah_donasi)
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="2" class="text-center text-lg font-semibold">Total</td>
                        <td class="text-center text-lg font-semibold">@currency($totalDonasiJemaat)</td>
                    </tr>
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
                        <tr>
                        <td>&nbsp;</td>
                        </tr>
                        <tr>
                        <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Pt. Patuh Perangin-angin</td>
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
                        <tr>
                        <td>&nbsp;</td>
                        </tr>
                        <tr>
                        <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Cakradu Natalta Sembiring</td>
                        </tr>
                    </thead>
                </table>
            </div>
        </section>

        <section class="text-center text-lg">
            <p>Disetujui,</p>
            <p>Pendeta GBKP Runggun Pantai Barat</p>
            <br> <br>
            <p>Pdt. Magdalena Sari Novita Br.S.Depari, S.Th.</p>
        </section>
    </main>

    <script>
        // window.print();
    </script>
</body>
</html>