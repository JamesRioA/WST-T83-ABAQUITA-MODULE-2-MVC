@props(['subject'])

<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Subject Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label class="fw-bold">Subject Code:</label>
                <p>{{ $subject->code }}</p>
            </div>
            <div class="mb-3">
                <label class="fw-bold">Subject Name:</label>
                <p>{{ $subject->name }}</p>
            </div>
            <div class="mb-3">
                <label class="fw-bold">Description:</label>
                <p>{{ $subject->description }}</p>
            </div>
            <div class="mb-3">
                <label class="fw-bold">Units:</label>
                <p>{{ $subject->units }}</p>
            </div>
            <div class="mb-3">
                <label class="fw-bold">Created At:</label>
                <p>{{ $subject->created_at->format('F d, Y h:i A') }}</p>
            </div>
            <div class="mb-3">
                <label class="fw-bold">Last Updated:</label>
                <p>{{ $subject->updated_at->format('F d, Y h:i A') }}</p>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
</div> 