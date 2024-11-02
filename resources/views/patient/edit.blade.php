<div class="modal fade" id="updatePatientModal" tabindex="-1" role="dialog" aria-labelledby="patientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header modalHeader">
                <h5 class="modal-title" id="doctorModalLabel">Edit Patient Information</h5>
                <button type="button" class="btn-close" id="closePatientEditModal" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-xmark"></i></button>
            </div>
            <form action="{{ route('update.patient.info') }}" method="POST" enctype="multipart/form-data" id="updatePatient">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="form-group col-md-6">
                            <label for="first_name">Patient Name<span id="star">*</span></label>
                            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter first name" required>
                            <input type="hidden" name="id" class="id">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="mobile" class="d-flex">Mobile<span id="star">*</span>&nbsp;&nbsp;<span><small id="contact_no_res"></small></span></label>
                            <input type="number" class="form-control contact_no" id="mobile" name="mobile" placeholder="Enter contact no" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter patient email">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="gender">Gender<span id="star">*</span></label>
                            <select class="form-control" id="gender" name="gender" required>
                                <option value="" selected disabled>Select patient gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="age">Age <span id="star">*</span></label>
                            <input type="number" class="form-control" id="age" name="age" placeholder="Patient Age" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="patient_type_id">Subscription<span id="star">*</span></label>
                            <select name="patient_type_id" id="patient_type_id" class="form-control" required>
                                <option value="" selected disabled>Select Patient Subscription</option>
                                <option value="1">Not Subscribed</option>
                                <option value="33">3 Month(Regular)</option>
                                <option value="66">6 Month(Regular)</option>
                                <option value="3">3 Month(Session)</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="subscript_date">Subscription Start Date</label>
                            <input type="date" class="form-control" name="subscript_date" id="subscript_date">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="session_visite_count">Subscription Visits Completed</label>
                            <input type="number" class="form-control session_visite_count" name="session_visite_count" placeholder="If already Subscription visited">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="address">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="1" placeholder="Enter Patient Address"></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="geo_district_id">City<span id="star">*</span></label>
                            <select class="form-control geo_district" id="geo_district_id" name="geo_district_id" required>
                                <option value="" selected disabled>Select City</option>
                                @foreach ($districts as $city)
                                    <option value="{{ $city->id }}">{{ $city->district_name_eng }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="geo_upazila_id">State</label>
                            <select class="form-control geo_upozilla" id="geo_upazila_id" name="geo_upazila_id">
                                <option value="" selected disabled>Select Upozilla</option>
                                @foreach ($states as $state)
                                    <option value="{{ $state->id }}">{{ $state->upazila_name_eng }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nid">National ID</label>
                            <input type="text" class="form-control" id="nid" placeholder="Patient NID no" name="nid">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="marital_status">Marital Status</label>
                            <select class="form-control" id="marital_status" name="marital_status">
                                <option value="">Select Marital Status</option>
                                <option value="Married">Married</option>
                                <option value="Unmarried">Unmarried</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="blood_group">Blood Group</label>
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
                        <div class="form-group col-md-6">
                            <label for="emergency_phone">Emergency Phone</label>
                            <input type="number" class="form-control" id="emergency_phone" placeholder="Enter emergency contact no" name="emergency_phone">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="emergency_relation">Emergency Relation</label>
                            <input type="text" class="form-control" id="emergency_relation" placeholder="Ex: Brother/Wife/Husband/Daughter" name="emergency_relation">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="referral">Reference</label>
                            <input type="text" class="form-control" id="referral" placeholder="If anyone reference" name="referral">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="profession">Profession</label>
                            <input type="text" class="form-control" id="profession" placeholder="If know patient profession" name="profession">
                        </div>
                    </div>
                </div>
                <div class="modal-footer modalFooter">
                    <button type="submit" class="btn btn-primary">Update Patient</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#subscript_date').empty();

    var patient = @json($patient);
    var report = @json($report);
    var subscription = @json($subscription);

    // Populate form fields with patient data
    $('#first_name').val(patient.first_name);
    $('.id').val(patient.id);
    $('#email').val(patient.email);
    $('#mobile').val(patient.mobile);
    $('#gender').val(patient.gender);
    $('#blood_group').val(patient.blood_group);
    $('#nid').val(patient.nid);
    $('#marital_status').val(patient.marital_status);
    $('#address').val(patient.address);
    $('#emergency_phone').val(patient.emergency_phone);
    $('#emergency_relation').val(patient.emergency_relation);
    $('#geo_district_id').val(patient.geo_district_id);
    $('#geo_upazila_id').val(patient.geo_upazila_id);
    $('#age').val(patient.age);
    $('#referral').val(patient.referral);
    $('#profession').val(patient.profession);
    $('#patient_type_id').val(patient.patient_type_id);
    $('.session_visite_count').val(report.session_visite_count);
    $('#subscript_date').val(subscription.subscript_date);

    // Validate contact number input
    $('.contact_no').keyup(function() {
        var contact = $(this).val();
        var isNumeric = /^\d+$/.test(contact);
        var sub = contact.substring(0, 2);
        var length = contact.length;

        if (!isNumeric) {
            $('#contact_no_res').html('<p style="color:red">Contact no must contain only numeric digits</p>');
        } else if (sub != '01') {
            $('#contact_no_res').html('<p style="color:red">Contact no must start with 01</p>');
        } else if (length == 11) {
            $('#contact_no_res').html('<p style="color:green">Contact no is valid</p>');
        } else if (length != 11) {
            $('#contact_no_res').html('<p style="color:red">Contact no length must be 11 characters</p>');
        }
    });

    // Handle form submission
    $('#updatePatient').off('submit').on('submit', function(e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            method: 'POST',
            url: $(this).attr('action'), // Use the form's action attribute
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Patient Profile Updated Successfully!',
                        timer: 3000 // 3 seconds
                    });
                    $('#closePatientEditModal').click();
                    $('#patientTable').DataTable().ajax.reload();
                }
            },
            error: function(xhr) {
                var errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'An error occurred';
                Swal.fire({
                    icon: 'error',
                    title: 'Oops',
                    text: errorMessage,
                    confirmButtonText: 'OK',
                });
            }
        });
    });

    // Handle district change event
    $('.geo_district').on('change', function() {
        var id = $(this).val();
        $.ajax({
            url: '/getupozilla/' + id,
            type: 'GET',
            success: function(response) {
                $('.geo_upozilla').empty().append('<option disabled selected>Select Upozilla</option>');
                $.each(response, function(index, area) {
                    $('.geo_upozilla').append('<option value="' + area.id + '">' + area.upazila_name_eng + '</option>');
                });
            },
            error: function(xhr) {
                var errorMessage = xhr.responseJSON && xhr.responseJSON.errors ? xhr.responseJSON.errors.join('<br>') : 'An error occurred';
                Swal.fire({
                    icon: "error",
                    title: 'Oops! Failed',
                    text: errorMessage,
                    confirmButtonText: 'OK',
                });
            }
        });
    });
});
</script>


