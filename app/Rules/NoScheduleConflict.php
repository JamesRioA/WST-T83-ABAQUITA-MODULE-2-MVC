<?php

namespace App\Rules;

use App\Models\Enrollment;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NoScheduleConflict implements ValidationRule
{
    protected $studentId;
    protected $semester;
    protected $schoolYear;
    protected $excludeEnrollmentId;

    public function __construct($studentId, $semester, $schoolYear, $excludeEnrollmentId = null)
    {
        $this->studentId = $studentId;
        $this->semester = $semester;
        $this->schoolYear = $schoolYear;
        $this->excludeEnrollmentId = $excludeEnrollmentId;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $query = Enrollment::where('student_id', $this->studentId)
            ->where('semester', $this->semester)
            ->where('school_year', $this->schoolYear)
            ->where('schedule', $value);

        if ($this->excludeEnrollmentId) {
            $query->where('id', '!=', $this->excludeEnrollmentId);
        }

        if ($query->exists()) {
            $fail('The student already has a class scheduled at this time.');
        }
    }
}
