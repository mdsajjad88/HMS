<style>
    .select2-container--default .select2-selection--multiple {
        z-index: 1051;
        /* Higher than the modal backdrop */
    }
</style>
<div class="modal fade" id="reportEditModal" tabindex="-1" aria-labelledby="reportCreateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header modalHeader">
                <h5 class="modal-title" id="reportEditModalLabel">Edit patient report</h5>
                <button type="button" class="btn-close" id="reportUpdateClose" data-bs-dismiss="modal"
                    aria-label="Close"> <i class="fas fa-xmark"></i> </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <!-- Form   -->
                <form id='updateReport' method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <!-- First Name -->
                        <div class="col-md-6">

                            <div>
                                <label for="select_patient" class="form-label"> Patient Name<span
                                        id="star">*</span></label>

                                <select name="patient_user_id" class="form-control" id="patient_user_id" required>
                                    <option value="">Select Patient </option>

                                </select>
                                <input type="hidden" id="id" name="id">
                            </div>
                            <div>
                                <label for="doctor_user_id" class="form-label"> Doctor Name <span
                                        id="star">*</span></label>
                                <select name="doctor_user_id" class="form-control" id="doctor_user_id" required>
                                    <option value="">Select Patient</option>

                                </select>
                            </div>
                            <div>
                                <label for="last_visited_date" class="form-label">Last visited date <span
                                        id="star">*</span></label>
                                <input type="date" class="form-control" name="last_visited_date"
                                    id="last_visited_date" required>
                            </div>
                            <div>
                                <label for="no_of_visite" class="form-label">No of Visit <span
                                        id="star">*</span></label>
                                <input type="number" name="no_of_visite" id="no_of_visite" class="form-control"
                                    placeholder="No of visite" required>
                            </div>
                            <div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="bd_medicine" class="form-label">BD medicine <span
                                                id="star">*</span></label>
                                        <input type="number" name="bd_medicine" id="bd_medicine" class="form-control"
                                            placeholder="Enter BD medicine no" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="us_medicine" class="form-label">US medicine <span
                                                id="star">*</span></label>
                                        <input type="number" name="us_medicine" id="us_medicine" class="form-control"
                                            placeholder="Enter US medicine no">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="no_of_medicine" class="form-label">Total medicine <span
                                                id="star">*</span></label>
                                        <input type="text" name="no_of_medicine" id="no_of_medicine"
                                            class="form-control " readonly placeholder="0" required>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label for="no_of_test" class="form-label">No of Test </label>
                                <input type="number" class="form-control" name="no_of_test" id="no_of_test"
                                    placeholder="No of Test">
                            </div>

                        </div>



                        <div class="col-md-6 p-4">

                            <div>
                                <label for="no_of_ozone_therapy" class="form-label">Ozone therapy</label> &nbsp;&nbsp;
                                <input type="checkbox" name="no_of_ozone_therapy" id="no_of_ozone_therapy">
                            </div>
                            <div>
                                <label for="no_of_hijama_therapy" class="form-label">Hijama therapy</label> &nbsp;&nbsp;
                                <input type="checkbox" name="no_of_hijama_therapy" id="no_of_hijama_therapy">
                            </div>
                            <div>
                                <label for="on_of_acupuncture" class="form-label">Acupuncture</label> &nbsp;&nbsp;
                                <input type="checkbox" name="on_of_acupuncture" id="on_of_acupuncture">
                            </div>

                            <div>
                                <label for="no_of_physiotherapy " class="form-label">Physiotherapy </label>
                                &nbsp;&nbsp;
                                <input type="checkbox" name="no_of_physiotherapy" id="no_of_physiotherapy">
                            </div>
                            <div>
                                <label for="no_of_coffee_anema" class="form-label">Coffee enemas</label> &nbsp;&nbsp;
                                <input type="checkbox" name="no_of_coffee_anema" id="no_of_coffee_anema">
                            </div>
                            <div>
                                <label for="no_of_phototherapy" class="form-label">Phototherapy </label> &nbsp;&nbsp;
                                <input type="checkbox" name="no_of_phototherapy" id="no_of_phototherapy">
                            </div>
                            <div>
                                <label for="no_of_sauna" class="form-label">Sauna therapy </label> &nbsp;&nbsp;
                                <input type="checkbox" name="no_of_sauna" id="no_of_sauna">
                            </div>
                            <div style="z-index: 2000" class="row">
                                <label class="form-label">Problems<span id="star">*</span></label>
                                <div class="col-12">
                                    <select name="problem_id[]" id="problem" class="form-control d-none" multiple
                                        required></select>
                                </div>

                            </div>

                            <div>
                                <label for="physical_improvement" class="form-label">
                                    Physical Improvement <span id="star">*</span>
                                </label>
                                <div class="row">
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
                                </div>
                            </div>

                            <div>
                                <label for="comment_id" class="form-label">Comment</label>
                                <select name="comment_id[]" id="comments" class="form-control old-comment" multiple
                                    required>
                                </select>
                            </div>
                            <div>
                                <label for="reference_id" class="form-label">Reference</label>
                                <select name="reference_id" id="reference_id" class="form-control" required>
                                </select>
                            </div>
                            <div>
                                <label for="comment" class="form-label">Comment</label>
                                <textarea name="comment" id="comment" class="form-control" rows="2" placeholder="Comment of this patient"></textarea>
                            </div>

                        </div>
                        <div class="modal-footer modalFooter">
                            <button type="submit" class="btn btn-primary">Update Report</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

        function resetForm() {
            $("#patient_user_id").empty();
            $("#doctor_user_id").empty();
            $('#bd_medicine').val('');
            $('#us_medicine').val('');
            $('#no_of_medicine').val('0');
            $('#no_of_test').val('');
            $('#no_of_ozone_therapy').prop('checked', false);
            $('#no_of_hijama_therapy').prop('checked', false);
            $('#on_of_acupuncture').prop('checked', false);
            $('#no_of_physiotherapy').prop('checked', false);
            $('#no_of_coffee_anema').prop('checked', false);
            $('#no_of_phototherapy').prop('checked', false);
            $('#no_of_sauna').prop('checked', false);
            $('#physical_improvement').prop('checked', false);
            $('#comment').val('');
            $('#problem').empty();
            $('#comment_id').empty();
            $('#reference_id').empty();


        }

        resetForm();

        function calculateMedicineTotal() {
            var bd = parseInt($('#bd_medicine').val()) || 0;
            var us = parseInt($('#us_medicine').val()) || 0;
            $('#no_of_medicine').val(bd + us);
        }

        $('#bd_medicine, #us_medicine').on('keyup', calculateMedicineTotal);

        var patients = @json($patients);
        var doctors = @json($doctors);
        var selectedProblem = @json($selectedProblems);
        var problems = @json($problems);
        var comments = @json($comments);
        var selectedComment = @json($selectedComment);
        var references = @json($references);

        $.each(patients, function(index, patient) {
            $('#patient_user_id').append('<option value="' + patient.patient_user_id + '">' +
                patient.first_name + '</option>');
        });

        $.each(doctors, function(index, doctors) {
            $('#doctor_user_id').append('<option value="' + doctors.user_id + '">' +
                doctors.first_name + '</option>');
        });
        $.each(references, function(index, reference) {
            $('#reference_id').append('<option value="' + reference.id + '">' +
                reference.name + '</option>');
        });
        // $.each(comments, function(index, comment) {
        //     $('#comment_id').append('<option value="' + comment.id + '">' +
        //         comment.name + '</option>');
        // });

        var reportID = "<?php echo $report->id; ?>";

        var doctor = "<?php echo $report->doctor->id; ?>";


        var patient = "<?php echo $report->patient_user_id; ?>";
        var physicalImprovment = "<?php echo $report->physical_improvement; ?>";
        var lastVisitDate = '<?php echo $report->last_visited_date; ?>';
        $('#id').val(reportID);
        $('#comment').val("<?php echo $report->comment; ?>");
        $('#doctor_user_id').val(doctor);
        $('#patient_user_id').val(patient);
        $('#no_of_visite').val('<?php echo $report->no_of_visite; ?>');
        $('#last_visited_date').val(lastVisitDate);
        $('#bd_medicine').val('<?php echo $report->bd_medicine; ?>');
        $('#us_medicine').val('<?php echo $report->us_medicine; ?>');
        $('#no_of_medicine').val('<?php echo $report->no_of_medicine; ?>');
        $('#no_of_test').val('<?php echo $report->no_of_test; ?>');
        $('#comment').val('<?php echo $report->comment; ?>');
        var referenceId = '<?php echo $report->reference ? $report->reference->id : ''; ?>';

        if (referenceId) {
            $('#reference_id').val(referenceId);
        } else {
            $('#reference_id').val('');
        }


        var no_of_ozone_therapy = parseInt('<?php echo $report->no_of_ozone_therapy; ?>');
        var no_of_hijama_therapy = parseInt('<?php echo $report->no_of_hijama_therapy; ?>');
        var on_of_acupuncture = parseInt('<?php echo $report->on_of_acupuncture; ?>');
        var no_of_sauna = parseInt('<?php echo $report->no_of_sauna; ?>');
        var no_of_physiotherapy = parseInt('<?php echo $report->no_of_physiotherapy; ?>');
        var no_of_coffee_anema = parseInt('<?php echo $report->no_of_coffee_anema; ?>');
        var no_of_phototherapy = parseInt('<?php echo $report->no_of_phototherapy; ?>');

        if (no_of_ozone_therapy == 1) {
            $('#no_of_ozone_therapy').prop('checked', true);
        }
        if (no_of_hijama_therapy == 1) {
            $('#no_of_hijama_therapy').prop('checked', true);
        }
        if (on_of_acupuncture == 1) {
            $('#on_of_acupuncture').prop('checked', true);
        }
        if (no_of_sauna == 1) {
            $('#no_of_sauna').prop('checked', true);
        }
        if (no_of_physiotherapy == 1) {
            $('#no_of_physiotherapy').prop('checked', true);
        }
        if (no_of_coffee_anema == 1) {
            $('#no_of_coffee_anema').prop('checked', true);
        }
        if (no_of_phototherapy == 1) {
            $('#no_of_phototherapy').prop('checked', true);
        }
        if (physicalImprovment == 1) {
            $('#success-outlined').prop('checked', true);
        } else if (physicalImprovment == 0) {
            $('#dark-outlined').prop('checked', true);
        }

        function updateSelect2Options(problems, selectedProblem) {
            var $select = $('#problem');
            $select.empty();
            $.each(problems, function(key, problem) {
                $select.append('<option class="d-none" value="' + problem.id + '">' + problem.name +
                    '</option>');
            });

            $select.val(selectedProblem).trigger('change');
        }
        updateSelect2Options(problems, selectedProblem);

        function updateComment(comments, selectedComment) {
            var $select = $('#comments');
            $select.empty();
            $.each(comments, function(key, comment) {
                $select.append('<option class="d-none" value="' + comment.id + '">' + comment.name +
                    '</option>');
            });

            $select.val(selectedComment).trigger('change');
        }
        updateComment(comments, selectedComment);

        $('#updateReport').off('submit').on('submit', function(e) {
            e.preventDefault();
            var form = $('#updateReport')[0];
            var formData = new FormData(form);

            $.ajax({
                method: 'POST',
                url: 'medical-report/' + reportID,
                data: formData,

                contentType: false, // Ensure to set these options for FormData
                processData: false,
                success: function(response) {
                    $('#reportUpdateClose').click();
                    $('#reportTable').DataTable().ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: 'success!!',
                        text: 'Report Updated Successfully',
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
        $('.mult-select-tag').empty();

        new MultiSelectTag('problem', {
            rounded: true, // default true

            placeholder: 'Search', // default Search...
            tagColor: {

            },
        })
        new MultiSelectTag('comments', {
            rounded: true, // default true

            placeholder: 'Search', // default Search...
            tagColor: {

            },
        })
    });
</script>
