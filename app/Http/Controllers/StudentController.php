<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Student::all());
    }

   

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:student,email',
            'course' => 'required|string',
        ]);

        $student = Student::create($request->all());
        return response()->json($student, 201);
    }

    /**
     * Display the specified resource.
     */
    public function search(Request $request)
    {
        $search = $request->query('search');
    
        if ($search) {
            $students = Student::where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->get();
    
            if ($students->isNotEmpty()) {
                return response()->json($students);
            } else {
                return response()->json(['message' => 'Student not found'], 404);
            }
        }
    
        $students = Student::all();
        return response()->json($students);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $student = Student::find($student->id);
        if(is_null($student)){
            return response()->json(['message' => 'Student not found'], 404);
        }

        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:student,email',
            'course' => 'required|string',
        ]);

        $student->update($request->all());
        return response()->json([
            'message' => 'Student updated successfully',
            'student' => $student,
        ]);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student = Student::find($id);
        if(is_null($student)){
            return response()->json(['message' => 'Student not found'], 404);
        }
        $student->delete();
        return response()->json([
            'message' => 'student deleted successfully'
        ]);
    }
}
