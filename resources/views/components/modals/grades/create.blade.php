@props(['route'])

<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Add New Grade</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="createGradeForm" action="{{ $route }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="mb-3">
                    <label for="enrollment_search" class="form-label">Search Enrollment</label>
                    <select class="form-control" id="enrollment_id" name="enrollment_id" required>
                        <option value="">Select Enrollment</option>
                        @foreach(\App\Models\Enrollment::with(['student', 'subject'])->doesntHave('grade')->get() as $enrollment)
                            <option value="{{ $enrollment->id }}">
                                {{ $enrollment->student->name }} - {{ $enrollment->subject->subject_code }} ({{$enrollment->section}} {{ $enrollment->subject->subject_description }} {{ $enrollment->semester }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="midterm_grade" class="form-label">Midterm Grade</label>
                    <select class="form-control" id="midterm_grade" name="midterm_grade" required>
                        <option value="">Select Grade</option>
                        @foreach([1.00, 1.25, 1.50, 1.75, 2.00, 2.25, 2.50, 2.75, 3.00, 5.00] as $grade)
                            <option value="{{ number_format($grade, 2) }}">{{ number_format($grade, 2) }}</option>
                        @endforeach
                        <option value="INC">INC</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="final_grade" class="form-label">Final Grade</label>
                    <select class="form-control" id="final_grade" name="final_grade" required>
                        <option value="">Select Grade</option>
                        @foreach([1.00, 1.25, 1.50, 1.75, 2.00, 2.25, 2.50, 2.75, 3.00, 5.00] as $grade)
                            <option value="{{ number_format($grade, 2) }}">{{ number_format($grade, 2) }}</option>
                        @endforeach
                        <option value="INC">INC</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Add Grade</button>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#createGradeForm').on('submit', function(e) {
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
                let errorMessage = 'An error occurred while creating the grade.';
                
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
});
</script> 