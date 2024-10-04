<div class="modal fade" id="challengeCreating" tabindex="-1"
aria-labelledby="challengeCreatingModal" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="challengeCreatingLabel">Add new Challenge</h1>
            <button type="button" class="btn-close" id="challengeCreatingClose" data-bs-dismiss="modal"
                aria-label="Close"><i class="fas fa-close"></i></button>
        </div>
        <form id="challengeCreate" method="POST">
            @csrf
            <div class="modal-body">

                <div class="row g-2">
                    <div class="col-md-12">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name"
                            placeholder="Challege name" class="form-control" required>
                    </div>
                    <div class="col-md-12">
                        <label for="description">Description</label>
                        <textarea name="description" placeholder="Challenge description" class="form-control" id="description"  rows="2"></textarea>
                    </div>
                </div>

        </div>
        <div class="modal-footer">
            <button type="reset" class="btn btn-secondary">Reset</button>
            <button type="submit" class="btn btn-primary create">Create Problem</button>
        </div>
    </form>
    </div>
</div>
</div>
<script>
$(document).ready(function(){

    $('#challengeCreate').off('submit').on('submit', function(e) {
        e.preventDefault();
        var form = $('#challengeCreate')[0];
        var formData = new FormData(form);
        $.ajax({
            url: '{{route("challenges.store")}}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $("#challengeCreate")[0].reset();
                $('#challengeCreateClose').click();

                Swal.fire({
                    icon: 'success',
                    title: 'Successfull',
                    text: "Challenges Added Successfully",
                    confirmButtonText: 'OK',
                    timer:2000,
                    });
                    var newChallenge = $('<option>', {
                        value: response.challenge.id,
                        text: response.challenge.name,
                        selected: true
                    });

    $('.multipleChallenge').append(newChallenge);
                    $('#challengeCreatingClose').click();

            },
            error: function(xhr, status, error) {
                    var errorMessage = '';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage += xhr.responseJSON.message;
                    } else {
                        errorMessage += status;
                    }

                    Swal.fire({
                                icon: 'error',
                                title: 'Opps',
                                text: errorMessage,
                                confirmButtonText: 'OK',

                            });
                    }
        });
    });
})

</script>
