<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Carbon\Carbon;

class SalesController extends Controller
{
    public function index(Request $request): View
    {
        // 1. Target Benta kada araw (e.g., ₱5,000 baseline)
        $dailyTarget = 5000;

        // 2. Kuhanin ang Benta Ngayong Araw (Today)
        $todaySales = 0;
        if (class_exists(Sale::class)) {
            $todaySales = Sale::whereDate('created_at', Carbon::today())->sum('total_amount') ?? 0;
        } elseif (class_exists(Order::class)) {
            $todaySales = Order::whereDate('created_at', Carbon::today())->sum('total_amount') ?? 0;
        }

        // Status ngayong araw (Malakas vs Mahina)
        $todayStatus = $todaySales >= $dailyTarget ? 'Malakas' : 'Mahina';
        $todayPercentage = min(100, round(($todaySales / $dailyTarget) * 100, 1));

        // 3. Daily Sales Analytics para sa Huling 7 Araw (Graph Data)
        $dailyChartLabels = [];
        $dailyChartData = [];
        $dailyStatuses = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dailyChartLabels[] = $date->format('D (M d)');

            $daySales = 0;
            if (class_exists(Sale::class)) {
                $daySales = (float) Sale::whereDate('created_at', $date->toDateString())->sum('total_amount');
            } elseif (class_exists(Order::class)) {
                $daySales = (float) Order::whereDate('created_at', $date->toDateString())->sum('total_amount');
            }

            $dailyChartData[] = $daySales;
            $dailyStatuses[] = $daySales >= $dailyTarget ? 'Malakas' : 'Mahina';
        }

        // 4. Kuhanin ang Sales List
        $salesList = collect();
        if (class_exists(Sale::class)) {
            $salesList = Sale::latest()->paginate(10);
        } elseif (class_exists(Order::class)) {
            $salesList = Order::latest()->paginate(10);
        }

        // Summary Totals
        $totalRevenue = array_sum($dailyChartData);
        $averageDaily = count($dailyChartData) > 0 ? $totalRevenue / count($dailyChartData) : 0;

        return view('sales.index', compact(
            'salesList',
            'todaySales',
            'todayStatus',
            'todayPercentage',
            'dailyTarget',
            'dailyChartLabels',
            'dailyChartData',
            'dailyStatuses',
            'totalRevenue',
            'averageDaily'
        ));
    }
}