
<div class="modal  fade" id="updatePatientModal" tabindex="-1" role="dialog" aria-labelledby="patientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header modalHeader">
                <h5 class="modal-title" id="doctorModalLabel">Edit Patient Information</h5>
                <button type="button" class="btn-close" id="closePatientEditModal" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updatePatient"  method="POST" enctype="multipart/form-data" >
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                    <div class="form-group col-md-6">
                        <label for="first_name">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" required>
                        <input type="hidden" id="patientId" name="id" >
                    </div>
                    <div class="form-group col-md-6">
                        <label for="last_name">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="mobile">Mobile</label>
                        <input type="number" class="form-control contact_no" id="mobile" name="mobile" required>
                        <small id="contact_no_res"></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="gender">Gender</label>
                        <select class="form-control" id="gender" name="gender" required>
                            <option value="">Select your gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="date_of_birth">Date of Birth</label>
                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="nid">National ID</label>
                        <input type="text" class="form-control" id="nid" name="nid">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="marital_status">Marital status </label>
                        <select class="form-control" id="marital_status" name="marital_status" required>
                            <option value="">Select Marital status</option>

                            <option value="Married">Married</option>
                            <option value="Unmarried">Unmarried</option>
                            <option value="Other">Other</option>

                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="height_cm">Height (cm)</label>
                        <input type="text" class="form-control" id="height_cm" name="height_cm">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="weight_kg">Weight (kg)</label>
                        <input type="text" class="form-control" id="weight_kg" name="weight_kg">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="blood_group">Blood Group</label>
                        <select class="form-control" id="blood_group" name="blood_group" required>
                            <option value="">Select blood group</option>
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
                    <div class="form-group col-md-6">
                        <label for="emergency_phone">Emergency phone</label>
                        <input type="number" class="form-control" id="emergency_phone" name="emergency_phone">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="emergency_relation">Emergency relation</label>
                        <input type="text" class="form-control" id="emergency_relation" name="emergency_relation">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="discount">Discoutn</label>
                        <input type="number" class="form-control" id="discount" name="discount">
                    </div>
                    <div class="form-group col-md-6" >
                        <label for="address">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="1" placeholder="Enter Address" required></textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="city">City</label>
                        <select class="form-control" id="city" name="city" required>
                            <option value="">Select District</option>
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
                    <div class="form-group col-md-6">
                        <label for="state">State</label>
                        <select class="form-control" id="state" name="state" required>
                            <option value="">Select blood group</option>
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

                    </div>
                    <!-- Add more fields based on your schema -->
                </div>
                <div class="modal-footer modalFooter">
                    <button type="submit" class="btn btn-primary">Update Patient </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){

        var pId = '<?php echo $id ?>';

        // $('#first_name').empty();
        //             $('#last_name').empty();
        //             $('#email').empty();
        //             $('#mobile').empty();
        //             $('#gender').empty();
        //             $('#blood_group').empty();
        //             $('#date_of_birth').empty();
        //             $('#nid').empty();
        //             $('#marital_status').empty();
        //             $('#height_cm').empty();
        //             $('#weight_kg').empty();
        //             $('#address').empty();
        //             $('#patientId').empty();
        //             $('#emergency_phone').empty();
        //             $('#emergency_relation').empty();
        //             $('#discount').empty();
        //             $('#city').empty();
        //             $('#state').empty();


        $.ajax({
            url:'/getOnePatient/'+pId,
            method:'GET',
            success:function(patientInfo){
                var patient = patientInfo.data;

                    $('#first_name').val(patient.first_name);
                    $('#last_name').val(patient.last_name);
                    $('#email').val(patient.email);
                    $('#mobile').val(patient.mobile);
                    $('#gender').val(patient.gender);
                    $('#blood_group').val(patient.blood_group);
                    $('#date_of_birth').val(patient.date_of_birth);
                    $('#nid').val(patient.nid);
                    $('#marital_status').val(patient.marital_status);
                    $('#height_cm').val(patient.height_cm);
                    $('#weight_kg').val(patient.weight_kg);
                    $('#address').val(patient.address);
                    $('#patientId').val(patient.id);
                    $('#emergency_phone').val(patient.emergency_phone);
                    $('#emergency_relation').val(patient.emergency_relation);
                    $('#discount').val(patient.discount);
                    $('#city').val(patient.city);
                    $('#state').val(patient.state);



            }
        })
        $('#updatePatient').off('submit').on('submit', function(e){
            e.preventDefault(); // Prevent default form submission

            var form = $('#updatePatient')[0];
            var formData = new FormData(form);

            $.ajax({
                method: 'POST',
                url: '/updatePatient',
                data: formData,
                contentType: false, // Ensure to set these options for FormData
                processData: false,
                success: function(respons) {
                    if(respons.success){
                        Swal.fire({
                        icon: 'success',
                        title: 'Patient Profile Updated successfuly!',
                        timer: 3000 // 3 seconds

                    });
                        $('#closePatientEditModal').click();
                        $('#patientTable').DataTable().ajax.reload();
                    }
                    if(respons.error){
                        Swal.fire({
                        icon: 'error',
                        title: respons.error,
                        timer: 3000 // 3 seconds

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
                    Swal.fire({
                        icon: 'error',
                        title: errorMessage,
                        timer: 3000 // 3 seconds

                    });

                } else {

                }
                return false;
                }
            });
        })
     })
</script>
