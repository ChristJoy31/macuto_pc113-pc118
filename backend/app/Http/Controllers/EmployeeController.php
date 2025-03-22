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
            'password' => 'required|string',
            'position' => 'required|string',
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->password);

        $employee = Employee::create($data);
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $employee = Employee::find($employee->id);
        if (is_null($employee)) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:employees,email',
            'password' => 'required|string',
            'position' => 'required|string',
        ]);

        $data = $request->all();
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $employee->update($data);
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