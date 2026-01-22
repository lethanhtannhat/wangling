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

        // Handle sorting for columns from joined assets table
        if (in_array($request->get('sort'), ['os', 'device_model'])) {
            $query->leftJoin('assets', 'employees.asset_id', '=', 'assets.asset_id')
                  ->select('employees.*') // Prevent column duplication
                  ->orderBy('assets.' . $request->get('sort'), $request->get('order', 'desc'));
        } else {
            $query->sort($request);
        }

        $employees = $query->get();
        return view('employees.list', compact('employees'));
    }

    public function create()
    {
        $employee = new Employee();
        return view('employees.form', compact('employee'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'department' => 'nullable|string|max:255',
            'team' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'asset_id' => 'nullable|string|max:255|unique:employees,asset_id',
        ]);

        Employee::create($validated);
        return redirect()->route('users.list')->with('success', 'User created successfully!');
    }

    public function edit(Employee $employee)
    {
        return view('employees.form', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'department' => 'nullable|string|max:255',
            'team' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'asset_id' => 'nullable|string|max:255|unique:employees,asset_id,' . $employee->id,
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
