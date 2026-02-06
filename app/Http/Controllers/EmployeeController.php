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

        $sort = $request->get('sort');

        if ($sort) {
            // Handle sorting for columns from joined assets table
            if (in_array($sort, ['os', 'device_model'])) {
                $query->leftJoin('assets', 'employees.asset_id', '=', 'assets.asset_id')
                      ->select('employees.*') // Prevent column duplication
                      ->orderBy('assets.' . $sort, $request->get('order', 'desc'));
            } else {
                $query->sort($request);
            }
        } else {
            // Default sort by department and team
            $query->orderBy('department', 'asc')->orderBy('team', 'asc');
        }

        $employees = $query->get();
        return view('employees.list', compact('employees'));
    }

    public function create()
    {
        $employee = new Employee();
        $assignedAssetIds = Employee::whereNotNull('asset_id')->pluck('asset_id')->toArray();
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
        ]);

        Employee::create($validated);
        return redirect()->route('users.list')->with('success', 'User created successfully!');
    }

    public function edit(Employee $employee)
    {
        $assignedAssetIds = Employee::whereNotNull('asset_id')
            ->where('asset_id', '!=', $employee->asset_id)
            ->pluck('asset_id')
            ->toArray();
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
