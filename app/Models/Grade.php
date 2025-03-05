<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'enrollment_id',
        'midterm_grade',
        'final_grade',
    ];

    protected $appends = ['average_grade', 'remarks'];

    // Valid grades
    const VALID_GRADES = [
        1.00, 1.25, 1.50, 1.75, 
        2.00, 2.25, 2.50, 2.75, 
        3.00, 5.00, 'INC'
    ];

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function student()
    {
        return $this->enrollment->student;
    }

    public function subject()
    {
        return $this->enrollment->subject;
    }

    public function getAverageGradeAttribute()
    {
        // If either grade is INC, return INC
        if ($this->midterm_grade === 'INC' || $this->final_grade === 'INC') {
            return 'INC';
        }

        // Calculate weighted average (midterm 1/3, finals 2/3)
        $midterm = floatval($this->midterm_grade);
        $finals = floatval($this->final_grade);
        
        return round(($midterm * (1/3) + $finals * (2/3)), 2);
    }

    public function getRemarksAttribute()
    {
        if ($this->average_grade === 'INC') {
            return 'Incomplete';
        }

        $average = floatval($this->average_grade);
        
        if ($average >= 1.00 && $average <= 3.00) {
            return 'Passed';
        }
        
        return 'Failed';
    }
}
