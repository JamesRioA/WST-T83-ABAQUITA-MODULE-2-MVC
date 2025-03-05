@extends('layouts.test')

@section('title')
    <title>
        Enrollments | Student Information System
    </title>
@endsection('title')

@section('breadcrumbs')
    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{route( Auth::user()->role . '-dashboard')}}">Pages</a></li>
        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Enrollments</li>
    </ol>
    <h6 class="font-weight-bolder mb-0">Enrollments</h6>
@endsection('breadcrumbs')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6>Enrollments Management</h6>
                        <button type="button" class="btn bg-gradient-primary mb-0" 
                            onclick="openCreateModal()">
                            <i class="fa fa-plus"></i>&nbsp;&nbsp;Add Enrollment
                        </button>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div id="alert-container" class="mx-4">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <span class="alert-icon"><i class="fas fa-check-circle"></i></span>
                                <span class="alert-text">{{ session('success') }}</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <span class="alert-icon"><i class="fas fa-times-circle"></i></span>
                                <span class="alert-text">{{ session('error') }}</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                    </div>
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Student</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Subject</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Semester</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">School Year</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Schedule</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($enrollments as $enrollment)
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $enrollment->student->name }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $enrollment->student->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $enrollment->subject->subject_code }}</p>
                                        <p class="text-xs text-secondary mb-0">{{ $enrollment->subject->subject_description }}</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $enrollment->semester }}</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $enrollment->school_year }}</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $enrollment->schedule }}</p>
                                    </td>
                                    <td class="align-middle px-3">
                                        <a href="javascript:;" class="text-secondary font-weight-bold text-xs" onclick="openShowModal({{ $enrollment->id }})">
                                            <i class="fas fa-eye me-2"></i>
                                        </a>
                                        <a href="javascript:;" class="text-secondary font-weight-bold text-xs" onclick="openEditModal({{ $enrollment->id }})">
                                            <i class="fas fa-pen-to-square me-2"></i>
                                        </a>
                                        <a href="javascript:;" class="text-secondary font-weight-bold text-xs" onclick="deleteEnrollment({{ $enrollment->id }})">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">No enrollments found</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="px-3 pt-4">
                        {{ $enrollments->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Container -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true"></div>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include jQuery UI -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<!-- Include Bootstrap JS -->
<script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>

<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@push('scripts')
<script>
console.log('Index page script loaded');

// Function to show alerts
window.showAlert = function(type, message) {
    let icon = type === 'success' ? 'check-circle' : 'times-circle';
    let alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            <span class="alert-icon"><i class="fas fa-${icon}"></i></span>
            <span class="alert-text">${message}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
    
    // Clear existing alerts
    $('#alert-container').html(alertHtml);
    
    // Auto-dismiss after 5 seconds
    setTimeout(function() {
        $('.alert').alert('close');
    }, 5000);
}

function openCreateModal() {
    console.log('Opening create modal...');
    const url = "{{ route('enrollments.create') }}";
    console.log('Create modal URL:', url);
    
    $.get(url, function(data) {
        console.log('Modal content received');
        $("#modal").html(data);
        
        // Initialize the modal
        var myModal = new bootstrap.Modal(document.getElementById('modal'));
        myModal.show();
        
        // Ensure jQuery UI is loaded
        if (typeof $.ui === 'undefined') {
            console.error('jQuery UI is not loaded in the page!');
        } else {
            console.log('jQuery UI is loaded in the page');
        }
        
        // Force initialization of any scripts in the modal
        $(document).trigger('ready');
    }).fail(function(xhr, status, error) {
        console.error('Error loading create modal:', {
            status: xhr.status,
            statusText: xhr.statusText,
            responseText: xhr.responseText,
            error: error
        });
        Swal.fire('Error!', 'Failed to load the create form', 'error');
    });
}

function openEditModal(id) {
    const url = "{{ url('enrollments') }}/" + id + "/edit";
    
    $.get(url, function(data) {
        $("#modal").html(data);
        var myModal = new bootstrap.Modal(document.getElementById('modal'));
        myModal.show();
    }).fail(function() {
        Swal.fire('Error!', 'Failed to load the edit form', 'error');
    });
}

function openShowModal(id) {
    const url = "{{ url('enrollments') }}/" + id;
    
    $.get(url, function(data) {
        $("#modal").html(data);
        var myModal = new bootstrap.Modal(document.getElementById('modal'));
        myModal.show();
    }).fail(function() {
        Swal.fire('Error!', 'Failed to load the enrollment details', 'error');
    });
}

function deleteEnrollment(id) {
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
                url: "{{ url('enrollments') }}/" + id,
                type: 'DELETE',
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function(response) {
                    Swal.fire(
                        'Deleted!',
                        response.message,
                        'success'
                    ).then(() => {
                        location.reload();
                    });
                },
                error: function() {
                    Swal.fire(
                        'Error!',
                        'There was an error deleting the enrollment.',
                        'error'
                    );
                }
            });
        }
    });
}

// Document ready to ensure modal is properly initialized
$(document).ready(function() {
    // Initialize any Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endpush
@endsection 