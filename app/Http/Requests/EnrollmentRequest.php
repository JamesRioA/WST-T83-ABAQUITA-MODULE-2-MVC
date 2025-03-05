<?php

namespace App\Http\Requests;

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
        return [
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'section' => 'required|string|max:10',
            'semester' => 'required|string|in:1st Semester,2nd Semester,Summer',
            'school_year' => 'required|string|max:9',
            'schedule' => 'required|string|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'student_id.required' => 'Please select a student.',
            'student_id.exists' => 'The selected student is invalid.',
            'subject_id.required' => 'Please select a subject.',
            'subject_id.exists' => 'The selected subject is invalid.',
            'section.required' => 'Please enter a section.',
            'section.max' => 'Section code cannot exceed 10 characters.',
            'semester.required' => 'Please select a semester.',
            'semester.in' => 'Please select a valid semester.',
            'school_year.required' => 'Please enter a school year.',
            'school_year.max' => 'School year format should be YYYY-YYYY.',
            'schedule.required' => 'Please enter a schedule.',
            'schedule.max' => 'Schedule cannot exceed 50 characters.',
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