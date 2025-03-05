<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\GradeController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('layouts.test');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/profile', function () {
    return view('profile');
})->middleware(['auth', 'verified'])->name('profile');

Route::middleware('auth')->group(function () {
    Route::get('/profile.edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile.update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile.destroy', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth' ,'role:admin'])->group(function () {
    Route::get('/admin-dashboard', function(){
        return view('admin.dashboard');
    })->name('admin-dashboard');

    // Admin routes for CRUD operations
   
    
    Route::resource('students', StudentController::class);
    Route::resource('subjects', SubjectController::class);
    Route::resource('enrollments', EnrollmentController::class);
    Route::resource('grades', GradeController::class);
});

Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/student-dashboard', function(){
        return view('student.dashboard');
    })->name('student-dashboard');

    // Student grade viewing route
    Route::get('/student-grade', [GradeController::class, 'studentGrades'])->name('student-grade');
});

// Add a direct test route for search
Route::get('/test-search', function(\Illuminate\Http\Request $request) {
    $term = $request->get('term');
    
    if (!$term) {
        return response()->json(['error' => 'No search term provided']);
    }
    
    $users = \App\Models\User::where(function($query) use ($term) {
            $query->where('name', 'LIKE', "%{$term}%")
                ->orWhere('email', 'LIKE', "%{$term}%");
        })
        ->limit(10)
        ->get(['id', 'name', 'email', 'role']);
    
    return response()->json($users);
});

// Add this before or after your other student routes
Route::get('test-search', [App\Http\Controllers\StudentController::class, 'search'])->name('students.search');

require __DIR__.'/auth.php';
