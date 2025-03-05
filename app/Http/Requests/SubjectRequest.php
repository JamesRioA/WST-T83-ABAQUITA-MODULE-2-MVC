<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Subject;

class SubjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'subject_description' => 'required|string',
            'units' => 'required|integer|min:1|max:6'
        ];

        // Add unique validation for subject_code only on create or when code is changed
        if ($this->isMethod('post')) {
            $rules['subject_code'] = 'required|string|max:50|unique:subjects,subject_code';
        } else {
            $rules['subject_code'] = 'required|string|max:50|unique:subjects,subject_code,' . $this->subject->id;
        }

        return $rules;
    }

    public function handle(?Subject $subject = null)
    {
        $data = $this->validated();
        
        if ($this->isMethod('post')) {
            $subject = Subject::create($data);
        } else {
            $subject->update($data);
        }
        
        return response()->json([
            'message' => $this->isMethod('post') ? 'Subject created successfully' : 'Subject updated successfully',
            'subject' => $subject->fresh()
        ]);
    }
} 