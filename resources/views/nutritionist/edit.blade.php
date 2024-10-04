<div class="modal fade" id="nutritionistEditModal" tabindex="-1" aria-labelledby="nutritionistEditModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header modalHeader">
                <h5 class="modal-title" id="nutritionistEditModalLabel">Edit Nutritionist Information</h5>
                <button type="button" class="btn-close" id="closeModal" data-bs-dismiss="modal" aria-label="Close"><i
                        class="fas fa-xmark"></i> </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <!-- Form -->
                <form id="UpdateNutritionist" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <!-- First Name -->
                        <div class="col-md-6">
                            <input type="hidden" id="nu-id" name="id">
                            <label for="name" class="form-label">Nutritionist Name <span
                                    id="star">*</span></label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Enter Nutritionist Name" required>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email <span id="star">*</span></label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Enter valid email address" required readonly>
                        </div>

                        <!-- Mobile -->
                        <div class="col-md-6">
                            <label for="mobile" class="form-label">Mobile <span id="star">*</span></label>
                            <input type="number" class="form-control contact_no" id="mobile" name="mobile"
                                placeholder="Enter contact no" required readonly>
                            <small id="contact_no_res"></small>
                        </div>

                        <!-- Gender -->
                        <div class="col-md-6">
                            <label for="gender" class="form-label">Gender <span id="star">*</span></label>
                            <select class="form-control" id="gender" name="gender" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <!-- Blood Group -->
                        <div class="col-md-6">
                            <label for="blood_group" class="form-label">Blood Group </label>
                            <select class="form-control" id="blood_group" name="blood_group">
                                <option value="">Select Blood Group</option>
                                <option value="A+">A+</option>
                                <option value="B+">B+</option>
                                <option value="AB+">AB+</option>
                                <option value="O+">O+</option>
                                <option value="A-">A-</option>
                                <option value="B-">B-</option>
                                <option value="AB-">AB-</option>
                                <option value="O-">O-</option>
                            </select>
                        </div>

                        <!-- Date of Birth -->
                        <div class="col-md-6">
                            <label for="date_of_birth" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth">
                        </div>

                        <!-- NID -->
                        <div class="col-md-6">
                            <label for="nid" class="form-label">NID </label>
                            <input type="text" class="form-control" id="nid" name="nid"
                                placeholder="Enter NID no">
                        </div>

                        <!-- Specialist -->
                        <div class="col-md-6">
                            <label for="specialist" class="form-label">Specialist </label>
                            <input type="text" class="form-control" id="specialist" name="specialist"
                                placeholder="Enter doctor specialist">
                        </div>

                        <!-- Fee -->
                        <div class="col-md-6">
                            <label for="fee" class="form-label">Fee </label>
                            <input type="number" class="form-control" id="fee" name="fee"
                                placeholder="Enter doctor fee">
                        </div>

                        <!-- Designation -->
                        <div class="col-md-6">
                            <label for="designation" class="form-label">Designation</label>
                            <input type="text" class="form-control" id="designation" name="designation"
                                placeholder="Enter doctor designation">
                        </div>

                        <!-- Consultant Type -->
                        <div class="col-md-6">
                            <label for="consultant_type" class="form-label">Consultant Type</label>
                            <input type="text" class="form-control" id="consultant_type" name="consultant_type"
                                placeholder="Enter consultant type">
                        </div>


                        <!-- Address -->
                        <div class="col-md-6">
                            <label for="address" class="form-label">Address </label>
                            <textarea class="form-control" id="address" name="address" rows="2" placeholder="Enter doctor address"></textarea>
                        </div>

                        <!-- Description -->
                        <div class="col-md-6">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="2" placeholder="Enter comments"></textarea>
                        </div>
                    </div>


                    <div class="modal-footer modalFooter">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        var nutritionist = @json($nutritionist);
        $('#nu-id').val(nutritionist.id);
        $('#name').val(nutritionist.name);
        $('#email').val(nutritionist.email);
        $('#mobile').val(nutritionist.mobile);
        $('#gender').val(nutritionist.gender);
        $('#blood_group').val(nutritionist.blood_group);
        $('#date_of_birth').val(nutritionist.date_of_birth);
        $('#nid').val(nutritionist.nid);
        $('#specialist').val(nutritionist.specialist);
        $('#fee').val(nutritionist.fee);
        $('#designation').val(nutritionist.designation);
        $('#consultant_type').val(nutritionist.consultant_type);
        $('#address').val(nutritionist.address);
        $('#description').val(nutritionist.description);

        $('#UpdateNutritionist').off('submit').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            var submitBtn = $(this).find('button[type="submit"]');
            submitBtn.prop('disabled', true);

            var form = $('#UpdateNutritionist')[0];
            var formData = new FormData(form);

            // Get the nutritionist ID from the hidden input
            var id = $('#nu-id').val();

            // Construct the URL with the ID
            var url = "{{ route('nutritionist.update', ':id') }}".replace(':id', id);

            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                contentType: false, // Ensure to set these options for FormData
                processData: false,
                success: function(response) {
                    $('#closeModal').click();
                    $('#nutritionistTable').DataTable().ajax.reload();

                    Swal.fire({
                        icon: 'success',
                        title: 'Success!!',
                        text: 'Nutritionist Profile updated successfully',
                        confirmButtonText: 'OK',
                        timer: 2000
                    });
                },
                error: function(xhr, status, error) {
                    submitBtn.prop('disabled', false); // Re-enable the button

                    var errorMessage = '';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage += xhr.responseJSON.message;
                    } else {
                        errorMessage += status;
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops',
                        text: errorMessage,
                        confirmButtonText: 'OK',
                    });
                }
            });
        })
        $('#closeModal').click(function() {
            window.location.reload();
        })
    })
</script>
