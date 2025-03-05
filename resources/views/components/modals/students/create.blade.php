@props(['route'])

<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Add New Student</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        
        <form id="createStudentForm">
            @csrf
            
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="search_user" class="form-control-label">Search User</label>
                            <div class="row">
                                <div class="col-md-8">
                                    <input class="form-control" type="text" id="search_user" name="search_user" placeholder="Type to search for a user..." autocomplete="off">
                                </div>
                                <div class="col-md-4">
                                    <button type="button" id="test_search" class="btn btn-primary w-100" onclick="testSearch();">Search</button>
                                </div>
                            </div>
                            <input type="hidden" id="user_id" name="user_id">
                            <div id="search-status" class="mt-2"></div>
                            <small class="form-text text-muted">Search for a user to add as a student</small>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="form-control-label">Name</label>
                            <input class="form-control" type="text" id="name" name="name" value="{{ old('name') }}" required readonly>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email" class="form-control-label">Email</label>
                            <input class="form-control" type="email" id="email" name="email" value="{{ old('email') }}" required readonly>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="course" class="form-control-label">Course</label>
                            <input class="form-control" type="text" id="course" name="course" value="{{ old('course') }}" required>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="year_level" class="form-control-label">Year Level</label>
                            <select class="form-control" id="year_level" name="year_level" required>
                                <option value="">Select Year Level</option>
                                <option value="1st Year" {{ old('year_level') == '1st Year' ? 'selected' : '' }}>1st Year</option>
                                <option value="2nd Year" {{ old('year_level') == '2nd Year' ? 'selected' : '' }}>2nd Year</option>
                                <option value="3rd Year" {{ old('year_level') == '3rd Year' ? 'selected' : '' }}>3rd Year</option>
                                <option value="4th Year" {{ old('year_level') == '4th Year' ? 'selected' : '' }}>4th Year</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="submitStudentForm()">Add Student</button>
            </div>
        </form>
    </div>
</div>

<!-- Define the testSearch function directly in the HTML -->
<script type="text/javascript">
function testSearch() {
    console.log("Search function called");
    
    const searchInput = $("#search_user");
    const searchStatus = $("#search-status");
    const searchTerm = searchInput.val();
    
    if (!searchTerm || searchTerm.length < 2) {
        searchStatus.html('<div class="alert alert-warning py-2">Please enter at least 2 characters</div>');
        return;
    }
    
    searchStatus.html('<div class="alert alert-info py-2">Searching...</div>');
    
    // Use the direct test route
    const searchUrl = "{{ url('test-search') }}";
    
    $.ajax({
        url: searchUrl,
        type: "GET",
        dataType: "json",
        data: { term: searchTerm },
        success: function(data) {
            console.log("Search response:", data);
            
            if (data.error) {
                searchStatus.html('<div class="alert alert-danger py-2">Error: ' + data.error + '</div>');
                return;
            }
            
            if (!data || data.length === 0) {
                searchStatus.html('<div class="alert alert-warning py-2">No users found matching "' + searchTerm + '"</div>');
                return;
            }
            
            let resultHtml = '<div class="alert alert-success py-2">Found ' + data.length + ' users:</div>';
            resultHtml += '<ul class="list-group mt-2">';
            
            $.each(data, function(index, user) {
                resultHtml += '<li class="list-group-item py-2 select-user" data-id="' + user.id + '" data-name="' + user.name + '" data-email="' + user.email + '">';
                resultHtml += '<strong>' + user.name + '</strong><br><small>' + user.email + '</small>';
                if (user.role) {
                    resultHtml += '<br><span class="badge bg-info">' + user.role + '</span>';
                }
                resultHtml += '</li>';
            });
            
            resultHtml += '</ul>';
            searchStatus.html(resultHtml);
            
            // Add click handler for user selection
            $(".select-user").on('click', function() {
                const userId = $(this).data('id');
                const userName = $(this).data('name');
                const userEmail = $(this).data('email');
                
                $("#user_id").val(userId);
                $("#name").val(userName);
                $("#email").val(userEmail);
                
                searchStatus.html('<div class="alert alert-success py-2">Selected: ' + userName + '</div>');
            });
        },
        error: function(xhr, status, error) {
            console.error("Search request failed:", error);
            searchStatus.html('<div class="alert alert-danger py-2">Error: ' + error + '</div>');
        }
    });
}

function submitStudentForm() {
    // Validate required fields
    if (!$('#user_id').val()) {
        Swal.fire({
            title: 'Error!',
            text: 'Please search and select a user first',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return false;
    }
    
    // Get the form data
    const formData = $('#createStudentForm').serialize();
    
    // Submit via AJAX
    $.ajax({
        url: "{{ $route }}",
        type: 'POST',
        data: formData,
        success: function(response) {
            // Close the modal
            $('#modal').modal('hide');
            
            // Show success message
            Swal.fire({
                title: 'Success!',
                text: response.message,
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                // Redirect to the students index page
                window.location.href = "{{ route('students.index') }}";
            });
        },
        error: function(xhr) {
            let errors = xhr.responseJSON.errors;
            let errorMessage = '';
            
            // Compile error messages
            Object.keys(errors).forEach(function(key) {
                errorMessage += errors[key][0] + '<br>';
            });
            
            // Show error message
            Swal.fire({
                title: 'Error!',
                html: errorMessage,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });
}
</script>

@push('scripts')
<script type="text/javascript">
$(document).ready(function() {
    console.log("Modal initialized");

    // CSRF token setup for AJAX requests
    $.ajaxSetup({
        headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" }
    });

    const searchInput = $("#search_user");
    
    // Initialize autocomplete
    searchInput.autocomplete({
        source: function(request, response) {
            // Use the direct URL
            const searchUrl = "{{ url('test-search') }}";
            
            $.ajax({
                url: searchUrl,
                type: "GET",
                dataType: "json",
                data: { term: request.term },
                success: function(data) {
                    if (!data || data.length === 0) {
                        response([]);
                        return;
                    }
                    
                    response($.map(data, function(item) {
                        return {
                            label: item.name + ' (' + item.email + ')',
                            value: item.name,
                            id: item.id,
                            name: item.name,
                            email: item.email
                        };
                    }));
                },
                error: function(xhr, status, error) {
                    response([]);
                }
            });
        },
        minLength: 2,
        select: function(event, ui) {
            $("#user_id").val(ui.item.id);
            $("#name").val(ui.item.name);
            $("#email").val(ui.item.email);
            $("#search-status").html('<div class="alert alert-success py-2">Selected: ' + ui.item.name + '</div>');
            return false;
        }
    }).autocomplete("instance")._renderItem = function(ul, item) {
        return $("<li>")
            .append("<div>" + item.name + "<br><small>" + item.email + "</small></div>")
            .appendTo(ul);
    };
});
</script>
@endpush
