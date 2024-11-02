@extends('layouts.main')
@section('title', 'Create New Report')
@section('content')
<style>
   .btn-check {
    display: none; /* Hide the actual radio button and checkbox */
}

.btn {
    cursor: pointer; /* Change cursor to pointer */
    padding: 5px 10px; /* Add padding for better appearance */
    border-radius: 5px; /* Optional: make edges rounded */
}

.btn.active {
    color: white; /* Change text color when active */
}

.btn-outline-success {
    border: 1px solid #28a745; /* Border color */
    background-color: transparent; /* Background color when inactive */
}

.btn-outline-success.active {
    background-color: #28a745; /* Background color when active */
}

.btn-outline-info {
    border: 1px solid #17a2b8; /* Border color */
    background-color: transparent; /* Background color when inactive */
}

.btn-outline-info.active {
    background-color: #17a2b8; /* Background color when active */
}

    </style>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6" id="reportCreteDesign">
            <form id="addReport" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mb-3">
                    <div class="col-2">
                        <a href="{{ route('medical-report.index') }}" class="btn btn-success"><-Back</a>
                    </div>
                    <div class="col-10">
                        <h2 class="text-center"><u>Create New Report</u></h2>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="patient_user_id" class="form-label">Patient Name <span id="star">*</span> &nbsp;<span><b id="board_result"></b></span></label>
                    <div class="row">
                        <div class="col-md-10">
                            <select name="patient_user_id" class="form-control patient_user_id" id="patient_user_id" required>
                                <option value="">Select Patient</option>
                            </select>
                        </div>
                        <div class="col-md-2 text-end">
                            <button type="button" id="patientCreate" class="btn btn-primary"><i class="fa-solid fa-plus"></i>Add</button>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="doctor_user_id" class="form-label">Doctor Name</label>
                    <select name="doctor_user_id" class="form-control" id="doctor_user_id" required>
                        <option value="" selected disabled>Select Doctor</option>
                    </select>
                </div>

                <div class="mb-3">
                    <div class="row">
                        <div class="col-9">
                            <label for="no_of_visite" class="form-label">No of Visit <span id="star">*</span>
                                <span><small id="patient_type_id"></small><small id="startDate"></small>
                                    <small class="d-none to"> to </small> <small id="endDate"></small></span>
                            </label>
                            <input type="number" class="form-control" name="no_of_visite" id="no_of_visite" placeholder="No of visit" required readonly>
                        </div>
                        <div class="col-3">
                            <label for="last_visited_date" class="form-label">Last Visited Date</label>
                            <input type="date" class="form-control" id="last_visited_date" disabled>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="row">
                        <div class="col-5">
                            <label for="today_date" class="form-label">Today Visit Date <span id="star">*</span>
                                <small class="showSession"></small></label>
                            <input type="date" class="form-control" name="last_visited_date" id="today_date" required>
                        </div>
                        <div class="col-2 d-flex flex-column align-items-center justify-content-center">
                            <label for="is_session_visite">Is Session?</label>
                            <input type="checkbox" name="is_session_visite" id="is_session_visite">
                            <div class="popup" id="popup-message">Patient does not have a subscription</div>
                        </div>
                        <div class="col-5">
                            <label for="session_visite_count" class="form-label">Session Visit No</label>
                            <input type="number" class="form-control" name="session_visite_count" id="session_visite_count" placeholder="No of session visit" readonly>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="problem_id" class="form-label">Problems <span id="star" class="probelmError">*</span></label>
                    <div class="row">
                        <div class="col-md-10">
                            <select name="problem_id[]" id="problem_id" class="multipleProblem form-control" multiple required>
                            </select>
                        </div>
                        <div class="col-md-2 text-end">
                            <button type="button" class="btn btn-primary" id="problem_add">
                                <i class="fa-solid fa-plus"></i>Add
                            </button>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="comments" class="form-label">Comments <span id="star" class="commentError">*</span></label>
                    <div class="row">
                        <div class="col-md-10">
                            <select name="comment_id[]" id="comments" class="form-control new-comment" multiple required>
                            </select>
                        </div>
                        <div class="col-md-2 text-end">
                            <a href="{{ action([\App\Http\Controllers\CommentController::class, 'create']) }}" class="btn btn-primary create_comment"><i class="fas fa-plus"></i>Add</a>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="comment" class="form-label">Comment/Patient Feedback or Suggestion</label>
                    <textarea name="comment" id="comment" class="form-control" rows="2" placeholder="Comment of this patient"></textarea>
                </div>

                <div class="mb-3">
                    <label for="physical_improvement" class="form-label">Physical Improvement <span id="star">*</span></label>
                    <div class="row" id="improvementSection">
                        <div class="col-md-2">
                            <input type="radio" class="btn-check" name="physical_improvement" id="success-outlined" value="1" required>
                            <label class="btn btn-outline-success" for="success-outlined">Yes</label>
                        </div>
                        <div class="col-md-2">
                            <input type="radio" class="btn-check" name="physical_improvement" id="dark-outlined" value="0" required>
                            <label class="btn btn-outline-success" for="dark-outlined">No</label>
                        </div>
                        <div class="col-md-3" id="is_board">
                            <input type="checkbox" class="btn-check" name="is_board" id="info-outlined" value="1">
                            <label class="btn btn-outline-info" for="info-outlined">Is Board</label>
                        </div>
                    </div>
                    <div class="row" id="first_visite">
                        <div class="col-md-3">
                            <input type="radio" class="btn-check" name="physical_improvement" id="primary-outlined" value="first_visite" checked required>
                            <label class="btn btn-outline-success" for="primary-outlined">First Visit</label>
                        </div>
                    </div>
                </div>



                <div class="row mt-1">
                    <div class="col-md-8"></div>
                    <div class="col-md-4 text-end">
                        <button type="reset" class="btn btn-secondary">Reset</button>
                        <button type="submit" class="btn btn-primary">Save Report</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-3"></div>
        <div class="modal fade create_comment_view" tabindex="-1" role="dialog"
            aria-labelledby="gridSystemModalLabel">
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#session_visite_count').empty();
        $('#is_session_visite').prop('disabled', true);
        $('#is_board').hide();
        var patients = @json($patients);
        var doctors = @json($doctors);
        var problems = @json($problems);
        var comments = @json($comments);

        function setTodayDate() {
            var today = new Date();
            var date = today.getDate();
            var month = today.getMonth() + 1;
            var year = today.getFullYear();
            var formattedDate = year + '-' + (month < 10 ? '0' + month : month) + '-' + (date < 10 ? '0' + date : date);
            $('#today_date').val(formattedDate);
        }
        setTodayDate();

        $.each(patients, function (index, patient) {
            $('#patient_user_id').append('<option value="' + patient.patient_user_id + '">' + patient.first_name + ' - ' + patient.mobile + '</option>');
        });
        $.each(comments, function (index, comment) {
            $('#comments').append('<option value="' + comment.id + '">' + comment.name + '</option>');
        });
        $.each(doctors, function (index, doctor) {
            $('#doctor_user_id').append('<option value="' + doctor.user_id + '">' + doctor.first_name + '</option>');
        });
        $.each(problems, function (index, problem) {
            $('#problem_id').append('<option value="' + problem.id + '">' + problem.name + '</option>');
        });

        $('#patient_user_id').on('change', function () {
            // Clear fields
            $('#is_board').hide();
            $('#no_of_visite').empty();
            $('#last_visited_date').empty();
            $('#patient_type_id').empty();
            $('#is_session_visite').prop('checked', false);
            $('#session_visite_count').val('');
            $('#board_result').empty();           // Get selected patient ID
            var reportId = $(this).val();
            var url = "{{ route('report.latest', ['id' => 'REPORT_ID']) }}".replace('REPORT_ID', reportId);

            // Make AJAX request
            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                success: function (response) {
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
                       if (response.data && response.data.problems) {
                            var selectedProblemIds = response.data.problems.map(p => p.id);
                            $('#problem_id').val(selectedProblemIds).trigger('change');
                        } else {
                            // Handle the case where no problems are available
                            $('#problem_id').val([]).trigger('change'); // Clear or set a default value
                        }

                        // Handle comments
                        if (response.data && response.data.comments) {
                            var selectedCommentIds = response.data.comments.map(c => c.id);
                            $('#comments').val(selectedCommentIds).trigger('change');
                        } else {
                            // Handle the case where no comments are available
                            $('#comments').val([]).trigger('change'); // Clear or set a default value
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
                            if(report.no_of_visite >= 3){
                                $('#is_board').show();
                                if(report.is_board == 1){
                                    $('#board_result').text('Board');
                                }
                            }
                            $('#last_visited_date').val(report.last_visited_date);
                            $('#doctor_user_id').val(report.doctor_user_id);
                            $('#first_visite').hide();
                            $('#improvementSection').show();
                            $('#primary-outlined').prop('checked', false);

                            // Update session visit count
                            var sessionVisitCount = 0;

                                // Check if ltsSession is defined and has the session_visite_count property
                                if (ltsSession && ltsSession.session_visite_count !== undefined) {
                                    sessionVisitCount = ltsSession.session_visite_count + 1;
                                } else {
                                    sessionVisitCount = 1; // or handle it as needed (e.g., starting count at 1)
                                }                            $('#is_session_visite').change(function () {
                                if ($(this).is(':checked')) {
                                    $('#session_visite_count').val(sessionVisitCount);
                                } else {
                                    $('#session_visite_count').val('');
                                }
                            });

                        } else if (response.nodata) {
                            $('#no_of_visite').val(1);
                            $('#last_visited_date').val('');
                            $('#doctor_user_id').val('');
                            $('#improvementSection').hide();
                            $('#first_visite').show();

                            $('#is_session_visite').change(function () {
                                if ($(this).is(':checked')) {
                                    $('#session_visite_count').val(1);
                                }
                            });

                        }
                    }
                    dataAssign();
                }
            });
        });

        $('#problem_add').click(function () {
            $.ajax({
                type: 'GET',
                url: '{{ route("problems.create") }}',
                success: function (response) {
                    $('body').append(response);
                    $('#problemCreating').modal('show');
                }
            });
        });

        $('#patientCreate').on('click', function () {
            $.ajax({
                method: 'GET',
                url: '{{ route("add.patient") }}',
                cache: false,
                success: function (response) {
                    $('body').append(response);
                    $('#patientModal').modal({ backdrop: 'static', keyboard: false });
                    $('#patientModal').modal('show'); // Show modal
                }
            });
        });

        $('#addReport').off('submit').on('submit', function (e) {
            e.preventDefault();
            var form = $('#addReport')[0];
            var formData = new FormData(form);
            $.ajax({
                method: 'POST',
                url: "{{ route('medical-report.store') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    $('#addReport')[0].reset();
                    $('#reportTable').DataTable().ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!!',
                        text: 'Report Added Successfully',
                        confirmButtonText: 'OK',
                        timer: 2000,
                        timerProgressBar: true
                    }).then((result) => {
                        if (result.isConfirmed || result.dismiss === Swal.DismissReason.timer) {
                            window.location.href = '{{ route("medical-report.index") }}';
                        }
                    });
                },
                error: function (xhr, status, error) {
                    var errorMessage = '';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage += xhr.responseJSON.message;
                    } else {
                        errorMessage += status;
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops',
                        text: errorMessage,
                        confirmButtonText: 'OK',
                    });
                }
            });
        });

        $('#problem_id').select2({
            placeholder: "Select problem",
            allowClear: false,
        });
        $('#comments').select2({
            placeholder: "Select comments",
            allowClear: false,
        });
        $('#patient_user_id').select2({
            placeholder: "Select Patient",
            allowClear: false,
        });

        $('#is_session_visite').on('mouseover', function () {
            if ($(this).is(':disabled')) {
                $('#popup-message').css({
                    'display': 'block',
                    'opacity': 1
                });
            }
        });

        $('#is_session_visite').on('mouseout', function () {
            $('#popup-message').css({
                'display': 'none',
                'opacity': 0
            });
        });
        $(document).on('click', '.create_comment', function(e) {
            e.preventDefault();
            $('div.create_comment_view').load($(this).attr('href'), function() {
                $(this).modal('show');
            });
        });
        $('input[type="radio"].btn-check').change(function() {
            // Remove 'active' class from all labels in the radio group
            $('input[name="physical_improvement"]').each(function() {
                $('label[for="' + $(this).attr('id') + '"]').removeClass('active');
            });

            // Add 'active' class to the selected label
            if ($(this).is(':checked')) {
                $('label[for="' + $(this).attr('id') + '"]').addClass('active');
            }
        });

        $('input[type="checkbox"].btn-check').change(function() {
            // Toggle the 'active' class for the checkbox label
            if ($(this).is(':checked')) {
                $('label[for="' + $(this).attr('id') + '"]').addClass('active');
            } else {
                $('label[for="' + $(this).attr('id') + '"]').removeClass('active');
            }
        });
    });
</script>
@endsection
