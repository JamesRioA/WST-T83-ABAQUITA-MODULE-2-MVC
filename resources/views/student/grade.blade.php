@extends('layouts.test')

@section('title')
    <title>
        Grades | Student Information System
    </title>
@endsection('title')

@section('breadcrumbs')
    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{route( Auth::user()->role . '-dashboard')}}">Pages</a></li>
        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">My Grades</li>
    </ol>
    <h6 class="font-weight-bolder mb-0">My Grades</h6>
@endsection('breadcrumbs')


@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>My Grades</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Subject</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Section</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Midterm Grade</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Final Grade</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($enrollments as $enrollment)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $enrollment->subject->subject_code }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $enrollment->subject->subject_description }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $enrollment->section }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="badge badge-sm bg-gradient-{{ $enrollment->grade && $enrollment->grade->midterm_grade <= 3.0 ? 'success' : 'danger' }}">
                                            {{ $enrollment->grade ? $enrollment->grade->midterm_grade : 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="badge badge-sm bg-gradient-{{ $enrollment->grade && $enrollment->grade->final_grade <= 3.0 ? 'success' : 'danger' }}">
                                            {{ $enrollment->grade ? $enrollment->grade->final_grade : 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="align-middle text-center">
                                        @if($enrollment->grade)
                                            @if(($enrollment->grade->midterm_grade + $enrollment->grade->final_grade) / 2 <= 3.0)
                                                <span class="text-secondary text-xs font-weight-bold">Passed</span>
                                            @else
                                                <span class="text-secondary text-xs font-weight-bold">Failed</span>
                                            @endif
                                        @else
                                            <span class="text-secondary text-xs font-weight-bold">No Grade Yet</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">No enrollments found</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection('content')
