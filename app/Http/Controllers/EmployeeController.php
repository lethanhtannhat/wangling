<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Asset;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    private function checkFeature($feature)
    {
        if (!config("features.{$feature}")) {
            abort(404);
        }
    }

    public function checkUnique(Request $request)
    {
        $field = $request->query('field', 'asset_id');
        $value = $request->query('value');
        $currentId = $request->query('current_id');
        
        $exists = Employee::where($field, $value)
            ->when($currentId, function($query) use ($currentId) {
                return $query->where('id', '!=', $currentId);
            })
            ->exists();

        return response()->json(['exists' => $exists]);
    }

    public function index()
    {
        $this->checkFeature('user_list');
        $employees = Employee::with('asset')->get();
        return view('employees.list', compact('employees'));
    }

    public function create()
    {
        $this->checkFeature('user_create');
        $employee = new Employee();
        return view('employees.form', compact('employee'));
    }

    public function store(Request $request)
    {
        $this->checkFeature('user_create');
        
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
        $this->checkFeature('user_edit');
        return view('employees.form', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $this->checkFeature('user_edit');
        
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
        $this->checkFeature('user_delete');
        $employee->delete();
        
        return redirect()->route('users.list')->with('success', 'User deleted successfully!');
    }
}
