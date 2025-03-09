<?php

namespace App\Http\Requests;

use App\Rules\NoScheduleConflict;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;

class EnrollmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        $enrollmentId = $this->route('enrollment')?->id;

        return [
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'semester' => 'required|in:1st Semester,2nd Semester,Summer',
            'school_year' => 'required|regex:/^\d{4}-\d{4}$/',
            'section' => 'required|string|max:10',
            'schedule' => [
                'required',
                'string',
                new NoScheduleConflict(
                    $this->input('student_id'),
                    $this->input('semester'),
                    $this->input('school_year'),
                    $enrollmentId
                )
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'student_id.required' => 'Please select a student.',
            'student_id.exists' => 'The selected student is invalid.',
            'subject_id.required' => 'Please select a subject.',
            'subject_id.exists' => 'The selected subject is invalid.',
            'semester.required' => 'Please select a semester.',
            'semester.in' => 'Invalid semester selected.',
            'school_year.required' => 'Please enter a school year.',
            'school_year.regex' => 'School year must be in format YYYY-YYYY.',
            'section.required' => 'Please enter a section.',
            'section.max' => 'Section code cannot exceed 10 characters.',
            'schedule.required' => 'Please enter a schedule.',
        ];
    }

    public function handle(?Enrollment $enrollment = null)
    {
        $data = $this->validated();
        
        if ($this->isMethod('post')) {
            $enrollment = Enrollment::create($data);
        } else {
            $enrollment->update($data);
        }
        
        return response()->json([
            'message' => $this->isMethod('post') ? 'Enrollment created successfully' : 'Enrollment updated successfully',
            'enrollment' => $enrollment->fresh()
        ]);
    }
} 