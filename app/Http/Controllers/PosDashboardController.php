<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;     // <-- Na-import na ang Sale model
use App\Models\MenuItem; // <-- Na-import na ang MenuItem model

class PosDashboardController extends Controller
{
    public function index()
    {
        // Mag-fetch ng data gamit ang Sale model
        $todaySales = Sale::whereDate('created_at', today())->sum('total_amount') ?? 0;
        $todayOrdersCount = Sale::whereDate('created_at', today())->count();
        $totalMenuItems = MenuItem::count();

        return view('pos.dashboard', compact('todaySales', 'todayOrdersCount', 'totalMenuItems'));
    }
}