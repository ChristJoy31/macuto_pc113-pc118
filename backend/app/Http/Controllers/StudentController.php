<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function studentD()
    {
        return view('student.dashboard');
    }

    public function index()
    {
        return response()->json(Student::all());
    }

   

    public function store(Request $request)
    {
         $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string',
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
	
	if($search){
	    $student = Student::where('id', $search)
        ->orWhere('first_name', 'like', "%{$search}%")
	    ->orWhere('last_name', 'like', "%{$search}%")
	    ->orWhere('email', 'like', "%{$search}%")
	    ->get();

	  if($student->isNotEmpty()){
		return response()->json($student);
	}else{
		return response()->json([
			'message' => 'Student Not Found'], 404);
	}
	}
	
	$student = Student::all();
	return response()->json($student);
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
    public function update(Request $request, $id)
    {
        try {
            // Find student by ID
            $student = Student::findOrFail($id);
    
            // Validate request (ensure all fields are present)
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:students,email,' . $id,
                'course' => 'required|string|max:255',
            ]);
    
            // Update student
            $student->update($validated);
    
            return response()->json(['message' => 'Student updated successfully!', 'student' => $student], 200);
    
        } catch (\Exception $e) {
            // Catch errors and log them
            \Log::error('Error updating student: ' . $e->getMessage());
            return response()->json(['error' => 'Something went wrong!', 'details' => $e->getMessage()], 500);
        }
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
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
