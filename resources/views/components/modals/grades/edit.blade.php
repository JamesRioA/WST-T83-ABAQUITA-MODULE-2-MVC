@props(['grade', 'route'])

<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit Grade</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="editGradeForm" action="{{ $route }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Student & Subject</label>
                    <input type="text" class="form-control" value="{{ $grade->enrollment->student->name }} - {{ $grade->enrollment->subject->subject_code }} ({{ $grade->enrollment->section }} {{ $grade->enrollment->subject->subject_description }} {{ $grade->enrollment->semester }})" readonly>
                    <input type="hidden" name="enrollment_id" value="{{ $grade->enrollment_id }}">
                </div>
                <div class="mb-3">
                    <label for="midterm_grade" class="form-label">Midterm Grade</label>
                    <select class="form-control" id="midterm_grade" name="midterm_grade" required>
                        <option value="">Select Grade</option>
                        @foreach([1.00, 1.25, 1.50, 1.75, 2.00, 2.25, 2.50, 2.75, 3.00, 5.00] as $g)
                            <option value="{{ number_format($g, 2) }}" {{ $grade->midterm_grade == number_format($g, 2) ? 'selected' : '' }}>
                                {{ number_format($g, 2) }}
                            </option>
                        @endforeach
                        <option value="INC" {{ $grade->midterm_grade == 'INC' ? 'selected' : '' }}>INC</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="final_grade" class="form-label">Final Grade</label>
                    <select class="form-control" id="final_grade" name="final_grade" required>
                        <option value="">Select Grade</option>
                        @foreach([1.00, 1.25, 1.50, 1.75, 2.00, 2.25, 2.50, 2.75, 3.00, 5.00] as $g)
                            <option value="{{ number_format($g, 2) }}" {{ $grade->final_grade == number_format($g, 2) ? 'selected' : '' }}>
                                {{ number_format($g, 2) }}
                            </option>
                        @endforeach
                        <option value="INC" {{ $grade->final_grade == 'INC' ? 'selected' : '' }}>INC</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update Grade</button>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#editGradeForm').on('submit', function(e) {
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
                let errorMessage = 'An error occurred while updating the grade.';
                
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