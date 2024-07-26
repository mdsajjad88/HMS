@extends('layouts.app')
@section('title', 'create new report')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6" id="reportCreteDesign">
            <form id="addReport" method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="row">
                        <div class="col">
                            <div class="h2 text-center"><u>Create new report</u></div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="select_patient" class="form-label"> Patient Name<span
                            id="star">*</span></label>
                        <div class="col-md-10">
                            <select name="patient_user_id" class="form-control patient_user_id" id="patient_user_id" required>
                                <option value="">Select Patient </option>
                            </select>
                        </div>
                        <div class="col-md-2 text-right">
                            <button type="button" class="addPatient btn btn-primary"><i class="fa-solid fa-plus"></i>Add</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="select_doctor" class="form-label"> Doctor Name </label>
                            <select name="doctor_user_id" class="form-control" id="doctor_user_id">
                                <option value="">Select Doctor</option>

                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="no_of_visite" class="form-label">No of Visit <span id="star">*</span></label>
                            <input type="number" class="form-control" name="no_of_visite" id="no_of_visite"
                                placeholder="No of visite" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="last_visited_date" class="form-label">Last visited date </label>
                            <input type="date" class="form-control" id="last_visited_date"
                            disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="last_visited_date" class="form-label">Today visite date <span
                                id="star">*</span></label>
                            <input type="date" class="form-control" name="last_visited_date" id="today_date"
                            required>
                        </div>
                    </div>
                    <div class="row">

                        <label for="problem_id" class="form-label">Problems <span id="star">*</span></label>
                        
                        <div class="col-md-10">

                            <select name="problem_id[]" id="problem_id" class="multipleProblem form-control" multiple required>
                                <option value="">Select problem</option>
                            </select>
                        </div>
                        <div class="col-md-2 text-right">
                            <button type="button" class="btn btn-primary" id="problem_add">
                                <i class="fa-solid fa-plus"></i>Add
                            </button>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="comment" class="form-label">Comment/Patient Feedback or Suggetion </label>
                            <textarea name="comment" id="comment" class="form-control" rows="2" placeholder="Comment of this patient"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="physical_improvement" class="form-label">Physical Improvement <span
                                id="star">*</span></label>
                        <div class="row">
                            <section id="improvementSection">
                                <div class="col-md-2">
                                    <input type="radio" class="btn-check" name="physical_improvement"
                                        id="success-outlined" value="1" required>
                                    <label class="btn btn-outline-success" for="success-outlined">Yes</label>

                                </div>
                                <div class="col-md-2">
                                    <input type="radio" class="btn-check" name="physical_improvement"
                                        id="dark-outlined" value="0" required>
                                    <label class="btn btn-outline-success" for="dark-outlined">No</label>
                                </div>
                            </section>
                            <section id="first_visite">
                                <div class="col-md-3">
                                    <input type="radio" class="btn-check" name="physical_improvement"
                                        id="primary-outlined" value="first_visite" checked required>
                                    <label class="btn btn-outline-success" for="primary-outlined">First Visite</label>
                                </div>
                            </section>

                        </div>
                        </div>
                    </div>
                    <div class="hidden">
                        <input type="hidden" name="no_of_medicine">
                        <input type="hidden" name="no_of_test">
                        <input type="hidden" name="no_of_ozone_therapy">
                        <input type="hidden" name="no_of_hijama_therapy">
                        <input type="hidden" name="on_of_acupuncture">
                        <input type="hidden" name="no_of_sauna">
                        <input type="hidden" name="no_of_physiotherapy">
                        <input type="hidden" name="no_of_coffee_anema">
                        <input type="hidden" name="no_of_others">
                        <input type="hidden" name="no_of_life_style_food">
                    </div>
                    <div class="row mt-1">
                        <div class="col-md-8">
                        </div>
                        <div class="col-md-4 text-right">
                            <button type="reset" class="btn btn-secondary">Reset</button>
                            <button type="submit" class="btn btn-primary">Save Report</button>
                        </div>
                    </div>
                    </div>


                </div>


            </form>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            var patients = @json($patients);
            var doctors = @json($doctors);
            var problems = @json($problems);
            function setTodayDate() {

            var today = new Date();
            var date = today.getDate();
            var month = today.getMonth() + 1;
            var year = today.getFullYear();

            var formattedDate = year + '-' + (month < 10 ? '0' + month : month) + '-' + (date < 10 ? '0' + date : date);
            $('#today_date').val(formattedDate);
        }
        setTodayDate();
            $.each(patients, function(index, patient) {
                $('#patient_user_id').append('<option value="' + patient.patient_user_id + '">' +
                    patient.first_name + '</option>');
            });
            $.each(doctors, function(index, doctors) {
                $('#doctor_user_id').append('<option value="' + doctors.user_id + '">' +
                    doctors.first_name + '</option>');
            });
            $.each(problems, function(index, problem) {
                $('#problem_id').append('<option value="' + problem.id + '">' +
                    problem.name + '</option>');
            });


            $('#patient_user_id').off('change').on('change', function() {
                $('#no_of_visite').empty();
                $('#last_visited_date').empty();
                var patient = $(this).val();
                $.ajax({
                    url: '/latest/report/' + patient,
                    method: 'GET',
                    success: function(respons) {
                        if(respons.data){
                        var report = respons.data;

                        $('#no_of_visite').val(report.no_of_visite+ 1);
                        $('#last_visited_date').val(report.last_visited_date);
                        $('#doctor_user_id').val(report.doctor_user_id);
                        $('#first_visite').hide();
                        $('#improvementSection').show();
                        $('#primary-outlined').prop('checked', false);
                        }
                        else if(respons.nodata){
                            $('#no_of_visite').val(' ');
                            $('#last_visited_date').val(' ');
                            $('#doctor_user_id').val(' ');
                            $('#improvementSection').hide();
                            $('#first_visite').show();
                        }

                    }
                });
            });
            $('#problem_add').click(function(){
                $.ajax({
                    type:'GET',
                    url: '{{route("problems.create")}}',
                    success:function(respons){
                        $('body').append(respons);
                        $('#problemCreating').modal('show');
                    }
                })
            });

            function addNewPatient(){
            $.ajax({
                method: 'GET',
                url: '/addPatient',
                success: function(response) {
                    $('body').append(response)
                    $('#patientModal').modal('show'); // Show modal

                }
            })
        }
        $('.addPatient').on('click', function(){
            addNewPatient();
        })
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
                        text: 'Report Added Successfully',
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
        $(document).ready(function() {
            $('#problem_id').select2({
                placeholder: "Select problem",
                allowClear: true
            });
            $('.multipleProblem').select2();
        });
    </script>
@endsection
