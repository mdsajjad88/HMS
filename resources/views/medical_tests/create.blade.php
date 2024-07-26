 <!-- Create Modal -->
 <div class="modal fade medicalTest" id="testCreateModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header modalHeader">
                <h5 class="modal-title" id="createModalLabel">Create New Medical Test</h5>
                <button type="button" class="btn-close testAddClose"  data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="medicalTestAdd" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">


                    <div class="row g-2">
                        <div class="form-group col-md-6">
                            <label for="name">Test Name:</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Enter test name" required>
                        </div>


                        <div class="form-group col-md-6">
                            <label for="price">Test Price:</label>
                            <input type="number" id="price" name="price" class="form-control" step="0.01" placeholder="Enter test price" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="sample_collection_room_number">Sample Collection Room Number:</label>
                            <input type="text" id="sample_collection_room_number" name="sample_collection_room_number" placeholder="Sample collection room number" class="form-control">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="lab_location_id">Lab Location ID:</label>
                            <input type="number" id="lab_location_id" name="lab_location_id" class="form-control" placeholder="Lab location id" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="status">Status:</label>
                            <select id="status" name="status" class="form-control" required>
                                <option value="">Select test Status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="discount_type">Discount Type:</label>
                            <input type="text" id="discount_type" name="discount_type" class="form-control" placeholder="Enter discount type">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="discount">Discount:</label>
                            <input type="number" id="discount" name="discount" class="form-control" step="0.01" placeholder="Enter discount">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="description">Description:</label>
                            <textarea id="description" name="description" class="form-control" placeholder="Comment of this test"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer modalFooter">
                    <button type="reset" class="btn btn-secondary" >Reset</button>
                    <button type="submit" class="btn btn-primary saveTest">Save Test</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#medicalTestAdd').off('submit').on('submit', function(e){
            e.preventDefault();
            var form = $('#medicalTestAdd')[0];
            var formData = new FormData(form);

            $.ajax({

                method: 'POST',
                url: "{{route('medical-tests.store')}}",
                contentType: false, // Ensure to set these options for FormData
                processData: false,
                data: formData,
                success:function(respons){
                    $('#medicalTestAdd')[0].reset();
                    $('.testAddClose').click();
                    Swal.fire({
                                icon: 'success',
                                title: 'Successfull',
                                text: 'Test Name Added',
                                confirmButtonText: 'OK',

                            });
                    $('#medicalTestTable').DataTable().ajax.reload();

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
