<div class="modal fade" id="nutritionistProfile" tabindex="-1" role="dialog" aria-labelledby="nutritionistProfileLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content" id="printableArea">
            <div class="row modalHeader" style="text-align: center">
                <div class="text-center">
                    <h4 class="modal-title">Nutritionist Profile Summary</h4>
                </div>
            </div>
            <div class="modal-body p-3">
                <!-- Other fields remain the same -->
                <div class="row">
                    <div class="col-6 d-print-none">
                        <select name="days" id="days" class="form-control">
                            <option value="1">Last 30 Days</option>
                            <option value="2">Last 60 Days</option>
                            <option value="9">Last 90 Days</option>
                            <option value="12">1 Year</option>
                            <option value="all">All Time</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <p><span id="start_date"></span> &nbsp; &nbsp; to &nbsp; &nbsp; <span id="end_date"></span></p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-5"><b>Nutritionist name</b></div>
                    <div class="col-1"><b>:</b></div>
                    <div class="col-6"><b id="nutritionistName"></b></div>
                </div>
                <div class="row mt-1">
                    <div class="col-5"><b>Total Visit's</b></div>
                    <div class="col-1"><b>:</b></div>
                    <div class="col-6" id="total_visit"></div>
                </div>
                <div class="row mt-1">
                    <div class="col-5"><b>Average Visit Duration</b></div>
                    <div class="col-1"><b>:</b></div>
                    <div class="col-6" id="avg_visit_duration"></div>
                </div>
                <div class="row mt-1">
                    <div class="col-5"><b>Diet Plan Adherence Avg</b></div>
                    <div class="col-1"><b>:</b></div>
                    <div class="col-6" id="diet_plan_adherence_avg"></div>
                </div>
                <div class="row mt-1">
                    <div class="col-5"><b>Diet Plan Satisfaction Avg</b></div>
                    <div class="col-1"><b>:</b></div>
                    <div class="col-6" id="diet_plan_satisfaction_avg"></div>
                </div>
                <div class="row mt-1">
                    <div class="col-5"><b>Treatment Satisfaction Avg</b></div>
                    <div class="col-1"><b>:</b></div>
                    <div class="col-6" id="treatment_satisfaction_avg"></div>
                </div>

                <div class="row mt-1">
                    <div class="col">
                        <h4><u><b>Type of Consulting:</b></u></h4>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-2"></div>
                    <div class="col-8">
                        <table class="table" id="consultingTable">
                            <thead>
                                <tr>
                                    <th>Consulting Name</th>
                                    <th>Count  </th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="col-2"></div>
                </div>
                <div class="row mt-1">
                    <div class="col">
                        <h4><u><b>Reasons why unable to maintain diet/Challenges faced:</b></u></h4>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-2"></div>
                    <div class="col-8">
                        <table class="table" id="challengesFacedTable">
                            <thead>
                                <tr>
                                    <th>Challenge Name</th>
                                    <th>Count <span id="total_challenge"></span></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="col-2"></div>
                </div>

                <div class="row mt-1">
                    <div class="col">
                        <h4><u><b>Problems:</b></u></h4>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-2"></div>
                    <div class="col-8">
                        <table class="table table-striped" id="problemTable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Count <span id="total_problem"></span></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="col-2"></div>
                </div>
                <div class="row mt-1">
                    <div class="col">
                        <h4><u><b>Suggestions:</b></u></h4>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-2"></div>
                    <div class="col-8">
                        <table class="table table-striped" id="suggestionsTable">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Comment</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="col-2"></div>
                </div>
                <div class="modal-footer modalFooter d-print-none">
                    <button type="button" class="btn btn-primary" id="printModal">Print</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        aria-label="Close">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        function printModal() {
            var printContent = $('#printableArea').html();
            var originalContents = $('body').html();

            $('body').html(printContent);

            window.print();

            $('body').html(originalContents);
            location.reload(); // Reload the page to reinitialize Bootstrap modal
        }

        $('#printModal').on('click', function() {
            printModal();
        });
        var profile = @json($data);
        var id = profile.nutritionist.id;
        console.log(id)

        function getRangeLabel(value) {
            // Round the value to the nearest integer
            var roundedValue = Math.round(value);

            // Ensure roundedValue is within the expected range (1 to 5)
            if (roundedValue < 1) roundedValue = 1;
            if (roundedValue > 5) roundedValue = 5;

            // Map the rounded value to descriptive labels
            switch (roundedValue) {
                case 1:
                    return 'Very Low';
                case 2:
                    return 'Low';
                case 3:
                    return 'Medium';
                case 4:
                    return 'High';
                case 5:
                    return 'Very High';
                default:
                    return 'Unknown'; // For values outside the expected range
            }
        }
        valusetting();

        function valusetting() {
            $('#start_date').empty();
            $('#end_date').empty();
            $('#nutritionistName').empty();
            $('#total_visit').empty();
            $('#avg_visit_duration').empty();
            $('#diet_plan_adherence_avg').empty();
            $('#diet_plan_satisfaction_avg').empty();
            $('#treatment_satisfaction_avg').empty();
            $('#total_problem').empty();
            $('#total_challenge').empty();
            $('#problemTable tbody').empty();
            $('#challengesFacedTable tbody').empty();
            $('#suggestionsTable tbody').empty();

            $('#start_date').text(profile.start_date);
            $('#end_date').text(profile.end_date);
            $('#nutritionistName').text(profile.nutritionist.name);
            $('#total_visit').text(profile.totalVisit);
            $('#total_problem').text("("+ profile.totalProblemCount+")");
            $('#total_challenge').text("("+ profile.challengeCount+")");
            $('#avg_visit_duration').text(profile.avgVisitTime + ' Minutes'); // Ensure two decimal places
            $('#diet_plan_adherence_avg').html(profile.diet_plan_status + ' Out of 5 <b>(' + getRangeLabel(
                profile.diet_plan_status) + ')</b>');
            $('#diet_plan_satisfaction_avg').html(profile.dietPlanSatisAvg + ' Out of 5 <b>(' + getRangeLabel(
                profile.dietPlanSatisAvg) + ')</b>');
            $('#treatment_satisfaction_avg').html(profile.treatmentSatisAvg + ' Out of 5 <b>(' + getRangeLabel(
                profile.treatmentSatisAvg) + ')</b>');

            var problems = profile.problems;
                $.each(problems, function(index, problem) {
                var row = $('<tr>');
                row.append($('<td>').text(problem.name));
                row.append($('<td>').text(problem.problem_count));
                $('#problemTable tbody').append(row);
            });
            var challenges = profile.challenges;
                $.each(challenges, function(index, challenge) {
                var row = $('<tr>');
                row.append($('<td>').text(challenge.name));
                row.append($('<td>').text(challenge.challenge_count));
                $('#challengesFacedTable tbody').append(row);
            });
            var suggetions = profile.nutritionistVisits;
                $.each(suggetions, function(index, suggetion){
                    const formatDate = (dateString) => {
                    const date = new Date(dateString);
                    const day = ('0' + date.getDate()).slice(-2); // Get day with leading zero
                    const month = ('0' + (date.getMonth() + 1)).slice(-2); // Get month with leading zero (months are 0-based)
                    const year = date.getFullYear();
                    return `${day}-${month}-${year}`;
                };
                var row = $('<tr>');
                    row.append($('<td>').text(formatDate(suggetion.created_at)));
                        row.append($('<td>').text(suggetion.suggetion_for_improvement));
                            if(suggetion.suggetion_for_improvement){
                                $('#suggestionsTable tbody').append(row);

                            }
            });
        }

        // Ensure the change event is correctly bound
        $(document).off('change').on('change', '#days', function() {
            var day = $(this).val();
            console.log('Selected value:', day); // Debugging: check the selected value

            $.ajax({
                type: 'GET',
                url: "nutritionist-profile/" + id + '/' + day,
                success: function(response) {
                    // Assuming the response contains HTML content for the modal
                    $('body').append(response);
                    $('#nutritionistProfile').modal('show'); // Show modal
                    valusetting();
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    var errorMessage = '';

                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        // If validation errors exist, display them
                        var errors = xhr.responseJSON.errors;
                        for (var key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                errorMessage += '- ' + errors[key].join('\n- ') +
                                '\n'; // Accumulate error messages
                            }
                        }
                    } else {
                        // Handle other types of errors or unexpected issues
                        errorMessage = xhr.responseText || 'An unexpected error occurred.';
                    }

                    Swal.fire({
                        title: 'Error!',
                        text: errorMessage,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });



    });
</script>
