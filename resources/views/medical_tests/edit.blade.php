 <!-- Edit Modal -->
 <div class="modal fade " id="testEditModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header modalHeader">
                <h5 class="modal-title" id="createModalLabel">Edit Medical Test</h5>
                <button type="button" class="btn-close testEditClose"  data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="medicalTestUpdate" action="{{ route('medical-tests.update', $test->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                 @method('PUT')
                <div class="modal-body">


                    <div class="row g-2">
                        <div class="form-group col-md-6">
                            <label for="name">Test Name:</label>
                            <input type="text" id="name" name="name" class="form-control"   placeholder="Enter test name" required>
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
                    <button type="submit" class="btn btn-primary updateTest">Update Test</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
                $('#name').val('<?php echo $test->name ?>');
                $('#price').val('<?php echo $test->price ?>');
                $('#sample_collection_room_number').val('<?php echo $test->sample_collection_room_number ?>');
                $('#lab_location_id').val('<?php echo $test->lab_location_id?>');
                $('#status').val('<?php echo $test->status ?>');
                $('#discount_type').val('<?php echo $test->discount_type ?>');
                $('#discount').val('<?php echo $test->discount ?>');
                $('#description').val('<?php echo $test->description ?>');

        $('#medicalTestUpdate').off('submit').on('submit', function(e){

            e.preventDefault();

            var formData = $(this).serialize(); // Serialize form data

            $.ajax({
                url: $(this).attr('action'), // Form action URL
                type: 'PUT', // PUT request
                data: formData,
                dataType: 'json',
                success: function(response){
                    $('.testEditClose').click();
                    Swal.fire({
                                icon: 'success',
                                title: 'Successfull',
                                text: 'Test Update Successfully',
                                confirmButtonText: 'OK',
                                timer:2000

                            });
                    $('#medicalTestTable').DataTable().ajax.reload();
                },
            });
        })


    })
</script>
