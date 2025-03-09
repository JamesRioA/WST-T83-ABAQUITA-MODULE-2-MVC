@props(['enrollment'])

<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Enrollment Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label class="fw-bold">Student:</label>
                <p>{{ $enrollment->student->name }} ({{ $enrollment->student->email }})</p>
            </div>
            <div class="mb-3">
                <label class="fw-bold">Subject:</label>
                <p>{{ $enrollment->subject->subject_code }} - {{ $enrollment->subject->subject_description }}</p>
            </div>
            <div class="mb-3">
                <label class="fw-bold">Subject Description:</label>
                <p>{{ $enrollment->subject->subject_description }}</p>
            </div>
            <div class="mb-3">
                <label class="fw-bold">Units:</label>
                <p>{{ $enrollment->subject->units }}</p>
            </div>
            <div class="mb-3">
                <label class="fw-bold">Section:</label>
                <p>{{ $enrollment->section }}</p>
            </div>
            <div class="mb-3">
                <label class="fw-bold">School Year:</label>
                <p>{{ $enrollment->school_year }}</p>
            </div>
            <div class="mb-3">
                <label class="fw-bold">Semester:</label>
                <p>{{ $enrollment->semester }}</p>
            </div>
            <div class="mb-3">
                <label class="fw-bold">Enrolled At:</label>
                <p>{{ $enrollment->created_at->format('F d, Y h:i A') }}</p>
            </div>
            <div class="mb-3">
                <label class="fw-bold">Last Updated:</label>
                <p>{{ $enrollment->updated_at->format('F d, Y h:i A') }}</p>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
</div> 