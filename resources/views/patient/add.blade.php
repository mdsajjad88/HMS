
<div class="modal  fade" id="patientModal" tabindex="-1" role="dialog" aria-labelledby="patientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header modalHeader">
                <h5 class="modal-title" id="doctorModalLabel">Add New Patient</h5>
                <button type="button" class="btn-close patientModalClose" id="closePatientModal" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-xmark"></i> </button>
            </div>
            <form id='addNewPatient' method="POST" enctype="multipart/form-data" >
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="form-group col-md-6">
                            <label for="first_name">Patient Name<span id="star">*</span></label>
                            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter first name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="mobile" class="d-flex">Mobile<span id="star">*</span> &nbsp; &nbsp; <span><small id="contact_no_res"></small></span></label>
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
                                    <option value="6">6 Month(Regular)</option>
                                    <option value="3">3 Month(Session)</option>
                                </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="subscript_date">Subscription Start Date</label>
                                <input type="date" class="form-control" name="subscript_date" id="subscript_date" readonly max="today">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="session_visite_count">Subscription Visit complete</label>
                                <input type="number" class="form-control session_visite_count" name="session_visite_count" placeholder="If already Subscription visited " readonly>
                        </div>


                        <div class="form-group col-md-6">
                            <label for="geo_district_id">District<span id="star">*</span></label>
                            <select class="form-control geo_district" id="geo_district_id" name="geo_district_id" required>
                            <option value="" selected disabled>Select City</option>
                            @foreach ($districts as $city)
                            <option value="{{$city->id}}" >{{$city->district_name_eng}}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="geo_upazila_id">Upozilla</label>
                            <select class="form-control geo_upozilla" id="geo_upazila_id" name="geo_upazila_id">
                                <option value="" selected disabled>Select Upozilla</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6" >
                            <label for="address">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="1" placeholder="Enter Address" placeholder="Enter Patient address"></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nid">National ID</label>
                            <input type="text" class="form-control" id="nid" placeholder="Patient NID no" name="nid">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="marital_status">Marital status</label>
                            <select class="form-control" id="marital_status" name="marital_status">
                                <option value="">Select Marital status</option>

                                <option value="Married">Married</option>
                                <option value="Unmarried">Unmarried</option>
                                <option value="Other">Other</option>

                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="blood_group">Blood Group</label>
                            <select class="form-control" id="blood_group"  name="blood_group">
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
                    <button type="reset" class="btn btn-secondary" >Reset</button>
                    <button type="submit" class="btn btn-primary">Save </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){

        function subsCription(){
            var today = new Date().toISOString().split('T')[0];

                var sessionCount = $('#patient_type_id').val();
            if(sessionCount == 3 || sessionCount == 33 || sessionCount == 6){
                $('#subscript_date').removeAttr('readonly');
                $('.session_visite_count').removeAttr('readonly');
                $('#subscript_date').val(today);
                $('#subscript_date').attr('max', today);
            }
            else{
                $('#subscript_date').attr('readonly', 'readonly');
                $('.session_visite_count').attr('readonly', 'readonly');
                $('#subscript_date').val('');
                }
        }

        $('#patient_type_id').on('change', function(){
            subsCription();
        })


            $('.contact_no').keyup(function() {

            var contact = $(this).val();
            var isNumeric = /^\d+$/.test(contact); // Regular expression to test if the input is numeric
            var sub = contact.substring(0, 2);
            var length = contact.length
            if(!isNumeric) {
            $('#contact_no_res').html('<p style="color:red">Contact no must contain only numeric digits</p>');
            }
            else if (sub != '01') {
            $('#contact_no_res').html('<p style="color:red">Contact no  must be start at 01</p>')
            } else if (length == 11) {
            $('#contact_no_res').html('<p style="color:green">Contact no is valid</p>')
            } else if (length != 11) {
            $('#contact_no_res').html(
            '<p style="color:red">Contact no length must be 11 character</p>')
            }
        });

        $('#addNewPatient').off('submit').on('submit', function(e){
            e.preventDefault(); // Prevent default form submission

            var form = $('#addNewPatient')[0];
            var formData = new FormData(form);

            $.ajax({
                method: 'POST',
                url: 'addNewPatient',
                data: formData,
                contentType: false, // Ensure to set these options for FormData
                processData: false,
                success: function(respons) {
                    $('#addNewPatient')[0].reset();
                    if(respons.success){
                        $('#closePatientModal').click();
                        $('#patientTable').DataTable().ajax.reload();
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!!',
                            text: 'Report Added Successfully',
                            confirmButtonText: 'OK',
                            timer: 2000, // Optional: show alert for 2 seconds before auto-closing
                            timerProgressBar: true // Optional: show a progress bar indicating the timer
                        }).then((result) => {
                            if (result.isConfirmed || result.dismiss === Swal.DismissReason.timer) {
                                window.location.reload();
                            }
                        });  // Redirect to new route
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
                error: function(xhr) {
                    console.log(xhr); // Log the entire response for debugging

                    var errorMessage = xhr.responseJSON && xhr.responseJSON.error
                        ? xhr.responseJSON.error
                        : xhr.responseText || 'An unknown error occurred.';

                    Swal.fire({
                        title: 'Error!',
                        text: errorMessage,
                        icon: 'error'
                    });
                }

            });
        });

        $('.geo_district').on('change', function(){
       var id = $(this).val();

       $.ajax({
        url: 'getupozilla/'+id,
        type: 'GET',
        success: function (response) {
                    $('.geo_upozilla').empty();


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
            });
        });




        $('.patientModalClose').click(function(){
            window.location.reload();
        })
    });

</script>
