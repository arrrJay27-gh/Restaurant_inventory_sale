<?php

namespace App\Http\Controllers;

use App\Models\WasteLog;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;

class WasteLogController extends Controller
{
    /**
     * Display a listing of waste logs with summary analytics.
     */
    public function index(): View
    {
        $wasteLogsQuery = class_exists(WasteLog::class) ? WasteLog::with('item') : null;

        if (!$wasteLogsQuery) {
            return view('waste_logs.index', [
                'wasteLogs' => collect(),
                'items' => collect(),
                'totalWasteCount' => 0,
                'totalWasteCost' => 0,
                'thisMonthWasteCost' => 0,
            ]);
        }

        $wasteLogs = (clone $wasteLogsQuery)->latest()->paginate(10);
        $items = class_exists(Item::class) ? Item::orderBy('name')->get() : collect();

        // Metrics Calculation
        $totalWasteCount = (clone $wasteLogsQuery)->count();
        $totalWasteCost = (clone $wasteLogsQuery)->get()->sum(function ($log) {
            return ($log->quantity ?? 0) * ($log->cost_per_unit ?? $log->item->unit_price ?? 0);
        });

        $thisMonthWasteCost = (clone $wasteLogsQuery)
            ->where('created_at', '>=', Carbon::now()->startOfMonth())
            ->get()
            ->sum(function ($log) {
                return ($log->quantity ?? 0) * ($log->cost_per_unit ?? $log->item->unit_price ?? 0);
            });

        return view('waste_logs.index', compact(
            'wasteLogs',
            'items',
            'totalWasteCount',
            'totalWasteCost',
            'thisMonthWasteCost'
        ));
    }

    /**
     * Store a newly created waste log.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'item_id' => 'required',
            'quantity' => 'required|numeric|min:0.01',
            'reason' => 'required|string|max:255',
            'remarks' => 'nullable|string',
        ]);

        if (class_exists(WasteLog::class)) {
            $item = class_exists(Item::class) ? Item::find($request->item_id) : null;
            
            WasteLog::create([
                'item_id' => $request->item_id,
                'quantity' => $request->quantity,
                'cost_per_unit' => $item->unit_price ?? $item->cost ?? 0,
                'reason' => $request->reason,
                'remarks' => $request->remarks,
                'logged_by' => auth()->id(),
            ]);

            // Deduct from item stock if stock column exists
            if ($item && isset($item->quantity)) {
                $item->decrement('quantity', $request->quantity);
            }
        }

        return redirect()->route('waste-logs.index')->with('success', 'Waste log recorded successfully.');
    }

    /**
     * Remove the specified waste log.
     */
    public function destroy($id): RedirectResponse
    {
        if (class_exists(WasteLog::class)) {
            $log = WasteLog::findOrFail($id);
            $log->delete();
        }

        return redirect()->route('waste-logs.index')->with('success', 'Waste log deleted successfully.');
    }
}