<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Subject;
use App\Http\Requests\EnrollmentRequest;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $enrollments = Enrollment::with(['student', 'subject'])->paginate(10);
        return view('admin.enrollments.index', compact('enrollments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('components.modals.enrollments.create', [
            'route' => route('enrollments.store')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EnrollmentRequest $request)
    {
        return $request->handle();
    }

    /**
     * Display the specified resource.
     */
    public function show(Enrollment $enrollment)
    {
        return view('components.modals.enrollments.show', compact('enrollment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Enrollment $enrollment)
    {
        return view('components.modals.enrollments.edit', [
            'enrollment' => $enrollment,
            'route' => route('enrollments.update', $enrollment)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EnrollmentRequest $request, Enrollment $enrollment)
    {
        return $request->handle($enrollment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();
        
        return response()->json([
            'message' => 'Enrollment deleted successfully'
        ]);
    }

    public function search(Request $request)
    {
        $term = $request->get('term');
        
        $students = Student::where('name', 'LIKE', "%{$term}%")
            ->orWhere('email', 'LIKE', "%{$term}%")
            ->limit(10)
            ->get(['id', 'name', 'email', 'course']);
        
        return response()->json($students);
    }
}
