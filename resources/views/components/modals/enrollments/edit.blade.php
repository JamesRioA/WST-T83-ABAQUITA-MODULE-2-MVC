@props(['route', 'enrollment'])

<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit Enrollment</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="editEnrollmentForm" action="{{ $route }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="student_id" class="form-control-label">Student</label>
                            <select class="form-control" id="student_id" name="student_id" required>
                                <option value="">Select Student</option>
                                @foreach(\App\Models\Student::all() as $student)
                                    <option value="{{ $student->id }}" {{ $enrollment->student_id == $student->id ? 'selected' : '' }}>
                                        {{ $student->name }} - {{ $student->course }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="subject_id" class="form-control-label">Subject</label>
                            <select class="form-control" id="subject_id" name="subject_id" required>
                                <option value="">Select Subject</option>
                                @foreach(\App\Models\Subject::all() as $subject)
                                    <option value="{{ $subject->id }}" {{ $enrollment->subject_id == $subject->id ? 'selected' : '' }}>
                                        {{ $subject->subject_code }} - {{ $subject->subject_description }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="semester" class="form-control-label">Semester</label>
                            <select class="form-control" id="semester" name="semester" required>
                                <option value="">Select Semester</option>
                                @foreach(['1st Semester', '2nd Semester', 'Summer'] as $sem)
                                    <option value="{{ $sem }}" {{ $enrollment->semester == $sem ? 'selected' : '' }}>
                                        {{ $sem }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="school_year" class="form-control-label">School Year</label>
                            <input type="text" class="form-control" id="school_year" name="school_year" 
                                value="{{ $enrollment->school_year }}" placeholder="e.g., 2023-2024" required>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="section" class="form-control-label">Section</label>
                            <input type="text" class="form-control" id="section" name="section" 
                                value="{{ $enrollment->section }}" placeholder="e.g., A" required>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="schedule" class="form-control-label">Schedule</label>
                            <input type="text" class="form-control" id="schedule" name="schedule" 
                                value="{{ $enrollment->schedule }}" placeholder="e.g., MWF 9:00 AM - 10:30 AM" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update Enrollment</button>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    // Form submission
    $('#editEnrollmentForm').on('submit', function(e) {
        e.preventDefault();
        
        const form = $(this);
        const submitBtn = form.find('button[type="submit"]');
        submitBtn.prop('disabled', true);
        
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            success: function(response) {
                // Hide the modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('modal'));
                modal.hide();
                
                // Show success message using SweetAlert2
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.message,
                    showConfirmButton: false,
                    timer: 1500
                });
                
                // Use the parent page's showAlert function if available
                if (typeof window.showAlert === 'function') {
                    window.showAlert('success', response.message);
                }
                
                // Refresh the page after a short delay
                setTimeout(function() {
                    window.location.reload();
                }, 1500);
            },
            error: function(xhr) {
                submitBtn.prop('disabled', false);
                let errorMessage = 'An error occurred while updating the enrollment.';
                
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    errorMessage = Object.values(xhr.responseJSON.errors).flat().join('\n');
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                // Show error message using SweetAlert2
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMessage
                });
                
                // Use the parent page's showAlert function if available
                if (typeof window.showAlert === 'function') {
                    window.showAlert('danger', errorMessage);
                }
            }
        });
    });
});</script> 