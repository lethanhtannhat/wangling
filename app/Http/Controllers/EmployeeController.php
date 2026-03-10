<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Asset;
use Illuminate\Http\Request;
use App\Traits\HandlesValidation;

class EmployeeController extends Controller
{
    use HandlesValidation;

    public function index(Request $request)
    {
        $query = Employee::with('asset');

        // 1. Filtering
        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        if ($request->filled('os')) {
            $query->whereHas('asset', function($q) use ($request) {
                $q->where('os', $request->os);
            });
        }

        // 2. Sorting
        $sort = $request->get('sort');

        if ($sort) {
            // Sorting for columns still in assets table
            if (in_array($sort, ['os', 'device_model'])) {
                $query->leftJoin('assets', 'employees.asset_id', '=', 'assets.asset_id')
                      ->select('employees.*')
                      ->orderBy('assets.' . $sort, $request->get('order', 'desc'));
            } else {
                $query->sort($request);
            }
        } else {
            $query->orderBy('department', 'asc')->orderBy('team', 'asc');
        }

        $employees = $query->get();
        $departments = Employee::distinct()->pluck('department')->filter()->sort();

        return view('employees.list', compact('employees', 'departments'));
    }

    public function create()
    {
        $employee = new Employee();
        $assignedEmployeeAssetIds = Employee::whereNotNull('asset_id')->pluck('asset_id')->toArray();
        $assignedStockAssetIds = \App\Models\Stock::whereNotNull('asset_id')->pluck('asset_id')->toArray();
        $assignedAssetIds = array_unique(array_merge($assignedEmployeeAssetIds, $assignedStockAssetIds));
        
        $assets = Asset::whereNotIn('asset_id', $assignedAssetIds)->orderBy('asset_id')->get();
        return view('employees.form', compact('employee', 'assets'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'department' => 'required|string|max:255',
            'team' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'asset_id' => 'required|string|max:255|unique:employees,asset_id',
            'os_version' => 'nullable|string|max:255',
            'encryption_status' => 'nullable|string|max:255',
            'user_type' => 'nullable|string|max:255',
            'admin_password_status' => 'nullable|string|max:255',
            'account_status' => 'nullable|string|max:255',
            'speedometer_score' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        Employee::create($validated);
        
        return redirect()->route('users.list')->with('success', 'User created successfully!');
    }

    public function edit(Employee $employee)
    {
        $assignedEmployeeAssetIds = Employee::whereNotNull('asset_id')
            ->where('asset_id', '!=', $employee->asset_id)
            ->pluck('asset_id')
            ->toArray();
        $assignedStockAssetIds = \App\Models\Stock::whereNotNull('asset_id')->pluck('asset_id')->toArray();
        $assignedAssetIds = array_unique(array_merge($assignedEmployeeAssetIds, $assignedStockAssetIds));
        
        $assets = Asset::whereNotIn('asset_id', $assignedAssetIds)->orderBy('asset_id')->get();
        return view('employees.form', compact('employee', 'assets'));
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'department' => 'required|string|max:255',
            'team' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'asset_id' => 'required|string|max:255|unique:employees,asset_id,' . $employee->id,
            'os_version' => 'nullable|string|max:255',
            'encryption_status' => 'nullable|string|max:255',
            'user_type' => 'nullable|string|max:255',
            'admin_password_status' => 'nullable|string|max:255',
            'account_status' => 'nullable|string|max:255',
            'speedometer_score' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $employee->update($validated);
        
        return redirect()->route('users.list')->with('success', 'User updated successfully!');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('users.list')->with('success', 'User deleted successfully!');
    }

    public function checkUnique(Request $request)
    {
        return $this->performUniqueCheck($request, Employee::class);
    }
}
