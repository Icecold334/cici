<div class="">
    {{-- DASHBOARD --}}

    {{-- Statistik Ringkas --}}
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <!-- Total Pendapatan Hari Ini -->
        <div class="p-4 bg-gradient-to-bl from-primary-50 md:col-span-3 to-primary-100 rounded-lg shadow-md">
            <div class="text-green-500 text-xl mb-1"><i class="fas fa-money-bill-wave"></i></div>
            <div class="text-gray-700 dark:text-gray-200">Total Pendapatan Hari Ini</div>
            <div class="text-2xl font-bold">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</div>
        </div>

        <!-- Total Transaksi Hari Ini -->
        <div class="p-4 bg-gradient-to-bl from-primary-50 md:col-span-1 to-primary-100 rounded-lg shadow-md">
            <div class="text-pink-500 text-xl mb-1"><i class="fas fa-calendar-day"></i></div>
            <div class="text-gray-700 dark:text-gray-200">Total Transaksi Hari Ini</div>
            <div class="text-2xl font-bold">{{ $todayTransactionCount }}</div>
        </div>

        <!-- Total Transaksi Bulan Ini -->
        <div class="p-4 bg-gradient-to-bl from-primary-50 md:col-span-1 to-primary-100 rounded-lg shadow-md">
            <div class="text-blue-500 text-xl mb-1"><i class="fas fa-calendar-alt"></i></div>
            <div class="text-gray-700 dark:text-gray-200">Total Transaksi Bulan Ini</div>
            <div class="text-2xl font-bold">{{ $monthTransactionCount }}</div>
        </div>

        <!-- Total Pendapatan Bulan Ini -->
        <div class="p-4 bg-gradient-to-bl from-primary-50 md:col-span-2 to-primary-100 rounded-lg shadow-md">
            <div class="text-yellow-500 text-xl mb-1"><i class="fas fa-chart-line"></i></div>
            <div class="text-gray-700 dark:text-gray-200">Total Pendapatan Bulan Ini</div>
            <div class="text-2xl font-bold">Rp {{ number_format($monthRevenue, 0, ',', '.') }}</div>
        </div>

        <!-- Booking Masuk -->
        <div class="p-4 bg-gradient-to-bl from-primary-50 md:col-span-2 to-primary-100 rounded-lg shadow-md">
            <div class="text-purple-500 text-xl mb-1"><i class="fas fa-hourglass-half"></i></div>
            <div class="text-gray-700 dark:text-gray-200">Booking Masuk</div>
            <div class="text-2xl font-bold">{{ $bookingActiveCount }}</div>
        </div>

        <!-- Transaksi Selesai -->
        <div class="p-4 bg-gradient-to-bl from-primary-50 md:col-span-1 to-primary-100  rounded-lg shadow-md">
            <div class="text-green-600 text-xl mb-1"><i class="fas fa-check-circle"></i></div>
            <div class="text-gray-700 dark:text-gray-200">Transaksi Selesai</div>
            <div class="text-2xl font-bold">{{ $completedTransactionCount }}</div>
        </div>
    </div>
    <hr
        class="w-full h-1 mx-auto my-3 bg-gradient-to-bl from-primary-500 to bg-primary-600 border-0 rounded-sm md:my-5 ">
    {{-- Grafik Visual --}}
    <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
        <!-- Grafik Pendapatan 14 Hari -->
        <div class="p-4 bg-gradient-to-bl from-primary-50 md:col-span-12 to-primary-100 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-white flex items-center mb-2">
                <i class="fas fa-chart-line mr-2 text-pink-500"></i> Pendapatan 14 Hari Terakhir
            </h3>
            <div id="line-chart-pendapatan" class="w-full"></div>
        </div>

        <!-- Grafik Bar Transaksi -->
        <div class="p-4 bg-gradient-to-bl from-primary-50 md:col-span-8 to-primary-100 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-white flex items-center mb-2">
                <i class="fas fa-chart-bar mr-2 text-pink-500"></i> Jumlah Transaksi per Status
            </h3>
            <div id="barChart" class="w-full"></div>
        </div>

        <!-- Pie Chart Layanan Favorit -->
        <div class="p-4 bg-gradient-to-bl from-primary-50 md:col-span-4 to-primary-100 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-white flex items-center mb-2">
                <i class="fas fa-chart-pie mr-2 text-pink-500"></i> Top 5 Layanan Terfavorit
            </h3>
            <div id="pieChartFavorit" class="w-full"></div>
        </div>
    </div>
    <hr
        class="w-full h-1 mx-auto my-3 bg-gradient-to-bl from-primary-500 to bg-primary-600 border-0 rounded-sm md:my-5 ">
    {{-- Informasi Ringkas --}}
    <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
        <!-- Transaksi Terbaru -->
        <div class="p-4 bg-gradient-to-bl from-primary-50 md:col-span-2 to-primary-100  rounded-lg shadow-md">
            <h3 class="font-bold text-lg mb-2 flex items-center gap-2">
                <i class="fa-solid fa-clock text-pink-600"></i> Transaksi Terbaru
            </h3>
            <ul class="space-y-2 text-sm">
                @foreach ($transaksiTerbaru as $trx)
                <li class="flex justify-between border-b pb-1">
                    <span>{{ $trx->pasien->nama ?? $trx->nama }}</span>
                    <span class="text-right text-gray-500">{{ $trx->waktu->format('d/m H:i') }}</span>
                </li>
                @endforeach
            </ul>
        </div>

        <!-- Booking Hari Ini -->
        <div class="p-4 bg-gradient-to-bl from-primary-50 md:col-span-2 to-primary-100  rounded-lg shadow-md">
            <h3 class="font-bold text-lg mb-2 flex items-center gap-2">
                <i class="fa-solid fa-calendar-check text-yellow-500"></i> Booking Hari Ini
            </h3>
            <ul class="space-y-2 text-sm">
                @forelse ($bookingHariIni as $trx)
                <li class="flex justify-between border-b pb-1">
                    <span>{{ $trx->pasien->nama ?? $trx->nama }}</span>
                    <span class="text-right text-gray-500">{{ $trx->waktu->format('H:i') }}</span>
                </li>
                @empty
                <li class="text-gray-400">Tidak ada booking</li>
                @endforelse
            </ul>
        </div>

        <!-- Top 5 Pasien -->
        <div class="p-4 bg-gradient-to-bl from-primary-50 md:col-span-2 to-primary-100  rounded-lg shadow-md">
            <h3 class="font-bold text-lg mb-2 flex items-center gap-2">
                <i class="fa-solid fa-user-group text-blue-600"></i> Top 5 Pasien
            </h3>
            <ul class="space-y-2 text-sm">
                @foreach ($topPasien as $rank => $item)
                <li class="flex justify-between border-b pb-1">
                    <span>{{ $rank + 1 }}. {{ $item->pasien->nama ?? '-' }}</span>
                    <span class="text-gray-700 font-semibold">{{ $item->total }} x</span>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    const chart = new ApexCharts(document.querySelector("#line-chart-pendapatan"), {
        chart: {
            type: 'line',
            height: 200,
            toolbar: { show: false },
            zoom:{enabled:false}
        },
        series: [{
            name: 'Pendapatan',
            data: @json($data)
        }],
        xaxis: {
            categories: @json($labels),
            labels: { style: { colors: '#6b7280' } }
        },
        yaxis: {
            labels: {
                formatter: val => 'Rp ' + val.toLocaleString('id-ID'),
                style: { colors: '#6b7280' }
            }
        },
        colors: ['#ec4899'],
        stroke: { curve: 'smooth', width: 3 },
        markers: { size: 5, colors: ['#ec4899'], strokeWidth: 2 },
        tooltip: {
            y: {
                formatter: val => 'Rp ' + val.toLocaleString('id-ID')
            }
        },
        grid: {
            borderColor: '#e5e7eb',
            row: { colors: ['transparent'], opacity: 0.5 }
        }
    });
    chart.render();
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const barColors = ['#6b7280', '#2563eb', '#eab308', '#16a34a', '#dc2626'];
        const barLabels = @json(array_keys($transaksiPerStatus));
        const barData = @json(array_values($transaksiPerStatus));

        const barChart = new ApexCharts(document.querySelector("#barChart"), {
            chart: {
                type: 'bar',
                height: 200,
                toolbar: { show: false }
            },
            series: [{
                name: 'Jumlah',
                data: barData
            }],
            xaxis: {
                categories: barLabels,
                labels: { show: false }
            },
            legend: {
                show: true,
                position: 'top',
                horizontalAlign: 'center'
            },
            colors: barColors,
            plotOptions: {
                bar: {
                    distributed: true,
                    borderRadius: 2,
                    columnWidth: '20%'
                }
            },
            dataLabels: {
                enabled: true,
                style: {
                    fontSize: '12px',
                    colors: ['#ffffff']
                }
            }
        });

        barChart.render();
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const pieChart = new ApexCharts(document.querySelector("#pieChartFavorit"), {
            chart: {
                type: 'pie',
                height: 200,
            },
            labels: @json($pieFavoritLabels),
            series: @json($pieFavoritData),
            legend: {
                // show: false
            },
            dataLabels: {
                formatter: (val, opts) => opts.w.config.series[opts.seriesIndex],
                style: {
                    fontSize: '14px',
                    fontWeight: 'bold',
                    colors: ['#fff']
                }
            }
        });

        pieChart.render();
    });
</script>
@endpush