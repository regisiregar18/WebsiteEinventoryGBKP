@extends('layouts.default')

@section('content')
    <div class="grid grid-cols-12 gap-3">
        <div class="xl:col-span-7 col-span-12">
            <div class="bg-white px-5 py-8 rounded-lg mb-8">
                <div class="grid lg:grid-cols-3 grid-cols-1 gap-5 mb-5">
                    <div class="px-8">
                        <h1 class="text-center text-xl font-bold">{{ $totalBarang }}</h1>
                        <h1 class="text-center font-medium text-slate-500">Total Barang</h1>
                    </div>
                    <div class="sm:px-8 lg:py-0 py-8 lg:border-x-2 lg:border-y-0 border-y-2">
                        <h1 class="text-center text-xl font-bold">{{ $barangBelumKembali }}</h1>
                        <h1 class="text-center font-medium text-sm text-slate-500">Total peminjaman yang belum kembali</h1>
                    </div>
                    <div class="px-8">
                        <h1 class="text-center text-xl font-bold">{{ $barangSudahKembali }}</h1>
                        <h1 class="text-center font-medium text-sm text-slate-500">Total peminjaman yang sudah kembali</h1>
                    </div>
                </div>
                <canvas id="myChart" width="400" height="200" class="w-full"></canvas>
            </div>
            <div class="bg-white px-5 py-8 rounded-lg">
                <h1 class="bg-white px-2 py-1 shadow-lg border font-medium w-max mb-3">Data Kondisi Barang</h1>
                <canvas id="myChart2" width="400" height="200"></canvas>
            </div>
        </div>
        <div class="xl:col-span-5 col-span-12">
    <div class="px-5 py-3 bg-white rounded-lg">
        <h1 class="text-lg font-semibold mb-5">History Barang</h1>
        <form method="GET" action="{{ route('filterPeminjaman') }}">
            <div class="flex gap-4 mb-4">
                <select name="bulan" class="border border-gray-300 p-2 rounded-lg">
                    <option value="">Pilih Bulan</option>
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                        </option>
                    @endfor
                </select>
                <select name="tahun" class="border border-gray-300 p-2 rounded-lg">
                    <option value="">Pilih Tahun</option>
                    @for ($i = 2020; $i <= date('Y'); $i++)
                        <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Filter</button>
            </div>
        </form>

        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Nama Peminjam</th>
                        <th scope="col" class="px-6 py-3">Barang Yang Dipinjam</th>
                        <th scope="col" class="px-6 py-3">Tanggal Peminjaman</th>
                        <th scope="col" class="px-6 py-3">Tanggal Kembali</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Kondisi Barang</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($listPeminjam->isEmpty())
                        <tr>
                            <td colspan="5" class="text-center py-4">Tidak ada data peminjaman untuk bulan dan tahun yang dipilih.</td>
                        </tr>
                    @else
                        @foreach ($listPeminjam as $item)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $item->nama_peminjam }}
                                </th>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $item->nama_barang }}
                                </th>
                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($item->tgl_peminjaman)->format('d M Y') }}</td>
                                <td class="px-6 py-4">
                                    {{ $item->tgl_kembali ? \Carbon\Carbon::parse($item->tgl_kembali)->format('d M Y') : '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    @if ($item->tgl_kembali)
                                        <div class="flex items-center gap-2">
                                            <svg class="w-5 text-white bg-green-500 rounded-full" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5"/>
                                            </svg>
                                            Sudah Mengembalikan
                                        </div>
                                    @else
                                        <div class="flex items-center gap-2">
                                            <svg class="w-5 text-white bg-red-500 rounded-full" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
                                            </svg>
                                            Belum Mengembalikan
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if ($item->kondisi_barang == 1)
                                        <span class="text-green-600 font-semibold">Bisa Dipakai</span>
                                    @else
                                        <span class="text-red-500 font-semibold">Rusak</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
        
        {{ $listPeminjam->links() }}  {{-- Untuk menampilkan pagination --}}
    </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Doughnut chart
    const ctx = document.getElementById('myChart');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Total Barang', 'Belum Kembali', 'Sudah Kembali'],
            datasets: [{
                label: ' Jumlah Barang ',
                data: [
                    {{ $totalBarang }},
                    {{ $barangBelumKembali }},
                    {{ $barangSudahKembali }},
                ],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(75, 192, 192, 0.6)'
                ],
                borderWidth: 1
            }]
        }
    });


    // Bar chart
    const ctx2 = document.getElementById('myChart2');
    new Chart(ctx2, {
    type: 'bar',
    data: {
        labels: ['Baik', 'Rusak'], // Label untuk sumbu x
        datasets: [{
            label: ' Jumlah Barang ', // Label dataset
            data: [
                @json($barangBaik), // Nilai barangBaik dari Blade
                @json($barangRusak)   // Jumlah barang rusak (kondisi 0)
            ],
            backgroundColor: [
                'rgba(0, 128, 0, 0.6)',  // Warna untuk barang baik (hijau)
                'rgba(255, 0, 0, 0.6)'    // Warna untuk barang rusak (merah)
            ],
            borderColor: [
                'rgba(0, 128, 0, 1)',      // Warna border untuk barang baik
                'rgba(255, 0, 0, 1)'       // Warna border untuk barang rusak
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true, // Memastikan sumbu y mulai dari 0
                suggestedMax: Math.max({{ $barangBaik }}, {{ $barangRusak }})
            }
        },
        plugins: {
            legend: {
                display: true, // Menampilkan legend
                labels: {
                    generateLabels: function(chart) {
                        return [
                            {
                                text: 'Barang Baik',
                                fillStyle: 'rgba(0, 128, 0, 0.6)',
                            },
                            {
                                text: 'Barang Rusak',
                                fillStyle: 'rgba(255, 0, 0, 0.6)',
                            }
                        ];
                    }
                }
            }
        }
    }
});


</script>




@endsection