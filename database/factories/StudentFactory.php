<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition()
    {
        $user = User::factory()->create();
        
        return [
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'course' => fake()->randomElement(['BSIT', 'BSCS', 'BSIS']),
            'year_level' => fake()->randomElement(['1st Year', '2nd Year', '3rd Year', '4th Year']),
        ];
    }
} 