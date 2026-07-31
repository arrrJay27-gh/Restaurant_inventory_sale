@php
use App\Models\Ingredient;
use App\Models\MenuItem;
use App\Models\Order;

$totalItems = class_exists(Ingredient::class) ? Ingredient::count() : 0;
$totalMenuItems = class_exists(MenuItem::class) ? MenuItem::count() : 0;
$totalSales = class_exists(Order::class) ? Order::count() : 0;
$totalSuppliers = 0;
$totalWaste = 0;
$lowStock = 0;
$purchaseOrdersCount = 0;
$totalRevenue = 0;
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Dashboard') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500">Restaurant inventory, sales, and waste overview.</p>
            </div>
            <div class="text-right">
                <p class="text-sm font-medium text-gray-600">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-500">Inventory Manager</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
                <div class="rounded-xl bg-white border border-slate-200 p-6 shadow-sm">
                    <p class="text-sm font-semibold text-slate-500">Total Ingredients</p>
                    <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $totalItems }}</p>
                    <p class="mt-2 text-sm text-slate-500">Active raw ingredients.</p>
                </div>

                <div class="rounded-xl bg-white border border-slate-200 p-6 shadow-sm">
                    <p class="text-sm font-semibold text-slate-500">Menu Items</p>
                    <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $totalMenuItems }}</p>
                    <p class="mt-2 text-sm text-slate-500">Configured dishes and POS products.</p>
                </div>

                <div class="rounded-xl bg-white border border-slate-200 p-6 shadow-sm">
                    <p class="text-sm font-semibold text-slate-500">Sales Transactions</p>
                    <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $totalSales }}</p>
                    <p class="mt-2 text-sm text-slate-500">Completed orders captured by POS.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>