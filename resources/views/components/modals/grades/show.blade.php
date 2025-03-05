@props(['grade'])

<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Grade Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label class="fw-bold">Student:</label>
                <p>{{ $grade->enrollment->student->name }} ({{ $grade->enrollment->student->email }})</p>
            </div>
            <div class="mb-3">
                <label class="fw-bold">Subject:</label>
                <p>{{ $grade->enrollment->subject->code }} - {{ $grade->enrollment->subject->name }}</p>
            </div>
            <div class="mb-3">
                <label class="fw-bold">School Year:</label>
                <p>{{ $grade->enrollment->school_year }}</p>
            </div>
            <div class="mb-3">
                <label class="fw-bold">Semester:</label>
                <p>{{ $grade->enrollment->semester }}</p>
            </div>
            <div class="mb-3">
                <label class="fw-bold">Midterm Grade:</label>
                <p>{{ number_format($grade->midterm, 2) }}</p>
            </div>
            <div class="mb-3">
                <label class="fw-bold">Finals Grade:</label>
                <p>{{ number_format($grade->finals, 2) }}</p>
            </div>
            <div class="mb-3">
                <label class="fw-bold">Average:</label>
                <p>{{ number_format($grade->average, 2) }}</p>
            </div>
            @if($grade->remarks)
            <div class="mb-3">
                <label class="fw-bold">Remarks:</label>
                <p>{{ $grade->remarks }}</p>
            </div>
            @endif
            <div class="mb-3">
                <label class="fw-bold">Created At:</label>
                <p>{{ $grade->created_at->format('F d, Y h:i A') }}</p>
            </div>
            <div class="mb-3">
                <label class="fw-bold">Last Updated:</label>
                <p>{{ $grade->updated_at->format('F d, Y h:i A') }}</p>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
</div> 