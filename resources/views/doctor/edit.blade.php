<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

<!-- Bootstrap Modal -->
<div class="modal  fade" id="doctorEditModal" tabindex="-1" aria-labelledby="doctorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header modalHeader">
                <h5 class="modal-title" id="doctorModalLabel">Edit Doctor Profile</h5>
                <button type="button" class="btn-close" id="closeEditModal" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <!-- Form -->
                <form id="updateDoctor"  method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <!-- First Name -->
                        <div class="col-md-6">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter First Name" required>
                            <input type="hidden" id="doctorId" name="doctorId" >
                        </div>

                        <!-- Last Name -->
                        <div class="col-md-6">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter Last Name" required>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter valid email address" required>
                        </div>

                        <!-- Mobile -->
                        <div class="col-md-6">
                            <label for="mobile" class="form-label">Mobile</label>
                            <input type="number" class="form-control contact_no" id="mobile" name="mobile" placeholder="Enter contact no" required>
                            <small id="contact_no_res"></small>
                        </div>

                        <!-- Gender -->
                        <div class="col-md-6">
                            <label for="gender" class="form-label">Gender</label>
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
                            <input type="text" class="form-control" id="bmdc_number" name="bmdc_number" placeholder="Enter BMDC number" class="form-control">
                        </div>

                        <!-- Blood Group -->
                        <div class="col-md-6">
                            <label for="blood_group" class="form-label">Blood Group</label>
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
                            <label for="date_of_birth" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
                        </div>

                        <!-- NID -->
                        <div class="col-md-6">
                            <label for="nid" class="form-label">NID</label>
                            <input type="text" class="form-control" id="nid" name="nid" placeholder="Enter NID no"  required>
                        </div>

                        <!-- Specialist -->
                        <div class="col-md-6">
                            <label for="specialist" class="form-label">Specialist</label>
                            <input type="text" class="form-control" id="specialist" name="specialist" placeholder="Enter doctor specialist" required>
                        </div>

                        <!-- Fee -->
                        <div class="col-md-6">
                            <label for="fee" class="form-label">Fee</label>
                            <input type="number" class="form-control" id="fee" name="fee" placeholder="Enter doctor fee" required>
                        </div>

                        <!-- Designation -->
                        <div class="col-md-6">
                            <label for="designation" class="form-label">Designation</label>
                            <input type="text" class="form-control" id="designation" name="designation" placeholder="Enter doctor designation" required>
                        </div>

                        <!-- Consultant Type -->
                        <div class="col-md-6">
                            <label for="consultant_type" class="form-label">Consultant Type</label>
                            <input type="text" class="form-control" id="consultant_type" name="consultant_type" placeholder="Enter consultant type">
                        </div>

                        <!-- Address -->
                        <div class="col-md-6">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="2" placeholder="Enter doctor address"></textarea>
                        </div>

                        <!-- Description -->
                        <div class="col-md-6">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="2" placeholder="Enter comments"></textarea>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="modal-footer modalFooter">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- btm end --}}

<script>
    $(document).ready(function(){
        var firstName = '<?php echo $doctor->first_name ?>';
        var lastName = '<?php echo $doctor->last_name ?>';
        var email = '<?php echo $doctor->email ?>';
        var mobile = '<?php echo $doctor->mobile ?>';
        var gender = '<?php echo $doctor->gender ?>';
        var bmdc_number = '<?php echo $doctor->bmdc_number ?>';
        var blood_group = '<?php echo $doctor->blood_group ?>';
        var address = '<?php echo $doctor->address ?>';
        var date_of_birth = '<?php echo $doctor->date_of_birth ?>';
        var nid = '<?php echo $doctor->nid ?>';
        var description = '<?php echo $doctor->description ?>';
        var designation = '<?php echo $doctor->designation ?>';
        var specialist = '<?php echo $doctor->specialist ?>';
        var fee = '<?php echo $doctor->fee ?>';
        var consultant_type = '<?php echo $doctor->consultant_type ?>';
        var img = '<?php echo $doctor->photo ?>';
        var id = '<?php echo $doctor->id ?>';
        function dataInsert(){
            $('#first_name').val(firstName);
        $('#last_name').val(lastName);
        $('#email').val(email);
        $('#mobile').val(mobile);
        $('#gender').val(gender);
        $('#bmdc_number').val(bmdc_number);
        $('#blood_group').val(blood_group);
        $('#date_of_birth').val(date_of_birth);
        $('#nid').val(nid);
        $('#specialist').val(specialist);
        $('#fee').val(fee);
        $('#designation').val(designation);
        $('#consultant_type').val(consultant_type);
        $('#address').val(address);
        $('#description').val(description);
        $('#doctorId').val(id);
        }
        dataInsert();


        $('#updateDoctor').off('submit').on( 'submit', function(e){
            e.preventDefault(); // Prevent default form submission
            var submitBtn = $(this).find('button[type="submit"]');
            submitBtn.prop('disabled', true);
            var form = $('#updateDoctor')[0];
            var formData = new FormData(form);
            $.ajax({
                method: 'POST',
                url: '/updateDoctor',
                data: formData,
                contentType: false, // Ensure to set these options for FormData
                processData: false,
                success: function(respons) {

                    if(respons.success){
                        Swal.fire({
                                icon: 'success',
                                title: 'success!!',
                                text: 'Doctor Profile Updated',

                                confirmButtonText: 'OK',
                                timer:2000
                            });
                        $('#closeEditModal').click();
                        $('#doctorProfilesTable').DataTable().ajax.reload();

                    }
                    if(respons.error){
                        Swal.fire({
                                icon: 'error',
                                title: 'Opps!!',
                                text: respons.error,

                                confirmButtonText: 'OK'
                            });
                    }
                },
                error: function(xhr, status, error) {
                // Handle error response
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    // If validation errors exist, display them
                    var errors = xhr.responseJSON.errors;
                    var errorMessage = '';

                    for (var key in errors) {
                        errorMessage += '- ' + errors[key].join('\n- ') + '\n'; // Accumulate error messages
                    }

                   alert(errorMessage)
                } else {

                }
                return false;
                },
                complete: function() {
                // Re-enable the submit button after request completes
                submitBtn.prop('disabled', false);
            }
            });
        });


    })
</script>

