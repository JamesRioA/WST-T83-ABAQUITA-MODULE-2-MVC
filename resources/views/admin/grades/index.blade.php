@extends('layouts.test')

@section('title')
    <title>
        Grades | Student Information System
    </title>
@endsection('title')

@section('breadcrumbs')
    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{route( Auth::user()->role . '-dashboard')}}">Pages</a></li>
        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Grades</li>
    </ol>
    <h6 class="font-weight-bolder mb-0">Grades</h6>
@endsection('breadcrumbs')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6>Grades Management</h6>
                        <button type="button" class="btn bg-gradient-primary mb-0" 
                            onclick="openModal('{{ route('grades.create') }}')">
                            <i class="fas fa-plus"></i>&nbsp;&nbsp;Add Grade
                        </button>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mx-4" role="alert">
                            <span class="alert-text">{{ session('success') }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mx-4" role="alert">
                            <span class="alert-text">{{ session('error') }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">STUDENT</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">SUBJECT</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">SECTION</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">MIDTERM</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">FINALS</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">AVERAGE</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">REMARKS</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($grades as $grade)
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $grade->enrollment->student->name }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $grade->enrollment->student->course }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $grade->enrollment->subject->subject_code }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $grade->enrollment->subject->subject_description }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0 px-3">{{ $grade->enrollment->section }}</p>
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
                                        <span class="badge badge-sm px-3 {{ $grade->remarks === 'Passed' ? 'bg-gradient-success' : ($grade->remarks === 'Incomplete' ? 'bg-gradient-warning' : 'bg-gradient-danger') }}">
                                            {{ $grade->remarks }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <button class="btn btn-link text-secondary mb-0" 
                                                onclick="openModal('{{ route('grades.show', $grade) }}')">
                                                <i class="fas fa-eye text-xs"></i>
                                            </button>
                                            <button class="btn btn-link text-secondary mb-0" 
                                                onclick="openModal('{{ route('grades.edit', $grade) }}')">
                                                <i class="fas fa-edit text-xs"></i>
                                            </button>
                                            <button class="btn btn-link text-secondary mb-0" 
                                                onclick="deleteGrade('{{ route('grades.destroy', $grade) }}')">
                                                <i class="fas fa-trash text-xs"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">
                                        <p class="text-sm font-weight-bold mb-0">No grades found</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="px-3 pt-4">
                        {{ $grades->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Container -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true"></div>

@endsection

@push('scripts')
<script>
function openModal(url) {
    $.get(url, function(data) {
        $("#modal").html(data);
        var modal = new bootstrap.Modal(document.getElementById('modal'));
        modal.show();
    }).fail(function(xhr) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to load modal content'
        });
    });
}

function deleteGrade(url) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong!'
                    });
                }
            });
        }
    });
}
</script>
@endpush 