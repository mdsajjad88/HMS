<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

 <div class="modal fade" id="doctorModal" tabindex="-1" aria-labelledby="doctorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header modalHeader">
                <h5 class="modal-title" id="doctorModalLabel">Add New Doctor</h5>
                <button type="button" class="btn-close" id="closeModal" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <!-- Form -->
                <form id="addDoctor"  method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <!-- First Name -->
                        <div class="col-md-6">
                            <label for="first_name" class="form-label">First Name <span id="star">*</span></label>
                            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter First Name" required>
                        </div>

                        <!-- Last Name -->
                        <div class="col-md-6">
                            <label for="last_name" class="form-label">Last Name <span id="star">*</span></label>
                            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter Last Name" required>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email <span id="star">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter valid email address" required>
                        </div>

                        <!-- Mobile -->
                        <div class="col-md-6">
                            <label for="mobile" class="form-label">Mobile <span id="star">*</span></label>
                            <input type="number" class="form-control contact_no" id="mobile" name="mobile" placeholder="Enter contact no" required>
                            <small id="contact_no_res"></small>
                        </div>

                        <!-- Gender -->
                        <div class="col-md-6">
                            <label for="gender" class="form-label">Gender <span id="star">*</span></label>
                            <select class="form-select" id="gender" name="gender" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <!-- BMDC Number -->
                        <div class="col-md-6">
                            <label for="bmdc_number" class="form-label">BMDC Number</label>
                            <input type="text" class="form-control" id="bmdc_number" name="bmdc_number" placeholder="Enter BMDC number">
                        </div>

                        <!-- Blood Group -->
                        <div class="col-md-6">
                            <label for="blood_group" class="form-label">Blood Group <span id="star">*</span></label>
                            <select class="form-select" id="blood_group" name="blood_group" required>
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
                            <label for="date_of_birth" class="form-label">Date of Birth <span id="star">*</span></label>
                            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
                        </div>

                        <!-- NID -->
                        <div class="col-md-6">
                            <label for="nid" class="form-label">NID <span id="star">*</span></label>
                            <input type="text" class="form-control" id="nid" name="nid" placeholder="Enter NID no" required >
                        </div>

                        <!-- Specialist -->
                        <div class="col-md-6">
                            <label for="specialist" class="form-label">Specialist <span id="star">*</span></label>
                            <input type="text" class="form-control" id="specialist" name="specialist" placeholder="Enter doctor specialist" required>
                        </div>

                        <!-- Fee -->
                        <div class="col-md-6">
                            <label for="fee" class="form-label">Fee <span id="star">*</span></label>
                            <input type="number" class="form-control" id="fee" name="fee" placeholder="Enter doctor fee" required>
                        </div>

                        <!-- Designation -->
                        <div class="col-md-6">
                            <label for="designation" class="form-label">Designation <span id="star">*</span></label>
                            <input type="text" class="form-control" id="designation" name="designation" placeholder="Enter doctor designation" required>
                        </div>

                        <!-- Consultant Type -->
                        <div class="col-md-6">
                            <label for="consultant_type" class="form-label">Consultant Type</label>
                            <input type="text" class="form-control" id="consultant_type" name="consultant_type" placeholder="Enter consultant type">
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

                        <button type="reset" class="btn btn-secondary" >Reset</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function(){

        $('#addDoctor').off('submit').on('submit', function(e){
            e.preventDefault(); // Prevent default form submission
            var form = $('#addDoctor')[0];
            var formData = new FormData(form);

            $.ajax({
                method: 'POST',
                url: '/addDoctor',
                data: formData,
                contentType: false, // Ensure to set these options for FormData
                processData: false,
                success:function(response) {
                    $('#addDoctor')[0].reset();

                    $('#closeModal').click();
                    $('#doctorProfilesTable').DataTable().ajax.reload();

                    Swal.fire({
                                icon: 'success',
                                title: 'success!!',
                                text: 'Doctor Profile cteate Successfully',
                                confirmButtonText: 'OK'
                            });

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
                                timer:3000
                            });
            }
            });
        })

    })
</script>

