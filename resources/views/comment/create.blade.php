<div class="modal-dialog" role="document">
    <div class="modal-content">
        @php
            $form_id = 'comment_store_form';
            $url = action([\App\Http\Controllers\CommentController::class, 'store']);
        @endphp
        <form action="{{ $url }}" method="POST" id="{{ $form_id }}">
            @csrf <!-- Add CSRF token -->
            <div class="modal-header">
                <h5 class="modal-title" id="commentStoreModalLabel">Add Doctor Business Day</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> <i
                        class="fas fa-close"></i> </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5">
                        <div class="mb-3">
                            <label for="problem_name" class="form-label">Name <span class="star">*</span></label>
                            <input type="text" class="form-control" name="name" placeholder="Enter Problem Name"
                                required>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="problem_description" class="form-label">Description <span
                                    class="star">*</span></label>
                            <input type="text" class="form-control" name="description"
                                placeholder="Enter Problem Description" required>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Handle form submission
        $('#comment_store_form').submit(function(e) {
            e.preventDefault();

            var data = $(this).serialize();

            $.ajax({
                method: 'POST',
                url: $(this).attr('action'),
                dataType: 'json',
                data: data,
                success: function(result) {
                    if (result.success) {
                        // Use the correct modal class for hiding
                        $('.btn-close').click();
                        Swal.fire({
                            icon: 'success',
                            title: 'success!!',
                            text: result.msg,
                            confirmButtonText: 'OK',
                            timer: 2000
                        });
                        var newComment = $('<option>', {
                            value: result.comment.id,
                            text: result.comment.name,
                            selected: true
                        });
                        $('.new-comment').append(newComment);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Wrong!!',
                            text: result.msg,
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Wrong!!',
                        text: xhr,
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    });
</script>
