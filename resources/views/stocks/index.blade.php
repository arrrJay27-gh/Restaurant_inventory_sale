<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Stock Movement Activity History') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date & Time</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Ingredient Item</th>
                                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Quantity Modified</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Reason / Reference</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Processed By</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($logs as $log)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $log->created_at->format('M d, Y h:i A') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                            {{ $log->item->name ?? 'Deleted Item' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                            @if($log->type === 'IN')
                                                <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800">📈 STOCK IN</span>
                                            @elseif($log->type === 'OUT')
                                                <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-red-100 text-red-800">📉 STOCK OUT</span>
                                            @else
                                                <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-amber-100 text-amber-800">🔄 ADJUSTMENT</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-semibold text-gray-900">
                                            {{ number_format($log->quantity, 2) }} <span class="text-xs text-gray-400">{{ $log->item->unit ?? '' }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $log->reason ?? 'No notes provided' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $log->user->name ?? 'System' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-500">
                                            No stock updates have been recorded yet. Use the "Adjust Stock" tool inside Raw Ingredients to change values!
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
