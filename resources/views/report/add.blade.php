
<div class="modal fade" id="reportCreateModal" tabindex="-1" aria-labelledby="reportCreateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header modalHeader">
                <h5 class="modal-title" id="reportCreateModalLabel">Add New Report</h5>
                <button type="button" class="btn-close" id="closeReportModal" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <!-- Form -->
                <form id="addReport" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <!-- First Name -->
                        <div class="col-md-6">
                            <label for="select_patient" class="form-label"> Patient Name</label>

                        <select name="patient_user_id" class="form-control" id="patient_user_id" multiple required>
                            <option value="">Select Patient</option>
                            @foreach ($patients as $patient)
                            <option value="{{$patient->patient_user_id}}">{{$patient->first_name}}</option>
                            @endforeach
                        </select>
                        </div>

                        <!-- Last Name -->
                        <div class="col-md-6">
                            <label for="select_doctor" class="form-label"> Doctor Name</label>
                            <select name="doctor_user_id" class="form-control" id="doctor_user_id"  required>
                                <option value="">Select Patient</option>
                                @foreach ($doctors as $doctor)
                                <option value="{{$doctor->user_id}}">{{$doctor->first_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label for="patient_medical_test_id" class="form-label">Medical Test</label>
                            <select name="patient_medical_test_id" id="patient_medical_test_id" class="form-control" required>
                                <option value="">Select Medical Test</option>
                                @foreach ($patient_medical_tests as $test)
                                <option value="{{$test->id}}">{{$test->name}}</option>
                                @endforeach
                            </select>

                        </div>


                        <div class="col-md-6">
                            <label for="prescribed_medicine_id" class="form-label">Prescribed Medicine </label>
                            <select name="prescribed_medicine_id" id="prescribed_medicine_id" class="form-control">
                                <option value="">prescribed_medicine_id</option>
                            </select>
                        </div>


                        <div class="col-md-6">
                            <label for="prescription_therapie_id" class="form-label">Prescription Therapies </label>
                           <select name="prescription_therapie_id" id="prescription_therapie_id" class="form-control">
                            <option value="">prescription_therapie_id</option>
                           </select>
                        </div>


                        <div class="col-md-6">
                            <label for="physical_improvement" class="form-label">Physical Improvement</label>
                            <div class="row">
                                <div class="col-md-2">
                                    <input type="radio" class="btn-check" name="physical_improvement" id="success-outlined" value="1" required>
                                    <label class="btn btn-outline-success" for="success-outlined">Yes</label>

                                </div>
                                <div class="col-md-2">
                                    <input type="radio" class="btn-check" name="physical_improvement" id="dark-outlined" value="0" required>
                                    <label class="btn btn-outline-success" for="dark-outlined">No</label>
                                </div>
                            </div>

                        </div>


                        <div class="col-md-6">
                            <label for="comment" class="form-label">Comment</label>
                          <textarea name="comment" id="comment" class="form-control" rows="2"></textarea>
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
        $('#addReport').off('submit').on('submit', function(e){
            e.preventDefault();
            var form = $('#addReport')[0];
            var formData = new FormData(form);
         console.log(formData)
            $.ajax({
                method: 'POST',
                url: "{{route('medical-report.store')}}",
                data: formData,
                contentType: false, // Ensure to set these options for FormData
                processData: false,
                success:function(response){
                    $('#addReport')[0].reset();
                    $('#closeReportModal').click();
                    $('#reportTable').DataTable().ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: 'success!!',
                        text: 'Report cteate Successfully',
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
    });
</script>
