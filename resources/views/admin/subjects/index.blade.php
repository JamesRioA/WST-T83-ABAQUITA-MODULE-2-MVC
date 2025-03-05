@extends('layouts.test')

@section('title')
    <title>
        Subjects | Student Information System
    </title>
@endsection('title')

@section('breadcrumbs')
    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{route( Auth::user()->role . '-dashboard')}}">Pages</a></li>
        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Subjects</li>
    </ol>
    <h6 class="font-weight-bolder mb-0">Subjects</h6>
@endsection('breadcrumbs')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6>Subjects Management</h6>
                        <button type="button" class="btn bg-gradient-primary mb-0" 
                            onclick="openModal('{{ route('subjects.create') }}')">
                            <i class="fa fa-plus"></i>&nbsp;&nbsp;Add Subject
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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Subject Code</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Description</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Units</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($subjects as $subject)
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm ">{{ $subject->subject_code }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm text-wrap mb-0" style="max-width: 400px;">{{ $subject->subject_description }}</p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $subject->units }}</p>
                                    </td>
                                    <td class="align-middle">
                                        <button class="btn btn-link text-secondary mb-0" 
                                            onclick="openModal('{{ route('subjects.show', $subject) }}')">
                                            <i class="fa fa-eye text-xs"></i>
                                        </button>
                                        <button class="btn btn-link text-secondary mb-0" 
                                            onclick="openModal('{{ route('subjects.edit', $subject) }}')">
                                            <i class="fa fa-edit text-xs"></i>
                                        </button>
                                        <button class="btn btn-link text-secondary mb-0" 
                                            onclick="deleteSubject('{{ route('subjects.destroy', $subject) }}')">
                                            <i class="fa fa-trash text-xs"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">No subjects found</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="px-3 pt-4">
                        {{ $subjects->links('vendor.pagination.custom') }}
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

function openModal(url) {
    $.get(url, function(data) {
        $("#modal").html(data);
        var modal = new bootstrap.Modal(document.getElementById('modal'));
        modal.show();
    }).fail(function(xhr) {
        showAlert('danger', 'Failed to load modal content');
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to load modal content'
        });
    });
}

function deleteSubject(url) {
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
                    showAlert('success', response.message);
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(function() {
                        location.reload();
                    });
                },
                error: function(xhr) {
                    showAlert('danger', 'Something went wrong!');
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