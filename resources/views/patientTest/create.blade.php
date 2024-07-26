<div class="modal fade" id="patientTestCreateModal" tabindex="-1" aria-labelledby="reportCreateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header modalHeader">
                <h5 class="modal-title" id="reportCreateModalLabel">Patient Medical Test Create</h5>
                <button type="button" class="btn-close" id="closeTestCreate" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <!-- Form  action=""-->
                <form  id="patientTestStore">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="patient_user_id">Patient Username</label>
                                <select name="patient_user_id" id="patient_user_id" class="form-control"  required>
                                    <option value="">Select Patient name</option>
                                    @foreach ($patients as $patient)
                                    <option value="{{$patient->id}}">{{$patient->username}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="doctor_profile_id">Select Doctor </label>
                                <select name="doctor_profile_id" id="doctor_profile_id" class="form-control" required>
                                    <option value="" selected disabled>---Select---</option>
                                    @foreach ($doctors as $doctor)
                                    <option value="{{$doctor->id}}">{{$doctor->first_name." ".$doctor->last_name}}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">

                                <label for="medical_test">Medical Test:</label>
                                <div class="row">
                                    <div class="col-md-10">
                                        <select name="medical_test[]" id="medical_test" class="form-control">
                                            <option value="">---Select---</option>

                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn  btn-dark" type="button" id="add_medical_test">Add</button>
                                    </div>
                                    <div class="col-md-12" id="new_medical_test">

                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Status:</label>
                                <select id="status" name="status" class="form-control" required>
                                    <option value="1">Pending</option>
                                    <option value="2">Completed</option>
                                    <option value="3">Cancelled</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="types">Types:</label>
                                <input type="text" id="types" name="types" class="form-control" value="1" placeholder="Enter types">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="collection_charge">Collection Charge:</label>
                                <input type="number" id="collection_charge" name="collection_charge" class="form-control" step="0.01" placeholder="Enter collection charge">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="others_discount">Others Discount:</label>
                                <input type="number" id="others_discount" name="others_discount" class="form-control" step="0.01" placeholder="Enter others discount">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="amount">Amount:</label>
                                <input type="number" id="amount" name="amount" class="form-control" step="0.01" placeholder="Enter amount">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="discount">Discount:</label>
                                <input type="number" id="discount" name="discount" class="form-control" step="0.01" placeholder="Enter discount">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="final_total">Final Total:</label>
                                <input type="number" id="final_total" name="final_total" class="form-control" step="0.01" placeholder="Enter final total">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="paid_amount">Paid Amount:</label>
                                <input type="number" id="paid_amount" name="paid_amount" class="form-control" step="0.01" placeholder="Enter paid amount">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="payment_status">Payment Status:</label>
                                <select id="payment_status" name="payment_status" class="form-control"  required>
                                    <option value="1">Pending</option>
                                    <option value="2">Paid</option>
                                    <option value="3">Partial</option>
                                </select>
                            </div>
                        </div>

                        <!-- Additional fields like created_by, modified_by, helped_by can be added if needed -->
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-primary">Reset</button>
                            <button type="submit" class="btn btn-primary">Submit</button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        var medicalTests = @json($medicalTests); // Convert PHP array to JavaScript object
        function populateOptions(selectElement) {
        $(selectElement).empty(); // Clear existing options
        $(selectElement).append('<option value="">---Select---</option>'); // Add default option

        // Iterate through medicalTests array and append options to select element
        $.each(medicalTests, function(index, test) {
            $(selectElement).append('<option value="' + test.id + '">' + test.name + '</option>');
        });
    }

    // Initial population of the first select box
    populateOptions('#medical_test');
        $('#add_medical_test').click(function(){
            var medicalTests = @json($medicalTests);
            var test = `<div class="row mt-1">
                                    <div class="col-md-10">
                                        <select name="medical_test[]" id="medical_test" class="form-control new-medical-test">
                                            <option value="">---Select---</option>

                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button type='button' class="btn btn-sm btn-danger" id="removeBtn">Remove</button>
                                    </div>
                                </div>`;
                        $('#new_medical_test').append(test);

                        var newSelectElement = $('#new_medical_test').find('.new-medical-test:last');
                        populateOptions(newSelectElement);
        });
        $('#new_medical_test').on('click', '#removeBtn', function() {
        $(this).closest('.row').remove();
    });
        $('#patientTestStore').off('submit').on('submit', function(e){
            e.preventDefault();
            var form = $('#patientTestStore')[0];
            var formData = new FormData(form);

            $.ajax({
                method: 'POST',
                url: "{{route('patient-medical-tests.store')}}",
                data: formData,
                contentType: false, // Ensure to set these options for FormData
                processData: false,
                success:function(response){
                    $('#patientTestStore')[0].reset();
                    $('#closeTestCreate').click();

                    Swal.fire({
                        icon: 'success',
                        title: 'success!!',
                        text: 'Test cteate Successfully',
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

                            });
                    }
            });
        });

    })
</script>
