<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\Student;
use App\Http\Requests\GradeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grades = Grade::with(['enrollment.student', 'enrollment.subject'])->paginate(10);
        return view('admin.grades.index', compact('grades'));
    }

    /**
     * Display student grades
     */
    public function studentGrades(Request $request)
    {
        // Get the authenticated student's ID
        $studentId = Auth::user()->student->id;
        
        // Get unique school years for the filter
        $schoolYears = Enrollment::where('student_id', $studentId)
            ->distinct()
            ->pluck('school_year')
            ->sort()
            ->values();

        // Build the query
        $query = Grade::whereHas('enrollment', function($q) use ($studentId) {
            $q->where('student_id', $studentId);
        })->with(['enrollment.subject']);

        // Apply filters if present
        if ($request->filled('school_year')) {
            $query->whereHas('enrollment', function($q) use ($request) {
                $q->where('school_year', $request->school_year);
            });
        }

        if ($request->filled('semester')) {
            $query->whereHas('enrollment', function($q) use ($request) {
                $q->where('semester', $request->semester);
            });
        }

        // Get the grades with pagination
        $grades = $query->orderBy('created_at', 'desc')->paginate(10);

        // Keep the filters in pagination links
        $grades->appends($request->only(['school_year', 'semester']));

        return view('student.grades.index', compact('grades', 'schoolYears'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('components.modals.grades.create', [
            'route' => route('grades.store')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GradeRequest $request)
    {
        return $request->handle();
    }

    /**
     * Display the specified resource.
     */
    public function show(Grade $grade)
    {
        return view('components.modals.grades.show', compact('grade'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Grade $grade)
    {
        return view('components.modals.grades.edit', [
            'grade' => $grade,
            'route' => route('grades.update', $grade)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GradeRequest $request, Grade $grade)
    {
        return $request->handle($grade);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grade $grade)
    {
        $grade->delete();
        
        return response()->json([
            'message' => 'Grade deleted successfully!'
        ]);
    }
}
