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
        
        $exists = Employee::where($field, $value)->exists();

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
        return view('employees.form');
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

        return redirect()->route('dashboard')->with('success', 'User created successfully!');
    }
}
