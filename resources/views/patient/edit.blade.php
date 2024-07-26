
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
                        <label for="age">Age</label>
                        <input type="number" class="form-control" id="age" name="age" required>
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
                        <label for="discount">Discount</label>
                        <input type="number" class="form-control" id="discount" name="discount" placeholder="if Discount have">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="referral">Reference</label>
                        <input type="text" class="form-control" id="referral" name="referral" placeholder="If anyone Reference">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="profession">Profession</label>
                        <input type="text" class="form-control" id="profession" name="profession" placeholder="Patient profession">
                    </div>
                    <div class="form-group col-md-6" >
                        <label for="address">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="1" placeholder="Enter Address" required></textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="geo_district_id">City<span id="star">*</span></label>
                        <select class="form-control edit_geo_district" id="geo_district_id" name="geo_district_id" required>
                          <option value="" selected disabled>Select City</option>
                          @foreach ($districts as $city)
                          <option value="{{$city->id}}" >{{$city->district_name_eng}}</option>
                          @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="geo_upazila_id ">State<span id="star">*</span></label>
                        <select class="form-control edit_geo_upozilla" id="geo_upazila_id" name="geo_upazila_id " required>
                            <option value="" selected disabled>Select Upozilla</option>
                            @foreach ($states as $state)
                            <option value="{{$state->id}}" >{{$state->upazila_name_eng}}</option>
                            @endforeach
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
                    $('#geo_district_id').val(patient.geo_district_id);
                    $('#geo_upazila_id').val(patient.geo_upazila_id );
                    $('#age').val(patient.age);
                    $('#referral').val(patient.referral);
                    $('#profession').val(patient.profession);
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

                },

                // Handle error response
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
        })
        $('.edit_geo_district ').on('change', function(){
       var id = $(this).val();
       $.ajax({
        url: '/getupozilla/'+id,
        type: 'GET',
        success: function (response) {
                    $('.edit_geo_upozilla ').empty();
                    $('.edit_geo_upozilla ').append(
                        '<option disabled selected>Select Upozilla</option>');
                    $.each(response, function (index, area) {
                        $('.edit_geo_upozilla ').append('<option value="' + area.id + '">' +
                            area.upazila_name_eng + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        var errors = xhr.responseJSON.errors;
                        var errorMessage = '';
                        for (var key in errors) {
                            errorMessage += errors[key].join('<br>');
                            Swal.fire({
                            icon: "error",
                            title: 'Opps! Failed',
                            text: errorMessage,
                            confirmButtonText: 'OK',
                            })
                        return false;
                        }

                    }
                }
       })
    });
     })
</script>

