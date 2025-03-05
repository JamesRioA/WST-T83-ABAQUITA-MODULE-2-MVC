@props(['route', 'subject'])

<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit Subject</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="editSubjectForm" action="{{ $route }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="mb-3">
                    <label for="subject_code" class="form-label">Subject Code</label>
                    <input type="text" class="form-control" id="subject_code" name="subject_code" value="{{ $subject->subject_code }}" required>
                </div>
                <div class="mb-3">
                    <label for="subject_description" class="form-label">Description</label>
                    <textarea class="form-control" id="subject_description" name="subject_description" rows="3" required>{{ $subject->subject_description }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="units" class="form-label">Units</label>
                    <input type="number" class="form-control" id="units" name="units" min="1" max="6" value="{{ $subject->units }}" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update Subject</button>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#editSubjectForm').on('submit', function(e) {
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
                let errorMessage = 'An error occurred while updating the subject.';
                
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