
<div class="modal  fade" id="patientModal" tabindex="-1" role="dialog" aria-labelledby="patientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header modalHeader">
                <h5 class="modal-title" id="doctorModalLabel">Add New Patient</h5>
                <button type="button" class="btn-close" id="closePatientModal" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addNewPatient" method="POST" enctype="multipart/form-data" >
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                    <div class="form-group col-md-6">
                        <label for="first_name">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter first name" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="last_name">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter last name" >
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter patient email" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="mobile">Mobile</label>
                        <input type="number" class="form-control contact_no" id="mobile" name="mobile" placeholder="Enter contact no" required>
                        <small id="contact_no_res"></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="gender">Gender</label>
                        <select class="form-control" id="gender" name="gender" required>
                            <option value="">Select patient gender</option>
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
                        <input type="text" class="form-control" id="nid" placeholder="Patient NID no" name="nid">
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
                        <input type="text" class="form-control" id="height_cm" placeholder="Enter Patient Height" name="height_cm" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="weight_kg">Weight (kg)</label>
                        <input type="text" class="form-control" id="weight_kg" placeholder="Enter Patient Weight" name="weight_kg" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="blood_group">Blood Group</label>
                        <select class="form-control" id="blood_group"  name="blood_group" required>
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
                        <input type="number" class="form-control" id="emergency_phone" placeholder="Enter emergency contact no" name="emergency_phone">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="emergency_relation">Emergency relation</label>
                        <input type="text" class="form-control" id="emergency_relation" placeholder="Ex: Brother/Wife/Husband/doughter's" name="emergency_relation">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="discount">Discount</label>
                        <input type="number" class="form-control" id="discount" placeholder="If Special Discount" name="discount">
                    </div>
                    <div class="form-group col-md-6" >
                        <label for="address">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="1" placeholder="Enter Address" placeholder="Enter Patient address" required></textarea>
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
                            <option value="">Upozilla</option>
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
                    <button type="reset" class="btn btn-secondary" >Reset</button>
                    <button type="submit" class="btn btn-primary">Save </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#addNewPatient').off('submit').on('submit', function(e){
            e.preventDefault(); // Prevent default form submission

            var form = $('#addNewPatient')[0];
            var formData = new FormData(form);

            $.ajax({
                method: 'POST',
                url: '/addNewPatient',
                data: formData,
                contentType: false, // Ensure to set these options for FormData
                processData: false,
                success: function(respons) {
                    $('#addNewPatient')[0].reset();
                    if(respons.success){

                        $('#closePatientModal').click();
                        $('#patientTable').DataTable().ajax.reload();
                        Swal.fire({
                        title: 'success!',
                        text: 'Patient Added Successfully',
                        icon: 'success', // 'success', 'error', 'warning', 'info', 'question'
                        confirmButtonText: 'OK',
                        timer: 2000
                    });

                    }
                    if(respons.error){
                        alert(respons.error)
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
                        title: 'error!',
                        text: errorMessage,
                        icon: 'error', // 'success', 'error', 'warning', 'info', 'question'
                        confirmButtonText: 'OK'
                    });

                } else {

                }
                return false;
                }
            });
        })
    })
</script>
