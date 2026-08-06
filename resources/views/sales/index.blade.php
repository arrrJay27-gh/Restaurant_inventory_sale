<x-app-layout>
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- MAIN CONTAINER WITH LEFT MARGIN FOR SIDEBAR -->
    <div class="sm:ml-64 bg-[#F6FAF3] min-h-screen p-6 md:p-8">
        
        <!-- TOP HEADER BAR -->
        <header class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-[#1A2E12] tracking-tight">Sales Analytics & Monitoring</h1>
                <p class="text-sm text-gray-500 mt-1">Analyze daily performance and track high vs. low sales periods.</p>
            </div>
            
            <div class="flex items-center gap-3 bg-white px-4 py-2 rounded-2xl border border-green-100/80 shadow-sm w-fit">
                <div class="w-10 h-10 bg-[#70C116] text-white font-black rounded-xl flex items-center justify-center text-sm shadow-sm">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-800 leading-tight">{{ auth()->user()->name }}</p>
                    <span class="inline-block px-2 py-0.5 text-[10px] font-semibold bg-green-100 text-[#52930a] rounded-full">
                        {{ ucfirst(auth()->user()->role ?? 'Admin') }}
                    </span>
                </div>
            </div>
        </header>

        <!-- STATS CARDS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- TODAY SALES -->
            <div class="bg-white p-6 rounded-3xl border border-green-100 shadow-sm">
                <p class="text-xs font-bold uppercase tracking-wider text-gray-400">TODAY'S SALES</p>
                <h2 class="text-3xl font-black text-gray-900 mt-1">₱{{ number_format($todaySales ?? 0, 2) }}</h2>
                <p class="text-xs text-gray-400 mt-2">Target: ₱5,000.00 / day</p>
            </div>

            <!-- TODAY STATUS -->
            <div class="bg-white p-6 rounded-3xl border border-green-100 shadow-sm">
                <p class="text-xs font-bold uppercase tracking-wider text-gray-400">TODAY'S STATUS</p>
                <div class="mt-2">
                    @if(($todaySales ?? 0) >= 5000)
                        <span class="inline-flex items-center gap-1.5 text-base font-extrabold text-green-700">
                            📈 High
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 text-base font-extrabold text-amber-600">
                            📉 Low
                        </span>
                    @endif
                </div>
                <p class="text-xs text-gray-400 mt-2">
                    {{ number_format((($todaySales ?? 0) / 5000) * 100, 1) }}% of daily target reached
                </p>
            </div>

            <!-- 7-DAY TOTAL -->
            <div class="bg-white p-6 rounded-3xl border border-green-100 shadow-sm">
                <p class="text-xs font-bold uppercase tracking-wider text-gray-400">TOTAL (LAST 7 DAYS)</p>
                <h2 class="text-3xl font-black text-[#70C116] mt-1">₱{{ number_format(array_sum($dailyValues ?? []), 2) }}</h2>
                <p class="text-xs text-gray-400 mt-2">Sum of past 7 days</p>
            </div>

            <!-- DAILY AVERAGE -->
            <div class="bg-white p-6 rounded-3xl border border-green-100 shadow-sm">
                <p class="text-xs font-bold uppercase tracking-wider text-gray-400">DAILY AVERAGE</p>
                <h2 class="text-3xl font-black text-gray-900 mt-1">₱{{ number_format($averageDailySales ?? 0, 2) }}</h2>
                <p class="text-xs text-gray-400 mt-2">Average revenue per day</p>
            </div>
        </div>

        <!-- 7-DAY SALES GRAPH -->
        <div class="bg-white p-6 rounded-3xl border border-green-100 shadow-sm mb-8">
            <div class="text-center mb-6">
                <h3 class="text-xl font-extrabold text-gray-900">7-Day Sales Trend & Performance</h3>
                <p class="text-xs text-gray-400 mt-1">Daily revenue monitoring to identify high and low performing days.</p>
                
                <!-- LEGEND BADGES -->
                <div class="flex items-center justify-center gap-4 mt-3 text-xs font-bold">
                    <span class="inline-flex items-center gap-1.5 text-green-700">
                        <span class="w-3 h-3 rounded-full bg-[#70C116]"></span> High (≥ ₱5,000)
                    </span>
                    <span class="inline-flex items-center gap-1.5 text-amber-600">
                        <span class="w-3 h-3 rounded-full bg-amber-500"></span> Low (&lt; ₱5,000)
                    </span>
                </div>
            </div>

            <div class="w-full h-80">
                <canvas id="dailySalesChart"></canvas>
            </div>
        </div>

        <!-- RECENT TRANSACTIONS TABLE -->
        <div class="bg-white p-6 rounded-3xl border border-green-100 shadow-sm">
            <h3 class="text-lg font-extrabold text-gray-900 mb-4">Sales Records</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 text-xs font-bold text-gray-400 uppercase">
                            <th class="py-3 px-4">Transaction ID</th>
                            <th class="py-3 px-4">Customer</th>
                            <th class="py-3 px-4">Total Amount</th>
                            <th class="py-3 px-4">Date & Time</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm font-semibold text-gray-700">
                        @forelse($sales ?? [] as $sale)
                            <tr class="hover:bg-gray-50/50">
                                <td class="py-4 px-4 text-gray-900 font-bold">#{{ $sale->id }}</td>
                                <td class="py-4 px-4">{{ $sale->customer_name ?? 'Walk-in Customer' }}</td>
                                <td class="py-4 px-4 text-[#70C116] font-bold">₱{{ number_format($sale->total_amount, 2) }}</td>
                                <td class="py-4 px-4 text-xs text-gray-400">{{ optional($sale->created_at)->format('M d, Y - h:i A') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-12 text-center text-gray-400 text-sm">
                                    No sales records found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(isset($sales) && method_exists($sales, 'links'))
                <div class="mt-6">
                    {{ $sales->links() }}
                </div>
            @endif
        </div>

    </div>

    <!-- SCRIPT FOR CHART.JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('dailySalesChart').getContext('2d');
            
            const labels = @json($dailyLabels ?? []);
            const dataValues = @json($dailyValues ?? []);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Revenue (₱)',
                        data: dataValues,
                        backgroundColor: dataValues.map(value => value >= 5000 ? '#70C116' : '#F59E0B'),
                        borderRadius: 12,
                        borderSkipped: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Revenue: ₱' + context.raw.toLocaleString();
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return '₱' + value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>