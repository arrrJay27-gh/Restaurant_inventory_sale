<x-app-layout>
    <div class="p-6 bg-white rounded-lg shadow-sm">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800">Sales Register</h2>
            <a href="{{ route('sales.create') }}" class="bg-emerald-600 text-white px-4 py-2 rounded-md hover:bg-emerald-700 transition inline-block">
                Record Sale
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b text-gray-500 font-medium bg-gray-50">
                        <th class="py-3 px-4">INVOICE NO</th>
                        <th class="py-3 px-4 text-right">TOTAL AMOUNT</th>
                        <th class="py-3 px-4">ORDER TYPE</th>
                        <th class="py-3 px-4">PAYMENT METHOD</th>
                        <th class="py-3 px-4">STATUS</th>
                        <th class="py-3 px-4">DATE</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales as $sale)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="py-3 px-4 font-semibold text-emerald-600">{{ $sale->sale_number }}</td>
                            <td class="py-3 px-4 text-right font-bold text-gray-900">${{ number_format($sale->total_amount, 2) }}</td>
                            <td class="py-3 px-4 capitalize text-gray-700">{{ $sale->order_type }}</td>
                            <td class="py-3 px-4 capitalize text-gray-700">{{ $sale->payment_method }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 rounded text-xs font-bold uppercase bg-green-100 text-green-800">
                                    {{ $sale->status }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-gray-500">{{ $sale->created_at->format('M d, Y h:i A') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-gray-400">No sales transactions logged yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $sales->links() }}
        </div>
    </div>
</x-app-layout>
