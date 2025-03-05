<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Student;

class StudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'course' => 'required|string|max:255',
            'year_level' => 'required|string|max:50',
        ];

        // Add user_id requirement only for store (create) operation
        if ($this->isMethod('post')) {
            $rules['user_id'] = 'required|exists:users,id';
            $rules['email'] .= '|unique:students';
        }

        // Add unique email validation with ignore for update operation
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['email'] .= '|unique:students,email,' . $this->student->id;
        }

        return $rules;
    }

    /**
     * Handle the student creation/update process.
     */
    public function handle(?Student $student = null)
    {
        if ($this->isMethod('post')) {
            $student = Student::create($this->validated());
        } else {
            $student->update($this->validated());
        }
        
        return response()->json([
            'message' => $this->isMethod('post') ? 'Student created successfully' : 'Student updated successfully',
            'student' => $student->fresh()
        ]);
    }
} 