<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Log Waste / Spoilage') }}</h2>
                <p class="mt-1 text-sm text-gray-500">Record wasted ingredients and adjust stock automatically.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                @if ($errors->any())
                    <div class="mb-6 rounded-lg bg-red-50 border border-red-200 p-4 text-red-700">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('waste-logs.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Item</label>
                        <select name="item_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="">Select item</option>
                            @foreach($items as $item)
                                <option value="{{ $item->id }}" @selected(old('item_id') == $item->id)>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Quantity</label>
                        <input type="number" step="0.001" name="quantity" value="{{ old('quantity') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Reason</label>
                        <textarea name="reason" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('reason') }}</textarea>
                    </div>

                    <div class="flex items-center justify-end gap-4">
                        <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900">Cancel</a>
                        <button type="submit" class="inline-flex items-center justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Log Waste</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
