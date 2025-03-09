<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use App\Http\Requests\StudentRequest;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Student::query();
        
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('course', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('year_level', 'LIKE', "%{$searchTerm}%");
            });
        }
        
        $students = $query->paginate(10);
        
        // Keep the search term in pagination links
        $students->appends(['search' => $request->search]);
        
        return view('admin.students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('components.modals.students.create', [
            'route' => route('students.store')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentRequest $request)
    {
        return $request->handle();
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        return view('components.modals.students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        return view('components.modals.students.edit', [
            'student' => $student,
            'route' => route('students.update', $student)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StudentRequest $request, Student $student)
    {
        return $request->handle($student);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return response()->json([
            'message' => 'Student deleted successfully!'
        ]);
    }

    /**
     * Search for users by name or email for autocomplete.
     */
    public function search(Request $request)
    {
        $term = $request->get('term');
        
        $users = User::where('role', 'student') // Ensure only students are retrieved
            ->where(function ($query) use ($term) {
                $query->where('name', 'LIKE', "%{$term}%")
                      ->orWhere('email', 'LIKE', "%{$term}%");
            })
            ->limit(10)
            ->get()
            ->map(function($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ];
            });

        return response()->json($users);
    }
}
