
<div class="modal fade" id="reportCreateModal" tabindex="-1" aria-labelledby="reportCreateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header modalHeader">
                <h5 class="modal-title" id="reportCreateModalLabel">Add New Report</h5>
                <button type="button" class="btn-close" id="closeReportModal" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-xmark"></i> </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <!-- Form -->
                <form id="addReport" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <!-- First Name -->
                        <div class="col-md-6">
                            <label for="select_patient" class="form-label"> Patient Name<span id="star">*</span></label>

                            <select name="patient_user_id" class="form-control" id="patient_user_id" required>
                                <option value="">Select Patient  </option>
                                @foreach ($patients as $patient)
                                <option value="{{$patient->patient_user_id}}">{{$patient->first_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Last Name -->
                        <div class="col-md-6">
                            <label for="select_doctor" class="form-label"> Doctor Name  <span id="star">*</span></label>
                            <select name="doctor_user_id" class="form-control" id="doctor_user_id" required>
                                <option value="">Select Patient</option>
                                @foreach ($doctors as $doctor)
                                <option value="{{$doctor->user_id}}">{{$doctor->first_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label for="no_of_visite" class="form-label">No of Visit <span id="star">*</span></label>
                            <input type="number" name="no_of_visite" id="no_of_visite" class="form-control" placeholder="No of visite" required>
                        </div>

                        <div class="col-md-6">
                            <label for="last_visited_date" class="form-label">Last visited date <span id="star">*</span></label>
                           <input type="date" class="form-control" name="last_visited_date" required>
                        </div>

                        <div class="col-md-6">
                            <label for="no_of_medicine" class="form-label">No of medicine  <span id="star">*</span></label>
                           <input type="number" class="form-control" name="no_of_medicine" id="no_of_medicine" placeholder="No of Medicine" required>
                        </div>
                        <div class="col-md-6">
                            <label for="no_of_test" class="form-label">No of Test </label>
                           <input type="number" class="form-control" name="no_of_test" id="no_of_test" placeholder="No of Test">
                        </div>
                        <div class="col-md-6">
                            <label for="no_of_ozone_therapy" class="form-label">No of Ozone therapy</label>
                           <input type="number" class="form-control" name="no_of_ozone_therapy" id="no_of_ozone_therapy" placeholder="No of Ozone therapy">
                        </div>
                        <div class="col-md-6">
                            <label for="no_of_hijama_therapy" class="form-label">Hijama therapy</label>
                           <input type="number" class="form-control" name="no_of_hijama_therapy" id="no_of_hijama_therapy" placeholder="No of Hijama Therapy">
                        </div>
                        <div class="col-md-6">
                            <label for="on_of_acupuncture" class="form-label">No of Acupuncture</label>
                           <input type="number" class="form-control" name="on_of_acupuncture" id="on_of_acupuncture" placeholder="No of Acupanture">
                        </div>
                        <div class="col-md-6">
                            <label for="no_of_sauna" class="form-label">No of Sauna</label>
                           <input type="number" class="form-control" name="no_of_sauna" id="no_of_sauna" placeholder="No of Sauna">
                        </div>
                        <div class="col-md-6">
                            <label for="no_of_physiotherapy " class="form-label">No of Physiotherapy </label>
                           <input type="number" class="form-control" name="no_of_physiotherapy" placeholder="No of Physiotherapy">
                        </div>
                        <div class="col-md-6">
                            <label for="no_of_coffee_anema" class="form-label">No of Coffee enemas</label>
                           <input type="number" class="form-control" name="no_of_coffee_anema" id="no_of_coffee_anema" placeholder="No of Coffee enema">
                        </div>
                        <div class="col-md-6">
                            <label for="no_of_others" class="form-label">No of Others </label>
                           <input type="number" class="form-control" name="no_of_others" id="no_of_others" placeholder="No of Other ">
                        </div>
                        <div class="col-md-6">
                            <label for="no_of_life_style_food" class="form-label">No of life style food</label>
                           <input type="number" class="form-control" name="no_of_life_style_food" id="no_of_life_style_food" placeholder="No of patient lifestyle food ">
                        </div>
                        <div class="col-md-6">
                            <label for="problem_id" class="form-label">Problems </label>
                           <select name="problem_id" id="problem_id" class="form-control">
                            <option value="">Select problem</option>
                           </select>
                        </div>


                        <div class="col-md-6">
                            <label for="physical_improvement" class="form-label">Physical Improvement*</label>
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
                          <textarea name="comment" id="comment" class="form-control" rows="2" placeholder="Comment of this patient"></textarea>
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
                        text: response.success,
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

