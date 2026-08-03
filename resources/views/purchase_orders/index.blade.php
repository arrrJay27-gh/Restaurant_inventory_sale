<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Purchase Orders') }}</h2>
            <a href="{{ route('purchase_orders.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm transition">+ Create PO</a>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100 p-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">PO Number</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Supplier</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Total Amount</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($orders as $order)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-900 font-bold">{{ $order->po_number }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $order->supplier->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold">₱{{ number_format($order->total_amount, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                    <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-amber-100 text-amber-800 uppercase">{{ $order->status }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-sm text-gray-500">No active purchase invoices tracked yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
