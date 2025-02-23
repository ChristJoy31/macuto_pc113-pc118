<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
            'position' => 'required|string',
        ]);

        $employee = Employee::create($request->all());
        return response()->json($employee, 201);
    }

    /**
     * Display the specified resource.
     */
    public function search(Request $request)
{
    
    $search = $request->query('search');

    if ($search) {
        $employees = Employee::where('first_name', 'like', "%{$search}%")
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


    
    public function update(Request $request, Employee $employee)
    {
        $employee = Employee::find($employee->id);
        if(is_null($employee)){
            return response()->json(['message' => 'Employee not found'], 404);
        }

        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:employees,email',
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
    public function destroy(Employee $employee)
    {
        $employee = Employee::find($id);
        if(is_null($employee)){
            return response()->json(['message' => 'Employee not found'], 404);
        }
        $employee->delete();
        return response()->json([
            'message' => 'Employee deleted successfully'
        ]);
    }
}
