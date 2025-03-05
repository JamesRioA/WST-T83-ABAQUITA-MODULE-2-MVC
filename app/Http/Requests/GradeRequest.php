<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Grade;

class GradeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        $validGrades = array_map(function($grade) {
            return is_numeric($grade) ? number_format($grade, 2) : $grade;
        }, Grade::VALID_GRADES);

        return [
            'enrollment_id' => 'required|exists:enrollments,id',
            'midterm_grade' => ['required', 'in:' . implode(',', $validGrades)],
            'final_grade' => ['required', 'in:' . implode(',', $validGrades)],
        ];
    }

    public function messages(): array
    {
        return [
            'enrollment_id.required' => 'Please select an enrollment.',
            'enrollment_id.exists' => 'The selected enrollment is invalid.',
            'midterm_grade.required' => 'Please select a midterm grade.',
            'midterm_grade.in' => 'The selected midterm grade is invalid.',
            'final_grade.required' => 'Please select a final grade.',
            'final_grade.in' => 'The selected final grade is invalid.',
        ];
    }

    public function handle(?Grade $grade = null)
    {
        $data = $this->validated();
        
        if ($this->isMethod('post')) {
            $grade = Grade::create($data);
        } else {
            $grade->update($data);
        }
        
        return response()->json([
            'message' => $this->isMethod('post') ? 'Grade created successfully' : 'Grade updated successfully',
            'grade' => $grade->fresh()
        ]);
    }
} 