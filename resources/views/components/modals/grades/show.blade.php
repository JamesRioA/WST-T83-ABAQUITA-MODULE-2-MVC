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
                <p>{{ $grade->enrollment->subject->subject_code }} - {{ $grade->enrollment->subject->subject_description }}</p>
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
                <p>{{ $grade->midterm_grade }}</p>
            </div>
            <div class="mb-3">
                <label class="fw-bold">Finals Grade:</label>
                <p>{{ $grade->final_grade }}</p>
            </div>
            <div class="mb-3">
                <label class="fw-bold">Average:</label>
                <p>{{ $grade->average_grade }}</p>
            </div>
            <div class="mb-3">
                <label class="fw-bold">Remarks:</label>
                <p>
                    <span class="badge badge-sm {{ $grade->remarks === 'Passed' ? 'bg-gradient-success' : ($grade->remarks === 'Incomplete' ? 'bg-gradient-warning' : 'bg-gradient-danger') }}">
                        {{ $grade->remarks }}
                    </span>
                </p>
            </div>
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