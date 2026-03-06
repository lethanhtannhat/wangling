<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Asset;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Traits\HandlesValidation;

class StockController extends Controller
{
    use HandlesValidation;

    public function index(Request $request)
    {
        $query = Stock::with('asset');

        $sort = $request->get('sort');

        if ($sort) {
            // Sorting for columns still in assets table
            if (in_array($sort, ['os', 'device_model'])) {
                $query->leftJoin('assets', 'stocks.asset_id', '=', 'assets.asset_id')
                      ->select('stocks.*')
                      ->orderBy('assets.' . $sort, $request->get('order', 'desc'));
            } else {
                $query->sort($request);
            }
        } else {
            // Default sort by department and name
            $query->orderBy('department', 'asc')->orderBy('name', 'asc');
        }

        $stocks = $query->get();
        return view('stocks.list', compact('stocks'));
    }

    public function create()
    {
        $stock = new Stock();
        // Get asset IDs assigned to either employees or stocks
        $assignedEmployeeAssetIds = Employee::whereNotNull('asset_id')->pluck('asset_id')->toArray();
        $assignedStockAssetIds = Stock::whereNotNull('asset_id')->pluck('asset_id')->toArray();
        $assignedAssetIds = array_unique(array_merge($assignedEmployeeAssetIds, $assignedStockAssetIds));
        
        $assets = Asset::whereNotIn('asset_id', $assignedAssetIds)->orderBy('asset_id')->get();
        return view('stocks.form', compact('stock', 'assets'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'asset_id' => 'required|string|max:255|unique:stocks,asset_id',
            'previous_user' => 'nullable|string',
            // Asset detail fields
            'os_version' => 'nullable|string|max:255',
            'encryption_status' => 'nullable|string|max:255',
            'admin_password_status' => 'nullable|string|max:255',
            'speedometer_score' => 'nullable|numeric|min:0',
        ]);

        Stock::create($validated);
        
        return redirect()->route('stocks.list')->with('success', 'Stock item created successfully!');
    }

    public function edit(Stock $stock)
    {
        $assignedEmployeeAssetIds = Employee::whereNotNull('asset_id')->pluck('asset_id')->toArray();
        $assignedStockAssetIds = Stock::whereNotNull('asset_id')
            ->where('asset_id', '!=', $stock->asset_id)
            ->pluck('asset_id')
            ->toArray();
        $assignedAssetIds = array_unique(array_merge($assignedEmployeeAssetIds, $assignedStockAssetIds));
        
        $assets = Asset::whereNotIn('asset_id', $assignedAssetIds)->orderBy('asset_id')->get();
        return view('stocks.form', compact('stock', 'assets'));
    }

    public function update(Request $request, Stock $stock)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'asset_id' => 'required|string|max:255|unique:stocks,asset_id,' . $stock->id,
            'previous_user' => 'nullable|string',
            // Asset detail fields
            'os_version' => 'nullable|string|max:255',
            'encryption_status' => 'nullable|string|max:255',
            'admin_password_status' => 'nullable|string|max:255',
            'speedometer_score' => 'nullable|numeric|min:0',
        ]);

        $stock->update($validated);
        
        return redirect()->route('stocks.list')->with('success', 'Stock item updated successfully!');
    }

    public function destroy(Stock $stock)
    {
        $stock->delete();
        return redirect()->route('stocks.list')->with('success', 'Stock item deleted successfully!');
    }

    public function checkUnique(Request $request)
    {
        return $this->performUniqueCheck($request, Stock::class);
    }
}
