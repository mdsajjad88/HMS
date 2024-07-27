
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
                        <label for="first_name">First Name<span id="star">*</span></label>
                        <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter first name" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="last_name">Last Name<span id="star">*</span></label>
                        <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter last name" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter patient email">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="mobile">Mobile<span id="star">*</span></label>
                        <input type="number" class="form-control contact_no" id="mobile" name="mobile" placeholder="Enter contact no" required>
                        <small id="contact_no_res"></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="gender">Gender<span id="star">*</span></label>
                        <select class="form-control" id="gender" name="gender" required>
                            <option value="">Select patient gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="date_of_birth">Date of Birth<span id="star">*</span></label>
                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="age">Age <span id="star">*</span></label>
                        <input type="number" class="form-control" id="age" name="age" placeholder="Patient Age" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="nid">National ID</label>
                        <input type="text" class="form-control" id="nid" placeholder="Patient NID no" name="nid">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="marital_status">Marital status <span id="star">*</span></label>
                        <select class="form-control" id="marital_status" name="marital_status" required>
                            <option value="">Select Marital status</option>

                            <option value="Married">Married</option>
                            <option value="Unmarried">Unmarried</option>
                            <option value="Other">Other</option>

                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="height_cm">Height (cm)<span id="star">*</span></label>
                        <input type="text" class="form-control" id="height_cm" placeholder="Enter Patient Height" name="height_cm" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="weight_kg">Weight (kg)<span id="star">*</span></label>
                        <input type="text" class="form-control" id="weight_kg" placeholder="Enter Patient Weight" name="weight_kg" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="blood_group">Blood Group<span id="star">*</span></label>
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
                        <label for="patient_type_id">Subscription</label>
                             <select name="patient_type_id" id="patient_type_id" class="form-control" required>
                                <option value="" selected disabled>Select Patient Subscription</option>
                                <option value="1">Regular</option>
                                <option value="3">3 Month</option>
                                <option value="6">6 Month</option>
                            </select>
                        </div>
                    <div class="form-group col-md-6">
                        <label for="referral">Reference</label>
                        <input type="text" class="form-control" id="referral" placeholder="If Special Discount" name="referral">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="profession">Profession</label>
                        <input type="text" class="form-control" id="profession" placeholder="If Special Discount" name="profession">
                    </div>

                    <div class="form-group col-md-6" >
                        <label for="address">Address<span id="star">*</span></label>
                        <textarea class="form-control" id="address" name="address" rows="1" placeholder="Enter Address" placeholder="Enter Patient address" required></textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="geo_district_id">City<span id="star">*</span></label>
                        <select class="form-control geo_district" id="geo_district_id" name="geo_district_id" required>
                          <option value="" selected disabled>Select City</option>
                          @foreach ($districts as $city)
                          <option value="{{$city->id}}" >{{$city->district_name_eng}}</option>
                          @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="geo_upazila_id">State<span id="star">*</span></label>
                        <select class="form-control geo_upozilla" id="geo_upazila_id" name="geo_upazila_id" required>
                            <option value="" selected disabled>Select Upozilla</option>
                        </select>
                    </div>
                    {{-- <div class="form-group col-md-4">
                        <div class="row">
                            <div class="col-6">
                                <label for="">Regular</label>
                            </div>
                            <div class="col-6">
                                <input type="radio" name="subscriptions" id="is_regular" >
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="row">
                            <div class="col-6">
                                <label for="">Subscription 3 Months</label>
                            </div>
                            <div class="col-6">
                                <input type="radio" name="subscriptions"  id="is_subscriptions_3_months">
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="row">
                            <div class="col-6">
                                <label for="">Subscription 6 Months</label>
                            </div>
                            <div class="col-6">
                                <input type="radio" name="subscriptions" id="is_subscriptions_6_months">
                            </div>
                        </div>

                    </div> --}}

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

                        var newPatient = '<option value="' + respons.success.patient_user_id + '">' + respons.success.first_name + '</option>';
                        $('#patient_user_id').append(newPatient);


                    }
                    if(respons.error){
                        Swal.fire({
                        title: 'error!',
                        text: respons.error,
                        icon: 'error',
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
        });

        $('.geo_district').on('change', function(){
       var id = $(this).val();

       $.ajax({
        url: '/getupozilla/'+id,
        type: 'GET',
        success: function (response) {
                    $('.geo_upozilla').empty();
                    $('.geo_upozilla').append(
                        '<option disabled selected>Select Upozilla</option>');
                    $.each(response, function (index, area) {
                        $('.geo_upozilla').append('<option value="' + area.id + '">' +
                            area.upazila_name_eng + '</option>');
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

                            });
                    }
       })
    });
    })
</script>
