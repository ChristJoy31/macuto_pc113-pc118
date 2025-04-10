<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function employee()
    {
        return view('employee.dashboard');
    }

    public function index()
    {
        return response()->json(Employee::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'email' => 'required|email|unique:employees,email',
        'password' => 'required|string|min:8', 
        'position' => 'required|string',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    if ($request->hasFile('photo')) {
        $photoPath = $request->file('photo')->store('employee_photos', 'public');
    } else {
        $photoPath = null;
    }

    $employee = Employee::create([
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'position' => $request->position,
        'photo' => $photoPath,
    ]);

    return response()->json(['message' => 'Employee Created successfully'], 200);
}

        /**
     * Display the specified resource.
     */
    public function search(Request $request)
    {
        $search = $request->query('find');

        if ($search) {
            $employees = Employee::where('id', $search)
                ->orWhere('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->get();

            if ($employees->isNotEmpty()) {
                return response()->json($employees);
            } else {
                return response()->json(['message' => 'Employee not found'], 404);
            }
        }

        $employees = Employee::all();
        return response()->json($employees);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $employee = Employee::find($id);
    
        if (!$employee) {
            return response()->json(['message' => 'User not found'], 404);
        }
    
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:employees,email,' . $id,
            'position' => 'required|string',
        ]);
    
        $employee->update($request->all());
    
        return response()->json([
            'message' => 'Employee updated successfully',
            'employee' => $employee,
        ]);
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);
        if (is_null($employee)) {
            return response()->json(['message' => 'Employee not found'], 404);
        }
        $employee->delete();
        return response()->json([
            'message' => 'Employee deleted successfully'
        ]);
    }
}