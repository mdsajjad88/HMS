@extends('layouts.main')
@section('title', 'create new report')
@section('content')


    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6" id="reportCreteDesign">
                <form id="addReport" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-2">
                            <a href="{{route('medical-report.index')}}" class="btn btn-success"><-Back</a>
                         </div>
                        <div class="col-10">
                            <div class="h2 text-center"><u>Create new report</u></div>
                        </div>

                    </div>
                    <div class="row">
                        <label for="select_patient" class="form-label"> Patient Name<span id="star">*</span></label>
                        <div class="col-md-10">
                            <select name="patient_user_id" class="form-control patient_user_id" id="patient_user_id"
                                required>
                                <option value="">Select Patient </option>
                            </select>
                        </div>
                        <div class="col-md-2 text-right">
                            <button type="button" id="patientCreate" class="btn btn-primary"><i
                                    class="fa-solid fa-plus"></i>Add</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="select_doctor" class="form-label"> Doctor Name </label>
                            <select name="doctor_user_id" class="form-control" id="doctor_user_id" required>
                                <option value="" selected disabled>Select Doctor</option>

                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-9">
                            <label for="no_of_visite" class="form-label">No of Visit <span id="star">*</span>
                                <span><small id="patient_type_id"></small><small id="startDate"></small> <small class="d-none to"> to </small> <small
                                        id="endDate"></small></span></label>
                            <input type="number" class="form-control" name="no_of_visite" id="no_of_visite"
                                placeholder="No of visit" required readonly>
                        </div>
                        <div class="col-3">
                            <label for="last_visited_date" class="form-label">Last visited date </label>
                            <input type="date" class="form-control" id="last_visited_date" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5">
                            <label for="today_date" class="form-label">Today visit date  <span
                                    id="star">*</span> <small class="showSession"></small></label>
                            <input type="date" class="form-control" name="last_visited_date" id="today_date" required>
                        </div>
                        <div class="col-2 d-flex flex-column align-items-center justify-content-center">
                            <label for="">Is Session?</label>
                            <input type="checkbox" name="is_session_visite" id="is_session_visite">
                            <div class="popup" id="popup-message">Patient does not have a subscription</div>
                        </div>

                        <div class="col-5">
                            <label for="session_visite_count" class="form-label">Session Visit no </label>
                            <input type="number" class="form-control" name="session_visite_count" id="session_visite_count"
                                placeholder="No of session visite" readonly>
                        </div>

                    </div>
                    <div class="row">

                        <label for="problem_id" class="form-label">Problems <span id="star" class="probelmError">*</span></label>

                        <div class="col-md-10">

                            <select name="problem_id[]" id="problem_id" class="multipleProblem form-control" multiple
                                required>

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
                                        <label class="btn btn-outline-success" for="primary-outlined">First Visit</label>
                                    </div>
                                </section>

                            </div>
                        </div>
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


            $('#session_visite_count').empty();
            $('#is_session_visite').prop('disabled', true);
            var patients = @json($patients);
            var doctors = @json($doctors);
            var problems = @json($problems);

            function setTodayDate() {

                var today = new Date();
                var date = today.getDate();
                var month = today.getMonth() + 1;
                var year = today.getFullYear();

                var formattedDate = year + '-' + (month < 10 ? '0' + month : month) + '-' + (date < 10 ? '0' +
                    date : date);
                $('#today_date').val(formattedDate);
            }
            setTodayDate();
            $.each(patients, function(index, patient) {
                $('#patient_user_id').append('<option value="' + patient.patient_user_id + '">' +
                    patient.first_name + ' - ' + patient.mobile + '</option>');
            });
            $.each(doctors, function(index, doctors) {
                $('#doctor_user_id').append('<option value="' + doctors.user_id + '">' +
                    doctors.first_name + '</option>');
            });
            $.each(problems, function(index, problem) {
                $('#problem_id').append('<option value="' + problem.id + '">' +
                    problem.name + '</option>');
            });


           $('#patient_user_id').on('change', function() {
                // Clear fields
                $('#no_of_visite').empty();
                $('#last_visited_date').empty();
                $('#patient_type_id').empty();
                $('#is_session_visite').prop('checked', false);
                $('#session_visite_count').val('');

                // Get selected patient ID
                var reportId = $(this).val();
                var url = "{{ route('report.latest', ['id' => 'REPORT_ID']) }}".replace('REPORT_ID', reportId);

                // Make AJAX request
                $.ajax({
                    url: url,
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        // Function to assign data to elements
                        function dataAssign() {
                            // Patient type handling
                            var patient = response.patient || {};
                            var status = patient.patient_type_id;
                            if (status) {
                                switch (status) {
                                    case 1:
                                        $('#patient_type_id').text('(Regular Patient)');
                                        $('.to').addClass('d-none');
                                        $('.showSession').addClass('d-none');
                                        break;
                                    case 2:
                                        $('#patient_type_id').text('(No Subscription)');
                                        $('#is_session_visite').prop('disabled', true);
                                        break;
                                    case 3:
                                        $('#patient_type_id').text('(3 Months Subscription)');
                                        break;
                                    case 33:
                                        $('#patient_type_id').text('(3 Months Regular)');
                                        $('#is_session_visite').prop('disabled', true);
                                        break;
                                    case 6:
                                        $('#patient_type_id').text('(6 Months Regular)');
                                        $('#is_session_visite').prop('disabled', true);
                                        break;
                                }
                            }

                            // Handle subscription dates
                            var subscription = response.subscription;
                            if (subscription) {
                                $('#startDate').text(subscription.subscript_date || '');
                                $('#endDate').text(subscription.expiry_date || '');
                                $('.to').removeClass('d-none');
                                $('.showSession').removeClass('d-none');
                            } else {
                                $('#startDate').empty();
                                $('#endDate').empty();
                            }

                            // Handle session visit
                            var session = response.session;
                            if (status != 3) {
                                $('.showSession').text('(Out of session)');
                            } else {
                                $('.showSession').text('(Session visit)');
                                $('#is_session_visite').prop('disabled', false);
                            }

                            // Handle report data
                            if (response.data) {
                                var report = response.data;
                                var ltsSession = response.ltsSession;
                                $('#no_of_visite').val(report.no_of_visite + 1);
                                $('#last_visited_date').val(report.last_visited_date);
                                $('#doctor_user_id').val(report.doctor_user_id);
                                $('#first_visite').hide();
                                $('#improvementSection').show();
                                $('#primary-outlined').prop('checked', false);

                                // Update session visit count
                                var sessionVisitCount = (ltsSession.session_visite_count || 0) + 1;
                                $('#is_session_visite').change(function() {
                                    if ($(this).is(':checked')) {
                                        $('#session_visite_count').val(sessionVisitCount);
                                    } else {
                                        $('#session_visite_count').val('');
                                    }
                                });

                                // Populate problem IDs
                                if (response.data.problems) {
                                    var selectedProblemIds = response.data.problems.map(p => p.id);
                                    $('#problem_id').val(selectedProblemIds).trigger('change');
                                }
                            } else if (response.nodata) {
                                // Handle no data case
                                $('#no_of_visite').val(1);
                                $('#last_visited_date').val('');
                                $('#doctor_user_id').val('');
                                $('#improvementSection').hide();
                                $('#first_visite').show();
                            }
                        }

                        // Call the function to assign data
                        dataAssign();
                    }
                });
            });




            $('#problem_add').click(function() {
                $.ajax({
                    type: 'GET',
                    url: '{{ route("problems.create") }}',
                    success: function(respons) {
                        $('body').append(respons);
                        $('#problemCreating').modal('show');
                    }
                })
            });


        $('#patientCreate').on('click', function(){
            $.ajax({
                method: 'GET',
                url: '{{route("add.patient")}}',
                cache: false,
                success: function(response) {
                    $('body').append(response);
                    $('#patientModal').modal({backdrop: 'static', keyboard: false});
                    $('#patientModal').modal('show'); // Show modal
                }
            })
        })
            $('#addReport').off('submit').on('submit', function(e) {
                e.preventDefault();
                var form = $('#addReport')[0];
                var formData = new FormData(form);
                $.ajax({
                    method: 'POST',
                    url: "{{ route('medical-report.store') }}",
                    data: formData,
                    contentType: false, // Ensure to set these options for FormData
                    processData: false,
                    success: function(response) {
                        $('#addReport')[0].reset();
                        $('#reportTable').DataTable().ajax.reload();
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!!',
                            text: 'Report Added Successfully',
                            confirmButtonText: 'OK',
                            timer: 2000, // Optional: show alert for 2 seconds before auto-closing
                            timerProgressBar: true // Optional: show a progress bar indicating the timer
                        }).then((result) => {

                            if (result.isConfirmed || result.dismiss === Swal.DismissReason.timer) {

                                window.location.href = '{{ route("medical-report.index") }}';
                            }
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
                allowClear: false,

            });
            $('#patient_user_id').select2({
                placeholder: "Select Patient",
                allowClear: false,

            });


        });
        $(document).ready(function() {
    $('#is_session_visite').on('mouseover', function() {
        if ($(this).is(':disabled')) {
            $('#popup-message').css({
                'display': 'block',
                'opacity': 1
            });
        }
    });

    $('#is_session_visite').on('mouseout', function() {
        $('#popup-message').css({
            'display': 'none',
            'opacity': 0
        });
    });
});


    </script>
@endsection
