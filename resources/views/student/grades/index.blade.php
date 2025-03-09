@extends('layouts.test')

@section('title')
    <title>
        My Grades | Student Information System
    </title>
@endsection('title')

@section('breadcrumbs')
    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{route('student-dashboard')}}">Pages</a></li>
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
                    <div class="d-flex justify-content-between align-items-center">
                        <h6>My Grades</h6>
                        @if(!isset($notStudent))
                        <div class="d-flex gap-2">
                            <select class="form-control form-control-sm" id="school_year" style="width: 150px;">
                                <option value="">All School Years</option>
                                @foreach($schoolYears as $year)
                                    <option value="{{ $year }}" {{ request('school_year') == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                            <select class="form-control form-control-sm" id="semester" style="width: 150px;">
                                <option value="">All Semesters</option>
                                <option value="1st Semester" {{ request('semester') == '1st Semester' ? 'selected' : '' }}>1st Semester</option>
                                <option value="2nd Semester" {{ request('semester') == '2nd Semester' ? 'selected' : '' }}>2nd Semester</option>
                                <option value="Summer" {{ request('semester') == 'Summer' ? 'selected' : '' }}>Summer</option>
                            </select>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    @if(isset($notStudent))
                        <div class="text-center py-4">
                            <p class="text-lg font-weight-bold">You are not added as a student yet.</p>
                        </div>
                    @else
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">SUBJECT CODE</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">DESCRIPTION</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">SECTION</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">SEMESTER</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">SCHOOL YEAR</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">MIDTERM</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">FINALS</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">AVERAGE</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">REMARKS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($grades as $grade)
                                    <tr>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0 px-3">{{ $grade->enrollment->subject->subject_code }}</p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0 px-3">{{ $grade->enrollment->subject->subject_description }}</p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0 px-3">{{ $grade->enrollment->section }}</p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0 px-3">{{ $grade->enrollment->semester }}</p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0 px-3">{{ $grade->enrollment->school_year }}</p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0 px-3">{{ $grade->midterm_grade }}</p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0 px-3">{{ $grade->final_grade }}</p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0 px-3">{{ $grade->average_grade }}</p>
                                        </td>
                                        <td>
                                            <span class="badge badge-sm {{ $grade->remarks === 'Passed' ? 'bg-gradient-success' : ($grade->remarks === 'Incomplete' ? 'bg-gradient-warning' : 'bg-gradient-danger') }}">
                                                {{ $grade->remarks }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="text-center">
                                            <p class="text-sm font-weight-bold mb-0">No grades found</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="px-3 pt-4">
                            {{ $grades->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Handle filter changes
    $('#school_year, #semester').change(function() {
        const schoolYear = $('#school_year').val();
        const semester = $('#semester').val();
        
        // Build the URL with filter parameters
        let url = new URL(window.location.href);
        let params = new URLSearchParams(url.search);
        
        // Update or remove parameters based on selection
        if (schoolYear) {
            params.set('school_year', schoolYear);
        } else {
            params.delete('school_year');
        }
        
        if (semester) {
            params.set('semester', semester);
        } else {
            params.delete('semester');
        }
        
        // Redirect to filtered URL
        window.location.href = `${url.pathname}?${params.toString()}`;
    });
});
</script>
@endpush 