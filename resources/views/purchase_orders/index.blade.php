<x-app-layout>
    <!-- MAIN CONTAINER WITH LEFT MARGIN FOR SIDEBAR -->
    <div class="sm:ml-64 bg-[#F6FAF3] min-h-screen p-6 md:p-8">
        
        <!-- TOP HEADER BAR -->
        <header class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-[#1A2E12] tracking-tight">Purchase Orders</h1>
                <p class="text-sm text-gray-500 mt-1">Overview of orders placed by customers and procurement status.</p>
            </div>
            
            <div class="flex items-center gap-3">
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
            </div>
        </header>

        <!-- MAIN TABLE CONTAINER -->
        <div class="bg-white p-6 rounded-3xl border border-green-100 shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 text-xs font-bold text-gray-400 uppercase">
                            <th class="py-3 px-4">PO Number</th>
                            <th class="py-3 px-4">Customer / Supplier</th>
                            <th class="py-3 px-4">Total Amount</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4">Created</th>
                            <th class="py-3 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm font-semibold text-gray-700">
                        @forelse($purchaseOrders ?? [] as $po)
                            <tr class="hover:bg-gray-50/50">
                                <td class="py-4 px-4 text-gray-900 font-bold">#{{ $po->po_number ?? $po->id }}</td>
                                <td class="py-4 px-4">{{ $po->customer_name ?? $po->supplier->name ?? $po->supplier_name ?? 'Customer Order' }}</td>
                                <td class="py-4 px-4 text-[#70C116] font-bold">₱{{ number_format($po->total_amount ?? 0, 2) }}</td>
                                <td class="py-4 px-4">
                                    <span class="px-3 py-1 text-xs font-bold rounded-full 
                                        {{ strtolower($po->status ?? '') === 'received' || strtolower($po->status ?? '') === 'completed' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                                        {{ ucfirst($po->status ?? 'Pending') }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-xs text-gray-400">{{ optional($po->created_at)->format('M d, Y') ?? 'N/A' }}</td>
                                <td class="py-4 px-4 text-right">
                                    <a href="{{ route('purchase-orders.show', $po->id) }}" class="text-xs font-bold text-gray-600 hover:text-gray-900 bg-gray-100 px-3 py-1.5 rounded-xl transition">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-gray-400 text-sm">
                                    No purchase orders found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- PAGINATION LINKS -->
            @if(isset($purchaseOrders) && method_exists($purchaseOrders, 'links'))
                <div class="mt-6">
                    {{ $purchaseOrders->links() }}
                </div>
            @endif
        </div>

    </div>
</x-app-layout>