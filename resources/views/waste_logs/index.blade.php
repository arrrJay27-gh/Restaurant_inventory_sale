<x-app-layout>
    <!-- Alpine.js (para sa Modal toggle) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <div x-data="{ openModal: false }" class="sm:ml-64 bg-[#F6FAF3] min-h-screen p-6 md:p-8">
        
        <!-- TOP HEADER BAR -->
        <header class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-[#1A2E12] tracking-tight">Waste & Spoilage Logs</h1>
                <p class="text-sm text-gray-500 mt-1">Track damaged, expired, or discarded inventory items and costs.</p>
            </div>
            
            <div class="flex items-center gap-3">
                <button @click="openModal = true" class="bg-[#70C116] hover:bg-[#5eab0f] text-white font-bold px-5 py-2.5 rounded-2xl shadow-sm transition flex items-center gap-2 text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Log Waste Item
                </button>

                <div class="flex items-center gap-3 bg-white px-4 py-2 rounded-2xl border border-green-100/80 shadow-sm">
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
            </div>
        </header>

        <!-- FLASH SUCCESS MESSAGE -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-200 text-green-800 rounded-2xl text-sm font-semibold flex items-center justify-between">
                <span>{{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="text-green-900 font-bold">&times;</button>
            </div>
        @endif

        <!-- ANALYTICS SUMMARY CARDS -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-3xl border border-green-100 shadow-sm">
                <p class="text-xs font-bold uppercase tracking-wider text-gray-400">TOTAL WASTE LOGS</p>
                <h2 class="text-3xl font-black text-gray-900 mt-1">{{ number_format($totalWasteCount ?? 0) }}</h2>
                <p class="text-xs text-gray-400 mt-2">Recorded waste incidents</p>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-green-100 shadow-sm">
                <p class="text-xs font-bold uppercase tracking-wider text-gray-400">THIS MONTH'S LOSS</p>
                <h2 class="text-3xl font-black text-rose-600 mt-1">₱{{ number_format($thisMonthWasteCost ?? 0, 2) }}</h2>
                <p class="text-xs text-gray-400 mt-2">Estimated cost this month</p>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-green-100 shadow-sm">
                <p class="text-xs font-bold uppercase tracking-wider text-gray-400">ALL-TIME WASTE COST</p>
                <h2 class="text-3xl font-black text-gray-900 mt-1">₱{{ number_format($totalWasteCost ?? 0, 2) }}</h2>
                <p class="text-xs text-gray-400 mt-2">Total financial inventory loss</p>
            </div>
        </div>

        <!-- WASTE LOGS TABLE -->
        <div class="bg-white p-6 rounded-3xl border border-green-100 shadow-sm">
            <h3 class="text-lg font-extrabold text-gray-900 mb-4">Waste History & Records</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 text-xs font-bold text-gray-400 uppercase">
                            <th class="py-3 px-4">Item Name</th>
                            <th class="py-3 px-4">Qty</th>
                            <th class="py-3 px-4">Est. Total Cost</th>
                            <th class="py-3 px-4">Reason</th>
                            <th class="py-3 px-4">Logged Date</th>
                            <th class="py-3 px-4 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm font-semibold text-gray-700">
                        @forelse($wasteLogs ?? [] as $log)
                            @php
                                $unitCost = $log->cost_per_unit ?? $log->item->unit_price ?? 0;
                                $totalCost = ($log->quantity ?? 0) * $unitCost;
                            @endphp
                            <tr class="hover:bg-gray-50/50">
                                <td class="py-4 px-4 text-gray-900 font-bold">
                                    {{ $log->item->name ?? $log->item_name ?? 'Unknown Item' }}
                                </td>
                                <td class="py-4 px-4 text-gray-800">
                                    {{ $log->quantity }} {{ $log->item->unit ?? 'pcs' }}
                                </td>
                                <td class="py-4 px-4 text-rose-600 font-bold">
                                    ₱{{ number_format($totalCost, 2) }}
                                </td>
                                <td class="py-4 px-4">
                                    <span class="px-3 py-1 text-xs font-bold rounded-full bg-rose-100 text-rose-700">
                                        {{ ucfirst($log->reason ?? 'Spoiled') }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-xs text-gray-400">
                                    {{ optional($log->created_at)->format('M d, Y - h:i A') }}
                                </td>
                                <td class="py-4 px-4 text-right">
                                    <form action="{{ route('waste-logs.destroy', $log->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this log?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs font-bold text-red-500 hover:text-red-700 bg-red-50 px-3 py-1.5 rounded-xl transition">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-gray-400 text-sm">
                                    No waste logs recorded yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(isset($wasteLogs) && method_exists($wasteLogs, 'links'))
                <div class="mt-6">
                    {{ $wasteLogs->links() }}
                </div>
            @endif
        </div>

        <!-- CREATE WASTE LOG MODAL -->
        <div x-show="openModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
            <div @click.away="openModal = false" class="bg-white rounded-3xl p-6 md:p-8 max-w-md w-full shadow-2xl">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-extrabold text-gray-900">Record Waste Item</h3>
                    <button @click="openModal = false" class="text-gray-400 hover:text-gray-600 text-2xl font-bold">&times;</button>
                </div>

                <form action="{{ route('waste-logs.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Select Item</label>
                        <select name="item_id" required class="w-full bg-gray-50 border border-gray-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:border-[#70C116]">
                            <option value="" disabled selected>Choose an item...</option>
                            @foreach($items ?? [] as $item)
                                <option value="{{ $item->id }}">{{ $item->name }} (Available: {{ $item->quantity ?? 0 }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Quantity Lost</label>
                        <input type="number" step="0.01" name="quantity" required placeholder="0.00" class="w-full bg-gray-50 border border-gray-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:border-[#70C116]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Reason</label>
                        <select name="reason" required class="w-full bg-gray-50 border border-gray-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:border-[#70C116]">
                            <option value="Spoiled / Expired">Spoiled / Expired</option>
                            <option value="Damaged Packaging">Damaged Packaging</option>
                            <option value="Spill / Prep Error">Spill / Prep Error</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Remarks (Optional)</label>
                        <textarea name="remarks" rows="2" placeholder="Additional details..." class="w-full bg-gray-50 border border-gray-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:border-[#70C116]"></textarea>
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button type="button" @click="openModal = false" class="w-1/2 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-2xl text-sm transition">Cancel</button>
                        <button type="submit" class="w-1/2 py-3 bg-[#70C116] hover:bg-[#5eab0f] text-white font-bold rounded-2xl text-sm shadow-sm transition">Save Log</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>